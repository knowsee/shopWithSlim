<?php
declare(strict_types=1);
namespace App\Model;

class AjaxGoods extends Base
{
    
    const TABLE_NAME = 'goods';
    const TABLE_PY = 'id';
	
    const TABLE_ORDER = array(
        'id' => 'DESC',
    );
    protected static $table = self::TABLE_NAME;
    protected static $pk = self::TABLE_PY;
    protected static $order = self::TABLE_ORDER;
    
}
