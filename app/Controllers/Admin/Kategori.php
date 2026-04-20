<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    // Tampilkan data
    public function index()
    {
        // Query untuk mengambil kategori beserta jumlah alatnya
        $data['kategori'] = $this->kategoriModel
            ->select('kategori.*, COUNT(alat.id_alat) as total_alat')
            ->join('alat', 'alat.id_kategori = kategori.id_kategori', 'left')
            ->groupBy('kategori.id_kategori')
            ->findAll();

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses halaman kategori',
            'tanggal' => date('Y-m-d H:i:s')
        ]);
        
        return view('admin/kategori/index', $data);
    }

    // Form tambah
    public function create()
    {
        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses form tambah kategori',
            'tanggal' => date('Y-m-d H:i:s')
        ]);
        
        return view('admin/kategori/create');
    }

    // Simpan data
    public function store()
    {
        $this->kategoriModel->save([
            'nama' => $this->request->getPost('nama')
        ]);

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Menambahkan kategori',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/kategori')->with('success', 'Data berhasil ditambahkan');
    }

    // Form edit
    public function edit($id)
    {
        $data['kategori'] = $this->kategoriModel->find($id);

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses form edit kategori',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return view('admin/kategori/edit', $data);
    }

    // Update
    public function update($id)
    {
        $this->kategoriModel->update($id, [
            'nama' => $this->request->getPost('nama')
        ]);

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Memperbarui kategori',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/kategori')->with('success', 'Data berhasil diupdate');
    }

    // Hapus
    public function delete($id)
    {
        $this->kategoriModel->delete($id);
        
        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Menghapus kategori',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/kategori')->with('success', 'Data berhasil dihapus');
    }
}