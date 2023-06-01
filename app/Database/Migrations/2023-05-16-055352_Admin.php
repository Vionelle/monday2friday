<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Admin extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id'=>[
                'type'=>'INT',
                'constraint'=>11,
                'unsigned'=>TRUE,
                'auto_increment'=>TRUE
            ],
            'username'=>[
                'type'=>'VARCHAR',
                'constraint'=>100,
                'unique' => TRUE
            ],
            'password'=>[
                'type'=>'TEXT'
            ],
            'role'=>[
                'type'=>'INT',
                'constraint'=>1,
                'default'=>0
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint'=>100,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => TRUE
            ],
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => 25
            ],
            'last_login timestamp default now()'
        ]);

        $this->forge->addKey('id',TRUE);
        $this->forge->createTable('admin');
        
    }

    public function down()
    {
        //
        $this->forge->dropTable('admin');
    }
}
