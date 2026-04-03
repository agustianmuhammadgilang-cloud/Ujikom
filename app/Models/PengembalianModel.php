<?php

namespace App\Models;

use CodeIgniter\Model;

class PengembalianModel extends Model
{
    protected $table = 'pengembalian';
    protected $primaryKey = 'id_pengembalian';

    protected $allowedFields = [
        'id_peminjaman',
        'tanggal_kembali',
        'denda',
        'jumlah_bayar',
        'diterima_oleh',
        'status_denda',
        'tanggal_bayar'
    ];

    public function getWithUser()
    {
        return $this->select('peminjaman.*, users.nama as nama_peminjam')
                    ->join('users', 'users.id_user = peminjaman.id_user');
    }
}