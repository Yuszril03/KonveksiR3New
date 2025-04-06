<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <?= view('Template/V_CSS') ?>
    <link rel="stylesheet" href="<?= base_url() ?>/Asset/Main/Custom/page/pelanggan/infopelanggan.css">
</head>

<body>
    <script src="<?= base_url() ?>/Asset/Main/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <?= view('Template/V_Header') ?>
            <div class="content-wrapper container">

                <div class="page-heading">
                    <h3><button class="btn" id="Back1"><i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; margin-top:-10px"></i> </button> Informasi Pelanggan</h3>
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12 col-lg-8">

                            <div class="row">
                                <div class="col-12">
                                    <div class="card">

                                        <div class="card-body px-4 py-4-5">

                                            <div class="row">
                                                <div class="col-lg-3 col-12">
                                                    <center>
                                                        <img id="detailImage" src="<?= base_url() ?>/Asset/Icon/no-image.jpg" class="img-thumbnail custom-img-product" alt="">
                                                        <div>
                                                            <p class="mt-2 text-muted custom-subtitle">Status Pelanggan</p>
                                                            <div class="fw-bold" id="status"><?= LoadingData ?></div>
                                                        </div>
                                                    </center>

                                                </div>
                                                <div class="col-lg-9">
                                                    <h4 class="mb-3 mt-lg-0 mt-4" id="nameEmploye"></h4>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="custom-konten">
                                                                <p class="text-muted custom-subtitle">Username</p>
                                                                <div class="fw-bold value-subtitle" id="username"><?= LoadingData ?></div>
                                                            </div>
                                                            <div class="custom-konten">
                                                                <p class="text-muted custom-subtitle">Email</p>
                                                                <div class="fw-bold value-subtitle" id="email"><?= LoadingData ?></div>
                                                            </div>

                                                        </div>
                                                        <div class="col">
                                                            <div class="custom-konten">
                                                                <p class="text-muted custom-subtitle">Jenis Kelamin</p>
                                                                <div class="fw-bold value-subtitle" id="gender"><?= LoadingData ?></div>
                                                            </div>
                                                            <div class="custom-konten">
                                                                <p class="text-muted custom-subtitle">Telefon</p>
                                                                <div class="fw-bold value-subtitle" id="telepon"><?= LoadingData ?></div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="custom-konten">
                                                        <p class="text-muted custom-subtitle">Alamat</p>
                                                        <div class="fw-bold value-subtitle" id="alamat"><?= LoadingData ?></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-6">
                                                            <div class="custom-konten">
                                                                <p class="text-muted custom-subtitle">Tanggal Dibuat</p>
                                                                <div class="fw-bold value-subtitle" id="created"><?= LoadingData ?></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-6">
                                                            <div class="custom-konten">
                                                                <p class="text-muted custom-subtitle">Terkahir Diubah</p>
                                                                <div class="fw-bold value-subtitle" id="update"><?= LoadingData ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-lg-12 col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4>Data Harga Khusus</h4>
                                                </div>
                                                <div class="card-body custom-card">
                                                    <div id="loadingDataHarga" class="d-none">
                                                        <center class="p-4">
                                                            <div class="loader"></div>
                                                            <h6 class="mt-3">Mengambil Data</h6>
                                                        </center>
                                                    </div>
                                                    <div id="nonePrice" class="d-none">
                                                        <center>
                                                            <img class="custom-empty-price" src="<?= base_url() ?>/Asset/Icon/empty-data.svg" alt="">
                                                            <h5 class="mt-2">Data tidak ditemukan</h5>
                                                        </center>
                                                    </div>
                                                    <div id="valuePrice" class="scroll-price d-none">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="float-end">
                                        <button id="prevStatik" class=" btn custom-btn-statik"><i class="bi bi-arrow-left-circle-fill"></i></button>
                                        <button id="nextStatik" disabled class=" btn custom-filter-price"><i class="bi bi-arrow-right-circle-fill"></i></button>
                                    </div>
                                    <h4 class="mb-3">Pembelian <span id="years"></span></h4>
                                </div>
                                <div class="card-body">

                                    <div id="loadingDataLog" class="d-none">
                                        <center class="p-4">
                                            <div class="loader"></div>
                                            <h6 class="mt-3">Mengambil Data</h6>
                                        </center>
                                    </div>
                                    <div id="noneLog" class="d-none">
                                        <center>
                                            <img class="custom-empty-price" src="<?= base_url() ?>/Asset/Icon/empty-data.svg" alt="">
                                            <h6 class="mt-2">Data tidak ditemukan</h6>
                                        </center>
                                    </div>
                                   

                                    <div id="chartYear">

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
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/pelanggan/infopelanggan.js"></script>

</body>

</html>