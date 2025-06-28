<?php
require_once '../config/oys_vt.php';

// Aktif sayfa yolunu al
$current = $_SERVER['SCRIPT_NAME'];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8" />
    <title>Okul Yönetim Sistemi</title>
    <link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect" />
    <link as="style"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
        onload="this.rel='stylesheet'" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="data:image/x-icon;base64," rel="icon" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="/css/app.css">
</head>

<body class="bg-gray-50" style='font-family: Inter, "Noto Sans", sans-serif;'>
    <div class="relative flex size-full min-h-screen flex-col bg-white group/design-root overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">
            <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md shadow-sm">
                <div class="container mx-auto flex items-center justify-between whitespace-nowrap px-6 py-4">
                    <div class="flex items-center gap-3 text-[var(--text-primary)]">
                        <div class="text-[var(--primary-color)]">
                            <img alt="Okul Logosu" class="h-10 w-10 rounded-lg object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDE_VihHPU04db0go5nw2keLMe5KlYinZTxuZKxXDdwxy-xDhD523LopiZbFZjfqXW4Za0FofBUHekLrpSJyPyLOJquRGsKtDjJcxEcpqriYfQj7tghEnSqTRp3m5uVC1SQVYW-clDU8Gw-czAHXY65jIlq65oOE6M9yxXqbnX6hXQuJS_DNcc8LMOcuarqyEKywkqu0Rz255zthJTYMGC_68cGo73HJSQ1BXfY9VrDaS-Ih213QGNMAIJ9wI7c0HoBwI5zJgAyB2BJ" />
                        </div>
                        <h2 class="text-[var(--text-primary)] text-xl font-bold leading-tight tracking-[-0.015em]">Okul
                            Yönetim Sistemi</h2>
                    </div>
                    <nav class="flex flex-1 justify-end items-center gap-1">
                        <a class="nav-link flex items-center <?= (strpos($current, '/admin/dashboard.php') !== false) ? 'nav-link-active' : '' ?>" href="../admin/dashboard.php">
                            <span class="material-icons nav-link-icon">admin_panel_settings</span>Yönetici Paneli
                        </a>
                        <a class="nav-link flex items-center <?= (strpos($current, '/admin/siniflar.php') !== false) ? 'nav-link-active' : '' ?>" href="../admin/siniflar.php">
                            <span class="material-icons nav-link-icon">class</span>Sınıf Yönetimi
                        </a>
                        <a class="nav-link flex items-center <?= (strpos($current, '/admin/students.php') !== false) ? 'nav-link-active' : '' ?>" href="../admin/students.php">
                            <span class="material-icons nav-link-icon">people</span>Öğrenci İşlemleri
                        </a>
                        <a class="nav-link flex items-center <?= (strpos($current, '/teachers/teachers.php') !== false) ? 'nav-link-active' : '' ?>" href="../teachers/teachers.php">
                            <span class="material-icons nav-link-icon">school</span>Öğretmenler
                        </a>
                        <a class="nav-link flex items-center <?= (strpos($current, '/lessons/lessons.php') !== false) ? 'nav-link-active' : '' ?>" href="../lessons/lessons.php">
                            <span class="material-icons nav-link-icon">book</span>Ders Yönetimi
                        </a>
                        <a class="nav-link flex items-center <?= (strpos($current, '/program/program.php') !== false) ? 'nav-link-active' : '' ?>" href="../program/program.php">
                            <span class="material-icons nav-link-icon">schedule</span>Ders Programı
                        </a>
                        <div class="relative group">
                            <button class="nav-link flex items-center" tabindex="0">
                                <span class="material-icons nav-link-icon">more_horiz</span>Diğer
                            </button>
                            <div
                                class="absolute left-0 mt-0 w-48 bg-white rounded-md shadow-lg py-1 z-20 opacity-0 group-hover:opacity-100 group-focus-within:opacity-100 transition-opacity duration-150 ease-in-out invisible group-hover:visible group-focus-within:visible">
                                <a class="block px-4 py-2 text-sm text-[var(--text-primary)] hover:bg-[var(--secondary-color)] flex items-center <?= (strpos($current, '/examinations/examinations.php') !== false) ? 'nav-link-active' : '' ?>"
                                    href="../examinations/examinations.php"><span class="material-icons nav-link-icon">assessment</span>Sınav
                                    Yönetimi</a>
                                <a class="block px-4 py-2 text-sm text-[var(--text-primary)] hover:bg-[var(--secondary-color)] flex items-center"
                                    href="#"><span class="material-icons nav-link-icon">grading</span>Not Yönetimi</a>
                                <a class="block px-4 py-2 text-sm text-[var(--text-primary)] hover:bg-[var(--secondary-color)] flex items-center"
                                    href="#"><span class="material-icons nav-link-icon">campaign</span>Duyurular</a>
                                <a class="block px-4 py-2 text-sm text-[var(--text-primary)] hover:bg-[var(--secondary-color)] flex items-center"
                                    href="#"><span class="material-icons nav-link-icon">calendar_today</span>Takvim</a>
                                <a class="block px-4 py-2 text-sm text-[var(--text-primary)] hover:bg-[var(--secondary-color)] flex items-center"
                                    href="#"><span class="material-icons nav-link-icon">settings</span>Ayarlar</a>
                            </div>
                        </div>
                    </nav>
                </div>
            </header>