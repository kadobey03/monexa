<!DOCTYPE html>
<html lang="en" class="dark bg-gray-300 h-full" data-theme="">
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

    <!-- Lucide Icons - Local -->
    <script src="{{ asset('vendor/lucide/lucide.js') }}"></script>

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
    
    
    <!-- Theme Toggle (Hidden but accessible) -->
    <div class="fixed top-4 right-4 z-50">
        
        
        <button id="theme-toggle"
            class="relative inline-flex items-center justify-center w-10 h-10 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors duration-150 backdrop-blur-sm">
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
            @include('layouts.lang')
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
            
            // Initialize Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
 <!-- Language Selector -->
    @include('layouts.lang')
    <!-- Language Selector -->
    <!--@include('layouts.lang')-->
</body>
</html>
