<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= session()->get('NamaPage') ?> - <?= NameApp ?></title>

    <?= view('Template/V_CSS') ?>
</head>

<body>
    <script src="<?= base_url() ?>/Asset/Main/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <?= view('Template/V_Header') ?>
            <div class="content-wrapper container">

                <!-- <div class="page-heading">
                    <h3>Horizontal Layout</h3>
                </div> -->
                <div class="page-content">
                    <section class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <center>
                                        <img class="w-25 mt-4" src="<?= base_url() ?>/Asset/Icon/error.svg" alt="">
                                        <h5 class="mt-4"><?= session()->get('ErrorText') ?></h5>
                                        <a href="<?= base_url() ?>/" class="btn btn-primary mt-4 mb-4">Kembali Beranda</a>
                                    </center>
                                </div>
                            </div>
                        </div>

                    </section>
                </div>

            </div>

            <?= view('Template/V_Footer') ?>
        </div>
    </div>
    <?= view('Template/V_JS') ?>

</body>

</html>