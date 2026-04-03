<?= $this->extend('layout/peminjam_template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="/peminjam/peminjaman" class="text-decoration-none">Pengajuan Baru</a></li>
                <li class="breadcrumb-item active" aria-current="page">Riwayat</li>
            </ol>
        </nav>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square me-2 text-primary"></i>Form Pengajuan Pinjam</h5>
            </div>
            <div class="card-body p-4">
                <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
                <?php endif; ?>
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                <?php endif; ?>
                <form action="/peminjam/peminjaman/store" method="post">
                    <?= csrf_field(); ?>

                    <label class="form-label small fw-bold text-secondary mb-3">1. Pilih Alat yang Ingin Dipinjam</label>
                    <div class="table-responsive rounded border mb-4">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary small">
                                <tr>
                                    <th class="text-center" style="width: 10%">Pilih</th>
                                    <th>Nama Alat</th>
                                    <th class="text-center">Stok Tersedia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($alat as $a): ?>
                                <tr>
                                    <td class="text-center">
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input shadow-none" type="radio" name="id_alat" id="alat<?= $a['id_alat'] ?>" value="<?= $a['id_alat'] ?>" required>
                                        </div>
                                    </td>
                                    <td>
                                        <label for="alat<?= $a['id_alat'] ?>" class="fw-medium text-dark d-block" style="cursor: pointer;">
                                            <?= $a['nama_alat'] ?>
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge <?= ($a['stok'] > 0) ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?> px-3">
                                            <?= $a['stok'] ?> Unit
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row g-3">
                        <label class="form-label small fw-bold text-secondary mb-0">2. Lengkapi Detail Pinjaman</label>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Jumlah Pinjam</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-hash"></i></span>
                                <input type="number" name="jumlah" class="form-control border-start-0 ps-0 shadow-none" placeholder="0" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Rencana Tanggal Kembali</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-calendar-check"></i></span>
                                <input type="date" name="tanggal_kembali" class="form-control border-start-0 ps-0 shadow-none" required>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info border-0 mt-4 mb-4 py-2 small">
                        <i class="bi bi-info-circle-fill me-2"></i> 
                        Pastikan data sudah benar sebelum menekan tombol pinjam.
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="/peminjam/peminjaman" class="btn btn-light px-4 border">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-send me-2"></i> Ajukan Pinjam Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-4 text-center">
            <p class="text-muted small">E-PINJAM System &copy; 2026</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>