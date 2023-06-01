<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primarykey = 'email';
    protected $allowedFields = [
        'username','password','nama_lengkap','token'
    ];

    //Untuk mengambil data
    public function getData($parameter){
        $builder = $this->table($this->table);
        $builder->where('username=', $parameter);
        $builder->orWhere('email=', $parameter);
        $query = $builder->get();

        return $query->getRowArray();
    }

    //Untuk update dan simpan data
    public function updateData($email,$data){
        $builder = $this->table($this->table)
                        ->where(["email" => $email])
                        ->set($data)
                        ->update();
        
    }

    // protected $returnType = 'App\Entities\Admin';
    // protected $useTimestamps = false;
}