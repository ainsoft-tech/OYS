<?php

require '../../vendor/autoload.php';
include '../../config/oys_vt.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Verileri çek
$stmt = $pdo->query("SELECT id, full_name, tc_no, class, school_number, birth_date, birth_place, gender, lesson_room, email, phone, parent_name, parent_phone, address, education_period, registration_date, status FROM students ORDER BY id ASC");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Excel dosyası oluştur
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Başlıklar
$headers = [
    'ID', 'Ad Soyad', 'TC Kimlik', 'Sınıf', 'Numara', 'Doğum Tarihi', 'Doğum Yeri', 'Cinsiyet',
    'Şube', 'E-posta', 'Telefon', 'Veli Adı', 'Veli Telefonu', 'Adres', 'Eğitim Dönemi', 'Kayıt Tarihi', 'Durum'
];
$sheet->fromArray($headers, NULL, 'A1');

// Veriler
$row = 2;
foreach ($students as $student) {
    $sheet->fromArray(array_values($student), NULL, 'A'.$row);
    $row++;
}

// Dosya çıktısı
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="ogrenci_listesi.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;