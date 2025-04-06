<!DOCTYPE html>
<html lang="en">

<head>
    <?= view('Template/V_CSS') ?>
    <link rel="stylesheet" href="<?= base_url() ?>/Asset/Main/Custom/page/product/from.css">
</head>

<body>
    <script src="<?= base_url() ?>/Asset/Main/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <?= view('Template/V_Header') ?>
            <div class="content-wrapper container">

                <div class="page-heading">
                    <h3><button class="btn" id="Back1"><i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; margin-top:-10px"></i> </button>Edit Produk</h3>
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <!-- <div class="list-menu-custom">
                                        <div class="d-flex bd-highlight">
                                            <div class="p-2 w-100 bd-highlight">Data Produk</div>
                                            <div class="p-2 flex-shrink-1 bd-highlight"><button id="btnProduct" class="btn btn-custom" type="button"><i id="iconProduct" class="bi bi-chevron-up"></i></button></div>
                                        </div>
                                    </div> -->
                                    <div id="contenProduct">
                                        <label for="Name" class="form-label">Foto Produk </label>
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
                                            <div class="col"></div>
                                        </div>


                                        <div class="mb-3">
                                            <label for="Name" class="form-label">Nama Produk <span class="text-danger"><sup>*</sup></span></label>
                                            <input type="hidden" class="form-control d-none" placeholder="Ketik Disini..." name="TempSlug" id="TempSlug" aria-describedby="nameHelp">
                                            <input type="text" class="form-control " placeholder="Ketik Disini..." name="Name" id="Name" aria-describedby="nameHelp">
                                            <div id="nameHelp" class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-12">
                                                <div class="mb-3">
                                                    <label for="Name" class="form-label">Ukuran Produk <span class="text-danger"><sup>*</sup></span></label>
                                                    <input type="text" class="form-control " placeholder="Ketik Disini..." name="Size" id="Size" aria-describedby="sizeHelp">
                                                    <div id="sizeHelp" class="invalid-feedback">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-12">
                                                <div class="mb-3">
                                                    <label for="Name" class="form-label">Jenis Produk <span class="text-danger"><sup>*</sup></span></label>
                                                    <select name="type" id="type" class="form-select"></select>
                                                    <div id="typeHelp" class="invalid-feedback">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-12">
                                                <div class="mb-3">
                                                    <label for="Name" class="form-label">Bahan Produk <span class="text-danger"><sup>*</sup></span></label>
                                                    <select name="material" id="material" class="form-select"></select>
                                                    <div id="materialHelp" class="invalid-feedback">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-info" role="alert">
                                            <strong>Info,</strong> jika tidak ingin memberikan nilai pada kolom bisa isikan dengan <b>0</b>
                                        </div>
                                        <div class="mb-3">
                                            <label for="Name" class="form-label">Modal Produk
                                                <span class="text-danger"><sup>*</sup></span>
                                            </label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-default">Rp</span>
                                                <input onkeyup="isNumberKey(this,event)" type="text" class="form-control" placeholder="Ketik Disini..." name="ModalP" id="ModalP" aria-describedby="modalHelp">
                                                <div id="modalHelp" class="invalid-feedback">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-12">
                                                <div class="mb-3">
                                                    <label for="Name" class="form-label">Harga Perpotong (Umum)
                                                        <span class="text-danger"><sup>*</sup></span>
                                                    </label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="inputGroup-sizing-default">Rp</span>
                                                        <input onkeyup="isNumberKey(this,event)" type="text" class="form-control" placeholder="Ketik Disini..." name="Potong" id="Potong" aria-describedby="potongHelp">
                                                        <div id="potongHelp" class="invalid-feedback">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-12">
                                                <div class="mb-3">
                                                    <label for="Name" class="form-label">Harga PerLusin (Umum)<span class="text-danger"><sup>*</sup></span></label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="inputGroup-sizing-default">Rp</span>
                                                        <input onkeyup="isNumberKey(this,event)" type="text" class="form-control" placeholder="Ketik Disini..." name="Lusin" id="Lusin" aria-describedby="lusinHelp">
                                                        <div id="lusinHelp" class="invalid-feedback">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-12">
                                                <div class="mb-3">
                                                    <label for="Name" class="form-label">Harga PerKodi (Umum)<span class="text-danger"><sup>*</sup></span></label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="inputGroup-sizing-default">Rp</span>
                                                        <input onkeyup="isNumberKey(this,event)" type="text" class="form-control" placeholder="Ketik Disini..." name="Kodi" id="Kodi" aria-describedby="kodiHelp">
                                                        <div id="kodiHelp" class="invalid-feedback">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-12">
                                                <label for="Name" class="form-label">Stok Produk </label>
                                                <div class="input-group mb-3">
                                                    <input disabled onkeyup="isNumberKey(this,event)" type="text" class="form-control w-50" placeholder="Ketik Disini..." name="Stok2" id="Stok2">
                                                    <input disabled onkeyup="isNumberKey(this,event)" type="hidden" class="form-control w-50" placeholder="Ketik Disini..." name="Stok" id="Stok">
                                                    <select disabled class="form-select d-none" id="typeStok" aria-label="Example select with button addon">

                                                    </select>
                                                    <div id="stokHelp" class="invalid-feedback">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <label for="Name" class="form-label">Limit Produk <span class="text-danger"><sup>*</sup></span></label>
                                                <div class="input-group mb-3">
                                                    <input onkeyup="isNumberKey(this,event)" type="text" class="form-control w-50" placeholder="Ketik Disini..." name="Limit" id="Limit">
                                                    <select disabled class="form-control" id="typeLimit" aria-label="Example select with button addon">

                                                    </select>
                                                    <div id="limitHelp" class="invalid-feedback">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- <div class="list-menu-custom">
                                        <div class="d-flex bd-highlight">
                                            <div class="p-2 w-100 bd-highlight">Data Tipe Harga Produk</div>
                                            <div class="p-2 flex-shrink-1 bd-highlight"><button id="btnPriceCustom" class="btn btn-custom" type="button"><i id="iconPriceCustom" class="bi bi-chevron-up"></i></button></div>
                                        </div>
                                    </div> -->
                                    <!-- <div id="contenPriceCustom">

                                        <div class="table-responsive">
                                            <table class="table table-striped w-100" id="tableHarga">
                                                <thead>
                                                    <tr>
                                                        <th data-orderable="false">Tipe Harga</th>
                                                        <th>Perpotong</th>
                                                        <th>PerLusin</th>
                                                        <th>PerKodi</th>
                                                        <th data-orderable="false">Status</th>
                                                        <th data-orderable="false">Aksi</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div> -->

                                    <div class="mt-2 float-end">
                                        <button class="btn btn-danger m-1" id="cancelData">Batal</button>
                                        <button class="btn btn-primary m-1" id="saveData">Simpan</button>
                                    </div>

                                    <!-- Modal Add Harga-->
                                    <!-- <div class="modal fade" id="customPrice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="labelCustomPrice"></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="alert alert-info" role="alert">
                                                        <strong>Info,</strong> jika tidak ingin memberikan nilai pada kolom bisa isikan dengan <b>0</b>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="Name" class="form-label">Nama Tipe Harga <span class="text-danger"><sup>*</sup></span></label>
                                                        <input type="text" class="form-control " placeholder="Ketik Disini..." name="NameTypePrice" id="NameTypePrice" aria-describedby="NameTypePriceHelp">
                                                        <div id="NameTypePriceHelp" class="invalid-feedback">

                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="Name" class="form-label">Harga PerPotong<span class="text-danger"><sup>*</sup></span></label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="inputGroup-sizing-default">Rp</span>
                                                            <input onkeyup="isNumberKey(this,event)" type="text" class="form-control" placeholder="Ketik Disini..." name="CustomPotong" id="CustomPotong" aria-describedby="CustomPotongHelp">
                                                            <div id="CustomPotongHelp" class="invalid-feedback">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="Name" class="form-label">Harga PerLusin<span class="text-danger"><sup>*</sup></span></label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="inputGroup-sizing-default">Rp</span>
                                                            <input onkeyup="isNumberKey(this,event)" type="text" class="form-control" placeholder="Ketik Disini..." name="CustomLusin" id="CustomLusin" aria-describedby="CustomLusinHelp">
                                                            <div id="CustomLusinHelp" class="invalid-feedback">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="Name" class="form-label">Harga PerKodi<span class="text-danger"><sup>*</sup></span></label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="inputGroup-sizing-default">Rp</span>
                                                            <input onkeyup="isNumberKey(this,event)" type="text" class="form-control" placeholder="Ketik Disini..." name="CustomKodi" id="CustomKodi" aria-describedby="CustomKodiHelp">
                                                            <div id="CustomKodiHelp" class="invalid-feedback">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" id="cancelCustom">Batal</button>
                                                    <button type="button" class="btn btn-primary" id="saveCustom">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->


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
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/product/Editfrom.js"></script>
    <!-- <script>
        new DataTable('#example');
    </script> -->
</body>

</html>