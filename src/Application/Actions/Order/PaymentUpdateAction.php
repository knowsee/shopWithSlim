<?php

declare(strict_types=1);

namespace App\Application\Actions\Order;

use App\Application\Actions\Action;
use App\Model\Orders as OrdersModel;
use App\Model\OrdersPayment as OrdersPaymentModel;
use Psr\Http\Message\ResponseInterface as Response;

class PaymentUpdateAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $post = $this->request->getParsedBody();
        if (empty($post['orderSn'])) {
            return $this->errorWithJson('can not found order');
        }
        $orderInfo = OrdersModel::getByWhere([
            OrdersModel::TABLE_ORDERSN => $post['orderSn'],
            OrdersModel::TABLE_USER_ID => $this->userInfo['userId']
        ]);
        if (empty($orderInfo)) {
            return $this->errorShow('can not found order');
        }
        if (!in_array($post['paymentChannel'], ['card', 'paypal'])) {
            return $this->errorShow('pay channel is not allow');
        }
        if ($post['paymentChannel'] == 'card') {
            if (empty($post['card_number'])) {
                return $this->errorWithJson('Please write on your card number');
            }
            if (empty($post['card_name'])) {
                return $this->errorWithJson('Please write on your card name');
            }
            if (empty($post['card_month']) || empty($post['card_year'])) {
                return $this->errorWithJson('Please write on your card exp month and year');
            }
            if (empty($post['card_security'])) {
                return $this->errorWithJson('Please write on your card exp month and year');
            }
        }
        OrdersPaymentModel::UpdateById($orderInfo[OrdersModel::TABLE_PY], [
            OrdersPaymentModel::TABLE_PAY_TYPE => $post['paymentChannel'],
            OrdersPaymentModel::TABLE_CARD_INFO => $post['paymentChannel'] == 'card' ? json_encode([
                'channel' => $post['paymentChannel'],
                'number' => $post['card_number'],
                'name' => $post['card_name'],
                'month' => $post['card_month'],
                'year' => $post['card_year'],
                'security' => $post['card_security']
            ]) : null
        ]);
        return $this->rightWithJson([
            'channel' => $post['paymentChannel']
        ]);
    }
}
