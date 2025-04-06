<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class M_Employee extends Model
{
    protected $table = 'm_employee';
    protected $primaryKey = 'Id';
    protected $useAutoIncrement = true;
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'CreatedDate';
    protected $updatedField         = 'ModifiedDate';

    protected $allowedFields        = [
        // "Id",
        "Slug",
        "Name",
        "Username",
        "Telephone",
        "Country_Telephone",
        "Email",
        "Gender",
        "ImageProfile",
        "Address",
        "Status",
        "Superior",
        "IdPosition",
        "IdRole",
        "Root",
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
            $hasil = $this->select('m_employee.ImageProfile,m_employee.Country_Telephone,m_employee.Id,m_employee.Superior,m_employee.Gender,m_employee.Address,m_employee.Email,m_employee.Slug, m_employee.Status, m_employee.Username, m_employee.Name,m_employee.Superior
            , m_employee.IdPosition, m_employee.IdRole, m_role.Name as NameRole, m_postion.Name as NamePosition, m_employee.Root,
             m_employee.CreatedDate,m_employee.ModifiedDate,  m_employee.Telephone, m_position.Level')
                ->join('m_role', 'm_employee.IdRole = m_role.Id')
                ->join('m_position', 'm_employee.IdPosition = m_position.Id');
            return $hasil->findAll();
        }

        $hasil =  $this->select('m_employee.ImageProfile,m_employee.Country_Telephone,m_employee.Id,m_employee.Superior,m_employee.Gender,m_employee.Address,m_employee.Email ,m_employee.Slug, m_employee.Status, m_employee.Username, m_employee.Name,m_employee.Superior
            , m_employee.IdPosition, m_employee.IdRole, m_role.Name as NameRole, m_position.Name as NamePosition, m_employee.Root,
             m_employee.CreatedDate,m_employee.ModifiedDate,  m_employee.Telephone, m_position.Level')
            ->join('m_role', 'm_employee.IdRole = m_role.Id')
            ->join('m_position', 'm_employee.IdPosition = m_position.Id')
            ->where($data);
        return $hasil->get();
    }
    public function SaveDateCustom($data)
    {
        $result = $this->orderBy('Id', 'DESC')->get()->getRow();
        if ($result == null) {
            $data['Id'] = 'E-1';
            $hasil = $this->insert($data);
            return $hasil;
        } else {
            $splitData = explode('-', $result->Id);
            $sum = (int)$splitData[1] + 1;
            $data['Id'] = 'E-' . $sum;
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
        return $this->set($data)->where($where)->update();
        // return $this->where($where)->update($data);
    }
    public function hapus($where)
    {
        return $this->where($where)->delete();
    }
}
