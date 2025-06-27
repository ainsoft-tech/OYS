<?php
header('Content-Type: application/json');
include_once '../config/oys_vt.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $dersler = $pdo->query("SELECT id, ders_adi, ders_saati FROM lessons")->fetchAll(PDO::FETCH_ASSOC);
    $teachers = $pdo->query("SELECT id, full_name FROM teachers")->fetchAll(PDO::FETCH_ASSOC);
    $siniflar = $pdo->query("SELECT id, sinif_adi FROM siniflar")->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['dersler' => $dersler, 'teachers' => $teachers, 'siniflar' => $siniflar]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ders_id = intval($_POST['ders_id'] ?? 0);
    $ders_adi_id = intval($_POST['ders_adi_id'] ?? 0);
    $teacher_id = intval($_POST['teacher_id'] ?? 0);
    $sinif_id = intval($_POST['sinif_id'] ?? 0);
    $gun = trim($_POST['gun'] ?? '');
    $ders_saati = trim($_POST['ders_saati'] ?? '');
    $haftalik_ders_saati = intval($_POST['haftalik_ders_saati'] ?? 0);
    $duration = trim($_POST['duration'] ?? '');
    $classroom = trim($_POST['classroom'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $created_by = 1; // Giriş yapan kullanıcı id'si ile değiştirin
    $status = 'aktif';

    if ($ders_id && $ders_adi_id && $teacher_id && $sinif_id && $gun && $ders_saati && $haftalik_ders_saati) {
        try {
            $stmt = $pdo->prepare("INSERT INTO timetable 
                (ders_id, ders_adi_id, teacher_id, sinif_id, gun, ders_saati, haftalik_ders_saati, status, created_by, duration, classroom, description) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $ok = $stmt->execute([
                $ders_id, $ders_adi_id, $teacher_id, $sinif_id, $gun, $ders_saati, $haftalik_ders_saati, $status, $created_by, $duration, $classroom, $description
            ]);
            if ($ok) {
                echo json_encode(['success' => true]);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => 'Kayıt eklenemedi.']);
                exit;
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Tüm alanları doldurun.']);
        exit;
    }
}
echo json_encode(['success' => false, 'message' => 'Geçersiz istek.']);
exit;