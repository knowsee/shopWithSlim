<?php
declare(strict_types=1);
namespace App\Model;

class CartGoods extends Base 
{
    
    const TABLE_NAME = 'cart_list';
    const TABLE_PY = 'id';
    const TABLE_SESSION_ID = 'cart_id';
    const TABLE_GOODS_ID = 'cart_goodsId';
    const TABLE_CART_NUM = 'cart_num';
    const TABLE_CART_PRICE = 'cart_price';
    const TABLE_CART_ADDTIME = 'cart_addtime';
    const TABLE_CART_SKUID = 'cart_skuid';
    const TABLE_CART_OPTIONS = 'cart_options';
    const TABLE_ORDER = array(
        'id' => 'DESC',
    );

    protected static $table = self::TABLE_NAME;
    protected static $pk = self::TABLE_PY;
    protected static $order = self::TABLE_ORDER;
    
}
