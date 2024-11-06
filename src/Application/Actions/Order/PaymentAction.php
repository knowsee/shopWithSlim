<?php

declare(strict_types=1);

namespace App\Application\Actions\Order;

use App\Application\Actions\Action;
use App\Model\Orders as OrdersModel;
use App\Model\OrdersPayment as OrdersPaymentModel;
use Psr\Http\Message\ResponseInterface as Response;

class PaymentAction extends Action
{
    protected string $title = 'Pay My Order';
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $orderSn = $this->resolveArg('orderSn');
        $orderInfo = OrdersModel::getByWhere([
            OrdersModel::TABLE_ORDERSN => $orderSn,
            OrdersModel::TABLE_USER_ID => $this->userInfo['userId']
        ]);
        if (empty($orderInfo)) {
            return $this->errorShow('can not found order');
        }
        $payInfo = OrdersPaymentModel::getById($orderInfo[OrdersModel::TABLE_PY]);
        if ($payInfo[OrdersPaymentModel::TABLE_CARD_INFO]) {
            $payInfo[OrdersPaymentModel::TABLE_CARD_INFO] = json_decode($payInfo[OrdersPaymentModel::TABLE_CARD_INFO], true);
        }
        $orderInfo[OrdersModel::TABLE_GOODSLIST] = preg_replace('/[\x00-\x1F]/', '', $orderInfo[OrdersModel::TABLE_GOODSLIST]);
        $orderInfo[OrdersModel::TABLE_GOODSLIST] = json_decode($orderInfo[OrdersModel::TABLE_GOODSLIST], true);
        foreach ($orderInfo[OrdersModel::TABLE_GOODSLIST] as $k => $value) {
            $orderInfo[OrdersModel::TABLE_GOODSLIST][$k]['images'] = siteUrl('Upload') . $value['images'];
        }
        return $this->view('OrderPayment.php', [
            'orderInfo' => $orderInfo,
            'paymentInfo' => $payInfo,
            'payMethod' => $payInfo[OrdersPaymentModel::TABLE_PAY_TYPE]
        ]);
    }
}
