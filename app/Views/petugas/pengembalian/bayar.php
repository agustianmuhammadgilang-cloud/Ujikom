<?= $this->extend('layout/petugas_template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="/petugas/pengembalian" class="text-decoration-none text-muted">Pengembalian</a></li>
                <li class="breadcrumb-item active text-primary" aria-current="page">Pembayaran Denda</li>
            </ol>
        </nav>

        <div class="card shadow-sm border-0 overflow-hidden">
            <div class="card-header bg-danger bg-opacity-10 py-3 border-0">
                <h5 class="fw-bold mb-0 text-danger"><i class="bi bi-cash-coin me-2"></i>Penyelesaian Denda</h5>
            </div>
            
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-md-6 border-end">
                        <label class="small text-muted d-block mb-1">Nama Peminjam</label>
                        <p class="fw-bold text-dark mb-3"><?= $peminjaman['nama_peminjam'] ?></p>

                        <label class="small text-muted d-block mb-2">Riwayat Waktu & Keterlambatan</label>
                        <div class="p-3 rounded-3 bg-light border-start border-danger border-4">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Batas Kembali:</small>
                                <small class="fw-medium text-dark"><?= date('d M Y', strtotime($peminjaman['tanggal_kembali_rencana'])) ?></small>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted">Tanggal Dikembalikan:</small>
                                <small class="fw-medium text-danger"><?= date('d M Y', strtotime($pengembalian['tanggal_kembali'])) ?></small>
                            </div>
                            <hr class="my-2 opacity-25">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="small fw-bold text-dark">Total Telat:</span>
                                <?php 
                                    $awal  = strtotime($peminjaman['tanggal_kembali_rencana']);
                                    $akhir = strtotime($pengembalian['tanggal_kembali']);
                                    $diff  = ($akhir - $awal) / (60 * 60 * 24);
                                    $hari  = ($diff > 0) ? floor($diff) : 0;
                                ?>
                                <span class="badge bg-danger px-2 shadow-sm"><?= $hari ?> Hari</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 ps-md-4">
                        <label class="small text-muted d-block mb-2">Detail Alat yang Dipinjam</label>
                        <div class="vstack gap-2">
                            <?php foreach($detail as $d): ?>
                                <div class="d-flex align-items-center p-2 rounded-3 border-bottom-0 bg-light bg-opacity-50 border">
                                    <div class="rounded-2 bg-white d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px; overflow: hidden;">
                                        <?php if (!empty($d['foto'])) : ?>
                                            <img src="/uploads/<?= $d['foto'] ?>" class="w-100 h-100" style="object-fit: cover;">
                                        <?php else : ?>
                                            <i class="bi bi-box small text-muted"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="small fw-bold text-dark line-height-1"><?= $d['nama_alat'] ?></div>
                                        <div class="text-muted" style="font-size: 10px;"><?= $d['jumlah'] ?> Unit Terpinjam</div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <hr class="opacity-25">

                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 text-center">
                            <label class="small text-muted d-block">Total Denda yang Harus Dibayar</label>
                            <h3 class="fw-bold text-danger mb-0">Rp <?= number_format($pengembalian['denda'], 0, ',', '.') ?></h3>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <form method="post" action="/petugas/pengembalian/proses-bayar/<?= $pengembalian['id_pengembalian'] ?>">
                            <?= csrf_field(); ?>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-dark">Jumlah Bayar</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">Rp</span>
                                    <input type="number" 
                                           name="jumlah_bayar" 
                                           class="form-control border-start-0 ps-1 shadow-none fw-bold" 
                                           placeholder="Masukkan nominal"
                                           value="<?= $pengembalian['denda'] ?>"
                                           required>
                                </div>
                                <div class="form-text small" style="font-size: 11px;">Input nominal pembayaran sesuai uang yang diterima.</div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="/petugas/pengembalian" class="btn btn-light border flex-fill">Batal</a>
                                <button type="submit" class="btn btn-danger flex-fill shadow-sm">
                                    <i class="bi bi-check2-circle me-1"></i> Bayar Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="card-footer bg-white border-0 py-3 text-center border-top">
                <small class="text-muted italic"><i class="bi bi-shield-lock me-1"></i> Transaksi ini akan dicatat dalam laporan keuangan sistem.</small>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>