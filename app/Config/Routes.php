<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

#region Login
$routes->get('/', 'C_Login::index');
$routes->get('/Profil', 'C_Login::account');
$routes->get('/Ubah-Kata-Sandi', 'C_Login::changePassword');
$routes->get('/Masuk', 'C_Login::index');
$routes->post('/Auth', 'C_Login::AuthLogin');
$routes->get('/Keluar', 'C_Login::Logout');
#endregion
#region Role Staf- Admin
$routes->get('/Beranda', 'C_Home::index');

#region Pelanggan
$routes->get('/Pelanggan', 'C_Pelanggan::index');
$routes->get('/Tambah-Pelanggan', 'C_Pelanggan::FromCustomer');
$routes->get('/Edit-Pelanggan' . '/(:any)', 'C_Pelanggan::EditCustomer/$1');
$routes->post('/SavePelanggan', 'C_Pelanggan::SavePelanggan');
$routes->post('/SavePelangganTransaksi', 'C_Pelanggan::SavePelangganTransaksi');
$routes->post('/UpdatePelanggan', 'C_Pelanggan::UpdatePelanggan');
$routes->get('/Informasi-Pelanggan' . '/(:any)', 'C_Pelanggan::InfoPelanggan/$1');
#endregion

#region Employee
$routes->get('/Karyawan', 'C_Employee::index');
$routes->get('/Tambah-Karyawan', 'C_Employee::FromEmployee');
$routes->post('/SaveEmployee', 'C_Employee::SaveEmployee');
$routes->post('/updateEmployee', 'C_Employee::updateEmployee');
$routes->get('/Edit-Karyawan' . '/(:any)', 'C_Employee::EditEmployee/$1');
$routes->get('/Informasi-Karyawan' . '/(:any)', 'C_Employee::InfoEmployee/$1');

#endregion

#region Data Jenis Produk
$routes->get('/Jenis-Produk', 'C_Product::listTypeProduct');
$routes->post('/SaveDataTypeProduct', 'C_Product::SaveDataTypeProducts');
$routes->post('/UpdateDataTypeProduct', 'C_Product::UpdateDataTypeProduct');
#endregion

#region Data Bahan Produk
$routes->get('/Bahan-Produk', 'C_Product::listMaretrialProduct');
$routes->post('/SaveDataMaterialProduct', 'C_Product::SaveDataMaterialProduct');
$routes->post('/UpdateDataMaterialProduct', 'C_Product::UpdateDataMaterialProduct');
#endregion

#region Data Produk
$routes->get('/Produk', 'C_Product::index');
$routes->get('/Tambah-Produk', 'C_Product::FromAddProduct');
$routes->get('/Kustom-Harga-Produk' . '/(:any)', 'C_Product::FormCustomPrice/$1');
$routes->get('/Edit-Produk' . '/(:any)', 'C_Product::formEditProduct/$1');
$routes->post('/saveProduct', 'C_Product::saveProduct');
$routes->post('/saveEditProduct', 'C_Product::saveEditProduct');
$routes->get('/Laporan-Produk', 'C_Product::ReportProduk');
$routes->get('/Informasi-Produk' . '/(:any)', 'C_Product::InfoProduk/$1');
// $routes->post('/UpdateDataMaterialProduct', 'C_Product::UpdateDataMaterialProduct');
#endregion

#region Payment Method
$routes->get('/Metode-Bayar', 'C_PaymentMethod::index');
$routes->post('/SaveDataMethodPayment', 'C_PaymentMethod::SaveDataMethodPayment');
$routes->post('/EditDataMethodPayment', 'C_PaymentMethod::EditDataMethodPayment');
#endregion

#endregion
#region Kasir - Staf
$routes->get('/Transaksi', 'C_Transaction::index');
$routes->get('/Tambah-Transaksi', 'C_Transaction::NewTransaction');
$routes->get('/Riwayat-Transaksi', 'C_Transaction::HistoryTrans');
$routes->get('/Laporan-Transaksi', 'C_Transaction::ReportTrans');
$routes->get('/Detail-Transaksi/(:any)', 'C_Transaction::DetailTrans/$1');
$routes->get('/Edit-Transaksi/(:any)', 'C_Transaction::EditTrans/$1');
$routes->get('/Nota-Transaksi/(:any)', 'C_Transaction::PrintNota/$1');
$routes->post('/addTransaksi', 'C_Transaction::addTransaction');
$routes->post('/addToCart', 'C_Transaction::addToCart');
$routes->post('/updateToCart', 'C_Transaction::updateToCart');
$routes->post('/deleteToCart', 'C_Transaction::deleteToCart');
$routes->post('/cancelTrasaction', 'C_Transaction::cancelTrasaction');
$routes->post('/savingTrasaction', 'C_Transaction::savingTrasaction');
$routes->post('/paymentTransaction', 'C_Transaction::paymentTransaction');
$routes->post('/paymentTransactionDebt', 'C_Transaction::paymentTransactionDebt');
#endregion

#region Error
$routes->get('/Error', 'C_Home::error');
#endregion

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
