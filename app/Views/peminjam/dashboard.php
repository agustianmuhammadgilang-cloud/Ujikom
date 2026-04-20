<?= $this->extend('layout/peminjam_template') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0 text-dark">Halo, Selamat Datang!</h4>
    <p class="text-muted small">Pantau status peminjaman alat Anda di sini.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <i class="bi bi-box-seam fs-3"></i>
                    <span class="badge bg-white text-primary rounded-pill px-3 fw-bold">Live</span>
                </div>
                <h6 class="small fw-medium mb-1 opacity-75">Alat Tersedia</h6>
                <h2 class="fw-bold mb-0"><?= $alat_tersedia ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-warning bg-opacity-10 p-2 rounded text-warning">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                </div>
                <h6 class="text-secondary small fw-bold mb-1">Menunggu</h6>
                <h2 class="fw-bold mb-0"><?= $menunggu ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 p-2 rounded text-success">
                        <i class="bi bi-check-circle fs-4"></i>
                    </div>
                </div>
                <h6 class="text-secondary small fw-bold mb-1">Disetujui</h6>
                <h2 class="fw-bold mb-0"><?= $disetujui ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-light p-2 rounded text-secondary">
                        <i class="bi bi-collection fs-4"></i>
                    </div>
                </div>
                <h6 class="text-secondary small fw-bold mb-1">Total Pinjam</h6>
                <h2 class="fw-bold mb-0"><?= $total_peminjaman ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm bg-light">
    <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between p-4">
        <div>
            <h6 class="fw-bold mb-1">Butuh alat untuk kegiatan Anda?</h6>
            <p class="text-muted small mb-0">Klik tombol di samping untuk mulai mengajukan permohonan pinjam alat baru.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="/peminjam/peminjaman/" class="btn btn-primary px-4 py-2 shadow-sm rounded-pill">
                <i class="bi bi-plus-lg me-2"></i> Buat Pengajuan Baru
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>