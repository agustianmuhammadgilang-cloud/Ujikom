<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.4; }
        .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop h1 { margin: 0; text-transform: uppercase; font-size: 20px; }
        .info-cetak { font-size: 10px; text-align: right; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { background-color: #f2f2f2; border: 1px solid #444; padding: 8px; font-size: 11px; text-transform: uppercase; }
        td { border: 1px solid #444; padding: 6px; font-size: 11px; vertical-align: middle; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .ttd-container { float: right; width: 200px; text-align: center; margin-top: 20px; }
        .ttd-space { height: 60px; }
    </style>
</head>
<body>
    <div class="kop">
        <h1>Sistem Informasi Peminjaman Alat</h1>
    </div>

    <h3 style="text-align: center;"><?= $title ?></h3>
    <div class="info-cetak">Dicetak oleh: <?= $petugas ?> | <?= $tanggal_cetak ?></div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">ID Pinjam</th>
                <th width="20%">Peminjam</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th width="15%">Denda</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; $grandTotal = 0; foreach($data_laporan as $d): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td class="text-center"><?= $d['id_peminjaman'] ?></td>
                <td><?= $d['nama_peminjam'] ?></td>
                <td class="text-center"><?= date('d/m/Y', strtotime($d['tanggal_pinjam'])) ?></td>
                <td class="text-center"><?= $d['tanggal_kembali'] ? date('d/m/Y', strtotime($d['tanggal_kembali'])) : '-' ?></td>
                <td class="text-center"><?= strtoupper($d['status_pinjam']) ?></td>
                <td class="text-right">Rp <?= number_format($d['denda'] ?? 0, 0, ',', '.') ?></td>
            </tr>
            <?php $grandTotal += ($d['denda'] ?? 0); endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="background-color: #f9f9f9; font-weight: bold;">
                <td colspan="6" class="text-right">TOTAL DENDA KESELURUHAN</td>
                <td class="text-right">Rp <?= number_format($grandTotal, 0, ',', '.') ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="ttd-container">
        <p>Dicetak pada, <?= date('d F Y') ?></p>
        <p>Petugas Perpustakaan,</p>
        <div class="ttd-space"></div>
        <p><strong>( <?= $petugas ?> )</strong></p>
    </div>
</body>
</html>