<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyUser6 extends Migration
{
    public function up()
    {
        {
            $fields = [
                'kontak' => [
                    'type' => 'INT',
                    'constraint' => 20,
                    'null' => TRUE
                 ],
                 'alamat' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => TRUE
                 ],
            ];
            $this->forge->addColumn('user', $fields);
        }
    }

    public function down()
    {
        //
    }
}
