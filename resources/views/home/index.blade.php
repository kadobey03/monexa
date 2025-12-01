@extends('layouts.base')
@section('pageTitle', 'Ana Sayfa')

@section('title', 'Ana Sayfa')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-emerald-900/20 to-gray-900 pt-10 md:pt-16 pb-14 overflow-hidden">
    <!-- Decorative background behind headline -->
    <div class="pointer-events-none absolute inset-0 -z-10">
        <img src="https://img.freepik.com/premium-photo/bull-market-stock-index-colorful-price-spike-upward_1190272-3919.jpg?semt=ais_hybrid&w=740&q=80" alt="background" class="absolute inset-0 w-full h-full object-cover opacity-10" />
        <div class="absolute -top-24 -left-24 h-80 w-80 rounded-full bg-emerald-500/15 blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 h-80 w-80 rounded-full bg-emerald-400/10 blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid md:grid-cols-2 gap-10 items-center">
        <div>
            <p class="text-emerald-400 font-semibold uppercase tracking-wide mb-3">Ultimate Alım Satım Platformu</p>
            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight text-white max-w-[22ch]">
                Ultimate Alım Satım Ortamınız
            </h1>
            <p class="mt-4 text-gray-300 max-w-xl">
                Güvenli platform ve yeni nesil araçlarla daha akıllı işlem yapın. Gelişmiş grafikler, hızlı emir iletimi ve ayna işlemler — hem yeni başlayanlar hem profesyoneller için.
            </p>
            <div class="mt-6 flex gap-3">
                <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 transform hover:scale-105">Kayıt Ol</a>
                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-gray-600 hover:border-gray-500 text-gray-300 hover:text-white font-medium rounded-lg transition-colors duration-200">Giriş Yap</a>
            </div>
            <!-- Market Ticker -->
            <div class="mt-10">
                <!-- TradingView Widget BEGIN -->
                <div class="tradingview-widget-container">
                    <div class="tradingview-widget-container__widget"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
                    {
                        "symbols": [
                            {
                                "proName": "BINANCE:BTCUSDT",
                                "title": "Bitcoin"
                            },
                            {
                                "proName": "BINANCE:ETHUSDT",
                                "title": "Ethereum"
                            },
                            {
                                "proName": "BINANCE:BNBUSDT",
                                "title": "BNB"
                            },
                            {
                                "proName": "FX:EURUSD",
                                "title": "EUR/USD"
                            },
                            {
                                "proName": "FX:GBPUSD",
                                "title": "GBP/USD"
                            },
                            {
                                "proName": "NASDAQ:AAPL",
                                "title": "Apple"
                            },
                            {
                                "proName": "NASDAQ:TSLA",
                                "title": "Tesla"
                            },
                            {
                                "proName": "TVC:GOLD",
                                "title": "Gold"
                            }
                        ],
                        "showSymbolLogo": true,
                        "colorTheme": "dark",
                        "isTransparent": false,
                        "displayMode": "adaptive",
                        "locale": "tr"
                    }
                    </script>
                </div>
                <!-- TradingView Widget END -->
            </div>
        </div>

        <div class="hidden md:block relative md:mt-0">
            <div class="bg-gray-800 border border-gray-700 p-2 sm:p-3 md:p-5 rounded-xl animate-pulse max-w-xs sm:max-w-sm md:max-w-none mx-auto md:mx-0">
                <img class="w-full h-auto rounded-xl aspect-video sm:aspect-[16/10] object-cover" loading="eager" decoding="async" alt="Trading platform screenshot" src="https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?q=80&w=800&auto=format&fit=crop&ixlib=rb-4.0.3"/>
            </div>

            <div class="absolute -bottom-6 -left-6 md:block">
                <div class="bg-gray-800 border border-gray-700 p-4 rounded-lg w-44">
                    <p class="text-xs text-emerald-200/80">Açık Pozisyonlar</p>
                    <p class="text-2xl font-bold text-white">+12.4%</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Partners Bar -->
<div class="bg-emerald-900/20 border-y border-emerald-900/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 overflow-hidden">
        <div class="flex gap-10 animate-pulse opacity-80">
            @php
                $base = ['Netlify', 'Webflow', 'Coinbase', 'Spotify', 'Slack', 'Facebook', 'Netlify'];
                $items = [];
                foreach($base as $name) {
                    $items[] = ['name' => $name, 'price' => 5 + rand(0, 245)];
                }
                $itemsTwice = array_merge($items, $items);
            @endphp
            @foreach($itemsTwice as $item)
                <span class="text-emerald-300/80 text-sm">
                    {{ $item['name'] }} ${{ number_format($item['price'], 2) }}
                </span>
            @endforeach
        </div>
    </div>
</div>

<!-- Benefits Section -->
<section class="py-12 bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-10 items-center">
            <div class="bg-gray-800 border border-gray-700 p-6 rounded-xl">
                <div class="text-sm text-emerald-300/80">Devlet Destekli Platform</div>
                <h2 class="mt-2 text-2xl md:text-3xl font-extrabold bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">Neden Devlet Destekli Platformumuzu Tercih Etmelisiniz</h2>
                <p class="mt-3 text-emerald-100/80">Türkiye Cumhuriyeti tarafından desteklenen güvenli finans platformu ile yatırımlarınızı büyütün</p>
                <div class="mt-4 p-3 bg-emerald-900/30 rounded-lg border border-emerald-700/50">
                    <p class="text-emerald-200 text-sm">
                        <i class="fas fa-shield-alt text-emerald-400 mr-2"></i>
                        <strong>SPK Lisanslı ve Devlet Denetimli:</strong> Sermaye Piyasası Kurulu tarafından lisanslanmış ve devlet kurumları tarafından denetlenmektedir.
                    </p>
                </div>
                <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 transform hover:scale-105 mt-6">Kayıt Ol</a>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                @php
                    $features = [
                        ['title' => 'Devlet Garantisi', 'desc' => 'Türkiye Cumhuriyeti tarafından desteklenen güvenli yatırım ortamı'],
                        ['title' => 'SPK Lisanslı', 'desc' => 'Sermaye Piyasası Kurulu denetiminde şeffaf işlemler'],
                        ['title' => 'Yerli Sermaye', 'desc' => 'Türk ekonomisine katkı sağlayan milli platform'],
                        ['title' => 'Devlet Teşviki', 'desc' => 'Vergi avantajları ve devlet desteklerinden faydalanın']
                    ];
                @endphp
                @foreach($features as $feature)
                    <div class="bg-gray-800 border border-gray-700 p-5 rounded-xl">
                        <div class="h-10 w-10 rounded-full bg-emerald-500/15 text-emerald-300 grid place-items-center mb-3">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="text-white font-semibold">{{ $feature['title'] }}</div>
                        <div class="text-emerald-100/70 text-sm mt-1">{{ $feature['desc'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-12 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <p class="text-emerald-300/80 text-sm">Hizmetlerimiz</p>
            <h2 class="text-2xl md:text-3xl font-extrabold bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">Profesyonel Ticaret Hizmetleri</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @php
                $services = [
                    [
                        'title' => 'Algoritmik Trading',
                        'img' => 'https://images.unsplash.com/photo-1555421689-491a97ff2040?q=80&w=800&auto=format&fit=crop',
                        'desc' => 'İşlemlerinizin otomatik emir altyapısı ile kural bazlı yürütülmesi.'
                    ],
                    [
                        'title' => 'Mobil Servisler',
                        'img' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=800&auto=format&fit=crop',
                        'desc' => 'Piyasaları anlık takip edin, pay senedi/varant/viop işlemlerini hızlı ve güvenli yapın.'
                    ],
                    [
                        'title' => 'Yatırım Fonları İşlemleri',
                        'img' => 'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?q=80&w=800&auto=format&fit=crop',
                        'desc' => 'Birikimlerinizi profesyonel yöneticiler ile çeşitli sermaye araçlarında değerlendirin.'
                    ],
                    [
                        'title' => 'Devlet Destekli',
                        'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSDBrBvxvWYQhuhkLCTyic3o4V1aOKjlJHOgQ&s',
                        'desc' => 'Devlet Desteği İle Kazanın.'
                    ],
                    [
                        'title' => 'Forex İşlemleri',
                        'img' => 'https://albyatirim.com.tr/uploads/blogs/71d8a78831894bd3b9bdbb0da46a563f.jpg',
                        'desc' => 'Kaldıraçlı alım satım ve döviz çiftlerinde 7/24 erişim.'
                    ],
                    [
                        'title' => 'Türev Araçları',
                        'img' => 'https://images.unsplash.com/photo-1559526324-593bc073d938?q=80&w=800&auto=format&fit=crop',
                        'desc' => 'Riskten korunma veya getiri artırımı için futures, opsiyon ve yapılandırılmış ürünler.'
                    ],
                    [
                        'title' => 'Hazine Borçlanma Araçları',
                        'img' => 'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?q=80&w=800&auto=format&fit=crop',
                        'desc' => 'Sabit getirili menkul kıymetlerde tercih ve vade uyumlu yatırım.'
                    ],
                    [
                        'title' => 'Varlık Yönetimi',
                        'img' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=800&auto=format&fit=crop',
                        'desc' => 'Uzman ekiple hedeflerinize uygun portföy stratejileri ve raporlama.'
                    ]
                ];
            @endphp
            @foreach($services as $service)
                <div class="bg-gray-800 border border-gray-700 p-5 rounded-xl">
                    <div class="w-16 h-16 rounded-full overflow-hidden mx-auto mb-3 border border-emerald-700/40">
                        <img src="{{ $service['img'] }}" alt="{{ $service['title'] }}" class="w-full h-full object-cover" loading="lazy"/>
                    </div>
                    <div class="text-white font-semibold text-center">{{ $service['title'] }}</div>
                    <div class="text-emerald-100/70 text-sm mt-2 text-center">{{ $service['desc'] }}</div>
                    <div class="text-center mt-2">
                        <a href="#" class="text-emerald-400 hover:underline text-sm">Devamı</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Türkiye Piyasaları Section -->
<section class="py-12 bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-3xl font-extrabold bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent mb-4">Türkiye Piyasaları</h2>
            <div class="max-w-4xl mx-auto">
                <h3 class="text-lg md:text-xl font-semibold text-white mb-4">Bu Şirketlerde İşlem Yapabilirsiniz</h3>
                <p class="text-emerald-100/80 mb-6">
                    Baykar, Koç, Türkiye Petrolleri, Aselsan, Havelsan ve Togg gibi yerli liderlerde pozisyon açın.
                    Her yatırım ülke ekonomisine katkıdır; destek olurken kazanç potansiyelini keşfedin.
                    Bağımsız uzmanlarla çalışarak bilinçli kararlar verin.
                </p>

                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gray-800 border border-gray-700 p-5 rounded-xl">
                        <div class="text-emerald-300 font-semibold mb-2">Devlete Destek</div>
                        <div class="text-emerald-100/70 text-sm">
                            Yerli şirketlere yatırım ekonomiye kaynak sağlar, sürdürülebilir büyümeye katkı sunar.
                        </div>
                    </div>
                    <div class="bg-gray-800 border border-gray-700 p-5 rounded-xl">
                        <div class="text-emerald-300 font-semibold mb-2">Desteklerken Kazanç</div>
                        <div class="text-emerald-100/70 text-sm">
                            Uzun vadeli değer yaratımından faydalanırken portföyünüzü büyütme fırsatı.
                        </div>
                    </div>
                    <div class="bg-gray-800 border border-gray-700 p-5 rounded-xl">
                        <div class="text-emerald-300 font-semibold mb-2">Bağımsız Uzmanlar</div>
                        <div class="text-emerald-100/70 text-sm">
                            Araştırma ve risk yönetiminde uzman ekiple objektif bakış açısı.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Şirket Kartları -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $companies = [
                    [
                        'name' => 'Baykar',
                        'symbol' => 'BAYKAR',
                        'price' => '485.08',
                        'change' => '-1.01',
                        'isPositive' => false,
                        'logo' => 'https://idsb.tmgrup.com.tr/ly/uploads/images/2025/02/02/366619.jpg'
                    ],
                    [
                        'name' => 'Koç Holding',
                        'symbol' => 'KCHOL',
                        'price' => '473.78',
                        'change' => '+0.35',
                        'isPositive' => true,
                        'logo' => 'https://bursaajansi.com/wp-content/uploads/2024/05/koc-holding-o-sektore-giris-yapiyor-milyarlarca-dolar-yatirim-yapacaklar-IRAEw5Sw.jpg'
                    ],
                    [
                        'name' => 'Türkiye Petrolleri',
                        'symbol' => 'TPAO',
                        'price' => '68.41',
                        'change' => '+0.92',
                        'isPositive' => true,
                        'logo' => 'https://beypet.com/storage/420/WhatsApp-Image-2024-08-14-at-14.50.54-(2).jpeg.jpeg'
                    ],
                    [
                        'name' => 'Aselsan',
                        'symbol' => 'ASELS',
                        'price' => '173.44',
                        'change' => '-0.43',
                        'isPositive' => false,
                        'logo' => 'https://image.hurimg.com/i/hurriyet/75/0x0/68c11a9f292d8a4321ac6929.jpg'
                    ],
                    [
                        'name' => 'Havelsan',
                        'symbol' => 'HAVELSAN',
                        'price' => '337.97',
                        'change' => '+1.99',
                        'isPositive' => true,
                        'logo' => 'https://www.savunmasanayist.com/wp-content/uploads/2022/05/HAVELSAN-780x470.jpg'
                    ],
                    [
                        'name' => 'Togg',
                        'symbol' => 'TOGG',
                        'price' => '388.28',
                        'change' => '+1.42',
                        'isPositive' => true,
                        'logo' => 'https://nextcar.ua/images/blog/548/265874.jpg'
                    ]
                ];
            @endphp

            @foreach($companies as $company)
                <div class="bg-gray-800 border border-gray-700 hover:scale-105 transition-transform duration-300 overflow-hidden rounded-xl">
                    <!-- Ana Resim -->
                    <div class="relative h-32 bg-gradient-to-br from-emerald-600/20 to-emerald-800/20 mb-3">
                        <img src="{{ $company['logo'] }}" alt="{{ $company['name'] }}" class="w-full h-full object-cover" loading="lazy"/>

                        <!-- Sol üst köşedeki logo/balon -->
                        <div class="absolute top-2 left-2">
                            <div class="w-8 h-8 rounded-full bg-emerald-500/80 backdrop-blur-sm border border-emerald-400/50 flex items-center justify-center">
                                <div class="w-4 h-4 rounded-full bg-white/90"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Kart bilgileri -->
                    <div class="p-4">
                        <div class="text-white font-semibold text-sm mb-2">{{ $company['name'] }}</div>

                        <div class="mb-3">
                            <div class="text-xl font-bold text-white">${{ number_format($company['price'], 2) }}</div>
                            <div class="flex items-center gap-1 {{ $company['isPositive'] ? 'text-emerald-400' : 'text-red-400' }}">
                                <i class="fas fa-{{ $company['isPositive'] ? 'caret-up' : 'caret-down' }} text-xs"></i>
                                <span class="text-sm font-medium">{{ $company['change'] }}%</span>
                            </div>
                        </div>

                        <a href="/giris" class="inline-flex items-center px-6 py-3 border border-gray-600 hover:border-gray-500 text-gray-300 hover:text-white font-medium rounded-lg transition-colors duration-200 w-full justify-center">
                            İşlem Yap
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Sık Sorulan Sorular Section -->
<section class="py-12 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-3xl font-extrabold bg-gradient-to-r from-emerald-400 to-blue-400 bg-clip-text text-transparent">Sık Sorulan Sorular</h2>
            <p class="text-emerald-100/80 mt-2">Hesaplar, yatırma ve platform özellikleri hakkında</p>
        </div>

        <div class="space-y-4">
            <!-- Soru 1: Devlet destekli mi? -->
            <div class="faq-item bg-gray-800 border border-gray-700 rounded-xl hover:border-emerald-600/50 transition-all duration-300 hover:shadow-lg">
                <div class="faq-header p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-white font-semibold text-lg flex items-center">
                            <span class="w-8 h-8 bg-emerald-600 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">1</span>
                            Devlet destekli mi?
                        </h3>
                        <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-all duration-200 p-2 rounded-lg hover:bg-emerald-600/10">
                            <i class="fas fa-chevron-down text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="faq-answer pl-6 pr-6 pb-6">
                    <div class="bg-gray-700/50 p-4 rounded-lg border-l-4 border-emerald-500">
                        <p class="mb-3">✅ <strong>Evet, platformumuz devlet destekli bir finansal hizmet sağlayıcısıdır.</strong></p>
                        <p class="mb-2 text-emerald-100/80">• Türkiye Cumhuriyeti Sermaye Piyasası Kurulu (SPK) denetiminde</p>
                        <p class="mb-2 text-emerald-100/80">• İlgili devlet kurumları tarafından desteklenmekte</p>
                        <p class="text-emerald-100/80">• Kullanıcılarımıza güvenli ve regüle edilmiş yatırım ortamı sunuyoruz</p>
                    </div>
                </div>
            </div>

            <!-- Soru 2: Kayıp yaşayabilir miyim? -->
            <div class="faq-item bg-gray-800 border border-gray-700 rounded-xl hover:border-emerald-600/50 transition-all duration-300 hover:shadow-lg">
                <div class="faq-header p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-white font-semibold text-lg flex items-center">
                            <span class="w-8 h-8 bg-orange-600 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">2</span>
                            Kayıp yaşayabilir miyim?
                        </h3>
                        <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-all duration-200 p-2 rounded-lg hover:bg-emerald-600/10">
                            <i class="fas fa-chevron-down text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="faq-answer pl-6 pr-6 pb-6">
                    <div class="bg-gray-700/50 p-4 rounded-lg border-l-4 border-orange-500">
                        <p class="mb-3">⚠️ <strong>Tüm finansal işlemlerde kayıp riski vardır, ancak:</strong></p>
                        <p class="mb-2 text-emerald-100/80">• Gelişmiş risk yönetimi araçlarımız ile riskleri minimize ediyoruz</p>
                        <p class="mb-2 text-emerald-100/80">• Başarı oranımız %85'in üzerindedir</p>
                        <p class="mb-2 text-emerald-100/80">• Uzman destek ekibimiz 7/24 sizinle</p>
                        <p class="text-emerald-100/80">• Kayıp durumunda özel destek hizmetleri sunuyoruz</p>
                    </div>
                </div>
            </div>

            <!-- Soru 3: Uzmanlar kimler? -->
            <div class="faq-item bg-gray-800 border border-gray-700 rounded-xl hover:border-emerald-600/50 transition-all duration-300 hover:shadow-lg">
                <div class="faq-header p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-white font-semibold text-lg flex items-center">
                            <span class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">3</span>
                            Uzmanlar kimler?
                        </h3>
                        <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-all duration-200 p-2 rounded-lg hover:bg-emerald-600/10">
                            <i class="fas fa-chevron-down text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="faq-answer pl-6 pr-6 pb-6">
                    <div class="bg-gray-700/50 p-4 rounded-lg border-l-4 border-blue-500">
                        <p class="mb-3">👨‍💼 <strong>Uzman Ekibimiz:</strong></p>
                        <p class="mb-2 text-emerald-100/80">• 15+ yıllık deneyime sahip lisanslı finansal analistler</p>
                        <p class="mb-2 text-emerald-100/80">• Eski banka çalışanları ve sermaye piyasası uzmanları</p>
                        <p class="mb-2 text-emerald-100/80">• Yapay zeka destekli algoritmalarımız 7/24 piyasa analizi yapar</p>
                        <p class="text-emerald-100/80">• Tüm uzmanlarımız SPK lisansına sahiptir</p>
                    </div>
                </div>
            </div>

            <!-- Soru 4: Ne kadar kazanacağım? -->
            <div class="faq-item bg-gray-800 border border-gray-700 rounded-xl hover:border-emerald-600/50 transition-all duration-300 hover:shadow-lg">
                <div class="faq-header p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-white font-semibold text-lg flex items-center">
                            <span class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">4</span>
                            Ne kadar kazanacağım?
                        </h3>
                        <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-all duration-200 p-2 rounded-lg hover:bg-emerald-600/10">
                            <i class="fas fa-chevron-down text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="faq-answer pl-6 pr-6 pb-6">
                    <div class="bg-gray-700/50 p-4 rounded-lg border-l-4 border-green-500">
                        <p class="mb-3">💰 <strong>Kazanç Potansiyeli:</strong></p>
                        <p class="mb-2 text-emerald-100/80">• <span class="text-green-400 font-bold">Minimum paketler:</span> Aylık %15-25 getiri</p>
                        <p class="mb-2 text-emerald-100/80">• <span class="text-yellow-400 font-bold">VIP paketler:</span> Aylık %40'a kadar getiri</p>
                        <p class="mb-2 text-emerald-100/80">• Kazanç geçmişinizi hesap panelinizden takip edebilirsiniz</p>
                        <p class="text-emerald-100/80">⚡ <em>Not: Kazançlar piyasa koşulları ve seçilen plana göre değişir</em></p>
                    </div>
                </div>
            </div>

            <!-- Soru 5: Devlet neden destek veriyor? -->
            <div class="faq-item bg-gray-800 border border-gray-700 rounded-xl hover:border-emerald-600/50 transition-all duration-300 hover:shadow-lg">
                <div class="faq-header p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-white font-semibold text-lg flex items-center">
                            <span class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">5</span>
                            Devlet neden destek veriyor?
                        </h3>
                        <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-all duration-200 p-2 rounded-lg hover:bg-emerald-600/10">
                            <i class="fas fa-chevron-down text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="faq-answer pl-6 pr-6 pb-6">
                    <div class="bg-gray-700/50 p-4 rounded-lg border-l-4 border-purple-500">
                        <p class="mb-3">🇹🇷 <strong>Devlet Desteğinin Sebepleri:</strong></p>
                        <p class="mb-2 text-emerald-100/80">• Yerli finansal teknolojilerin gelişmesi</p>
                        <p class="mb-2 text-emerald-100/80">• Uluslararası platformlara bağımlılığın azalması</p>
                        <p class="mb-2 text-emerald-100/80">• Yerli şirketlere yatırımla ekonomik büyümeye katkı</p>
                        <p class="text-emerald-100/80">• Düşük maliyetli hizmet sunabilme imkanı</p>
                    </div>
                </div>
            </div>

            <!-- Soru 6: Komisyon ve ücretler -->
            <div class="faq-item bg-gray-800 border border-gray-700 rounded-xl hover:border-emerald-600/50 transition-all duration-300 hover:shadow-lg">
                <div class="faq-header p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-white font-semibold text-lg flex items-center">
                            <span class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">6</span>
                            Komisyon ve ücretler nelerdir?
                        </h3>
                        <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-all duration-200 p-2 rounded-lg hover:bg-emerald-600/10">
                            <i class="fas fa-chevron-down text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="faq-answer pl-6 pr-6 pb-6">
                    <div class="bg-gray-700/50 p-4 rounded-lg border-l-4 border-red-500">
                        <p class="mb-3">💳 <strong>Ücret Tarifeleri:</strong></p>
                        <p class="mb-2 text-emerald-100/80">• <span class="text-yellow-400 font-bold">İşlem komisyonu:</span> %0.1 - %0.5 arası</p>
                        <p class="mb-2 text-emerald-100/80">• <span class="text-green-400 font-bold">Para yatırma/çekme:</span> ÜCRETSİZ</p>
                        <p class="mb-2 text-emerald-100/80">• VIP üyelerde özel indirimler</p>
                        <p class="text-emerald-100/80">✨ Sürpriz maliyet yok, tüm ücretler şeffaf!</p>
                    </div>
                </div>
            </div>

            <!-- Soru 7: Veriler nereden geliyor? -->
            <div class="faq-item bg-gray-800 border border-gray-700 rounded-xl hover:border-emerald-600/50 transition-all duration-300 hover:shadow-lg">
                <div class="faq-header p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-white font-semibold text-lg flex items-center">
                            <span class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">7</span>
                            Veriler nereden geliyor?
                        </h3>
                        <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-all duration-200 p-2 rounded-lg hover:bg-emerald-600/10">
                            <i class="fas fa-chevron-down text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="faq-answer pl-6 pr-6 pb-6">
                    <div class="bg-gray-700/50 p-4 rounded-lg border-l-4 border-indigo-500">
                        <p class="mb-3">📊 <strong>Veri Kaynaklarımız:</strong></p>
                        <p class="mb-2 text-emerald-100/80">• Borsa İstanbul - anlık piyasa verileri</p>
                        <p class="mb-2 text-emerald-100/80">• Uluslararası borsalar</p>
                        <p class="mb-2 text-emerald-100/80">• Bloomberg Terminal entegrasyonu</p>
                        <p class="mb-2 text-emerald-100/80">• Kendi geliştirdiğimiz yapay zeka algoritmaları</p>
                        <p class="text-emerald-100/80">🔒 Tüm veriler SSL şifreleme ile korunur</p>
                    </div>
                </div>
            </div>

            <!-- Soru 8: Para yatırma/çekme -->
            <div class="faq-item bg-gray-800 border border-gray-700 rounded-xl hover:border-emerald-600/50 transition-all duration-300 hover:shadow-lg">
                <div class="faq-header p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-white font-semibold text-lg flex items-center">
                            <span class="w-8 h-8 bg-teal-600 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">8</span>
                            Nasıl para yatırır/çekerim?
                        </h3>
                        <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-all duration-200 p-2 rounded-lg hover:bg-emerald-600/10">
                            <i class="fas fa-chevron-down text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="faq-answer pl-6 pr-6 pb-6">
                    <div class="bg-gray-700/50 p-4 rounded-lg border-l-4 border-teal-500">
                        <p class="mb-3">💰 <strong>Ödeme Yöntemleri:</strong></p>
                        <p class="mb-2 text-emerald-100/80">• Havale/EFT - 7/24 işlem</p>
                        <p class="mb-2 text-emerald-100/80">• Kredi kartı - anlık onay</p>
                        <p class="mb-2 text-emerald-100/80">• Kripto para - hızlı transfer</p>
                        <p class="mb-2 text-emerald-100/80">• <span class="text-yellow-400 font-bold">Minimum:</span> ₺1.000</p>
                        <p class="mb-2 text-emerald-100/80">• <span class="text-green-400 font-bold">Para çekme:</span> Maks. 24 saat</p>
                        <p class="text-emerald-100/80">⚡ VIP üyeler öncelikli işlem hakkına sahiptir</p>
                    </div>
                </div>
            </div>

            <!-- Soru 9: Hesap kapatma -->
            <div class="faq-item bg-gray-800 border border-gray-700 rounded-xl hover:border-emerald-600/50 transition-all duration-300 hover:shadow-lg">
                <div class="faq-header p-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-white font-semibold text-lg flex items-center">
                            <span class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">9</span>
                            Hesabımı nasıl kapatırım?
                        </h3>
                        <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-all duration-200 p-2 rounded-lg hover:bg-emerald-600/10">
                            <i class="fas fa-chevron-down text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="faq-answer pl-6 pr-6 pb-6">
                    <div class="bg-gray-700/50 p-4 rounded-lg border-l-4 border-gray-500">
                        <p class="mb-3">🔒 <strong>Hesap Kapatma İşlemi:</strong></p>
                        <p class="mb-2 text-emerald-100/80">• Profil ayarları veya müşteri hizmetlerinden</p>
                        <p class="mb-2 text-emerald-100/80">• Önce açık pozisyonları kapatın ve bakiyenizi çekin</p>
                        <p class="mb-2 text-emerald-100/80">• İşlem süresi: 7 gün</p>
                        <p class="mb-2 text-emerald-100/80">• 7 gün süre zarfında cayma hakkınız var</p>
                        <p class="text-emerald-100/80">🛡️ Tüm verileriniz güvenli şekilde silinir</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Styles -->
<style>
.faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s ease-in-out, opacity 0.3s ease-in-out, padding 0.3s ease-in-out;
    opacity: 0;
    padding-top: 0;
    padding-bottom: 0;
}

.faq-answer.active {
    max-height: 500px;
    opacity: 1;
    padding-top: 1rem;
    padding-bottom: 1.5rem;
}

.faq-item {
    transition: all 0.3s ease-in-out;
}

.faq-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.15);
}

.faq-toggle {
    transition: transform 0.3s ease-in-out;
}

.faq-toggle.rotated {
    transform: rotate(180deg);
}

.faq-header {
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.faq-header:hover {
    background-color: rgba(16, 185, 129, 0.05);
}

.faq-item.active {
    border-color: rgba(16, 185, 129, 0.6);
    box-shadow: 0 4px 20px rgba(16, 185, 129, 0.1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tüm FAQ elemanlarını seç
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const header = item.querySelector('.faq-header');
        const toggle = item.querySelector('.faq-toggle');
        const answer = item.querySelector('.faq-answer');
        const icon = toggle.querySelector('i');
        
        // Başlangıçta tüm cevapları gizli yap
        answer.classList.remove('active');
        
        // Header'a click event'i ekle
        header.addEventListener('click', function(e) {
            e.preventDefault();
            
            const isCurrentlyActive = answer.classList.contains('active');
            
            // Tüm diğer FAQ'ları kapat
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    const otherAnswer = otherItem.querySelector('.faq-answer');
                    const otherToggle = otherItem.querySelector('.faq-toggle');
                    const otherIcon = otherToggle.querySelector('i');
                    
                    otherAnswer.classList.remove('active');
                    otherToggle.classList.remove('rotated');
                    otherItem.classList.remove('active');
                    otherIcon.classList.remove('fa-chevron-up');
                    otherIcon.classList.add('fa-chevron-down');
                }
            });
            
            // Mevcut FAQ'yı toggle et
            if (!isCurrentlyActive) {
                // Aç
                answer.classList.add('active');
                toggle.classList.add('rotated');
                item.classList.add('active');
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                // Kapat
                answer.classList.remove('active');
                toggle.classList.remove('rotated');
                item.classList.remove('active');
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        });
        
        // Toggle button'a da aynı işlevi ekle
        toggle.addEventListener('click', function(e) {
            e.stopPropagation(); // Header click'ini tetiklememek için
            header.click(); // Header'ın click'ini tetikle
        });
    });
});
</script>

@endsection