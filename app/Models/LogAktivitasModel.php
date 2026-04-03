<?php

namespace App\Models;

use CodeIgniter\Model;

class LogAktivitasModel extends Model
{
    protected $table = 'log_aktivitas';
    protected $primaryKey = 'id_log';

    protected $allowedFields = [
        'id_user',
        'aktivitas',
        'tanggal'
    ];

    protected $useTimestamps = false;
}