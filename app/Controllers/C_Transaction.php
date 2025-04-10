<?php

namespace App\Controllers;

use App\Models\Activity\M_ActivityProduct;
use App\Models\Activity\M_ActivityQueueTransaction;
use App\Models\Activity\M_ActivityTransaction;
use App\Models\Master\M_Customer;
use App\Models\Master\M_CustomerPriceProduct;
use App\Models\Master\M_Employee;
use App\Models\Master\M_PaymentMethod;
use App\Models\Master\M_PriceProduct;
use App\Models\Master\M_Product;
use App\Models\Master\M_Status_Transaction;
use App\Models\Transaction\T_DetailTransactionManual;
use App\Models\Transaction\T_TransactionManual;
use CodeIgniter\HTTP\Header;
use CodeIgniter\HTTP\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_Transaction extends BaseController
{
    protected $M_Customer;
    protected $M_Product;
    protected $M_Employee;
    protected $M_PriceProduct;
    protected $M_CustomerPriceProduct;
    protected $T_TransaksiManual;
    protected $T_DetailTransactionManual;
    protected $M_PaymentMethod;
    protected $C_Activity;
    protected $M_Status_Transaksi;
    protected $databases;
    protected $M_ActivityTransaction;
    protected $M_ActivityTransactionQueue;
    protected $M_ActivityProduk;
    public function __construct()
    {
        $this->M_Customer = new M_Customer();
        $this->M_Employee = new M_Employee();
        $this->T_TransaksiManual = new T_TransactionManual();
        $this->T_DetailTransactionManual = new T_DetailTransactionManual();
        $this->C_Activity = new C_Activity();
        $this->M_Product = new M_Product();
        $this->M_PriceProduct = new M_PriceProduct();
        $this->M_CustomerPriceProduct = new M_CustomerPriceProduct();
        $this->M_PaymentMethod = new M_PaymentMethod();
        $this->M_ActivityTransaction = new M_ActivityTransaction();
        $this->M_ActivityTransactionQueue = new M_ActivityQueueTransaction();
        $this->M_Status_Transaksi = new M_Status_Transaction();
        $this->M_ActivityProduk = new M_ActivityProduct();
        $this->databases = \Config\Database::connect();
        // $this->load->library('PDF');
    }
    public function index()
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));
            if (session()->get('Position') == '3') {
                return  redirect()->to(base_url('/Beranda'));
            } else  if (session()->get('Position') == '2') {
                $setData = [
                    'NamaPage' => 'Transaksi',
                    'IconPage' => 'Transaksi'
                ];
                $this->C_Activity->LastActiveUser();
                session()->set($setData);
                return view('Transaction/V_Transaction');
            }
        } else {
            return  redirect()->to(base_url('/'));
        }
    }
    public function NewTransaction()
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));
            if (session()->get('Position') == '2') {
                return  redirect()->to(base_url('/Beranda'));
            } else  if (session()->get('Position') == '3') {
                $setData = [
                    'NamaPage' => 'Tambah-Transaksi',
                    'IconPage' => 'Transaksi'
                ];
                $this->C_Activity->LastActiveUser();
                session()->set($setData);
                return view('Transaction/V_Transaction');
            }
        } else {
            return  redirect()->to(base_url('/'));
        }
    }
    public function HistoryTrans()
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));
            $queryHistorty = '';
            $isQueryHistory = 0;
            if (session()->get('NamaPage') == 'Detail Transaksi' || session()->get('NamaPage') == 'Edit Transaksi') {
                $queryHistorty =  session()->get('QueryHistorty');
                $isQueryHistory = 1;
            }


            $this->C_Activity->LastActiveUser();
            if (session()->get('Position') == 3) {
                $setData = [
                    'NamaPage' => 'Riwayat Transaksi',
                    'IconPage' => 'Transaksi',
                    'QueryHistorty' =>  $queryHistorty,
                    'isQueryHistory' =>  $isQueryHistory
                ];
                session()->set($setData);
                return view('Transaction/V_HistoryTransactionManager');
            } else {
                $setData = [
                    'NamaPage' => 'Riwayat Transaksi',
                    'IconPage' => 'Riwayat Transaksi',
                    'QueryHistorty' =>  $queryHistorty,
                    'isQueryHistory' =>  $isQueryHistory
                ];
                session()->set($setData);
                return view('Transaction/V_HistoryTransaction');
            }
        } else {
            return  redirect()->to(base_url('/'));
        }
    }

    public function ReportTrans()
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));

            $setData = [
                'NamaPage' => 'Laporan Transaksi',
                'IconPage' => 'Laporan Transaksi'
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();

            if (session()->get('Role') == 1) {
                return view('Transaction/V_ReportTrasactionOwner');
            } else if (session()->get('Role') == 2) {
                return view('Transaction/V_ReportTrasactionManager');
            }
            // if (session()->get('Position') == 3) {
            // } else {

            //     return view('Transaction/V_HistoryTransaction');
            // }
        } else {
            return  redirect()->to(base_url('/'));
        }
    }

    public function checkTransaction()
    {
        $userEmploye = session()->get('Username');
        $where = "t_transaction_manual.Username_Employee = '$userEmploye' AND t_transaction_manual.Status=1";
        echo json_encode($this->T_TransaksiManual->getDataJoin($where)->getResult('array'));
    }
    public function SetTransactionEdit()
    {
        $IdTrans = session()->get('IDTrans');
        $where = "t_transaction_manual.Number_Trans = '$IdTrans' AND t_transaction_manual.Status=2";
        echo json_encode($this->T_TransaksiManual->getDataJoin($where)->getResult('array'));
    }
    public function getTransaction()
    {
        if ($this->request->getVar('query') == '') {
            echo json_encode($this->T_TransaksiManual->getData());
        } else {

            echo json_encode($this->T_TransaksiManual->getData($this->request->getVar('query'))->getResult('array'));
        }
    }
    public function getCart()
    {
        // $where = [
        //     'Id_Transaction' => $this->request->getVar('Id')
        // ];
        $whereProdukAll = [
            'Status' => 1
        ];
        $resultPRodukAll = $this->M_Product->getData($whereProdukAll)->getResult('array');
        $where = "Id_Transaction = '" . $this->request->getVar('Id') . "' AND (Status = 10 OR Status = 7)";
        // $where = "Id_Transaction = '5e9cecc2-55bd-acdd-d859-2bedc283aa20' AND Status = 10";
        $resultData = $this->T_DetailTransactionManual->getData($where)->getResult('array');
        $data = array();
        $totalSemua = 0;
        $totalHutang = 0;
        $jumlahTundaProduk = 0;
        for ($i = 0; $i < count($resultData); $i++) {
            $whereProduk = [
                'm_product.Id' => $resultData[$i]['Id_Product']
            ];
            $whereTrans = [
                'Id' => $resultData[$i]['Id_Transaction']
            ];

            $resultTransaction = $this->T_TransaksiManual->getData($whereTrans)->getRow();
            $totalHutang = $resultTransaction->Total_Dept;
            $resultProduk = $this->M_Product->getDataJoin($whereProduk)->getRow();
            $resultKhususProduk = $this->M_Product->getDataJoin($whereProduk)->getRow();
            $harga = 0;
            $piece = 1;
            $status = 8;

            for ($j = 0; $j < count($resultPRodukAll); $j++) {
                if ($resultProduk->Id == $resultPRodukAll[$j]['Id']) {
                    // echo $resultPRodukAll[$j]['Name'] . " = " . $resultPRodukAll[$j]['Stock_Piece'] . " - ";
                    // echo  $resultData[$i]['Sum_Product_PerPiece'];
                    if ($resultPRodukAll[$j]['Stock_Piece'] >= $resultData[$i]['Sum_Product_PerPiece']) {
                        $temp2 = $resultPRodukAll[$j]['Stock_Piece'] - $resultData[$i]['Sum_Product_PerPiece'];
                        $resultPRodukAll[$j]['Stock_Piece'] = $temp2;
                        $status = 7;
                        // echo  $temp2;
                    } else {
                        $jumlahTundaProduk++;
                    }
                    // echo $resultPRodukAll[$j]['Stock_Piece'] . "<br>";
                }
                // echo "<br>";
            }

            // if ($resultProduk->Stock_Piece >= $resultData[$i]['Sum_Product_PerPiece']) {
            //     $status = 7;
            // }

            $wherePriceKhusus = [
                'm_customer_price_product.Id_Product' => $resultData[$i]['Id_Product'],
                'm_customer_price_product.Id_Customer' =>  $resultTransaction->IdCustomer,
                'pp.Status' =>  '1'
            ];
            $resultKhususProduk = $this->M_CustomerPriceProduct->getDataPriceTrans($wherePriceKhusus)->getRow();
            if ($resultKhususProduk == null) {
                if ($resultData[$i]['Unit_Product'] == 'Potong') {
                    $harga = $resultProduk->Per_Piece;
                    $piece = $resultData[$i]['Sum_Product_PerPiece'];
                } else  if ($resultData[$i]['Unit_Product'] == 'Lusin') {
                    $harga = $resultProduk->Per_Doze;
                    $piece =  $resultData[$i]['Sum_Product_PerPiece'] /  12;
                } else  if ($resultData[$i]['Unit_Product'] == 'Kodi') {
                    $harga = $resultProduk->Per_Kodi;
                    $piece =  $resultData[$i]['Sum_Product_PerPiece'] / 20;
                }
            } else {
                if ($resultData[$i]['Unit_Product'] == 'Potong') {
                    $harga = $resultKhususProduk->Potong;
                    $piece = $resultData[$i]['Sum_Product_PerPiece'];
                } else  if ($resultData[$i]['Unit_Product'] == 'Lusin') {
                    $harga = $resultKhususProduk->Lusin;
                    $piece = $resultData[$i]['Sum_Product_PerPiece'] / 12;
                } else  if ($resultData[$i]['Unit_Product'] == 'Kodi') {
                    $harga = $resultKhususProduk->Kodi;
                    $piece =  $resultData[$i]['Sum_Product_PerPiece'] / 20;
                }
            }


            $total = $harga * $piece;
            $totalSemua = $totalSemua + $total;
            $values = [
                'Name_Product' => $resultProduk->Name,
                'Price_Product' => $harga,
                'Unit_Product' => $resultData[$i]['Unit_Product'],
                'Status' => $status,
                'Sum_Product_PerPiece' => $resultData[$i]['Sum_Product_PerPiece'],
                'Id' => $resultData[$i]['Id'],
                'Id_Product' => $resultData[$i]['Id_Product'],
                'Id_Transaction' => $resultData[$i]['Id_Transaction'],
                'Total_Payment' =>  $total,
            ];
            array_push($data, $values);
        }
        $ra = [
            'Data' => $data,
            'SubTotal' => $totalSemua,
            'Total' => $totalSemua + $totalHutang,
            'Hutang' => $totalHutang,
            'Tunda' => $jumlahTundaProduk
        ];
        echo json_encode($ra);
        // echo json_encode($this->T_DetailTransactionManual->getData($where)->getResult('array'));
    }
    public function EditCart()
    {
        $result = $this->T_DetailTransactionManual->getData($this->request->getVar('query'))->getRow();
        $whereProduk = [
            'm_product.Id' => $result->Id_Product
        ];
        $resultProduk = $this->M_Product->getDataJoin($whereProduk)->getRow();
        $data = [
            'Produk' =>  $resultProduk,
            'TranSaction' =>  $result
        ];
        echo json_encode($data);
    }
    public function addTransaction()
    {
        if (session()->get('status') == TRUE) {
            $wherePelanggan = [
                'Id' => $this->request->getVar('Pelanggan')
            ];
            $whereGetHutang = [
                'IdCustomer' => $this->request->getVar('Pelanggan'),
                'Status' => 5
            ];
            $resultPelanggan = $this->M_Customer->getData($wherePelanggan)->getRow();
            $resultGetHutang = $this->T_TransaksiManual->getData($whereGetHutang)->getRow();
            $data = [];
            $dataHutang = [];
            $guidData = $this->createGuidData();
            if ($this->request->getVar('Hutang') == 0) {
                $data = [
                    'Id' => $guidData,
                    'Number_Trans' => 'R',
                    'Username_Employee' => session()->get('Username'),
                    'Operator' => session()->get('Username'),
                    'IdCustomer' => $this->request->getVar('Pelanggan'),
                    'Sum_Transaction' => 0,
                    'Payment' => 0,
                    'Sub_Total' => 0,
                    'Total_Dept' => 0,
                    'Total_Payment' => 0,
                    'Status' => 1,
                    'CreatedBy' => session()->get('Username'),
                    'ModifiedBy' => session()->get('Username')
                ];
            } else {
                $totalHUtang = (int) $resultGetHutang->Total_Payment - (int) $resultGetHutang->Payment;
                $data = [
                    'Id' => $guidData,
                    'Number_Trans' => 'R',
                    'Username_Employee' => session()->get('Username'),
                    'Operator' => session()->get('Username'),
                    'IdCustomer' => $this->request->getVar('Pelanggan'),
                    'Sum_Transaction' => 0,
                    'Payment' => 0,
                    'Sub_Total' => 0,
                    'Total_Dept' =>  $totalHUtang,
                    'Total_Payment' => $totalHUtang,
                    'Transc_continuance' => $resultGetHutang->Id,
                    'Status' => 1,
                    'CreatedBy' => session()->get('Username'),
                    'ModifiedBy' => session()->get('Username')
                ];
                $dataHutang = [
                    'Operator' => session()->get('Username'),
                    'Status' => 6,
                    'ModifiedBy' => session()->get('Username')
                ];
            }
            if (!$this->T_TransaksiManual->SaveDateCustom($data)) {
                if ($this->request->getVar('Hutang') != 0) {
                    $whereTransHUtang = [
                        'Id' => $resultGetHutang->Id
                    ];
                    $this->T_TransaksiManual->updateData($dataHutang, $whereTransHUtang);
                }
                $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Menambahkan Data Transaksi ' . $guidData, 1, 'Transaksi');
                $this->C_Activity->SetLogTransaction($guidData, 'Berhasil Menambahkan Transaksi', 17, null, 0, 0, 0, 1);
                $whereResult = [
                    'Id' => $guidData
                ];
                $dataResult = [
                    'kondisi' => 1,
                    'data' => $this->T_TransaksiManual->getData($whereResult)->getRow()
                ];
                echo json_encode($dataResult);
            } else {
                $this->C_Activity->SetLogTransaction($guidData, 'Gagal Menambahkan Data Transaksi', 17, null, 0, 0, 0, 0);
                $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menambahkan Data Transaksi ', 0, 'Transaksi');
                $dataResult = [
                    'kondisi' => 0,
                    'data' => null
                ];
                echo json_encode($dataResult);
            }
            // $dataResult = [
            //     'kondisi' => 0,
            //     'data' => null
            // ];
            // echo json_encode($dataResult);
        } else {
            $dataResult = [
                'kondisi' => 2,
                'data' => null
            ];
            echo json_encode($dataResult);
        }
    }

    public function addToCart()
    {
        if (session()->get('status') == TRUE) {
            $whereTransaksi = [
                'Number_Trans' => $this->request->getVar('idTrans')
            ];
            $resultTransaksi = $this->T_TransaksiManual->getData($whereTransaksi)->getRow();
            $statusTrans = 10;
            if ($resultTransaksi->Status == 2) {
                $statusTrans = 7;
            }
            $whereProduct = [
                'Id' => $this->request->getVar('IdProduct')
            ];
            $resultProduct = $this->M_Product->getData($whereProduct)->getRow();

            $wherePriceProduct = [
                'Id' => $this->request->getVar('IdProductPrice')
            ];
            $resultPriceProduct = $this->M_PriceProduct->getData($wherePriceProduct)->getRow();
            $whereCheckProdukCart = [
                'Id_Transaction' =>   $resultTransaksi->Id,
                'Id_Product' => $this->request->getVar('IdProduct'),
                'Unit_Product' => $this->request->getVar('Satuan')
            ];
            $resultCheckProductCart = $this->T_DetailTransactionManual->getData($whereCheckProdukCart)->getRow();

            $whereCartTransaction = [
                'Id_Transaction' =>   $resultTransaksi->Id,
            ];

            $kondisiCart = 1; //sudah ada


            $sumUnit = 1;
            if ($this->request->getVar('Satuan') == 'Lusin') {
                $sumUnit = 12;
            } else if ($this->request->getVar('Satuan') == 'Kodi') {
                $sumUnit = 20;
            }
            $realSumSebagian = 0;
            $realSum = 0;
            $tempSum = 0;
            $status;
            $dataProduk = [];

            $guidData = $this->createGuidData();
            $NamePrice = 'Normal';
            $Price = 0;

            $total = 0;
            $totalSebagian = 0;


            if ($resultCheckProductCart != null) {
                $realSumSebagian = ((int) $this->request->getVar('Jumlah')) * $sumUnit;
                $realSum = (int) $resultCheckProductCart->Sum_Product_PerPiece + ((int) $this->request->getVar('Jumlah') * $sumUnit);
            } else {
                $kondisiCart = 0; //belum ada

                $realSum = ((int) $this->request->getVar('Jumlah')) * $sumUnit;
            }


            $data = [
                'Id' => $guidData,
                'Id_Transaction' => $resultTransaksi->Id,
                'Id_Product' => $resultProduct->Id,

                // 'Id_Price_Product' => $this->request->getVar('IdProductPrice'),
                // 'Name_Price' => $NamePrice,
                'Type_Transaction' => 'Manual',
                'Unit_Product' => $this->request->getVar('Satuan'),
                'Price_Product' => 0,
                'Sum_Product_PerPiece' =>   $realSum,
                'Sum_Temporary_PerPiece' => 0,
                'Total_Payment' =>  0,
                'Status' =>  $statusTrans,
                'CreatedBy' => session()->get('Username'),
                'ModifiedBy' => session()->get('Username'),
            ];
            // $subTotal = $resultTransaksi->Sub_Total + $total;
            $dataTransaksi = [
                'Sum_Transaction' => ($resultTransaksi->Sum_Transaction + 1)
                // 'Sub_Total' =>  $subTotal,
                // 'Total_Payment' => ($resultTransaksi->Total_Payment + $total),
            ];
            if ($kondisiCart == 1) {
                $data = [

                    // 'Id_Price_Product' => $this->request->getVar('IdProductPrice'),
                    // 'Name_Price' => $NamePrice,
                    'Type_Transaction' => 'Manual',
                    'Unit_Product' => $this->request->getVar('Satuan'),
                    'Price_Product' => 0,
                    'Sum_Product_PerPiece' =>   $realSum,
                    'Sum_Temporary_PerPiece' => 0,
                    'Total_Payment' => 0,
                    'Status' =>  $statusTrans,
                    'ModifiedBy' => session()->get('Username'),
                ];
            }
            if ($kondisiCart == 1) {
                $whereUpdateCart = [
                    'Id' => $resultCheckProductCart->Id
                ];
                if ($this->T_DetailTransactionManual->updateData($data, $whereUpdateCart)) {
                    $resultCartTransaction = $this->T_DetailTransactionManual->getData($whereCartTransaction)->getResult('array');
                    $sumTotal = 0;
                    $sumProduk = count($resultCartTransaction);
                    for ($i = 0; $i < count($resultCartTransaction); $i++) {
                        $sumTotal = $sumTotal + (int) $resultCartTransaction[$i]['Total_Payment'];
                    }
                    $dataTransaksi = [
                        'Sum_Transaction' => $sumProduk,
                        // 'Sub_Total' =>  $sumTotal,
                        // 'Total_Payment' => ($resultTransaksi->Total_Dept + $sumTotal),
                    ];
                    $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Update Data Produk Transaksi ' . $resultTransaksi->Id, 1, 'Transaksi');
                    $this->C_Activity->SetLogTransaction($resultTransaksi->Id, 'Berhasil Update Data Produk Transaksi', 15, null, 0, 0, 0, 1);
                    // $this->M_Product->updateData($dataProduk, $whereProduct);
                    $this->T_TransaksiManual->updateData($dataTransaksi, $whereTransaksi);
                    echo json_encode(1);
                } else {
                    $this->C_Activity->SetLogTransaction($resultTransaksi->Id, 'Gagal Update Data Produk Transaksi', 15, null, 0, 0, 0, 0);
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menambahkan Data Produk Transaksi ' . $resultTransaksi->Id, 0, 'Transaksi');
                    echo json_encode(0);
                }
            } else {
                if (!$this->T_DetailTransactionManual->saveData($data)) {
                    $resultCartTransaction = $this->T_DetailTransactionManual->getData($whereCartTransaction)->getResult('array');
                    $sumTotal = 0;
                    $sumProduk = count($resultCartTransaction);
                    for ($i = 0; $i < count($resultCartTransaction); $i++) {
                        $sumTotal = $sumTotal + (int) $resultCartTransaction[$i]['Total_Payment'];
                    }
                    $dataTransaksi = [
                        'Sum_Transaction' => $sumProduk,
                        // 'Sub_Total' =>  $sumTotal,
                        // 'Total_Payment' => ($resultTransaksi->Total_Dept + $sumTotal),
                    ];
                    $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Menambahkan Data Produk Transaksi ' . $resultTransaksi->Id, 1, 'Transaksi');
                    $this->C_Activity->SetLogTransaction($resultTransaksi->Id, 'Berhasil Menambahkan Data Produk Transaksi', 15, null, 0, 0, 0, 1);
                    // $this->M_Product->updateData($dataProduk, $whereProduct);
                    $this->T_TransaksiManual->updateData($dataTransaksi, $whereTransaksi);
                    echo json_encode(1);
                } else {
                    $this->C_Activity->SetLogTransaction($resultTransaksi->Id, 'Gagal Menambahkan Data Produk Transaksi', 15, null, 0, 0, 0, 0);
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menambahkan Data Produk Transaksi ' . $resultTransaksi->Id, 0, 'Transaksi');
                    echo json_encode(0);
                }
            }
        } else {
            echo json_encode(2);
        }
    }

    public function updateToCart()
    {
        if (session()->get('status') == TRUE) {
            $whereTransaksi = [
                'Number_Trans' => $this->request->getVar('idTrans')
            ];
            $resultTransaksi = $this->T_TransaksiManual->getData($whereTransaksi)->getRow();
            $whereTransDetail = [
                'Id_Product' => $this->request->getVar('IdProduct'),
                'Id_Transaction' => $resultTransaksi->Id,
                'Unit_Product' => $this->request->getVar('Satuan'),
                'Status' => 10
            ];
            $dataTrans = [
                'ModifiedBy' => session()->get('Username'),
            ];
            $piece = 1;
            if ($this->request->getVar('Satuan') == "Lusin") {
                $piece = 12;
            } else if ($this->request->getVar('Satuan') == "Kodi") {
                $piece = 20;
            }
            $resultTransDetail = $this->T_DetailTransactionManual->getData($whereTransDetail)->getRow();
            if ($resultTransDetail != null) {
                if ($resultTransDetail->Id != $this->request->getVar('IdTransDetail')) {
                    $dataTrans = [
                        'Sum_Transaction' => $resultTransaksi->Sum_Transaction - 1,
                        'ModifiedBy' => session()->get('Username'),
                    ];
                    $sumData = $resultTransDetail->Sum_Product_PerPiece + ($this->request->getVar('Jumlah') * $piece);
                    $dataNew = [
                        'Sum_Product_PerPiece' =>  $sumData,
                        'ModifiedBy' => session()->get('Username'),
                    ];
                    $whereDataNew = [
                        'Id' => $resultTransDetail->Id
                    ];
                    $dataOld = [
                        'Status' =>  9,
                        'ModifiedBy' => session()->get('Username'),
                    ];
                    $whereDataOld = [
                        'Id' => $this->request->getVar('IdTransDetail')
                    ];
                    if ($this->T_DetailTransactionManual->updateData($dataNew, $whereDataNew)) {
                        $this->T_DetailTransactionManual->hapus($whereDataOld);
                        $this->T_TransaksiManual->updateData($dataTrans, $whereTransaksi);
                        $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Memperbarui Data Produk Transaksi ' .  $resultTransDetail->Id_Transaction, 1, 'Transaksi');
                        $this->C_Activity->SetLogTransaction($resultTransDetail->Id_Transaction, 'Berhasil Memperbarui Data Produk Transaksi', 19, null, 0, 0, 0, 1);
                        echo json_encode(1);
                    } else {
                        $this->C_Activity->SetLogTransaction($resultTransDetail->Id_Transaction, 'Gagal Memperbarui Data Produk Transaksi', 19, null, 0, 0, 0, 0);
                        $this->C_Activity->Employee(session()->get('Username'), 'Gagal Memperbarui Data Produk Transaksi ' . $resultTransaksi->Id, 0, 'Transaksi');
                        echo json_encode(0);
                    }
                } else {
                    $whereData = [
                        'Id' => $this->request->getVar('IdTransDetail')
                    ];
                    // $SumProduct = $resultTransDetail->Sum_Product_PerPiece +
                    $data = [
                        'Sum_Product_PerPiece' =>   (int) $this->request->getVar('Jumlah') * $piece,
                        'ModifiedBy' => session()->get('Username'),
                    ];
                    if ($this->T_DetailTransactionManual->updateData($data, $whereData)) {
                        $this->T_TransaksiManual->updateData($dataTrans, $whereTransaksi);
                        $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Memperbarui Data Produk Transaksi ' .  $resultTransDetail->Id_Transaction, 1, 'Transaksi');
                        $this->C_Activity->SetLogTransaction($resultTransDetail->Id_Transaction, 'Berhasil Memperbarui Data Produk Transaksi', 19, null, 0, 0, 0, 1);
                        echo json_encode(1);
                    } else {
                        $this->C_Activity->SetLogTransaction($resultTransDetail->Id_Transaction, 'Gagal Memperbarui Data Produk Transaksi', 19, null, 0, 0, 0, 0);
                        $this->C_Activity->Employee(session()->get('Username'), 'Gagal Memperbarui Data Produk Transaksi ' . $resultTransaksi->Id, 0, 'Transaksi');
                        echo json_encode(0);
                    }
                }
            } else {
                $whereData = [
                    'Id' => $this->request->getVar('IdTransDetail')
                ];
                // $SumProduct = $resultTransDetail->Sum_Product_PerPiece +
                $data = [
                    'Unit_Product' => $this->request->getVar('Satuan'),
                    'Sum_Product_PerPiece' =>   (int) $this->request->getVar('Jumlah') * $piece,
                    'ModifiedBy' => session()->get('Username'),
                ];
                if ($this->T_DetailTransactionManual->updateData($data, $whereData)) {
                    $this->T_TransaksiManual->updateData($dataTrans, $whereTransaksi);
                    $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Memperbarui Data Produk Transaksi ' . $resultTransaksi->Id, 1, 'Transaksi');
                    $this->C_Activity->SetLogTransaction($resultTransaksi->Id, 'Berhasil Memperbarui Data Produk Transaksi', 19, null, 0, 0, 0, 1);
                    echo json_encode(1);
                } else {
                    $this->C_Activity->SetLogTransaction($resultTransaksi->Id, 'Gagal Memperbarui Data Produk Transaksi', 19, null, 0, 0, 0, 0);
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Memperbarui Data Produk Transaksi ' . $resultTransaksi->Id, 0, 'Transaksi');
                    echo json_encode(0);
                }
                // echo json_encode();
            }
            // echo json_encode($this->T_DetailTransactionManual->getData($whereTransDetail));
        } else {
            echo json_encode(2);
        }
    }

    public function cancelTrasaction()
    {
        if (session()->get('status') == TRUE) {
            $whereTrans = [
                'Number_Trans' => $this->request->getVar('idTrans')
            ];
            $resultTrans = $this->T_TransaksiManual->getData($whereTrans)->getRow();
            $dataTrans = [
                'Status' => 3,
                'Sum_Transaction' => 0,
                'Sub_Total' => 0,
                'Payment' => 0,
                'Total_Dept' => 0,
                'Total_Payment' => 0,
                'Transc_continuance' => null,
                'ModifiedBy' => session()->get('Username'),
                'Operator' => session()->get('Username')
            ];
            $dataTransHutang = [
                'Operator' => session()->get('Username'),
                'Status' => 5,
                'ModifiedBy' => session()->get('Username')
            ];
            $whereTransHutang = [
                'Id' => $resultTrans->Transc_continuance,
            ];
            $hutangTrans = 0;
            if ($resultTrans->Transc_continuance != null) {
                $hutangTrans = 1;
            }

            $whereTransDetail = [
                'Id_Transaction' => $resultTrans->Id
            ];

            if ($this->T_TransaksiManual->updateData($dataTrans, $whereTrans)) {

                if ($hutangTrans == 1) {
                    $this->T_TransaksiManual->updateData($dataTransHutang, $whereTransHutang);
                }
                $this->T_DetailTransactionManual->hapus($whereTransDetail);
                $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Membatalkan Transaksi ' .  $resultTrans->Id, 1, 'Transaksi');
                $this->C_Activity->SetLogTransaction($resultTrans->Id, 'Berhasil Membatalkan Transaksi', 18, null, 0, 0, 0, 1);
                echo json_encode(1);
            } else {
                $this->C_Activity->SetLogTransaction($resultTrans->Id, 'Gagal Membatalkan Transaksi', 18, null, 0, 0, 0, 0);
                $this->C_Activity->Employee(session()->get('Username'), 'Gagal Membatalkan Transaksi ' . $resultTrans->Id, 0, 'Transaksi');
                echo json_encode(0);
            }
        } else {
            echo json_encode(2);
        }
    }

    public function deleteToCart()
    {
        if (session()->get('status') == TRUE) {
            $whereTransDetail = [
                'Id' => $this->request->getVar('IdTransDetail')
            ];

            $resultTransDetail = $this->T_DetailTransactionManual->getData($whereTransDetail)->getRow();
            $whereMainTrans = [
                'Id' => $resultTransDetail->Id_Transaction
            ];
            if ($this->T_DetailTransactionManual->hapus($whereTransDetail)) {
                $whereDetailTransAfter = [
                    'Id_Transaction' => $resultTransDetail->Id_Transaction
                ];
                $resultAfter = $this->T_DetailTransactionManual->getData($whereDetailTransAfter)->getResult('array');
                $DataTrans = [
                    'Sum_Transaction' => count($resultAfter)
                ];
                $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Menghapus Data Produk Transaksi ' .  $resultTransDetail->Id_Transaction, 1, 'Transaksi');
                $this->C_Activity->SetLogTransaction($resultTransDetail->Id_Transaction, 'Berhasil Menghapus Data Produk Transaksi', 20, null, 0, 0, 0, 1);
                // $this->M_Product->updateData($dataProduk, $whereProduct);
                $this->T_TransaksiManual->updateData($DataTrans, $whereMainTrans);
                echo json_encode(1);
            } else {
                $this->C_Activity->SetLogTransaction($resultTransDetail->Id_Transaction, 'Gagal Menghapus Data Produk Transaksi', 20, null, 0, 0, 0, 0);
                $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menghapus Data Produk Transaksi ' . $resultTransaksi->Id, 0, 'Transaksi');
                echo json_encode(0);
            }
        } else {
            echo json_encode(2);
        }
    }

    public function savingTrasaction()
    {
        if (session()->get('status') == TRUE) {


            $whereTrans = [
                'Number_Trans' => $this->request->getVar('idTrans')
            ];
            $dataTrans = [

                'Status' => 2,
                'Operator' => session()->get('Username'),
                'ModifiedBy' => session()->get('Username'),
            ];
            $resultTrans = $this->T_TransaksiManual->getData($whereTrans)->getRow();
            $whereDetailTrans = [
                'Id_Transaction' => $resultTrans->Id,
                'Status' => 10
            ];
            $dataDetail = [
                'Status' => 7,
                'ModifiedBy' => session()->get('Username')
            ];
            if ($this->T_TransaksiManual->updateData($dataTrans, $whereTrans)) {
                $this->T_DetailTransactionManual->updateData($dataDetail, $whereDetailTrans);
                $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Menyimpan Data Produk Transaksi ' .  $resultTrans->Id, 1, 'Transaksi');
                $this->C_Activity->SetLogTransaction($resultTrans->Id, 'Berhasil Menyimpan Data Produk Transaksi', 21, null, 0, 0, 0, 1);
                // $this->M_Product->updateData($dataProduk, $whereProduct);
                echo json_encode(1);
            } else {
                $this->C_Activity->SetLogTransaction($resultTrans->Id, 'Gagal Menyimpan Data Produk Transaksi', 21, null, 0, 0, 0, 0);
                $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menyimpan Data Transaksi ' . $resultTrans->Id, 0, 'Transaksi');
                echo json_encode(0);
            }
        } else {
            echo json_encode(2);
        }
    }

    public function paymentTransaction()
    {
        if (session()->get('status') == TRUE) {

            $condition = 0;
            $cekRule = [];
            if ($this->request->getVar('typePayment') == '1') {
                $cekRule = [
                    'typePayment' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom jenis pembayaran harus dipilih'
                        ]
                    ],
                    'nominal' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom nominal pembayaran harus diisi',
                            // 'is_unique' => 'Jenis Produk Sudah Tersedia'
                        ]
                    ],
                    'ImageBUktiTF' => [
                        'rules' => 'uploaded[ImageBUktiTF]',
                        'errors' => [
                            'uploaded' => 'Kolom upload bukti pembayaran harus diisi'
                        ]
                    ]
                ];
            } else {
                $cekRule = [
                    'typePayment' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom jenis pembayaran harus dipilih'
                        ]
                    ],
                    'nominal' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom nominal pembayaran harus diisi',
                            // 'is_unique' => 'Jenis Produk Sudah Tersedia'
                        ]
                    ]
                ];
            }
            // $dataError = [];
            // echo json_encode($this->validate($cekRule));

            if ($this->validate($cekRule)) {

                $usernames = session()->get('Username');
                $whereTrans = [
                    'Number_Trans' => $this->request->getVar('idTrans')
                ];
                $resultTrans = $this->T_TransaksiManual->getData($whereTrans)->getRow();
                $whereTransDetail = "Id_Transaction = '" . $resultTrans->Id . "' AND (Status = 10 OR Status =7)";
                $resultTransDetail = $this->T_DetailTransactionManual->getData($whereTransDetail)->getResult('array');
                $countFailed = 0;
                $dataActivity = array();
                $this->databases->transBegin();
                foreach ($resultTransDetail  as $row) {
                    if ($countFailed == 0) {
                        $NamePrice = 'Normal';
                        $IdPrice = 0;
                        $Unit = 1;
                        $whereProduct = [
                            'm_product.Id' => $row['Id_Product']
                        ];
                        $resultProduct = $this->M_Product->getDataJoin($whereProduct)->getRow();
                        $price = $resultProduct->Per_Piece;
                        if ($row['Unit_Product'] == "Lusin") {
                            $Unit = 12;
                            $price = $resultProduct->Per_Doze;
                        } else if ($row['Unit_Product'] == "Kodi") {
                            $Unit = 20;
                            $price = $resultProduct->Per_Kodi;
                        }
                        // Convert To Asli Stok Activity
                        $activityStok = $row['Sum_Product_PerPiece'];
                        if ($row['Unit_Product'] == "Lusin") {
                            $activityStok = (int) $row['Sum_Product_PerPiece'] / 12;
                        } else if ($row['Unit_Product'] == "Kodi") {
                            $activityStok = (int) $row['Sum_Product_PerPiece'] / 20;
                        }

                        $wherePriceKhusus = [
                            'm_customer_price_product.Id_Product' => $row['Id_Product'],
                            'm_customer_price_product.Id_Customer' =>  $resultTrans->IdCustomer,
                            'pp.Status' =>  '1'
                        ];
                        $resultKhususProduk = $this->M_CustomerPriceProduct->getDataPriceTrans($wherePriceKhusus)->getRow();
                        if ($resultKhususProduk != null) {
                            $IdPrice =  $resultKhususProduk->IdHarga;
                            $wherePriceSpesial2 = "Id = " . (int)$resultKhususProduk->IdHarga;
                            $resultPriceSpesial = $this->M_PriceProduct->getData($wherePriceSpesial2)->getRow();
                            $NamePrice =   $resultPriceSpesial->Name;
                            $price = $resultPriceSpesial->Per_Piece;
                            if ($row['Unit_Product'] == "Lusin") {
                                $price = $resultPriceSpesial->Per_Dozen;
                            } else if ($row['Unit_Product'] == "Kodi") {
                                $price = $resultPriceSpesial->Per_Kodi;
                            }
                        }
                        $totalHarga = $price *  $activityStok;
                        $sisaProduct = $resultProduct->Stock_Piece - $row['Sum_Product_PerPiece'];
                        if ($sisaProduct < 0) {
                            $countFailed = $countFailed + 1;
                        } else {
                            $dataProduk = [
                                'Stock_Piece' => $sisaProduct,
                                'Stock' => $sisaProduct,
                                'ModifiedBy' => $usernames
                            ];

                            $dataActivityProduk = [
                                'Id_Product' => $row['Id_Product'],
                                'Status' => 4,
                                'Satuan' => $row['Unit_Product'],
                                'Stock' =>  $activityStok,
                                'Description' => 'Berhasil Mengurangi Stok Produk',
                                'CreatedBy' => session()->get('Username'),
                                'isDone' => 1,
                            ];
                            array_push($dataActivity, $dataActivityProduk);
                            // $this->databases->table('activity_product')->insert($dataActivityProduk);
                            $this->databases->table('m_product')->set($dataProduk)->where($whereProduct)->update();

                            // $this->databases->query("UPDATE m_product SET Stock_Piece= $sisaProduct, Stock =   $sisaProduct, ModifiedBy= '" . $usernames . "'
                            // WHERE Id = " . $row['Id_Product']);
                            $whereIDDetail = [
                                'Id' => $row['Id']
                            ];
                            $dataTransDetail = [
                                'Name_Product' =>  $resultProduct->Name,
                                'Size_Product' =>  $resultProduct->Size,
                                'Type_Product' =>  $resultProduct->Jenis,
                                'Meterial_Product' =>  $resultProduct->Bahan,
                                'Id_Price_Product' =>  $IdPrice,
                                'Name_Price' =>  $NamePrice,
                                'Price_Product' =>  $price,
                                'Total_Payment' =>  $totalHarga,
                                'Status' =>  8,
                                'ModifiedBy' =>  $usernames,
                            ];
                            $this->databases->table('t_detail_transaction_manual')->set($dataTransDetail)->where($whereIDDetail)->update();
                        }
                    }
                }

                if ($countFailed == 0) {
                    $this->databases->transCommit();

                    $whereTransDetail = "Id_Transaction = '" . $resultTrans->Id . "' AND (Status = 8)";
                    $resultTransDetail = $this->T_DetailTransactionManual->getData($whereTransDetail)->getResult('array');
                    $sumPrice = 0;
                    foreach ($resultTransDetail as $row) {
                        $sumPrice = $sumPrice + $row['Total_Payment'];
                    }
                    $grandTotal = $sumPrice + $resultTrans->Total_Dept;
                    $status = 4;
                    $sisa = 0;
                    $kembalianINT = 0;
                    $textKembali = 'Kembalian Pembayaran';
                    if ($this->request->getVar('nominal') == $grandTotal || $this->request->getVar('nominal') >= $grandTotal) {
                        $kembalianINT = $grandTotal -  (int) $this->request->getVar('nominal');
                        $sisa = 0;
                        $status = 4;
                    } else if ($grandTotal > (int) $this->request->getVar('nominal')) {
                        $kembalianINT = 0;
                        $sisa = $grandTotal -  (int) $this->request->getVar('nominal');
                        $status = 5;
                        // $textKembali = 'Sisa Pembayaran';
                    }
                    $dataTrans = [
                        'Operator' => session()->get('Username'),
                        'Sub_Total' => $sumPrice,
                        'Payment' => $this->request->getVar('nominal'),
                        'Total_Payment' => $grandTotal,
                        'Status' => $status,
                        'ModifiedBy' => session()->get('Username'),
                    ];
                    if ($this->T_TransaksiManual->updateData($dataTrans, $whereTrans)) {
                        $this->commitActivityProduk($dataActivity);
                        if ($this->request->getVar('typePayment') == '1') {
                            $img = $this->request->getFile('ImageBUktiTF');
                            $namaFoto = $img->getRandomName();
                            $locationBuktiTrans = 'Image/Transaction/' . $resultTrans->Number_Trans . '/' . $namaFoto;
                            $this->C_Activity->SetLogTransaction($resultTrans->Id, 'Berhasil Melakukan Pembayaran Transaksi', 16, $locationBuktiTrans, $this->request->getVar('nominal'), abs($sisa), abs($kembalianINT), 1);
                            $img->move('Image/Transaction/' . $resultTrans->Number_Trans, $namaFoto);
                        } else {
                            $this->C_Activity->SetLogTransaction($resultTrans->Id, 'Berhasil Melakukan Pembayaran Transaksi', 16, null, $this->request->getVar('nominal'), abs($sisa), abs($kembalianINT), 1);
                        }
                        $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Melakukan Pembayaran Transaksi ' .  $resultTrans->Id, 1, 'Transaksi');
                        $condition = 1;
                    } else {
                        $this->C_Activity->Employee(session()->get('Username'), 'Gagal Melakukan Pembayaran Transaksi ' .  $resultTrans->Id, 0, 'Transaksi');
                        $this->C_Activity->SetLogTransaction($resultTrans->Id, 'Gagal Melakukan Pembayaran Transaksi', 16, null, 0, 0, 0, 0);
                        $condition = 2;
                    }
                } else {
                    $this->databases->transRollback();
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Melakukan Pembayaran Transaksi ' .  $resultTrans->Id, 0, 'Transaksi');
                    $this->C_Activity->SetLogTransaction($resultTrans->Id, 'Gagal Melakukan Pembayaran Transaksi', 16, null, 0, 0, 0, 0);
                    $condition = 4;
                }
            }

            $dataResult = [
                'kondisi' =>  $condition,
                'error' => $this->validator->getErrors()
            ];
            echo json_encode($dataResult);
        } else {
            $dataResult = [
                'kondisi' => 3,
                'error' => null
            ];
            echo json_encode($dataResult);
        }
    }
    public function commitActivityProduk($data)
    {
        foreach ($data as $row) {
            $this->M_ActivityProduk->saveData($row);
        }
    }
    public function getStatusTransPay()
    {
        $title = 'Transaksi Sudah Lunas';
        $subTitle = 'Mohon Untuk melakukan muat ulang halaman agar data diperbarui';
        $status = 2;
        $whereTrans = [
            'Number_Trans' => session()->get('IDTrans')
        ];
        $resultTrans = $this->T_TransaksiManual->getData($whereTrans)->getRow();
        $whereQueue = [
            'Id_Transaction' =>  $resultTrans->Id,
            'Status' => 11
        ];
        $resultQueue = $this->M_ActivityTransactionQueue->getData($whereQueue)->getNumRows();
        if ($resultQueue > 0) {
            $title = 'Transaksi Sedang Berlangsung';
            $subTitle = 'Mohon ditunggu beberapa saat';
            $status = 0;
        } else {
            if ($resultTrans->Status == 4) {
                $title = 'Transaksi Sudah Lunas';
                $subTitle = 'Mohon Untuk melakukan muat ulang halaman agar data diperbarui';
                $status = 2;
            } else if ($resultTrans->Status == 5) {
                $title = '';
                $subTitle = '';
                $status = 1;
            }
        }
        $datas = [
            'title' => $title,
            'subtitle' => $subTitle,
            'status' => $status,
            'lastModif' =>  $resultTrans->ModifiedDate
        ];
        echo json_encode($datas);
    }

    public function paymentTransactionDebt()
    {
        if (session()->get('status') == TRUE) {
            $condition = 0;
            $cekRule = [];
            if ($this->request->getVar('typePayment') == '1') {
                $cekRule = [
                    'typePayment' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom jenis pembayaran harus dipilih'
                        ]
                    ],
                    'nominal' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom nominal pembayaran harus diisi',
                            // 'is_unique' => 'Jenis Produk Sudah Tersedia'
                        ]
                    ],
                    'ImageBUktiTF' => [
                        'rules' => 'uploaded[ImageBUktiTF]',
                        'errors' => [
                            'uploaded' => 'Kolom upload bukti pembayaran harus diisi'
                        ]
                    ]
                ];
            } else {
                $cekRule = [
                    'typePayment' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom jenis pembayaran harus dipilih'
                        ]
                    ],
                    'nominal' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom nominal pembayaran harus diisi',
                            // 'is_unique' => 'Jenis Produk Sudah Tersedia'
                        ]
                    ]
                ];
            }

            if ($this->validate($cekRule)) {
                $whereTrans = [
                    'Number_Trans' => session()->get('IDTrans')
                ];
                $resultTrans = $this->T_TransaksiManual->getData($whereTrans)->getRow();
                $dataInsert = [
                    'Id_Transaction' => $resultTrans->Id,
                    'Id_Session' => session()->get('SessionID'),
                    'Username' => session()->get('Username'),
                    'Status' => 11
                ];
                $data = [];
                $sisa = 0;
                $kembalianINT = 0;
                $textKembali = "Kembalian Pembayaran";
                $this->M_ActivityTransactionQueue->saveData($dataInsert);
                $whereQueue = [
                    'Id_Transaction' => $resultTrans->Id
                ];
                $resultQueue = $this->M_ActivityTransactionQueue->getLastData($whereQueue)->getResult('array');
                $idQueue = $resultQueue[0]['Id'];
                $whereUpdateQueue = [
                    'Id' => $idQueue
                ];
                $dataUpdateQueue = [
                    'Status' => '12'
                ];
                $total = $resultTrans->Total_Payment;
                if ($this->request->getVar('Kurang') == 1) {
                    $sisa = $total - ((int) $resultTrans->Payment + (int)$this->request->getVar('nominal'));
                    $kembalianINT = 0;
                    $textKembali = "Sisa Pembayaran";
                    $data = [
                        'Payment' => $resultTrans->Payment + $this->request->getVar('nominal'),
                        'ModifiedBy' => session()->get('Username')
                    ];
                } else {
                    $sisa = 0;
                    $kembalianINT = $total - ((int) $resultTrans->Payment + (int) $this->request->getVar('nominal'));
                    $data = [
                        'Payment' => $resultTrans->Payment + $this->request->getVar('nominal'),
                        'ModifiedBy' => session()->get('Username'),
                        'Status' => 4
                    ];
                }

                if ($this->T_TransaksiManual->updateData($data, $whereTrans)) {
                    if ($this->request->getVar('typePayment') == '1') {
                        $img = $this->request->getFile('ImageBUktiTF');
                        $namaFoto = $img->getRandomName();
                        $locationBuktiTrans = 'Image/Transaction/' . $resultTrans->Number_Trans . '/' . $namaFoto;
                        $this->C_Activity->SetLogTransaction($resultTrans->Id, 'Berhasil Melakukan Pembayaran Transaksi', 16, $locationBuktiTrans, $this->request->getVar('nominal'), abs($sisa), abs($kembalianINT), 1);
                        $img->move('Image/Transaction/' . $resultTrans->Number_Trans, $namaFoto);
                    } else {
                        $this->C_Activity->SetLogTransaction($resultTrans->Id, 'Berhasil Melakukan Pembayaran Transaksi', 16, null, $this->request->getVar('nominal'), abs($sisa), abs($kembalianINT), 1);
                    }
                    $this->M_ActivityTransactionQueue->updateData($dataUpdateQueue, $whereUpdateQueue);
                    $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Melakukan Pembayaran Transaksi ' .  $resultTrans->Id, 1, 'Transaksi');
                    $condition = 1;
                } else {
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Melakukan Pembayaran Transaksi ' .  $resultTrans->Id, 0, 'Transaksi');
                    $this->C_Activity->SetLogTransaction($resultTrans->Id, 'Gagal Melakukan Pembayaran Transaksi', 16, null, 0, 0, 0, 0);
                    $condition = 2;
                }
            } else {
                $condition = 0;
            }
            $dataResult = [
                'kondisi' => $condition,
                'error' => $this->validator->getErrors(),
                'Jenis' => $this->request->getVar('Kurang')
            ];
            echo json_encode($dataResult);
        } else {
            $dataResult = [
                'kondisi' => 3,
                'error' => null,
                'Jenis' => $this->request->getVar('Kurang')
            ];
            echo json_encode($dataResult);
        }
    }

    public function testLoop()
    {
        echo json_encode(session()->get('spanTanggal'));
    }
    public function getHistoryTrans()
    {
        $usernameOP = session()->get('Username');
        $where = $this->request->getVar('query') . ' ' . $this->request->getVar('search') . " AND Operator = '$usernameOP'";
        $sortData = $this->request->getVar('sort');
        $spanSort = $this->request->getVar('spanSort');
        $spanStatus = $this->request->getVar('spanStatus');
        $spanTanggal = $this->request->getVar('spanTanggal');
        $isFilter = 1;
        if (session()->get('QueryHistorty') != '' && session()->get('isQueryHistory') == 1) {
            $where = session()->get('QueryHistorty');
            $spanSort = session()->get('spanSort');
            $spanStatus = session()->get('spanStatus');
            $spanTanggal = session()->get('spanTanggal');
            $isFilter = 0;
            if (session()->get('spanSort') == 'Terbesar-Terkecil') {
                $sortData = 'desc';
            } else {
                $sortData = 'asc';
            }
        }
        $result = $this->T_TransaksiManual->getTrans($where, $sortData)->getResult('array');
        $pembagian = count($result) / 10;
        $array = explode('.', $pembagian . '');
        $jumlah = 0;
        if (count($array) > 1) {
            $jumlah = (int) $array[0] + 1;
        } else {
            $jumlah = (int) $array[0];
        }
        $datas = [
            'data' => $result,
            'jumlah' => $jumlah,
            'spanSort' =>  $spanSort,
            'spanStatus' =>  $spanStatus,
            'spanTanggal' =>   $spanTanggal,
            'isFilter' => $isFilter
        ];
        $setData = [
            'QueryHistorty' =>  $where,
            'isQueryHistory' =>  0,
            'spanSort' =>  $spanSort,
            'spanStatus' =>  $spanStatus,
            'spanTanggal' =>   $spanTanggal,
        ];
        session()->set($setData);
        echo json_encode($datas);
    }
    public function getNameKasirInManager()
    {
        $where = [
            'Superior' => session()->get('Username')
        ];
        echo json_encode($this->M_Employee->getData($where)->getResult('array'));
    }
    public function getNameKasirInOwner()
    {
        $where = [
            'IdRole' => 2
        ];
        echo json_encode($this->M_Employee->getData($where)->getResult('array'));
    }

    public function getHistoryTransOwner()
    {
        $data = [
            'data' => [],
            'jumlah' => 0,
            'sum' => 0,
            'isFilter' => 0
        ];
        if ($this->request->getVar('SearchStatus') == 0) {
            echo json_encode($data);
        } else {
            $result = array();


            $selectALL = "SELECT Username FROM `m_employee` WHERE `IdRole` = 2";
            $sortData = $this->request->getVar('sort');
            $spanKasir = $this->request->getVar('spanKasir');
            $where = '';

            if ($spanKasir == 'semua') {
                $where = $this->request->getVar('query') . ' ' . " AND (t_transaction_manual.Operator IN ($selectALL)) AND " . $this->request->getVar('spanTanggal');
            } else {
                $where = $this->request->getVar('query') . ' AND ' . $this->request->getVar('spanTanggal');
            }
            $result = $this->M_ActivityTransaction->getSumPaymentHistory($where, $sortData);
            // $dataLoop = $this->T_TransaksiManual->getTrans($whereLoop, $sortData)->getResult('array');
            $pembagian = count($result) / 10;
            $array = explode('.', $pembagian . '');
            $jumlah = 0;
            if (count($array) > 1) {
                $jumlah = (int) $array[0] + 1;
            } else {
                $jumlah = (int) $array[0];
            }
            $data = [
                'data' => $result['data'],
                'sum' => $result['sum'],
                'jumlah' => $jumlah,
                'isFilter' => 1
            ];
            $sessionQuery = [
                'QueryLaporan' => $where,
                'SortLaporan' => $sortData,
            ];
            session()->set($sessionQuery);
            echo json_encode($data);

            // echo json_encode($results);
        }
    }

    public function getHistoryTransManager3()
    {
        $data = [
            'data' => [],
            'jumlah' => 0,
            'sum' => 0,
            'isFilter' => 0
        ];
        if ($this->request->getVar('SearchStatus') == 0) {
            echo json_encode($data);
        } else {
            $whereActivity = $this->request->getVar('spanTanggal') . " AND TypeTransaction = 16";
            $resultActivity = "SELECT Id_Transaction FROM `activity_transaction` WHERE $whereActivity";
            $result = array();

            $usernameOP = session()->get('Username');
            $selectALL = "SELECT Username FROM `m_employee` WHERE `Superior` = '$usernameOP'";
            $sortData = $this->request->getVar('sort');
            $spanKasir = $this->request->getVar('spanKasir');
            $where = '';

            if ($spanKasir == 'semua') {
                $where = $this->request->getVar('spanTanggal') . ' AND ' . $this->request->getVar('query') . ' ' . " AND (t_transaction_manual.Operator = '$usernameOP' OR t_transaction_manual.Operator IN ($selectALL))";
            } else {
                $where = $this->request->getVar('spanTanggal') . ' AND ' . $this->request->getVar('query') . ' ' . " AND (t_transaction_manual.Operator IN ('$spanKasir'))";
            }
            $result = $this->M_ActivityTransaction->getSumPaymentHistory($where, $sortData);
            // $dataLoop = $this->T_TransaksiManual->getTrans($whereLoop, $sortData)->getResult('array');
            $pembagian = count($result) / 10;
            $array = explode('.', $pembagian . '');
            $jumlah = 0;
            if (count($array) > 1) {
                $jumlah = (int) $array[0] + 1;
            } else {
                $jumlah = (int) $array[0];
            }
            $data = [
                'data' => $result['data'],
                'sum' => $result['sum'],
                'jumlah' => $jumlah,
                'isFilter' => 1
            ];
            $sessionQuery = [
                'QueryLaporan' => $where,
                'SortLaporan' => $sortData,
            ];
            session()->set($sessionQuery);
            echo json_encode($data);

            // echo json_encode($results);
        }
    }


    public function getHistoryTransManager2()
    {
        $data = [
            'data' => [],
            'jumlah' => 0,
            'isFilter' => 0
        ];
        if ($this->request->getVar('SearchStatus') == 0) {
            echo json_encode($data);
        } else {
            $whereActivity = $this->request->getVar('spanTanggal') . " AND Description LIKE '%Berhasil Melakukan Pembayaran Transaksi%'";
            $resultActivity = "SELECT Id_Transaction FROM `activity_transaction` WHERE $whereActivity"; //$this->M_ActivityTransaction->getGroupByTransaction($whereActivity)->getResult('array');
            $result = array();

            $usernameOP = session()->get('Username');
            $selectALL = "SELECT Username FROM `m_employee` WHERE `Superior` = '$usernameOP'";
            $sortData = $this->request->getVar('sort');
            $spanKasir = $this->request->getVar('spanKasir');
            $where = '';
            // $where = $this->request->getVar('query') . ' ' . " AND (Operator = '$spanKasir' )";
            if ($spanKasir == 'semua') {
                $where = $this->request->getVar('query') . ' ' . " AND (Operator = '$usernameOP' OR Operator IN ($selectALL))";
            } else {
                $where = $this->request->getVar('query') . ' ' . " AND (Operator IN ('$spanKasir'))";
            }
            $whereLoop = $where . "AND t_transaction_manual.Id IN ($resultActivity)";
            $dataLoop = $this->T_TransaksiManual->getTrans($whereLoop, $sortData)->getResult('array');

            foreach ($dataLoop as $row) {
                $whereSumActivity = $whereActivity . "AND Id_Transaction = '" . $row['Id'] . "'";
                $resultSumActivity = $this->M_ActivityTransaction->getSumPaymentHistory($whereSumActivity);
                $dataTemp = [
                    'Id' => $row['Id'],
                    'Bayar' => $resultSumActivity['sum'],
                    'CreatedDate' => $resultSumActivity['lastDate'],
                    'Number_Trans' => $row['Number_Trans'],
                    'NamaCustomer' => $row['NamaCustomer'],
                    'NamaKasir' => $row['NamaKasir'],
                    'Total_Payment' => $row['Total_Payment'],
                    'StatusTransakksi' => $row['StatusTransakksi'],
                    'Angsuran' => $resultSumActivity['angsuran'],
                ];
                array_push($result, $dataTemp);
            }
            // $usernameOP = session()->get('Username');
            // $selectALL = "SELECT Username FROM `m_employee` WHERE `Superior` = '$usernameOP'";
            // $sortData = $this->request->getVar('sort');
            // $spanKasir = $this->request->getVar('spanKasir');
            // $where = '';
            // // $where = $this->request->getVar('query') . ' ' . " AND (Operator = '$spanKasir' )";
            // if ($spanKasir == 'semua') {
            //     $where = $this->request->getVar('query') . ' ' . " AND (Operator = '$usernameOP' OR Operator IN ($selectALL))";
            // } else {
            //     $where = $this->request->getVar('query') . ' ' . " AND (Operator IN ('$spanKasir'))";
            // }
            // $result = $this->T_TransaksiManual->getTrans($where, $sortData)->getResult('array');
            $pembagian = count($result) / 10;
            $array = explode('.', $pembagian . '');
            $jumlah = 0;
            if (count($array) > 1) {
                $jumlah = (int) $array[0] + 1;
            } else {
                $jumlah = (int) $array[0];
            }
            $data = [
                'data' => $result,
                'jumlah' => $jumlah,
                'isFilter' => 1
            ];
            echo json_encode($data);
        }
    }
    public function getHistoryTransManager()
    {
        $usernameOP = session()->get('Username');
        $selectALL = "SELECT Username FROM `m_employee` WHERE `Superior` = '$usernameOP'";
        $where = $this->request->getVar('query') . ' ' . $this->request->getVar('search');
        $sortData = $this->request->getVar('sort');
        $spanSort = $this->request->getVar('spanSort');
        $spanStatus = $this->request->getVar('spanStatus');
        $spanTanggal = $this->request->getVar('spanTanggal');
        $spanKasir = $this->request->getVar('spanKasir');
        if ($spanKasir == '') {
            $where = $this->request->getVar('query') . ' ' . $this->request->getVar('search') . " AND (Operator = '$usernameOP' OR Operator IN ($selectALL))";
        }
        $isFilter = 1;
        if (session()->get('QueryHistorty') != '' && session()->get('isQueryHistory') == 1) {
            $where = session()->get('QueryHistorty');
            $spanSort = session()->get('spanSort');
            $spanStatus = session()->get('spanStatus');
            $spanTanggal = session()->get('spanTanggal');
            $spanKasir = session()->get('spanKasir');
            $isFilter = 0;
            if (session()->get('spanSort') == 'Terbesar-Terkecil') {
                $sortData = 'desc';
            } else {
                $sortData = 'asc';
            }
        }
        $result = $this->T_TransaksiManual->getTrans($where, $sortData)->getResult('array');
        $pembagian = count($result) / 10;
        $array = explode('.', $pembagian . '');
        $jumlah = 0;
        if (count($array) > 1) {
            $jumlah = (int) $array[0] + 1;
        } else {
            $jumlah = (int) $array[0];
        }
        $datas = [
            'data' => $result,
            'jumlah' => $jumlah,
            'spanSort' =>  $spanSort,
            'spanStatus' =>  $spanStatus,
            'spanTanggal' =>   $spanTanggal,
            'spanKasir' =>   $spanKasir,
            'isFilter' => $isFilter
        ];
        $setData = [
            'QueryHistorty' =>  $where,
            'isQueryHistory' =>  0,
            'spanSort' =>  $spanSort,
            'spanStatus' =>  $spanStatus,
            'spanTanggal' =>   $spanTanggal,
            'spanKasir' =>   $spanKasir,
        ];
        session()->set($setData);
        echo json_encode($datas);
    }

    public function getDataDashboard()
    {
        //1. Omset
        $dateNow = date("Y-m-d");
        $dateAddOne = date('Y-m-d', strtotime(date("Y-m-d") . ' +1 day'));
        $whereOmset = "CreatedDate >= '$dateNow' AND CreatedDate < '$dateAddOne' AND TypeTransaction=16";
        $resultOmset = $this->M_ActivityTransaction->getData($whereOmset)->getResult('array');
        $omset = 0;
        foreach ($resultOmset as $row) {
            if ($row['OverPay'] == 0) {
                $temp = $row['Payment'] - $row['ChangePay'];
                $omset = $omset + $temp;
            } else {
                $omset = $omset + $row['Payment'];
            }
        }

        //2. Status Transaksi
        $whereStatus = "Type='Transaksi'";
        $resultStatus = $this->M_Status_Transaksi->getData($whereStatus)->getResult('array');
        $dataStatus = array();
        foreach ($resultStatus as $row) {
            $whereTransStatus = "Status = $row[Id]";
            $sumTrans = $this->T_TransaksiManual->getData($whereTransStatus)->getNumRows();
            $temp = [
                'Nama' => $row['Name'],
                'Jumlah' => $sumTrans,
            ];
            array_push($dataStatus, $temp);
        }

        //3. Omset Tahunan
        $omsetTahunan = array();
        for ($i = 0; $i < 12; $i++) {
            $month = $i + 1;
            $dateNowTahunan = date("Y") . '-' . $month . '-01';
            $dateAddOneTahunan = date('Y-m-d', strtotime($dateNowTahunan . ' +1 month'));
            $whereOmsetTahunan = "CreatedDate >= '$dateNowTahunan' AND CreatedDate < '$dateAddOneTahunan' AND TypeTransaction=16";
            $resultOmsetTahunan = $this->M_ActivityTransaction->getData($whereOmsetTahunan)->getResult('array');
            $tempOmset = 0;
            foreach ($resultOmsetTahunan as $row) {
                if ($row['OverPay'] == '0') {
                    $temp = $row['Payment'] - $row['ChangePay'];
                    $tempOmset = $tempOmset + $temp;
                } else {
                    $tempOmset = $tempOmset + $row['Payment'];
                }
            }

            $temparray = [
                'Bulan' => $month,
                'omset' => $tempOmset,
            ];
            array_push($omsetTahunan, $temparray);
        }



        $data = [
            'Omset' => $omset,
            'Status' => $dataStatus,
            'OmsetTahunan' => $omsetTahunan
        ];
        echo json_encode($data);
    }

    public function getDataReportManager()
    {
        $usernameOP = session()->get('Username');
        $selectALL = "SELECT Username FROM `m_employee` WHERE `Superior` = '$usernameOP'";
        $where = $this->request->getVar('query') . ' ' . $this->request->getVar('search');
        $data = array();
        if ($this->request->getVar('query') == "") {
            echo json_encode($data);
        } else {
        }
    }

    public function getTotalTransAdmin()
    {
        echo json_encode($this->T_TransaksiManual->getData());
    }

    public function DetailTrans($id)
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));

            $setData = [
                'NamaPage' => 'Detail Transaksi',
                'IconPage' => 'Riwayat Transaksi',
                'IDTrans' => $id
            ];
            $where = [
                'Number_Trans' => $id
            ];
            $result = $this->T_TransaksiManual->getData($where)->getResult('array');
            session()->set($setData);
            if (count($result) > 0) {
                $this->C_Activity->LastActiveUser();
                return view('Transaction/V_TransactionDetail');
            } else {
                $this->C_Activity->LastActiveUser();
                return view('Transaction/V_Transaction_Empty');
            }
        } else {
            return  redirect()->to(base_url('/'));
        }
    }
    public function EditTrans($id)
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));

            $setData = [
                'NamaPage' => 'Edit Transaksi',
                'IconPage' => 'Riwayat Transaksi',
                'IDTrans' => $id
            ];
            $where = [
                'Number_Trans' => $id
            ];
            $result = $this->T_TransaksiManual->getData($where)->getResult('array');
            session()->set($setData);
            if (count($result) > 0) {
                $this->C_Activity->LastActiveUser();
                $this->C_Activity->OpenTrans($result[0]['Id']);
                return view('Transaction/V_TransactionEdit');
            } else {
                $this->C_Activity->LastActiveUser();
                return view('Transaction/V_Transaction_Empty');
            }
        } else {
            return  redirect()->to(base_url('/'));
        }
    }
    public function checkOpenTransUser()
    {
        $where = [
            'Number_Trans' => session()->get('IDTrans')
        ];
        $result = $this->T_TransaksiManual->getData($where)->getResult('array');
        echo json_encode($this->C_Activity->checkTrans($result[0]['Id'])); //$this->C_Activity->checkTrans($result[0]['Id']);
    }
    public function closeTransUser()
    {
        $where = [
            'Number_Trans' => session()->get('IDTrans')
        ];
        $result = $this->T_TransaksiManual->getData($where)->getResult('array');
        echo json_encode($this->C_Activity->CloseTrans($result[0]['Id']));
    }
    public function getDetailTrans()
    {
        $whereTrans = [
            't_transaction_manual.Number_Trans' => session()->get('IDTrans')
            // 't_transaction_manual.Number_Trans' => 'R-20240612-00001'
        ];
        $resultTrans = $this->T_TransaksiManual->getDataJoin($whereTrans)->getRow();
        $resultNextTrans = [];
        $resultBeforeTrans = [];
        if ($resultTrans->StatusTransakksi == '6') {
            $whereTerusan = [
                'Transc_continuance' =>  $resultTrans->Id
            ];
            $resultNextTrans = $this->T_TransaksiManual->getData($whereTerusan)->getRow();
        }
        if ($resultTrans->StatusTransakksi != '0') {
            $whereTerusan = [
                'Id' =>  $resultTrans->Transc_continuance
            ];
            $resultBeforeTrans = $this->T_TransaksiManual->getData($whereTerusan)->getRow();
        }
        $whereLog = [
            'Id_Transaction' => $resultTrans->Id
        ];

        $whereLogPayament = "Id_Transaction = '$resultTrans->Id' AND TypeTransaction =16";

        $totalSemua = 0;
        $DataItems = array();
        if ($resultTrans->StatusTransakksi == 6 || $resultTrans->StatusTransakksi == 4 || $resultTrans->StatusTransakksi == 5) {
            $whereDetailData = [
                'Id_Transaction' => $resultTrans->Id,
                'Status' => 8
            ];
            $dataDetailTrans =  $this->T_DetailTransactionManual->getData($whereDetailData)->getResult('array');

            foreach ($dataDetailTrans as $row) {
                $whereProduk = [
                    'm_product.Id' => $row['Id_Product']
                ];
                $resultProduk = $this->M_Product->getData($whereProduk)->getRow();
                $items = 1;
                if ($row['Unit_Product'] == 'Lusin') {
                    $items = 12;
                } else if ($row['Unit_Product'] == 'Kodi') {
                    $items = 20;
                }
                $tempData = [
                    'NamaProduk' => $row['Name_Product'],
                    'Ukuran' => $row['Size_Product'],
                    'Foto' => $resultProduk->Image,
                    'Unit' => $row['Unit_Product'],
                    'Harga' => $row['Price_Product'],
                    'Item' => ($row['Sum_Product_PerPiece'] / $items),
                    'Total' => ($row['Sum_Product_PerPiece'] / $items) * $row['Price_Product'],
                ];
                $totalSemua =  $totalSemua + (($row['Sum_Product_PerPiece'] / $items) * $row['Price_Product']);
                array_push($DataItems, $tempData);
            }
        } else if ($resultTrans->StatusTransakksi == 1 || $resultTrans->StatusTransakksi == 2) {
            $jnsStatus = 10;
            if ($resultTrans->StatusTransakksi == 2) {
                $jnsStatus = 7;
            }
            $whereDetailData = [
                'Id_Transaction' => $resultTrans->Id,
                'Status' => $jnsStatus
            ];

            $dataDetailTrans =  $this->T_DetailTransactionManual->getData($whereDetailData)->getResult('array');

            foreach ($dataDetailTrans as $row) {
                $wherePriceKhusus = [
                    'm_customer_price_product.Id_Product' => $row['Id_Product'],
                    'm_customer_price_product.Id_Customer' =>  $resultTrans->IdCustomer,
                    'pp.Status' =>  '1'
                ];
                $whereProduk = [
                    'm_product.Id' => $row['Id_Product']
                ];
                $resultProduk = $this->M_Product->getData($whereProduk)->getRow();
                $price = $resultProduk->Per_Piece;
                $items = 1;
                if ($row['Unit_Product'] == 'Lusin') {
                    $price = $resultProduk->Per_Doze;
                    $items = 12;
                } else  if ($row['Unit_Product'] == 'Kodi') {
                    $price = $resultProduk->Per_Kodi;
                    $items = 20;
                }
                $resultKhususProduk = $this->M_CustomerPriceProduct->getDataPriceTrans($wherePriceKhusus)->getRow();

                if ($resultKhususProduk != null) {
                    $price = $resultKhususProduk->Potong;
                    if ($row['Unit_Product'] == 'Lusin') {
                        $price = $resultKhususProduk->Lusin;
                    } else  if ($row['Unit_Product'] == 'Kodi') {
                        $price = $resultKhususProduk->Kodi;
                    }
                }
                $tempData = [
                    'NamaProduk' => $resultProduk->Name,
                    'Ukuran' => $resultProduk->Size,
                    'Foto' => $resultProduk->Image,
                    'Unit' => $row['Unit_Product'],
                    'Harga' => $price,
                    'Item' => ($row['Sum_Product_PerPiece'] / $items),
                    'Total' => ($row['Sum_Product_PerPiece'] / $items) * $price,
                ];
                // echo json_encode($tempData);
                $totalSemua =  $totalSemua + (($row['Sum_Product_PerPiece'] / $items) * $price);
                array_push($DataItems, $tempData);
            }
        }
        $data = [
            'Trans' => $resultTrans,
            'NextTrans' => $resultNextTrans,
            'BeforeTrans' => $resultBeforeTrans,
            'LogTrans' => $this->C_Activity->getLogTransaksi($whereLog),
            'LogTransPayment' => $this->M_ActivityTransaction->getData($whereLogPayament)->getResult('array'),
            'Item' => $DataItems,
            'SubTotal' => $totalSemua
        ];
        echo json_encode($data);
    }

    public function setCartDraftPrint($whereID)
    {
        $resultData = $this->T_DetailTransactionManual->getData($whereID)->getResult('array');
        $data = $resultData;
        // $data = array();
        $totalSemua = 0;
        $totalHutang = 0;
        $jumlahTundaProduk = 0;
        $whereProdukAll = [
            'Status' => 1
        ];
        $resultPRodukAll = $this->M_Product->getData($whereProdukAll)->getResult('array');

        for ($i = 0; $i < count($resultData); $i++) {
            $whereProduk = [
                'm_product.Id' => $resultData[$i]['Id_Product']
            ];
            $whereTrans = [
                'Id' => $resultData[$i]['Id_Transaction']
            ];

            $resultTransaction = $this->T_TransaksiManual->getData($whereTrans)->getRow();
            $totalHutang = $resultTransaction->Total_Dept;
            $resultProduk = $this->M_Product->getDataJoin($whereProduk)->getRow();
            $resultKhususProduk = $this->M_Product->getDataJoin($whereProduk)->getRow();
            $harga = 0;
            $piece = 1;
            $status = 8;

            for ($j = 0; $j < count($resultPRodukAll); $j++) {
                if ($resultProduk->Id == $resultPRodukAll[$j]['Id']) {

                    if ($resultPRodukAll[$j]['Stock_Piece'] >= $resultData[$i]['Sum_Product_PerPiece']) {
                        $temp2 = $resultPRodukAll[$j]['Stock_Piece'] - $resultData[$i]['Sum_Product_PerPiece'];
                        $resultPRodukAll[$j]['Stock_Piece'] = $temp2;
                        $status = 7;
                    } else {
                        $jumlahTundaProduk++;
                    }
                }
            }

            // if ($resultProduk->Stock_Piece >= $resultData[$i]['Sum_Product_PerPiece']) {
            //     $status = 7;
            // }

            $wherePriceKhusus = [
                'm_customer_price_product.Id_Product' => $resultData[$i]['Id_Product'],
                'm_customer_price_product.Id_Customer' =>  $resultTransaction->IdCustomer,
                'pp.Status' =>  '1'
            ];
            $resultKhususProduk = $this->M_CustomerPriceProduct->getDataPriceTrans($wherePriceKhusus)->getRow();
            if ($resultKhususProduk == null) {
                if ($resultData[$i]['Unit_Product'] == 'Potong') {
                    $harga = $resultProduk->Per_Piece;
                    $piece = $resultData[$i]['Sum_Product_PerPiece'];
                } else  if ($resultData[$i]['Unit_Product'] == 'Lusin') {
                    $harga = $resultProduk->Per_Doze;
                    $piece =  $resultData[$i]['Sum_Product_PerPiece'] /  12;
                } else  if ($resultData[$i]['Unit_Product'] == 'Kodi') {
                    $harga = $resultProduk->Per_Kodi;
                    $piece =  $resultData[$i]['Sum_Product_PerPiece'] / 20;
                }
            } else {
                if ($resultData[$i]['Unit_Product'] == 'Potong') {
                    $harga = $resultKhususProduk->Potong;
                    $piece = $resultData[$i]['Sum_Product_PerPiece'];
                } else  if ($resultData[$i]['Unit_Product'] == 'Lusin') {
                    $harga = $resultKhususProduk->Lusin;
                    $piece = $resultData[$i]['Sum_Product_PerPiece'] / 12;
                } else  if ($resultData[$i]['Unit_Product'] == 'Kodi') {
                    $harga = $resultKhususProduk->Kodi;
                    $piece =  $resultData[$i]['Sum_Product_PerPiece'] / 20;
                }
            }


            $total = $harga * $piece;
            $totalSemua = $totalSemua + $total;
            $data[$i]['Name_Product'] = $resultProduk->Name;
            $data[$i]['Size_Product'] = $resultProduk->Size;
            $data[$i]['Price_Product'] = $harga;
            $data[$i]['Total_Payment'] = $total;
        }
        return $data;
    }

    public function PrintNota($trans)
    {
        $whereTrans = [
            'Number_Trans' => $trans
        ];
        $resultTrans = $this->T_TransaksiManual->getTrans($whereTrans, 'ASC')->getRow();
        $date = date_create($resultTrans->CreatedDate);

        $whereDetailTrans = [
            'Id_Transaction' => $resultTrans->Id
        ];
        $resultDetailTrans = $this->T_DetailTransactionManual->getData($whereDetailTrans)->getResult('array');
        $wherePaymentTrans = [
            'Id_Transaction' => $resultTrans->Id,
            'TypeTransaction' => 16
        ];
        $resultPaymentTrans = $this->M_ActivityTransaction->getData($wherePaymentTrans)->getResult('array');


        if ($resultTrans->StatusTransakksi == 1  || $resultTrans->StatusTransakksi == 3) {
            $setData = [
                'ErrorText' => 'Transaksi Tidak Dapat Mencetak Nota'
            ];
            session()->set($setData);
            return  redirect()->to(base_url('/Error'));
        } else {
            if ($resultTrans->StatusTransakksi == 2) {
                $resultDetailTrans = $this->setCartDraftPrint($whereDetailTrans);
            }

            $countLenghtTExt = 0;
            $totalPanjanglengTExt = 0;
            foreach ($resultDetailTrans as $row) {
                $textProduct = $row['Name_Product'] . '(' . $row['Size_Product'] . ')';
                if (strlen($textProduct) > 21) {
                    $countLenghtTExt = $countLenghtTExt + 1;
                    $totalPanjanglengTExt =  $totalPanjanglengTExt + 1;
                }
            }
            $PanjangAwal = 103;
            if ($countLenghtTExt > 0) {
                $PanjangAwal = 105;
            }
            if ($resultTrans->StatusTransakksi == 2) {
                $PanjangAwal = 95;
            }
            if ($countLenghtTExt > 0) {
                $tambahan = ($totalPanjanglengTExt * count($resultDetailTrans)) - $totalPanjanglengTExt;
                $PanjangAwal = $PanjangAwal + $tambahan;
            }

            if (count($resultDetailTrans) > 1) {
                $tambahan = (5 * count($resultDetailTrans)) - 5;
                $PanjangAwal = $PanjangAwal + $tambahan;
            }
            if (count($resultPaymentTrans) > 1) {
                $tambahan = (4 * count($resultPaymentTrans)) - 4;
                $PanjangAwal = $PanjangAwal + $tambahan;
            }


            $pdf = new\FPDF('P', 'mm', array(100, $PanjangAwal));
            $pdf->AddPage();

            $pdf->SetLeftMargin(5);
            $pdf->SetAutoPageBreak(false);

            // Header
            $pdf->SetFont('Arial', 'B', 15);
            $pdf->Cell(0, 10, 'Konveksi R-3', 0, 1, 'C');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(0, 2, 'Dukuh Kedawung Desa Sidorejo Gg Melati 3', 0, 1, 'C');
            $pdf->Cell(0, 5, 'Kec. Comal, Kabupaten Pemalang, 52363', 0, 1, 'C');
            $pdf->Cell(0, 3, 'WhatsApp : +6285865363125', 0, 1, 'C');
            $pdf->SetLineWidth(0.1);
            $pdf->Line(95, 32, 4, 32);

            //Sub Header
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(50, 13, 'Transaksi :' . $trans, 0, 0);
            $pdf->Cell(0, 13, 'Pelanggan : ' . $resultTrans->NamaCustomer, 0, 1);
            $pdf->Cell(50, -4, 'Tanggal : ' . date_format($date, "Y-m-d H:i"), 0, 0);
            $pdf->Cell(0, -4, 'Kasir : ' . $resultTrans->NamaKasir, 0, 1);
            $pdf->SetLineWidth(0.1);
            $pdf->Line(95, 45, 4, 45);


            //Value
            $pdf->Cell(10, 8, '', 0, 1);
            $enterName = 0;
            $subTotalDraft = 0;
            $lengtext = 0;
            foreach ($resultDetailTrans as $row) {

                $x = $pdf->GetX();
                $y = $pdf->GetY();
                if ($enterName == 1) {
                    $y = $y + 5;
                }

                if ($lengtext > 21) {
                    $y = $y + 5;
                }
                $pdf->SetXY($x, $y);


                $textProduct = $row['Name_Product'] . '(' . $row['Size_Product'] . ')';
                $pdf->MultiCell(35, 5, $textProduct, 0, 'L');
                $lengtext = strlen($textProduct);
                $pdf->SetXY($x + 32, $y);
                $JumlahQTY = "";
                if ($row['Unit_Product'] == "Potong") {
                    $JumlahQTY = ($row['Sum_Product_PerPiece'] / 1) . "PT";
                } else  if ($row['Unit_Product'] == "Lusin") {
                    $JumlahQTY = ($row['Sum_Product_PerPiece'] / 12) . "LSN";
                } else  if ($row['Unit_Product'] == "Kodi") {
                    $JumlahQTY = ($row['Sum_Product_PerPiece'] / 20) . "KD";
                }
                $pdf->MultiCell(15, 5, $JumlahQTY, 0, "L");
                $pdf->SetXY($x + 43, $y);
                $pdf->MultiCell(25, 5, number_format($row['Price_Product'], 0, ",", "."), 0, "L");
                $pdf->SetXY($x + 65, $y);
                $pdf->MultiCell(0, 5, number_format($row['Total_Payment'], 0, ",", "."), 0, "L");
                $subTotalDraft = $subTotalDraft + $row['Total_Payment'];
                // $enterName = 1;
                $pdf->Ln(0);
            }
            if ($resultTrans->StatusTransakksi == 2) {
                $resultTrans->Sub_Total = $subTotalDraft;
                $resultTrans->Total_Payment = $subTotalDraft + $resultTrans->Total_Dept;
            }
            $y = $pdf->GetY();
            $spacesub = 0;
            if ($countLenghtTExt > 0) {
                $y = $pdf->GetY() + 3;
                $spacesub = 7;
            }
            $pdf->SetLineWidth(0.1);
            $pdf->Line(45, $y + 3, 95, $y + 3);
            $y = $pdf->GetY();

            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(52, 13 + $spacesub, "Subtotal", 0, 0, "R");
            $pdf->Cell(13, 13 + $spacesub, ":", 0, 0, "C");
            $pdf->Cell(0, 13 + $spacesub, number_format($resultTrans->Sub_Total, 0, ",", "."), 0, 1, "L");

            $pdf->Cell(52, -5 - $spacesub, "Hutang", 0, 0, "R");
            $pdf->Cell(13, -5 - $spacesub, ":", 0, 0, "C");
            $pdf->Cell(0, -5 - $spacesub, number_format($resultTrans->Total_Dept, 0, ",", "."), 0, 1, "L");

            $y = $pdf->GetY();
            if ($countLenghtTExt > 0) {
                $y = $pdf->GetY() + 3;
                $spacesub = 7;
            }
            $pdf->SetLineWidth(0.1);
            $pdf->Line(45, $y + 6, 95, $y + 6);
            $y = $pdf->GetY();

            $pdf->Cell(52, 18 + $spacesub, "Total", 0, 0, "R");
            $pdf->Cell(13, 18 + $spacesub, ":", 0, 0, "C");
            $pdf->Cell(0, 18 + $spacesub, number_format($resultTrans->Total_Payment, 0, ",", "."), 0, 1, "L");




            if ($countLenghtTExt > 0) {
                $pdf->Cell(10, -3 - $spacesub, '', 0, 1);
            } else {
                $pdf->Cell(10, -7, '', 0, 1);
            }
            $urutanBayar = 1;
            $sisaPayment = 0;
            $kembaliPayment = 0;
            foreach ($resultPaymentTrans as $row) {
                $x = $pdf->GetX();
                $y = $pdf->GetY();
                $getText = 'Bayar ' . $urutanBayar;
                if (count($resultPaymentTrans) == 1) {
                    $getText = 'Bayar';
                }
                $sisaPayment = $row['OverPay'];
                $kembaliPayment = $row['ChangePay'];
                $pdf->SetXY($x, $y);
                $pdf->MultiCell(52, 5, $getText, 0, 'R');
                $pdf->SetXY($x + 57, $y);
                $pdf->MultiCell(13, 5, ':', 0, "L");
                $pdf->SetXY($x + 65, $y);
                $pdf->MultiCell(0, 5, number_format($row['Payment'], 0, ",", "."), 0, "L");
                $pdf->Ln(0);
                $urutanBayar = $urutanBayar + 1;
            }
            $y = $pdf->GetY();

            $Status = 'Draft';
            $hasilKembalianorsisa = 0;
            $textKembalian = 'Kembali';
            if ($resultTrans->StatusTransakksi == '4') {
                $Status = 'Lunas';
                if (count($resultPaymentTrans) > 1) {
                    $textKembalian = 'Kembali Tahap ' . count($resultPaymentTrans);
                    $hasilKembalianorsisa = $kembaliPayment;
                } else {
                    $textKembalian = 'Kembali';
                    $hasilKembalianorsisa = $kembaliPayment;
                }
            } else if ($resultTrans->StatusTransakksi == '5') {
                $Status = 'Belum Lunas';
                $textKembalian = 'Sisa';
                $hasilKembalianorsisa = $sisaPayment;
            } else if ($resultTrans->StatusTransakksi == '6') {
                $textKembalian = 'Sisa';
                $hasilKembalianorsisa = $sisaPayment;
                $Status = 'Diteruskan';
            }

            if ($resultTrans->StatusTransakksi != 2) {
                $pdf->Cell(52, 5, $textKembalian, 0, 0, "R");
                $pdf->Cell(13, 5, ":", 0, 0, "C");
                $pdf->Cell(0, 5, number_format($hasilKembalianorsisa, 0, ",", "."), 0, 1, "L");
            }




            $pdf->Cell(95, 5, "(*)Transaksi Status " . $Status, 0, 0, "L");

            $y = $pdf->GetY();
            $pdf->SetLineWidth(0.1);
            $pdf->Line(5, $y + 7, 95, $y + 7);
            // $pdf->Line(95, 42, 4, 42);
            $y = $pdf->GetY();

            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(-95, 20, 'Terima Kasih Atas Kunjungan Anda', 0, 1, 'C');
            $y = $pdf->GetY();
            $pdf->SetLineWidth(0.1);
            $pdf->Line(5, $y - 6, 95, $y - 6);
            // // $pdf->SetX(25);
            // $pdf->Cell(18, -2, 'Bank Mandiri : 12345678 (Carudi) | Bank Mandiri : 12345678 (Carudi)', 0, 1, 'L');
            // // $pdf->Cell(2, -2, ':', 0, 0, 'L');
            // // $pdf->Cell(15, -2, '102030489 (Carudi)', 0, 0, 'L');
            // $pdf->SetX(30);
            // $pdf->Cell(20, 12, 'Bank BCA : 12345678 (Carudi) ', 0, 0, 'L');
            // // $pdf->Cell(5, 12, ':', 0, 0, 'L');
            // // $pdf->Cell(15, 12, '102030489 (Carudi)', 0, 1, 'L');
            // // $pdf->SetX(25);
            // // $pdf->Cell(20, -2, 'Bank BRI', 0, 0, 'L');
            // // $pdf->Cell(5, -2, ':', 0, 0, 'L');
            // // $pdf->Cell(15, -2, '102030489 (Carudi)', 0, 1, 'L');

            // $y = $pdf->GetY();
            // $pdf->SetLineWidth(0.1);
            // $pdf->Line(5, $y + 10, 95, $y + 10);


            $this->response->setHeader('Content-Type', 'application/pdf');
            $pdf->Output("Nota-Pembayaran " . $trans . ".pdf", "I");
        }
    }

    public function testDAta()
    {
        echo json_encode(basename('Laporan/Transaksi/data.xlsx'));
    }

    public function ExportToExcel()
    {


        $result = $this->M_ActivityTransaction->getSumPaymentHistory(session()->get('QueryLaporan'), session()->get('SortLaporan'));
        $datas = $result['data'];

        $dates = $this->request->getVar('Tanggal');
        $file_name = 'Export Data Laporan Transaksi (' . $dates . ').xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                ),
            ),
        );

        $styleHeader = [
            'font' => [
                'bold' => true,
            ]
        ];
        $sheet->setCellValue('A1', 'No. Transaksi');
        $sheet->setCellValue('B1', 'Pelanggan');
        $sheet->setCellValue('C1', 'Kasir');
        $sheet->setCellValue('D1', 'Tanggal Bayar');
        $sheet->setCellValue('E1', 'Metode');
        $sheet->setCellValue('F1', 'Nominal');
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleHeader);
        $count = 2;
        $Total = 0;
        // for ($i = 0; $i < 10; $i++) {
        foreach ($datas as $row) {
            $metode = 'Tunai';
            if ($row['Image']) {
                $metode = 'Transfer';
            }
            $sum = 0;
            if ($row['OverPay'] == 0) {
                $temp = $row['Payment'] -  $row['ChangePay'];
                $sum = $sum + $temp;
            } else {
                $sum = $sum +  $row['Payment'];
            }
            $Total = $Total + $sum;
            $sheet->setCellValue('A' . $count, $row['Number_Trans']);

            $sheet->setCellValue('B' . $count, $row['Customer']);

            $sheet->setCellValue('C' . $count, $row['Kasir']);

            $sheet->setCellValue('D' . $count, $row['TGLBayar']);
            $sheet->setCellValue('E' . $count,  $metode);
            $sheet->setCellValue('F' . $count, number_format($sum, 2, ",", "."));

            $count++;
        }
        $sheet->setCellValue('A' . $count, 'Total Omset');
        $sheet->setCellValue('F' . $count, number_format($Total, 2, ",", "."));
        $spreadsheet->getActiveSheet()->mergeCells('A' . $count . ':E' . $count);
        $spreadsheet->getActiveSheet()->getStyle('A' . $count)->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('F' . $count)->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('A1:F' . $count)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        // $spreadsheet->getActiveSheet()->freezePane('D2');

        $writer = new Xlsx($spreadsheet);

        $fileSave = 'Laporan/Transaksi/' . $file_name;

        $writer->save($fileSave);

        header("Content-Type: application/vnd.ms-excel");

        header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');

        header('Expires: 0');

        header('Cache-Control: must-revalidate');

        header('Pragma: public');

        header('Content-Length:' . filesize($fileSave));

        flush();

        readfile($fileSave);

        exit;
    }

    public function createGuidData()
    {
        $hash = md5(uniqid());
        $phash = array(
            substr($hash, 0, 8),
            substr($hash, 8, 4),
            substr($hash, 12, 4),
            substr($hash, 16, 4),
            substr($hash, 20),
        );
        $guid = join('-', $phash);
        return $guid;
    }
}
