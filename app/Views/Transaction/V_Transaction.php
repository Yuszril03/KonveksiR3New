<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <?= view('Template/V_CSS') ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <link rel="stylesheet" href="<?= base_url() ?>/Asset/Main/Custom/page/transaksi/index.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css" integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>

<body id="test">
    <script src="<?= base_url() ?>/Asset/Main/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <?= view('Template/V_Header') ?>
            <div class="content-wrapper container">

                <div class="page-heading">
                    <h3>Transaksi</h3>
                </div>
                <div class="page-content">
                    <section class="row">

                        <div class="col-12 col-lg-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="position-relative ">

                                        <!-- <div class="timeline-item">
                                            <div class="animated-background">
                                            </div>
                                        </div> -->


                                        <div class="mb-3">
                                            <input id="inputserch" type="text" class="form-control" placeholder="Cari Berdasarkan Nama, Bahan, Jenis ....">
                                        </div>
                                        <div class="container-list-product" id="listProduct">
                                            <div class="row d-none">
                                                <div class="col-lg-4 col-6 mt-2">
                                                    <btn class="btn w-100 text-start btn-list-product">
                                                        <img src="<?= base_url() ?>/Asset/Icon/no-image.jpg" class="img-list-product" alt="">
                                                        <span class="badge bg-primary mt-1 size-list-product">Ukuran</span>
                                                        <p class="text-muted mt-1 title-list-product">Judul Produk</p>
                                                        <p class="text-danger fw-bold price-list-product">
                                                            <span class="badge bg-warning material-list-product">Jenis</span>
                                                            <span class="badge bg-success material-list-product">Bahan</span>
                                                        </p>
                                                    </btn>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="emptyproduct" class="w-100 custom-empty d-none">
                                            <img src="<?= base_url() ?>/Asset/Icon/empty-product.svg" style="width: 150px;" alt="">
                                            <p class="mt-1">Produk tidak tersedia</p>
                                        </div>
                                        <div id="tambahTransaksi" class="d-none position-absolute top-50 start-50 translate-middle w-100 h-100 layout-button-add-transaction">
                                            <div class="layout-inner-button-add-trancs">
                                                <button id="btntambahtransaksi" class="btn btn-success btn-custom-add-transac"><i class="bi bi-plus"></i> Tambah Transaksi</button>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modaladdTrans" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Transaksi</h5>
                                                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" class="d-none" id="tempPelanggan">
                                                        <input type="hidden" class="d-none" id="tempHutang">
                                                        <input type="hidden" class="d-none" id="tempSaving">
                                                        <div class="mb-3">
                                                            <label for="">Nama Pelanggan <sup><span class="text-danger">*</span></sup></label>
                                                            <!-- <select name="pelanggan" id="pelanggan" class="form-select"></select> -->
                                                            <select id="select-tools" class="form-control custom-form-name" style="padding: 0" multiple placeholder="Pilih Pelanggan..."></select>
                                                            <div class="invalid-feedback" id="tempPelangganHelp">
                                                                Harap memilih pelanggan dahulu
                                                            </div>
                                                        </div>
                                                        <div class="float-end">
                                                            <button id="btnAddPelanggan" class="btn btn-link">Tambah Pelanggan ?</button>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" id="bataladdTrans" class="btn btn-secondary">Batal</button>
                                                        <button type="button" id="btnAddTrans" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="modallAddPelanggan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Pelanggan</h5>
                                                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="">Nama Pelanggan <sup><span class="text-danger">*</span></sup></label>
                                                            <input type="text" class="form-control" id="NameCus" placeholder="Ketik Disini...">
                                                            <div class="invalid-feedback" id="NameCusHelp">
                                                                Please choose a username.
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="Name" class="form-label">Nomor Telefon <sup><span class="text-danger">*</span></sup></label> <br>
                                                            <input type="text" onkeypress="return isNumberKey(event)" class="form-control w-100" name="Telephone" id="Telephone" aria-describedby="telefonHelp">
                                                            <div id="telefonHelp" class="form-text text-danger"></div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="Name" class="form-label">Alamat</label>
                                                            <textarea name="address" id="address" class="form-control" rows="3" placeholder="Ketik Disini..."></textarea>
                                                            <div id="addressHelp" class="form-text text-danger"></div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" id="bataladdPelanggan" class="btn btn-secondary">Batal</button>
                                                        <button type="button" id="simpanaddPelanggan" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modaladdPrice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Harga Khusus</h5>
                                                        <button type="button" id="btncloseaddprice" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped w-100" id="tableaddprice">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nama Harga</th>
                                                                        <th>Per-Potong</th>
                                                                        <th>Per-Lusin</th>
                                                                        <th>Per-Kodi</th>
                                                                        <th>Opsi</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary">Save changes</button>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Modal Sukses Pembayaran -->
                                        <div class="modal fade" id="modalSukses" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content p-4" style="border-radius: 20px;">
                                                    <div class="modal-body">
                                                        <center>
                                                            <img class="w-25" src="<?= base_url() ?>\Asset\Icon\check-true.png" alt="">
                                                            <h4 class="mt-4">Pembayaran Berhasil</h4>
                                                            <p>Pembayaran sudah dilakukan</p>
                                                            <button id="cetakNota" class="btn btn-secondary">Cetak Nota</button>
                                                            <button id="download" class="btn btn-danger">Download Nota</button>
                                                            <button id="nextTrans" class="btn btn-primary">Lanjutkan Transaksi Baru</button>
                                                        </center>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                        <!-- Modal Product-->
                                        <div class="modal fade" id="detailproduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Detail Produk</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <img id="detailImage" src="<?= base_url() ?>/Asset/Icon/empty-image-produk.svg" class="img-thumbnail" style="width: 250px; border-radius: 20px;" alt="">
                                                            </div>
                                                            <div class="col-lg">
                                                                <input type="text" id="tempIDProduct" class="d-none">
                                                                <h3 class="mt-lg-0 mt-1" id="titleProductM">Nama Produk</h3>
                                                                <p>
                                                                    <span class="badge bg-primary">Ukuran : <span id="sizeM"></span></span>
                                                                </p>
                                                                <div class="row ">
                                                                    <div class="col-lg-6 col-6">
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-12">
                                                                                Jenis Produk
                                                                            </div>
                                                                            <div id="jenisM" class="col-lg-12 col-12 fw-bold">
                                                                                <strong>1200</strong>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-12">
                                                                                Bahan Produk
                                                                            </div>
                                                                            <div class="col-lg-12 col-12 fw-bold" id="bahanM">
                                                                                1200
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-12">
                                                                                Stok Produk
                                                                            </div>
                                                                            <div class="col-lg-12 col-12 fw-bold" id="stokM">
                                                                                1200/PT <span class="badge bg-primary">Tersedia</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-6 ">
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-12">
                                                                                Harga Per-Potong
                                                                            </div>
                                                                            <div class="col-lg-12 col-12 fw-bold " id="potongM">
                                                                                <strong>1200</strong>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-12">
                                                                                Harga Per-Lusin
                                                                            </div>
                                                                            <div class="col-lg-12 col-12 fw-bold" id="lusinM">
                                                                                1200
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-12">
                                                                                Harga Per-Kodi
                                                                            </div>
                                                                            <div class="col-lg-12 col-12 fw-bold" id="kodiM">

                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="col-lg-4 mt-lg-0 mt-3">
                                                                <div class="choicePayment ">
                                                                    <h5 class="mt-1 ml-1">Atur Pemesanan</h5>
                                                                    <span class="fst-italic">*Produk yang masuk keranjang masih dalam kondisi keep belum terpotong stok*</span>
                                                                    <input type="text" class="d-none" id="IdDetailTrans">
                                                                    <div class="mt-3">
                                                                        <p>Harga Khusus </p>
                                                                        <div class="group-btns">
                                                                            <input type="text" class="d-none" id="IdTempMemberPrice">
                                                                            <button id="hargaKhusus" class="btn btn-danger btn-rounded"><i class="bi bi-x-circle"></i> Potong</button>
                                                                            <button id="tambahHargaKhusus" class="btn btn-success btn-rounded"><i class="bi bi-plus-circle"></i> Tambah Harga Khusus</button>
                                                                            <span id="statusHargaKhusus">Kedaluwarsa</span>
                                                                        </div>


                                                                        <p>Pilih Satuan <sup class="text-danger">*</sup></p>
                                                                        <div class="group-btns">
                                                                            <button id="btnPotong" class="btn btn-outline-primary btn-rounded">Potong</button>
                                                                            <button id="btnLusin" class="btn btn-outline-primary btn-rounded">Lusin</button>
                                                                            <button id="btnKodi" class="btn btn-outline-primary btn-rounded">Kodi</button>
                                                                        </div>
                                                                        <p>Jumlah <sup class="text-danger">*</sup></p>
                                                                        <div class="row custom-row-entity">
                                                                            <div class="col-lg-4 col-4">
                                                                                <div class="d-flex flex-row bd-highlight mb-3 custom-entity">
                                                                                    <div class="p-1 bd-highlight">
                                                                                        <button id="btnMinus" class="btn btn-custom-sum  btn-sm"><i class="bi bi-dash text-primary"></i></button>
                                                                                    </div>
                                                                                    <div class="p-1 bd-highlight custom-sum">
                                                                                        <span class="d-none" id="ItemCart">1</span>
                                                                                        <input id="inputItem" class="customInputItem" placeholder="0" type="text">
                                                                                    </div>
                                                                                    <div class="p-1 bd-highlight">
                                                                                        <button id="btnPlus" class="btn btn-custom-sum  btn-sm"><i class="bi bi-plus text-primary"></i></button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg col-4">
                                                                                <div class="custom-status-entity">
                                                                                    <span id="statusPersedian"> </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <button id="addTocart" class="btn btn-primary btn-block btn-custom-cart"> Tambah Keranjang</button>
                                                                        <div class="row d-none" id="btnCart">
                                                                            <div class="col-lg-6 col-6">
                                                                                <button id="UpdateTocart" class="btn btn-primary btn-block m-1 btn-custom-cart"> Perbarui</button>
                                                                            </div>
                                                                            <div class="col-lg-6 col-6">
                                                                                <button id="CancelTocart" class="btn btn-danger btn-block m-1 btn-custom-cart"> Hapus</button>
                                                                            </div>

                                                                        </div>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h5 class="mt-3 d-none">Harga Khusus</h5>
                                                        <input type="text" id="idTempIdPrice" class="d-none">
                                                        <div class=" table-responsive mt-1 d-none">
                                                            <table class="table table-striped w-100" id="tablehargakhusus">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 100px;">Harga</th>
                                                                        <th>Per-Potong</th>
                                                                        <th>Per-Lusin</th>
                                                                        <th>Per-Kodi</th>
                                                                        <th>Status</th>
                                                                        <th>Opsi</th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer d-none">
                                                        <button type="button" id="canceladdProduct" class="btn btn-secondary">Batal</button>
                                                        <button type="button" class="btn btn-primary">Tambah Keranjang</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-5">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Detail Transaksi</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary d-none" id="demoNota">
                                        Launch demo modal
                                    </button>

                                    <div class="row">
                                        <div class="col-lg-4 col-5">
                                            <p class="text-muted">No. Transaksi</p>
                                        </div>
                                        <div class="col-lg col">
                                            <div class="fw-bold text-end " id="idTrans">
                                                <div class="timeline-item">
                                                    <div class="animated-background">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <p class="fw-bold text-end d-none" id="idTrans"></p> -->

                                        </div>
                                    </div>

                                    <div class="row container-detail-trans">
                                        <div class="col-lg-4 col-5">
                                            <p class="text-muted">Tanggal</p>
                                        </div>
                                        <div class="col-lg col">
                                            <div class="fw-bold text-end " id="dateTrans">
                                                <div class="timeline-item">
                                                    <div class="animated-background">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <p class="fw-bold text-end" id="dateTrans">123444</p> -->
                                        </div>
                                    </div>
                                    <div class="row container-detail-trans">
                                        <div class="col-lg-4 col-5">
                                            <p class="text-muted">Kasir</p>
                                        </div>
                                        <div class="col-lg col">
                                            <div class="fw-bold text-end " id="kasirTrans">
                                                <div class="timeline-item">
                                                    <div class="animated-background">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <p class="fw-bold text-end" id="kasirTrans">123444</p> -->
                                        </div>
                                    </div>
                                    <div class="container-detail-trans">
                                        <p class="text-muted">Nama Pelanggan</p>
                                        <div class="row" style="margin-top: -13px;">
                                            <div class="col-lg col">
                                                <input type="text" class="d-none" id="IdCustomer">
                                                <div class="fw-bold" id="namapelanggan">
                                                    <div class="timeline-item">
                                                        <div class="animated-background">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <p class="fw-bold" id="namapelanggan">Pelanggan</p> -->
                                            </div>
                                            <div class="col-lg-2 col-2">
                                                <!-- <button class="btn btn-sm text-end"><i class="bi bi-pen"></i></button> -->
                                            </div>
                                        </div>
                                    </div>
                                    <HR style="margin-top: 3px;">
                                    </HR>
                                    <div id="noneCart" class="w-100 d-none text-center">
                                        <img src="<?= base_url() ?>/Asset/Icon/empty-cart.svg" style="width: 120px;" alt="">
                                        <p class="mt-1">Keranjang masih kosong</p>
                                    </div>
                                    <div id="tableCart" class="table-responsive" style="margin-top: -8px; max-height:500px;">
                                        <table id class="table  w-100">
                                            <thead style="background-color: white;">
                                                <tr>
                                                    <th class="bg-table-th">Produk</th>
                                                    <th class="bg-table-th">Sub-total</th>
                                                    <th class="bg-table-th"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="bodytableCart"></tbody>

                                        </table>
                                    </div>
                                    <HR style="margin-top: 3px;">
                                    </HR>
                                    <div class="row" style="margin-top: -8px;">
                                        <div class="col-lg-4 col-5">
                                            <p class="text-muted" style="font-size: 11pt;">Sub Total</p>
                                        </div>
                                        <div class="col-lg col">

                                            <div class="fw-bold text-end" style="font-size: 11pt;" id="subtotal">
                                                <?= LoadingData ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: -8px;">
                                        <div class="col-lg-4 col-5">
                                            <p class="text-muted" style="font-size: 11pt;">Hutang</p>
                                        </div>
                                        <div class="col-lg col">
                                            <div class="fw-bold text-end" style="font-size: 11pt;" id="hutang">
                                                <?= LoadingData ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: -8px;">
                                        <div class="col-lg-4 col-5">
                                            <p class="fw-bold" style="font-size: 14pt;">Total</p>
                                        </div>
                                        <div class="col-lg col">
                                            <div class="fw-bold text-end" style="font-size: 14pt;" id="total">
                                                <?= LoadingData ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row d-none" style="margin-top: -8px;">
                                        <div class="col-lg-4 col-5">
                                            <p class="fw-bold" style="font-size: 14pt;">Bayar</p>
                                        </div>
                                        <div class="col-lg col">
                                            <p class="fw-bold text-end" style="font-size: 14pt;" id="balance">123444</p>
                                        </div>
                                    </div>
                                    <div class="row d-none" style="margin-top: -8px;">
                                        <div class="col-lg-4 col-5">
                                            <p class="text-muted" style="font-size: 11pt;">Kembalian</p>
                                        </div>
                                        <div class="col-lg col">

                                            <p class="fw-bold text-end" style="font-size: 11pt;" id="sisa">123444</p>
                                        </div>
                                    </div>
                                    <div class="row d-none" style="margin-top: -8px;">
                                        <div class="col-lg-4 col-5">
                                            <p class="text-muted" style="font-size: 11pt;">Status</p>
                                        </div>
                                        <div class="col-lg col">
                                            <p class="fw-bold text-end" style="font-size: 11pt;" id="stausTRans">123444</p>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="btn-group btn-block " role="group" aria-label="Basic example">
                                            <button id="bataltrans" type="button" disabled class="btn btn-danger m-1 " style="border-radius: 10px;">Batal</button>
                                            <button id="simpantrans" type="button" class="btn btn-warning m-1 " style="border-radius: 10px;">Simpan</button>
                                            <button id="bayartrans" type="button" class="btn btn-primary m-1 " style="border-radius: 10px;">Bayar</button>
                                            <button id="cetakNota" type="button" class="btn btn-secondary m-1 d-none" style="border-radius: 10px;">Cetak Nota</button>
                                        </div>

                                        <!-- Modal -->


                                        <div class="modal fade" id="modalPembayaranTrans" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Pembayaran</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="">Jenis Pembayaran</label>
                                                            <select name="payments" id="payments" class="form-select">
                                                                <option value="" disabled selected> Pilih Pembayaran</option>
                                                                <option value="0"> Tunai</option>
                                                                <option value="1"> Transfer Bank</option>
                                                            </select>
                                                            <div id="paymentsHelp" class="invalid-feedback">
                                                                Please provide a valid city.
                                                            </div>
                                                        </div>
                                                        <div id="content-bayar" class="mb-3">
                                                            <label for="">Upload Bukti Pembayaran</label>
                                                            <input type="file" accept="image/*" class="form-control" name="fileBuktiKirim" id="fileBuktiKirim">
                                                            <div id="fileBuktiKirimHelp" class="invalid-feedback">
                                                                Please provide a valid city.
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label for="">Nominal Pembayaran</label>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                                                <input type="text" class="form-control" id="nominalbayar" onkeyup="isNumberKey(this,event)" placeholder="0" aria-describedby="basic-addon1">
                                                            </div>
                                                            <div id="nominalbayarHelp" class="invalid-feedback">
                                                                Please provide a valid city.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" id="batalPay" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="button" id="nextPay" class="btn btn-primary">Lanjut Pembayaran</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row d-none">
                                            <div class="col">
                                                <button class="btn btn-danger btn-sm btn-block"> Batal</button>
                                            </div>
                                            <div class="col">
                                                <button class="btn btn-warning btn-sm btn-block"> Simpan</button>
                                            </div>
                                            <div class="col">
                                                <button class="btn btn-primary btn-sm btn-block"> Bayar</button>
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
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/transaksi/index.js"></script>
    <script>

    </script>

</body>

</html>