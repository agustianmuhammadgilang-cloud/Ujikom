<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #333; }
        .kop { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #f2f2f2; border: 1px solid #000; padding: 5px; }
        td { border: 1px solid #000; padding: 5px; }
        .text-center { text-align: center; }
        .footer { margin-top: 20px; float: right; width: 200px; text-align: center; }
    </style>
</head>
<body>
    <div class="kop">
        <h2>SISTEM INFORMASI INVENTARIS ALAT</h2>
        <p>Laporan Monitoring Peminjaman, Persetujuan, dan Pengembalian</p>
    </div>

    <h3 class="text-center"><?= $title ?></h3>
    <p>Dicetak pada: <?= $tanggal_cetak ?></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Alat (Qty)</th>
                <th>Status</th>
                <th>Disetujui Oleh</th>
                <th>Denda</th>
                <th>Status Denda</th>
                <th>Diterima Oleh</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($monitoring as $m): 
                $peminjam = $m['id_user'] ? $m['nama_user_akun'] : $m['nama_peminjam_manual'];
                $isSelesai = ($m['status_pengembalian'] == 'selesai');
            ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= $peminjam ?></td>
                <td><?= $m['nama_alat'] ?> (<?= $m['jumlah_detail'] ?>)</td>
                <td class="text-center"><?= $isSelesai ? 'SELESAI' : strtoupper($m['status']) ?></td>
                <td><?= $m['nama_penyetuju'] ?? '-' ?></td>
                <td>Rp <?= number_format($m['denda'] ?? 0, 0, ',', '.') ?></td>
                <td class="text-center"><?= strtoupper($m['status_denda'] ?? '-') ?></td>
                <td><?= $m['nama_penerima'] ?? '-' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh,</p>
        <br><br><br>
        <p><strong>( <?= $admin ?> )</strong></p>
    </div>
</body>
</html>