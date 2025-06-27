<?php
include '../config/oys_vt.php';

// Form gönderildiyse yeni ders ekle
$addMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ders_kodu'])) {
    $ders_kodu = trim($_POST['ders_kodu']);
    $ders_adi = trim($_POST['ders_adi']);
    $teacher_id = intval($_POST['teacher_id']);
    $haftalik_ders_saati = intval($_POST['haftalik_ders_saati']);
    $status = isset($_POST['status']) ? 1 : 0;
    $ders_saati = trim($_POST['ders_saati']);
    $gun = trim($_POST['gun']);
    $created_by = 1; // Giriş yapan kullanıcı id'si ile değiştirilebilir

    if ($ders_kodu && $ders_adi && $teacher_id && $haftalik_ders_saati) {
        $stmt = $pdo->prepare("INSERT INTO lessons (ders_kodu, ders_adi, teacher_id, haftalik_ders_saati, ders_saati, gun, status, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$ok = $stmt->execute([$ders_kodu, $ders_adi, $teacher_id, $haftalik_ders_saati, $ders_saati, $gun, $status, $created_by]);
        if ($ok) {
            header("Location: lessons.php");
            exit;
        } else {
            $addMessage = '<div class="text-red-600 mb-4">Kayıt eklenemedi.</div>';
        }
    } else {
        $addMessage = '<div class="text-red-600 mb-4">Tüm alanları doldurunuz.</div>';
    }
}

// Ekleme başarılıysa mesajı göster
if (isset($_GET['ekleme']) && $_GET['ekleme'] === 'ok') {
    $addMessage = '<div class="text-green-600 mb-4">Ders başarıyla eklendi.</div>';
}

// lessons ve teachers sorguları
$stmt = $pdo->query("SELECT id, ders_kodu, ders_adi, haftalik_ders_saati FROM lessons ORDER BY id DESC");
$lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);
$teachers = $pdo->query("SELECT id, full_name FROM teachers ORDER BY full_name ASC")->fetchAll(PDO::FETCH_ASSOC);

// Artık header dosyasını çağırabilirsin
require_once '../partials/header.php';
?>
    <style type="text/tailwindcss">
        :root {
            --primary-color: #0b80ee;
            --primary-color-hover: #0069cc;
            --primary-color-active: #005bb5;
            --secondary-color: #f0f2f5;
            --text-primary: #111518;
            --text-secondary: #60768a;
            --border-color: #dbe1e6;
        }
        body {
            font-family: 'Inter', 'Noto Sans', sans-serif;
        }
        .nav-item {
            @apply flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-[var(--secondary-color)] transition-colors duration-150 cursor-pointer;
        }
        .nav-item.active {
            @apply bg-[var(--primary-color)] text-white;
        }
        .nav-item.active svg {
            @apply text-white;
        }
        .nav-item.active p {
            @apply text-white;
        }
        .nav-item p {
            @apply text-[var(--text-primary)] text-sm font-medium leading-normal;
        }
        .nav-item svg {
            @apply text-[var(--text-primary)];
        }
        .form-input {
            @apply flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[var(--text-primary)] focus:outline-0 focus:ring-2 focus:ring-[var(--primary-color)] border border-[var(--border-color)] bg-white focus:border-[var(--primary-color)] h-11 placeholder:text-[var(--text-secondary)] p-3 text-sm font-normal leading-normal;
        }
        .btn-primary {
            @apply flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-5 bg-[var(--primary-color)] text-white text-sm font-semibold leading-normal tracking-[0.01em] hover:bg-[var(--primary-color-hover)] active:bg-[var(--primary-color-active)] transition-colors duration-150;
        }
        .table-header-cell {
            @apply px-4 py-3 text-left text-[var(--text-primary)] text-xs font-semibold uppercase tracking-wider leading-normal;
        }
        .table-body-cell {
            @apply h-[60px] px-4 py-3 text-[var(--text-primary)] text-sm font-normal leading-normal;
        }
        .table-body-cell-secondary {
            @apply text-[var(--text-secondary)];
        }
        .table-action-button {
            @apply text-[var(--primary-color)] hover:text-[var(--primary-color-hover)] text-sm font-semibold leading-normal tracking-[0.01em] cursor-pointer transition-colors duration-150;
        }
    </style>

            <main class="mt-20 flex-1 p-6 space-y-6">
                <header class="flex justify-between items-center">
                    <h2 class="text-[var(--text-primary)] text-2xl font-bold leading-tight">Ders Yönetimi</h2>
                </header>
                <section class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-[var(--text-primary)] text-xl font-semibold leading-tight tracking-tight mb-6">Yeni Ders Ekle</h3>
                    <?= $addMessage ?>
                    <form method="post" class="grid grid-cols-1 md:grid-cols-5 gap-6 items-end">
                        <div class="flex flex-col">
                            <label class="text-[var(--text-primary)] text-sm font-medium leading-normal pb-1.5" for="dersKodu">Ders Kodu</label>
                            <input class="form-input" id="dersKodu" name="ders_kodu" placeholder="Örn: MAT101" required />
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[var(--text-primary)] text-sm font-medium leading-normal pb-1.5" for="dersAdi">Ders Adı</label>
                            <input class="form-input" id="dersAdi" name="ders_adi" placeholder="Örn: Matematik" required />
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[var(--text-primary)] text-sm font-medium leading-normal pb-1.5" for="teacherId">Öğretmen</label>
                            <select class="form-input" id="teacherId" name="teacher_id" required>
                                <option value="">Öğretmen Seç</option>
                                <?php foreach ($teachers as $t): ?>
                                    <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['full_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[var(--text-primary)] text-sm font-medium leading-normal pb-1.5" for="haftalikDersSaati">Haftalık Ders Saati</label>
                            <input class="form-input" id="haftalikDersSaati" name="haftalik_ders_saati" type="number" min="1" max="40" placeholder="Örn: 4" required />
                        </div>
                        <div class="flex flex-col">
                            <label class="text-[var(--text-primary)] text-sm font-medium leading-normal pb-1.5" for="status">Durum</label>
                            <select class="form-input" id="status" name="status">
                                <option value="1" selected>Aktif</option>
                                <option value="0">Pasif</option>
                            </select>
                        </div>
                        <div class="flex flex-col">
    <label class="text-[var(--text-primary)] text-sm font-medium leading-normal pb-1.5" for="dersSaati">Ders Saati</label>
    <input class="form-input" id="dersSaati" name="ders_saati" placeholder="Örn: 09:00-10:45" required />
</div>
<div class="flex flex-col">
    <label class="text-[var(--text-primary)] text-sm font-medium leading-normal pb-1.5" for="gun">Gün</label>
    <select class="form-input" id="gun" name="gun" required>
        <option value="">Gün Seç</option>
        <option value="Pazartesi">Pazartesi</option>
        <option value="Salı">Salı</option>
        <option value="Çarşamba">Çarşamba</option>
        <option value="Perşembe">Perşembe</option>
        <option value="Cuma">Cuma</option>
        <option value="Cumartesi">Cumartesi</option>
        <option value="Pazar">Pazar</option>
    </select>
</div>
                        <div class="md:col-span-5 flex justify-end pt-2 gap-2">
                            <button class="btn-primary" type="submit">
                                <svg class="mr-2" fill="none" height="18" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="18"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <line x1="12" x2="12" y1="5" y2="19"></line>
                                    <line x1="5" x2="19" y1="12" y2="12"></line>
                                </svg>
                                <span>Ders Ekle</span>
                            </button>
                            <!-- PDF Butonu -->
                            <a href="lesson_list_pdf.php" target="_blank"
                            class="flex items-center gap-1 px-4 py-2 rounded-full bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition"
                            title="Dersleri PDF olarak indir">
                                <span class="material-icons align-middle" style="font-size:18px;">picture_as_pdf</span>
                                PDF
                            </a>
                            <!-- Excel Butonu -->
                            <a href="lesson_list_excel.php" target="_blank"
                            class="flex items-center gap-1 px-4 py-2 rounded-full bg-green-600 text-white text-sm font-semibold hover:bg-green-700 transition"
                            title="Dersleri Excel olarak indir">
                                <span class="material-icons align-middle" style="font-size:18px;">table_view</span>
                                Excel
                            </a>
                        </div>
                    </form>
                </section>
                <section class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-[var(--text-primary)] text-xl font-semibold leading-tight tracking-tight mb-6">
                        Mevcut Dersler</h3>
                    <div class="overflow-x-auto @container">
                        <table class="min-w-full">
                            <thead class="border-b border-[var(--border-color)]">
                                <tr>
                                    <th class="table-header-cell">#ID</th>
                                    <th class="table-header-cell">Ders Kodu</th>
                                    <th class="table-header-cell">Ders Adı</th>
                                    <th class="table-header-cell">Haftalık Ders Saati</th>
                                    <th class="table-header-cell text-right">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($lessons as $lesson): ?>
                                <tr class="border-b border-[var(--border-color)] hover:bg-slate-50 transition-colors duration-150">
                                    <td class="table-body-cell"><?= htmlspecialchars($lesson['id']) ?></td>
                                    <td class="table-body-cell"><?= htmlspecialchars($lesson['ders_kodu']) ?></td>
                                    <td class="table-body-cell"><?= htmlspecialchars($lesson['ders_adi']) ?></td>
                                    <td class="table-body-cell"><?= htmlspecialchars($lesson['haftalik_ders_saati']) ?></td>
                                    <td class="table-body-cell text-right">
                                        <div class="flex justify-start gap-2">
                                            <!-- Detay -->
                                            <button title="Detay" onclick="lessonDetail(<?= $lesson['id'] ?>)" class="text-blue-500 hover:text-blue-700 transition-colors">
                                                <span class="material-icons text-lg align-middle">info</span>
                                            </button>
                                            <!-- Düzenle -->
                                            <button title="Düzenle" onclick="editLesson(<?= $lesson['id'] ?>)" class="text-[var(--primary-color)] hover:text-opacity-80 transition-opacity">
                                                <span class="material-icons text-lg align-middle">edit</span>
                                            </button>
                                            <!-- Sil -->
                                            <button title="Sil" onclick="deleteLesson(<?= $lesson['id'] ?>)" class="text-red-500 hover:text-red-700 transition-colors">
                                                <span class="material-icons text-lg align-middle">delete</span>
                                            </button>
                                            <!-- PDF -->
                                            <a title="PDF Aktar" href="lesson_pdf.php?id=<?= $lesson['id'] ?>" target="_blank" class="text-gray-600 hover:text-red-600 transition-colors">
                                                <span class="material-icons text-lg align-middle">picture_as_pdf</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <style>
                            @container(max-width:120px) {
                                .table-f0e7eac5-499c-4f69-b3b8-4b25364fd062-column-120 {
                                    display: none;
                                }
                            }

                            @container(max-width:240px) {
                                .table-f0e7eac5-499c-4f69-b3b8-4b25364fd062-column-240 {
                                    display: none;
                                }
                            }

                            @container(max-width:360px) {
                                .table-f0e7eac5-499c-4f69-b3b8-4b25364fd062-column-360 {
                                    display: none;
                                }
                            }

                            @container(max-width:480px) {
                                .table-f0e7eac5-499c-4f69-b3b8-4b25364fd062-column-480 {
                                    display: none;
                                }
                            }
                        </style>
                    </div>
                </section>
            </main>
        </div>
    </div>
<script>
function lessonDetail(id) {
    // Detay modalı açabilir veya detay sayfasına yönlendirebilirsin
    window.location.href = 'lesson_detail.php?id=' + id;
}

function editLesson(id) {
    // Düzenleme modalı açabilir veya düzenleme sayfasına yönlendirebilirsin
    window.location.href = 'lesson_edit.php?id=' + id;
}

function deleteLesson(id) {
    if (confirm('Bu dersi silmek istediğinize emin misiniz?')) {
        fetch('lesson_delete.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'id=' + encodeURIComponent(id)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Silme işlemi başarısız.');
            }
        })
        .catch(() => alert('Bir hata oluştu.'));
    }
}
</script>
<?php
require_once '../partials/footer.php';
?>