<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPeminjamanModel extends Model
{
    protected $table = 'detail_peminjaman';
    protected $primaryKey = 'id_detail';

    protected $allowedFields = [
        'id_peminjaman',
        'id_alat',
        'jumlah'
    ];

    // join alat
    public function getDetail($id_peminjaman)
    {
        return $this->select('detail_peminjaman.*, alat.nama_alat')
                    ->join('alat', 'alat.id_alat = detail_peminjaman.id_alat')
                    ->where('id_peminjaman', $id_peminjaman)
                    ->findAll();
    }
}