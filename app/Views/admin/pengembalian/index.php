<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0 text-dark">Data Pengembalian</h4>
    <p class="text-muted small mb-0">Riwayat pengembalian alat yang telah diproses oleh sistem.</p>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small fw-bold" style="width: 5%">No</th>
                        <th class="py-3 text-secondary small fw-bold">Nama Peminjam</th>
                        <th class="py-3 text-secondary small fw-bold">Tanggal Kembali</th>
                        <th class="py-3 text-secondary small fw-bold text-end">Denda</th>
                        <th class="py-3 text-secondary small fw-bold text-center">Status Denda</th>
                        <th class="py-3 text-secondary small fw-bold text-center">Diterima Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($pengembalian as $p): ?>
                    <tr>
                        <td class="ps-4 text-muted small"><?= $no++ ?></td>
                        <td>
                            <div class="fw-semibold text-dark"><?= $p['nama_user'] ?></div>
                        </td>
                        <td class="text-dark small">
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
                        <td class="text-center">
                            <span class="badge bg-light text-dark border fw-normal px-3 small">
                                <i class="bi bi-person me-1"></i><?= $p['nama_petugas'] ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if (empty($pengembalian)) : ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted small">
                                <i class="bi bi-inbox d-block fs-2 mb-2 opacity-50"></i>
                                Belum ada riwayat pengembalian alat.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3 text-muted small">
    Total Riwayat: <strong><?= count($pengembalian) ?></strong> data pengembalian.
</div>
<?= $this->endSection() ?>