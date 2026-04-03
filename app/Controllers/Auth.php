<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        // Jika sudah login, langsung arahkan ke dashboard masing-masing
        if (session()->get('logged_in')) {
            return $this->_redirectByRole(session()->get('role'));
        }
        return view('auth/login');
    }

    public function prosesLogin()
    {
        // 1. Validasi input sederhana
        if (!$this->validate([
            'username' => 'required',
            'password' => 'required'
        ])) {
            return redirect()->back()->with('error', 'Username dan Password wajib diisi.');
        }

        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        // 2. Cek keberadaan user
        if ($user) {
            // 3. Verifikasi password (asumsi di database sudah di-hash)
            if (password_verify($password, $user['password'])) { 

                session()->set([
                    'id_user'   => $user['id_user'],
                    'nama'      => $user['nama'],
                    'role'      => $user['role'],
                    'logged_in' => true
                ]);

                // Gunakan helper method agar lebih rapi
                return $this->_redirectByRole($user['role']);

            } else {
                return redirect()->back()->with('error', 'Password salah.');
            }
        } else {
            return redirect()->back()->with('error', 'Username tidak ditemukan.');
        }
    }

    // Helper method untuk pengalihan halaman berdasarkan role
    private function _redirectByRole($role)
    {
        if ($role == 'admin') {
            return redirect()->to('/admin/dashboard');
        } elseif ($role == 'petugas') {
            return redirect()->to('/petugas/dashboard');
        } else {
            return redirect()->to('/peminjam/dashboard');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}