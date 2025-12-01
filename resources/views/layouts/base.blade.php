
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="dark scroll-smooth">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FontAwesome REMOVED - Using unified Heroicons instead -->

    <!-- jQuery - Local -->

    <!-- DataTables JS - Local -->

    <!-- AOS JS - Local -->

    <title>{{$settings->site_name}} | CFD Ticareti — Hisse Senetleri, Altın, Petrol, Endeksler</title>
    <meta name="theme-color" content="#111827">
    <meta property="x-session-id" content="ghJjEOrjZ3KUPun1UQksVUbvK88y21dgIhKtb8GT">
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

        // Navigation state management
        let activeDropdown = null;

        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            const isOpen = dropdown.classList.contains('opacity-100');
            
            // Close all dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('opacity-100', 'scale-100', 'visible');
                menu.classList.add('opacity-0', 'scale-95', 'invisible');
            });
            
            // Toggle current dropdown
            if (!isOpen) {
                dropdown.classList.remove('opacity-0', 'scale-95', 'invisible');
                dropdown.classList.add('opacity-100', 'scale-100', 'visible');
                activeDropdown = dropdownId;
            } else {
                activeDropdown = null;
            }
        }

        function closeDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            dropdown.classList.remove('opacity-100', 'scale-100', 'visible');
            dropdown.classList.add('opacity-0', 'scale-95', 'invisible');
            if (activeDropdown === dropdownId) {
                activeDropdown = null;
            }
        }

        // Mobile menu toggle
        let mobileMenuOpen = false;
        let mobileSubmenusOpen = {};

        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('mobile-menu-icon');
            const closeIcon = document.getElementById('mobile-close-icon');
            
            mobileMenuOpen = !mobileMenuOpen;
            
            if (mobileMenuOpen) {
                mobileMenu.classList.remove('hidden');
                menuIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            } else {
                mobileMenu.classList.add('hidden');
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                // Close all mobile submenus
                Object.keys(mobileSubmenusOpen).forEach(key => {
                    if (mobileSubmenusOpen[key]) {
                        toggleMobileSubmenu(key);
                    }
                });
            }
        }

        function toggleMobileSubmenu(submenuId) {
            const submenu = document.getElementById(`mobile-${submenuId}`);
            const chevron = document.getElementById(`mobile-${submenuId}-chevron`);
            
            mobileSubmenusOpen[submenuId] = !mobileSubmenusOpen[submenuId];
            
            if (mobileSubmenusOpen[submenuId]) {
                submenu.classList.remove('hidden');
                chevron.classList.add('rotate-180');
            } else {
                submenu.classList.add('hidden');
                chevron.classList.remove('rotate-180');
            }
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (activeDropdown && !event.target.closest('.dropdown-container')) {
                closeDropdown(activeDropdown);
            }
        });

        // Close dropdown when clicking inside dropdown links
        document.addEventListener('click', function(event) {
            if (event.target.closest('.dropdown-menu a')) {
                if (activeDropdown) {
                    closeDropdown(activeDropdown);
                }
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            
            if (mobileMenuOpen && !mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                toggleMobileMenu();
            }
        });

        // Language change function
        function changeLanguage(lang) {
            // Add language switching logic here
            if (lang === 'tr') {
                // Switch to Turkish
                console.log('Switching to Turkish');
                // You can add actual language switching logic here
            } else if (lang === 'ru') {
                // Switch to Russian
                console.log('Switching to Russian');
                // You can add actual language switching logic here
            }
            // Close dropdown after selection
            closeDropdown('language-dropdown');
        }
    </script>

    <!-- Flag Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons@6.6.6/css/flag-icons.min.css">

</head>

<body class="antialiased bg-gray-900 text-gray-100 font-sans min-h-screen flex flex-col">
    <!-- Accessibility Skip Link -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:bg-blue-700 focus:text-white focus:fixed focus:px-4 focus:py-2 focus:top-2 focus:left-2 focus:z-50">
        İçeriği Atla
    </a>

    <!-- Header -->
    <header class="bg-gray-900 border-b border-gray-800 sticky top-0 z-50 backdrop-blur-sm bg-opacity-95">
        <!-- Top Navigation Bar -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="/" class="flex items-center group">
                            <img class="h-8 w-auto transition-transform group-hover:scale-105" 
                                 src="{{ asset('storage/'.$settings->logo) }}" 
                                 alt="{{$settings->site_name}}">
                        </a>
                    </div>

                    <!-- Main Navigation - Desktop -->
                    <nav class="hidden md:flex items-center space-x-1">
                        <!-- Trading Dropdown -->
                        <div class="relative dropdown-container">
                            <button onclick="toggleDropdown('trade-dropdown')"
                                    class="group inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-md transition-colors duration-200">
                                <span>Ticaret</span>
                                <svg class="ml-1 h-4 w-4 text-gray-400 group-hover:text-gray-300 transition-colors duration-200"
                                     xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div id="trade-dropdown"
                                 class="absolute left-0 mt-2 w-56 rounded-lg shadow-xl bg-gray-800 border border-gray-700 py-2 opacity-0 scale-95 invisible transition-colors duration-200 transform-gpu dropdown-menu">
                                 <a href="cryptocurrencies"
                                    class="block px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                                     <div class="flex items-center">
                                         <svg class="w-4 h-4 mr-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                             <path d="M10 2L3 7v11a1 1 0 001 1h3v-6h6v6h3a1 1 0 001-1V7l-7-5z"/>
                                         </svg>
                                         Kripto Para
                                     </div>
                                 </a>
                                 <a href="forex"
                                    class="block px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                                     <div class="flex items-center">
                                         <svg class="w-4 h-4 mr-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                             <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                                         </svg>
                                         Döviz
                                     </div>
                                 </a>
                                 <a href="shares"
                                    class="block px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                                     <div class="flex items-center">
                                         <svg class="w-4 h-4 mr-3 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                             <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                                         </svg>
                                         Hisseler
                                     </div>
                                 </a>
                                 <a href="indices"
                                    class="block px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                                     <div class="flex items-center">
                                         <svg class="w-4 h-4 mr-3 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                             <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                         </svg>
                                         Endeksler
                                     </div>
                                 </a>
                                 <a href="etfs"
                                    class="block px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                                     <div class="flex items-center">
                                         <svg class="w-4 h-4 mr-3 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                             <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                         </svg>
                                         ETF'ler
                                     </div>
                                 </a>
                             </div>
                         </div>

                        <!-- Company Dropdown -->
                        <div class="relative dropdown-container">
                            <button onclick="toggleDropdown('company-dropdown')"
                                    class="group inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-md transition-colors duration-200">
                                <span>Şirket</span>
                                <svg class="ml-1 h-4 w-4 text-gray-400 group-hover:text-gray-300 transition-colors duration-200"
                                     xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div id="company-dropdown"
                                 class="absolute left-0 mt-2 w-56 rounded-lg shadow-xl bg-gray-800 border border-gray-700 py-2 opacity-0 scale-95 invisible transition-colors duration-200 transform-gpu dropdown-menu">
                                <a href="about"
                                   class="block px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                        </svg>
                                        Hakkımızda
                                    </div>
                                </a>
                                <a href="why-us"
                                   class="block px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Neden Biz
                                    </div>
                                </a>
                                <a href="faq"
                                   class="block px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"/>
                                        </svg>
                                        SSS
                                    </div>
                                </a>
                                <a href="regulation"
                                   class="block px-4 py-3 text-sm text-gray-300 hover-bg-gray-700 hover:text-white transition-colors duration-200">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        Yasal ve Düzenlemeler
                                    </div>
                                </a>
                            </div>
                        </div>

                        <a href="for-traders"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-md transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                            Eğitim
                        </a>
                        <a href="contacts"
                           class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-md transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            İletişim
                        </a>
                    </nav>

                    <!-- Right Navigation -->
                    <div class="hidden md:flex items-center space-x-4">
                        <!-- Language Selector -->
                        <div class="relative dropdown-container">
                            <button onclick="toggleDropdown('language-dropdown')"
                                    class="group inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-all duration-200 border border-gray-600 hover:border-gray-500">
                                <span class="fi fi-tr mr-3 text-lg"></span>
                                <span class="hidden lg:inline mr-2">Türkçe</span>
                                <span class="lg:hidden mr-2">TR</span>
                                <svg class="ml-1 h-4 w-4 text-gray-400 group-hover:text-gray-300 transition-colors duration-200"
                                     xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div id="language-dropdown"
                                 class="absolute right-0 mt-2 w-40 rounded-lg shadow-xl bg-gray-800 border border-gray-700 py-2 opacity-0 scale-95 invisible transition-all duration-200 transform-gpu dropdown-menu z-50">
                                <a href="#" onclick="changeLanguage('tr')"
                                   class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                                    <span class="fi fi-tr mr-3 text-lg"></span>
                                    <span>Türkçe</span>
                                    <svg class="ml-auto h-4 w-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </a>
                                <a href="#" onclick="changeLanguage('ru')"
                                   class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors duration-200">
                                    <span class="fi fi-ru mr-3 text-lg"></span>
                                    <span>Русский</span>
                                </a>
                            </div>
                        </div>

                        <!-- Auth Buttons -->
                        <div class="flex items-center space-x-3">
                            <a href="login"
                               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                </svg>
                                Giriş Yap
                            </a>
                            <a href="register"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 transform hover:scale-105">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                                </svg>
                                Kayıt Ol
                            </a>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button onclick="toggleMobileMenu()"
                                id="mobile-menu-button"
                                type="button"
                                class="inline-flex items-center justify-center p-2 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-colors duration-200"
                                aria-controls="mobile-menu"
                                aria-expanded="false">
                            <span class="sr-only">Menüyü Aç</span>
                            <svg id="mobile-menu-icon"
                                 class="block h-6 w-6"
                                 xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 aria-hidden="true">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg id="mobile-close-icon"
                                 class="hidden h-6 w-6"
                                 xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 aria-hidden="true">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden border-t border-gray-800 bg-gray-900">
                <div class="px-4 pt-3 pb-4 space-y-2">
                    <!-- Trading Submenu -->
                    <div class="space-y-1">
                        <button onclick="toggleMobileSubmenu('trade')"
                                class="w-full flex justify-between items-center px-3 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors duration-200">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                                </svg>
                                Ticaret
                            </div>
                            <svg id="mobile-trade-chevron"
                                 class="h-4 w-4 text-gray-400 transition-transform duration-200"
                                 xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="mobile-trade" class="hidden pl-6 space-y-1">
                            <a href="cryptocurrencies"
                               class="flex items-center px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2L3 7v11a1 1 0 001 1h3v-6h6v6h3a1 1 0 001-1V7l-7-5z"/>
                                </svg>
                                Kripto Para
                            </a>
                            <a href="forex"
                               class="flex items-center px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                                </svg>
                                Döviz
                            </a>
                            <a href="shares"
                               class="flex items-center px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                                </svg>
                                Hisseler
                            </a>
                            <a href="indices"
                               class="flex items-center px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                                Endeksler
                            </a>
                            <a href="etfs"
                               class="flex items-center px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                ETF'ler
                            </a>
                        </div>
                    </div>

                    <!-- Company Submenu -->
                    <div class="space-y-1">
                        <button onclick="toggleMobileSubmenu('company')"
                                class="w-full flex justify-between items-center px-3 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors duration-200">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                                Şirket
                            </div>
                            <svg id="mobile-company-chevron"
                                 class="h-4 w-4 text-gray-400 transition-transform duration-200"
                                 xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20"
                                 fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div id="mobile-company" class="hidden pl-6 space-y-1">
                            <a href="about"
                               class="flex items-center px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                                Hakkımızda
                            </a>
                            <a href="why-us"
                               class="flex items-center px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Neden Biz
                            </a>
                            <a href="faq"
                               class="flex items-center px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"/>
                                </svg>
                                SSS
                            </a>
                            <a href="regulation"
                               class="flex items-center px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1z"
                                          clip-rule="evenodd"/>
                                </svg>
                                Yasal ve Düzenlemeler
                            </a>
                        </div>
                    </div>

                    <!-- Direct Links -->
                    <a href="for-traders"
                       class="flex items-center px-3 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                        Eğitim
                    </a>
                    <a href="contacts"
                       class="flex items-center px-3 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        İletişim
                    </a>

                    <!-- Mobile Auth Links -->
                    <div class="pt-4 mt-4 border-t border-gray-700">
                        <div class="space-y-2">
                            <a href="login"
                               class="flex items-center px-3 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                </svg>
                                Giriş Yap
                            </a>
                            <a href="register"
                               class="flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                                </svg>
                                Kayıt Ol
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Market Ticker Widget -->
    <div class="bg-gray-800 border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-1">
                <div class="crypto-ticker-wrapper">
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
                            "isTransparent": true,
                            "displayMode": "adaptive",
                            "colorTheme": "dark",
                            "locale": "tr"
                        }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <main id="main-content" class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 mt-auto">
        <!-- Upper Footer -->
        <div class="border-t border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <!-- Company Info -->
                        <div class="lg:col-span-1">
                            <div class="flex items-center mb-6">
                                <a href="/" class="flex items-center group">
                                    <img class="h-8 w-auto transition-transform duration-200 group-hover:scale-105"
                                         src="{{ asset('storage/'.$settings->logo) }}"
                                         alt="{{$settings->site_name}}">
                                </a>
                            </div>
                            <p class="text-sm text-gray-400 mb-6 leading-relaxed">
                                {{$settings->site_name}} offers CFD işlem yaparak on stocks, forex, indices, commodities, and cryptocurrencies with competitive spreads and advanced işlem yaparak tools.
                            </p>
                            <div class="flex space-x-4">
                                <a href="#"
                                   class="p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition-colors duration-200">
                                    <span class="sr-only">Twitter</span>
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                                    </svg>
                                </a>
                                <a href="#"
                                   class="p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition-colors duration-200">
                                    <span class="sr-only">LinkedIn</span>
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>
                                <a href="mailto:{{$settings->contact_email}}"
                                   class="p-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition-colors duration-200">
                                    <span class="sr-only">Email</span>
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Hızlı Bağlantılar -->
                        <div>
                            <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-6">Hızlı Bağlantılar</h3>
                            <ul class="space-y-4">
                                <li>
                                    <a href="about"
                                       class="text-sm text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 text-blue-400 group-hover:text-blue-300 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Hakkımızda
                                    </a>
                                </li>
                                <li>
                                    <a href="why-us"
                                       class="text-sm text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 text-green-400 group-hover:text-green-300 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Neden Bizi Seçmelisiniz
                                    </a>
                                </li>
                                <li>
                                    <a href="for-traders"
                                       class="text-sm text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 text-yellow-400 group-hover:text-yellow-300 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                        </svg>
                                        Eğitim
                                    </a>
                                </li>
                                <li>
                                    <a href="contacts"
                                       class="text-sm text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 text-purple-400 group-hover:text-purple-300 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                        </svg>
                                        İletişim
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Trading -->
                        <div>
                            <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-6">Ticaret</h3>
                            <ul class="space-y-4">
                                <li>
                                    <a href="cryptocurrencies"
                                       class="text-sm text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 text-yellow-400 group-hover:text-yellow-300 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 2L3 7v11a1 1 0 001 1h3v-6h6v6h3a1 1 0 001-1V7l-7-5z"/>
                                        </svg>
                                        Kripto Paralar
                                    </a>
                                </li>
                                <li>
                                    <a href="forex"
                                       class="text-sm text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 text-blue-400 group-hover:text-blue-300 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                                        </svg>
                                        Döviz
                                    </a>
                                </li>
                                <li>
                                    <a href="shares"
                                       class="text-sm text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 text-green-400 group-hover:text-green-300 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                                        </svg>
                                        Hisseler
                                    </a>
                                </li>
                                <li>
                                    <a href="indices"
                                       class="text-sm text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 text-purple-400 group-hover:text-purple-300 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                        </svg>
                                        Endeksler
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Account -->
                        <div>
                            <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-6">Hesabınız</h3>
                            <ul class="space-y-4">
                                <li>
                                    <a href="login"
                                       class="text-sm text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 text-indigo-400 group-hover:text-indigo-300 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Giriş Yap
                                    </a>
                                </li>
                                <li>
                                    <a href="register"
                                       class="text-sm text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 text-green-400 group-hover:text-green-300 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                                        </svg>
                                        Hesap Oluştur
                                    </a>
                                </li>
                                <li>
                                    <a href="demo-account"
                                       class="text-sm text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 text-blue-400 group-hover:text-blue-300 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Demo Hesap
                                    </a>
                                </li>
                                <li>
                                    <a href="help"
                                       class="text-sm text-gray-400 hover:text-white transition-colors duration-200 flex items-center group">
                                        <svg class="w-3 h-3 mr-2 text-yellow-400 group-hover:text-yellow-300 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"/>
                                        </svg>
                                        Yardım Merkezi
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Platform Availability -->
        <div class="border-t border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-6">
                    <div class="flex flex-col md:flex-row items-center justify-between">
                        <div class="mb-4 md:mb-0">
                            <h4 class="text-sm font-semibold text-white mb-2">Uygun Platformlar</h4>
                        </div>
                        <div class="flex items-center space-x-6">
                            <a href="#"
                               class="flex items-center text-gray-400 hover:text-white transition-colors duration-200 group">
                                <svg class="w-4 h-4 mr-2 text-blue-400 group-hover:text-blue-300 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm">Web</span>
                            </a>
                            <a href="#" 
                               class="flex items-center text-gray-400 hover:text-white transition-colors duration-200 group">
                                <svg class="w-4 h-4 mr-2 text-green-400 group-hover:text-green-300 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H4a1 1 0 01-1-1v-4zM9 3a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V3zM9 9a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V9z"/>
                                </
                                </svg>
                                <span class="text-sm">Android</span>
                            </a>
                            <a href="#" 
                               class="flex items-center text-gray-400 hover:text-white transition-colors duration-200 group">
                                <svg class="w-4 h-4 mr-2 text-purple-400 group-hover:text-purple-300 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M17 2a1 1 0 011 1v1h1a2 2 0 012 2v11a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2h1V3a1 1 0 112 0v1h6V3a1 1 0 011-1zM5 8v10h10V8H5zm2 3a1 1 0 100-2 1 1 0 000 2zm4 0a1 1 0 100-2 1 1 0 000 2z"/>
                                </svg>
                                <span class="text-sm">iOS</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Footer -->
        <div class="border-t border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-6">
                    <div class="flex flex-col md:flex-row items-center justify-between text-sm text-gray-400">
                        <div class="mb-4 md:mb-0">
                            <p>&copy; {{ date('Y') }} {{$settings->site_name}}. Tüm hakları saklıdır.</p>
                        </div>
                        <div class="flex items-center space-x-6">
                            <a href="terms-of-service" class="hover:text-white transition-colors duration-200">Kullanım Koşulları</a>
                            <a href="privacy-policy" class="hover:text-white transition-colors duration-200">Gizlilik Politikası</a>
                            <a href="risk-disclosure" class="hover:text-white transition-colors duration-200">Risk Bildirimi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Communication Widget System -->
    <!-- Chat Widget Priority: Tawk.to > Tidio (Only one loads) -->
    @if(isset($settings))
        @if(!empty($settings->tawk_to))
            <!-- Tawk.to Chat Widget -->
            @if(str_contains($settings->tawk_to, '<script'))
                <!-- Full Tawk.to Widget Code -->
                {!! $settings->tawk_to !!}
            @else
                <!-- Tawk.to Widget ID Only -->
                <script type="text/javascript">
                    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
                    (function(){
                        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
                        s1.async = true;
                        s1.src = 'https://embed.tawk.to/{{ $settings->tawk_to }}{{ str_contains($settings->tawk_to, "/") ? "" : "/default" }}';
                        s1.charset = 'UTF-8';
                        s1.setAttribute('crossorigin','*');
                        s0.parentNode.insertBefore(s1,s0);
                    })();
                </script>
            @endif
            
            <!-- Tawk.to Mobile Compatibility CSS -->
            <style>
                /* Ensure Tawk.to widget appears on mobile */
                #tawkchat-container,
                .widget-chat-container {
                    z-index: 9999 !important;
                    position: fixed !important;
                }
                
                /* Mobile responsive adjustments */
                @media (max-width: 768px) {
                    #tawkchat-container,
                    .widget-chat-container {
                        bottom: 10px !important;
                        right: 10px !important;
                        z-index: 9999 !important;
                    }
                    
                    /* Ensure chat bubble is visible on mobile */
                    .tawk-chat-bubble {
                        display: block !important;
                        visibility: visible !important;
                        opacity: 1 !important;
                    }
                }
            </style>
        @elseif(!empty($settings->tido))
            <!-- Tidio Live Chat Integration (fallback) -->
            <script src="//code.tidio.co/{{ $settings->tido }}.js" async></script>
        @endif
        
        <!-- Social Media Contact Buttons -->
        @if(!empty($settings->whatsapp) || !empty($settings->telegram))
            <div class="fixed right-4 top-1/2 transform -translate-y-1/2 flex flex-col space-y-3 z-40">
                <!-- WhatsApp Button -->
                @if(!empty($settings->whatsapp))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp) }}"
                       target="_blank"
                       class="bg-green-500 hover:bg-green-600 text-white p-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-110 group"
                       title="WhatsApp ile iletişime geçin">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                        <span class="absolute right-16 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white px-2 py-1 rounded text-sm whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            Bize ulaşın
                        </span>
                    </a>
                @endif
                
                <!-- Telegram Button -->
                @if(!empty($settings->telegram))
                    <a href="https://t.me/{{ ltrim($settings->telegram, '@') }}"
                       target="_blank"
                       class="bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-110 group"
                       title="Telegram ile iletişime geçin">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                        </svg>
                        <span class="absolute right-16 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white px-2 py-1 rounded text-sm whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            Telegram
                        </span>
                    </a>
                @endif
            </div>
        @endif
    @endif
    
</body>
</html>