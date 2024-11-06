<?php

declare(strict_types=1);

namespace App\Model;

class Goods extends Base
{

    const TABLE_NAME = 'goods_list';
    const TABLE_PY = 'goods_Id';
    const TABLE_GOODS_SN = 'goodsn';
    const TABLE_GOODS_CODE = 'goods_code';
    const TABLE_TYPE = 'goods_type';
    const TABLE_GOODS_ETYPE = 'goods_eType';
    const TABLE_GOODS_NAME = 'goods_name';
    const TABLE_GOODS_PRICE = 'goods_price';
    const TABLE_EXTRA_PRICE = 'goods_extraPrice';
    const TABLE_BUYER_PRICE = 'buyer_price';
    const TABLE_GOODS_IMAGES = 'goods_images';
    const TABLE_GOODS_MESSAGE = 'goods_message';
    const TABLE_GOODS_NUM = 'goods_num';
    const TABLE_GOODS_SELL_NUM = 'goods_sellNum';
    const TABLE_GOODS_UPDATE_TIME = 'goods_updatetime';

    const T_IS_DEFAULE = 0;
    const T_IS_COMBO = 1;

    protected static $table = 'goods_list';
    protected static $pk = 'goods_Id';
    protected static $order = [
        'goods_Id' => 'DESC'
    ];

    public static function makeSn()
    {
        return md5(uniqid() . mt_rand(1, 500000) . mt_rand(1, 500000));
    }
}
