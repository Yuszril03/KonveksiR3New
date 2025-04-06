            <header class="mb-5">
                <div class="header-top">
                    <div class="container">
                        <div class="logo">
                            <input type="hidden" id="linkURL" value="<?= base_url() ?>/">
                            <a href="<?= base_url() ?>/"><img class="img-logo-header" src="<?= base_url() ?>/Asset/Icon/Logo.png" alt="Logo"></a>
                        </div>
                        <div class="header-top-right">

                            <div class="dropdown">
                                <a href="#" id="topbarUserDropdown" class="user-dropdown d-flex align-items-center dropend dropdown-toggle " data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="avatar avatar-md2">
                                        <?php
                                        if (session()->get('Image') != NULL) {
                                        ?>
                                            <img src="<?= base_url() ?>/<?= session()->get('Image') ?>" alt="Avatar">
                                        <?php

                                        } else { ?>
                                            <img src="<?= base_url() ?>/Asset/Main/compiled/jpg/<?= (session()->get('Gender') == 1) ? '2' : '3' ?>.jpg" alt="Avatar">
                                        <?php } ?>
                                    </div>
                                    <div class="text">
                                        <h6 class="user-dropdown-name ShortName"><?= session()->get('ShortName') ?></h6>
                                        <h6 class="user-dropdown-name FullName"><?= session()->get('Name') ?></h6>
                                        <p class="user-dropdown-status text-sm text-muted"><?= session()->get('NamePosition') ?></p>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                                    <li><a class="dropdown-item" href="<?= base_url() ?>/Profil">Profil</a></li>
                                    <?php
                                    if (session()->get('Root') == 0) {
                                    ?>
                                        <li><a class="dropdown-item" href="<?= base_url() ?>/Ubah-Kata-Sandi">Ubah Kata Sandi</a></li>
                                    <?php } ?>
                                    <li>
                                        <div class="d-flex bd-highlight">
                                            <div class="p-2 flex-grow-1 bd-highlight dropdown-item" style="margin-left: 15px;">Mode</div>
                                            <div class="p-2 bd-highlight">
                                                <div class="theme-toggle d-flex gap-2  align-items-center ">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                                        <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
                                                            <g transform="translate(-210 -1)">
                                                                <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                                                <circle cx="220.5" cy="11.5" r="4"></circle>
                                                                <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                    <div class="form-check form-switch fs-6">
                                                        <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                                                        <label class="form-check-label"></label>
                                                    </div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                                        <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="<?= base_url() ?>/Keluar">Keluar</a></li>
                                </ul>
                            </div>

                            <!-- Burger button responsive -->
                            <a href="#" class="burger-btn d-block d-xl-none">
                                <i class="bi bi-justify fs-3"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <nav class="main-navbar">
                    <div class="container">
                        <ul>
                            <!-- Menu Owner Start-->
                            <?php if (session()->get('Role') == 1) { ?>
                                <li class="menu-item  ">
                                    <a href="<?= base_url() ?>/" class='menu-link'>
                                        <span class="<?= (session()->get('NamaPage') == 'Beranda') ? 'fw-bold text-selected' : '' ?>"><i class="bi bi-house "></i> Beranda</span>
                                    </a>
                                </li>
                                <li class="menu-item  ">
                                    <a href="<?= base_url() ?>/Laporan-Produk" class='menu-link'>
                                        <span class="<?= (session()->get('NamaPage') == 'Laporan Produk') ? 'fw-bold text-selected' : '' ?>"><i class="bi bi-boxes "></i> Laporan Produk</span>
                                    </a>
                                </li>
                                <li class="menu-item  ">
                                    <a href="<?= base_url() ?>/Laporan-Transaksi" class='menu-link'>
                                        <span class="<?= (session()->get('NamaPage') == 'Laporan Transaksi') ? 'fw-bold text-selected' : '' ?>"><i class="bi bi-bag-plus "></i> Laporan Transaksi</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <!-- Menu Owner End-->

                            <!-- Menu Kasir Start-->
                            <?php if (session()->get('Role') == 2) { ?>
                                <!-- Staf Start -->
                                <?php if (session()->get('Position') == 2) { ?>
                                    <li class="menu-item  ">
                                        <a href="<?= base_url() ?>/" class='menu-link'>
                                            <span class="<?= (session()->get('NamaPage') == 'Transaksi') ? 'fw-bold text-selected' : '' ?>"><i class="bi bi-bag-plus "></i> Transaksi</span>
                                        </a>
                                    </li>
                                    <li class="menu-item  ">
                                        <a href="<?= base_url() ?>/Riwayat-Transaksi" class='menu-link'>
                                            <span class="<?= (session()->get('NamaPage') == 'Riwayat Transaksi') ? 'fw-bold text-selected' : '' ?>"><i class="bi bi-clock-history "></i> Riwayat Transaksi</span>
                                        </a>
                                    </li>

                                    <!-- Staf End -->
                                <?php  } else  if (session()->get('Position') == 3) { ?>
                                    <li class="menu-item  ">
                                        <a href="<?= base_url() ?>/" class='menu-link'>
                                            <span class="<?= (session()->get('NamaPage') == 'Beranda') ? 'fw-bold text-selected' : '' ?>"><i class="bi bi-house "></i> Beranda</span>
                                        </a>
                                    </li>
                                    <li class="menu-item  has-sub">
                                        <a href="#" class='menu-link'>
                                            <span class="<?= (session()->get('IconPage') == 'Transaksi') ? 'fw-bold text-selected' : '' ?>"><i class="bi bi-boxes"></i> Transaksi</span>
                                        </a>
                                        <div class="submenu ">
                                            <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                                            <div class="submenu-group-wrapper">
                                                <ul class="submenu-group">

                                                    <li class="submenu-item   ">
                                                        <a href="<?= base_url() ?>/Tambah-Transaksi" class='submenu-link <?= (session()->get('NamaPage') == 'Tambah-Transaksi') ? 'fw-bold text-selected' : '' ?>'>Tambah Transaksi</a>
                                                    </li>
                                                    <li class="submenu-item  ">
                                                        <a href="<?= base_url() ?>/Riwayat-Transaksi" class='submenu-link <?= (session()->get('NamaPage') == 'Riwayat Transaksi') ? 'fw-bold text-selected' : '' ?>'>Riwayat Transaksi</a>
                                                    </li>



                                                </ul>


                                            </div>
                                        </div>
                                    </li>
                                    <li class="menu-item  ">
                                        <a href="<?= base_url() ?>/Laporan-Transaksi" class='menu-link'>
                                            <span class="<?= (session()->get('NamaPage') == 'Laporan Transaksi') ? 'fw-bold text-selected' : '' ?>"><i class="bi bi-clipboard-pulse "></i> Laporan</span>
                                        </a>
                                    </li>
                                <?php  } ?>
                            <?php  } ?>
                            <!-- Menu Kasir End -->

                            <!-- Menu Administrator Start -->
                            <?php if (session()->get('Role') == 3) { ?>
                                <li class="menu-item  ">
                                    <a href="<?= base_url() ?>/" class='menu-link'>
                                        <span class="<?= (session()->get('NamaPage') == 'Beranda') ? 'fw-bold text-selected' : '' ?>"><i class="bi bi-house "></i> Beranda</span>
                                    </a>
                                </li>
                                <li class="menu-item  has-sub">
                                    <a href="#" class='menu-link'>
                                        <span class="<?= (session()->get('IconPage') == 'Produk') ? 'fw-bold text-selected' : '' ?>"><i class="bi bi-boxes"></i> Produk</span>
                                    </a>
                                    <div class="submenu ">
                                        <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                                        <div class="submenu-group-wrapper">
                                            <ul class="submenu-group">

                                                <li class="submenu-item   ">
                                                    <a href="<?= base_url() ?>/Tambah-Produk" class='submenu-link <?= (session()->get('NamaPage') == 'Tambah Produk') ? 'fw-bold text-selected' : '' ?>'>Tambah Produk</a>
                                                </li>
                                                <li class="submenu-item  ">
                                                    <a href="<?= base_url() ?>/Produk" class='submenu-link <?= (session()->get('NamaPage') == 'Produk') ? 'fw-bold text-selected' : '' ?>'>List Produk</a>
                                                </li>

                                                <li class="submenu-item  line-in-dropdwon-header">
                                                    <HR>
                                                    </HR>
                                                </li>
                                                <li class="submenu-item  ">
                                                    <a href="<?= base_url() ?>/Jenis-Produk" class='submenu-link <?= (session()->get('NamaPage') == 'Jenis Produk') ? 'fw-bold text-selected' : '' ?>'>Data Jenis Produk</a>
                                                </li>
                                                <li class="submenu-item  ">
                                                    <a href="<?= base_url() ?>/Bahan-Produk" class='submenu-link <?= (session()->get('NamaPage') == 'Bahan Produk') ? 'fw-bold text-selected' : '' ?>'>Data Bahan Produk</a>
                                                </li>

                                            </ul>


                                        </div>
                                    </div>
                                </li>

                                <li class="menu-item  has-sub">
                                    <a href="#" class='menu-link'>
                                        <span class="<?= (session()->get('IconPage') == 'Karyawan') ? 'fw-bold text-selected' : '' ?>"><i class="bi bi-person-badge"></i> Karyawan</span>
                                    </a>
                                    <div class="submenu ">
                                        <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                                        <div class="submenu-group-wrapper">
                                            <ul class="submenu-group">

                                                <li class="submenu-item  <?= (session()->get('NamaPage') == 'Tambah Karyawan') ? 'fw-bold text-selected' : '' ?>">
                                                    <a href="<?= base_url() ?>/Tambah-Karyawan" class='submenu-link'>Tambah Karyawan</a>
                                                </li>
                                                <li class="submenu-item  <?= (session()->get('NamaPage') == 'Karyawan') ? 'fw-bold text-selected' : '' ?>">
                                                    <a href="<?= base_url() ?>/Karyawan" class='submenu-link'>List Karyawan</a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="menu-item  has-sub">
                                    <a href="#" class='menu-link'>
                                        <span class="
                                        <?= (session()->get('IconPage') == 'Pelanggan') ? 'fw-bold text-selected' : '' ?>
                                        "><i class="bi bi-people"></i> Pelanggan</span>
                                    </a>
                                    <div class="submenu ">
                                        <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                                        <div class="submenu-group-wrapper">
                                            <ul class="submenu-group">

                                                <li class="submenu-item  <?= (session()->get('NamaPage') == 'Tambah Pelanggan') ? 'fw-bold text-selected' : '' ?>">
                                                    <a href="<?= base_url() ?>/Tambah-Pelanggan" class='submenu-link'>Tambah Pelanggan</a>
                                                </li>
                                                <li class="submenu-item   <?= (session()->get('NamaPage') == 'Pelanggan') ? 'fw-bold text-selected' : '' ?>">
                                                    <a href="<?= base_url() ?>/Pelanggan" class='submenu-link'>List Pelanggan</a>
                                                </li>

                                            </ul>


                                        </div>
                                    </div>
                                </li>
                                <!--                                 
                                <li class="menu-item  has-sub">
                                    <a href="#" class='menu-link'>
                                        <span class="<?= (session()->get('IconPage') == 'Lainnya') ? 'fw-bold' : '' ?>"><i class="bi bi-grid-3x3-gap"></i> Lainnya</span>
                                    </a>
                                    <div class="submenu ">
                                      
                                        <div class="submenu-group-wrapper">
                                            <ul class="submenu-group">

                                                <li class="submenu-item  <?= (session()->get('NamaPage') == 'Metode Bayar') ? 'fw-bold ' : '' ?>">
                                                    <a href="<?= base_url() ?>/Metode-Bayar" class='submenu-link'>Metode Bayar</a>
                                                </li>


                                            </ul>
                                        </div>
                                    </div>
                                </li> -->

                            <?php } ?>
                            <!-- Menu Administrator End -->



                        </ul>
                    </div>
                </nav>

            </header>