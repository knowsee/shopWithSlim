<?= $this->fetch('common/header.php') ?>
<style>
    .ec-checkout-wrap .ec-check-bill-form {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -ms-flex-flow: row wrap;
        flex-flow: row wrap;
        margin: 0 -15px;
    }
    .ec-sidebar-wrap .ec-sidebar-block .ec-sb-block-content .ec-checkout-pro .ec-product-inner .ec-pro-content {
        width: 250px;
    }
    .ec-check-pay-img-wrap .ec-check-pay-img {
        width: 60px
    }
    .checkout_page [type=radio]:not(:checked) + label:before {
        top: 20px;
    }
    .checkout_page [type=radio]:checked + label:before {
        top: 20px;
    }
    .checkout_page [type=radio]:checked + label:after {
        top: 24px;
    }
</style>
<div class="checkout_page">
    <!-- Ec checkout page -->
    <section class="ec-page-content">
        <form action="<?= excUrl('Order/Create') ?>" method="post">
            <input name="paymentChannel" value="paypal" type="hidden" />
            <div class="container">
                <div class="row">
                    <div class="ec-checkout-leftside col-lg-8 col-md-12 ">
                        <!-- checkout content Start -->
                        <div class="ec-checkout-content">
                            <div class="ec-checkout-inner">
                            <div class="ec-checkout-wrap margin-bottom-30">
                                <div class="ec-checkout-block ec-check-new">
                                    <h3 class="ec-checkout-title">Choose Payment</h3>
                                    <div class="ec-check-block-content">
                                            <span class="ec-new-option">
                                                <span>
                                                    <input type="radio" id="paypal" name="paymentType" checked="" value="paypal">
                                                    <label for="paypal">
                                                        <i style="color:#3474d4" class="fa-brands fa-cc-paypal fa-4x"></i>
                                                    </label>
                                                </span>
                                                <span>
                                                    <input type="radio" id="card" name="paymentType" value="card">
                                                    <label for="card">
                                                        <i style="color:#3474d4" class="fa-brands fa-cc-visa fa-4x"></i>
                                                        <i style="color:#3474d4" class="fa-brands fa-cc-mastercard fa-4x"></i>
                                                        <i style="color:#3474d4" class="fa-brands fa-cc-amex fa-4x"></i>
                                                    </label>
                                                </span>
                                            </span>
                                        <div class="ec-new-desc">
                                            We are accept using "PayPal" Or "Visa、Master、AMERICAN EXPRESS" to pay the order.
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div id="payment-card" class="ec-checkout-wrap margin-bottom-30" style="display:none">
                                    <div class="ec-checkout-block ec-check-bill">
                                        <h3 class="ec-checkout-title">信用卡資料</h3>
                                        <div class="ec-bl-block-content">
                                            <div class="ec-check-bill-form">
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Card Number*</label>
                                                    <input type="text" name="card_number" value="" placeholder="Enter Your Card Number" />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Card Name*</label>
                                                    <input type="text" name="card_name" value="" placeholder="Enter Your Card name" />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>EXP Month*</label>
                                                    <input type="text" name="card_month" value="" placeholder="MM" />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>EXP Year*</label>
                                                    <input type="text" name="card_year" value="" placeholder="YYYY" />
                                                </span>
                                                <span class="ec-bill-wrap">
                                                    <label>CVC*</label>
                                                    <input type="text" name="card_security" value="" placeholder="" />
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ec-checkout-wrap margin-bottom-30 padding-bottom-3">
                                    <div class="ec-checkout-block ec-check-bill">
                                        <h3 class="ec-checkout-title">用戶資料</h3>
                                        <div class="ec-bl-block-content">
                                            <div class="ec-check-bill-form">
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>姓氏*</label>
                                                    <input type="text" name="firstname" value="<?= $user_shipping['userFirstName'] ?>" placeholder="Enter your first name" required />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>名稱*</label>
                                                    <input type="text" name="lastname" value="<?= $user_shipping['userLastName'] ?>" placeholder="Enter your last name" required />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>電話*</label>
                                                    <input type="text" name="mobile" value="<?= $user_shipping['userMobile'] ?>" placeholder="Enter your mobile number" required />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>地區號*</label>
                                                    <input type="text" name="postalcode" value="<?= $user_shipping['userPostcode'] ?>" placeholder="Post Code" required />
                                                </span>
                                                <span class="ec-bill-wrap">
                                                    <label>地址*</label>
                                                    <input type="text" name="address" value="<?= $user_shipping['userAddress'] ?>" placeholder="Address Line" required />
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="ec-check-order-btn">
                                    <button class="btn btn-primary" type="submit">Submit Order</button>
                                </span>
                            </div>
                        </div>
                        <!--cart content End -->
                    </div>
                    <!-- Sidebar Area Start -->
                    <div class="ec-checkout-rightside col-lg-4 col-md-12">
                    <div class="ec-sidebar-wrap ec-checkout-del-wrap">
                            <!-- Sidebar Summary Block -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">訊息</h3>
                                </div>
                                <div class="ec-sb-block-content">
                                    <div class="ec-checkout-del">
                                        <div class="ec-del-desc">如果您有任何問題想讓我們知道，請留言。</div>
                                        <span class="ec-del-commemt">
                                            <textarea name="orderMessage" placeholder="Message"></textarea>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- Sidebar Summary Block -->
                        </div>
                        <div class="ec-sidebar-wrap">
                            <!-- Sidebar Summary Block -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">總結</h3>
                                </div>
                                <div class="ec-sb-block-content">
                                    <div class="ec-checkout-summary">
                                        <div>
                                            <span class="text-left">產品價格</span>
                                            <span class="text-right">$<?= number_format($cart['total'], 2) ?></span>
                                        </div>
                                        <div style="display:none;">
                                            <span class="text-left">Delivery Charges</span>
                                            <span class="text-right">$<?= number_format($cart['extraTotal'], 2) ?></span>
                                        </div>
                                        <div class="ec-checkout-summary-total">
                                            <span class="text-left">金額</span>
                                            <span class="text-right">$<?= number_format($cart['total'], 2) ?></span>
                                        </div>
                                    </div>
                                    <div class="ec-checkout-pro">
                                        <?php foreach ($cart['list'] as $info) : ?>
                                            <div class="col-sm-12 mb-6">
                                                <div class="ec-product-inner">
                                                    <div class="ec-pro-image-outer">
                                                        <div class="ec-pro-image">
                                                            <a href="product-left-sidebar.html" class="image">
                                                                <img height="100" width="100" class="main-image" src="<?= $info['images'] ?>" alt="Product" />
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="ec-pro-content">
                                                        <h5 class="ec-pro-title"><a href="#"><?= $info['name'] ?></a></h5>
                                                        <span class="ec-price">
                                                            <span class="new-price">$<?= $info['price'] ?> x <?= $info['num'] ?></span>
                                                        </span>
                                                        <span class="ec-price">
                                                            <span style="font-size:12px;"><?= $info['options'] ?></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Sidebar Summary Block -->
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>
<script>
    var queryNum = 0;
    var paymentType = 'paypal';
    window.onload = function() {
        $('form input[name="paymentType"]').change(function() {
            console.log($(this).val())
            if($(this).val() == 'card') {
                paymentType = 'card';
                $('#payment-card').show();
            } else {
                paymentType = 'paypal';
                $('#payment-card').hide();
            }
            $('input[name="paymentChannel"]').val(paymentType);
        });
        $('button[type="submit"]').attr('disabled', false);
        $('button[type="submit"]').html('付款');
        $('form').on('submit', function (e) {
            e.preventDefault();
            $('button[type="submit"]').attr('disabled', true);
            var options = {
                success: function (data, textStatus, jqXHR) {
                    $('button[type="submit"]').attr('disabled', false);
                    if (data.code !== 200) {
                        alertMsg(data.message, 'error');
                    } else {
                        $('button[type="submit"]').attr('disabled', true);
                        var ordersn = data.data.sn;
                        alertExtendMsg('<p>We handle order now</p>', 'Going to pay', 'success', function() {
                            window.location.href = '<?= excUrl('Order/Payment') ?>/'+ordersn;
                        });
                        /*
                        showToast('Request Paying');
                        $.post('<?= excUrl('Pay/PayPal') ?>', {
                            orderId:data.data.orderId
                        }, function(data) {
                            alertExtendMsg('<p>We handle order now</p>', 'Going to pay', 'success', function() {
                                window.location.href = '<?= excUrl('Order/Payment') ?>/'+ordersn;
                            });
                            $('button[type="submit"]').attr('disabled', false);
                            if(data.data.pay == true) {
                                alertExtendMsg('<p>We handle order now</p>', 'Pay Success', 'success', function() {
                                    window.location.href = '<?= excUrl('Order/Info') ?>?orderSn='+ordersn;
                                });
                            } else {
                                alertExtendMsg('<p>'+data.message+'</p>', 'Pay Error', 'error', function() {
                                    window.location.href = '<?= excUrl('Order/Info') ?>?orderSn='+ordersn;
                                });
                            }
                        });
                        */
                    }
                },
                dataType: 'json',
                error: function (data, textStatus, jqXHR) {
                    alertMsg(data.responseJSON.message, 'error');
                    $('button[type="submit"]').attr('disabled', false);
                }
            };
            $('form').ajaxSubmit(options);
        });
    }
</script>
<?= $this->fetch('common/footer.php') ?>