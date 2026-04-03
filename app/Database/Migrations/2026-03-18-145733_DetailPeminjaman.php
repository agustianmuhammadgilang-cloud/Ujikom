<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailPeminjaman extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_peminjaman' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'id_alat' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'jumlah' => [
                'type' => 'INT',
            ],
        ]);

        $this->forge->addKey('id_detail', true);
        $this->forge->addForeignKey('id_peminjaman', 'peminjaman', 'id_peminjaman', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_alat', 'alat', 'id_alat', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_peminjaman');
    }

    public function down()
    {
        //
    }
}
