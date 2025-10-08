
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
        "locale": "en"
        }
        </script>
    </div>
    <!-- TradingView Widget END -->
</div>


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
                        "locale": "tr",
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
                        "timeZone": "Europe/Istanbul",
                        "style": "area",
                        "interval": "1D",
                        "hideDateRanges": false,
                        "hideMarketStatus": false,
                        "hideSymbolLogo": false,
                        "saveImage": false,
                        "calendar": false,
                        "showVolume": true,
                        "volumeUpColor": "rgba(0, 255, 0, 0.8)",
                        "volumeDownColor": "rgba(255, 0, 0, 0.8)",
                        "showIntervalTabs": true,
                        "showCurrencySymbols": true,
                        "showPriceLabels": true,
                        "showChangePercent": true,
                        "showChangeValue": true,
                        "enableScrolling": false,
                        "fontSizes": {
                            "title": 16,
                            "label": 12,
                            "value": 14
                        },
                        "backgroundColor": "rgba(0, 0, 0, 0)",
                        "widgetFontColor": "rgba(255, 255, 255, 1)",
                        "borderColor": "rgba(255, 255, 255, 0.1)",
                        "upColor": "#26a69a",
                        "downColor": "#ef5350",
                        "borderUpColor": "#26a69a",
                        "borderDownColor": "#ef5350",
                        "wickUpColor": "#26a69a",
                        "wickDownColor": "#ef5350",
                        "ohlcColor": "#2962FF",
                        "bidAskColor": "#FF6D00",
                        "prePostMarketColor": "#FF9800",
                        "priceLineColor": "#2962FF",
                        "lineColor": "#2962FF",
                        "areaColor": "rgba(41, 98, 255, 0.12)",
                        "areaTopColor": "rgba(41, 98, 255, 0.12)",
                        "areaBottomColor": "rgba(41, 98, 255, 0)",
                        "crosshairColor": "rgba(255, 255, 255, 0.8)",
                        "crosshairBackgroundColor": "rgba(0, 0, 0, 0.9)",
                        "crosshairLabelBackgroundColor": "rgba(0, 0, 0, 0.8)",
                        "crosshairLabelBorderColor": "rgba(255, 255, 255, 0.2)",
                        "scaleTextColor": "rgba(255, 255, 255, 1)",
                        "scaleLineColor": "rgba(255, 255, 255, 0.2)",
                        "scaleLabelColor": "rgba(255, 255, 255, 0.8)",
                        "scaleGridLineColor": "rgba(255, 255, 255, 0.1)",
                        "tabActiveBackgroundColor": "rgba(41, 98, 255, 0.12)",
                        "tabBackgroundColor": "rgba(255, 255, 255, 0.05)",
                        "tabBorderColor": "rgba(255, 255, 255, 0.1)",
                        "tabBodyBackgroundColor": "rgba(0, 0, 0, 0)",
                        "tabBodyBorderColor": "rgba(255, 255, 255, 0.1)",
                        "tabBodyTextColor": "rgba(255, 255, 255, 1)",
                        "tabHeaderBackgroundColor": "rgba(0, 0, 0, 0)",
                        "tabHeaderTextColor": "rgba(255, 255, 255, 1)",
                        "tabHoverBackgroundColor": "rgba(255, 255, 255, 0.1)",
                        "tableColor": "rgba(255, 255, 255, 1)",
                        "tableGridColor": "rgba(255, 255, 255, 0.1)",
                        "tableTextColor": "rgba(255, 255, 255, 1)",
                        "tableHeaderColor": "rgba(255, 255, 255, 1)",
                        "tableHeaderBackgroundColor": "rgba(255, 255, 255, 0.05)",
                        "tableHeaderTextColor": "rgba(255, 255, 255, 1)",
                        "tableRowBackgroundColor": "rgba(255, 255, 255, 0.02)",
                        "tableRowBorderColor": "rgba(255, 255, 255, 0.05)",
                        "tableRowHoverBackgroundColor": "rgba(255, 255, 255, 0.05)",
                        "tableRowTextColor": "rgba(255, 255, 255, 1)",
                        "loadingScreenBackgroundColor": "rgba(0, 0, 0, 0.9)",
                        "loadingScreenSpinnerColor": "rgba(255, 255, 255, 1)",
                        "loadingScreenTextColor": "rgba(255, 255, 255, 0.8)",
                        "tooltipBackgroundColor": "rgba(0, 0, 0, 0.9)",
                        "tooltipBorderColor": "rgba(255, 255, 255, 0.2)",
                        "tooltipTextColor": "rgba(255, 255, 255, 1)",
                        "tooltipHeaderTextColor": "rgba(255, 255, 255, 1)",
                        "tooltipBodyTextColor": "rgba(255, 255, 255, 0.8)",
                        "tooltipArrowColor": "rgba(0, 0, 0, 0.9)",
                        "scrollbarColor": "rgba(255, 255, 255, 0.3)",
                        "scrollbarBackgroundColor": "rgba(0, 0, 0, 0)",
                        "scrollbarBorderColor": "rgba(255, 255, 255, 0.1)",
                        "scrollbarArrowColor": "rgba(255, 255, 255, 0.5)",
                        "resizeBorderColor": "rgba(255, 255, 255, 0.3)",
                        "resizeBackgroundColor": "rgba(0, 0, 0, 0.8)",
                        "resizeHandleColor": "rgba(255, 255, 255, 0.5)",
                        "contextMenuBackgroundColor": "rgba(0, 0, 0, 0.9)",
                        "contextMenuBorderColor": "rgba(255, 255, 255, 0.2)",
                        "contextMenuTextColor": "rgba(255, 255, 255, 1)",
                        "contextMenuHoverBackgroundColor": "rgba(255, 255, 255, 0.1)",
                        "contextMenuArrowColor": "rgba(255, 255, 255, 0.8)",
                        "dialogBackgroundColor": "rgba(0, 0, 0, 0.9)",
                        "dialogBorderColor": "rgba(255, 255, 255, 0.2)",
                        "dialogTextColor": "rgba(255, 255, 255, 1)",
                        "dialogHeaderTextColor": "rgba(255, 255, 255, 1)",
                        "dialogButtonBackgroundColor": "rgba(41, 98, 255, 1)",
                        "dialogButtonBorderColor": "rgba(41, 98, 255, 1)",
                        "dialogButtonTextColor": "rgba(255, 255, 255, 1)",
                        "dialogButtonHoverBackgroundColor": "rgba(41, 98, 255, 0.8)",
                        "dialogInputBackgroundColor": "rgba(255, 255, 255, 0.1)",
                        "dialogInputBorderColor": "rgba(255, 255, 255, 0.2)",
                        "dialogInputTextColor": "rgba(255, 255, 255, 1)",
                        "notificationBackgroundColor": "rgba(0, 0, 0, 0.9)",
                        "notificationBorderColor": "rgba(255, 255, 255, 0.2)",
                        "notificationTextColor": "rgba(255, 255, 255, 1)",
                        "notificationIconColor": "rgba(255, 255, 255, 1)",
                        "rangeSelectorBackgroundColor": "rgba(0, 0, 0, 0)",
                        "rangeSelectorBorderColor": "rgba(255, 255, 255, 0.1)",
                        "rangeSelectorButtonBackgroundColor": "rgba(255, 255, 255, 0.1)",
                        "rangeSelectorButtonBorderColor": "rgba(255, 255, 255, 0.2)",
                        "rangeSelectorButtonTextColor": "rgba(255, 255, 255, 1)",
                        "rangeSelectorInputBackgroundColor": "rgba(255, 255, 255, 0.1)",
                        "rangeSelectorInputBorderColor": "rgba(255, 255, 255, 0.2)",
                        "rangeSelectorInputTextColor": "rgba(255, 255, 255, 1)",
                        "rangeSelectorLabelColor": "rgba(255, 255, 255, 0.8)",
                        "rangeSelectorSelectedBackgroundColor": "rgba(41, 98, 255, 0.2)",
                        "rangeSelectorSelectedBorderColor": "rgba(41, 98, 255, 0.3)",
                        "rangeSelectorThumbBackgroundColor": "rgba(255, 255, 255, 1)",
                        "rangeSelectorThumbBorderColor": "rgba(0, 0, 0, 0.3)",
                        "separatorColor": "rgba(255, 255, 255, 0.1)",
                        "shadowColor": "rgba(0, 0, 0, 0.5)",
                        "shadowOpacity": 0.5,
                        "shadowBlur": 10,
                        "shadowOffsetX": 0,
                        "shadowOffsetY": 2,
                        "popupBackgroundColor": "rgba(0, 0, 0, 0.9)",
                        "popupBorderColor": "rgba(255, 255, 255, 0.2)",
                        "popupTextColor": "rgba(255, 255, 255, 1)",
                        "popupArrowColor": "rgba(0, 0, 0, 0.9)",
                        "popupShadowColor": "rgba(0, 0, 0, 0.5)",
                        "popupShadowOpacity": 0.5,
                        "popupShadowBlur": 10,
                        "popupShadowOffsetX": 0,
                        "popupShadowOffsetY": 2,
                        "dropdownBackgroundColor": "rgba(0, 0, 0, 0.9)",
                        "dropdownBorderColor": "rgba(255, 255, 255, 0.2)",
                        "dropdownTextColor": "rgba(255, 255, 255, 1)",
                        "dropdownHoverBackgroundColor": "rgba(255, 255, 255, 0.1)",
                        "dropdownArrowColor": "rgba(255, 255, 255, 0.8)",
                        "dropdownSeparatorColor": "rgba(255, 255, 255, 0.1)",
                        "dropdownShadowColor": "rgba(0, 0, 0, 0.5)",
                        "dropdownShadowOpacity": 0.5,
                        "dropdownShadowBlur": 10,
                        "dropdownShadowOffsetX": 0,
                        "dropdownShadowOffsetY": 2,
                        "buttonBackgroundColor": "rgba(41, 98, 255, 1)",
                        "buttonBorderColor": "rgba(41, 98, 255, 1)",
                        "buttonTextColor": "rgba(255, 255, 255, 1)",
                        "buttonHoverBackgroundColor": "rgba(41, 98, 255, 0.8)",
                        "buttonHoverBorderColor": "rgba(41, 98, 255, 0.8)",
                        "buttonHoverTextColor": "rgba(255, 255, 255, 1)",
                        "buttonDisabledBackgroundColor": "rgba(255, 255, 255, 0.1)",
                        "buttonDisabledBorderColor": "rgba(255, 255, 255, 0.2)",
                        "buttonDisabledTextColor": "rgba(255, 255, 255, 0.5)",
                        "inputBackgroundColor": "rgba(255, 255, 255, 0.1)",
                        "inputBorderColor": "rgba(255, 255, 255, 0.2)",
                        "inputTextColor": "rgba(255, 255, 255, 1)",
                        "inputFocusBackgroundColor": "rgba(255, 255, 255, 0.15)",
                        "inputFocusBorderColor": "rgba(41, 98, 255, 0.5)",
                        "inputFocusTextColor": "rgba(255, 255, 255, 1)",
                        "inputPlaceholderColor": "rgba(255, 255, 255, 0.5)",
                        "inputErrorBackgroundColor": "rgba(244, 67, 54, 0.1)",
                        "inputErrorBorderColor": "rgba(244, 67, 54, 0.5)",
                        "inputErrorTextColor": "rgba(244, 67, 54, 1)",
                        "inputWarningBackgroundColor": "rgba(255, 152, 0, 0.1)",
                        "inputWarningBorderColor": "rgba(255, 152, 0, 0.5)",
                        "inputWarningTextColor": "rgba(255, 152, 0, 1)",
                        "inputSuccessBackgroundColor": "rgba(76, 175, 80, 0.1)",
                        "inputSuccessBorderColor": "rgba(76, 175, 80, 0.5)",
                        "inputSuccessTextColor": "rgba(76, 175, 80, 1)",
                        "checkboxBackgroundColor": "rgba(255, 255, 255, 0.1)",
                        "checkboxBorderColor": "rgba(255, 255, 255, 0.2)",
                        "checkboxCheckedBackgroundColor": "rgba(41, 98, 255, 1)",
                        "checkboxCheckedBorderColor": "rgba(41, 98, 255, 1)",
                        "checkboxDisabledBackgroundColor": "rgba(255, 255, 255, 0.05)",
                        "checkboxDisabledBorderColor": "rgba(255, 255, 255, 0.1)",
                        "radioBackgroundColor": "rgba(255, 255, 255, 0.1)",
                        "radioBorderColor": "rgba(255, 255, 255, 0.2)",
                        "radioCheckedBackgroundColor": "rgba(41, 98, 255, 1)",
                        "radioCheckedBorderColor": "rgba(41, 98, 255, 1)",
                        "radioDisabledBackgroundColor": "rgba(255, 255, 255, 0.05)",
                        "radioDisabledBorderColor": "rgba(255, 255, 255, 0.1)",
                        "toggleBackgroundColor": "rgba(255, 255, 255, 0.1)",
                        "toggleBorderColor": "rgba(255, 255, 255, 0.2)",
                        "toggleCheckedBackgroundColor": "rgba(41, 98, 255, 1)",
                        "toggleCheckedBorderColor": "rgba(41, 98, 255, 1)",
                        "toggleDisabledBackgroundColor": "rgba(255, 255, 255, 0.05)",
                        "toggleDisabledBorderColor": "rgba(255, 255, 255, 0.1)",
                        "toggleThumbColor": "rgba(255, 255, 255, 1)",
                        "toggleThumbDisabledColor": "rgba(255, 255, 255, 0.5)",
                        "selectBackgroundColor": "rgba(255, 255, 255, 0.1)",
                        "selectBorderColor": "rgba(255, 255, 255, 0.2)",
                        "selectTextColor": "rgba(255, 255, 255, 1)",
                        "selectArrowColor": "rgba(255, 255, 255, 0.8)",
                        "selectHoverBackgroundColor": "rgba(255, 255, 255, 0.15)",
                        "selectDisabledBackgroundColor": "rgba(255, 255, 255, 0.05)",
                        "selectDisabledBorderColor": "rgba(255, 255, 255, 0.1)",
                        "selectDisabledTextColor": "rgba(255, 255, 255, 0.5)",
                        "textareaBackgroundColor": "rgba(255, 255, 255, 0.1)",
                        "textareaBorderColor": "rgba(255, 255, 255, 0.2)",
                        "textareaTextColor": "rgba(255, 255, 255, 1)",
                        "textareaPlaceholderColor": "rgba(255, 255, 255, 0.5)",
                        "textareaFocusBackgroundColor": "rgba(255, 255, 255, 0.15)",
                        "textareaFocusBorderColor": "rgba(41, 98, 255, 0.5)",
                        "textareaDisabledBackgroundColor": "rgba(255, 255, 255, 0.05)",
                        "textareaDisabledBorderColor": "rgba(255, 255, 255, 0.1)",
                        "textareaDisabledTextColor": "rgba(255, 255, 255, 0.5)",
                        "progressBackgroundColor": "rgba(255, 255, 255, 0.1)",
                        "progressFillColor": "rgba(41, 98, 255, 1)",
                        "progressTextColor": "rgba(255, 255, 255, 1)",
                        "badgeBackgroundColor": "rgba(41, 98, 255, 1)",
                        "badgeTextColor": "rgba(255, 255, 255, 1)",
                        "badgeBorderColor": "rgba(41, 98, 255, 1)",
                        "tagBackgroundColor": "rgba(255, 255, 255, 0.1)",
                        "tagTextColor": "rgba(255, 255, 255, 1)",
                        "tagBorderColor": "rgba(255, 255, 255, 0.2)",
                        "tagCloseColor": "rgba(255, 255, 255, 0.8)",
                        "tagCloseHoverColor": "rgba(255, 255, 255, 1)",
                        "spinnerColor": "rgba(255, 255, 255, 1)",
                        "spinnerBackgroundColor": "rgba(0, 0, 0, 0.5)",
                        "iconColor": "rgba(255, 255, 255, 1)",
                        "iconHoverColor": "rgba(255, 255, 255, 0.8)",
                        "iconDisabledColor": "rgba(255, 255, 255, 0.5)",
                        "linkColor": "rgba(41, 98, 255, 1)",
                        "linkHoverColor": "rgba(41, 98, 255, 0.8)",
                        "linkVisitedColor": "rgba(41, 98, 255, 0.9)",
                        "linkActiveColor": "rgba(41, 98, 255, 1)",
                        "linkDisabledColor": "rgba(255, 255, 255, 0.5)",
                        "highlightColor": "rgba(41, 98, 255, 0.2)",
                        "overlayBackgroundColor": "rgba(0, 0, 0, 0.8)",
                        "overlayTextColor": "rgba(255, 255, 255, 1)",
                        "overlayIconColor": "rgba(255, 255, 255, 1)",
                        "overlayCloseColor": "rgba(255, 255, 255, 0.8)",
                        "overlayCloseHoverColor": "rgba(255, 255, 255, 1)",
                        "dividerColor": "rgba(255, 255, 255, 0.1)",
                        "dividerTextColor": "rgba(255, 255, 255, 1)",
                        "focusRingColor": "rgba(41, 98, 255, 0.5)",
                        "focusRingOffset": 2,
                        "focusRingWidth": 2,
                        "animationDuration": 200,
                        "animationEasing": "ease-out",
                        "zIndex": 1000,
                        "borderRadius": 8,
                        "borderWidth": 1,
                        "spacing": 8,
                        "padding": 16,
                        "margin": 0,
                        "fontFamily": "Trebuchet MS, Roboto, Ubuntu, sans-serif",
                        "fontSize": 14,
                        "fontWeight": 400,
                        "lineHeight": 1.4,
                        "letterSpacing": 0,
                        "textAlign": "left",
                        "textDecoration": "none",
                        "textTransform": "none",
                        "textShadow": "none",
                        "boxShadow": "0 2px 10px rgba(0, 0, 0, 0.5)",
                        "backdropFilter": "blur(10px)",
                        "transition": "all 200ms ease-out",
                        "transform": "none",
                        "opacity": 1,
                        "visibility": "visible",
                        "display": "block",
                        "position": "relative",
                        "overflow": "hidden",
                        "cursor": "default",
                        "pointerEvents": "auto",
                        "userSelect": "text",
                        "resize": "none",
                        "scrollBehavior": "smooth",
                        "tabs": [
                            {
                                "title": "Endeksler",
                                "symbols": [
                                    {"s": "SPX500", "d": "S&P 500"},
                                    {"s": "NDX", "d": "NASDAQ 100"},
                                    {"s": "DJI", "d": "Dow Jones"},
                                    {"s": "FTSE", "d": "FTSE 100"},
                                    {"s": "CAC40", "d": "CAC 40"},
                                    {"s": "DAX", "d": "DAX 40"}
                                ],
                                "originalTitle": "Endeksler"
                            },
                            {
                                "title": "Emtia",
                                "symbols": [
                                    {"s": "XAUUSD", "d": "Altın"},
                                    {"s": "XAGUSD", "d": "Gümüş"},
                                    {"s": "XPTUSD", "d": "Platinum"},
                                    {"s": "XPTUSD", "d": "Palladium"},
                                    {"s": "OIL", "d": "Brent Petrol"},
                                    {"s": "USDTRY", "d": "USD/TRY Vadeli"}
                                ],
                                "originalTitle": "Emtia"
                            },
                            {
                                "title": "Tahviller",
                                "symbols": [
                                    {"s": "US10Y", "d": "Türkiye Tahvili"}
                                ],
                                "originalTitle": "Tahviller"
                            },
                            {
                                "title": "Döviz",
                                "symbols": [
                                    {"s": "FX:USDTRY", "d": "USD/TRY"},
                                    {"s": "FX:EURTRY", "d": "EUR/TRY"},
                                    {"s": "GBPUSD", "d": "GBP/TRY"},
                                    {"s": "USDJPY", "d": "JPY/TRY"},
                                    {"s": "USDCHF", "d": "CHF/TRY"},
                                    {"s": "USDCAD", "d": "CAD/TRY"}
                                ],
                                "originalTitle": "Döviz"
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
            <h2 class="text-3xl font-bold text-white">Çeşitli Ticaret Ürünleri</h2>
            <p class="mt-2 text-gray-400">Rekabetçi koşullar ile küresel piyasalara erişin</p>
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
                    <p class="text-gray-400 mb-4">70+ ana, ikincil ve egzotik döviz çiftiyle rekabetçi spreadler ve koşullarla ticaret yapın</p>
                    <a href="forex" class="text-blue-400 hover:text-blue-300 flex items-center text-sm font-medium">
                        Forex'i Keşfedin
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
                    <h3 class="text-xl font-bold text-white mb-2">Hisse Senetleri</h3>
                    <p class="text-gray-400 mb-4">ABD, İngiltere, Almanya ve daha fazla piyasadan yüzlerce halka açık şirkete erişin</p>
                    <a href="shares" class="text-green-400 hover:text-green-300 flex items-center text-sm font-medium">
                        Hisse Senetlerini Keşfedin
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
                    <h3 class="text-xl font-bold text-white mb-2">Enerjiler</h3>
                    <p class="text-gray-400 mb-4">İngiltere ve ABD Ham Petrolü ile doğal gazda fırsatları sıkı spreadlerle keşfedin</p>
                    <a href="commodities" class="text-yellow-400 hover:text-yellow-300 flex items-center text-sm font-medium">
                        Enerjileri Keşfedin
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
                    <h3 class="text-xl font-bold text-white mb-2">Endeksler</h3>
                    <p class="text-gray-400 mb-4">Dünyanın her yerinden ana ve ikincil Endeks CFD'lerinde rekabetçi koşullarla ticaret yapın</p>
                    <a href="indices" class="text-blue-400 hover:text-blue-300 flex items-center text-sm font-medium">
                        Endeksleri Keşfedin
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
                Popüler Varlık Sınıfı
            </div>
            <h2 class="text-3xl font-bold text-white">Kripto Para Ticareti</h2>
            <p class="mt-2 text-gray-400 max-w-2xl mx-auto">Dünyanın en popüler dijital varlıklarını rekabetçi spreadler ve gelişmiş araçlarla ticaret edin</p>
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
                Tüm kripto paraları görüntüle
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
                Üstün Ticaret Deneyimi
            </span>
            <h2 class="mt-2 text-3xl font-bold text-white">Daha Dar Spreadler. Daha Hızlı Yürütme.</h2>
            <p class="mt-2 text-gray-400 max-w-2xl mx-auto">Profesyonel tüccarlar için tasarlanmış kurumsal sınıf ticaret koşullarını yaşayın</p>
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
                            Detaylı koşulları görüntüle
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
                Hikayemiz
            </span>
            <h2 class="mt-2 text-3xl font-bold text-white">Hakkımızda</h2>
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
                        Kişiselleştirilmiş Ticaret
                    </h3>
                    <p class="text-gray-400 mt-2">
                        Biraz mı yoksa çok mu risk almak istiyorsunuz? Kısa vadede mi yoksa uzun vadede mi kazanç istiyorsunuz? Günlük tüccar mı, swing tüccarı mı yoksa scalper mı olmak istiyorsunuz?
                    </p>
                </div>

                <div class="bg-dark-300 bg-opacity-60 p-4 rounded-lg">
                    <h3 class="text-white font-semibold flex items-center">
                        <i class="fas fa-check-circle text-primary mr-2"></i>
                        Tam Kontrol
                    </h3>
                    <p class="text-gray-400 mt-2">
                        Doğru araçlar, bilgiler ve dünyanın tüm para birimlerine erişim ile {{$settings->site_name}}, yaptığınız işlemlerin kontrolünü size verir.
                    </p>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="about" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-blue-700 transition duration-150">
                    Hakkımızda daha fazla bilgi edinin
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

            <!-- Expert Support Content -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2 flex items-center">
                        <i class="fas fa-headset text-primary mr-3"></i>
                        UZMANLARIMIZLA GÜNCEL KALIN
                    </h2>
                    <div class="h-1 w-20 bg-primary my-4"></div>
                    <p class="text-gray-300 leading-relaxed">
                        Yerel ve uluslararası ekiplerimiz, 20'den fazla dilde 24/5 bazında sizi desteklemek için burada. Aynı zamanda geniş ödeme yöntemleri yelpazemiz, yatırımlar ve çekimler konusunda size daha fazla esneklik sağlıyor.
                    </p>
                </div>

                <div class="bg-dark-300 rounded-lg p-6 border border-gray-800">
                    <h2 class="text-xl font-bold text-white mb-3 flex items-center">
                        <i class="fas fa-star text-yellow-400 mr-3"></i>
                        Ticaretten Daha Fazla Deneyim Yaşam
                    </h2>
                    <p class="text-gray-300 leading-relaxed">
                        Başarımız bir dizi temel değer etrafında toplanır. Bunlar arasında sıkı spreadler aracılığıyla rekabetçi brokeraj ücretleri sağlama, yıldırım hızında yürütme sağlama, geniş ürün yelpazesi ile gelişmiş ticaret platformlarına erişim ve istisnai müşteri hizmetleri yer alır.
                    </p>

                    <div class="mt-6">
                        <a href="login" class="inline-flex items-center px-5 py-2 border border-gray-700 text-base font-medium rounded-md text-gray-300 hover:text-white hover:border-primary transition duration-150">
                            Komisyonlarımızı öğrenin
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
                Platform Özellikleri
            </span>
            <h2 class="mt-3 text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-400">Gelişmiş Ticaret Araçları</h2>
            <p class="mt-3 text-gray-300 max-w-2xl mx-auto">Platformumuz, başarılı ticaret için ihtiyacınız olan her şeyi güçlü bir arayüzde sağlar</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Feature 1 -->
            <div class="bg-gray-800 bg-opacity-80 p-6 rounded-xl border border-gray-700 hover:border-blue-500 shadow-lg transition duration-300 transform hover:-translate-y-1 hover:shadow-blue-900/20">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <i class="fas fa-bolt text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Güvenilir <span class="text-blue-400">Yürütme</span></h3>
                <p class="text-gray-300">
                    Piyasanın en keskin yürütmesi ile, {{$settings->site_name}} cTrader, herhangi bir requote veya fiyat manipülasyonu olmadan siparişlerinizi milisaniyeler içinde doldurur.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-gray-800 bg-opacity-80 p-6 rounded-xl border border-gray-700 hover:border-blue-500 shadow-lg transition duration-300 transform hover:-translate-y-1 hover:shadow-blue-900/20">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-blue-700 rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Akıllı <span class="text-indigo-400">Analiz</span></h3>
                <p class="text-gray-300">
                    Trading Central'den akıllı piyasa analizi araçları, Canlı Duygu verileri ve platform içi piyasa içgörüleri ile bilinçli kararlar alın.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-gray-800 bg-opacity-80 p-6 rounded-xl border border-gray-700 hover:border-blue-500 shadow-lg transition duration-300 transform hover:-translate-y-1 hover:shadow-blue-900/20">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <i class="fas fa-search-dollar text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Şeffaf <span class="text-cyan-400">Raporlama</span></h3>
                <p class="text-gray-300">
                    Performansınızın kristal kadar net şekilde anlaşılması için işlem istatistiklerine, öz sermaye grafikleri ve işlemlerinizin detaylı geçmişine erişin.
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-gray-800 bg-opacity-80 p-6 rounded-xl border border-gray-700 hover:border-blue-500 shadow-lg transition duration-300 transform hover:-translate-y-1 hover:shadow-blue-900/20">
                <div class="w-16 h-16 bg-gradient-to-br from-teal-600 to-green-700 rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <i class="fas fa-desktop text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">Sezgisel <span class="text-teal-400">Arayüz</span></h3>
                <p class="text-gray-300">
                    Kolay kullanım ve navigasyon, {{$settings->site_name}} cTrader gerçek tüccarların ihtiyaçları göz önünde bulundurularak inşa edildi. {{$settings->site_name}} cTrader ile ticaret yapın ve belirgin avantajını deneyimleyin.
                </p>
            </div>
        </div>
    </div>
</section>















<!-- How It Works Section -->
<section class="py-16 bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 text-center">
            <span class="inline-block px-4 py-1 text-sm font-semibold tracking-wider text-blue-400 uppercase bg-blue-900 bg-opacity-70 rounded-full shadow-lg">
                Basit Süreç
            </span>
            <h2 class="mt-3 text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-600">Nasıl Çalışır</h2>
            <p class="mt-3 text-gray-300 max-w-2xl mx-auto">Üç basit adımda ticaret yapmaya başlayın</p>
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
                Başarı Hikayeleri
            </span>
            <h2 class="mt-3 text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-400">Müşteri Görüşleri</h2>
            <p class="mt-3 text-gray-300 max-w-2xl mx-auto">Platformumuzla etkileyici sonuçlar elde eden memnun müşterilerimizden duyun</p>
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
                        <p class="text-gray-300 leading-relaxed text-sm">Monexa Finans kullanmaya başladıktan beri daha önce hiç olmadığı kadar kazanç elde ediyorum. Sizler en iyi sinyallere sahipsiniz.</p>
                    </div>
                    <div class="flex items-center">
                        <img src="temp/custom/imge2.jpg" alt="Ahmet Yılmaz" class="w-10 h-10 rounded-full object-cover border-2 border-blue-500">
                        <div class="ml-3">
                            <h4 class="text-white font-semibold text-sm">Ahmet Yılmaz</h4>
                            <p class="text-blue-400 text-xs">Doğrulanmış Tüccar</p>
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
                        <p class="text-gray-300 leading-relaxed text-sm">Monexa Finans ile yatırım yaparak bir ay içinde 200.000 $'dan fazla kazandım. Yakında tekrar yatırım yapacağım.</p>
                    </div>
                    <div class="flex items-center">
                        <img src="temp/custom/imge1.jpg" alt="Mehmet Kaya" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-500">
                        <div class="ml-3">
                            <h4 class="text-white font-semibold text-sm">Mehmet Kaya</h4>
                            <p class="text-emerald-400 text-xs">Elit Yatırımcı</p>
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
                        <p class="text-gray-300 leading-relaxed text-sm">Karıma 30.000 $ ek kazanç sağlayabildim. Harika, sizler en iyisiniz, devam edin.</p>
                    </div>
                    <div class="flex items-center">
                        <img src="temp/custom/imge3.jpg" alt="Ayşe Demir" class="w-10 h-10 rounded-full object-cover border-2 border-blue-500">
                        <div class="ml-3">
                            <h4 class="text-white font-semibold text-sm">Ayşe Demir</h4>
                            <p class="text-blue-400 text-xs">Profesyonel Tüccar</p>
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
                        <p class="text-gray-300 leading-relaxed text-sm">Bu çok kolay bir süreçti ve fonlarımı ihtiyaç duyduğum kadar hızlı aldım! Monexa Finans'yi şiddetle tavsiye ederim.</p>
                    </div>
                    <div class="flex items-center">
                        <img src="temp/custom/imge4.jpg" alt="Fatma Öz" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-500">
                        <div class="ml-3">
                            <h4 class="text-white font-semibold text-sm">Fatma Öz</h4>
                            <p class="text-emerald-400 text-xs">Aktif Tüccar</p>
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
                            <p class="text-gray-300 leading-relaxed text-sm">{{$settings->site_name}}'ye hizmet nedeniyle beş yıldız veriyorum, çünkü çevrimiçi kayıt oluyorsunuz, kimlik yükleyip ticaret sonrasında yatırma ve çekme yapıyorsunuz. Bu çok hoş.</p>
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
                            <p class="text-gray-300 leading-relaxed text-sm">Müşteri hizmetinden çok memnunum. Ayrıca çevrimiçi hizmet harika ve kolay, teşekkür ederim {{$settings->site_name}} ekibi.</p>
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
                            <p class="text-gray-300 leading-relaxed text-sm">Mutluyum ki zor zamanlarda sizi destekleyecek ve daha fazla para kazanmanıza yardımcı olacak insanlar var, bana şans verdiğiniz için teşekkür ederim {{$settings->site_name}}.</p>
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
                            <p class="text-gray-300 leading-relaxed text-sm">{{$settings->site_name}} ile birkaç kez yatırım yaptım, her zaman zamanında geri ödedim. Tüm ticaret süreci sadece birkaç günde tamamlandı. Çok etkilendim ve memnunum.</p>
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
            <p class="text-center text-gray-400 text-sm mt-4">Resimler gizlilik gereği gerçek değildir.</p>
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


@endsection

