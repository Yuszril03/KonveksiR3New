<?php

namespace App\Models\Transaction;

use CodeIgniter\Model;

class T_TransactionManual extends Model
{
    protected $table = 't_transaction_manual';
    // protected $primaryKey = 'Id';
    // protected $useAutoIncrement = true;
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'CreatedDate';
    protected $updatedField         = 'ModifiedDate';

    protected $allowedFields        = [
        "Id",
        "Number_Trans",
        "Username_Employee",
        "IdCustomer",
        "Operator",
        "Sum_Transaction",
        "Payment",
        "Sub_Total",
        "Total_Dept",
        "Total_Payment",
        "Transc_continuance",
        "Status",
        "CreatedBy",
        "ModifiedBy",
    ];

    public function getData($data = false)
    {
        if ($data == false) {
            // $hasil = $this->join('jenisproduk', 'produk.jenisProduk = jenisproduk.idJenisProduk')
            //     ->join('bahan', 'produk.jenisBahan = bahan.idBahan');
            return $this->orderBy('CreatedDate', 'ASC')->findAll();
        }

        $hasil = $this->where($data);
        return $hasil->orderBy('CreatedDate', 'ASC')->get();
    }
    public function getDataJoin($data = false)
    {
        if ($data == false) {
            $hasil = $this->select('t_transaction_manual.Id, t_transaction_manual.Number_Trans, t_transaction_manual.CreatedDate,
                m_customer.Name as NamaCustomer, m_employee.Name as NamaKasir, Sub_Total, Payment, Total_Dept, Total_Payment,t_transaction_manual.Status as StatusTransakksi,
                t_transaction_manual.IdCustomer, Transc_continuance,t_transaction_manual.ModifiedDate as transModif')
                ->join('m_customer', 't_transaction_manual.IdCustomer = m_customer.Id')
                ->join('m_employee', 't_transaction_manual.Username_Employee = m_employee.Username');
            return $hasil->findAll();
        }
        $hasil = $this->select('t_transaction_manual.Id, t_transaction_manual.Number_Trans, t_transaction_manual.CreatedDate,
                m_customer.Name as NamaCustomer, m_employee.Name as NamaKasir, Sub_Total, Payment, Total_Dept, Total_Payment,t_transaction_manual.Status as StatusTransakksi,
                t_transaction_manual.IdCustomer,Transc_continuance,t_transaction_manual.ModifiedDate as transModif')
            ->join('m_customer', 't_transaction_manual.IdCustomer = m_customer.Id')
            ->join('m_employee', 't_transaction_manual.Username_Employee = m_employee.Username');
        return $hasil->where($data)->get();
    }

    public function getTrans($data = false, $sort)
    {
        if ($data == false) {
            $hasil = $this->select('t_transaction_manual.Id, t_transaction_manual.Number_Trans, t_transaction_manual.CreatedDate,
                m_customer.Name as NamaCustomer,m_employee.Id as usernamekasir, m_employee.Name as NamaKasir, Sub_Total, Payment, Total_Dept, Total_Payment,t_transaction_manual.Status as StatusTransakksi,
                t_transaction_manual.IdCustomer')
                ->join('m_customer', 't_transaction_manual.IdCustomer = m_customer.Id')
                ->join('m_employee', 't_transaction_manual.Username_Employee = m_employee.Username');
            return $hasil->orderBy('Number_Trans', $sort)->findAll();
        }
        $hasil = $this->select('t_transaction_manual.Id, t_transaction_manual.Number_Trans, t_transaction_manual.CreatedDate,
                m_customer.Name as NamaCustomer,m_employee.Id as usernamekasir , m_employee.Name as NamaKasir, Sub_Total, Payment, Total_Dept, Total_Payment,t_transaction_manual.Status as StatusTransakksi,
                t_transaction_manual.IdCustomer')
            ->join('m_customer', 't_transaction_manual.IdCustomer = m_customer.Id')
            ->join('m_employee', 't_transaction_manual.Username_Employee = m_employee.Username');
        return $hasil->where($data)->orderBy('Number_Trans', $sort)->get();
    }

    public function saveData($data)
    {
        $hasil = $this->insert($data);
        return $hasil;
    }
    public function SaveDateCustom($data)
    {
        $result = $this->orderBy('Number_Trans', 'DESC')->get()->getRow();
        if ($result == null) {
            $dateNow = date('Ymd');
            $data['Number_Trans'] = 'R-' . $dateNow . '-00001';
            $hasil = $this->insert($data);
            return $hasil;
        } else {
            $splitData = explode('-', $result->Number_Trans);
            $dateNow = date('Ymd');
            if ($splitData[1] == $dateNow) {
                $sum = (int)$splitData[2] + 1;
                $zero = '0000';
                if (strlen('' . $sum . '') == 1) {
                    $zero = '0000';
                } else if (strlen('' . $sum . '') == 2) {
                    $zero = '000';
                } else if (strlen('' . $sum . '') == 3) {
                    $zero = '00';
                } else if (strlen('' . $sum . '') == 4) {
                    $zero = '0';
                } else {
                    $zero = '';
                }
                $data['Number_Trans'] = 'R-' . $dateNow . '-' . $zero . '' . $sum;
            } else {
                // $dateNow = date('Ymd');
                $data['Number_Trans'] = 'R-' . $dateNow . '-00001';
            }
            // $data['Id'] = 'C-' . $sum;
            $hasil = $this->insert($data);
            // return  $data;
            return $hasil;
        }
    }
    public function updateData($data, $where)
    {
        return $this->set($data)->where($where)->update();
        // return $this->where($where)->update($data);
    }
    public function hapus($where)
    {
        return $this->where($where)->delete();
    }
}
