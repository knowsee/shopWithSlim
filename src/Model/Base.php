<?php

declare(strict_types=1);

namespace App\Model;

use App\Infrastructure\Driver\Pdo as PdoDriver;
use App\Infrastructure\Driver\Cache as CacheDriver;
use Slim\PDO\Database;
use Slim\Factory\AppFactory;

/**
 * base Model
 * @author knowsee
 * @method Helper
 */
class Base
{

    private Database $pdo;

    /**
     * 表名
     */
    protected static $table;
    /**
     * 自增键名
     */
    protected static $pk;
    protected static $order;
    public static function cache()
    {
        return AppFactory::create()->getContainer()->get(CacheDriver::class);
    }
    public static function __callStatic($name, $arguments)
    {
        $pdo = AppFactory::create()->getContainer()->get(PdoDriver::class);
        Helper::db($pdo, static::$pk, static::$table, static::$order);
        return call_user_func_array([Helper::class, $name], $arguments);
    }

}