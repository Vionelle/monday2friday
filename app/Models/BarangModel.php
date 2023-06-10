<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'barang';
    protected $primarykey = 'id';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'id','nama','harga','stok','gambar','size','created_date','updated_date'
    ];
    protected $returnType = 'App\Entities\Barang';
    protected $useTimestamps = false;

    // public function search($search){
    //     return $this->table('barang')->like('nama',$search);
    // }

    public function getProducts($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}