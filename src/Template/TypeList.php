<?= $this->fetch('common/header.php') ?>
<section class="ec-page-content section-space-p">
        <div class="container-fluid">
            <div class="row">
                <div class="ec-shop-rightside col-lg-12 col-md-12">
                    <!-- Shop Top Start -->
                    <!-- <div class="ec-pro-list-top d-flex">
                        <div class="col-md-6 ec-grid-list">
                            <div class="ec-gl-btn">
                                <button class="btn sidebar-toggle-icon"><img src="<?= siteUrl() ?>assets/images/icons/filter.svg"
                                        class="svg_img gl_svg" alt="filter" /></button>
                                <button class="btn btn-grid-50 active"><img src="<?= siteUrl() ?>assets/images/icons/grid.svg"
                                        class="svg_img gl_svg" alt="grid" /></button>
                                <button class="btn btn-list-50"><img src="<?= siteUrl() ?>assets/images/icons/list.svg"
                                        class="svg_img gl_svg" alt="list" /></button>
                            </div>
                        </div>
                        <div class="col-md-6 ec-sort-select">
                            <span class="sort-by">Sort by</span>
                            <div class="ec-select-inner">
                                <select name="ec-select" id="ec-select">
                                    <option selected disabled>Position</option>
                                    <option value="1">Relevance</option>
                                    <option value="2">Name, A to Z</option>
                                    <option value="3">Name, Z to A</option>
                                    <option value="4">Price, low to high</option>
                                    <option value="5">Price, high to low</option>
                                </select>
                            </div>
                        </div>
                    </div> -->
                    <!-- Shop Top End -->

                    <!-- Shop content Start -->
                    <div class="shop-pro-content">
                        <div class="shop-pro-inner">
                            <div class="row">
                            <?php foreach ($goodslist as $k => $hInfo) : ?>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 mb-6 pro-gl-content">
                                    <div class="ec-product-inner">
                                        <div class="ec-pro-image-outer">
                                            <div class="ec-pro-image">
                                                <a href="<?=excUrl('Index/Goods')?>?goodsId=<?= $hInfo['goods_Id'] ?>" class="image">
                                                    <img class="main-image" 
                                                        src="<?= $hInfo['goods_images'] ?>" height="238" />
                                                </a>
                                                <!--<span class="percentage">20%</span>-->
                                                <div class="ec-pro-actions">
                                                    <!--<a href="compare.html" class="ec-btn-group compare"
                                                        title="Compare"><img src="<?= siteUrl() ?>assets/images/icons/compare.svg"
                                                            class="svg_img pro_svg" alt="" /></a>-->
                                                    <?php if($hInfo['is_cake'] == 0): ?>
                                                    <button title="Add To Cart"  data-id="<?= $hInfo['goods_Id'] ?>" class="addcart add-to-cart">
                                                        <img src="<?= siteUrl() ?>assets/images/icons/cart.svg" class="svg_img pro_svg"
                                                            alt="" />Add To Cart
                                                    </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-pro-content">
                                            <h5 class="ec-pro-title"><a href="<?=excUrl('Index/Goods')?>?goodsId=<?= $hInfo['goods_Id'] ?>"><?= $hInfo['goods_name'] ?></a></h5>
                                            <!--<div class="ec-pro-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star"></i>
                                            </div>-->
                                            <span class="ec-price">
                                                <!--<span class="old-price">$27.00</span>-->
                                                <span class="new-price">$<?= $hInfo['goods_price'] ?></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            </div>
                        </div>
                        <!-- Ec Pagination Start -->
                        <div class="ec-pro-pagination">
                            <span>Page <?=$page?></span>
                            <ul class="ec-pro-pagination-inner">
                            <?php if($page > 1): ?>
                                <li><a class="next" href="<?=excUrl('Index/Types')?>?typeId=<?=$typeId?>&page=<?=$page-1?>"> <i class="ecicon eci-angle-left"></i></a></li>
                            <?php endif; ?>
                            <?php if(count($goodslist) == 12): ?>
                                <li><a class="next" href="<?=excUrl('Index/Types')?>?typeId=<?=$typeId?>&page=<?=$page+1?>"> <i class="ecicon eci-angle-right"></i></a></li>
                            <?php endif; ?>
                            </ul>
                        </div>
                        <!-- Ec Pagination End -->
                    </div>
                    <!--Shop content End -->
                </div>

            </div>
        </div>
    </section>
    <!-- End Shop page -->





<script>
window.onload = function() {
    $('.addcart').click(function() {
		addCart($(this).data('id'), 1, 0)
	});
}
</script>
<?= $this->fetch('common/footer.php') ?>