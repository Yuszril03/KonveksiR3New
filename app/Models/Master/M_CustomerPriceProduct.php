<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class M_CustomerPriceProduct extends Model
{
    protected $table = 'm_customer_price_product';
    protected $primaryKey = 'Id';
    protected $useAutoIncrement = true;
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'CreatedDate';
    protected $updatedField         = 'ModifiedDate';

    protected $allowedFields        = [
        "Id_Price_Product",
        "Id_Product",
        "Id_Customer",
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
            $hasil = $this->select('m_customer.Name, m_customer_price_product.Id')
                ->join('m_customer', 'm_customer_price_product.Id_Customer = m_customer.Id');
            //     ->join('bahan', 'produk.jenisBahan = bahan.idBahan');
            return $hasil->findAll();
        }
        $hasil = $this->select('m_customer.Name, m_customer_price_product.Id')
            ->join('m_customer', 'm_customer_price_product.Id_Customer = m_customer.Id');
        //     ->join('bahan', 'produk.jenisBahan = bahan.idBahan');
        // return $hasil->findAll();
        $hasil->where($data);
        return $hasil->get();
    }

    public function getDataPriceTrans($data = false)
    {
        if ($data == false) {
            $result = $this->select('m_customer_price_product.Id,pp.Name as NamaHarga, pp.Per_Piece as Potong, pp.Per_Dozen as Lusin, pp.Per_Kodi as Kodi, pp.Status as StatusHarga, pp.Id as IdHarga,
            pp.Id as IdPrice')
                ->join('m_price_product pp', 'm_customer_price_product.Id_Price_Product = pp.Id');

            return $result->findAll();
        }
        $result = $this->select('m_customer_price_product.Id,pp.Name as NamaHarga, pp.Per_Piece as Potong, pp.Per_Dozen as Lusin, pp.Per_Kodi as Kodi, pp.Status as StatusHarga, pp.Id as IdHarga,
         pp.Id as IdPrice')
            ->join('m_price_product pp', 'm_customer_price_product.Id_Price_Product = pp.Id')->where($data);

        return $result->get();
    }

    public function getInfoDataPrice($data = false)
    {
        if ($data == false) {
            $result = $this->select('m_customer_price_product.Id,pp.Name as NamaHarga, pp.Per_Piece as Potong, pp.Per_Dozen as Lusin, pp.Per_Kodi as Kodi, pp.Status as StatusHarga, pp.Id as IdHarga,
            pp.Id as IdPrice, mp.Name as produk')
                ->join('m_price_product pp', 'm_customer_price_product.Id_Price_Product = pp.Id')
                ->join('m_product mp', 'm_customer_price_product.Id_Product = mp.Id');

            return $result->findAll();
        }
        $result = $this->select('m_customer_price_product.Id,pp.Name as NamaHarga, pp.Per_Piece as Potong, pp.Per_Dozen as Lusin, pp.Per_Kodi as Kodi, pp.Status as StatusHarga, pp.Id as IdHarga,
            pp.Id as IdPrice, mp.Name as produk')
            ->join('m_price_product pp', 'm_customer_price_product.Id_Price_Product = pp.Id')
            ->join('m_product mp', 'm_customer_price_product.Id_Product = mp.Id')->where($data);

        return $result->get();
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
