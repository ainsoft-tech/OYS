<?php
include '../partials/header.php';
require_once '../config/oys_vt.php';

$stmt = $pdo->query("SELECT COUNT(*) as total_records FROM students");
$total_records = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<style type="text/tailwindcss">
    :root {
        --primary-color: #0b80ee;
        --primary-color-hover: rgb(5, 83, 155);
        --secondary-text: #4b5563;
        --border-color: #e5e7eb;
        --background-hover: #f3f4f6;
    }
</style>
<main class="flex-1 p-8">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Öğrenci Yönetimi</h2>
        <p class="text-[var(--secondary-text)] mt-1">Okuldaki öğrencilerin bilgilerini yönetin ve takip edin.</p>
    </div>

    <!-- Arama + Butonlar -->
    <div class="flex items-center gap-4 mb-6">
        <label class="relative block flex-1 max-w-sm">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="20px"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"></path>
                </svg>
            </span>
            <input id="searchInput"
                class="form-input block w-full rounded-lg border border-[var(--border-color)] bg-white py-3 pl-10 pr-4 text-gray-700 placeholder:text-gray-400 focus:border-[var(--primary-color)] focus:ring-1 focus:ring-[var(--primary-color)] text-sm"
                placeholder="Ad Soyad'a göre ara..." type="search" />
        </label>
        <p class="text-sm text-[var(--secondary-text)]">
            Toplam <span class="font-semibold text-gray-700" id="totalStudentCount"><?= $total_records['total_records'] ?></span> öğrenciden
        </p>
        <select id="perPageSelect" class="w-20 px-3 py-2 border border-gray-300 rounded-md text-sm">
            <option value="10" selected>10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select><p>Öğrenci</p>
        <div class="flex-1"></div>
        <button onclick="openAddModal()"
            class="flex items-center gap-2 bg-[var(--primary-color)] hover:bg-[var(--primary-color-hover)] text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition-colors duration-200">
            <svg fill="currentColor" height="20" viewBox="0 0 256 256" width="20"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M224,128a8,8,0,0,1-8,8H136v80a8,8,0,0,1-16,0V136H40a8,8,0,0,1,0-16h80V40a8,8,0,0,1,16,0v80h80A8,8,0,0,1,224,128Z"></path>
            </svg>
            <span> Ekle</span>
        </button>
        
        <button onclick="exportListToPDF()"
            class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition-colors duration-200 ml-2">
            <!-- Adobe PDF simgesi SVG -->
            <svg width="20" height="20" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="32" height="32" rx="6" fill="#FF0000"/>
                <path d="M16.5 8C16.5 8 17.5 15 12 22C12 22 15 24 20 22C20 22 23 19 21 15C21 15 18 14 16.5 8Z" stroke="white" stroke-width="2" fill="none"/>
                <circle cx="16.5" cy="8" r="1.5" fill="white"/>
                <circle cx="12" cy="22" r="1.5" fill="white"/>
                <circle cx="20" cy="22" r="1.5" fill="white"/>
            </svg>
            <span>PDF </span>
        </button>
        <button onclick="exportListToExcel()"
            class="flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition-colors duration-200 ml-2">
            <svg width="20" height="20" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="48" height="48" rx="8" fill="#217346"/>
                <path d="M16 16H32V32H16V16Z" fill="white"/>
                <path d="M20.5 20L24 28L27.5 20" stroke="#217346" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M22 24H26" stroke="#217346" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Excel
        </button>
    </div>

    <!-- Öğrenci Listesi -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden @container">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ad Soyad</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">TC Kimlik</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Sınıf</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Numara</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Durum</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border-color)]" id="studentTableBody">
                    <!-- AJAX buraya yazacak -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-[var(--border-color)] flex flex-wrap justify-between items-center">
            <div class="flex gap-2 items-center">
                <button id="prevPage"
                    class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50"
                    disabled>Önceki</button>
                <span id="pageInfo" class="text-sm text-gray-700">Sayfa 1 / 1</span>
                <button id="nextPage"
                    class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Sonraki</button>
            </div>
        </div>
    </div>
</main>

<!-- Modal - Yeni/Düzenle -->
<div id="addModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-60 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-8 max-h-[90vh] overflow-y-auto relative animate-fadeIn scale-95 transition-all duration-300">
        <button onclick="closeAddModal()" class="absolute top-4 right-4 text-2xl text-gray-400 hover:text-gray-700 transition-colors">×</button>
        <h3 id="modalTitle" class="text-2xl font-bold mb-6 text-center text-[var(--primary-color)]">Yeni Öğrenci Ekle</h3>
        <form id="studentForm" onsubmit="saveStudent(event)">
            <div id="formMessage" class="mb-4 hidden text-center text-green-600 font-semibold"></div>
            <input type="hidden" name="id" id="studentId">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Ad Soyad</label><input required name="full_name" id="full_name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">TC Kimlik No</label><input name="tc_no" id="tc_no" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Numara</label><input name="school_number" id="school_number" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Doğum Tarihi</label><input type="date" name="birth_date" id="birth_date" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Doğum Yeri</label><input name="birth_place" id="birth_place" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Cinsiyet</label><select name="gender" id="gender" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition"><option value="">Seçiniz</option><option value="Erkek">Erkek</option><option value="Kadın">Kadın</option></select></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Sınıf</label><input name="class" id="class" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Şube</label><input name="lesson_room" id="lesson_room" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">E-posta</label><input name="email" id="email" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Telefon</label><input name="phone" id="phone" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Veli Adı</label><input name="parent_name" id="parent_name" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Veli Telefonu</label><input name="parent_phone" id="parent_phone" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition"></div>
                <div class="col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-2">Adres</label><textarea name="address" id="address" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition"></textarea></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Fotoğraf</label><input type="file" name="photo" id="photo" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Eğitim Dönemi</label><input name="education_period" id="education_period" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Kayıt Tarihi</label><input type="date" name="registration_date" id="registration_date" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Durum</label><select name="status" id="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition"><option value="Aktif">Aktif</option><option value="Pasif">Pasif</option></select></div>
            </div>
            <div class="mt-8 flex justify-end gap-4">
                <button type="button" onclick="closeAddModal()" class="px-5 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 font-semibold transition">Kapat</button>
                <button type="submit" class="px-5 py-2 bg-[var(--primary-color)] text-white rounded-lg font-semibold shadow hover:bg-[var(--primary-color-hover)] transition">Kaydet</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal - Detay -->
<div id="detailModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-60 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-8 max-h-[90vh] overflow-y-auto relative animate-fadeIn scale-95 transition-all duration-300">
        <h3 class="text-2xl font-bold mb-6 text-center text-[var(--primary-color)]">Öğrenci Detayı</h3>
        <div id="detailContent" class="space-y-4"></div>
        <div class="mt-8 flex justify-end">
            <button onclick="closeDetail()" class="px-5 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 font-semibold transition">Kapat</button>
        </div>
    </div>
</div>

<script>
let currentPage = 1;
let perPage = 10;

document.addEventListener("DOMContentLoaded", () => {
    fetchStudents(currentPage, '');
});

function fetchStudents(page = 1, query = '') {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "transactions/search_students.php?page=" + page + "&size=" + perPage + "&query=" + encodeURIComponent(query), true);
    xhr.onload = function () {
        if (this.status === 200) {
            try {
                const res = JSON.parse(this.responseText);
                document.getElementById("studentTableBody").innerHTML = res.html;
                document.getElementById("totalStudentCount").textContent = res.total;
                updatePagination(res.total, page);
            } catch (e) {
                alert("JSON hatası oluştu!");
            }
        } else {
            alert("AJAX isteği başarısız.");
        }
    };
    xhr.send();
}

function updatePagination(total, current) {
    currentPage = current;
    totalPages = Math.ceil(total / perPage);
    document.getElementById("pageInfo").textContent = `Sayfa ${current} / ${totalPages}`;
    document.getElementById("prevPage").disabled = current === 1;
    document.getElementById("nextPage").disabled = current === totalPages || totalPages === 0;
}

// İşlem Butonları
document.getElementById("searchInput").addEventListener("input", () => {
    fetchStudents(1, document.getElementById("searchInput").value.trim());
});
document.getElementById("perPageSelect").addEventListener("change", () => {
    perPage = parseInt(document.getElementById("perPageSelect").value);
    fetchStudents(1, document.getElementById("searchInput").value.trim());
});
document.getElementById("prevPage").addEventListener("click", () => {
    if (currentPage > 1) fetchStudents(currentPage - 1, document.getElementById("searchInput").value.trim());
});
document.getElementById("nextPage").addEventListener("click", () => {
    if (currentPage < totalPages) fetchStudents(currentPage + 1, document.getElementById("searchInput").value.trim());
});

// Modal işlemleri
function openAddModal(id = null) {
    if (id) {
        fetch(`transactions/get_student.php?id=${id}`)
            .then(res => res.json())
            .then(student => {
                for (const key in student) {
                    const el = document.getElementById(key);
                    if (el && el.type !== 'file') {
                        el.value = student[key];
                    }
                }
                document.getElementById("studentId").value = student.id;
                document.getElementById("modalTitle").innerText = "Öğrenciyi Düzenle";
                document.getElementById("addModal").classList.remove("hidden");
            });
    } else {
        document.getElementById("studentForm").reset();
        document.getElementById("studentId").value = '';
        document.getElementById("modalTitle").innerText = "Yeni Öğrenci Ekle";
        document.getElementById("addModal").classList.remove("hidden");
    }
}
function closeAddModal() {
    document.getElementById("addModal").classList.add("hidden");
}

function saveStudent(e) {
    e.preventDefault();
    const formData = new FormData(document.getElementById("studentForm"));
    const formMessage = document.getElementById("formMessage");
    formMessage.classList.add("hidden");
    formMessage.textContent = "";

    // Dosya yükleme varsa işle
    const photoInput = document.getElementById("photo");
    if (photoInput && photoInput.files.length > 0) {
        formData.append("photo", photoInput.files[0]);
    }

    fetch("transactions/save_student.php", {
        method: "POST",
        body: formData
    }).then(res => res.json()).then(data => {
        formMessage.textContent = data.message;
        formMessage.classList.remove("hidden");
        if (data.success) {
            document.getElementById("studentForm").reset();
            setTimeout(() => {
                closeAddModal();
                fetchStudents(currentPage, document.getElementById("searchInput").value.trim());
            }, 500);
        }
    });
}

function showDetail(studentData) {
    studentData = JSON.parse(studentData);
    let html = `
        <p><strong>ID:</strong> ${studentData.id}</p>
        <p><strong>Ad Soyad:</strong> ${studentData.full_name}</p>
        <p><strong>Sınıf:</strong> ${studentData.class || '-'}</p>
        <p><strong>Numara:</strong> ${studentData.school_number || '-'}</p>
        <p><strong>TC Kimlik:</strong> ${studentData.tc_no || '-'}</p>
        <p><strong>Cinsiyet:</strong> ${studentData.gender || '-'}</p>
        <p><strong>Veli Adı:</strong> ${studentData.parent_name || '-'}</p>
        <p><strong>Durum:</strong> ${studentData.status}</p>
        <p><strong>Fotoğraf:</strong> ${studentData.photo ? `<img src='uploads/${studentData.photo}' class='mt-2 h-20 w-20 object-cover rounded' />` : '-'}</p>
        <p><strong>Eğitim Dönemi:</strong> ${studentData.education_period || '-'}</p>
        <p><strong>Kayıt Tarihi:</strong> ${studentData.registration_date || '-'}</p>
    `;
    document.getElementById("detailContent").innerHTML = html;
    document.getElementById("detailModal").classList.remove("hidden");
}
function closeDetail() {
    document.getElementById("detailModal").classList.add("hidden");
}
function editStudent(id) {
    openAddModal(id);
}
function deleteStudent(id) {
    if (!confirm("Bu öğrenciyi silmek istediğinize emin misiniz?")) return;
    fetch(`transactions/delete_student.php?id=${id}`)
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            fetchStudents(currentPage, document.getElementById("searchInput").value.trim());
        });
}
function exportToPDF(id) {
    window.open(`transactions/pdf_export.php?id=${id}`, '_blank');
}
function exportListToPDF() {
    window.open('transactions/pdf_export.php', '_blank');
}

function exportListToExcel() {
    window.open('transactions/student_csv_export.php', '_blank');
}

console.log("JS yüklendi!");
console.log(typeof editStudent);
</script>

<?php include '../partials/footer.php'; ?>