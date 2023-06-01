<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyUser extends Migration
{
    public function up()
    {
        $field = [
            'username' => [
                'name' => 'username',
                'type' => 'VARCHAR',
                'constraint'=> 100,
                'unique' => TRUE
            ],
        ];
    }

    public function down()
    {
        //
    }
}
