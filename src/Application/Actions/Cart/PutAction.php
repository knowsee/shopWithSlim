<?php

declare(strict_types=1);

namespace App\Application\Actions\Cart;

use App\Application\Actions\Action;
use App\Model\Cart as CartModel;
use App\Model\Goods;
use Psr\Http\Message\ResponseInterface as Response;

class PutAction extends Action
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $post = $this->request->getParsedBody();
        $post['skuId'] = intval($post['skuId']);
        $post['options'] = $post['options'] ?? [];
        $num = intval($post['num']);
        $goodsId = intval($post['goodsId']);
        $goodsInfo = Goods::getById($goodsId);
        if ($num < 1) {
            return $this->errorWithJson('不能添加0个');
        }
        if (empty($goodsInfo)) {
            return $this->errorWithJson('找不到这件商品');
        }
        if ($num > $goodsInfo[Goods::TABLE_GOODS_NUM]) {
            return $this->errorWithJson('存库不足，只有 ' . $goodsInfo[Goods::TABLE_GOODS_NUM]);
        }
        $prices = $goodsInfo[Goods::TABLE_GOODS_PRICE];
        if($goodsInfo['goods_sku']) {
            $goodsInfo['goods_sku'] = json_decode($goodsInfo['goods_sku'], true);
            $founds = false;
            foreach($goodsInfo['goods_sku'] as $sku) {
                if($founds == false) {
                    if($sku['id'] == $post['skuId'] || $post['skuId'] == 0) {
                        $prices = $sku['prices'];
                        $post['skuId'] = $sku['id'];
                        $founds = true;
                    }
                }
            }
            if($founds == false && $post['skuId'] > 0) {
                return $this->errorWithJson('规格不存在');
            }
        }
        //CartModel::deleteCart($this->cartId, $this->userInfo['userId']);
        CartModel::putGoodsInCart($goodsId, $num, $prices, $this->cartId, $post['skuId'], empty($post['options']) ? [] : $post['options']);
        return $this->rightWithJson();
    }
}
