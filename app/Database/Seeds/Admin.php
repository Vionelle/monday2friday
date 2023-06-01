<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Admin extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'admin01',
            'password' => password_hash('administrator', PASSWORD_DEFAULT),
            'nama_lengkap' => 'Muhammad Idzhar Abisina',
            'email' => 'muhammadidzharabisina@gmail.com',
        ];
        $this->db->table('admin')->insert($data);
    }
}
