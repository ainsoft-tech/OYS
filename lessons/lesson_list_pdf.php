<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Dompdf autoload
include '../config/oys_vt.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Tüm dersleri ve öğretmen adlarını çek
$stmt = $pdo->query("
    SELECT l.id, l.ders_kodu, l.ders_adi, t.full_name AS ogretmen, l.haftalik_ders_saati, l.status, l.created_at, l.updated_at, l.created_by
    FROM lessons l
    LEFT JOIN teachers t ON l.teacher_id = t.id
    ORDER BY l.id DESC
");
$lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);

// HTML oluştur
$html = '
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: DejaVu Sans, Arial, sans-serif; background: #fff; color: #222; }
    h2 { color:rgb(158, 4, 125); font-size: 1.7rem; font-weight: bold; text-align: center; margin-bottom: 18px; }
    table { width: 100%; border-collapse: collapse; font-size: 0.95rem; }
    th, td { border: 1px solid #e5e7eb; padding: 8px 6px; }
    th { background: #f1f5f9; color: #2563eb; font-weight: 700; }
    tr:nth-child(even) { background: #f9fafb; }
</style>
</head>
<body>
    <h2>Dersler Listesi</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Ders Kodu</th>
                <th>Ders Adı</th>
                <th>Öğretmen</th>
                <th>Haftalık Ders Saati</th>
                <th>Durum</th>
                <th>Oluşturulma</th>
                <th>Güncellenme</th>
                <th>Ekleyen</th>
            </tr>
        </thead>
        <tbody>';
foreach ($lessons as $i => $l) {
    $html .= '<tr>
        <td>' . htmlspecialchars($l['id']) . '</td>
        <td>' . htmlspecialchars($l['ders_kodu']) . '</td>
        <td>' . htmlspecialchars($l['ders_adi']) . '</td>
        <td>' . htmlspecialchars($l['ogretmen'] ?? '-') . '</td>
        <td>' . htmlspecialchars($l['haftalik_ders_saati']) . '</td>
        <td>' . ($l['status'] ? 'Aktif' : 'Pasif') . '</td>
        <td>' . htmlspecialchars($l['created_at'] ?? '') . '</td>
        <td>' . htmlspecialchars($l['updated_at'] ?? '') . '</td>
        <td>' . htmlspecialchars($l['created_by'] ?? '') . '</td>
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
$dompdf->setPaper('A4', 'landscape'); // Yatay A4
$dompdf->render();
$dompdf->stream('dersler_listesi.pdf', ['Attachment' => false]);
exit;