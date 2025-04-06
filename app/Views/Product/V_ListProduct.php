<!DOCTYPE html>
<html lang="en">

<head>
    <?= view('Template/V_CSS') ?>
    <link rel="stylesheet" href="<?= base_url() ?>/Asset/Main/Custom/page/product/index.css">
</head>

<body>
    <script src="<?= base_url() ?>/Asset/Main/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <?= view('Template/V_Header') ?>
            <div class="content-wrapper container">

                <div class="page-heading">
                    <h3>Data Produk</h3>
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">

                                    <h6 id="parentTextFilter" class="fst-italic text-muted d-none">Filter Data : <span id="textFilter"></span></h6>
                                    <div class="table-responsive">
                                        <table id="table" class="table " style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Ukuran</th>
                                                    <th data-orderable="false">Jenis</th>
                                                    <th data-orderable="false">Bahan</th>
                                                    <th data-orderable="false">Stok</th>
                                                    <th>Terakhir Edit</th>
                                                    <th data-orderable="false">Status</th>
                                                    <th data-orderable="false" style="width: 100px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Nama</td>
                                                    <td>Ukuran</td>
                                                    <td>Jenis</td>
                                                    <td>Bahan</td>
                                                    <td>Stok</td>
                                                    <td>Terakhir Edit</td>
                                                    <td>Status</td>
                                                    <td>Aksi</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Filter Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-12">
                                                            <div class="mb-3">
                                                                <label for="exampleFormControlInput1" class="form-label">Jenis Produk</label>
                                                                <select class="form-select" id="jenis" aria-label="Default select example">

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-12">
                                                            <div class="mb-3">
                                                                <label for="exampleFormControlInput1" class="form-label">Bahan Produk</label>
                                                                <select class="form-select" id="bahan" aria-label="Default select example">

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-12">
                                                            <div class="mb-3">
                                                                <label for="exampleFormControlInput1" class="form-label">Stok Produk</label>
                                                                <select class="form-select" id="stokStatus" aria-label="Default select example">
                                                                    <option selected value="">Semua Stok</option>
                                                                    <option value="1">Tersedia</option>
                                                                    <option value="2">Hampir Habis</option>
                                                                    <option value="3">Habis</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-12">
                                                            <div class="mb-3">
                                                                <label for="exampleFormControlInput1" class="form-label">Status Jenis Produk</label>
                                                                <select class="form-select" id="status" aria-label="Default select example">
                                                                    <option selected value="">Semua Status</option>
                                                                    <option value="1">Aktif</option>
                                                                    <option value="0">Tidak Aktif</option>
                                                                </select>
                                                            </div>
                                                        </div>
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

                                    <div class="modal fade" id="addstok" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg  modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalLabelForm">Tambah Stok Produk</h5>
                                                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <div class="col-lg-6 col-12">
                                                        </div>
                                                        <div class="col-lg col-12"></div>
                                                    </div>
                                                    <div class="d-flex flex-custom bd-highlight mb-3">
                                                        <div class="p-2 flex-shrink-1 bd-highlight">
                                                            <img id="imagep" class="rounded-3 " style="width: 100pt;" src="<?= base_url() ?>/Asset/Icon/no-image.jpg" alt="">

                                                        </div>
                                                        <div class="p-2 w-100  bd-highlight w-100">
                                                            <h4 class="mt-2" id="judulM">Judul</h4>
                                                            <div class="d-flex flex-row bd-highlight mb-1">
                                                                <div class=" bd-highlight">Jenis Produk: <strong><span id="typeM">Celana</span></strong></div>
                                                                <div style="padding-left: 2px; padding-right: 2px;" class=" bd-highlight">|</div>
                                                                <div class="bd-highlight">Bahan Produk: <strong><span id="bahanM">Celana</span></strong></div>
                                                            </div>
                                                            <div class=" bd-highlight mb-1">Stok Produk: <strong><span id="stokM">Celana</span></strong> <strong id="statusM"></strong></div>
                                                            <div class=" bd-highlight">Limit Produk: <strong><span id="limitM">Celana</span></strong></div>

                                                        </div>
                                                    </div>
                                                    <input type="hidden" class="d-none" id="tempIDM">
                                                    <label for="Name" class="form-label">Stok Produk <span class="text-danger"><sup>*</sup></span></label>
                                                    <div class="input-group mb-3">
                                                        <input onkeyup="isNumberKey(this,event)" type="text" class="form-control w-50" placeholder="Ketik Disini..." name="StokFrom" id="StokFrom">
                                                        <select class="form-select" id="typeStokFrom" aria-label="Example select with button addon">

                                                        </select>
                                                        <div id="StokFromHelp" class="invalid-feedback">

                                                        </div>
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
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/product/index.js"></script>
    <!-- <script>
        new DataTable('#example');
    </script> -->
</body>

</html>