<?php

declare(strict_types=1);

namespace App\Model;

class Cart extends Base
{

    const TABLE_NAME = 'cart_info';
    const TABLE_PY = 'id';
    const TABLE_USER_ID = 'userId';
    const TABLE_SESSION_ID = 'sessionId';
    const TABLE_CREATE_TIME = 'createTime';
    const CACHE_CART_INFO = 'userCart.';
    const CACHE_CART_GOODSLIST = 'cartList.';
    const TABLE_ORDER = array(
        'id' => 'DESC',
    );

    protected static $table = self::TABLE_NAME;
    protected static $pk = self::TABLE_PY;
    protected static $order = self::TABLE_ORDER;

    public static function getCart($userId)
    {
        $cartInfo = self::getCartCache($userId);
        if (empty($cartInfo)) {
            $cartInfo = self::getByWhere([self::TABLE_USER_ID => $userId]);
            if ($cartInfo['createTime'] + 86400 < time()) {
                self::Delete([self::TABLE_USER_ID => $userId]);
                if(!empty($cartInfo[self::TABLE_PY])) {
                    User::deleteCache(self::CACHE_CART_GOODSLIST . $cartInfo[self::TABLE_PY]);
                    User::deleteCache(self::CACHE_CART_INFO . $userId);
                }
            }
            $cartInfo = self::createCart($userId);
        }
        return $cartInfo[self::TABLE_PY];
    }

    public static function getCartGoodsNum($cartId)
    {
        return CartGoods::getCountByWhere([
            CartGoods::TABLE_SESSION_ID => $cartId
        ]);
    }

    public static function deleteCartGoods($cartId, $goodsId, $skuId)
    {
        CartGoods::Delete([
            CartGoods::TABLE_GOODS_ID => $goodsId,
            CartGoods::TABLE_SESSION_ID => $cartId,
            CartGoods::TABLE_CART_SKUID => $skuId
        ]);
        self::setCartGoodsListCache($cartId, $goodsId, $skuId, 'take');
    }

    public static function deleteCart($cartId, $userId)
    {
        self::Delete([self::TABLE_USER_ID => $userId]);
        User::deleteCache(self::CACHE_CART_GOODSLIST . $cartId);
        User::deleteCache(self::CACHE_CART_INFO . $userId);
        return true;
    }

    public static function showOptions(?array $options) {
        $text = [];
        if(!empty($options['text'])) {
            $text[] = '月亮燈上字句: '.$options['text']. '(+$'.$options['detail']['word'].')';
        }
        if(!empty($options['boxtext'])) {
            $text[] = '玻璃盒上人名: '.$options['boxtext'];
        }
        unset($options['detail']['word']);
        if(!empty($options['detail'])) {
            foreach($options['detail'] as $key => $info) {
                $text[] = $info['name']. '(+$'.$info['prices'].')';
            }
        }
        
        return ['html_text' => implode(', ', $text), 'money' => $options['money'] ?? 0.00];
    }

    public static function getCartList($cartId)
    {
        $list = CartGoods::getListByWhere(1, 500, [
            CartGoods::TABLE_SESSION_ID => $cartId
        ]);
        $goodsList = $cartList = $newCartList = [];
        $cartTotal = $extraTotal = 0;
        foreach ($list as $cart) {
            $cartList[$cart[CartGoods::TABLE_GOODS_ID]][$cart[CartGoods::TABLE_CART_SKUID]] = ['num' => (int)$cart[CartGoods::TABLE_CART_NUM], 'cart_options' => $cart[CartGoods::TABLE_CART_OPTIONS]];
            $goodsList[] = $cart[CartGoods::TABLE_GOODS_ID];
        }
        if (!empty($goodsList)) {
            $list = Goods::getListByWhere(1, 500, [Goods::TABLE_PY => ['IN' => $goodsList]]);
            foreach ($list as $goods) {
                foreach($cartList[$goods[Goods::TABLE_PY]] as $skuId => $skuInfo) {
                    if(is_string($goods['goods_sku'])) {
                        $goods['goods_sku'] = json_decode($goods['goods_sku'], true);
                        $goods['sku'] = [];
                        foreach($goods['goods_sku'] as $info) {
                            $goods['sku'][$info['id']] = $info;
                        }
                    }
                    $options = $skuInfo['cart_options'] ? self::showOptions(json_decode($skuInfo['cart_options'], true)) : '';
                    if($skuId == 0) {
                        $goods['sku'][$skuId]['prices'] = $goods['goods_price'];
                    }
                    $goods['sku'][$skuId]['o_prices'] = $goods['sku'][$skuId]['prices'];
                    if($options) {
                        $goods['sku'][$skuId]['o_prices'] = $goods['sku'][$skuId]['prices'];
                        $goods['sku'][$skuId]['prices'] = $goods['sku'][$skuId]['prices'] + $options['money'];
                    }

                    $thisGoodsCartInfo = [
                        'goodsId' => $goods[Goods::TABLE_PY],
                        'skuId' => $skuId,
                        'price' => isset($goods['sku'][$skuId]) ? $goods['sku'][$skuId]['prices'] : $goods[Goods::TABLE_GOODS_PRICE],
                        'name' => $goods[Goods::TABLE_GOODS_NAME],
                        'options' => $options['html_text'] ?? '',
                        'skuName' => isset($goods['sku'][$skuId]) && $skuId > 0 ? $goods['sku'][$skuId]['name'] : 'default',
                        'extra' => 0.00,
                        'images' => $goods[Goods::TABLE_GOODS_IMAGES],
                        'num' => $skuInfo['num'],
                        'skuInfo' => $goods['sku'],
                        'o_prices' => $goods['sku'][$skuId]['o_prices'],
                        'options_fee' => $options['money'] ?? 0.00
                    ];
                    $newCartList[] = $thisGoodsCartInfo;
                    $cartTotal += $thisGoodsCartInfo['price'] * $thisGoodsCartInfo['num'];
                    $extraTotal += $thisGoodsCartInfo['num'] * $thisGoodsCartInfo['extra'];
                }
            }
        }

        return ['list' => $newCartList, 'total' => $cartTotal, 'extraTotal' => $_ENV['SERVICE_FEE']];
    }

    public static function putGoodsInCart($goodsId, $goodsNum, $price, $cartId, $skuid, array $options = [])
    {
        $check = self::setCartGoodsListCache($cartId, $goodsId, $skuid);
        if ($check) {
            CartGoods::Insert([
                CartGoods::TABLE_SESSION_ID => $cartId,
                CartGoods::TABLE_GOODS_ID => $goodsId,
                CartGoods::TABLE_CART_NUM => $goodsNum,
                CartGoods::TABLE_CART_PRICE => $price,
                CartGoods::TABLE_CART_ADDTIME => time(),
                CartGoods::TABLE_CART_SKUID => $skuid,
                CartGoods::TABLE_CART_OPTIONS => $options ? CakeConfig::makeCartJson($options) : null
            ]);
        } else {
            CartGoods::Update([
                CartGoods::TABLE_CART_NUM => $goodsNum,
                CartGoods::TABLE_CART_PRICE => $price,
                CartGoods::TABLE_CART_OPTIONS => $options ? CakeConfig::makeCartJson($options) : null
            ], [
                CartGoods::TABLE_GOODS_ID => $goodsId,
                CartGoods::TABLE_SESSION_ID => $cartId,
                CartGoods::TABLE_CART_SKUID => $skuid
            ]);
        }
    }

    public static function takeOffCart($goodsId, $goodsNum, $cartId, $skuid)
    {
        CartGoods::Update([
            CartGoods::TABLE_CART_NUM => $goodsNum
        ], [
            CartGoods::TABLE_GOODS_ID => $goodsId,
            CartGoods::TABLE_SESSION_ID => $cartId,
            CartGoods::TABLE_CART_SKUID => $skuid
        ]);
        self::checkCart($cartId);
    }

    private static function checkCart($cartId)
    {
        $cartList = CartGoods::getListByWhere(1, 500, [
            CartGoods::TABLE_SESSION_ID => $cartId
        ]);
        foreach ($cartList as $cart) {
            if ($cart[CartGoods::TABLE_CART_NUM] < 1) {
                self::setCartGoodsListCache($cartId, $cart[CartGoods::TABLE_GOODS_ID], $cart[CartGoods::TABLE_CART_SKUID], 'take');
                CartGoods::DeleteById($cart[CartGoods::TABLE_PY]);
            }
        }
    }

    private static function createCart($userId)
    {
        $cartInfo = [
            self::TABLE_USER_ID => $userId,
            self::TABLE_CREATE_TIME => time()
        ];
        $cartId = self::Insert($cartInfo, true);
        $cartInfo[self::TABLE_PY] = $cartId;
        self::setCartCache($userId, $cartInfo);
        return $cartInfo;
    }

    private static function getCartCache($id)
    {
        return User::getCache(self::CACHE_CART_INFO . $id);
    }

    private static function setCartCache($userId, $value)
    {
        User::setCache(self::CACHE_CART_INFO . $userId, $value, 86400);
    }

    private static function getCartGoodsListCache($cartId)
    {
        $info = User::getCache(self::CACHE_CART_GOODSLIST . $cartId);
        return empty($info) ? array() : $info;
    }

    private static function setCartGoodsListCache($cartId, $goodsId, $skuid, $do = 'put')
    {
        $goodsCheck = false;
        $list = self::getCartGoodsListCache($cartId);
        if (!in_array($goodsId.'_'.$skuid, $list) && $do == 'put') {
            $list[] = $goodsId.'_'.$skuid;
            $goodsCheck = true;
        } elseif ($do == 'take') {
            $key = array_search($goodsId.'_'.$skuid, $list);
            if ($key > 0) {
                unset($list[$key]);
                $goodsCheck = true;
            }
        }
        User::setCache(self::CACHE_CART_GOODSLIST . $cartId, $list, 86400);
        return $goodsCheck;
    }
}
