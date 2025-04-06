<!DOCTYPE html>
<html lang="en">

<head>
    <?= view('Template/V_CSS') ?>
    <style>
        .img-custom {
            width: 150px;
            /* height: 150px; */
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
                    <h3><button class="btn" id="Back1"><i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; margin-top:-10px"></i></button> Detail Transaksi</h3>
                </div>
                <div class="page-content">

                    <section class="row">
                        <div class="col-12 col-lg-12">
                            <div class="card">

                                <div class="card-body px-4 py-4-5">
                                    <div class="text-center">
                                        <img src="<?= base_url() ?>/Asset/Icon/empty-trans.png" class="img-custom" alt="">
                                        <h5 class="mt-2">Maaf transaksi tidak ditemukan</h5>
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
    <script src="<?= base_url() ?>/Asset/Main/Custom/page/transaksi/emptytrans.js"></script>
    <!-- <script>
        new DataTable('#example');
    </script> -->
</body>

</html>