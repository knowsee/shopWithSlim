<?= $this->fetch('common/header.php') ?>
<!-- User history section -->
<section class="ec-page-content ec-vendor-uploads ec-user-account">
    <div class="container">
        <div class="row">
            <!-- Sidebar Area Start -->
            <?= $this->fetch('UserLeftside.php') ?>
            <div class="ec-shop-rightside col-lg-9 col-md-12">
                <div class="ec-vendor-dashboard-card ec-vendor-setting-card">
                    <div class="ec-vendor-card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="ec-vendor-block-profile">
                                    <h5>Account Information</h5>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="ec-vendor-detail-block ec-vendor-block-email space-bottom-30">
                                                <h6>First Name</h6>
                                                <ul>
                                                    <li><?= $users['userFirstName'] ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="ec-vendor-detail-block ec-vendor-block-contact space-bottom-30">
                                                <h6>Last Name</h6>
                                                <ul>
                                                    <li><?= $users['userLastName'] ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="ec-vendor-detail-block ec-vendor-block-email space-bottom-30">
                                                <h6>E-mail address</h6>
                                                <ul>
                                                    <li><?= $users['userEmail'] ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="ec-vendor-detail-block ec-vendor-block-contact space-bottom-30">
                                                <h6>Contact nubmer</h6>
                                                <ul>
                                                    <li><?= $users['userMobile'] ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="ec-vendor-detail-block ec-vendor-block-address mar-b-30">
                                                <h6>Address</h6>
                                                <ul>
                                                    <li><?= $users['userAddress'] ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="ec-vendor-detail-block ec-vendor-block-address">
                                                <h6>Post Code</h6>
                                                <ul>
                                                    <li><?= $users['userPostcode'] ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 15px">
                                        <div class="ec-btn-ds">
                                            <a href="#" class="btn btn-primary" data-link-action="editmodal" title="Edit Detail" data-bs-toggle="modal" data-bs-target="#edit_modal">Edit Detail</a>
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
<!-- End User profile section -->


<!-- Modal -->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="ec-vendor-block-img space-bottom-30">
                        <div class="ec-vendor-upload-detail">
                            <form class="row g-3" action="<?= excUrl('Users/ProfileUpdate') ?>" method="POST">
                                <div class="col-md-6 space-t-15">
                                    <label class="form-label">First name</label>
                                    <input type="text" class="form-control" value="<?= $users['userFirstName'] ?>" name="userFirstName">
                                </div>
                                <div class="col-md-6 space-t-15">
                                    <label class="form-label">Last name</label>
                                    <input type="text" class="form-control" value="<?= $users['userLastName'] ?>" name="userLastName">
                                </div>
                                <div class="col-md-12 space-t-15">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" value="<?= $users['userAddress'] ?>" name="userAddress">
                                </div>
                                <div class="col-md-12 space-t-15">
                                    <label class="form-label">Post Code</label>
                                    <input type="text" class="form-control" value="<?= $users['userPostcode'] ?>" name="userPostcode">
                                </div>
                                <div class="col-md-6 space-t-15">
                                    <label class="form-label">Contact nubmer</label>
                                    <input type="text" class="form-control" value="<?= $users['userMobile'] ?>" name="userMobile">
                                </div>
                                <div class="col-md-12 space-t-15">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="#" class="btn btn-lg btn-secondary qty_close" data-bs-dismiss="modal" aria-label="Close">Close</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal end -->
<script>
    var queryNum = 0;
    var paymentType = 'paypal';
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