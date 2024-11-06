<?php
declare(strict_types=1);
namespace App\Model;

class GoodsType extends Base
{
    
    const TABLE_NAME = 'goods_type';
    const TABLE_PY = 'typeId';
    const TABLE_TYPE_MAINID = 'typeMainId';
    const TABLE_TYPENAME = 'typeName';
    const TABLE_TYPES_WEIGHT = 'typeWeight';
    
    protected static $table = 'goods_type';
    protected static $pk = 'typeId';
    protected static $order = [
        'typeId' => 'DESC',
    ];
    
    
}
