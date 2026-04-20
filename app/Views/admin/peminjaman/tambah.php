<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="/admin/peminjaman" class="text-decoration-none text-muted">Daftar Peminjaman</a></li>
                    <li class="breadcrumb-item active text-primary" aria-current="page">Tambah Pinjaman Manual</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-person-plus me-2"></i>Tambah Peminjaman Manual</h5>
                </div>
                <div class="card-body p-4">
                    <form action="/admin/peminjaman/store" method="post">
                        <?= csrf_field() ?>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Nama Lengkap Peminjam (Tamu)</label>
                                <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap peminjam..." required>
                                <div class="form-text">Input ini digunakan khusus untuk peminjam yang tidak memiliki akun sistem.</div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Pilih Alat</label>
                                <select name="id_alat" id="id_alat" class="form-select" required onchange="updateStok()">
                                    <option value="" data-stok="0">-- Pilih Alat --</option>
                                    <?php foreach($alat as $a): ?>
                                        <option value="<?= $a['id_alat'] ?>" data-stok="<?= $a['stok'] ?>">
                                            <?= $a['nama_alat'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Jumlah Pinjam</label>
                                <div class="input-group">
                                    <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="1" required>
                                    <span class="input-group-text bg-light small" id="stok_tersedia">Stok: 0</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" class="form-control" value="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Tanggal Rencana Kembali</label>
                                <input type="date" name="tanggal_kembali" class="form-control" required>
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="/admin/peminjaman" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check2-circle me-1"></i> Simpan Peminjaman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateStok() {
    const select = document.getElementById('id_alat');
    const selectedOption = select.options[select.selectedIndex];
    const stok = selectedOption.getAttribute('data-stok');
    const jumlahInput = document.getElementById('jumlah');
    
    document.getElementById('stok_tersedia').innerText = 'Stok: ' + stok;
    jumlahInput.setAttribute('max', stok);
}
</script>
<?= $this->endSection() ?>