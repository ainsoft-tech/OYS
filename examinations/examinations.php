<?php
include '../partials/header.php';
?>
    <style type="text/tailwindcss">
    :root {
        --primary-color: #0b80ee;
        --secondary-color: #f0f2f5;
        --text-primary: #111518;
        --text-secondary: #60768a;
        --border-color: #dbe1e6;
    }
    body {
        font-family: Inter, "Noto Sans", sans-serif;
    }
    .sidebar-link {
        @apply flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium leading-normal;
    }
    .sidebar-link.active {
        @apply bg-[var(--secondary-color)] text-[var(--primary-color)];
    }
    .sidebar-link:not(.active) {
        @apply text-[var(--text-primary)] hover:bg-gray-100;
    }
    .sidebar-link .icon {
        @apply text-[var(--text-primary)];
    }
    .sidebar-link.active .icon {
        @apply text-[var(--primary-color)];
    }
    .tab-link {
        @apply flex flex-col items-center justify-center pb-[13px] pt-4 border-b-[3px] text-sm font-bold leading-normal tracking-[0.015em];
    }
    .tab-link.active {
        @apply border-b-[var(--primary-color)] text-[var(--primary-color)];
    }
    .tab-link:not(.active) {
        @apply border-b-transparent text-[var(--text-secondary)] hover:text-[var(--text-primary)];
    }
    .form-label {
        @apply text-[var(--text-primary)] text-sm font-medium leading-normal pb-2;
    }
    .form-input-field {
        @apply form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[var(--text-primary)] focus:outline-0 focus:ring-2 focus:ring-[var(--primary-color)] border border-[var(--border-color)] bg-white focus:border-[var(--primary-color)] h-12 px-4 py-3 placeholder:text-[var(--text-secondary)] text-sm font-normal leading-normal;
    }
    .primary-button {
        @apply flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-6 bg-[var(--primary-color)] text-white text-sm font-bold leading-normal tracking-[0.015em] hover:bg-blue-600 transition-colors;
    }
    .table-header {
        @apply px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[var(--text-secondary)];
    }
    .table-cell {
        @apply h-[60px] px-4 py-3 text-sm font-normal leading-normal;
    }
    .navbar-link {
        @apply flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium leading-normal;
    }
    .navbar-link.active {
        @apply bg-[var(--secondary-color)] text-[var(--primary-color)];
    }
    .navbar-link:not(.active) {
        @apply text-[var(--text-primary)] hover:bg-gray-100;
    }
    .navbar-link .icon {
        @apply text-[var(--text-primary)];
    }
    .navbar-link.active .icon {
        @apply text-[var(--primary-color)];
    }
    </style>


    <main class="flex-1 bg-gray-50 p-6">
        <div class="flex flex-wrap justify-between items-center gap-3 mb-6">
            <p class="text-[var(--text-primary)] tracking-tight text-2xl font-bold leading-tight">Sınav Yönetimi
            </p>
        </div>
        <div class="mb-6">
            <div class="flex border-b border-[var(--border-color)] gap-8">
                <a class="tab-link active" href="#">
                    <p>Sınav Oluştur</p>
                </a>
                <a class="tab-link" href="#">
                    <p>Sınav Takvimi</p>
                </a>
                <a class="tab-link" href="#">
                    <p>Sınav Sonuçları</p>
                </a>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8">
            <h2 class="text-[var(--text-primary)] text-xl font-semibold leading-tight tracking-[-0.015em] mb-6">
                Sınav Ekle</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                <label class="flex flex-col">
                    <p class="form-label">Sınav Adı</p>
                    <input class="form-input-field" placeholder="Örn: Matematik 1. Dönem" value="" />
                </label>
                <label class="flex flex-col">
                    <p class="form-label">Ders</p>
                    <select class="form-input-field bg-[image:--select-button-svg]">
                        <option disabled="" selected="" value="">Ders Seçin</option>
                        <option value="matematik">Matematik</option>
                        <option value="fizik">Fizik</option>
                        <option value="kimya">Kimya</option>
                    </select>
                </label>
                
                <label class="flex flex-col">
                    <p class="form-label">Sınıf</p>
                    <select class="form-input-field bg-[image:--select-button-svg]">
                        <option disabled="" selected="" value="">Sınıf Seçin</option>
                        <option value="9a">9-A</option>
                        <option value="10b">10-B</option>
                        <option value="11c">11-C</option>
                    </select>
                </label>

                <label class="flex flex-col">
                    <p class="form-label">Sınav Tipi</p>
                    <select class="form-input-field bg-[image:--select-button-svg]">
                        <option disabled="" selected="" value="">Sınav Tipi Seçin</option>
                        <option value="9a">Yazılı</option>
                        <option value="10b">Sözlü</option>
                        <option value="11c">Test</option>
                    </select>
                </label>
                
                <label class="flex flex-col">
                    <p class="form-label">Sınav Tarihi</p>
                    <input class="form-input-field" type="date" value="" />
                </label>
                <label class="flex flex-col">
                    <p class="form-label">Sınav Saati</p>
                    <input class="form-input-field" type="time" value="" />
                </label>
            </div>
            <div class="flex justify-end mt-6">
                <button class="primary-button">
                    <span class="truncate">Sınav Ekle</span>
                </button>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h2 class="text-[var(--text-primary)] text-xl font-semibold leading-tight tracking-[-0.015em] mb-6">
                Sınav Takvimi</h2>
            <div class="overflow-x-auto @container">
                <div class="border border-[var(--border-color)] rounded-lg">
                    <table class="min-w-full divide-y divide-[var(--border-color)]">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="table-header table-4f6eef1f-9921-4af9-b887-38429df257e2-column-120">
                                    Sınav Adı
                                </th>
                                <th class="table-header table-4f6eef1f-9921-4af9-b887-38429df257e2-column-240">
                                    Ders</th>
                                <th class="table-header table-4f6eef1f-9921-4af9-b887-38429df257e2-column-360">
                                    Sınıf</th>
                                <th class="table-header table-4f6eef1f-9921-4af9-b887-38429df257e2-column-480">
                                    Tarih</th>
                                <th class="table-header table-4f6eef1f-9921-4af9-b887-38429df257e2-column-600">
                                    Saat</th>
                                <th
                                    class="table-header table-4f6eef1f-9921-4af9-b887-38429df257e2-column-720 text-right">
                                    İşlemler
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-[var(--border-color)]">
                            <tr>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-120 text-[var(--text-primary)] font-medium">
                                    Matematik 1. Dönem
                                </td>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-240 text-[var(--text-secondary)]">
                                    Matematik
                                </td>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-360 text-[var(--text-secondary)]">
                                    9-A</td>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-480 text-[var(--text-secondary)]">
                                    15/05/2024
                                </td>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-600 text-[var(--text-secondary)]">
                                    10:00</td>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-720 text-right">
                                    <button
                                        class="text-[var(--primary-color)] hover:text-blue-700 font-semibold text-sm">Düzenle</button>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-120 text-[var(--text-primary)] font-medium">
                                    Fizik 1. Dönem
                                </td>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-240 text-[var(--text-secondary)]">
                                    Fizik</td>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-360 text-[var(--text-secondary)]">
                                    10-B</td>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-480 text-[var(--text-secondary)]">
                                    16/05/2024
                                </td>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-600 text-[var(--text-secondary)]">
                                    11:00</td>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-720 text-right">
                                    <button
                                        class="text-[var(--primary-color)] hover:text-blue-700 font-semibold text-sm">Düzenle</button>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-120 text-[var(--text-primary)] font-medium">
                                    Kimya 1. Dönem
                                </td>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-240 text-[var(--text-secondary)]">
                                    Kimya</td>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-360 text-[var(--text-secondary)]">
                                    11-C</td>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-480 text-[var(--text-secondary)]">
                                    17/05/2024
                                </td>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-600 text-[var(--text-secondary)]">
                                    12:00</td>
                                <td
                                    class="table-cell table-4f6eef1f-9921-4af9-b887-38429df257e2-column-720 text-right">
                                    <button
                                        class="text-[var(--primary-color)] hover:text-blue-700 font-semibold text-sm">Düzenle</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <style>
                    @container(max-width:120px) {
                        .table-4f6eef1f-9921-4af9-b887-38429df257e2-column-120 {
                            display: none;
                        }
                    }

                    @container(max-width:240px) {
                        .table-4f6eef1f-9921-4af9-b887-38429df257e2-column-240 {
                            display: none;
                        }
                    }

                    @container(max-width:360px) {
                        .table-4f6eef1f-9921-4af9-b887-38429df257e2-column-360 {
                            display: none;
                        }
                    }

                    @container(max-width:480px) {
                        .table-4f6eef1f-9921-4af9-b887-38429df257e2-column-480 {
                            display: none;
                        }
                    }

                    @container(max-width:600px) {
                        .table-4f6eef1f-9921-4af9-b887-38429df257e2-column-600 {
                            display: none;
                        }
                    }

                    @container(max-width:720px) {
                        .table-4f6eef1f-9921-4af9-b887-38429df257e2-column-720 {
                            display: none;
                        }
                    }
                </style>
            </div>
        </div>
    </main>
            </div>
        </div>
    </div>

<?php
include '../partials/footer.php';
?>
   