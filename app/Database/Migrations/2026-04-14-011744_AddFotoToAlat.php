<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoToAlat extends Migration
{
    public function up()
    {
        $fields = [
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'harga_denda'
            ],
        ];

        $this->forge->addColumn('alat', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('alat', 'foto');
    }
}
