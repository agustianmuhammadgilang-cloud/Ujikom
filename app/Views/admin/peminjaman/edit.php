<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small">
                <li class="breadcrumb-item"><a href="/admin/peminjaman" class="text-decoration-none text-muted">Data Peminjaman</a></li>
                <li class="breadcrumb-item active text-primary fw-medium" aria-current="page">Edit Peminjaman</li>
            </ol>
        </nav>

        <h4 class="fw-bold mb-4 text-dark">Edit Detail Peminjaman</h4>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-lg-5">
                <form action="/admin/peminjaman/update/<?= $peminjaman['id_peminjaman'] ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="row g-4">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label small fw-bold text-secondary">Nama Peminjam (Tamu)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-secondary-subtle"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control shadow-none border-secondary-subtle" value="<?= $peminjaman['nama_peminjam_manual'] ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">Alat yang Dipinjam</label>
                                <input type="text" class="form-control bg-light shadow-none border-secondary-subtle" value="<?= $alat_pilihan['nama_alat'] ?>" readonly>
                                <input type="hidden" name="id_alat" value="<?= $alat_pilihan['id_alat'] ?>">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">Jumlah Pinjam</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-secondary-subtle"><i class="bi bi-box-seam"></i></span>
                                    <input type="number" name="jumlah" class="form-control bg-light shadow-none border-secondary-subtle" value="<?= $detail['jumlah'] ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_pinjam" class="form-label small fw-bold text-secondary">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control shadow-none border-secondary-subtle" value="<?= date('Y-m-d', strtotime($peminjaman['tanggal_pinjam'])) ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_kembali" class="form-label small fw-bold text-secondary">Rencana Kembali</label>
                                <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control shadow-none border-secondary-subtle" value="<?= date('Y-m-d', strtotime($peminjaman['tanggal_kembali_rencana'])) ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info border-0 shadow-sm mt-4 small" style="background-color: #e8f0fe; color: #1967d2;">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Hanya identitas peminjam dan tanggal yang dapat diubah untuk menjaga validitas stok.
                    </div>

                    <hr class="my-4 opacity-25">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="/admin/peminjaman" class="btn btn-light px-4 border text-secondary fw-medium">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm fw-medium">
                            <i class="bi bi-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>