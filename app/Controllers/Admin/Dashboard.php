<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AlatModel;
use App\Models\PeminjamanModel;

class Dashboard extends BaseController
{
    // DASHBOARD
    public function index()
    {
        $userModel = new UserModel();
        $alatModel = new AlatModel();
        $peminjamanModel = new PeminjamanModel();

        $data = [
            'total_user' => $userModel->countAll(),
            'total_alat' => $alatModel->countAll(),
            'total_peminjaman' => $peminjamanModel->countAll()
        ];

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses dashboard',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return view('admin/dashboard', $data);
    }
}