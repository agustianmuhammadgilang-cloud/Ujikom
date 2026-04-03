<?= $this->extend('layout/petugas_template') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Laporan Aktivitas</h4>
        <p class="text-muted small mb-0">Rekapitulasi data peminjaman dan pengembalian alat.</p>
    </div>
    <button class="btn btn-outline-primary btn-sm px-3 shadow-sm" onclick="window.print()">
        <i class="bi bi-printer me-1"></i> Cetak
    </button>
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
                <h4 class="fw-bold mb-0 text-danger">
                    Rp <?= number_format($total_denda ?? 0, 0, ',', '.') ?>
                </h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-info border-4">
            <div class="card-body py-3">
                <small class="text-muted d-block mb-1">Denda Lunas</small>
                <h4 class="fw-bold mb-0 text-success">
                    Rp <?= number_format($total_denda_lunas ?? 0, 0, ',', '.') ?>
                </h4>
            </div>
        </div>
    </div>
</div>

<div class="mb-4">
    <div class="d-flex align-items-center mb-3">
        <div class="bg-success p-1 rounded me-2"></div>
        <h6 class="fw-bold mb-0">Rincian Data Peminjaman dan Pengembalian</h6>
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
                    <?php $no = 1; foreach($data_laporan as $d): ?>
                    <?php
                        $denda = $d['denda'] ?? 0;
                        $kembali = !empty($d['tanggal_kembali']);
                    ?>
                    <tr>
                        <td class="ps-4 text-muted"><?= $no++ ?></td>

                        <td class="fw-semibold"><?= $d['nama_peminjam'] ?></td>

                        <td>
                            <div class="text-muted" style="font-size: 11px;">
                                P: <?= date('d/m/y', strtotime($d['tanggal_pinjam'])) ?>
                            </div>

                            <?php if ($kembali): ?>
                                <div class="text-dark">
                                    K: <?= date('d/m/y', strtotime($d['tanggal_kembali'])) ?>
                                </div>
                            <?php else: ?>
                                <div class="text-danger">Belum kembali</div>
                            <?php endif; ?>
                        </td>

                        <!-- STATUS -->
                        <td class="text-center">
                            <?php
                            if ($d['status'] == 'ditolak') {
                                echo '<span class="badge bg-danger-subtle text-danger border">Ditolak</span>';
                            } elseif ($d['status'] == 'menunggu') {
                                echo '<span class="badge bg-secondary-subtle text-secondary border">Menunggu</span>';
                            } elseif ($d['status'] == 'dipinjam') {
                                echo '<span class="badge bg-warning-subtle text-warning border">Dipinjam</span>';
                            } elseif ($d['status'] == 'dikembalikan') {
                                echo '<span class="badge bg-success-subtle text-success border">Dikembalikan</span>';
                            }
                            ?>
                        </td>

                        <!-- DENDA -->
                        <td class="text-end fw-bold text-danger">
                            <?= ($denda > 0) ? 'Rp ' . number_format($denda, 0, ',', '.') : '-' ?>
                        </td>

                        <!-- STATUS DENDA -->
                        <td class="text-center">
                            <?php
                            if (!$kembali) {
                                echo '<span class="badge bg-light text-muted border">-</span>';
                            } elseif ($denda == 0) {
                                echo '<span class="badge bg-light text-muted border">Tidak Ada Denda</span>';
                            } elseif ($d['status_denda'] == 'sudah_bayar') {
                                echo '<span class="badge bg-success-subtle text-success border">Lunas</span>';
                            } else {
                                echo '<span class="badge bg-danger-subtle text-danger border">Belum Bayar</span>';
                            }
                            ?>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>