<?= $this->fetch('common/header.php') ?>

<!-- User invoice section -->
<section class="ec-page-content ec-vendor-uploads ec-user-account">
    <div class="container">
        <div class="row">
            <!-- Sidebar Area Start -->
            <?= $this->fetch('Users/Leftside.php') ?>
            <div class="ec-shop-rightside col-lg-9 col-md-12">
                <div class="ec-vendor-dashboard-card">
                    <div class="ec-vendor-card-header">
                        <h5>Invoice [<?= $orderInfo['statusName'] ?>]</h5>
                        <div class="ec-header-btn">
                            <!--<a class="btn btn-lg btn-secondary" href="#">Print</a>-->
                            <?php if (in_array($orderInfo['orderStatus'], [0])) : ?>
                                <a class="btn btn-lg btn-primary" href="<?= excUrl('Order/Payment/') . $orderInfo['orderSn'] ?>">Pay</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if($orderInfo['orderStatus'] > 1): ?>
                    <div class="ec-trackorder-content col-md-12">
                        <div class="ec-trackorder-inner">
                            <div class="ec-trackorder-top">
                                <h2 class="ec-order-id">Express tracking</h2>
                                <div class="ec-order-detail">
                                    <div>Express Company <span><?=$orderInfo['postCompany']?></span></div>
                                    <div>Tracking Number <span><?=$orderInfo['postNumber']?></span></div>
                                </div>
                            </div>
                            <div class="ec-trackorder-bottom">
                                <div class="ec-progress-track">
                                    <ul id="ec-progressbar">
                                        <li class="step0 <?= $orderInfo['orderStatus'] >= 0 ? 'active' : '' ?>"><span class="ec-progressbar-track"></span><span class="ec-track-title">order
                                                <br>create</span></li>
                                        <li class="step0 <?= $orderInfo['orderStatus'] > 0 ? 'active' : '' ?>"><span class="ec-progressbar-track"></span><span class="ec-track-title">order
                                                <br>processing</span></li>
                                        <li class="step0 <?= $orderInfo['orderStatus'] > 1 ? 'active' : '' ?>"><span class="ec-progressbar-track"></span><span class="ec-track-title">order
                                                <br>shipped</span></li>
                                        <li class="step0 <?= $orderInfo['orderStatus'] > 2 ? 'active' : '' ?>"><span class="ec-progressbar-track"></span><span class="ec-track-title">order
                                                <br>arrived</span></li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="ec-vendor-card-body padding-b-0">
                        <div class="page-content">
                            <div class="container px-0">
                                <?php if($_GET['pay'] == 'false'): ?>
                                <div class="col-12">
                                    <div class="alert alert-dark">
                                        <?=$_GET['message']?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="row mt-4">
                                    <div class="col-lg-12">
                                        <hr class="row brc-default-l1 mx-n1 mb-4" />

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="my-2">
                                                    <span class="text-sm text-grey-m2 align-middle">To : </span>
                                                    <span class="text-600 text-110 text-blue align-middle"><?= $orderInfo['realName'] ?></span>
                                                </div>
                                                <div class="text-grey-m2">
                                                    <div class="my-2">
                                                        <?= $orderInfo['address'] ?>
                                                    </div>
                                                    <div class="my-2"><b class="text-600">Phone : </b><?= $orderInfo['mobile'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.col -->

                                            <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                                                <hr class="d-sm-none" />
                                                <div class="text-grey-m2">

                                                    <div class="my-2"><span class="text-600 text-90">Order No : </span>
                                                        # <?= $orderInfo['orderSn'] ?></div>
                                                    <div class="my-2"><span class="text-600 text-90">Issue Date :
                                                        </span> <?= date('m-d-Y', $orderInfo['orderTime']) ?></div>
                                                    <div class="my-2"><span class="text-600 text-90">Pay Date :
                                                        </span> <?= $orderInfo['orderPaytime'] > 0 ? date('m-d-Y', $orderInfo['orderPaytime']) : 'wait pay' ?></div>
                                                    <div class="my-2"><span class="text-600 text-90">Shipping Date :
                                                        </span> <?= $orderInfo['postedTime'] ?? 'wait shipping' ?></div>
                                                
                                                </div>
                                            </div>
                                            <!-- /.col -->
                                        </div>

                                        <div class="mt-4">

                                            <div class="text-95 text-secondary-d3">
                                                <div class="ec-vendor-card-table">
                                                    <table class="table ec-table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">ID</th>
                                                                <th scope="col">Name</th>
                                                                <th scope="col">Qty</th>
                                                                <th scope="col">Price</th>
                                                                <th scope="col">Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($orderInfo['ordersGoodList'] as $k => $info) : ?>
                                                                <tr>
                                                                    <th><span><?= $k + 1 ?></span></th>
                                                                    <td><span style="font-weight:bold;"><?= $info['name'] ?>(<?= $info['skuName'] ?>)</span><?= $info['options'] ?></td>
                                                                    <td><span><?= $info['num'] ?></span></td>
                                                                    <td><span>$<?= $info['price'] ?></span></td>
                                                                    <td><span>$<?= bcmul((string)$info['num'], (string)$info['price'], 2) ?></span></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td class="border-none" colspan="3">
                                                                    <span></span>
                                                                </td>
                                                                <td class="border-color" colspan="1">
                                                                    <span><strong>Sub Total</strong></span>
                                                                </td>
                                                                <td class="border-color">
                                                                    <span>$<?= number_format($orderInfo['orderPrice'] + $orderInfo['discount'] - $orderInfo['handlingFee'], 2) ?></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="border-none" colspan="3">
                                                                    <span></span>
                                                                </td>
                                                                <td class="border-color" colspan="1">
                                                                    <span><strong>Delivery</strong></span>
                                                                </td>
                                                                <td class="border-color">
                                                                    <span>$<?= $orderInfo['handlingFee'] ?></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="border-none" colspan="3">
                                                                    <span></span>
                                                                </td>
                                                                <td class="border-color" colspan="1">
                                                                    <span><strong>Discount</strong></span>
                                                                </td>
                                                                <td class="border-color">
                                                                    <span>-$<?= $orderInfo['discount'] ?></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="border-none m-m15" colspan="3"><span class="note-text-color">*Message</span></td>
                                                                <td class="border-color m-m15" colspan="1"><span><strong>Total</strong></span>
                                                                </td>
                                                                <td class="border-color m-m15">
                                                                    <span>$<?= $orderInfo['orderPrice'] ?></span>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End User invoice section -->

<script>
    function pay() {
        showToast('Request Paying');
        $.post('<?= excUrl('Pay/Index') ?>', {
            orderId: '<?= $orderInfo['orderId'] ?>'
        }, function(data) {
            if (data.data.pay == true) {
                alertExtendMsg('<p>We handle order now</p>', 'Pay Success', 'success', function() {
                    window.location.reload();
                });
            } else {
                alertExtendMsg('<p>' + data.message + '</p>', 'Pay Error', 'error', function() {

                });
            }
        });
    }
</script>
<?= $this->fetch('common/footer.php') ?>