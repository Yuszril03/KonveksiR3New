<!DOCTYPE html>
<html lang="en">

<head>
    <?= view('Template/V_CSS') ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <link rel="stylesheet" href="<?= base_url() ?>/Asset/Main/Custom/page/pelanggan/addpelanggan.css">
</head>

<body>
    <script src="<?= base_url() ?>/Asset/Main/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <?= view('Template/V_Header') ?>
            <div class="content-wrapper container">

                <div class="page-heading">
                    <h3>Tambah Pelanggan</h3>
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">

                                    <div class="mb-3">
                                        <label for="Name" class="form-label">Nama Lengkap <sup><span class="text-danger">*</span></sup></label>
                                        <input type="text" class="form-control" name="Name" id="Name" placeholder="Ketik Disini..." aria-describedby="nameHelp">
                                        <div id="nameHelp" class="form-text text-danger"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="mb-3">
                                                <label for="Name" class="form-label">Nomor Telefon <sup><span class="text-danger">*</span></sup></label> <br>
                                                <input type="text" onkeypress="return isNumberKey(event)" class="form-control w-100" name="Telephone" id="Telephone" aria-describedby="telefonHelp">
                                                <div id="telefonHelp" class="form-text text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="mb-3">
                                                <label for="Name" class="form-label">Email</label>
                                                <input type="text" class="form-control" id="Email" name="Email" placeholder="Ketik Disini..." aria-describedby="emailHelp">
                                                <div id="emailHelp" class="form-text text-danger"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="Name" class="form-label">Alamat <sup><span class="text-danger">*</span></sup></label>
                                        <textarea name="Address" id="Address" class="form-control" rows="5" placeholder="Ketik Disini..." aria-describedby="addressHelp"></textarea>
                                        <div id="addressHelp" class="form-text text-danger"></div>
                                    </div>
                                    <div class="float-end">
                                        <button id="cancel" class="btn btn-danger">Batal</button>
                                        <button id="save" class="btn btn-primary">Simpan</button>
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
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/pelanggan/addpelanggan.js"></script>

</body>

</html>