<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - E-Pinjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; color: #202124; }
        .navbar { background-color: #ffffff; border-bottom: 1px solid #dadce0; padding: 0.7rem 1rem; }
        
        /* Brand/Logo Styling: Khusus untuk Admin */
        .navbar-brand { font-weight: 700; color: #1a73e8 !important; letter-spacing: -0.5px; }
        /* Update bagian ini di semua template */
        .navbar-brand .logo-wrapper { 
            height: 55px; /* Dinaikkan dari 40px ke 55px agar lebih terlihat */
            width: auto;  /* Biarkan lebar menyesuaikan otomatis */
            background-color: transparent; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin-right: 15px; /* Jarak ke teks sebelah kanan ditambah sedikit */
        }

        .navbar-brand .logo-wrapper img {
            height: 100%; /* Gambar akan selalu setinggi kontainernya */
            width: auto;
            object-fit: contain;
        }

        .nav-link { color: #5f6368; font-weight: 500; font-size: 14px; padding: 0.5rem 1rem !important; border-radius: 6px; transition: 0.2s; }
        .nav-link:hover { color: #1a73e8; background-color: #f1f3f4; }
        .nav-link.active { color: #1a73e8 !important; background-color: #e8f0fe; }
        
        footer { margin-top: 50px; border-top: 1px solid #dadce0; padding: 25px 0; color: #70757a; font-size: 13px; background: white; }
        .main-content { min-height: 80vh; padding-top: 30px; padding-bottom: 50px; }
        
        /* Pagination Custom */
        .custom-pagination ul { display: flex; padding-left: 0; list-style: none; gap: 4px; }
        .custom-pagination li a { text-decoration: none; padding: 6px 12px; border: 1px solid #dadce0; color: #1a73e8; background: #fff; border-radius: 4px; font-size: 13px; }
        .custom-pagination li.active a { background-color: #1a73e8; color: #fff; border-color: #1a73e8; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/admin/dashboard">
        <div class="logo-wrapper">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo PA" style="width: 100%; height: 100%; object-fit: contain;">
        </div>
        <div class="d-none d-sm-block">
            <span class="d-block lh-1 text-uppercase small text-muted">Akses Utama</span>
            <span class="d-block lh-1 fs-5 fw-bold">E-PINJAM</span>
        </div>
    </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link <?= url_is('admin/dashboard*') ? 'active' : '' ?>" href="/admin/dashboard">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link <?= url_is('admin/user*') ? 'active' : '' ?>" href="/admin/user">User</a></li>
                <li class="nav-item"><a class="nav-link <?= url_is('admin/alat*') ? 'active' : '' ?>" href="/admin/alat">Alat</a></li>
                <li class="nav-item"><a class="nav-link <?= url_is('admin/kategori*') ? 'active' : '' ?>" href="/admin/kategori">Kategori</a></li>
                <li class="nav-item"><a class="nav-link <?= url_is('admin/peminjaman*') ? 'active' : '' ?>" href="/admin/peminjaman">Peminjaman</a></li>
                <li class="nav-item"><a class="nav-link <?= url_is('admin/pengembalian*') ? 'active' : '' ?>" href="/admin/pengembalian">Pengembalian</a></li>
                <li class="nav-item"><a class="nav-link <?= url_is('admin/logaktivitas*') ? 'active' : '' ?>" href="/admin/logaktivitas">Log</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="small me-3 text-muted d-none d-lg-inline">Administrator</span>
                <button onclick="confirmLogout()" class="btn btn-outline-danger btn-sm px-3 shadow-sm rounded-pill">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </div>
        </div>
    </div>
</nav>

<main class="container main-content">
    <?= $this->renderSection('content') ?>
</main>

<footer class="text-center">
    <div class="container">
        <p class="mb-0">© 2026 Sistem Peminjaman Alat - Rekayasa Perangkat Lunak</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success'); ?>', showConfirmButton: false, timer: 2500, timerProgressBar: true });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({ icon: 'error', title: 'Gagal!', text: '<?= session()->getFlashdata('error'); ?>' });
    <?php endif; ?>

    function confirmLogout() {
        Swal.fire({ title: 'Keluar sistem?', text: "Anda perlu login kembali untuk mengakses panel.", icon: 'question', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#6e7881', confirmButtonText: 'Ya, Logout', cancelButtonText: 'Batal', reverseButtons: true }).then((result) => { if (result.isConfirmed) { window.location.href = "/logout"; } })
    }
</script>

</body>
</html>