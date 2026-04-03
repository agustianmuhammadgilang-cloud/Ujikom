<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Data Kategori</h4>
        <p class="text-muted small mb-0">Kelola pengelompokan alat untuk mempermudah pencarian.</p>
    </div>
    <a href="/admin/kategori/create" class="btn btn-primary shadow-sm px-4">
        <i class="bi bi-plus-lg me-2"></i> Tambah Kategori
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success border-0 shadow-sm py-2 mb-4" role="alert" style="background-color: #e6f4ea; color: #137333;">
        <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small fw-bold" style="width: 5%">No</th>
                        <th class="py-3 text-secondary small fw-bold">Nama Kategori</th>
                        <th class="py-3 text-secondary small fw-bold text-center" style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($kategori as $k) : ?>
                    <tr>
                        <td class="ps-4 text-muted small"><?= $no++ ?></td>
                        <td class="fw-semibold text-dark"><?= $k['nama'] ?></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="/admin/kategori/edit/<?= $k['id_kategori'] ?>" class="btn btn-sm btn-outline-primary border-0" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="/admin/kategori/delete/<?= $k['id_kategori'] ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Menghapus kategori akan berdampak pada data alat. Yakin?')" title="Hapus">
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
    Total: <strong><?= count($kategori) ?></strong> kategori terdaftar.
</div>

<?= $this->endSection() ?>