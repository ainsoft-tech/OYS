<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8" />
    <link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect" />
    <link as="style"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
        onload="this.rel='stylesheet'" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <title>Okul Yönetim Sistemi</title>
    <link href="data:image/x-icon;base64," rel="icon" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="../css/styles.css">
    <style type="text/tailwindcss">
        
        .btn-primary {
            @apply flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-6 bg-[var(--primary-color)] text-[var(--secondary-color)] text-sm font-bold leading-normal tracking-[0.015em] transition-colors duration-200 hover:bg-opacity-80;
        }
        .section-title {
            @apply text-[var(--primary-color)] text-3xl font-bold leading-tight tracking-tight text-center;
        }
        .card {
            @apply bg-[var(--secondary-color)] rounded-xl shadow-lg overflow-hidden transition-shadow duration-300 hover:shadow-xl;
        }
        .footer-link {
            @apply text-[var(--neutral-text)] text-base font-normal leading-normal min-w-40 transition-colors duration-200 hover:text-[var(--accent-color)];
        }
        .slider-container {
            position: relative;
            width: 100%;
            height: calc(100vh - 80px);
            min-height: 500px;
            max-height: 700px;
            overflow: hidden;
        }
        .slider-wrapper {
            display: flex;
            transition: transform 0.5s ease-in-out;
            height: 100%;
        }
        .slide {
            min-width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 20;
            background-color: rgba(0, 0, 0, 0.3);
            color: var(--secondary-color);
            border: none;
            padding: 0.75rem;
            cursor: pointer;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }
        .slider-nav:hover {
            background-color: rgba(0, 0, 0, 0.6);
        }
        .slider-nav-prev {
            left: 1rem;
        }
        .slider-nav-next {
            right: 1rem;
        }
        @keyframes slide-animation {
            0%, 28% { transform: translateX(0%); }
            33%, 61% { transform: translateX(-100%); }
            66%, 94% { transform: translateX(-200%); }
            100% { transform: translateX(0%); }
        }
        .slider-wrapper-animated {
            animation: slide-animation 15s infinite;}
    </style>
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
                        
                        <a class="nav-link flex items-center" href="#">Ana Sayfa</a>
                        <a class="nav-link flex items-center" href="#">Hakkımızda</a>
                        <a class="nav-link flex items-center" href="#">Akademik</a>
                        <a class="nav-link flex items-center" href="#">Etkinlikler</a>
                        <a class="nav-link flex items-center" href="#">İletişim</a>
                    
                    <div class="flex items-center gap-4">
                        <button class="btn-primary"><a href="login.php">
                            <span class="truncate">Giriş Yap</span>
                        </a></button>
                        <button aria-label="Menüyü aç"
                            class="lg:hidden p-2 rounded-md text-[var(--primary-color)] hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[var(--accent-color)]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6h16M4 12h16m-7 6h7" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"></path>
                            </svg>
                        </button>
                    </div>            


                    </nav>
                </div>
            </header>

            <main class="flex-1">
                <section class="slider-container" id="image-slider">
                    <div class="slider-wrapper slider-wrapper-animated">
                        <div class="slide"
                            style='background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0.1) 50%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuCTuURWq9O7niVWOu8v_RpCd5UBc11hsoYamQB15bwxPtWTSNTbEpctjX-ea6YRMm7hzpcp14fYK0wcZbrtQg7rQIGO5AacafNRavxtuAOieX-nz19-ORGNi8xLmQ9sjc_F11LZIWR8ph1xfRv_T7KpK_M0QB4wsCfg6LKENLK4Q4P85SISUJoq7IKb_8dWBZhW5r787qoKzxy2enftCdoTH7_IhfSnCSf7HnRCCeHZc0YIq4q5LT8Zf__eIOf_SsOFQGgmxUYsWFkF");'>
                            <div
                                class="relative z-10 flex h-full flex-col items-center justify-center text-center text-[var(--secondary-color)] p-6">
                                <h2 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">Modern Eğitimin Adresi
                                </h2>
                                <p class="text-lg md:text-xl max-w-2xl mb-8">
                                    Yenilikçi yaklaşımlarımız ve güçlü akademik kadromuzla geleceğe yön veriyoruz.
                                </p>
                                <a class="btn-primary bg-[var(--accent-color)] hover:bg-blue-700 px-8 py-3 text-lg"
                                    href="#">Daha Fazla Bilgi</a>
                            </div>
                        </div>
                        <div class="slide"
                            style='background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0.1) 50%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuC-y0_4R0Vp3Z5XOXeBdeDlARdiqX5VnEj5AiVWlSFXis2Z1yBnv5OQhUa1m4t4VWKryVK9NN-raRJbNbNnUGAhaJllotVsS_l0sgLC_YBTzoiEkO5ZiBS9KPdDnWAh2XWZIpvUAEZd1IiWD6hEn7nmnGE2qSnIrCZIyQ707eFPbkZQX2stTJ_U3WB4fX75ARyQG1VDQw219i-DjXu-t_eMcBKjGxMd-zwKpcSOrA062E4_se3Jq6qNS20a7pcBNCWHmxfhgZjSl0Qs");'>
                            <div
                                class="relative z-10 flex h-full flex-col items-center justify-center text-center text-[var(--secondary-color)] p-6">
                                <h2 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">Parlak Bir Gelecek İçin
                                </h2>
                                <p class="text-lg md:text-xl max-w-2xl mb-8">
                                    Öğrencilerimizi bilgi ve beceriyle donatarak hayallerine ulaştırıyoruz.
                                </p>
                                <a class="btn-primary bg-[var(--accent-color)] hover:bg-blue-700 px-8 py-3 text-lg"
                                    href="#">Programlarımızı Keşfedin</a>
                            </div>
                        </div>
                        <div class="slide"
                            style='background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0.1) 50%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuC-y0_4R0Vp3Z5XOXeBdeDlARdiqX5VnEj5AiVWlSFXis2Z1yBnv5OQhUa1m4t4VWKryVK9NN-raRJbNbNnUGAhaJllotVsS_l0sgLC_YBTzoiEkO5ZiBS9KPdDnWAh2XWZIpvUAEZd1IiWD6hEn7nmnGE2qSnIrCZIyQ707eFPbkZQX2stTJ_U3WB4fX75ARyQG1VDQw219i-DjXu-t_eMcBKjGxMd-zwKpcSOrA062E4_se3Jq6qNS20a7pcBNCWHmxfhgZjSl0Qs");'>
                            <div
                                class="relative z-10 flex h-full flex-col items-center justify-center text-center text-[var(--secondary-color)] p-6">
                                <h2 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">İlham Veren Ortam</h2>
                                <p class="text-lg md:text-xl max-w-2xl mb-8">
                                    Destekleyici ve motive edici bir atmosferde öğrenmenin keyfini çıkarın.
                                </p>
                                <a class="btn-primary bg-[var(--accent-color)] hover:bg-blue-700 px-8 py-3 text-lg"
                                    href="#">Kampüs Turu</a>
                            </div>
                        </div>
                    </div>
                    <button aria-label="Önceki Slayt" class="slider-nav slider-nav-prev">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            </path>
                        </svg>
                    </button>
                    <button aria-label="Sonraki Slayt" class="slider-nav slider-nav-next">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            </path>
                        </svg>
                    </button>
                    <div class="absolute bottom-5 left-1/2 z-20 flex -translate-x-1/2 space-x-2">
                        <button aria-label="Slayt 1"
                            class="h-2 w-2 rounded-full bg-[var(--secondary-color)] ring-2 ring-transparent focus:outline-none focus:ring-[var(--accent-color)] transition-all"></button>
                        <button aria-label="Slayt 2"
                            class="h-2 w-2 rounded-full bg-[var(--secondary-color)] bg-opacity-50 ring-2 ring-transparent focus:outline-none focus:ring-[var(--accent-color)] transition-all"></button>
                        <button aria-label="Slayt 3"
                            class="h-2 w-2 rounded-full bg-[var(--secondary-color)] bg-opacity-50 ring-2 ring-transparent focus:outline-none focus:ring-[var(--accent-color)] transition-all"></button>
                    </div>
                </section>
                <section class="py-16 lg:py-24 bg-[var(--neutral-bg)]">
                    <div class="container mx-auto px-6 lg:px-10">
                        <h2 class="section-title mb-6">Okulumuza Hoş Geldiniz</h2>
                        <p
                            class="text-[var(--neutral-text)] text-lg font-normal leading-relaxed text-center max-w-3xl mx-auto mb-12">
                            Okulumuz, öğrencilerin akademik ve kişisel gelişimine odaklanan, yenilikçi bir eğitim
                            kurumudur. Deneyimli kadromuz ve modern tesislerimizle, öğrencilerimize en iyi
                            eğitim ortamını sunmayı hedefliyoruz.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <div class="card">
                                <div class="w-full h-56 bg-center bg-no-repeat bg-cover"
                                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAKsqB2bRs3b9AesJ4pNOg-ZwzDMCEoH_a_6eXnUiW_-JHO5oMaUpwqU0YWf5Db6XqK8soE_gF2JLPN6lS21pe-lyuzcXbzxitgyxlvUu6eznVdtKEYZ99_G6jrUpKAV-kRDslcB-bZ2IPX2817GxERkp8JrduaCLIb_1eB1LZNPYBvzbqP8uhJRHVjfOBQI5KxXB2uo1Z2mSm9kMosHOYhQIiGkKC9ySH0nQ3_LzWPZXOFm1GlkTc5senarSH_WtFBrPZjSym2cunQ");'>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-[var(--primary-color)] text-xl font-semibold leading-tight mb-2">
                                        Akademik Programlar</h3>
                                    <p class="text-[var(--neutral-text)] text-sm font-normal leading-normal">Geniş ve
                                        kapsamlı akademik programlarımızla öğrencilerimizin başarısını destekliyoruz.
                                    </p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="w-full h-56 bg-center bg-no-repeat bg-cover"
                                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAB4S-AhVDhulF5k-ODBo4z0ZufNW9r1CRZZZG8hSBeNZJmp2Zhv5f3ePzRt8Eaoe68j6uX7GNULJYEsp6l0YTr6734yXtGEbEtajHK88flsqyVCDeTFV-7pVQa5ZveLa_9WDG-YOyRweScomnDMw3EHQo4srr9wDFzB0r9qii5xKgxaEDfpvCej3cfiGr5DP_mZFlV8U0q24xl03_laA3xnaxo8paj8TihYUhMl5mcxTdM0gRUsxtvTmU-U4UvMkoTRWD_rx94JxVz");'>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-[var(--primary-color)] text-xl font-semibold leading-tight mb-2">
                                        Sosyal Etkinlikler</h3>
                                    <p class="text-[var(--neutral-text)] text-sm font-normal leading-normal">
                                        Öğrencilerimizin sosyal gelişimine katkıda bulunan çeşitli etkinlikler ve
                                        kulüplerle dolu bir okul hayatı sunuyoruz.
                                    </p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="w-full h-56 bg-center bg-no-repeat bg-cover"
                                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDRlI49S5QJZPOYeA-sGmOyOs2vLATLf1MhwXUFWX7H1rAAhkREjPl9zlV37nHaqdqIHdrn_jkGrPAopmUheyfrzfIlWXjkLrza1Q6vG_R5COR4OxXBhsIzpzidwLegHl5pa-8EBQR6PhpDFTL4bAL1GBHonwXA5PXLbRw9rKz9l28DklJdzNA8IJ0Igbae1VGlNhqmD4Mo2QNaBGrnLnPTNekeAN3cvhwRLW-KU1trrtbd1U0zX5p-2JFL-xdMAxRbJMzD1Ipu4j58");'>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-[var(--primary-color)] text-xl font-semibold leading-tight mb-2">
                                        Spor Faaliyetleri</h3>
                                    <p class="text-[var(--neutral-text)] text-sm font-normal leading-normal">Spor
                                        faaliyetleriyle öğrencilerimizin fiziksel sağlığını ve takım ruhunu
                                        geliştiriyoruz.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
            <footer class="bg-[var(--secondary-color)] border-t border-[var(--border-color)]">
                <div class="container mx-auto px-6 py-10 lg:px-10 text-center">
                    <div
                        class="flex flex-col md:flex-row flex-wrap items-center justify-center gap-6 mb-6 @[480px]:justify-around">
                        <a class="footer-link" href="#">Gizlilik Politikası</a>
                        <a class="footer-link" href="#">Kullanım Koşulları</a>
                        <a class="footer-link" href="#">İletişim</a>
                    </div>
                    <p class="text-[var(--neutral-text)] text-sm leading-normal">© 2023 Okul Yönetim Sistemi. Tüm
                        hakları saklıdır.</p>
                </div>
            </footer>
        </div>
    </div>
    <script>
        const slider = document.getElementById('image-slider');
        const sliderWrapper = slider.querySelector('.slider-wrapper');
        const slides = slider.querySelectorAll('.slide');
        const prevButton = slider.querySelector('.slider-nav-prev');
        const nextButton = slider.querySelector('.slider-nav-next');
        const dots = slider.querySelectorAll('.absolute.bottom-5 button');
        let currentIndex = 0;
        const slideCount = slides.length;
        let autoSlideInterval;
        function updateSlider() {
            sliderWrapper.style.transform = `translateX(-${currentIndex * 100}%)`;
            dots.forEach((dot, index) => {
                dot.classList.toggle('bg-opacity-50', index !== currentIndex);
                dot.classList.toggle('bg-[var(--secondary-color)]', index === currentIndex);
            });
        }
        function nextSlide() {
            currentIndex = (currentIndex + 1) % slideCount;
            updateSlider();
        }
        function prevSlide() {
            currentIndex = (currentIndex - 1 + slideCount) % slideCount;
            updateSlider();
        }
        function goToSlide(index) {
            currentIndex = index;
            updateSlider();
        }
        function startAutoSlide() {
            // Clear existing interval if any
            if (autoSlideInterval) {
                clearInterval(autoSlideInterval);
            }
            // Remove animation class to prevent conflict
            sliderWrapper.classList.remove('slider-wrapper-animated');
            autoSlideInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
        }
        function stopAutoSlideAndRestartAnimation() {
            clearInterval(autoSlideInterval);
            sliderWrapper.classList.add('slider-wrapper-animated'); // Re-add for CSS animation
        }
        // Initial setup for CSS animation
        if (sliderWrapper.classList.contains('slider-wrapper-animated')) {
            // If CSS animation is active, manual controls pause it and switch to JS control
            prevButton.addEventListener('click', () => {
                sliderWrapper.classList.remove('slider-wrapper-animated');
                prevSlide();
                startAutoSlide(); // Restart JS-based auto slide
            });
            nextButton.addEventListener('click', () => {
                sliderWrapper.classList.remove('slider-wrapper-animated');
                nextSlide();
                startAutoSlide();
            });
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    sliderWrapper.classList.remove('slider-wrapper-animated');
                    goToSlide(index);
                    startAutoSlide();
                });
            });
        } else {
            // Fallback or if CSS animation is not preferred for some reason
            prevButton.addEventListener('click', () => {
                prevSlide();
                startAutoSlide();
            });
            nextButton.addEventListener('click', () => {
                nextSlide();
                startAutoSlide();
            });
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    goToSlide(index);
                    startAutoSlide();
                });
            });
            startAutoSlide(); // Start JS auto slide if no CSS animation
        }
        // Update dots based on CSS animation progress (approximate)
        // This is tricky with pure CSS animation. For precise dot updates, JS-driven animation is better.
        // The current CSS animation will cycle through slides. The dots won't perfectly sync with the CSS animation
        // without more complex JS to monitor the animation state.
        // For simplicity, this example assumes the CSS animation handles visual transitions, and dots are largely decorative
        // or updated by manual interaction.
        // If you prefer JS to control the animation entirely for better dot syncing:
        // 1. Remove 'slider-wrapper-animated' class and the @keyframes rule.
        // 2. Uncomment the `startAutoSlide()` call above this comment block.
        // 3. `updateSlider` will then accurately reflect the current slide for dots.
    </script>
</body>

</html>