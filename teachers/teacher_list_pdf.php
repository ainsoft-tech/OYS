<?php

require_once __DIR__ . '/../vendor/autoload.php'; // dompdf autoload
include '../config/oys_vt.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Tüm öğretmenleri çek
$stmt = $pdo->query("SELECT id, full_name, tc_no, branch, email, phone, start_date FROM teachers ORDER BY full_name ASC");
$teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// HTML oluştur
$html = '
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: DejaVu Sans, Arial, sans-serif; background: #fff; color: #222; }
    h2 { color: #2563eb; font-size: 1.7rem; font-weight: bold; text-align: center; margin-bottom: 18px; }
    table { width: 100%; border-collapse: collapse; font-size: 0.95rem; }
    th, td { border: 1px solid #e5e7eb; padding: 8px 6px; }
    th { background: #f1f5f9; color: #2563eb; font-weight: 700; }
    tr:nth-child(even) { background: #f9fafb; }
</style>
</head>
<body>
    <h2>Öğretmenler Listesi</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Ad Soyad</th>
                <th>TC Kimlik No</th>
                <th>Branş</th>
                <th>E-posta</th>
                <th>Telefon</th>
                <th>Başlama Tarihi</th>
            </tr>
        </thead>
        <tbody>';
foreach ($teachers as $i => $t) {
    $html .= '<tr>
        <td>' . ($i+1) . '</td>
        <td>' . htmlspecialchars($t['full_name'] ?? '') . '</td>
        <td>' . htmlspecialchars($t['tc_no'] ?? '') . '</td>
        <td>' . htmlspecialchars($t['branch'] ?? '') . '</td>
        <td>' . htmlspecialchars($t['email'] ?? '') . '</td>
        <td>' . htmlspecialchars($t['phone'] ?? '') . '</td>
        <td>' . htmlspecialchars($t['start_date'] ?? '') . '</td>
    </tr>';
}
$html .= '
        </tbody>
    </table>
</body>
</html>
';

// Dompdf ayarları
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'DejaVu Sans'); // Türkçe karakter desteği için
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'landscape'); // YATAY A4
$dompdf->render();
$dompdf->stream('ogretmenler_listesi.pdf', ['Attachment' => false]);
exit;