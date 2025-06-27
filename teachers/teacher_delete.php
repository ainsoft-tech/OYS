<?php
header('Content-Type: application/json; charset=utf-8');

include '../config/oys_vt.php';

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM teachers WHERE id = ?");
    $ok = $stmt->execute([$id]);
    if ($ok) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Silme işlemi başarısız!']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geçersiz ID!']);
}
exit;