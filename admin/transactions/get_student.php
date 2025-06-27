<?php
include '../../config/oys_vt.php';
$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($student);