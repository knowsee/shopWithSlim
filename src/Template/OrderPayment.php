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

    .checkout_page [type=radio]:not(:checked)+label:before {
        top: 20px;
    }

    .checkout_page [type=radio]:checked+label:before {
        top: 20px;
    }

    .checkout_page [type=radio]:checked+label:after {
        top: 24px;
    }

    .btn-xxs {
        height: 30px;
        line-height: 27px;
    }
</style>
<div class="checkout_page">
    <!-- Ec checkout page -->
    <section class="ec-page-content">
        <form action="<?= excUrl('Order/Update') ?>" method="post">
            <input name="paymentChannel" value="<?= $payMethod ?>" type="hidden" />
            <input name="orderSn" value="<?= $orderInfo['orderSn'] ?>" type="hidden" />
            <div class="container">
                <div class="row typography" style="max-width: 1050px;padding: 30px;margin: 0 auto;border: 1px solid #ededed;">

                    <div class="col-md-12">
                        <h4 class="ec-fw-normal ec-fc" style="position: relative;margin-bottom: 5px;">Order #<?= $orderInfo['orderSn'] ?>
                            <div style="position: absolute;right: 0;top: 7px;font-size: 18px;">应付 $<?= $orderInfo['orderPrice'] ?></div>
                        </h4>
                        <p style="margin-bottom: 30px;">确认订单内容并进行支付</p>
                    </div>

                    <div class="col-md-12">
                        <div class="ec-common-wrapper" style="padding-bottom: 50px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="ec-lb ec-fc">收货信息</h6>
                                    <div class="my-2">
                                        <b class="text-600">To : </b><?= $orderInfo['realName'] ?>
                                    </div>
                                    <div class="text-grey-m2">
                                        <div class="my-2">
                                            <b class="text-600">Address : </b><?= $orderInfo['address'] ?>
                                        </div>
                                        <div class="my-2">
                                            <b class="text-600">Phone : </b><?= $orderInfo['mobile'] ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="ec-lb ec-fc">支付方式</h6>
                                    <div class="my-2">
                                        <?php if ($payMethod == 'paypal') : ?>
                                            <div><i style="color:#3474d4" class="fa-solid fa-credit-card fa-2x"></i> PayPal</div>
                                        <?php elseif ($payMethod == 'card') : ?>
                                            <div><i style="color:#3474d4" class="fa-brands fa-cc-visa fa-2x"></i>
                                            <i style="color:#3474d4" class="fa-brands fa-cc-mastercard fa-2x"></i>
                                            <i style="color:#3474d4" class="fa-brands fa-cc-amex fa-2x"></i> 信用卡</div>
                                            <ul>
                                                <li><strong>Number : </strong><?= $paymentInfo['payCardPayInfo']['number'] ?></li>
                                                <li><strong>Name : </strong><?= $paymentInfo['payCardPayInfo']['name'] ?></li>
                                                <li><strong>Month/Year : </strong><?= $paymentInfo['payCardPayInfo']['month'] ?>/<?= $paymentInfo['payCardPayInfo']['year'] ?></li>
                                                <li><strong>CVC/CCV : </strong> *** (On Hide)</li>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                    <button type="button" onclick="javascript:onEdit()" class="btn btn-primary btn-sm btn-xxs" style="margin-top:15px">更换</button>
                                </div>
                            </div>
                        </div>
                        <div id="onEdit" class="ec-checkout-wrap margin-bottom-30" style="display:none">
                            <div class="ec-checkout-block ec-check-bill">
                                <h3 class="ec-checkout-title">更改支付</h3>
                                <div class="ec-check-block-content" style="margin-bottom: 10px;">
                                    <span class="ec-new-option">
                                        <span>
                                            <input type="radio" id="paypal" name="paymentType" <?= $payMethod == 'paypal' ? 'checked=""' : '' ?> value="paypal">
                                            <label for="paypal">
                                                <i style="color:#3474d4" class="fa-brands fa-cc-paypal fa-4x"></i>
                                            </label>
                                        </span>
                                        <span>
                                            <input type="radio" id="card" name="paymentType" value="card" <?= $payMethod == 'card' ? 'checked=""' : '' ?>>
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
                                <div class="ec-bl-block-content" id="payment-card" <?= $payMethod !== 'card' ? 'style="display:none"' : '' ?>>
                                    <div class="ec-check-bill-form">
                                        <span class="ec-bill-wrap ec-bill-half">
                                            <label>Card Number*</label>
                                            <input type="text" name="card_number" value="<?= $paymentInfo['payCardPayInfo']['number'] ?? '' ?>" placeholder="Enter Your Card Number" />
                                        </span>
                                        <span class="ec-bill-wrap ec-bill-half">
                                            <label>Card Name*</label>
                                            <input type="text" name="card_name" value="<?= $paymentInfo['payCardPayInfo']['name'] ?? '' ?>" placeholder="Enter Your Card name" />
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
                            <span class="ec-check-order-btn">
                                <button class="btn btn-primary" type="submit">Submit Order</button>
                            </span>
                        </div>

                        <div class="ec-trackorder-inner ec-common-wrapper" style="margin: 80px 0 0 0;">
                            <div class="col-sm-12 ec-cms-block">
                                <div class="ec-cms-block-inner">
                                    <div>
                                        <?php if ($payMethod == 'paypal') : ?>
                                            <div class="ec-border-anim ec-border-anim text-center">
                                                <button type="button" onclick="goPay()" class="corner-button">
                                                    <span>
                                                        <i class="fa-solid fa-angles-right"></i> Click here to pay
                                                    </span>
                                                </button>
                                            </div>
                                        <?php elseif ($payMethod == 'card') : ?>
                                            <div class="ec-border-anim ec-border-anim text-center">
                                                <button type="button" onclick="goPay()" class="corner-button">
                                                    <span>
                                                        <i class="fa-solid fa-angles-right"></i> Click here to pay
                                                    </span>
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </section>
</div>
<script>
    function goPay() {
        window.location.href = '<?= excUrl('payment/index?method=' . $payMethod . '&orderId=' . $orderInfo['orderId']) ?>';
    }
    function onEdit() {
        $('#onEdit').toggle();
    }
    var queryNum = 0;
    var paymentType = '<?= $payMethod ?>';
    window.onload = function() {
        $('form input[name="paymentType"]').change(function() {
            if ($(this).val() == 'card') {
                paymentType = 'card';
                $('#payment-card').show();
            } else {
                paymentType = 'paypal';
                $('#payment-card').hide();
            }
            $('input[name="paymentChannel"]').val(paymentType);
        });
        $('form').on('submit', function(e) {
            e.preventDefault();
            $('button[type="submit"]').attr('disabled', true);
            var options = {
                success: function(data, textStatus, jqXHR) {
                    $('button[type="submit"]').attr('disabled', false);
                    if (data.code !== 200) {
                        alertMsg(data.message, 'error');
                    } else {
                        alertExtendMsg('<p>We accept you change</p>', 'you can pay now', 'success', function() {
                            window.location.reload();
                        });
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
</script>
<?= $this->fetch('common/footer.php') ?>