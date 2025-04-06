<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <?= view('Template/V_CSS') ?>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css"> -->
    <link rel="stylesheet" href="<?= base_url() ?>/Asset/Main/Custom/page/profil/index.css">

</head>

<body>
    <script src="<?= base_url() ?>/Asset/Main/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <?= view('Template/V_Header') ?>
            <div class="content-wrapper container">

                <div class="page-heading">
                    <h3>Ubah Kata Sandi</h3>
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body py-4 px-4">
                                    <p>Pastikan anda sudah yakin ingin mengganti kata sandi lama anda ke kata sandi baru. Kata sandi ini digunakan untuk masuk ke dalam <code>Aplikasi Karyawan Konveksi R-Tiga</code>.</p>
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="mb-3">
                                                <label for="">Kata Sandi Lama</label>
                                                <input type="password" class="form-control" id="ktLama" placeholder="Ketik Disini...">
                                                <div id="ktLamaHelp" class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="">Kata Sandi Baru</label>
                                                <input type="password" class="form-control" id="ktBaru" placeholder="Ketik Disini...">
                                                <div id="ktBaruHelp" class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="">Konfirmasi Kata Sandi Baru</label>
                                                <input type="password" class="form-control" id="ktBaruKof" placeholder="Ketik Disini...">
                                                <div id="ktBaruKofHelp" class="invalid-feedback">

                                                </div>
                                            </div>
                                            <button class="btn btn-primary btn-block" id="simpan">Simpan</button>
                                        </div>
                                        <div class="col-lg-6 col-12 d-lg-block d-none">
                                            <center>
                                                <img src="<?= base_url() ?>/Asset/Icon/password.svg" width="280" alt="">
                                            </center>
                                        </div>
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
    <!-- <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script> -->
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/profil/password.js"></script>

</body>

</html>