<?php
session_start();

// Veritabanı bağlantısını yükle
require_once 'config/oys_vt.php';

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        // Kullanıcıyı sorgula
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Giriş başarılı
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role']
            ];

            // Rol bazlı yönlendirme
            switch ($user['role']) {
                case 'admin':
                    header("Location: admin/dashboard.php");
                    exit;
                case 'teacher':
                    header("Location: dashboard/teacher.php");
                    exit;
                case 'student':
                    header("Location: dashboard/student.php");
                    exit;
                case 'idareci':
                    header("Location: dashboard/idareci.php");
                    exit;
                default:
                    $error = "Bilinmeyen rol.";
            }
        } else {
            $error = "E-posta veya şifre yanlış.";
        }
    } else {
        $error = "Lütfen tüm alanları doldurunuz.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8"/>
  <link crossorigin="" href="https://fonts.gstatic.com/"  rel="preconnect"/>
  <link as="style" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900" onload="this.rel='stylesheet'" rel="stylesheet"/>
  <title>Giriş Yap - Okul Yönetim Sistemi</title>
  <link href="data:image/x-icon;base64," rel="icon" type="image/x-icon"/>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <style type="text/tailwindcss">
    :root {
      --primary-color: #0c7ff2;   
      --primary-hover-color:rgb(1, 69, 141);
    }
    body {
      font-family: Inter, "Noto Sans", sans-serif;
    }
  </style>
</head>
<body>
  <div class="relative flex size-full min-h-screen flex-col bg-slate-50 group/design-root overflow-x-hidden">
    <div class="layout-container flex h-full grow flex-col">
      <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-slate-200 bg-white px-6 sm:px-10 py-4 shadow-sm">
        <div class="flex items-center gap-3 text-slate-800">
          <div class="flex items-center gap-3 sm:gap-4 text-[var(--text-primary)]">
            <div class="size-6 text-[var(--primary-color)]">
              <!-- SVG logo -->
            </div>
            <img alt="Okul Logosu" class="h-10 w-10 rounded-lg object-cover"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuDE_VihHPU04db0go5nw2keLMe5KlYinZTxuZKxXDdwxy-xDhD523LopiZbFZjfqXW4Za0FofBUHekLrpSJyPyLOJquRGsKtDjJcxEcpqriYfQj7tghEnSqTRp3m5uVC1SQVYW-clDU8Gw-czAHXY65jIlq65oOE6M9yxXqbnX6hXQuJS_DNcc8LMOcuarqyEKywkqu0Rz255zthJTYMGC_68cGo73HJSQ1BXfY9VrDaS-Ih213QGNMAIJ9wI7c0HoBwI5zJgAyB2BJ" />
            <h2 class="text-xl font-semibold">Okul Yönetim Sistemi</h2>
          </div>
        </div>
      </header>

      <main class="flex flex-1 items-center justify-center py-8 px-4 sm:px-6 lg:px-8 bg-slate-50">
        <div class="w-full max-w-md space-y-8 bg-white p-8 sm:p-10 rounded-xl shadow-xl">
          <div>
            <h2 class="text-center text-3xl font-extrabold text-[var(--text-primary)]">Giriş Yap</h2>
            <p class="mt-2 text-center text-sm text-[var(--text-secondary)]">
              Hesabınıza erişmek için bilgilerinizi girin.
            </p>
          </div>

          <?php if (!empty($error)): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded text-sm text-center">
              <?= htmlspecialchars($error); ?>
            </div>
          <?php endif; ?>

          <form method="POST" class="space-y-6">
            <div>
              <label class="sr-only" for="email">E-posta</label>
              <input autocomplete="email"
                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-md text-slate-900 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:border-transparent border border-slate-300 bg-white h-12 placeholder:text-slate-500 p-3 text-base font-normal leading-normal transition-colors duration-200 ease-in-out hover:border-slate-400"
                id="email" name="email" placeholder="E-posta" required type="email" value="<?= htmlspecialchars($email ?? '') ?>" />
            </div>
            <div>
              <label class="sr-only" for="password">Şifre</label>
              <input autocomplete="current-password"
                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-md text-slate-900 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:border-transparent border border-slate-300 bg-white h-12 placeholder:text-slate-500 p-3 text-base font-normal leading-normal transition-colors duration-200 ease-in-out hover:border-slate-400"
                id="password" name="password" placeholder="Şifre" required type="password" />
            </div>
            <div class="text-right">
              <a class="text-sm font-medium text-[var(--primary-color)] hover:text-[var(--primary-hover-color)] hover:underline"
                href="#"> Şifremi unuttum </a>
            </div>
            <div>
              <button
                class="flex min-w-[84px] w-full cursor-pointer items-center justify-center overflow-hidden rounded-md h-11 px-4 bg-[var(--primary-color)] text-white text-base font-semibold leading-normal tracking-wide shadow-sm hover:bg-[var(--primary-hover-color)] focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:ring-offset-2 transition-colors duration-200 ease-in-out"
                type="submit">
                Giriş Yap
              </button>
            </div>
          </form>
          <p class="mt-8 text-center text-sm text-slate-600">
            Şifre bilgilerini
            <a class="font-medium text-[var(--primary-color)] hover:text-[var(--primary-hover-color)] hover:underline"
              href="#"> Değiştir </a>
          </p>
        </div>
      </main>

<?php
include_once 'partials/footer.php';
?>