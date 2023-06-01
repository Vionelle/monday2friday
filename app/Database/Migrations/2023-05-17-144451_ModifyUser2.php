<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyUser2 extends Migration
{
    public function up()
    {
        $fields = [
            'username' => [
                'name' => 'username',
                'type' => 'VARCHAR',
                'constraint'=> 100,
                'unique' => TRUE
            ],
        ];
        $this->forge->modifyColumn('user', $fields);
    }

    public function down()
    {
        //
    }
}
