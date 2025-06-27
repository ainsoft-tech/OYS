<?php
include '../../config/oys_vt.php';

$stmt = $pdo->query("
    SELECT 
        t.id,
        l.ders_adi,
        t.lesson_day AS gun,
        t.lesson_time AS saat,
        s.sinif_adi,
        tc.full_name AS ogretmen_ad
    FROM timetable t
    LEFT JOIN lessons l ON t.lesson_id = l.id
    LEFT JOIN siniflar s ON t.class_id = s.id
    LEFT JOIN teachers tc ON t.teacher_id = tc.id
    ORDER BY FIELD(t.lesson_day, 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma')");
$dersler = $stmt->fetchAll(PDO::FETCH_ASSOC);

$html = "";
foreach ($dersler as $ders) {
    $html .= "<tr class='hover:bg-gray-50'>
                <td class='px-6 py-4 whitespace-nowrap'>{$ders['saat']}</td>
                <td class='px-6 py-4 whitespace-nowrap'>{$ders['ders_adi']}</td>
                <td class='px-6 py-4 whitespace-nowrap'>{$ders['sinif_adi']}</td>
                <td class='px-6 py-4 whitespace-nowrap'>{$ders['ogretmen_ad']}</td>
              </tr>";
}

echo json_encode(['html' => $html]);