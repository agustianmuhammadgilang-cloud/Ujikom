<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengembalianModel;

class Pengembalian extends BaseController
{
    protected $pengembalianModel;

    public function __construct()
    {
        $this->pengembalianModel = new PengembalianModel();
    }
    // LIST
    public function index()
    {
        $data['pengembalian'] = $this->pengembalianModel
        ->select('
            pengembalian.*, 
            users.nama as nama_user,
            petugas.nama as nama_petugas
        ')
        ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman')
        ->join('users', 'users.id_user = peminjaman.id_user')
        ->join('users as petugas', 'petugas.id_user = pengembalian.diterima_oleh')
        ->findAll();

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses halaman pengembalian',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return view('admin/pengembalian/index', $data);
    }
}