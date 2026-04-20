<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AlatModel;
use App\Models\KategoriModel;

class Alat extends BaseController
{
    protected $alatModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->alatModel = new AlatModel();
        $this->kategoriModel = new KategoriModel();
    }

    // LIST
    public function index()
    {
        $data['alat'] = $this->alatModel
            ->select('alat.*, kategori.nama as nama_kategori')
            ->join('kategori', 'kategori.id_kategori = alat.id_kategori')
            ->findAll();


        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses halaman alat',
            'tanggal' => date('Y-m-d H:i:s')
        ]);
        return view('admin/alat/index', $data);
    }

    // FORM TAMBAH
    public function create()
    {
        $data['kategori'] = $this->kategoriModel->findAll();

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses form tambah alat',
            'tanggal' => date('Y-m-d H:i:s')
        ]);
        
        return view('admin/alat/create', $data);
    }

    // SIMPAN
    public function store()
    {
        $file = $this->request->getFile('foto');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads', $namaFile);
        } else {
            $namaFile = null;
        }

        $this->alatModel->save([
            'nama_alat'   => $this->request->getPost('nama_alat'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'stok'        => $this->request->getPost('stok'),
            'harga_denda' => $this->request->getPost('harga_denda'),
            'foto'        => $namaFile
        ]);

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Menambahkan alat',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/alat')->with('success', 'Data berhasil ditambahkan');
    }

    // EDIT
    public function edit($id)
    {
        $data['alat'] = $this->alatModel->find($id);
        $data['kategori'] = $this->kategoriModel->findAll();

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses form edit alat',
            'tanggal' => date('Y-m-d H:i:s')
        ]);


        return view('admin/alat/edit', $data);
    }

    // UPDATE
    public function update($id)
    {
        $file = $this->request->getFile('foto');
        
        // UBAH DISINI: Sesuaikan dengan 'name' di form View (fotoLama)
        $fotoLama = $this->request->getPost('fotoLama'); 

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads', $namaFile);

            // hapus foto lama jika ada file baru yang diupload
            if ($fotoLama && $fotoLama != 'default.png' && file_exists('uploads/' . $fotoLama)) {
                unlink('uploads/' . $fotoLama);
            }
        } else {
            // Jika tidak ada foto baru, gunakan foto lama
            $namaFile = $fotoLama;
        }

        $this->alatModel->update($id, [
            'nama_alat'   => $this->request->getPost('nama_alat'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'stok'        => $this->request->getPost('stok'),
            'harga_denda' => $this->request->getPost('harga_denda'),
            'foto'        => $namaFile
        ]);

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Memperbarui alat',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/alat')->with('success', 'Data berhasil diupdate');
    }

    // DELETE
    public function delete($id)
    {
        $alat = $this->alatModel->find($id);

        if ($alat['foto'] && file_exists('uploads/' . $alat['foto'])) {
            unlink('uploads/' . $alat['foto']);
        }

        $this->alatModel->delete($id);

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Menghapus alat',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/alat')->with('success', 'Data berhasil dihapus');
    }
}