<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $data['users'] = $model->findAll();

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses halaman user',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return view('admin/user/index', $data);
    }

    public function create()
    {
        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses form tambah user',
            'tanggal' => date('Y-m-d H:i:s')
        ]);
        
        return view('admin/user/create');
    }

    public function store()
    {
        $model = new UserModel();

        $model->save([
            'username' => $this->request->getPost('username'),
            'nama'     => $this->request->getPost('nama'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role')
        ]);

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Menambahkan user',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/user');
    }

    public function edit($id)
    {
        $model = new UserModel();

        $data['user'] = $model->find($id);

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mengakses form edit user',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return view('admin/user/edit', $data);
    }

    public function update($id)
    {
        $model = new UserModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'nama'     => $this->request->getPost('nama'),
            'role'     => $this->request->getPost('role')
        ];

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Memperbarui user',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        // kalau password diisi → update
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $model->update($id, $data);

        return redirect()->to('/admin/user');
    }

    public function delete($id)
    {
        $model = new UserModel();
        $model->delete($id);

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Menghapus user',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/user');
    }
}