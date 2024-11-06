<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <title>404 Page Not Found - <?= $_ENV['SITE_NAME'] ?></title>

    <!-- site Favicon -->
    <link rel="icon" href="<?= siteUrl() ?>assets/images/favicon/favicon.png" sizes="32x32" />
    <link rel="apple-touch-icon" href="<?= siteUrl() ?>assets/images/favicon/favicon.png" />

    <!-- css Icon Font -->
    <link rel="stylesheet" href="<?= siteUrl() ?>assets/css/vendor/ecicons.min.css" />
    <link rel="stylesheet" href="<?= siteUrl() ?>assets/css/all.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= siteUrl() ?>assets/css/style.css" />
    <link rel="stylesheet" href="<?= siteUrl() ?>assets/css/responsive.css" />


    <!-- Background css -->
    <link rel="stylesheet" id="bg-switcher-css" href="<?= siteUrl() ?>assets/css/backgrounds/bg-4.css">
</head>

<body>

    <!-- Start main Section -->
    <section class="ec-under-maintenance">

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="under-maintenance">
                        <h1>Error 404</h1>
                        <h4>The page was not found.</h4>
                        <a href="<?= siteUrl() ?>" class="btn btn-lg btn-primary" tabindex="0">Back to Home</a>
                    </div>
                </div>
                <div class="col-md-6 disp-768">
                    <div class="under-maintenance">
                        <img class="maintenance-img" src="<?= siteUrl() ?>assets/images/common/404.png" alt="maintenance">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End main Section -->
</body>
</html>