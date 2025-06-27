<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Dompdf autoload
include '../config/oys_vt.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("
    SELECT l.*, t.full_name AS ogretmen
    FROM lessons l
    LEFT JOIN teachers t ON l.teacher_id = t.id
    WHERE l.id = ?
");
$stmt->execute([$id]);
$lesson = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$lesson) {
    die("Ders bulunamadı.");
}

$html = '
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<style>
    body { font-family: DejaVu Sans, Arial, sans-serif; background: #fff; color: #222; }
    .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 18px; padding: 32px 24px; }
    h2 { color: #2563eb; font-size: 2rem; font-weight: bold; text-align: center; margin-bottom: 16px; }
    table { width: 100%; border-collapse: collapse; margin-top: 12px; }
    td { padding: 8px 6px; font-size: 1rem; border-bottom: 1px solid #e5e7eb; }
    tr:last-child td { border-bottom: none; }
    td:first-child { color: #555; font-weight: 600; width: 180px; }
    td:last-child { color: #222; }
</style>
</head>
<body>
<div class="container">
    <h2>Ders Bilgileri</h2>
    <table>
        <tr><td>Ders Kodu:</td><td>' . htmlspecialchars($lesson["ders_kodu"]) . '</td></tr>
        <tr><td>Ders Adı:</td><td>' . htmlspecialchars($lesson["ders_adi"]) . '</td></tr>
        <tr><td>Öğretmen:</td><td>' . htmlspecialchars($lesson["ogretmen"] ?? '-') . '</td></tr>
        <tr><td>Haftalık Ders Saati:</td><td>' . htmlspecialchars($lesson["haftalik_ders_saati"]) . '</td></tr>
        <tr><td>Durum:</td><td>' . ($lesson["status"] ? "Aktif" : "Pasif") . '</td></tr>
        <tr><td>Oluşturulma:</td><td>' . htmlspecialchars($lesson["created_at"] ?? '') . '</td></tr>
        <tr><td>Güncellenme:</td><td>' . htmlspecialchars($lesson["updated_at"] ?? '') . '</td></tr>
        <tr><td>Ekleyen (ID):</td><td>' . htmlspecialchars($lesson["created_by"] ?? '') . '</td></tr>
    </table>
</div>
</body>
</html>
';

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('defaultFont', 'DejaVu Sans');
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('ders_bilgisi.pdf', ['Attachment' => false]);
exit;