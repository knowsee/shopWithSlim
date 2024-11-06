<?php

declare(strict_types=1);

namespace App\Application\Actions\Pay;

use App\Application\Actions\Action;
use App\Model\Orders as OrdersModel;
use App\Model\OrdersPayment as OrdersPaymentModel;
use Psr\Http\Message\ResponseInterface as Response;
use Omnipay\Omnipay;
use Slim\Exception\HttpBadRequestException;
use App\Application\Settings\SettingsInterface; 

class IndexAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $get = $this->request->getQueryParams();
        $orderId = $get['orderId'];
        $method = $get['method'];
        if (!empty($orderId)) {
            $orderInfo = OrdersModel::getById($orderId);
        } else {
            return $this->errorShow('can not found order');
        }
        if (empty($orderInfo)) {
            return $this->errorShow('can not found order');
        }
        if (intval($orderInfo[OrdersModel::TABLE_ORDER_STATUS]) !== 0) {
            return $this->errorShow('you can not pay, please contect us');
        }
        $orderInfo[OrdersModel::TABLE_ORDER_PRICE] = round($orderInfo[OrdersModel::TABLE_ORDER_PRICE], 2);
        switch ($method) {
            case 'card':
            try {
                $payInfo = OrdersPaymentModel::getById($orderId);
                if ($payInfo[OrdersPaymentModel::TABLE_CARD_INFO]) {
                    $payInfo[OrdersPaymentModel::TABLE_CARD_INFO] = json_decode($payInfo[OrdersPaymentModel::TABLE_CARD_INFO], true);
                } else {
                    return $this->errorShow('Card Info Does not have');
                }
                return $this->callStripe(
                    $orderInfo[OrdersModel::TABLE_ORDER_PRICE],
                    $orderInfo[OrdersModel::TABLE_ORDERSN],
                    $_ENV['SITE_NAME'] . ' #Pay ' . $orderInfo[OrdersModel::TABLE_ORDERSN],
                    $payInfo[OrdersPaymentModel::TABLE_CARD_INFO]
                );
            } catch(HttpBadRequestException $e) {
                return $this->errorShow($e->getMessage());
            }
                
                break;
            case 'paypal':
                return $this->callPayPal(
                    $orderInfo[OrdersModel::TABLE_ORDER_PRICE],
                    $orderInfo[OrdersModel::TABLE_ORDERSN],
                    $_ENV['SITE_NAME'] . ' #Pay ' . $orderInfo[OrdersModel::TABLE_ORDERSN]
                );
            default:
                return $this->rightWithJson([
                    'result' => false
                ]);
                break;
        }
    }

    private function callStripe(float $money, string $orderNo, string $desc, array $cardInfo)
    {
        $gateway = Omnipay::create('Stripe\PaymentIntents');
		$setting = $this->container->get(SettingsInterface::class)->get('pay');
        $gateway->setApiKey($setting['stripe']['apikey']);
        $realName = explode(' ', $cardInfo['name']);
        if (!isset($realName[0]) || empty($realName[0]) || !isset($realName[1]) || empty($realName[1])) {
            throw new HttpBadRequestException($this->request, 'Card RealName is not right');
        }
        return $this->response->withHeader('Location', excUrl('payment/done/bstripe/' . $orderNo))
        ->withStatus(302);
    }

    private function callPayPal(float $money, string $orderNo, string $desc)
    {
        $gateway = Omnipay::create('PayPal_Express');
		$setting = $this->container->get(SettingsInterface::class)->get('pay');
        $gateway->setUsername($setting['paypal']['username']);
        $gateway->setPassword($setting['paypal']['password']);
        $gateway->setSignature($setting['paypal']['signture']);
        //$gateway->setTestMode(true);
        $params = [
            'amount' => $money,
            'currency' => $setting['paypal']['currency'],
            'description' => $desc,
            'transactionId' => $orderNo,
            'transactionReference' => $orderNo,
            'returnUrl' => excUrl('payment/done/paypal/' . $orderNo),
            'cancelUrl' => excUrl('Order/Info/' . $orderNo),
            'notifyUrl' => excUrl('payment/notify/paypal/' . $orderNo)
        ];
        $response = $gateway->purchase($params)->send();
        if ($response->isRedirect()) {
            return $response->redirect();
        } else {
            return $response;
        }
    }
}
