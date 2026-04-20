<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-7">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small">
                <li class="breadcrumb-item"><a href="/admin/pengembalian" class="text-decoration-none text-muted">Riwayat Kembali</a></li>
                <li class="breadcrumb-item active text-primary fw-medium" aria-current="page">Proses Kembali</li>
            </ol>
        </nav>

        <h4 class="fw-bold mb-4 text-dark">Proses Pengembalian</h4>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom border-light">
                <h6 class="fw-bold mb-0 text-primary">
                    <i class="bi bi-arrow-return-left me-2"></i>Input Pengembalian Manual
                </h6>
            </div>
            <div class="card-body p-4 p-lg-5">
                <form action="/admin/pengembalian/store" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label for="id_peminjaman" class="form-label small fw-bold text-secondary">Pilih Nama Peminjam</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-secondary-subtle"><i class="bi bi-person-search"></i></span>
                            <select name="id_peminjaman" id="id_peminjaman" class="form-select shadow-none border-secondary-subtle" required>
                                <option value="">-- Cari Nama Peminjam --</option>
                                <?php foreach($peminjaman_aktif as $p): ?>
                                    <option value="<?= $p['id_peminjaman'] ?>">
                                        <?= $p['nama_peminjam_manual'] ?> 
                                        (Batas: <?= date('d/m/Y', strtotime($p['tanggal_kembali_rencana'])) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-text small mt-2">
                            <i class="bi bi-info-circle me-1"></i> Hanya menampilkan peminjam manual yang belum mengembalikan alat.
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="tanggal_kembali" class="form-label small fw-bold text-secondary">Tanggal Dikembalikan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-secondary-subtle"><i class="bi bi-calendar-check"></i></span>
                            <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control shadow-none border-secondary-subtle" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="alert alert-info border-0 shadow-sm small d-flex align-items-start" style="background-color: #e8f0fe; color: #1967d2;">
                        <i class="bi bi-exclamation-circle-fill me-3 mt-1 fs-5"></i>
                        <div>
                            Pastikan barang sudah dicek fisiknya sebelum diproses. 
                            <strong>Sistem akan otomatis menghitung denda</strong> jika tanggal kembali melewati batas rencana kembali.
                        </div>
                    </div>

                    <hr class="my-4 opacity-25">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="/admin/pengembalian" class="btn btn-light px-4 border text-secondary fw-medium">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm fw-medium">
                            <i class="bi bi-check2-circle me-2"></i> Proses Pengembalian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>