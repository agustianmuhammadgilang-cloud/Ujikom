<?php

namespace App\Controllers\Peminjam;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\LogAktivitasModel;

class Pengembalian extends BaseController
{
    public function index()
    {
        $id_user = session()->get('id_user');
        $db = \Config\Database::connect();
        
        // Ambil data peminjaman beserta info denda dari tabel pengembalian
        $peminjaman = $db->table('peminjaman')
            ->select('peminjaman.*, pengembalian.denda, pengembalian.status_denda, pengembalian.tanggal_kembali')
            ->join('pengembalian', 'pengembalian.id_peminjaman = peminjaman.id_peminjaman', 'left')
            ->where('peminjaman.id_user', $id_user)
            ->orderBy('peminjaman.id_peminjaman', 'DESC')
            ->get()
            ->getResultArray();

        foreach ($peminjaman as &$p) {
            $p['estimasi_denda'] = 0;
            $p['terlambat'] = 0;

            // Logika Estimasi Denda (Jika masih dipinjam/proses kembali)
            if ($p['status'] == 'disetujui' && $p['status_pengembalian'] != 'selesai') {
                $tgl_deadline = strtotime($p['tanggal_kembali_rencana']);
                $tgl_sekarang = strtotime(date('Y-m-d'));

                if ($tgl_sekarang > $tgl_deadline) {
                    $selisih_detik = $tgl_sekarang - $tgl_deadline;
                    $hari_terlambat = floor($selisih_detik / (60 * 60 * 24));
                    $p['terlambat'] = $hari_terlambat;

                    $tarif = $db->table('detail_peminjaman')
                        ->join('alat', 'alat.id_alat = detail_peminjaman.id_alat')
                        ->where('id_peminjaman', $p['id_peminjaman'])
                        ->selectSum('alat.harga_denda', 'total_tarif')
                        ->get()
                        ->getRowArray();
                    
                    $p['estimasi_denda'] = $hari_terlambat * ($tarif['total_tarif'] ?? 0);
                }
            }
        }

        // Log
        $logModel = new LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses halaman pengembalian',
            'tanggal' => date('Y-m-d H:i:s')
        ]);


        $data['peminjaman'] = $peminjaman;
        return view('peminjam/pengembalian/index', $data);
    }

    public function ajukan($id)
    {
        $model = new PeminjamanModel();
        $id_user = session()->get('id_user');

        $data = $model->where(['id_peminjaman' => $id, 'id_user' => $id_user])->first();

        if (!$data || $data['status'] !== 'disetujui' || $data['status_pengembalian'] !== 'tidak_diajukan') {
            return redirect()->back()->with('error', 'Permintaan tidak valid.');
        }

        $model->update($id, ['status_pengembalian' => 'diajukan']);

        $logModel = new LogAktivitasModel();
        $logModel->insert([
            'id_user'   => $id_user,
            'aktivitas' => 'Mengajukan pengembalian ID ' . $id,
            'tanggal'   => date('Y-m-d H:i:s')
        ]);

        // Log
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengajukan pengembalian ID ' . $id,
            'tanggal' => date('Y-m-d H:i:s')
        ]);


        return redirect()->back()->with('success', 'Pengembalian berhasil diajukan!');
    }
}