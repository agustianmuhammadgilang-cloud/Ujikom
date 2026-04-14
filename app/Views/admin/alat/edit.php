<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="/admin/alat" class="text-decoration-none">Data Alat</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Alat</li>
            </ol>
        </nav>

        <h4 class="fw-bold mb-4">Edit Data Alat</h4>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="/admin/alat/update/<?= $alat['id_alat'] ?>" method="post">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="nama_alat" class="form-label small fw-medium">Nama Alat</label>
                        <input type="text" name="nama_alat" class="form-control" id="nama_alat" 
                               value="<?= $alat['nama_alat'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="id_kategori" class="form-label small fw-medium">Kategori</label>
                        <select name="id_kategori" id="id_kategori" class="form-select" required>
                            <?php foreach($kategori as $k): ?>
                                <option value="<?= $k['id_kategori'] ?>"
                                    <?= $alat['id_kategori'] == $k['id_kategori'] ? 'selected' : '' ?>>
                                    <?= $k['nama'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="stok" class="form-label small fw-medium">Jumlah Stok</label>
                        <input type="number" name="stok" class="form-control" id="stok" 
                            value="<?= $alat['stok'] ?>" min="0" required>
                    </div>

                    <div class="mb-4">
                        <label for="harga_denda" class="form-label small fw-medium">Harga Denda / Hari</label>
                        <input type="number" name="harga_denda" class="form-control" id="harga_denda" 
                            value="<?= $alat['harga_denda'] ?>" min="0" required>
                    </div>

                    <hr class="text-muted opacity-25 mb-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="/admin/alat" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-arrow-repeat me-1"></i> Perbarui Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>