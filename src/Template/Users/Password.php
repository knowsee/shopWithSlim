<?= $this->fetch('common/header.php') ?>
<!-- User history section -->
<section class="ec-page-content ec-vendor-uploads ec-user-account">
    <div class="container">
        <div class="row">
            <!-- Sidebar Area Start -->
            <?= $this->fetch('Users/Leftside.php') ?>
            <div class="ec-shop-rightside col-lg-9 col-md-12">
                <div class="ec-vendor-dashboard-card ec-vendor-setting-card">
                    <div class="ec-vendor-card-body">
                        <div class="row">
                        <form class="row g-3" action="<?= excUrl('Users/Password') ?>" method="POST">
                            <div class="col-md-12">
                                <div class="ec-vendor-block-profile">
                                    <h5>Password</h5>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <span class="ec-check-login-wrap">
                                                <label>New password</label>
                                                <input type="password" name="password" placeholder="if you want to change, please enter your new password" required="">
                                            </span>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <span class="ec-check-login-wrap">
                                                <label>Replace new password</label>
                                                <input type="password" name="repassword" placeholder="please enter your new password again" required="">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 15px">
                                        <div class="ec-btn-ds">
                                            <button class="btn btn-primary" type="submit">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End User profile section -->

<script>
    window.onload = function() {
        $('button[type="submit"]').attr('disabled', false);
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
                        alertExtendMsg('<p>We are accept</p>', 'Refrush', 'success', function() {
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
<?= $this->fetch('common/footer.php') ?>