<?php
$host='localhost';
$dbname='oys';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Bağlantı başarısız: ' . $e->getMessage();
}
?>

<?php
include_once '../partials/header.php';
include_once '../config/oys_vt.php';

$stmt = $pdo->query("SELECT COUNT(*) as total_records FROM students");
$total_records = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Okul Yönetim Sistemi - Yönetici Paneli" />
    <meta name="keywords" content="Okul, Yönetim, Sistemi, Öğrenci, Sınıf, Yönetimi" />
    <meta name="author" content="Okul Yönetim Sistemi" />
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <p>&nbsp;</p>


    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Öğrenci Yönetimi</h1>
        <p class="mb-4">Toplam Öğrenci Sayısı: <span id="totalRecords"><?php echo $total_records['total_records']; ?></span></p>

        <div class="mb-4">
            <label for="filterName" class="block text-sm font-medium text-gray-700">Ad Soyad:</label>
            <input type="text" id="filterName" class="mt-1 block> w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ad Soyad ile ara...">
        </div>
    </div>
<!-- 1. arama çubuğunu ad soyada göre arama yapacak şekilde düzenle,
2. kayıt ekleme butonunu students tablosuna göre veri eklemek için modern ve görsel olarak açılır pencere (modal) şeklinde ve fotoğraf yükleme imkanı da olacak şekilde oluştur
3. öğrenci listesini, 10, 25, 50, 100 seçenekli olacak şekilde kayıt sayısı gösterme imkanı olsun.
4. arama sonucuna göre bulunan kayıt sayısı dinamik olarak güncellensin
5. Listenin sağ alt tarafındaki pagination aktif edilsin, pagination kayıt sayısı gösterme kriterine göre dinamik olarak sayfalama olsun
Tüm bu değişiklikleri düzenledikten sonra sırayla ve açıklamalı olarak, her sayfanın tam kodunu verir misin? -->
</body>
</html>



