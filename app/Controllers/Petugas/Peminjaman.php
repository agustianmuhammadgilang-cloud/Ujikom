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

        // ambil data peminjaman + user
        $peminjaman = $peminjamanModel
            ->select('peminjaman.*, users.nama')
            ->join('users', 'users.id_user = peminjaman.id_user')
            ->where('id_peminjaman', $id)
            ->first();

        // ambil detail alat + stok
        $detail = $detailModel
            ->select('detail_peminjaman.*, alat.nama_alat, alat.stok')
            ->join('alat', 'alat.id_alat = detail_peminjaman.id_alat')
            ->where('id_peminjaman', $id)
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

        // ambil data peminjaman
        $peminjaman = $peminjamanModel->find($id);

        // proteksi: jangan approve 2x
        if ($peminjaman['status'] == 'disetujui') {
            return redirect()->back()->with('error', 'Sudah disetujui!');
        }

        // ambil detail alat
        $details = $detailModel->where('id_peminjaman', $id)->findAll();

        foreach ($details as $d) {
            $alat = $alatModel->find($d['id_alat']);

            // cek stok cukup atau tidak
            if ($alat['stok'] < $d['jumlah']) {
                return redirect()->back()->with('error', 'Stok tidak cukup untuk ' . $alat['nama_alat']);
            }

            // kurangi stok
            $alatModel->set('stok', 'stok - ' . $d['jumlah'], false)
            ->where('id_alat', $d['id_alat'])
            ->update();
        }

        // update status
        $peminjamanModel->update($id, [
            'status' => 'disetujui',
            'disetujui_oleh' => session()->get('id_user')
        ]);

        // LOG
        $log = new LogAktivitasModel();
        $log->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Menyetujui peminjaman ID ' . $id,
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/petugas/peminjaman');
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