<?php

declare(strict_types=1);

namespace App\Application\Actions\Order;

use App\Application\Actions\Action;
use App\Model\Cart as CartModel;
use App\Model\User as UserModel;
use App\Model\Orders as OrdersModel;
use Psr\Http\Message\ResponseInterface as Response;

class CreateAction extends Action
{
    protected string $title = 'Home';
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $cartInNum = CartModel::getCartGoodsNum($this->cartId);
        if ($cartInNum < 1) {
            $this->errorWithJson('购物车为空，加点东西再提交', [
                'code' => '10010'
            ]);
        }
        $post = $this->request->getParsedBody();
        $post['noticeTime'] = time();
        $post['realname'] = $post['firstname'] . ' ' . $post['lastname'];
        if (empty($post['address']) || empty($post['postalcode']) || empty($post['mobile']) || empty($post['realname'])) {
            return $this->errorWithJson('Please write on your address and mobile');
        }
        if ($post['paymentChannel'] == 'card') {
            if (empty($post['card_number'])) {
                return $this->errorWithJson('Please write on your card number');
            }
            if (empty($post['card_name'])) {
                return $this->errorWithJson('Please write on your card name');
            }
            if (empty($post['card_month']) || empty($post['card_year'])) {
                return $this->errorWithJson('Please write on your card exp month and year');
            }
            if (empty($post['card_security'])) {
                return $this->errorWithJson('Please write on your card exp month and year');
            }

        }
        UserModel::updateById($this->userInfo['userId'], [UserModel::TABLE_USER_ADDRESS => $post['address'], UserModel::TABLE_MOBILE => $post['mobile'], UserModel::TABLE_USER_REALNAME => $post['realname']]);
		$post['orderMessageDate'] = $post['orderMessageDate'] ?? null;
        list($orderSN, $orderPrice, $discount, $firstGoods, $cartNum, $orderId) =
            OrdersModel::createOrder(
                $this->cartId,
                $this->userInfo,
                $post['noticeTime'],
                ['realName' => $post['realname'], 'address' => $post['address'], 'mobile' => $post['mobile'], 'reserve' => false, 'postalcode' => $post['postalcode']],
                0,
                '交收日子：'.$post['orderMessageDate'].'<br/>'.$post['orderMessage'],
                [
                    'channel' => $post['paymentChannel'],
                    'number' => $post['card_number'],
                    'name' => $post['card_name'],
                    'month' => $post['card_month'],
                    'year' => $post['card_year'],
                    'security' => $post['card_security']
                ]
            );
        return $this->rightWithJson([
            'sn' => $orderSN,
            'discount' => number_format($discount, 2),
            'orderId' => $orderId
        ]);
    }
}
