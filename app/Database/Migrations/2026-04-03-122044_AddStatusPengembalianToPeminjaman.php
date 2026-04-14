<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusPengembalianToPeminjaman extends Migration
{
    public function up()
    {
        $this->forge->addColumn('peminjaman', [
            'status_pengembalian' => [
                'type' => 'ENUM',
                'constraint' => ['tidak_diajukan', 'diajukan', 'selesai'],
                'default' => 'tidak_diajukan',
                'after' => 'status'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('peminjaman', 'status_pengembalian');
    }
}