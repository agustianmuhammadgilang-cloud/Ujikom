<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small">
                <li class="breadcrumb-item"><a href="/admin/alat" class="text-decoration-none text-muted">Data Alat</a></li>
                <li class="breadcrumb-item active text-primary fw-medium" aria-current="page">Tambah Alat</li>
            </ol>
        </nav>

        <h4 class="fw-bold mb-4 text-dark">Tambah Alat Baru</h4>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-lg-5">
                <form action="/admin/alat/store" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <div class="row g-4">
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label for="nama_alat" class="form-label small fw-bold text-secondary">Nama Alat</label>
                                <input type="text" name="nama_alat" class="form-control shadow-none border-secondary-subtle" id="nama_alat" placeholder="Contoh: Kamera Canon EOS 600D" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="id_kategori" class="form-label small fw-bold text-secondary">Kategori</label>
                                <select name="id_kategori" id="id_kategori" class="form-select shadow-none border-secondary-subtle" required>
                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                    <?php foreach($kategori as $k): ?>
                                        <option value="<?= $k['id_kategori'] ?>"><?= $k['nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="stok" class="form-label small fw-bold text-secondary">Jumlah Stok</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-secondary-subtle"><i class="bi bi-box"></i></span>
                                            <input type="number" name="stok" class="form-control shadow-none border-secondary-subtle" id="stok" placeholder="0" min="0" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="harga_denda" class="form-label small fw-bold text-secondary">Denda / Hari</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-secondary-subtle small">Rp</span>
                                            <input type="number" name="harga_denda" class="form-control shadow-none border-secondary-subtle" id="harga_denda" placeholder="5000" min="0" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 border-start ps-md-4">
                            <label class="form-label small fw-bold text-secondary">Foto Alat</label>
                            <div class="mb-3 text-center">
                                <div class="preview-container mb-3 d-flex align-items-center justify-content-center bg-light rounded" style="height: 180px; border: 2px dashed #dee2e6;">
                                    <img src="/uploads/default.png" class="img-preview img-fluid rounded" style="max-height: 100%; object-fit: contain;">
                                </div>
                                <input type="file" name="foto" class="form-control form-control-sm shadow-none border-secondary-subtle" id="foto" accept="image/*" onchange="previewImg()">
                                <div class="form-text small mt-2">Format: JPG, PNG, WebP (Maks. 2MB)</div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-25">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="/admin/alat" class="btn btn-light px-4 border text-secondary fw-medium">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm fw-medium">
                            <i class="bi bi-save me-2"></i> Simpan Alat
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="mt-4 text-center">
            <p class="text-muted small">Sistem Inventaris E-PINJAM &copy; 2026</p>
        </div>
    </div>
</div>

<script>
    function previewImg() {
        const foto = document.querySelector('#foto');
        const imgPreview = document.querySelector('.img-preview');

        const fileFoto = new FileReader();
        fileFoto.readAsDataURL(foto.files[0]);

        fileFoto.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>
<?= $this->endSection() ?>