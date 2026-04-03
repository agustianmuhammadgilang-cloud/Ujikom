<?= $this->extend('layout/petugas_template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Antrean Peminjaman</h4>
        <p class="text-muted small mb-0">Daftar permohonan pinjam alat yang perlu diproses atau dipantau.</p>
    </div>
    <div class="text-muted small">
        <i class="bi bi-calendar3 me-1"></i> <?= date('d M Y') ?>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small fw-bold" style="width: 5%">No</th>
                        <th class="py-3 text-secondary small fw-bold">Nama Peminjam</th>
                        <th class="py-3 text-secondary small fw-bold">Tanggal Pinjam</th>
                        <th class="py-3 text-secondary small fw-bold text-center">Status</th>
                        <th class="py-3 text-secondary small fw-bold text-center" style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach($peminjaman as $p): ?>
                    <tr>
                        <td class="ps-4 text-muted small"><?= $no++ ?></td>
                        <td>
                            <div class="fw-semibold text-dark"><?= $p['nama'] ?></div>
                        </td>
                        <td class="text-dark small">
                            <i class="bi bi-clock-history me-1 text-muted"></i>
                            <?= date('d M Y', strtotime($p['tanggal_pinjam'])) ?>
                        </td>
                        <td class="text-center">
                            <?php 
                            $status = strtolower($p['status']);
                            if ($status == 'menunggu') : ?>
                                <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle px-3">Menunggu</span>
                            <?php elseif ($status == 'disetujui' || $status == 'dipinjam') : ?>
                                <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle px-3">Aktif</span>
                            <?php else : ?>
                                <span class="badge rounded-pill bg-light text-secondary border px-3"><?= $p['status'] ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="/petugas/peminjaman/detail/<?= $p['id_peminjaman'] ?>" class="btn btn-sm btn-outline-primary px-3 shadow-sm border-0 bg-primary bg-opacity-10">
                                <i class="bi bi-search me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if (empty($peminjaman)) : ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted small">
                                <i class="bi bi-inbox d-block fs-2 mb-2"></i>
                                Tidak ada data peminjaman saat ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3 text-muted small">
    Total Data: <strong><?= count($peminjaman) ?></strong> entri ditemukan.
</div>
<?= $this->endSection() ?>