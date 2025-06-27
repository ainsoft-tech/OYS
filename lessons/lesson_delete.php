<?php
// filepath: c:\laragon\www\school_management_system\lessons\lesson_delete.php
include '../config/oys_vt.php';

header('Content-Type: application/json');
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM lessons WHERE id = ?");
    $ok = $stmt->execute([$id]);
    if ($ok) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Silme başarısız.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz ID.']);
}
exit;