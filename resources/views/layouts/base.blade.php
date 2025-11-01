
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="dark">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <!-- Tailwind CSS configurations are now handled by Vite build -->

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FontAwesome REMOVED - Using unified Lucide icons instead -->
    <!-- Unified Icon Service loaded via Vite assets -->

    <!-- jQuery - Local -->
    <script src="{{ asset('vendor/jquery/jquery-3.7.0.min.js') }}"></script>

    <!-- DataTables JS - Local -->
    <script type="text/javascript" src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>

    <!-- AOS JS - Local -->
    <script src="{{ asset('vendor/aos/aos.js') }}"></script>

    <!-- Custom Styles -->
    <style>

        /* Custom scrollbar for dark mode */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1F2937;
        }
        ::-webkit-scrollbar-thumb {
            background: #4B5563;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #6B7280;
        }

        /* Form elements styling */
        .form-input {
            @apply bg-dark-100 border-0 rounded-lg px-4 py-3 text-gray-100 font-medium focus:ring-2 focus:ring-primary focus:outline-none transition-all duration-200;
        }

        .form-select {
            @apply bg-dark-100 border-0 rounded-lg px-4 py-3 text-gray-100 font-medium focus:ring-2 focus:ring-primary focus:outline-none transition-all duration-200;
        }

        .btn-primary {
            @apply bg-primary hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-200;
        }

        .btn-secondary {
            @apply bg-dark-100 hover:bg-dark-200 text-white font-bold py-3 px-6 rounded-lg transition-all duration-200;
        }

        /* Navbar and mobile menu animations */
        .navbar-dropdown {
            @apply transition-all duration-300 ease-in-out transform origin-top;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* Light mode overrides */
        html:not(.dark) {
            @apply bg-gray-100 text-gray-900;
        }

        html:not(.dark) body {
            @apply bg-gray-100 text-gray-900;
        }

        html:not(.dark) .bg-dark-400 {
            @apply bg-white;
        }

        html:not(.dark) .bg-dark-300 {
            @apply bg-gray-50;
        }

        html:not(.dark) .border-gray-800 {
            @apply border-gray-200;
        }

        html:not(.dark) .text-gray-200,
        html:not(.dark) .text-gray-300,
        html:not(.dark) .text-gray-400 {
            @apply text-gray-700;
        }

        html:not(.dark) .hover\:bg-dark-200:hover,
        html:not(.dark) .hover\:bg-gray-700:hover {
            @apply hover:bg-gray-200;
        }

        html:not(.dark) .bg-dark-500 {
            @apply bg-gray-100;
        }
    </style>

    <title>{{$settings->site_name}} | CFD Ticareti — Hisse Senetleri, Altın, Petrol, Endeksler</title>
    <meta name="theme-color" content="#111827">    <meta property="x-session-id" content="ghJjEOrjZ3KUPun1UQksVUbvK88y21dgIhKtb8GT">
    <meta property="og:site_name" content="{{$settings->site_name}}">
    <meta property="og:description" content="{{$settings->site_name}} ile CFD Ticareti. Ultra hızlı execution ve 0.0 pipten başlayan spreadlerle Hisse Senetleri, Altın, Petrol, Endeksler'de işlem yapın. Tecrübeli ve yeni başlayan traderlar için haberler, makaleler ve eğitim materyalleri.">
    <meta name="description" content="{{$settings->site_name}} ile CFD Ticareti. Ultra hızlı execution ve 0.0 pipten başlayan spreadlerle Hisse Senetleri, Altın, Petrol, Endeksler'de işlem yapın. Tecrübeli ve yeni başlayan traderlar için haberler, makaleler ve eğitim materyalleri.">
    <meta name="keywords" content="döviz, CFDler, CFD, Bitcoin ticareti, kripto ticareti, online işlem yaparak, Döviz ticareti, Petrol ticareti, Altın ticareti, endeks ticareti, hisse ticareti, emtia ticareti, işlem yaparak platformu, Kripto paralar günlük ticareti">
    <meta property="og:type" content="website">
    <meta property="og:title" content="CFD Ticareti — Hisse Senetleri, Altın, Petrol, Endeksler | {{$settings->site_name}}">
    <meta property="og:image" content="img/share.jpg">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ $settings->favicon ? asset('storage/'.$settings->favicon) : asset('favicon.ico') }}" type="image/x-icon">

    <!-- Inter Font - Local -->
    <link href="{{ asset('vendor/fonts/inter.css') }}" rel="stylesheet">

    <!-- DataTables CSS - Local -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/datatables.min.css') }}"/>

    <!-- AOS CSS - Local -->
    <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet">

    <!-- JavaScript utilities -->
    <script>
        // Initialize theme from local storage
        document.addEventListener('DOMContentLoaded', () => {
            const theme = localStorage.getItem('darkMode');
            if (theme === 'light') {
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('bg-gray-900');
                document.body.classList.add('bg-gray-100');
            }
        });

        // Theme toggle function
        function toggleDarkMode() {
            const isDark = document.documentElement.classList.contains('dark');
            if (isDark) {
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('bg-gray-900');
                document.body.classList.add('bg-gray-100');
                localStorage.setItem('darkMode', 'light');
            } else {
                document.documentElement.classList.add('dark');
                document.body.classList.add('bg-gray-900');
                document.body.classList.remove('bg-gray-100');
                localStorage.setItem('darkMode', 'dark');
            }
        }

        // Dropdown states
        let tradeMenuOpen = false;
        let companyMenuOpen = false;
        let mobileMenuOpen = false;
        let mobileTradeOpen = false;
        let mobileCompanyOpen = false;

        // Navigation toggle functions
        function toggleTradeMenu() {
            tradeMenuOpen = !tradeMenuOpen;
            const menu = document.getElementById('trade-menu');
            menu.style.display = tradeMenuOpen ? 'block' : 'none';
            if (tradeMenuOpen && companyMenuOpen) {
                toggleCompanyMenu();
            }
        }

        function toggleCompanyMenu() {
            companyMenuOpen = !companyMenuOpen;
            const menu = document.getElementById('company-menu');
            menu.style.display = companyMenuOpen ? 'block' : 'none';
            if (companyMenuOpen && tradeMenuOpen) {
                toggleTradeMenu();
            }
        }

        function toggleMobileMenu() {
            mobileMenuOpen = !mobileMenuOpen;
            const menu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('mobile-menu-icon');
            const closeIcon = document.getElementById('mobile-close-icon');
            
            if (mobileMenuOpen) {
                menu.style.display = 'block';
                menuIcon.style.display = 'none';
                closeIcon.style.display = 'block';
            } else {
                menu.style.display = 'none';
                menuIcon.style.display = 'block';
                closeIcon.style.display = 'none';
            }
        }

        function toggleMobileTrade() {
            mobileTradeOpen = !mobileTradeOpen;
            const menu = document.getElementById('mobile-trade-menu');
            const chevron = document.getElementById('mobile-trade-chevron');
            
            menu.style.display = mobileTradeOpen ? 'block' : 'none';
            chevron.classList.toggle('rotate-180', mobileTradeOpen);
        }

        function toggleMobileCompany() {
            mobileCompanyOpen = !mobileCompanyOpen;
            const menu = document.getElementById('mobile-company-menu');
            const chevron = document.getElementById('mobile-company-chevron');
            
            menu.style.display = mobileCompanyOpen ? 'block' : 'none';
            chevron.classList.toggle('rotate-180', mobileCompanyOpen);
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const tradeMenu = document.getElementById('trade-menu');
            const companyMenu = document.getElementById('company-menu');
            
            if (tradeMenuOpen && !event.target.closest('[onclick="toggleTradeMenu()"]') && !tradeMenu.contains(event.target)) {
                toggleTradeMenu();
            }
            
            if (companyMenuOpen && !event.target.closest('[onclick="toggleCompanyMenu()"]') && !companyMenu.contains(event.target)) {
                toggleCompanyMenu();
            }
        });
    </script>
</head>

<body class="antialiased text-gray-200 bg-gray-900 font-sans min-h-screen flex flex-col">
    <!-- Accessibility Skip Link -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:bg-blue-700 focus:text-white focus:fixed focus:px-4 focus:py-2 focus:top-2 focus:left-2 focus:z-50">
        İçeriği Atla
    </a>




















    <!-- Header -->
<header class="bg-gray-900 border-b border-gray-800 relative z-50">
    <!-- Top Navigation Bar -->
    <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8" id="navbar-container">
        <div class="relative">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center">
                        <img class="h-8 w-auto" src="{{ asset('storage/'.$settings->logo)}}" alt="{{$settings->site_name}}">
                    </a>
                </div>

                <!-- Main Navigation - Desktop -->
                <nav class="hidden md:flex space-x-8">
                    <div class="relative">
                        <button onclick="toggleTradeMenu()" class="group inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-200 hover:text-white focus:outline-none">
                            <span>Ticaret</span>
                            <svg class="ml-2 h-4 w-4 text-gray-400 group-hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="trade-menu" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-dark-300 ring-1 ring-black ring-opacity-5 z-50" style="display: none;">
                            <a href="cryptocurrencies" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Kripto Para</a>
                            <a href="forex" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Döviz</a>
                            <a href="shares" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Hisseler</a>
                            <a href="indices" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Endeksler</a>
                            <a href="etfs" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">ETF'ler</a>
                        </div>
                    </div>


                    <div class="relative">
                        <button onclick="toggleCompanyMenu()" class="group inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-200 hover:text-white focus:outline-none">
                            <span>Şirket</span>
                            <svg class="ml-2 h-4 w-4 text-gray-400 group-hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="company-menu" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-dark-300 ring-1 ring-black ring-opacity-5 z-50" style="display: none;">
                            <a href="about" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Hakkımızda</a>
                            <a href="why-us" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Neden Biz</a>
                            <a href="faq" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">SSS</a>
                            <a href="regulation" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Yasal ve Düzenlemeler</a>
                        </div>
                    </div>

                    <a href="for-traders" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-200 hover:text-white">Eğitim</a>
                    <a href="contacts" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-200 hover:text-white">İletişim</a>
                </nav>

                <!-- Right Navigation -->
                <div class="hidden md:flex items-center">
                    <div class="flex space-x-1 mr-4">
                        <a href="#" class="text-gray-400 hover:text-gray-200 p-1" aria-label="Desktop Version">
                            <i data-lucide="monitor" class="w-4 h-4"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-200 p-1" aria-label="Windows App">
                            <i data-lucide="smartphone" class="w-4 h-4"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-200 p-1" aria-label="Android App">
                            <i data-lucide="smartphone" class="w-4 h-4"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-200 p-1" aria-label="iOS App">
                            <i data-lucide="smartphone" class="w-4 h-4"></i>
                        </a>
                    </div>


                    <!-- Dark/Light Mode Toggle -->
                    <!--<button-->
                    <!--    x-data-->
                    <!--    @click="$store.darkMode.toggle()"-->
                    <!--    class="p-2 text-gray-400 hover:text-gray-200 mr-4 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-600"-->
                    <!--    aria-label="Toggle dark/light mode"-->
                    <!-->-->
                    <!--    <i x-show="$store.darkMode.on" class="fas fa-sun"></i>-->
                    <!--    <i x-show="!$store.darkMode.on" class="fas fa-moon"></i>-->
                    <!--</button>-->

                    <div class="flex items-center space-x-4">
                        <a href="login" class="text-gray-200 hover:text-white flex items-center">
                            <i class="fas fa-lock mr-1"></i>
                            <span>Giriş Yap</span>
                        </a>
                        <a href="register" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            Kayıt Ol
                        </a>
                    </div>
                </div>

                <!-- Mobile menu button and theme toggle -->
                <div class="flex md:hidden items-center space-x-2">
                    <!-- Mobile Theme Toggle -->
                    <!--<button-->
                    <!--    x-data-->
                    <!--    @click="$store.darkMode.toggle()"-->
                    <!--    class="p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"-->
                    <!--    aria-label="Toggle dark/light mode"-->
                    <!-->-->
                    <!--    <i x-show="$store.darkMode.on" class="fas fa-sun text-lg"></i>-->
                    <!--    <i x-show="!$store.darkMode.on" class="fas fa-moon text-lg"></i>-->
                    <!--</button>-->

                    <!-- Mobile Menu Toggle -->
                    <button onclick="toggleMobileMenu()" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Menüyü Aç</span>
                        <svg id="mobile-menu-icon" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg id="mobile-close-icon" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="md:hidden" style="display: none;">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <!-- Mobile Navigation -->
                <div class="py-1">
                    <button onclick="toggleMobileTrade()" class="w-full flex justify-between items-center px-4 py-2 text-sm text-gray-200 hover:bg-gray-700">
                        <span>Ticaret</span>
                        <svg id="mobile-trade-chevron" class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div id="mobile-trade-menu" class="pl-4" style="display: none;">
                        <a href="cryptocurrencies" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Kripto Para</a>
                        <a href="forex" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Döviz</a>
                        <a href="shares" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Hisseler</a>
                        <a href="indices" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Endeksler</a>
                        <a href="etfs" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">ETF'ler</a>
                    </div>
                </div>

                <div class="py-1">
                    <button onclick="toggleMobileCompany()" class="w-full flex justify-between items-center px-4 py-2 text-sm text-gray-200 hover:bg-gray-700">
                        <span>Şirket</span>
                        <svg id="mobile-company-chevron" class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div id="mobile-company-menu" class="pl-4" style="display: none;">
                        <a href="about" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Hakkımızda</a>
                        <a href="why-us" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Neden Biz</a>
                        <a href="faq" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">SSS</a>
                        <a href="regulation" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Yasal ve Düzenlemeler</a>
                    </div>
                </div>

                <a href="for-traders" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Eğitim</a>
                <a href="contacts" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">İletişim</a>


                <div class="pt-4 pb-3 border-t border-gray-700">
                    <div class="flex items-center justify-between px-4">
                        <div class="flex items-center space-x-3">
                            <a href="login" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                <i data-lucide="lock" class="w-4 h-4 mr-1"></i> Giriş Yap
                            </a>
                            <a href="register" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Kayıt Ol
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>



    <!--  sub menu -->

<!-- Market Ticker Widget -->
<div class="bg-dark-300 border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-1">
            <div class="crypto-ticker-wrapper">
                <iframe src="https://widget.coinlib.io/widget?type=horizontal_v2&theme=dark&pref_coin_id=1505&invert_hover=no"
                        width="100%"
                        height="36px"
                        scrolling="auto"
                        marginwidth="0"
                        marginheight="0"
                        frameborder="0"
                        border="0"
                        class="w-full">
                </iframe>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Area -->
<main id="main-content" class="flex-grow">
    @yield('content')
</main>







<!-- Footer -->
<footer class="bg-dark-400 text-gray-300">
    <!-- Upper Footer -->
    <div class="border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-12">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Company Info -->
                    <div>
                        <div class="flex items-center mb-6">
                            <a href="/" class="flex items-center">
                                <img class="h-8 w-auto" src="{{ asset('storage/'.$settings->logo)}}" alt="{{$settings->site_name}}">
                            </a>
                        </div>
                        <p class="text-sm text-gray-400 mb-6">
                            {{$settings->site_name}} offers CFD işlem yaparak on stocks, forex, indices, commodities, and cryptocurrencies with competitive spreads and advanced işlem yaparak tools.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white">
                                <span class="sr-only">Twitter</span>
                                <i data-lucide="twitter" class="w-5 h-5"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <span class="sr-only">LinkedIn</span>
                                <i data-lucide="linkedin" class="w-5 h-5"></i>
                            </a>
                            <a href="mailto:{{$settings->contact_email}}" class="text-gray-400 hover:text-white">
                                <span class="sr-only">Email</span>
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Hızlı Bağlantılar -->
                    <div>
                        <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Hızlı Bağlantılar</h3>
                        <ul class="space-y-3">
                            <li><a href="about" class="text-sm text-gray-400 hover:text-white transition">Hakkımızda</a></li>
                            <li><a href="why-us" class="text-sm text-gray-400 hover:text-white transition">Neden Bizi Seçmelisiniz</a></li>
                            <li><a href="for-traders" class="text-sm text-gray-400 hover:text-white transition">Eğitim</a></li>
                            <li><a href="contacts" class="text-sm text-gray-400 hover:text-white transition">İletişim</a></li>
                        </ul>
                    </div>

                    <!-- Trading -->
                    <div>
                        <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Ticaret</h3>
                        <ul class="space-y-3">
                            <li><a href="cryptocurrencies" class="text-sm text-gray-400 hover:text-white transition">Kripto Paralar</a></li>
                            <li><a href="forex" class="text-sm text-gray-400 hover:text-white transition">Döviz</a></li>
                            <li><a href="shares" class="text-sm text-gray-400 hover:text-white transition">Hisseler</a></li>
                            <li><a href="indices" class="text-sm text-gray-400 hover:text-white transition">Endeksler</a></li>
                        </ul>
                    </div>

                    <!-- Account -->
                    <div>
                        <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Hesabınız</h3>
                        <ul class="space-y-3">
                            <li><a href="login" class="text-sm text-gray-400 hover:text-white transition">Giriş Yap</a></li>
                            <li><a href="register" class="text-sm text-gray-400 hover:text-white transition">Hesap Oluştur</a></li>
                            <li><a href="login" class="text-sm text-gray-400 hover:text-white transition">Demo Hesap</a></li>
                            <li><a href="contact" class="text-sm text-gray-400 hover:text-white transition">Yardım Merkezi</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Platform Availability -->
    <div class="border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-4 md:mb-0">
                        <h4 class="text-sm font-semibold text-white">Uygun Platformlar</h4>
                    </div>
                    <div class="flex items-center space-x-6">
                        <a href="#" class="flex items-center text-gray-400 hover:text-white" aria-label="Web Platform">
                            <i data-lucide="monitor" class="w-4 h-4 mr-2"></i>
                            <span class="text-sm">Web</span>
                        </a>
                        <a href="#" class="flex items-center text-gray-400 hover:text-white" aria-label="Windows App">
                            <i data-lucide="smartphone" class="w-4 h-4 mr-2"></i>
                            <span class="text-sm">Windows</span>
                        </a>
                        <a href="#" class="flex items-center text-gray-400 hover:text-white" aria-label="Android App">
                            <i data-lucide="smartphone" class="w-4 h-4 mr-2"></i>
                            <span class="text-sm">Android</span>
                        </a>
                        <a href="#" class="flex items-center text-gray-400 hover:text-white" aria-label="iOS App">
                            <i data-lucide="smartphone" class="w-4 h-4 mr-2"></i>
                            <span class="text-sm">iOS</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Disclaimer & Legal -->
    <div class="bg-dark-500 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="text-xs text-gray-400">
                    <p class="mb-4 leading-relaxed">
                        <span class="font-semibold text-gray-300">RİSK UYARISI:</span> Şirket tarafından sunulan finansal ürünler Fark Sözleşmeleri ('CFD'ler') ve diğer karmaşık finansal ürünleri içerir. CFD işlemi yapmak yüksek seviyede risk taşır çünkü kaldıraç hem avantajınıza hem de dezavantajınıza çalışabilir. Sonuç olarak, CFD'ler tüm yatırımcılar için uygun olmayabilir çünkü yatırılan sermayenin tamamını kaybetmek mümkündür. Kaybetmeyi göze alamayacağınız parayı hiçbir zaman yatırmamalısınız. Sunulan karmaşık finansal ürünlerde işlem yapmadan önce, lütfen riskleri anladığınızdan emin olun.
                    </p>
                    <div class="flex flex-wrap gap-4 mb-4">
                        <a href="terms" class="text-blue-400 hover:text-blue-300 transition">Şartlar ve Koşullar</a>
                        <a href="privacy" class="text-blue-400 hover:text-blue-300 transition">Gizlilik Politikası</a>
                        <a href="regulation" class="text-blue-400 hover:text-blue-300 transition">Yasal Belgeler</a>
                    </div>
                    <p>© <script>document.write(new Date().getFullYear())</script> {{$settings->site_name}}. Tüm Hakları Saklıdır.</p>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.lang')
</footer>


<!-- Live Chat Button -->

<!-- Live Chat Button -->
{{-- <div class="fixed bottom-20 right-6 z-40">
    <button onclick="openLiveChat(event)" class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg flex items-center justify-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
        <i data-lucide="message-circle" class="w-5 h-5"></i>
    </button>
</div> --}}












        <!-- GetButton.io widget -->
<!--<script type="text/javascript">-->
<!--    (function () {-->
<!--        var options = {-->
            <!--whatsapp: "{{$settings->whatsapp}}", // WhatsApp number-->
            <!--call_to_action: "Message us", // Call to action-->
            <!--button_color: "#FF6550", // Color of button-->
            <!--position: "right", // Position may be 'right' or 'left'-->
<!--        };-->
<!--        var proto = 'https:', host = "getbutton.io", url = proto + '//static.' + host;-->
<!--        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';-->
<!--        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };-->
<!--        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);-->
<!--    })();-->
<!--</script>-->
<!-- Additional Scripts -->
<script>
    // Live Chat Function
    function openLiveChat(e) {
        e.preventDefault();
        console.log('Opening live chat...');
        // Implement your live chat functionality here
    }

    // Theme toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize any custom components
        console.log('DOM loaded, initializing components...');

        // Initialize AOS
        if (typeof AOS !== 'undefined') {
            AOS.init();
        }
    });

    // Analytics (preserved from original)
    function bindGAEvents(eventCategory, callback, iter) {
        if (typeof iter === "undefined") { iter = 1; }
        if(window.dataLayer) {
            if (typeof callback === "function") {
                callback();
            }
        } else if(iter > 2 && typeof callback === "function") {
            callback();
        } else {
            setTimeout(function(){
                bindGAEvents(eventCategory, callback, iter + 1);
            }, 500);
        }
    }

    $(document).ready(function() {
        if('' == '1') {
            bindGAEvents('ex_new_user');
        }

        $(document).on('click', '.start-işlem yaparak, .open-live-account, .open-demo-account', function (event) {
            var redirectLink = $(this).attr('href');
            bindGAEvents('ex_button', function(){
                window.location.href = redirectLink;
            });
            event.preventDefault();
        });
    });
</script>

@include('layouts.livechat')
</body>
</html>
