<!DOCTYPE html>
<html lang="en">

<head>
    <?= view('Template/V_CSS') ?>
</head>

<body>
    <script src="<?= base_url() ?>/Asset/Main/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <?= view('Template/V_Header') ?>
            <div class="content-wrapper container">

                <div class="page-heading">
                    <h3>Pelanggan</h3>
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
                                                    <th>Telepon</th>
                                                    <th>Alamat</th>
                                                    <th>Terakhir Edit</th>
                                                    <th data-orderable="false">Status</th>
                                                    <th data-orderable="false">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Nama</td>
                                                    <td>Telepon</td>
                                                    <td>Alamat</td>
                                                    <td>Alamat</td>
                                                    <td>Status</td>
                                                    <td>Aksi</td>
                                                </tr>
                                            </tbody>
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
                                                        <label for="exampleFormControlInput1" class="form-label">Status Pelanggan</label>
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

                                    <div class="modal fade" id="resetSandi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Reset Kata Sandi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="exampleFormControlInput1" class="form-label">Kata Sandi Baru</label>
                                                        <input type="password" class="form-control" id="Pass" aria-describedby="PassHelp">
                                                        <div id="PassHelp" class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="exampleFormControlInput1" class="form-label">Konfirmasi Kata Sandi Baru</label>
                                                        <input type="password" class="form-control" id="PassConf" aria-describedby="PassConfHelp">
                                                        <div id="PassConfHelp" class="invalid-feedback"></div>
                                                    </div>

                                                </div>
                                                <div class=" modal-footer">
                                                    <button type="button" id="simpanSandi" class="btn btn-primary ">Simpan</button>
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
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/pelanggan/listpelanggan.js"></script>
    <!-- <script>
        new DataTable('#example');
    </script> -->
</body>

</html>