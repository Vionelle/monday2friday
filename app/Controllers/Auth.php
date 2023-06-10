<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function __construct(){
        helper('form');
        helper('cookie');
        $this->validation = \Config\Services::validation();
        $this->session = session();
        $this->email = \Config\Services::email();
        $this->db      = \Config\Database::connect();
        $this->builderUser = $this->db->table('user');
    }
    public function register(){
        $this->builderUser->selectMax("id");
        $id_tangkap = $this->builderUser->countAll();
        $id_tangkap++;
        $id_user = "PBL" . $id_tangkap;

        if($this->request->getPost()){
            $data = $this->request->getPost();
            $validate = $this->validation->run($data,'register');
            $errors = $this->validation->getErrors();

            if(!$errors){
                $userModel = new \App\Models\UserModel();
                $user = new \App\Entities\User();
                $user->id = $id_user;
                $user->username = $this->request->getPost('username');
                $user->password = $this->request->getPost('password');
                $user->email = $this->request->getPost('email');
                $user->active = 0;
                // $user->created_by = 0;
                $user->created_date = date("Y-m-d H:i:s");
                $userModel->save($user);

                //EMAIL INVOICE
                $this->email->setFrom('jackquiledarrent@gmail.com', 'Monday to Friday');
                //EMAIL INVOICE manual
                $this->email->setTo($data['email']);

                $this->email->SetSubject('Konfirmasi akun email');

                $this->email->setMessage('Silahkan klik link berikut untuk mengaktivasi akun anda. http://localhost/monday2friday/emailValidation/' . $data['username'] . ''); // Our message above including the link

                if (!$this->email->send()) {
                    return redirect()->to('register');
                } else {
                    session()->setFlashdata('login', 'Anda berhasil mendaftar, silahkan aktivasi akun terlebih dahulu');
                    return redirect()->to('login');
                }

                // $success = "Akun berhasil dibuat, silahkan login";
                // session()->setFlashdata('success',$success);
                // return redirect()->to('login');

            }else{
                session()->setFlashdata('errors', $errors);
                return redirect()->to('register');    
            }
        }
        return view('register');
    }
    public function emailValidation($username)
    {
        //menampilkan halaman register
        $userModel = new \App\Models\UserModel();

        $user = $userModel->getUsernameDetail($username);

        $userModel->save([
            // $user->id ;
            'id' => $user->id,
            // 'id' => $user['id'],
            'active' => '1',
        ]);

        return redirect()->to('/login');
    }

    public function login(){
        $userModel = new \App\Models\UserModel();

        // if(get_cookie('cookie_username') && get_cookie('cookie_password')){
        //     $username = get_cookie('cookie_username');
        //     $password = get_cookie('cookie_password');

        //     $dataUser = $userModel->getData($username);
        //     if($password!=$dataUser['password']){
        //         $error[] = "Akun yang Anda masukkan tidak sesuai";
        //         session()->setFlashdata('username',$username);
        //         session()->setFlashdata('warning',$error);

        //         delete_cookie('cookie_username');
        //         delete_cookie('cookie_password');

        //         return redirect()->to('login');
        //     }
        //     $akun = [
        //         'username' => $user->username,
        //         'id' => $user->id,
        //         'role' => $user->role,
        //         'isLoggedin' => TRUE
        //         'email' => $dataUser['email']
        //     ];
        //     session()->set($akun);

        //     return redirect()->to('home');
        // }
        
        if($this->request->getPost()){
            $data = $this->request->getPost();
            $validate = $this->validation->run($data,'login');
            $errors = $this->validation->getErrors();

            if($errors){
                session()->setFlashdata('errors', $errors);
                return redirect()->to('login');
            }

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            // $remember = $this->request->getVar('remember_me');
            
            $user = $userModel->where('username',$username)->first();
            $dataUser = $userModel->getData($username);

            // if($remember == '1'){
            //     set_cookie('cookie_username', $username, 3600*24*30);
            //     set_cookie('cookie_password', $dataUser['password'], 3600*24*30);
            // }
            
            if($user){
                $salt = $user->salt;
                if($user->password!==md5($salt.$password)){

                    //** DEBUG */
                    // $new = [md5($salt.$password),$user->password];
                    // session()->setFlashdata('errors', $new);

                    session()->setFlashdata('errors', ['Password Yang Anda Masukkan Salah']);
                    return redirect()->to('login');

                } else if($user->active != 1){
                    session()->setFlashdata('errors', ['Anda belum mengaktivasi akun ini, silahkan cek email anda']);
                    return redirect()->to('login');
                }
                else{
                    $sessData = [
                        'username' => $user->username,
                        'id' => $user->id,
                        'role' => $user->role,
                        'isLoggedin' => TRUE
                    ];

                    session()->set($sessData);
                    return redirect()->to(site_url('home'));
                }
            }else{
                $this->session->setFlashdata('errors', ['User Tidak Ditemukan']);
                return redirect()->to('login');
            }            
        }
        return view('login');
    }
    
    public function logout(){
        $this->session->destroy();
        return redirect()->to(site_url('login'));
    }

    public function forgotPassword(){
        $err=[];
        $userModel = new \App\Models\UserModel();
        if($this->request->getPost()){
            $username = $this->request->getVar('username');
            if($username == ''){
                $err[] = "Silahkan masukkan username atau email yang Anda punya";
            }
            if(empty($err)){
                $data = $userModel->getData($username);
                if(empty($data)){
                    $err[] = "Akun yang Anda masukkan tidak terdata";
                }
            }
            if(empty($err)){
                $email = $data['email'];
                $token = md5(date('ymdhis'));

                $link = site_url("reset_password/?email=$email&token=$token");
                $attachment = "";
                $to = $email;
                $title = "Reset Password";
                $message = "Berikut ini adalah link untuk melakukan reset password";
                $message .= "Silahkan klik link berikut ini $link";

                $this->sendEmailReset($attachment,$to,$title,$message);

                $dataUpdate = [
                    'token' => $token
                ];
                $userModel->updateData($email, $dataUpdate);

                session()->setFlashdata('success', "Email untuk recovery sudah terkirim ke email Anda");
            }
            if($err){
                session()->setFlashdata('username', $username);
                session()->setFlashdata('errors', $err);
            }
            return redirect()->to('lupa_password');
        }

        return view('lupapassword');
    }

    public function resetPassword(){
        $err = [];
        $userModel = new \App\Models\UserModel();
        $user = new \App\Entities\User();

        $email = $this->request->getVar('email');
        $token = $this->request->getVar('token');

        if($email != '' && $token != ''){
            $dataUser = $userModel->getData($email);
            if($dataUser['token'] != $token){
                $err[] = "Token tidak valid";
            }
        }else{
            $err[] = "Parameter yang dikirimkan tidak valid";
        }

        if($err){
            session()->setFlashData('errors', $err);
        }

        if($this->request->getPost()){
            $data = $this->request->getPost();
            $validate = $this->validation->run($data,'resetpasswordadmin');
            $errors = $this->validation->getErrors();

            $password = $this->request->getPost('password');

            $akun = $userModel->where('email', $email)->first();
            $salt = $akun->salt;
            $new_password = md5($salt.$password);

            if($errors){
                session()->setFlashData('errors',$errors);
            }else{
                $dataUpdate=[
                    'password' => $new_password,
                    'token' => NULL,
                    'updated_date' => date("Y-m-d H:i:s")
                ];
                $userModel->updateData($email,$dataUpdate);
                session()->setFlashdata('success','Password berhasil direset, silahkan login');
                delete_cookie('cookie_username');
                delete_cookie('cookie_password');

                //** DEBUG */
                // session()->setFlashdata('success',$new_password);
                
                return redirect()->to('login')->withCookies();
            }
        }

        return view('resetpassword');
    }

    public function sendEmailReset($attachment,$to,$title,$message){
        $this->email->setFrom(EMAIL_PENGIRIM,EMAIL_NAMA);
        $this->email->setTo($to);
        $this->email->attach($attachment);
        $this->email->setSubject($title);
        $this->email->setMessage($message);

        if(!$this->email->send()){
            return false;
        }else{
            return true;
        }
    }
}

?>