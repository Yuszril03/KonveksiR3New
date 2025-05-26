<!DOCTYPE html>
<html lang="en">

<head>
    <?= view('Template/V_CSS') ?>
    <link rel="stylesheet" href="<?= base_url() ?>/Asset/Main/Custom/page/transaksi/detailtrans.css">
    <link href="<?= base_url() ?>/Asset/photoviewer-master/dist/photoviewer.min.css" rel="stylesheet" />
</head>

<body>
    <script src="<?= base_url() ?>/Asset/Main/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <?= view('Template/V_Header') ?>
            <div class="content-wrapper container">

                <div class="page-heading">
                    <h3><button class="btn" id="Back1"><i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; margin-top:-10px"></i></button> Detail Transaksi</h3>
                </div>
                <div class="page-content">
                    <div id="statusKonten" class="alert  d-flex align-items-center" role="alert">

                        <i id="iconStatus" class="bi   flex-shrink-0 me-1" style="width: 24px; height: 24px;"></i>
                        <div id="valueStatus">

                        </div>
                    </div>
                    <section class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">

                                <div class="card-body px-4 py-4-5">
                                    <!-- <h5 class="card-title">Detail Transaksi</h5> -->
                                    <div class=" mt-3">
                                        <p class="text-muted">Nomor Transaksi</p>
                                        <div class="fw-bold" id="nota" style="margin-top: -10px;"> <?= LoadingData ?></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-6">
                                            <div class=" ">
                                                <p class="text-muted">Tgl. Transaksi</p>
                                                <div class="fw-bold" id="tglTrans" style="margin-top: -10px;"> <?= LoadingData ?></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-6">
                                            <div class=" ">
                                                <p class="text-muted">Kasir</p>
                                                <div class="fw-bold" id="namaKAsir" style="margin-top: -10px;"> <?= LoadingData ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-6">
                                            <div class=" ">
                                                <p class="text-muted">Pelanggan</p>
                                                <div class="fw-bold" id="pelanggan" style="margin-top: -10px;"> <?= LoadingData ?></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-6">
                                            <div class=" ">
                                                <p class="text-muted">Transaksi Terusan</p>
                                                <div class="fw-bold" id="transTerusan" style="margin-top: -10px;"> <?= LoadingData ?></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card">

                                <div class="card-body px-4 py-4-5">
                                    <div class="d-flex bd-highlight mb-3">
                                        <div class="mt-2 w-100 bd-highlight">
                                            <h5 class="card-title">Log Transaksi</h5>
                                        </div>
                                        <div class=" flex-shrink-1 bd-highlight">
                                            <button class="btn" id="btnLog" data-bs-toggle="collapse" data-bs-target="#kontenlog" aria-expanded="false" aria-controls="kontenlog"><i style="font-size: 20px;" id="iconLog" class="bi bi-chevron-down"></i></button>
                                        </div>
                                    </div>
                                    <div class="collapse" id="kontenlog" style="overflow:scroll; overflow-x: hidden; max-height:300px;">

                                    </div>



                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <h5 class="card-title ">Rincian Transaksi</h5>
                                    <div id="kontenItem"></div>
                                    <div id="loadingData" class="d-none">
                                        <center class="p-4">
                                            <div class="loader"></div>
                                            <h6 class="mt-3">Mengambil Item Transaksi</h6>
                                        </center>
                                    </div>

                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <!-- <h5 class="card-title">Total Transaksi</h5> -->
                                    <div class="text-end">
                                        <div class="row">
                                            <div class="col-lg-10 col-7">
                                                <p>Sub Total</p>
                                            </div>
                                            <div class="col-lg col">
                                                <div id="subtotal"> <?= LoadingData ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="row">
                                            <div class="col-lg-10 col-7">
                                                <p>Hutang</p>
                                            </div>
                                            <div class="col-lg col">
                                                <div id="hutang"> <?= LoadingData ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="row">
                                            <div class="col-lg-10 col-7">
                                                <p>Total</p>
                                            </div>
                                            <div class="col-lg col">
                                                <div id="total"> <?= LoadingData ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div id="valueOtherBayar"></div>
                                        <div class="row" id="valueOriBayar">
                                            <div class="col-lg-10 col-7">
                                                <p>Bayar</p>
                                            </div>
                                            <div class="col-lg col">
                                                <div id="bayar"> <?= LoadingData ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="row">
                                            <div class="col-lg-10 col-7">
                                                <p id="titleKembalian">Kembalian</p>
                                            </div>
                                            <div class="col-lg col">
                                                <div id="kembalian"> <?= LoadingData ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end" id="paymentConten">
                                        <div class="row">
                                            <div class="col-12">
                                                <button id="btnHutang" class="btn btn-success d-none">Pembayaran Hutang</button>
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
                                                        <button id="prevRiwayat" class="btn btn-primary">Kembali Menu Riwayat</button>
                                                    </center>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="modalWarningPayment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <!-- <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div> -->
                                                <div class="modal-body text-center" style="padding: 50px;">
                                                    <img class="w-50" src="<?= base_url() ?>/Asset/Icon/prosesPayment.svg" alt="">
                                                    <h5 id="titleWarPay" class="mt-2">Transaksi Sedang Berlansung</h5>
                                                    <p id="subtitleWarPay">Mohon ditunggu beberapa saat</p>
                                                    <button id="btnReload" class="btn btn-primary mt-3" data-bs-dismiss="modal">Okey</button>
                                                    <button id="btnNonRelod" class="btn btn-primary mt-3" data-bs-dismiss="modal">Okey</button>
                                                </div>
                                                <!-- <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>

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
                                                    <div id="content-bayar" class="mb-3 d-none">
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
                                                        <div id="nominalbayarHelp" class="invalid-feedback ">
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

                                </div>
                            </div>


                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="detailBuktiPembayaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img id="imgTf" src="<?= base_url() ?>/Asset/Icon/logo.png" alt="">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
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
    <script src="<?= base_url() ?>/Asset/image-viewer-ezoom/ezoom.js"></script>
    <script src="<?= base_url() ?>/Asset/photoviewer-master/dist/photoviewer.min.js"></script>
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/transaksi/detailtrans.js"></script>
    <!-- <script>
        new DataTable('#example');
    </script> -->
</body>

</html>