<?php

namespace App\Controllers\Peminjam;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\AlatModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $peminjamanModel = new PeminjamanModel();
        $alatModel = new AlatModel();

        $id_user = session()->get('id_user');

        $data = [
            'total_peminjaman' => $peminjamanModel->where('id_user', $id_user)->countAllResults(),
            'menunggu' => $peminjamanModel->where([
                'id_user' => $id_user,
                'status' => 'menunggu'
            ])->countAllResults(),
            'disetujui' => $peminjamanModel->where([
                'id_user' => $id_user,
                'status' => 'disetujui'
            ])->countAllResults(),
            'alat_tersedia' => $alatModel->where('stok >', 0)->countAllResults()
        ];

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => $id_user,
            'aktivitas' => 'Mengakses dashboard',
            'tanggal' => date('Y-m-d H:i:s')
        ]);


        return view('peminjam/dashboard', $data);
    }
}