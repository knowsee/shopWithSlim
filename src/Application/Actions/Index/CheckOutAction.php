<?php

declare(strict_types=1);

namespace App\Application\Actions\Index;

use App\Application\Actions\Action;
use App\Model\Cart as CartModel;
use App\Model\User as UserModel;
use Psr\Http\Message\ResponseInterface as Response;

class CheckOutAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $post = $this->request->getParsedBody();
        $cartInfo = CartModel::getCartList($this->cartId);
        if (empty($cartInfo['list'])) {
            $cartInfo['list'] = [];
        }
        foreach ($cartInfo['list'] as $k => $value) {
            $cartInfo['list'][$k]['images'] = siteUrl('Upload') . $value['images'];
        }
        $this->title = 'Checkout';
        return $this->view('Checkout.php', [
            'orderInfo' => $post,
            'cart' => $cartInfo,
            'user_shipping' =>  UserModel::getById($this->userInfo['userId'])
        ]);
    }
}
