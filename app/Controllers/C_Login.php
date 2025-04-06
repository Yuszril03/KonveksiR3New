<?php

namespace App\Controllers;

use App\Models\Activity\M_ActivityEmploye;
use App\Models\Master\M_AccountEmployee;
use App\Models\Master\M_Employee;
use App\Models\Master\M_Role;
use DateTime;
use Config\App;

class C_Login extends BaseController
{
    protected $session;
    protected $M_Employe;
    protected $M_AccountEmploye;
    protected $M_ActivityEmploye;
    protected $Config;
    protected $M_Role;
    protected $C_Activity;
    public function __construct()
    {

        $this->session = \Config\Services::session();
        $this->M_Employe = new M_Employee();
        $this->M_AccountEmploye = new M_AccountEmployee();
        $this->M_ActivityEmploye = new M_ActivityEmploye();
        $this->Config = new App();

        $this->M_Role = new M_Role();
        $this->C_Activity = new C_Activity();
        // $this->session->stat();
    }
    public function index()
    {
        if (session()->get('status') == TRUE) {
            $this->C_Activity->LastActiveUser();
            return  redirect()->to(base_url('/Beranda'));
        } else {

            return view('Login/V_Login2');
        }
    }
    public function account()
    {
        if (session()->get('status') == TRUE) {
            $setData = [
                'NamaPage' => 'Profil',
                'IconPage' => 'Profil'
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();
            return view('Login/V_Account');
        } else {
            return  redirect()->to(base_url('/Masuk'));
        }
    }
    public function changePassword()
    {
        if (session()->get('status') == TRUE) {
            $setData = [
                'NamaPage' => 'Ubah Kata Sandi',
                'IconPage' => 'Ubah Kata Sandi'
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();
            return view('Login/V_Password');
        } else {
            return  redirect()->to(base_url('/Masuk'));
        }
    }
    public function SavePassword()
    {
        if (session()->get('status') == TRUE) {
            $ktLama = $this->request->getVar('ktLama');
            $ktBaru = $this->request->getVar('ktBaru');
            $ktBaruKof = $this->request->getVar('ktBaruKof');
            $whereAccount = [
                'Username' => session()->get('Username')
            ];
            $resultData = $this->M_AccountEmploye->getData($whereAccount)->getRow();
            $Lama = [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Kolom kata sandi harap diisi',
                    'min_length' => 'Kata sandi minimal 8 karakter'
                ]
            ];
            $Baru = [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Kolom kata sandi harap diisi',
                    'min_length' => 'Kata sandi minimal 8 karakter'
                ]
            ];
            $BaruKof = [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Kolom kata sandi harap diisi',
                    'min_length' => 'Kata sandi minimal 8 karakter'
                ]
            ];
            if (md5($ktLama) != $resultData->Password && $ktLama != '') {
                $Lama = [
                    'rules' => 'min_length[200]',
                    'errors' => [
                        'min_length' => 'Kata Sandi tidak sama'
                    ]
                ];
            }
            if ($ktLama == $ktBaru) {
                $Baru = [
                    'rules' => 'min_length[200]',
                    'errors' => [
                        'min_length' => 'Kata sandi baru tidak boleh sama dengan yang lama'
                    ]
                ];
            }
            if ($ktBaru != $ktBaruKof && $ktBaruKof != '') {
                $BaruKof = [
                    'rules' => 'min_length[200]',
                    'errors' => [
                        'min_length' => 'Kata sandi tidak sama'
                    ]
                ];
            }
            $cekUser = [
                'ktLama' => $Lama,
                'ktBaru' => $Baru,
                'ktBaruKof' => $BaruKof,
            ];
            $kondisi = 0;
            if ($this->validate($cekUser)) {
                $dataEmploye = [
                    'ModifiedBy' => session()->get('Username')
                ];
                $dataAccounts = [
                    'Password' => md5($ktBaru)
                ];
                if ($this->M_AccountEmploye->updateData($dataAccounts, $whereAccount)) {
                    $this->M_Employe->updateData($dataEmploye, $whereAccount);
                    $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Memperbarui Kata Sandi Profil', 1, 'Employee');
                    $kondisi = 1;
                } else {
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Memperbarui Kata Sandi Profil', 0, 'Employee');
                    $kondisi = 2;
                }
            } else {
                $kondisi = 0;
            }
            $dataResult = [
                'kondisi' => $kondisi,
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
    public function UpdateDataEmployee()
    {
        if (session()->get('status') == TRUE) {
            $telefons = [
                'rules' => 'required|is_unique[m_employee.Telephone]|min_length[12]',
                'errors' => [
                    'required' => 'Kolom nomor telefon harap diisi',
                    'is_unique' => 'Nomor telefon sudah tersedia',
                    'min_length' => 'Nomor telefon kurang dari 12 digit'
                ]
            ];
            $email = [
                'rules' => 'permit_empty|valid_email|is_unique[m_employee.Email]',
                'errors' => [
                    'is_unique' => 'Email sudah tersedia',
                    'valid_email' => 'Email tidak valid'
                ]
            ];
            if ($this->request->getVar('Telephone') == $this->request->getVar('tempTelefon')) {
                $telefons = [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom nomor telefon harap diisi'
                    ]
                ];
            }
            if ($this->request->getVar('TempEmail') == $this->request->getVar('Email')) {
                $email = [
                    'rules' => 'permit_empty'
                ];
            }

            $cekUser = [
                'Telephone' =>  $telefons,
                'Email' =>  $email,
                'Address' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom alamat harus diisi'
                    ]
                ]
            ];
            $kondisi = 0;
            // $this->validate($cekUser);
            if ($this->validate($cekUser)) {
                $where = [
                    'Id' => session()->get('Id')
                ];
                $data = [
                    'Telephone' => $this->request->getVar('Telephone'),
                    'Country_Telephone' => $this->request->getVar('CountryTelephone'),
                    'Email' => $this->request->getVar('Email'),
                    'Address' => $this->request->getVar('Address'),
                    'ModifiedBy' => session()->get('Username')
                ];
                if ($this->M_Employe->updateData($data, $where)) {
                    $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Memperbarui Data Karyawan', 1, 'Karyawan');
                    $kondisi = 1;
                } else {
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Memperbarui Data Karyawan', 0, 'Karyawan');
                    $kondisi = 2;
                }
            } else {
                $kondisi = 0;
            }
            // $data = [
            //     'Telephone' => $this->request->getVar('Telephone'),
            //     'Country_Telephone' => $this->request->getVar('CountryTelephone'),
            //     'Email' => $this->request->getVar('Email'),
            //     'Address' => $this->request->getVar('Address'),
            //     'ModifiedBy' => session()->get('Username')
            // ];
            $dataResult = [
                'kondisi' =>   $kondisi,
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
    public function saveImage()
    {
        if (session()->get('status') == TRUE) {
            $foto = [
                'rules' => 'permit_empty|max_size[Foto,1024]|ext_in[Foto,png,jpg]',
                'errors' => [
                    'max_size' => 'Ukuran foto makasimal 1 MB',
                    'ext_in' => 'Tipe foto harus PNG dan JPG'
                ]
            ];
            if ($this->request->getVar('IsFoto') == 0 || $this->request->getVar('IsFoto') == 2) {
                $foto = [
                    'rules' => 'permit_empty'
                ];
            }
            $cekRule = ['Foto' => $foto];
            $condition = 1;
            if ($this->validate($cekRule)) {
                $where = [
                    'Id' => session()->get('Id')
                ];
                $resultData = $this->M_Employe->getData($where)->getRow();
                $img = $this->request->getFile('Foto');
                $data = [];
                $dataSession = [];
                $namaFoto = '';
                if ($this->request->getVar('IsFoto') == 1) {
                    $namaFoto = $img->getRandomName();
                    $data = [
                        'ImageProfile' => 'Image/Employe/' . $resultData->Slug . '/' . $namaFoto,
                        'ModifiedBy' => session()->get('Username')
                    ];
                    $dataSession = [
                        'Image' => 'Image/Employe/' . $resultData->Slug . '/' . $namaFoto
                    ];
                } else if ($this->request->getVar('IsFoto') == 0) {
                    $data = [
                        'ImageProfile' => null,
                        'ModifiedBy' => session()->get('Username')
                    ];
                    $dataSession = [
                        'Image' => null
                    ];
                }

                if ($this->request->getVar('IsFoto') == 2) {
                    $condition = 1;
                } else {
                    if ($this->M_Employe->updateData($data, $where)) {
                        if ($this->request->getVar('IsFoto') == 1) {
                            $img->move('Image/Employe/' . $resultData->Slug, $namaFoto);
                        }
                        session()->set($dataSession);
                        $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Memperbarui Data Profil', 1, 'Employe');
                        $condition = 1;
                    } else {
                        $this->C_Activity->Employee(session()->get('Username'), 'Gagal Memperbarui Data Profil', 0, 'Employe');
                        $condition = 2;
                    }
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

    public function getDataProfil()
    {
        $where = [
            'm_employee.Id' => session()->get('Id')
        ];
        echo json_encode($this->M_Employe->getDataJoin($where)->getRow());
    }

    public function AuthLogin()
    {
        $username = strtolower($this->request->getVar('username'));
        $pass = $this->request->getVar('pass');

        $dataAccount = [
            'LOWER(Username)' => $username,
            'Password' => md5($pass)
        ];
        $dataEmploye = [
            'LOWER(Username)' => $username
        ];
        $CheckUser = $this->M_AccountEmploye->getData($dataAccount)->getNumRows();
        $AccountUserss = $this->M_AccountEmploye->getData($dataAccount)->getRow();
        if ($CheckUser > 0) {
            $getUser = $this->M_Employe->getDataJoin($dataEmploye)->getRow();
            if ($getUser->Status == 1) {

                $tanggalLastActive = new DateTime($AccountUserss->LastActive);
                $tanggalNow = new DateTime();
                $selisih  = $tanggalNow->getTimestamp() - $tanggalLastActive->getTimestamp();

                // if ($selisih <= $this->Config->sessionExpiration && $AccountUserss->Status == 1) {
                //     session()->setFlashdata('pesan', 'Pegawai sedang aktif di device lain, Mohon untuk melakukan konfirmasi jika ingin login');
                //     $this->C_Activity->Employee($username, 'Pegawai sedang aktif di device lain', 0, 'Login');
                //     return redirect()->to(base_url('/'));
                // } else {
                $ShortNameArray = explode(" ", $getUser->Name);
                $tempShort = '';
                if (count($ShortNameArray) > 1) {
                    $tempShort = $ShortNameArray[0] . '...';
                } else {
                    $tempShort = $ShortNameArray[0];
                }
                $sessionID = $this->createGuidData();
                $date = new DateTime();
                $resultDate = $date->format('Y-m-d H:i:s');
                $dataSession = [
                    'SessionID' => $sessionID,
                    'status' => TRUE,
                    'Id' => $getUser->Id,
                    'Username' => $getUser->Username,
                    'Gender' => $getUser->Gender,
                    'Image' => $getUser->ImageProfile,
                    'Name' => $getUser->Name,
                    'ShortName' => $tempShort,
                    'Superior' => $getUser->Superior,
                    'Position' => $getUser->IdPosition,
                    'NamePosition' => $getUser->NamePosition,
                    'Role' => $getUser->IdRole,
                    'RoleName' => $getUser->NameRole,
                    'Root' => $getUser->Root,
                ];
                session()->set($dataSession);
                // session()->start();
                $this->C_Activity->Employee($username, 'Berhasil Melakukan Login Aplikasi', 1, 'Login');
                $dataUpdateAccount = [
                    // 'Status' => 1,
                    'IdSession' => $sessionID,
                    'LastActive' => $resultDate,
                ];
                $this->M_AccountEmploye->updateData($dataUpdateAccount, $dataAccount);
                if ($getUser->IdRole == 2 && $getUser->IdPosition == 2) {

                    return redirect()->to(base_url('/Transaksi'));
                }
                return redirect()->to(base_url('/Beranda'));
                // }

            } else {
                session()->setFlashdata('pesan', 'Pegawai sudah tidak aktif');
                $this->C_Activity->Employee($username, 'Pegawai sudah tidak aktif', 0, 'Login');
                return redirect()->to(base_url('/'));
            }
        } else {
            session()->setFlashdata('pesan', 'Username dan Kata Sandi Tidak Sesuai');
            $this->C_Activity->Employee($username, 'Username dan Kata Sandi Tidak Sesuai', 0, 'Login');
            return redirect()->to(base_url('/'));
        }
    }

    public function aktif()
    {
        echo json_encode(session()->get('status'));
        // if($dateUser == ''){
        //     return 1;
        // }else{
        //     $tanggal_1 = date_create($dateUser);
        //     // waktu sekarnag
        //     $tanggal_2 = date_create();
        //     // date_diff adalah fungsi php dalam menghitung har
        //     $selisih  = date_diff($tanggal_1, $tanggal_2);
        //     $seccond = $selisih->i * 60;
        //     // $this->Config->sessionExpiration
        //     echo json_encode($selisih->i * 60);
        // }

    }
    public function cekUthActive()
    {
        $where = [
            'IdSession' => session()->get('SessionID')
        ];
        $resultData = $this->M_AccountEmploye->getData($where)->getNumRows();
        echo json_encode($resultData);
    }
    public function logoutAlert()
    {
        $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Melakukan Logout Aplikasi', 1, 'Logout');
        // session()->close();

        session()->destroy();
        return redirect()->to(base_url('/'));
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

    public function checkDataUser()
    {
        echo json_encode(session()->get());
    }

    public function Logout()
    {
        $this->C_Activity->LogoutActiveUser();
        $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Melakukan Logout Aplikasi', 1, 'Logout');
        // session()->close();

        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
