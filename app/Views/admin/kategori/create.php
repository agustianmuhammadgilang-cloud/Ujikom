<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6"> <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="/admin/kategori" class="text-decoration-none">Data Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Kategori</li>
            </ol>
        </nav>

        <div class="d-flex align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">Tambah Kategori Baru</h4>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="/admin/kategori/store" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-4">
                        <label for="nama" class="form-label small fw-medium text-secondary">Nama Kategori</label>
                        <input type="text" 
                               name="nama" 
                               class="form-control form-control-lg" 
                               id="nama" 
                               placeholder="Contoh: Elektronik, Alat Lab, dll" 
                               style="font-size: 15px;"
                               required 
                               autofocus>
                        <div class="form-text small text-muted">Pastikan kategori belum terdaftar sebelumnya.</div>
                    </div>

                    <hr class="text-muted opacity-25 mb-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="/admin/kategori" class="btn btn-light px-4 text-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-save me-2"></i> Simpan Kategori
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