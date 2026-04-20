<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Monitoring Terpadu</h4>
        <p class="text-muted small mb-0">Pantau seluruh aliran peminjaman, persetujuan, hingga penanggung jawab alat.</p>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.location.reload()" class="btn btn-light btn-sm border shadow-sm px-3">
            <i class="bi bi-arrow-clockwise me-1"></i> Refresh Data
        </button>
        <div class="d-flex gap-2">
    <a href="<?= base_url('admin/monitoring/pdf') ?>" class="btn btn-outline-danger btn-sm px-3 shadow-sm" target="_blank">
        <i class="bi bi-file-earmark-pdf me-1"></i> Cetak PDF
    </a>
    <a href="<?= base_url('admin/monitoring/excel') ?>" class="btn btn-outline-success btn-sm px-3 shadow-sm">
        <i class="bi bi-file-earmark-excel me-1"></i> Ekspor Excel
    </a>
</div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-secondary small fw-bold">
                <tr>
                    <th class="ps-4 py-3">No</th>
                    <th>Peminjam</th>
                    <th>Alat & Qty</th>
                    <th class="text-center">Status Transaksi</th>
                    <th class="text-center">Info Denda</th>
                    <th class="text-center">Penerimaan Alat</th>
                </tr>
            </thead>
            <tbody class="small">
    <?php $no = 1; foreach ($monitoring as $m) : 
        $isSelesai = ($m['status_pengembalian'] == 'selesai');
        $statusPinjam = strtolower($m['status']);
    ?>
    <tr>
        <td class="ps-4 text-muted"><?= $no++; ?></td>
        <td>
            <div class="fw-semibold">
                <?= $m['id_user'] ? esc($m['nama_user_akun']) : esc($m['nama_peminjam_manual']); ?>
            </div>
            <small class="text-muted">
                <?= $m['id_user'] ? '<span class="badge bg-info-subtle text-info border-0" style="font-size:10px">AKUN</span>' : '<span class="badge bg-secondary-subtle text-secondary border-0" style="font-size:10px">MANUAL</span>'; ?>
            </small>
        </td>
        <td>
            <div class="fw-medium text-dark"><?= esc($m['nama_alat']); ?></div>
            <small class="text-muted">Jumlah: <?= $m['jumlah_detail']; ?> unit</small>
        </td>
        <td class="text-center">
            <?php if ($statusPinjam == 'ditolak'): ?>
                <span class="badge bg-danger-subtle text-danger border px-2 mb-1">Ditolak</span>
                <div class="text-muted" style="font-size: 10px;">Oleh: <?= esc($m['nama_penyetuju'] ?? '-'); ?></div>
            <?php elseif ($isSelesai): ?>
                <span class="badge bg-primary-subtle text-primary border px-2 mb-1">Selesai / Kembali</span>
                <div class="text-muted" style="font-size: 10px;">Disetujui: <?= esc($m['nama_penyetuju'] ?? 'Admin'); ?></div>
            <?php elseif ($statusPinjam == 'disetujui' || $statusPinjam == 'dipinjam'): ?>
                <span class="badge bg-success-subtle text-success border px-2 mb-1">Sedang Dipinjam</span>
                <div class="text-muted" style="font-size: 10px;">Oleh: <?= esc($m['nama_penyetuju'] ?? 'Admin'); ?></div>
            <?php else: ?>
                <span class="badge bg-warning-subtle text-warning border px-2">Menunggu Konfirmasi</span>
            <?php endif; ?>
        </td>
        <td class="text-center">
            <?php if ($statusPinjam == 'ditolak'): ?>
                <span class="text-muted">-</span> <?php elseif ($isSelesai) : ?>
                <div class="fw-bold <?= $m['denda'] > 0 ? 'text-danger' : 'text-muted' ?>">
                    <?= $m['denda'] > 0 ? 'Rp ' . number_format($m['denda'], 0, ',', '.') : 'Tidak Ada Denda' ?>
                </div>
                <?php if ($m['denda'] > 0): ?>
                    <span class="badge <?= $m['status_denda'] == 'sudah_bayar' ? 'bg-success' : 'bg-danger' ?>" style="font-size: 9px;">
                        <?= $m['status_denda'] == 'sudah_bayar' ? 'LUNAS' : 'BELUM BAYAR' ?>
                    </span>
                <?php endif; ?>
            <?php else : ?>
                <span class="text-muted" style="font-size: 11px;"><i class="bi bi-arrow-right-short"></i> Masih Berjalan</span>
            <?php endif; ?>
        </td>
        <td class="text-center">
            <?php if ($statusPinjam == 'ditolak'): ?>
                <span class="text-muted">-</span>
            <?php elseif ($isSelesai): ?>
                <div class="text-dark fw-medium" style="font-size: 10px;">Diterima Oleh:</div>
                <div class="text-primary fw-bold"><?= esc($m['nama_penerima'] ?? '-'); ?></div>
            <?php else: ?>
                <span class="text-muted small">-</span>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>