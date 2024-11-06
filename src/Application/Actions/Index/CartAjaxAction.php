<?php

declare(strict_types=1);

namespace App\Application\Actions\Index;

use App\Application\Actions\Action;
use App\Model\Cart as CartModel;
use App\Model\User as UserModel;
use Psr\Http\Message\ResponseInterface as Response;

class CartAjaxAction extends Action
{
    protected string $title = 'View Cart';
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $cartInfo = CartModel::getCartList($this->cartId);
        if (empty($cartInfo['list'])) {
            $cartInfo['list'] = array();
        }
        foreach ($cartInfo['list'] as $k => $value) {
            $cartInfo['list'][$k]['images'] = siteUrl('Upload') . $value['images'];
            $cartInfo['list'][$k]['totalPrices'] = bcmul((string)$value['price'], (string)$value['num'], 2);
        }
        $cartInfo['list'] = array_values($cartInfo['list']);
        return $this->rightWithJson($cartInfo);
    }
}
