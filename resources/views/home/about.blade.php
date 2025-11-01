
@extends('layouts.master', ['layoutType' => 'base'])
@inject('content', 'App\Http\Controllers\FrontController')
@section('title', 'Hakkımızda')

@section('content')

<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-gray-900 to-gray-800">
    <!-- Abstract Background Elements -->
    <div class="absolute inset-0 z-20 md:z-0 pointer-events-none">
        <div class="absolute top-0 left-0 w-full h-full opacity-60 md:opacity-20">
            <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="a" x1="50%" x2="50%" y1="0%" y2="100%">
                        <stop stop-color="#3B82F6" stop-opacity=".25" offset="0%"/>
                        <stop stop-color="#10B981" stop-opacity=".2" offset="100%"/>
                    </linearGradient>
                </defs>
                <path fill="url(#a)" d="M400,115 C515.46,115 615,214.54 615,330 C615,445.46 515.46,545 400,545 C284.54,545 185,445.46 185,330 C185,214.54 284.54,115 400,115 Z" transform="translate(0 -50)" />
                <path fill="url(#a)" d="M400,115 C515.46,115 615,214.54 615,330 C615,445.46 515.46,545 400,545 C284.54,545 185,445.46 185,330 C185,214.54 284.54,115 400,115 Z" transform="translate(350 150)" />
            </svg>
        </div>
        <div class="absolute bottom-0 right-0 w-full h-full opacity-50 md:opacity-10">
            <svg width="100%" height="100%" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
                <g fill="none" stroke="#6366F1" stroke-width="2">
                    <path d="M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764"/>
                    <path d="M-4 44L190 190 731 737 520 660 309 538 40 599 295 764"/>
                    <path d="M-4 44L190 190 731 737M490 85L309 538 40 599 295 764"/>
                    <path d="M733 738L520 660M603 493L731 737M520 660L309 538"/>
                </g>
            </svg>
        </div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                Şirketimiz
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl md:text-5xl">
                <span class="block">{{$settings->site_name}} Hakkında</span>
                <span class="block mt-1 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-400">Herkese alım satımı mümkün kılıyoruz</span>
            </h1>
            <p class="max-w-2xl mt-5 mx-auto text-xl text-gray-300">
                İnovasyon, güvenlik ve üstün hizmet aracılığıyla dünyanın en güvenilir alım satım platformu olma misyonumuzu keşfedin
            </p>
        </div>
    </div>
</section>

<!-- Our Values Section -->
<section class="py-16 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-white">Değerlerimiz</h2>
            <div class="w-24 h-1 mx-auto mt-4 rounded-full bg-gradient-to-r from-blue-500 to-teal-400"></div>
        </div>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
            <!-- Value Card 1 -->
            <div class="relative group" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                <!-- Card Background Glow Effect -->
                <div class="absolute inset-0 bg-gradient-to-b from-blue-600/20 to-blue-800/5 rounded-xl transform group-hover:scale-105 transition-all duration-300 opacity-0 group-hover:opacity-100"></div>

                <!-- Card Content -->
                <div class="relative bg-gray-800 bg-opacity-80 backdrop-blur-sm rounded-xl overflow-hidden border border-gray-700 p-6 transition-all duration-300 group-hover:border-blue-500 group-hover:shadow-lg group-hover:shadow-blue-900/20 h-full flex flex-col items-center">
                    <div class="w-20 h-20 mb-6 bg-blue-900 bg-opacity-30 rounded-full flex items-center justify-center">
                        <img src="temp/custom/img/users.png" alt="Client Focus" class="w-10 h-10">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Müşteri Odaklı</h3>
                    <p class="text-gray-300 text-center">En iyi müşteri hizmetini sağlamak temel değerimizdir. 100'den fazla hesap yöneticisi müşterilerimizin ihtiyaçlarına odaklanmıştır.</p>
                </div>
            </div>

            <!-- Value Card 2 -->
            <div class="relative group" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                <div class="absolute inset-0 bg-gradient-to-b from-blue-600/20 to-blue-800/5 rounded-xl transform group-hover:scale-105 transition-all duration-300 opacity-0 group-hover:opacity-100"></div>
                <div class="relative bg-gray-800 bg-opacity-80 backdrop-blur-sm rounded-xl overflow-hidden border border-gray-700 p-6 transition-all duration-300 group-hover:border-blue-500 group-hover:shadow-lg group-hover:shadow-blue-900/20 h-full flex flex-col items-center">
                    <div class="w-20 h-20 mb-6 bg-blue-900 bg-opacity-30 rounded-full flex items-center justify-center">
                        <img src="temp/custom/img/website.png" alt="Simplicity" class="w-10 h-10">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Basitlik</h3>
                    <p class="text-gray-300 text-center">Herkes en kolay kullanımlı alım satım platformumuzla trader olabilir. {{$settings->site_name}} tüm modern platformlarda mevcuttur: Web, Windows, MacOS, iPhone, iPad ve Android.</p>
                </div>
            </div>

            <!-- Value Card 3 -->
            <div class="relative group" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                <div class="absolute inset-0 bg-gradient-to-b from-blue-600/20 to-blue-800/5 rounded-xl transform group-hover:scale-105 transition-all duration-300 opacity-0 group-hover:opacity-100"></div>
                <div class="relative bg-gray-800 bg-opacity-80 backdrop-blur-sm rounded-xl overflow-hidden border border-gray-700 p-6 transition-all duration-300 group-hover:border-blue-500 group-hover:shadow-lg group-hover:shadow-blue-900/20 h-full flex flex-col items-center">
                    <div class="w-20 h-20 mb-6 bg-blue-900 bg-opacity-30 rounded-full flex items-center justify-center">
                        <img src="temp/custom/img/speed.png" alt="Speed" class="w-10 h-10">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Hız</h3>
                    <p class="text-gray-300 text-center">En son teknolojileri kullanarak en hızlı alım satımı sağlıyoruz. Sipariş yürütmelerinde gecikme ve kullanıcı arayüzünde takılma yok.</p>
                </div>
            </div>

            <!-- Value Card 4 -->
            <div class="relative group" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                <div class="absolute inset-0 bg-gradient-to-b from-blue-600/20 to-blue-800/5 rounded-xl transform group-hover:scale-105 transition-all duration-300 opacity-0 group-hover:opacity-100"></div>
                <div class="relative bg-gray-800 bg-opacity-80 backdrop-blur-sm rounded-xl overflow-hidden border border-gray-700 p-6 transition-all duration-300 group-hover:border-blue-500 group-hover:shadow-lg group-hover:shadow-blue-900/20 h-full flex flex-col items-center">
                    <div class="w-20 h-20 mb-6 bg-blue-900 bg-opacity-30 rounded-full flex items-center justify-center">
                        <img src="temp/custom/img/1497835.png" alt="Reliability" class="w-10 h-10">
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Güvenilirlik</h3>
                    <p class="text-gray-300 text-center">Endüstri lideri olarak müşterilerimize ekstra sağlamlık sağlıyoruz. Müşterilerimizin ihtiyaçlarını karşılamak için herkesten daha fazlasını yapıyoruz.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-16 bg-gray-800 relative overflow-hidden">
    <!-- Background pattern -->
    <div class="absolute inset-0 z-0 opacity-5">
        <svg width="100%" height="100%" viewBox="0 0 800 800" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse">
                    <path d="M 50 0 L 0 0 0 50" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)" />
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white">{{$settings->site_name}} Neden Dünyanın En Güvenilir Markalarından Biri?</h2>
            <div class="w-24 h-1 mx-auto mt-4 rounded-full bg-gradient-to-r from-blue-500 to-teal-400"></div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 items-center">
            <div class="w-full lg:w-1/2">
                <div class="bg-gray-900 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden shadow-lg">
                    <img src="temp/custom/img/commission-scheme-crypt1d.png" alt="Trading Platform" class="w-full h-auto">
                </div>
            </div>

            <div class="w-full lg:w-1/2">
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-lg font-medium text-white">Küresel Düzenleme</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-lg font-medium text-white">40+ Uluslararası Ödül</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-lg font-medium text-white">24/7 Çok Dilli Müşteri Desteği</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-lg font-medium text-white">Ayrılmış Müşteri Fonları</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-lg font-medium text-white">Kişisel Hesap Yöneticileri</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-lg font-medium text-white">Tutarlı Dar Spreadler</p>
                        </div>
                    </li>
                </ul>

                <div class="mt-8">
                    <a href="login" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        Komisyonlarımız Hakkında Bilgi Edinin
                        <svg class="ml-2 -mr-1 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section class="py-16 bg-gray-900 relative overflow-hidden">
    <!-- Background image with overlay -->
    <div class="absolute inset-0 z-0 opacity-20" style="background-image: url(temp/custom/img/abt.png); background-position: center; background-repeat: no-repeat; background-size: cover;"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white">Hakkımızda</h2>
            <div class="w-24 h-1 mx-auto mt-4 rounded-full bg-gradient-to-r from-blue-500 to-teal-400"></div>
        </div>

        <div class="bg-gray-800 bg-opacity-70 backdrop-blur-sm rounded-2xl border border-gray-700 shadow-xl overflow-hidden p-6 md:p-10">
            <div class="prose prose-lg prose-invert max-w-none">
                <p>
                    {{$settings->site_name}} endüstride en saygın brokerlerden biri haline geldi ve traderlara Forex, Hisse Senetleri, Emtialar ve Vadeli İşlemler alanlarında CFD'ler sunuyor. Forex piyasasında alım satım, gelir elde etmenin yasal ve doğrudan bir yolu. Ve iyi haber, para kazanmak için profesyonel bir trader olmanız gerekmiyor. Sadece doğru kişiliğe ve doğru beceri setine sahip olmak yeterli; yabancı borsalarda alım satım yaparak para kazanabilirsiniz.
                </p>
                <p>
                    {{$settings->site_name}} size en uygun şekilde alım satım yapmanızı sağlar. Az mı çok mu risk almak istiyorsunuz? Kısa vadede mi yoksa uzun vadede mi kazanç istiyorsunuz? Günlük trader, swing trader mi yoksa scalper misiniz? Deneyimli mi yoksa su test eden acemi mi? Önemli değil çünkü {{$settings->site_name}} kontrolü size verir.
                </p>
                <p>
                    Bugünkü başarınızı kontrol edebiliyor ve yarının kararlılığını bulutlandırmıyorsanız, muhtemelen döviz trader'ı olarak para kazanmak sizde var. Forex'teki ödüller kesinlikle parlak ama günü akılcılık ve ısrar kazanıyor. Doğru araçlar, bilgi ve dünyanın tüm para birimlerine erişimle {{$settings->site_name}} yaptığınız işlemleri kontrol etmenizi sağlar.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Expert Support Section -->
<section class="py-16 bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col-reverse lg:flex-row gap-8 items-center">
            <!-- Left side: Image -->
            <div class="w-full lg:w-1/2">
                <div class="relative">
                    <!-- Decorative elements -->
                    <div class="absolute -top-4 -left-4 w-24 h-24 bg-blue-500 opacity-20 rounded-full blur-xl"></div>
                    <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-teal-400 opacity-20 rounded-full blur-xl"></div>

                    <!-- Image -->
                    <div class="relative bg-gray-900 bg-opacity-50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden shadow-lg">
                        <img src="temp/custom/img/commission-scheme-crypt1t.png" alt="Expert Support" class="w-full h-auto">
                    </div>
                </div>
            </div>

            <!-- Right side: Content -->
            <div class="w-full lg:w-1/2 space-y-8">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-4">UZMANLARIMIZLA GÜNCEL KALIN!</h2>
                    <p class="text-gray-300">
                        Yerel ve uluslararası ekiplerimiz, 20'den fazla dilde 24/5 bazında sizi desteklemek için burada, geniş ödeme yöntemleri yelpazemiz ise para yatırma ve çekme konusunda size daha fazla esneklik sağlar.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-white mb-4">Alım Satımdan Daha Fazlasını Yaşayın</h2>
                    <p class="text-gray-300">
                        Başarımız bir dizi temel değer etrafında toplanır. Bunlar arasında sıkı spreadler aracılığıyla rekabetçi komisyon ücretleri sağlamak, şimşek hızında yürütme sağlamak, geniş ürün yelpazesiyle gelişmiş alım satım platformlarına erişim ve üstün müşteri hizmetleri bulunur.
                    </p>
                </div>

                <div class="pt-6">
                    <a href="register" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                        Şimdi Alım Satıma Başla
                        <svg class="ml-2 -mr-1 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

