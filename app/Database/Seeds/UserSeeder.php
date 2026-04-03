<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'admin',
            'nama'     => 'Administrator',
            'password' => password_hash('123456', PASSWORD_DEFAULT),
            'role'     => 'admin'
        ];

        $this->db->table('users')->insert($data);
    }
}