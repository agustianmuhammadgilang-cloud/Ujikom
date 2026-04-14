<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddHargaDendaToAlat extends Migration
{
    public function up()
    {
        $this->forge->addColumn('alat', [
            'harga_denda' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'after' => 'stok'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('alat', 'harga_denda');
    }
}