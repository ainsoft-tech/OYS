<?php

require_once "../partials/header.php";
include '../config/oys_vt.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
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
    <h2 class="text-2xl font-bold mb-4"><?= htmlspecialchars($teacher['full_name'] ?? '') ?></h2>
    <ul class="space-y-2">
        <li><b>Branş:</b> <?= htmlspecialchars($teacher['branch'] ?? '') ?></li>
        <li><b>E-posta:</b> <?= htmlspecialchars($teacher['email'] ?? '') ?></li>
        <li><b>Telefon:</b> <?= htmlspecialchars($teacher['phone'] ?? '') ?></li>
        <li><b>Adres:</b> <?= htmlspecialchars($teacher['address'] ?? '') ?></li>
        <li><b>Başlama Tarihi:</b> <?= htmlspecialchars($teacher['start_date'] ?? '') ?></li>
        <li><b>Doğum Tarihi:</b> <?= htmlspecialchars($teacher['birth_date'] ?? '') ?></li>
        <li><b>Çocuk Sayısı:</b> <?= htmlspecialchars($teacher['children_count'] ?? '') ?></li>
        <!-- Diğer alanlar eklenebilir -->
    </ul>
    <a href="teachers.php" class="inline-block mt-6 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Geri Dön</a>
</div>
<?php require_once "../partials/footer.php"; ?>