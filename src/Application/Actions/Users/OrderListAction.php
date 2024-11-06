<?php

declare(strict_types=1);

namespace App\Application\Actions\Users;

use App\Application\Actions\Action;
use App\Model\Orders as OrdersModel;
use Psr\Http\Message\ResponseInterface as Response;

class OrderListAction extends Action
{
    protected string $title = 'Order List';
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $whereParam = [
            OrdersModel::TABLE_USER_ID => $this->userInfo['userId']
        ];
        $list = OrdersModel::getListByWhere($this->page, $this->pageNum, $whereParam, function ($order) {
            $order[OrdersModel::TABLE_GOODSLIST] = json_decode($order[OrdersModel::TABLE_GOODSLIST], true);
            $order[OrdersModel::TABLE_GOODSLIST] = array_values($order[OrdersModel::TABLE_GOODSLIST]);
            foreach ($order[OrdersModel::TABLE_GOODSLIST] as $key => $val) {
                $order[OrdersModel::TABLE_GOODSLIST][$key]['images'] = siteUrl('Upload') . $val['images'];
            }
            $order['statusName'] = OrdersModel::getStatusName($order[OrdersModel::TABLE_ORDER_STATUS]);
            return $order;
        });
        return $this->view('OrderList.php', [
            'list' => $list
        ]);
    }
}
