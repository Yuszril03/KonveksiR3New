<!DOCTYPE html>
<html lang="en">

<head>
    <?= view('Template/V_CSS') ?>
    <style>
        .container-list {
            width: 100%;
            /* height: 100px; */
            border-radius: 20px;
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
    </style>
</head>

<body>
    <script src="<?= base_url() ?>/Asset/Main/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <?= view('Template/V_Header') ?>
            <div class="content-wrapper container">

                <div class="page-heading">
                    <h3>Riwayat Transaksi</h3>
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <!-- <button class="btn btn-secondary btn-custom-filter float-end"><i class="bi bi-funnel-fill"></i> Filter</button>
                                    <br>
                                    <br> -->
                                    <div class="input-group mb-3">
                                        <input type="text" id="textSearch" class="form-control m-1 btn-custom-filter " placeholder="Cari berdasarkan No.Transaksi / Nama Pelanggan ..." aria-label="Recipient's username" aria-describedby="btnfilter">
                                        <button class="btn btn-secondary m-1 btn-custom-filter " type="button" id="btnfilter"><i class="bi bi-funnel-fill"></i></button>
                                    </div>
                                    <div style="margin-left: 10px;">
                                        <span id="textsort" class="badge text-bg-primary">Terbesar-Terkecil</span>
                                        <span id="textstatus" class="badge text-bg-secondary d-none">Secondary</span>
                                        <span id="texttanggal" class="badge text-bg-success d-none">Success</span>
                                    </div>
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

                                    <!-- Modal -->
                                    <div class="modal fade" id="filterData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Filter Data</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-2">
                                                        <label for="">Pengurutan Transaksi</label>
                                                        <div class="d-flex flex-row mb-3">
                                                            <div class="p-2">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="asc" value="asc">
                                                                    <label class="form-check-label" for="inlineRadio1">Terkecil - Terbesar</label>
                                                                </div>
                                                            </div>
                                                            <div class="p-2">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="desc" checked value="desc">
                                                                    <label class="form-check-label" for="inlineRadio2">Terbesar - Terkecil</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="">Status</label>
                                                        <select name="status" id="status" class="form-select">
                                                            <option value="" selected>Pilih Status...</option>
                                                            <option value="1">Draft</option>
                                                            <option value="2">Tersimpan</option>
                                                            <option value="3">Batal</option>
                                                            <option value="4">Lunas</option>
                                                            <option value="5">Hutang</option>
                                                            <option value="6">Diteruskan</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="exampleFormControlInput1" class="form-label">Terakhir Edit</label>
                                                        <input type="text" class="form-control selector" placeholder="Pilih tanggal..." id="date">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                                                    <button type="button" id="terapkan" class="btn btn-primary">Terapkan</button>
                                                </div>
                                            </div>
                                        </div>
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
                                            <!-- <tbody>
                                                <tr>
                                                    <td>Nama</td>
                                                    <td>Telepon</td>
                                                    <td>Alamat</td>
                                                    <td>Status</td>
                                                    <td>Aksi</td>
                                                </tr>
                                            </tbody> -->
                                        </table>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Filter Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="exampleFormControlInput1" class="form-label">Status Bahan Produk</label>
                                                        <select class="form-select" id="status" aria-label="Default select example">
                                                            <option selected value="2">Semua Status</option>
                                                            <option value="1">Aktif</option>
                                                            <option value="0">Tidak Aktif</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="exampleFormControlInput1" class="form-label">Terakhir Edit</label>
                                                        <input type="text" class="form-control selector" placeholder="Pilih tanggal..." id="date">
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="resetData" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                                                    <button type="button" id="terapkanData" class="btn btn-primary " data-bs-dismiss="modal">Terapkan</button>
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
                                                        <label for="exampleFormControlInput1" class="form-label">Nama Bahan Produk</label>
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
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/transaksi/historytrans.js"></script>
    <!-- <script>
        new DataTable('#example');
    </script> -->
</body>

</html>