<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->session = session();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        //cek apakah ada session bernama isLogin
        // if (!$this->session->has('isLogin')) {
        //     return redirect()->to('/login');
        // }
        // dd($this->session->get('username'));
        $id = $this->session->get('id');
        $user = $this->userModel->getUserDetail($id);
        // dd($user);
        $data = [
            'title' => 'User | Monday To Friday',
            'user' => $this->userModel->getUserDetail($id),
            'statusNav' => 'profile',
            'cart' => $cart = \Config\Services::cart()
        ];

        return view('user/index', $data);
    }

    public function edit()
    {
        //cek apakah ada session bernama isLogin
        // if (!$this->session->has('isLogin')) {
        //     return redirect()->to('/login');
        // }
        // session();
        $userModel = new \App\Models\UserModel();
        $id = $this->session->get('id');
        $data = [
            'title' => 'Form Edit Data User | Monday to Friday',
            'validation' => \Config\Services::validation(),
            'user' => $this->userModel->getUserDetail($id),
            'statusNav' => 'profile',
            'cart' => $cart = \Config\Services::cart()
        ];
        return view('user/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            //kalau mau nambah rules baru, tambah pake |. misal required|numeric
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} product harus diisi,',
                ]
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} product harus diisi,',
                ]
            ],
            // 'no_hp' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => '{field} product harus diisi,',
            //     ]
            // ]
        ])) {
            return redirect()->to('/user/edit/' . $this->request->getVar('id'))->withInput();
            // return redirect()->to('/user/edit/' . $this->session->get('id'))->withInput();
        }

        // $this->$userModel->save([
        //     'id' => $id,
        //     'username' => $this->request->getVar('username'),
        //     'email' => $this->request->getVar('email'),
        //     'no_hp' => $this->request->getVar('no_hp'),
        // ]);

        $data = $this->request->getPost();
        $userModel = new \App\Models\UserModel();
        $user = new \App\Entities\User();

        $user->fill($data);
        $user->id = $this->session->get('id');

        // $transaksi->created_at = $this->session->get('logged_in');
        $user->updated_at = date("Y-m-d H:i:s");

        $userModel->save($user);

        session()->setFlashdata('pesan', 'Data berhasil diubah!');

        return redirect()->to('/user');
    }
    // public function index()
    // {
    //     $data['title'] = 'My Profile';
    //     return view('user/index', $data);
    // }
}
