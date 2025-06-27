<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Okul Yönetim Sistemi</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script> 
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Swiper.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .swiper-pagination-bullet-active {
            background-color: #4B5563; 
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900">

<!-- Header -->
<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-indigo-700">Okul Yönetim Sistemi</h1>
        <nav class="space-x-6 hidden md:flex">
            <a href="#" class="hover:text-indigo-600 transition">Anasayfa</a>
            <a href="#" class="hover:text-indigo-600 transition">Hakkımızda</a>
            <a href="#" class="hover:text-indigo-600 transition">İletişim</a>
			<a href="login.php" class="hover:text-indigo-600 transition">Kullanıcı Giriş</a>
        </nav>
        <button class="md:hidden focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>
</header>

<!-- Slider (Jumbotron) -->
<section class="relative overflow-hidden mt-6 bg-gray-900">
    <div id="slider" class="swiper-container w-full h-[600px]">
        <div class="swiper-wrapper">

            <!-- Slide 1 -->
            <div class="swiper-slide bg-cover bg-center" style="background-image: url('https://picsum.photos/id/1015/1920/800');"> 
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                    <div class="text-center text-white px-6 max-w-3xl">
                        <h2 class="text-4xl md:text-5xl font-extrabold mb-4">Öğrenme Geleceğini Şekillendirir</h2>
                        <p class="text-lg md:text-xl mb-8">Modern ve etkileşimli bir eğitim sistemiyle öğrencilerin başarılarını takip edin.</p>
                        <a href="#content-section" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold px-6 py-3 rounded-lg shadow-md transition transform hover:scale-105">
                            Duyurular & Etkinlikler
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="swiper-slide bg-cover bg-center" style="background-image: url('https://picsum.photos/id/1016/1920/800');"> 
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                    <div class="text-center text-white px-6 max-w-3xl">
                        <h2 class="text-4xl md:text-5xl font-extrabold mb-4">Veriye Dayalı Eğitim Yönetimi</h2>
                        <p class="text-lg md:text-xl mb-8">Gelişmiş raporlama ve analiz araçlarıyla eğitim sürecini optimize edin.</p>
                        <a href="#content-section" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold px-6 py-3 rounded-lg shadow-md transition transform hover:scale-105">
                            Duyurular & Etkinlikler
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Navigation Buttons -->
        <div class="absolute inset-y-0 left-0 flex items-center pl-4 z-10">
            <button id="prevBtn" class="bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-70 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
        </div>
        <div class="absolute inset-y-0 right-0 flex items-center pr-4 z-10">
            <button id="nextBtn" class="bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-70 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <!-- Pagination -->
        <div class="swiper-pagination absolute bottom-4 left-1/2 transform -translate-x-1/2"></div>
    </div>
</section>

<!-- Content Section (Duyurular + Etkinlikler) -->
<section id="content-section" class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            <!-- Duyurular Alanı -->
            <div class="bg-gray-100 rounded-xl shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Son Duyurular</h2>
                <div class="space-y-4">
                    <?php
                    // Örnek duyurular (ileride veritabanından çekilecek)
                    $duyurular = [
                        ["tarih" => "2025-04-05", "baslik" => "Yaz Dönemi Başvuruları Başladı", "icerik" => "Lütfen başvuru kılavuzuna göz atarak gerekli evrakları yükleyin."],
                        ["tarih" => "2025-04-03", "baslik" => "Sınıf Değişikliği Tarihi Bildirimi", "icerik" => "Tüm sınıflar için değişiklik tarihi 15 Nisan olarak belirlendi."],
                        ["tarih" => "2025-04-01", "baslik" => "Okul İdare Toplantısı", "icerik" => "İlköğretim kademesinde yapılan toplantıda kararlar paylaşıldı."]
                    ];

                    foreach ($duyurular as $d) {
                        echo '
                        <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-blue-500">
                            <span class="text-sm text-gray-500">' . $d['tarih'] . '</span>
                            <h3 class="font-semibold text-gray-800 mt-1">' . $d['baslik'] . '</h3>
                            <p class="text-sm text-gray-600 mt-2">' . $d['icerik'] . '</p>
                        </div>';
                    }
                    ?>
                </div>
            </div>

            <!-- Etkinlikler Alanı -->
            <div class="bg-gray-100 rounded-xl shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Yaklaşan Etkinlikler</h2>
                <div class="space-y-4">
                    <?php
                    // Örnek etkinlikler (ileride veritabanından çekilecek)
                    $etkinlikler = [
                        ["tarih" => "2025-04-10", "baslik" => "Kültür Haftası Açılışı", "yer" => "Ana Bina Konferans Salonu"],
                        ["tarih" => "2025-04-15", "baslik" => "Veli Toplantısı", "yer" => "A Blok Toplantı Odası"],
                        ["tarih" => "2025-04-20", "baslik" => "Okul Spor Şenliği", "yer" => "Futbol Sahası"]
                    ];

                    foreach ($etkinlikler as $e) {
                        echo '
                        <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-green-500">
                            <span class="text-sm text-gray-500">' . $e['tarih'] . '</span>
                            <h3 class="font-semibold text-gray-800 mt-1">' . $e['baslik'] . '</h3>
                            <p class="text-sm text-gray-600 mt-2">📍 ' . $e['yer'] . '</p>
                        </div>';
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-6 text-center">
        <p>&copy; 2025 Okul Yönetim Sistemi. Tüm Hakları Saklıdır.</p>
    </div>
</footer>

<!-- Swiper.js JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script> 
<!-- Slider Initialization -->
<script>
    const swiper = new Swiper('.swiper-container', {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 0,
        autoplay: {
            delay: 5000,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });

    // Manuel gezinme butonları
    document.getElementById('prevBtn').addEventListener('click', () => {
        swiper.slidePrev();
    });

    document.getElementById('nextBtn').addEventListener('click', () => {
        swiper.slideNext();
    });
</script>

</body>
</html>