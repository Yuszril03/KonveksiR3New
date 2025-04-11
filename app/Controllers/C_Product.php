<?php

namespace App\Controllers;

use App\Models\Activity\M_ActivityProduct;
use App\Models\Master\M_Customer;
use App\Models\Master\M_CustomerPriceProduct;
use App\Models\Master\M_MaterialProduct;
use App\Models\Master\M_PriceProduct;
use App\Models\Master\M_Product;
use App\Models\Master\M_Type_Item;
use App\Models\Master\M_TypeProduct;
use App\Models\Temporary\Temp_CustomerPriceProduct;
use App\Models\Transaction\T_DetailTransactionManual;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class C_Product extends BaseController
{
    protected $M_TypeProduct;
    protected $M_MaterialProduct;
    protected $C_Activity;
    protected $M_TypeItem;
    protected $M_Product;
    protected $Temp_CustomerPriceProduct;
    protected $M_PriceProduct;
    protected $M_CustomerPriceProduct;
    protected $M_Customer;
    protected $M_ActivityProduk;
    protected $T_DetailTrasaction;
    public function __construct()
    {
        $this->M_TypeProduct = new M_TypeProduct();
        $this->M_MaterialProduct = new M_MaterialProduct();
        $this->M_TypeItem = new M_Type_Item();
        $this->Temp_CustomerPriceProduct = new Temp_CustomerPriceProduct();
        $this->C_Activity = new C_Activity();
        $this->M_Product = new M_Product();
        $this->M_PriceProduct = new M_PriceProduct();
        $this->M_CustomerPriceProduct = new M_CustomerPriceProduct();
        $this->M_Customer = new M_Customer();
        $this->M_ActivityProduk = new M_ActivityProduct();
        $this->T_DetailTrasaction = new T_DetailTransactionManual();
    }


    #region Data Produk
    public function index()
    {
        if (
            session()->get('status') == TRUE
        ) {
            // return  redirect()->to(base_url('Home'));
            $setData = [
                'NamaPage' => 'Produk',
                'IconPage' => 'Produk'
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();
            return view('Product/V_ListProduct');
        } else {
            return  redirect()->to(base_url('/'));
        }
    }
    public function FormCustomPrice($codeQr)
    {
        if (
            session()->get('status') == TRUE
        ) {
            // return  redirect()->to(base_url('Home'));
            $setData = [
                'NamaPage' => 'Custom Harga Produk',
                'IconPage' => 'Produk',
                'CodeQr' => $codeQr
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();
            return view('Product/V_CustomPrice');
        } else {
            return  redirect()->to(base_url('/'));
        }
    }
    public function FromAddProduct()
    {
        if (
            session()->get('status') == TRUE
        ) {
            // return  redirect()->to(base_url('Home'));
            $setData = [
                'NamaPage' => 'Produk',
                'IconPage' => 'Tambah Produk'
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();
            return view('Product/V_FromProduct');
        } else {
            return  redirect()->to(base_url('/'));
        }
    }
    public function formEditProduct($code)
    {
        if (
            session()->get('status') == TRUE
        ) {
            // return  redirect()->to(base_url('Home'));
            $setData = [
                'NamaPage' => 'Produk',
                'IconPage' => 'Edit Produk',
                'CodeQr' => $code
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();
            return view('Product/V_FromProductEdit');
        } else {
            return  redirect()->to(base_url('/'));
        }
    }
    public function getTypeItem()
    {
        $where = [
            'Status' => 1
        ];
        echo json_encode($this->M_TypeItem->getData($where)->getResult('array'));
    }

    public function getDataForm()
    {
        $where = [
            'CodeQr' => session()->get('CodeQr')
        ];
        echo json_encode($this->M_Product->getData($where)->getRow());
    }

    public function saveProduct()
    {

        if (
            session()->get('status') == TRUE
        ) {
            $foto = [
                'rules' => 'permit_empty|max_size[Foto,1024]|ext_in[Foto,png,jpg]',
                'errors' => [
                    'max_size' => 'Ukuran foto makasimal 1 MB',
                    'ext_in' => 'Tipe foto harus PNG dan JPG'
                ]
            ];


            if ($this->request->getVar('IsFoto') == 0) {
                $foto = [
                    'rules' => 'permit_empty'
                ];
            }
            $cekRule = [
                'Name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom nama produk harus diisi'
                    ]
                ],
                'Size' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom ukuran produk harus diisi'
                    ]
                ],
                'Type' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom jenis produk harus diisi'
                    ]
                ],
                'Material' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom bahan produk harus diisi'
                    ]
                ],
                'Modal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom modal produk harus diisi'
                    ]
                ],
                'Potong' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom harga per-potong produk harus diisi'
                    ]
                ],
                'Lusin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom harga per-lusin produk harus diisi'
                    ]
                ],
                'Kodi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom harga per-kodi produk harus diisi'
                    ]
                ],
                'Stok' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom stok produk harus diisi'
                    ]
                ],
                'Limit' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom limit produk harus diisi'
                    ]
                ],
                'typeStok' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom jenis stok produk harus diisi'
                    ]
                ],
                'typeLimit' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom jenis limit produk harus diisi'
                    ]
                ],
                'Slug' => [
                    'rules' => 'is_unique[m_product.Slug]',
                    'errors' => [
                        'is_unique' => 'Nama dan Ukuran Produk sudah tersedia'
                    ]
                ],
                'Foto' => $foto
            ];
            $condition = 1;
            if ($this->validate($cekRule)) {
                $data = [];
                $qrCode =  $this->generateRandomString();
                $slug = strtolower(str_replace('', '-', $this->request->getVar('Name')) . '-' . str_replace('', '-', $this->request->getVar('Size')));
                $img = $this->request->getFile('Foto');
                $Stock =  $this->request->getVar('Stok');
                $whereTypeSatuan = [
                    'Id' => $this->request->getVar('typeStok')
                ];
                $resultTypeSatuan  = $this->M_TypeItem->getData($whereTypeSatuan)->getRow();
                $realPiece = (int) $Stock * (int) $resultTypeSatuan->Per_Piece;
                if ($this->request->getVar('IsFoto') == 1) {
                    $newName = $img->getRandomName();
                    $data = [
                        'Name' => $this->request->getVar('Name'),
                        'Id_Type_Product' => $this->request->getVar('Type'),
                        'Id_Material_Product' => $this->request->getVar('Material'),
                        'Size' => $this->request->getVar('Size'),
                        'Limit' => $this->request->getVar('Limit'),
                        'TypeLimit' => $this->request->getVar('typeLimit'),
                        'Image' => 'Image/Product/' . $qrCode . '/' . $newName,
                        'Slug' => $slug,
                        'CodeQr' => $qrCode,
                        'Capital_Price' => $this->request->getVar('Modal'),
                        'Per_Piece' => $this->request->getVar('Potong'),
                        'Per_Doze' => $this->request->getVar('Lusin'),
                        'Per_Kodi' => $this->request->getVar('Kodi'),
                        'Stock' => $this->request->getVar('Stok'),
                        'TypeStock' => $this->request->getVar('typeStok'),
                        'Stock_Piece' =>   $realPiece,
                        'Status' => 1,
                        'CreatedBy' => session()->get('Username'),
                        'ModifiedBy' => session()->get('Username')
                    ];
                } else {
                    $data = [
                        'Name' => $this->request->getVar('Name'),
                        'Id_Type_Product' => $this->request->getVar('Type'),
                        'Id_Material_Product' => $this->request->getVar('Material'),
                        'Size' => $this->request->getVar('Size'),
                        'Limit' => $this->request->getVar('Limit'),
                        'TypeLimit' => $this->request->getVar('typeLimit'),
                        // 'Image' => 'Image/Product/' . $qrCode . '/' . $newName,
                        'Slug' => $slug,
                        'CodeQr' => $qrCode,
                        'Capital_Price' => $this->request->getVar('Modal'),
                        'Per_Piece' => $this->request->getVar('Potong'),
                        'Per_Doze' => $this->request->getVar('Lusin'),
                        'Per_Kodi' => $this->request->getVar('Kodi'),
                        'Stock' => $this->request->getVar('Stok'),
                        'TypeStock' => $this->request->getVar('typeStok'),
                        'Stock_Piece' =>   $realPiece,
                        'Status' => 1,
                        'CreatedBy' => session()->get('Username'),
                        'ModifiedBy' => session()->get('Username')
                    ];
                }
                if ($this->M_Product->saveData($data)) {
                    if ($this->request->getVar('IsFoto') == 1) {
                        $img->move('Image/Product/' . $qrCode, $newName);
                    }
                    $whereGetData = [
                        'CodeQr' => $qrCode
                    ];
                    $resultP = $this->M_Product->getData($whereGetData)->getRow();
                    $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Menambahkan Data Produk', 1, 'Produk');
                    $this->C_Activity->insertActivityProduk($resultP->Id, 1, null, 0, 'Berhasil Menambahkan Data Produk', 1);
                    $condition = 1;
                } else {
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menambahkan Data Produk', 0, 'Produk');
                    $condition = 2;
                }
                // $condition = 2;
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

    public function saveEditProduct()
    {
        if (session()->get('status') == TRUE) {
            $foto = [
                'rules' => 'permit_empty|max_size[Foto,1024]|ext_in[Foto,png,jpg]',
                'errors' => [
                    'max_size' => 'Ukuran foto makasimal 1 MB',
                    'ext_in' => 'Tipe foto harus PNG dan JPG'
                ]
            ];
            $slug = [
                'rules' => 'is_unique[m_product.Slug]',
                'errors' => [
                    'is_unique' => 'Nama dan Ukuran Produk sudah tersedia'
                ]
            ];
            if ($this->request->getVar('TempSlug') == $this->request->getVar('Slug')) {
                $slug = [
                    'rules' => 'permit_empty'
                ];
            }


            if ($this->request->getVar('IsFoto') == 0 || $this->request->getVar('IsFoto') == 2) {
                $foto = [
                    'rules' => 'permit_empty'
                ];
            }
            $cekRule = [
                'Name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom nama produk harus diisi'
                    ]
                ],
                'Size' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom ukuran produk harus diisi'
                    ]
                ],
                'Type' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom jenis produk harus diisi'
                    ]
                ],
                'Material' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom bahan produk harus diisi'
                    ]
                ],
                'Modal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom modal produk harus diisi'
                    ]
                ],
                'Potong' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom harga per-potong produk harus diisi'
                    ]
                ],
                'Lusin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom harga per-lusin produk harus diisi'
                    ]
                ],
                'Kodi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom harga per-kodi produk harus diisi'
                    ]
                ],
                'Stok' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom stok produk harus diisi'
                    ]
                ],
                'Limit' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom limit produk harus diisi'
                    ]
                ],
                'typeStok' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom jenis stok produk harus diisi'
                    ]
                ],
                'typeLimit' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom jenis limit produk harus diisi'
                    ]
                ],
                'Slug' => $slug,
                'Foto' => $foto
            ];
            $condition = 1;
            if ($this->validate($cekRule)) {
                $data = [];
                $qrCode =  session()->get('CodeQr');
                $wherUpdate = [
                    'CodeQr' => $qrCode
                ];
                $resultP = $this->M_Product->getData($wherUpdate)->getRow();
                $slug = strtolower(str_replace('', '-', $this->request->getVar('Name')) . '-' . str_replace('', '-', $this->request->getVar('Size')));
                $img = $this->request->getFile('Foto');
                if ($this->request->getVar('IsFoto') == 1) {
                    $newName = $img->getRandomName();
                    $data = [
                        'Name' => $this->request->getVar('Name'),
                        'Id_Type_Product' => $this->request->getVar('Type'),
                        'Id_Material_Product' => $this->request->getVar('Material'),
                        'Size' => $this->request->getVar('Size'),
                        'Limit' => $this->request->getVar('Limit'),
                        'TypeLimit' => $this->request->getVar('typeLimit'),
                        'Image' => 'Image/Product/' . $qrCode . '/' . $newName,
                        'Slug' => $slug,
                        'Capital_Price' => $this->request->getVar('Modal'),
                        'Per_Piece' => $this->request->getVar('Potong'),
                        'Per_Doze' => $this->request->getVar('Lusin'),
                        'Per_Kodi' => $this->request->getVar('Kodi'),
                        // 'Stock' => $this->request->getVar('Stok'),
                        // 'TypeStock' => $this->request->getVar('typeStok'),
                        'ModifiedBy' => session()->get('Username')
                    ];
                } else if ($this->request->getVar('IsFoto') == 2) {
                    $data = [
                        'Name' => $this->request->getVar('Name'),
                        'Id_Type_Product' => $this->request->getVar('Type'),
                        'Id_Material_Product' => $this->request->getVar('Material'),
                        'Size' => $this->request->getVar('Size'),
                        'Limit' => $this->request->getVar('Limit'),
                        'TypeLimit' => $this->request->getVar('typeLimit'),
                        'Slug' => $slug,
                        'Capital_Price' => $this->request->getVar('Modal'),
                        'Per_Piece' => $this->request->getVar('Potong'),
                        'Per_Doze' => $this->request->getVar('Lusin'),
                        'Per_Kodi' => $this->request->getVar('Kodi'),
                        // 'Stock' => $this->request->getVar('Stok'),
                        // 'TypeStock' => $this->request->getVar('typeStok'),
                        'ModifiedBy' => session()->get('Username')
                    ];
                } else {
                    $data = [
                        'Name' => $this->request->getVar('Name'),
                        'Id_Type_Product' => $this->request->getVar('Type'),
                        'Id_Material_Product' => $this->request->getVar('Material'),
                        'Size' => $this->request->getVar('Size'),
                        'Limit' => $this->request->getVar('Limit'),
                        'TypeLimit' => $this->request->getVar('typeLimit'),
                        'Slug' => $slug,
                        'Image' => null,
                        'Capital_Price' => $this->request->getVar('Modal'),
                        'Per_Piece' => $this->request->getVar('Potong'),
                        'Per_Doze' => $this->request->getVar('Lusin'),
                        'Per_Kodi' => $this->request->getVar('Kodi'),
                        // 'Stock' => $this->request->getVar('Stok'),
                        // 'TypeStock' => $this->request->getVar('typeStok'),
                        'ModifiedBy' => session()->get('Username')
                    ];
                }
                if ($this->M_Product->updateData($data, $wherUpdate)) {
                    if ($this->request->getVar('IsFoto') == 1) {
                        $img->move('Image/Product/' . $qrCode, $newName);
                    }
                    $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Memperbarui Data Produk', 1, 'Produk');
                    $this->C_Activity->insertActivityProduk($resultP->Id, 2, null, 0, 'Berhasil Memperbarui Data Produk', 1);
                    $condition = 1;
                } else {
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Memperbarui Data Produk', 0, 'Produk');
                    $this->C_Activity->insertActivityProduk($resultP->Id, 2, null, 0, 'Gagal Memperbarui Data Produk', 0);
                    $condition = 2;
                }
                // $condition = 0;
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

    public function getData()
    {
        if ($this->request->getVar('query') == '') {
            echo json_encode($this->M_Product->getDataJoin());
        } else {

            echo json_encode($this->M_Product->getDataJoin($this->request->getVar('query'))->getResult('array'));
        }
    }
    public function getDataOne()
    {
        echo json_encode($this->M_Product->getDataJoin($this->request->getVar('query'))->getRow());
        // echo json_encode($this->M_Product->getDataJoin($this->request->getVar('query'))->getRow());
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
                'ModifiedBy' => session()->get('Username')
            ];
            $where = [
                'Id' => $Id
            ];
            if ($this->M_Product->updateData($data, $where)) {
                $this->C_Activity->insertActivityProduk($Id, 2, null, 0, 'Berhasil Mengubah Status Produk', 1);
                $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Mengubah Status ' . $statusData . ' Produk', 1, 'Produk');
                echo json_encode(1);
            } else {
                $this->C_Activity->insertActivityProduk($Id, 2, null, 0, 'Berhasil Mengubah Status Produk', 0);
                $this->C_Activity->Employee(session()->get('Username'), 'Gagal Mengubah Status ' . $statusData . ' Produk', 0, 'Produk');
                echo json_encode(0);
            }
        } else {
            echo json_encode(2);
        }
    }

    public function getCustomPrice()
    {

        $whereProduct = [
            'CodeQr' => session()->get('CodeQr')
        ];
        $resultProduct = $this->M_Product->getData($whereProduct)->getRow();
        $whereCustom = [
            'Id_Product' => $resultProduct->Id
        ];
        echo json_encode($this->M_PriceProduct->getData($whereCustom)->getResult('array'));
    }
    public function getPriceCustomeTrans()
    {
        echo json_encode($this->M_CustomerPriceProduct->getDataPriceTrans($this->request->getVar('query'))->getResult('array'));
    }
    public function getOneCustomPrice($id)
    {
        // $result = $this->M_CustomerPriceProduct->getData($this->request->getVar('query'))->getResult('array');
        // if (count($result) > 0) {
        //     echo json_encode([]);
        // } else {
        //     $whereGetPrice = [
        //         'm_price_product.Id' => $result[0]->Id_Price_Product
        //     ];

        //     echo json_encode($this->M_PriceProduct->getData($whereGetPrice)->getResult('array'));
        // }
        $whereGetPrice = [
            'm_price_product.Id' => $id
        ];

        echo json_encode($this->M_PriceProduct->getData($whereGetPrice)->getRow());
    }
    public function UpdateCustomPrice()
    {
        if (session()->get('status') == TRUE) {
            $condition = 1;
            $nameRules = [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom nama harus diisi'
                ]
            ];
            if ($this->request->getVar('IsName') == 1) {
                $whereCustomPriceProduct = [
                    'Id' => $this->request->getVar('Id')
                ];
                $resultCustomProduct = $this->M_PriceProduct->getData($whereCustomPriceProduct)->getRow();
                $whereName = [
                    'Name' => $this->request->getVar('Name'),
                    'Id_Product' => $resultCustomProduct->Id_Product
                ];
                $resultCustom = $this->M_PriceProduct->getData($whereName)->getNumRows();
                if ($resultCustom >= 1) {
                    $nameRules = [
                        'rules' => 'valid_email',
                        'errors' => [
                            'valid_email' => 'Nama custom harga sudah tersedia pada produk ini'
                        ]
                    ];
                }
            }
            $cekRule = [
                'Name' => $nameRules,
                'Potong' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom harga per-potong produk harus diisi'
                    ]
                ],
                'Lusin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom harga per-lusin produk harus diisi'
                    ]
                ],
                'Kodi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom harga per-kodi produk harus diisi'
                    ]
                ]
            ];
            if ($this->validate($cekRule)) {
                $data = [
                    'Name' => $this->request->getVar('Name'),
                    'Per_Piece' => $this->request->getVar('Potong'),
                    'Per_Dozen' => $this->request->getVar('Lusin'),
                    'Per_Kodi' => $this->request->getVar('Kodi'),
                    'ModifiedBy' => session()->get('Username')
                ];
                $whereCustomPriceProduct = [
                    'Id' => $this->request->getVar('Id')
                ];
                if ($this->M_PriceProduct->updateData($data, $whereCustomPriceProduct)) {
                    $this->C_Activity->insertActivityProduk($resultCustomProduct->Id_Product, 8, null, 0, 'Berhasil Memperbarui Data Custom Harga Produk', 1);
                    $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Memperbarui Data Custom Harga Produk', 1, 'Produk');
                    $condition = 1;
                } else {
                    $this->C_Activity->insertActivityProduk($resultCustomProduct->Id_Product, 8, null, 0, 'Gagal Memperbarui Data Custom Harga Produk', 0);
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Memperbarui Data Custom Harga Produk', 0, 'Produk');
                    $condition = 2;
                }
            } else {
                $condition = 0;
            }
            $dataResult = [
                'kondisi' => $condition,
                'error' =>  $this->validator->getErrors()
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
    public function AddCustomPrice()
    {
        if (session()->get('status') == TRUE) {
            $condition = 1;
            $whereProduct = [
                'CodeQr' => session()->get('CodeQr')
            ];
            $resultProduct = $this->M_Product->getData($whereProduct)->getRow();
            $whereName = [
                'Name' => $this->request->getVar('Name'),
                'Id_Product' => $resultProduct->Id
            ];
            $resultCustom = $this->M_PriceProduct->getData($whereName)->getNumRows();
            $nameRules = [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom nama harus diisi'
                ]
            ];
            if ($resultCustom >= 1) {
                $nameRules = [
                    'rules' => 'valid_email',
                    'errors' => [
                        'valid_email' => 'Nama custom harga sudah tersedia pada produk ini'
                    ]
                ];
            }
            $cekRule = [
                'Name' => $nameRules,
                'Potong' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom harga per-potong produk harus diisi'
                    ]
                ],
                'Lusin' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom harga per-lusin produk harus diisi'
                    ]
                ],
                'Kodi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom harga per-kodi produk harus diisi'
                    ]
                ]
            ];
            if ($this->validate($cekRule)) {
                $data = [
                    'Name' => $this->request->getVar('Name'),
                    'Id_Product' => $resultProduct->Id,
                    'Per_Piece' => $this->request->getVar('Potong'),
                    'Per_Dozen' => $this->request->getVar('Lusin'),
                    'Per_Kodi' => $this->request->getVar('Kodi'),
                    'Status' => 1,
                    'CreatedBy' => session()->get('Username'),
                    'ModifiedBy' => session()->get('Username')
                ];
                if ($this->M_PriceProduct->saveData($data)) {
                    $this->C_Activity->insertActivityProduk($resultProduct->Id, 7, null, 0, 'Berhasil Menambahkan Data Custom Harga Produk', 1);
                    $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Menambahkan Data Custom Harga Produk', 1, 'Produk');
                    $condition = 1;
                } else {
                    $this->C_Activity->insertActivityProduk($resultProduct->Id, 7, null, 0, 'Gagal Menambahkan Data Custom Harga Produk', 0);
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menambahkan Data Custom Harga Produk', 0, 'Produk');
                    $condition = 2;
                }
            } else {
                $condition = 0;
            }
            $dataResult = [
                'kondisi' => $condition,
                'error' =>  $this->validator->getErrors()
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

    public function UpdateStatusCustomPrice($Id, $Status)
    {
        $statusData = 'Aktif';
        if ($Status == 0) {
            $statusData = 'Tidak Aktif';
        }
        $data = [
            'Status' => $Status,
            'ModifiedBy' => session()->get('Username')
        ];
        $where = [
            'Id' => $Id
        ];
        if ($this->M_PriceProduct->updateData($data, $where)) {
            $this->C_Activity->insertActivityProduk($Id, 2, null, 0, 'Berhasil Mengubah Status Produk', 1);
            $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Mengubah Status ' . $statusData . ' Harga Custom Produk', 1, 'Produk');
            echo json_encode(1);
        } else {
            $this->C_Activity->insertActivityProduk($Id, 2, null, 0, 'Gagal Mengubah Status Produk', 0);
            $this->C_Activity->Employee(session()->get('Username'), 'Gagal Mengubah Status ' . $statusData . ' Harga Custom Produk', 0, 'Produk');
            echo json_encode(0);
        }
    }

    public function getDataMemberPrice($id)
    {
        $where = [
            'Id_Price_Product' => $id
        ];
        echo json_encode($this->M_CustomerPriceProduct->getDataJoin($where)->getResult('array'));
    }
    public function getPriceProductTrans()
    {

        echo json_encode($this->M_PriceProduct->getData($this->request->getVar('query'))->getResult('array'));
    }
    public function getDataAddMemberPrice()
    {
        $whereProducts = [
            'CodeQr' => session()->get('CodeQr')
        ];
        $resultProduct = $this->M_Product->getData($whereProducts)->getRow();
        $wheres = "Name LIKE '%" . $this->request->getVar('query1') . "%'";
        $resultCus = $this->M_Customer->getData($wheres)->getResult('array');
        $dataArray = array();
        for ($i = 0; $i < count($resultCus); $i++) {
            $wherePP = [
                // 'Id_Price_Product' => $this->request->getVar('idProdCus'),
                'Id_Customer' => $resultCus[$i]['Id'],
                'Id_Product' => $resultProduct->Id
            ];
            $whereProductPrice = [
                'Id' => $this->request->getVar('idProdCus'),
                'Id_Product' => $resultProduct->Id
            ];
            $resultPRows = $this->M_PriceProduct->getData($whereProductPrice)->getNumRows();
            // echo json_encode($resultPRows);
            $resultPP = $this->M_CustomerPriceProduct->getData($wherePP)->getNumRows();
            if ($resultPP == 0) {
                $data = [
                    'Name' => $resultCus[$i]['Name'],
                    'Id' => $resultCus[$i]['Id'],
                ];
                array_push($dataArray, $data);
            }
        }
        echo json_encode($dataArray);
    }
    public function AddMemberPrice()
    {
        if (session()->get('status') == TRUE) {
            $condition = 1;
            $whereProducts = [
                'CodeQr' => session()->get('CodeQr')
            ];
            $resultProduct = $this->M_Product->getData($whereProducts)->getRow();
            $data = [
                'Id_Price_Product' => $this->request->getVar('IdPricepRo'),
                'Id_Customer' => $this->request->getVar('IdCus'),
                'Id_Product' => $resultProduct->Id,
                'Status' => 1,
                'CreatedBy' => session()->get('Username'),
                'ModifiedBy' => session()->get('Username'),
            ];
            if ($this->M_CustomerPriceProduct->saveData($data)) {
                $this->C_Activity->insertActivityProduk($resultProduct->Id, 5, null, 0, 'Berhasil Menambahkan Data Member Custom Harga Produk', 1);
                $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Menambahkan Data Member Custom Harga Produk', 1, 'Produk');
                $condition = 1;
            } else {
                $this->C_Activity->insertActivityProduk($resultProduct->Id, 5, null, 0, 'Gagal Menambahkan Data Member Custom Harga Produk', 0);
                $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menambahkan Data Member Custom Harga Produk', 0, 'Produk');
                $condition = 0;
            }
            echo json_encode($condition);
        } else {
            echo json_encode(2);
        }
    }
    public function AddMemberPriceTrans()
    {
        if (session()->get('status') == TRUE) {
            $condition = 1;

            $data = [
                'Id_Price_Product' => $this->request->getVar('IdPriceProduct'),
                'Id_Customer' => $this->request->getVar('IdCustomer'),
                'Id_Product' => $this->request->getVar('IdProduct'),
                'Status' => 1,
                'CreatedBy' => session()->get('Username'),
                'ModifiedBy' => session()->get('Username'),
            ];
            if ($this->M_CustomerPriceProduct->saveData($data)) {
                $this->C_Activity->insertActivityProduk($this->request->getVar('IdProduct'), 5, null, 0, 'Berhasil Menambahkan Data Member Custom Harga Produk', 1);
                $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Menambahkan Data Member Custom Harga Produk', 1, 'Produk');
                $condition = 1;
            } else {
                $this->C_Activity->insertActivityProduk($this->request->getVar('IdProduct'), 5, null, 0, 'Gagal Menambahkan Data Member Custom Harga Produk', 0);
                $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menambahkan Data Member Custom Harga Produk', 0, 'Produk');
                $condition = 0;
            }
            echo json_encode($condition);
        } else {
            echo json_encode(2);
        }
    }
    public function DeleteMemberPrice()
    {
        if (session()->get('status') == TRUE) {
            $condition = 1;
            $where = [
                'Id' => (int) $this->request->getVar('Id')
            ];
            $resultDAta = $this->M_CustomerPriceProduct->getData($where)->getRow();
            $dataTemp = [
                'Id_Price_Product' => $resultDAta->Id_Price_Product,
                'Id_Customer' => $resultDAta->Id_Customer,
                'Id_Product' => $resultDAta->Id_Product,
                'CreatedBy' => session()->get('Username'),
                'ModifiedBy' => session()->get('Username'),
            ];
            if ($this->M_CustomerPriceProduct->hapus($where)) {
                $this->Temp_CustomerPriceProduct->saveData($dataTemp);
                $this->C_Activity->insertActivityProduk($resultDAta->Id_Product, 6, null, 0, 'Berhasil Menghapus Data Member Custom Harga Produk', 1);
                $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Menghapus Data Member Custom Harga Produk', 1, 'Produk');
                $condition = 1;
            } else {
                $this->C_Activity->insertActivityProduk($resultDAta->Id_Product, 6, null, 0, 'Gagal Menghapus Data Member Custom Harga Produk', 0);
                $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menghapus Data Member Custom Harga Produk', 0, 'Produk');
                $condition = 0;
            }
            echo json_encode($condition);
        } else {
            echo json_encode(2);
        }
    }
    public function addStok()
    {
        if (session()->get('status') == TRUE) {
            $condition = 1;
            $cekRule = [
                'Stok' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom stok produk harus diisi'
                    ]
                ],
                'typeStok' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom jenis stok produk harus diisi'
                    ]
                ]
            ];
            if ($this->validate($cekRule)) {
                $whereType = [
                    'Id' => $this->request->getVar('typeStok')
                ];
                $resultData = $this->M_TypeItem->getData($whereType)->getRow();
                $whereProduct = [
                    'Id' => $this->request->getVar('Id')
                ];
                $resultProduct = $this->M_Product->getData($whereProduct)->getRow();
                $whereType2 = [
                    'Id' => $resultProduct->TypeStock
                ];
                $resultDataProductType = $this->M_TypeItem->getData($whereType2)->getRow();
                $data = [];
                if ($this->request->getVar('typeStok') == 1) {
                    $plus = (float) $resultProduct->Stock_Piece + (int) $this->request->getVar('Stok');
                    $data = [
                        'Stock' => $plus,
                        'Stock_Piece' => $plus
                    ];
                } else {

                    $hasil = (int) $this->request->getVar('Stok') * (int) $resultData->Per_Piece;
                    $plus = (int) $resultProduct->Stock_Piece + $hasil;
                    $konversi = $plus / $resultDataProductType->Per_Piece;
                    $data = [
                        'Stock' =>  $konversi,
                        'Stock_Piece' => $plus
                    ];
                }
                if ($this->M_Product->updateData($data, $whereProduct)) {
                    $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Menambahkan Stok Produk', 1, 'Produk');
                    $this->C_Activity->insertActivityProduk($this->request->getVar('Id'), 3, $resultData->Name, $this->request->getVar('Stok'), 'Berhasil Menambahkan Stok Produk', 1);
                    // $this->C_Activity->SetLogStock($this->request->getVar('Id'), $resultProduct->Name . '-' . $resultProduct->Size, $this->request->getVar('Stok'), $resultData->Name);
                    $condition = 1;
                } else {
                    $this->C_Activity->insertActivityProduk($this->request->getVar('Id'), 3, $resultData->Name, $this->request->getVar('Stok'), 'Gagal Menambahkan Stok Produk', 0);
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menambahkan Stok Produk', 0, 'Produk');
                    $condition = 2;
                }
            } else {
                $condition = 0;
            }
            $dataResult = [
                'kondisi' => $condition,
                'error' =>  $this->validator->getErrors()
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

    public function ReportProduk()
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));

            $setData = [
                'NamaPage' => 'Laporan Produk',
                'IconPage' => 'Laporan Produk'
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();

            if (session()->get('Role') == 1) {
                return view('Product/V_Report_Owner');
            }
        } else {
            return  redirect()->to(base_url('/'));
        }
    }
    public function InfoProduk($code)
    {
        if (
            session()->get('status') == TRUE
        ) {
            // return  redirect()->to(base_url('Home'));
            $setData = [
                'NamaPage' => 'Informasi Produk',
                'IconPage' => 'Produk',
                'CodeQr' => $code
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();
            return view('Product/V_InfoProduct');
        } else {
            return  redirect()->to(base_url('/'));
        }
    }

    public function getInfoProduct()
    {
        // 1. Get Product
        $whereProduct = [
            'm_product.CodeQr' => session()->get('CodeQr')
        ];
        $resultProduct = $this->M_Product->getDataJoin($whereProduct)->getRow();
        $isProduct = $this->request->getVar('IsProduct');

        //2. Get Harga
        $wherePrice = 'Id_Product =' . $resultProduct->Id . ' AND ' . $this->request->getVar('queryPrice');
        $resultPrice = $this->M_PriceProduct->getData($wherePrice)->getResult('array');
        $isHarga = $this->request->getVar('IsPrice');

        //3. Get Log
        $whereLog = [
            'Id_Product' => $resultProduct->Id
        ];
        $resultLog = $this->M_ActivityProduk->getData2($whereLog, 'DESC')->getResult('array');
        $IsLog = $this->request->getVar('IsLog');

        // 4. Get Statistik
        $statistik = array();
        $idStatik = $this->request->getVar('IsStatik');
        for ($i = 0; $i < 12; $i++) {
            $month = $i + 1;
            $dateNowTahunan = $this->request->getVar('yearStatik') . '-' . $month . '-01';
            $dateAddOneTahunan = date('Y-m-d', strtotime($dateNowTahunan . ' +1 month'));
            $whereproduksiTahunan = "CreatedDate >= '$dateNowTahunan' AND CreatedDate < '$dateAddOneTahunan' AND Status =8 AND Id_Product=" . $resultProduct->Id;
            $resultPeminatProduk = $this->T_DetailTrasaction->getData($whereproduksiTahunan)->getResult('array');
            $countValue = 0;
            foreach ($resultPeminatProduk as $row) {
                $countValue = $countValue + $row['Sum_Product_PerPiece'];
            }
            $temp = [
                'Bulan' => ($i + 1),
                'Value' => $countValue
            ];
            array_push($statistik, $temp);
        }

        $data = [
            'Product' =>  $resultProduct,
            'IsProduct' => $isProduct,
            'Harga' =>  $resultPrice,
            'IsHarga' =>  $isHarga,
            'Log' =>  $resultLog,
            'IsLog' =>  $IsLog,
            'Statik' =>  $statistik,
            'IsStatik' =>  $idStatik,
        ];

        echo json_encode($data);
    }

    public function getDataDashboard()
    {
        $produksiTahunan = array();
        for ($i = 0; $i < 12; $i++) {
            $month = $i + 1;
            $dateNowTahunan = date("Y") . '-' . $month . '-01';
            $dateAddOneTahunan = date('Y-m-d', strtotime($dateNowTahunan . ' +1 month'));
            $whereproduksiTahunan = "CreatedDate >= '$dateNowTahunan' AND CreatedDate < '$dateAddOneTahunan' AND Status IN(3,4)";
            $resultProduksiTahunan = $this->M_ActivityProduk->getData($whereproduksiTahunan)->getResult('array');
            $tempMasuk = 0;
            $tempKeluar = 0;
            foreach ($resultProduksiTahunan as $row) {
                $pcs = 1;
                if ($row['Satuan'] == "Lusin") {
                    $pcs = 12;
                } else if ($row['Satuan'] == "Kodi") {
                    $pcs = 20;
                }
                if ($row['Status'] == 3) {
                    $temp = $row['Stock'] * $pcs;
                    $tempMasuk = $tempMasuk + $temp;
                } else {
                    $temp = $row['Stock'] * $pcs;
                    $tempKeluar = $tempKeluar + $temp;
                }
            }

            $temparray = [
                'Masuk' => $tempMasuk,
                'Keluar' => $tempKeluar,
            ];
            array_push($produksiTahunan, $temparray);
        }

        echo json_encode($produksiTahunan);
    }

    public function getDataReportOwner()
    {
        if ($this->request->getVar('IsFilter') == 0) {
            $data = [
                'data' => array(),
                'jumlah' => 0,
                'isFilter' => 0
            ];
            echo json_encode($data);
        } else {
            $where = $this->request->getVar('Query');
            $sort = $this->request->getVar('Urutan');

            $result = $this->M_ActivityProduk->getDataReport($where, $sort)->getResult('array');
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
                'data' => $result,
                'jumlah' => $jumlah,
                'isFilter' => 1
            ];
            $sessionQuery = [
                'QueryLaporanProduk' => $where,
                'SortLaporanProduk' => $sort,
            ];
            session()->set($sessionQuery);

            echo json_encode($data);
        }
    }
    public function ExportToExcel()
    {


        $result = $this->M_ActivityProduk->getDataReport(session()->get('QueryLaporanProduk'), session()->get('SortLaporanProduk'))->getResult('array');
        $datas = $result;

        $dates = $this->request->getVar('Tanggal');
        $file_name = 'Export Data Laporan Produk (' . $dates . ').xlsx';
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
        $sheet->setCellValue('A1', 'Nama Produk');
        $sheet->setCellValue('B1', 'Ukuran');
        $sheet->setCellValue('C1', 'Jumlah');
        $sheet->setCellValue('D1', 'Satuan');
        $sheet->setCellValue('E1', 'Tanggal');
        $sheet->setCellValue('F1', 'Status');
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleHeader);
        $count = 2;
        $Total = 0;
        // for ($i = 0; $i < 10; $i++) {
        foreach ($datas as $row) {
            $metode = 'Tunai';
            // if ($row['Image']) {
            //     $metode = 'Transfer';
            // }
            // $sum = 0;
            // if ($row['OverPay'] == 0) {
            //     $temp = $row['Payment'] -  $row['ChangePay'];
            //     $sum = $sum + $temp;
            // } else {
            //     $sum = $sum +  $row['Payment'];
            // }
            // $Total = $Total + $sum;
            $sheet->setCellValue('A' . $count, $row['Name']);
            $sheet->setCellValue('B' . $count, $row['Size']);

            $sheet->setCellValue('C' . $count, $row['Stock']);

            $sheet->setCellValue('D' . $count, $row['Satuan']);

            $sheet->setCellValue('E' . $count, $row['CreatedDate']);
            $sheet->setCellValue('F' . $count,  $row['JenisSTok']);

            $count++;
        }
        // $sheet->setCellValue('A' . $count, 'Total Omset');
        // $sheet->setCellValue('F' . $count, number_format($Total, 2, ",", "."));
        // $spreadsheet->getActiveSheet()->mergeCells('A' . $count . ':E' . $count);
        // $spreadsheet->getActiveSheet()->getStyle('A' . $count)->applyFromArray($styleHeader);
        // $spreadsheet->getActiveSheet()->getStyle('F' . $count)->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('A1:F' . ($count - 1))->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        // $spreadsheet->getActiveSheet()->freezePane('D2');

        $writer = new Xlsx($spreadsheet);
        $fileSave = 'Laporan/Produk/' . $file_name;
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


    #endregion


    #region Data Jenis Produk
    public function listTypeProduct()
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));
            $setData = [
                'NamaPage' => 'Jenis Produk',
                'IconPage' => 'Produk'
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();
            return view('Product/V_TypeProduct');
        } else {
            return  redirect()->to(base_url('/'));
        }
    }
    public function getDataTypeProduct()
    {
        if ($this->request->getVar('query') == '') {
            echo json_encode($this->M_TypeProduct->getData());
        } else {
            echo json_encode($this->M_TypeProduct->getData($this->request->getVar('query'))->getResult('array'));
        }
    }

    public function SaveDataTypeProducts()
    {
        if (session()->get('status') == TRUE) {
            $condition = 0;
            $cekRule = [
                'Name' => [
                    'rules' => 'required|is_unique[m_type_produk.Name]',
                    'errors' => [
                        'required' => 'Kolom nama jenis produk harus diisi',
                        'is_unique' => 'Jenis Produk Sudah Tersedia'
                    ]
                ],
                'Description' => [
                    'rules' => 'permit_empty'
                ]
            ];
            if ($this->validate($cekRule)) {
                $data = [
                    'Name' => $this->request->getVar('Name'),
                    'Description' => $this->request->getVar('Description'),
                    'Status' => 1,
                    'CreatedBy' => session()->get('Username'),
                    'ModifiedBy' => session()->get('Username')
                ];
                if ($this->M_TypeProduct->saveData($data)) {
                    $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Menambahkan Data Jenis Produk', 1, 'Produk');
                    $condition = 1;
                } else {
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menambahkan Data Jenis Produk', 0, 'Produk');
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

    public function UpdateDataTypeProduct()
    {
        if (session()->get('status') == TRUE) {
            $condition = 0;
            $name = [
                'rules' => 'permit_empty'
            ];
            if ($this->request->getVar('IsName') == 1) {
                $name = [
                    'rules' => 'required|is_unique[m_type_produk.Name]',
                    'errors' => [
                        'required' => 'Kolom nama jenis produk harus diisi',
                        'is_unique' => 'Jenis Produk Sudah Tersedia'
                    ]
                ];
            }
            $cekRule = [
                'Name' =>  $name,
                'Description' => [
                    'rules' => 'permit_empty'
                ]
            ];
            if ($this->validate($cekRule)) {
                $data = [
                    'Name' => $this->request->getVar('Name'),
                    'Description' => $this->request->getVar('Description'),
                    'ModifiedBy' => session()->get('Username')
                ];
                $where = [
                    'Id' => $this->request->getVar('Id')
                ];
                if ($this->M_TypeProduct->updateData($data, $where)) {
                    $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Mengubah Data Jenis Produk', 1, 'Produk');
                    $condition = 1;
                } else {
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Mengubah Data Jenis Produk', 0, 'Produk');
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

    public function UpdateStatusTypeProduct($Id, $Status)
    {
        if (session()->get('status') == TRUE) {
            $statusData = 'Aktif';
            if ($Status == 0) {
                $statusData = 'Tidak Aktif';
            }
            $data = [
                'Status' => $Status,
                'ModifiedBy' => session()->get('Username')
            ];
            $where = [
                'Id' => $Id
            ];
            if ($this->M_TypeProduct->updateData($data, $where)) {
                $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Mengubah Status ' . $statusData . ' Jenis Produk', 1, 'Produk');
                echo json_encode(1);
            } else {
                $this->C_Activity->Employee(session()->get('Username'), 'Gagal Mengubah Status ' . $statusData . ' Jenis Produk', 0, 'Produk');
                echo json_encode(0);
            }
        } else {
            echo json_encode(2);
        }
    }
    #endregion

    #region Data Bahan Produk
    public function listMaretrialProduct()
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));
            $setData = [
                'NamaPage' => 'Bahan Produk',
                'IconPage' => 'Produk'
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();
            return view('Product/V_MaterialProduct');
        } else {
            return  redirect()->to(base_url('/'));
        }
    }

    public function getDataMaterialProduct()
    {
        if ($this->request->getVar('query') == '') {
            echo json_encode($this->M_MaterialProduct->getData());
        } else {
            echo json_encode($this->M_MaterialProduct->getData($this->request->getVar('query'))->getResult('array'));
        }
    }

    public function SaveDataMaterialProduct()
    {
        if (session()->get('status') == TRUE) {
            $condition = 0;
            $cekRule = [
                'Name' => [
                    'rules' => 'required|is_unique[m_type_produk.Name]',
                    'errors' => [
                        'required' => 'Kolom nama jenis produk harus diisi',
                        'is_unique' => 'Jenis Produk Sudah Tersedia'
                    ]
                ],
                'Description' => [
                    'rules' => 'permit_empty'
                ]
            ];
            if ($this->validate($cekRule)) {
                $data = [
                    'Name' => $this->request->getVar('Name'),
                    'Description' => $this->request->getVar('Description'),
                    'Status' => 1,
                    'CreatedBy' => session()->get('Username'),
                    'ModifiedBy' => session()->get('Username')
                ];
                if ($this->M_MaterialProduct->saveData($data)) {
                    $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Menambahkan Data Bahan Produk', 1, 'Produk');
                    $condition = 1;
                } else {
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menambahkan Data Bahan Produk', 0, 'Produk');
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

    public function UpdateDataMaterialProduct()
    {
        if (session()->get('status') == TRUE) {
            $condition = 0;
            $name = [
                'rules' => 'permit_empty'
            ];
            if ($this->request->getVar('IsName') == 1) {
                $name = [
                    'rules' => 'required|is_unique[m_type_produk.Name]',
                    'errors' => [
                        'required' => 'Kolom nama jenis produk harus diisi',
                        'is_unique' => 'Bahan Produk Sudah Tersedia'
                    ]
                ];
            }
            $cekRule = [
                'Name' =>  $name,
                'Description' => [
                    'rules' => 'permit_empty'
                ]
            ];
            if ($this->validate($cekRule)) {
                $data = [
                    'Name' => $this->request->getVar('Name'),
                    'Description' => $this->request->getVar('Description'),
                    'ModifiedBy' => session()->get('Username')
                ];
                $where = [
                    'Id' => $this->request->getVar('Id')
                ];
                if ($this->M_MaterialProduct->updateData($data, $where)) {
                    $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Mengubah Data Bahan Produk', 1, 'Produk');
                    $condition = 1;
                } else {
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Mengubah Data Bahan Produk', 0, 'Produk');
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

    public function UpdateStatusMaterialProduct($Id, $Status)
    {
        if (session()->get('status') == TRUE) {
            $statusData = 'Aktif';
            if ($Status == 0) {
                $statusData = 'Tidak Aktif';
            }
            $data = [
                'Status' => $Status,
                'ModifiedBy' => session()->get('Username')
            ];
            $where = [
                'Id' => $Id
            ];
            if ($this->M_MaterialProduct->updateData($data, $where)) {
                $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Mengubah Status ' . $statusData . ' Bahan Produk', 1, 'Produk');
                echo json_encode(1);
            } else {
                $this->C_Activity->Employee(session()->get('Username'), 'Gagal Mengubah Status ' . $statusData . ' Bahan Produk', 0, 'Produk');
                echo json_encode(0);
            }
        } else {
            echo json_encode(2);
        }
    }

    #endregion


    #region Other
    public function generateRandomString()
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
    #endregion
}
