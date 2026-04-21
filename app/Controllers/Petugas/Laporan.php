<?php

namespace App\Controllers\Petugas;

use App\Controllers\BaseController;
use App\Models\LogAktivitasModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends BaseController
{
    /**
     * Helper untuk mengambil data laporan secara konsisten
     * Digunakan oleh index, pdf, dan excel
     */
    private function getLaporanData()
    {
        $db = \Config\Database::connect();
        
        // Gunakan Query Builder untuk kontrol JOIN yang lebih baik
        $data = $db->table('peminjaman')
            ->select('
                peminjaman.*, 
                peminjaman.status as status_pinjam, 
                peminjaman.nama_peminjam_manual,
                users.nama as nama_user, 
                pengembalian.tanggal_kembali, 
                pengembalian.denda, 
                pengembalian.status_denda
            ')
            ->join('users', 'users.id_user = peminjaman.id_user', 'left')
            ->join('pengembalian', 'pengembalian.id_peminjaman = peminjaman.id_peminjaman', 'left')
            ->where('peminjaman.status !=', 'ditolak')
            // KUNCI: Menghindari duplikasi jika ada multiple join di tabel lain
            ->groupBy('peminjaman.id_peminjaman') 
            ->orderBy('peminjaman.tanggal_pinjam', 'DESC')
            ->get()
            ->getResultArray();

        // Olah data nama (User Akun vs Input Manual)
        foreach ($data as &$d) {
            $d['nama_peminjam'] = (!empty($d['nama_user'])) ? $d['nama_user'] : ($d['nama_peminjam_manual'] ?? 'Tamu');
        }

        return $data;
    }

    public function index()
    {
        $dataLaporan = $this->getLaporanData();

        // Hitung Ringkasan Statistik
        $total_peminjaman = count($dataLaporan);
        $total_pengembalian = 0;
        $total_denda = 0;
        $total_denda_lunas = 0;

        foreach ($dataLaporan as $d) {
            $denda = $d['denda'] ?? 0;
            
            if (!empty($d['tanggal_kembali'])) {
                $total_pengembalian++;
            }

            $total_denda += $denda;

            if ($denda > 0 && ($d['status_denda'] ?? '') == 'sudah_bayar') {
                $total_denda_lunas += $denda;
            }
        }

        // Log Aktivitas
        $logModel = new LogAktivitasModel();
        $logModel->insert([
            'id_user'   => session()->get('id_user'),
            'aktivitas' => 'Mengakses halaman laporan utama',
            'tanggal'   => date('Y-m-d H:i:s')
        ]);

        return view('petugas/laporan/index', [
            'data_laporan'       => $dataLaporan,
            'total_peminjaman'   => $total_peminjaman,
            'total_pengembalian' => $total_pengembalian,
            'total_denda'        => $total_denda,
            'total_denda_lunas'  => $total_denda_lunas
        ]);
    }

    public function pdf()
    {
        $dataLaporan = $this->getLaporanData();

        $data = [
            'title'         => 'LAPORAN AKTIVITAS PEMINJAMAN ALAT',
            'data_laporan'  => $dataLaporan,
            'tanggal_cetak' => date('d F Y H:i'),
            'petugas'       => session()->get('nama') ?? 'Petugas Laboratorium' 
        ];

        $html = view('petugas/laporan/cetak_pdf', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        $dompdf->stream("Laporan_" . date('Ymd') . ".pdf", ["Attachment" => false]);

        // Log Aktivitas
        $logModel = new LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Mencetak laporan PDF',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

    }

    public function excel()
{
    $dataLaporan = $this->getLaporanData(); 
    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // 1. SET JUDUL BESAR
    $sheet->setCellValue('A1', 'LAPORAN SISTEM PEMINJAMAN ALAT');
    $sheet->mergeCells('A1:G1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $sheet->setCellValue('A2', 'Tanggal Unduh: ' . date('d/m/Y H:i'));
    $sheet->mergeCells('A2:G2');
    $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // 2. HEADER TABEL
    $columnRow = 4;
    $headers = ['No', 'ID Pinjam', 'Nama Peminjam', 'Tgl Pinjam', 'Tgl Kembali', 'Status', 'Denda'];
    $columnLetter = 'A';
    
    foreach ($headers as $h) {
        $sheet->setCellValue($columnLetter . $columnRow, $h);
        $columnLetter++;
    }

    // Styling Header
    $headerStyle = [
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => '4472C4'], // Warna Biru Profesional
        ],
    ];
    $sheet->getStyle('A4:G4')->applyFromArray($headerStyle);
    $sheet->getRowDimension('4')->setRowHeight(25); // Tinggi header

    // 3. ISI DATA
    $row = 5;
    $startDataRow = 5;
    $grandTotalDenda = 0;
    
    foreach ($dataLaporan as $key => $d) {
        $currentDenda = $d['denda'] ?? 0;
        
        $sheet->setCellValue('A' . $row, $key + 1);
        $sheet->setCellValue('B' . $row, $d['id_peminjaman']);
        $sheet->setCellValue('C' . $row, $d['nama_peminjam']); 
        $sheet->setCellValue('D' . $row, date('d/m/Y', strtotime($d['tanggal_pinjam'])));
        $sheet->setCellValue('E' . $row, $d['tanggal_kembali'] ? date('d/m/Y', strtotime($d['tanggal_kembali'])) : '-');
        $sheet->setCellValue('F' . $row, strtoupper($d['status_pinjam']));
        $sheet->setCellValue('G' . $row, $currentDenda);
        
        // Alignment tengah untuk kolom tertentu
        $sheet->getStyle('A'.$row.':B'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D'.$row.':F'.$row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        // Format Rupiah/Angka untuk Denda
        $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
        
        $grandTotalDenda += $currentDenda;
        $row++;
    }

    // 4. FOOTER TOTAL
    $sheet->setCellValue('A' . $row, 'TOTAL DENDA KESELURUHAN');
    $sheet->mergeCells('A' . $row . ':F' . $row);
    $sheet->setCellValue('G' . $row, $grandTotalDenda);

    // Styling Footer
    $footerStyle = [
        'font' => ['bold' => true],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'E9EBF5'],
        ],
    ];
    $sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray($footerStyle);
    $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('Rp #,##0');
    $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

    // 5. GARIS BORDER UNTUK SELURUH TABEL
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ];
    $sheet->getStyle('A4:G' . $row)->applyFromArray($styleArray);

    // 6. AUTO SIZE COLUMN (Agar lebar kolom menyesuaikan isi)
    foreach (range('A', 'G') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // 7. OUTPUT
    $filename = "Laporan_Peminjaman_" . date('Ymd_His') . ".xlsx";
    $writer = new Xlsx($spreadsheet);
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    
    $writer->save('php://output');
    exit;

    // Log Aktivitas
    $logModel = new LogAktivitasModel();
    $logModel->insert([
        'id_user' => session()->get('id_user'),
        'aktivitas' => 'Mencetak laporan Excel',
        'tanggal' => date('Y-m-d H:i:s')
    ]);

}
}