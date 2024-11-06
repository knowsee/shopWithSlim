<?php

namespace App\Model;

use App\Model\Exception\Error;
use Slim\PDO\Database;
use Slim\PDO\Statement\{SelectStatement};

class Helper
{

    /**
     * @var Database
     */
    private static $db = null;
    private static $tableName = '';
    private static $pk = '';
    private static $order = [];

    private static $whereInit;
    public static function db($db, string $pk, string $tableName, ?array $order = array())
    {
        self::$db = $db;
        self::$pk = $pk;
        self::$order = $order;
        self::$tableName = $tableName;
        self::$whereInit = null;
    }

    public static function query($sql, $data)
    {
        $sth = self::$db->prepare($sql);
        $sth->execute($data);
        return $sth;
    }

    public static function beginTransaction()
    {
        self::$db->beginTransaction();
    }

    public static function rollback()
    {
        self::$db->rollback();
    }

    public static function commit()
    {
        self::$db->commit();
    }

    /**
     * Get DataList
     * @param int $page
     * @param int $num
     * @param callable|null $callback
     * @param array|null $order
     * @param array|null $groupBy
     * @return array List
     * @throws Error
     */
    public static function getList($page = 1, $num = 20, callable $callback = null, ?array $order = array(), ?array $groupBy = array())
    {
        if ($page < 1 || $num < 1) {
            throw new Error(Error::DEFAULT_ERROR, '$page or $num is not num or less than 1', array(
                'page' => $page,
                'num' => $num
            ));
        }
        if ($callback && !is_callable($callback)) {
            throw new Error(Error::IMPORTANT_ERROR, '$callback need is callable', array(
                'callableType' => gettype($callback),
            ));
        }
        self::$whereInit = self::select();
        if (empty($order)) {
            $order = self::$order;
        }
        if ($order) {
            self::$whereInit->orderBy(key($order), $order[key($order)]);
        }
        if ($groupBy) {
            self::$whereInit->groupBy(implode(',', $groupBy));
        }
        list($offset, $row) = self::pageHandle($page, $num);
        $result = self::$whereInit->limit($row, $offset)->execute()->fetchAll();
        if ($callback) {
            return array_map($callback, $result);
        } else {
            return $result;
        }
    }

    /**
     * getListByWhere
     * @param int $page
     * @param int $num
     * @param array|null $where
     * @param callable|null $callback
     * @param array|null $order
     * @param array|null $groupBy
     * @return array
     * @throws SError
     */
    public static function getListByWhere($page = 1, $num = 20, ?array $where = array(), callable $callback = null, ?array $order = array(), ?array $groupBy = array())
    {
        if ($page < 1 || $num < 1) {
            throw new Error(Error::DEFAULT_ERROR, '$page or $num is not num or less than 1', array(
                'page' => $page,
                'num' => $num
            ));
        }
        if ($callback && !is_callable($callback)) {
            throw new Error(Error::IMPORTANT_ERROR, '$callback need is callable', array(
                'callableType' => gettype($callback),
            ));
        }
        self::$whereInit = self::select();
        self::makeWhere($where);
        if (empty($order)) {
            $order = self::$order;
        }
        if ($order) {
            self::$whereInit->orderBy(key($order), $order[key($order)]);
        }
        if ($groupBy) {
            self::$whereInit->groupBy(implode(',', $groupBy));
        }
        list($offset, $row) = self::pageHandle($page, $num);
        $result = self::$whereInit->limit($row, $offset)->execute()->fetchAll();
        if ($callback) {
            return array_map($callback, $result);
        } else {
            return $result;
        }
    }

    public static function pageHandle($page, $num)
    {
        return array(($page - 1) * $num, $num);
    }

    /**
     * getOne
     * @param array $order
     * @return array
     */
    public static function getOne($order = array())
    {
        return self::select()->orderBy(key($order), $order[key($order)])->execute()->fetch();
    }

    /**
     * getCount
     * @return int
     */
    public static function getCount()
    {
        $result = self::select()->count('*', 'total')->execute()->fetch();
        return $result['total'];
    }

    /**
     * getCountByWhere
     * @return int
     */
    public static function getCountByWhere($where)
    {
        self::$whereInit = self::select()->count('*', 'total');
        self::makeWhere($where);
        $result = self::$whereInit->execute()->fetch();
        return $result['total'];
    }

    /**
     * Insert To Db
     * @param array $data
     * @param bool $lastId
     * @return mixed
     */
    public static function Insert(array $data, bool $lastId = false)
    {
        $insertStatement = self::$db->insert(array_keys($data))->into(self::$tableName)->values(array_values($data));
        if ($lastId == true) {
            return $insertStatement->execute(true);
        } else {
            return $insertStatement->execute();
        }
    }

    /**
     * Update
     * @param array $data
     * @param array $where
     * @return result
     */
    public static function Update(array $data, array $where = array())
    {
        self::$whereInit = self::$db->update($data)->table(self::$tableName);
        self::makeWhere($where);
        return self::$whereInit->execute();
    }

    /**
     * @title array to sql
     * @param $array
     * EG: sql: WHERE KEY > '1' AND KEY < '10'
     *     php: $handleThis->where(array('KEY' => array('>' => '1', '<=' => '10')))
     *     sql: WHERE KEY LIKE %'1'%
     *     php: $handleThis->where(array('KEY' => array('LIKEMORE' => '1')));
     *     sql: WHERE KEY IN('1','2','3','4','5')
     *     php: $handleThis->where(array('KEY'=> array('IN' => array(1,2,3,4,5))))
     */
    private static function makeWhere(?array $array = array())
    {
        if (empty($array)) {
            return;
        }
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $handle => $val) {
                    self::condSql($key, $val, $handle);
                }
            } else {
                self::condSql($key, $value, '');
            }
        }
    }

    private static function condSql($key, $value, $handle)
    {
        if (in_array($handle, array('>', '<', '>=', '<=', '!='))) {
            self::$whereInit = self::$whereInit->where($key, $handle, $value);
        } elseif ($handle == 'IN') {
            self::$whereInit = self::$whereInit->whereIn($key, $value);
        } elseif ($handle == 'LIKE') {
            self::$whereInit = self::$whereInit->whereLike($key, $value);
        } elseif ($handle == 'LIKEMORE') {
            self::$whereInit = self::$whereInit->whereLike($key, '%' . $value . '%');
        } else {
            self::$whereInit = self::$whereInit->where($key, '=', $value);
        }
    }

    /**
     * UpdateById
     * @param mixed $id
     * @param array $data
     * @return result
     */
    public static function UpdateById($id, array $data)
    {
        self::$whereInit = self::$db->update($data)->table(self::$tableName);
        self::makeWhere([
            self::$pk => $id
        ]);
        return self::$whereInit->execute();
    }

    /**
     * Delete
     * @param array $where
     * @return result
     */
    public static function Delete(array $where = array())
    {
        self::$whereInit = self::$db->delete()->from(self::$tableName);
        self::makeWhere($where);
        return self::$whereInit->execute();
    }

    /**
     * DeleteById
     * @param mixed $id
     * @return result
     */
    public static function DeleteById($id)
    {
        self::$whereInit = self::$db->delete()->from(self::$tableName);
        self::makeWhere([
            self::$pk => $id
        ]);
        return self::$whereInit->execute();
    }

    /**
     * distinctCount
     * @param string $feild
     * @return int
     */
    public static function distinctCount(string $feild = '*')
    {
        $result = self::select()->count($feild, 'total', true)->execute()->fetch();
        return $result['total'];
    }

    /**
     * getById
     * @param mixed $id
     * @return array
     */
    public static function getById($id)
    {
        return self::select()->where(self::$pk, '=', $id)->execute()->fetch();
    }

    /**
     * getByWhere
     * @param array $where
     * @param null|array $order
     * @return array
     */
    public static function getByWhere(array $where, ?array $order = array())
    {
        self::$whereInit = self::select();
        self::makeWhere($where);
        if ($order) {
            self::$whereInit->orderBy(key($order), $order[key($order)]);
        }
        return self::$whereInit->execute()->fetch();
    }

    /**
     * select
     * @return SelectStatement
     */
    public static function select()
    {
        return self::$db->select()->from(self::$tableName);
    }
}
