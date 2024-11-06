<?php

declare(strict_types=1);

namespace App\Application\Actions\Cart;

use App\Application\Actions\Action;
use App\Model\Cart as CartModel;
use Psr\Http\Message\ResponseInterface as Response;

class TakeAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $post = $this->request->getParsedBody();
        $post['skuId'] = intval($post['skuId']);
        $num = intval($post['num']);
        $goodsId = intval($post['goodsId']);
        if ($num < 1) {
            return $this->errorWithJson('不能提交0个');
        }
        CartModel::takeOffCart($goodsId, $num, $this->cartId, $post['skuId']);
        return $this->rightWithJson();
    }
}
