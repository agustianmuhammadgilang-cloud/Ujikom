<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small">
                <li class="breadcrumb-item"><a href="/admin/pengembalian" class="text-decoration-none text-muted">Data Pengembalian</a></li>
                <li class="breadcrumb-item active text-primary fw-medium" aria-current="page">Edit Pengembalian</li>
            </ol>
        </nav>

        <h4 class="fw-bold mb-4 text-dark">Edit Detail Pengembalian</h4>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-lg-5">
                <form action="/admin/pengembalian/update/<?= $pengembalian['id_pengembalian'] ?>" method="post">
                    <?= csrf_field(); ?>
                    
                    <input type="hidden" name="id_pengembalian" value="<?= $pengembalian['id_pengembalian'] ?>">

                    <div class="row g-4">
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label for="nama_peminjam_manual" class="form-label small fw-bold text-secondary">Nama Peminjam</label>
                                <input type="text" name="nama_peminjam_manual" 
                                       class="form-control shadow-none border-secondary-subtle fw-semibold" 
                                       id="nama_peminjam_manual" 
                                       value="<?= old('nama_peminjam_manual', $pengembalian['nama_peminjam_manual']) ?>" required>
                                <div class="form-text small text-info">
                                    <i class="bi bi-info-circle me-1"></i> Hanya kolom nama yang dapat diperbarui pada tahap ini.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Tanggal Kembali</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-secondary-subtle"><i class="bi bi-calendar-event"></i></span>
                                    <input type="text" class="form-control bg-light border-secondary-subtle text-muted" 
                                           value="<?= date('d M Y', strtotime($pengembalian['tanggal_kembali'])) ?>" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Status Denda</label>
                                <?php 
                                    // Logika Status Denda agar masuk akal
                                    if ($pengembalian['denda'] <= 0) {
                                        $status_class = 'text-secondary';
                                        $status_label = 'Tanpa Denda';
                                    } elseif ($pengembalian['status_denda'] == 'sudah_bayar') {
                                        $status_class = 'text-success fw-bold';
                                        $status_label = 'Lunas / Sudah Bayar';
                                    } else {
                                        $status_class = 'text-danger fw-bold';
                                        $status_label = 'Belum Bayar';
                                    }
                                ?>
                                <input type="text" class="form-control bg-light border-secondary-subtle <?= $status_class ?>" 
                                       value="<?= $status_label ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Jumlah Alat</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-secondary-subtle">
                                        <i class="bi bi-box-seam"></i>
                                    </span>
                                    <input type="text" class="form-control bg-light border-secondary-subtle text-muted fw-medium" 
                                        value="<?= $pengembalian['jumlah_pinjam'] ?? '0' ?> Unit" readonly>
                                </div>
                                <div class="form-text small">Total kuantitas alat yang dipinjam.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Total Denda</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-secondary-subtle small">Rp</span>
                                    <input type="text" class="form-control bg-light border-secondary-subtle text-muted fw-bold" 
                                           value="<?= number_format($pengembalian['denda'], 0, ',', '.') ?>" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Jumlah yang Dibayarkan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-secondary-subtle small">Rp</span>
                                    <input type="text" class="form-control bg-light border-secondary-subtle text-muted" 
                                           value="<?= number_format($pengembalian['jumlah_bayar'], 0, ',', '.') ?>" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Tanggal Pelunasan</label>
                                <input type="text" class="form-control bg-light border-secondary-subtle text-muted" 
                                       value="<?= ($pengembalian['tanggal_bayar']) ? date('d M Y', strtotime($pengembalian['tanggal_bayar'])) : '-' ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-25">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="/admin/pengembalian" class="btn btn-light px-4 border text-secondary fw-medium">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm fw-medium">
                            <i class="bi bi-check2-circle me-2"></i> Perbarui Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>