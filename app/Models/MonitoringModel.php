<?php

namespace App\Models;

use CodeIgniter\Model;

class MonitoringModel extends Model
{
    protected $table = 'peminjaman';

    public function getAllMonitoringData()
    {
        return $this->select('
                peminjaman.*, 
                peminjam.nama as nama_user_akun, 
                penyetuju.nama as nama_penyetuju, 
                penerima.nama as nama_penerima,
                pengembalian.denda, 
                pengembalian.status_denda,
                alat.nama_alat,
                detail_peminjaman.jumlah as jumlah_detail
            ')
            ->join('users as peminjam', 'peminjam.id_user = peminjaman.id_user', 'left')
            ->join('users as penyetuju', 'penyetuju.id_user = peminjaman.disetujui_oleh', 'left')
            ->join('detail_peminjaman', 'detail_peminjaman.id_peminjaman = peminjaman.id_peminjaman', 'left')
            ->join('alat', 'alat.id_alat = detail_peminjaman.id_alat', 'left')
            ->join('pengembalian', 'pengembalian.id_peminjaman = peminjaman.id_peminjaman', 'left')
            ->join('users as penerima', 'penerima.id_user = pengembalian.diterima_oleh', 'left')
            ->orderBy('peminjaman.id_peminjaman', 'DESC')
            ->findAll();
    }
}