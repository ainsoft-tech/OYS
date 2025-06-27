<?php
$host = 'localhost';
$dbname = 'oys'; // veritabanı adınız
$username = 'root'; // MySQL kullanıcı adı
$password = ''; // şifre (XAMPP için genelde boş)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}