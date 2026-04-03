<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusDendaToPengembalian extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pengembalian', [
            'status_denda' => [
                'type' => 'ENUM',
                'constraint' => ['belum_bayar', 'sudah_bayar'],
                'default' => 'belum_bayar',
                'after' => 'denda'
            ],
            'tanggal_bayar' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'status_denda'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pengembalian', ['status_denda', 'tanggal_bayar']);
    }
}