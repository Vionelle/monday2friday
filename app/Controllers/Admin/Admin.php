<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\AdminModel;
use CodeIgniter\Config\Config;

class Admin extends BaseController
{
    public function __construct(){
        helper('form');
        helper('cookie');
        $this->validation = \Config\Services::validation();
        $this->session = session();
        $this->adminModel = new \App\Models\AdminModel();
        $this->email = \Config\Services::email();
    }

    public function adminLogin(){
        // if(get_cookie('cookie_username') && get_cookie('cookie_password')){
        //     $username = get_cookie('cookie_username');
        //     $password = get_cookie('cookie_password');

        //     $dataAdmin = $this->adminModel->getData($username);
        //     if($password!=$dataAdmin['password']){
        //         $error[] = "Akun yang Anda masukkan tidak sesuai";
        //         session()->setFlashdata('username',$username);
        //         session()->setFlashdata('warning',$error);

        //         delete_cookie('cookie_username');
        //         delete_cookie('cookie_password');

        //         return redirect()->to('admin/login');
        //     }
        //     $akun = [
        //         'username' => $username,
        //         'nama_lengkap' => $dataAdmin['nama_lengkap'],
        //         'email' => $dataAdmin['email']
        //     ];
        //     session()->set($akun);

        //     return redirect()->to('admin/sukses');
        // }

        $data = [];
        if($this->request->getPost()){
            $data = $this->request->getPost();
            $validate = $this->validation->run($data,'admin');
            $errors = $this->validation->getErrors();

            if($errors){
                session()->setFlashdata('errors', $errors);
                return redirect()->to('admin/login');
            }
            // else{
            //     session()->setFlashdata('success',"CONTOH SUKSES");
            //     return redirect()->to('Admin/adminLogin');
            // }
            
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $remember = $this->request->getVar('remember_me');

            $dataAdmin = $this->adminModel->getData($username);
            $admin = $this->adminModel->where('username', $username)->first();

            if($admin){
                if(!password_verify($password,$dataAdmin['password'])){
                    session()->setFlashdata('username',$username);
                    session()->setFlashdata('errors',['Password yang Anda masukkan tidak sesuai']);
                    return redirect()->to('admin/login');
                }
            }else{
                session()->setFlashdata('errors',['Akun yang Anda masukkan tidak terdaftar']);
                return redirect()->to('admin/login');
            }

            if($remember == '1'){
                set_cookie('cookie_username', $username, 3600*24*30);
                set_cookie('cookie_password', $dataAdmin['password'], 3600*24*30);
            }

            $akun = [
                'id' => $dataAdmin['id_admin'],
                'username' => $dataAdmin['username'],
                'nama_lengkap' => $dataAdmin['nama_lengkap'],
                'email' => $dataAdmin['email']
            ];

            session()->set($akun);

            return redirect()->to('admin/sukses')->withCookies();

        }
        return view("admin/admin_login",$data);
    }

    public function adminSuccess(){
        // delete_cookie('cookie_username');
        // delete_cookie('cookie_password');
        // session()->destroy();
        // if(session()->get('username')!=''){
        //     session()->setFlashdata('success','Anda berhasil logout');
        // }
        // echo view('admin/admin_login');

        return redirect()->to('admin/dashboard');

        // print_r(session()->get());
        // echo "ISIAN COOKIE USERNAME".get_cookie('cookie_username')." DAN PASSWORD ".get_cookie('cookie_password');
    }

    public function adminLogout(){
        delete_cookie('cookie_username');
        delete_cookie('cookie_password');
        session()->destroy();
        if(session()->get('username')!=''){
            session()->setFlashdata('success','Anda berhasil logout');
        }
        echo view('admin/admin_login');
    }

    public function adminForgotPassword(){
        $err=[];
        if($this->request->getPost()){
            $username = $this->request->getVar('username');
            if($username == ''){
                $err[] = "Silahkan masukkan username atau email yang Anda punya";
            }
            if(empty($err)){
                $data = $this->adminModel->getData($username);
                if(empty($data)){
                    $err[] = "Akun yang Anda masukkan tidak terdata";
                }
            }
            if(empty($err)){
                $email = $data['email'];
                $token = md5(date('ymdhis'));

                $link = site_url("admin/resetpassword/?email=$email&token=$token");
                $attachment = "";
                $to = $email;
                $title = "Reset Password";
                $message = "Berikut ini adalah link untuk melakukan reset password";
                $message .= "Silahkan klik link berikut ini $link";

                $this->sendEmailReset($attachment,$to,$title,$message);
                // dd($this->email->printDebugger());

                $dataUpdate = [
                    'token' => $token
                ];
                $this->adminModel->updateData($email, $dataUpdate);

                session()->setFlashdata('success', "Email untuk recovery sudah terkirim ke email Anda");
            }
            if($err){
                session()->setFlashdata('username', $username);
                session()->setFlashdata('errors', $err);
            }
            return redirect()->to('admin/lupapassword');
        }

        return view('admin/forgot_admin');
    }

    public function adminResetPassword(){
        $err = [];
        $email = $this->request->getVar('email');
        $token = $this->request->getVar('token');
        if($email != '' && $token != ''){
            $dataAdmin = $this->adminModel->getData($email);
            if($dataAdmin['token'] != $token){
                $err[] = "Token tidak valid";
            }
        }else{
            $err[] = "Parameter yang dikirimkan tidak valid";
        }

        if($err){
            session()->setFlashData('errors',$err);
        }

        if($this->request->getPost()){
            $data = $this->request->getPost();
            $validate = $this->validation->run($data,'resetpasswordadmin');
            $errors = $this->validation->getErrors();

            if($errors){
                session()->setFlashData('errors',$errors);
            }else{
                $dataUpdate=[
                    'password' => password_hash($this->request->getVar('password'),PASSWORD_DEFAULT),
                    'token' => NULL
                ];
                $this->adminModel->updateData($email,$dataUpdate);
                session()->setFlashdata('success','Password berhasil direset, silahkan login');
                delete_cookie('cookie_username');
                delete_cookie('cookie_password');

                return redirect()->to('admin/login')->withCookies();
            }
        }

        return view('admin/resetpass_admin');
    }

    public function sendEmailReset($attachment,$to,$title,$message){
        $this->email->setFrom(EMAIL_PENGIRIM, 'Monday to Friday');
        $this->email->setTo($to);
        $this->email->attach($attachment);
        $this->email->setSubject($title);
        $this->email->setMessage($message);

        if(!$this->email->send()){
            // echo $this->email->printDebugger();
            return false;
        }else{
            // echo $this->email->printDebugger();
            return true;
        }
    }
    
}


?>