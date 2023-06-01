<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyUser5 extends Migration
{
    public function up()
    {
        $fields = [
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
             ],
        ];
        $this->forge->addColumn('user', $fields);
    }

    public function down()
    {
        //
    }
}
