<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LogAktivitasModel;

class LogAktivitas extends BaseController
{
    public function index()
    {
        $model = new LogAktivitasModel();

        // 1. Ambil halaman saat ini untuk keperluan penomoran di View
        // 'page_log' adalah nama grup pagination yang kita gunakan
        $currentPage = $this->request->getVar('page_log') ? $this->request->getVar('page_log') : 1;

        // 2. Gunakan paginate() alih-alih findAll() untuk efisiensi query 
        $data = [
            'log'         => $model->select('log_aktivitas.*, users.nama')
                                   ->join('users', 'users.id_user = log_aktivitas.id_user')
                                   ->orderBy('tanggal', 'DESC')
                                   ->paginate(10, 'log'), // Menampilkan 10 data per halaman
            'pager'       => $model->pager,
            'currentPage' => $currentPage
        ];

        // // LOG: Mencatat aktivitas akses halaman
        // $model->insert([
        //     'id_user'   => session()->get('id_user'),
        //     'aktivitas' => 'Mengakses halaman log aktivitas',
        //     'tanggal'   => date('Y-m-d H:i:s')
        // ]);

        return view('admin/log_aktivitas/index', $data);
    }
}