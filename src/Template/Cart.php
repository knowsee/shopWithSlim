<?= $this->fetch('common/header.php') ?>
<section class="ec-page-content section-space-p">
    <div class="container">
        <form name="new-cart" method="post" action="<?= excUrl('Index/CheckOut') ?>">
            <div class="row">
                <div class="ec-cart-leftside col-lg-8 col-md-12 ">
                    <!-- cart content Start -->
                    <div class="ec-cart-content">
                        <div class="ec-cart-inner">
                            <div class="row">

                                <div class="table-content cart-table-content" id="cartAjaxInfo">
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="ec-cart-update-bottom">
                                            <div class="col-lg-7">
                                                 
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="ec-btn-ds">
                                                    <button type="button" name="updatecart" class="btn btn-primary">更新</button>
                                                    <button type="submit" class="btn btn-primary">付款</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--cart content End -->
                </div>
                <!-- Sidebar Area Start -->
                <div class="ec-cart-rightside col-lg-4 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <!-- Sidebar Summary Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">總結</h3>
                            </div>

                            <div class="ec-sb-block-content">
                                <div class="ec-cart-summary-bottom">
                                    <div class="ec-cart-summary">
                                        <div>
                                            <span class="text-left">產品價格</span>
                                            <span class="text-right" id="sub-total">$<?= number_format($cart['total'], 2) ?></span>
                                        </div>
                                        <div style="display:none;">
                                            <span class="text-left">Delivery Charges</span>
                                            <span class="text-right" id="delivery-total">$<?= number_format($cart['extraTotal'], 2) ?></span>
                                        </div>
                                        <div class="ec-cart-summary-total">
                                            <span class="text-left">金額</span>
                                            <span class="text-right" id="prices-total">$<?= number_format($cart['total'], 2) ?></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Sidebar Summary Block -->
                    </div>
                </div>
            </div>
			<div class="row" style="padding-top:15px;">
                <h5>推荐商品</h5>
			<?php foreach ($cartOnlyGoods as $k => $cartGood) : ?>
				<div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 mb-6 pro-gl-content">
					<div class="ec-product-inner">
						<div class="ec-pro-image-outer">
							<div class="ec-pro-image">
								<a href="<?=excUrl('Index/Goods')?>?goodsId=<?= $cartGood['goods_Id'] ?>" class="image">
									<img class="main-image" 
										src="<?= $cartGood['goods_images'] ?>" height="138" />
								</a>
								<!--<span class="percentage">20%</span>-->
								<div class="ec-pro-actions">
									<!--<a href="compare.html" class="ec-btn-group compare"
										title="Compare"><img src="<?= siteUrl() ?>assets/images/icons/compare.svg"
											class="svg_img pro_svg" alt="" /></a>-->
									<button type="button" title="Add To Cart"  data-id="<?= $cartGood['goods_Id'] ?>" class="addcart add-to-cart">
										<img src="<?= siteUrl() ?>assets/images/icons/cart.svg" class="svg_img pro_svg"
											alt="" />Add To Cart
									</button>
								</div>
							</div>
						</div>
						<div class="ec-pro-content">
							<h5 class="ec-pro-title"><a href="<?=excUrl('Index/Goods')?>?goodsId=<?= $cartGood['goods_Id'] ?>"><?= $cartGood['goods_name'] ?></a></h5>
							<span class="ec-price">
								<!--<span class="old-price">$27.00</span>-->
								<span class="new-price">$<?= $cartGood['goods_price'] ?></span>
							</span>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
			</div>
        </form>
    </div>
</section>

<script type="text/template" id="cartTemplate">
    <table>
  <thead>
      <tr>
          <th>產品</th>
          <th>價錢</th>
          <th style="text-align: center;">數量</th>
          <th>總金額</th>
          <th></th>
      </tr>
  </thead>
  <tbody>
  {{#each list}}
    <input name="cartNumOld[{{goodsId}}_{{skuId}}]" type="hidden" value="{{num}}">
      <tr>

          <td data-label="Product" class="ec-cart-pro-name" style="position: relative;">
            <img class="ec-cart-pro-img mr-4" src="{{images}}" alt="" />
            <div style="position: absolute;top: 25px;left: 90px;width: 80%;">
                <a href="#">{{name}}({{skuName}})</a>
                <p style="font-size:12px;">{{options}}</p>
            </div>
          </td>
          <td data-label="Price" class="ec-cart-pro-price"><span class="amount">现價${{price}}</span><br><span style="font-size:12px;color: #979494;">原價${{o_prices}}<span></td>
          <td data-label="Quantity" class="ec-cart-pro-qty"
              style="text-align: center;">
              <div class="cart-qty-plus-minus">
                  <input class="cart-plus-minus change_num" type="text"
                  name="cartNum[{{goodsId}}_{{skuId}}]" value="{{num}}" />
              </div>
          </td>
          <td data-label="Total" class="ec-cart-pro-subtotal">{{totalPrices}}</td>
          <td data-label="Remove" class="ec-cart-pro-remove">
              <a href="javascript:deleteCart({{goodsId}}, {{skuId}}, function() {getList();});"><i class="ecicon eci-trash-o"></i></a>
          </td>
      </tr>
      {{/each}}
  </tbody>
</table>
</script>


<script>
    var queryNum = 0;
    window.onload = function() {
        function getList() {
            $.getJSON('<?= excUrl('Index/CartAjax') ?>', function(jsonData) {
                $('#cartAjaxInfo').html('');
                if (jsonData.data.list.length < 1) {
                    $('#cartAjaxInfo').html('Cart is empty');
                }
                $('#cartAjaxInfo').renderAppend($("#cartTemplate").html(), jsonData.data, function() {
                    var CartQtyPlusMinus = $(".cart-qty-plus-minus");
                    CartQtyPlusMinus.append('<div class="ec_cart_qtybtn"><div class="inc ec_qtybtn">+</div><div class="dec ec_qtybtn">-</div></div>');
                    $(".cart-qty-plus-minus .ec_cart_qtybtn .ec_qtybtn").on("click", function() {
                        var $cartqtybutton = $(this);
                        var CartQtyoldValue = $cartqtybutton.parent().parent().find("input").val();
                        if ($cartqtybutton.text() === "+") {
                            var CartQtynewVal = parseFloat(CartQtyoldValue) + 1;
                        } else {
                            if (CartQtyoldValue > 1) {
                                var CartQtynewVal = parseFloat(CartQtyoldValue) - 1;
                            } else {
                                CartQtynewVal = 1;
                            }
                        }
                        $cartqtybutton.parent().parent().find("input").val(CartQtynewVal);
                    });
                });
            });
        }
        getList();

        $('button[name="updatecart"]').click(function() {
            queryNum++;
            $.post('<?= excUrl('ApiCart/GoodsNumUpdate') ?>', $('form[name="new-cart"]').serialize(), function(data, textStatus, jqXHR) {
                queryNum--;
                if (queryNum < 1) {
                    $.getJSON('<?= excUrl('ApiCart/List') ?>', function(data) {
                        console.log(data);
                        if (data.code == 200) {
                            showToast('UPDATE SUCCESS');
                            $('#prices-total,#sub-total').text('$' + data.data.cartPrice);
                            $('#delivery-total').text('$' + data.data.extraTotal);
                            getList();
                        }
                    })
                }
            });
        });
        $('button[type="submit"]').attr('disabled', false);
        $('button[type="submit"]').html('支付');
		$('.addcart').click(function() {
			addCart($(this).data('id'), 1, $(this).data('skuid'), null, function() {
				window.location.reload();
			});
		});
        /*
        $('form').on('submit', function (e) {
              e.preventDefault();
              $.post('<?= excUrl('ApiCart/GoodsNumUpdate') ?>', $('form').serialize(), function(data, textStatus, jqXHR) {
                if(data.code !== 200) {
                  showToast(data.message);
                } else {
                  var options = {
                      success: function (data, textStatus, jqXHR) {
                          if (data.code !== 200) {
                              alertMsg(data.message, 'error');
                          } else {
                              alertExtendMsg('<p>we are working now..</p>', 'ORDER SUCCESS', 'success', function() {
                                window.location.href = '<?= excUrl('Order/Info') ?>?orderSn='+data.data.sn;
                              });
                          }
                      },
                      dataType: 'json',
                      error: function() {
                        showToast('SYSTEM BUSY');
                      }
                  };
                  $('form').ajaxSubmit(options);
                }
              });
          });
          */
    }
</script>

<?= $this->fetch('common/footer.php') ?>