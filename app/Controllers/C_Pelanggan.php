<?php

namespace App\Controllers;

use App\Models\Master\M_AccountCustomer;
use App\Models\Master\M_Customer;
use App\Models\Master\M_CustomerPriceProduct;
use App\Models\Transaction\T_TransactionManual;

class C_Pelanggan extends BaseController
{
    protected $M_Customer;
    protected $M_AccountCustomer;
    protected $C_Activity;
    protected $M_CustomerPriceProduct;
    protected $T_TransactionManual;
    public function __construct()
    {

        $this->M_Customer = new M_Customer();
        $this->M_CustomerPriceProduct = new M_CustomerPriceProduct();
        $this->M_AccountCustomer = new M_AccountCustomer();
        $this->T_TransactionManual = new T_TransactionManual();
        $this->C_Activity = new C_Activity();
    }
    public function index()
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));
            $setData = [
                'NamaPage' => 'Pelanggan',
                'IconPage' => 'Pelanggan'
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();
            return view('Pelanggan/V_ListPelanggan');
        } else {
            return  redirect()->to(base_url('/'));
        }
    }
    public function FromCustomer()
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));
            $setData = [
                'NamaPage' => 'Tambah Pelanggan',
                'IconPage' => 'Pelanggan'
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();
            return view('Pelanggan/V_AddPelanggan');
        } else {
            return  redirect()->to(base_url('/'));
        }
    }
    public function EditCustomer($Slug)
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));
            $setData = [
                'NamaPage' => 'Edit Pelanggan',
                'IconPage' => 'Pelanggan',
                'Slug' => $Slug,
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();
            return view('Pelanggan/V_EditPelanggan');
        } else {
            return  redirect()->to(base_url('/'));
        }
    }

    public function getData()
    {
        if ($this->request->getVar('query') == '') {
            echo json_encode($this->M_Customer->getData());
        } else {
            echo json_encode($this->M_Customer->getData($this->request->getVar('query'))->getResult('array'));
        }
    }
    public function GetDataEdit()
    {
        $where = [
            'Slug' => session()->get('Slug')
        ];

        echo json_encode($this->M_Customer->getData($where)->getRow());
    }
    public function UpdatePelanggan()
    {
        if (session()->get('status') == TRUE) {
            $cekRule = [];
            if ($this->request->getVar('KondisiNomor') == 'Tidak') {
                $cekRule = [
                    'Name' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom nama pelanggan harus diisi'
                        ]
                    ],
                    'Telephone' => [
                        'rules' => 'required|is_unique[m_customer.Telephone]|min_length[12]',
                        'errors' => [
                            'required' => 'Kolom nomor telefon harap diisi',
                            'is_unique' => 'Nomor Telefon Sudah Tersedia',
                            'min_length' => 'Nomor Telefon kurang dari 12 digit'
                        ]
                    ],
                    'Email' => [
                        'rules' => 'permit_empty|valid_email|is_unique[m_customer.Email]',
                        'errors' => [
                            'is_unique' => 'Email Sudah Tersedia',
                            'valid_email' => 'Email tidak valid'
                        ]
                    ],
                    'Address' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom alamat harus diisi'
                        ]
                    ]
                ];
            } else {
                $cekRule = [
                    'Name' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom nama pelanggan harus diisi'
                        ]
                    ],
                    'Email' => [
                        'rules' => 'permit_empty|valid_email|is_unique[m_customer.Email]',
                        'errors' => [
                            'is_unique' => 'Email Sudah Tersedia',
                            'valid_email' => 'Email tidak valid'
                        ]
                    ],
                    'Address' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom alamat harus diisi'
                        ]
                    ]
                ];
            }
            $this->validate($cekRule);
            $condition = 0;
            if ($this->validate($cekRule)) {
                $whereGetID = [
                    'Slug' => session()->get('Slug')
                ];
                $DataTemp = $this->M_Customer->getData($whereGetID)->getRow();
                $whereData = [
                    'IdCustomer' => $DataTemp->Id
                ];
                $Customer = [
                    'Name' => $this->request->getVar('Name'),
                    'Telephone' => $this->request->getVar('Telephone'),
                    'Country_Telephone' => $this->request->getVar('CountryTelephone'),
                    'Email' => $this->request->getVar('Email'),
                    'Gender' => $this->request->getVar('Gender'),
                    'Address' => $this->request->getVar('Address'),
                    'ModifiedBy' => session()->get('Username') . '-E',
                ];
                $AccountCustomer = [
                    'Telephone' => $this->request->getVar('Telephone')
                ];
                if ($this->M_Customer->updateData($Customer, $whereGetID)) {
                    if ($this->M_AccountCustomer->updateData($AccountCustomer, $whereData)) {
                        $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Memperbarui Data Pelanggan', 1, 'Pelanggan');
                        $condition = 1;
                    } else {
                        $Customer = [
                            'Name' => $DataTemp->Name,
                            'Telephone' => $DataTemp->Telephone,
                            'Country_Telephone' =>  $DataTemp->Country_Telephone,
                            'Email' =>  $DataTemp->Email,
                            'Gender' =>  $DataTemp->Gender,
                            'Address' =>  $DataTemp->Address,
                            'ModifiedBy' =>  $DataTemp->ModifiedBy,
                        ];
                        $this->M_Customer->updateData($Customer, $whereGetID);
                        $this->C_Activity->Employee(session()->get('Username'), 'Gagal Memperbarui Data Pelanggan', 0, 'Pelanggan');
                        $condition = 2;
                    }
                } else {
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Memperbarui Data Pelanggan', 0, 'Pelanggan');
                    $condition = 2;
                }
            }
            $dataResult = [
                'kondisi' => $condition,
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
    public function SavePelangganTransaksi()
    {
        if (session()->get('status') == TRUE) {
            $cekRule = [
                'Name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom nama pelanggan harus diisi'
                    ]
                ],
                'Telephone' => [
                    'rules' => 'required|is_unique[m_customer.Telephone]|min_length[12]',
                    'errors' => [
                        'required' => 'Kolom nomor telefon harap diisi',
                        'is_unique' => 'Nomor Telefon Sudah Tersedia',
                        'min_length' => 'Nomor Telefon kurang dari 12 digit'
                    ]
                ],
                'Address' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom alamat harus diisi'
                    ]
                ]
            ];
            $condition = 0;
            if ($this->validate($cekRule)) {
                $slugData = '';
                $kondisiSlug = 0;
                for ($i = 0; $i < 10; $i++) {
                    $TempslugData = $this->generateRandomString(10);
                    $checkSlug = [
                        'Slug' => $TempslugData
                    ];
                    if (($this->M_Customer->getData($checkSlug)->getNumRows()) == 0 && $kondisiSlug == 0) {
                        $slugData = $TempslugData;
                        $kondisiSlug = 1;
                    }
                }
                $Customer = [
                    'Id' => 'C',
                    'Slug' => $slugData,
                    'Name' => $this->request->getVar('Name'),
                    'Telephone' => $this->request->getVar('Telephone'),
                    'Country_Telephone' => $this->request->getVar('CountryTelephone'),
                    'Address' => $this->request->getVar('Address'),
                    'Status' => 1,
                    'CreatedBy' => session()->get('Username') . '-E',
                    'ModifiedBy' => session()->get('Username') . '-E',
                ];
                if (!$this->M_Customer->SaveDateCustom($Customer)) {
                    $getDataCustomer = [
                        'Telephone' => $this->request->getVar('Telephone')
                    ];
                    $resultCustomer = $this->M_Customer->getData($getDataCustomer)->getRow();
                    $AccountCustomer = [
                        'IdCustomer' => $resultCustomer->Id,
                        'Telephone' => $this->request->getVar('Telephone'),
                        'Password' => md5('12345678')
                    ];
                    // $this->M_AccountCustomer->saveData($AccountCustomer);
                    if (!$this->M_AccountCustomer->saveData($AccountCustomer)) {
                        $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Menambahkan Data Pelanggan', 1, 'Pelanggan');
                        $condition = 1;
                    } else {
                        $this->M_Customer->hapus($getDataCustomer);
                        $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menambahkan Data Pelanggan', 0, 'Pelanggan');
                        $condition = 2;
                    }
                    // $condition = 2;
                } else {
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menambahkan Data Pelanggan', 0, 'Pelanggan');
                    $condition = 2;
                }
            } else {
                $condition = 0;
            }
            $dataResult = [
                'kondisi' => $condition,
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
    public function SavePelanggan()
    {
        if (session()->get('status') == TRUE) {
            $cekRule = [
                'Name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom nama pelanggan harus diisi'
                    ]
                ],
                'Telephone' => [
                    'rules' => 'required|is_unique[m_customer.Telephone]|min_length[12]',
                    'errors' => [
                        'required' => 'Kolom nomor telefon harap diisi',
                        'is_unique' => 'Nomor Telefon Sudah Tersedia',
                        'min_length' => 'Nomor Telefon kurang dari 12 digit'
                    ]
                ],
                'Email' => [
                    'rules' => 'permit_empty|valid_email|is_unique[m_customer.Email]',
                    'errors' => [
                        'is_unique' => 'Email Sudah Tersedia',
                        'valid_email' => 'Email tidak valid'
                    ]
                ],
                'Address' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom alamat harus diisi'
                    ]
                ]
            ];
            // $this->validate($cekRule);

            if ($this->validate($cekRule)) {
                $slugData = '';
                $kondisiSlug = 0;
                for ($i = 0; $i < 10; $i++) {
                    $TempslugData = $this->generateRandomString(10);
                    $checkSlug = [
                        'Slug' => $TempslugData
                    ];
                    if (($this->M_Customer->getData($checkSlug)->getNumRows()) == 0 && $kondisiSlug == 0) {
                        $slugData = $TempslugData;
                        $kondisiSlug = 1;
                    }
                }
                $Customer = [
                    'Id' => 'C',
                    'Slug' => $slugData,
                    'Name' => $this->request->getVar('Name'),
                    'Telephone' => $this->request->getVar('Telephone'),
                    'Country_Telephone' => $this->request->getVar('CountryTelephone'),
                    'Email' => $this->request->getVar('Email'),
                    'Address' => $this->request->getVar('Address'),
                    'Status' => 1,
                    'CreatedBy' => session()->get('Username') . '-E',
                    'ModifiedBy' => session()->get('Username') . '-E',
                ];
                if (!$this->M_Customer->SaveDateCustom($Customer)) {
                    $getDataCustomer = [
                        'Telephone' => $this->request->getVar('Telephone')
                    ];
                    $resultCustomer = $this->M_Customer->getData($getDataCustomer)->getRow();
                    $AccountCustomer = [
                        'IdCustomer' => $resultCustomer->Id,
                        'Telephone' => $this->request->getVar('Telephone'),
                        'Password' => md5('12345678')
                    ];
                    // $this->M_AccountCustomer->saveData($AccountCustomer);
                    if (!$this->M_AccountCustomer->saveData($AccountCustomer)) {
                        $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Menambahkan Data Pelanggan', 1, 'Pelanggan');
                        $condition = 1;
                    } else {
                        $this->M_Customer->hapus($getDataCustomer);
                        $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menambahkan Data Pelanggan', 0, 'Pelanggan');
                        $condition = 2;
                    }
                    // $condition = 2;
                } else {
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menambahkan Data Pelanggan', 0, 'Pelanggan');
                    $condition = 2;
                }
            } else {
                $condition = 0;
            }
            $dataResult = [
                'kondisi' => $condition,
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


    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function updatePassword()
    {
        if (session()->get('status') == TRUE) {
            $dataCustomer = [
                'ModifiedBy' => session()->get('Username') . '-E'
            ];
            $dataAccount = [
                'Password' => md5($this->request->getVar('Pass'))
            ];
            $whereAccount = [
                'IdCustomer' => $this->request->getVar('Id')
            ];
            $whereCustomer = [
                'Id' => $this->request->getVar('Id')
            ];
            if ($this->M_AccountCustomer->updateData($dataAccount, $whereAccount)) {
                $this->M_Customer->updateData($dataCustomer, $whereCustomer);
                $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Memperbarui Kata Sandi Pelanggan', 1, 'Pelanggan');
                echo json_encode(1);
            } else {
                $this->C_Activity->Employee(session()->get('Username'), 'Gagal Memperbarui Kata Sandi Pelanggan', 0, 'Pelanggan');
                echo json_encode(0);
            }
        } else {
            echo json_encode(2);
        }
    }
    public function InfoPelanggan($Slug)
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));
            $setData = [
                'NamaPage' => 'Informasi Pelanggan',
                'IconPage' => 'Pelanggan',
                'SlugPelanggan' => $Slug
            ];
            session()->set($setData);
            // echo json_encode(session()->get('Slug'));
            $this->C_Activity->LastActiveUser();
            return view('Pelanggan/V_InfoPelanggan');
        } else {

            return  redirect()->to(base_url('/'));
        }
    }
    public function UpdateStatus($Id, $Status)
    {
        if (session()->get('status') == TRUE) {
            $statusData = 'Aktif';
            if ($Status == 0) {
                $statusData = 'Tidak Aktif';
            }
            $data = [
                'Status' => $Status,
                'ModifiedBy' => session()->get('Username') . '-E'
            ];
            $where = [
                'Id' => $Id
            ];
            if ($this->M_Customer->updateData($data, $where)) {
                $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Mengubah Status ' . $statusData . ' Pelanggan', 1, 'Pelanggan');
                echo json_encode(1);
            } else {
                $this->C_Activity->Employee(session()->get('Username'), 'Gagal Mengubah Status ' . $statusData . ' Pelanggan', 0, 'Pelanggan');
                echo json_encode(0);
            }
        } else {
            echo json_encode(2);
        }
    }

    public function getInformationPelanggan()
    {
        // 1. Get Data User
        $whereUser = [
            'Slug' => session()->get('SlugPelanggan')
        ];
        $resultDataUser = $this->M_Customer->getData($whereUser)->getRow();

        //2. Get Harga Khusus
        $whereHarga = [
            'm_customer_price_product.Id_Customer' =>  $resultDataUser->Id
        ];

        $resultDataPrice = $this->M_CustomerPriceProduct->getInfoDataPrice($whereHarga)->getResult('array');

        // 3. Get Statistik
        $statistik = array();
        // $idStatik = $this->request->getVar('IsStatik');
        for ($i = 0; $i < 12; $i++) {
            $month = $i + 1;
            $dateNowTahunan = date('Y') . '-' . $month . '-01';
            $dateAddOneTahunan = date('Y-m-d', strtotime($dateNowTahunan . ' +1 month'));
            $whereproduksiTahunan = "CreatedDate >= '$dateNowTahunan' AND CreatedDate < '$dateAddOneTahunan' AND Status IN (4,5,6) AND IdCustomer= '" . $resultDataUser->Id . "'";
            $resultPeminatProduk = $this->T_TransactionManual->getData($whereproduksiTahunan)->getResult('array');
            $countValue = 0;
            foreach ($resultPeminatProduk as $row) {
                $countValue = $countValue + $row['Sub_Total'];
            }
            $temp = [
                'Bulan' => ($i + 1),
                'Value' => $countValue
            ];
            array_push($statistik, $temp);
        }
        $data = [
            'Pelanggan' => $resultDataUser,
            'Price' =>    $resultDataPrice,
            'Statistik' => $statistik
        ];

        echo json_encode($data);
    }

    public function getStatistikPembelian()
    {
        $whereUser = [
            'Slug' => session()->get('SlugPelanggan')
        ];
        $resultDataUser = $this->M_Customer->getData($whereUser)->getRow();
        // 3. Get Statistik
        $statistik = array();
        $years = $this->request->getVar('years');
        for ($i = 0; $i < 12; $i++) {
            $month = $i + 1;
            $dateNowTahunan =   $years . '-' . $month . '-01';
            $dateAddOneTahunan = date('Y-m-d', strtotime($dateNowTahunan . ' +1 month'));
            $whereproduksiTahunan = "CreatedDate >= '$dateNowTahunan' AND CreatedDate < '$dateAddOneTahunan' AND Status IN (4,5,6) AND IdCustomer= '" . $resultDataUser->Id . "'";
            $resultPeminatProduk = $this->T_TransactionManual->getData($whereproduksiTahunan)->getResult('array');
            $countValue = 0;
            foreach ($resultPeminatProduk as $row) {
                $countValue = $countValue + $row['Sub_Total'];
            }
            $temp = [
                'Bulan' => ($i + 1),
                'Value' => $countValue
            ];
            array_push($statistik, $temp);
        }
        echo json_encode($statistik);
    }
}
