<?php

declare(strict_types=1);

namespace App\Application\Actions\Cart;

use App\Application\Actions\Action;
use App\Model\Cart as CartModel;
use Psr\Http\Message\ResponseInterface as Response;

class ListAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $cartInfo = CartModel::getCartList($this->cartId);
        if (empty($cartInfo['list'])) {
            $cartInfo['list'] = [];
        }
        foreach ($cartInfo['list'] as $k => $value) {
            $cartInfo['list'][$k]['images'] = siteUrl('Upload') . $value['images'];
        }
        $cartInfo['total'] = (float)$cartInfo['total'];
        $cartInfo['extraTotal'] = (float)$cartInfo['extraTotal'];
        return $this->rightWithJson([
            'list' => $cartInfo['list'],
            'cartPrice' => number_format($cartInfo['total'], 2),
            'cartPriceRmb' => number_format(round($cartInfo['total'] * 0.92, 2), 2),
            'advance' => round($cartInfo['total'] / 2),
            'extraTotal' => number_format($cartInfo['extraTotal'], 2)
        ]);
    }
}
