<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petugas Panel - E-Pinjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; color: #202124; }
        .navbar { background-color: #ffffff; border-bottom: 1px solid #dadce0; padding: 0.7rem 1rem; }
        
        /* Brand/Logo Styling: Tema Hijau untuk Petugas */
        .navbar-brand { font-weight: 700; color: #198754 !important; letter-spacing: -0.5px; }
        
        .navbar-brand .logo-wrapper { 
            height: 55px; 
            width: auto;  
            background-color: transparent; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin-right: 15px; 
        }

        .navbar-brand .logo-wrapper img {
            height: 100%; 
            width: auto;
            object-fit: contain;
        }

        .nav-link { color: #5f6368; font-weight: 500; font-size: 14px; padding: 0.5rem 1rem !important; border-radius: 6px; transition: 0.2s; }
        .nav-link:hover { color: #198754; background-color: #e6f4ea; }
        .nav-link.active { color: #198754 !important; background-color: #e6f4ea; font-weight: 600; }
        
        footer { margin-top: 50px; border-top: 1px solid #dadce0; padding: 25px 0; color: #70757a; font-size: 13px; background: white; }
        .main-content { min-height: 80vh; padding-top: 30px; padding-bottom: 50px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/petugas/dashboard">
            <div class="logo-wrapper">
                <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo PA">
            </div>
            <div class="d-none d-sm-block">
                <span class="d-block lh-1 text-uppercase small text-muted">Operasional</span>
                <span class="d-block lh-1 fs-5 fw-bold">OFFICER</span>
            </div>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link <?= url_is('petugas/dashboard*') ? 'active' : '' ?>" href="/petugas/dashboard">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link <?= url_is('petugas/peminjaman*') ? 'active' : '' ?>" href="/petugas/peminjaman">Peminjaman</a></li>
                <li class="nav-item"><a class="nav-link <?= url_is('petugas/pengembalian*') ? 'active' : '' ?>" href="/petugas/pengembalian">Pengembalian</a></li>
                <li class="nav-item"><a class="nav-link <?= url_is('petugas/laporan*') ? 'active' : '' ?>" href="/petugas/laporan">Laporan</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="small me-3 text-muted d-none d-lg-inline">Officer</span>
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
        Swal.fire({ 
            title: 'Keluar petugas?', 
            text: "Anda perlu login kembali untuk memverifikasi alat.", 
            icon: 'question', 
            showCancelButton: true, 
            confirmButtonColor: '#198754', 
            cancelButtonColor: '#6e7881', 
            confirmButtonText: 'Ya, Logout', 
            cancelButtonText: 'Batal', 
            reverseButtons: true 
        }).then((result) => { 
            if (result.isConfirmed) { 
                window.location.href = "/logout"; 
            } 
        })
    }
</script>

</body>
</html>