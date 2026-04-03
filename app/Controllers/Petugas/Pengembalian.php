<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;
use App\Models\PeminjamanModel;
use App\Models\PengembalianModel;
use App\Models\DetailPeminjamanModel;
use App\Models\AlatModel;
use App\Models\LogAktivitasModel;

class Pengembalian extends BaseController
{
    public function index()
    {
        $peminjamanModel = new PeminjamanModel();

        $data['peminjaman'] = $peminjamanModel
        ->select('peminjaman.*, users.nama as nama_peminjam, pengembalian.id_pengembalian, pengembalian.denda, pengembalian.status_denda')
        ->join('users', 'users.id_user = peminjaman.id_user')
        ->join('pengembalian', 'pengembalian.id_peminjaman = peminjaman.id_peminjaman', 'left')
        ->where('peminjaman.status', 'disetujui')
        ->findAll();

        // LOG
        $logModel = new LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses halaman pengembalian',
            'tanggal' => date('Y-m-d H:i:s')
        ]);


        return view('petugas/pengembalian/index', $data);
    }

    public function proses($id)
    {
        $peminjamanModel = new PeminjamanModel();
        $detailModel = new DetailPeminjamanModel();

        $peminjaman = $peminjamanModel
            ->select('peminjaman.*, users.nama as nama_peminjam')
            ->join('users', 'users.id_user = peminjaman.id_user')
            ->where('peminjaman.id_peminjaman', $id)
            ->first();

        $detail = $detailModel
            ->select('detail_peminjaman.*, alat.nama_alat')
            ->join('alat', 'alat.id_alat = detail_peminjaman.id_alat')
            ->where('id_peminjaman', $id)
            ->findAll();

        $data = [
            'peminjaman' => $peminjaman,
            'detail' => $detail
        ];

        // LOG
        $logModel = new LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses proses pengembalian ID ' . $id,
            'tanggal' => date('Y-m-d H:i:s')
        ]);


        return view('petugas/pengembalian/proses', $data);
    }

    public function simpan($id)
    {
        $peminjamanModel = new PeminjamanModel();
        $pengembalianModel = new PengembalianModel();
        $detailModel = new DetailPeminjamanModel();
        $alatModel = new AlatModel();

        $peminjaman = $peminjamanModel->find($id);

        $tanggal_kembali = $this->request->getPost('tanggal_kembali');
        $tanggal_rencana = $peminjaman['tanggal_kembali_rencana'];

        // HITUNG SELISIH
        $selisih = floor(
        (strtotime((string)$tanggal_kembali) - strtotime((string)$tanggal_rencana)) 
        / (60 * 60 * 24)
        );

        // HITUNG DENDA
        $denda = 0;
        if ($selisih > 0) {
            $denda = $selisih * 1000; // contoh 1000/hari
        }

        // SIMPAN PENGEMBALIAN
        $pengembalianModel->insert([
            'id_peminjaman' => $id,
            'tanggal_kembali' => $tanggal_kembali,
            'denda' => $denda,
            'jumlah_bayar' => 0,
            'status_denda' => 'belum_bayar',
            'tanggal_bayar' => null,
            'diterima_oleh' => session()->get('id_user')
        ]);

        // UPDATE STOK
        $details = $detailModel->where('id_peminjaman', $id)->findAll();

        foreach ($details as $d) {
            $alat = $alatModel->find($d['id_alat']);

            $alatModel->update($d['id_alat'], [
                'stok' => $alat['stok'] + $d['jumlah']
            ]);
        }

        // LOG
        $log = new LogAktivitasModel();
        $log->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Memproses pengembalian ID ' . $id . ' dengan denda ' . $denda,
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/petugas/pengembalian');
    }

    public function bayar($id)
    {
        $pengembalianModel = new PengembalianModel();
        $detailModel = new DetailPeminjamanModel();
        $peminjamanModel = new PeminjamanModel();

        $pengembalian = $pengembalianModel->find($id);

        if (!$pengembalian) {
            return redirect()->back();
        }

        $peminjaman = $peminjamanModel
            ->select('peminjaman.*, users.nama as nama_peminjam')
            ->join('users', 'users.id_user = peminjaman.id_user')
            ->where('id_peminjaman', $pengembalian['id_peminjaman'])
            ->first();

        $detail = $detailModel
            ->select('detail_peminjaman.*, alat.nama_alat')
            ->join('alat', 'alat.id_alat = detail_peminjaman.id_alat')
            ->where('id_peminjaman', $pengembalian['id_peminjaman'])
            ->findAll();

        // LOG
        $logModel = new LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses halaman pembayaran pengembalian ID ' . $id,
            'tanggal' => date('Y-m-d H:i:s')
        ]);


        return view('petugas/pengembalian/bayar', [
            'pengembalian' => $pengembalian,
            'peminjaman' => $peminjaman,
            'detail' => $detail
        ]);
    }

    public function prosesBayar($id)
    {
        $model = new PengembalianModel();

        $data = $model->find($id);

        $jumlah_bayar = $this->request->getPost('jumlah_bayar');

        if ($jumlah_bayar < $data['denda']) {
            return redirect()->back()->with('error', 'Uang kurang!');
        }

        $model->update($id, [
            'jumlah_bayar' => $jumlah_bayar,
            'status_denda' => 'sudah_bayar',
            'tanggal_bayar' => date('Y-m-d')
        ]);

        // LOG
        $log = new LogAktivitasModel();
        $log->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Membayar denda pengembalian ID ' . $id,
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        // LOG
        $logModel = new LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Menyelesaikan pembayaran denda pengembalian ID ' . $id,
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/petugas/pengembalian');
    }
}