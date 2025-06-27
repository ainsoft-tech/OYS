<?php
ob_start(); // Çıktı tamponlaması
include '../partials/header.php';
require_once '../config/oys_vt.php';

// Yeni sınıf ekleme
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sinif_kaydet'])) {
    $sinif_kodu = $_POST['sinif_kodu'];
    $sinif_adi = $_POST['sinif_adi'];
    $ogretmen_id = $_POST['ogretmen_id'] ?: NULL;

    $stmt = $pdo->prepare("INSERT INTO siniflar (sinif_kodu, sinif_adi, ogretmen_id) VALUES (?, ?, ?)");
    $stmt->execute([$sinif_kodu, $sinif_adi, $ogretmen_id]);

    header("Location: siniflar.php");
    exit;
}

// Sınıf silme işlemi
if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
    $id = intval($_GET['sil']);
    $stmt = $pdo->prepare("DELETE FROM siniflar WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: siniflar.php");
    exit;
}

// Sınıfları veritabanından çek
$stmt = $pdo->query("SELECT s.id, s.sinif_kodu, s.sinif_adi, o.full_name AS ogretmen_ad FROM siniflar s LEFT JOIN teachers o ON s.ogretmen_id = o.id");
$siniflar = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<style type="text/tailwindcss">
    :root {
        --primary-color: #0b80ee;
        --secondary-color: #f0f2f5;
        --text-primary: #111518;
        --text-secondary: #60768a;
        --border-color: #dbe1e6;
    }
</style>

<main class="flex-1 p-6">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <h2 class="text-[var(--text-primary)] text-3xl font-bold leading-tight">Sınıflar</h2>

        <!-- Arama Çubuğu ve Butonlar Aynı Satırda -->
        <div class="flex flex-wrap sm:flex-nowrap items-center w-full gap-4 mt-4 sm:mt-0">
            <!-- Arama Çubuğu -->
            <div class="w-full sm:w-auto flex-1">
                <label class="flex w-full flex-col min-w-0 h-12">
                    <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
                        <div class="text-[var(--text-secondary)] flex border border-r-0 border-[var(--border-color)] bg-white items-center justify-center pl-2 rounded-l-lg">
                            <svg fill="currentColor" height="20px" viewBox="0 0 256 256" width="50px"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"></path>
                            </svg>
                        </div>
                        <input id="searchInput"
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-r-lg text-[var(--text-primary)] focus:outline-none focus:ring-2 border border-[var(--border-color)] bg-white h-full placeholder:text-[var(--text-secondary)] px-4 text-sm font-normal leading-normal"
                            placeholder="Sınıf ara..." value="" />
                    </div>
                </label>
            </div>

            <!-- Butonlar -->
            <div class="flex flex-wrap gap-2 justify-end">
                <button onclick="openModal()"
                    class="flex items-center justify-center gap-2 rounded-lg h-10 px-5 bg-[var(--primary-color)] text-white text-sm font-medium leading-normal hover:bg-opacity-90 transition-colors">
                    <svg fill="currentColor" height="20" viewBox="0 0 256 256" width="20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M224,128a8,8,0,0,1-8,8H136v80a8,8,0,0,1-16,0V136H40a8,8,0,0,1,0-16h80V40a8,8,0,0,1,16,0v80h80A8,8,0,0,1,224,128Z"></path>
                    </svg>
                    <span>Yeni Sınıf Ekle</span>
                </button>
                <button onclick="window.print()"
                    class="flex items-center justify-center gap-2 rounded-lg h-10 px-5 bg-green-600 text-white text-sm font-medium leading-normal hover:bg-green-700 transition-colors">
                    <svg fill="currentColor" height="20" viewBox="0 0 24 24" width="20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 8H5V19H19V8ZM17 17H7V10H17V17ZM17 6H7V4H17V6ZM19 2H5C3.9 2 3 2.9 3 4V20C3 21.1 3.9 22 5 22H19C20.1 22 21 21.1 21 20V4C21 2.9 20.1 2 19 2Z" />
                    </svg>
                    <span>Listeyi PDF Al</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Öğrenci Listesi -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden @container">
        <div class="overflow-x-auto">
            <table class="w-full" id="studentTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-2 text-left">Sınıf Kodu</th>
                        <th class="px-6 py-2 text-left">Sınıf Adı</th>
                        <th class="px-6 py-2 text-left">Sınıf Öğretmeni</th>
                        <th class="px-6 py-2 text-left">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($siniflar as $sinif): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($sinif['sinif_kodu']) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($sinif['sinif_adi']) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($sinif['ogretmen_ad'] ?? '-') ?></td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                            <button onclick="editClass(<?= $sinif['id'] ?>)" class="text-blue-600 hover:underline">Düzenle</button>
                            <a href="?sil=<?= $sinif['id'] ?>" onclick="return confirm('Bu sınıfı silmek istediğinize emin misiniz?')" class="text-red-600 hover:underline">Sil</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
            </table>
        </div>
</main>

<!-- Modal - Yeni Sınıf Ekle -->
<div id="sinifEkleModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h3 class="text-xl font-semibold mb-4">Yeni Sınıf Ekle</h3>
        <form method="post">
            <div class="mb-4">
                <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1" for="sinif_kodu">Sınıf Kodu</label>
                <input required name="sinif_kodu" id="sinif_kodu" class="w-full border border-[var(--border-color)] rounded px-3 py-2" />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1" for="sinif_adi">Sınıf Adı</label>
                <input required name="sinif_adi" id="sinif_adi" class="w-full border border-[var(--border-color)] rounded px-3 py-2" />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1" for="ogretmen_id">Öğretmen Seç</label>
                <select name="ogretmen_id" id="ogretmen_id" class="w-full border border-[var(--border-color)] rounded px-3 py-2">
                    <option value="">Seçiniz</option>
                    <?php
                    $stmt = $pdo->query("SELECT id, full_name FROM teachers ORDER BY full_name ASC");
                    while ($ogretmen = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$ogretmen['id']}'>{$ogretmen['full_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">İptal</button>
                <button type="submit" name="sinif_kaydet" class="px-4 py-2 bg-[var(--primary-color)] text-white rounded hover:bg-opacity-90">Kaydet</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal - Sınıf Düzenle -->
<div id="sinifDuzenleModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h3 class="text-xl font-semibold mb-4">Sınıfı Düzenle</h3>
        <form id="sinifDuzenleForm">
            <input type="hidden" name="id" id="duzenle_id" />
            <div class="mb-4">
                <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1" for="duzenle_sinif_kodu">Sınıf Kodu</label>
                <input required name="sinif_kodu" id="duzenle_sinif_kodu" class="w-full border border-[var(--border-color)] rounded px-3 py-2" />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1" for="duzenle_sinif_adi">Sınıf Adı</label>
                <input required name="sinif_adi" id="duzenle_sinif_adi" class="w-full border border-[var(--border-color)] rounded px-3 py-2" />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-[var(--text-secondary)] mb-1" for="duzenle_ogretmen_id">Öğretmen Seç</label>
                <select name="ogretmen_id" id="duzenle_ogretmen_id" class="w-full border border-[var(--border-color)] rounded px-3 py-2">
                    <option value="">Seçiniz</option>
                    <?php
                    $stmt = $pdo->query("SELECT id, full_name FROM teachers ORDER BY full_name ASC");
                    while ($ogretmen = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$ogretmen['id']}'>{$ogretmen['full_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">İptal</button>
                <button type="submit" class="px-4 py-2 bg-[var(--primary-color)] text-white rounded hover:bg-opacity-90">Kaydet</button>
            </div>
            <div id="duzenleFormMesaj" class="mt-3 text-sm text-red-600 hidden"></div>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('sinifEkleModal').classList.remove('hidden');
}
function closeModal() {
    document.getElementById('sinifEkleModal').classList.add('hidden');
}

function confirmDelete(id) {
    if (confirm("Bu sınıfı silmek istediğinize emin misiniz?")) {
        window.location.href = "siniflar.php?sil=" + id;
    }
}

function editClass(id) {
    alert("Düzenleme modülü ileride eklenecek.");
}

document.getElementById("searchInput").addEventListener("keyup", function () {
    const term = this.value.toLowerCase();
    const rows = document.querySelectorAll("#sinifTablosu tbody tr");

    rows.forEach(row => {
        const cells = row.getElementsByTagName("td");
        let found = false;
        for (let i = 0; i < cells.length - 1; i++) {
            if (cells[i].textContent.toLowerCase().includes(term)) {
                found = true;
                break;
            }
        }
        row.style.display = found ? "" : "none";
    });
});
</script>
<script>
function editClass(id) {
    // Sınıf bilgilerini AJAX ile çek
    fetch('sinif_getir.php?id=' + id)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('duzenle_id').value = data.sinif.id;
                document.getElementById('duzenle_sinif_kodu').value = data.sinif.sinif_kodu;
                document.getElementById('duzenle_sinif_adi').value = data.sinif.sinif_adi;
                document.getElementById('duzenle_ogretmen_id').value = data.sinif.ogretmen_id || '';
                document.getElementById('duzenleFormMesaj').classList.add('hidden');
                document.getElementById('sinifDuzenleModal').classList.remove('hidden');
            } else {
                alert('Sınıf bilgisi alınamadı.');
            }
        });
}

function closeEditModal() {
    document.getElementById('sinifDuzenleModal').classList.add('hidden');
}

// Form submit
document.getElementById('sinifDuzenleForm').onsubmit = function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('sinif_guncelle.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const msg = document.getElementById('duzenleFormMesaj');
        if (data.success) {
            msg.classList.remove('hidden');
            msg.classList.remove('text-red-600');
            msg.classList.add('text-green-600');
            msg.textContent = "Güncelleme başarılı, sayfa yenileniyor...";
            setTimeout(() => location.reload(), 900);
        } else {
            msg.classList.remove('hidden');
            msg.classList.remove('text-green-600');
            msg.classList.add('text-red-600');
            msg.textContent = data.message || "Bir hata oluştu.";
        }
    })
    .catch(() => {
        const msg = document.getElementById('duzenleFormMesaj');
        msg.classList.remove('hidden');
        msg.classList.remove('text-green-600');
        msg.classList.add('text-red-600');
        msg.textContent = "Bir hata oluştu.";
    });
};
</script>
<?php include '../partials/footer.php'; ?>