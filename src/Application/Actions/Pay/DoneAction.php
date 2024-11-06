<?php

declare(strict_types=1);

namespace App\Application\Actions\Pay;

use App\Application\Actions\Action;
use App\Model\User as UserModel;
use App\Model\Orders as OrdersModel;
use App\Model\OrdersPayment as OrdersPaymentModel;
use Psr\Http\Message\ResponseInterface as Response;
use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;
use App\Helpers\Mail;
use App\Application\Settings\SettingsInterface; 
use Omnipay\Common\Exception\InvalidCreditCardException;

class DoneAction extends Action
{
    private array $orderInfo = [];
    private string $orderNo = '';
    private string $method = '';
    private string $channel = 'card';
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $this->method = $this->resolveArg('method');
        $this->orderNo = $this->resolveArg('orderSn');
        $this->orderInfo = OrdersModel::getByWhere([
            OrdersModel::TABLE_ORDERSN => $this->orderNo
        ]);
        $this->orderInfo[OrdersModel::TABLE_ORDER_PRICE] = round($this->orderInfo[OrdersModel::TABLE_ORDER_PRICE], 2);
        $isPayed = false;
		try {
			switch ($this->method) {
				case 'paypal':
					$isPayed = $this->paypal($this->orderInfo[OrdersModel::TABLE_ORDER_PRICE], $this->orderNo);
					$this->channel = 'paypal';
					break;
				case 'stripe':
					$isPayed = $this->stripe($this->orderInfo[OrdersModel::TABLE_ORDER_PRICE], $this->orderNo);
					$this->channel = 'card';
					break;
				case 'bstripe':
					$payInfo = OrdersPaymentModel::getById($this->orderInfo[OrdersModel::TABLE_PY]);
					$payInfo[OrdersPaymentModel::TABLE_CARD_INFO] = json_decode($payInfo[OrdersPaymentModel::TABLE_CARD_INFO], true);
					$result = $this->beginStripe(
						$this->orderInfo[OrdersModel::TABLE_ORDER_PRICE],
						$this->orderInfo[OrdersModel::TABLE_ORDERSN],
						$_ENV['SITE_NAME'] . ' #Pay ' . $this->orderInfo[OrdersModel::TABLE_ORDERSN],
						$payInfo[OrdersPaymentModel::TABLE_CARD_INFO]
					);
					if (is_bool($result)) {
						$isPayed = $result;
					} else {
						return $result;
					}
					$this->channel = 'card';
					break;
				default:
					return $this->errorWithJson('Bad Payment Request');
			}
			return $this->payBefore($isPayed);
		} catch(InvalidCreditCardException $e) {
			return $this->response->withHeader('Location', excUrl('Order/Info/' . $this->orderNo . '?pay=false&message=' . $e->getMessage()))
                ->withStatus(302);
		}
        
    }

    private string $transactionId = '';
    private array $transactionInfo = [];
    private string $payMessage = '';

    private function payBefore(bool $isPayed)
    {
        $this->response->getBody()->write('Payment Success, Redirect...');
        if ($isPayed == true) {
            OrdersPaymentModel::Update([
                OrdersPaymentModel::TABLE_PAY_TIME => time(),
                OrdersPaymentModel::TABLE_PAY_STATUS => OrdersPaymentModel::PAYMENT_STATUS_PAYED,
                OrdersPaymentModel::TABLE_PAY_TYPE => $this->channel,
                OrdersPaymentModel::TABLE_PAY_THIRD_ORDER => $this->transactionId,
                OrdersPaymentModel::TABLE_PAY_MESSAGE => $this->method . '::payMessage::' . $this->payMessage
            ], [
                OrdersPaymentModel::TABLE_PY => $this->orderInfo[OrdersModel::TABLE_PY],
            ]);
            OrdersModel::updateById($this->orderInfo[OrdersModel::TABLE_PY], [
                OrdersModel::TABLE_ORDER_STATUS => OrdersModel::STATUS_PAYED,
                OrdersModel::TABLE_ORDER_PAYTIME => time()
            ]);
            $user = UserModel::getById($this->orderInfo[OrdersModel::TABLE_USER_ID]);
            (new Mail(
                $user[UserModel::TABLE_EMAIL],
                $user[UserModel::TABLE_FIRSTNAME] . ' ' . $user[UserModel::TABLE_LASTNAME]
            )
            )->orderCreate(
                $this->orderInfo[OrdersModel::TABLE_ORDERSN],
                json_decode($this->orderInfo[OrdersModel::TABLE_GOODSLIST], true),
                $this->orderInfo[OrdersModel::TABLE_ORDER_PRICE]
            );
            return $this->response->withHeader('Location', excUrl('Order/Info/' . $this->orderNo . '?pay=true'))
                ->withStatus(302);
        } else {
            return $this->response->withHeader('Location', excUrl('Order/Info/' . $this->orderNo . '?pay=false&message=' . $this->payMessage))
                ->withStatus(302);
        }
		
    }
	

    private function getStripe()
    {
        $gateway = Omnipay::create('Stripe\PaymentIntents');
		$setting = $this->container->get(SettingsInterface::class)->get('pay');
        $gateway->setApiKey($setting['stripe']['apikey']);
        return $gateway;
    }

    private function beginStripe(float $money, string $orderNo, string $desc, array $cardInfo)
    {
        $gateway = $this->getStripe();
        $realName = explode(' ', $cardInfo['name']);
        if (!isset($realName[0]) || empty($realName[0]) || !isset($realName[1]) || empty($realName[1])) {
            throw new HttpBadRequestException($this->request, 'Card RealName is not right');
        }
        $firstName = $realName[0];
        unset($realName[0]);
        $card = new CreditCard([
            "number" => $cardInfo['number'],
            "expiryMonth" => $cardInfo['month'],
            "expiryYear" => $cardInfo['year'],
            "cvv" => $cardInfo['security'],
            'firstName' => $firstName,
            'lastName' => implode(' ', $realName)
        ]);
        $paymentMethod = $gateway->createCard(['card' => $card])->send()->getCardReference();
        $paymentIntent = $gateway->authorize(
            [
                'amount' => $money,
                'currency' => 'HKD',
                'card' => $card,
                'paymentMethod' => $paymentMethod,
                'confirm' => true,
                'returnUrl' => excUrl('payment/done/stripe/' . $orderNo)
            ]
        )->send();
        $response = $paymentIntent;
        if ($response->isRedirect()) {
            return $response->redirect();
        } elseif ($response->isSuccessful()) {
            $this->transactionId = $response->getTransactionReference();
            return true;
        } else {
            $this->payMessage = $response->getMessage();
            return false;
        }
    }

    private function stripe(float $amount, string $orderNo)
    {
        $get = $this->request->getQueryParams();
        $gateway = $this->getStripe();
        $response = $gateway->confirm([
            'paymentIntentReference' => $get['payment_intent'],
            'returnUrl' => excUrl('Order/Info/' . $orderNo),
        ])->send();
        if ($response->isSuccessful()) {
            $this->transactionId = $response->getTransactionReference();
            return true;
        } else {
            return false;
        }
    }

    private function paypal(float $amount, string $orderNo)
    {
        $gateway = Omnipay::create('PayPal_Express');
		$setting = $this->container->get(SettingsInterface::class)->get('pay');
        $gateway->setUsername($setting['paypal']['username']);
        $gateway->setPassword($setting['paypal']['password']);
        $gateway->setSignature($setting['paypal']['signture']);
        $response = $gateway
            ->completePurchase([
                'amount' => $amount,
                'transactionId' => $orderNo,
                'currency' => $setting['paypal']['currency'],
                'returnUrl' => excUrl('payment/done/paypal/' . $orderNo),
                'cancelUrl' => excUrl('Order/Info/' . $orderNo),
                'notifyUrl' => excUrl('payment/notify/paypal/' . $orderNo)
            ])->send();
        $this->payMessage = $response->getMessage();
        if ($response->isSuccessful()) {
            $this->transactionId = $response->getTransactionReference();
            return true;
        } else {
            return false;
        }
    }
}
