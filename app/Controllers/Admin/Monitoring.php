<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MonitoringModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Monitoring extends BaseController
{
    public function index()
    {
        $model = new MonitoringModel();
        $data['monitoring'] = $model->getAllMonitoringData();

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Admin mengakses halaman monitoring',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

        return view('admin/monitoring/index', $data);
    }

    public function pdf()
    {
        $model = new MonitoringModel();
        $data = [
            'title'         => 'LAPORAN MONITORING PEMINJAMAN TERPADU',
            'monitoring'    => $model->getAllMonitoringData(),
            'tanggal_cetak' => date('d F Y H:i'),
            'admin'         => session()->get('nama') ?? 'Administrator'
        ];

        $html = view('admin/monitoring/cetak_pdf', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        $dompdf->stream("Monitoring_" . date('Ymd') . ".pdf", ["Attachment" => false]);

        // LOG
        $logModel = new \App\Models\LogAktivitasModel();
        $logModel->insert([
            'id_user' => session()->get('id_user'),
            'aktivitas' => 'Admin mencetak laporan monitoring (PDF)',
            'tanggal' => date('Y-m-d H:i:s')
        ]);

    }

    public function excel()
{
    $model = new MonitoringModel();
    $monitoring = $model->getAllMonitoringData();
    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // 1. Judul Laporan
    $sheet->setCellValue('A1', 'LAPORAN MONITORING PEMINJAMAN & PENGEMBALIAN ALAT');
    $sheet->mergeCells('A1:H1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $sheet->setCellValue('A2', 'Tanggal Cetak: ' . date('d F Y H:i'));
    $sheet->mergeCells('A2:H2');
    $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // 2. Header Tabel
    $headers = ['No', 'Nama Peminjam', 'Alat', 'Qty', 'Status Transaksi', 'Disetujui Oleh', 'Denda', 'Diterima Oleh'];
    $column = 'A';
    foreach ($headers as $h) {
        $sheet->setCellValue($column . '4', $h);
        // Styling Header
        $sheet->getStyle($column . '4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4']
            ],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ]);
        $column++;
    }

    // 3. Isi Data
    $row = 5;
    $grandTotalDenda = 0;
    foreach ($monitoring as $key => $m) {
        $peminjam = $m['id_user'] ? $m['nama_user_akun'] : $m['nama_peminjam_manual'];
        
        // Logika Status untuk Excel
        if (strtolower($m['status']) == 'ditolak') {
            $status = 'DITOLAK';
        } elseif ($m['status_pengembalian'] == 'selesai') {
            $status = 'SELESAI / KEMBALI';
        } else {
            $status = strtoupper($m['status']);
        }

        $sheet->setCellValue('A' . $row, $key + 1);
        $sheet->setCellValue('B' . $row, $peminjam);
        $sheet->setCellValue('C' . $row, $m['nama_alat']);
        $sheet->setCellValue('D' . $row, $m['jumlah_detail']);
        $sheet->setCellValue('E' . $row, $status);
        $sheet->setCellValue('F' . $row, $m['nama_penyetuju'] ?? '-');
        $sheet->setCellValue('G' . $row, $m['denda'] ?? 0);
        $sheet->setCellValue('H' . $row, $m['nama_penerima'] ?? '-');

        // Format Angka Denda
        $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
        
        $grandTotalDenda += ($m['denda'] ?? 0);
        $row++;
    }

    // 4. Footer Total
    $lastRow = $row - 1;
    $sheet->setCellValue('A' . $row, 'TOTAL DENDA KESELURUHAN');
    $sheet->mergeCells('A' . $row . ':F' . $row);
    $sheet->setCellValue('G' . $row, $grandTotalDenda);
    $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0');
    
    // Bold footer
    $sheet->getStyle('A' . $row . ':H' . $row)->getFont()->setBold(true);

    // 5. Styling Border untuk seluruh tabel
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
    ];
    $sheet->getStyle('A4:H' . $row)->applyFromArray($styleArray);

    // 6. Auto-size kolom agar rapi
    foreach (range('A', 'H') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // 7. Proses Download
    $filename = "Monitoring_Terpadu_" . date('Ymd_His') . ".xlsx";
    $writer = new Xlsx($spreadsheet);
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    
    $writer->save('php://output');
    exit;

    // LOG
    $logModel = new \App\Models\LogAktivitasModel();
    $logModel->insert([
        'id_user' => session()->get('id_user'),
        'aktivitas' => 'Admin mencetak laporan monitoring (Excel)',
        'tanggal' => date('Y-m-d H:i:s')
    ]);

}
}