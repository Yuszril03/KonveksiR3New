<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class M_Status_Transaction extends Model
{
    protected $table = 'm_status_transaction';
    protected $primaryKey = 'Id';
    protected $useAutoIncrement = true;
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'CreatedDate';
    protected $updatedField         = 'ModifiedDate';

    protected $allowedFields        = [
        "Name",
        "Type",
        "Descroption",
        "Status",
        "CreatedBy",
        "ModifiedBy"
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
            $hasil = $this->select('m_role_position.Superior,m_role.Id As IdRole, m_role.Name As NameRole, m_position.Id as IdPosition, m_position.Name as NamePosition')
                ->join('m_role', 'm_role_position.IdRole =  m_role.Id')
                ->join('m_position', 'm_role_position.IdPosition =  m_position.Id');
            return $hasil->findAll();
        }
        $hasil = $this->select('m_role_position.Superior,m_role.Id As IdRole, m_role.Name As NameRole, m_position.Id as IdPosition, m_position.Name as NamePosition')
            ->join('m_role', 'm_role_position.IdRole =  m_role.Id')
            ->join('m_position', 'm_role_position.IdPosition =  m_position.Id')->where($data);
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
