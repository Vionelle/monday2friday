<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyUser4 extends Migration
{
    public function up()
    {
        $fields = [
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => TRUE
             ],
        ];
        $this->forge->addColumn('user', $fields);
    }

    public function down()
    {
        //
    }
}
