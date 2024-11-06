-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2024-11-06 15:07:09
-- 服务器版本： 10.11.4-MariaDB-log
-- PHP 版本： 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `shop_new`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin_list`
--

CREATE TABLE `admin_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `userName` varchar(120) NOT NULL,
  `password` char(64) NOT NULL,
  `token` varchar(64) DEFAULT NULL,
  `lastLogin` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- 转存表中的数据 `admin_list`
--

INSERT INTO `admin_list` (`id`, `userName`, `password`, `token`, `lastLogin`) VALUES
(1, 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', '9a6d62a04ee2c67f545e931178c94202817808b4', '2024-05-13 02:57:44');

-- --------------------------------------------------------

--
-- 表的结构 `cake_config`
--

CREATE TABLE `cake_config` (
  `id` int(10) UNSIGNED NOT NULL,
  `cName` varchar(64) NOT NULL,
  `system_name` varchar(64) NOT NULL,
  `cType` enum('word','timepackup','cNum','cColor') NOT NULL,
  `cPrices` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `cart_info`
--

CREATE TABLE `cart_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `sessionId` char(64) DEFAULT NULL,
  `createTime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- 表的结构 `cart_list`
--

CREATE TABLE `cart_list` (
  `id` bigint(20) NOT NULL,
  `cart_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `cart_goodsId` int(10) UNSIGNED NOT NULL,
  `cart_skuid` int(10) UNSIGNED DEFAULT 0,
  `cart_options` text DEFAULT NULL,
  `cart_num` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `cart_price` float(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `cart_addtime` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- 表的结构 `feedback`
--

CREATE TABLE `feedback` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(25) NOT NULL DEFAULT '',
  `user_id` int(11) DEFAULT 0,
  `message` mediumtext NOT NULL,
  `images` varchar(200) DEFAULT NULL,
  `createtime` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `goods_extends`
--

CREATE TABLE `goods_extends` (
  `id` int(11) NOT NULL,
  `goods_Id` mediumint(9) NOT NULL,
  `extendsName` varchar(140) NOT NULL,
  `extendsNum` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `extendsPrice` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `goods_list`
--

CREATE TABLE `goods_list` (
  `goodsn` varchar(32) NOT NULL COMMENT 'SN',
  `goods_code` varchar(20) DEFAULT NULL,
  `goods_Id` mediumint(8) UNSIGNED NOT NULL COMMENT 'ID',
  `goods_type` int(10) UNSIGNED NOT NULL COMMENT 'TYPE',
  `is_cake` int(1) UNSIGNED NOT NULL DEFAULT 0,
  `goods_sku` text DEFAULT NULL,
  `goods_eType` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '1: 套装',
  `goods_name` varchar(200) NOT NULL COMMENT 'NAME',
  `goods_price` float(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT 'PRICE',
  `buyer_price` varchar(25) DEFAULT '0.00',
  `goods_extraPrice` float(10,2) UNSIGNED DEFAULT 0.00,
  `goods_images` varchar(400) DEFAULT NULL COMMENT 'IMAGES URL',
  `goods_extimg` text DEFAULT NULL COMMENT '多图',
  `goods_message` mediumtext DEFAULT NULL COMMENT 'SUMMARY',
  `goods_num` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'GOODS STOCK',
  `goods_sellNum` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'SELL STOCK',
  `goods_updatetime` int(10) UNSIGNED NOT NULL COMMENT 'LAST UPDATE TIME'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `goods_type`
--

CREATE TABLE `goods_type` (
  `typeId` int(11) NOT NULL,
  `typeMainId` int(11) NOT NULL,
  `typeName` varchar(100) NOT NULL,
  `typeWeight` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `orders_list`
--

CREATE TABLE `orders_list` (
  `orderId` int(10) UNSIGNED NOT NULL,
  `orderSn` char(20) NOT NULL,
  `orderUserId` int(10) UNSIGNED NOT NULL,
  `userName` varchar(40) DEFAULT NULL,
  `userEmail` varchar(100) DEFAULT NULL,
  `realName` varchar(50) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `orderPrice` float(10,2) UNSIGNED NOT NULL,
  `orderRmbPrice` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '人民币金额',
  `handlingFee` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `discount` decimal(10,2) DEFAULT 0.00,
  `reservePrice` float(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `costPrice` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `ordersGoodList` mediumtext NOT NULL,
  `orderMessage` text DEFAULT NULL,
  `orderTime` int(10) UNSIGNED NOT NULL,
  `noticeTime` int(11) NOT NULL DEFAULT 0,
  `orderPaytime` int(10) UNSIGNED NOT NULL,
  `orderStatus` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0：创建，1：支付，2：采购完毕，3：已发货，4：已取消',
  `postStatus` int(10) UNSIGNED DEFAULT 0,
  `postedTime` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `orders_payment`
--

CREATE TABLE `orders_payment` (
  `orderId` int(11) NOT NULL,
  `payType` varchar(30) NOT NULL DEFAULT '' COMMENT 'Pay using',
  `payTime` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `payCardPayInfo` varchar(255) DEFAULT NULL,
  `payCardResult` text DEFAULT NULL,
  `payStatus` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0: no pay 1: payed 2: return 3:cancel 11: advance',
  `payMoney` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `payAccount` varchar(30) DEFAULT NULL,
  `payRealName` varchar(60) DEFAULT NULL,
  `payMessage` varchar(200) DEFAULT NULL,
  `payThirdOrderSn` varchar(64) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `orders_takemessage`
--

CREATE TABLE `orders_takemessage` (
  `msgId` bigint(20) UNSIGNED NOT NULL,
  `tmpId` int(10) UNSIGNED NOT NULL,
  `replyName` varchar(150) NOT NULL,
  `replyMessage` mediumtext NOT NULL,
  `replyTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `orders_takeway`
--

CREATE TABLE `orders_takeway` (
  `tmpId` int(10) UNSIGNED NOT NULL,
  `userId` mediumint(9) NOT NULL,
  `orderStatus` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `orderServiceId` int(10) UNSIGNED NOT NULL,
  `orderGoods` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `orderMessage` mediumtext DEFAULT NULL,
  `orderId` int(11) NOT NULL,
  `orderTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `orders_takewaygoods`
--

CREATE TABLE `orders_takewaygoods` (
  `goodsId` int(10) UNSIGNED NOT NULL,
  `tmpId` int(10) UNSIGNED NOT NULL,
  `goodsName` int(11) NOT NULL,
  `goodsBuyType` varchar(50) NOT NULL,
  `buyValue` mediumtext DEFAULT NULL,
  `buyNum` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `buyPrice` varchar(100) DEFAULT NULL,
  `realPrice` float(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `buyMessage` varchar(300) DEFAULT NULL,
  `buyImages` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `order_goods`
--

CREATE TABLE `order_goods` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `goods_id` int(10) UNSIGNED NOT NULL,
  `options` text DEFAULT NULL COMMENT '扩展价格说明',
  `options_fee` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `skuId` int(10) DEFAULT 0,
  `skuInfo` text DEFAULT NULL,
  `goods_name` varchar(200) NOT NULL,
  `goods_prices` decimal(10,2) NOT NULL DEFAULT 0.00,
  `buy_time` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `service_user`
--

CREATE TABLE `service_user` (
  `userId` mediumint(9) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `userNickname` varchar(120) NOT NULL,
  `TipsMessage` varchar(250) DEFAULT NULL,
  `lastLogin` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `user_list`
--

CREATE TABLE `user_list` (
  `userId` int(11) NOT NULL,
  `user_Img` varchar(255) DEFAULT NULL,
  `userTempToken` char(128) DEFAULT NULL,
  `openId` varchar(64) DEFAULT NULL,
  `userName` varchar(100) DEFAULT NULL,
  `userFirstName` varchar(24) DEFAULT NULL,
  `userLastName` varchar(64) DEFAULT NULL,
  `sex` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `userPassword` varchar(128) NOT NULL,
  `userHash` char(20) NOT NULL,
  `userRealName` varchar(50) DEFAULT NULL,
  `userMobile` varchar(20) DEFAULT NULL,
  `userEmail` varchar(100) DEFAULT NULL,
  `userAddress` varchar(200) DEFAULT NULL,
  `userPostcode` int(11) DEFAULT NULL,
  `userWechat` varchar(120) DEFAULT NULL,
  `userOrderNum` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `userTotalNum` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `userRegTime` int(10) UNSIGNED DEFAULT NULL,
  `userLoginTime` int(10) UNSIGNED DEFAULT NULL,
  `user_inviti` int(10) UNSIGNED DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

--
-- 转储表的索引
--

--
-- 表的索引 `admin_list`
--
ALTER TABLE `admin_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userName` (`userName`),
  ADD KEY `token` (`token`);

--
-- 表的索引 `cake_config`
--
ALTER TABLE `cake_config`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_name` (`system_name`);

--
-- 表的索引 `cart_info`
--
ALTER TABLE `cart_info`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `userId` (`userId`) USING BTREE,
  ADD KEY `sessionId` (`sessionId`) USING BTREE;

--
-- 表的索引 `cart_list`
--
ALTER TABLE `cart_list`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `cart_goodsId` (`cart_goodsId`) USING BTREE,
  ADD KEY `cart_id` (`cart_id`) USING BTREE;

--
-- 表的索引 `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- 表的索引 `goods_extends`
--
ALTER TABLE `goods_extends`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `goods_Id` (`goods_Id`) USING BTREE;

--
-- 表的索引 `goods_list`
--
ALTER TABLE `goods_list`
  ADD PRIMARY KEY (`goods_Id`) USING BTREE,
  ADD KEY `goods_type` (`goods_type`) USING BTREE,
  ADD KEY `goods_code` (`goods_code`) USING BTREE;

--
-- 表的索引 `goods_type`
--
ALTER TABLE `goods_type`
  ADD PRIMARY KEY (`typeId`) USING BTREE,
  ADD KEY `typeMainId` (`typeMainId`) USING BTREE,
  ADD KEY `typeWeight` (`typeWeight`) USING BTREE;

--
-- 表的索引 `orders_list`
--
ALTER TABLE `orders_list`
  ADD PRIMARY KEY (`orderId`) USING BTREE,
  ADD UNIQUE KEY `orderSn` (`orderSn`) USING BTREE,
  ADD KEY `orderStatus` (`orderStatus`) USING BTREE,
  ADD KEY `orderUserId` (`orderUserId`) USING BTREE;

--
-- 表的索引 `orders_payment`
--
ALTER TABLE `orders_payment`
  ADD PRIMARY KEY (`orderId`) USING BTREE,
  ADD KEY `payStatus` (`payStatus`) USING BTREE,
  ADD KEY `orderId` (`orderId`) USING BTREE;

--
-- 表的索引 `orders_takemessage`
--
ALTER TABLE `orders_takemessage`
  ADD PRIMARY KEY (`msgId`) USING BTREE,
  ADD KEY `tmpId` (`tmpId`) USING BTREE;

--
-- 表的索引 `orders_takeway`
--
ALTER TABLE `orders_takeway`
  ADD PRIMARY KEY (`tmpId`) USING BTREE,
  ADD KEY `userId` (`userId`) USING BTREE,
  ADD KEY `orderStatus` (`orderStatus`) USING BTREE,
  ADD KEY `orderServiceId` (`orderServiceId`) USING BTREE;

--
-- 表的索引 `orders_takewaygoods`
--
ALTER TABLE `orders_takewaygoods`
  ADD PRIMARY KEY (`goodsId`) USING BTREE,
  ADD KEY `tmpId` (`tmpId`) USING BTREE;

--
-- 表的索引 `order_goods`
--
ALTER TABLE `order_goods`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `order_id` (`order_id`) USING BTREE,
  ADD KEY `goods_id` (`goods_id`) USING BTREE;

--
-- 表的索引 `service_user`
--
ALTER TABLE `service_user`
  ADD PRIMARY KEY (`userId`) USING BTREE,
  ADD KEY `userName` (`userName`) USING BTREE;

--
-- 表的索引 `user_list`
--
ALTER TABLE `user_list`
  ADD PRIMARY KEY (`userId`) USING BTREE,
  ADD KEY `userTempToken` (`userTempToken`) USING BTREE,
  ADD KEY `userName` (`userName`) USING BTREE,
  ADD KEY `userEmail` (`userEmail`) USING BTREE,
  ADD KEY `openId` (`openId`) USING BTREE,
  ADD KEY `user_inviti` (`user_inviti`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin_list`
--
ALTER TABLE `admin_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `cake_config`
--
ALTER TABLE `cake_config`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `cart_info`
--
ALTER TABLE `cart_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `cart_list`
--
ALTER TABLE `cart_list`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `goods_extends`
--
ALTER TABLE `goods_extends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `goods_list`
--
ALTER TABLE `goods_list`
  MODIFY `goods_Id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- 使用表AUTO_INCREMENT `goods_type`
--
ALTER TABLE `goods_type`
  MODIFY `typeId` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `orders_list`
--
ALTER TABLE `orders_list`
  MODIFY `orderId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `orders_takemessage`
--
ALTER TABLE `orders_takemessage`
  MODIFY `msgId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `orders_takeway`
--
ALTER TABLE `orders_takeway`
  MODIFY `tmpId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `orders_takewaygoods`
--
ALTER TABLE `orders_takewaygoods`
  MODIFY `goodsId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `order_goods`
--
ALTER TABLE `order_goods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `service_user`
--
ALTER TABLE `service_user`
  MODIFY `userId` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `user_list`
--
ALTER TABLE `user_list`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
