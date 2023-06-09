<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'id','email','username','password','salt','created_date','updated_date','token','kontak','alamat', 'role', 'active'
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

    public function getUsernameDetail($username)
    {
        return $this->where('username', $username)->first();
    }
    public function getUserDetail($id)
    {
        return $this->where('id', $id)->first();
    }
}

