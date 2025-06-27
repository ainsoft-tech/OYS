<?php
// filepath: c:\laragon\www\school_management_system\lessons\lesson_edit.php
require_once '../partials/header.php';
include '../config/oys_vt.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("SELECT * FROM lessons WHERE id = ?");
$stmt->execute([$id]);
$lesson = $stmt->fetch(PDO::FETCH_ASSOC);

$teachers = $pdo->query("SELECT id, full_name FROM teachers ORDER BY full_name ASC")->fetchAll(PDO::FETCH_ASSOC);

if (!$lesson) {
    echo "<div class='p-8 text-center text-red-600'>Ders bulunamadı.</div>";
    require_once "../partials/footer.php";
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ders_kodu = trim($_POST['ders_kodu']);
    $ders_adi = trim($_POST['ders_adi']);
    $teacher_id = intval($_POST['teacher_id']);
    $haftalik_ders_saati = intval($_POST['haftalik_ders_saati']);
    $status = isset($_POST['status']) ? 1 : 0;

    if ($ders_kodu && $ders_adi && $teacher_id && $haftalik_ders_saati) {
        $stmt = $pdo->prepare("UPDATE lessons SET ders_kodu=?, ders_adi=?, teacher_id=?, haftalik_ders_saati=?, status=? WHERE id=?");
        $ok = $stmt->execute([$ders_kodu, $ders_adi, $teacher_id, $haftalik_ders_saati, $status, $id]);
        if ($ok) {
            header("Location: lessons.php");
            exit;
        } else {
            $error = "Güncelleme başarısız.";
        }
    } else {
        $error = "Tüm alanları doldurunuz.";
    }
}
?>
<div class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-8 mt-8">
    <h2 class="text-2xl font-bold mb-4">Ders Düzenle</h2>
    <?php if ($error): ?>
        <div class="mb-4 text-red-600"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <label class="block mb-2">Ders Kodu</label>
        <input type="text" name="ders_kodu" value="<?= htmlspecialchars($lesson['ders_kodu']) ?>" class="form-input w-full mb-4" required>
        <label class="block mb-2">Ders Adı</label>
        <input type="text" name="ders_adi" value="<?= htmlspecialchars($lesson['ders_adi']) ?>" class="form-input w-full mb-4" required>
        <label class="block mb-2">Öğretmen</label>
        <select name="teacher_id" class="form-input w-full mb-4" required>
            <option value="">Öğretmen Seç</option>
            <?php foreach ($teachers as $t): ?>
                <option value="<?= $t['id'] ?>" <?= $lesson['teacher_id'] == $t['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t['full_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label class="block mb-2">Haftalık Ders Saati</label>
        <input type="number" name="haftalik_ders_saati" value="<?= htmlspecialchars($lesson['haftalik_ders_saati']) ?>" min="1" max="40" class="form-input w-full mb-4" required>
        <label class="block mb-2">Durum</label>
        <select name="status" class="form-input w-full mb-4">
            <option value="1" <?= $lesson['status'] ? 'selected' : '' ?>>Aktif</option>
            <option value="0" <?= !$lesson['status'] ? 'selected' : '' ?>>Pasif</option>
        </select>
        <div class="flex gap-2 mt-6">
            <button type="submit" class="px-5 py-2 rounded-lg bg-blue-600 text-white font-bold hover:bg-blue-700 transition">Kaydet</button>
            <a href="lessons.php" class="px-5 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold transition">İptal</a>
        </div>
    </form>
</div>
<?php require_once "../partials/footer.php"; ?>