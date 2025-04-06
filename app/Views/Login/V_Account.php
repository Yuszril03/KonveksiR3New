<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <?= view('Template/V_CSS') ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <link rel="stylesheet" href="<?= base_url() ?>/Asset/Main/Custom/page/profil/index.css">

</head>

<body>
    <script src="<?= base_url() ?>/Asset/Main/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <?= view('Template/V_Header') ?>
            <div class="content-wrapper container">

                <div class="page-heading">
                    <h3>Profil</h3>
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12 col-lg-8">
                            <div class="card">
                                <div class="card-body py-4 px-4">
                                    <div class="w-100 bg-profil mb-3 position-relative">

                                        <div class="position-absolute top-50 start-50 translate-middle custom-position-image">
                                            <input type="hidden" class="d-none" id="tempImage" value="<?= session()->get('Image') ?>">
                                            <button class="btn btn-image" id="changeProfil" title="Ganti Profil">
                                                <?php
                                                if (session()->get('Image') != NULL) {
                                                ?>
                                                    <img src="<?= base_url() ?>/<?= session()->get('Image') ?>" class="rounded-circle img-profil img-thumbnail" alt="">
                                                <?php

                                                } else { ?>
                                                    <img src="<?= base_url() ?>/Asset/Main/compiled/jpg/<?= (session()->get('Gender') == 1) ? '2' : '3' ?>.jpg" class="rounded-circle img-profil img-thumbnail" alt="">
                                                <?php } ?>

                                                <img src="<?= base_url() ?>/Asset/Icon/camera.png" class="rounded-circle img-profil2 img-thumbnail" alt="">
                                            </button>
                                        </div>
                                        <div class="position-absolute top-100 start-50 translate-middle custom-position-name">
                                            <p id="Name" class="custom-name">Achmad Yuszril Oiszy</p>
                                        </div>
                                    </div>
                                    <div class="list-menu-custom">
                                        <div class="d-flex bd-highlight">
                                            <div class="p-2 w-100 bd-highlight custom-judul"><i id="iconPeronal" class="bi bi-person"> </i>Data Personal</div>
                                            <div class="p-2 flex-shrink-1 bd-highlight"><button id="btnPersonal" class="btn btn-custom" type="button"></button></div>
                                        </div>
                                    </div>
                                    <div id="contenPersonal">
                                        <button id="editData" class="btn btn-warning btn-sm float-end"><i class="bi bi-pen"></i> Edit</button>
                                        <div class="row">
                                            <div class="col-lg-6 col-12">
                                                <div class="mb-3">
                                                    <p class="text-muted ">Username</p>
                                                    <p class=" custom-desc-sub" id="username">-</p>
                                                </div>
                                                <div class="mb-3">
                                                    <p class="text-muted ">Email</p>
                                                    <p class=" custom-desc-sub" id="email">-</p>
                                                </div>

                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <div class="mb-3">
                                                    <p class="text-muted ">Jenis Kelamin</p>
                                                    <p class="text-capitalize custom-desc-sub" id="gender">-</p>
                                                </div>
                                                <div class="mb-3">
                                                    <p class="text-muted ">Telefon</p>
                                                    <p class="text-capitalize custom-desc-sub" id="telefon">-</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="mb-3 custom-address">
                                            <p class="text-muted ">Alamat</p>
                                            <p class="text-capitalize custom-desc-sub" style=" text-align: justify; text-justify: inter-word;" id="address">-</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="card">
                                <div class="card-body py-4 px-4">
                                    <div class="list-menu-custom">
                                        <div class="d-flex bd-highlight">
                                            <div class="p-2 w-100 bd-highlight custom-judul"><i class="bi bi-briefcase"></i> Data Pekerjaan</div>
                                            <div class="p-2 flex-shrink-1 bd-highlight"><button id="btnUbahSandi" class="btn btn-custom" type="button"></button></div>
                                        </div>
                                    </div>
                                    <div id="contentUbahSandi">
                                        <div class="row">
                                            <div class="col-lg-6 col-12">
                                                <div class="mb-3">
                                                    <p class="text-muted ">Posisi</p>
                                                    <p class="text-capitalize custom-desc-sub" id="posisi">Laki-Laki</p>
                                                </div>
                                                <div class="mb-3">
                                                    <p class="text-muted ">Atasan</p>
                                                    <p class="text-capitalize custom-desc-sub" id="atasan">Laki-Laki</p>
                                                </div>

                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <div class="mb-3">
                                                    <p class="text-muted ">Role</p>
                                                    <p class="text-capitalize custom-desc-sub" id="role">Laki-Laki</p>
                                                </div>
                                                <div class="mb-3">
                                                    <p class="text-muted ">Status</p>
                                                    <p class="text-capitalize custom-desc-sub" id="status">Laki-Laki</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body py-4 px-4">
                                    <div class="list-menu-custom">
                                        <div class="d-flex bd-highlight">
                                            <div class="p-2 w-100 bd-highlight custom-judul"><i class="bi bi-info-circle"></i> Informasi Lain</div>
                                            <div class="p-2 flex-shrink-1 bd-highlight"><button id="btnUbahSandi" class="btn btn-custom" type="button"></button></div>
                                        </div>
                                    </div>
                                    <div id="contentUbahSandi">
                                        <div class="mb-3">
                                            <p class="text-muted ">Tanggal Buat</p>
                                            <p class="text-capitalize custom-desc-sub" id="created">Laki-Laki</p>
                                        </div>
                                        <div class="mb-3">
                                            <p class="text-muted ">Terakhir Diubah</p>
                                            <p class="text-capitalize custom-desc-sub" id="modified">Laki-Laki</p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="modalEditData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="">Nama</label>
                                                <input type="text" class="form-control" id="NameM" placeholder="Ketik Disini..." disabled>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-12">
                                                    <div class="mb-3">
                                                        <label for="">Username</label>
                                                        <input type="text" class="form-control" id="UsernameM" placeholder="Ketik Disini..." disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <input type="hidden" id="tempTelephone" class="d-none">
                                                    <div class="mb-3">
                                                        <label for="">Telefon <span class="text-danger"><sup>*</sup></span></label>
                                                        <input type="text" onkeypress="return isNumberKey(event)" class="form-control w-100" name="TelephoneM" id="Telephone" aria-describedby="telefonHelp">
                                                        <div id="telefonHelp" class="invalid-feedback">
                                                            ss
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-12">
                                                    <div class="mb-3">
                                                        <input type="hidden" class="d-none" id="TempEmail">
                                                        <label for="">Email<span class="text-danger"><sup>*</sup></span></label>
                                                        <input type="text" class="form-control" id="EmailM" placeholder="Ketik Disini...">
                                                        <div id="emailnHelp" class="invalid-feedback">
                                                            ss
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <div class="mb-3">
                                                        <label for="">Jenis Kelamin<span class="text-danger"></label>
                                                        <input type="text" class="form-control" id="genderM" disabled placeholder="Ketik Disini...">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="Name" class="form-label">Alamat </label>
                                                <textarea name="AddressM" id="AddressM" rows="3" class="form-control" placeholder="Ketik Disini" aria-describedby="addressHelp"></textarea>
                                                <div id="addressHelp" class="invalid-feedback">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="batal" class="btn btn-secondary">Batal</button>
                                            <button type="button" id="simpan" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="modalEditFoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Ubah Profil</h5>
                                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col">
                                                    <div id="fileUploass" class="file-upload">
                                                        <button type="button" id="btnCancelImage" onclick="removeUpload()" title="Hapus Foto" class="btn float-right"> <i class="bi bi-x-circle-fill" style="color: red;"></i> </button>
                                                        <div class="Imagees">
                                                            <img src="<?= base_url() ?>/Asset/Icon/uploadData.svg" id="NoneImage" alt="">
                                                            <img src="" id="AddImage" alt="">
                                                        </div>
                                                        <center>
                                                            <div class="image-upload-wrap" style="margin-top: -110px ;">
                                                                <input id="uploadFilee" accept="image/*" class="file-upload-input" type='file' onchange="readURL(this);" />

                                                                <div class="drag-text mt-4">
                                                                    <h6 style="margin-top:-20px;">Seret dan lepas file atau pilih tambahkan Gambar</h6>
                                                                </div>
                                                            </div>
                                                            <p class="image-title">Unggah Gambar</p>
                                                        </center>

                                                    </div>
                                                    <div id="fotoHelp" class="invalid-feedback d-none">

                                                    </div>
                                                </div>
                                                <!-- <div class="col"></div> -->
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" id="cancelImage">Batal</button>
                                            <button type="button" class="btn btn-primary" id="saveImage">Simpan</button>
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
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/profil/index.js"></script>

</body>

</html>