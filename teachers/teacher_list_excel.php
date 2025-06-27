<?php
require_once __DIR__ . '/../vendor/autoload.php'; // PhpSpreadsheet autoload

include '../config/oys_vt.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Tüm öğretmenleri çek
$stmt = $pdo->query("SELECT * FROM teachers ORDER BY full_name ASC");
$teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Excel dosyası oluştur
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Başlıklar
$headers = [
    'ID', 'Ad Soyad', 'TC Kimlik No', 'Kullanıcı Adı', 'E-posta', 'Telefon', 'Branş', 'Maaş',
    'Adres', 'Cinsiyet', 'Medeni Durum', 'Doğum Yeri', 'Doğum Tarihi', 'Çocuk Sayısı',
    'Eğitim Durumu', 'Başlama Tarihi', 'Fotoğraf', 'Oluşturulma', 'Güncellenme'
];
$sheet->fromArray($headers, null, 'A1');

// Satırları ekle
$row = 2;
foreach ($teachers as $t) {
    $sheet->fromArray([
        $t['id'],
        $t['full_name'],
        $t['tc_no'],
        $t['username'],
        $t['email'],
        $t['phone'],
        $t['branch'],
        $t['salary'],
        $t['address'],
        $t['gender'],
        $t['marital_status'],
        $t['birth_place'],
        $t['birth_date'],
        $t['children_count'],
        $t['education_status'],
        $t['start_date'],
        $t['photo'],
        $t['created_at'] ?? '',
        $t['updated_at'] ?? ''
    ], null, 'A' . $row++);
}

// Otomatik sütun genişliği
foreach (range('A', $sheet->getHighestColumn()) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Dosyayı indir
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ogretmenler_listesi.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;