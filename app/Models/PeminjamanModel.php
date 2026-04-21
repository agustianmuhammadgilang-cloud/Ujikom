<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $allowedFields = [
        'id_user',
        'nama_peminjam_manual',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'status',
        'disetujui_oleh',
        'status_pengembalian'
    ];

    // ambil dengan user
    public function getWithUser()
    {
        return $this->select('peminjaman.*, users.nama')
                    ->join('users', 'users.id_user = peminjaman.id_user')
                    ->findAll();
    }
}