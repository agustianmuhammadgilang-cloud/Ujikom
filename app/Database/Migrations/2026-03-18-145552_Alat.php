<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Alat extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_alat' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_alat' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'id_kategori' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'stok' => [
                'type' => 'INT',
            ],
        ]);

        $this->forge->addKey('id_alat', true);
        $this->forge->addForeignKey('id_kategori', 'kategori', 'id_kategori', 'CASCADE', 'CASCADE');
        $this->forge->createTable('alat');
    }

    public function down()
    {
        //
    }
}
