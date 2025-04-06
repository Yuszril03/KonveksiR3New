<!DOCTYPE html>
<html lang="en">

<head>
    <?= view('Template/V_CSS') ?>
    <link rel="stylesheet" href="<?= base_url() ?>/Asset/Main/Custom/page/product/infoProduct.css">
</head>

<body>
    <script src="<?= base_url() ?>/Asset/Main/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <?= view('Template/V_Header') ?>
            <div class="content-wrapper container">

                <div class="page-heading">
                    <h3><button class="btn" id="Back1"><i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; margin-top:-10px"></i> </button>Informasi Produk</h3>
                </div>
                <div class="page-content">
                    <section class="row">
                        <div class="col-12 col-lg-8">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">

                                    <div class="row">
                                        <div class="col-lg-3 col-12">
                                            <center>
                                                <img id="detailImage" src="<?= base_url() ?>/Asset/Icon/empty-image-produk.svg" class="img-thumbnail custom-img-product" alt="">
                                                <div>
                                                    <p class="mt-2 text-muted custom-subtitle">Stok Produk</p>
                                                    <p class="fw-bold" id="stok">300</p>
                                                </div>
                                            </center>

                                        </div>
                                        <div class="col-lg-9">
                                            <h4 class="mb-3" id="nameProduk">Nama Produk</h4>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="custom-konten">
                                                        <p class="text-muted custom-subtitle">Jenis Produk</p>
                                                        <p class="fw-bold" id="typeProduk">Produk</p>
                                                    </div>
                                                    <div class="custom-konten">
                                                        <p class="text-muted custom-subtitle">Bahan Produk</p>
                                                        <p class="fw-bold" id="materialProduk">Produk</p>
                                                    </div>
                                                    <div class="custom-konten">
                                                        <p class="text-muted custom-subtitle">Ukuran Produk</p>
                                                        <p class="fw-bold" id="sizeProduk">Produk</p>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="custom-konten">
                                                        <p class="text-muted custom-subtitle">Harga Per-Potong</p>
                                                        <p class="fw-bold" id="pricePotong">Produk</p>
                                                    </div>
                                                    <div class="custom-konten">
                                                        <p class="text-muted custom-subtitle">Harga Per-Lusin</p>
                                                        <p class="fw-bold" id="priceLusin">Produk</p>
                                                    </div>
                                                    <div class="custom-konten">
                                                        <p class="text-muted custom-subtitle">Harga Per-Kodi</p>
                                                        <p class="fw-bold" id="priceKodi">Produk</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <h5 class="mb-3">Harga Kostum Produk
                                        <button id="btnFilterPrice" class="float-end btn custom-filter-price"><i id="iconFilterPrice" class="bi bi-funnel"></i></button>
                                    </h5>
                                    <div id="nonePrice" class="d-none">
                                        <center>
                                            <img class="custom-empty-price" src="<?= base_url() ?>/Asset/Icon/empty-data.svg" alt="">
                                            <h5 class="mt-2">Data tidak ditemukan</h5>
                                        </center>
                                    </div>
                                    <div id="valuePrice" class="scroll-price d-block">

                                    </div>
                                </div>
                            </div>
                            <!-- Modal Filter Price -->
                            <div class="modal fade" id="searchPrice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title" id="exampleModalLabel">Filter Data</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <!-- <label for="">Nama Harga</label> -->
                                                <input id="textNamePrice" type="text" class="form-control" placeholder="Pencarian Berdasarkan Nama Harga ...">
                                            </div>
                                            <label for="">Status</label>
                                            <div class=" mt-2">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="statusPrice" id="inlineRadio1" value="all" checked>
                                                    <label class="form-check-label" for="inlineRadio1">Semua</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="statusPrice" id="inlineRadio2" value="1">
                                                    <label class="form-check-label" for="inlineRadio2">Aktif</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="statusPrice" id="inlineRadio3" value="0">
                                                    <label class="form-check-label" for="inlineRadio3">Non-Aktif</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button id="resetFilterPrice" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                                            <button id="submitFilterPrice" type="button" class="btn btn-primary">Terapkan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">

                                    <div class="float-end">
                                        <button id="prevStatik" class=" btn custom-btn-statik"><i class="bi bi-arrow-left-circle-fill"></i></button>
                                        <button id="nextStatik" disabled class=" btn custom-filter-price"><i class="bi bi-arrow-right-circle-fill"></i></button>
                                    </div>
                                    <h5 class="mb-3">Statik Produk <span id="years"></span></h5>
                                    <div id="chartYear">

                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <h5 class="mb-3">Log Produk</h5>
                                    <div id="noneLog" class="d-none">
                                        <center>
                                            <img class="custom-empty-price" src="<?= base_url() ?>/Asset/Icon/empty-data.svg" alt="">
                                            <h5 class="mt-2">Data tidak ditemukan</h5>
                                        </center>
                                    </div>
                                    <div id="valueLog" class="scroll-log">

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
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/product/infoProduct.js"></script>
    <!-- <script>
        new DataTable('#example');
    </script> -->
</body>

</html>