<!DOCTYPE html>
<html lang="tr" x-data="{ 
    darkMode: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
    sidebarOpen: false,
    sidebarCollapsed: localStorage.getItem('sidebar-collapsed') === 'true' 
}" 
:class="{ 'dark': darkMode }"
x-init="
    $watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'));
    $watch('sidebarCollapsed', val => localStorage.setItem('sidebar-collapsed', val.toString()));
">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? 'Admin Panel' }} - {{ $settings->site_name ?? 'Monexa' }}</title>
    
    <!-- Favicon -->
    <link href="{{ asset('storage/app/public/' . ($settings->favicon ?? 'favicon.ico')) }}" rel="icon" type="image/x-icon" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    
    <!-- AlpineJS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        
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
        
        /* Sidebar navigation scrollbar */
        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }
        
        .sidebar-nav::-webkit-scrollbar-track {
            background: rgba(229, 231, 235, 0.1);
            border-radius: 2px;
        }
        
        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.3);
            border-radius: 2px;
        }
        
        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.5);
        }
        
        .dark .sidebar-nav::-webkit-scrollbar-track {
            background: rgba(55, 65, 81, 0.1);
        }
        
        .dark .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(75, 85, 99, 0.3);
        }
        
        .dark .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(75, 85, 99, 0.5);
        }
        
        /* Firefox scrollbar */
        .sidebar-nav {
            scrollbar-width: thin;
            scrollbar-color: rgba(156, 163, 175, 0.3) transparent;
        }
        
        .dark .sidebar-nav {
            scrollbar-color: rgba(75, 85, 99, 0.3) transparent;
        }
        
        /* Sidebar transition */
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Loading animation */
        .loading-spinner {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 dark:bg-admin-900 text-gray-900 dark:text-gray-100 antialiased" x-cloak>
    
    <!-- Loading Screen -->
    <div id="loading-screen" class="fixed inset-0 bg-white dark:bg-admin-900 z-50 flex items-center justify-center">
        <div class="text-center">
            <div class="w-12 h-12 border-4 border-primary-200 border-t-primary-600 rounded-full loading-spinner mx-auto mb-4"></div>
            <p class="text-admin-600 dark:text-admin-400">Yükleniyor...</p>
        </div>
    </div>

    <!-- Admin Layout Container -->
    <div class="min-h-screen flex">
        
        <!-- Sidebar -->
        <aside class="sidebar-transition fixed inset-y-0 left-0 z-50 bg-white dark:bg-admin-800 shadow-elegant dark:shadow-glass-dark border-r border-admin-200 dark:border-admin-700"
               :class="{
                   'w-64': !sidebarCollapsed,
                   'w-20': sidebarCollapsed,
                   'translate-x-0': sidebarOpen || window.innerWidth >= 1024,
                   '-translate-x-full': !sidebarOpen && window.innerWidth < 1024
               }"
               x-show="sidebarOpen || window.innerWidth >= 1024"
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full">
            
            <!-- Sidebar Header -->
            <div class="h-20 flex items-center justify-between px-6 border-b border-admin-200 dark:border-admin-700 bg-gradient-to-r from-primary-600 to-primary-700">
                <div class="flex items-center space-x-3" :class="{ 'justify-center w-full': sidebarCollapsed }">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                    </div>
                    <div x-show="!sidebarCollapsed" x-transition class="text-white">
                        @php $adminUser = Auth::guard('admin')->user(); @endphp
                        <h2 class="text-lg font-bold truncate">{{ $adminUser?->firstName ?? 'Admin' }}</h2>
                        <p class="text-xs text-primary-100">{{ $adminUser?->type ?? 'User' }}</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="sidebar-nav flex-1 overflow-y-auto py-6 px-4" style="height: calc(100vh - 180px);" x-data="{ openMenus: {} }">
                
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-700 dark:hover:text-primary-300 transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300' : '' }}"
                   :title="sidebarCollapsed ? 'Kontrol Paneli' : ''">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" :class="{ 'mr-0': sidebarCollapsed }"></i>
                    <span x-show="!sidebarCollapsed" x-transition class="font-medium">Kontrol Paneli</span>
                </a>

                @php $adminUser = Auth::guard('admin')->user(); @endphp
                @if ($adminUser && ($adminUser->type == 'Super Admin' || $adminUser->type == 'Admin'))
                
                <!-- Users Management -->
                <div class="mt-4" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700/50 transition-all duration-200 group"
                            :title="sidebarCollapsed ? 'Kullanıcıları Yönet' : ''">
                        <div class="flex items-center">
                            <i data-lucide="users" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-emerald-500" :class="{ 'mr-0': sidebarCollapsed }"></i>
                            <span x-show="!sidebarCollapsed" x-transition class="font-medium">Kullanıcılar</span>
                        </div>
                        <i data-lucide="chevron-down" x-show="!sidebarCollapsed" class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>
                    
                    <div x-show="open && !sidebarCollapsed" x-transition class="mt-2 ml-12 space-y-1">
                        <a href="{{ route('manageusers') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                            Tüm Kullanıcılar
                        </a>
                    </div>
                </div>

                <!-- Financial Management -->
                <div class="mt-6">
                    <div class="px-4 mb-3">
                        <span x-show="!sidebarCollapsed" class="text-xs font-semibold text-admin-400 dark:text-admin-500 uppercase tracking-wider">Finans Yönetimi</span>
                    </div>
                    
                    <a href="{{ route('mdeposits') }}" 
                       class="flex items-center px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-300 transition-all duration-200 group {{ request()->routeIs('mdeposits') ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : '' }}"
                       :title="sidebarCollapsed ? 'Yatırımları Yönet' : ''">
                        <i data-lucide="trending-up" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-emerald-500" :class="{ 'mr-0': sidebarCollapsed }"></i>
                        <span x-show="!sidebarCollapsed" x-transition class="font-medium">Yatırımlar</span>
                    </a>

                    <a href="{{ route('mwithdrawals') }}" 
                       class="flex items-center px-4 py-3 mt-1 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-rose-50 dark:hover:bg-rose-900/20 hover:text-rose-700 dark:hover:text-rose-300 transition-all duration-200 group {{ request()->routeIs('mwithdrawals') ? 'bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300' : '' }}"
                       :title="sidebarCollapsed ? 'Çekimleri Yönet' : ''">
                        <i data-lucide="trending-down" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-rose-500" :class="{ 'mr-0': sidebarCollapsed }"></i>
                        <span x-show="!sidebarCollapsed" x-transition class="font-medium">Çekimler</span>
                    </a>
                </div>

                <!-- Business Management -->
                <div class="mt-6">
                    <div class="px-4 mb-3">
                        <span x-show="!sidebarCollapsed" class="text-xs font-semibold text-admin-400 dark:text-admin-500 uppercase tracking-wider">İş Yönetimi</span>
                    </div>

                    <a href="{{ route('emailservices') }}"
                       class="flex items-center px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-700 dark:hover:text-blue-300 transition-all duration-200 group {{ request()->routeIs('emailservices') ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : '' }}"
                       :title="sidebarCollapsed ? 'E-posta Servisleri' : ''">
                        <i data-lucide="mail" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-blue-500" :class="{ 'mr-0': sidebarCollapsed }"></i>
                        <span x-show="!sidebarCollapsed" x-transition class="font-medium">E-posta Servisleri</span>
                    </a>

                    <a href="{{ route('kyc') }}"
                       class="flex items-center px-4 py-3 mt-1 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-teal-50 dark:hover:bg-teal-900/20 hover:text-teal-700 dark:hover:text-teal-300 transition-all duration-200 group {{ request()->routeIs('kyc') ? 'bg-teal-100 dark:bg-teal-900/30 text-teal-700 dark:text-teal-300' : '' }}"
                       :title="sidebarCollapsed ? 'KYC Başvuruları' : ''">
                        <i data-lucide="user-check" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-teal-500" :class="{ 'mr-0': sidebarCollapsed }"></i>
                        <span x-show="!sidebarCollapsed" x-transition class="font-medium">KYC Başvuruları</span>
                    </a>

                    <a href="{{ route('admin.trades.index') }}"
                       class="flex items-center px-4 py-3 mt-1 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-violet-50 dark:hover:bg-violet-900/20 hover:text-violet-700 dark:hover:text-violet-300 transition-all duration-200 group {{ request()->routeIs('admin.trades.index') ? 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300' : '' }}"
                       :title="sidebarCollapsed ? 'İşlem Yönetimi' : ''">
                        <i data-lucide="trending-up" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-violet-500" :class="{ 'mr-0': sidebarCollapsed }"></i>
                        <span x-show="!sidebarCollapsed" x-transition class="font-medium">İşlem Yönetimi</span>
                    </a>

                    <a href="{{ route('admin.leads.index') }}"
                       class="flex items-center px-4 py-3 mt-1 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-amber-50 dark:hover:bg-amber-900/20 hover:text-amber-700 dark:hover:text-amber-300 transition-all duration-200 group {{ request()->routeIs('admin.leads.index') ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300' : '' }}"
                       :title="sidebarCollapsed ? 'Müşteri Adayları' : ''">
                        <i data-lucide="users" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-amber-500" :class="{ 'mr-0': sidebarCollapsed }"></i>
                        <span x-show="!sidebarCollapsed" x-transition class="font-medium">Müşteri Adayları</span>
                    </a>
                </div>

                <!-- Content Management -->
                <div class="mt-6">
                    <div class="px-4 mb-3">
                        <span x-show="!sidebarCollapsed" class="text-xs font-semibold text-admin-400 dark:text-admin-500 uppercase tracking-wider">İçerik Yönetimi</span>
                    </div>
                    
                    <a href="{{ route('admin.phrases') }}"
                       class="flex items-center px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-pink-50 dark:hover:bg-pink-900/20 hover:text-pink-700 dark:hover:text-pink-300 transition-all duration-200 group {{ request()->routeIs('admin.phrases') ? 'bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-300' : '' }}"
                       :title="sidebarCollapsed ? 'Dil/Cümleler' : ''">
                        <i data-lucide="languages" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-pink-500" :class="{ 'mr-0': sidebarCollapsed }"></i>
                        <span x-show="!sidebarCollapsed" x-transition class="font-medium">Dil/Cümleler</span>
                    </a>
                </div>

                @endif

                <!-- Tasks Management -->
                <div class="mt-6" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-slate-50 dark:hover:bg-slate-900/20 hover:text-slate-700 dark:hover:text-slate-300 transition-all duration-200 group"
                            :title="sidebarCollapsed ? 'Görevler' : ''">
                        <div class="flex items-center">
                            <i data-lucide="list-checks" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-slate-500" :class="{ 'mr-0': sidebarCollapsed }"></i>
                            <span x-show="!sidebarCollapsed" x-transition class="font-medium">Görevler</span>
                        </div>
                        <i data-lucide="chevron-down" x-show="!sidebarCollapsed" class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>
                    
                    <div x-show="open && !sidebarCollapsed" x-transition class="mt-2 ml-12 space-y-1">
                        @if ($adminUser && $adminUser->type == 'Super Admin')
                            <a href="{{ url('/admin/dashboard/task') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                                Görev Oluştur
                            </a>
                            <a href="{{ url('/admin/dashboard/mtask') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                                Görevleri Yönet
                            </a>
                        @else
                            <a href="{{ url('/admin/dashboard/viewtask') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                                Görevlerimi Görüntüle
                            </a>
                        @endif
                    </div>
                </div>

                @if ($adminUser && $adminUser->type == 'Super Admin')
                
                <!-- Admins Management -->
                <div class="mt-4" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 dark:hover:text-red-300 transition-all duration-200 group"
                            :title="sidebarCollapsed ? 'Yöneticiler' : ''">
                        <div class="flex items-center">
                            <i data-lucide="user-cog" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-red-500" :class="{ 'mr-0': sidebarCollapsed }"></i>
                            <span x-show="!sidebarCollapsed" x-transition class="font-medium">Yöneticiler</span>
                        </div>
                        <i data-lucide="chevron-down" x-show="!sidebarCollapsed" class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>
                    
                    <div x-show="open && !sidebarCollapsed" x-transition class="mt-2 ml-12 space-y-1">
                        <a href="{{ url('/admin/dashboard/addmanager') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                            Yönetici Ekle
                        </a>
                        <a href="{{ url('/admin/dashboard/madmin') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                            Yöneticileri Yönet
                        </a>
                    </div>
                </div>

                <!-- Super Admin Settings -->
                <div class="mt-8 pt-6 border-t border-admin-200 dark:border-admin-700">
                    <div class="px-4 mb-3">
                        <span x-show="!sidebarCollapsed" class="text-xs font-semibold text-admin-400 dark:text-admin-500 uppercase tracking-wider">Sistem Yönetimi</span>
                    </div>
                    
                    <!-- System Settings Menu -->
                    <a href="{{ route('appsettingshow') }}"
                       class="flex items-center px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-orange-50 dark:hover:bg-orange-900/20 hover:text-orange-700 dark:hover:text-orange-300 transition-all duration-200 group {{ request()->routeIs('appsettingshow') ? 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }}"
                       :title="sidebarCollapsed ? 'Sistem Ayarları' : ''">
                        <i data-lucide="server" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-orange-500" :class="{ 'mr-0': sidebarCollapsed }"></i>
                        <span x-show="!sidebarCollapsed" x-transition class="font-medium">Sistem Ayarları</span>
                    </a>

                    <!-- Settings Dropdown -->
                    <div class="mt-4" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 hover:text-purple-700 dark:hover:text-purple-300 transition-all duration-200 group"
                                :title="sidebarCollapsed ? 'Diğer Ayarlar' : ''">
                            <div class="flex items-center">
                                <i data-lucide="settings" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-purple-500" :class="{ 'mr-0': sidebarCollapsed }"></i>
                                <span x-show="!sidebarCollapsed" x-transition class="font-medium">Diğer Ayarlar</span>
                            </div>
                            <i data-lucide="chevron-down" x-show="!sidebarCollapsed" class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }"></i>
                        </button>
                        
                        <div x-show="open && !sidebarCollapsed" x-transition class="mt-2 ml-12 space-y-1">
                            <a href="{{ route('refsetshow') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                                Tavsiye/Bonus Ayarları
                            </a>
                            <a href="{{ route('paymentview') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                                Ödeme Ayarları
                            </a>
                            <a href="{{ route('managecryptoasset') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                                Takas Ayarları
                            </a>
                            <a href="{{ url('/admin/dashboard/ipaddress') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                                IP Adresi
                            </a>
                        </div>
                    </div>
                </div>
                @endif

            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-admin-200 dark:border-admin-700">
                <div class="flex items-center justify-center space-x-2" :class="{ 'flex-col space-x-0 space-y-2': sidebarCollapsed }">
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" 
                            class="p-2 rounded-lg bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 transition-colors"
                            :title="darkMode ? 'Açık Tema' : 'Koyu Tema'">
                        <i data-lucide="sun" x-show="darkMode" class="w-4 h-4"></i>
                        <i data-lucide="moon" x-show="!darkMode" class="w-4 h-4"></i>
                    </button>
                    
                    <!-- Collapse Toggle (Desktop Only) -->
                    <button @click="sidebarCollapsed = !sidebarCollapsed"
                            class="hidden lg:block p-2 rounded-lg bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 transition-colors"
                            :title="sidebarCollapsed ? 'Genişlet' : 'Daralt'">
                        <i data-lucide="panel-left" x-show="!sidebarCollapsed" class="w-4 h-4"></i>
                        <i data-lucide="panel-right" x-show="sidebarCollapsed" class="w-4 h-4"></i>
                    </button>
                </div>
                
                <div x-show="!sidebarCollapsed" x-transition class="mt-3 text-center">
                    <p class="text-xs text-admin-500">{{ $settings->site_name ?? 'Admin Panel' }}</p>
                    <p class="text-xs text-admin-400">© {{ date('Y') }}</p>
                </div>
            </div>

        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen && window.innerWidth < 1024" 
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"></div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden sidebar-transition"
             :class="{
                 'lg:ml-64': !sidebarCollapsed,
                 'lg:ml-20': sidebarCollapsed
             }">

            <!-- Top Navigation -->
            <header class="h-20 bg-white dark:bg-admin-800 shadow-sm dark:shadow-glass-dark border-b border-admin-200 dark:border-admin-700 flex items-center justify-between px-6">
                
                <!-- Left Side -->
                <div class="flex items-center space-x-4">
                    <!-- Mobile Menu Button -->
                    <button @click="sidebarOpen = !sidebarOpen" 
                            class="lg:hidden p-2 rounded-lg text-admin-500 hover:text-admin-700 dark:hover:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 transition-colors">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>

                    <!-- Breadcrumbs -->
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2">
                            @if(isset($breadcrumbs))
                                @foreach($breadcrumbs as $breadcrumb)
                                    <li class="flex items-center">
                                        @if(!$loop->first)
                                            <i data-lucide="chevron-right" class="w-4 h-4 text-admin-400 mx-2"></i>
                                        @endif
                                        @if($loop->last)
                                            <span class="text-sm font-medium text-admin-900 dark:text-admin-100">{{ $breadcrumb['title'] }}</span>
                                        @else
                                            <a href="{{ $breadcrumb['url'] }}" class="text-sm text-admin-500 hover:text-admin-700 dark:hover:text-admin-300">{{ $breadcrumb['title'] }}</a>
                                        @endif
                                    </li>
                                @endforeach
                            @else
                                <li><span class="text-sm font-medium text-admin-900 dark:text-admin-100">{{ $title ?? 'Dashboard' }}</span></li>
                            @endif
                        </ol>
                    </nav>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    
                    <!-- Quick Search -->
                    <div class="hidden md:block relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="w-4 h-4 text-admin-400"></i>
                        </div>
                        <input type="text" 
                               placeholder="Kullanıcıları ara..."
                               class="admin-input w-64 pl-10 pr-4 py-2 text-sm"
                               onclick="window.location.href='{{ route('manageusers') }}'">
                    </div>

                    <!-- Notifications -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="relative p-2 rounded-lg text-admin-500 hover:text-admin-700 dark:hover:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 transition-colors">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            @php
                                $notificationCount = $adminUser ? \App\Models\Notification::where('admin_id', $adminUser->id)->where('is_read', 0)->count() : 0;
                            @endphp
                            @if($notificationCount > 0)
                                <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
                                    {{ $notificationCount > 9 ? '9+' : $notificationCount }}
                                </span>
                            @endif
                        </button>

                        <!-- Notifications Dropdown -->
                        <div x-show="open" @click.away="open = false"
                             x-transition class="absolute right-0 mt-2 w-80 bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 max-h-96 overflow-hidden z-50">
                            
                            <div class="px-6 py-4 border-b border-admin-200 dark:border-admin-700 bg-admin-50 dark:bg-admin-900/50">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-semibold text-admin-900 dark:text-admin-100">Bildirimler</h3>
                                    @if($notificationCount > 0)
                                        <span class="text-xs bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-200 px-2 py-1 rounded-full">{{ $notificationCount }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="overflow-y-auto max-h-64">
                                @if($notificationCount > 0)
                                    <!-- Display notifications here -->
                                    <div class="p-4 text-center text-admin-500">
                                        {{ $notificationCount }} yeni bildirim
                                    </div>
                                @else
                                    <div class="p-8 text-center">
                                        <i data-lucide="bell-off" class="w-12 h-12 text-admin-400 mx-auto mb-3"></i>
                                        <p class="text-sm text-admin-500">Yeni bildirim yok</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center space-x-3 p-2 rounded-lg hover:bg-admin-100 dark:hover:bg-admin-700 transition-colors">
                            <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                {{ $adminUser ? substr($adminUser->firstName, 0, 1) : 'A' }}
                            </div>
                            <div class="hidden sm:block text-left">
                                <div class="text-sm font-medium text-admin-900 dark:text-admin-100">{{ $adminUser?->firstName ?? 'Admin' }}</div>
                                <div class="text-xs text-admin-500">{{ $adminUser?->type ?? 'User' }}</div>
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-admin-400"></i>
                        </button>

                        <!-- Profile Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                             x-transition class="absolute right-0 mt-2 w-56 bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 z-50">
                            
                            <div class="p-4 border-b border-admin-200 dark:border-admin-700">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ $adminUser ? substr($adminUser->firstName, 0, 1) : 'A' }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-admin-900 dark:text-admin-100">{{ $adminUser?->firstName ?? 'Admin' }} {{ $adminUser?->lastName ?? '' }}</div>
                                        <div class="text-sm text-admin-500">{{ $adminUser?->type ?? 'User' }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2">
                                <a href="{{ route('adminprofile') }}" class="flex items-center px-3 py-2 text-sm text-admin-700 dark:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 rounded-lg transition-colors">
                                    <i data-lucide="user-cog" class="w-4 h-4 mr-3"></i>
                                    Hesap Ayarları
                                </a>
                                <a href="{{ url('admin/dashboard/adminchangepassword') }}" class="flex items-center px-3 py-2 text-sm text-admin-700 dark:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 rounded-lg transition-colors">
                                    <i data-lucide="key" class="w-4 h-4 mr-3"></i>
                                    Şifre Değiştir
                                </a>
                                <div class="border-t border-admin-200 dark:border-admin-700 my-2"></div>
                                <form action="{{ route('adminlogout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                        <i data-lucide="log-out" class="w-4 h-4 mr-3"></i>
                                        Çıkış Yap
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-admin-900">
                
                <!-- Alert Messages -->
                <div class="p-6 pb-0">
                    <x-success-alert />
                    <x-danger-alert />
                    <x-notify-alert />
                </div>

                <!-- Page Content -->
                <div class="p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Initialize Lucide Icons
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
            
            // Hide loading screen
            const loadingScreen = document.getElementById('loading-screen');
            if (loadingScreen) {
                setTimeout(() => {
                    loadingScreen.style.opacity = '0';
                    setTimeout(() => {
                        loadingScreen.style.display = 'none';
                    }, 300);
                }, 500);
            }
        });

        // Re-initialize icons after Alpine updates
        document.addEventListener('alpine:init', () => {
            Alpine.nextTick(() => {
                lucide.createIcons();
            });
        });

        // Handle window resize for sidebar
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                // Close mobile sidebar on desktop
                Alpine.store('sidebar', { ...Alpine.store('sidebar'), sidebarOpen: false });
            }
        });
    </script>

    <!-- Page Specific Scripts -->
    @stack('scripts')

    <!-- Laravel Mix Hot Reload (Development only) -->
    @if(app()->environment('local'))
        <script src="{{ mix('js/app.js') }}"></script>
    @endif
</body>
</html>