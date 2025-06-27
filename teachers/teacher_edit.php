<?php

require_once "../partials/header.php";
include '../config/oys_vt.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $branch = $_POST['branch'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $stmt = $pdo->prepare("UPDATE teachers SET full_name=?, branch=?, email=?, phone=?, address=? WHERE id=?");
    $ok = $stmt->execute([$full_name, $branch, $email, $phone, $address, $id]);
    if ($ok) {
        header("Location: teachers.php");
        exit;
    } else {
        $error = "Güncelleme başarısız!";
    }
}

// Mevcut veriyi çek
$stmt = $pdo->prepare("SELECT * FROM teachers WHERE id = ?");
$stmt->execute([$id]);
$teacher = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$teacher) {
    echo "<div class='p-8 text-center text-red-600'>Öğretmen bulunamadı.</div>";
    require_once "../partials/footer.php";
    exit;
}
?>
<div class="max-w-xl mx-auto bg-white rounded-xl shadow-md p-8 mt-8">
    <h2 class="text-2xl font-bold mb-4">Öğretmen Düzenle</h2>
    <?php if (!empty($error)): ?>
        <div class="mb-4 text-red-600"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="full_name" value="<?= htmlspecialchars($teacher['full_name'] ?? '') ?>" class="form-input w-full mb-4" required>
<label class="block mb-2">Branş</label>
<input type="text" name="branch" value="<?= htmlspecialchars($teacher['branch'] ?? '') ?>" class="form-input w-full mb-4">
<label class="block mb-2">E-posta</label>
<input type="email" name="email" value="<?= htmlspecialchars($teacher['email'] ?? '') ?>" class="form-input w-full mb-4">
<label class="block mb-2">Telefon</label>
<input type="text" name="phone" value="<?= htmlspecialchars($teacher['phone'] ?? '') ?>" class="form-input w-full mb-4">
<label class="block mb-2">Adres</label>
<input type="text" name="address" value="<?= htmlspecialchars($teacher['address'] ?? '') ?>" class="form-input w-full mb-4">
        <div class="flex gap-2 mt-6">
            <button type="submit" class="px-5 py-2 rounded-lg bg-blue-600 text-white font-bold hover:bg-blue-700 transition">Kaydet</button>
            <a href="teachers.php" class="px-5 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold transition">İptal</a>
        </div>
    </form>
</div>
<?php require_once "../partials/footer.php"; ?>