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
                    <h3><button class="btn" id="Back1"><i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; margin-top:-10px"></i> </button>Edit Pelanggan</h3>
                </div>
                <div class=" page-content">
                    <section class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">

                                    <div class="mb-3">
                                        <label for="Name" class="form-label">Nama Lengkap <sup><span class="text-danger">*</span></sup></label>
                                        <input type="text" class="form-control" name="Name" id="Name" aria-describedby="nameHelp" placeholder="Ketik Disini...">
                                        <div id="nameHelp" class="form-text text-danger"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="mb-3">
                                                <label for="Name" class="form-label">Username </label>
                                                <input type="text" readonly class="form-control w-100" name="Username" id="Username" placeholder="Username Belum Terbentuk" aria-describedby="usernameHelp">
                                                <div id="usernameHelp" class="form-text text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="mb-3">
                                                <label for="Name" class="form-label">Jenis Kelamin</label>
                                                <select name="Gender" id="Gender" class="form-control" aria-describedby="genderHelp">
                                                    <option selected disabled>Pilih Jenis Kelamin...</option>
                                                    <option value="1">Laki-Laki</option>
                                                    <option value="0">Perempuan</option>
                                                </select>
                                                <div id="genderHelp" class="form-text text-danger"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="mb-3">
                                                <label for="Name" class="form-label">Nomor Telefon <sup><span class="text-danger">*</span></sup></label> <br>
                                                <input type="text" onkeypress="return isNumberKey(event)" placeholder="Ketik Disini..." class="form-control w-100" name="Telephone" id="Telephone" aria-describedby="telefonHelp">
                                                <input type="hidden" id="tempTelephone">
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
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/pelanggan/editpelanggan.js"></script>

</body>

</html>