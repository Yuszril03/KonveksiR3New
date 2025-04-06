<?php

namespace App\Controllers;

use App\Models\Master\M_Bank;
use App\Models\Master\M_PaymentMethod;

class C_PaymentMethod extends BaseController
{
    protected $C_Activity;
    protected $M_PaymentMethod;
    protected $M_Bank;
    public function __construct()
    {
        $this->C_Activity = new C_Activity();
        $this->M_PaymentMethod = new M_PaymentMethod();
        $this->M_Bank = new M_Bank();
        // $this->session->stat();
    }
    public function index()
    {
        if (session()->get('status') == TRUE) {

            $setData = [
                'NamaPage' => 'Metode Bayar',
                'IconPage' => 'Lainnya',
            ];
            session()->set($setData);
            return view('Others/V_MethodPayment');
        } else {
            return  redirect()->to(base_url('/'));
        }
    }
    public function getData()
    {
        if ($this->request->getVar('query') == '') {
            echo json_encode($this->M_PaymentMethod->getDataJoin());
        } else {
            echo json_encode($this->M_PaymentMethod->getDataJoin($this->request->getVar('query'))->getResult('array'));
        }
    }
    public function getDataBank()
    {
        echo json_encode($this->M_Bank->getData($this->request->getVar('query'))->getResult('array'));
    }

    public function SaveDataMethodPayment()
    {
        if (session()->get('status') == TRUE) {
            $condition = 0;
            $cekRule = [
                'Name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom nama pengguna rekening harus diisi',
                        'is_unique' => 'Jenis Produk Sudah Tersedia'
                    ]
                ],
                'Bank' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom jenis bank harus diisi',
                        // 'is_unique' => 'Jenis Produk Sudah Tersedia'
                    ]
                ],
                'Rekening' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom nomor rekening harus diisi',
                        // 'is_unique' => 'Jenis Produk Sudah Tersedia'
                    ]
                ]
            ];
            $this->validate($cekRule);
            $dataErrors = $this->validator->getErrors();
            if ($this->validate($cekRule)) {

                $whereCheckValidasi = [
                    'Number_Account' => $this->request->getVar('Rekening'),
                    'Id_Bank' => $this->request->getVar('Bank')
                ];
                $resultData = $this->M_PaymentMethod->getData($whereCheckValidasi)->getNumRows();
                if ($resultData > 0) {
                    $dataErrors = [
                        'Rekening' => 'Data pengguna sudah tersedia',
                        'Bank' => 'Data pengguna sudah tersedia',
                    ];
                    $condition = 0;
                } else {
                    $data = [
                        'Name' => $this->request->getVar('Name'),
                        'Number_Account' => $this->request->getVar('Rekening'),
                        'Id_Bank' => $this->request->getVar('Bank'),
                        'Status' => 1,
                        'CreatedBy' => session()->get('Username'),
                        'ModifiedBy' => session()->get('Username')
                    ];
                    if ($this->M_PaymentMethod->saveData($data)) {
                        $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Menambahkan Data Metode Bayar', 1, 'Metode Bayar');
                        $condition = 1;
                    } else {
                        $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menambahkan Data Metode Bayar', 0, 'Metode Bayar');
                        $condition = 2;
                    }
                }
            }
            $dataResult = [
                'kondisi' => $condition,
                'error' => $dataErrors
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

    public function EditDataMethodPayment()
    {
        if (session()->get('status') == TRUE) {
            $condition = 0;
            $cekRule = [
                'Name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom nama pengguna rekening harus diisi',
                        'is_unique' => 'Jenis Produk Sudah Tersedia'
                    ]
                ],
                'Bank' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom jenis bank harus diisi',
                        // 'is_unique' => 'Jenis Produk Sudah Tersedia'
                    ]
                ],
                'Rekening' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom nomor rekening harus diisi',
                        // 'is_unique' => 'Jenis Produk Sudah Tersedia'
                    ]
                ]
            ];
            $this->validate($cekRule);
            $dataErrors = $this->validator->getErrors();
            if ($this->validate($cekRule)) {

                $whereCheckValidasi = [
                    'Number_Account' => $this->request->getVar('Rekening'),
                    'Id_Bank' => $this->request->getVar('Bank')
                ];
                $resultData = $this->M_PaymentMethod->getData($whereCheckValidasi)->getNumRows();
                if ($resultData > 0 && $this->request->getVar('IsTrue') == 0) {
                    $dataErrors = [
                        'Rekening' => 'Data pengguna sudah tersedia',
                        'Bank' => 'Data pengguna sudah tersedia',
                    ];
                    $condition = 0;
                } else {
                    $data = [
                        'Name' => $this->request->getVar('Name'),
                        'Number_Account' => $this->request->getVar('Rekening'),
                        'Id_Bank' => $this->request->getVar('Bank'),
                        'ModifiedBy' => session()->get('Username')
                    ];
                    $whereData = [
                        'Id' => $this->request->getVar('Id')
                    ];
                    if ($this->M_PaymentMethod->updateData($data, $whereData)) {
                        $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Memperbarui Data Metode Bayar', 1, 'Metode Bayar');
                        $condition = 1;
                    } else {
                        $this->C_Activity->Employee(session()->get('Username'), 'Gagal Memperbarui Data Metode Bayar', 0, 'Metode Bayar');
                        $condition = 2;
                    }
                }
            }
            $dataResult = [
                'kondisi' => $condition,
                'error' => $dataErrors
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

    public function getTypeBankFilter()
    {
        $resultData = $this->M_PaymentMethod->GetTypeBank();
        $arrayData = [1];
        foreach ($resultData as $ro) {
            array_push($arrayData, $ro['Id_Bank']);
        }
        $whereIn = implode("','", $arrayData);
        $whereData = "Status = 1 OR Id IN('" . $whereIn . "')";
        echo json_encode($this->M_Bank->getData($whereData)->getResult('array'));
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
            if ($this->M_PaymentMethod->updateData($data, $where)) {
                $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Mengubah Status ' . $statusData . ' Metode Bayar', 1, 'Metode bayar');
                echo json_encode(1);
            } else {
                $this->C_Activity->Employee(session()->get('Username'), 'Gagal Mengubah Status ' . $statusData . ' Metode Bayar', 0, 'Metode Bayar');
                echo json_encode(0);
            }
        } else {
            echo json_encode(2);
        }
    }
}
