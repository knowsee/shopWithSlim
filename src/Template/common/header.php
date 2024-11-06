<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    
    <title><?=$title?> <?=$_ENV['SITE_NAME']?></title>

    <!-- site Favicon -->
    <link rel="icon" href="<?= siteUrl() ?>assets/images/favicon/favicon.png" sizes="32x32" />
    <link rel="apple-touch-icon" href="<?= siteUrl() ?>assets/images/favicon/favicon.png" />
    
    <!-- css Icon Font -->
    <link rel="stylesheet" href="<?= siteUrl() ?>assets/css/vendor/ecicons.min.css" />
    <link rel="stylesheet" href="<?= siteUrl() ?>assets/css/all.css" rel="stylesheet">

    <!-- css All Plugins Files -->
    <link rel="stylesheet" href="<?= siteUrl() ?>assets/css/plugins/animate.css" />
    <link rel="stylesheet" href="<?= siteUrl() ?>assets/css/plugins/swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?= siteUrl() ?>assets/css/plugins/jquery-ui.min.css" />
    <link rel="stylesheet" href="<?= siteUrl() ?>assets/css/plugins/countdownTimer.css" />
    <link rel="stylesheet" href="<?= siteUrl() ?>assets/css/plugins/slick.min.css" />
    <link rel="stylesheet" href="<?= siteUrl() ?>assets/css/plugins/bootstrap.css" />
    <link rel="stylesheet" href="<?= siteUrl() ?>assets/css/plugins/nouislider.css" />
    <link rel="stylesheet" href="<?= siteUrl() ?>assets/css/plugins/jquery.toast.min.css" />
    <!-- Main Style -->
    <link rel="stylesheet" href="<?= siteUrl() ?>assets/css/style.css" />
    <link rel="stylesheet" href="<?= siteUrl() ?>assets/css/responsive.css" />
    

    <!-- Background css -->
    <link rel="stylesheet" id="bg-switcher-css" href="<?= siteUrl() ?>assets/css/backgrounds/bg-4.css">
    <script>
    var setting_shop = {'isLogin': '<?=$user['userName'] ? true : false?>','cartnum': '<?=excUrl('/ApiCart/GetNum')?>','cartput': '<?=excUrl('/ApiCart/Put')?>','carttake': '<?=excUrl('/ApiCart/Take')?>','cartdelete': '<?=excUrl('/ApiCart/Delete')?>'};
    </script>
</head>
<body>

    <!-- Header start  -->
    <header class="ec-header">
        <!--Ec Header Top Start -->
        <div class="header-top">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Header Top social Start -->
                   
                    <!-- Header Top social End -->
                    <!-- Header Top Message Start -->
                    <div class="col header-top-center">
                        <div class="header-top-message text-upper">
                        <?=$_ENV['SITE_NAME']?>
                        </div>
                    </div>
                    <!-- Header Top Message End -->
                    <!-- Header Top Language Currency -->
                    <div class="col header-top-right d-none d-lg-block">
                        <div class="header-top-lan-curr d-flex justify-content-end">
                        </div>
                    </div>
                    <!-- Header Top Language Currency -->
                    <!-- Header Top responsive Action -->
                    <div class="col d-lg-none ">
                        <div class="ec-header-bottons">
                            <!-- Header User Start -->
                            <div class="ec-header-user dropdown">
                                <button class="dropdown-toggle" data-bs-toggle="dropdown"><img
                                        src="<?= siteUrl() ?>assets/images/icons/user.svg" class="svg_img header_svg" alt="" /></button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <?php if($user['userName']): ?>
                                        <li><a class="dropdown-item" href="#">Welcome <?=$user['userName']?></a></li>
                                        <li><a class="dropdown-item" href="<?=excUrl('Users/OrderList')?>">訂單</a></li>
                                        <li><a class="dropdown-item" href="<?=excUrl('Index/Cart')?>">購物車</a></li>
										<li><a class="dropdown-item" href="javascript:logout();">登出</a></li>
                                    <?php else: ?>
                                        <li><a class="dropdown-item" href="<?=excUrl('Index/Reg')?>">成為會員</a></li>
                                        <li><a class="dropdown-item" href="<?=excUrl('Index/Login')?>">登入</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <!-- Header User End -->
                            <!-- Header Cart Start -->
                            <a href="<?=excUrl('Index/Cart')?>" class="ec-header-btn">
                                <div class="header-icon"><img src="<?= siteUrl() ?>assets/images/icons/cart.svg"
                                        class="svg_img header_svg" alt="" /></div>
                                <span class="ec-header-count cart-count-lable" id="cart_num"><?=intval($user['cartNum'])?></span>
                            </a>
                            <!-- Header Cart End -->
                            <!-- Header menu Start -->
                            <a href="#ec-mobile-menu" class="ec-header-btn ec-side-toggle d-lg-none">
                                <img src="<?= siteUrl() ?>assets/images/icons/menu.svg" class="svg_img header_svg" alt="icon" />
                            </a>
                            <!-- Header menu End -->
                        </div>
                    </div>
                    <!-- Header Top responsive Action -->
                </div>
            </div>
        </div>
        <!-- Ec Header Top  End -->
        <!-- Ec Header Bottom  Start -->
        <div class="ec-header-bottom d-none d-lg-block">
            <div class="container position-relative">
                <div class="row">
                    <div class="ec-flex">
                        <!-- Ec Header Logo Start -->
                        <div class="align-self-center">
                            <div class="header-logo">
                                <a href="<?=excUrl('Index/Index')?>"><img src="<?= siteUrl() ?>assets/images/logo/logo.png" alt="Site Logo" /><img
                                        class="dark-logo" src="<?= siteUrl() ?>assets/images/logo/dark-logo.png" alt="Site Logo"
                                        style="display: none;" /></a>
                            </div>
                        </div>
                        <!-- Ec Header Logo End -->

                        <!-- Ec Header Search Start -->
                        <div class="align-self-center">
                            <div class="header-search">
                                <div class="ec-btn-group-form">
                                    <input class="form-control" name="keywordsearch" placeholder="Enter Your Product Name..." type="text">
                                    <button class="submit keywordsearchbut" type="button"><img src="<?= siteUrl() ?>assets/images/icons/search.svg"
                                            class="svg_img header_svg" alt="" /></button>
                                </div>
                            </div>
                        </div>
                        <!-- Ec Header Search End -->

                        <!-- Ec Header Button Start -->
                        <div class="align-self-center">
                            <div class="ec-header-bottons">

                                <!-- Header User Start -->
                                <div class="ec-header-user dropdown">
                                    <button class="dropdown-toggle" data-bs-toggle="dropdown"><img
                                            src="<?= siteUrl() ?>assets/images/icons/user.svg" class="svg_img header_svg" alt="" /></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                    <?php if($user['userName']): ?>
                                        <li><a class="dropdown-item" href="#">你好 <?=$user['userName']?></a></li>
                                        <li><a class="dropdown-item" href="<?=excUrl('Users/OrderList')?>">訂單</a></li>
                                        <li><a class="dropdown-item" href="<?=excUrl('Index/Cart')?>">購物車</a></li>
										<li><a class="dropdown-item" href="javascript:logout();">登出</a></li>
                                    <?php else: ?>
                                        <li><a class="dropdown-item" href="<?=excUrl('Index/Reg')?>">成為會員</a></li>
                                        <li><a class="dropdown-item" href="<?=excUrl('Index/Login')?>">登入</a></li>
                                    <?php endif; ?>
                                    </ul>
                                </div>
                                <!-- Header User End -->
                                <!-- Header Cart Start -->
                                <a href="<?=excUrl('Index/Cart')?>" class="ec-header-btn">
                                    <div class="header-icon"><img src="<?= siteUrl() ?>assets/images/icons/cart.svg"
                                            class="svg_img header_svg" alt="" /></div>
                                    <span class="ec-header-count cart-count-lable" id="cart_num_x"><?=intval($user['cartNum'])?></span>
                                </a>
                                <!-- Header Cart End -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Ec Header Button End -->
        <!-- Header responsive Bottom  Start -->
        <div class="ec-header-bottom d-lg-none">
            <div class="container position-relative">
                <div class="row ">

                    <!-- Ec Header Logo Start -->
                    <div class="col">
                        <div class="header-logo">
                            <a href="<?=excUrl('Index/Index')?>"><img src="<?= siteUrl() ?>assets/images/logo/logo.png" alt="Site Logo" /><img
                                    class="dark-logo" src="<?= siteUrl() ?>assets/images/logo/dark-logo.png" alt="Site Logo"
                                    style="display: none;" /></a>
                        </div>
                    </div>
                    <!-- Ec Header Logo End -->
                    <!-- Ec Header Search Start -->
                    <div class="col">
                        <div class="header-search">
                            <div class="ec-btn-group-form">
                                <input class="form-control" name="keywordsearch" placeholder="Enter Your Product Name..." type="text">
                                <button class="submit keywordsearchbut" type="button"><img src="<?= siteUrl() ?>assets/images/icons/search.svg"
                                        class="svg_img header_svg" alt="icon" /></button>
                            </div>
                        </div>
                    </div>
                    <!-- Ec Header Search End -->
                </div>
            </div>
        </div>
        <!-- Header responsive Bottom  End -->
        <!-- EC Main Menu Start -->
        <div id="ec-main-menu-desk" class="d-none d-lg-block sticky-nav">
            <div class="container position-relative">
                <div class="row">
                    <div class="col-md-12 align-self-center">
                        <div class="ec-main-menu">
                            <ul>
                                <li><a href="/">Home</a></li>
                                <?foreach($type_system['btype'] as $Id => $typeName):?>
                                    <?php if(isset($type_system['stype'][$Id])): ?>
                                    <li class="dropdown"><a href="javascript:void(0)"><?=$typeName?></a>
                                        <ul class="sub-menu">
                                        <?foreach($type_system['stype'][$Id] as $stype):?>
                                            <li><a href="<?=excUrl('Index/Types')?>?typeId=<?=$stype['typeId']?>"><?=$stype['typeName']?></a></li>
                                        <?php endforeach;?>
                                        </ul>
                                    </li>
                                    <?php else: ?>
                                    <li><a href="<?=excUrl('Index/Types')?>?typeId=<?=$Id?>"><?=$typeName?></a></li>
                                    <?php endif; ?>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Ec Main Menu End -->
        <!-- ekka Mobile Menu Start -->
        <div id="ec-mobile-menu" class="ec-side-cart ec-mobile-menu">
            <div class="ec-menu-title">
                <span class="menu_title">My Menu</span>
                <button class="ec-close">×</button>
            </div>
            <div class="ec-menu-inner">
                <div class="ec-menu-content">
                    <ul>
                        <li><a href="<?=excUrl('Index/Index')?>">Home</a></li>
                        <?foreach($type_system['btype'] as $Id => $typeName):?>
                            <?php if(isset($type_system['stype'][$Id])): ?>
                                <li><a href="javascript:void(0)"><?=$typeName?></a>
                                    <ul class="sub-menu">
                                    <?foreach($type_system['stype'][$Id] as $stype):?>
                                        <li><a href="<?=excUrl('Index/Types')?>?typeId=<?=$stype['typeId']?>"><?=$stype['typeName']?></a></li>
                                    <?php endforeach;?>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li><a href="<?=excUrl('Index/Types')?>?typeId=<?=$Id?>"><?=$typeName?></a></li>
                            <?php endif; ?>
                        <?php endforeach;?>    
                    </ul>
                </div>
                <div class="header-res-lan-curr">
                    <div class="header-top-lan-curr">
                    </div>
                    <!-- Social Start -->
                    <div class="header-res-social">
                        <div class="header-top-social">
                            <ul class="mb-0">
                                <li class="list-inline-item"><a class="hdr-facebook" href="#"><i class="ecicon eci-facebook"></i></a></li>
                                <li class="list-inline-item"><a class="hdr-twitter" href="#"><i class="ecicon eci-twitter"></i></a></li>
                                <li class="list-inline-item"><a class="hdr-instagram" href="#"><i class="ecicon eci-instagram"></i></a></li>
                                <li class="list-inline-item"><a class="hdr-linkedin" href="#"><i class="ecicon eci-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Social End -->
                </div>
            </div>
        </div>
        <!-- ekka mobile Menu End -->
    </header>
    <!-- Header End  -->

    <style>
        .ec-product-inner .ec-pro-image .ec-pro-actions .add-to-cart {
            bottom: 0!important;
        }
    </style>
    <!-- ekka Cart End -->
<!-- Ec breadcrumb start -->
<div class="sticky-header-next-sec ec-breadcrumb section-space-mb">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row ec_breadcrumb_inner">
                    <div class="col-md-6 col-sm-12">
                        <h2 class="ec-breadcrumb-title"><?=$title?></h2>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <!-- ec-breadcrumb-list start -->
                        <ul class="ec-breadcrumb-list">
                            <li class="ec-breadcrumb-item"><a href="<?=excUrl('Index/Types')?>">Home</a></li>
                            <li class="ec-breadcrumb-item active"><?=$title?></li>
                        </ul>
                        <!-- ec-breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ec breadcrumb end -->