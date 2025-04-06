<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url() ?>/Asset/Login/fonts/icomoon/style.css">

    <link rel="stylesheet" href="<?= base_url() ?>/Asset/Login/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/Asset/Login/css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="<?= base_url() ?>/Asset/Login/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>/Asset/Login/Custom/css/Main.css">
    <link rel="icon" type="image/png" href="<?= base_url() ?>/Asset/Icon/Logo.png" />
    <title>Masuk - <?= NameApp ?></title>
</head>

<body>



    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?= base_url() ?>/Asset/Login/images/undraw_web_shopping_re_owap.svg" alt="Image" class="img-fluid">
                </div>
                <div class="col-md-6 contents">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h3>Masuk</h3>
                                <p class="mb-4">Jika ingin masuk dalam aplikasi, masukan username dan kata sandi <span style="color: grey; font-weight: bold;">Karyawan</span></p>
                            </div>
                            <?php if (session()->getFlashdata('pesan')) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= session()->getFlashdata('pesan') ?>
                                </div>
                            <?php } ?>
                            <form action="<?= base_url() ?>/Auth" method="post">

                                <div class="form-group first">
                                    <label for="username">Username</label>
                                    <input autocapitalize="none" type="text" class="form-control" name="username" id="username" required>

                                </div>
                                <div class="form-group last mb-4">
                                    <label for="password">Kata Sandi</label>
                                    <input type="password" class="form-control" name="pass" id="pass" required>

                                </div>

                                <!-- <div class="d-flex mb-5 align-items-center">
                                    <span class="ml-auto"><a href="#" onclick="ForgotPassword()" class="forgot-pass">Lupa Kata Sandi</a></span>
                                </div> -->
                                <button type="submit" class="btn btn-block" style="background-color: #435ebe; color: white;">Masuk</button>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <script src="<?= base_url() ?>/Asset/Login/js/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url() ?>/Asset/SweetAlert/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="<?= base_url() ?>/Asset/Login/js/popper.min.js"></script>
    <script src="<?= base_url() ?>/Asset/Login/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/Asset/Login/js/main.js"></script>
    <!-- <script type="text/javascript" src="<?= base_url() ?>/CustomAsset/js/Login/Login.js"></script> -->
</body>

</html>