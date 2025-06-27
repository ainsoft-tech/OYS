<?php
include_once '../partials/header.php';

?>

            <main class="flex-1 bg-gradient-to-br from-slate-50 to-sky-100">
                <div class="container mx-auto px-6 py-16 flex flex-1 justify-center items-center min-h-[calc(100vh-80px)]">
                    <div class="layout-content-container flex flex-col items-center max-w-2xl text-center">
                        <h1 class="text-[var(--text-primary)] tracking-tight text-4xl sm:text-5xl font-bold leading-tight pb-6">
                            Okul Yönetim Sistemine <span class="text-[var(--primary-color)]">Hoş Geldiniz</span>
                        </h1>
                        <p class="text-[var(--text-secondary)] text-lg font-normal leading-relaxed pb-8">
                            Okul yönetim sistemimiz, eğitim kurumlarının tüm ihtiyaçlarını modern ve kullanıcı dostu bir
                            arayüzle karşılamak üzere tasarlanmıştır. Öğrencilerin, öğretmenlerin ve yöneticilerin
                            günlük işlerini kolaylaştırarak verimliliği artırmayı hedefler.
                        </p>
                        <div class="flex gap-4">
                            <button class="flex min-w-[120px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-[var(--primary-color)] text-white text-base font-semibold leading-normal tracking-[0.015em] hover:bg-blue-700 transition-colors duration-150 ease-in-out shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                <span class="material-icons mr-2">rocket_launch</span>
                                <span class="truncate">Başla</span>
                            </button>
                            <button class="flex min-w-[120px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-transparent border-2 border-[var(--primary-color)] text-[var(--primary-color)] text-base font-semibold leading-normal tracking-[0.015em] hover:bg-blue-50 transition-colors duration-150 ease-in-out shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                <span class="material-icons mr-2">info</span>
                                <span class="truncate">Daha Fazla Bilgi</span>
                            </button>
                        </div>
                    </div>
                </div>
            </main>
<?php
include_once 'partials/footer.php';

?>