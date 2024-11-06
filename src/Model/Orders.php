<?php

declare(strict_types=1);

namespace App\Model;

use Throwable;

class Orders extends Base
{

    const TABLE_NAME = 'orders_list';
    const TABLE_PY = 'orderId';
    const TABLE_USER_ID = 'orderUserId';
    const TABLE_USER_EMAIL = 'userEmail';
    const TABLE_USERNAME = 'userName';
    const TABLE_ORDERSN = 'orderSn';
    const TABLE_ORDER_PRICE = 'orderPrice';
    const TABLE_PAY_RMB_MONEY = 'orderRmbPrice';
    const TABLE_HANDLING_PRICE = 'handlingFee';
    const TABLE_ORDER_COST_PRICE = 'costPrice';
    const TABLE_ORDER_RESERVE_PRICE = 'reservePrice';
    const TABLE_ORDER_MESSAGE = 'orderMessage';
    const TABLE_GOODSLIST = 'ordersGoodList';
    const TABLE_ORDER_TIME = 'orderTime';
    const TABLE_ORDER_NOTICETIME = 'noticeTime';
    const TABLE_ORDER_PAYTIME = 'orderPaytime';
    const TABLE_ORDER_STATUS = 'orderStatus';

    const TABLE_ORDER_MOBILE = 'mobile';
    const TABLE_ORDER_ADDRESS = 'address';
    const TABLE_ORDER_REALNAME = 'realName';

    const STATUS_CREATE = 0;
    const STATUS_PAYED = 1;
    const STATUS_TAKE_PACKAGE = 2;
    const STATUS_COMPLATE = 3;
    const STATUS_CANCEL = 4;
    const STATUS_LENDING = 5;
    const STATUS_REVERT = 5;

    const TABLE_ORDER = array(
        'orderId' => 'DESC',
    );
    protected static $table = self::TABLE_NAME;
    protected static $pk = self::TABLE_PY;
    protected static $order = self::TABLE_ORDER;

    public static function getStatusName($status)
    {
        $name = [
            'Create',
            'Payed',
            'OnRoad',
            'Send',
            'Cancel'
        ];
        return $name[$status];
    }

    public static function createOrder($cartId, $user, $noticeTime, $oInfo, $discount = 0.00, $orderMessage = '', $cardInfo = array())
    {
        self::beginTransaction();
        try {
            $cartInfo = Cart::getCartList($cartId);
            $orderSN = self::makeOrderSn();
            $extra = $cartInfo['extraTotal'];
            if ($discount < 1) {
                $discount = 0.00;
            }
			if(empty($cartInfo['list'])) {
				throw new Throwable('Cart is Empty');
			}
            $orderId = self::Insert([
                self::TABLE_ORDERSN => $orderSN,
                self::TABLE_ORDER_PRICE => round($cartInfo['total'] + $extra - $discount, 2),
                self::TABLE_HANDLING_PRICE => $extra,
                self::TABLE_ORDER_RESERVE_PRICE => $extra,
                self::TABLE_GOODSLIST => json_encode($cartInfo['list'], JSON_UNESCAPED_UNICODE),
                self::TABLE_ORDER_TIME => time(),
                self::TABLE_ORDER_NOTICETIME => $noticeTime,
                self::TABLE_USER_ID => $user['userId'],
                self::TABLE_USER_EMAIL => $user['userEmail'],
                self::TABLE_USERNAME => $user['userName'],
                self::TABLE_ORDER_MESSAGE => $orderMessage,
                self::TABLE_ORDER_MOBILE => $oInfo[self::TABLE_ORDER_MOBILE],
                self::TABLE_ORDER_ADDRESS => $oInfo[self::TABLE_ORDER_ADDRESS],
                self::TABLE_ORDER_REALNAME => $oInfo[self::TABLE_ORDER_REALNAME],
                self::TABLE_ORDER_PAYTIME => 0,
                'discount' => $discount
            ], true);
            foreach ($cartInfo['list'] as $goods) {
                OrderGoods::Insert([
                    OrderGoods::ORDER_ID => $orderId,
                    OrderGoods::GOODS_ID => $goods['goodsId'],
                    OrderGoods::GOODS_NAME => $goods['name'],
                    OrderGoods::GOODS_PRICES => $goods['price'],
					'skuId' => $goods['skuId'],
					'skuInfo' => json_encode($goods['skuInfo'], JSON_UNESCAPED_UNICODE),
					'options' => $goods['options'],
					'options_fee' => $goods['options_fee'],
                    OrderGoods::BUY_TIME => time()
                ]);
            }
            OrdersPayment::Insert([
                OrdersPayment::TABLE_PY => $orderId,
                OrdersPayment::TABLE_PAY_MONEY => round($cartInfo['total'] + $extra - $discount, 2),
                OrdersPayment::TABLE_PAY_MESSAGE => OrdersPayment::getPayMessage(OrdersPayment::PAYMENT_STATUS_UNPAY),
                OrdersPayment::TABLE_PAY_TYPE => $cardInfo['channel'],
                OrdersPayment::TABLE_CARD_INFO => json_encode($cardInfo)
            ]);
            Cart::deleteCart($cartId, $user['userId']);
            self::commit();
        } catch (Throwable $e) {
            self::rollback();
            throw new Throwable('System Busy');
        }
        return [$orderSN, round($cartInfo['total'] + $extra, 2), $discount, current($cartInfo['list'])['name'], count($cartInfo['list']), $orderId];
    }

    private static function getDiscountOnGlobal($total)
    {
        $discount = 0;
        if ($total > 2000) {
            $discount = mt_rand(20, 50);
        } elseif ($total > 1000) {
            $discount = mt_rand(20, 30);
        } elseif ($total > 500) {
            $discount = mt_rand(8, 30);
        } elseif ($total > 200) {
            $discount = mt_rand(3, 10);
        } elseif ($total > 50) {
            $discount = 5 - (mt_rand(0, 8) / 10 + mt_rand(0, 8) / 10 + mt_rand(0, 8) / 10 + mt_rand(0, 8) / 10);
        }
        if ($discount < 1) {
            return mt_rand(0, 8) / 10;
        }
        if ($discount > 2) {
            $discount = $discount - (mt_rand(0, 8) / 10 + mt_rand(0, 8) / 10 + mt_rand(0, 8) / 10 + mt_rand(0, 8) / 10);
        }
        return $discount;
    }

    public static function makeOrderSn()
    {
        return date('Ymd') . substr(md5(date('YmdHis') . time()), 4, 6) . mt_rand(100, 999);
    }
}
