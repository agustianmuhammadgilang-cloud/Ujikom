<?php

namespace App\Controllers\Peminjam;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\DetailPeminjamanModel;
use App\Models\AlatModel;
use App\Models\KategoriModel;
use App\Models\LogAktivitasModel;

class Peminjaman extends BaseController
{
    protected $peminjamanModel;
    protected $detailModel;
    protected $alatModel;
    protected $kategoriModel;
    protected $logModel;
    protected $db;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
        $this->detailModel = new DetailPeminjamanModel();
        $this->alatModel = new AlatModel();
        $this->kategoriModel = new KategoriModel();
        $this->logModel = new LogAktivitasModel();
        $this->db = \Config\Database::connect();
    }

    // 1. HALAMAN KATALOG ALAT (PILIH ALAT)
    public function index()
    {
        $id_kategori = $this->request->getVar('kategori');
        
        // Ambil data alat dengan join kategori
        $builder = $this->alatModel->select('alat.*, kategori.nama as nama_kategori')
                                   ->join('kategori', 'kategori.id_kategori = alat.id_kategori');

        if ($id_kategori) {
            $builder->where('alat.id_kategori', $id_kategori);
        }

        $data = [
            'alat'      => $builder->findAll(),
            'kategori'  => $this->kategoriModel->findAll(),
            'title'     => 'Katalog Alat'
        ];

        return view('peminjam/peminjaman/index', $data);
    }

    // 2. HALAMAN RIWAYAT PEMINJAMAN (PINDAHAN DARI INDEX LAMA)
    public function riwayat()
    {
        $id_user = session()->get('id_user');

        $data = [
            'peminjaman' => $this->peminjamanModel->where('id_user', $id_user)->findAll(),
            'title'      => 'Riwayat Peminjaman'
        ];

        return view('peminjam/peminjaman/riwayat', $data);
    }

    // 3. FORM PINJAM (DENGAN DETAIL ALAT YANG DIPILIH)
    public function create($id_alat = null)
    {
        if (!$id_alat) {
            return redirect()->to('/peminjam/peminjaman')->with('error', 'Pilih alat terlebih dahulu');
        }

        $alat = $this->alatModel->select('alat.*, kategori.nama as nama_kategori')
                                ->join('kategori', 'kategori.id_kategori = alat.id_kategori')
                                ->find($id_alat);

        if (!$alat) {
            return redirect()->to('/peminjam/peminjaman')->with('error', 'Alat tidak ditemukan');
        }

        $data = [
            'alat'  => $alat,
            'title' => 'Konfirmasi Pinjam'
        ];

        return view('peminjam/peminjaman/create', $data);
    }

    // 4. SIMPAN DATA
    public function store()
    {
        $id_user = session()->get('id_user');
        $id_alat = $this->request->getPost('id_alat');
        $jumlah  = (int) $this->request->getPost('jumlah');
        
        // Ambil data tanggal dari input manual
        $tanggal_pinjam = $this->request->getPost('tanggal_pinjam'); 
        $tanggal_kembali = $this->request->getPost('tanggal_kembali');

        // Validasi tambahan: pastikan tanggal pinjam diisi
        if (!$id_alat || !$jumlah || !$tanggal_kembali || !$tanggal_pinjam) {
            return redirect()->back()->withInput()->with('error', 'Data tidak lengkap');
        }

        $alat = $this->alatModel->find($id_alat);
        if ($jumlah > $alat['stok']) {
            return redirect()->back()->withInput()->with('error', 'Jumlah pinjam melebihi stok tersedia!');
        }

        $this->db->transStart();

        // 1. Insert Peminjaman
        $this->peminjamanModel->insert([
            'id_user' => $id_user,
            'tanggal_pinjam' => $tanggal_pinjam, // Sekarang menggunakan variabel dari input
            'tanggal_kembali_rencana' => $tanggal_kembali,
            'status' => 'menunggu'
        ]);

        $id_peminjaman = $this->peminjamanModel->getInsertID();

        // 2. Insert Detail
        $this->detailModel->insert([
            'id_peminjaman' => $id_peminjaman,
            'id_alat'       => $id_alat,
            'jumlah'        => $jumlah
        ]);

        // 3. Log Aktivitas
        $this->logModel->insert([
            'id_user'   => $id_user,
            'aktivitas' => 'Mengajukan pinjaman alat: ' . $alat['nama_alat'],
            'tanggal'   => date('Y-m-d H:i:s') // Log tetap otomatis waktu sekarang
        ]);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi.');
        }

        return redirect()->to('/peminjam/peminjaman/riwayat')->with('success', 'Pengajuan berhasil dikirim!');
    }
}