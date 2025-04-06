<!DOCTYPE html>
<html lang="en">

<head>
    <?= view('Template/V_CSS') ?>
    <!-- <link rel="stylesheet" href="<?= base_url() ?>/Asset/Main/Custom/page/product/from.css"> -->
    <link rel="stylesheet" href="<?= base_url() ?>/Asset/Main/Custom/page/product/infoProduct.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <!-- <link rel="stylesheet" href="<?= base_url() ?>/Asset/Main/Custom/page/product/customprice.css"> -->
</head>

<body>
    <script src="<?= base_url() ?>/Asset/Main/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <?= view('Template/V_Header') ?>
            <div class="content-wrapper container">

                <div class="page-heading">
                    <h3><button class="btn" id="Back1"><i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; margin-top:-10px"></i> </button>Custom Harga Produk</h3>
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12 col-lg-5">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="p-2 col-lg-12">
                                            <center>
                                                <img id="imagep" class="img-thumbnail custom-img-product" src="<?= base_url() ?>/Asset/Icon/empty-image-produk.svg'" alt="">
                                                <p class="text-muted custom-subtitle mt-2">Stok Produk</p>
                                                <p class="fw-bold" id="stok"></p>
                                            </center>
                                        </div>
                                        <div class="p-2 col-lg">
                                            <h4 id=NameProduct>Judul Produk</h4>
                                            <div class="row">
                                                <div class="col-lg-6 col-6">
                                                    <div class="custom-konten">
                                                        <p class="text-muted custom-subtitle">Jenis Produk</p>
                                                        <p class="fw-bold" id="type">Produk</p>
                                                    </div>
                                                    <div class="custom-konten">
                                                        <p class="text-muted custom-subtitle">Bahan Produk</p>
                                                        <p class="fw-bold" id="bahan">Produk</p>
                                                    </div>
                                                    <div class="custom-konten">
                                                        <p class="text-muted custom-subtitle">Ukuran Produk</p>
                                                        <p class="fw-bold" id="sizeProduk">Produk</p>
                                                    </div>

                                                    <!-- <div class=" bd-highlight mb-1">Stok Produk: <strong><span id="stok">Celana</span></strong></div> -->
                                                    <div class=" bd-highlight d-none">Limit Produk: <strong><span id="limit">Celana</span></strong></div>
                                                </div>
                                                <div class="col-lg col-6">
                                                    <div class="custom-konten">
                                                        <p class="text-muted custom-subtitle">Harga Per-Potong</p>
                                                        <p class="fw-bold" id="potong">Produk</p>
                                                    </div>
                                                    <div class="custom-konten">
                                                        <p class="text-muted custom-subtitle">Harga Per-Lusin</p>
                                                        <p class="fw-bold" id="lusin">Produk</p>
                                                    </div>
                                                    <div class="custom-konten">
                                                        <p class="text-muted custom-subtitle">Harga Per-Kodi</p>
                                                        <p class="fw-bold" id="kodi">Produk</p>
                                                    </div>
                                                    <!-- <div class=" bd-highlight flex-custom mb-1">Harga Per-Potong (Umum): <strong><span id="potong">Celana</span></strong></div> -->
                                                    <!-- <div class=" bd-highlight mb-1">Harga Per-Lusin (Umum): <strong><span id="lusin">Celana</span></strong></div> -->
                                                    <!-- <div class=" bd-highlight mb-1">Harga Per-Kodi (Umum): <strong><span id="kodi">Celana</span></strong></div> -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="p-2 bd-highlight">Flex item 3</div> -->
                                    </div>




                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="table-responsive">
                                        <table id="table" class="table " style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Nama Harga</th>
                                                    <th>Per-Potong</th>
                                                    <th>Per-Lusin</th>
                                                    <th>Per-Kodi</th>
                                                    <th data-orderable="false">Status</th>
                                                    <th data-orderable="false" style="width: 150px;">Aksi</th>
                                                </tr>
                                            </thead>

                                        </table>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="labelAdd">Filter Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input class="d-none" type="hidden" id="tempIdCustom">
                                                    <input class="d-none" type="hidden" id="tempName">
                                                    <div class="mb-3">
                                                        <label for="exampleFormControlInput1" class="form-label">Nama Harga
                                                            <span class="text-danger"><sup>*</sup></span>
                                                        </label>
                                                        <input placeholder="Ketik Disini..." type="text" class="form-control" id="Name">
                                                        <div id="nameHelp" class="invalid-feedback">

                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="Name" class="form-label">Harga Perpotong
                                                            <span class="text-danger"><sup>*</sup></span>
                                                        </label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="inputGroup-sizing-default">Rp</span>
                                                            <input onkeyup="isNumberKey(this,event)" type="text" class="form-control" placeholder="Ketik Disini..." name="Potong" id="Potong" aria-describedby="potongHelp">
                                                            <div id="potongHelp" class="invalid-feedback">

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="Name" class="form-label">Harga PerLusin (Umum)<span class="text-danger"><sup>*</sup></span></label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text" id="inputGroup-sizing-default">Rp</span>
                                                            <input onkeyup="isNumberKey(this,event)" type="text" class="form-control" placeholder="Ketik Disini..." name="Lusin" id="Lusin" aria-describedby="lusinHelp">
                                                            <div id="lusinHelp" class="invalid-feedback">

                                                            </div>
                                                        </div>
                                                    </div>
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
                                                <div class="modal-footer">
                                                    <button type="button" id="CancelData" class="btn btn-secondary">Batal</button>
                                                    <button type="button" id="SaveData" class="btn btn-primary ">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalLabelForm"></h5>
                                                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <input type="hidden" id="tempName">
                                                        <label for="exampleFormControlInput1" class="form-label">Nama Jenis Produk</label>
                                                        <input type="text" class="form-control" id="Name" aria-describedby="nameHelp" placeholder="Ketik Disini...">
                                                        <div id="nameHelp" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="exampleFormControlInput1" class="form-label">Deskripsi</label>
                                                        <textarea name="des" id="des" aria-describedby="desHelp" placeholder="Ketik Disini..." class="form-control" rows="3"></textarea>
                                                        <div id="desHelp" class="invalid-feedback"></div>
                                                    </div>

                                                </div>
                                                <div class=" modal-footer">
                                                    <button type="button" id="saveData" class="btn btn-primary ">Simpan</button>
                                                    <button type="button" id="cancelData" class="btn btn-secondary ">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="formAddUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalLabelUser"></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" class="d-none" id="tempIdCustomprice">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-12">
                                                            <div class="list-menu-custom">
                                                                <div class="d-flex bd-highlight">
                                                                    <div class="p-2 w-100 bd-highlight">Form Tambah</div>
                                                                    <!-- <div class="p-2 flex-shrink-1 bd-highlight"><button id="btnProduct" class="btn btn-custom" type="button"><i id="iconProduct" class="bi bi-chevron-up"></i></button></div> -->
                                                                </div>
                                                            </div>
                                                            <!-- <label for="">Nama Pelanggan</label> -->
                                                            <div class="input-group mb-3">
                                                                <input type="text" id="serachData" class="form-control" placeholder="Ketik Disini Nama Pelanggan..." aria-label="Recipient's username" aria-describedby="button-addon2">
                                                                <!-- <button class="btn btn-outline-secondary" type="button" id="button-addon2">Button</button> -->
                                                            </div>
                                                            <div style="margin-top: -30px;" class="table-responsive">
                                                                <table id="addMember" class="table table-borderless w-100">
                                                                    <thead>
                                                                        <tr>
                                                                            <th data-orderable="false"></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <div class=" shadow-sm bg-body-tertiary rounded d-flex">
                                                                                    <div class="p-2 w-100">Flex item</div>
                                                                                    <div class="  p-1 flex-shrink-1"><button class="btn"><i class="bi bi-plus-circle text-success"></i></button></div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg col-12">
                                                            <div class="list-menu-custom">
                                                                <div class="d-flex bd-highlight">
                                                                    <div class="p-2 w-100 bd-highlight">Data Anggota</div>
                                                                    <!-- <div class="p-2 flex-shrink-1 bd-highlight"><button id="btnProduct" class="btn btn-custom" type="button"><i id="iconProduct" class="bi bi-chevron-up"></i></button></div> -->
                                                                </div>
                                                            </div>
                                                            <div style="margin-top: -20px;" class="table-responsive">
                                                                <table id="listMember" class="table table-borderless w-100">
                                                                    <thead>
                                                                        <tr>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <!-- <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <div class=" shadow-sm bg-body-tertiary rounded d-flex">
                                                                                    <div class="p-2 w-100">Flex item</div>
                                                                                    <div class="  p-1 flex-shrink-1"><button class="btn"><i class="bi bi-x-circle text-danger"></i></button></div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody> -->
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- <div class=" modal-footer">
                                                    <button type="button" id="saveMemberData" class="btn btn-primary ">Simpan</button>
                                                    <button type="button" id="cancelMemberData" class="btn btn-secondary ">Batal</button>
                                                </div> -->
                                            </div>
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
    <!-- Latest compiled and minified JavaScript -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> -->
    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script> -->
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/product/customprice.js"></script>
    <!-- <script>
        new DataTable('#example');
    </script> -->
</body>

</html>