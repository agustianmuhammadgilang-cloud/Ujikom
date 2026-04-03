<?= $this->extend('layout/petugas_template') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Data Pengembalian</h4>
        <p class="text-muted small mb-0">Kelola status pengembalian alat dan pelunasan denda pengguna.</p>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small fw-bold" style="width: 5%">No</th>
                        <th class="py-3 text-secondary small fw-bold">Nama Peminjam</th>
                        <th class="py-3 text-secondary small fw-bold text-end">Denda</th>
                        <th class="py-3 text-secondary small fw-bold text-center">Status</th>
                        <th class="py-3 text-secondary small fw-bold text-center" style="width: 20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($peminjaman as $p): ?>
                    <tr>
                        <td class="ps-4 text-muted small"><?= $no++ ?></td>
                        <td>
                            <div class="fw-semibold text-dark"><?= $p['nama_peminjam'] ?></div>
                        </td>

                        <td class="text-end fw-medium <?= ($p['denda'] ?? 0) > 0 ? 'text-danger' : 'text-muted' ?>">
                            <?= ($p['denda'] ?? 0) > 0 ? 'Rp ' . number_format($p['denda'], 0, ',', '.') : '-' ?>
                        </td>

                        <td class="text-center">
                            <?php if (empty($p['id_pengembalian'])): ?>
                                <span class="badge rounded-pill bg-light text-secondary border px-3 fw-normal">Belum Dikembalikan</span>

                            <?php else: ?>
                                <?php if ($p['denda'] == 0): ?>
                                    <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 fw-medium">Tidak Ada Denda</span>

                                <?php else: ?>
                                    <?php if ($p['status_denda'] == 'sudah_bayar'): ?>
                                        <span class="badge rounded-pill bg-success text-white px-3 fw-medium">Lunas</span>
                                    <?php else: ?>
                                        <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-3 fw-medium">Belum Bayar</span>
                                    <?php endif; ?>

                                <?php endif; ?>
                            <?php endif; ?>
                        </td>

                        <td class="text-center">
                            <?php if (empty($p['id_pengembalian'])): ?>
                                <a href="/petugas/pengembalian/proses/<?= $p['id_peminjaman'] ?>" class="btn btn-sm btn-primary px-3 shadow-sm">
                                    <i class="bi bi-box-arrow-in-left me-1"></i> Proses
                                </a>

                            <?php else: ?>
                                <?php if ($p['denda'] > 0 && $p['status_denda'] == 'belum_bayar'): ?>
                                    <a href="/petugas/pengembalian/bayar/<?= $p['id_pengembalian'] ?>" class="btn btn-sm btn-danger px-3 shadow-sm">
                                        <i class="bi bi-cash-stack me-1"></i> Bayar Denda
                                    </a>

                                <?php else: ?>
                                    <span class="text-muted small"><i class="bi bi-check2-all me-1"></i> Selesai</span>

                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3 text-muted small">
    Total Data: <strong><?= count($peminjaman) ?></strong> entri.
</div>

<?= $this->endSection() ?>