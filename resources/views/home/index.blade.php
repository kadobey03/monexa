
@extends('layouts.base')

@section('title', 'Ana Sayfa')

@inject('content', 'App\Http\Controllers\FrontController')
@section('content')

<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-gray-900 to-gray-800">
    <!-- Abstract Background Elements -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 left-0 w-full h-full opacity-20">
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
        <div class="absolute bottom-0 right-0 w-full h-full opacity-10">
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
        <div class="flex flex-col items-stretch gap-8 md:flex-row md:items-start">
            <!-- Left Column - Text Content -->
            <div class="w-full md:w-1/2 order-1 md:order-1 flex flex-col justify-center" x-data="{ isVisible: false }" x-init="setTimeout(() => { isVisible = true }, 200)">
                <div
                    x-show="isVisible"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 transform translate-y-8"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="space-y-6 h-full flex flex-col justify-center py-8"
                >
                    <div class="inline-block px-3 py-1 mb-2 text-xs font-semibold tracking-wider text-primary uppercase bg-blue-900 bg-opacity-30 rounded-full self-start">
                        Yenilikçi Ticaret Platformu
                    </div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl md:text-5xl">
                        <span class="block">Küresel Piyasaları Ticaret Edin</span>
                        <span class="block mt-1 text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Güvenle</span>
                    </h1>
                    <p class="max-w-lg mt-5 text-xl text-gray-300">
                        Forex, Kripto Paralar, Emtialar, Endeksler ve daha fazlası için gelişmiş ticaret araçlarına rekabetçi spreadler ve yıldırım hızında uygulama ile erişin.
                    </p>
                    <div class="flex flex-wrap gap-4 mt-8">
                        <a href="register" class="px-8 py-3 text-lg font-medium text-white transition-all duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-gray-900">
                            Hesap Oluştur
                        </a>
                        <a href="login" class="px-8 py-3 text-lg font-medium text-gray-200 transition-all duration-200 bg-dark-200 border border-gray-700 rounded-lg hover:bg-dark-100 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                          Giriş Yap
                        </a>
                    </div>

                    <!-- Additional content to match height -->

                </div>
            </div>

            <!-- Right Column - Professional Trading Platform Preview -->
            <div class="w-full md:w-1/2 order-2 md:order-2 flex items-stretch">
                <div class="relative overflow-hidden backdrop-blur-sm bg-opacity-60 bg-gray-800 rounded-2xl border border-gray-700 shadow-[0_0_25px_rgba(59,130,246,0.15)] w-full">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-600 rounded-full filter blur-3xl opacity-10 -mr-10 -mt-10"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-blue-400 rounded-full filter blur-3xl opacity-10 -ml-10 -mb-10"></div>

                    <!-- Platform Header -->
                    <div class="bg-gray-800 bg-opacity-90 border-b border-gray-700 p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                                    <span class="text-sm font-semibold text-green-400">PROFESYONEL TİCARET</span>
                                </div>
                                <div class="text-xs text-gray-400">
                                    <span x-data="{ time: '' }" x-init="setInterval(() => { time = new Date().toLocaleTimeString('en-US', {hour: '2-digit', minute:'2-digit', second:'2-digit'}) }, 1000)" x-text="time"></span>
                                </div>
                            </div>
                            <div class="text-xs text-emerald-400 font-medium">
                                Gelişmiş Platform
                            </div>
                        </div>
                    </div>

                    <!-- Trading Features Grid -->
                    <div class="p-6 space-y-4">


                        <!-- Platform Features -->
                        <div class="bg-gray-900 bg-opacity-50 rounded-xl p-4">
                            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                                <i class="fas fa-cogs text-emerald-400 mr-2"></i>
                                Platform Özellikleri
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between bg-gray-800 rounded-lg p-3 hover:bg-gray-700 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-bolt text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <span class="text-white font-medium">Yıldırım Hızında Yürütme</span>
                                            <div class="text-xs text-gray-400">Ultra düşük gecikme ile ticaret</div>
                                        </div>
                                    </div>
                                    <div class="text-emerald-400 text-sm font-semibold">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between bg-gray-800 rounded-lg p-3 hover:bg-gray-700 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-shield-alt text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <span class="text-white font-medium">Gelişmiş Risk Yönetimi</span>
                                            {{-- <div class="text-xs text-gray-400">Stop Loss & Take Profit</div> --}}
                                        </div>
                                    </div>
                                    <div class="text-emerald-400 text-sm font-semibold">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between bg-gray-800 rounded-lg p-3 hover:bg-gray-700 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-chart-area text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <span class="text-white font-medium">Gerçek Zamanlı Analitik</span>
                                            <div class="text-xs text-gray-400">Canlı piyasa verileri ve grafikleri</div>
                                        </div>
                                    </div>
                                    <div class="text-emerald-400 text-sm font-semibold">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Call to Action -->
                        <div class="pt-4 space-y-3">
                            <a href="register" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 flex items-center justify-center space-x-2 shadow-lg">
                                <i class="fas fa-rocket"></i>
                                <span>Bugün Ticarete Başlayın</span>
                            </a>
                            <a href="login" class="w-full bg-gray-700 hover:bg-gray-600 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 flex items-center justify-center space-x-2">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>Hesabınıza Erişin</span>
                            </a>
                            <div class="text-center pt-2">
                                <span class="text-xs text-gray-400">Düzenlenmiş • Güvenli • Profesyonel</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Market Ticker -->
<div class="py-2 bg-gray-800 border-t border-b border-gray-700">
    <!-- TradingView Widget BEGIN -->
    <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
        {
        "symbols": [
            {
            "proName": "FOREXCOM:SPXUSD",
            "title": "S&P 500"
            },
            {
            "proName": "FOREXCOM:NSXUSD",
            "title": "Nasdaq 100"
            },
            {
            "proName": "FX_IDC:EURUSD",
            "title": "EUR/USD"
            },
            {
            "proName": "BITSTAMP:BTCUSD",
            "title": "BTC/USD"
            },
            {
            "proName": "BITSTAMP:ETHUSD",
            "title": "ETH/USD"
            }
        ],
        "showSymbolLogo": true,
        "colorTheme": "dark",
        "isTransparent": false,
        "displayMode": "adaptive",
        "locale": "en"
        }
        </script>
    </div>
    <!-- TradingView Widget END -->
</div>

<!-- Cryptocurrency Price Cards -->
{{-- <section class="py-12 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <h2 class="text-3xl font-bold text-white">Live Cryptocurrency Prices</h2>
            <p class="mt-2 text-gray-400">Stay updated with real-time market data</p>
        </div>

        <!-- Crypto Price Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Bitcoin Card -->
            <div class="bg-gray-800 rounded-xl p-6 transition-transform transform hover:scale-105 duration-300 border border-gray-700 hover:border-blue-500 hover:shadow-xl hover:shadow-blue-900/10">
                <div class="flex items-center mb-4">
                    <img src="{{ asset('dash/bitcoin-btc-logo.png') }}" alt="Bitcoin" class="w-10 h-10 mr-3">
                    <div>
                        <h3 class="font-semibold text-lg text-white">Bitcoin</h3>
                        <span class="text-xs text-gray-400">BTC</span>
                    </div>
                </div>
                <div x-data="{ price: 0, change: 0 }" x-init="
                    fetch('https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=usd&include_24hr_change=true')
                        .then(response => response.json())
                        .then(data => {
                            price = data.bitcoin.usd;
                            change = data.bitcoin.usd_24h_change;
                        })
                        .catch(err => console.error(err))
                ">
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-white" x-text="'$' + price.toLocaleString()">$--,---</span>
                        <span class="px-2 py-1 rounded-full text-sm"
                            :class="change >= 0 ? 'bg-green-900 bg-opacity-30 text-green-400' : 'bg-red-900 bg-opacity-30 text-red-400'"
                            x-text="(change >= 0 ? '+' : '') + change.toFixed(2) + '%'">---%</span>
                    </div>
                </div>
            </div>

            <!-- Ethereum Card -->
            <div class="bg-gray-800 rounded-xl p-6 transition-transform transform hover:scale-105 duration-300 border border-gray-700 hover:border-blue-500 hover:shadow-xl hover:shadow-blue-900/10">
                <div class="flex items-center mb-4">
                    <img src="{{ asset('dash/ethereum-eth-logo.png') }}" alt="Ethereum" class="w-10 h-10 mr-3">
                    <div>
                        <h3 class="font-semibold text-lg text-white">Ethereum</h3>
                        <span class="text-xs text-gray-400">ETH</span>
                    </div>
                </div>
                <div x-data="{ price: 0, change: 0 }" x-init="
                    fetch('https://api.coingecko.com/api/v3/simple/price?ids=ethereum&vs_currencies=usd&include_24hr_change=true')
                        .then(response => response.json())
                        .then(data => {
                            price = data.ethereum.usd;
                            change = data.ethereum.usd_24h_change;
                        })
                        .catch(err => console.error(err))
                ">
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-white" x-text="'$' + price.toLocaleString()">$--,---</span>
                        <span class="px-2 py-1 rounded-full text-sm"
                            :class="change >= 0 ? 'bg-green-900 bg-opacity-30 text-green-400' : 'bg-red-900 bg-opacity-30 text-red-400'"
                            x-text="(change >= 0 ? '+' : '') + change.toFixed(2) + '%'">---%</span>
                    </div>
                </div>
            </div>

            <!-- Tether Card -->
            <div class="bg-gray-800 rounded-xl p-6 transition-transform transform hover:scale-105 duration-300 border border-gray-700 hover:border-blue-500 hover:shadow-xl hover:shadow-blue-900/10">
                <div class="flex items-center mb-4">
                    <img src="{{ asset('dash/tether-usdt-logo.png') }}" alt="Tether" class="w-10 h-10 mr-3">
                    <div>
                        <h3 class="font-semibold text-lg text-white">Tether</h3>
                        <span class="text-xs text-gray-400">USDT</span>
                    </div>
                </div>
                <div x-data="{ price: 0, change: 0 }" x-init="
                    fetch('https://api.coingecko.com/api/v3/simple/price?ids=tether&vs_currencies=usd&include_24hr_change=true')
                        .then(response => response.json())
                        .then(data => {
                            price = data.tether.usd;
                            change = data.tether.usd_24h_change;
                        })
                        .catch(err => console.error(err))
                ">
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-white" x-text="'$' + price.toLocaleString()">$--,---</span>
                        <span class="px-2 py-1 rounded-full text-sm"
                            :class="change >= 0 ? 'bg-green-900 bg-opacity-30 text-green-400' : 'bg-red-900 bg-opacity-30 text-red-400'"
                            x-text="(change >= 0 ? '+' : '') + change.toFixed(2) + '%'">---%</span>
                    </div>
                </div>
            </div>

            <!-- Binance Coin Card -->
            <div class="bg-gray-800 rounded-xl p-6 transition-transform transform hover:scale-105 duration-300 border border-gray-700 hover:border-blue-500 hover:shadow-xl hover:shadow-blue-900/10">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 mr-3 bg-yellow-500 rounded-full flex items-center justify-center">
                        <span class="font-bold text-dark-400">BNB</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg text-white">Binance Coin</h3>
                        <span class="text-xs text-gray-400">BNB</span>
                    </div>
                </div>
                <div x-data="{ price: 0, change: 0 }" x-init="
                    fetch('https://api.coingecko.com/api/v3/simple/price?ids=binancecoin&vs_currencies=usd&include_24hr_change=true')
                        .then(response => response.json())
                        .then(data => {
                            price = data.binancecoin.usd;
                            change = data.binancecoin.usd_24h_change;
                        })
                        .catch(err => console.error(err))
                ">
                    <div class="flex justify-between items-center">
                        <span class="text-2xl font-bold text-white" x-text="'$' + price.toLocaleString()">$--,---</span>
                        <span class="px-2 py-1 rounded-full text-sm"
                            :class="change >= 0 ? 'bg-green-900 bg-opacity-30 text-green-400' : 'bg-red-900 bg-opacity-30 text-red-400'"
                            x-text="(change >= 0 ? '+' : '') + change.toFixed(2) + '%'">---%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}

<!-- Features Section -->
<section class="py-12 bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 text-center">
            <h2 class="text-3xl font-bold text-white">Neden Bizimle Ticaret Yapmalısınız</h2>
            <p class="mt-2 text-gray-400">Başarılı ticaret için ihtiyacınız olan her şey</p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Feature 1 -->
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-gradient-to-br from-blue-600 to-blue-800 shadow-lg">
                    <i class="fas fa-chart-line text-white text-2xl"></i>
                </div>
                <h3 class="mb-2 text-xl font-bold text-white text-center">Ticaret Araçları</h3>
                <p class="text-gray-400 text-center">Ücretsiz profesyonel ticaret araçlarımızla işlemlerinizi etkili şekilde planlayın</p>
            </div>

            <!-- Feature 2 -->
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-gradient-to-br from-green-500 to-green-700 shadow-lg">
                    <i class="fas fa-layer-group text-white text-2xl"></i>
                </div>
                <h3 class="mb-2 text-xl font-bold text-white text-center">Ticaret Ürünleri</h3>
                <p class="text-gray-400 text-center">Çoklu piyasalarda ticaret portföyünüzü optimize etmek için çeşitli fırsatlar</p>
            </div>

            <!-- Feature 3 -->
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 shadow-lg">
                    <i class="fas fa-desktop text-white text-2xl"></i>
                </div>
                <h3 class="mb-2 text-xl font-bold text-white text-center">Ticaret Platformları</h3>
                <p class="text-gray-400 text-center">Herhangi bir cihazda tüm ticaret tarzlarına ve ihtiyaçlara uygun güçlü platformlar</p>
            </div>

            <!-- Feature 4 -->
            <div class="flex flex-col items-center">
                <div class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-gradient-to-br from-yellow-500 to-yellow-700 shadow-lg">
                    <i class="fas fa-wallet text-white text-2xl"></i>
                </div>
                <h3 class="mb-2 text-xl font-bold text-white text-center">Finansman Yöntemleri</h3>
                <p class="text-gray-400 text-center">Ticaret hesabınızı finanse etmek için birden fazla hızlı, kolay ve güvenli yöntem</p>
            </div>
        </div>
    </div>
</section>




<!-- Market Analysis Section -->
<section class="py-16 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 text-center">
            <span class="inline-block px-4 py-1 text-sm font-semibold tracking-wider text-emerald-400 uppercase bg-gradient-to-r from-emerald-900 to-teal-900 bg-opacity-70 rounded-full shadow-lg">
                Gerçek Zamanlı İstihbarat
            </span>
            <h2 class="mt-3 text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-blue-400">Piyasa Analizi ve İçgörüler</h2>
            <p class="mt-3 text-gray-300 max-w-2xl mx-auto">Gerçek zamanlı piyasa verileri, yapay zeka destekli içgörüler ve uzman analizleri ile önde kalın</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Market Overview Chart -->
            <div class="bg-gray-800 p-5 rounded-xl border border-gray-700 shadow-lg hover:border-blue-500 transition-all duration-300">
                <h3 class="mb-4 text-xl font-semibold text-white">Canlı Piyasa Genel Görünümü</h3>
                <!-- TradingView Widget BEGIN -->
                <div class="tradingview-widget-container">
                    <div class="tradingview-widget-container__widget"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js" async>
                    {
                    "colorTheme": "dark",
                    "dateRange": "12M",
                    "showChart": true,
                    "locale": "en",
                    "largeChartUrl": "",
                    "isTransparent": false,
                    "showSymbolLogo": true,
                    "showFloatingTooltip": false,
                    "width": "100%",
                    "height": "500",
                    "plotLineColorGrowing": "rgba(0, 255, 0, 1)",
                    "plotLineColorFalling": "rgba(255, 0, 0, 1)",
                    "gridLineColor": "rgba(42, 46, 57, 0.5)",
                    "scaleFontColor": "rgba(106, 109, 120, 1)",
                    "belowLineFillColorGrowing": "rgba(41, 98, 255, 0.12)",
                    "belowLineFillColorFalling": "rgba(41, 98, 255, 0.12)",
                    "belowLineFillColorGrowingBottom": "rgba(41, 98, 255, 0)",
                    "belowLineFillColorFallingBottom": "rgba(41, 98, 255, 0)",
                    "symbolActiveColor": "rgba(41, 98, 255, 0.12)",
                    "tabs": [
                        {
                        "title": "Indices",
                        "symbols": [
                            {
                            "s": "FOREXCOM:SPXUSD",
                            "d": "S&P 500"
                            },
                            {
                            "s": "FOREXCOM:NSXUSD",
                            "d": "US 100"
                            },
                            {
                            "s": "FOREXCOM:DJI",
                            "d": "Dow 30"
                            },
                            {
                            "s": "INDEX:NKY",
                            "d": "Nikkei 225"
                            },
                            {
                            "s": "INDEX:DEU40",
                            "d": "DAX Index"
                            },
                            {
                            "s": "FOREXCOM:UKXGBP",
                            "d": "UK 100"
                            }
                        ],
                        "originalTitle": "Indices"
                        },
    {
      "title": "Futures",
      "symbols": [
        {
          "s": "CME_MINI:ES1!",
          "d": "S&P 500"
        },
        {
          "s": "CME:6E1!",
          "d": "Euro"
        },
        {
          "s": "COMEX:GC1!",
          "d": "Gold"
        },
        {
          "s": "NYMEX:CL1!",
          "d": "Crude Oil"
        },
        {
          "s": "NYMEX:NG1!",
          "d": "Natural Gas"
        },
        {
          "s": "CBOT:ZC1!",
          "d": "Corn"
        }
      ],
      "originalTitle": "Futures"
    },
    {
      "title": "Bonds",
      "symbols": [
        {
          "s": "CME:GE1!",
          "d": "Eurodollar"
        },
        {
          "s": "CBOT:ZB1!",
          "d": "T-Bond"
        },
        {
          "s": "CBOT:UB1!",
          "d": "Ultra T-Bond"
        },
        {
          "s": "EUREX:FGBL1!",
          "d": "Euro Bund"
        },
        {
          "s": "EUREX:FBTP1!",
          "d": "Euro BTP"
        },
        {
          "s": "EUREX:FGBM1!",
          "d": "Euro BOBL"
        }
      ],
      "originalTitle": "Bonds"
    },
    {
      "title": "Forex",
                        "symbols": [
                            {
                            "s": "FX:EURUSD",
                            "d": "EUR/USD"
                            },
                            {
                            "s": "FX:GBPUSD",
                            "d": "GBP/USD"
                            },
                            {
                            "s": "FX:USDJPY",
                            "d": "USD/JPY"
                            },
                            {
                            "s": "FX:USDCHF",
                            "d": "USD/CHF"
                            },
                            {
                            "s": "FX:AUDUSD",
                            "d": "AUD/USD"
                            },
                            {
                            "s": "FX:USDCAD",
                            "d": "USD/CAD"
                            }
                        ],
                        "originalTitle": "Forex"
                        }
                    ]
                    }
                    </script>
                </div>
                <!-- TradingView Widget END -->
            </div>

            <!-- Expert Analysis Content -->
            <div class="space-y-6">
                <div class="bg-gray-800 bg-opacity-80 p-6 rounded-xl border border-gray-700 hover:border-emerald-500 shadow-lg transition duration-300">
                    <h3 class="text-xl font-semibold text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-blue-400 mb-4">Uzman Piyasa Analizi</h3>

                    <div class="space-y-6">
                        <!-- Analysis Card 1 -->
                        <div class="flex items-start space-x-4" x-data="{ expanded: false }">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-12 h-12 bg-gradient-to-br from-emerald-600 to-blue-700 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-chart-bar text-white"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-lg font-medium text-white">Günlük Piyasa <span class="text-emerald-400">Güncellemeleri</span></h4>
                                <p class="mt-2 text-gray-300" :class="expanded ? '' : 'line-clamp-2'">
                                    Receive daily market analysis directly to your inbox. Our team of expert analysts provide actionable insights on market trends, price movements, and trading opportunities across all major asset classes.
                                </p>
                                <button @click="expanded = !expanded" class="mt-2 px-3 py-1 text-xs font-semibold bg-gradient-to-r from-emerald-700 to-blue-700 hover:from-emerald-600 hover:to-blue-600 text-white rounded-full transition duration-300 focus:outline-none">
                                    <span x-show="!expanded">Read more</span>
                                    <span x-show="expanded">Show less</span>
                                </button>
                            </div>
                        </div>

                        <!-- Analysis Card 2 -->
                        <div class="flex items-start space-x-4" x-data="{ expanded: false }">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-tools text-white"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-lg font-medium text-white">Premium Ticaret <span class="text-blue-400">Araçları</span></h4>
                                <p class="mt-2 text-gray-300" :class="expanded ? '' : 'line-clamp-2'">
                                    Access advanced trading tools designed for all experience levels. Our platform offers customizable solutions to meet diverse trading needs and styles, with multi-language support for international traders.
                                </p>
                                <button @click="expanded = !expanded" class="mt-2 px-3 py-1 text-xs font-semibold bg-gradient-to-r from-blue-700 to-blue-700 hover:from-blue-600 hover:to-blue-600 text-white rounded-full transition duration-300 focus:outline-none">
                                    <span x-show="!expanded">Read more</span>
                                    <span x-show="expanded">Show less</span>
                                </button>
                            </div>
                        </div>

                        <!-- Analysis Card 3 -->
                        <div class="flex items-start space-x-4" x-data="{ expanded: false }">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-shield-alt text-white"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-lg font-medium text-white">Fon <span class="text-blue-400">Koruması</span></h4>
                                <p class="mt-2 text-gray-300" :class="expanded ? '' : 'line-clamp-2'">
                                    Your security is our priority. We provide industry-leading insurance protection for client funds up to $1,000,000, ensuring your investments are protected against unforeseen circumstances.
                                </p>
                                <button @click="expanded = !expanded" class="mt-2 px-3 py-1 text-xs font-semibold bg-gradient-to-r from-blue-700 to-blue-700 hover:from-blue-600 hover:to-blue-600 text-white rounded-full transition duration-300 focus:outline-none">
                                    <span x-show="!expanded">Read more</span>
                                    <span x-show="expanded">Show less</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <a href="login" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 shadow-lg transition duration-300 transform hover:-translate-y-1">
                            Hizmetlerimiz hakkında daha fazla bilgi edinin
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<!-- Trading Products Section -->
<section class="py-16 bg-dark-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 text-center">
            <h2 class="text-3xl font-bold text-white">Diverse Trading Products</h2>
            <p class="mt-2 text-gray-400">Access global markets with competitive conditions</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Forex Card -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-400 rounded-lg transform rotate-1 group-hover:rotate-0 transition-all duration-300 opacity-50"></div>
                <div class="relative bg-dark-400 p-6 rounded-lg border border-gray-700 group-hover:border-blue-500 transition-all duration-300">
                    <div class="w-12 h-12 bg-blue-600 bg-opacity-20 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-globe text-blue-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Forex</h3>
                    <p class="text-gray-400 mb-4">Trade 70+ major, minor & exotic currency pairs with competitive spreads and conditions</p>
                    <a href="forex" class="text-blue-400 hover:text-blue-300 flex items-center text-sm font-medium">
                        Explore Forex
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Shares Card -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-400 rounded-lg transform rotate-1 group-hover:rotate-0 transition-all duration-300 opacity-50"></div>
                <div class="relative bg-dark-400 p-6 rounded-lg border border-gray-700 group-hover:border-green-500 transition-all duration-300">
                    <div class="w-12 h-12 bg-green-600 bg-opacity-20 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-chart-line text-green-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Shares</h3>
                    <p class="text-gray-400 mb-4">Access hundreds of public companies from the US, UK, Germany and more markets</p>
                    <a href="shares" class="text-green-400 hover:text-green-300 flex items-center text-sm font-medium">
                        Explore Shares
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Energies Card -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-yellow-600 to-yellow-400 rounded-lg transform rotate-1 group-hover:rotate-0 transition-all duration-300 opacity-50"></div>
                <div class="relative bg-dark-400 p-6 rounded-lg border border-gray-700 group-hover:border-yellow-500 transition-all duration-300">
                    <div class="w-12 h-12 bg-yellow-600 bg-opacity-20 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-fire text-yellow-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Energies</h3>
                    <p class="text-gray-400 mb-4">Discover opportunities on UK & US Crude Oil as well as Natural Gas with tight spreads</p>
                    <a href="commodities" class="text-yellow-400 hover:text-yellow-300 flex items-center text-sm font-medium">
                        Explore Energies
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Indices Card -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-400 rounded-lg transform rotate-1 group-hover:rotate-0 transition-all duration-300 opacity-50"></div>
                <div class="relative bg-dark-400 p-6 rounded-lg border border-gray-700 group-hover:border-blue-500 transition-all duration-300">
                    <div class="w-12 h-12 bg-blue-600 bg-opacity-20 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-landmark text-blue-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Indices</h3>
                    <p class="text-gray-400 mb-4">Trade major and minor Index CFDs from around the globe with competitive conditions</p>
                    <a href="indices" class="text-blue-400 hover:text-blue-300 flex items-center text-sm font-medium">
                        Explore Indices
                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>




<!-- Cryptocurrency Trading Section -->
<section class="py-16 bg-gradient-to-b from-dark-400 to-dark-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 text-center">
            <div class="inline-block px-3 py-1 mb-2 text-xs font-semibold tracking-wider text-secondary uppercase bg-green-900 bg-opacity-30 rounded-full">
                Popular Asset Class
            </div>
            <h2 class="text-3xl font-bold text-white">Cryptocurrency Trading</h2>
            <p class="mt-2 text-gray-400 max-w-2xl mx-auto">Trade the world's most popular digital assets with competitive spreads and advanced tools</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Bitcoin Card -->
            <div class="bg-dark-400 rounded-xl overflow-hidden group hover:shadow-xl transition duration-300 transform hover:-translate-y-1 border border-gray-800">
                <div class="h-24 bg-gradient-to-r from-orange-500 to-yellow-500 flex items-center justify-center">
                    <img src="{{ asset('dash/bitcoin-btc-logo.png') }}" alt="Bitcoin" class="h-16 w-16">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-2">Bitcoin</h3>
                    <p class="text-gray-400 text-sm h-24 overflow-hidden">
                        Bitcoin, merkezi olmayan bir dijital para birimidir ve aracılara ihtiyaç duymadan blockchain ağı üzerinde eşler arası işlemlere olanak tanır.
                    </p>
                    <div class="mt-4 flex justify-between items-center">
                        <a href="cryptocurrencies" class="text-primary hover:underline text-sm font-medium flex items-center">
                            Trade now
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                        <span class="text-xs py-1 px-2 bg-gray-800 rounded-full text-gray-300">BTC/USD</span>
                    </div>
                </div>
            </div>

            <!-- Ethereum Card -->
            <div class="bg-dark-400 rounded-xl overflow-hidden group hover:shadow-xl transition duration-300 transform hover:-translate-y-1 border border-gray-800">
                <div class="h-24 bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center">
                    <img src="{{ asset('dash/ethereum-eth-logo.png') }}" alt="Ethereum" class="h-16 w-16">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-2">Ethereum</h3>
                    <p class="text-gray-400 text-sm h-24 overflow-hidden">
                        Ethereum, akıllı sözleşme işlevselliğine sahip merkezi olmayan, açık kaynaklı bir blockchain platformudur. Bitcoin'den sonra piyasa değeri açısından en büyük kripto para birimi ve en aktif kullanılan blockchain'dir.
                    </p>
                    <div class="mt-4 flex justify-between items-center">
                        <a href="cryptocurrencies" class="text-primary hover:underline text-sm font-medium flex items-center">
                            Trade now
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                        <span class="text-xs py-1 px-2 bg-gray-800 rounded-full text-gray-300">ETH/USD</span>
                    </div>
                </div>
            </div>

            <!-- Ripple Card -->
            <div class="bg-dark-400 rounded-xl overflow-hidden group hover:shadow-xl transition duration-300 transform hover:-translate-y-1 border border-gray-800">
                <div class="h-24 bg-gradient-to-r from-blue-500 to-blue-700 flex items-center justify-center">
                    <div class="h-16 w-16 bg-gray-900 rounded-full flex items-center justify-center border border-blue-400 shadow-lg">
                        <span class="text-blue-400 text-3xl font-bold">XRP</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-2">Ripple</h3>
                    <p class="text-gray-400 text-sm h-24 overflow-hidden">
                        Ripple, Ripple Labs tarafından oluşturulan gerçek zamanlı brüt ödeme sistemi, döviz değişimi ve havale ağıdır. Hızlı, düşük maliyetli uluslararası işlemleri kolaylaştırmak için XRP'yi yerel kripto para birimi olarak kullanır.
                    </p>
                    <div class="mt-4 flex justify-between items-center">
                        <a href="cryptocurrencies" class="text-primary hover:underline text-sm font-medium flex items-center">
                            Trade now
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                        <span class="text-xs py-1 px-2 bg-gray-800 rounded-full text-gray-300">XRP/USD</span>
                    </div>
                </div>
            </div>

            <!-- Cardano Card -->
            <div class="bg-dark-400 rounded-xl overflow-hidden group hover:shadow-xl transition duration-300 transform hover:-translate-y-1 border border-gray-800">
                <div class="h-24 bg-gradient-to-r from-blue-800 to-indigo-800 flex items-center justify-center">
                    <div class="h-16 w-16 bg-gray-900 rounded-full flex items-center justify-center border border-indigo-400 shadow-lg">
                        <span class="text-indigo-400 text-3xl font-bold">ADA</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-2">Cardano</h3>
                    <p class="text-gray-400 text-sm h-24 overflow-hidden">
                        Cardano, Ethereum'un kurucu ortağı Charles Hoskinson tarafından oluşturulan proof-of-stake blockchain platformudur. Diğer blockchain platformlarından daha ölçeklenebilir, sürdürülebilir ve birlikte çalışabilir olmayı hedefler.
                    </p>
                    <div class="mt-4 flex justify-between items-center">
                        <a href="cryptocurrencies" class="text-primary hover:underline text-sm font-medium flex items-center">
                            Trade now
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                        <span class="text-xs py-1 px-2 bg-gray-800 rounded-full text-gray-300">ADA/USD</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 text-center">
            <a href="cryptocurrencies" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition duration-150">
                View all cryptocurrencies
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

















<!-- Trading Advantage Section -->
<section class="py-16 bg-gradient-to-b from-dark-300 to-dark-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 text-center">
            <span class="inline-block px-3 py-1 text-sm font-semibold tracking-wider text-primary uppercase bg-blue-900 bg-opacity-30 rounded-full">
                Superior Trading Experience
            </span>
            <h2 class="mt-2 text-3xl font-bold text-white">Tighter Spreads. Faster Execution.</h2>
            <p class="mt-2 text-gray-400 max-w-2xl mx-auto">Experience institutional-grade trading conditions designed for professional traders</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <!-- Left Side: Trading Advantages -->
            <div class="space-y-8">
                <div class="bg-dark-300 rounded-xl p-6 border border-gray-800 shadow-lg">
                    <h3 class="text-2xl font-bold text-white mb-6">Premium Trading Conditions</h3>

                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center">
                                    <i class="fas fa-check text-xs text-white"></i>
                                </div>
                            </div>
                            <p class="ml-3 text-gray-300">
                                Ana çiftlerde 0.0 pipten başlayan <span class="font-semibold text-white">ultra düşük spreadler</span>
                            </p>
                        </li>

                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center">
                                    <i class="fas fa-check text-xs text-white"></i>
                                </div>
                            </div>
                            <p class="ml-3 text-gray-300">
                                NY4 sunucu tesisinden <span class="font-semibold text-white">yıldırım hızında uygulama</span> ve minimum kayma ile
                            </p>
                        </li>

                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center">
                                    <i class="fas fa-check text-xs text-white"></i>
                                </div>
                            </div>
                            <p class="ml-3 text-gray-300">
                                <span class="font-semibold text-white">Üst düzey likidite</span> ve pazar lideri fiyatlandırma 24/5
                            </p>
                        </li>

                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center">
                                    <i class="fas fa-check text-xs text-white"></i>
                                </div>
                            </div>
                            <p class="ml-3 text-gray-300">
                                <span class="font-semibold text-white">Dealing desk yok</span> ve hiçbir zaman requote yok
                            </p>
                        </li>
                    </ul>

                    <div class="mt-8">
                        <a href="login" class="inline-flex items-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-blue-700 transition duration-150">
                            View detailed conditions
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Side: Trading Widget -->
            <div class="bg-dark-300 rounded-xl p-5 border border-gray-800 shadow-lg">
                <h3 class="text-xl font-semibold text-white mb-4">Live Market Overview</h3>

                <!-- TradingView Widget BAŞLANGIÇ -->
                <div class="tradingview-widget-container">
                    <div class="tradingview-widget-container__widget"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-forex-cross-rates.js" async>
                    {
                    "width": "100%",
                    "height": "400",
                    "currencies": [
                        "EUR",
                        "USD",
                        "JPY",
                        "GBP",
                        "CHF",
                        "AUD",
                        "CAD",
                        "NZD"
                    ],
                    "isTransparent": false,
                    "colorTheme": "dark",
                    "locale": "en"
                    }
                    </script>
                </div>
                <!-- TradingView Widget BİTTİ -->
            </div>
        </div>
    </div>
</section>











<!-- About Us Section -->
<section class="py-16 bg-gradient-to-b from-dark-400 to-dark-500 relative">
    <!-- Background overlay with image -->
    <div class="absolute inset-0 opacity-20" style="background-image: url(temp/custom/img/abt.png); background-position: center; background-repeat: no-repeat; background-size: cover;"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <span class="inline-block px-3 py-1 text-sm font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-30 rounded-full">
                Our Story
            </span>
            <h2 class="mt-2 text-3xl font-bold text-white">About Us</h2>
            <div class="h-1 w-20 bg-primary mx-auto my-4"></div>
        </div>

        <div class="max-w-4xl mx-auto bg-dark-400 bg-opacity-80 p-8 rounded-xl border border-gray-800 shadow-xl">
            <p class="text-gray-300 leading-relaxed">
                {{$settings->site_name}}, Forex, Hisse Senetleri, Emtialar ve Vadeli İşlemler genelinde CFD'ler sunan sektörün en saygın brokerlarından biri haline geldi. Forex piyasasında ticaret yapmak, gelir elde etmenin meşru ve basit bir yoludur.
            </p>

            <p class="text-gray-300 leading-relaxed mt-4">
                İyi haber şu ki, para kazanmak için profesyonel bir tüccar olmanız gerekmez. Doğru kişiliğe ve doğru beceri setine sahip olmanız yeterlidir ve döviz borsalarında para kazanabilirsiniz. {{$settings->site_name}}, size en uygun şekilde ticaret yapma imkanı sunar.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="bg-dark-300 bg-opacity-60 p-4 rounded-lg">
                    <h3 class="text-white font-semibold flex items-center">
                        <i class="fas fa-check-circle text-primary mr-2"></i>
                        Personalized Trading
                    </h3>
                    <p class="text-gray-400 mt-2">
                        Biraz mı yoksa çok mu risk almak istiyorsunuz? Kısa vadede mi yoksa uzun vadede mi kazanç istiyorsunuz? Günlük tüccar mı, swing tüccarı mı yoksa scalper mı olmak istiyorsunuz?
                    </p>
                </div>

                <div class="bg-dark-300 bg-opacity-60 p-4 rounded-lg">
                    <h3 class="text-white font-semibold flex items-center">
                        <i class="fas fa-check-circle text-primary mr-2"></i>
                        Complete Control
                    </h3>
                    <p class="text-gray-400 mt-2">
                        Doğru araçlar, bilgiler ve dünyanın tüm para birimlerine erişim ile {{$settings->site_name}}, yaptığınız işlemlerin kontrolünü size verir.
                    </p>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="about" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-blue-700 transition duration-150">
                    Learn more about us
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>





<!-- Start Pricing Trading on the Forex market is a legitimate and straightforward way of generating income. And the good news is that you donâ€™t have to be a professional trader in order to make money. All you need is the right personality and the right skill set and you can make money trading on foreign exchanges. {{$settings->site_name}} lets you trade in the way that best suits you. Biraz mı yoksa çok mu risk almak istiyorsunuz? Kısa vadede mi yoksa uzun vadede mi kazanç istiyorsunuz? Günlük tüccar mı, swing tüccarı mı yoksa scalper mı olmak istiyorsunuz? Are you an old hand or a rookie just testing the water? It does not matter because {{$settings->site_name}} puts you in control.If you can control todayâ€™s success and not let it cloud tomorrowâ€™s judgment, you probably have it in you to make money as a currency trader. The prizes in Forex are certainly glittering but it is level headedness and persistence that win the day. With the right tools, information and access to all the worldâ€™s currencies, {{$settings->site_name}} puts you in control of the trades you make. </p> </li> </center></ul></div>



<div class="text-center"></div>

<div class="text-center mt-3"></div></div></section>
















<!-- Expert Support Section -->
<section class="py-16 bg-dark-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Chart Widget -->
           <div class="bg-dark-300 rounded-xl overflow-hidden border border-gray-800 shadow-lg">
    <div class="w-full h-[400px]">
        <iframe
            src="https://widget.coinlib.io/widget?type=chart&theme=dark&coin_id=859&pref_coin_id=1505"
            scrolling="auto"
            marginwidth="0"
            marginheight="0"
            frameborder="0"
            class="w-full h-full border-0">
        </iframe>
    </div>
    <div class="p-2 text-right text-xs text-green-500">
        <a href="https://coinlib.io" target="_blank" class="hover:underline">Cryptocurrency Prices by Coinlib</a>
    </div>
</div>

            <!-- Expert Support Content -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2 flex items-center">
                        <i class="fas fa-headset text-primary mr-3"></i>
                        STAY UP TO DATE WITH OUR EXPERTS
                    </h2>
                    <div class="h-1 w-20 bg-primary my-4"></div>
                    <p class="text-gray-300 leading-relaxed">
                        Our local and international teams are here to support you on a 24/5 basis in more than 20 languages, while our wide range of payment methods gives you greater flexibility when it comes to deposits and withdrawals.
                    </p>
                </div>

                <div class="bg-dark-300 rounded-lg p-6 border border-gray-800">
                    <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                        <i class="fas fa-star text-yellow-400 mr-3"></i>
                        Experience More Than Trading
                    </h2>
                    <p class="text-gray-300 leading-relaxed">
                        Our success is centred around a number of core values. They include providing competitive brokerage fees through tight spreads, ensuring lightning-fast execution, access to advanced trading platforms with a wide range of products, and exceptional customer service.
                    </p>

                    <div class="mt-6">
                        <a href="login" class="inline-flex items-center px-5 py-2 border border-gray-700 text-base font-medium rounded-md text-gray-300 hover:text-white hover:border-primary transition duration-150">
                            Learn about our commissions
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>

<!-- Trading Features Section -->
<section class="py-16 bg-gradient-to-b from-dark-300 to-dark-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 text-center">
            <span class="inline-block px-4 py-1 text-sm font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-70 rounded-full shadow-lg">
                Platform Features
            </span>
            <h2 class="mt-3 text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-400">Advanced Trading Tools</h2>
            <p class="mt-3 text-gray-300 max-w-2xl mx-auto">Our platform provides everything you need for successful trading in one powerful interface</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Feature 1 -->
            <div class="bg-gray-800 bg-opacity-80 p-6 rounded-xl border border-gray-700 hover:border-blue-500 shadow-lg transition duration-300 transform hover:-translate-y-1 hover:shadow-blue-900/20">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <i class="fas fa-bolt text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Reliable <span class="text-blue-400">Execution</span></h3>
                <p class="text-gray-300">
                    Featuring the market's sharpest execution, {{$settings->site_name}} cTrader fills your orders in milliseconds without any requotes or price manipulation.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-gray-800 bg-opacity-80 p-6 rounded-xl border border-gray-700 hover:border-blue-500 shadow-lg transition duration-300 transform hover:-translate-y-1 hover:shadow-blue-900/20">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-blue-700 rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Intelligent <span class="text-indigo-400">Analysis</span></h3>
                <p class="text-gray-300">
                    Make informed decisions with smart market analysis tools, Live Sentiment data and in-platform market insights from Trading Central.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-gray-800 bg-opacity-80 p-6 rounded-xl border border-gray-700 hover:border-blue-500 shadow-lg transition duration-300 transform hover:-translate-y-1 hover:shadow-blue-900/20">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <i class="fas fa-search-dollar text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Transparent <span class="text-cyan-400">Reporting</span></h3>
                <p class="text-gray-300">
                    Access transaction statistics, equity charts and detailed history of your deals for a crystal clear understanding of your performance.
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-gray-800 bg-opacity-80 p-6 rounded-xl border border-gray-700 hover:border-blue-500 shadow-lg transition duration-300 transform hover:-translate-y-1 hover:shadow-blue-900/20">
                <div class="w-16 h-16 bg-gradient-to-br from-teal-600 to-green-700 rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <i class="fas fa-desktop text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Intuitive <span class="text-teal-400">Interface</span></h3>
                <p class="text-gray-300">
                    Easy to use and navigate, {{$settings->site_name}} cTrader was built with real traders' needs in mind. Trade with {{$settings->site_name}} cTrader and experience its distinct advantage.
                </p>
            </div>
        </div>
    </div>
</section>







<!-- Trusted Brand Section -->
<section class="py-16 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 text-center">
            <span class="inline-block px-4 py-1 text-sm font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-70 rounded-full shadow-lg">
                Global Trust
            </span>
            <h2 class="mt-3 text-3xl font-bold text-white">Why <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-600">{{$settings->site_name}}</span> Is One of the World's Most Trusted Brands</h2>
            <p class="mt-3 text-gray-300 max-w-2xl mx-auto">Experience the reliability and security that our global clients have come to trust</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <!-- TradingView Widget Container -->
            <div class="bg-gray-800 rounded-xl overflow-hidden border border-gray-700 shadow-xl transform transition duration-500 hover:shadow-blue-900/20" x-data="{}" x-init="setTimeout(() => {
                new TradingView.widget({
                    'container_id': 'forex_heat_map',
                    'width': '100%',
                    'height': 400,
                    'currencies': ['EUR', 'USD', 'JPY', 'GBP', 'CHF', 'AUD', 'CAD', 'NZD', 'CNY'],
                    'isTransparent': true,
                    'colorTheme': 'dark',
                    'locale': 'en'
                });
            }, 100)">
                <div class="p-4 bg-gray-800 border-b border-gray-700">
                    <h3 class="text-xl font-semibold text-white">Real-Time Market Analysis</h3>
                </div>
                <!-- TradingView Widget BEGIN -->
                <div id="forex_heat_map" class="w-full h-96 bg-gray-800"></div>
                <div class="py-2 px-4 text-right text-xs text-blue-400 bg-gray-800">
                    <a href="https://www.tradingview.com/markets/currencies/forex-heat-map/" rel="noopener" target="_blank" class="hover:underline">Forex Heat Map by TradingView</a>
                </div>
                <!-- TradingView Widget END -->
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-forex-heat-map.js" async></script>
            </div>

            <!-- Trust Features -->
            <div class="bg-gray-800 rounded-xl overflow-hidden border border-gray-700 shadow-xl transition duration-300 transform hover:-translate-y-1 hover:shadow-blue-900/20">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-6 border-b border-gray-700 pb-3">Our Trusted Reputation</h3>
                    <ul class="space-y-5">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 bg-opacity-20">
                                    <i class="fas fa-check text-blue-400"></i>
                                </span>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-white font-medium">Globally Regulated</h4>
                                <p class="text-gray-400 text-sm mt-1">Operating under strict financial regulations to ensure maximum security for your assets</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 bg-opacity-20">
                                    <i class="fas fa-trophy text-blue-400"></i>
                                </span>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-white font-medium">40+ International Awards</h4>
                                <p class="text-gray-400 text-sm mt-1">Recognition for excellence in trading services, platform technology and customer support</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 bg-opacity-20">
                                    <i class="fas fa-headset text-blue-400"></i>
                                </span>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-white font-medium">24/7 Multilingual Support</h4>
                                <p class="text-gray-400 text-sm mt-1">Expert assistance available around the clock in multiple languages</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 bg-opacity-20">
                                    <i class="fas fa-shield-alt text-blue-400"></i>
                                </span>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-white font-medium">Segregated Client Funds</h4>
                                <p class="text-gray-400 text-sm mt-1">Your investments are kept in separate accounts for maximum security</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 bg-opacity-20">
                                    <i class="fas fa-user-tie text-blue-400"></i>
                                </span>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-white font-medium">Personal Account Managers</h4>
                                <p class="text-gray-400 text-sm mt-1">Dedicated professionals to guide your trading journey</p>
                            </div>
                        </li>
                    </ul>
                    <div class="mt-8 text-center">
                        <a href="login" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 shadow-lg transition duration-300 transform hover:-translate-y-1">
                            Learn More
                            <svg class="ml-2 -mr-1 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>












<!-- How It Works Section -->
<section class="py-16 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 text-center">
            <span class="inline-block px-4 py-1 text-sm font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-70 rounded-full shadow-lg">
                Simple Process
            </span>
            <h2 class="mt-3 text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-600">How It Works</h2>
            <p class="mt-3 text-gray-300 max-w-2xl mx-auto">Get started with trading in three simple steps</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-b from-blue-600/20 to-blue-800/20 rounded-xl transform rotate-1 group-hover:rotate-0 transition-all duration-300 opacity-50"></div>
                <div class="relative bg-gray-800 bg-opacity-90 rounded-xl p-8 shadow-lg border border-gray-700 group-hover:border-blue-600 transform transition-all duration-500 hover:shadow-lg hover:shadow-blue-900/20 hover:-translate-y-2 h-full">
                    <div class="flex justify-center mb-6">
                        <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg">1</div>
                    </div>
                    <h3 class="text-xl font-bold text-center text-white mb-3">Deposit</h3>
                    <div class="flex justify-center mb-4">
                        <div class="h-1 w-20 bg-blue-500 mx-auto"></div>
                    </div>
                    <p class="text-gray-300 text-center mb-8">
                        Gerçek hesap açın ve fon ekleyin. Kolaylığınız için 20'den fazla ödeme sistemi ile çalışıyoruz.
                    </p>
                    <div class="mt-auto text-center">
                        <a href="register" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 shadow-lg transition duration-300 transform hover:-translate-y-1">
                            Get Started
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-b from-blue-600/20 to-blue-800/20 rounded-xl transform rotate-1 group-hover:rotate-0 transition-all duration-300 opacity-50"></div>
                <div class="relative bg-gray-800 bg-opacity-90 rounded-xl p-8 shadow-lg border border-gray-700 group-hover:border-blue-600 transform transition-all duration-500 hover:shadow-lg hover:shadow-blue-900/20 hover:-translate-y-2 h-full">
                    <div class="flex justify-center mb-6">
                        <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg">2</div>
                    </div>
                    <h3 class="text-xl font-bold text-center text-white mb-3">Trade</h3>
                    <div class="flex justify-center mb-4">
                        <div class="h-1 w-20 bg-blue-500 mx-auto"></div>
                    </div>
                    <p class="text-gray-300 text-center mb-8">
                        100'den fazla varlık ve hisse senedi ile işlem yapın. Daha iyi sonuçlar için teknik analiz kullanın ve haberleri takip edin.
                    </p>
                    <div class="mt-auto text-center">
                        <a href="login" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 shadow-lg transition duration-300 transform hover:-translate-y-1">
                            Explore Markets
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-b from-blue-600/20 to-blue-800/20 rounded-xl transform rotate-1 group-hover:rotate-0 transition-all duration-300 opacity-50"></div>
                <div class="relative bg-gray-800 bg-opacity-90 rounded-xl p-8 shadow-lg border border-gray-700 group-hover:border-blue-600 transform transition-all duration-500 hover:shadow-lg hover:shadow-blue-900/20 hover:-translate-y-2 h-full">
                    <div class="flex justify-center mb-6">
                        <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg">3</div>
                    </div>
                    <h3 class="text-xl font-bold text-center text-white mb-3">Withdraw</h3>
                    <div class="flex justify-center mb-4">
                        <div class="h-1 w-20 bg-blue-500 mx-auto"></div>
                    </div>
                    <p class="text-gray-300 text-center mb-8">
                        Hızlı ve güvenli para çekme sürecimizle paranızı kolayca banka kartınıza veya e-cüzdanınıza alın.
                    </p>
                    <div class="mt-auto text-center">
                        <a href="login" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 shadow-lg transition duration-300 transform hover:-translate-y-1">
                            Learn More
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>























</section>

<!-- Client Testimonials Section -->
<section class="py-16 bg-gray-900 relative overflow-hidden" x-data="{ activeTestimonial: null }">
    <!-- Background Effects -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-emerald-400/5"></div>
        <!-- Animated Grid Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="testimonial-grid" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 40V0h40" fill="none" stroke="currentColor" stroke-width="0.5"/>
                        <circle cx="20" cy="20" r="1" fill="currentColor"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#testimonial-grid)"/>
            </svg>
        </div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="mb-12 text-center">
            <span class="inline-block px-4 py-1 text-sm font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-70 rounded-full shadow-lg">
                Success Stories
            </span>
            <h2 class="mt-3 text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-400">Client Testimonials</h2>
            <p class="mt-3 text-gray-300 max-w-2xl mx-auto">Hear from our satisfied clients who have achieved impressive results with our platform</p>
        </div>

        <!-- Testimonials Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Testimonial 1 -->
            <div class="relative group"
                x-data="{ isHovered: false }"
                @mouseenter="isHovered = true; activeTestimonial = 1"
                @mouseleave="isHovered = false; activeTestimonial = null">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-emerald-400/20 rounded-2xl filter blur-xl transition-opacity duration-300"
                    :class="{ 'opacity-75': isHovered, 'opacity-0': !isHovered }"></div>
                <div class="relative h-full bg-gray-800 bg-opacity-80 rounded-2xl p-6 border border-gray-700 transition-all duration-300 hover:border-blue-500/50">
                    <div class="mb-6">
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                            <svg class="w-8 h-8 text-blue-400 ml-auto opacity-20" fill="currentColor" viewBox="0 0 32 32">
                                <path d="M10 8c-3.3 0-6 2.7-6 6v10h6V14h-4c0-2.2 1.8-4 4-4zm12 0c-3.3 0-6 2.7-6 6v10h6V14h-4c0-2.2 1.8-4 4-4z"/>
                            </svg>
                        </div>
                        <p class="text-gray-300 leading-relaxed text-sm">Since I started using {{$settings->site_name}}, I have been earning like never before. You guys have the best signals.</p>
                    </div>
                    <div class="flex items-center">
                        <img src="temp/custom/imge2.jpg" alt="Malcom47" class="w-10 h-10 rounded-full object-cover border-2 border-blue-500">
                        <div class="ml-3">
                            <h4 class="text-white font-semibold text-sm">Malcom47</h4>
                            <p class="text-blue-400 text-xs">Verified Trader</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="relative group"
                x-data="{ isHovered: false }"
                @mouseenter="isHovered = true; activeTestimonial = 2"
                @mouseleave="isHovered = false; activeTestimonial = null">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/20 to-blue-400/20 rounded-2xl filter blur-xl transition-opacity duration-300"
                    :class="{ 'opacity-75': isHovered, 'opacity-0': !isHovered }"></div>
                <div class="relative h-full bg-gray-800 bg-opacity-80 rounded-2xl p-6 border border-gray-700 transition-all duration-300 hover:border-emerald-500/50">
                    <div class="mb-6">
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                            <svg class="w-8 h-8 text-emerald-400 ml-auto opacity-20" fill="currentColor" viewBox="0 0 32 32">
                                <path d="M10 8c-3.3 0-6 2.7-6 6v10h6V14h-4c0-2.2 1.8-4 4-4zm12 0c-3.3 0-6 2.7-6 6v10h6V14h-4c0-2.2 1.8-4 4-4z"/>
                            </svg>
                        </div>
                        <p class="text-gray-300 leading-relaxed text-sm">I already got more than $200,000 within a month investing with {{$settings->site_name}}. Will again invest soon.</p>
                    </div>
                    <div class="flex items-center">
                        <img src="temp/custom/imge1.jpg" alt="Christy" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-500">
                        <div class="ml-3">
                            <h4 class="text-white font-semibold text-sm">Christy</h4>
                            <p class="text-emerald-400 text-xs">Elite Investor</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="relative group"
                x-data="{ isHovered: false }"
                @mouseenter="isHovered = true; activeTestimonial = 3"
                @mouseleave="isHovered = false; activeTestimonial = null">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-emerald-400/20 rounded-2xl filter blur-xl transition-opacity duration-300"
                    :class="{ 'opacity-75': isHovered, 'opacity-0': !isHovered }"></div>
                <div class="relative h-full bg-gray-800 bg-opacity-80 rounded-2xl p-6 border border-gray-700 transition-all duration-300 hover:border-blue-500/50">
                    <div class="mb-6">
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                            <svg class="w-8 h-8 text-blue-400 ml-auto opacity-20" fill="currentColor" viewBox="0 0 32 32">
                                <path d="M10 8c-3.3 0-6 2.7-6 6v10h6V14h-4c0-2.2 1.8-4 4-4zm12 0c-3.3 0-6 2.7-6 6v10h6V14h-4c0-2.2 1.8-4 4-4z"/>
                            </svg>
                        </div>
                        <p class="text-gray-300 leading-relaxed text-sm">I was able to earn additional $30,000 to my profit. It's amazing, you guys are the best, keep it up.</p>
                    </div>
                    <div class="flex items-center">
                        <img src="temp/custom/imge3.jpg" alt="Linday8" class="w-10 h-10 rounded-full object-cover border-2 border-blue-500">
                        <div class="ml-3">
                            <h4 class="text-white font-semibold text-sm">Linday8</h4>
                            <p class="text-blue-400 text-xs">Professional Trader</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 4 -->
            <div class="relative group"
                x-data="{ isHovered: false }"
                @mouseenter="isHovered = true; activeTestimonial = 4"
                @mouseleave="isHovered = false; activeTestimonial = null">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/20 to-blue-400/20 rounded-2xl filter blur-xl transition-opacity duration-300"
                    :class="{ 'opacity-75': isHovered, 'opacity-0': !isHovered }"></div>
                <div class="relative h-full bg-gray-800 bg-opacity-80 rounded-2xl p-6 border border-gray-700 transition-all duration-300 hover:border-emerald-500/50">
                    <div class="mb-6">
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                            <svg class="w-8 h-8 text-emerald-400 ml-auto opacity-20" fill="currentColor" viewBox="0 0 32 32">
                                <path d="M10 8c-3.3 0-6 2.7-6 6v10h6V14h-4c0-2.2 1.8-4 4-4zm12 0c-3.3 0-6 2.7-6 6v10h6V14h-4c0-2.2 1.8-4 4-4z"/>
                            </svg>
                        </div>
                        <p class="text-gray-300 leading-relaxed text-sm">This was a very easy process and I received my funds quickly as I needed them! Highly recommend {{$settings->site_name}}.</p>
                    </div>
                    <div class="flex items-center">
                        <img src="temp/custom/imge4.jpg" alt="Crian" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-500">
                        <div class="ml-3">
                            <h4 class="text-white font-semibold text-sm">Crian</h4>
                            <p class="text-emerald-400 text-xs">Active Trader</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional testimonials collapsed section -->
        <div x-data="{ showMore: false }" class="mt-8">
            <template x-if="showMore">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                    <!-- Additional testimonials... -->

                    <!-- Testimonial 5 -->
                    <div class="relative bg-gray-800 bg-opacity-80 rounded-2xl p-6 border border-gray-700 transition-all duration-300 hover:border-blue-500/50">
                        <div class="mb-6">
                            <div class="flex items-center mb-4">
                                <div class="flex text-yellow-400">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <!-- More stars... -->
                                </div>
                            </div>
                            <p class="text-gray-300 leading-relaxed text-sm">I rate {{$settings->site_name}} five stars because of the service, you register online, upload ID and you deposit and withdraw after trades. This is so lovely.</p>
                        </div>
                        <div class="flex items-center">
                            <img src="temp/custom/imge5.jpg" alt="Claudia" class="w-10 h-10 rounded-full object-cover border-2 border-blue-500">
                            <div class="ml-3">
                                <h4 class="text-white font-semibold text-sm">Claudia</h4>
                                <p class="text-blue-400 text-xs">Satisfied Investor</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 6 -->
                    <div class="relative bg-gray-800 bg-opacity-80 rounded-2xl p-6 border border-gray-700 transition-all duration-300 hover:border-emerald-500/50">
                        <div class="mb-6">
                            <div class="flex items-center mb-4">
                                <div class="flex text-yellow-400">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <!-- More stars... -->
                                </div>
                            </div>
                            <p class="text-gray-300 leading-relaxed text-sm">I am very pleased with the customer service. Also online service is great and easy thank you {{$settings->site_name}} team.</p>
                        </div>
                        <div class="flex items-center">
                            <img src="temp/custom/jenny.jpg" alt="Jenny" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-500">
                            <div class="ml-3">
                                <h4 class="text-white font-semibold text-sm">Jenny</h4>
                                <p class="text-emerald-400 text-xs">Premium Member</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 7 -->
                    <div class="relative bg-gray-800 bg-opacity-80 rounded-2xl p-6 border border-gray-700 transition-all duration-300 hover:border-blue-500/50">
                        <div class="mb-6">
                            <div class="flex items-center mb-4">
                                <div class="flex text-yellow-400">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <!-- More stars... -->
                                </div>
                            </div>
                            <p class="text-gray-300 leading-relaxed text-sm">I'm happy, that in difficult times there are people that will support you and help you make more money, thank you {{$settings->site_name}} for giving me a chance.</p>
                        </div>
                        <div class="flex items-center">
                            <img src="temp/custom/mike.jpg" alt="Mike" class="w-10 h-10 rounded-full object-cover border-2 border-blue-500">
                            <div class="ml-3">
                                <h4 class="text-white font-semibold text-sm">Mike</h4>
                                <p class="text-blue-400 text-xs">Regular Investor</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 8 -->
                    <div class="relative bg-gray-800 bg-opacity-80 rounded-2xl p-6 border border-gray-700 transition-all duration-300 hover:border-emerald-500/50">
                        <div class="mb-6">
                            <div class="flex items-center mb-4">
                                <div class="flex text-yellow-400">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <!-- More stars... -->
                                </div>
                            </div>
                            <p class="text-gray-300 leading-relaxed text-sm">I've invested with {{$settings->site_name}} several times, always paid back on time. The entire trade process is complete in just a few days. Very impressed and satisfied.</p>
                        </div>
                        <div class="flex items-center">
                            <img src="temp/custom/kathy.jpg" alt="Kathy" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-500">
                            <div class="ml-3">
                                <h4 class="text-white font-semibold text-sm">Kathy</h4>
                                <p class="text-emerald-400 text-xs">Long-term Client</p>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- View More Button -->
            <div class="text-center mt-12">
                <button @click="showMore = !showMore"
                    class="inline-flex items-center px-6 py-3 rounded-xl bg-gradient-to-r from-blue-500 to-emerald-400 text-white font-medium transition-transform duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-blue-500/25">
                    <span x-text="showMore ? 'Daha Az Göster' : 'Daha Fazla Başarı Hikayesi Görüntüle'"></span>
                    <svg class="w-5 h-5 ml-2 transition-transform duration-300"
                        :class="{ 'rotate-180': showMore }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>



<!-- Cryptocurrency Logos Section - Dark Mode -->
<section class="bg-gray-900 py-10">
  <div class="container mx-auto px-4">
    <div class="max-w-7xl mx-auto">
      <div class="flex flex-wrap justify-center items-center gap-8 md:gap-12">
        <!-- Bitcoin -->
        <div class="w-1/4 sm:w-1/6 md:w-1/7 transform hover:scale-110 transition-transform duration-300">
          <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm p-4 rounded-xl border border-gray-700 hover:border-blue-500">
            <img src="temp/custom/img/btc.png" alt="Bitcoin" class="w-full h-auto filter drop-shadow-lg">
          </div>
        </div>

        <!-- Ethereum -->
        <div class="w-1/4 sm:w-1/6 md:w-1/7 transform hover:scale-110 transition-transform duration-300">
          <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm p-4 rounded-xl border border-gray-700 hover:border-blue-500">
            <img src="temp/custom/img/eth.png" alt="Ethereum" class="w-full h-auto filter drop-shadow-lg">
          </div>
        </div>

        <!-- Dogecoin -->
        <div class="w-1/4 sm:w-1/6 md:w-1/7 transform hover:scale-110 transition-transform duration-300">
          <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm p-4 rounded-xl border border-gray-700 hover:border-blue-500">
            <img src="temp/custom/img/doge.png" alt="Dogecoin" class="w-full h-auto filter drop-shadow-lg">
          </div>
        </div>

        <!-- Bitcoin Cash -->
        <div class="w-1/4 sm:w-1/6 md:w-1/7 transform hover:scale-110 transition-transform duration-300">
          <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm p-4 rounded-xl border border-gray-700 hover:border-blue-500">
            <img src="temp/custom/img/bch.png" alt="Bitcoin Cash" class="w-full h-auto filter drop-shadow-lg">
          </div>
        </div>

        <!-- Tether -->
        <div class="w-1/4 sm:w-1/6 md:w-1/7 transform hover:scale-110 transition-transform duration-300">
          <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm p-4 rounded-xl border border-gray-700 hover:border-blue-500">
            <img src="temp/custom/img/usdt.png" alt="Tether" class="w-full h-auto filter drop-shadow-lg">
          </div>
        </div>

        <!-- Binance Coin -->
        <div class="w-1/4 sm:w-1/6 md:w-1/7 transform hover:scale-110 transition-transform duration-300">
          <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm p-4 rounded-xl border border-gray-700 hover:border-blue-500">
            <img src="temp/custom/img/bnb.png" alt="Binance Coin" class="w-full h-auto filter drop-shadow-lg">
          </div>
        </div>

        <!-- Litecoin -->
        <div class="w-1/4 sm:w-1/6 md:w-1/7 transform hover:scale-110 transition-transform duration-300">
          <div class="bg-gray-800 bg-opacity-50 backdrop-blur-sm p-4 rounded-xl border border-gray-700 hover:border-blue-500">
            <img src="temp/custom/img/ltc.png" alt="Litecoin" class="w-full h-auto filter drop-shadow-lg">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script type=text/javascript> var host = 'h51.p.ctrader.com';</script><script src=temp/custom/js/spreads-home.js type=module></script>

@endsection

