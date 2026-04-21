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

    // Peminjaman Manual (Admin)
    $routes->get('peminjaman', 'Admin\Peminjaman::index');
    $routes->get('peminjaman/create', 'Admin\Peminjaman::create');
    $routes->post('peminjaman/store', 'Admin\Peminjaman::store');
    $routes->get('peminjaman/edit/(:num)', 'Admin\Peminjaman::edit/$1');
    $routes->post('peminjaman/update/(:num)', 'Admin\Peminjaman::update/$1');
    $routes->get('peminjaman/delete/(:num)', 'Admin\Peminjaman::delete/$1');

    // Pengembalian Manual (Admin)
    $routes->get('pengembalian', 'Admin\Pengembalian::index');
    $routes->get('pengembalian/create', 'Admin\Pengembalian::create'); 
    $routes->post('pengembalian/store', 'Admin\Pengembalian::store'); 
    $routes->get('pengembalian/bayar/(:num)', 'Admin\Pengembalian::bayar/$1');
    $routes->post('pengembalian/proses-bayar/(:num)', 'Admin\Pengembalian::prosesBayar/$1');
    $routes->post('pengembalian/delete/(:num)', 'Admin\Pengembalian::delete/$1');

    // Edit Pengembalian Manual
    $routes->get('pengembalian/edit/(:num)', 'Admin\Pengembalian::edit/$1');
    $routes->post('pengembalian/update/(:num)', 'Admin\Pengembalian::update/$1');

    // monitoring
    $routes->get('monitoring', 'Admin\Monitoring::index');
    // monitoring PDF
    $routes->get('monitoring/pdf', 'Admin\Monitoring::pdf');
    // monitoring Excel
    $routes->get('monitoring/excel', 'Admin\Monitoring::excel');

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
    // laporan
    $routes->get('laporan', 'Petugas\Laporan::index');
    $routes->get('laporan/pdf', 'Petugas\Laporan::pdf');  
    $routes->get('laporan/excel', 'Petugas\Laporan::excel'); 
});


// group peminjam
$routes->group('peminjam', function($routes) {
    // dashboard
    $routes->get('dashboard', 'Peminjam\Dashboard::index');
    
    // peminjaman
    $routes->get('peminjaman', 'Peminjam\Peminjaman::index');
    
    // Ini route baru untuk riwayat (pastikan diletakkan DI ATAS yang ada (:num))
    $routes->get('peminjaman/riwayat', 'Peminjam\Peminjaman::riwayat');
    
    // Ini route baru untuk create dengan ID alat
    $routes->get('peminjaman/create/(:num)', 'Peminjam\Peminjaman::create/$1');
    
    $routes->post('peminjaman/store', 'Peminjam\Peminjaman::store');
    
    // pengembalian
    $routes->get('pengembalian', 'Peminjam\Pengembalian::index');
    $routes->get('pengembalian/ajukan/(:num)', 'Peminjam\Pengembalian::ajukan/$1');
});