<?= $this->extend('layout/peminjam_template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-10">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="/peminjam/peminjaman" class="text-decoration-none text-muted">Katalog Alat</a></li>
                <li class="breadcrumb-item active text-primary fw-medium" aria-current="page">Konfirmasi Pinjam</li>
            </ol>
        </nav>

        <div class="card shadow-sm border-0 overflow-hidden">
            <div class="row g-0">
                <div class="col-md-5 bg-light d-flex align-items-center justify-content-center p-4" style="border-right: 1px solid #f1f3f4;">
                    <div class="text-center">
                        <?php if ($alat['foto']) : ?>
                            <img src="/uploads/<?= $alat['foto'] ?>" class="img-fluid rounded shadow-sm mb-3" style="max-height: 250px;">
                        <?php else : ?>
                            <i class="bi bi-image text-secondary opacity-25 mb-3" style="font-size: 100px;"></i>
                        <?php endif; ?>
                        <h5 class="fw-bold mb-1"><?= $alat['nama_alat'] ?></h5>
                        <span class="badge bg-white text-primary border border-primary-subtle rounded-pill px-3"><?= $alat['nama_kategori'] ?></span>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="card-body p-4 p-lg-5">
                        <h5 class="fw-bold mb-4">Detail Peminjaman</h5>
                        
                        <form action="/peminjam/peminjaman/store" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id_alat" value="<?= $alat['id_alat'] ?>">

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary">Jumlah yang ingin dipinjam</label>
                                <div class="input-group border rounded-3 overflow-hidden shadow-none">
                                    <span class="input-group-text bg-white border-0"><i class="bi bi-hash text-muted"></i></span>
                                    <input type="number" name="jumlah" class="form-control border-0 shadow-none" 
                                           placeholder="Tersedia: <?= $alat['stok'] ?> unit" 
                                           min="1" max="<?= $alat['stok'] ?>" required>
                                </div>
                                <div class="form-text small">Maksimal peminjaman: <?= $alat['stok'] ?> unit.</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary">Tanggal Mulai Pinjam</label>
                                <div class="input-group border rounded-3 overflow-hidden shadow-none">
                                    <span class="input-group-text bg-white border-0"><i class="bi bi-calendar-plus text-muted"></i></span>
                                    <input type="date" name="tanggal_pinjam" class="form-control border-0 shadow-none" 
                                        value="<?= date('Y-m-d') ?>" required>
                                </div>
                                <div class="form-text small">Tentukan kapan Anda akan mengambil alat.</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary">Rencana Tanggal Pengembalian</label>
                                <div class="input-group border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-white border-0"><i class="bi bi-calendar-check text-muted"></i></span>
                                    <input type="date" name="tanggal_kembali" class="form-control border-0 shadow-none" required>
                                </div>
                                <div class="form-text small text-info"><i class="bi bi-info-circle me-1"></i> Biaya denda keterlambatan: <b>Rp<?= number_format($alat['harga_denda'], 0, ',', '.') ?></b> per hari.</div>
                            </div>

                            <hr class="my-4 opacity-25">

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="/peminjam/peminjaman" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left"></i> Kembali</a>
                                <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm fw-bold">
                                    Ajukan Pinjaman <i class="bi bi-send-fill ms-1"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>