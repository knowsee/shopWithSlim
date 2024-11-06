<?php
declare(strict_types=1);
namespace App\Model;

class GoodsExtends extends Base
{
    
    const TABLE_NAME = 'goods_extends';
    const TABLE_PY = 'id';
    const TABLE_GOODS_MAINID = 'goods_Id';
    const TABLE_E_NAME = 'extendsName';
    const TABLE_E_NUM = 'extendsNum';
    const TABLE_E_PRICE = 'extendsPrice';
    
    const TABLE_ORDER = array(
        'id' => 'DESC',
    );
    protected static $table = self::TABLE_NAME;
    protected static $pk = self::TABLE_PY;
    protected static $order = self::TABLE_ORDER;
    
    
}
