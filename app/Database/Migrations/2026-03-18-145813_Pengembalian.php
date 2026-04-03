<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pengembalian extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pengembalian' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_peminjaman' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'tanggal_kembali' => [
                'type' => 'DATETIME',
            ],
            'denda' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'diterima_oleh' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
        ]);

        $this->forge->addKey('id_pengembalian', true);
        $this->forge->addForeignKey('id_peminjaman', 'peminjaman', 'id_peminjaman', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('diterima_oleh', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengembalian');
    }

    public function down()
    {
        //
    }
}
