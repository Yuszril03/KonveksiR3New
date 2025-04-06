<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <?= view('Template/V_CSS') ?>
    <link rel="stylesheet" href="<?= base_url() ?>/Asset/Main/Custom/page/employee/infoemployee.css">
</head>

<body>
    <script src="<?= base_url() ?>/Asset/Main/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <?= view('Template/V_Header') ?>
            <div class="content-wrapper container">

                <div class="page-heading">
                    <h3><button class="btn" id="Back1"><i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; margin-top:-10px"></i> </button> Informasi Karyawan</h3>
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12 col-lg-8">
                            <div class="row d-none">
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon purple mb-2">
                                                        <i class="iconly-boldShow"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Profile Views</h6>
                                                    <h6 class="font-extrabold mb-0">112.000</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
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
                                <div class="col-6 col-lg-3 col-md-6">
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
                                <div class="col-6 col-lg-3 col-md-6">
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
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">

                                        <div class="card-body px-4 py-4-5">

                                            <div class="row">
                                                <div class="col-lg-3 col-12">
                                                    <center>
                                                        <img id="detailImage" src="<?= base_url() ?>/Asset/Icon/no-image.jpg" class="img-thumbnail custom-img-product" alt="">
                                                        <div>
                                                            <p class="mt-2 text-muted custom-subtitle">Status Karyawan</p>
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4>Data Pekerjaan</h4>
                                                </div>
                                                <div class="card-body custom-card">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="custom-konten">
                                                                <p class="text-muted custom-subtitle">Posisi</p>
                                                                <div class="fw-bold value-subtitle" id="posisi"><?= LoadingData ?></div>
                                                            </div>
                                                            <div class="custom-konten">
                                                                <p class="text-muted custom-subtitle">Atasan</p>
                                                                <div class="fw-bold value-subtitle" id="atasan"><?= LoadingData ?></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="custom-konten">
                                                                <p class="text-muted custom-subtitle">Role</p>
                                                                <div class="fw-bold value-subtitle" id="role"><?= LoadingData ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4>Informasi Lain</h4>
                                                </div>
                                                <div class="card-body custom-card">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-6">
                                                            <div class="custom-konten">
                                                                <p class="text-muted custom-subtitle">Tanggal Dibuat</p>
                                                                <div class="fw-bold value-subtitle" id="created"><?= LoadingData ?></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-6">
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

                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <button class="btn custom-btn-statik selector float-end"><i class="bi bi-calendar-week"></i></button>
                                    <h4>Aktivitas Karyawan </h4>
                                    <p id="valueDate" class="text-muted value-date fst-italic"></p>
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
                                    <div id="valueLog" class="scroll-log d-none">

                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Karyawan Saya (Jika Atasan)</h4>
                                </div>
                                <div class="card-body">
                                    <div id="loadingDataBawahan" class="d-none">
                                        <center class="p-4">
                                            <div class="loader"></div>
                                            <h6 class="mt-3">Mengambil Data</h6>
                                        </center>
                                    </div>
                                    <div id="noneBawahan" class="d-none">
                                        <center>
                                            <img class="custom-empty-bawahan" src="<?= base_url() ?>/Asset/Icon/empty-data.svg" alt="">
                                            <h6 class="mt-2">Data tidak ditemukan</h6>
                                        </center>
                                    </div>
                                    <div id="valueBawahan" class="scroll-karyawan-saya d-none">

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
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/employee/infoemployee.js"></script>

</body>

</html>