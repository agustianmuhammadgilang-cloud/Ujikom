<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;

class Laporan extends BaseController
{
    public function index()
    {
        $peminjamanModel = new PeminjamanModel();

        // =====================
        // DATA GABUNGAN (VERSI 3)
        // =====================
        $dataLaporan = $peminjamanModel
            ->select('
                peminjaman.*,
                users.nama as nama_peminjam,
                pengembalian.tanggal_kembali,
                pengembalian.denda,
                pengembalian.status_denda
            ')
            ->join('users', 'users.id_user = peminjaman.id_user')
            ->join('pengembalian', 'pengembalian.id_peminjaman = peminjaman.id_peminjaman', 'left')
            ->where('peminjaman.status !=', 'ditolak')
            ->findAll();

        // =====================
        // RINGKASAN
        // =====================
        $total_peminjaman = count($dataLaporan);

        $total_pengembalian = 0;
        $total_denda = 0;
        $total_denda_lunas = 0;

        foreach ($dataLaporan as $d) {
            $denda = $d['denda'] ?? 0;
            $kembali = !empty($d['tanggal_kembali']);

            // Hitung pengembalian
            if ($kembali) {
                $total_pengembalian++;
            }

            // Total denda
            $total_denda += $denda;

            // Denda lunas (harus ada denda & sudah bayar)
            if ($denda > 0 && $d['status_denda'] == 'sudah_bayar') {
                $total_denda_lunas += $denda;
            }
        }

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses halaman laporan',
            'tanggal' => date('Y-m-d H:i:s')
        ]);


        return view('petugas/laporan/index', [
            'data_laporan' => $dataLaporan,
            'total_peminjaman' => $total_peminjaman,
            'total_pengembalian' => $total_pengembalian,
            'total_denda' => $total_denda,
            'total_denda_lunas' => $total_denda_lunas
        ]);
    }
}