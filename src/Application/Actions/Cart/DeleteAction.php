<?php

declare(strict_types=1);

namespace App\Application\Actions\Cart;

use App\Application\Actions\Action;
use App\Model\Cart as CartModel;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $post = $this->request->getParsedBody();
        $post['skuId'] = intval($post['skuId']);
        CartModel::deleteCartGoods($this->cartId, $post['goodsId'], $post['skuId']);
        return $this->rightWithJson();
    }
}
