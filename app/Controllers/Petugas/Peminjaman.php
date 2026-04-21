<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\LogAktivitasModel;
use App\Models\DetailPeminjamanModel;
use App\Models\AlatModel;

class Peminjaman extends BaseController
{
    public function index()
    {
        $model = new PeminjamanModel();

        $data['peminjaman'] = $model
            ->select('peminjaman.*, users.nama')
            ->join('users', 'users.id_user = peminjaman.id_user')
            ->findAll();

        // LOG
        $logModel = new LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses halaman peminjaman',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return view('petugas/peminjaman/index', $data);
    }

    public function detail($id)
    {
        $peminjamanModel = new PeminjamanModel();
        $detailModel = new DetailPeminjamanModel();

        $peminjaman = $peminjamanModel
            ->select('peminjaman.*, users.nama')
            ->join('users', 'users.id_user = peminjaman.id_user')
            ->where('peminjaman.id_peminjaman', $id) // Gunakan prefix tabel
            ->first();

        // Pastikan WHERE menggunakan nama tabel agar tidak menarik data dari peminjaman lain
        $detail = $detailModel
            ->select('detail_peminjaman.*, alat.nama_alat, alat.stok, alat.foto, kategori.nama as nama_kategori')
            ->join('alat', 'alat.id_alat = detail_peminjaman.id_alat')
            ->join('kategori', 'kategori.id_kategori = alat.id_kategori', 'left')
            ->where('detail_peminjaman.id_peminjaman', $id) // WAJIB: Gunakan detail_peminjaman.id_peminjaman
            ->findAll();

        // LOG
        $logModel = new LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses detail peminjaman ID ' . $id,
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return view('petugas/peminjaman/detail', [
            'peminjaman' => $peminjaman,
            'detail' => $detail
        ]);
    }

    public function setujui($id)
    {
        $peminjamanModel = new PeminjamanModel();
        $detailModel = new DetailPeminjamanModel();
        $alatModel = new AlatModel();

        $peminjaman = $peminjamanModel->find($id);

        if (!$peminjaman || $peminjaman['status'] == 'disetujui') {
            return redirect()->back()->with('error', 'Data tidak ditemukan atau sudah disetujui!');
        }

        // Ambil detail secara spesifik
        $details = $detailModel->where('id_peminjaman', $id)->findAll();

        foreach ($details as $d) {
            $alat = $alatModel->find($d['id_alat']);

            // CEK: Jika alat tidak ditemukan (menghindari error null)
            if (!$alat) {
                return redirect()->back()->with('error', 'Salah satu ID alat (ID: '.$d['id_alat'].') tidak ditemukan di database!');
            }

            if ($alat['stok'] < $d['jumlah']) {
                return redirect()->back()->with('error', 'Stok tidak cukup untuk ' . $alat['nama_alat']);
            }

            // Update stok
            $alatModel->set('stok', 'stok - ' . $d['jumlah'], false)
                    ->where('id_alat', $d['id_alat'])
                    ->update();
        }

        $peminjamanModel->update($id, [
            'status' => 'disetujui',
            'disetujui_oleh' => session()->get('id_user')
        ]);

        // LOG
        $log = new \App\Models\LogAktivitasModel();
        $log->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Menyetujui peminjaman ID ' . $id,
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/petugas/peminjaman')->with('success', 'Peminjaman berhasil disetujui');
    }

    public function tolak($id)
    {
        $model = new PeminjamanModel();

        $model->update($id, [
            'status' => 'ditolak',
            'disetujui_oleh' => session()->get('id_user')
        ]);

        // LOG
        $log = new LogAktivitasModel();
        $log->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Menolak peminjaman ID ' . $id,
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/petugas/peminjaman');
    }
}