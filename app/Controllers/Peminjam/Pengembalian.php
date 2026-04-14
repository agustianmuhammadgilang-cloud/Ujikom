<?php

namespace App\Controllers\Peminjam;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\LogAktivitasModel;

class Pengembalian extends BaseController
{
    public function index()
    {
        $id_user = session()->get('id_user');

        $peminjamanModel = new PeminjamanModel();

        $data['peminjaman'] = $peminjamanModel
            ->where('id_user', $id_user)
            ->findAll();

        // LOG
        $logModel = new LogAktivitasModel();
        $logModel->insert([
            'id_user' => $id_user,
            'aktivitas' => 'Mengakses halaman pengembalian',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return view('peminjam/pengembalian/index', $data);
    }

    // ✅ AJUKAN PENGEMBALIAN (FITUR BARU)
    public function ajukan($id)
    {
        $model = new PeminjamanModel();

        $data = $model->find($id);

        // ❗ validasi
        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // ❗ hanya boleh jika sudah disetujui
        if ($data['status'] != 'disetujui') {
            return redirect()->back()->with('error', 'Belum bisa mengajukan pengembalian');
        }

        // ❗ jangan double ajukan
        if ($data['status_pengembalian'] == 'diajukan') {
            return redirect()->back()->with('error', 'Sudah diajukan sebelumnya');
        }

        // update status
        $model->update($id, [
            'status_pengembalian' => 'diajukan'
        ]);

        // LOG
        $logModel = new LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengajukan pengembalian ID ' . $id,
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Pengembalian berhasil diajukan');
    }
}