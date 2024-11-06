<?= $this->fetch('common/header.php') ?>
<section class="ec-page-content section-space-p">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-title">
                    <h2 class="ec-bg-title">登記</h2>
                    <h2 class="ec-title">登記</h2>
                    <p class="sub-title mb-3">成為會員</p>
                </div>
            </div>
            <div class="ec-register-wrapper">
                <div class="ec-register-container">
                    <div class="ec-register-form">
                        <form action="<?=excUrl('ApiUser/Reg')?>" method="post">
                            <span class="ec-register-wrap ec-register-half">
                                <label>姓氏*</label>
                                <input type="text" name="firstname" placeholder="" required />
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>名稱*</label>
                                <input type="text" name="lastname" placeholder="" required />
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>密碼*</label>
                                <input type="password" name="password" placeholder="" required />
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>再次密碼*</label>
                                <input type="password" name="repassword" placeholder="" required />
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>Email*</label>
                                <input type="email" name="email" placeholder="" required />
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>電話 *</label>
                                <input type="text" name="mobile" placeholder="" required />
                            </span>
                            <span class="ec-register-wrap ec-register-half">
                                <label>區號</label>
                                <input type="text" name="postalcode" placeholder="852" value = "852"/>
                            </span>
                            <span class="ec-register-wrap ec-register-btn">
                                <button class="btn btn-primary" type="submit">發送</button>
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
                      window.location.href = '/';
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