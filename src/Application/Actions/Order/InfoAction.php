<?php

declare(strict_types=1);

namespace App\Application\Actions\Order;

use App\Application\Actions\Action;
use App\Model\Orders as OrdersModel;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class InfoAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $get = $this->request->getQueryParams();
        try {
            $orderNo = $this->resolveArg('orderSn');
            $orderId = null;
        } catch (HttpBadRequestException $e) {
            $orderId = isset($get['orderId']) ? $get['orderId'] : null;
        }
        if (empty($orderId)) {
            $orderSn = $get['orderSn'] ?? $orderNo;
            $orderInfo = OrdersModel::getByWhere([
                OrdersModel::TABLE_ORDERSN => $orderSn
            ]);
        } else {
            $orderInfo = OrdersModel::getById($orderId);
        }
        if (empty($orderInfo)) {
            $this->errorWithJson('Can not found this order');
        }
        $orderInfo[OrdersModel::TABLE_GOODSLIST] = preg_replace('/[\x00-\x1F]/', '', $orderInfo[OrdersModel::TABLE_GOODSLIST]);
        $orderInfo[OrdersModel::TABLE_GOODSLIST] = json_decode($orderInfo[OrdersModel::TABLE_GOODSLIST], true);
        foreach ($orderInfo[OrdersModel::TABLE_GOODSLIST] as $k => $value) {
            $orderInfo[OrdersModel::TABLE_GOODSLIST][$k]['images'] = siteUrl('Upload') . $value['images'];
        }
        $orderInfo['statusName'] = OrdersModel::getStatusName($orderInfo[OrdersModel::TABLE_ORDER_STATUS]);
        $this->title = 'View ' . $orderInfo['orderSn'];
        return $this->view('OrderInfo.php', [
            'orderInfo' => $orderInfo,
            'orderId' => $orderInfo['orderId']
        ]);
    }
}
