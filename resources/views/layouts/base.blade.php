
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="dark">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#10B981',
                        accent: '#6366F1',
                        warning: '#F59E0B',
                        danger: '#EF4444',
                        dark: {
                            100: '#374151',
                            200: '#1F2937',
                            300: '#111827',
                            400: '#0F172A',
                            500: '#0B1120',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Custom Styles -->
    <style>
        /* Alpine.js x-cloak directive */
        [x-cloak] {
            display: none !important;
        }

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
    <link rel="shortcut icon" href="{{ asset('storage/app/public/'.$settings->favicon)}}" type="image/x-icon">

    <!-- Preload key assets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- jQuery (required for some components) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css"/>

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- JavaScript utilities -->
    <script>
        // Utility function for mobile menu
        document.addEventListener('alpine:init', () => {
            Alpine.store('navigation', {
                open: false,
                toggle() {
                    this.open = !this.open;
                },
                close() {
                    this.open = false;
                }
            });

            // Theme toggler
            Alpine.store('darkMode', {
                on: true,
                toggle() {
                    this.on = !this.on;
                    if (this.on) {
                        document.documentElement.classList.add('dark');
                        document.body.classList.add('bg-gray-900');
                        document.body.classList.remove('bg-gray-100');
                    } else {
                        document.documentElement.classList.remove('dark');
                        document.body.classList.remove('bg-gray-900');
                        document.body.classList.add('bg-gray-100');
                    }
                    localStorage.setItem('darkMode', this.on ? 'dark' : 'light');
                }
            });
        });

        // Initialize theme from local storage
        document.addEventListener('DOMContentLoaded', () => {
            const theme = localStorage.getItem('darkMode');
            if (theme === 'light') {
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('bg-gray-900');
                document.body.classList.add('bg-gray-100');
                if (window.Alpine) {
                    Alpine.store('darkMode').on = false;
                }
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
    <div x-data="{ mobileMenuOpen: false }" class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center">
                        <img class="h-8 w-auto" src="{{ asset('storage/app/public/'.$settings->logo)}}" alt="{{$settings->site_name}}">
                    </a>
                </div>

                <!-- Main Navigation - Desktop -->
                <nav class="hidden md:flex space-x-8">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="group inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-200 hover:text-white focus:outline-none">
                            <span>Ticaret</span>
                            <svg class="ml-2 h-4 w-4 text-gray-400 group-hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-dark-300 ring-1 ring-black ring-opacity-5 z-50" style="display: none;">
                            <a href="cryptocurrencies" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Kripto Para</a>
                            <a href="forex" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Döviz</a>
                            <a href="shares" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Hisseler</a>
                            <a href="indices" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Endeksler</a>
                            <a href="etfs" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">ETF'ler</a>
                        </div>
                    </div>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="group inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-200 hover:text-white focus:outline-none">
                            <span>Sistem</span>
                            <svg class="ml-2 h-4 w-4 text-gray-400 group-hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-dark-300 ring-1 ring-black ring-opacity-5 z-50" style="display: none;">
                            <a href="trade" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Ticaret</a>
                            <a href="copy" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Kopya Ticaret</a>
                            <a href="automate" class="block px-4 py-2 text-sm text-gray-200 hover:bg-dark-200">Otomatik Ticaret</a>
                        </div>
                    </div>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="group inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-200 hover:text-white focus:outline-none">
                            <span>Şirket</span>
                            <svg class="ml-2 h-4 w-4 text-gray-400 group-hover:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-dark-300 ring-1 ring-black ring-opacity-5 z-50" style="display: none;">
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
                            <i class="fas fa-desktop"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-200 p-1" aria-label="Windows App">
                            <i class="fab fa-windows"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-200 p-1" aria-label="Android App">
                            <i class="fab fa-android"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-200 p-1" aria-label="iOS App">
                            <i class="fab fa-apple"></i>
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
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Menüyü Aç</span>
                        <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" class="md:hidden" id="mobile-menu" style="display: none;">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <!-- Mobile Navigation -->
                <div x-data="{ open: false }" class="py-1">
                    <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2 text-sm text-gray-200 hover:bg-gray-700">
                        <span>Ticaret</span>
                        <svg class="h-4 w-4 text-gray-400" :class="{'transform rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4">
                        <a href="cryptocurrencies" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Kripto Para</a>
                        <a href="forex" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Döviz</a>
                        <a href="shares" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Hisseler</a>
                        <a href="indices" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Endeksler</a>
                        <a href="etfs" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">ETF'ler</a>
                    </div>
                </div>

                <div x-data="{ open: false }" class="py-1">
                    <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2 text-sm text-gray-200 hover:bg-gray-700">
                        <span>Sistem</span>
                        <svg class="h-4 w-4 text-gray-400" :class="{'transform rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4">
                        <a href="trade" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Ticaret</a>
                        <a href="copy" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Kopya Ticaret</a>
                        <a href="automate" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Otomatik Ticaret</a>
                    </div>
                </div>

                <div x-data="{ open: false }" class="py-1">
                    <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2 text-sm text-gray-200 hover:bg-gray-700">
                        <span>Şirket</span>
                        <svg class="h-4 w-4 text-gray-400" :class="{'transform rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4">
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
                                <i class="fas fa-lock mr-1"></i> Giriş Yap
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
                                <img class="h-8 w-auto" src="{{ asset('storage/app/public/'.$settings->logo)}}" alt="{{$settings->site_name}}">
                            </a>
                        </div>
                        <p class="text-sm text-gray-400 mb-6">
                            {{$settings->site_name}} offers CFD işlem yaparak on stocks, forex, indices, commodities, and cryptocurrencies with competitive spreads and advanced işlem yaparak tools.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white">
                                <span class="sr-only">Twitter</span>
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <span class="sr-only">LinkedIn</span>
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <a href="mailto:{{$settings->contact_email}}" class="text-gray-400 hover:text-white">
                                <span class="sr-only">Email</span>
                                <i class="fas fa-envelope"></i>
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
                            <i class="fas fa-desktop mr-2"></i>
                            <span class="text-sm">Web</span>
                        </a>
                        <a href="#" class="flex items-center text-gray-400 hover:text-white" aria-label="Windows App">
                            <i class="fab fa-windows mr-2"></i>
                            <span class="text-sm">Windows</span>
                        </a>
                        <a href="#" class="flex items-center text-gray-400 hover:text-white" aria-label="Android App">
                            <i class="fab fa-android mr-2"></i>
                            <span class="text-sm">Android</span>
                        </a>
                        <a href="#" class="flex items-center text-gray-400 hover:text-white" aria-label="iOS App">
                            <i class="fab fa-apple mr-2"></i>
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


    <style>
        .notification-popup {
            position: fixed;
            z-index: 1000;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 16px 20px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            max-width: 350px;
            min-width: 280px;
            transform: translateX(400px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .notification-popup.show {
            transform: translateX(0);
            opacity: 1;
        }

        .notification-popup .notification-header {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .notification-popup .notification-icon {
            width: 24px;
            height: 24px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            font-size: 12px;
            color: #fff;
        }

        .notification-popup .notification-title {
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            opacity: 0.9;
        }

        .notification-popup .notification-content {
            color: #fff;
            font-size: 13px;
            line-height: 1.4;
            margin-bottom: 12px;
        }

        .notification-popup .notification-content b {
            font-weight: 700;
            color: #FFD700;
        }

        .notification-popup .notification-content a {
            color: #FFD700;
            text-decoration: none;
            font-weight: 600;
            border-bottom: 1px solid transparent;
            transition: border-color 0.2s ease;
        }

        .notification-popup .notification-content a:hover {
            border-bottom-color: #FFD700;
        }

        .notification-popup .notification-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            color: rgba(255, 255, 255, 0.7);
        }

        .notification-popup .notification-time {
            font-style: italic;
        }

        .notification-popup .notification-close {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            cursor: pointer;
            padding: 2px;
            border-radius: 3px;
            transition: color 0.2s ease;
        }

        .notification-popup .notification-close:hover {
            color: #fff;
        }

        .notification-popup .progress-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: rgba(255, 215, 0, 0.8);
            border-radius: 0 0 12px 12px;
            transition: width linear;
        }

        /* Dark mode adjustments */
        html.dark .notification-popup {
            background: linear-gradient(135deg, #1e3a8a 0%, #3730a3 100%);
            border-color: rgba(255, 255, 255, 0.1);
        }

        /* Mobile responsiveness */
        @media (max-width: 640px) {
            .notification-popup {
                right: 10px;
                bottom: 80px;
                max-width: calc(100vw - 20px);
                min-width: auto;
            }
        }

        /* Animation keyframes */
        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        .notification-popup.animate-in {
            animation: slideInRight 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .notification-popup.animate-out {
            animation: slideOutRight 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
    </style>

    <div class="notification-popup" id="işlem yaparakNotification" style="display: none;">
        <div class="notification-header">
            <div class="notification-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="notification-title">Canlı Ticaret Aktivitesi</div>
            <button class="notification-close ml-auto" onclick="closeNotification()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="notification-content" id="notificationText"></div>
        <div class="notification-footer">
            <span class="notification-time" id="notificationTime"></span>
            <span style="font-size: 10px;">🟢 Canlı</span>
        </div>
        <div class="progress-bar" id="progressBar"></div>
    </div>
    <script type="text/javascript">
        class TradingNotificationManager {
            constructor() {
                this.listCountries = [
                    'New York', 'London', 'Tokyo', 'Singapore', 'Frankfurt', 'Sydney', 'Dubai', 'Hong Kong',
                    'Toronto', 'Zurich', 'Paris', 'Amsterdam', 'Stockholm', 'Copenhagen', 'Milan', 'Madrid',
                    'Seoul', 'Mumbai', 'São Paulo', 'Mexico City', 'Buenos Aires', 'Cairo', 'Johannesburg',
                    'Moscow', 'Istanbul', 'Bangkok', 'Jakarta', 'Manila', 'Ho Chi Minh City', 'Kuala Lumpur',
                    'Tel Aviv', 'Warsaw', 'Prague', 'Budapest', 'Vienna', 'Brussels', 'Oslo', 'Helsinki',
                    'Dublin', 'Lisbon', 'Athens', 'Bucharest', 'Sofia', 'Zagreb', 'Sarajevo', 'Belgrade',
                    'Skopje', 'Podgorica', 'Tirana', 'Pristina'
                ];

                this.listAmounts = [
                    '$1,250', '$2,500', '$5,000', '$7,500', '$10,000', '$15,000', '$25,000', '$50,000',
                    '$75,000', '$100,000', '$150,000', '$200,000', '$3,450', '$8,900', '$12,340', '$18,750',
                    '$22,100', '$35,680', '$47,230', '$65,420', '$89,150', '$125,000', '$175,000', '$225,000'
                ];

                this.transactionTypes = [
                    { action: 'invested', icon: 'fa-chart-line', color: '#10B981' },
                    { action: 'withdrawn', icon: 'fa-money-bill-wave', color: '#3B82F6' },
                    { action: 'earned', icon: 'fa-trophy', color: '#F59E0B' }
                ];

                this.instruments = [
                    'Bitcoin', 'Ethereum', 'Apple Stock', 'Tesla Stock', 'Gold', 'Oil', 'EUR/USD', 'GBP/USD',
                    'USD/JPY', 'AUD/USD', 'Nvidia Stock', 'Microsoft Stock', 'Amazon Stock', 'Google Stock',
                    'S&P 500', 'NASDAQ 100', 'Dow Jones', 'Silver', 'Crude Oil', 'Natural Gas'
                ];

                this.currentNotification = null;
                this.interval = null;
                this.isActive = true;
                this.displayDuration = 45000; // 45 seconds - much longer than before
                this.intervalRange = { min: 8000, max: 20000 }; // 8-20 seconds between notifications

                this.init();
            }

            init() {
                this.scheduleNext();
            }

            getRandomElement(array) {
                return array[Math.floor(Math.random() * array.length)];
            }

            getRandomAmount() {
                return this.getRandomElement(this.listAmounts);
            }

            getRandomCountry() {
                return this.getRandomElement(this.listCountries);
            }

            getRandomTransaction() {
                return this.getRandomElement(this.transactionTypes);
            }

            getRandomInstrument() {
                return this.getRandomElement(this.instruments);
            }

            formatTime() {
                return new Date().toLocaleTimeString('en-US', {
                    hour12: false,
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            createNotificationMessage() {
                const country = this.getRandomCountry();
                const transaction = this.getRandomTransaction();
                const amount = this.getRandomAmount();
                const instrument = this.getRandomInstrument();

                let message = '';

                switch(transaction.action) {
                    case 'invested':
                        message = `<b>${country}</b>'dan bir ticaretçi <a href="javascript:void(0);" onclick="javascript:void(0);">${amount}</a> tutarında ${instrument}'a <b>yatırım yaptı</b>`;
                        break;
                    case 'withdrawn':
                        message = `<b>${country}</b>'dan bir ticaretçi başarıyla <a href="javascript:void(0);" onclick="javascript:void(0);">${amount}</a> tutarını <b>çekti</b>`;
                        break;
                    case 'earned':
                        message = `<b>${country}</b>'dan bir ticaretçi ${instrument} ile işlem yaparak <a href="javascript:void(0);" onclick="javascript:void(0);">${amount}</a> tutarında <b>kazandı</b>`;
                        break;
                }

                return { message, transaction };
            }

            showNotification() {
                if (!this.isActive) return;

                const notification = document.getElementById('işlem yaparakNotification');
                const textElement = document.getElementById('notificationText');
                const timeElement = document.getElementById('notificationTime');
                const progressBar = document.getElementById('progressBar');

                if (!notification || !textElement || !timeElement || !progressBar) return;

                const { message, transaction } = this.createNotificationMessage();

                // Update content
                textElement.innerHTML = message;
                timeElement.textContent = this.formatTime();

                // Update icon color based on transaction type
                const icon = notification.querySelector('.notification-icon');
                if (icon) {
                    icon.style.background = transaction.color + '40'; // 40 for opacity
                }

                // Show notification with animation
                notification.style.display = 'block';
                setTimeout(() => {
                    notification.classList.add('show', 'animate-in');
                }, 100);

                // Progress bar animation
                progressBar.style.width = '100%';
                progressBar.style.transition = `width ${this.displayDuration}ms linear`;

                setTimeout(() => {
                    progressBar.style.width = '0%';
                }, 200);

                // Auto hide after display duration
                this.currentNotification = setTimeout(() => {
                    this.hideNotification();
                }, this.displayDuration);
            }

            hideNotification() {
                const notification = document.getElementById('işlem yaparakNotification');
                const progressBar = document.getElementById('progressBar');

                if (!notification) return;

                // Clear any existing timeout
                if (this.currentNotification) {
                    clearTimeout(this.currentNotification);
                    this.currentNotification = null;
                }

                // Hide with animation
                notification.classList.remove('animate-in');
                notification.classList.add('animate-out');

                setTimeout(() => {
                    notification.classList.remove('show', 'animate-out');
                    notification.style.display = 'none';

                    // Reset progress bar
                    progressBar.style.width = '100%';
                    progressBar.style.transition = 'none';

                    // Schedule next notification
                    this.scheduleNext();
                }, 300);
            }

            scheduleNext() {
                if (!this.isActive) return;

                const delay = Math.floor(
                    Math.random() * (this.intervalRange.max - this.intervalRange.min + 1) +
                    this.intervalRange.min
                );

                if (this.interval) {
                    clearTimeout(this.interval);
                }

                this.interval = setTimeout(() => {
                    this.showNotification();
                }, delay);
            }

            pause() {
                this.isActive = false;
                if (this.interval) {
                    clearTimeout(this.interval);
                    this.interval = null;
                }
                if (this.currentNotification) {
                    clearTimeout(this.currentNotification);
                    this.currentNotification = null;
                }
                this.hideNotification();
            }

            resume() {
                this.isActive = true;
                this.scheduleNext();
            }

            destroy() {
                this.pause();
                const notification = document.getElementById('işlem yaparakNotification');
                if (notification) {
                    notification.style.display = 'none';
                }
            }
        }

        // Global functions for notification control
        function closeNotification() {
            if (window.tradingNotificationManager) {
                window.tradingNotificationManager.hideNotification();
            }
        }

        function pauseNotifications() {
            if (window.tradingNotificationManager) {
                window.tradingNotificationManager.pause();
            }
        }

        function resumeNotifications() {
            if (window.tradingNotificationManager) {
                window.tradingNotificationManager.resume();
            }
        }

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Small delay to ensure everything is loaded
            setTimeout(() => {
                window.tradingNotificationManager = new TradingNotificationManager();
            }, 500); // Reduced from 2000ms to 500ms
        });

        // Pause notifications when user is inactive
        let userActiveTimeout;
        function resetUserActiveTimer() {
            clearTimeout(userActiveTimeout);
            if (window.tradingNotificationManager && !window.tradingNotificationManager.isActive) {
                resumeNotifications();
            }

            userActiveTimeout = setTimeout(() => {
                pauseNotifications();
            }, 300000); // Pause after 5 minutes of inactivity
        }

        // Listen for user activity
        ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'].forEach(event => {
            document.addEventListener(event, resetUserActiveTimer, true);
        });

        // Initialize user activity timer
        resetUserActiveTimer();
    </script>

<!-- Live Chat Button -->
{{-- <div class="fixed bottom-20 right-6 z-40">
    <button onclick="openLiveChat(event)" class="bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg flex items-center justify-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
        <i class="fas fa-comments text-xl"></i>
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
