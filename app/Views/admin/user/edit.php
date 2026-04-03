<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="/admin/user" class="text-decoration-none">Data Pengguna</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit User</li>
            </ol>
        </nav>

        <div class="d-flex align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">Edit Data Pengguna</h4>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="/admin/user/update/<?= $user['id_user'] ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="username" class="form-label small fw-medium text-secondary">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-at"></i></span>
                            <input type="text" 
                                   name="username" 
                                   class="form-control border-start-0 ps-0 shadow-none" 
                                   id="username" 
                                   value="<?= $user['username'] ?>" 
                                   required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label small fw-medium text-secondary">Nama Lengkap</label>
                        <input type="text" 
                               name="nama" 
                               class="form-control shadow-none" 
                               id="nama" 
                               value="<?= $user['nama'] ?>" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label small fw-medium text-secondary text-primary">Password Baru <span class="text-muted fw-normal">(Opsional)</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" 
                                   name="password" 
                                   class="form-control border-start-0 ps-0 shadow-none" 
                                   id="password" 
                                   placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                        <div class="form-text small" style="font-size: 11px; color: #d93025;">
                            <i class="bi bi-info-circle me-1"></i> Hanya isi jika Anda ingin mengganti password lama.
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="role" class="form-label small fw-medium text-secondary">Hak Akses (Role)</label>
                        <select name="role" class="form-select shadow-none" id="role">
                            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin System</option>
                            <option value="petugas" <?= $user['role'] == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                            <option value="peminjam" <?= $user['role'] == 'peminjam' ? 'selected' : '' ?>>Peminjam</option>
                        </select>
                    </div>

                    <hr class="text-muted opacity-25 mb-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="/admin/user" class="btn btn-light px-4 text-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-arrow-repeat me-2"></i> Perbarui Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>