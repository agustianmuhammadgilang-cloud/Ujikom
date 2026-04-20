<?= $this->extend('layout/peminjam_template') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0 text-dark">Pilih Alat</h4>
    <p class="text-muted small">Cari dan pilih alat yang ingin Anda pinjam hari ini.</p>
</div>

<div class="mb-4 d-flex justify-content-between align-items-center">
    <div class="dropdown">
        <button class="btn btn-white border shadow-sm dropdown-toggle px-4 rounded-pill btn-sm fw-medium" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-filter me-2 text-primary"></i>
            <?php 
                $activeKategori = "Semua Kategori";
                foreach ($kategori as $k) {
                    if (isset($_GET['kategori']) && $_GET['kategori'] == $k['id_kategori']) {
                        $activeKategori = $k['nama'];
                    }
                }
                echo $activeKategori;
            ?>
        </button>
        <ul class="dropdown-menu shadow-sm border-0 mt-2">
            <li>
                <a class="dropdown-item small py-2 <?= empty($_GET['kategori']) ? 'active bg-primary' : '' ?>" href="/peminjam/peminjaman">
                    Semua Kategori
                </a>
            </li>
            <li><hr class="dropdown-divider opacity-50"></li>
            <?php foreach ($kategori as $k) : ?>
                <li>
                    <a class="dropdown-item small py-2 <?= (isset($_GET['kategori']) && $_GET['kategori'] == $k['id_kategori']) ? 'active bg-primary' : '' ?>" 
                       href="?kategori=<?= $k['id_kategori'] ?>">
                        <?= $k['nama'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="text-muted small">
        Menampilkan <b><?= count($alat) ?></b> alat
    </div>
</div>

<div class="row g-3">
    <?php if (empty($alat)) : ?>
        <div class="col-12 text-center py-5">
            <i class="bi bi-search d-block fs-1 text-muted opacity-50 mb-3"></i>
            <p class="text-muted">Alat tidak ditemukan untuk kategori ini.</p>
        </div>
    <?php endif; ?>

    <?php foreach ($alat as $a) : ?>
        <div class="col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 160px; overflow: hidden; border-bottom: 1px solid #f1f3f4;">
                    <?php if ($a['foto']) : ?>
                        <img src="/uploads/<?= $a['foto'] ?>" class="w-100 h-100" style="object-fit: cover;">
                    <?php else : ?>
                        <i class="bi bi-image text-secondary opacity-25 fs-1"></i>
                    <?php endif; ?>
                </div>
                
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <span class="badge bg-primary-subtle text-primary border-0 small mb-2" style="font-size: 10px;"><?= $a['nama_kategori'] ?></span>
                        <span class="small text-muted" style="font-size: 11px;">Stok: <b><?= $a['stok'] ?></b></span>
                    </div>
                    <h6 class="fw-bold text-dark text-truncate mb-2"><?= $a['nama_alat'] ?></h6>
                    <p class="text-muted mb-3" style="font-size: 12px;">Denda: Rp<?= number_format($a['harga_denda'], 0, ',', '.') ?>/hari</p>
                    
                    <?php if ($a['stok'] > 0) : ?>
                        <a href="/peminjam/peminjaman/create/<?= $a['id_alat'] ?>" class="btn btn-primary w-100 btn-sm rounded-3">
                            Pilih Alat <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    <?php else : ?>
                        <button class="btn btn-secondary w-100 btn-sm rounded-3 disabled">Stok Habis</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="position-fixed bottom-0 end-0 m-4">
    <a href="/peminjam/peminjaman/riwayat" class="btn btn-dark shadow-lg px-4 py-2 rounded-pill">
        <i class="bi bi-clock-history me-2"></i> Lihat Riwayat Pinjam
    </a>
</div>
<?= $this->endSection() ?>