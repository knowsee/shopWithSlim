<?php

declare(strict_types=1);

namespace App\Model;

class OrdersPayment extends Base
{

    const TABLE_NAME = 'orders_payment';
    const TABLE_PY = 'orderId';
    const TABLE_PAY_TIME = 'payTime';
    const TABLE_CARD_INFO = 'payCardPayInfo';
    const TABLE_PAY_TYPE = 'payType';
    const TABLE_PAY_STATUS = 'payStatus';
    const TABLE_PAY_MONEY = 'payMoney';
    const TABLE_PAY_ADVANCE = 'advance';
    const TABLE_PAY_ACCOUNT = 'payAccount';
    const TABLE_PAY_REALNAME = 'payRealName';
    const TABLE_PAY_MESSAGE = 'payMessage';
    const TABLE_PAY_THIRD_ORDER = 'payThirdOrderSn';

    const PAYMENT_STATUS_UNPAY = 0;
    const PAYMENT_STATUS_PAYED = 1;
    const PAYMENT_STATUS_RETURN = 2;
    const PAYMENT_STATUS_CANCEL = 3;

    const PAYMENT_STATUS_PAY_HALF = 11;

    const TABLE_ORDER = array(
        'orderId' => 'DESC',
    );
    protected static $table = self::TABLE_NAME;
    protected static $pk = self::TABLE_PY;
    protected static $order = self::TABLE_ORDER;


    public function changePayment($orderId, $payType, $payAcc, $payRealName, $payStatus = self::PAYMENT_STATUS_PAYED)
    {
        self::UpdateById($orderId, [
            self::TABLE_PAY_TYPE => $payType,
            self::TABLE_PAY_ACCOUNT => $payAcc,
            self::TABLE_PAY_REALNAME => $payRealName,
            self::TABLE_PAY_TIME => time(),
            self::TABLE_PAY_MESSAGE => self::getPayMessage($payStatus),
            self::TABLE_PAY_STATUS => $payStatus
        ]);
    }

    public static function getPayMessage($status)
    {
        switch ($status) {
            case self::PAYMENT_STATUS_UNPAY:
                $message = 'Waiting Pay';
                break;
            case self::PAYMENT_STATUS_PAYED:
                $message = 'Pay all';
                break;
            case self::PAYMENT_STATUS_RETURN:
                $message = 'Pay back';
                break;
            case self::PAYMENT_STATUS_CANCEL:
                $message = 'Pay cancel';
                break;
            case self::PAYMENT_STATUS_PAY_HALF:
                $message = 'Pay 50%';
                break;
        }
        return $message;
    }
}
