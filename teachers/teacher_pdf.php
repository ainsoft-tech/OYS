<?php

require_once __DIR__ . '/../vendor/autoload.php'; // dompdf autoload
include '../config/oys_vt.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("SELECT * FROM teachers WHERE id = ?");
$stmt->execute([$id]);
$teacher = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$teacher) {
    die("Öğretmen bulunamadı.");
}

// Fotoğraf yolu (varsa)
$imgHtml = '';
if (!empty($teacher['photo'])) {
    $photoPath = realpath(__DIR__ . '/uploads/' . $teacher['photo']);
    if ($photoPath && file_exists($photoPath)) {
        $imgSrc = 'data:image/' . pathinfo($photoPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($photoPath));
        $imgHtml = '<div style="text-align:center; margin-bottom:24px;">
            <img src="' . $imgSrc . '" style="width:120px; height:120px; object-fit:cover; border-radius:50%; border:3px solid #3b82f6; box-shadow:0 4px 16px #0002;" />
        </div>';
    }
}

$html = '
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: DejaVu Sans, Arial, sans-serif; background: #f3f4f6; color: #222; }
    .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 18px; box-shadow: 0 4px 24px #0001; padding: 32px 24px; }
    h2 { color: #2563eb; font-size: 2rem; font-weight: bold; text-align: center; margin-bottom: 16px; }
    table { width: 100%; border-collapse: collapse; margin-top: 12px; }
    td { padding: 8px 6px; font-size: 1rem; border-bottom: 1px solid #e5e7eb; }
    tr:last-child td { border-bottom: none; }
    td:first-child { color: #555; font-weight: 600; width: 160px; }
    td:last-child { color: #222; }
</style>
</head>
<body>
<div class="container">
    ' . $imgHtml . '
    <h2>Öğretmen Bilgileri</h2>
    <table>
        <tr><td>Ad Soyad:</td><td>' . htmlspecialchars($teacher["full_name"] ?? '') . '</td></tr>
        <tr><td>TC Kimlik No:</td><td>' . htmlspecialchars($teacher["tc_no"] ?? '') . '</td></tr>
        <tr><td>Kullanıcı Adı:</td><td>' . htmlspecialchars($teacher["username"] ?? '') . '</td></tr>
        <tr><td>E-posta:</td><td>' . htmlspecialchars($teacher["email"] ?? '') . '</td></tr>
        <tr><td>Telefon:</td><td>' . htmlspecialchars($teacher["phone"] ?? '') . '</td></tr>
        <tr><td>Branş:</td><td>' . htmlspecialchars($teacher["branch"] ?? '') . '</td></tr>
        <tr><td>Maaş:</td><td>' . htmlspecialchars($teacher["salary"] ?? '') . '</td></tr>
        <tr><td>Adres:</td><td>' . htmlspecialchars($teacher["address"] ?? '') . '</td></tr>
        <tr><td>Cinsiyet:</td><td>' . htmlspecialchars($teacher["gender"] ?? '') . '</td></tr>
        <tr><td>Medeni Durum:</td><td>' . htmlspecialchars($teacher["marital_status"] ?? '') . '</td></tr>
        <tr><td>Doğum Yeri:</td><td>' . htmlspecialchars($teacher["birth_place"] ?? '') . '</td></tr>
        <tr><td>Doğum Tarihi:</td><td>' . htmlspecialchars($teacher["birth_date"] ?? '') . '</td></tr>
        <tr><td>Çocuk Sayısı:</td><td>' . htmlspecialchars($teacher["children_count"] ?? '') . '</td></tr>
        <tr><td>Eğitim Durumu:</td><td>' . htmlspecialchars($teacher["education_status"] ?? '') . '</td></tr>
        <tr><td>Başlama Tarihi:</td><td>' . htmlspecialchars($teacher["start_date"] ?? '') . '</td></tr>
    </table>
</div>
</body>
</html>
';

// Dompdf ayarları
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'DejaVu Sans'); // Türkçe karakter desteği için
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('ogretmen_bilgileri.pdf', ['Attachment' => false]);
exit;