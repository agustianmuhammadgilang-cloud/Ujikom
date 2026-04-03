<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="/admin/alat" class="text-decoration-none">Data Alat</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Alat</li>
            </ol>
        </nav>

        <h4 class="fw-bold mb-4">Tambah Alat Baru</h4>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="/admin/alat/store" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="nama_alat" class="form-label small fw-medium">Nama Alat</label>
                        <input type="text" name="nama_alat" class="form-control" id="nama_alat" placeholder="Contoh: Kamera Canon EOS 600D" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="id_kategori" class="form-label small fw-medium">Kategori</label>
                        <select name="id_kategori" id="id_kategori" class="form-select" required>
                            <option value="" selected disabled>-- Pilih Kategori --</option>
                            <?php foreach($kategori as $k): ?>
                                <option value="<?= $k['id_kategori'] ?>">
                                    <?= $k['nama'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="stok" class="form-label small fw-medium">Jumlah Stok</label>
                        <input type="number" name="stok" class="form-control" id="stok" placeholder="0" min="0" required>
                    </div>

                    <hr class="text-muted opacity-25 mb-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="/admin/alat" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-save me-1"></i> Simpan Alat
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="mt-4 text-center">
            <p class="text-muted small">Pastikan data yang dimasukkan sudah sesuai dengan fisik alat yang tersedia.</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>