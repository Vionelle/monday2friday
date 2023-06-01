<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        for($i=0; $i<30; $i++){
            $data = [
                'username' => $faker->username,
                //'email'    => 'darth@theempire.com',
                'password' => $faker->password,
                'salt' => $faker->password,
                'avatar' => NULL,
                'role' => 1,
                'created_by' => 0,
                'created_date' => date("Y-m-d H:i:s"),
            ];
    
            // Using Query Builder
            $this->db->table('user')->insert($data);
        }
        
    }
}
?>