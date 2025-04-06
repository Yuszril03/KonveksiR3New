<!DOCTYPE html>
<html lang="en">

<head>
    <?= view('Template/V_CSS') ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <link rel="stylesheet" href="<?= base_url() ?>/Asset/Main/Custom/page/employee/addemployee.css">

</head>

<body>
    <script src="<?= base_url() ?>/Asset/Main/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <?= view('Template/V_Header') ?>
            <div class="content-wrapper container">

                <div class="page-heading">
                    <h3><button class="btn" id="Back1"><i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; margin-top:-10px"></i> </button>Edit Karyawan</h3>
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="list-menu-custom">
                                        <div class="d-flex bd-highlight">
                                            <div class="p-2 w-100 bd-highlight">Data Personal</div>
                                            <div class="p-2 flex-shrink-1 bd-highlight"><button id="btnPersonal" class="btn btn-custom" type="button"><i id="iconPeronal" class="bi bi-chevron-up"></i></button></div>
                                        </div>
                                    </div>
                                    <div id="contenPersonal">
                                        <div class="mb-3">
                                            <label for="Name" class="form-label">Nama Lengkap Karyawan <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="text" class="form-control " placeholder="Ketik Disini..." name="Name" id="Name" aria-describedby="nameHelp">
                                            <div id="nameHelp" class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-12">

                                                <div class="mb-3">
                                                    <label for="Name" class="form-label">Jenis Kelamin <span class="text-danger"><sup>*</sup></span></label>
                                                    <select name="Gender" id="Gender" class="form-control" aria-describedby="genderHelp">
                                                        <option value="" selected disabled>Pilih Jenis Kelamin...</option>
                                                        <option value="1">Laki-Laki</option>
                                                        <option value="2">Perempuan</option>
                                                    </select>
                                                    <div id="genderHelp" class="invalid-feedback">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <div class="mb-3">
                                                    <label for="Name" class="form-label">Telefon WhatsApp<span class="text-danger"><sup>*</sup></span></label>
                                                    <input type="hidden" id="tempTelephone">
                                                    <input type="text" onkeypress="return isNumberKey(event)" class="form-control w-100" name="Telephone" id="Telephone" aria-describedby="telefonHelp">
                                                    <div id="telefonHelp" class="invalid-feedback">
                                                        ss
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6 col-12">
                                                <div class="mb-3">
                                                    <label for="Name" class="form-label">Email</label>
                                                    <input type="text" class="form-control " placeholder="Ketik Disini..." name="Email" id="Email" aria-describedby="emailHelp">
                                                    <div id="emailHelp" class="invalid-feedback">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <div class="mb-3">
                                                    <label for="Name" class="form-label">Username </label>
                                                    <input type="text" disabled readonly class="form-control " placeholder="Ketik Disini..." name="Username" id="Username" aria-describedby="usernameHelp">
                                                    <div id="usernameHelp" class="invalid-feedback">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="Name" class="form-label">Alamat <span class="text-danger"><sup>*</sup></span></label>
                                            <textarea name="Address" id="Address" rows="3" class="form-control" placeholder="Ketik Disini" aria-describedby="addressHelp"></textarea>
                                            <div id="addressHelp" class="invalid-feedback">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="list-menu-custom">
                                        <div class="d-flex bd-highlight">
                                            <div class="p-2 w-100 bd-highlight">Data Pekerjaan</div>
                                            <div class="p-2 flex-shrink-1 bd-highlight"><button id="btnPekerjaan" class="btn btn-custom" type="button"><i id="iconPekerjaan" class="bi bi-chevron-up"></i></button></div>
                                        </div>
                                    </div>
                                    <div id="contenPekerjaan">
                                        <div class="row">
                                            <div class="col-lg-6 col-12">

                                                <div class="mb-3">
                                                    <label for="Name" class="form-label">Role Kerja <span class="text-danger"><sup>*</sup></span></label>
                                                    <select name="IdRole" id="IdRole" class="form-control" aria-describedby="IdRoleHelp">
                                                        <option value="2" selected disabled>Pilih Role...</option>
                                                        <option value="1">Laki-Laki</option>
                                                        <option value="2">Perempuan</option>
                                                    </select>
                                                    <div id="IdRoleHelp" class="invalid-feedback">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <div class="mb-3">
                                                    <label for="Name" class="form-label">Posisi Kerja <span class="text-danger"><sup>*</sup></span></label>
                                                    <select disabled name="IdPosition" id="IdPosition" class="form-control" aria-describedby="IdPositionHelp">
                                                        <option value="" selected disabled>Pilih Posisi...</option>
                                                        <option value="1">Laki-Laki</option>
                                                        <option value="2">Perempuan</option>
                                                    </select>
                                                    <div id="IdPositionHelp" class="invalid-feedback">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="formSwitchSuperior" class="mb-3 d-none">
                                            <label for="Name" id="labelSwitchSuperior" class="form-label">Pengalihan Atasan <span class="text-danger"><sup>*</sup></span></label>
                                            <select name="SwitchSuperior" id="SwitchSuperior" class="form-control" aria-describedby="SwcithSuperiorHelp">
                                                <option value="" selected disabled>Pilih Atasan...</option>

                                            </select>
                                            <div id="SwcithSuperiorHelp" class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div id="formSuperior" class="mb-3 d-none">
                                            <label for="Name" id="labelSuperior" class="form-label">Atasan <span class="text-danger"><sup>*</sup></span></label>
                                            <select name="Superior" id="Superior" class="form-control" aria-describedby="SuperiorHelp">
                                                <option value="" selected disabled>Pilih Atasan...</option>

                                            </select>
                                            <div id="SuperiorHelp" class="invalid-feedback">

                                            </div>
                                        </div>

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
    <!-- <script src="<?= base_url() ?>/Asset/Main/Custom/page/employee/editemployee.js"></script> -->
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/employee/edit2employee.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/username-generator@1.1.0/test/index.js"></script> -->

</body>

</html>