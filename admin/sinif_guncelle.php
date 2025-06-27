<?php
// filepath: c:\laragon\www\school_management_system\admin\sinif_guncelle.php
require_once '../config/oys_vt.php';
$id = intval($_POST['id'] ?? 0);
$sinif_kodu = trim($_POST['sinif_kodu'] ?? '');
$sinif_adi = trim($_POST['sinif_adi'] ?? '');
$ogretmen_id = $_POST['ogretmen_id'] ?: NULL;

if ($id && $sinif_kodu && $sinif_adi) {
    $stmt = $pdo->prepare("UPDATE siniflar SET sinif_kodu=?, sinif_adi=?, ogretmen_id=? WHERE id=?");
    $ok = $stmt->execute([$sinif_kodu, $sinif_adi, $ogretmen_id, $id]);
    if ($ok) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Güncelleme başarısız.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Tüm alanları doldurun.']);
}