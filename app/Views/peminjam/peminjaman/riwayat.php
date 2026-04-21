<?= $this->extend('layout/peminjam_template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Riwayat Peminjaman</h4>
        <p class="text-muted small mb-0">Daftar semua pengajuan peminjaman alat Anda secara detail.</p>
    </div>
    <a href="/peminjam/peminjaman" class="btn btn-primary shadow-sm px-4">
        Tambah Pinjaman Baru
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success py-2 small shadow-sm" role="alert">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small fw-bold">Alat & Spesifikasi</th>
                        <th class="py-3 text-secondary small fw-bold text-center">Jumlah</th>
                        <th class="py-3 text-secondary small fw-bold">Waktu Pinjam</th>
                        <th class="py-3 text-secondary small fw-bold">Batas Kembali</th>
                        <th class="py-3 text-secondary small fw-bold text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($peminjaman)) : ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                Belum ada riwayat peminjaman yang tercatat.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($peminjaman as $p): ?>
                    <tr>
                        <td class="ps-4">
                            <span class="d-block fw-bold text-dark"><?= $p['nama_alat'] ?? 'Alat Tidak Diketahui' ?></span>
                        </td>
                        <td class="text-center">
                            <span class="text-dark fw-medium"><?= $p['jumlah_detail'] ?> Unit</span>
                        </td>
                        <td class="text-dark small">
                            <?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?>
                        </td>
                        <td class="text-dark small">
                            <?= date('d M Y', strtotime($p['tanggal_kembali_rencana'])) ?>
                        </td>
                        <td class="text-center">
                            <?php 
                            $status = strtolower($p['status']);
                            if ($status == 'menunggu') : ?>
                                <span class="badge bg-warning text-dark border-0 px-3 fw-medium">Menunggu</span>
                            <?php elseif ($status == 'disetujui') : ?>
                                <span class="badge bg-success text-white border-0 px-3 fw-medium">Disetujui</span>
                            <?php elseif ($status == 'ditolak') : ?>
                                <span class="badge bg-danger text-white border-0 px-3 fw-medium">Ditolak</span>
                            <?php else : ?>
                                <span class="badge bg-secondary text-white border-0 px-3 fw-medium text-capitalize"><?= $p['status'] ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    <div class="p-3 bg-light border rounded small text-muted">
        <strong>Keterangan:</strong> 
        <ul class="mb-0 mt-1">
            <li>Pastikan membawa kartu identitas saat pengambilan alat yang telah <strong>Disetujui</strong>.</li>
            <li>Keterlambatan pengembalian akan dikenakan denda sesuai ketentuan yang berlaku.</li>
        </ul>
    </div>
</div>
<?= $this->endSection() ?>