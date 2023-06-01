<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyBarang extends Migration
{
    public function up()
    {
        $fields = [
            'size' => [
                'type' => 'VARCHAR',
                'constraint' => 3,
             ],
        ];
        $this->forge->addColumn('barang', $fields);
    }

    public function down()
    {
        //
    }
}
