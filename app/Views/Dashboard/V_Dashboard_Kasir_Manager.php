<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= session()->get('NamaPage') ?> - <?= NameApp ?></title>

    <?= view('Template/V_CSS') ?>
    <style>
        .container-header {
            width: 100%;
            background-color: #ffffff;
            border-radius: 25px;
            margin-bottom: 30px;
        }

        @media only screen and (min-device-width: 1024px) {
            .container-header {
                padding-left: 30px;
                padding-right: 30px;
                padding-bottom: 0px;
                padding-top: 30px;
            }

        }

        @media only screen and (max-width: 360px),
        (min-device-width: 360px) and (max-device-width: 1024px) {
            .container-header {
                padding: 20px;
            }
        }

        html[data-bs-theme="dark"] .container-header {
            background-color: #1e1e2d;
        }

        html[data-bs-theme="dark"] .apexcharts-title-text {
            fill: white;
        }
    </style>
</head>

<body>
    <script src="<?= base_url() ?>/Asset/Main/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <?= view('Template/V_Header') ?>
            <div class="content-wrapper container">

                <div class="page-heading d-none d-lg-block">
                    <!-- <h3>Horizontal Layout</h3> -->
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12 col-lg-8">

                            <div class="container-header">
                                <div class="row">
                                    <div class="col-7">
                                        <h5 class=" fw-normal m-lg-1" id="txtTime">Selamat Siang,</h5>
                                        <h3 class="text-primary fw-bold"><?= session()->get('Name') ?></h3>
                                    </div>
                                    <div class="col d-none d-lg-block">
                                        <img style="width: 280px; margin-top: -96px;" src="<?= base_url() ?>/Asset/Icon/welcome.svg" alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h4>Transaksi <?= date('Y') ?></h4>
                                </div>
                                <div class="card-body">
                                    <div id="chartYear"></div>
                                </div>
                            </div>



                        </div>
                        <div class="col-12 col-lg-4">

                            <div class="card">
                                <div class="card-body py-4 px-5">

                                    <div class="d-flex align-items-center">

                                        <div class=" name">
                                            <h5 class="font-bold">Omset Hari Ini</h5>
                                            <h6 class="text-muted mb-0" id="textOmsetNow">0</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-none">
                                <div class="col-6 col-lg col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon purple mb-2">
                                                        <i class="iconly-boldShow"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Profile</h6>
                                                    <h6 class="font-extrabold mb-0">112.000</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon blue mb-2">
                                                        <i class="iconly-boldProfile"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Followers</h6>
                                                    <h6 class="font-extrabold mb-0">183.000</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon green mb-2">
                                                        <i class="iconly-boldAdd-User"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Following</h6>
                                                    <h6 class="font-extrabold mb-0">80.000</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon red mb-2">
                                                        <i class="iconly-boldBookmark"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Saved Post</h6>
                                                    <h6 class="font-extrabold mb-0">112</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="card">
                                <div class="card-header">
                                    <h4>Status Transaksi</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart"></div>
                                    <!-- <div id="chart"></div> -->
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/Dashboard/Manager Kasir/index.js"></script>

</body>

</html>