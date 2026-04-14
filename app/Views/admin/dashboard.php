<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12 mb-4">
        <h4 class="fw-bold text-dark">Dashboard Admin</h4>
        <p class="text-muted">Selamat datang kembali, <?= session()->get('nama'); ?>. Berikut ringkasan data aplikasi hari ini.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card h-100 p-3">
            <div class="card-body d-flex align-items-center">
                <div class="flex-shrink-0 p-3 bg-primary bg-opacity-10 rounded-3">
                    <i class="bi bi-people text-primary fs-3"></i>
                </div>
                <div class="flex-grow-1 ms-4">
                    <p class="text-muted small mb-1">Total User</p>
                    <h3 class="fw-bold mb-0"><?= $total_user ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card h-100 p-3">
            <div class="card-body d-flex align-items-center">
                <div class="flex-shrink-0 p-3 bg-success bg-opacity-10 rounded-3">
                    <i class="bi bi-tools text-success fs-3"></i>
                </div>
                <div class="flex-grow-1 ms-4">
                    <p class="text-muted small mb-1">Total Alat</p>
                    <h3 class="fw-bold mb-0"><?= $total_alat ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card h-100 p-3">
            <div class="card-body d-flex align-items-center">
                <div class="flex-shrink-0 p-3 bg-warning bg-opacity-10 rounded-3">
                    <i class="bi bi-cart-check text-warning fs-3"></i>
                </div>
                <div class="flex-grow-1 ms-4">
                    <p class="text-muted small mb-1">Total Peminjaman</p>
                    <h3 class="fw-bold mb-0"><?= $total_peminjaman ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-12">
        <div class="card p-4 text-center bg-light border-0">
            <p class="mb-0 text-muted small">
                Gunakan menu navigasi di atas untuk mengelola data master, memantau log aktivitas, dan laporan. Selalu pastikan data alat dan peminjaman terupdate untuk kelancaran operasional.
            </p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>