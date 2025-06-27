<?php
// filepath: c:\laragon\www\school_management_system\admin\sinif_getir.php
require_once '../config/oys_vt.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("SELECT * FROM siniflar WHERE id = ?");
$stmt->execute([$id]);
$sinif = $stmt->fetch(PDO::FETCH_ASSOC);
if ($sinif) {
    echo json_encode(['success' => true, 'sinif' => $sinif]);
} else {
    echo json_encode(['success' => false]);
}