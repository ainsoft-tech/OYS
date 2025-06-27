<?php
include_once '../partials/header.php';
include_once '../config/oys_vt.php';

// Haftanın günleri ve saat aralıkları
$gunler = ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'];

// Tabloda geçen tüm ders saatlerini çek (sıralı ve tekrar etmeyen)
$saatler = $pdo->query("SELECT DISTINCT ders_saati FROM timetable ORDER BY ders_saati")->fetchAll(PDO::FETCH_COLUMN);

// Filtreleri al
$sinif_id = isset($_GET['sinif_id']) ? intval($_GET['sinif_id']) : 0;
$teacher_id = isset($_GET['teacher_id']) ? intval($_GET['teacher_id']) : 0;

// Sorgu oluştur
$query = "
    SELECT 
        t.gun,
        t.ders_saati,
        l.ders_adi,
        s.sinif_adi,
        te.full_name AS ogretmen_adi
    FROM timetable t
    LEFT JOIN lessons l ON t.ders_id = l.id
    LEFT JOIN siniflar s ON t.sinif_id = s.id
    LEFT JOIN teachers te ON t.teacher_id = te.id
    WHERE t.status = 'aktif'
";
$params = [];
if ($sinif_id) {
    $query .= " AND t.sinif_id = ?";
    $params[] = $sinif_id;
}
if ($teacher_id) {
    $query .= " AND t.teacher_id = ?";
    $params[] = $teacher_id;
}
$query .= " ORDER BY t.gun, t.ders_saati";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$programlar = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Programı [gun][saat] => ders şeklinde grupla
$programMap = [];
foreach ($programlar as $row) {
    $programMap[$row['gun']][$row['ders_saati']][] = $row;
}
?>
<style type="text/tailwindcss">
    :root {
      --primary-color:rgb(0, 0, 0);
      --secondary-color: #1E3A8A;
      --accent-color: #3B82F6;
      --neutral-color: #F3F4F6;
      --text-primary: #1F2937;
      --text-secondary: #6B7280;
    }
    body {
      font-family: 'Manrope', "Noto Sans", sans-serif;
    }
    .nav-link-active {
      color: var(--accent-color) !important;
      font-weight: 700 !important;
      border-bottom: 2px solid var(--accent-color);
    }
    .nav-link:hover{
        background-color: var(--neutral-color);
    }
    .table th {
      background-color: var(--neutral-color);
      color: var(--text-primary);
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      border-bottom: 2px solid #E5E7EB;
      border-right: 1px solid #E5E7EB;}
     .table th:last-child {
      border-right: none;}
    .table td {
      color: var(--text-secondary);
      border-bottom: 1px solid #E5E7EB;
      border-right: 1px solid #E5E7EB;}
     .table td:last-child {
      border-right: none;}
    .table tr:last-child td {
      border-bottom: none;
    }
    .table td.time-slot {
      color: var(--text-primary);
      font-weight: 500;
    }
    .table td.break-slot {
      background-color: #F9FAFB;
      color: #9CA3AF;
      font-style: italic;
    }
    .table td.activity-slot {
      background-color: #EFF6FF;
      color: #1D4ED8;
      font-weight: 500;
    }
    #timetableModal {
      display: none;
      align-items: center;
      justify-content: center;
    }
    #timetableModal.active {
      display: flex;
    }
    #timetableModal .modal-content {
      animation: fadeInScale .3s;
    }
    @keyframes fadeInScale {
      from { opacity: 0; transform: scale(0.95);}
      to { opacity: 1; transform: scale(1);}
    }
</style>

      <main class="px-4 md:px-8 lg:px-12 flex flex-1 justify-center py-8">
        <div class="layout-content-container flex flex-col max-w-full w-full flex-1">
          <div class="flex flex-wrap justify-between items-center gap-4 p-4 mb-6">
            <div class="flex flex-col gap-1">
              <h1 class="text-[var(--text-primary)] text-3xl font-bold leading-tight tracking-tight">Haftalık Ders Programı</h1>
              <p class="text-[var(--text-secondary)] text-base font-normal leading-normal">Haftalık ders programını görüntüleyin ve yönetin.</p>
            </div>
            <div class="flex items-center gap-2">
              <button class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-gray-200 text-[var(--text-secondary)] hover:bg-gray-300 transition-colors text-sm font-semibold">
                <span class="material-icons text-base">print</span> Yazdır
              </button>
              <button class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-green-100 text-green-700 hover:bg-green-200 transition-colors text-sm font-semibold">
                <span class="material-icons text-base">file_download</span> Excel İndir
              </button>
              <button class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition-colors text-sm font-semibold">
                <span class="material-icons text-base">picture_as_pdf</span> PDF İndir
              </button>
              <button type="button" onclick="openTimetableModal()" class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-[var(--accent-color)] text-white text-sm font-semibold hover:bg-[var(--secondary-color)] transition-colors">
                <svg fill="currentColor" height="18px" viewBox="0 0 256 256" width="18px" xmlns="http://www.w3.org/2000/svg">
                  <path d="M224,128a8,8,0,0,1-8,8H136v80a8,8,0,0,1-16,0V136H40a8,8,0,0,1,0-16h80V40a8,8,0,0,1,16,0v80h80A8,8,0,0,1,224,128Z"></path>
                </svg>
                Ders Ekle
              </button>
            </div>
          </div>
          <!-- Statistics Cards -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6 px-4">
            <div class="bg-white p-6 rounded-xl shadow-lg flex items-center gap-4">
              <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <span class="material-icons">event_note</span>
              </div>
              <div>
                <p class="text-sm text-[var(--text-secondary)]">Toplam Ders</p>
                <p class="text-2xl font-bold text-[var(--text-primary)]">150</p>
              </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-lg flex items-center gap-4">
              <div class="p-3 rounded-full bg-green-100 text-green-500">
                <span class="material-icons">schedule</span>
              </div>
              <div>
                <p class="text-sm text-[var(--text-secondary)]">Haftalık Saat</p>
                <p class="text-2xl font-bold text-[var(--text-primary)]">40</p>
              </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-lg flex items-center gap-4">
              <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <span class="material-icons">school</span>
              </div>
              <div>
                <p class="text-sm text-[var(--text-secondary)]">Ders Sayısı</p>
                <p class="text-2xl font-bold text-[var(--text-primary)]">12</p>
              </div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-lg flex items-center gap-4">
              <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                <span class="material-icons">group</span>
              </div>
              <div>
                <p class="text-sm text-[var(--text-secondary)]">Öğretmen Sayısı</p>
                <p class="text-2xl font-bold text-[var(--text-primary)]">25</p>
              </div>
            </div>
          </div>
          <div class="bg-white p-6 rounded-xl shadow-lg mb-6 px-4">
            <div class="flex flex-wrap items-center gap-4">
              <div class="relative flex-grow">
                <span class="material-icons absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                <input
                  class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[var(--accent-color)] focus:border-[var(--accent-color)] transition-colors"
                  placeholder="Ders, sınıf, öğretmen Ara..." type="text" />
              </div>
              
              <form id="filterForm" method="get" class="flex flex-wrap items-center gap-4 mb-0">
                  <div class="relative">
                    <select name="sinif_id" class="appearance-none w-full sm:w-auto bg-white border border-gray-300 rounded-lg py-2 pl-3 pr-8 text-[var(--text-secondary)] focus:ring-2 focus:ring-[var(--accent-color)] focus:border-[var(--accent-color)] transition-colors"
                      onchange="document.getElementById('filterForm').submit()">
                      <option value="">Sınıf Seçin</option>
                      <?php
                      $siniflar = $pdo->query("SELECT id, sinif_adi FROM siniflar")->fetchAll(PDO::FETCH_ASSOC);
                      $selectedSinif = isset($_GET['sinif_id']) ? $_GET['sinif_id'] : '';
                      foreach ($siniflar as $s) {
                        echo '<option value="'.$s['id'].'"'.($selectedSinif==$s['id']?' selected':'').'>'.htmlspecialchars($s['sinif_adi']).'</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="relative">
                    <select name="teacher_id" class="appearance-none w-full sm:w-auto bg-white border border-gray-300 rounded-lg py-2 pl-3 pr-8 text-[var(--text-secondary)] focus:ring-2 focus:ring-[var(--accent-color)] focus:border-[var(--accent-color)] transition-colors"
                      onchange="document.getElementById('filterForm').submit()">
                      <option value="">Öğretmen Seçin</option>
                      <?php
                      $teachers = $pdo->query("SELECT id, full_name FROM teachers")->fetchAll(PDO::FETCH_ASSOC);
                      $selectedTeacher = isset($_GET['teacher_id']) ? $_GET['teacher_id'] : '';
                      foreach ($teachers as $t) {
                        echo '<option value="'.$t['id'].'"'.($selectedTeacher==$t['id']?' selected':'').'>'.htmlspecialchars($t['full_name']).'</option>';
                      }
                      ?>
                    </select>
                  </div>
                </form>
              
              
              <div class="relative">
                <select
                  class="appearance-none w-full sm:w-auto bg-white border border-gray-300 rounded-lg py-2 pl-3 pr-8 text-[var(--text-secondary)] focus:ring-2 focus:ring-[var(--accent-color)] focus:border-[var(--accent-color)] transition-colors">
                  <option>Ders Seçin</option>
                  <option>Matematik</option>
                  <option>Türkçe</option>
                </select>
                <span
                  class="material-icons absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">expand_more</span>
              </div>
              
              <div class="relative">
                <select
                  class="appearance-none w-full sm:w-auto bg-white border border-gray-300 rounded-lg py-2 pl-3 pr-8 text-[var(--text-secondary)] focus:ring-2 focus:ring-[var(--accent-color)] focus:border-[var(--accent-color)] transition-colors">
                  <option>Akademik Dönem</option>
                  <option>2023-2024 Güz</option>
                  <option>2023-2024 Bahar</option>
                </select>
                <span
                  class="material-icons absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">expand_more</span>
              </div>
            </div>
          </div>
          
          <div class="px-4 py-3 @container bg-white shadow-lg rounded-xl overflow-x-auto mb-6">
            <table class="w-full min-w-[900px] table-fixed table">
              <thead>
                <tr>
                  <th class="px-4 py-3.5 text-left text-sm w-[150px]">Saat</th>
                  <?php foreach ($gunler as $gun): ?>
                    <th class="px-4 py-3.5 text-left text-sm"><?= htmlspecialchars($gun) ?></th>
                  <?php endforeach; ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($saatler as $saat): ?>
                  <tr>
                    <td class="time-slot h-[60px] px-4 py-2 text-sm"><?= htmlspecialchars($saat) ?></td>
                    <?php foreach ($gunler as $gun): ?>
                      <td class="h-[60px] px-4 py-2 text-sm">
                        <?php
                        $dersler = $programMap[$gun][$saat] ?? [];
                        if (count($dersler) > 0) {
                            foreach ($dersler as $ders) {
                                echo '<div class="mb-2">';
                                echo '<span class="font-semibold">'.htmlspecialchars($ders['ders_adi']).'</span><br>';
                                echo '<span class="text-xs text-gray-500">'.htmlspecialchars($ders['ogretmen_adi']).'</span><br>';
                                echo '<span class="text-xs text-gray-400">'.htmlspecialchars($ders['sinif_adi']).'</span>';
                                echo '</div>';
                            }
                        } else {
                            echo '<span class="text-gray-300 text-xs">-</span>';
                        }
                        ?>
                      </td>
                    <?php endforeach; ?>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

        </div>

    <!-- Ders Ekle Modalı -->
    <div id="timetableModal" class="fixed inset-0 z-50 bg-black bg-opacity-40">
      <div class="modal-content bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8 relative flex flex-col items-center justify-center">
        <button type="button" onclick="closeTimetableModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-2xl transition">&times;</button>
        <h2 class="text-2xl font-bold mb-6 text-[var(--text-primary)] flex items-center gap-2">
          <span class="material-icons text-blue-500">event</span> Ders Ekle
        </h2>
        <form id="timetableForm" autocomplete="off">
          <input type="hidden" name="ders_adi_id" id="ders_adi_id">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-semibold mb-1" for="ders_id">Ders</label>
              <select name="ders_id" id="ders_id" class="form-input w-full rounded-lg" required onchange="setDersSaati()">
                <option value="">Ders Seç</option>
                <?php
                $lessons = $pdo->query("SELECT id, ders_adi, ders_saati FROM lessons")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($lessons as $lesson) {
                  echo '<option value="'.$lesson['id'].'" data-saati="'.htmlspecialchars($lesson['ders_saati']).'" data-adi-id="'.$lesson['id'].'">'.htmlspecialchars($lesson['ders_adi']).'</option>';
                }
                ?>
              </select>
            </div>
            <div>
              <label class="block text-sm font-semibold mb-1" for="teacher_id">Öğretmen</label>
              <select name="teacher_id" id="teacher_id" class="form-input w-full rounded-lg" required>
                <option value="">Öğretmen Seç</option>
                <?php
                $teachers = $pdo->query("SELECT id, full_name FROM teachers")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($teachers as $t) {
                  echo '<option value="'.$t['id'].'">'.htmlspecialchars($t['full_name']).'</option>';
                }
                ?>
              </select>
            </div>
            <div>
              <label class="block text-sm font-semibold mb-1" for="sinif_id">Sınıf</label>
              <select name="sinif_id" id="sinif_id" class="form-input w-full rounded-lg" required>
                <option value="">Sınıf Seç</option>
                <?php
                $siniflar = $pdo->query("SELECT id, sinif_adi FROM siniflar")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($siniflar as $s) {
                  echo '<option value="'.$s['id'].'">'.htmlspecialchars($s['sinif_adi']).'</option>';
                }
                ?>
              </select>
            </div>
            <div>
              <label class="block text-sm font-semibold mb-1" for="gun">Gün</label>
              <select name="gun" id="gun" class="form-input w-full rounded-lg" required>
                <option value="">Gün Seç</option>
                <option value="Pazartesi">Pazartesi</option>
                <option value="Salı">Salı</option>
                <option value="Çarşamba">Çarşamba</option>
                <option value="Perşembe">Perşembe</option>
                <option value="Cuma">Cuma</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-semibold mb-1" for="ders_saati">Ders Saati</label>
              <input type="text" name="ders_saati" id="ders_saati" class="form-input w-full rounded-lg bg-gray-100" placeholder="08:00 - 08:40" readonly required>
            </div>
            <div>
              <label class="block text-sm font-semibold mb-1" for="haftalik_ders_saati">Haftalık Ders Saati</label>
              <input type="number" name="haftalik_ders_saati" id="haftalik_ders_saati" class="form-input w-full rounded-lg" min="1" max="40" required>
            </div>
            <div>
              <label class="block text-sm font-semibold mb-1" for="duration">Süre</label>
              <input type="text" name="duration" id="duration" class="form-input w-full rounded-lg" placeholder="Örn: 40 dk">
            </div>
            <div>
              <label class="block text-sm font-semibold mb-1" for="classroom">Derslik</label>
              <input type="text" name="classroom" id="classroom" class="form-input w-full rounded-lg" placeholder="Örn: 101">
            </div>
          </div>
          <div class="mt-4">
            <label class="block text-sm font-semibold mb-1" for="description">Açıklama</label>
            <textarea name="description" id="description" class="form-input w-full rounded-lg" rows="2"></textarea>
          </div>
          <div class="flex justify-end gap-2 mt-6">
            <button type="button" onclick="closeTimetableModal()" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold">İptal</button>
            <button type="submit" class="px-4 py-2 rounded-lg bg-[var(--accent-color)] text-white font-semibold hover:bg-[var(--secondary-color)]">Kaydet</button>
          </div>
          <div id="timetableFormMsg" class="mt-3 text-sm hidden"></div>
        </form>
      </div>
    </div>
  </div>
</main>

<script>
function openTimetableModal() {
  document.getElementById('timetableModal').classList.add('active');
  document.getElementById('timetableFormMsg').classList.add('hidden');
  document.getElementById('timetableForm').reset();
}
function closeTimetableModal() {
  document.getElementById('timetableModal').classList.remove('active');
  document.getElementById('timetableForm').reset();
  document.getElementById('timetableFormMsg').classList.add('hidden');
}
// Modal dışında bir yere tıklayınca kapansın
document.getElementById('timetableModal').addEventListener('click', function(e) {
  if (e.target === this) closeTimetableModal();
});
// Ders seçilince ders saatini ve ders_adi_id'yi otomatik doldur
function setDersSaati() {
  var select = document.getElementById('ders_id');
  var selected = select.options[select.selectedIndex];
  var dersSaati = selected.getAttribute('data-saati');
  var dersAdiId = selected.getAttribute('data-adi-id');
  document.getElementById('ders_saati').value = dersSaati || '';
  document.getElementById('ders_adi_id').value = dersAdiId || '';
}
// Form submit (AJAX ile ekleme)
document.getElementById('timetableForm').onsubmit = function(e) {
  e.preventDefault();
  var formData = new FormData(this);
  fetch('add_timetable.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    const msg = document.getElementById('timetableFormMsg');
    if (data.success) {
      msg.classList.remove('text-red-600');
      msg.classList.add('text-green-600');
      msg.textContent = "Ders başarıyla eklendi!";
      msg.classList.remove('hidden');
      setTimeout(() => {
        closeTimetableModal(); // form reset ve mesaj gizleme burada!
        location.reload();
      }, 1000);
    } else {
      msg.classList.remove('hidden', 'text-green-600');
      msg.classList.add('text-red-600');
      msg.textContent = data.message || "Kayıt eklenemedi.";
    }
  })
  .catch(() => {
    const msg = document.getElementById('timetableFormMsg');
    msg.classList.remove('hidden', 'text-green-600');
    msg.classList.add('text-red-600');
    msg.textContent = "Bir hata oluştu.";
  });
};
</script>

<?php
include_once '../partials/footer.php';
?>