<?php

namespace App\Models\Transaction;

use CodeIgniter\Model;

class T_DetailTransactionManual extends Model
{
    protected $table = 't_detail_transaction_manual';
    // protected $primaryKey = 'Id';
    // protected $useAutoIncrement = true;
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'CreatedDate';
    protected $updatedField         = 'ModifiedDate';

    protected $allowedFields        = [
        "Id",
        "Id_Transaction",
        "Id_Product",
        "Name_Product",
        "Size_Product",
        "Type_Product",
        "Meterial_Product",
        "Id_Price_Product",
        "Name_Price",
        "Type_Transaction",
        "Unit_Product",
        "Price_Product",
        "Sum_Product_PerPiece",
        "Sum_Temporary_PerPiece",
        "Total_Payment",
        "Status",
        "CreatedBy",
        "ModifiedBy",
    ];

    public function getData($data = false)
    {
        if ($data == false) {
            // $hasil = $this->join('jenisproduk', 'produk.jenisProduk = jenisproduk.idJenisProduk')
            //     ->join('bahan', 'produk.jenisBahan = bahan.idBahan');
            return $this->orderBy('CreatedDate','ASC')->findAll();
        }

        $hasil = $this->where($data);
        return $hasil->orderBy('CreatedDate','ASC')->get();
    }


    public function getDataJoinCart($data = false)
    {
        if ($data == false) {
            $hasil = $this->select('t_detail_transaction_manual.Id , t_detail_transaction_manual.')
                ->join('m_product produk', 't_detail_transaction_manual.Id_Product = produk.Id')
                ->join('bahan', 'produk.jenisBahan = bahan.idBahan');
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
