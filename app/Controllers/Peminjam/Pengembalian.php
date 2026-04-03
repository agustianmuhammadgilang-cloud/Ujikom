<?php

namespace App\Controllers\Peminjam;

use App\Controllers\BaseController;
use App\Models\PengembalianModel;

class Pengembalian extends BaseController
{
    protected $pengembalianModel;

    public function __construct()
    {
        $this->pengembalianModel = new PengembalianModel();
    }

    public function index()
    {
        $id_user = session()->get('id_user');

        $data['pengembalian'] = $this->pengembalianModel
            ->select('pengembalian.*, peminjaman.tanggal_pinjam')
            ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman')
            ->where('peminjaman.id_user', $id_user)
            ->findAll();

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => $id_user,
            'aktivitas' => 'Mengakses halaman pengembalian',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return view('peminjam/pengembalian/index', $data);
    }
}