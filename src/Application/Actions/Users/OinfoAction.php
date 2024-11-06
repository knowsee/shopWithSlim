<?php

declare(strict_types=1);

namespace App\Application\Actions\Users;

use App\Application\Actions\Action;
use App\Model\Orders as OrdersModel;
use App\Model\OrdersPayment as OrdersPaymentModel;
use Psr\Http\Message\ResponseInterface as Response;

class OinfoAction extends Action
{
    protected string $title = 'Categories';
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $get = $this->request->getQueryParams();
        $orderId = intval($get['orderId']);
        if (empty($orderId)) {
            $orderSn = $get('orderSn');
            $orderInfo = OrdersModel::getByWhere([
                OrdersModel::TABLE_ORDERSN => $orderSn
            ]);
        } else {
            $orderInfo = OrdersModel::getById($orderId);
        }
        if (empty($orderInfo)) {
            $this->errorWithJson('找不到订单哦');
        }
        $orderInfo[OrdersModel::TABLE_GOODSLIST] = json_decode($orderInfo[OrdersModel::TABLE_GOODSLIST], true);
        foreach ($orderInfo[OrdersModel::TABLE_GOODSLIST] as $k => $value) {
            $orderInfo[OrdersModel::TABLE_GOODSLIST][$k]['images'] = siteUrl('Upload') . $value['images'];
        }
        $orderPayInfo = OrdersPaymentModel::getById($orderInfo[OrdersModel::TABLE_PY]);
        $orderPayInfo[OrdersPaymentModel::TABLE_PAY_ADVANCE] = round($orderPayInfo[OrdersPaymentModel::TABLE_PAY_MONEY] / 2);

        return $this->view('OrderInfo.php', [
            'orderInfo' => $orderInfo
        ]);
    }
}
