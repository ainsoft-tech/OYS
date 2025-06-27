<?php
session_start();

// Veritabanı bağlantısı için sınıf dosyasını dahil et
require_once 'config/oys_vt.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$username || !$password) {
        $error = "Tüm alanları doldurunuz.";
    } else {
        // Tablolar ve karşılık gelen roller
        $roller = [
            ['tablo' => 'admins', 'rol' => 'admin'],
            ['tablo' => 'teachers', 'rol' => 'teacher'],
            ['tablo' => 'students', 'rol' => 'student']
        ];

        foreach ($roller as $hedef) {
            $stmt = OYSVT::baglan()->prepare("SELECT id, username, password FROM {$hedef['tablo']} WHERE username = ?");
            $stmt->execute([$username]);
            $kullanici = $stmt->fetch();

            if ($kullanici && password_verify($password, $kullanici['password'])) {
                // Oturum başlat
                $_SESSION['user'] = [
                    'id' => $kullanici['id'],
                    'username' => $kullanici['username'],
                    'role' => $hedef['rol']
                ];

                // Rol'e göre yönlendir
                header("Location: {$hedef['rol']}/dashboard.php");
                exit;
            }
        }

        // Eşleşme yoksa hata ver
        $error = "Kullanıcı adı veya şifre hatalı.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <script src="https://cdn.tailwindcss.com"></script> 
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Giriş Yap</h2>

    <?php if ($error): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Kullanıcı Adı</label>
            <input type="text" id="username" name="username" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Şifre</label>
            <input type="password" id="password" name="password" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition">
            Giriş Yap
        </button>
    </form>

    <p class="mt-4 text-center text-sm text-gray-600">
        
        <br><strong>Şifremi Unuttum</strong>
        <br><strong>Şifre Sıfırlama</strong>
        <br><strong>Öğrenci:</strong> kullanıcı: <em>student1</em>, şifre: <em>1234</em>
    </p>
</div>

</body>
</html>