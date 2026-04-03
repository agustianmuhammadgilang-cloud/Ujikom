<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $allowedFields = [
        'username',
        'nama',
        'password',
        'role'
    ];

    protected $useTimestamps = true;

    // ambil user berdasarkan username
    public function getByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}