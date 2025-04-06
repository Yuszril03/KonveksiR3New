<?php

namespace App\Models\Activity;

use CodeIgniter\Model;

class M_ActivityTransaction extends Model
{
    protected $table = 'activity_transaction';
    protected $primaryKey = 'Id';
    protected $useAutoIncrement = true;
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'CreatedDate';
    protected $updatedField         = 'CreatedDate';

    protected $allowedFields        = [
        "Id_Transaction",
        "Description",
        "Image",
        "TypeTransaction",
        "OverPay",
        "ChangePay",
        "Payment",
        "Description",
        "Status",
        "CreatedBy"
    ];

    public function getData($data = false)
    {
        if ($data == false) {
            // $hasil = $this->join('jenisproduk', 'produk.jenisProduk = jenisproduk.idJenisProduk')
            //     ->join('bahan', 'produk.jenisBahan = bahan.idBahan');
            return $this->findAll();
        }

        $hasil = $this->where($data);
        return $hasil->get();
    }
    public function getGroupByTransaction($where)
    {
        $hasil = $this->select('Id_Transaction')->where($where);
        return $hasil->get();
    }
    public function getSumPaymentHistory($where, $sort)
    {
        $hasil = $this->select('t_transaction_manual.Id AS IdTransaksi, t_transaction_manual.Number_Trans, m_customer.Name AS Customer, m_employee.Name AS Kasir
        , activity_transaction.CreatedDate AS TGLBayar, activity_transaction.Payment, activity_transaction.OverPay, activity_transaction.ChangePay, activity_transaction.Image')
            ->join('t_transaction_manual', 'activity_transaction.Id_Transaction = t_transaction_manual.Id')
            ->join('m_customer', 't_transaction_manual.IdCustomer = m_customer.Id')
            ->join('m_employee', 't_transaction_manual.Operator = m_employee.Username');
        // return $hasil->where($data)->get();
        $hasil = $this->where($where . ' AND activity_transaction.TypeTransaction=16')->orderBy('activity_transaction.CreatedDate', $sort);
        $loop = $hasil->get()->getResult('array');
        $sum = 0;
        $lastDate = '';
        foreach ($loop as $row) {
            if ($row['OverPay'] == 0) {
                $temp = $row['Payment'] -  $row['ChangePay'];
                $sum = $sum + $temp;
            } else {
                $sum = $sum +  $row['Payment'];
            }
        }
        $data = [
            'sum' => $sum,
            'data' => $loop
        ];
        return $data;
    }
    public function getData2($data = false)
    {
        if ($data == false) {
            // $hasil = $this->join('jenisproduk', 'produk.jenisProduk = jenisproduk.idJenisProduk')
            //     ->join('bahan', 'produk.jenisBahan = bahan.idBahan');
            return $this->findAll();
        }

        $hasil = $this->where($data);
        return $hasil;
    }

    public function saveData($data)
    {
        $hasil = $this->insert($data);
        return $hasil;
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
