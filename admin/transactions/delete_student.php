<?php
include '../../config/oys_vt.php';
$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
$stmt->execute([$id]);

echo json_encode(['success' => true, 'message' => 'Silindi']);