<?php

declare(strict_types=1);

namespace App\Application\Actions\Index;

use App\Application\Actions\Action;
use App\Model\Goods as GoodsModel;
use App\Model\GoodsType as GoodsTypeModel;
use App\Model\Cart as CartModel;
use App\Model\User as UserModel;
use Psr\Http\Message\ResponseInterface as Response;

class CartAction extends Action
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
        }
		
		$list = GoodsModel::getListByWhere($this->page, 12, ['goods_eType' => 1]);
        GoodsTypeModel::getList(1, 100, function ($value) use (&$typeList) {
            $typeList[$value[GoodsTypeModel::TABLE_PY]] = $value[GoodsTypeModel::TABLE_TYPENAME];
        });
        foreach ($list as $k => $value) {
            $list[$k]['typeName'] = $typeList[$value[GoodsModel::TABLE_TYPE]];
            $list[$k]['goods_images'] = siteUrl('Upload') . $value['goods_images'];
            $list[$k]['goods_extraPrice'] = $value['goods_extraPrice'] < 1 ? 'no lend' : $value['goods_extraPrice'];
            $list[$k]['goods_eType'] = $list[$k]['goods_eType'] !== '1' ? null : 1;
        }
		
        return $this->view('Cart.php', [
            'cart' => $cartInfo,
            'user_shipping' => UserModel::getById($this->userInfo['userId']),
			'cartOnlyGoods' => $list
        ]);
    }
}
