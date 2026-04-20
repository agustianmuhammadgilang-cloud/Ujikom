<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Daftar Peminjaman Manual</h4>
        <p class="text-muted small mb-0">Catatan transaksi peminjaman alat secara langsung (offline).</p>
    </div>
    <a href="/admin/peminjaman/create" class="btn btn-primary shadow-sm px-4">
        <i class="bi bi-plus-lg me-2"></i> Tambah Pinjaman
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success border-0 shadow-sm py-2 mb-4" role="alert" style="background-color: #e6f4ea; color: #137333;">
        <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small fw-bold" style="width: 5%">No</th>
                        <th class="py-3 text-secondary small fw-bold">Nama Peminjam</th>
                        <th class="py-3 text-secondary small fw-bold">Tgl Pinjam</th>
                        <th class="py-3 text-secondary small fw-bold">Rencana Kembali</th>
                        <th class="py-3 text-secondary small fw-bold text-center">Status</th>
                        <th class="py-3 text-secondary small fw-bold text-center" style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($peminjaman)) : ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Belum ada data peminjaman manual.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; foreach ($peminjaman as $p) : ?>
                        <tr>
                            <td class="ps-4 text-muted small"><?= $no++ ?></td>
                            <td class="text-dark fw-medium"><?= $p['nama_peminjam_manual'] ?></td>
                            <td class="text-dark small"><?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?></td>
                            <td class="text-dark small"><?= date('d M Y', strtotime($p['tanggal_kembali_rencana'])) ?></td>
                            <td class="text-center">
                                <?php if ($p['status'] == 'dipinjam') : ?>
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 fw-medium" style="color: #856404 !important;">Dipinjam</span>
                                <?php else : ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 fw-medium">Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="/admin/peminjaman/edit/<?= $p['id_peminjaman'] ?>" class="btn btn-sm btn-outline-primary border-0" title="Edit Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button onclick="hapusPinjaman(<?= $p['id_peminjaman'] ?>)" class="btn btn-sm btn-outline-danger border-0" title="Hapus Data">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3 text-muted small">
    Total Transaksi: <strong><?= count($peminjaman) ?></strong> data ditemukan.
</div>

<script>
function hapusPinjaman(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini? Stok alat akan dikembalikan otomatis.')) {
        window.location.href = '/admin/peminjaman/delete/' + id;
    }
}
</script>
<?= $this->endSection() ?>