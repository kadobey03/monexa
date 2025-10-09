@extends('layouts.base')
@inject('content', 'App\Http\Controllers\FrontController')
@section('title', '{{$title}}')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-gray-900 to-gray-800">
    <!-- Abstract Background Elements -->
    <div class="absolute inset-0 z-0 pointer-events-none opacity-20">
        <div class="absolute top-0 left-0 w-full h-full">
            <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="grad1" x1="50%" x2="50%" y1="0%" y2="100%">
                        <stop stop-color="#3B82F6" stop-opacity=".25" offset="0%"/>
                        <stop stop-color="#10B981" stop-opacity=".2" offset="100%"/>
                    </linearGradient>
                </defs>
                <path fill="url(#grad1)" d="M400,115 C515.46,115 615,214.54 615,330 C615,445.46 515.46,545 400,545 C284.54,545 185,445.46 185,330 C185,214.54 284.54,115 400,115 Z" />
            </svg>
        </div>
        <div class="absolute bottom-0 right-0 w-full h-full">
            <svg width="100%" height="100%" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                <g fill="none" stroke="#6366F1" stroke-width="2" opacity="0.15">
                    <path d="M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764"/>
                    <path d="M-4 44L190 190 731 737 520 660 309 538 40 599 295 764"/>
                    <path d="M-4 44L190 190 731 737M490 85L309 538 40 599 295 764"/>
                </g>
            </svg>
        </div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 px-4 py-20 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col items-center text-center">
            <div class="w-full md:w-2/3" x-data="{ isVisible: false }" x-init="setTimeout(() => { isVisible = true }, 200)">
                <div
                    x-show="isVisible"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="space-y-6"
                >
                    <div class="inline-block px-3 py-1 mb-2 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                        Gelişmiş Alım Satım Platformu
                    </div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl md:text-5xl">
                        <span class="block">cTRADER COPY</span>
                        <span class="block mt-2 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-400">Akıllı Strateji Çoğaltma</span>
                    </h1>
                    <p class="mt-3 text-lg text-gray-300 max-w-2xl mx-auto">
                        Başarılı trader'lardan başarılı alım satım stratejilerini çoğaltın. Portföyünüzü çeşitlendirin ve akıllı kopyalama alım satım platformumuzla karları maksimize edin.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4 mt-6">
                        <a href="register" class="px-6 py-3 text-base font-medium text-white bg-blue-600 rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-200">
                            Başlayın
                        </a>
                        <a href="#features" class="px-6 py-3 text-base font-medium text-gray-300 bg-gray-800 border border-gray-700 rounded-lg shadow-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-200">
                            Daha Fazla Bilgi Edinin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-20 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                Ana Özellikler
            </div>
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">Alım Satım Potansiyelinizi Artırın</span>
            </h2>
            <p class="mt-4 text-xl text-gray-300 max-w-3xl mx-auto">
                Kopyalama alım satım platformumuz, yatırım stratejinizi optimize etmenize ve getirileri maksimize etmenize yardımcı olacak yenilikçi özellikler sunar.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Feature 1 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 transform transition-all duration-300 hover:translate-y-[-5px] hover:shadow-lg">
                <div class="w-12 h-12 bg-blue-600 bg-opacity-20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">400+ Strateji Kopyala</h3>
                <p class="text-gray-300">7 varlık sınıfı genelinde 1000'den fazla enstrüman için yüzlerce stratejiye erişin, her alım satım tarzı için çeşitli fırsatlar sağlayın.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 transform transition-all duration-300 hover:translate-y-[-5px] hover:shadow-lg">
                <div class="w-12 h-12 bg-blue-600 bg-opacity-20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">En İyi Performans Gösterenleri Seçin</h3>
                <p class="text-gray-300">Stratejileri performansa göre sıralamak ve benzersiz koşullarınız için en uygun olanları seçmek için gelişmiş raporlama araçlarımızı kullanın.</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 transform transition-all duration-300 hover:translate-y-[-5px] hover:shadow-lg">
                <div class="w-12 h-12 bg-blue-600 bg-opacity-20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Korunmada Kalın</h3>
                <p class="text-gray-300">Sistemimiz, hesabınız için maruziyetinizi optimal düzeyde tutmak için sofistike hesaplamalar kullanarak yatırımlarınızı korur.</p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 transform transition-all duration-300 hover:translate-y-[-5px] hover:shadow-lg">
                <div class="w-12 h-12 bg-blue-600 bg-opacity-20 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Diğer Yöntemlerle Birleştirin</h3>
                <p class="text-gray-300">Entegre platformumuz, kopyalamayı manuel ve otomatik alım satım ile birleştirmenizi, yaklaşımınızı tercihlerinize göre uyarlamanızı sağlar.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-20 bg-gradient-to-b from-gray-900 to-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                Alım Satım Süreci
            </div>
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">Kopyalama Alım Satımı Nasıl Çalışır</span>
            </h2>
            <p class="mt-4 text-xl text-gray-300 max-w-3xl mx-auto">
                Kopyalama alım satımına sadece birkaç basit adımda başlayın
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 relative">
                <div class="absolute -top-4 -left-4 w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xl z-10">1</div>
                <div class="pt-6">
                    <h3 class="text-xl font-bold text-white mb-3">Stratejilere Göz Atın</h3>
                    <p class="text-gray-300">Alım satım stratejileri pazarımızı keşfedin. Performans metriklerine, risk seviyesine, varlık sınıfına göre filtreleyin ve yatırım hedeflerinize uygun stratejileri bulun.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 relative">
                <div class="absolute -top-4 -left-4 w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xl z-10">2</div>
                <div class="pt-6">
                    <h3 class="text-xl font-bold text-white mb-3">Seçin ve Abone Olun</h3>
                    <p class="text-gray-300">Takip etmek istediğiniz stratejileri seçin. Risk parametrelerinizi ve tahsis miktarınızı ayarlayın, böylece her stratejiye ne kadar sermaye tahsis etmek istediğinizi özelleştirin.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 relative">
                <div class="absolute -top-4 -left-4 w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xl z-10">3</div>
                <div class="pt-6">
                    <h3 class="text-xl font-bold text-white mb-3">Otomatik Alım Satım</h3>
                    <p class="text-gray-300">Abone olduktan sonra, strateji sağlayıcısının faaliyetine göre, risk ayarlarınıza ve sermaye tahsisinize göre ayarlanmış olarak işlemler hesabınızda otomatik olarak yürütülecektir.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Expert Support Section -->
<section class="py-20 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Image Column -->
            <div class="relative" x-data="{ isVisible: false }" x-init="setTimeout(() => { isVisible = true }, 300)">
                <div
                    x-show="isVisible"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 transform translate-x-8"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    class="relative z-10"
                >
                    <div class="relative rounded-lg overflow-hidden shadow-2xl">
                        <img src="temp/custom/img/commission-scheme-crypt1t.png" alt="Expert Support" class="w-full">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-teal-400 opacity-20"></div>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-blue-500 bg-opacity-20 rounded-full filter blur-xl"></div>
                    <div class="absolute -top-6 -left-6 w-24 h-24 bg-teal-500 bg-opacity-20 rounded-full filter blur-xl"></div>
                </div>
            </div>

            <!-- Content Column -->
            <div class="space-y-8" x-data="{ isVisible: false }" x-init="setTimeout(() => { isVisible = true }, 500)">
                <div
                    x-show="isVisible"
                    x-transition:enter="transition ease-out duration-700 delay-300"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                >
                    <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                        Premium Destek
                    </div>

                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl mb-6">
                        <span class="block">UZMANLARIMIZLA</span>
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-400">GÜNCEL KALIN!</span>
                    </h2>

                    <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6 mb-8">
                        <p class="text-gray-300 text-lg">
                            Yerel ve uluslararası ekiplerimiz, 20'den fazla dilde 24/5 bazında sizi desteklemek için burada, geniş ödeme yöntemleri yelpazemiz ise para yatırma ve çekme konusunda size daha fazla esneklik sağlar.
                        </p>
                    </div>

                    <h3 class="text-2xl font-bold text-white mb-4">Alım Satımdan Daha Fazlasını Yaşayın</h3>

                    <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl p-6">
                        <p class="text-gray-300 text-lg">
                            Başarımız bir dizi temel değer etrafında toplanır. Bunlar arasında sıkı spreadler aracılığıyla rekabetçi komisyon ücretleri sağlamak, şimşek hızında yürütme sağlamak, geniş ürün yelpazesiyle gelişmiş alım satım platformlarına erişim ve üstün müşteri hizmetleri bulunur.
                        </p>
                    </div>

                    <div class="mt-8">
                        <a href="about" title="Learn About {{$settings->site_name}} Trade Commissions" class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-blue-500 transition-all duration-200">
                            Daha Fazla Bilgi Edinin
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-16 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-blue-900 to-blue-800 rounded-2xl overflow-hidden shadow-xl">
            <div class="relative px-8 py-12 md:p-12 lg:px-16 lg:py-16">
                <!-- Background Pattern -->
                <div class="absolute inset-0 overflow-hidden opacity-10">
                    <svg class="absolute right-0 top-0 h-full" viewBox="0 0 800 800">
                        <path fill="none" stroke="white" stroke-width="2" d="M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764">
                        </path>
                        <path fill="none" stroke="white" stroke-width="2" d="M-4 44L190 190 731 737 520 660 309 538 40 599 295 764">
                        </path>
                        <path fill="none" stroke="white" stroke-width="2" d="M-4 44L190 190 731 737M490 85L309 538 40 599 295 764">
                        </path>
                    </svg>
                </div>

                <!-- Content -->
                <div class="relative z-10 text-center max-w-2xl mx-auto">
                    <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                        Kopyalama Alım Satımına Başlamaya Hazır mısınız?
                    </h2>
                    <p class="mt-4 text-xl text-blue-100">
                        Başarılı stratejileri çoğaltmak ve karları maksimize etmek için platformumuzu kullanan binlerce trader'a katılın.
                    </p>
                    <div class="mt-8 flex justify-center">
                        <a href="/register" class="px-8 py-4 text-base font-medium text-blue-900 bg-white border border-transparent rounded-lg shadow-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-800 transition-all duration-200">
                            Ücretsiz Hesap Oluşturun
                        </a>
                        <a href="login" class="ml-4 px-8 py-4 text-base font-medium text-white bg-transparent border border-white rounded-lg shadow-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-800 transition-all duration-200">
                            Giriş
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
