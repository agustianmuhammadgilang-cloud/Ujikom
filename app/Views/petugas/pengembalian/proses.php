<?= $this->extend('layout/petugas_template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-5">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-info-circle me-2 text-primary"></i>Data Peminjam</h6>
            </div>
            <div class="card-body pt-0">
                <div class="mb-3">
                    <label class="small text-muted d-block">Nama Peminjam</label>
                    <span class="fw-bold text-dark"><?= $peminjaman['nama_peminjam'] ?></span>
                </div>
                <div class="row mb-4">
                    <div class="col-6">
                        <label class="small text-muted d-block">Tanggal Pinjam</label>
                        <span class="text-dark small"><?= date('d M Y', strtotime($peminjaman['tanggal_pinjam'])) ?></span>
                    </div>
                    <div class="col-6">
                        <label class="small text-muted d-block">Rencana Kembali</label>
                        <span class="text-dark small fw-medium text-primary"><?= date('d M Y', strtotime($peminjaman['tanggal_kembali_rencana'])) ?></span>
                    </div>
                </div>

                <div class="bg-light p-3 rounded">
                    <form action="/petugas/pengembalian/simpan/<?= $peminjaman['id_peminjaman'] ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Tanggal Alat Diterima</label>
                            <input type="date" name="tanggal_kembali" class="form-control shadow-sm" value="<?= date('Y-m-d') ?>" required>
                            <div class="form-text small" style="font-size: 11px;">Sistem akan menghitung denda otomatis jika melewati batas rencana kembali.</div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary shadow-sm">
                                <i class="bi bi-check2-square me-2"></i> Simpan Pengembalian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <a href="/petugas/pengembalian" class="btn btn-light w-100 text-muted small border">Batal & Kembali</a>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-box-seam me-2 text-primary"></i>Alat yang Harus Kembali</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 small fw-bold text-secondary">Nama Alat</th>
                                <th class="py-3 small fw-bold text-secondary text-center">Jumlah Pinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($detail as $d): ?>
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-3 bg-light d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; overflow: hidden; border: 1px solid #eee;">
                                        <?php if (!empty($d['foto'])) : ?>
                                            <img src="/uploads/<?= $d['foto'] ?>" class="w-100 h-100" style="object-fit: cover;">
                                        <?php else : ?>
                                            <i class="bi bi-box text-secondary opacity-50"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0"><?= $d['nama_alat'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold"><?= $d['jumlah'] ?> Unit</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0 py-3">
                <div class="alert alert-warning border-0 mb-0 small py-2">
                    <i class="bi bi-exclamation-triangle me-2"></i> Pastikan semua alat fisik telah diterima dalam kondisi baik.
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>