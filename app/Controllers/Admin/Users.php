<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Config\Config;

class Users extends BaseController
{
    public function __construct(){
        $this->session = session();
        $this->userModel = new \App\Models\UserModel();
    }

    public function daftarUser(){
        $data = [];
        $data['judul'] = "Daftar User";

        $dataUser = [
            'users' => $this->userModel->paginate(10),
            'pager' => $this->userModel->pager,
        ];

        // return view('user/index',[
        //     'data' => $data,
        // ]);

        echo view('admin/template_header',$data);
        echo view('admin/list_user.php',['data' => $dataUser]);
        echo view('admin/template_footer',$data); 
    }
}
?>