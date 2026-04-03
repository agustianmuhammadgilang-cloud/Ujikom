<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDendaFieldsToPengembalian extends Migration
{
    public function up()
    {
        $fields = [];

        if (!$this->db->fieldExists('jumlah_bayar', 'pengembalian')) {
            $fields['jumlah_bayar'] = [
                'type' => 'INT',
                'default' => 0,
                'after' => 'denda'
            ];
        }

        if (!$this->db->fieldExists('status_denda', 'pengembalian')) {
            $fields['status_denda'] = [
                'type' => 'ENUM',
                'constraint' => ['belum', 'lunas'],
                'default' => 'belum',
                'after' => 'jumlah_bayar'
            ];
        }

        if (!empty($fields)) {
            $this->forge->addColumn('pengembalian', $fields);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('pengembalian', ['jumlah_bayar', 'status_denda']);
    }
}