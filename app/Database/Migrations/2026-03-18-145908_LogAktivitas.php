<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LogAktivitas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_log' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'aktivitas' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal' => [
                'type' => 'DATETIME',
            ],
        ]);

        $this->forge->addKey('id_log', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('log_aktivitas');
    }

    public function down()
    {
        //
    }
}
