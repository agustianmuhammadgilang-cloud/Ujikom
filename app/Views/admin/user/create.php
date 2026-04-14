<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="/admin/user" class="text-decoration-none">Data Pengguna</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah User</li>
            </ol>
        </nav>

        <div class="d-flex align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">Tambah User Baru</h4>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="/admin/user/store" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="username" class="form-label small fw-medium text-secondary">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-at"></i></span>
                            <input type="text" name="username" class="form-control border-start-0 ps-0" id="username" placeholder="username_peminjam" required autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label small fw-medium text-secondary">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan nama sesuai identitas" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label small fw-medium text-secondary">Password Akun</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key"></i></span>
                            <input type="password" name="password" class="form-control border-start-0 ps-0" id="password" placeholder="Min. 6 karakter" required>
                        </div>
                        <div class="form-text small" style="font-size: 11px;">Gunakan kombinasi huruf dan angka untuk keamanan.</div>
                    </div>

                    <div class="mb-4">
                        <label for="role" class="form-label small fw-medium text-secondary">Hak Akses (Role)</label>
                        <select name="role" class="form-select shadow-none" id="role">
                            <option value="peminjam" selected>Peminjam</option>
                            <option value="petugas">Petugas</option>
                            <option value="admin">Admin System</option>
                        </select>
                    </div>

                    <hr class="text-muted opacity-25 mb-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="/admin/user" class="btn btn-light px-4 text-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-person-check me-2"></i> Simpan User
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-4 text-center">
            <p class="text-muted small">E-PINJAM System &copy; 2026</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>