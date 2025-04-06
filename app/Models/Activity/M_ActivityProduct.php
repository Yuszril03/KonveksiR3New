<?php

namespace App\Models\Activity;

use CodeIgniter\Model;

class M_ActivityProduct extends Model
{
    protected $table = 'activity_product';
    protected $primaryKey = 'Id';
    protected $useAutoIncrement = true;
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'CreatedDate';
    protected $updatedField         = 'CreatedDate';

    protected $allowedFields        = [
        "Id_Product",
        "Status",
        "Satuan",
        "Stock",
        "Description",
        "CreatedBy",
        "isDone"
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
    public function getData2($data = false, $sort = 'DESC')
    {
        if ($data == false) {
            // $hasil = $this->join('jenisproduk', 'produk.jenisProduk = jenisproduk.idJenisProduk')
            //     ->join('bahan', 'produk.jenisBahan = bahan.idBahan');
            return $this->findAll();
        }

        $hasil = $this->where($data)->orderBy('activity_product.CreatedDate', $sort);
        return $hasil->get();
    }

    public function getDataReport($where, $sort)
    {
        $hasil = $this->select('activity_product.`CreatedDate`,b.`Name`,b.Size,activity_product.`Satuan`,activity_product.`Stock`, c.`Name` AS JenisSTok,activity_product.`Status` AS IdStok')
            ->join('m_product b', 'activity_product.Id_Product = b.Id')
            ->join('m_status c', 'activity_product.Status = c.Id');
        $hasil = $this->where($where . ' AND activity_product.isDone=1')->orderBy('activity_product.CreatedDate', $sort);
        return $hasil->get();
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
