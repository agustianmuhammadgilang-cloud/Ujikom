<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0 text-dark">Data Peminjaman</h4>
    <p class="text-muted small mb-0">Daftar seluruh transaksi peminjaman alat yang tercatat dalam sistem.</p>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small fw-bold" style="width: 8%">No</th>
                        <th class="py-3 text-secondary small fw-bold">Nama Peminjam</th>
                        <th class="py-3 text-secondary small fw-bold">Tanggal Pinjam</th>
                        <th class="py-3 text-secondary small fw-bold">Rencana Kembali</th>
                        <th class="py-3 text-secondary small fw-bold text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($peminjaman as $p): ?>
                    <tr>
                        <td class="ps-4 text-muted small"><?= $no++ ?></td>
                        <td>
                            <div class="fw-semibold text-dark"><?= $p['nama_user'] ?></div>
                        </td>
                        <td class="text-dark small">
                            <?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?>
                        </td>
                        <td class="text-dark small">
                            <?= date('d M Y', strtotime($p['tanggal_kembali_rencana'])) ?>
                        </td>
                        <td class="text-center">
                            <?php 
                            $status = strtolower($p['status']);
                            if ($status == 'dipinjam') : ?>
                                <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle px-3">Dipinjam</span>
                            <?php elseif ($status == 'kembali') : ?>
                                <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3">Selesai</span>
                            <?php elseif ($status == 'terlambat') : ?>
                                <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-3">Terlambat</span>
                            <?php else : ?>
                                <span class="badge rounded-pill bg-secondary-subtle text-secondary border border-secondary-subtle px-3"><?= $p['status'] ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if (empty($peminjaman)) : ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted small">
                                Belum ada data peminjaman yang tersedia.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3 text-muted small">
    Total: <strong><?= count($peminjaman) ?></strong> transaksi peminjaman.
</div>
<?= $this->endSection() ?>