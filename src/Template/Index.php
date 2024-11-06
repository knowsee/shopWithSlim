<?= $this->fetch('common/header.php') ?>
<link rel="stylesheet" href="<?= siteUrl() ?>assets/css/demo1.css" />
    <!-- Main Slider Start -->
    <div class="sticky-header-next-sec ec-main-slider section section-space-pb">
        <div class="ec-slider swiper-container main-slider-nav main-slider-dot">
            <!-- Main slider -->
            <div class="swiper-wrapper">
                <div class="ec-slide-item swiper-slide d-flex ec-slide-1">
                    <div class="container align-self-center">
                        <div class="row">
                            <div class="col-xl-6 col-lg-7 col-md-7 col-sm-7 align-self-center">
                                <div class="ec-slide-content slider-animation">
                                    <h1 class="ec-slide-title">新城創建工程有限公司</h1>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ec-slide-item swiper-slide d-flex ec-slide-2">
                    <div class="container align-self-center">
                        <div class="row">
                            <div class="col-xl-6 col-lg-7 col-md-7 col-sm-7 align-self-center">
                                <div class="ec-slide-content slider-animation">
                                    <h1 class="ec-slide-title">冷氣清洗服務</h1>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination swiper-pagination-white"></div>
            <div class="swiper-buttons">
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
    <!-- Main Slider End -->

    <!-- Product tab Area Start -->
    <section class="section ec-product-tab section-space-p">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">服務及產品</h2>
                        <h2 class="ec-title">服務及產品</h2>
                        
                    </div>
                </div>

                <!-- Tab Start -->
                <div class="col-md-12 text-center">
                    <ul class="ec-pro-tab-nav nav justify-content-center">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-for-new">New</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-for-hot">Hot</a></li>
                    </ul>
                </div>
                <!-- Tab End -->
            </div>
            <div class="row">
                <div class="col">
                    <div class="tab-content">
                        <!-- 1st Product tab start -->
                        <div class="tab-pane fade show active" id="tab-for-new">
                            <div class="row">
                                <!-- Product Content -->
                                <?php foreach ($new as $k => $hInfo) : ?>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content" data-animation="fadeIn">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="<?=excUrl('Index/Goods')?>?goodsId=<?= $hInfo['goods_Id'] ?>" class="image">
                                                    <img class="main-image" 
                                                        src="<?= $hInfo['goods_images'] ?>" height="238" />
                                                </a>
                                                <!--<span class="percentage">20%</span>-->
                                                <?php if($hInfo['is_cake'] == 0): ?>
                                                <div class="ec-pro-actions">
                                                    <button title="Add To Cart"  data-id="<?= $hInfo['goods_Id'] ?>" class="addcart add-to-cart">
                                                        <img src="<?= siteUrl() ?>assets/images/icons/cart.svg" class="svg_img pro_svg"
                                                            alt="" />Add To Cart
                                                    </button>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="<?=excUrl('Index/Goods')?>?goodsId=<?= $hInfo['goods_Id'] ?>"><?= $hInfo['goods_name'] ?></a></h5>
                                            <span class="ec-price">
                                                <span class="new-price">$<?= $hInfo['goods_price'] ?></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>

                                <div class="col-sm-12 shop-all-btn"><a href="<?=excUrl('Index/List')?>">全部</a></div>
                            </div>
                        </div>
                        <!-- ec 1st Product tab end -->
                        <!-- ec 2nd Product tab start -->
                        <div class="tab-pane fade" id="tab-for-hot">
                            <div class="row">
                                <!-- Product Content -->
                                <?php foreach ($hot as $k => $hInfo) : ?>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 mb-3  ec-product-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="<?=excUrl('Index/Goods')?>?goodsId=<?= $hInfo['goods_Id'] ?>" class="image">
                                                    <img class="main-image" 
                                                        src="<?= $hInfo['goods_images'] ?>" height="238" />
                                                </a>
                                                <!--<span class="percentage">20%</span>-->
                                                <?php if($hInfo['is_cake'] == 0): ?>
                                                <div class="ec-pro-actions">
                                                    <button title="Add To Cart"  data-id="<?= $hInfo['goods_Id'] ?>" class="addcart add-to-cart">
                                                        <img src="<?= siteUrl() ?>assets/images/icons/cart.svg" class="svg_img pro_svg"
                                                            alt="" />Add To Cart
                                                    </button>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="<?=excUrl('Index/Goods')?>?goodsId=<?= $hInfo['goods_Id'] ?>"><?= $hInfo['goods_name'] ?></a></h5>
                                            <span class="ec-price">
                                                <span class="new-price">$<?= $hInfo['goods_price'] ?></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <div class="col-sm-12 shop-all-btn"><a href="<?=excUrl('Index/HotList')?>">Show All Collection</a></div>
                            </div>
                        </div>
                        <!-- ec 2nd Product tab end -->
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ec Product tab Area End -->

    <!-- ec Banner Section Start -->
    <section class="ec-banner section section-space-p">
        <h2 class="d-none">Banner</h2>
        <div class="container">
            <!-- ec Banners Start -->
            <div class="ec-banner-inner">
                <!--ec Banner Start -->
                <div class="ec-banner-block ec-banner-block-2">
                    <div class="row">
                        <div class="banner-block col-lg-6 col-md-12 margin-b-30" data-animation="slideInRight">
                            <div class="bnr-overlay">
                                <img src="<?= siteUrl() ?>assets/images/banner/2.jpg" alt="" />
                                <div class="banner-text">
                                    <span class="ec-banner-stitle">清洗各類型冷氣機</span>
                                 </div>
                              
                            </div>
                        </div>
                        <div class="banner-block col-lg-6 col-md-12" data-animation="slideInLeft">
                            <div class="bnr-overlay">
                                <img src="<?= siteUrl() ?>assets/images/banner/3.jpg" alt="" />
                                <div class="banner-text">
                                    <span class="ec-banner-stitle">檢查維修</span>
                                 </div>
                              
                            </div>
                        </div>
                    </div>
                    <!-- ec Banner End -->
                </div>
                <!-- ec Banners End -->
            </div>
        </div>
    </section>
    <!-- ec Banner Section End -->

    <!--  services Section Start -->
    <section class="section ec-services-section section-space-p">
        <h2 class="d-none">Services</h2>
        <div class="container">
            <div class="row">
                <div class="ec_ser_content ec_ser_content_1 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                    <div class="ec_ser_inner">
                        
                        <div class="ec-service-desc">
                            <h2>冷氣清洗</h2>
                         </div>
                    </div>
                </div>
                <div class="ec_ser_content ec_ser_content_2 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                    <div class="ec_ser_inner">
                        
                        <div class="ec-service-desc">
                            <h2>冷氣檢查</h2>
                         </div>
                    </div>
                </div>
                <div class="ec_ser_content ec_ser_content_3 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                    <div class="ec_ser_inner">
                       
                        <div class="ec-service-desc">
                            <h2>冷氣安裝</h2>
                         </div>
                    </div>
                </div>
                <div class="ec_ser_content ec_ser_content_4 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                    <div class="ec_ser_inner">
                     
                        <div class="ec-service-desc">
                            <h2>冷氣維修</h2>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--services Section End -->

 

    <!-- Ec Brand Section Start -->
    <section class="section ec-brand-area section-space-p">
        <h2 class="d-none">Brand</h2>
        <div class="container">
            <div class="row">
                <div class="ec-brand-outer">
                    <ul id="ec-brand-slider">
                        <li class="ec-brand-item"  data-animation="zoomIn">
                            <h4>廚房</h4>
                        </li>
                        <li class="ec-brand-item"  data-animation="zoomIn">
                            <h4>睡房</h4>
                        </li>
                        <li class="ec-brand-item"  data-animation="zoomIn">
                            <h4>客廳</h4>
                        </li>
                        <li class="ec-brand-item"  data-animation="zoomIn">
                            <h4>浴室</h4>
                        </li>
                        <li class="ec-brand-item"  data-animation="zoomIn">
                            <h4>清拆</h4>
                        </li>
                        <li class="ec-brand-item"  data-animation="zoomIn">
                            <h4>油漆</h4>
                        </li>
                        <li class="ec-brand-item"  data-animation="zoomIn">
                            <h4>水喉</h4>
                        </li>
                        <li class="ec-brand-item"  data-animation="zoomIn">
                            <h4>電工</h4>
                        </li>
                        <li class="ec-brand-item"  data-animation="zoomIn">
                            <h4>木器</h4>
                        </li>

                        <li class="ec-brand-item"  data-animation="zoomIn">
                            <h4>泥水</h4>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Ec Brand Section End -->
 

<script>
window.onload = function() {
    $('.addcart').click(function() {
		addCart($(this).data('id'), 1)
	});
}
</script>
<?= $this->fetch('common/footer.php') ?>