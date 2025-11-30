<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="dark bg-gray-300 h-full" data-theme="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->site_name ?? 'Trading Platform' }} - @yield('title', 'Secure Trading Platform')</title>

    <!-- Favicon -->
    <link href="{{ ($settings && $settings->favicon) ? asset('storage/'.$settings->favicon) : asset('favicon.ico') }}" rel="icon" type="image/x-icon" />

    <!-- Inter Font - Local -->
    <link href="{{ asset('vendor/fonts/inter.css') }}" rel="stylesheet">

    <!-- Tailwind CSS configurations are now handled by Vite build -->

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Heroicons - Loaded via unified Icon Service -->

    <!-- All styles now handled by Vite with Tailwind CSS -->

<title>{{ $settings->site_name ?? 'Trading Platform' }}</title>
<meta name="theme-color" content="#4D7DE6">
<meta name="msapplication-navbutton-color" content="#4D7DE6">
<!-- iOS Safari -->
<meta name="apple-mobile-web-app-status-bar-style" content="#4D7DE6">

<meta name="theme-color" content="#4D7DE6">
<meta name="msapplication-navbutton-color" content="#4D7DE6">
<!-- iOS Safari -->
<meta name="apple-mobile-web-app-status-bar-style" content="#4D7DE6">

<link href="{{ ($settings && $settings->favicon) ? asset('storage/'.$settings->favicon) : asset('favicon.ico') }}" rel="icon" type="image/x-icon" />
<!-- <link rel="icon" sizes="192x192" href="404.html"> -->

<meta name="keywords" content="{{ $settings->site_name ?? 'Trading Platform' }}" />
<meta property="og:image" content="temp/custom/images/icon/icon-310x310.png" />

<meta name="msapplication-square310x310logo" content="{{ ($settings && $settings->favicon) ? asset('storage/'.$settings->favicon) : asset('favicon.ico') }}">
<meta name="msapplication-square70x70logo" content="{{ ($settings && $settings->favicon) ? asset('storage/'.$settings->favicon) : asset('favicon.ico') }}">
<meta name="msapplication-square150x150logo" content="{{ ($settings && $settings->favicon) ? asset('storage/'.$settings->favicon) : asset('favicon.ico') }}">
<meta name="msapplication-wide310x150logo" content="{{ ($settings && $settings->favicon) ? asset('storage/'.$settings->favicon) : asset('favicon.ico') }}">

<link rel="apple-touch-icon-precomposed" href="{{ ($settings && $settings->favicon) ? asset('storage/'.$settings->favicon) : asset('favicon.ico') }}">
<!-- <link rel="apple-touch-icon-precomposed" sizes="57x57" href="404.html" /> -->
<!-- <link rel="apple-touch-icon-precomposed" sizes="72x72" href="404.html" /> -->
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ ($settings && $settings->favicon) ? asset('storage/'.$settings->favicon) : asset('favicon.ico') }}" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ ($settings && $settings->favicon) ? asset('storage/'.$settings->favicon) : asset('favicon.ico') }}" />

<meta property="og:site_name" content="{{ $settings->site_name ?? 'Trading Platform' }}">
<meta property="og:title" content="Trading With {{ $settings->site_name ?? 'Trading Platform' }}" />
<meta name="description" content="{{ $settings->site_name ?? 'Trading Platform' }} LIMITED???
INVEST IN A LEADING
TRADE AND INVESTMENT
COMPANY, OPERATING IN
THE UK.
SERVICES INCLUDE: FOREX TRADING
CRYPTOCURRENCIES, STOCKS & COMMODITIES INVESTMENTS. OIL & GAS, REAL ESTATE INVESTMENTS, MARKET
RESEARCH AND ANALYSIS:
ASSISTING BOTH INDIVIDUALS & COMPANIES INVEST IN THE
COMMERCIAL MARKET.TRAINING CLIENTS & INVESTORS TO BECOME
EXPERTISE.???">
<meta property="og:description" content="{{ $settings->site_name ?? 'Trading Platform' }} LIMITED???
INVEST IN A LEADING
TRADE AND INVESTMENT
COMPANY, OPERATING IN
THE UK.
SERVICES INCLUDE: FOREX TRADING
CRYPTOCURRENCIES, STOCKS & COMMODITIES INVESTMENTS. OIL & GAS, REAL ESTATE INVESTMENTS, MARKET
RESEARCH AND ANALYSIS:
ASSISTING BOTH INDIVIDUALS & COMPANIES INVEST IN THE
COMMERCIAL MARKET.TRAINING CLIENTS & INVESTORS TO BECOME
EXPERTISE.???">
<meta property="og:type" content="website" />

<!-- <link href="404" rel="stylesheet" /> -->

</head>

    <style>
        body {
            overflow-x: hidden;
        }

        .js-hidden {
            display: none !important;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        .trading-card {
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(75, 85, 99, 0.2);
            box-shadow:
                0 10px 25px -5px rgba(0, 0, 0, 0.3),
                0 20px 25px -5px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.05);
        }

        .light .trading-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(229, 231, 235, 0.3);
            box-shadow:
                0 10px 25px -5px rgba(0, 0, 0, 0.1),
                0 20px 25px -5px rgba(0, 0, 0, 0.04),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .step-indicator {
            position: relative;
            z-index: 1;
        }

        .step-indicator::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, rgba(79, 70, 229, 0.3) 50%, transparent 100%);
            transform: translateY(-50%);
            z-index: -1;
        }

        .skiptranslate {
            display: none !important;
        }

        body {
            top: 0 !important;
        }
    </style>
</head>

<body class="h-full bg-gray-300 font-sans antialiased transition-colors duration-300 text-gray-900 dark js-hidden" id="main-body">

    <!-- Header Controls (Language + Theme Toggle) -->
    <div class="fixed top-4 right-4 z-50 flex items-center space-x-3">
        
        <!-- Language Switcher -->
        <div class="relative">
            <button onclick="toggleLanguageDropdown()"
                    class="group flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-white/80 dark:hover:bg-gray-800/80 rounded-xl transition-all duration-200 backdrop-blur-sm">
                <x-heroicon name="language" class="w-4 h-4 group-hover:scale-110 transition-transform duration-200" />
                <span class="hidden sm:block">
                    @if(session('locale') === 'ru')
                        {{ __('navigation.language_russian') }}
                    @else
                        {{ __('navigation.language_turkish') }}
                    @endif
                </span>
                <x-heroicon name="chevron-down" class="w-3 h-3 group-hover:rotate-180 transition-transform duration-200" />
            </button>

            <div id="languageDropdown" class="hidden absolute right-0 mt-2 w-48 max-w-[calc(100vw-2rem)] bg-white/95 dark:bg-gray-800/95 rounded-2xl shadow-2xl backdrop-blur-xl z-30 border border-gray-200/50 dark:border-gray-700/50">
                <div class="p-2">
                    <a href="{{ route('language.change', 'tr') }}"
                       class="group flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gradient-to-r hover:from-emerald-600/20 hover:to-teal-600/20 rounded-xl transition-all duration-200 {{ session('locale', 'tr') === 'tr' ? 'bg-emerald-600/10 text-emerald-600 dark:text-emerald-400' : '' }}">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-red-500/20 to-red-600/20 flex items-center justify-center mr-3 group-hover:from-red-500/30 group-hover:to-red-600/30 transition-all duration-200">
                            <span class="text-xs font-bold">🇹🇷</span>
                        </div>
                        <div>
                            <div class="font-medium">{{ __('navigation.language_turkish') }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Türkçe</div>
                        </div>
                        @if(session('locale', 'tr') === 'tr')
                            <x-heroicon name="check" class="w-4 h-4 text-emerald-600 dark:text-emerald-400 ml-auto" />
                        @endif
                    </a>
                    <a href="{{ route('language.change', 'ru') }}"
                       class="group flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gradient-to-r hover:from-blue-600/20 hover:to-indigo-600/20 rounded-xl transition-all duration-200 {{ session('locale') === 'ru' ? 'bg-blue-600/10 text-blue-600 dark:text-blue-400' : '' }}">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-600/20 flex items-center justify-center mr-3 group-hover:from-blue-500/30 group-hover:to-blue-600/30 transition-all duration-200">
                            <span class="text-xs font-bold">🇷🇺</span>
                        </div>
                        <div>
                            <div class="font-medium">{{ __('navigation.language_russian') }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Русский</div>
                        </div>
                        @if(session('locale') === 'ru')
                            <x-heroicon name="check" class="w-4 h-4 text-blue-600 dark:text-blue-400 ml-auto" />
                        @endif
                    </a>
                </div>
            </div>
        </div>

        <!-- Theme Toggle -->
        <button id="theme-toggle"
            class="relative inline-flex items-center justify-center w-10 h-10 text-gray-600 dark:text-gray-300 hover:bg-white/80 dark:hover:bg-gray-800/80 rounded-lg transition-colors duration-150 backdrop-blur-sm">
            <svg id="sun-icon" class="w-5 h-5 js-hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 12.728l-.707-.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <svg id="moon-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
            <span class="absolute inset-0 rounded-lg ring-2 ring-inset ring-transparent transition-colors duration-150 hover:ring-blue-400/20"></span>
        </button>
    </div>

    <!-- Main Content Wrapper -->
    <div class="relative min-h-screen overflow-hidden">
        <!-- Content -->
        <div class="relative z-10">
            @yield('content')
        </div>
    </div>

    <!-- Professional Trading Ticker -->
    <div class="fixed bottom-0 left-0 right-0 bg-white/80 dark:bg-gray-900/90 backdrop-blur-md border-t border-gray-200/50 dark:border-gray-700/50 z-40">
        <div class="tradingview-widget-container">
            <div class="tradingview-widget-container__widget"></div>
            <!--<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>-->
            <!--{-->
            <!--    "symbols": [-->
            <!--        {"proName": "BINANCE:BTCUSDT", "title": "BTC/USDT"},-->
            <!--        {"proName": "BINANCE:ETHUSDT", "title": "ETH/USDT"},-->
            <!--        {"proName": "FX:EURUSD", "title": "EUR/USD"},-->
            <!--        {"proName": "FX:GBPUSD", "title": "GBP/USD"},-->
            <!--        {"proName": "FX:USDJPY", "title": "USD/JPY"},-->
            <!--        {"proName": "NASDAQ:AAPL", "title": "APPLE"},-->
            <!--        {"proName": "TVC:GOLD", "title": "GOLD"}-->
            <!--    ],-->
            <!--    "showSymbolLogo": true,-->
            <!--    "colorTheme": "dark",-->
            <!--    "isTransparent": true,-->
            <!--    "displayMode": "adaptive",-->
            <!--    "locale": "en"-->
            <!--}-->
            <!--</script>-->
        </div>
    </div>

    <!-- Initialize Scripts -->
    <script>
        // Theme Management - Vanilla JavaScript
        let isDarkMode = localStorage.getItem('theme') === 'dark' || !localStorage.getItem('theme');
        
        // Set dark mode as default if no preference is stored
        if (!localStorage.getItem('theme')) {
            localStorage.setItem('theme', 'dark');
            isDarkMode = true;
        }

        function updateTheme() {
            const html = document.documentElement;
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');
            
            if (isDarkMode) {
                html.classList.add('dark');
                html.setAttribute('data-theme', 'dark');
                if (sunIcon) sunIcon.classList.add('js-hidden');
                if (moonIcon) moonIcon.classList.remove('js-hidden');
            } else {
                html.classList.remove('dark');
                html.setAttribute('data-theme', 'light');
                if (sunIcon) sunIcon.classList.remove('js-hidden');
                if (moonIcon) moonIcon.classList.add('js-hidden');
            }
            localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
        }

        function toggleTheme() {
            isDarkMode = !isDarkMode;
            updateTheme();
        }

        // Initialize theme on page load
        document.addEventListener('DOMContentLoaded', () => {
            // Show body content
            const body = document.getElementById('main-body');
            if (body) {
                body.classList.remove('js-hidden');
            }
            
            // Initialize theme
            updateTheme();
            
            // Theme toggle button
            const themeToggle = document.getElementById('theme-toggle');
            if (themeToggle) {
                themeToggle.addEventListener('click', toggleTheme);
            }

            // Icons initialized via unified Icon Service
        });

        // Language Dropdown Function
        window.toggleLanguageDropdown = function() {
            const dropdown = document.getElementById('languageDropdown');
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        };

        // Click away listener for language dropdown
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('languageDropdown');
            const button = document.querySelector('button[onclick="toggleLanguageDropdown()"]');
            
            if (dropdown && !dropdown.contains(e.target) &&
                (!button || !button.contains(e.target))) {
                dropdown.classList.add('hidden');
            }
        });

        // ESC key to close dropdown
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const dropdown = document.getElementById('languageDropdown');
                if (dropdown) {
                    dropdown.classList.add('hidden');
                }
            }
        });
    </script>
 <!-- Modern Language Selector already integrated above in header -->
</body>
</html>
