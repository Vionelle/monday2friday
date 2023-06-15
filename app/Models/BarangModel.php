<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'id_barang','nama','harga','stok','gambar','size','created_date','updated_date'
    ];
    protected $returnType = 'App\Entities\Barang';
    protected $useTimestamps = false;

    // public function search($search){
    //     return $this->table('barang')->like('nama',$search);
    // }

    public function getProducts($id_barang = false)
    {
        if ($id_barang == false) {
            return $this->findAll();
        }

        return $this->where(['id_barang' => $id_barang])->first();
    }
}