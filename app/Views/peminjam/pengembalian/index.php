<?= $this->extend('layout/peminjam_template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Riwayat Pengembalian</h4>
        <p class="text-muted small mb-0">Daftar alat yang sedang dipinjam, diajukan, dan telah dikembalikan.</p>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-0">
        <div class="p-3 border-bottom">
            <h6 class="fw-bold mb-0 text-dark">Pengajuan Pengembalian</h6>
            <small class="text-muted">Ajukan pengembalian alat yang sedang Anda pinjam.</small>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small fw-bold">No</th>
                        <th class="py-3 text-secondary small fw-bold">Tanggal Pinjam</th>
                        <th class="py-3 text-secondary small fw-bold text-center">Status</th>
                        <th class="py-3 text-secondary small fw-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                <?php if (empty($peminjaman)) : ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            Tidak ada data peminjaman.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php $no = 1; foreach ($peminjaman as $p): ?>
                <tr>
                    <td class="ps-4 text-muted small"><?= $no++ ?></td>

                    <td class="small text-dark">
                        <?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?>
                    </td>

                    <!-- STATUS -->
                    <td class="text-center">
                        <?php if ($p['status'] == 'menunggu'): ?>
                            <span class="badge bg-secondary-subtle text-secondary border px-3">Menunggu</span>

                        <?php elseif ($p['status'] == 'ditolak'): ?>
                            <span class="badge bg-danger-subtle text-danger border px-3">Ditolak</span>

                        <?php elseif ($p['status'] == 'disetujui' || $p['status'] == 'dipinjam'): ?>

                            <?php if ($p['status_pengembalian'] == 'tidak_diajukan'): ?>
                                <span class="badge bg-primary-subtle text-primary border px-3">Dipinjam</span>

                            <?php elseif ($p['status_pengembalian'] == 'diajukan'): ?>
                                <span class="badge bg-warning-subtle text-warning border px-3">Diajukan</span>

                            <?php elseif ($p['status_pengembalian'] == 'selesai'): ?>
                                <span class="badge bg-success-subtle text-success border px-3">Selesai</span>

                            <?php endif; ?>

                        <?php elseif ($p['status'] == 'selesai'): ?>
                            <span class="badge bg-success-subtle text-success border px-3">Selesai</span>
                        <?php endif; ?>
                    </td>

                    <!-- AKSI -->
                    <td class="text-center">

                        <?php if (
                            ($p['status'] == 'disetujui' || $p['status'] == 'dipinjam') &&
                            $p['status_pengembalian'] == 'tidak_diajukan'
                        ): ?>

                            <a href="/peminjam/pengembalian/ajukan/<?= $p['id_peminjaman'] ?>"
                               class="btn btn-warning btn-sm">
                               Ajukan
                            </a>

                        <?php elseif ($p['status_pengembalian'] == 'diajukan'): ?>

                            <span class="text-warning small">Menunggu Petugas</span>

                        <?php elseif ($p['status_pengembalian'] == 'selesai' || $p['status'] == 'selesai'): ?>

                            <span class="text-success small">Selesai</span>

                        <?php else: ?>

                            <span class="text-muted small">-</span>

                        <?php endif; ?>

                    </td>
                </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    <div class="alert bg-light border-0 small text-muted d-flex align-items-center">
        <i class="bi bi-info-circle me-2 fs-5"></i>
        <span>Jika Anda memiliki status <b>Belum Bayar</b>, harap segera melakukan pembayaran denda melalui petugas di gudang alat.</span>
    </div>
</div>
<?= $this->endSection() ?>