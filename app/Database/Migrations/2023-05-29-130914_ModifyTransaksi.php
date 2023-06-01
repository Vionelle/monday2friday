<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyTransaksi extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'CHAR',
                'constraint' => 3,
                'name' => 'id_transaksi',
             ]
        ];
        $this->forge->addColumn('transaksi', $fields);

    }

    public function down()
    {
        //
    }
}
