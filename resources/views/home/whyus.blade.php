
@extends('layouts.base')
@inject('content', 'App\Http\Controllers\FrontController')
@section('title', '{{$title}}')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gray-900 overflow-hidden">
    <!-- Dynamic Background -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
            <!-- Animated Grid Pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="why-us-grid" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M0 40V0h40" fill="none" stroke="currentColor" stroke-width="0.5"/>
                            <circle cx="20" cy="20" r="1" fill="currentColor"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#why-us-grid)"/>
                </svg>
            </div>
        </div>
        <!-- Glowing Accents -->
        <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-blue-500/20 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-1/4 left-1/4 w-96 h-96 bg-emerald-400/20 rounded-full filter blur-3xl"></div>
    </div>

    <div class="container mx-auto px-4 pt-24 pb-16 relative z-10">
        <div class="max-w-4xl">
            <!-- Header Content -->
            <div class="space-y-6">
                <div class="inline-block px-4 py-1 rounded-full bg-blue-500/10 border border-blue-500/20">
                    <p class="text-sm font-medium text-blue-400">Mükemmeli Seçin</p>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight">
                    Neden <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">{{$settings->site_name}}</span>'yi Seçmelisiniz?
                </h1>

                <!-- Breadcrumb -->
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{$settings->site_address}}" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <a href="#" class="text-gray-400 hover:text-white ml-1 md:ml-2 transition-colors">Şirket</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-300 ml-1 md:ml-2">Neden Biz</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<script type="application/ld+json">
{
    "@@context": "http://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@@type": "ListItem",
            "position": 1,
            "item": {
                "@@id": "{{$settings->site_address}}",
                "name": "{{$settings->site_name}}"
            }
        },
        {
            "@@type": "ListItem",
            "position": 2,
            "item": {
                "@@id": "{{$settings->site_address}}company",
                "name": "Şirket"
            }
        },
        {
            "@@type": "ListItem",
            "position": 3,
            "item": {
                "@@id": "{{$settings->site_address}}/why-us",
                "name": "Neden Biz"
            }
        }
    ]
}</script>

<!-- Features Grid Section -->
<section class="py-16 bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Reliable -->
            <div class="group">
                <div class="relative h-full">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-emerald-400/5 rounded-xl transition-all duration-300 group-hover:scale-105"></div>
                    <div class="relative h-full p-6 bg-gray-800 rounded-xl border border-gray-700 transition-all duration-300 hover:border-blue-500/50">
                        <div class="w-16 h-16 mx-auto mb-6 bg-blue-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4">Güvenilir</h3>
                        <p class="text-gray-300">Piyasadaki en keskin yürütme özelliğine sahip olan {{$settings->site_name}} cTrader, emirlerinizi yeniden fiyatlandırma veya fiyat manipülasyonu olmadan milisaniyeler içinde doldurur.</p>
                    </div>
                </div>
            </div>

            <!-- Intelligent -->
            <div class="group">
                <div class="relative h-full">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-blue-400/5 rounded-xl transition-all duration-300 group-hover:scale-105"></div>
                    <div class="relative h-full p-6 bg-gray-800 rounded-xl border border-gray-700 transition-all duration-300 hover:border-emerald-500/50">
                        <div class="w-16 h-16 mx-auto mb-6 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4">Akıllı</h3>
                        <p class="text-gray-300">Trading Central'den gelen akıllı piyasa analiz araçları, canlı duyarlılık verileri ve platform içi piyasa içgörüleri ile bilinçli kararlar alın.</p>
                    </div>
                </div>
            </div>

            <!-- Transparent -->
            <div class="group">
                <div class="relative h-full">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-emerald-400/5 rounded-xl transition-all duration-300 group-hover:scale-105"></div>
                    <div class="relative h-full p-6 bg-gray-800 rounded-xl border border-gray-700 transition-all duration-300 hover:border-blue-500/50">
                        <div class="w-16 h-16 mx-auto mb-6 bg-blue-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4">Şeffaf</h3>
                        <p class="text-gray-300">Performansınızı kristal netliğinde anlamak için işlem istatistiklerine, özkaynak grafiklerine ve işlemlerinizin detaylı geçmişine erişin.</p>
                    </div>
                </div>
            </div>

            <!-- Intuitive -->
            <div class="group">
                <div class="relative h-full">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-blue-400/5 rounded-xl transition-all duration-300 group-hover:scale-105"></div>
                    <div class="relative h-full p-6 bg-gray-800 rounded-xl border border-gray-700 transition-all duration-300 hover:border-emerald-500/50">
                        <div class="w-16 h-16 mx-auto mb-6 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4">Sezgisel</h3>
                        <p class="text-gray-300">Kullanımı ve gezinmesi kolay olan {{$settings->site_name}} Trader, gerçek trader'ların ihtiyaçları göz önünde bulundurularak geliştirildi. {{$settings->site_name}} cTrader ile işlem yapın ve farklı avantajını deneyimleyin.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trust Indicators Section -->
<section class="py-16 bg-gray-900 relative overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-emerald-400/5"></div>
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="trust-grid" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 40V0h40" fill="none" stroke="currentColor" stroke-width="0.5"/>
                        <circle cx="20" cy="20" r="1" fill="currentColor"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#trust-grid)"/>
            </svg>
        </div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">Güven Göstergeleri</span>
            </h2>
            <p class="text-lg text-gray-300">Güçlü işlem platformumuzla güvenliğinizi ve emniyetinizi ön planda tutuyoruz.</p>
        </div>

    </div>
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Globally Regulated -->
            <div class="group">
                <div class="relative h-full">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-emerald-400/5 rounded-xl transition-all duration-300 group-hover:scale-105"></div>
                    <div class="relative h-full p-6 bg-gray-800 rounded-xl border border-gray-700 transition-all duration-300 hover:border-blue-500/50">
                        <div class="w-16 h-16 mx-auto mb-6 bg-blue-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0 0h3m-3 0H9m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4">Küresel Olarak Düzenlenmiş</h3>
                        <p class="text-gray-300">Üst düzey finansal otoriteler tarafından düzenleniyoruz ve devlet destekleri ile fonlarınızın güvende olduğunu garanti ediyoruz.</p>
                    </div>
                </div>
            </div>

            <!-- International Awards -->
            <div class="group">
                <div class="relative h-full">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-blue-400/5 rounded-xl transition-all duration-300 group-hover:scale-105"></div>
                    <div class="relative h-full p-6 bg-gray-800 rounded-xl border border-gray-700 transition-all duration-300 hover:border-emerald-500/50">
                        <div class="w-16 h-16 mx-auto mb-6 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0 0h3m-3 0H9m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4">40+ Uluslararası Ödül</h3>
                        <p class="text-gray-300">İşlem hizmetleri ve müşteri desteğindeki mükemmelliğimiz ile dünya çapında tanınıyoruz. Devlet destekli projelerimizle sektörde lider konumdayız.</p>
                    </div>
                </div>
            </div>
            
            <!-- 24/7 Support -->
            <div class="group">
                <div class="relative h-full">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-emerald-400/5 rounded-xl transition-all duration-300 group-hover:scale-105"></div>
                    <div class="relative h-full p-6 bg-gray-800 rounded-xl border border-gray-700 transition-all duration-300 hover:border-blue-500/50">
                        <div class="w-16 h-16 mx-auto mb-6 bg-blue-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0 0h3m-3 0H9m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4">7/24 Destek</h3>
                        <p class="text-gray-300">Adanmış destek ekibimiz, herhangi bir işlem ihtiyacınız veya sorunuz için 7/24 hizmetinizdedir.</p>
                    </div>
                </div>
            </div>

            <!-- Secure Transactions -->
            <div class="group">
                <div class="relative h-full">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-blue-400/5 rounded-xl transition-all duration-300 group-hover:scale-105"></div>
                    <div class="relative h-full p-6 bg-gray-800 rounded-xl border border-gray-700 transition-all duration-300 hover:border-emerald-500/50">
                        <div class="w-16 h-16 mx-auto mb-6 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0 0h3m-3 0H9m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-4">Güvenli İşlemler</h3>
                        <p class="text-gray-300">Tüm işlemler gelişmiş şifreleme protokolleri ile güvence altına alınır ve devlet destekli güvenlik standartları ile verileriniz ve fonlarınız her zaman korunur.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





@endsection
