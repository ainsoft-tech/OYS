<?php
require_once "../partials/header.php";
include '../config/oys_vt.php';

// Sayfalama ayarları
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

// Toplam kayıt sayısı
$totalStmt = $pdo->query("SELECT COUNT(*) as total FROM teachers");
$totalRow = $totalStmt->fetch(PDO::FETCH_ASSOC);
$total = $totalRow ? $totalRow['total'] : 0;
$totalPages = ceil($total / $perPage);

// Kayıtları çek
$stmt = $pdo->prepare("SELECT id, full_name, branch, email, phone FROM teachers ORDER BY id DESC LIMIT :offset, :perPage");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
$stmt->execute();
$teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
    <style type="text/tailwindcss">
        :root {
            --primary-color:rgb(22, 112, 238);--light-bg: #F3F4F6;--light-surface: #FFFFFF;--light-surface-alt: #E5E7EB;--light-border: #D1D5DB;--light-text-primary: #1F2937;--light-text-secondary: #6B7280;--light-text-placeholder: #9CA3AF;}
        .nav-link-active {
            color: var(--primary-color) !important;
            background-color: var(--light-surface-alt);
            font-weight: 600;}
    </style>

            <main class="px-6 md:px-10 lg:px-12 flex flex-1 flex-col py-8">
                <div class="layout-content-container flex flex-col flex-1">
                    <div class="flex flex-col gap-2 p-4 mb-6">
                        <h1 class="text-[var(--light-text-primary)] tracking-light text-3xl font-bold leading-tight">
                            Öğretmenler
                        </h1>
                        <div class="flex items-center gap-2 mt-2">
                            <label class="flex flex-1 h-10 max-w-full">
                                <div class="flex w-full flex-1 items-stretch rounded-xl h-full bg-[var(--light-surface)] shadow-md border border-[var(--light-border)]">
                                    <div class="text-[var(--light-text-placeholder)] flex items-center justify-center pl-4">
                                        <span class="material-icons">search</span>
                                    </div>
                                    <input
                                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-r-xl text-[var(--light-text-primary)] focus:outline-0 focus:ring-0 border-none bg-[var(--light-surface)] h-full placeholder:text-[var(--light-text-placeholder)] px-4 pl-2 text-base font-normal leading-normal"
                                        placeholder="Öğretmen ara (Ad, Branş, vb...)" value="" />
                                </div>
                            </label>
                            <button onclick="openTeacherModal()"
                                class="flex items-center gap-2 min-w-[84px] cursor-pointer justify-center overflow-hidden rounded-lg h-10 px-5 bg-[var(--primary-color)] text-[var(--light-bg)] text-sm font-bold leading-normal hover:bg-opacity-80 transition-colors">
                                <span class="material-icons text-lg">add</span>
                                <span class="truncate"> Ekle</span>
                            </button>
                            <button onclick="window.open('teacher_list_pdf.php','_blank')"
                                class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold h-10 px-4 rounded-lg shadow-sm transition-colors duration-200">
                                <svg width="20" height="20" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="32" height="32" rx="6" fill="#FF0000"/>
                                    <path d="M16.5 8C16.5 8 17.5 15 12 22C12 22 15 24 20 22C20 22 23 19 21 15C21 15 18 14 16.5 8Z" stroke="white" stroke-width="2" fill="none"/>
                                    <circle cx="16.5" cy="8" r="1.5" fill="white"/>
                                    <circle cx="12" cy="22" r="1.5" fill="white"/>
                                    <circle cx="20" cy="22" r="1.5" fill="white"/>
                                </svg>
                                PDF
                            </button>
                            <button onclick="window.open('teacher_list_excel.php','_blank')"
                                class="flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white font-semibold h-10 px-4 rounded-lg shadow-sm transition-colors duration-200">
                                <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="48" height="48" rx="8" fill="#217346"/>
                                    <path d="M16 16H32V32H16V16Z" fill="white"/>
                                    <path d="M20.5 20L24 28L27.5 20" stroke="#217346" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M22 24H26" stroke="#217346" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                Excel
                            </button>
                        </div>
                    </div>
                    <div class="px-4 py-3 @container flex-1">
                        <div
                            class="overflow-hidden rounded-xl border border-[var(--light-border)] bg-[var(--light-surface)] shadow-lg h-full flex flex-col">
                            <table class="w-full">
                                <thead class="bg-[var(--light-surface-alt)]">
                                    <tr>
										<th
                                            class="px-6 py-4 text-left text-[var(--light-text-primary)] text-xs font-semibold uppercase tracking-wider">
                                            #ID
										</th>
                                        <th
                                            class="px-6 py-4 text-left text-[var(--light-text-primary)] text-xs font-semibold uppercase tracking-wider">
                                            Ad Soyad
										</th>
                                        <th
                                            class="px-6 py-4 text-left text-[var(--light-text-primary)] text-xs font-semibold uppercase tracking-wider">
                                            Branş
										</th>
                                        <th
                                            class="px-6 py-4 text-left text-[var(--light-text-primary)] text-xs font-semibold uppercase tracking-wider">
                                            E-Mail
										</th>
                                        <th
                                            class="px-6 py-4 text-left text-[var(--light-text-primary)] text-xs font-semibold uppercase tracking-wider">
                                            Telefon
										</th>
                                        <th
                                            class="px-6 py-4 text-left text-[var(--light-text-primary)] text-xs font-semibold uppercase tracking-wider">
                                            Durum
										</th>
                                        <th
                                            class="px-6 py-4 text-left text-[var(--light-text-primary)] text-xs font-semibold uppercase tracking-wider">
                                            İşlemler
										</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[var(--light-border)]">
                                    <?php foreach ($teachers as $teacher): ?>
                                    <tr class="hover:bg-[var(--light-surface-alt)] transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-[var(--light-text-primary)] text-sm font-medium">
                                            <?= htmlspecialchars($teacher['id']) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-[var(--light-text-primary)] text-sm font-medium">
                                            <?= htmlspecialchars($teacher['full_name']) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-[var(--light-text-secondary)] text-sm">
                                            <?= htmlspecialchars($teacher['branch'] ?? '') ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-[var(--light-text-secondary)] text-sm">
                                            <?= htmlspecialchars($teacher['email']) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-[var(--light-text-secondary)] text-sm">
                                            <?= htmlspecialchars($teacher['phone']) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center gap-2">
                                                <!-- Detay -->
                                                <button title="Detay" onclick="showTeacherDetail(<?= htmlspecialchars($teacher['id']) ?>)" class="text-blue-500 hover:text-blue-700 transition-colors">
                                                    <span class="material-icons text-xl">info</span>
                                                </button>
                                                <!-- Düzenle -->
                                                <button title="Düzenle" onclick="editTeacher(<?= htmlspecialchars($teacher['id']) ?>)" class="text-[var(--primary-color)] hover:text-opacity-80 transition-opacity">
                                                    <span class="material-icons text-xl">edit</span>
                                                </button>
                                                <!-- Sil -->
                                                <button title="Sil" onclick="deleteTeacher(<?= htmlspecialchars($teacher['id']) ?>)" class="text-red-500 hover:text-red-700 transition-colors">
                                                    <span class="material-icons text-xl">delete</span>
                                                </button>
                                                <!-- PDF -->
                                                <a title="PDF Aktar" href="teacher_pdf.php?id=<?= htmlspecialchars($teacher['id']) ?>" target="_blank" class="text-gray-600 hover:text-red-600 transition-colors">
                                                    <span class="material-icons text-xl">picture_as_pdf</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($teachers)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-6 text-[var(--light-text-secondary)]">Kayıt bulunamadı.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <div
                                class="mt-auto px-6 py-4 border-t border-[var(--light-border)] flex items-center justify-between">
                                <p class="text-sm text-[var(--light-text-secondary)]">Toplam <?= $total ?> öğretmen</p>
                                <div class="flex gap-2">
                                    <button
                                        class="p-2 rounded-md hover:bg-[var(--light-surface-alt)] disabled:opacity-50 text-[var(--light-text-secondary)]"
                                        disabled=""><span class="material-icons">chevron_left</span></button>
                                    <button
                                        class="p-2 rounded-md hover:bg-[var(--light-surface-alt)] text-[var(--light-text-secondary)]"><span
                                            class="material-icons">chevron_right</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <div class="fixed right-8 bottom-8 z-40">
                        <nav class="inline-flex rounded-lg shadow-lg overflow-hidden border border-[var(--light-border)] bg-[var(--light-surface)]">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?= $page-1 ?>" class="px-3 py-2 text-[var(--light-text-secondary)] hover:bg-[var(--light-surface-alt)] transition" title="Önceki">
                                    <span class="material-icons align-middle text-base">chevron_left</span>
                                </a>
                            <?php else: ?>
                                <span class="px-3 py-2 text-[var(--light-text-placeholder)] cursor-not-allowed">
                                    <span class="material-icons align-middle text-base">chevron_left</span>
                                </span>
                            <?php endif; ?>

                            <?php
                            // Sayfa numaraları (maksimum 5 göster)
                            $start = max(1, $page - 2);
                            $end = min($totalPages, $page + 2);
                            if ($start > 1) echo '<span class="px-2 py-2 text-[var(--light-text-placeholder)]">...</span>';
                            for ($i = $start; $i <= $end; $i++):
                            ?>
                                <?php if ($i == $page): ?>
                                    <span class="px-3 py-2 bg-[var(--primary-color)] text-white font-bold"><?= $i ?></span>
                                <?php else: ?>
                                    <a href="?page=<?= $i ?>" class="px-3 py-2 hover:bg-[var(--light-surface-alt)] text-[var(--light-text-primary)] transition"><?= $i ?></a>
                                <?php endif; ?>
                            <?php endfor;
                            if ($end < $totalPages) echo '<span class="px-2 py-2 text-[var(--light-text-placeholder)]">...</span>';
                            ?>

                            <?php if ($page < $totalPages): ?>
                                <a href="?page=<?= $page+1 ?>" class="px-3 py-2 text-[var(--light-text-secondary)] hover:bg-[var(--light-surface-alt)] transition" title="Sonraki">
                                    <span class="material-icons align-middle text-base">chevron_right</span>
                                </a>
                            <?php else: ?>
                                <span class="px-3 py-2 text-[var(--light-text-placeholder)] cursor-not-allowed">
                                    <span class="material-icons align-middle text-base">chevron_right</span>
                                </span>
                            <?php endif; ?>
                        </nav>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <!-- Öğretmen Ekle Modalı -->
<div id="addTeacherModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 overflow-y-auto hidden">
  <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-auto my-12 p-0 relative max-h-[95vh] flex flex-col">
    <!-- Başlık ve Kapat -->
    <div class="flex items-center justify-between px-8 pt-8 pb-4 border-b">
      <div class="flex items-center gap-3">
        <span class="material-icons text-blue-600 text-3xl">person_add</span>
        <div>
          <h2 class="text-2xl font-bold text-gray-800">Yeni Öğretmen Ekle</h2>
          <p class="text-sm text-gray-500">Lütfen tüm alanları eksiksiz doldurun.</p>
        </div>
      </div>
      <button onclick="closeTeacherModal()" class="text-gray-400 hover:text-red-600 text-3xl transition-colors">&times;</button>
    </div>
    <!-- Form -->
    <form id="addTeacherForm" enctype="multipart/form-data" autocomplete="off" class="flex-1 overflow-y-auto px-8 py-6 space-y-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block mb-1 font-semibold text-gray-700">Ad Soyad</label>
          <input type="text" name="full_name" required class="form-input w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
        </div>
        <div>
          <label class="block mb-1 font-semibold text-gray-700">TC Kimlik No</label>
          <input type="text" name="tc_no" maxlength="11" class="form-input w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
        </div>
        <div>
          <label class="block mb-1 font-semibold text-gray-700">Başlama Tarihi</label>
          <input type="date" name="start_date" class="form-input w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
        </div>
        <div>
          <label class="block mb-1 font-semibold text-gray-700">Telefon</label>
          <input type="text" name="phone" id="teacherPhone" class="form-input w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
        </div>
        <div>
          <label class="block mb-1 font-semibold text-gray-700">E-posta</label>
          <input type="email" name="email" id="teacherEmail" required class="form-input w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
        </div>
        <div>
          <label class="block mb-1 font-semibold text-gray-700">Kullanıcı Adı</label>
          <input type="text" name="username" id="teacherUsername" required class="form-input w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
        </div>
        <div>
          <label class="block mb-1 font-semibold text-gray-700">Branş</label>
          <input type="text" name="branch" class="form-input w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
        </div>
        <div>
          <label class="block mb-1 font-semibold text-gray-700">Maaş</label>
          <input type="number" name="salary" class="form-input w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
        </div>
        <div>
          <label class="block mb-1 font-semibold text-gray-700">Fotoğraf</label>
          <input type="file" name="photo" accept="image/*" class="form-input w-full border border-gray-300 rounded-lg px-3 py-2" />
        </div>
        <div class="md:col-span-2">
          <label class="block mb-1 font-semibold text-gray-700">Adres</label>
          <input type="text" name="address" class="form-input w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
        </div>
        <div>
          <label class="block mb-1 font-semibold text-gray-700">Cinsiyet</label>
          <select name="gender" class="form-input w-full border border-gray-300 rounded-lg px-3 py-2">
            <option value="">Seçiniz</option>
            <option value="Erkek">Erkek</option>
            <option value="Kadın">Kadın</option>
          </select>
        </div>
        <div>
          <label class="block mb-1 font-semibold text-gray-700">Medeni Durum</label>
          <select name="marital_status" class="form-input w-full border border-gray-300 rounded-lg px-3 py-2">
            <option value="">Seçiniz</option>
            <option value="Bekar">Bekar</option>
            <option value="Evli">Evli</option>
          </select>
        </div>
        <div>
          <label class="block mb-1 font-semibold text-gray-700">Doğum Yeri</label>
          <input type="text" name="birth_place" class="form-input w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
        </div>
        <div>
          <label class="block mb-1 font-semibold text-gray-700">Doğum Tarihi</label>
          <input type="date" name="birth_date" class="form-input w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
        </div>
        <div>
          <label class="block mb-1 font-semibold text-gray-700">Çocuk Sayısı</label>
          <input type="number" name="children_count" min="0" class="form-input w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
        </div>
        <div>
          <label class="block mb-1 font-semibold text-gray-700">Eğitim Durumu</label>
          <input type="text" name="education_status" class="form-input w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
        </div>
        <div>
          <label class="block mb-1 font-semibold text-gray-700">Şifre</label>
          <input type="password" name="password" required class="form-input w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
        </div>
      </div>
      <div class="mt-6 flex justify-end gap-2">
        <button type="button" onclick="closeTeacherModal()" class="px-5 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold transition">İptal</button>
        <button type="submit" class="px-5 py-2 rounded-lg bg-blue-600 text-white font-bold hover:bg-blue-700 transition">Kaydet</button>
      </div>
      <div id="teacherFormMessage" class="mt-3 text-sm text-center text-red-600 hidden"></div>
    </form>
  </div>
</div>



<script>
function openTeacherModal() {
    document.getElementById('addTeacherModal').classList.remove('hidden');
}
function closeTeacherModal() {
    document.getElementById('addTeacherModal').classList.add('hidden');
    document.getElementById('addTeacherForm').reset();
    document.getElementById('teacherFormMessage').classList.add('hidden');
}

// E-posta yazıldıkça username alanını doldur
document.getElementById('teacherEmail').addEventListener('input', function() {
    document.getElementById('teacherUsername').value = this.value;
});

// AJAX ile form gönderimi
document.getElementById('addTeacherForm').onsubmit = function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    fetch('add_teacher.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const msg = document.getElementById('teacherFormMessage');
        msg.textContent = data.message;
        msg.classList.remove('hidden');
        if (data.success) {
            setTimeout(() => {
                closeTeacherModal();
                location.reload();
            }, 800);
        }
    })
    .catch(() => {
        const msg = document.getElementById('teacherFormMessage');
        msg.textContent = "Bir hata oluştu.";
        msg.classList.remove('hidden');
    });
};

function showTeacherDetail(id) {
    // Burada modal açabilir veya detay sayfasına yönlendirebilirsiniz
    window.location.href = 'teacher_detail.php?id=' + id;
}
function editTeacher(id) {
    // Düzenleme modalı açabilir veya düzenleme sayfasına yönlendirebilirsiniz
    window.location.href = 'teacher_edit.php?id=' + id;
}
function deleteTeacher(id) {
    if (confirm('Bu öğretmeni silmek istediğinize emin misiniz?')) {
        fetch('teacher_delete.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'id=' + encodeURIComponent(id)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Öğretmen silindi.');
                location.reload();
            } else {
                alert(data.message || 'Silme işlemi başarısız.');
            }
        });
    }
}
</script>
<script>
function formatPhone(value) {
    let x = value.replace(/\D/g, '').substring(0, 11);
    // Başında 0 yoksa ekle
    if (x.length > 0 && x[0] !== '0') {
        x = '0' + x.substring(0, 10);
    }
    let formatted = '';
    if (x.length > 0) formatted = x.substring(0, 4);
    if (x.length > 4) formatted += ' ' + x.substring(4, 7);
    if (x.length > 7) formatted += ' ' + x.substring(7, 9);
    if (x.length > 9) formatted += ' ' + x.substring(9, 11);
    return formatted;
}

const phoneInput = document.getElementById('teacherPhone');

phoneInput.addEventListener('input', function(e) {
    // Sadece rakam girilsin, anlık olarak formatlama yapma
    let x = e.target.value.replace(/\D/g, '').substring(0, 11);
    e.target.value = x;
});

phoneInput.addEventListener('blur', function(e) {
    // Inputtan çıkınca başa 0 ekle ve formatla
    e.target.value = formatPhone(e.target.value);
});
</script>

<?php
require_once "../partials/footer.php";
?>