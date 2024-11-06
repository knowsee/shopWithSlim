<?php

declare(strict_types=1);

namespace App\Application\Actions\Cart;

use App\Application\Actions\Action;
use Exception;
use App\Model\Cart as CartModel;
use Psr\Http\Message\ResponseInterface as Response;

class GetNumAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $cartInNum = CartModel::getCartGoodsNum($this->cartId);
        return $this->rightWithJson([
            'num' => $cartInNum
        ]);
    }
}
