<?php

declare(strict_types=1);

namespace App\Application\Actions\Cart;

use App\Application\Actions\Action;
use Exception;
use App\Model\Cart as CartModel;
use App\Model\Goods;
use Psr\Http\Message\ResponseInterface as Response;

class GoodsNumUpdateAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $post = $this->request->getParsedBody();
        if (isset($post['cartNum'])) {
            foreach ($post['cartNum'] as $goodsIdR => $num) {
                list($goodsId, $skuId) = explode('_', $goodsIdR);
                $goodsId = intval($goodsId);
                if (isset($post['cartNumOld'][$goodsIdR])) {
                    $oldNum = $post['cartNumOld'][$goodsIdR];
                    $goodsInfo = Goods::getById($goodsId);
                    if ($oldNum < $num) {
                        if (empty($goodsInfo)) {
                            return $this->errorWithJson('找不到这件商品');
                        }
                        if ($num > $goodsInfo[Goods::TABLE_GOODS_NUM]) {
                            return $this->errorWithJson($goodsInfo[Goods::TABLE_GOODS_NAME] . '存库不足，只有 ' . $goodsInfo[Goods::TABLE_GOODS_NUM]);
                        }
                        CartModel::putGoodsInCart($goodsId, $num, $goodsInfo[Goods::TABLE_GOODS_PRICE], $this->cartId, $skuId);
                    } else {
                        $tryNum = $oldNum - $num;
                        if ($num < 1) {
                            CartModel::deleteCartGoods($this->cartId, $goodsId,$skuId);
                        } elseif ($tryNum > 0) {
                            CartModel::takeOffCart($goodsId, $num, $this->cartId,$skuId);
                        }
                    }
                }
            }
        }
        return $this->rightWithJson();
    }
}
