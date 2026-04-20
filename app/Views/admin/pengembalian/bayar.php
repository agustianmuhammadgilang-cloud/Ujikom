<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8"> <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="/admin/pengembalian" class="text-decoration-none text-muted">Riwayat</a></li>
                <li class="breadcrumb-item active text-primary fw-medium" aria-current="page">Pembayaran</li>
            </ol>
        </nav>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-danger bg-opacity-10 py-2 border-0">
                <h6 class="fw-bold mb-0 text-danger"><i class="bi bi-cash-stack me-2"></i>Penyelesaian Denda</h6>
            </div>
            
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6 border-end">
                        <div class="mb-3">
                            <label class="small text-muted d-block mb-1">Peminjam:</label>
                            <h5 class="fw-bold text-dark mb-0"><?= $peminjaman['nama_peminjam_manual'] ?></h5>
                        </div>

                        <div class="p-3 rounded-3 bg-light border-start border-danger border-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted small">Batas Kembali:</span>
                                <span class="small fw-medium"><?= date('d/m/Y', strtotime($peminjaman['tanggal_kembali_rencana'])) ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Tgl Dikembalikan:</span>
                                <span class="small fw-medium text-danger"><?= date('d/m/Y', strtotime($pengembalian['tanggal_kembali'])) ?></span>
                            </div>
                            <hr class="my-2 opacity-25">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-bold small">Terlambat:</span>
                                <?php 
                                    $awal  = strtotime($peminjaman['tanggal_kembali_rencana']);
                                    $akhir = strtotime($pengembalian['tanggal_kembali']);
                                    $diff  = ($akhir - $awal) / (60 * 60 * 24);
                                    $hari  = ($diff > 0) ? floor($diff) : 0;
                                ?>
                                <span class="badge bg-danger"><?= $hari ?> Hari</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="small text-muted d-block mb-2">Rincian Item:</label>
                        <ul class="list-group list-group-flush border rounded-2">
                            <?php foreach($detail as $d): ?>
                                <li class="list-group-item py-2 bg-transparent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="small fw-bold text-dark"><?= $d['nama_alat'] ?></div>
                                        <div class="small text-muted"><?= $d['jumlah'] ?> Unit</div>
                                    </div>
                                    <div class="text-muted" style="font-size: 11px;">
                                        Denda: Rp <?= number_format($d['harga_denda'], 0, ',', '.') ?> /hari
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <div class="mt-4 p-3 rounded-3 bg-light border">
                    <form method="post" action="<?= base_url('admin/pengembalian/proses-bayar/' . $pengembalian['id_pengembalian']) ?>">
                        <?= csrf_field(); ?>
                        <div class="row align-items-end g-3">
                            <div class="col-sm-6">
                                <label class="form-label small fw-bold text-muted">Total Denda Wajib Bayar</label>
                                <div class="h4 fw-bold text-danger mb-0">
                                    Rp <?= number_format($pengembalian['denda'], 0, ',', '.') ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label small fw-bold text-dark">Jumlah Uang Diterima</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white small">Rp</span>
                                    <input type="number" 
                                           name="jumlah_bayar" 
                                           class="form-control fw-bold text-primary shadow-none" 
                                           min="<?= $pengembalian['denda'] ?>"
                                           value="<?= $pengembalian['denda'] ?>"
                                           required>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-danger w-100 fw-bold" onclick="return confirm('Konfirmasi pelunasan?')">
                                    LUNASKAN SEKARANG
                                </button>
                                <a href="/admin/pengembalian" class="btn btn-link btn-sm w-100 text-decoration-none text-muted mt-2">Batalkan Prosedur</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card-footer bg-white py-2 text-center">
                <small class="text-muted" style="font-size: 11px;">
                    <i class="bi bi-info-circle me-1"></i> Data akan otomatis dipindahkan ke riwayat lunas setelah disimpan.
                </small>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>