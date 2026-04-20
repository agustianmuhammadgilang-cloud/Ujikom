<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNamaPeminjamManual extends Migration
{
    public function up()
    {
        $fields = [
            'nama_peminjam_manual' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
                'after'      => 'id_user', // Letakkan setelah id_user
            ],
        ];
        $this->forge->addColumn('peminjaman', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('peminjaman', 'nama_peminjam_manual');
    }
}
