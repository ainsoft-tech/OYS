<?php
require_once __DIR__ . '/../vendor/autoload.php'; // PhpSpreadsheet autoload
include '../config/oys_vt.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Tüm dersleri ve öğretmen adlarını çek
$stmt = $pdo->query("
    SELECT l.id, l.ders_kodu, l.ders_adi, t.full_name AS ogretmen, l.haftalik_ders_saati, l.status, l.created_at, l.updated_at, l.created_by
    FROM lessons l
    LEFT JOIN teachers t ON l.teacher_id = t.id
    ORDER BY l.id DESC
");
$lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Excel dosyası oluştur
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Başlıklar
$headers = [
    '#', 'Ders Kodu', 'Ders Adı', 'Öğretmen', 'Haftalık Ders Saati', 'Durum', 'Oluşturulma', 'Güncellenme', 'Ekleyen'
];
$sheet->fromArray($headers, null, 'A1');

// Satırları ekle
$row = 2;
foreach ($lessons as $l) {
    $sheet->fromArray([
        $l['id'],
        $l['ders_kodu'],
        $l['ders_adi'],
        $l['ogretmen'] ?? '-',
        $l['haftalik_ders_saati'],
        $l['status'] ? 'Aktif' : 'Pasif',
        $l['created_at'],
        $l['updated_at'],
        $l['created_by']
    ], null, 'A' . $row++);
}

// Otomatik sütun genişliği
foreach (range('A', $sheet->getHighestColumn()) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Dosyayı indir
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="dersler_listesi.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;