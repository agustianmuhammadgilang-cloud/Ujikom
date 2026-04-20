<?= $this->extend('layout/peminjam_template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Riwayat Pengembalian</h4>
        <p class="text-muted small mb-0">Pantau status pengembalian dan informasi denda Anda.</p>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small fw-bold">No</th>
                        <th class="py-3 text-secondary small fw-bold">Batas Kembali</th>
                        <th class="py-3 text-secondary small fw-bold">Status</th>
                        <th class="py-3 text-secondary small fw-bold text-center">Informasi Denda</th>
                        <th class="py-3 text-secondary small fw-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($peminjaman)) : ?>
                        <tr><td colspan="5" class="text-center py-4 text-muted">Tidak ada data.</td></tr>
                    <?php endif; ?>

                    <?php $no = 1; foreach ($peminjaman as $p): ?>
                    <tr>
                        <td class="ps-4 text-muted small"><?= $no++ ?></td>
                        <td class="small"><?= date('d M Y', strtotime($p['tanggal_kembali_rencana'])) ?></td>

                        <td>
                            <?php if ($p['status'] == 'menunggu'): ?>
                                <span class="badge bg-warning-subtle text-warning border px-3">Menunggu</span>
                            <?php elseif ($p['status'] == 'ditolak'): ?>
                                <span class="badge bg-danger-subtle text-danger border px-3">Ditolak</span>
                            <?php else: ?>
                                <?php if ($p['status_pengembalian'] == 'selesai'): ?>
                                    <span class="badge bg-success-subtle text-success border px-3">Selesai</span>
                                <?php elseif ($p['status_pengembalian'] == 'diajukan'): ?>
                                    <span class="badge bg-info-subtle text-info border px-3">Proses Kembali</span>
                                <?php else: ?>
                                    <span class="badge bg-primary-subtle text-primary border px-3">Dipinjam</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>

                        <td class="text-center">
                            <?php if ($p['status_pengembalian'] == 'selesai' || (!empty($p['denda']) && $p['denda'] > 0)): ?>
                                <?php if (!empty($p['denda']) && $p['denda'] > 0): ?>
                                    <div class="small fw-bold <?= ($p['status_denda'] == 'sudah_bayar') ? 'text-success' : 'text-danger' ?>">
                                        Rp <?= number_format($p['denda'], 0, ',', '.') ?>
                                        <br>
                                        <small class="fw-normal text-muted">(<?= ($p['status_denda'] == 'sudah_bayar') ? 'Lunas' : 'Belum Bayar' ?>)</small>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted small">Tidak Ada Denda</span>
                                <?php endif; ?>
                            <?php elseif ($p['status'] == 'disetujui' && $p['terlambat'] > 0): ?>
                                <div class="text-danger small fw-bold">
                                    Est: Rp <?= number_format($p['estimasi_denda'], 0, ',', '.') ?>
                                    <br><span class="badge bg-danger" style="font-size: 9px;">Telat <?= $p['terlambat'] ?> Hari</span>
                                </div>
                            <?php else: ?>
                                <span class="text-muted small">-</span>
                            <?php endif; ?>
                        </td>

                        <td class="text-center">
                            <?php if ($p['status'] == 'disetujui' && $p['status_pengembalian'] == 'tidak_diajukan'): ?>
                                <a href="/peminjam/pengembalian/ajukan/<?= $p['id_peminjaman'] ?>" 
                                   class="btn btn-warning btn-sm shadow-sm px-3 fw-medium"
                                   onclick="return confirm('Yakin ingin mengajukan pengembalian?')">
                                   Ajukan
                                </a>
                            <?php elseif ($p['status'] == 'ditolak'): ?>
                                <small class="text-danger italic">Pengajuan Ditolak</small>
                            <?php elseif ($p['status_pengembalian'] == 'diajukan'): ?>
                                <span class="text-info small fw-medium">Proses Verifikasi</span>
                            <?php elseif ($p['status_pengembalian'] == 'selesai'): ?>
                                <i class="bi bi-check-circle-fill text-success"></i>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>