<?php

namespace App\Controllers\Peminjam;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\DetailPeminjamanModel;
use App\Models\AlatModel;

class Peminjaman extends BaseController
{
    protected $peminjamanModel;
    protected $detailModel;
    protected $alatModel;
    protected $db;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
        $this->detailModel = new DetailPeminjamanModel();
        $this->alatModel = new AlatModel();
        $this->db = \Config\Database::connect();
    }

    // LIST + RIWAYAT
    public function index()
    {
        $id_user = session()->get('id_user');

        $data['peminjaman'] = $this->peminjamanModel
            ->where('id_user', $id_user)
            ->findAll();

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => $id_user,
            'aktivitas' => 'Mengakses halaman peminjaman',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return view('peminjam/peminjaman/index', $data);
    }

    // FORM PINJAM
    public function create()
    {
        $data['alat'] = $this->alatModel->where('stok >', 0)->findAll();

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses form peminjaman',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return view('peminjam/peminjaman/create', $data);
    }

    // SIMPAN
    public function store()
{
    $id_user = session()->get('id_user');

    $id_alat = $this->request->getPost('id_alat');
    $jumlah = (int) $this->request->getPost('jumlah');
    $tanggal_kembali = $this->request->getPost('tanggal_kembali');

    // 🔍 Validasi dasar
    if (!$id_alat || !$jumlah || !$tanggal_kembali) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Data tidak lengkap');
    }

    if ($jumlah < 1) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Jumlah tidak valid');
    }

    // 🔥 Ambil data alat
    $alat = $this->alatModel->find($id_alat);

    if (!$alat) {
        return redirect()->back()
            ->with('error', 'Alat tidak ditemukan');
    }

    // 🔥 VALIDASI STOK (INTI)
    if ($jumlah > $alat['stok']) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Jumlah pinjam melebihi stok tersedia!');
    }

    // 🚀 Pakai TRANSACTION biar aman (anti data setengah masuk)
    $this->db->transStart();

    // simpan peminjaman
    $this->peminjamanModel->insert([
        'id_user' => $id_user,
        'tanggal_pinjam' => date('Y-m-d H:i:s'),
        'tanggal_kembali_rencana' => $tanggal_kembali,
        'status' => 'menunggu'
    ]);

    $id_peminjaman = $this->peminjamanModel->getInsertID();

    // simpan detail
    $this->detailModel->insert([
        'id_peminjaman' => $id_peminjaman,
        'id_alat' => $id_alat,
        'jumlah' => $jumlah
    ]);

    // LOG
    $logModel = new \App\Models\LogAktivitasModel();
    $logModel->insert([
        'id_user' => $id_user,
        'aktivitas' => 'Mengajukan peminjaman',
        'tanggal' => date('Y-m-d H:i:s')
    ]);

    $this->db->transComplete();

    // ❌ kalau gagal
    if ($this->db->transStatus() === false) {
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan saat menyimpan data');
    }

    // ✅ sukses
    return redirect()->to('/peminjam/peminjaman')
        ->with('success', 'Berhasil mengajukan peminjaman');
}
}