<?php

namespace App\Controllers\Admin;

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

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
        $this->detailModel = new DetailPeminjamanModel();
        $this->alatModel = new AlatModel();
        $this->kategoriModel = new KategoriModel();
        $this->logModel = new LogAktivitasModel();
    }

    public function index()
    {
        $data['peminjaman'] = $this->peminjamanModel
            ->where('nama_peminjam_manual !=', null) // Hanya ambil data manual
            ->orderBy('id_peminjaman', 'DESC')
            ->findAll();

        return view('admin/peminjaman/index', $data);
    }

    public function create()
    {
        $data = [
            'kategori' => $this->kategoriModel->findAll(),
            'alat'     => $this->alatModel->where('stok >', 0)->findAll()
        ];
        return view('admin/peminjaman/tambah', $data);
    }

    public function store()
    {
        $id_alat = $this->request->getPost('id_alat');
        $jumlah  = $this->request->getPost('jumlah'); 
        
        // 1. Cek stok alat
        $alat = $this->alatModel->find($id_alat);
        if ($alat['stok'] < $jumlah) {
            return redirect()->back()->with('error', 'Stok alat tidak mencukupi!');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // 2. Simpan ke tabel PEMINJAMAN
        $this->peminjamanModel->insert([
            'id_user'                 => null,
            'nama_peminjam_manual'    => $this->request->getPost('nama_lengkap'),
            'id_alat'                 => $id_alat, 
            'jumlah_pinjam'           => $jumlah,  
            'tanggal_pinjam'          => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali_rencana' => $this->request->getPost('tanggal_kembali'),
            'status'                  => 'dipinjam',
            'status_pengembalian'     => 'tidak_diajukan',
            // --- TAMBAHKAN BARIS DI BAWAH INI ---
            'disetujui_oleh'          => session()->get('id_user') 
        ]);

        $idPeminjaman = $this->peminjamanModel->getInsertID();

        // 3. Simpan ke detail_peminjaman 
        $this->detailModel->insert([
            'id_peminjaman' => $idPeminjaman,
            'id_alat'       => $id_alat,
            'jumlah'        => $jumlah
        ]);

        // 4. Update Stok Alat
        $this->alatModel->update($id_alat, [
            'stok' => $alat['stok'] - $jumlah
        ]);

        // 5. Log Aktivitas
        $this->logModel->insert([
            'id_user'   => session()->get('id_user'),
            'aktivitas' => 'Admin membuat peminjaman manual (Auto-Approved) untuk: ' . $this->request->getPost('nama_lengkap'),
            'tanggal'   => date('Y-m-d H:i:s')
        ]);

        $db->transComplete();

        return redirect()->to('/admin/peminjaman')->with('success', 'Peminjaman manual berhasil dibuat.');
    }


    public function edit($id)
    {
        $peminjaman = $this->peminjamanModel->find($id);
        
        // Ambil detail peminjaman untuk mendapatkan ID Alat dan Jumlah
        $detail = $this->detailModel->where('id_peminjaman', $id)->first();
        
        // Ambil data alat yang sedang dipinjam untuk ditampilkan namanya
        $alat_pilihan = $this->alatModel->find($detail['id_alat']);

        $data = [
            'peminjaman'   => $peminjaman,
            'detail'       => $detail,
            'alat_pilihan' => $alat_pilihan,
            'kategori'     => $this->kategoriModel->findAll(),
            'alat'         => $this->alatModel->findAll()
        ];

        return view('admin/peminjaman/edit', $data);
    }

    public function update($id)
    {
        // Ambil data lama untuk memastikan id_user tetap NULL (karena manual)
        $peminjamanLama = $this->peminjamanModel->find($id);

        $this->peminjamanModel->update($id, [
            'id_user'                 => null, // Pastikan tetap null agar terbaca sebagai manual
            'nama_peminjam_manual'    => $this->request->getPost('nama_lengkap'),
            'tanggal_pinjam'          => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali_rencana' => $this->request->getPost('tanggal_kembali'),
        ]);

        // Log Aktivitas
        $this->logModel->insert([
            'id_user'   => session()->get('id_user'),
            'aktivitas' => 'Admin mengubah data peminjaman manual ID: ' . $id,
            'tanggal'   => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/peminjaman')->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    public function delete($id)
    {
        $peminjaman = $this->peminjamanModel->find($id);
        $detail     = $this->detailModel->where('id_peminjaman', $id)->first();

        if ($peminjaman && $detail) {
            // Kembalikan stok alat jika statusnya masih dipinjam
            if ($peminjaman['status'] == 'dipinjam') {
                $alat = $this->alatModel->find($detail['id_alat']);
                $this->alatModel->update($detail['id_alat'], [
                    'stok' => $alat['stok'] + $detail['jumlah']
                ]);
            }

            $this->peminjamanModel->delete($id);
            return redirect()->to('/admin/peminjaman')->with('success', 'Data berhasil dihapus & stok dikembalikan.');
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }
}