<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primarykey = 'id';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'id','email','username','password','salt','created_date','updated_date','token','kontak','alamat'
    ];
    protected $returnType = 'App\Entities\User';
    protected $useTimestamps = false;

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
}

