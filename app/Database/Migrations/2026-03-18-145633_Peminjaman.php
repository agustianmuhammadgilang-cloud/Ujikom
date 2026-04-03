<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Peminjaman extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_peminjaman' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'tanggal_pinjam' => [
                'type' => 'DATETIME',
            ],
            'tanggal_kembali_rencana' => [
                'type' => 'DATETIME',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['menunggu','disetujui','ditolak','dipinjam','selesai'],
            ],
            'disetujui_oleh' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_peminjaman', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('disetujui_oleh', 'users', 'id_user', 'SET NULL', 'CASCADE');
        $this->forge->createTable('peminjaman');
    }

    public function down()
    {
        //
    }
}
