<?php

namespace App\Controllers;

use App\Models\Activity\M_ActivityEmploye;
use App\Models\Master\M_AccountEmployee;
use App\Models\Master\M_Customer;
use App\Models\Master\M_Employee;
use App\Models\Master\M_Position;
use App\Models\Master\M_Role;
use App\Models\Master\M_RolePosition;
use DateTime;

class C_Employee extends BaseController
{
    protected $M_Employee;
    protected $M_Role;
    protected $M_Position;
    protected $M_AccountEmployee;
    protected $M_RolePosition;
    protected $C_Activity;
    protected $C_Customer;
    protected $M_ActivityEmployee;
    protected $C_WhatsApp;
    public function __construct()
    {

        $this->M_Employee = new M_Employee();
        $this->M_Role = new M_Role();
        $this->M_Position = new M_Position();
        $this->M_AccountEmployee = new M_AccountEmployee();
        $this->M_RolePosition = new M_RolePosition();
        $this->C_Activity = new C_Activity();
        $this->C_Customer = new M_Customer();
        $this->C_WhatsApp = new C_WhatsApp();
        $this->M_ActivityEmployee = new M_ActivityEmploye();
    }
    public function index()
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));
            $setData = [
                'NamaPage' => 'Karyawan',
                'IconPage' => 'Karyawan'
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();
            return view('Employee/V_ListEmployee');
        } else {
            return  redirect()->to(base_url('/'));
        }
    }

    public function InfoEmployee($Slug)
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));
            $setData = [
                'NamaPage' => 'Informasi Karyawan',
                'IconPage' => 'Karyawan',
                'Slug' => $Slug
            ];
            session()->set($setData);
            // echo json_encode(session()->get('Slug'));
            $this->C_Activity->LastActiveUser();
            return view('Employee/V_InfoEmployee');
        } else {
            // $setData = [
            //     'NamaPage' => 'Informasi Karyawan',
            //     'IconPage' => 'Karyawan',
            //     'Slug' => $Slug
            // ];
            // session()->set($setData);
            return  redirect()->to(base_url('/'));
        }
    }

    public function getInformationEmployee()
    {
        // 1. Get Data User
        $whereUser = [
            'Slug' => session()->get('Slug')
        ];
        $resultDataUser = $this->M_Employee->getDataJoin($whereUser)->getRow();

        // 2. Get Data Log
        $EndDate = date('Y-m-d');
        $StartDate = date('Y-m-d', strtotime($EndDate . ' -8 day'));
        $whereDataLog = "Username = '" . $resultDataUser->Username . "' AND CreatedDate >= '" . $StartDate . "' AND CreatedDate <= '" . $EndDate . "'";
        $resultLog = $this->M_ActivityEmployee->getDataLog($whereDataLog, 'DESC')->getResult('array');

        // 3. Get Bawahan
        $resultDataBawahan = array();
        // $whereDataBAwahan = "1=1";
        $whereDataBAwahan = " Superior = '" . $resultDataUser->Username . "'";
        if ((int)$resultDataUser->IdPosition == 1) {
            $whereDataBAwahan = "1=1 AND Username <> '".$resultDataUser->Username."'";
        } 

        $resultDataBawahan = $this->M_Employee->getData($whereDataBAwahan)->getResult('array');

        $data = [
            'Karyawan' => $resultDataUser,
            'Log' => $resultLog,
            'Bawahan' => $resultDataBawahan,
            'EndDate' => $EndDate,
            'StartDate' => $StartDate
        ];

        echo json_encode($data);
    }

    public function getLogEmployee()
    {
        $whereUser = [
            'Slug' => session()->get('Slug')
        ];
        $resultDataUser = $this->M_Employee->getDataJoin($whereUser)->getRow();

        $EndDate = date('Y-m-d', strtotime($this->request->getVar('end') . ' +1 day'));
        $StartDate = date('Y-m-d', strtotime($this->request->getVar('start') . ' +0 day'));
        $whereDataLog = "Username = '" . $resultDataUser->Username . "' AND CreatedDate >= '" . $StartDate . "' AND CreatedDate <= '" . $EndDate . "'";
        $resultLog = $this->M_ActivityEmployee->getDataLog($whereDataLog, 'DESC')->getResult('array');

        echo json_encode($resultLog);
    }

    public function FromEmployee()
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));
            $setData = [
                'NamaPage' => 'Tambah Karyawan',
                'IconPage' => 'Karyawan'
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();
            return view('Employee/V_AddEmployee');
        } else {
            return  redirect()->to(base_url('/'));
        }
    }

    public function updateEmployee()
    {
        if (session()->get('status') == TRUE) {
            $cekUser = [];
            $superior = null;
            $isSwitch = 1;
            $telefons = [
                'rules' => 'required|is_unique[m_employee.Telephone]|min_length[12]',
                'errors' => [
                    'required' => 'Kolom nomor telefon harap diisi',
                    'is_unique' => 'Nomor telefon sudah tersedia',
                    'min_length' => 'Nomor telefon kurang dari 12 digit'
                ]
            ];
            $switchSuperior = [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom atasan harus dipilih'
                ]
            ];
            if ($this->request->getVar('IsSwitchSuperior') == 0) {
                $switchSuperior = [
                    'rules' => 'permit_empty'
                ];
                $isSwitch = 0;
            }
            if ($this->request->getVar('Telephone') == $this->request->getVar('tempTelefon')) {
                $telefons = [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kolom nomor telefon harap diisi'
                    ]
                ];
            }
            // tempTelefon
            if ($this->request->getVar('IsSuperior') == "" || $this->request->getVar('IsSuperior') == "0") {
                $superior = null;
                $cekUser = [
                    'Name' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom nama karyawan harus isi'
                        ]
                    ],
                    'Gender' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom jenis kelamin harus diplih'
                        ]
                    ],
                    'Telephone' =>  $telefons,
                    'Email' => [
                        'rules' => 'permit_empty|valid_email|is_unique[m_employee.Email]',
                        'errors' => [
                            'is_unique' => 'Email sudah tersedia',
                            'valid_email' => 'Email tidak valid'
                        ]
                    ],
                    'Address' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom alamat harus diisi'
                        ]
                    ],
                    'IdRole' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom Role harus dipilih'
                        ]
                    ],
                    'IdPosition' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom posisi harus dipilih'
                        ]
                    ]
                ];
            } else {
                $superior = $this->request->getVar('Superior');
                $cekUser = [
                    'Name' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom nama karyawan harus isi'
                        ]
                    ],
                    'Gender' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom jenis kelamin harus diplih'
                        ]
                    ],
                    'Telephone' =>  $telefons,
                    'Email' => [
                        'rules' => 'permit_empty|valid_email|is_unique[m_employee.Email]',
                        'errors' => [
                            'is_unique' => 'Email sudah tersedia',
                            'valid_email' => 'Email tidak valid'
                        ]
                    ],
                    'Address' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom alamat harus diisi'
                        ]
                    ],
                    'IdRole' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom Role harus dipilih'
                        ]
                    ],
                    'IdPosition' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom posisi harus dipilih'
                        ]
                    ],
                    'Superior' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom atasan harus dipilih'
                        ]
                    ],
                    'SwitchSuperior' => $switchSuperior
                ];
            }
            $kondisi = 1;
            if ($this->validate($cekUser)) {
                $whereEmployee = [
                    'Slug' => session()->get('Slug')
                ];


                $Employee = [
                    'Name' => $this->request->getVar('Name'),
                    'Username' => $this->request->getVar('Username'),
                    'Telephone' => $this->request->getVar('Telephone'),
                    'Country_Telephone' => $this->request->getVar('CountryTelephone'),
                    'Email' => $this->request->getVar('Email'),
                    'Gender' => $this->request->getVar('Gender'),
                    'Address' => $this->request->getVar('Address'),
                    'Superior' => $superior,
                    'IdPosition' => $this->request->getVar('IdPosition'),
                    'IdRole' => $this->request->getVar('IdRole'),
                    'ModifiedBy' => session()->get('Username'),
                ];
                if ($this->M_Employee->updateData($Employee, $whereEmployee)) {
                    if ($isSwitch == 1) {
                        $whereEMployeAother = [
                            'Superior' => $this->request->getVar('Username')
                        ];
                        $dataEmployeOther = [
                            'Superior' => $this->request->getVar('SwitchSuperior')
                        ];
                        $this->M_Employee->updateData($dataEmployeOther, $whereEMployeAother);
                    }
                    $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Memperbarui Data Karyawan', 1, 'Karyawan');
                    $condition = 1;
                } else {
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Memperbarui Data Karyawan', 0, 'Karyawan');
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

    public function SaveEmployee()
    {
        if (session()->get('status') == TRUE) {
            $cekUser = [];
            $superior = '';
            if ($this->request->getVar('IsSuperior') == "" || $this->request->getVar('IsSuperior') == "0") {
                $superior = null;
                $cekUser = [
                    'Name' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom nama karyawan harus isi'
                        ]
                    ],
                    'Gender' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom jenis kelamin harus diplih'
                        ]
                    ],
                    'Telephone' => [
                        'rules' => 'required|is_unique[m_employee.Telephone]|min_length[12]',
                        'errors' => [
                            'required' => 'Kolom nomor telefon harap diisi',
                            'is_unique' => 'Nomor telefon sudah tersedia',
                            'min_length' => 'Nomor telefon kurang dari 12 digit'
                        ]
                    ],
                    'Email' => [
                        'rules' => 'permit_empty|valid_email|is_unique[m_employee.Email]',
                        'errors' => [
                            'is_unique' => 'Email sudah tersedia',
                            'valid_email' => 'Email tidak valid'
                        ]
                    ],
                    'Username' => [
                        'rules' => 'required|is_unique[m_employee.Username]',
                        'errors' => [
                            'required' => 'Kolom username harap diisi',
                            'is_unique' => 'username sudah tersedia'
                        ]
                    ],
                    'Address' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom alamat harus diisi'
                        ]
                    ],
                    'IdRole' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom Role harus dipilih'
                        ]
                    ],
                    'IdPosition' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom posisi harus dipilih'
                        ]
                    ]
                ];
            } else {
                $superior = $this->request->getVar('Superior');
                $cekUser = [
                    'Name' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom nama karyawan harus isi'
                        ]
                    ],
                    'Gender' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom jenis kelamin harus diplih'
                        ]
                    ],
                    'Telephone' => [
                        'rules' => 'required|is_unique[m_employee.Telephone]|min_length[12]',
                        'errors' => [
                            'required' => 'Kolom nomor telefon harap diisi',
                            'is_unique' => 'Nomor telefon sudah tersedia',
                            'min_length' => 'Nomor telefon kurang dari 12 digit'
                        ]
                    ],
                    'Email' => [
                        'rules' => 'permit_empty|valid_email|is_unique[m_employee.Email]',
                        'errors' => [
                            'is_unique' => 'Email sudah tersedia',
                            'valid_email' => 'Email tidak valid'
                        ]
                    ],
                    'Username' => [
                        'rules' => 'required|is_unique[m_employee.Username]',
                        'errors' => [
                            'required' => 'Kolom username harap diisi',
                            'is_unique' => 'username sudah tersedia'
                        ]
                    ],
                    'Address' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom alamat harus diisi'
                        ]
                    ],
                    'IdRole' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom Role harus dipilih'
                        ]
                    ],
                    'IdPosition' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom posisi harus dipilih'
                        ]
                    ],
                    'Superior' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Kolom atasan harus dipilih'
                        ]
                    ]
                ];
            }
            $kondisi = 1;
            if ($this->validate($cekUser)) {
                $slugData = '';
                $kondisiSlug = 0;
                for ($i = 0; $i < 10; $i++) {
                    $TempslugData = $this->generateRandomString(10);
                    $checkSlug = [
                        'Slug' => $TempslugData
                    ];
                    if (($this->M_Employee->getData($checkSlug)->getNumRows()) == 0 && $kondisiSlug == 0) {
                        $slugData = $TempslugData;
                        $kondisiSlug = 1;
                    }
                }
                $Employee = [
                    'Slug' => $slugData,
                    'Name' => $this->request->getVar('Name'),
                    'Username' => $this->request->getVar('Username'),
                    'Telephone' => $this->request->getVar('Telephone'),
                    'Country_Telephone' => $this->request->getVar('CountryTelephone'),
                    'Email' => $this->request->getVar('Email'),
                    'Gender' => $this->request->getVar('Gender'),
                    'Address' => $this->request->getVar('Address'),
                    'Superior' => $superior,
                    'IdPosition' => $this->request->getVar('IdPosition'),
                    'IdRole' => $this->request->getVar('IdRole'),
                    'CreatedBy' => session()->get('Username'),
                    'ModifiedBy' => session()->get('Username'),
                    'Status' => 1,
                    'Root' => 0,
                ];
                if ($this->M_Employee->saveData($Employee)) {
                    $AccountData = [
                        'Username' => $this->request->getVar('Username'),
                        'Password' => md5('12345678')
                    ];
                    if (!$this->M_AccountEmployee->saveData($AccountData)) {
                        $this->C_WhatsApp->sendData($this->request->getVar('Telephone'), $this->request->getVar('Username'), '12345678');
                        $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Menambahkan Data Karyawan', 1, 'Karyawan');
                        $condition = 1;
                    } else {
                        $this->M_Employee->hapus($AccountData);
                        $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menambahkan Data Karyawan', 0, 'Karyawan');
                        $condition = 2;
                    }
                } else {
                    $this->C_Activity->Employee(session()->get('Username'), 'Gagal Menambahkan Data Karyawan', 0, 'Karyawan');
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

    public function getRole()
    {
        $where = "Status=1 AND Name NOT IN ('Owner','Administrator')";
        echo json_encode($this->M_Role->getData($where)->getResult('array'));
    }
    public function getPosition($id)
    {
        $where = "m_role_position.Status=1 AND m_role_position.IdRole = $id";
        echo json_encode($this->M_RolePosition->getDataJoin($where)->getResult('array'));
        // echo json_encode($this->M_RolePosition->getDataJoin());
    }

    public function getPostionRoleAll()
    {
        $where = "Status=1";
        $data = [
            'Posisi' => $this->M_Position->getData($where)->getResult('array'),
            'Role' => $this->M_Role->getData($where)->getResult('array')
        ];
        echo json_encode($data);
    }

    public function checkUserName()
    {
        $data = explode(",", $this->request->getVar('data'));
        $result = array();
        for ($i = 0; $i < count($data); $i++) {
            $where = [
                'Username' => $data[$i]
            ];
            $counts = $this->M_Employee->getData($where)->getNumRows();
            if ($counts == 0 && $data[$i] != "") {
                array_push($result, $data[$i]);
            }
        }
        echo json_encode($result);
    }

    public function getSuperior($IdPosition, $idRole)
    {
        $where = "Status=1 AND IdRole=$idRole AND IdPosition=$IdPosition";
        echo json_encode($this->M_Employee->getData($where)->getResult('array'));
        // echo json_encode($where);
    }

    public function getData()
    {
        if ($this->request->getVar('query') == '') {
            echo json_encode($this->M_Employee->getDataJoin());
        } else {
            echo json_encode($this->M_Employee->getDataJoin($this->request->getVar('query'))->getResult('array'));
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
            if ($this->M_Employee->updateData($data, $where)) {
                $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Mengubah Status ' . $statusData . ' Karyawan', 1, 'Karyawan');
                echo json_encode(1);
            } else {
                $this->C_Activity->Employee(session()->get('Username'), 'Gagal Mengubah Status ' . $statusData . ' Karyawan', 0, 'Karyawan');
                echo json_encode(0);
            }
        } else {
            echo json_encode(2);
        }
    }

    public function updatePassword()
    {
        if (session()->get('status') == TRUE) {
            $dataEmployee = [
                'ModifiedBy' => session()->get('Username')
            ];
            $dataAccount = [
                'Password' => md5($this->request->getVar('Pass'))
            ];
            $whereEmployee = [
                'Id' => $this->request->getVar('Id')
            ];
            $resultEmployee = $this->M_Employee->getData($whereEmployee)->getRow();
            $whereAccount = [
                'Username' => $resultEmployee->Username
            ];

            if ($this->M_AccountEmployee->updateData($dataAccount, $whereAccount)) {
                $this->M_Employee->updateData($dataEmployee, $whereEmployee);
                $this->C_Activity->Employee(session()->get('Username'), 'Berhasil Memperbarui Kata Sandi Karyawan', 1, 'Karyawan');
                echo json_encode(1);
            } else {
                $this->C_Activity->Employee(session()->get('Username'), 'Gagal Memperbarui Kata Sandi Karyawan', 0, 'Karyawan');
                echo json_encode(0);
            }
        } else {
            echo json_encode(0);
        }
    }

    public function EditEmployee($Slug)
    {
        if (session()->get('status') == TRUE) {
            // return  redirect()->to(base_url('Home'));
            $setData = [
                'NamaPage' => 'Edit Karyawan',
                'IconPage' => 'Karyawan',
                'Slug' => $Slug,
            ];
            session()->set($setData);
            $this->C_Activity->LastActiveUser();
            return view('Employee/V_EditEmployee');
        } else {
            return  redirect()->to(base_url('/'));
        }
    }
    public function getDataFrom()
    {
        $where = [
            'Slug' => session()->get('Slug')
        ];
        echo json_encode($this->M_Employee->getData($where)->getRow());
    }

    public function getOnlineUser()
    {
        $dateNow = date("Y-m-d h:m:s");
        $getAll = $this->M_AccountEmployee->getData();
        $data = array();
        date_default_timezone_set("Asia/Jakarta");
        // echo (new DateTime($test))->format("Y-m-d H:i:s");
        foreach ($getAll as $row) {

            $date1 = new DateTime();
            $date2 = new DateTime($row['LastActive']);
            $interval = $date1->diff($date2);
            $Kondition = $interval->days == 0 && $interval->h < 1;
            // echo json_encode($date1);
            if ($Kondition == 'true' && $row['LastActive'] != null && $row['IdSession'] != null) {
                $where = [
                    'Username' => $row['Username']
                ];
                $resultDataEMploye = $this->M_Employee->getData($where)->getRow();
                $resultData = $this->M_ActivityEmployee->getOneActivity($where)->getRow();
                $tempData = [
                    'Nama' => $resultDataEMploye->Name,
                    'Image' => $resultDataEMploye->ImageProfile,
                    'Gender' => $resultDataEMploye->Gender,
                    'Kegiatan' => 'Aktivitas ' . $resultData->Activity . '(' . $resultData->Device . ')'
                ];
                array_push($data, $tempData);
            }
        }
        echo json_encode($data);
    }
}
