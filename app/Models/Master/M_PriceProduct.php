<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class M_PriceProduct extends Model
{
    protected $table = 'm_price_product';
    protected $primaryKey = 'Id';
    protected $useAutoIncrement = true;
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'CreatedDate';
    protected $updatedField         = 'ModifiedDate';

    protected $allowedFields        = [
        "Id_Product",
        "Name",
        "Per_Piece",
        "Per_Dozen",
        "Per_Kodi",
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
