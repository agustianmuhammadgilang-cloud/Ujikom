<?= $this->extend('layout/petugas_template') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0 text-dark">Selamat Datang, Petugas!</h4>
    <p class="text-muted small">Berikut adalah ringkasan operasional peminjaman alat hari ini.</p>
</div>

<div class="row g-3">
    <div class="col-md-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 p-2 rounded">
                        <i class="bi bi-box-arrow-right text-primary fs-4"></i>
                    </div>
                    <span class="badge bg-light text-dark border fw-normal">Total</span>
                </div>
                <h6 class="text-secondary small fw-bold mb-1">Total Peminjaman</h6>
                <h2 class="fw-bold mb-0"><?= $total_peminjaman ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 p-2 rounded">
                        <i class="bi bi-box-arrow-in-left text-success fs-4"></i>
                    </div>
                    <span class="badge bg-light text-dark border fw-normal">Selesai</span>
                </div>
                <h6 class="text-secondary small fw-bold mb-1">Total Pengembalian</h6>
                <h2 class="fw-bold mb-0"><?= $total_pengembalian ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-4 border-start border-warning border-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-warning bg-opacity-10 p-2 rounded">
                        <i class="bi bi-hourglass-split text-warning fs-4"></i>
                    </div>
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle fw-medium">Action Required</span>
                </div>
                <h6 class="text-secondary small fw-bold mb-1">Menunggu</h6>
                <h2 class="fw-bold mb-0"><?= $menunggu ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-info bg-opacity-10 p-2 rounded">
                        <i class="bi bi-check2-all text-info fs-4"></i>
                    </div>
                    <span class="badge bg-light text-dark border fw-normal">Verified</span>
                </div>
                <h6 class="text-secondary small fw-bold mb-1">Disetujui</h6>
                <h2 class="fw-bold mb-0"><?= $disetujui ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="alert alert-info border-0 shadow-sm d-flex align-items-center" role="alert">
            <i class="bi bi-info-circle-fill me-3 fs-4"></i>
            <div>
                <strong>Tips Petugas:</strong> Periksa secara berkala tab <strong>Menunggu</strong> untuk menyetujui permintaan peminjaman baru dari mahasiswa/user.
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>