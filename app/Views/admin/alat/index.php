<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Data Alat</h4>
        <p class="text-muted small mb-0">Kelola daftar alat yang tersedia untuk dipinjam.</p>
    </div>
    <a href="/admin/alat/create" class="btn btn-primary shadow-sm px-4">
        <i class="bi bi-plus-lg me-2"></i> Tambah Alat
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
                        <th class="py-3 text-secondary small fw-semibold">Nama Alat</th>
                        <th class="py-3 text-secondary small fw-semibold">Kategori</th>
                        <th class="py-3 text-secondary small fw-semibold">Stok</th>
                        <th class="py-3 text-secondary small fw-semibold">Harga Denda</th>
                        <th class="py-3 text-secondary small fw-semibold">Status</th>
                        <th class="py-3 text-secondary small fw-semibold text-center" style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($alat as $a) : ?>
                    <tr>
                        <td class="ps-4 fw-medium"><?= $no++ ?></td>
                        <td class="fw-semibold text-dark"><?= $a['nama_alat'] ?></td>
                        <td><span class="text-muted"><?= $a['nama_kategori'] ?></span></td>
                        <td><?= $a['stok'] ?></td>
                        <td>Rp <?= number_format($a['harga_denda'], 0, ',', '.') ?></td>
                        <td>
                            <?php if ($a['stok'] > 0) : ?>
                                <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3">Tersedia</span>
                            <?php else : ?>
                                <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-3">Habis</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="/admin/alat/edit/<?= $a['id_alat'] ?>" class="btn btn-sm btn-outline-primary border-0" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="/admin/alat/delete/<?= $a['id_alat'] ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3 text-muted small">
    Total Data: <strong><?= count($alat) ?></strong> alat terdaftar.
</div>

<?= $this->endSection() ?>