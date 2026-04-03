<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\PengembalianModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $peminjamanModel = new PeminjamanModel();
        $pengembalianModel = new PengembalianModel();

        $data = [
            'total_peminjaman'   => $peminjamanModel->countAll(),
            'total_pengembalian' => $pengembalianModel->countAll(),
            'menunggu' => $peminjamanModel->where('status', 'menunggu')->countAllResults(),
            'disetujui' => $peminjamanModel->where('status', 'disetujui')->countAllResults(),
        ];

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses dashboard',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return view('petugas/dashboard', $data);
    }
}