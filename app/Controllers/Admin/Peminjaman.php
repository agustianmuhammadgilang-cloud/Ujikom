<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;

class Peminjaman extends BaseController
{
    protected $peminjamanModel;
    
    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
    }
    // LIST
    public function index()
    {
        $data['peminjaman'] = $this->peminjamanModel
            ->select('peminjaman.*, users.nama as nama_user')
            ->join('users', 'users.id_user = peminjaman.id_user')
            ->findAll();

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses halaman peminjaman',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return view('admin/peminjaman/index', $data);
    }
}