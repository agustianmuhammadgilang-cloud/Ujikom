<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0 text-dark">Log Aktivitas</h4>
        <p class="text-muted small mb-0">Riwayat jejak digital penggunaan sistem oleh setiap pengguna.</p>
    </div>
    <button class="btn btn-outline-secondary btn-sm shadow-sm px-3" onclick="window.location.reload()">
        <i class="bi bi-arrow-clockwise me-1"></i> Refresh
    </button>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary small fw-bold" style="width: 8%">No</th>
                        <th class="py-3 text-secondary small fw-bold" style="width: 25%">User</th>
                        <th class="py-3 text-secondary small fw-bold">Aktivitas</th>
                        <th class="py-3 text-secondary small fw-bold text-end pe-4" style="width: 20%">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1 + (10 * ($currentPage - 1)); 
                    foreach ($log as $l): 
                    ?>
                    <tr>
                        <td class="ps-4 text-muted small"><?= $no++ ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                    <span class="text-primary fw-bold small"><?= strtoupper(substr($l['nama'] ?? 'U', 0, 1)) ?></span>
                                </div>
                                <div>
                                    <div class="fw-semibold text-dark mb-0"><?= $l['nama'] ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-dark small"><?= $l['aktivitas'] ?></span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="text-dark small fw-medium"><?= date('d/m/Y', strtotime($l['tanggal'])) ?></div>
                            <div class="text-muted small" style="font-size: 11px;"><?= date('H:i', strtotime($l['tanggal'])) ?> WIB</div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mt-4 px-2">
    <div class="text-muted small">
        Menampilkan <strong><?= count($log) ?></strong> data.
    </div>
    <div class="custom-pagination">
        <?= $pager->links('log', 'default_full') ?>
    </div>
</div>
<?= $this->endSection() ?>