<?= $this->fetch('common/header.php') ?>
<!-- Ec login page -->
<section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">登入</h2>
                        <h2 class="ec-title">登入</h2>
                      
                    </div>
                </div>
                <div class="ec-login-wrapper">
                    <div class="ec-login-container">
                        <div class="ec-login-form">
                            <form action="<?=excUrl('ApiUser/Login')?>" method="post">
                                <span class="ec-login-wrap">
                                    <label>電郵 *</label>
                                    <input type="text" name="email" placeholder="Enter your email ..." required />
                                </span>
                                <span class="ec-login-wrap">
                                    <label>密碼*</label>
                                    <input type="password" name="password" placeholder="Enter your password" required />
                                </span>
                                <span class="ec-login-wrap ec-login-btn">
                                    <button class="btn btn-primary" type="submit">登入</button>
                                    <a href="<?=excUrl('Index/Reg')?>" class="btn btn-secondary">成為會員</a>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script>
window.onload = function() {
    $('form').on('submit', function (e) {
        e.preventDefault();
        var options = {
            success: function (data, textStatus, jqXHR) {
                if (data.code !== 200) {
                    alertMsg(data.message, 'error');
                } else {
                    alertMsg(data.message, 'success', function() {
                        window.location.href = '<?=!empty($url) ? $url : '/'?>';
                    });
                }
            },
            error: function (data, textStatus, jqXHR) {
                alertMsg(data.responseJSON.message, 'error');
            },
            dataType: 'json'
        };
        $('form').ajaxSubmit(options);
    });
}
</script>
<?= $this->fetch('common/footer.php') ?>