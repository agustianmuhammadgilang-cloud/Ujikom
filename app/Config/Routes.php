<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/proses-login', 'Auth::prosesLogin');
$routes->get('/logout', 'Auth::logout');

// group admin
$routes->group('admin', function($routes) {
    // dashboard
    $routes->get('dashboard', 'Admin\Dashboard::index');
    // user management
    $routes->get('user', 'Admin\User::index');
    $routes->get('user/create', 'Admin\User::create');
    $routes->post('user/store', 'Admin\User::store');
    $routes->get('user/edit/(:num)', 'Admin\User::edit/$1');
    $routes->post('user/update/(:num)', 'Admin\User::update/$1');
    $routes->get('user/delete/(:num)', 'Admin\User::delete/$1');
    // alat
    $routes->get('alat', 'Admin\Alat::index');
    $routes->get('alat/create', 'Admin\Alat::create');
    $routes->post('alat/store', 'Admin\Alat::store');
    $routes->get('alat/edit/(:num)', 'Admin\Alat::edit/$1');
    $routes->post('alat/update/(:num)', 'Admin\Alat::update/$1');
    $routes->get('alat/delete/(:num)', 'Admin\Alat::delete/$1');

    // kategori
    $routes->get('kategori', 'Admin\Kategori::index');
    $routes->get('kategori/create', 'Admin\Kategori::create');
    $routes->post('kategori/store', 'Admin\Kategori::store');
    $routes->get('kategori/edit/(:num)', 'Admin\Kategori::edit/$1');
    $routes->post('kategori/update/(:num)', 'Admin\Kategori::update/$1');
    $routes->get('kategori/delete/(:num)', 'Admin\Kategori::delete/$1');

    // peminjaman & pengembalian
    $routes->get('peminjaman', 'Admin\Peminjaman::index');
    $routes->get('pengembalian', 'Admin\Pengembalian::index');
    // log aktivitas
    $routes->get('logaktivitas', 'Admin\LogAktivitas::index');
});

// group petugas
$routes->group('petugas', function($routes) {
    // dashboard
    $routes->get('dashboard', 'Petugas\Dashboard::index');
    // peminjaman
    $routes->get('peminjaman', 'Petugas\Peminjaman::index');
    // detail peminjaman
    $routes->get('peminjaman/detail/(:num)', 'Petugas\Peminjaman::detail/$1');
    // setujui peminjaman
    $routes->get('peminjaman/setujui/(:num)', 'Petugas\Peminjaman::setujui/$1');
    // tolak peminjaman
    $routes->get('peminjaman/tolak/(:num)', 'Petugas\Peminjaman::tolak/$1');
    // pengembalian
    $routes->get('pengembalian', 'Petugas\Pengembalian::index');
    $routes->get('pengembalian/proses/(:num)', 'Petugas\Pengembalian::proses/$1');
    $routes->post('pengembalian/simpan/(:num)', 'Petugas\Pengembalian::simpan/$1');
    // pembayaran denda
    $routes->get('pengembalian/bayar/(:num)', 'Petugas\Pengembalian::bayar/$1');
    // proses pembayaran denda
    $routes->post('pengembalian/proses-bayar/(:num)', 'Petugas\Pengembalian::prosesBayar/$1');
    // laporan
    $routes->get('laporan', 'Petugas\Laporan::index');
});

// group peminjam
$routes->group('peminjam', function($routes) {
    // dashboard
    $routes->get('dashboard', 'Peminjam\Dashboard::index');
    // peminjaman
    $routes->get('peminjaman', 'Peminjam\Peminjaman::index');
    $routes->get('peminjaman/create', 'Peminjam\Peminjaman::create');
    $routes->post('peminjaman/store', 'Peminjam\Peminjaman::store');
    // pengembalian
    $routes->get('pengembalian', 'Peminjam\Pengembalian::index');
    
});