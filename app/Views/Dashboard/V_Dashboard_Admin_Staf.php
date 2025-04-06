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

        .radius-form-search {
            border-radius: 20px !important;
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

        .custom-img-online {
            width: 50px !important;
            height: 50px !important;
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
                        <div class="col-12 col-lg-7">

                            <div class="container-header">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
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
                                    <h4>Statistik Aktivitas Karyawan
                                        <div class="float-end">
                                            <input type="text" class="form-control selector radius-form-search" placeholder="Pilih tanggal..." id="date">
                                        </div>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div id="chartTrans"></div>
                                </div>
                            </div>



                        </div>
                        <div class="col-12 col-lg-5">

                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon purple mb-2">
                                                        <i style="margin-top: -30px;margin-left: -10px;" class="bi bi-cart"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Transaksi</h6>
                                                    <h6 class="font-extrabold mb-0" id="totalTrans">183.000</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon red mb-2">
                                                        <i style="margin-top: -30px;margin-left: -10px;" class="bi bi-boxes"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Produk</h6>
                                                    <h6 class="font-extrabold mb-0" id="totalProduk">183.000</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon blue mb-2">
                                                        <i style="margin-top: -30px;margin-left: -10px;" class="bi bi-people"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Pelanggan</h6>
                                                    <h6 class="font-extrabold mb-0" id="totalPelanggan">183.000</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card ">
                                <div class="card-body py-4 px-4">

                                    <div class="d-flex align-items-center">

                                        <div class=" name mb-3">
                                            <h5 class="font-bold">Karyawan Online</h5>
                                        </div>
                                    </div>
                                    <div class="text-center d-none" id="offlineUser">
                                        <img style="width: 220px;" src="<?= base_url() ?>/Asset/Icon/offline.svg" alt="">
                                        <p>Tidak ada karyawan aktif</p>
                                    </div>
                                    <div id="onlineUser" class="d-none" style="overflow:scroll; height:235px;">

                                    </div>


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
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/Dashboard/Admin/index.js"></script>

</body>

</html>