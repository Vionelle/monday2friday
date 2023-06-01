<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'barang';
    protected $primarykey = 'id';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'id','nama','harga','stok','gambar','created_by','created_date','updated_by','updated_date','size'
    ];
    protected $returnType = 'App\Entities\Barang';
    protected $useTimestamps = false;

    // public function search($search){
    //     return $this->table('barang')->like('nama',$search);
    // }
}