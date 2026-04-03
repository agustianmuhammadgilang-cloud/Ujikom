<?= $this->extend('layout/peminjam_template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Riwayat Pengembalian</h4>
        <p class="text-muted small mb-0">Daftar alat yang telah Anda kembalikan beserta status administrasinya.</p>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small fw-bold" style="width: 5%">No</th>
                        <th class="py-3 text-secondary small fw-bold">Tanggal Pinjam</th>
                        <th class="py-3 text-secondary small fw-bold">Tanggal Kembali</th>
                        <th class="py-3 text-secondary small fw-bold text-end">Denda</th>
                        <th class="py-3 text-secondary small fw-bold text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pengembalian)) : ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-clock-history d-block fs-2 mb-2 opacity-50"></i>
                                Belum ada riwayat pengembalian.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php $no = 1; foreach ($pengembalian as $p): ?>
                    <tr>
                        <td class="ps-4 text-muted small"><?= $no++ ?></td>
                        <td class="small text-dark">
                            <?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?>
                        </td>
                        <td class="small text-dark">
                            <?= date('d M Y', strtotime($p['tanggal_kembali'])) ?>
                        </td>
                        <td class="text-end fw-medium">
                            <?php if ($p['denda'] > 0) : ?>
                                <span class="text-danger">Rp <?= number_format($p['denda'], 0, ',', '.') ?></span>
                            <?php else : ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php 
                            if ($p['denda'] == 0) {
                                echo '<span class="badge rounded-pill bg-light text-muted border px-3 fw-normal">Tidak Ada Denda</span>';
                            } elseif ($p['status_denda'] == 'sudah_bayar') {
                                echo '<span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 fw-medium">Lunas</span>';
                            } else {
                                echo '<span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-3 fw-medium">Belum Bayar</span>';
                            }
                            ?>
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