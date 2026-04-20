<?php

namespace App\Models;

use CodeIgniter\Model;

class AlatModel extends Model
{
    protected $table = 'alat';
    protected $primaryKey = 'id_alat';

    protected $allowedFields = [
        'nama_alat',
        'id_kategori',
        'stok',
        'harga_denda',
        'foto'
    ];

    // join kategori
    public function getWithKategori()
    {
        return $this->select('alat.*, kategori.nama as nama_kategori')
                    ->join('kategori', 'kategori.id_kategori = alat.id_kategori')
                    ->findAll();
    }
}