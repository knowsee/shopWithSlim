<?= $this->fetch('common/header.php') ?>
<!-- Sart Single product -->
<section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-pro-rightside ec-common-rightside col-lg-12 col-md-12">

                    <!-- Single product content Start -->
                    <div class="single-pro-block">
                        <div class="single-pro-inner">
                            <div class="row">
                                <div class="single-pro-img single-pro-img-no-sidebar">
                                    <div class="single-product-scroll">
                                        <div class="single-product-cover">
										<?php foreach($extimg as $img): ?>
                                            <div class="single-slide zoom-image-hover">
                                                <img class="img-responsive" src="<?=$img?>"
                                                    alt="">
                                            </div>
										<?php endforeach; ?>	
                                        </div>
                                        <div class="single-nav-thumb">
											<?php foreach($extimg as $img): ?>
                                            <div class="single-slide">
                                                <img class="img-responsive" src="<?=$img?>"
                                                    alt="">
                                            </div>
											<?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="single-pro-desc single-pro-desc-no-sidebar">
                                    <div class="single-pro-content">
                                        <h5 class="ec-single-title"><?=$info[\App\Model\Goods::TABLE_GOODS_NAME]?></h5>
                                        <div class="ec-single-rating-wrap">
                                            <!--<div class="ec-single-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star-o"></i>
                                            </div>-->
                                        </div>
                                        <!--<div class="ec-single-desc"></div>-->
                                        <div class="ec-single-price-stoke">
                                            <div class="ec-single-price">
                                                <span class="ec-single-ps-title"></span>
                                                <span class="new-price">$<?=$info[\App\Model\Goods::TABLE_GOODS_PRICE]?></span><span id="totalFee">fee: 0.00</span>
                                            </div>
                                            <div class="ec-single-stoke">
                                                <span class="ec-single-ps-title">IN STOCK</span>
                                                <span class="ec-single-sku"></span>
                                            </div>
                                        </div>
										<?php if($info['goods_sku']): ?>
										<div class="ec-pro-variation">
                                            <div class="ec-pro-variation-inner ec-pro-variation-size">
                                                <span>sku</span>
                                                <div id="skuListView" class="ec-pro-variation-content">
                                                    <ul>
													<?php foreach($info['goods_sku'] as $sku): ?>
                                                        <li id="onsku_<?=$sku['id']?>" class="sku" data-skuid="<?=$sku['id']?>" data-prices="<?=$sku['prices']?>"><span><?=$sku['name']?></span></li>
													<?php endforeach; ?>
													<!--class="active"-->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
										<?php endif; ?>
                                        <?php if($info['is_cake'] == 1): ?>
										<div class="ec-pro-variation">
											<div class="space-t-15">
												<label class="form-label">加朱古力球數量</label>
												<select name="options[]" data-name="id" style="border:1px solid #eeeeee !important" class="form-select">
												<?php foreach($cakeConfig['cNum'] as $value): ?>
													<option value="<?=$value['id']?>" data-prices="<?=$value['prices']?>"><?=$value['name']?>(+<?=$value['prices']?>)</option>
												<?php endforeach; ?>
												</select>
											</div>
											<div class="space-t-15">
												<label class="form-label">朱古力球顔色</label>
												<select name="options[]" data-name="id" style="border:1px solid #eeeeee !important" class="form-select">
												<?php foreach($cakeConfig['cColor'] as $value): ?>
													<option value="<?=$value['id']?>" data-prices="<?=$value['prices']?>"><?=$value['name']?>(+<?=$value['prices']?>)</option>
												<?php endforeach; ?>
												</select>
											</div>
											<div class="space-t-15">
												<label class="form-label">交收时间</label>
												<select name="options[]" data-name="id" style="border:1px solid #eeeeee !important" class="form-select">
												<?php foreach($cakeConfig['timepackup'] as $value): ?>
													<option value="<?=$value['id']?>" data-prices="<?=$value['prices']?>"><?=$value['name']?>(+<?=$value['prices']?>)</option>
												<?php endforeach; ?>
												</select>
											</div>
											<div class="space-t-15">
												<label class="form-label">月亮燈上字句（每字<?=$cakeConfig['word']?>元）</label>
												<select name="options[]" data-name="id" style="border:1px solid #eeeeee !important" class="form-select" onchange="selectTo(this.value)">
													<option value="no">不需要</option>
													<option value="yes">需要</option>
												</select>
											</div>
											<div class="space-t-15" id="textwords" style="display: none;">
												<label class="form-label">月亮燈上字句</label>
												<input type="text" name="options[wordtext]"  data-prices="<?=$cakeConfig['word']?>" data-name="wordtext" class="form-control" placeholder="填写内容（每字<?=$cakeConfig['word']?>元）">
											</div>
											<div class="space-t-15">
												<label class="form-label">玻璃盒上人名(只限英文大寫)</label>
												<input type="text" name="options[boxname]" data-name="boxname" class="form-control" placeholder="玻璃盒上人名">
											</div>
										</div>
                                        <?php else: ?>
                                            <input type="hidden" name="options[]" value="" />
                                        <?php endif; ?>

                                        <div class="ec-single-qty">
                                            <div class="qty-plus-minus">
                                                <input class="qty-input" name="stockNum" type="number" min="1" max="<?=$info[\App\Model\Goods::TABLE_GOODS_NUM]?>" step="1" value="<?=$goodsCartNum?>"/>
                                            </div>
                                            <div class="ec-single-cart ">
                                                <button class="btn btn-primary button-add-cart">Add To Cart</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Single product content End -->
                    <!-- Single product tab start -->
                    <div class="ec-single-pro-tab">
                        <div class="ec-single-pro-tab-wrapper">
                            <div class="ec-single-pro-tab-nav">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#ec-spt-nav-details" role="tablist">Detail</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content  ec-single-pro-tab-content">
                                <div id="ec-spt-nav-details" class="tab-pane fade show active">
                                    <div class="ec-single-pro-tab-desc">
                                    <pre><?=$info[\App\Model\Goods::TABLE_GOODS_MESSAGE] ? $info[\App\Model\Goods::TABLE_GOODS_MESSAGE] : '暂无详细介绍'?></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product details description area end -->
                </div>

            </div>
        </div>
    </section>
    <!-- End Single product -->






<script>
let skuIdView = '';
let skuId = 0;
let totalFee = 0;
function selectTo(type) {
    if(type == 'no') {
		$('input[name="options[wordtext]"]').val('');
        $('#textwords').hide();
    } else {
        $('#textwords').show();
    }
}
function wordsCount(str) {
  if (str == null || str == '') return 0;
  return str.match(/\w?|\W?/g).length - 1;
}
function isEnglish(str) {
  return /^[a-zA-Z]+$/.test(str);
}
window.onload = function() {
	$('select[name^="options"]').map(function(){
		if($(this).data('name') == 'id') {
			if($(this).val() !== 'no' && $(this).val() !== 'yes') {
				totalFee += Number($(this).find('option:selected').data('prices'));
			}
			if($(this).val() == 'yes') {
				totalFee += Number(wordsCount($('input[name="options[wordtext]"]').val()))*<?=$cakeConfig['word']?>;
			}
		}
	});
	$('#totalFee').text('+ fee: $'+totalFee);
	$('[name^="options"]').change(function() {
		totalFee = 0;
		$('select[name^="options"]').map(function(){
			if($(this).data('name') == 'id') {
				if($(this).val() !== 'no' && $(this).val() !== 'yes') {
					totalFee += Number($(this).find('option:selected').data('prices'));
				}
				if($(this).val() == 'yes') {
					totalFee += Number(wordsCount($('input[name="options[wordtext]"]').val()))*<?=$cakeConfig['word']?>;
				}
			}
		});
		console.log(totalFee);
		$('#totalFee').text('+ fee: $'+totalFee);
	});
	
	<?php if($info['goods_sku']): ?>
	skuIdView = $('#skuListView').find('li:first').attr('id');
	$('#'+skuIdView).trigger('click');
    skuId = $('#'+skuIdView).data('skuid');
	$('.new-price').text('$'+$('#skuListView').find('li:first').data('prices'));
	$('li.sku').click(function() {
		skuId = $(this).data('skuid');
		$('.new-price').text('$'+$(this).data('prices'));
	});
	<?php endif; ?>
    $('.button-add-cart').click(function() {
		var boxname = $('input[name="options[boxname]"]').val();
		if(boxname !== '' && !isEnglish(boxname)) {
			alert('玻璃盒上人名只限英文');
			return;
		} else {
			addCart('<?= $info[\App\Model\Goods::TABLE_PY] ?>', $('input[name="stockNum"]').val(), skuId, $('[name^="options"]').map(function(){return {'value':$(this).val(), 'name': $(this).data('name')};}).get());
		}
    })
}
</script>
<style>
.ec-pro-variation .ec-pro-variation-inner.ec-pro-variation-size .ec-pro-variation-content .active {
	padding: 5px 10px;
}
.ec-pro-variation .ec-pro-variation-inner.ec-pro-variation-size .ec-pro-variation-content li {
	padding: 5px 10px;
}
.single-pro-content .ec-pro-variation .ec-pro-variation-inner .ec-pro-variation-content li {
	height: auto;
	width: auto;
}
</style>
<?= $this->fetch('common/footer.php') ?>