<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\PengembalianModel;
use App\Models\DetailPeminjamanModel;
use App\Models\AlatModel;
use App\Models\LogAktivitasModel;

class Pengembalian extends BaseController
{
    protected $peminjamanModel;
    protected $pengembalianModel;
    protected $detailModel;
    protected $alatModel;

    public function __construct() {
        $this->peminjamanModel = new PeminjamanModel();
        $this->pengembalianModel = new PengembalianModel();
        $this->detailModel = new DetailPeminjamanModel();
        $this->alatModel = new AlatModel();
    }

    public function index() {
        $data['pengembalian'] = $this->peminjamanModel
            ->select('peminjaman.*, pengembalian.id_pengembalian, pengembalian.denda, pengembalian.status_denda, pengembalian.tanggal_kembali')
            // Gunakan INNER JOIN agar hanya data yang sudah dikembalikan yang muncul
            ->join('pengembalian', 'pengembalian.id_peminjaman = peminjaman.id_peminjaman') 
            ->where('peminjaman.nama_peminjam_manual !=', null)
            ->orderBy('pengembalian.id_pengembalian', 'DESC')
            ->findAll();

        // LOG
        $logModel = new LogAktivitasModel();
        $logModel->insert([
            'id_user'   => session()->get('id_user'),
            'aktivitas' => 'Admin mengakses halaman pengembalian',
            'tanggal'   => date('Y-m-d H:i:s')
        ]);

        return view('admin/pengembalian/index', $data);
    }

    public function create() {
    // Ambil semua id_peminjaman yang sudah pernah diproses kembali
    $peminjamanSelesai = $this->pengembalianModel->findColumn('id_peminjaman') ?: [0];

    $data['peminjaman_aktif'] = $this->peminjamanModel
        ->where('nama_peminjam_manual !=', null)
        ->where('status', 'dipinjam')
        // Pastikan nama yang sudah dikembalikan tidak muncul lagi
        ->whereNotIn('id_peminjaman', $peminjamanSelesai) 
        ->findAll();

        return view('admin/pengembalian/tambah', $data);
    }

    public function store()
    {
        $id_peminjaman = $this->request->getPost('id_peminjaman');
        $peminjaman = $this->peminjamanModel->find($id_peminjaman);

        if (!$peminjaman) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $tanggal_kembali = $this->request->getPost('tanggal_kembali');
        $tanggal_rencana = $peminjaman['tanggal_kembali_rencana'];

        // HITUNG SELISIH HARI
        $selisih = floor((strtotime((string)$tanggal_kembali) - strtotime((string)$tanggal_rencana)) / (60 * 60 * 24));
        $denda = 0;

        if ($selisih > 0) {
            $details = $this->detailModel
                ->select('detail_peminjaman.*, alat.harga_denda')
                ->join('alat', 'alat.id_alat = detail_peminjaman.id_alat')
                ->where('id_peminjaman', $id_peminjaman)
                ->findAll();

            foreach ($details as $d) {
                $denda += ($selisih * $d['harga_denda'] * $d['jumlah']);
            }
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. SIMPAN KE TABEL PENGEMBALIAN
        $this->pengembalianModel->insert([
            'id_peminjaman'   => $id_peminjaman,
            'tanggal_kembali' => $tanggal_kembali,
            'denda'           => $denda,
            'jumlah_bayar'    => 0,
            'status_denda'    => ($denda > 0) ? 'belum_bayar' : 'lunas',
            'diterima_oleh'   => session()->get('id_user')
        ]);

        // 2. UPDATE STATUS PEMINJAMAN (Penting agar tidak duplikat)
        $this->peminjamanModel->update($id_peminjaman, [
            'status' => 'selesai',
            'status_pengembalian' => 'selesai'
        ]);

        // 3. UPDATE STOK ALAT (Balikkan stok)
        $details = $this->detailModel->where('id_peminjaman', $id_peminjaman)->findAll();
        foreach ($details as $d) {
            $alat = $this->alatModel->find($d['id_alat']);
            $this->alatModel->update($d['id_alat'], [
                'stok' => $alat['stok'] + $d['jumlah']
            ]);
        }

        $db->transComplete();

        // 4. REDIRECT (Solusi Layar Putih)
        return redirect()->to('/admin/pengembalian')->with('success', 'Pengembalian berhasil diproses.');
    }

    public function bayar($id)
    {
        // Ambil data pengembalian
        $pengembalian = $this->pengembalianModel->find($id);
        
        if (!$pengembalian) {
            return redirect()->to('/admin/pengembalian')->with('error', 'Data denda tidak ditemukan.');
        }

        // Ambil data peminjaman terkait untuk nama peminjam
        $peminjaman = $this->peminjamanModel->find($pengembalian['id_peminjaman']);

        // Ambil rincian alat untuk ditampilkan di struk/rincian denda
        $detail = $this->detailModel
            ->select('detail_peminjaman.*, alat.nama_alat, alat.harga_denda')
            ->join('alat', 'alat.id_alat = detail_peminjaman.id_alat')
            ->where('id_peminjaman', $pengembalian['id_peminjaman'])
            ->findAll();

        $data = [
            'pengembalian' => $pengembalian,
            'peminjaman'   => $peminjaman,
            'detail'       => $detail
        ];

        return view('admin/pengembalian/bayar', $data);
    }

    public function prosesBayar($id)
    {
        $jumlah_bayar = $this->request->getPost('jumlah_bayar');
        $pengembalian = $this->pengembalianModel->find($id);

        if ($jumlah_bayar < $pengembalian['denda']) {
            return redirect()->back()->with('error', 'Jumlah bayar tidak boleh kurang dari total denda!');
        }

        // Update status denda menjadi lunas
        $this->pengembalianModel->update($id, [
            'jumlah_bayar' => $jumlah_bayar,
            'status_denda' => 'sudah_bayar'
        ]);

        // Log Aktivitas
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user'   => session()->get('id_user'),
            'aktivitas' => 'Admin menerima pembayaran denda ID Pengembalian: ' . $id,
            'tanggal'   => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/pengembalian')->with('success', 'Pembayaran denda berhasil dikonfirmasi. Status: Lunas.');
    }
    
public function edit($id)
{
    $data['pengembalian'] = $this->pengembalianModel
        ->select('pengembalian.*, peminjaman.nama_peminjam_manual, peminjaman.jumlah_pinjam') 
        ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman')
        ->find($id);

    if (!$data['pengembalian']) {
        return redirect()->to('/admin/pengembalian')->with('error', 'Data tidak ditemukan.');
    }

    return view('admin/pengembalian/edit', $data);
}

public function update($id)
{
    // 1. Ambil data pengembalian untuk mendapatkan 'id_peminjaman'
    $pengembalian = $this->pengembalianModel->find($id);
    
    if (!$pengembalian) {
        return redirect()->back()->with('error', 'Data pengembalian tidak ditemukan.');
    }

    // 2. Ambil ID peminjaman yang terkait
    $idPeminjaman = $pengembalian['id_peminjaman'];
    $namaBaru = $this->request->getPost('nama_peminjam_manual');

    // 3. Update nama di tabel PEMINJAMAN
    // Pastikan kamu sudah memanggil PeminjamanModel di constructor atau dengan model()
    $peminjamanModel = new \App\Models\PeminjamanModel();
    
    $peminjamanModel->update($idPeminjaman, [
        'nama_peminjam_manual' => $namaBaru
    ]);

    // 4. Redirect kembali
    session()->setFlashdata('success', 'Nama peminjam berhasil diperbarui di catatan peminjaman.');
    return redirect()->to('/admin/pengembalian');
}

public function delete($id)
{
    $model = new \App\Models\PengembalianModel();

    $model->delete($id);

    return redirect()->to('/admin/pengembalian')->with('success', 'Data berhasil dihapus');
}

}