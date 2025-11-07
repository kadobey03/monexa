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
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- SEO Meta Tags & Structured Data -->
    @include('components.seo-meta', [
        'pageType' => $pageType ?? 'homepage',
        'additionalData' => $additionalData ?? []
    ])
    
    <!-- jQuery with Fallback -->
    
    <script>
        // Load jQuery from CDN with local fallback
        if (!window.jQuery) {
            const jqueryScript = document.createElement('script');
            jqueryScript.src = 'https://code.jquery.com/jquery-3.7.1.min.js';
            jqueryScript.integrity = 'sha384-1H217gwSVyLSIfaLxHbE7dRb3v4mYCKbpQvzx0cegeju1MVsGrX5xXxAvs/HgeFs';
            jqueryScript.crossOrigin = 'anonymous';
            jqueryScript.onerror = function() {
                // Fallback to local jQuery if CDN fails
                const fallbackScript = document.createElement('script');
                fallbackScript.src = '{{ secure_asset("vendor/jquery/jquery-3.7.1.min.js") }}';
                document.head.appendChild(fallbackScript);
            };
            document.head.appendChild(jqueryScript);
        }
    </script>
    
    <!-- Bootstrap JavaScript with Fallback (Only for layouts that need it) -->
    @if(!in_array($layoutType ?? 'default', ['guest', 'default']))
    
    <script>
        if (!window.bootstrap) {
            document.write('<script src="{{ secure_asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"><\/script>');
        }
    </script>
    @endif
    
    <!-- SweetAlert2 with Fallback -->
    
    <script>
        if (!window.Swal) {
            document.write('<script src="{{ secure_asset('vendor/sweetalert2/sweetalert2.min.js') }}"><\/script>');
        }
    </script>
    
    <!-- Heroicons Component - Pure SVG icons with no JavaScript dependencies -->
    
    <!-- Console Error Fixes - Ultimate System -->
    
    
    
    
    <!-- TradingView Scripts for Dashboard Layout -->
    @if(($layoutType ?? 'default') === 'dashboard')
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
    
    <!-- Comprehensive Console Error Suppression for TradingView -->
    <script type="text/javascript">
        // Store original console methods
        const originalConsole = {
            error: console.error,
            warn: console.warn,
            log: console.log
        };
        
        // Function to check if message should be suppressed
        function shouldSuppress(message) {
            const suppressPatterns = [
                'Unable to check top-level optout',
                'Failed to read a named property',
                'cross-origin frame',
                'Blocked a frame with origin "https://s.tradingview.com"',
                'Blocked a frame with origin "https://www.tradingview-widget.com"',
                'checkPageOptout',
                'Invalid environment undefined',
                'snowplow-embed-widget-tracker',
                'embed_timeline_widget',
                'runtime-embed_timeline_widget'
            ];
            
            return suppressPatterns.some(pattern => message.includes(pattern));
        }
        
        // Override console.error with comprehensive filtering
        console.error = function(...args) {
            const message = args.join(' ');
            if (!shouldSuppress(message)) {
                originalConsole.error.apply(console, args);
            }
        };
        
        // Also suppress console.warn for TradingView widgets
        console.warn = function(...args) {
            const message = args.join(' ');
            if (!shouldSuppress(message)) {
                originalConsole.warn.apply(console, args);
            }
        };
        
        // Suppress window error events from TradingView
        window.addEventListener('error', function(e) {
            if (e.filename && (
                e.filename.includes('tradingview') ||
                e.filename.includes('snowplow') ||
                e.message.includes('cross-origin')
            )) {
                e.preventDefault();
                return false;
            }
        }, true);
        
        // Suppress unhandled promise rejections from TradingView
        window.addEventListener('unhandledrejection', function(e) {
            if (e.reason && e.reason.toString().includes('cross-origin')) {
                e.preventDefault();
                return false;
            }
        });
    </script>
    @endif
    
    @stack('head-scripts')
    @stack('head-styles')
</head>

<body class="h-full antialiased dark:bg-gray-900">
    
    <!-- Enhanced Theme Detection & Management -->
    <script>
        // Enhanced theme management with better persistence
        const ThemeManager = {
            getPreferredTheme() {
                if (localStorage.getItem('theme')) {
                    return localStorage.getItem('theme');
                }
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            },
            
            setTheme(theme) {
                localStorage.setItem('theme', theme);
                document.documentElement.classList.toggle('dark', theme === 'dark');
                
                // Update theme-specific elements
                this.updateThemeElements(theme);
                
                // Dispatch custom event for components
                document.dispatchEvent(new CustomEvent('theme-changed', {
                    detail: { theme }
                }));
            },
            
            updateThemeElements(theme) {
                // Update icons
                const sunIcons = document.querySelectorAll('.sun-icon');
                const moonIcons = document.querySelectorAll('.moon-icon');
                
                sunIcons.forEach(icon => {
                    icon.style.display = theme === 'dark' ? 'block' : 'none';
                });
                
                moonIcons.forEach(icon => {
                    icon.style.display = theme === 'dark' ? 'none' : 'block';
                });
            },
            
            toggleTheme() {
                const currentTheme = this.getPreferredTheme();
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                this.setTheme(newTheme);
            }
        };
        
        // Enhanced Layout Manager
        const LayoutManager = {
            // State management
            state: {
                sidebarOpen: false,
                sidebarCollapsed: localStorage.getItem('sidebar-collapsed') === 'true',
                mobileMenuOpen: false,
                notificationsOpen: false,
                profileOpen: false,
                quickActionsOpen: false,
                isLoading: true,
                openMenus: {}
            },
            
            // Configuration based on layout type
            config: {
                admin: {
                    sidebar: true,
                    header: true,
                    mobileNav: false,
                    footer: false,
                    theme: 'admin'
                },
                dashboard: {
                    sidebar: true,
                    header: true,
                    mobileNav: true,
                    footer: false,
                    theme: 'dark'
                },
                app: {
                    sidebar: false,
                    header: false,
                    mobileNav: false,
                    footer: true,
                    theme: 'light'
                },
                guest: {
                    sidebar: false,
                    header: true,
                    mobileNav: false,
                    footer: true,
                    theme: 'light'
                },
                base: {
                    sidebar: false,
                    header: true,
                    mobileNav: false,
                    footer: true,
                    theme: 'dark'
                },
                default: {
                    sidebar: false,
                    header: false,
                    mobileNav: false,
                    footer: true,
                    theme: 'light'
                }
            },
            
            // Get current layout type
            get layout() {
                return document.documentElement.getAttribute('data-layout') || 'default';
            },
            
            // Get current layout configuration
            get config() {
                const layouts = this._layouts || this._defineLayouts();
                return layouts[this.layout] || layouts.default;
            },
            
            // Define layout configurations
            _defineLayouts() {
                this._layouts = {
                    admin: {
                        sidebar: true,
                        header: true,
                        mobileNav: false,
                        footer: false,
                        theme: 'admin'
                    },
                    dashboard: {
                        sidebar: true,
                        header: true,
                        mobileNav: true,
                        footer: false,
                        theme: 'dark'
                    },
                    app: {
                        sidebar: false,
                        header: false,
                        mobileNav: false,
                        footer: true,
                        theme: 'light'
                    },
                    guest: {
                        sidebar: false,
                        header: true,
                        mobileNav: false,
                        footer: true,
                        theme: 'light'
                    },
                    base: {
                        sidebar: false,
                        header: true,
                        mobileNav: false,
                        footer: true,
                        theme: 'dark'
                    },
                    default: {
                        sidebar: false,
                        header: false,
                        mobileNav: false,
                        footer: true,
                        theme: 'light'
                    }
                };
                return this._layouts;
            },
            
            // Get responsive breakpoints
            get isMobile() {
                return window.innerWidth < 768;
            },
            
            get isTablet() {
                return window.innerWidth >= 768 && window.innerWidth < 1024;
            },
            
            // Theme management
            toggleTheme() {
                ThemeManager.toggleTheme();
            },
            
            // Sidebar management
            toggleSidebar() {
                if (!this.config.sidebar) return;
                
                this.state.sidebarOpen = !this.state.sidebarOpen;
                this.updateSidebarState();
                
                document.dispatchEvent(new CustomEvent('sidebar-toggle', {
                    detail: { open: this.state.sidebarOpen }
                }));
            },
            
            // Dashboard-specific sidebar toggle
            toggleDashboardSidebar() {
                if (this.layout !== 'dashboard') return;
                return this.toggleSidebar();
            },
            
            toggleSidebarCollapse() {
                if (!this.config.sidebar || this.layout !== 'admin') return;
                
                this.state.sidebarCollapsed = !this.state.sidebarCollapsed;
                localStorage.setItem('sidebar-collapsed', this.state.sidebarCollapsed.toString());
                this.updateSidebarCollapse();
            },
            
            // Mobile menu management
            toggleMobileMenu() {
                this.state.mobileMenuOpen = !this.state.mobileMenuOpen;
                this.updateMobileMenuState();
            },
            
            // Notifications management
            toggleNotifications() {
                this.state.notificationsOpen = !this.state.notificationsOpen;
                this.updateDropdownState('notifications');
            },
            
            // Profile dropdown management
            toggleProfileDropdown() {
                this.state.profileOpen = !this.state.profileOpen;
                this.updateDropdownState('profile');
            },
            
            // Quick actions management
            toggleQuickActions() {
                this.state.quickActionsOpen = !this.state.quickActionsOpen;
                this.updateDropdownState('quick-actions');
            },
            
            // Submenu management
            toggleSubMenu(menuId) {
                if (this.state.sidebarCollapsed) return;
                
                const isOpen = this.state.openMenus[menuId] || false;
                this.state.openMenus[menuId] = !isOpen;
                this.updateSubMenu(menuId, !isOpen);
            },
            
            // Update functions
            updateSidebarState() {
                // Handle different sidebar implementations based on layout
                let sidebar, overlay, menuIcon, closeIcon, mainContent;
                
                if (this.layout === 'dashboard') {
                    // Dashboard layout uses dashboard-sidebar component
                    sidebar = document.getElementById('dashboard-sidebar');
                    overlay = document.getElementById('dashboard-sidebar-overlay');
                    menuIcon = document.getElementById('menu-icon');
                    closeIcon = document.getElementById('close-icon');
                    mainContent = document.getElementById('dashboard-main-content');
                } else {
                    // Other layouts use generic sidebar
                    sidebar = document.getElementById('sidebar');
                    overlay = document.getElementById('sidebar-overlay');
                    menuIcon = document.getElementById('menu-icon');
                    closeIcon = document.getElementById('close-icon');
                    mainContent = document.getElementById('main-content') || document.getElementById('mainContent');
                }
                
                if (sidebar) {
                    if (this.state.sidebarOpen) {
                        sidebar.classList.remove('-translate-x-full');
                        sidebar.classList.add('translate-x-0');
                        if (overlay) {
                            overlay.classList.remove('hidden');
                            overlay.classList.add('opacity-50');
                        }
                        if (menuIcon) menuIcon.classList.add('hidden');
                        if (closeIcon) closeIcon.classList.remove('hidden');
                        
                        // Prevent body scrolling on mobile when sidebar is open
                        if (this.isMobile) {
                            document.body.style.overflow = 'hidden';
                        }
                    } else {
                        sidebar.classList.add('-translate-x-full');
                        sidebar.classList.remove('translate-x-0');
                        if (overlay) {
                            overlay.classList.add('hidden');
                            overlay.classList.remove('opacity-50');
                        }
                        if (menuIcon) menuIcon.classList.remove('hidden');
                        if (closeIcon) closeIcon.classList.add('hidden');
                        
                        // Restore body scrolling
                        document.body.style.overflow = '';
                    }
                }
            },
            
            updateSidebarCollapse() {
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('main-content') || document.getElementById('mainContent');
                
                if (sidebar && mainContent) {
                    if (this.state.sidebarCollapsed) {
                        sidebar.classList.remove('w-64');
                        sidebar.classList.add('w-20');
                        mainContent.classList.remove('lg:ml-64');
                        mainContent.classList.add('lg:ml-20');
                    } else {
                        sidebar.classList.remove('w-20');
                        sidebar.classList.add('w-64');
                        mainContent.classList.remove('lg:ml-20');
                        mainContent.classList.add('lg:ml-64');
                    }
                    
                    this.updateMenuTextVisibility(!this.state.sidebarCollapsed);
                }
            },
            
            updateMobileMenuState() {
                const mobileMenu = document.getElementById('mobile-menu');
                if (mobileMenu) {
                    mobileMenu.style.display = this.state.mobileMenuOpen ? 'block' : 'none';
                }
            },
            
            updateDropdownState(type) {
                const dropdown = document.getElementById(`${type}-dropdown`);
                const menu = document.getElementById(`${type}-menu`);
                
                if (dropdown && menu) {
                    if (this.state[`${type}Open`]) {
                        menu.classList.remove('hidden', 'opacity-0');
                        menu.classList.add('opacity-100');
                        dropdown.classList.add('active');
                    } else {
                        menu.classList.add('hidden', 'opacity-0');
                        menu.classList.remove('opacity-100');
                        dropdown.classList.remove('active');
                    }
                }
            },
            
            updateSubMenu(menuId, show) {
                const content = document.getElementById(`${menuId}Content`);
                const chevron = document.getElementById(`${menuId}Chevron`);
                
                if (content) {
                    content.style.display = show ? 'block' : 'none';
                }
                
                if (chevron) {
                    chevron.classList.toggle('rotate-180', show);
                }
            },
            
            updateMenuTextVisibility(show) {
                const menuSpans = document.querySelectorAll('#sidebarNav span.font-medium');
                const sectionTitles = document.querySelectorAll('#sidebarNav span.text-xs.font-semibold');
                const chevrons = document.querySelectorAll('#sidebarNav i[id$="Chevron"]');
                
                menuSpans.forEach(span => {
                    span.style.display = show ? 'block' : 'none';
                });
                
                sectionTitles.forEach(title => {
                    title.style.display = show ? 'block' : 'none';
                });
                
                chevrons.forEach(chevron => {
                    chevron.style.display = show ? 'block' : 'none';
                });
            },
            
            // Initialize layout
            init() {
                // Initialize theme
                ThemeManager.setTheme(ThemeManager.getPreferredTheme());
                
                // Apply initial layout states
                if (this.config.sidebar && this.state.sidebarCollapsed) {
                    this.updateSidebarCollapse();
                }
                
                // Initialize icons
                // Icons initialized via unified Icon Service
                
                // Hide loading screen
                setTimeout(() => {
                    this.state.isLoading = false;
                    document.dispatchEvent(new CustomEvent('loading-complete'));
                    
                    const loadingScreen = document.getElementById('loading-screen');
                    if (loadingScreen) {
                        loadingScreen.style.opacity = '0';
                        setTimeout(() => {
                            loadingScreen.style.display = 'none';
                        }, 500);
                    }
                    
                    const mainLayout = document.getElementById('main-layout');
                    if (mainLayout) {
                        mainLayout.style.opacity = '1';
                    }
                }, 500);
                
                // Event listeners
                this.setupEventListeners();
            },
            
            setupEventListeners() {
                // Theme changes
                document.addEventListener('theme-changed', (e) => {
                    // Icons initialized via unified Icon Service
                });
                
                // Outside click listeners
                document.addEventListener('click', (e) => {
                    this.handleOutsideClick(e);
                });
                
                // Window resize
                window.addEventListener('resize', () => {
                    this.handleResize();
                });
                
                // Keyboard shortcuts
                document.addEventListener('keydown', (e) => {
                    this.handleKeyboardShortcuts(e);
                });
            },
            
            handleOutsideClick(e) {
                // Close dropdowns when clicking outside
                Object.keys(this.state).forEach(key => {
                    if (key.endsWith('Open') && this.state[key]) {
                        const dropdown = document.getElementById(`${key.replace('Open', '')}-dropdown`);
                        if (dropdown && !dropdown.contains(e.target)) {
                            this.state[key] = false;
                            this.updateDropdownState(key.replace('Open', ''));
                        }
                    }
                });
                
                // Close sidebar on mobile when clicking overlay
                if (this.state.sidebarOpen && this.isMobile) {
                    const overlay = document.getElementById('sidebar-overlay');
                    if (overlay && e.target === overlay) {
                        this.state.sidebarOpen = false;
                        this.updateSidebarState();
                    }
                }
            },
            
            handleResize() {
                // Reset mobile states on desktop
                if (!this.isMobile) {
                    if (this.state.mobileMenuOpen) {
                        this.state.mobileMenuOpen = false;
                        this.updateMobileMenuState();
                    }
                }
            },
            
            handleKeyboardShortcuts(e) {
                // ESC key to close modals/dropdowns
                if (e.key === 'Escape') {
                    Object.keys(this.state).forEach(key => {
                        if (key.endsWith('Open') && this.state[key]) {
                            this.state[key] = false;
                            const type = key.replace('Open', '');
                            this.updateDropdownState(type);
                        }
                    });
                }
                
                // Ctrl/Cmd + D for theme toggle
                if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
                    e.preventDefault();
                    this.toggleTheme();
                }
            }
        };
        
        // Initialize on DOM load
        document.addEventListener('DOMContentLoaded', () => {
            LayoutManager.init();
        });
    </script>

    <!-- Enhanced Loading Screen -->
    <div id="loading-screen"
         class="fixed inset-0 bg-white dark:bg-gray-900 z-50 flex items-center justify-center transition-opacity duration-500"
         style="opacity: 0;">
        <div class="text-center">
            <div class="w-12 h-12 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-gray-600 dark:text-gray-400">Yükleniyor...</p>
        </div>
    </div>

    <!-- Main Layout Container -->
    <div id="main-layout"
         class="min-h-screen transition-opacity duration-500"
         style="opacity: 0;"
         data-layout-type="{{ $layoutType ?? 'default' }}">
        
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
            <div class="min-h-screen bg-gray-900">
                <!-- Main Content Area with proper sidebar spacing -->
                <main class="transition-all duration-300 ease-in-out pt-16
                           ml-0 pl-0
                           md:ml-72 md:pl-0
                           lg:ml-72 lg:pl-0
                           xl:ml-72 xl:pl-0"
                      id="dashboard-main-content">
                    @yield('content')
                </main>
                @include('layouts.components.mobile-nav')
            </div>
        @endif
-------
        
        <!-- App Layout (Enhanced) -->
        @if(($layoutType ?? 'default') === 'app')
            <div class="min-h-screen flex flex-col">
                <!-- App Header (Optional) -->
                @isset($showHeader)
                    @include('layouts.components.base-header')
                @endisset
                
                <!-- Main Content -->
                <main class="flex-1">
                    @yield('content')
                </main>
                
                <!-- App Footer -->
                @isset($showFooter)
                    @include('layouts.components.default-footer')
                @endisset
            </div>
        @endif
        
        <!-- Guest Layout (Enhanced) -->
        @if(($layoutType ?? 'default') === 'guest')
            <div class="min-h-screen flex flex-col">
                <!-- Guest Header -->
                <header class="bg-white dark:bg-gray-900 shadow-sm border-b border-gray-200 dark:border-gray-800">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center h-16">
                            <!-- Logo -->
                            <div class="flex-shrink-0">
                                @if(isset($settings) && $settings->logo)
                                    <img src="{{ asset('storage/'.$settings->logo)}}" class="h-8 w-auto" alt="{{$settings->site_name}}">
                                @else
                                    <span class="text-2xl font-bold text-blue-600">{{ $settings->site_name ?? 'Monexa' }}</span>
                                @endif
                            </div>
                            
                            <!-- Theme Toggle -->
                            <button onclick="LayoutManager.toggleTheme()" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                                <x-heroicon name="moon" class="w-5 h-5 sun-icon" />
                                <x-heroicon name="sun" class="w-5 h-5 moon-icon" />
                            </button>
                        </div>
                    </div>
                </header>

                <!-- Main Content Area -->
                <main class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
                    @yield('content')
                </main>

                <!-- Guest Footer -->
                <footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                        <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                            <p>© {{ date('Y') }} {{ $settings->site_name ?? 'Monexa' }}. Tüm hakları saklıdır.</p>
                            @if (isset($settings) && $settings->google_translate == 'on')
                                @include('layouts.lang')
                            @endif
                        </div>
                    </div>
                </footer>
            </div>
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
    
    <!-- Enhanced Core JavaScript -->
    <script>
        // Global notification system
        window.showNotification = (message, type = 'success', duration = 5000) => {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
                type === 'success' ? 'bg-green-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' :
                type === 'warning' ? 'bg-yellow-500 text-white' :
                'bg-blue-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : type === 'warning' ? 'exclamation' : 'info'}-circle mr-3"></i>
                    <span>${message}</span>
                    <button class="ml-4 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
                notification.style.opacity = '1';
            }, 10);
            
            // Auto remove
            setTimeout(() => {
                notification.style.transform = 'translateX(full)';
                notification.style.opacity = '0';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 300);
            }, duration);
        };
        
        // Enhanced utility functions - FIXED: Consistent naming convention
        window.toggleTheme = () => LayoutManager.toggleTheme();
        window.toggleDashboardSidebar = () => LayoutManager.toggleDashboardSidebar();
        window.toggleSidebarCollapse = () => LayoutManager.toggleSidebarCollapse();
        window.toggleMobileMenu = () => LayoutManager.toggleMobileMenu();
        window.toggleNotifications = () => LayoutManager.toggleNotifications();
        window.toggleProfileDropdown = () => LayoutManager.toggleProfileDropdown();
        window.toggleQuickActions = () => LayoutManager.toggleQuickActions();
        window.toggleSubMenu = (menuId) => LayoutManager.toggleSubMenu(menuId);
        
        // Legacy alias for backward compatibility
        window.toggleSidebar = () => LayoutManager.toggleDashboardSidebar();
        
        // SweetAlert2 integration
        window.showAlert = (title, text, icon = 'success') => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title,
                    text,
                    icon,
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            }
        };
        
        // Enhanced DOM ready handler
        document.addEventListener('DOMContentLoaded', function() {
            // Heroicons - No initialization needed (pure SVG components)
            console.log('Heroicons loaded - pure SVG components ready');
            
            // Initialize components
            initializeComponents();
            
            // Global event listeners
            setupGlobalEventListeners();
        });
        
        function initializeComponents() {
            // Initialize tooltips if any
            const tooltipElements = document.querySelectorAll('[data-tooltip]');
            tooltipElements.forEach(element => {
                element.addEventListener('mouseenter', showTooltip);
                element.addEventListener('mouseleave', hideTooltip);
            });
            
            // Initialize forms
            const forms = document.querySelectorAll('form[data-validate]');
            forms.forEach(form => {
                form.addEventListener('submit', validateForm);
            });
        }
        
        function setupGlobalEventListeners() {
            // Keyboard shortcuts
            document.addEventListener('keydown', handleGlobalShortcuts);
            
            // Auto-save for forms
            const autosaveForms = document.querySelectorAll('form[data-autosave]');
            autosaveForms.forEach(form => {
                form.addEventListener('input', debounce(autoSaveForm, 1000));
            });
        }
        
        function handleGlobalShortcuts(e) {
            // Ctrl/Cmd + / for help
            if ((e.ctrlKey || e.metaKey) && e.key === '/') {
                e.preventDefault();
                showNotification('Keyboard Shortcuts: Ctrl+D (Theme), Ctrl+/ (Help), ESC (Close)', 'info', 3000);
            }
        }
        
        // Utility functions
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
        
        function autoSaveForm(e) {
            const form = e.target;
            const formData = new FormData(form);
            // Implement auto-save logic here
            console.log('Auto-saving form...', Object.fromEntries(formData));
        }
        
        // Listen for custom events from components
        document.addEventListener('sidebar-toggle', handleSidebarToggle);
        document.addEventListener('theme-changed', handleThemeChange);
        document.addEventListener('notification-toggle', handleNotificationToggle);
        
        function handleSidebarToggle(e) {
            console.log('Sidebar toggled:', e.detail);
        }
        
        function handleThemeChange(e) {
            console.log('Theme changed:', e.detail.theme);
            // Update any theme-dependent components
        }
        
        function handleNotificationToggle(e) {
            console.log('Notification toggle:', e.detail);
        }
        
        // Crypto prices integration (for dashboard layout)
        if (document.documentElement.getAttribute('data-layout') === 'dashboard') {
            initializeCryptoPrices();
        }
        
        function initializeCryptoPrices() {
            // Crypto price fetching logic
            async function fetchCryptoPrices() {
                try {
                    const response = await fetch('/api/crypto/prices');
                    const data = await response.json();
                    updateCryptoDisplay(data);
                } catch (error) {
                    console.error('Error fetching crypto prices:', error);
                }
            }
            
            function updateCryptoDisplay(data) {
                const elements = {
                    btc: document.getElementById('btc-price') || document.getElementById('mobile-btc-price'),
                    eth: document.getElementById('eth-price') || document.getElementById('mobile-eth-price')
                };
                
                if (data.bitcoin && elements.btc) {
                    elements.btc.textContent = '$' + Math.round(data.bitcoin.usd).toLocaleString();
                }
                
                if (data.ethereum && elements.eth) {
                    elements.eth.textContent = '$' + Math.round(data.ethereum.usd).toLocaleString();
                }
            }
            
            // Fetch prices initially and then every 30 seconds
            fetchCryptoPrices();
            setInterval(fetchCryptoPrices, 30000);
        }
        
        // jQuery integration for legacy compatibility with Bootstrap
        if (typeof $ !== 'undefined') {
            $(document).ready(function() {
                console.log('jQuery ready - legacy compatibility mode');
                
                // Initialize Bootstrap components (only if Bootstrap is loaded)
                if (typeof bootstrap !== 'undefined') {
                    // Initialize modals with Bootstrap 5
                    const modalElements = document.querySelectorAll('.modal');
                    modalElements.forEach(modalEl => {
                        new bootstrap.Modal(modalEl);
                    });
                    
                    // Initialize dropdowns
                    const dropdownElements = document.querySelectorAll('.dropdown-toggle');
                    dropdownElements.forEach(dropdownEl => {
                        new bootstrap.Dropdown(dropdownEl);
                    });
                    
                    // Initialize tooltips
                    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
                    
                    console.log('Bootstrap components initialized');
                } else {
                    console.log('Bootstrap not loaded - using pure Tailwind CSS layout');
                }
                
                // Heroicons - No initialization needed (pure SVG components)
                console.log('Heroicons: Pure SVG components loaded - no initialization required');
            });
        }
    </script>
    
    <!-- Livewire Scripts -->
    @livewireScriptConfig
    @livewireScripts
    
    <!-- Enhanced Livewire Configuration -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configure Livewire if available
            if (typeof Livewire !== 'undefined') {
                // Configure Livewire for better UX
                Livewire.hook('request:failed', (response) => {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Oturum Süresi Doldu',
                            text: 'Sayfayı yeniden yüklemek için tamam\'a tıklayın.',
                            icon: 'warning',
                            confirmButtonText: 'Tamam'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        if (confirm('Oturum süresi doldu. Sayfayı yeniden yüklemek istiyor musunuz?')) {
                            window.location.reload();
                        }
                    }
                });
                
                // Loading states
                Livewire.hook('morph.updating', () => {
                    document.body.classList.add('loading');
                });
                
                Livewire.hook('morph.updated', () => {
                    document.body.classList.remove('loading');
                });
                
                console.log('Livewire configured successfully');
            } else {
                console.warn('Livewire not loaded');
            }
        });
        
        // Theme integration with Livewire
        document.addEventListener('theme-changed', (e) => {
            if (typeof Livewire !== 'undefined') {
                Livewire.dispatch('theme-changed', { theme: e.detail.theme });
            }
        });
    </script>
    
    <!-- Global Styles -->
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.4);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.6);
        }
        
        .dark ::-webkit-scrollbar-thumb {
            background: rgba(75, 85, 99, 0.4);
        }
        
        .dark ::-webkit-scrollbar-thumb:hover {
            background: rgba(75, 85, 99, 0.6);
        }
        
        /* Smooth transitions */
        * {
            transition: color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease, transform 0.2s ease, opacity 0.2s ease;
        }
        
        /* Focus styles */
        button:focus,
        input:focus,
        select:focus,
        textarea:focus {
            outline: 2px solid theme('colors.blue.500');
            outline-offset: 2px;
        }
        
        /* Loading states */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
        
        .spinner {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Layout-specific styles */
        [data-layout-type="admin"] .sidebar {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }
        
        [data-layout-type="dashboard"] {
            background: theme('colors.gray.900');
            color: theme('colors.gray.100');
        }
        
        [data-layout-type="dashboard"] .card {
            background: rgba(31, 41, 55, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }
        
        /* Animation utilities */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        .slide-up {
            animation: slideUp 0.3s ease-out;
        }
        
        .bounce-in {
            animation: bounceIn 0.6s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        @keyframes bounceIn {
            0%, 20%, 40%, 60%, 80% {
                transform: translateY(0);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        /* Utility classes */
        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .dark .glassmorphism {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
    
    <!-- Language Component -->
    @include('layouts.lang')
    
    <!-- Live Chat Component -->
    @include('layouts.livechat')
</body>

</html>