<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" 
      class="h-full"
      data-layout="{{ $layoutType ?? 'default' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? (isset($settings) ? $settings->site_name : 'Monexa') }} | {{ $pageTitle ?? 'Professional Trading' }}</title>
    
    <!-- Favicon -->
    <link rel="icon" 
          href="{{ (isset($settings) && $settings->favicon) ? asset('storage/' . $settings->favicon) : asset('favicon.ico') }}" 
          type="image/png" />
    
    <!-- Preconnect for Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Lucide Icons (Modern replacement for Font Awesome) -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    @stack('head-scripts')
    @stack('head-styles')
</head>

<body class="h-full antialiased dark:bg-gray-900">
    
    <!-- Theme Detection & Management -->
    <script>
        // Dark mode detection and storage
        const getPreferredTheme = () => {
            if (localStorage.getItem('theme')) {
                return localStorage.getItem('theme');
            }
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        };
        
        const setTheme = (theme) => {
            localStorage.setItem('theme', theme);
            document.documentElement.classList.toggle('dark', theme === 'dark');
        };
        
        // Layout utilities
        const LayoutManager = {
            // State
            sidebarOpen: false,
            sidebarCollapsed: localStorage.getItem('sidebar-collapsed') === 'true',
            mobileMenuOpen: false,
            notificationsOpen: false,
            isLoading: true,
            
            // Layout type
            get layout() {
                return document.documentElement.getAttribute('data-layout') || 'default';
            },
            
            // Theme utilities
            get isDarkMode() {
                return localStorage.getItem('theme') === 'dark';
            },
            
            get isMobile() {
                return window.innerWidth < 768;
            },
            
            // Theme toggle
            toggleTheme() {
                const currentTheme = localStorage.getItem('theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                setTheme(newTheme);
                
                // Dispatch custom event for components that need to listen
                document.dispatchEvent(new CustomEvent('theme-changed', { 
                    detail: { theme: newTheme } 
                }));
            },
            
            // Sidebar management
            toggleSidebar() {
                if (this.layout === 'admin' || this.layout === 'dashboard') {
                    this.sidebarOpen = !this.sidebarOpen;
                    document.dispatchEvent(new CustomEvent('sidebar-toggle', {
                        detail: { open: this.sidebarOpen }
                    }));
                }
            },
            
            toggleSidebarCollapse() {
                if (this.layout === 'admin') {
                    this.sidebarCollapsed = !this.sidebarCollapsed;
                    localStorage.setItem('sidebar-collapsed', this.sidebarCollapsed.toString());
                }
            },
            
            // Mobile menu
            toggleMobileMenu() {
                this.mobileMenuOpen = !this.mobileMenuOpen;
                document.dispatchEvent(new CustomEvent('mobile-menu-toggle', {
                    detail: { open: this.mobileMenuOpen }
                }));
            },
            
            // Notifications
            toggleNotifications() {
                this.notificationsOpen = !this.notificationsOpen;
                document.dispatchEvent(new CustomEvent('notifications-toggle', {
                    detail: { open: this.notificationsOpen }
                }));
            },
            
            // Initialize layout
            init() {
                // Initialize theme
                setTheme(getPreferredTheme());
                
                // Initialize icons
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
                
                // Hide loading screen after delay
                setTimeout(() => {
                    this.isLoading = false;
                    document.dispatchEvent(new CustomEvent('loading-complete'));
                }, 500);
                
                // Listen for theme changes
                document.addEventListener('theme-changed', (e) => {
                    if (typeof lucide !== 'undefined') {
                        setTimeout(() => lucide.createIcons(), 100);
                    }
                });
                
                // Global click listeners for outside clicks
                document.addEventListener('click', (e) => {
                    // Close dropdowns when clicking outside
                    if (this.notificationsOpen && !e.target.closest('.notifications-dropdown')) {
                        this.toggleNotifications();
                    }
                    
                    if (this.mobileMenuOpen && !e.target.closest('.mobile-menu')) {
                        this.toggleMobileMenu();
                    }
                });
            },
            
            // Body class management
            updateBodyClasses() {
                const body = document.body;
                const classes = ['h-full', 'antialiased', 'bg-gray-50', 'dark:bg-gray-900'];
                
                if (this.layout === 'admin') {
                    classes.push('min-h-screen', 'flex', 'overflow-hidden');
                } else if (this.layout === 'dashboard') {
                    classes.push('dark', 'text-gray-100', 'bg-gray-900', 'js-hidden');
                } else if (this.layout === 'guest') {
                    classes.push('bg-white', 'dark:bg-gray-900');
                }
                
                body.className = classes.join(' ');
            }
        };
        
        // Initialize on DOM load
        document.addEventListener('DOMContentLoaded', () => {
            LayoutManager.init();
            LayoutManager.updateBodyClasses();
        });
    </script>

    <!-- Loading Screen -->
    <div id="loading-screen" 
         class="fixed inset-0 bg-white dark:bg-gray-900 z-50 flex items-center justify-center transition-opacity duration-500"
         style="opacity: 0;">
        <div class="text-center">
            <div class="w-12 h-12 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-gray-600 dark:text-gray-400">Yükleniyor...</p>
        </div>
    </div>

    <!-- Loading completion handler -->
    <script>
        document.addEventListener('loading-complete', () => {
            const loadingScreen = document.getElementById('loading-screen');
            if (loadingScreen) {
                loadingScreen.style.opacity = '0';
                setTimeout(() => {
                    loadingScreen.style.display = 'none';
                }, 500);
            }
        });
    </script>

    <!-- Main Layout Container -->
    <div id="main-layout" 
         class="min-h-screen transition-opacity duration-500"
         style="opacity: 0;"
         @if(($layoutType ?? 'default') === 'admin') data-admin-layout="true" @endif>
        
        <!-- Admin Layout -->
        @if(($layoutType ?? 'default') === 'admin')
            @include('layouts.components.admin-sidebar')
            @include('layouts.components.admin-header')
            <main id="admin-main" 
                  class="flex-1 flex flex-col overflow-hidden transition-all duration-300"
                  data-sidebar-collapsed="false">
                @yield('content')
            </main>
        @endif
        
        <!-- Dashboard Layout -->
        @if(($layoutType ?? 'default') === 'dashboard')
            @include('layouts.components.dashboard-header')
            @include('layouts.components.dashboard-sidebar')
            <div class="flex min-h-screen bg-gray-900">
                @yield('content')
                <!-- Mobile Bottom Navigation -->
                @include('layouts.components.mobile-nav')
            </div>
        @endif
        
        <!-- Guest Layout -->
        @if(($layoutType ?? 'default') === 'guest')
            <main class="container mx-auto px-4">
                @yield('content')
            </main>
        @endif
        
        <!-- Base Layout (Landing/Trading) -->
        @if(($layoutType ?? 'default') === 'base')
            @include('layouts.components.base-header')
            @include('layouts.components.market-ticker')
            <main id="main-content" class="flex-grow">
                @yield('content')
            </main>
            @include('layouts.components.base-footer')
        @endif
        
        <!-- Default Layout (Simple) -->
        @if(($layoutType ?? 'default') === 'default')
            <main class="min-h-screen">
                @yield('content')
            </main>
            @include('layouts.components.default-footer')
        @endif
    </div>

    <!-- Global Scripts -->
    @stack('scripts')
    
    <!-- Core JavaScript -->
    <script>
        // Global notification system
        window.showNotification = (message, type = 'success') => {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateY(0)';
                notification.style.opacity = '1';
            }, 10);
            
            // Auto remove
            setTimeout(() => {
                notification.style.transform = 'translateY(-100%)';
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        };
        
        // Utility functions for layout management
        window.toggleTheme = () => LayoutManager.toggleTheme();
        window.toggleSidebar = () => LayoutManager.toggleSidebar();
        window.toggleMobileMenu = () => LayoutManager.toggleMobileMenu();
        window.toggleNotifications = () => LayoutManager.toggleNotifications();
        
        // Initialize Lucide icons after DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            // Fade in main layout
            setTimeout(() => {
                const mainLayout = document.getElementById('main-layout');
                if (mainLayout) {
                    mainLayout.style.opacity = '1';
                }
            }, 100);
        });
        
        // Listen for sidebar state changes
        document.addEventListener('sidebar-toggle', (e) => {
            const adminMain = document.getElementById('admin-main');
            if (adminMain && LayoutManager.layout === 'admin') {
                const adminMain = document.getElementById('admin-main');
                if (e.detail.open) {
                    adminMain.style.marginLeft = LayoutManager.sidebarCollapsed ? '80px' : '256px';
                } else {
                    adminMain.style.marginLeft = '0';
                }
            }
        });
    </script>
    
    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Language Component -->
    @include('layouts.components.language-switcher')
    
    <!-- Live Chat Component -->
    @include('layouts.components.live-chat')
</body>

</html>