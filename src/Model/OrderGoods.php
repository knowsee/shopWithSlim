<?php
declare(strict_types=1);
namespace App\Model;

class OrderGoods extends Base 
{

    const TABLE_NAME = 'order_goods';
    const TABLE_PY = 'id';
    const ORDER_ID = 'order_id';
    const GOODS_ID = 'goods_id';
    const GOODS_NAME = 'goods_name';
    const GOODS_PRICES = 'goods_prices';
    const BUY_TIME = 'buy_time';

    const TABLE_ORDER = array(
        'orderId' => 'DESC',
    );

    protected static $table = self::TABLE_NAME;
    protected static $pk = self::TABLE_PY;
    protected static $order = self::TABLE_ORDER;
    
    


}
