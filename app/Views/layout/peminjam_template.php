<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjam Panel - E-Pinjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; color: #202124; }
        .navbar { background-color: #ffffff; border-bottom: 1px solid #dadce0; padding: 0.7rem 1rem; }
        .navbar-brand { font-weight: 600; color: #1a73e8 !important; }
        .nav-link { color: #5f6368; font-weight: 500; font-size: 14px; padding: 0.5rem 1.2rem !important; border-radius: 8px; transition: 0.2s; }
        .nav-link:hover { color: #1a73e8; background-color: #f1f3f4; }
        .nav-link.active { color: #1a73e8 !important; background-color: #e8f0fe; }
        footer { margin-top: 50px; border-top: 1px solid #dadce0; padding: 25px 0; color: #70757a; font-size: 13px; background: white; }
        .main-content { min-height: 80vh; padding-top: 30px; padding-bottom: 50px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/peminjam/dashboard">
            <i class="bi bi-person-circle me-2"></i>PEMINJAM
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-2">
                <li class="nav-item"><a class="nav-link <?= url_is('peminjam/dashboard*') ? 'active' : '' ?>" href="/peminjam/dashboard">Beranda</a></li>
                <li class="nav-item"><a class="nav-link <?= url_is('peminjam/peminjaman*') ? 'active' : '' ?>" href="/peminjam/peminjaman">Pinjam Alat</a></li>
                <li class="nav-item"><a class="nav-link <?= url_is('peminjam/pengembalian*') ? 'active' : '' ?>" href="/peminjam/pengembalian">Riwayat</a></li>
                <li class="nav-item ms-lg-3">
                    <a href="/logout" class="btn btn-outline-danger btn-sm px-3 rounded-pill" onclick="return confirm('Keluar?')">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container main-content">
    <?= $this->renderSection('content') ?>
</main>

<footer class="text-center">
    <div class="container">
        <p class="mb-0">© 2026 E-PINJAM System. Layanan Peminjaman Terintegrasi.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>