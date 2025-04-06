<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class M_PaymentMethod extends Model
{
    protected $table = 'm_payment_method';
    protected $primaryKey = 'Id';
    protected $useAutoIncrement = true;
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'CreatedDate';
    protected $updatedField         = 'ModifiedDate';

    protected $allowedFields        = [
        "Name",
        "Number_Account",
        "Id_Bank",
        "Status",
        "CreatedBy",
        "ModifiedBy",
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
    public function getDataJoin($data = false)
    {
        if ($data == false) {
            $hasil = $this->select('m_payment_method.Id,m_payment_method.Name,m_payment_method.Number_Account,m_payment_method.Status, 
            m_payment_method.ModifiedDate, m_bank.Name as Bank,m_payment_method.Id_Bank')
                ->join('m_bank', 'm_payment_method.Id_Bank = m_bank.Id');
            return $hasil->findAll();
        }
        $hasil = $this->select('m_payment_method.Id,m_payment_method.Name,m_payment_method.Number_Account,m_payment_method.Status,
            m_payment_method.ModifiedDate, m_bank.Name as Bank,m_payment_method.Id_Bank')
            ->join('m_bank', 'm_payment_method.Id_Bank = m_bank.Id');
        return $hasil->where($data)->get();
    }
    public function GetTypeBank()
    {
        $db = db_connect();

        return $this->query('SELECT Id_Bank FROM m_payment_method GROUP BY Id_Bank')->getResult('array');
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
