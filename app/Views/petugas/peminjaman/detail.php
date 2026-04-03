<?= $this->extend('layout/petugas_template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0 text-dark">Informasi Peminjaman</h6>
            </div>
            <div class="card-body pt-0">
                <div class="mb-3">
                    <label class="small text-muted d-block">Nama Lengkap</label>
                    <span class="fw-bold text-dark"><?= $peminjaman['nama'] ?></span>
                </div>
                <div class="mb-3">
                    <label class="small text-muted d-block">Tanggal Pinjam</label>
                    <span class="text-dark"><?= date('d M Y', strtotime($peminjaman['tanggal_pinjam'])) ?></span>
                </div>
                <div class="mb-4">
                    <label class="small text-muted d-block">Rencana Kembali</label>
                    <span class="text-dark"><?= date('d M Y', strtotime($peminjaman['tanggal_kembali_rencana'])) ?></span>
                </div>

                <div class="p-3 rounded bg-light">
                    <label class="small text-muted d-block mb-1">Status Saat Ini</label>
                    <span class="badge rounded-pill <?= $peminjaman['status'] == 'menunggu' ? 'bg-warning text-dark' : 'bg-primary' ?> px-3 fw-medium text-capitalize">
                        <?= $peminjaman['status'] ?>
                    </span>
                </div>
            </div>
        </div>

        <?php if ($peminjaman['status'] == 'menunggu'): ?>
            <div class="d-grid gap-2">
                <a href="/petugas/peminjaman/setujui/<?= $peminjaman['id_peminjaman'] ?>" 
                   class="btn btn-success shadow-sm py-2" 
                   onclick="return confirm('Setujui peminjaman ini?')">
                    <i class="bi bi-check-circle me-2"></i> Setujui Peminjaman
                </a>
                <a href="/petugas/peminjaman/tolak/<?= $peminjaman['id_peminjaman'] ?>" 
                   class="btn btn-outline-danger py-2"
                   onclick="return confirm('Tolak permohonan ini?')">
                    <i class="bi bi-x-circle me-2"></i> Tolak Permohonan
                </a>
            </div>
        <?php endif; ?>
        
        <a href="/petugas/peminjaman" class="btn btn-light w-100 mt-2 text-muted small">Kembali ke Daftar</a>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark">Daftar Alat yang Dipinjam</h6>
                <span class="badge bg-light text-dark border fw-normal"><?= count($detail) ?> Jenis Alat</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 small fw-bold text-secondary">No</th>
                                <th class="py-3 small fw-bold text-secondary">Nama Alat</th>
                                <th class="py-3 small fw-bold text-secondary text-center">Jumlah</th>
                                <th class="py-3 small fw-bold text-secondary text-center">Stok</th>
                                <th class="py-3 small fw-bold text-secondary text-center">Validasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($detail as $d): ?>
                            <tr>
                                <td class="ps-4 text-muted small"><?= $no++ ?></td>
                                <td class="fw-medium text-dark"><?= $d['nama_alat'] ?></td>
                                <td class="text-center"><?= $d['jumlah'] ?></td>
                                <td class="text-center text-muted small"><?= $d['stok'] ?></td>
                                <td class="text-center text-nowrap">
                                    <?php if ($d['stok'] >= $d['jumlah']): ?>
                                        <span class="text-success small fw-medium">
                                            <i class="bi bi-check-lg"></i> Tersedia
                                        </span>
                                    <?php else: ?>
                                        <span class="text-danger small fw-medium">
                                            <i class="bi bi-x-lg"></i> Stok Kurang
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>