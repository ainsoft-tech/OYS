<?php
// filepath: c:\laragon\www\school_management_system\lessons\lesson_detail.php
require_once '../partials/header.php';
include '../config/oys_vt.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("SELECT l.*, t.full_name AS ogretmen FROM lessons l LEFT JOIN teachers t ON l.teacher_id = t.id WHERE l.id = ?");
$stmt->execute([$id]);
$lesson = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$lesson) {
    echo "<div class='p-8 text-center text-red-600'>Ders bulunamadı.</div>";
    require_once "../partials/footer.php";
    exit;
}
?>
<div class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-8 mt-8">
    <h2 class="text-2xl font-bold mb-4">Ders Detayı</h2>
    <table class="w-full">
        <tr><td class="font-semibold py-1">Ders Kodu:</td><td><?= htmlspecialchars($lesson['ders_kodu']) ?></td></tr>
        <tr><td class="font-semibold py-1">Ders Adı:</td><td><?= htmlspecialchars($lesson['ders_adi']) ?></td></tr>
        <tr><td class="font-semibold py-1">Öğretmen:</td><td><?= htmlspecialchars($lesson['ogretmen'] ?? '-') ?></td></tr>
        <tr><td class="font-semibold py-1">Haftalık Ders Saati:</td><td><?= htmlspecialchars($lesson['haftalik_ders_saati']) ?></td></tr>
        <tr><td class="font-semibold py-1">Ders Saati:</td><td><?= htmlspecialchars($lesson['ders_saati']) ?></td></tr>
        <tr><td class="font-semibold py-1">Gün :</td><td><?= htmlspecialchars($lesson['gun']) ?></td></tr>
        <tr><td class="font-semibold py-1">Durum:</td><td><?= $lesson['status'] ? 'Aktif' : 'Pasif' ?></td></tr>
        <tr><td class="font-semibold py-1">Oluşturulma:</td><td><?= htmlspecialchars($lesson['created_at'] ?? '') ?></td></tr>
        <tr><td class="font-semibold py-1">Güncellenme:</td><td><?= htmlspecialchars($lesson['updated_at'] ?? '') ?></td></tr>
        <tr><td class="font-semibold py-1">Ekleyen (ID):</td><td><?= htmlspecialchars($lesson['created_by'] ?? '') ?></td></tr>
    </table>
    <div class="mt-6 flex gap-2">
        <a href="lessons.php" class="px-5 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold transition">Geri</a>
        <a href="lesson_edit.php?id=<?= $lesson['id'] ?>" class="px-5 py-2 rounded-lg bg-blue-600 text-white font-bold hover:bg-blue-700 transition">Düzenle</a>
    </div>
</div>
<?php require_once "../partials/footer.php"; ?>