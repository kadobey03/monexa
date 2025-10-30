<!DOCTYPE html>
<html lang="tr" id="htmlRoot">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? 'Admin Panel' }} - {{ isset($settings) ? $settings->site_name : 'Monexa' }}</title>
    
    <!-- Favicon -->
    <link href="{{ (isset($settings) && $settings->favicon) ? asset('storage/' . $settings->favicon) : asset('favicon.ico') }}" rel="icon" type="image/x-icon" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Lucide Icons - Local fallback to avoid CDN issues -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" onerror="console.warn('Lucide CDN failed, using local fallback')"></script>
    
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        .hidden-initial { display: none !important; }
        
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
    @yield('styles')
</head>
<body class="bg-gray-50 dark:bg-admin-900 text-gray-900 dark:text-gray-100 antialiased hidden-initial" id="bodyElement">
    
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
        <aside class="sidebar-transition fixed inset-y-0 left-0 z-50 bg-white dark:bg-admin-800 shadow-elegant dark:shadow-glass-dark border-r border-admin-200 dark:border-admin-700 w-64 translate-x-0"
               id="sidebar">
            
            <!-- Sidebar Header -->
            <div class="h-20 flex items-center justify-between px-6 border-b border-admin-200 dark:border-admin-700 bg-gradient-to-r from-primary-600 to-primary-700">
                <div class="flex items-center space-x-3" id="sidebarHeader">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                    </div>
                    <div class="text-white" id="sidebarHeaderText">
                        @php $adminUser = Auth::guard('admin')->user(); @endphp
                        <h2 class="text-lg font-bold truncate">{{ $adminUser?->firstName ?? 'Admin' }}</h2>
                        <p class="text-xs text-primary-100">{{ $adminUser?->type ?? 'User' }}</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="sidebar-nav flex-1 overflow-y-auto py-6 px-4" style="height: calc(100vh - 180px);" id="sidebarNav">
                
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-700 dark:hover:text-primary-300 transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300' : '' }}"
                   title="Kontrol Paneli">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform"></i>
                    <span class="font-medium">Kontrol Paneli</span>
                </a>

                @php $adminUser = Auth::guard('admin')->user(); @endphp
                @if ($adminUser && ($adminUser->type == 'Super Admin' || $adminUser->type == 'Admin'))
                
                <!-- Users Management -->
                <div class="mt-4" id="usersMenu">
                    <button onclick="toggleSubMenu('usersMenu')"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700/50 transition-all duration-200 group"
                            title="Kullanıcıları Yönet">
                        <div class="flex items-center">
                            <i data-lucide="users" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-emerald-500"></i>
                            <span class="font-medium">Kullanıcılar</span>
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" id="usersMenuChevron"></i>
                    </button>
                    
                    <div class="mt-2 ml-12 space-y-1" id="usersMenuContent" style="display: none;">
                        <a href="{{ route('manageusers') }}" class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                            Tüm Kullanıcılar
                        </a>
                    </div>
                </div>

                <!-- Financial Management -->
                <div class="mt-6">
                    <div class="px-4 mb-3">
                        <span class="text-xs font-semibold text-admin-400 dark:text-admin-500 uppercase tracking-wider">Finans Yönetimi</span>
                    </div>
                    
                    <a href="{{ route('mdeposits') }}" 
                       class="flex items-center px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-700 dark:hover:text-emerald-300 transition-all duration-200 group {{ request()->routeIs('mdeposits') ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' : '' }}"
                       title="Yatırımları Yönet">
                        <i data-lucide="trending-up" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-emerald-500"></i>
                        <span class="font-medium">Yatırımlar</span>
                    </a>

                    <a href="{{ route('mwithdrawals') }}" 
                       class="flex items-center px-4 py-3 mt-1 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-rose-50 dark:hover:bg-rose-900/20 hover:text-rose-700 dark:hover:text-rose-300 transition-all duration-200 group {{ request()->routeIs('mwithdrawals') ? 'bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300' : '' }}"
                       title="Çekimleri Yönet">
                        <i data-lucide="trending-down" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-rose-500"></i>
                        <span class="font-medium">Çekimler</span>
                    </a>
                </div>

                <!-- Business Management -->
                <div class="mt-6">
                    <div class="px-4 mb-3">
                        <span class="text-xs font-semibold text-admin-400 dark:text-admin-500 uppercase tracking-wider">İş Yönetimi</span>
                    </div>

                    <a href="{{ route('emailservices') }}"
                       class="flex items-center px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-700 dark:hover:text-blue-300 transition-all duration-200 group {{ request()->routeIs('emailservices') ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : '' }}"
                       title="E-posta Servisleri">
                        <i data-lucide="mail" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-blue-500"></i>
                        <span class="font-medium">E-posta Servisleri</span>
                    </a>

                    <a href="{{ route('kyc') }}"
                       class="flex items-center px-4 py-3 mt-1 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-teal-50 dark:hover:bg-teal-900/20 hover:text-teal-700 dark:hover:text-teal-300 transition-all duration-200 group {{ request()->routeIs('kyc') ? 'bg-teal-100 dark:bg-teal-900/30 text-teal-700 dark:text-teal-300' : '' }}"
                       title="KYC Başvuruları">
                        <i data-lucide="user-check" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-teal-500"></i>
                        <span class="font-medium">KYC Başvuruları</span>
                    </a>

                    <a href="{{ route('admin.trades.index') }}"
                       class="flex items-center px-4 py-3 mt-1 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-violet-50 dark:hover:bg-violet-900/20 hover:text-violet-700 dark:hover:text-violet-300 transition-all duration-200 group {{ request()->routeIs('admin.trades.index') ? 'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300' : '' }}"
                       title="İşlem Yönetimi">
                        <i data-lucide="trending-up" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-violet-500"></i>
                        <span class="font-medium">İşlem Yönetimi</span>
                    </a>

                    <a href="{{ route('admin.leads.index') }}"
                       class="flex items-center px-4 py-3 mt-1 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-amber-50 dark:hover:bg-amber-900/20 hover:text-amber-700 dark:hover:text-amber-300 transition-all duration-200 group {{ request()->routeIs('admin.leads.index') ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300' : '' }}"
                       title="Müşteri Adayları">
                        <i data-lucide="users" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-amber-500"></i>
                        <span class="font-medium">Müşteri Adayları</span>
                    </a>
                </div>

                <!-- Content Management -->
                <div class="mt-6">
                    <div class="px-4 mb-3">
                        <span class="text-xs font-semibold text-admin-400 dark:text-admin-500 uppercase tracking-wider">İçerik Yönetimi</span>
                    </div>
                    
                    <a href="{{ route('admin.phrases') }}"
                       class="flex items-center px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-pink-50 dark:hover:bg-pink-900/20 hover:text-pink-700 dark:hover:text-pink-300 transition-all duration-200 group {{ request()->routeIs('admin.phrases') ? 'bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-300' : '' }}"
                       title="Dil/Cümleler">
                        <i data-lucide="languages" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-pink-500"></i>
                        <span class="font-medium">Dil/Cümleler</span>
                    </a>
                </div>

                @endif

                <!-- Tasks Management -->
                <div class="mt-6" id="tasksMenu">
                    <button onclick="toggleSubMenu('tasksMenu')"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-slate-50 dark:hover:bg-slate-900/20 hover:text-slate-700 dark:hover:text-slate-300 transition-all duration-200 group"
                            title="Görevler">
                        <div class="flex items-center">
                            <i data-lucide="list-checks" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-slate-500"></i>
                            <span class="font-medium">Görevler</span>
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" id="tasksMenuChevron"></i>
                    </button>
                    
                    <div class="mt-2 ml-12 space-y-1" id="tasksMenuContent" style="display: none;">
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
                
                <!-- Advanced Admin Management -->
                <div class="mt-4" id="managersMenu">
                    <button onclick="toggleSubMenu('managersMenu')"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 dark:hover:text-red-300 transition-all duration-200 group {{ request()->routeIs('admin.managers.*') ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' : '' }}"
                            title="Yöneticiler">
                        <div class="flex items-center">
                            <i data-lucide="user-cog" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-red-500"></i>
                            <span class="font-medium">Yöneticiler</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            @php
                                $totalManagers = \App\Models\Admin::where('type', '!=', 'Super Admin')->count();
                                $activeManagers = \App\Models\Admin::where('type', '!=', 'Super Admin')->where('status', 1)->count();
                            @endphp
                            <span class="text-xs bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 px-2 py-0.5 rounded-full font-medium">{{ $activeManagers }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" id="managersMenuChevron"></i>
                        </div>
                    </button>
                    
                    <div class="mt-2 ml-12 space-y-1" id="managersMenuContent" style="display: none;">
                        <a href="{{ route('admin.managers.index') }}"
                           class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors flex items-center justify-between group {{ request()->routeIs('admin.managers.index') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300' : '' }}">
                            <span>Yöneticiler Listesi</span>
                            <i data-lucide="list" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </a>
                        <a href="{{ route('admin.managers.create') }}"
                           class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-lg transition-colors flex items-center justify-between group {{ request()->routeIs('admin.managers.create') ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300' : '' }}">
                            <span>Yönetici Ekle</span>
                            <i data-lucide="user-plus" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </a>
                        <a href="{{ route('admin.hierarchy.index') }}"
                           class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-violet-600 dark:hover:text-violet-400 hover:bg-violet-50 dark:hover:bg-violet-900/20 rounded-lg transition-colors flex items-center justify-between group {{ request()->routeIs('admin.hierarchy.*') ? 'bg-violet-50 dark:bg-violet-900/20 text-violet-700 dark:text-violet-300' : '' }}">
                            <span>Hiyerarşi Görünümü</span>
                            <i data-lucide="git-branch" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </a>
                        
                        <!-- Legacy Routes (Backward Compatibility) -->
                        <div class="pt-2 border-t border-admin-200 dark:border-admin-700 mt-2">
                            <p class="text-xs text-admin-400 dark:text-admin-500 px-4 mb-1 font-medium">Eski Sistem</p>
                            <a href="{{ url('/admin/dashboard/addmanager') }}" class="block px-4 py-2 text-sm text-admin-500 dark:text-admin-500 hover:text-admin-600 dark:hover:text-admin-400 hover:bg-admin-50 dark:hover:bg-admin-800 rounded-lg transition-colors">
                                Eski Yönetici Ekle
                            </a>
                            <a href="{{ route('admin.managers.index') }}" class="block px-4 py-2 text-sm text-admin-500 dark:text-admin-500 hover:text-admin-600 dark:hover:text-admin-400 hover:bg-admin-50 dark:hover:bg-admin-800 rounded-lg transition-colors">
                                Eski Yöneticiler (Modern)
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Permissions & Roles Management -->
                <div class="mt-4" id="permissionsMenu">
                    <button onclick="toggleSubMenu('permissionsMenu')"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-700 dark:hover:text-indigo-300 transition-all duration-200 group {{ request()->routeIs('admin.permissions.*') || request()->routeIs('admin.roles.*') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300' : '' }}"
                            title="Yetkiler & Roller">
                        <div class="flex items-center">
                            <i data-lucide="shield-check" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-indigo-500"></i>
                            <span class="font-medium">Yetkiler & Roller</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            @php
                                $totalRoles = \App\Models\Role::count();
                                $totalPermissions = \App\Models\Permission::count();
                            @endphp
                            <span class="text-xs bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 px-2 py-0.5 rounded-full font-medium">{{ $totalRoles }}/{{ $totalPermissions }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" id="permissionsMenuChevron"></i>
                        </div>
                    </button>
                    
                    <div class="mt-2 ml-12 space-y-1" id="permissionsMenuContent" style="display: none;">
                        <a href="{{ route('admin.permissions.index') }}"
                           class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-colors flex items-center justify-between group {{ request()->routeIs('admin.permissions.index') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300' : '' }}">
                            <span>İzinler Matrisi</span>
                            <i data-lucide="grid-3x3" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </a>
                        <a href="{{ route('admin.roles.index') }}"
                           class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-purple-600 dark:hover:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-lg transition-colors flex items-center justify-between group {{ request()->routeIs('admin.roles.*') ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300' : '' }}">
                            <span>Rol Yönetimi</span>
                            <i data-lucide="users" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </a>
                        <a href="{{ route('admin.permissions.audit-log') }}"
                           class="block px-4 py-2 text-sm text-admin-600 dark:text-admin-400 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-lg transition-colors flex items-center justify-between group">
                            <span>İzin Geçmişi</span>
                            <i data-lucide="history" class="w-3 h-3 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </a>
                    </div>
                </div>

                <!-- Super Admin Settings -->
                <div class="mt-8 pt-6 border-t border-admin-200 dark:border-admin-700">
                    <div class="px-4 mb-3">
                        <span class="text-xs font-semibold text-admin-400 dark:text-admin-500 uppercase tracking-wider">Sistem Yönetimi</span>
                    </div>
                    
                    <!-- System Settings Menu -->
                    <a href="{{ route('appsettingshow') }}"
                       class="flex items-center px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-orange-50 dark:hover:bg-orange-900/20 hover:text-orange-700 dark:hover:text-orange-300 transition-all duration-200 group {{ request()->routeIs('appsettingshow') ? 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }}"
                       title="Sistem Ayarları">
                        <i data-lucide="server" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-orange-500"></i>
                        <span class="font-medium">Sistem Ayarları</span>
                    </a>

                    <!-- Settings Dropdown -->
                    <div class="mt-4" id="settingsMenu">
                        <button onclick="toggleSubMenu('settingsMenu')"
                                class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-admin-700 dark:text-admin-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 hover:text-purple-700 dark:hover:text-purple-300 transition-all duration-200 group"
                                title="Diğer Ayarlar">
                            <div class="flex items-center">
                                <i data-lucide="settings" class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform text-purple-500"></i>
                                <span class="font-medium">Diğer Ayarlar</span>
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" id="settingsMenuChevron"></i>
                        </button>
                        
                        <div class="mt-2 ml-12 space-y-1" id="settingsMenuContent" style="display: none;">
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
                <div class="flex items-center justify-center space-x-2" id="sidebarFooterControls">
                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleDarkMode()"
                            class="p-2 rounded-lg bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 transition-colors"
                            id="darkModeToggle" title="Tema Değiştir">
                        <i data-lucide="sun" class="w-4 h-4" id="sunIcon"></i>
                        <i data-lucide="moon" class="w-4 h-4" id="moonIcon" style="display: none;"></i>
                    </button>
                    
                    <!-- Collapse Toggle (Desktop Only) -->
                    <button onclick="toggleSidebarCollapse()"
                            class="hidden lg:block p-2 rounded-lg bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 transition-colors"
                            id="collapseToggle" title="Daralt">
                        <i data-lucide="panel-left" class="w-4 h-4" id="panelLeftIcon"></i>
                        <i data-lucide="panel-right" class="w-4 h-4" id="panelRightIcon" style="display: none;"></i>
                    </button>
                </div>
                
                <div class="mt-3 text-center" id="sidebarFooterText">
                    <p class="text-xs text-admin-500">{{ isset($settings) ? $settings->site_name : 'Admin Panel' }}</p>
                    <p class="text-xs text-admin-400">© {{ date('Y') }}</p>
                </div>
            </div>

        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div id="mobileOverlay" onclick="closeMobileSidebar()"
             class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden transition-opacity ease-linear duration-300 opacity-0"
             style="display: none;"></div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden sidebar-transition lg:ml-64" id="mainContent">

            <!-- Top Navigation -->
            <header class="h-20 bg-white dark:bg-admin-800 shadow-sm dark:shadow-glass-dark border-b border-admin-200 dark:border-admin-700 flex items-center justify-between px-6">
                
                <!-- Left Side -->
                <div class="flex items-center space-x-4">
                    <!-- Mobile Menu Button -->
                    <button onclick="toggleMobileSidebar()"
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
                               onclick="window.location.href='{{ route('manageusers') }}';">
                    </div>

                    <!-- Notifications -->
                    <div class="relative" id="notificationsDropdown">
                        <button onclick="toggleNotificationsDropdown()"
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
                        <div id="notificationsDropdownContent"
                             class="absolute right-0 mt-2 w-80 bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 max-h-96 overflow-hidden z-50 transition opacity-0"
                             style="display: none;">
                            
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
                    <div class="relative" id="profileDropdown">
                        <button onclick="toggleProfileDropdown()"
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
                        <div id="profileDropdownContent"
                             class="absolute right-0 mt-2 w-56 bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 z-50 transition opacity-0"
                             style="display: none;">
                            
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
        // Admin Layout State Management
        let adminState = {
            darkMode: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
            sidebarOpen: false,
            sidebarCollapsed: localStorage.getItem('sidebar-collapsed') === 'true',
            notificationsOpen: false,
            profileOpen: false,
            openMenus: {}
        };

        // Initialize admin layout
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Lucide Icons
            lucide.createIcons();
            
            // Apply initial theme
            applyTheme();
            
            // Apply initial sidebar state
            applySidebarState();
            
            // Hide loading screen
            const loadingScreen = document.getElementById('loading-screen');
            if (loadingScreen) {
                setTimeout(() => {
                    loadingScreen.style.opacity = '0';
                    setTimeout(() => {
                        loadingScreen.style.display = 'none';
                        document.getElementById('bodyElement').classList.remove('hidden-initial');
                    }, 300);
                }, 500);
            }
            
            // Add click outside listeners
            addClickOutsideListeners();
            
            console.log('Admin layout initialized');
        });

        // Apply theme
        function applyTheme() {
            const htmlRoot = document.getElementById('htmlRoot');
            const sunIcon = document.getElementById('sunIcon');
            const moonIcon = document.getElementById('moonIcon');
            
            if (adminState.darkMode) {
                htmlRoot.classList.add('dark');
                if (sunIcon) sunIcon.style.display = 'block';
                if (moonIcon) moonIcon.style.display = 'none';
            } else {
                htmlRoot.classList.remove('dark');
                if (sunIcon) sunIcon.style.display = 'none';
                if (moonIcon) moonIcon.style.display = 'block';
            }
        }

        // Apply sidebar state
        function applySidebarState() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarHeader = document.getElementById('sidebarHeader');
            const sidebarHeaderText = document.getElementById('sidebarHeaderText');
            const sidebarFooterControls = document.getElementById('sidebarFooterControls');
            const sidebarFooterText = document.getElementById('sidebarFooterText');
            const panelLeftIcon = document.getElementById('panelLeftIcon');
            const panelRightIcon = document.getElementById('panelRightIcon');
            const collapseToggle = document.getElementById('collapseToggle');
            
            if (adminState.sidebarCollapsed) {
                // Collapsed state
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                mainContent.classList.remove('lg:ml-64');
                mainContent.classList.add('lg:ml-20');
                
                if (sidebarHeader) {
                    sidebarHeader.classList.add('justify-center', 'w-full');
                }
                if (sidebarHeaderText) {
                    sidebarHeaderText.style.display = 'none';
                }
                if (sidebarFooterControls) {
                    sidebarFooterControls.classList.add('flex-col', 'space-y-2');
                    sidebarFooterControls.classList.remove('space-x-2');
                }
                if (sidebarFooterText) {
                    sidebarFooterText.style.display = 'none';
                }
                if (panelLeftIcon) panelLeftIcon.style.display = 'none';
                if (panelRightIcon) panelRightIcon.style.display = 'block';
                if (collapseToggle) collapseToggle.title = 'Genişlet';
                
                // Hide all menu text and chevrons
                updateMenuTextVisibility(false);
            } else {
                // Expanded state
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');
                mainContent.classList.remove('lg:ml-20');
                mainContent.classList.add('lg:ml-64');
                
                if (sidebarHeader) {
                    sidebarHeader.classList.remove('justify-center', 'w-full');
                }
                if (sidebarHeaderText) {
                    sidebarHeaderText.style.display = 'block';
                }
                if (sidebarFooterControls) {
                    sidebarFooterControls.classList.remove('flex-col', 'space-y-2');
                    sidebarFooterControls.classList.add('space-x-2');
                }
                if (sidebarFooterText) {
                    sidebarFooterText.style.display = 'block';
                }
                if (panelLeftIcon) panelLeftIcon.style.display = 'block';
                if (panelRightIcon) panelRightIcon.style.display = 'none';
                if (collapseToggle) collapseToggle.title = 'Daralt';
                
                // Show all menu text and chevrons
                updateMenuTextVisibility(true);
            }
            
            // Re-initialize Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }

        // Update menu text visibility
        function updateMenuTextVisibility(show) {
            const menuSpans = document.querySelectorAll('#sidebarNav span.font-medium');
            const sectionTitles = document.querySelectorAll('#sidebarNav span.text-xs.font-semibold');
            const chevrons = document.querySelectorAll('#sidebarNav i[id$="MenuChevron"]');
            
            menuSpans.forEach(span => {
                span.style.display = show ? 'block' : 'none';
            });
            
            sectionTitles.forEach(title => {
                title.style.display = show ? 'block' : 'none';
            });
            
            chevrons.forEach(chevron => {
                chevron.style.display = show ? 'block' : 'none';
            });
            
            // Also hide menu contents if collapsed
            if (!show) {
                Object.keys(adminState.openMenus).forEach(menuId => {
                    const content = document.getElementById(menuId + 'Content');
                    if (content) {
                        content.style.display = 'none';
                        adminState.openMenus[menuId] = false;
                    }
                });
            }
        }

        // Toggle dark mode
        function toggleDarkMode() {
            adminState.darkMode = !adminState.darkMode;
            localStorage.setItem('theme', adminState.darkMode ? 'dark' : 'light');
            applyTheme();
        }

        // Toggle sidebar collapse
        function toggleSidebarCollapse() {
            adminState.sidebarCollapsed = !adminState.sidebarCollapsed;
            localStorage.setItem('sidebar-collapsed', adminState.sidebarCollapsed.toString());
            applySidebarState();
        }

        // Toggle mobile sidebar
        function toggleMobileSidebar() {
            adminState.sidebarOpen = !adminState.sidebarOpen;
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            
            if (window.innerWidth < 1024) {
                if (adminState.sidebarOpen) {
                    // Show sidebar and overlay
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                    overlay.style.display = 'block';
                    setTimeout(() => {
                        overlay.classList.remove('opacity-0');
                        overlay.classList.add('opacity-100');
                    }, 10);
                } else {
                    // Hide sidebar and overlay
                    sidebar.classList.remove('translate-x-0');
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.remove('opacity-100');
                    overlay.classList.add('opacity-0');
                    setTimeout(() => {
                        overlay.style.display = 'none';
                    }, 300);
                }
            }
        }

        // Close mobile sidebar
        function closeMobileSidebar() {
            if (adminState.sidebarOpen && window.innerWidth < 1024) {
                adminState.sidebarOpen = false;
                toggleMobileSidebar();
            }
        }

        // Toggle submenu
        function toggleSubMenu(menuId) {
            if (adminState.sidebarCollapsed) return; // Don't open menus when collapsed
            
            const isOpen = adminState.openMenus[menuId] || false;
            adminState.openMenus[menuId] = !isOpen;
            
            const content = document.getElementById(menuId + 'Content');
            const chevron = document.getElementById(menuId + 'Chevron');
            
            if (content && chevron) {
                if (adminState.openMenus[menuId]) {
                    // Show menu
                    content.style.display = 'block';
                    chevron.classList.add('rotate-180');
                } else {
                    // Hide menu
                    content.style.display = 'none';
                    chevron.classList.remove('rotate-180');
                }
            }
        }

        // Toggle notifications dropdown
        function toggleNotificationsDropdown() {
            adminState.notificationsOpen = !adminState.notificationsOpen;
            const dropdown = document.getElementById('notificationsDropdownContent');
            
            if (dropdown) {
                if (adminState.notificationsOpen) {
                    dropdown.style.display = 'block';
                    setTimeout(() => {
                        dropdown.classList.remove('opacity-0');
                        dropdown.classList.add('opacity-100');
                    }, 10);
                } else {
                    dropdown.classList.remove('opacity-100');
                    dropdown.classList.add('opacity-0');
                    setTimeout(() => {
                        dropdown.style.display = 'none';
                    }, 150);
                }
            }
        }

        // Toggle profile dropdown
        function toggleProfileDropdown() {
            adminState.profileOpen = !adminState.profileOpen;
            const dropdown = document.getElementById('profileDropdownContent');
            
            if (dropdown) {
                if (adminState.profileOpen) {
                    dropdown.style.display = 'block';
                    setTimeout(() => {
                        dropdown.classList.remove('opacity-0');
                        dropdown.classList.add('opacity-100');
                    }, 10);
                } else {
                    dropdown.classList.remove('opacity-100');
                    dropdown.classList.add('opacity-0');
                    setTimeout(() => {
                        dropdown.style.display = 'none';
                    }, 150);
                }
            }
        }

        // Add click outside listeners
        function addClickOutsideListeners() {
            document.addEventListener('click', function(event) {
                // Close notifications dropdown
                const notificationsDropdown = document.getElementById('notificationsDropdown');
                const notificationsContent = document.getElementById('notificationsDropdownContent');
                if (adminState.notificationsOpen && notificationsDropdown && !notificationsDropdown.contains(event.target)) {
                    adminState.notificationsOpen = false;
                    if (notificationsContent) {
                        notificationsContent.classList.remove('opacity-100');
                        notificationsContent.classList.add('opacity-0');
                        setTimeout(() => {
                            notificationsContent.style.display = 'none';
                        }, 150);
                    }
                }
                
                // Close profile dropdown
                const profileDropdown = document.getElementById('profileDropdown');
                const profileContent = document.getElementById('profileDropdownContent');
                if (adminState.profileOpen && profileDropdown && !profileDropdown.contains(event.target)) {
                    adminState.profileOpen = false;
                    if (profileContent) {
                        profileContent.classList.remove('opacity-100');
                        profileContent.classList.add('opacity-0');
                        setTimeout(() => {
                            profileContent.style.display = 'none';
                        }, 150);
                    }
                }
            });
        }

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                // Close mobile sidebar on desktop
                if (adminState.sidebarOpen) {
                    adminState.sidebarOpen = false;
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('mobileOverlay');
                    
                    if (sidebar) {
                        sidebar.classList.remove('-translate-x-full');
                        sidebar.classList.add('translate-x-0');
                    }
                    if (overlay) {
                        overlay.style.display = 'none';
                    }
                }
            } else {
                // Handle mobile view
                if (!adminState.sidebarOpen) {
                    const sidebar = document.getElementById('sidebar');
                    if (sidebar) {
                        sidebar.classList.remove('translate-x-0');
                        sidebar.classList.add('-translate-x-full');
                    }
                }
            }
        });
    </script>

    <!-- Page Specific Scripts -->
    @stack('scripts')
    @yield('scripts')

    <!-- Application Scripts -->
    <!-- Already loaded by @vite directive above -->
</body>
</html>