<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class M_Product extends Model
{
    protected $table = 'm_product';
    protected $primaryKey = 'Id';
    protected $useAutoIncrement = true;
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'CreatedDate';
    protected $updatedField         = 'ModifiedDate';

    protected $allowedFields        = [
        "Name",
        "Id_Type_Product",
        "Id_Material_Product",
        "Size",
        "Limit",
        "TypeLimit",
        "Image",
        "Slug",
        "CodeQr",
        "Capital_Price",
        "Per_Piece",
        "Per_Doze",
        "Per_Kodi",
        "Stock",
        "TypeStock",
        "Stock_Piece",
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
            $result = $this->select('m_product.Stock_Piece,m_product.Name,m_product.Size, m_material_product.Name as Bahan, m_type_produk.Name as Jenis, m_type_item.Name as JenisStok, m_product.Stock, m_type_item.Name as singkatan, m_type_item.Per_Piece as piecetype
            , m_product.Status as StatusProduk, m_product.ModifiedDate as terakhiredit, m_product.CodeQr, m_product.Id, b.Name as singkatanlimit, m_product.Limit, m_product.Per_Piece,Per_Doze, Per_Kodi,Image')
                ->join('m_material_product', 'm_product.Id_Material_Product = m_material_product.Id')
                ->join('m_type_produk', 'm_product.Id_Type_Product = m_type_produk.Id')
                ->join('m_type_item', 'm_product.TypeStock = m_type_item.Id')
                ->join('m_type_item b', 'm_product.TypeLimit = b.Id');
            //     ->join('bahan', 'produk.jenisBahan = bahan.idBahan');
            return $result->findAll();
        }

        $result = $this->select('m_product.Stock_Piece,m_product.Name,m_product.Size, m_material_product.Name as Bahan, m_type_produk.Name as Jenis, m_type_item.Name as JenisStok, m_product.Stock, m_type_item.Name as singkatan, m_type_item.Per_Piece as piecetype
            , m_product.Status as StatusProduk, m_product.ModifiedDate as terakhiredit, m_product.CodeQr, m_product.Id, b.Name as singkatanlimit, m_product.Limit, m_product.Per_Piece,Per_Doze, Per_Kodi,Image')
            ->join('m_material_product', 'm_product.Id_Material_Product = m_material_product.Id')
            ->join('m_type_produk', 'm_product.Id_Type_Product = m_type_produk.Id')
            ->join('m_type_item', 'm_product.TypeStock = m_type_item.Id')
            ->join('m_type_item b', 'm_product.TypeLimit = b.Id')->where($data);
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
