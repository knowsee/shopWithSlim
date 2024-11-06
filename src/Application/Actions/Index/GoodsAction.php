<?php

declare(strict_types=1);

namespace App\Application\Actions\Index;

use App\Application\Actions\Action;
use App\Model\Goods as GoodsModel;
use App\Model\Cart as CartModel;
use App\Model\CakeConfig as CakeConfigModel;
use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Settings\SettingsInterface; 

class GoodsAction extends Action
{
    protected string $title = 'Categories';
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $get = $this->request->getQueryParams();
		$setting = $this->container->get(SettingsInterface::class)->get();
        $goodsId = intval($get['goodsId']);
        $goodsInfo = GoodsModel::getById($goodsId);
        $goodsInfo[GoodsModel::TABLE_GOODS_IMAGES] = siteUrl('Upload') . $goodsInfo[GoodsModel::TABLE_GOODS_IMAGES];
        $like = false;
        $cartNum = 0;
        if ($this->cartId > 0) {
            $cartInfo = CartModel::getCartList($this->cartId);
            $cartNum = 0;
            if (isset($cartInfo['list'][$goodsId][0])) {
                $like = true;
                $cartNum = $cartInfo['list'][$goodsId][0]['num'];
            }
        }
        $this->title = $goodsInfo[GoodsModel::TABLE_GOODS_NAME];
		$goodsInfo['goods_Id'] = $goodsId;
		if($goodsInfo['goods_sku']) {
			$goodsInfo['goods_sku'] = json_decode($goodsInfo['goods_sku'], true);
		} else {
			$goodsInfo['goods_sku'] = [];
		}
		if($goodsInfo['goods_extimg']) {
			$goodsInfo['goods_extimg'] = json_decode($goodsInfo['goods_extimg'], true);
			$extimg = [$goodsInfo['goods_images']];
            foreach($goodsInfo['goods_extimg'] as $key => $url) {
				if(!empty($url)) {
					$extimg[] = siteUrl('Upload') . $url;
				}
            }
			$goodsInfo['goods_extimg'] = $extimg;
		} else {
			$goodsInfo['goods_extimg'] = [$goodsInfo['goods_images']];
		}
        return $this->view('GoodView.php', [
            'info' => $goodsInfo,
            'goodsCartNum' => $cartNum > 0 ? $cartNum : 1,
            'like' => $like,
			'extimg' => $goodsInfo['goods_extimg'],
			'cakeConfig' => CakeConfigModel::getAll()
        ]);
    }
}
