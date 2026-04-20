<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Riwayat Pengembalian Manual</h4>
        <p class="text-muted small mb-0">Catatan pengembalian alat dan manajemen denda keterlambatan.</p>
    </div>
    <a href="/admin/pengembalian/create" class="btn btn-primary shadow-sm px-4">
        <i class="bi bi-arrow-return-left me-2"></i> Proses Pengembalian
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success py-2 small shadow-sm" role="alert">
        <i class="bi bi-check-circle me-2"></i> <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small fw-semibold" style="width: 5%">No</th>
                        <th class="py-3 text-secondary small fw-semibold">Nama Peminjam</th>
                        <th class="py-3 text-secondary small fw-semibold">Tgl Kembali</th>
                        <th class="py-3 text-secondary small fw-semibold">Total Denda</th>
                        <th class="py-3 text-secondary small fw-semibold text-center">Status Denda</th>
                        <th class="py-3 text-secondary small fw-semibold text-center" style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pengembalian)) : ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-journal-check fs-2 d-block mb-2"></i>
                                Belum ada data pengembalian manual.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; foreach ($pengembalian as $p) : ?>
                        <tr>
                            <td class="ps-4 fw-medium text-muted"><?= $no++ ?></td>
                            <td class="text-dark fw-semibold"><?= $p['nama_peminjam_manual'] ?></td>
                            <td class="text-muted small">
                                <?= $p['tanggal_kembali'] ? date('d M Y', strtotime($p['tanggal_kembali'])) : '<span class="fst-italic">Belum Kembali</span>' ?>
                            </td>
                            <td>
                                <span class="<?= $p['denda'] > 0 ? 'text-danger fw-bold' : 'text-muted small' ?>">
                                    Rp <?= number_format($p['denda'], 0, ',', '.') ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if ($p['denda'] <= 0) : ?>
                                    <span class="badge rounded-pill bg-light text-secondary border px-3 fw-medium small">Tanpa Denda</span>
                                <?php elseif ($p['status_denda'] == 'sudah_bayar') : ?>
                                    <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 fw-medium small">Lunas</span>
                                <?php else : ?>
                                    <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-3 fw-medium small">Belum Bayar</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <?php if ($p['denda'] > 0 && $p['status_denda'] == 'belum_bayar') : ?>
                                        <a href="/admin/pengembalian/bayar/<?= $p['id_pengembalian'] ?>" 
                                           class="btn btn-sm btn-outline-danger border-0" title="Klik untuk Lunasi">
                                            <i class="bi bi-cash-coin"></i>
                                        </a>
                                    <?php endif; ?>

                                    <a href="/admin/pengembalian/edit/<?= $p['id_pengembalian'] ?>" 
                                       class="btn btn-sm btn-outline-primary border-0" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="/admin/pengembalian/delete/<?= $p['id_pengembalian'] ?>" method="post" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-dark border-0" 
                                                onclick="return confirm('Yakin mau hapus data ini?');" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3 text-muted small">
    Total Riwayat: <strong><?= count($pengembalian) ?></strong> transaksi pengembalian.
</div>
<?= $this->endSection() ?>