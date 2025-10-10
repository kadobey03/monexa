@extends('layouts.base')

@section('title', 'Ana Sayfa')

@section('content')

<!-- Hero Section -->
<section class="relative gradient-hero wave-bg pt-10 md:pt-16 pb-14 overflow-hidden">
    <!-- Decorative background behind headline -->
    <div class="pointer-events-none absolute inset-0 -z-10">
        <img src="https://images.unsplash.com/photo-1644991287959-0f87cd9a8060?q=80&w=2000&auto=format&fit=crop" alt="background" class="absolute inset-0 w-full h-full object-cover opacity-10" />
        <div class="absolute -top-24 -left-24 h-80 w-80 rounded-full bg-emerald-500/15 blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 h-80 w-80 rounded-full bg-emerald-400/10 blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 max-w-7xl grid md:grid-cols-2 gap-10 items-center">
        <div>
            <p class="text-primary font-semibold uppercase tracking-wide mb-3">Ultimate Alım Satım Platformu</p>
            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight heading-accent headline-fix max-w-[22ch]">
                Ultimate Alım Satım Ortamınız
            </h1>
            <p class="mt-4 muted max-w-xl">
                Güvenli platform ve yeni nesil araçlarla daha akıllı işlem yapın. Gelişmiş grafikler, hızlı emir iletimi ve ayna işlemler — hem yeni başlayanlar hem profesyoneller için.
            </p>
            <div class="mt-6 flex gap-3">
                <a href="{{ route('register') }}" class="btn-primary">Kayıt Ol</a>
                <a href="{{ route('login') }}" class="btn-secondary">Giriş Yap</a>
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
                        "proName": "BIST:XU100",
                        "title": "BIST 100"
                        },
                        {
                        "proName": "SPX500",
                        "title": "S&P 500"
                        },
                        {
                        "proName": "NDX",
                        "title": "NASDAQ 100"
                        },
                        {
                        "proName": "FX:USDTRY",
                        "title": "USD/TRY"
                        },
                        {
                        "proName": "FX:EURTRY",
                        "title": "EUR/TRY"
                        },
                        {
                        "proName": "FX:GBPTRY",
                        "title": "GBP/TRY"
                        },
                        {
                        "proName": "FX:BTCTRY",
                        "title": "BTC/TRY"
                        },
                        {
                        "proName": "FX:ETHTRY",
                        "title": "ETH/TRY"
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
            <div class="card-dark p-2 sm:p-3 md:p-5 animate-float max-w-xs sm:max-w-sm md:max-w-none mx-auto md:mx-0">
                <img class="w-full h-auto rounded-xl aspect-video sm:aspect-[16/10] object-cover" loading="eager" decoding="async" alt="Trading platform screenshot" src="https://hayatestate.com/wp-content/uploads/2022/07/photo1658916471.jpeg"/>
            </div>

            <div class="absolute -bottom-6 -left-6 md:block">
                <div class="card-dark p-4 w-44">
                    <p class="text-xs text-emerald-200/80">Açık Pozisyonlar</p>
                    <p class="text-2xl font-bold text-white">+12.4%</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Partners Bar -->
<div class="bg-emerald-900/20 border-y border-emerald-900/30">
    <div class="container mx-auto px-4 py-3 overflow-hidden">
        <div class="flex gap-10 animate-ticker opacity-80">
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
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="grid md:grid-cols-2 gap-10 items-center">
            <div class="card-dark p-6">
                <div class="text-sm text-emerald-300/80">Platform Özellikleri</div>
                <h2 class="mt-2 text-2xl md:text-3xl font-extrabold heading-accent">Neden Bizimle Ticaret Yapmalısınız</h2>
                <p class="mt-3 text-emerald-100/80">Başarılı ticaret için ihtiyacınız olan her şey</p>
                <a href="{{ route('register') }}" class="btn-primary mt-6">Kayıt Ol</a>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                @php
                    $features = [
                        ['title' => 'Gelişmiş Araçlar', 'desc' => 'Profesyonel ticaret araçları'],
                        ['title' => 'Düşük Spreadler', 'desc' => 'Rekabetçi işlem koşulları'],
                        ['title' => 'Hızlı Yürütme', 'desc' => 'Milisaniyelik emir iletimi'],
                        ['title' => '7/24 Destek', 'desc' => 'Uzman müşteri hizmetleri']
                    ];
                @endphp
                @foreach($features as $feature)
                    <div class="card-dark p-5">
                        <div class="h-10 w-10 rounded-full bg-emerald-500/15 text-emerald-300 grid place-items-center mb-3">
                            <i class="fas fa-check"></i>
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
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="text-center mb-8">
            <p class="text-emerald-300/80 text-sm">Hizmetlerimiz</p>
            <h2 class="text-2xl md:text-3xl font-extrabold heading-accent">Profesyonel Ticaret Hizmetleri</h2>
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
                <div class="card-dark p-5">
                    <div class="w-16 h-16 rounded-full overflow-hidden mx-auto mb-3 border border-emerald-700/40">
                        <img src="{{ $service['img'] }}" alt="{{ $service['title'] }}" class="w-full h-full object-cover" loading="lazy"/>
                    </div>
                    <div class="text-white font-semibold text-center">{{ $service['title'] }}</div>
                    <div class="text-emerald-100/70 text-sm mt-2 text-center">{{ $service['desc'] }}</div>
                    <div class="text-center mt-2">
                        <a href="#" class="text-primary hover:underline text-sm">Devamı</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection