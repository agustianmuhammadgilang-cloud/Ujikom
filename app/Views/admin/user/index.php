<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Data Pengguna</h4>
        <p class="text-muted small mb-0">Kelola hak akses dan informasi akun pengguna sistem.</p>
    </div>
    <a href="/admin/user/create" class="btn btn-primary shadow-sm px-4">
        <i class="bi bi-person-plus me-2"></i> Tambah User
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
                        <th class="ps-4 py-3 text-secondary small fw-bold" style="width: 8%">No</th>
                        <th class="py-3 text-secondary small fw-bold">Username</th>
                        <th class="py-3 text-secondary small fw-bold">Nama Lengkap</th>
                        <th class="py-3 text-secondary small fw-bold text-center">Role</th>
                        <th class="py-3 text-secondary small fw-bold text-center" style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($users as $u): ?>
                    <tr>
                        <td class="ps-4 text-muted small"><?= $no++ ?></td>
                        <td class="text-dark fw-medium"><?= $u['username'] ?></td>
                        <td class="text-dark"><?= $u['nama'] ?></td>
                        <td class="text-center">
                            <?php if (strtolower($u['role']) == 'admin') : ?>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 fw-medium">Admin</span>
                            <?php elseif (strtolower($u['role']) == 'petugas') : ?>
                                <span class="badge bg-info-subtle text-info border border-info-subtle px-3 fw-medium">Petugas</span>
                            <?php elseif (strtolower($u['role']) == 'peminjam') : ?>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 fw-medium">Peminjam</span>
                            <?php else : ?>
                                <span class="badge bg-light text-secondary border px-3 fw-medium"><?= ucfirst($u['role']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="/admin/user/edit/<?= $u['id_user'] ?>" class="btn btn-sm btn-outline-primary border-0" title="Edit User">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="/admin/user/delete/<?= $u['id_user'] ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')" title="Hapus User">
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
    Total Pengguna: <strong><?= count($users) ?></strong> akun terdaftar.
</div>
<?= $this->endSection() ?>