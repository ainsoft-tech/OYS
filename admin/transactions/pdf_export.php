<?php
require '../../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

include '../../config/oys_vt.php';

// Eğer id parametresi varsa, tek öğrenci PDF'i üret

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) die("Öğrenci bulunamadı");

    // Fotoğraf yolu (örnek: uploads klasörü)
    $photoPath = !empty($student['photo']) ? "../uploads/{$student['photo']}" : "";
    $photoHtml = "";
    if ($photoPath && file_exists($photoPath)) {
        // Fotoğrafı base64 olarak ekle
        $imgData = base64_encode(file_get_contents($photoPath));
        $src = 'data:image/' . pathinfo($photoPath, PATHINFO_EXTENSION) . ';base64,' . $imgData;
        $photoHtml = "<div style='text-align:center;'><img src='$src' alt='Fotoğraf' style='width:175px;height:200px;object-fit:cover;border-radius:8px;border:1px solid #ccc;display:inline-block;margin-bottom:20px;'></div>";
    }
    $html = "<html><head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width:100%; border-collapse:collapse; margin-top:1rem; }
        td, th { padding:8px; border:1px solid #ccc; }
        th { background:#f3f4f6; }
    </style>
    </head><body>
    <h2 style='text-align:center;'>Öğrenci Bilgileri</h2>
    $photoHtml
    <table>
    
<tr><th>Alan</th><th>Değer</th></tr>";
$html .= "<tr><td>ID</td><td>" . htmlspecialchars($student['id']) . "</td></tr>";
$html .= "<tr><td>Ad Soyad</td><td>" . htmlspecialchars($student['full_name']) . "</td></tr>";
$html .= "<tr><td>TC Kimlik</td><td>" . htmlspecialchars($student['tc_no']) . "</td></tr>";
$html .= "<tr><td>Sınıf</td><td>" . htmlspecialchars($student['class']) . "</td></tr>";
$html .= "<tr><td>Numara</td><td>" . htmlspecialchars($student['school_number']) . "</td></tr>";
$html .= "<tr><td>Doğum Tarihi</td><td>" . htmlspecialchars($student['birth_date']) . "</td></tr>";
$html .= "<tr><td>Doğum Yeri</td><td>" . htmlspecialchars($student['birth_place']) . "</td></tr>";
$html .= "<tr><td>Cinsiyet</td><td>" . htmlspecialchars($student['gender']) . "</td></tr>";
$html .= "<tr><td>Şube</td><td>" . htmlspecialchars($student['lesson_room']) . "</td></tr>";
$html .= "<tr><td>E-posta</td><td>" . htmlspecialchars($student['email']) . "</td></tr>";
$html .= "<tr><td>Telefon</td><td>" . htmlspecialchars($student['phone']) . "</td></tr>";
$html .= "<tr><td>Veli Adı</td><td>" . htmlspecialchars($student['parent_name']) . "</td></tr>";
$html .= "<tr><td>Veli Telefonu</td><td>" . htmlspecialchars($student['parent_phone']) . "</td></tr>";
$html .= "<tr><td>Adres</td><td>" . htmlspecialchars($student['address']) . "</td></tr>";
$html .= "<tr><td>Eğitim Dönemi</td><td>" . htmlspecialchars($student['education_period']) . "</td></tr>";
$html .= "<tr><td>Kayıt Tarihi</td><td>" . htmlspecialchars($student['registration_date']) . "</td></tr>";
$html .= "<tr><td>Durum</td><td>" . htmlspecialchars($student['status']) . "</td></tr>";
    $html .= "</table></body></html>";

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html, 'UTF-8');
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("ogrenci_{$id}.pdf", ['Attachment' => false]);
    exit;
}

// ...yukarıdaki koddan sonra...
// id parametresi yoksa, tüm liste PDF'i üret
$stmt = $pdo->query("SELECT id, full_name, tc_no, class, phone FROM students ORDER BY id ASC");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

$html = "<html><head>
<style>
    body { font-family: DejaVu Sans, sans-serif; }
    table { width:100%; border-collapse:collapse; margin-top:1rem; }
    th, td { padding:8px; border:1px solid #ccc; }
    th { background:#f3f4f6; }
</style>
</head><body>
<h2>Öğrenci Listesi</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Ad Soyad</th>
            <th>TC Kimlik</th>
            <th>Sınıf</th>
            <th>Telefon</th>
        </tr>
    </thead>
    <tbody>";
foreach ($students as $student) {
    $html .= "<tr>
        <td>{$student['id']}</td>
        <td>{$student['full_name']}</td>
        <td>{$student['tc_no']}</td>
        <td>{$student['class']}</td>
        <td>{$student['phone']}</td>
    </tr>";
}
$html .= "</tbody></table></body></html>";

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("ogrenci_listesi.pdf", ['Attachment' => false]);
exit;