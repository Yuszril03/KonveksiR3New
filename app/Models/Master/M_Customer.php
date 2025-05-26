<?php

namespace App\Models\Master;

use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Model;

class M_Customer extends Model
{
    protected $table = 'm_customer';
    // protected $primaryKey = 'Id';
    // protected $useAutoIncrement = true;
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'CreatedDate';
    protected $updatedField         = 'ModifiedDate';

    protected $allowedFields        = [
        "Id",
        "Slug",
        "Name",
        "Username",
        "Telephone",
        "Country_Telephone",
        "Email",
        "Gender",
        "Image",
        "Address",
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

    public function SaveDateCustom($data)
    {
        $result = $this->orderBy('CreatedDate', 'DESC')->get()->getRow();
        if ($result == null) {
            $data['Id'] = 'C-1';
            $hasil = $this->insert($data);
            return $hasil;
        } else {
            $splitData = explode('-', $result->Id);
            $sum = (int)$splitData[1] + 1;
            $data['Id'] = 'C-' . $sum;
            $hasil = $this->insert($data);
            return $hasil;
        }
    }

    public function saveData($data)
    {
        $hasil = $this->insert($data);
        return $hasil;
    }
    public function updateData($data, $where)
    {
        return  $this->set($data)->where($where)->update();

        // return $this->where($where)->update($data);
    }
    public function hapus($where)
    {
        return $this->where($where)->delete();
    }
}
