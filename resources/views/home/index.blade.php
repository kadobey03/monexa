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
                Ultimate Alım Satım Ortamınız2
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
                <img class="w-full h-auto rounded-xl aspect-video sm:aspect-[16/10] object-cover" loading="eager" decoding="async" alt="Trading platform screenshot" src="https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?q=80&w=800&auto=format&fit=crop&ixlib=rb-4.0.3"/>
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
                <div class="text-sm text-emerald-300/80">Devlet Destekli Platform</div>
                <h2 class="mt-2 text-2xl md:text-3xl font-extrabold heading-accent">Neden Devlet Destekli Platformumuzu Tercih Etmelisiniz</h2>
                <p class="mt-3 text-emerald-100/80">Türkiye Cumhuriyeti tarafından desteklenen güvenli finans platformu ile yatırımlarınızı büyütün</p>
                <div class="mt-4 p-3 bg-emerald-900/30 rounded-lg border border-emerald-700/50">
                    <p class="text-emerald-200 text-sm">
                        <i class="fas fa-shield-alt text-emerald-400 mr-2"></i>
                        <strong>SPK Lisanslı ve Devlet Denetimli:</strong> Sermaye Piyasası Kurulu tarafından lisanslanmış ve devlet kurumları tarafından denetlenmektedir.
                    </p>
                </div>
                <a href="{{ route('register') }}" class="btn-primary mt-6">Kayıt Ol</a>
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
                    <div class="card-dark p-5">
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

<!-- Türkiye Piyasaları Section -->
<section class="py-12 bg-gray-800">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-3xl font-extrabold heading-accent mb-4">Türkiye Piyasaları</h2>
            <div class="max-w-4xl mx-auto">
                <h3 class="text-lg md:text-xl font-semibold text-white mb-4">Bu Şirketlerde İşlem Yapabilirsiniz</h3>
                <p class="text-emerald-100/80 mb-6">
                    Baykar, Koç, Türkiye Petrolleri, Aselsan, Havelsan ve Togg gibi yerli liderlerde pozisyon açın.
                    Her yatırım ülke ekonomisine katkıdır; destek olurken kazanç potansiyelini keşfedin.
                    Bağımsız uzmanlarla çalışarak bilinçli kararlar verin.
                </p>

                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="card-dark p-5">
                        <div class="text-emerald-300 font-semibold mb-2">Devlete Destek</div>
                        <div class="text-emerald-100/70 text-sm">
                            Yerli şirketlere yatırım ekonomiye kaynak sağlar, sürdürülebilir büyümeye katkı sunar.
                        </div>
                    </div>
                    <div class="card-dark p-5">
                        <div class="text-emerald-300 font-semibold mb-2">Desteklerken Kazanç</div>
                        <div class="text-emerald-100/70 text-sm">
                            Uzun vadeli değer yaratımından faydalanırken portföyünüzü büyütme fırsatı.
                        </div>
                    </div>
                    <div class="card-dark p-5">
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
                <div class="card-dark hover:scale-105 transition-transform duration-300 overflow-hidden">
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

                        <a href="/giris" class="btn-secondary text-sm px-4 py-2 w-full inline-block text-center">
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
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-3xl font-extrabold heading-accent">Sık Sorulan Sorular</h2>
            <p class="text-emerald-100/80 mt-2">Hesaplar, yatırma ve platform özellikleri hakkında</p>
        </div>

        <div class="space-y-4">
            <!-- Soru 1: Devlet destekli mi? -->
            <div class="card-dark p-6">
                <div class="d-flex justify-content-between align-items-start">
                    <h3 class="text-white font-semibold text-lg">Devlet destekli mi?</h3>
                    <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-colors" onclick="toggleFaq(this)">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="faq-answer mt-3 text-emerald-100/80 d-none">
                    Evet, platformumuz devlet destekli bir finansal hizmet sağlayıcısıdır. Türkiye Cumhuriyeti Sermaye Piyasası Kurulu (SPK) ve ilgili devlet kurumları tarafından denetlenmekte ve desteklenmektedir. Bu sayede kullanıcılarımıza güvenli ve regüle edilmiş bir yatırım ortamı sunuyoruz.
                </div>
            </div>

            <!-- Soru 2: Kayıp yaşayabilir miyim? -->
            <div class="card-dark p-6">
                <div class="d-flex justify-content-between align-items-start">
                    <h3 class="text-white font-semibold text-lg">Kayıp yaşayabilir miyim?</h3>
                    <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-colors" onclick="toggleFaq(this)">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="faq-answer mt-3 text-emerald-100/80 d-none">
                    Tüm finansal işlemlerde olduğu gibi, piyasa koşulları nedeniyle kayıp riski her zaman vardır. Ancak platformumuz gelişmiş risk yönetimi araçları ve uzman desteği ile bu riskleri minimize etmeye yardımcı olur. Başarı oranımız %85'in üzerindedir ve kullanıcılarımıza kayıp durumunda destek hizmetleri sunuyoruz.
                </div>
            </div>

            <!-- Soru 3: Uzmanlar kimler? -->
            <div class="card-dark p-6">
                <div class="d-flex justify-content-between align-items-start">
                    <h3 class="text-white font-semibold text-lg">Uzmanlar kimler?</h3>
                    <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-colors" onclick="toggleFaq(this)">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="faq-answer mt-3 text-emerald-100/80 d-none">
                    Ekibimizde 15+ yıllık deneyime sahip lisanslı finansal analistler, eski banka çalışanları ve sermaye piyasası uzmanları bulunmaktadır. Ayrıca yapay zeka destekli algoritmalarımız da 7/24 piyasa analizi yapmaktadır. Tüm uzmanlarımız SPK lisansına sahiptir.
                </div>
            </div>

            <!-- Soru 4: Ne kadar kazanacağım? -->
            <div class="card-dark p-6">
                <div class="d-flex justify-content-between align-items-start">
                    <h3 class="text-white font-semibold text-lg">Ne kadar kazanacağım?</h3>
                    <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-colors" onclick="toggleFaq(this)">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="faq-answer mt-3 text-emerald-100/80 d-none">
                    Kazanç miktarı yatırım tutarı, piyasa koşulları ve seçilen plana göre değişir. Minimum paketlerimiz aylık %15-25 getiri potansiyeline sahiptir. VIP paketlerde bu oran %40'a kadar çıkabilir. Gerçek kazanç geçmişinizi hesap panelinizden takip edebilirsiniz.
                </div>
            </div>

            <!-- Soru 5: Devlet neden destek veriyor? -->
            <div class="card-dark p-6">
                <div class="d-flex justify-content-between align-items-start">
                    <h3 class="text-white font-semibold text-lg">Devlet neden destek veriyor?</h3>
                    <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-colors" onclick="toggleFaq(this)">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="faq-answer mt-3 text-emerald-100/80 d-none">
                    Devletimiz yerli finansal teknolojilerin gelişmesini ve vatandaşlarımızın uluslararası platformlara bağımlılığının azalmasını desteklemektedir. Ayrıca yerli şirketlere yatırım yapılarak ekonomik büyümeye katkı sağlanması hedeflenmektedir. Bu destek sayesinde daha düşük maliyetlerle hizmet verebiliyoruz.
                </div>
            </div>

            <!-- Soru 6: Komisyon ve ücretler nelerdir? -->
            <div class="card-dark p-6">
                <div class="d-flex justify-content-between align-items-start">
                    <h3 class="text-white font-semibold text-lg">Komisyon ve ücretler nelerdir?</h3>
                    <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-colors" onclick="toggleFaq(this)">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="faq-answer mt-3 text-emerald-100/80 d-none">
                    Platform kullanım ücreti aylık ₺99'dur. İşlem komisyonları %0.1 ile %0.5 arasında değişir. Para yatırma/çekme işlemleri ücretsizdir. VIP üyelerimiz için özel indirimler uygulanır. Tüm ücretler şeffaf olarak gösterilir ve sürpriz maliyet yoktur.
                </div>
            </div>

            <!-- Soru 7: Veriler nereden geliyor? -->
            <div class="card-dark p-6">
                <div class="d-flex justify-content-between align-items-start">
                    <h3 class="text-white font-semibold text-lg">Veriler nereden geliyor?</h3>
                    <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-colors" onclick="toggleFaq(this)">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="faq-answer mt-3 text-emerald-100/80 d-none">
                    Gerçek zamanlı piyasa verilerini Borsa İstanbul, uluslararası borsalar ve Bloomberg Terminal gibi güvenilir kaynaklardan alıyoruz. Ayrıca kendi geliştirdiğimiz algoritmalar ile teknik analiz ve yapay zeka destekli tahminler üretiyoruz. Tüm veriler SSL şifreleme ile korunur.
                </div>
            </div>

            <!-- Soru 8: Nasıl para yatırır/çekerim? -->
            <div class="card-dark p-6">
                <div class="d-flex justify-content-between align-items-start">
                    <h3 class="text-white font-semibold text-lg">Nasıl para yatırır/çekerim?</h3>
                    <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-colors" onclick="toggleFaq(this)">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="faq-answer mt-3 text-emerald-100/80 d-none">
                    Havale/EFT, kredi kartı, kripto para ve diğer ödeme yöntemleri ile 7/24 para yatırabilirsiniz. Minimum yatırım tutarı ₺1.000'dir. Para çekme işlemleri maksimum 24 saat içinde gerçekleşir. VIP üyelerimiz için öncelikli işlem yapılır.
                </div>
            </div>

            <!-- Soru 9: Hesabımı nasıl kapatırım? -->
            <div class="card-dark p-6">
                <div class="d-flex justify-content-between align-items-start">
                    <h3 class="text-white font-semibold text-lg">Hesabımı nasıl kapatırım?</h3>
                    <button class="faq-toggle text-emerald-400 hover:text-emerald-300 transition-colors" onclick="toggleFaq(this)">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="faq-answer mt-3 text-emerald-100/80 d-none">
                    Hesap kapatma işlemi profil ayarlarından veya müşteri hizmetleri üzerinden yapılabilir. Önce açık pozisyonlarınızı kapatmanız ve bakiyenizi çekmeniz gerekir. Hesap kapatma işlemi 7 gün sürer ve bu süre zarfında cayma hakkınız vardır. Tüm verileriniz güvenli şekilde silinir.
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function toggleFaq(button) {
    const faqAnswer = button.parentElement.nextElementSibling;
    const icon = button.querySelector('i');

    if (faqAnswer.classList.contains('d-none')) {
        faqAnswer.classList.remove('d-none');
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
    } else {
        faqAnswer.classList.add('d-none');
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
    }
}
</script>

@endsection