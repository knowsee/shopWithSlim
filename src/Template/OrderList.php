<?= $this->fetch('common/header.php') ?>
<!-- User history section -->
<section class="ec-page-content ec-vendor-uploads ec-user-account">
        <div class="container">
            <div class="row">
                <!-- Sidebar Area Start -->
                <?= $this->fetch('Users/Leftside.php') ?>
                <div class="ec-shop-rightside col-lg-9 col-md-12">
                    <div class="ec-vendor-dashboard-card">
                        <div class="ec-vendor-card-header">
                            <h5>訂單記錄</h5>
                        </div>
                        <div class="ec-vendor-card-body">
                            <div class="ec-vendor-card-table">
                                <table class="table ec-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">訂單No.</th>
                                            <th scope="col">產品相片</th>
                                            <th scope="col">產品名稱</th>
                                            <th scope="col">日期</th>
                                            <th scope="col">價錢</th>
                                            <th scope="col">狀態</th>
                                            <th scope="col">行動</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($list as $info): ?>
                                        <?php if(isset($info['ordersGoodList'][0])) : ?>
                                        <tr>
                                            <th scope="row"><span><a 
                                                        href="<?=excUrl('Order/Info')?>?orderSn=<?=$info['orderSn']?>"><?=$info['orderSn']?></a></span></th>
                                            <td><img class="prod-img" src="<?=$info['ordersGoodList'][0]['images']?>"
                                                    alt="product image"></td>
                                            <td><span><?=$info['ordersGoodList'][0]['name']?>...</span></td>
                                            <td><span><?=date('Y-m-d', $info['orderTime'])?></span></td>
                                            <td><span>$<?=$info['orderPrice']?></span></td>
                                            <td><span><?=$info['statusName']?></span></td>
                                            <td><span class="tbl-btn"><a class="btn btn-lg btn-primary"
                                                        href="<?=excUrl('Order/Info')?>?orderSn=<?=$info['orderSn']?>">View</a></span></td>
                                        </tr>
                                        <?php endif; ?>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End User history section -->

    <?= $this->fetch('common/footer.php') ?>