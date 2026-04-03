<?= $this->extend('layout/peminjam_template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Data Peminjaman</h4>
        <p class="text-muted small mb-0">Daftar semua pengajuan peminjaman alat Anda.</p>
    </div>
    <a href="/peminjam/peminjaman/create" class="btn btn-primary shadow-sm px-4">
        <i class="bi bi-plus-lg me-2"></i> Tambah Peminjaman
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3 text-secondary small fw-bold">Waktu Pinjam</th>
                        <th class="py-3 text-secondary small fw-bold">Rencana Kembali</th>
                        <th class="py-3 text-secondary small fw-bold text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($peminjaman)) : ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-folder2-open d-block fs-2 mb-2"></i>
                                Belum ada riwayat peminjaman.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($peminjaman as $p): ?>
                    <tr>
                        <td class="text-dark">
                            <i class="bi bi-calendar-event me-2 text-muted small"></i>
                            <?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?>
                        </td>
                        <td class="text-dark">
                            <i class="bi bi-calendar-check me-2 text-muted small"></i>
                            <?= date('d M Y', strtotime($p['tanggal_kembali_rencana'])) ?>
                        </td>
                        <td class="text-center">
                            <?php 
                            $status = strtolower($p['status']);
                            if ($status == 'menunggu') : ?>
                                <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle px-3 fw-medium">Menunggu</span>
                            <?php elseif ($status == 'disetujui') : ?>
                                <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 fw-medium">Disetujui</span>
                            <?php elseif ($status == 'ditolak') : ?>
                                <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-3 fw-medium">Ditolak</span>
                            <?php else : ?>
                                <span class="badge rounded-pill bg-light text-secondary border px-3 fw-medium text-capitalize"><?= $p['status'] ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4 row">
    <div class="col-md-6">
        <div class="alert bg-light border-0 small text-muted">
            <i class="bi bi-info-circle me-2"></i> 
            <strong>Info Status:</strong> 
            <span class="ms-1">Silakan temui petugas di gudang jika status Anda sudah <b>Disetujui</b> untuk pengambilan alat.</span>
        </div>
    </div>
</div>
<?= $this->endSection() ?>