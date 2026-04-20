<?= $this->extend('layout/petugas_template') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Laporan Aktivitas</h4>
        <p class="text-muted small mb-0">Rekapitulasi data peminjaman dan pengembalian alat.</p>
    </div>
        <div class="d-flex gap-2">
        <a href="<?= base_url('petugas/laporan/pdf') ?>" class="btn btn-outline-danger btn-sm px-3 shadow-sm" target="_blank">
            <i class="bi bi-file-earmark-pdf me-1"></i> Cetak PDF
        </a>
        <a href="<?= base_url('petugas/laporan/excel') ?>" class="btn btn-outline-success btn-sm px-3 shadow-sm">
            <i class="bi bi-file-earmark-excel me-1"></i> Ekspor Excel
        </a>
    </div>
</div>

<div class="row g-3 mb-5">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-primary border-4">
            <div class="card-body py-3">
                <small class="text-muted d-block mb-1">Total Peminjaman</small>
                <h4 class="fw-bold mb-0"><?= $total_peminjaman ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-success border-4">
            <div class="card-body py-3">
                <small class="text-muted d-block mb-1">Total Pengembalian</small>
                <h4 class="fw-bold mb-0"><?= $total_pengembalian ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-danger border-4">
            <div class="card-body py-3">
                <small class="text-muted d-block mb-1">Total Denda</small>
                <h4 class="fw-bold mb-0 text-danger">Rp <?= number_format($total_denda, 0, ',', '.') ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-info border-4">
            <div class="card-body py-3">
                <small class="text-muted d-block mb-1">Denda Lunas</small>
                <h4 class="fw-bold mb-0 text-success">Rp <?= number_format($total_denda_lunas, 0, ',', '.') ?></h4>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-secondary small fw-bold">
                <tr>
                    <th class="ps-4 py-3">No</th>
                    <th>Nama Peminjam</th>
                    <th>Pinjam & Kembali</th>
                    <th class="text-center">Status</th>
                    <th class="text-end">Denda</th>
                    <th class="text-center">Status Denda</th>
                </tr>
            </thead>
            <tbody class="small">
                <?php $no = 1; foreach($data_laporan as $d): 
                    $denda = $d['denda'] ?? 0;
                    $isKembali = !empty($d['tanggal_kembali']);
                    $status = strtolower($d['status_pinjam'] ?? '');
                ?>
                <tr>
                    <td class="ps-4 text-muted"><?= $no++ ?></td>
                    <td class="fw-semibold"><?= esc($d['nama_peminjam']) ?></td>
                    <td>
                        <div class="text-muted" style="font-size: 11px;">
                            P: <?= date('d/m/y', strtotime($d['tanggal_pinjam'])) ?>
                        </div>
                        <?php if ($isKembali): ?>
                            <div class="text-dark">K: <?= date('d/m/y', strtotime($d['tanggal_kembali'])) ?></div>
                        <?php else: ?>
                            <div class="text-danger">Belum kembali</div>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if ($status == 'menunggu'): ?>
                            <span class="badge bg-secondary-subtle text-secondary border">Menunggu</span>
                        <?php elseif ($status == 'dipinjam'): ?>
                            <span class="badge bg-warning-subtle text-warning border">Dipinjam</span>
                        <?php elseif ($status == 'dikembalikan'): ?>
                            <span class="badge bg-success-subtle text-success border">Dikembalikan</span>
                        <?php else: ?>
                            <span class="badge bg-light text-dark border"><?= $status ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="text-end fw-bold text-danger">
                        <?= ($denda > 0) ? 'Rp ' . number_format($denda, 0, ',', '.') : '-' ?>
                    </td>
                    <td class="text-center">
                        <?php if (!$isKembali): ?>
                            <span class="badge bg-light text-muted border">-</span>
                        <?php elseif ($denda == 0): ?>
                            <span class="badge bg-light text-muted border">Tidak Ada Denda</span>
                        <?php elseif (($d['status_denda'] ?? '') == 'sudah_bayar'): ?>
                            <span class="badge bg-success-subtle text-success border">Lunas</span>
                        <?php else: ?>
                            <span class="badge bg-danger-subtle text-danger border">Belum Bayar</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>