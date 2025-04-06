<!DOCTYPE html>
<html lang="en">

<head>
    <?= view('Template/V_CSS') ?>
    <style>
        .container-list {
            width: 100%;
            /* height: 100px; */
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            padding-top: 15px;
            padding-left: 20px;
            padding-right: 20px;
        }

        .list-values {
            margin-top: -15px !important;
        }

        .btn-custom-filter {
            border-radius: 20px !important;
        }

        .custom-img {
            width: 200px;
        }

        .name-Kasir {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            width: 100%;
            background: #2496ed;
            height: 30px;
            padding-top: 3px;
        }

        .title-name-kasir {
            margin-left: 15px
        }

        .radius-form-search {
            border-radius: 20px !important;
        }

        .tgl_style {
            float: right;
            margin-right: 20px;
            font-style: italic;
        }

        @media only screen and (min-device-width: 1024px) {
            .name-Kasir {
                height: 15px;
            }

        }

        @media only screen and (max-width: 360px),
        (min-device-width: 360px) and (max-device-width: 1024px) {
            .name-Kasir {
                height: 15px;
            }
        }
    </style>
</head>

<body>
    <script src="<?= base_url() ?>/Asset/Main/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <?= view('Template/V_Header') ?>
            <div class="content-wrapper container">

                <div class="page-heading">
                    <h3>Laporan Transaksi</h3>
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12 col-lg-12">
                            <div class="row">
                                <div class="col-6 col-lg-6 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon purple mb-2">
                                                        <i class="iconly-boldWallet"></i>
                                                        <!-- <i class="bi bi-cash-stack"></i> -->

                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Omset</h6>
                                                    <h6 class="font-extrabold mb-0" id="omset">0</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-6 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon blue mb-2">
                                                        <i class="iconly-boldBuy"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Transaksi</h6>
                                                    <h6 class="font-extrabold mb-0" id="totalTransaksi">0</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-lg col-6">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Pengurutan</label>
                                                <select name="urutan" id="urutan" class="form-select radius-form-search">
                                                    <option value="asc" selected>Terkecil-Terbesar</option>
                                                    <option value="desc">Terbesar-Terkecil</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg col-6">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Kasir <span class="text-danger"><sup>(*)</sup></span></label>
                                                <select name="kasir" id="kasir" class="form-select radius-form-search"></select>
                                            </div>
                                        </div>
                                        <div class="col-lg col-12">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Pelanggan <span class="text-danger"><sup>(*)</sup></span></label>
                                                <select name="pelanggan" id="pelanggan" class="form-select radius-form-search"></select>
                                            </div>
                                        </div>
                                        <div class="col-lg col-6 d-none">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Status <span class="text-danger"><sup>(*)</sup></span></label>
                                                <select name="status" id="status" class="form-select radius-form-search">
                                                    <option disabled value="" selected>Pilih Status...</option>
                                                    <option value="semua">Semua Status</option>
                                                    <option value="1">Draft</option>
                                                    <option value="2">Tersimpan</option>
                                                    <option value="3">Batal</option>
                                                    <option value="4">Lunas</option>
                                                    <option value="5">Hutang</option>
                                                    <option value="6">Diteruskan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg col-12">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label ">Tanggal Pembayaran <span class="text-danger"><sup>(*)</sup></span></label>
                                                <input type="text" class="form-control selector radius-form-search" placeholder="Pilih tanggal..." id="date">
                                            </div>
                                        </div>
                                    </div>
                                    <button id="cari" class="btn btn-primary m-1 radius-form-search"><i class="bi bi-search"></i> Cari</button>
                                    <button id="ekpor" class="btn btn-secondary m-1 radius-form-search"><i class="bi bi-cloud-arrow-down"></i> Ekpor</button>
                                    <button id="reset" class="btn btn-danger m-1 radius-form-search d-none"><i class="bi bi-x-circle"></i> Reset</button>

                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div id="listTrans">

                                    </div>
                                    <div id="loadingData" class="d-none">
                                        <center class="p-4">
                                            <div class="loader"></div>
                                            <h6 class="mt-3">Mengambil Data Transaksi</h6>
                                        </center>
                                    </div>
                                    <div class="text-center d-none mt-3 mb-3" id="emptydata">
                                        <img src="<?= base_url() ?>/Asset/Icon/empty-cart.svg" class="custom-img" alt="">
                                        <h5 class="mt-2">Transaksi tidak ditemukan</h5>
                                    </div>



                                    <div class="shadow mt-3 mb-5 bg-body-tertiary container-list d-none">
                                        <div class="row">
                                            <div class="col-lg-2 col-6">
                                                <p class="text-muted">Tgl. Transaksi</p>
                                                <p class="fw-bold list-values">No.Transaksi</p>
                                            </div>
                                            <div class="col-lg-2 col-6">
                                                <p class="text-muted">No.Transaksi</p>
                                                <p class="fw-bold list-values">No.Transaksi</p>
                                            </div>
                                            <div class="col-lg-2 col-6">
                                                <p class="text-muted">Pelanggan</p>
                                                <p class="fw-bold list-values">No.Transaksi</p>
                                            </div>
                                            <div class="col-lg-2 col-6">
                                                <p class="text-muted">Total</p>
                                                <p class="fw-bold list-values">No.Transaksi</p>
                                            </div>
                                            <div class="col-lg-2 col-6">
                                                <p class="text-muted">Status</p>
                                                <p class="fw-bold list-values">No.Transaksi</p>
                                            </div>
                                            <div class="col-lg-2 col-6 text-center">
                                                <button class="btn btn-primary btn-sm mt-lg-3 mt-3"><i class="bi bi-pen"></i></button>
                                                <button class="btn btn-primary btn-sm mt-lg-3 mt-3"><i class="bi bi-pen"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <nav aria-label="Page navigation example" id="setPage">
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item disabled">
                                                <a class="page-link">
                                                    <i class="bi bi-chevron-left"></i>
                                                </a>
                                            </li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item active"><a class="page-link active" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">
                                                    <i class="bi bi-chevron-right"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>

                                    <h6 id="parentTextFilter" class="fst-italic text-muted d-none">Filter Data : <span id="textFilter"></span></h6>
                                    <div class="table-responsive d-none">
                                        <table id="table" class="table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal Transaksi</th>
                                                    <th>No. Transaksi</th>
                                                    <th>Pelanggan</th>
                                                    <th>Total</th>
                                                    <th data-orderable="false">Status</th>
                                                    <th data-orderable="false"> </th>
                                                </tr>
                                            </thead>

                                        </table>
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
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/transaksi/reporttrans_manager.js"></script>
    <!-- <script>
        new DataTable('#example');
    </script> -->
</body>

</html>