<?php

declare(strict_types=1);

namespace App\Model;

class CakeConfig extends Base
{

    const TABLE_NAME = 'cake_config';
    const TABLE_PY = 'id';
    const TABLE_C_NAME = 'cName';
    const TABLE_SYSTEM_NAME = 'system_name';
    const TABLE_TYPE = 'cType';
    const TABLE_C_PRICES = 'cPrices';
	
    protected static $table = 'cake_config';
    protected static $pk = 'id';
    protected static $order = [
        'id' => 'DESC'
    ];
	
	public static function getAll() {
		$list = self::getList(1, 500);
		$cache = [
			'word' => 0,
			'timepackup' => [],
			'cNum' => [],
			'cColor' => []
		];
		foreach($list as $info) {
			if($info[self::TABLE_TYPE] == 'word') {
				$cache[$info[self::TABLE_TYPE]] = $info[self::TABLE_C_PRICES];
			} else {
				$cache[$info[self::TABLE_TYPE]][] = [
					'id' => $info[self::TABLE_PY],
					'name' => $info[self::TABLE_C_NAME],
					'prices' => $info[self::TABLE_C_PRICES]
				];
			}
		}
		return $cache;
	}

	public static function makeCartJson(array $options) {
		$text = $boxtext = '';
		$totalMoney = 0.00;
		$config = self::getAll();
		$cache = [
			'word' => 0
		];
		$ids = [];
		if(empty($options[1]) || empty($options[0]['value'])) {
			return json_encode([]);
		}
		foreach($options as $value) {
			if($value['name'] == 'id') {
				$ids[] = $value['value'];
			}
			if($value['name'] == 'wordtext') {
				$text = $value['value'];
				$totalMoney = mb_strlen($value['value'])*$config['word'];
				$cache['word'] = $totalMoney;
			}
			if($value['name'] == 'boxname') {
				$boxtext = strtoupper($value['value']);
			}
		}
		
		$list = self::getListByWhere(1, 500, [self::TABLE_PY => ['IN' => $ids]]);
		foreach($list as $info) {
			if($info[self::TABLE_TYPE] == 'word') {
				$cache[$info[self::TABLE_TYPE]] = $info[self::TABLE_C_PRICES];
			} else {
				$cache[] = [
					'id' => $info[self::TABLE_PY],
					'name' => $info[self::TABLE_C_NAME],
					'prices' => $info[self::TABLE_C_PRICES]
				];
			}
			$totalMoney += $info[self::TABLE_C_PRICES];
		}
		return json_encode(['money' => $totalMoney, 'detail' => $cache, 'text' => $text, 'boxtext' => $boxtext]);
	}
	
	
}
