{{-- Modern Dashboard Header with Fintech Theme --}}
@php
    // Bildirim verilerini al
    $notifications = collect();
    $unreadCount = 0;
    
    if (auth()->check()) {
        $notifications = auth()->user()->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $unreadCount = auth()->user()->notifications()->unread()->count();
    }
@endphp

<nav id="dashboard-nav" class="bg-gradient-to-r from-slate-900/95 via-slate-800/95 to-slate-900/95 dark:from-gray-900/95 dark:via-gray-800/95 dark:to-gray-900/95 backdrop-blur-xl sticky top-0 z-50 shadow-lg">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-14 lg:h-16">
            
            <!-- Left: Sidebar Toggle & Logo -->
            <div class="flex items-center space-x-4">
                <!-- Sidebar Toggle Button -->
                <button onclick="toggleDashboardSidebar()"
                        class="group p-2 text-slate-300 dark:text-gray-300 hover:text-white hover:bg-gradient-to-r hover:from-blue-600/20 hover:to-purple-600/20 rounded-xl transition-all duration-200 md:hidden">
                    <x-heroicon name="bars-3" class="w-5 h-5 group-hover:scale-110 transition-transform duration-200" />
                </button>
                
                <!-- Logo & Brand -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 group">
                    <div class="relative">
                        @isset($settings)
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300">
                                <img src="{{ asset('storage/'.$settings->logo) }}" class="h-4 w-auto" alt="Logo" />
                            </div>
                        @else
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300">
                                <x-heroicon name="currency-dollar" class="w-4 h-4 text-white" />
                            </div>
                        @endisset
                        <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 rounded-full animate-pulse"></div>
                    </div>
                    <div class="block sm:hidden">
                        <h1 class="text-base font-bold text-white group-hover:text-blue-300 transition-colors duration-200">
                            @isset($settings)
                                {{ $settings->site_name }}
                            @else
                                Monexa
                            @endisset
                        </h1>
                    </div>
                </a>
            </div>

            <!-- Center: Market Status & Balance -->
            @auth
                <div class="hidden lg:flex items-center space-x-4">
                    <!-- Live Market Status -->
                    <div class="flex items-center space-x-2 px-3 py-1.5 bg-gradient-to-r from-emerald-600/10 to-green-600/10 rounded-xl">
                        <div class="flex items-center space-x-1.5">
                            <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></div>
                            <span class="text-xs font-medium text-emerald-300">Piyasa Açık</span>
                        </div>
                        <div class="w-px h-3 bg-emerald-500/30"></div>
                        <div class="text-xs text-slate-300">
                            <span class="text-emerald-400">BTC</span> $67,234
                        </div>
                    </div>

                    <!-- Account Balance Card -->
                    <div class="bg-gradient-to-r from-blue-600/10 via-purple-600/10 to-blue-600/10 px-4 py-2 rounded-xl backdrop-blur-sm">
                        <div class="flex items-center space-x-2">
                            <div class="w-6 h-6 rounded-xl bg-gradient-to-br from-blue-500/20 to-purple-600/20 flex items-center justify-center">
                                <x-heroicon name="wallet" class="w-3 h-3 text-blue-400" />
                            </div>
                            <div>
                                <div class="text-xs text-slate-400 uppercase tracking-wider font-medium">Hesap Bakiyesi</div>
                                <div class="text-sm font-bold text-white">
                                    {{ auth()->user()->currency }}{{ number_format(auth()->user()->account_bal, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth

            <!-- Right: Actions & User -->
            <div class="flex items-center space-x-2 lg:space-x-3">
                
                <!-- Notifications -->
                @auth
                    <div class="relative">
                        <button onclick="toggleNotifications()"
                                class="group relative p-2 text-slate-300 dark:text-gray-300 hover:text-white hover:bg-gradient-to-r hover:from-yellow-600/20 hover:to-orange-600/20 rounded-xl transition-all duration-200">
                            <x-heroicon name="bell" class="w-5 h-5 group-hover:scale-110 transition-transform duration-200" />
                            @if($unreadCount > 0)
                                <div class="absolute -top-1 -right-1 min-w-[18px] h-[18px] bg-gradient-to-r from-red-500 to-pink-500 rounded-full flex items-center justify-center shadow-lg">
                                    <span class="text-xs font-bold text-white px-1">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
                                </div>
                            @endif
                        </button>

                        <div id="notificationsDropdown" class="hidden absolute right-0 mt-2 w-96 max-w-[calc(100vw-2rem)] bg-gradient-to-b from-slate-800 to-slate-900 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-2xl backdrop-blur-xl z-30 overflow-hidden">
                            <!-- Header -->
                            <div class="p-4 bg-gradient-to-r from-slate-700/50 to-slate-600/50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <x-heroicon name="bell" class="w-5 h-5 text-yellow-400" />
                                        <h3 class="text-lg font-semibold text-white">Bildirimler</h3>
                                        @if($unreadCount > 0)
                                            <span class="px-2 py-0.5 text-xs font-medium bg-red-500 text-white rounded-full">{{ $unreadCount }}</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if($unreadCount > 0)
                                            <button onclick="markAllAsRead()"
                                                    class="text-xs text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                                Hepsini Okundu İşaretle
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Notifications List -->
                            <div class="max-h-80 overflow-y-auto scrollbar-thin scrollbar-thumb-slate-600 scrollbar-track-slate-800">
                                @forelse($notifications as $notification)
                                    <div class="p-4 hover:bg-slate-700/30 transition-colors duration-200 {{ !$notification->is_read ? 'bg-blue-600/5 border-l-4 border-blue-500' : '' }}">
                                        <div class="flex items-start space-x-3">
                                            <!-- Notification Icon -->
                                            <div class="flex-shrink-0 mt-1">
                                                @php
                                                    $iconConfig = [
                                                        'deposit' => ['icon' => 'arrow-down-circle', 'color' => 'text-emerald-400', 'bg' => 'bg-emerald-500/20'],
                                                        'withdrawal' => ['icon' => 'arrow-up-circle', 'color' => 'text-red-400', 'bg' => 'bg-red-500/20'],
                                                        'plan_purchase' => ['icon' => 'chart-bar', 'color' => 'text-blue-400', 'bg' => 'bg-blue-500/20'],
                                                        'bot_purchase' => ['icon' => 'cpu-chip', 'color' => 'text-purple-400', 'bg' => 'bg-purple-500/20'],
                                                        'profit' => ['icon' => 'currency-dollar', 'color' => 'text-yellow-400', 'bg' => 'bg-yellow-500/20'],
                                                        'admin_message' => ['icon' => 'megaphone', 'color' => 'text-indigo-400', 'bg' => 'bg-indigo-500/20'],
                                                        'login' => ['icon' => 'shield-check', 'color' => 'text-cyan-400', 'bg' => 'bg-cyan-500/20'],
                                                    ];
                                                    $config = $iconConfig[$notification->type] ?? $iconConfig['admin_message'];
                                                @endphp
                                                <div class="w-8 h-8 rounded-xl {{ $config['bg'] }} flex items-center justify-center">
                                                    <x-heroicon name="{{ $config['icon'] }}" class="w-4 h-4 {{ $config['color'] }}" />
                                                </div>
                                            </div>
                                            
                                            <!-- Notification Content -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between">
                                                    <h4 class="text-sm font-medium text-white truncate">{{ $notification->title }}</h4>
                                                    @if(!$notification->is_read)
                                                        <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 ml-2"></div>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-slate-300 mt-1 line-clamp-2">{{ $notification->message }}</p>
                                                <div class="flex items-center justify-between mt-2">
                                                    <span class="text-xs text-slate-400">{{ $notification->created_at->diffForHumans() }}</span>
                                                    @if(!$notification->is_read)
                                                        <button onclick="markAsRead({{ $notification->id }})"
                                                                class="text-xs text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                                            Okundu İşaretle
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-8 text-center">
                                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-700/50 flex items-center justify-center">
                                            <x-heroicon name="bell-slash" class="w-8 h-8 text-slate-400" />
                                        </div>
                                        <h3 class="text-sm font-medium text-slate-300 mb-1">Henüz bildirim yok</h3>
                                        <p class="text-xs text-slate-400">Yeni bildirimler burada görünecek</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Footer -->
                            @if($notifications->count() > 0)
                                <div class="p-3 bg-slate-700/30">
                                    <a href="#" onclick="showAllNotifications()"
                                       class="block w-full text-center text-sm text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                        Tüm Bildirimleri Görüntüle
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endauth

                <!-- Quick Actions Dropdown -->
                <div class="hidden md:block relative">
                    <button onclick="toggleQuickActions()"
                            class="group flex items-center space-x-1.5 px-3 py-2 text-sm font-medium text-slate-300 hover:text-white hover:bg-gradient-to-r hover:from-blue-600/20 hover:to-purple-600/20 rounded-xl transition-all duration-200">
                        <x-heroicon name="bolt" class="w-4 h-4 group-hover:scale-110 transition-transform duration-200" />
                        <span class="hidden lg:block">Hızlı İşlem</span>
                        <x-heroicon name="chevron-down" class="w-3 h-3 group-hover:rotate-180 transition-transform duration-200" />
                    </button>

                    <div id="quickActionsDropdown" class="hidden absolute right-0 mt-2 w-64 max-w-[calc(100vw-2rem)] bg-gradient-to-b from-slate-800 to-slate-900 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-2xl backdrop-blur-xl z-30">
                        <div class="p-2">
                            <a href="{{ route('deposits') }}" class="group flex items-center px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-gradient-to-r hover:from-emerald-600/20 hover:to-green-600/20 rounded-xl transition-all duration-200">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-500/20 to-green-600/20 flex items-center justify-center mr-3 group-hover:from-emerald-500/30 group-hover:to-green-600/30 transition-all duration-200">
                                    <x-heroicon name="arrow-down-circle" class="w-4 h-4 text-emerald-400" />
                                </div>
                                <div>
                                    <div class="font-medium">Para Yatırma</div>
                                    <div class="text-xs text-slate-400">Hesabınıza para ekleyin</div>
                                </div>
                            </a>
                            <a href="{{ route('withdrawalsdeposits') }}" class="group flex items-center px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-gradient-to-r hover:from-red-600/20 hover:to-pink-600/20 rounded-xl transition-all duration-200">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-red-500/20 to-pink-600/20 flex items-center justify-center mr-3 group-hover:from-red-500/30 group-hover:to-pink-600/30 transition-all duration-200">
                                    <x-heroicon name="arrow-up-circle" class="w-4 h-4 text-red-400" />
                                </div>
                                <div>
                                    <div class="font-medium">Para Çekme</div>
                                    <div class="text-xs text-slate-400">Kazançlarınızı çekin</div>
                                </div>
                            </a>
                            <a href="{{ route('trade.index') }}" class="group flex items-center px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-gradient-to-r hover:from-yellow-600/20 hover:to-orange-600/20 rounded-xl transition-all duration-200">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-yellow-500/20 to-orange-600/20 flex items-center justify-center mr-3 group-hover:from-yellow-500/30 group-hover:to-orange-600/30 transition-all duration-200">
                                    <x-heroicon name="bolt" class="w-4 h-4 text-yellow-400" />
                                </div>
                                <div>
                                    <div class="font-medium">Canlı İşlem</div>
                                    <div class="text-xs text-slate-400">Piyasada işlem yapın</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Dark Mode Toggle -->
                <button onclick="toggleTheme()"
                        class="group p-2 text-slate-300 dark:text-gray-300 hover:text-white hover:bg-gradient-to-r hover:from-indigo-600/20 hover:to-purple-600/20 rounded-xl transition-all duration-200">
                    <x-heroicon name="sun" class="w-4 h-4 group-hover:scale-110 group-hover:rotate-180 transition-all duration-300" id="sunIcon" />
                    <x-heroicon name="moon" class="w-4 h-4 hidden group-hover:scale-110 transition-all duration-300" id="moonIcon" />
                </button>

                <!-- User Profile -->
                @auth
                    <div class="relative">
                        <button onclick="toggleProfileDropdown()"
                                class="group flex items-center space-x-2 px-2 py-1.5 text-sm rounded-xl hover:bg-gradient-to-r hover:from-purple-600/20 hover:to-pink-600/20 transition-all duration-200">
                            <div class="relative">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-500 to-pink-600 flex items-center justify-center text-white text-xs font-bold shadow-lg ring-1 ring-purple-500/30 group-hover:ring-purple-400/50 transition-all duration-300">
                                    {{ Str::upper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 rounded-full border-2 border-slate-800 dark:border-gray-800"></div>
                            </div>
                            <div class="block sm:hidden text-left">
                                <div class="text-sm font-medium text-white group-hover:text-purple-200 transition-colors">
                                    {{ auth()->user()->name }}
                                </div>
                                <div class="text-xs text-slate-400 dark:text-gray-400">
                                    {{ Auth::user()->currency }}{{ number_format(auth()->user()->account_bal, 2) }}
                                </div>
                            </div>
                            <x-heroicon name="chevron-down" class="w-3 h-3 text-slate-400 group-hover:text-white group-hover:rotate-180 transition-all duration-200" />
                        </button>

                        <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-72 max-w-[calc(100vw-2rem)] bg-gradient-to-b from-slate-800 to-slate-900 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-2xl backdrop-blur-xl z-30">
                            
                            <!-- Profile Header -->
                            <div class="p-6 bg-gradient-to-r from-purple-600/10 to-pink-600/10 rounded-t-2xl">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        <div class="w-14 h-14 rounded-full bg-gradient-to-r from-purple-500 to-pink-600 flex items-center justify-center text-white text-xl font-bold shadow-lg ring-2 ring-purple-500/30">
                                            {{ Str::upper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-slate-800 dark:border-gray-800"></div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm font-semibold text-white">
                                            {{ auth()->user()->name }}
                                        </div>
                                        <div class="text-xs text-slate-400 mb-2">
                                            {{ auth()->user()->email }}
                                        </div>
                                        <div class="flex items-center space-x-1 px-2 py-1 bg-emerald-600/20 rounded-xl">
                                            <x-heroicon name="wallet" class="w-3 h-3 text-emerald-400" />
                                            <span class="text-xs font-medium text-emerald-300">
                                                {{ Auth::user()->currency }}{{ number_format(auth()->user()->account_bal, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Menu Items -->
                            <div class="p-2">
                                <a href="{{ route('profile') }}" class="group flex items-center px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-gradient-to-r hover:from-purple-600/20 hover:to-pink-600/20 rounded-xl transition-all duration-200">
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-purple-500/20 to-pink-600/20 flex items-center justify-center mr-3 group-hover:from-purple-500/30 group-hover:to-pink-600/30 transition-all duration-200">
                                        <x-heroicon name="user-circle" class="w-4 h-4 text-purple-400" />
                                    </div>
                                    Profil Ayarları
                                </a>
                                <a href="{{ route('accounthistory') }}" class="group flex items-center px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-gradient-to-r hover:from-blue-600/20 hover:to-indigo-600/20 rounded-xl transition-all duration-200">
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-500/20 to-indigo-600/20 flex items-center justify-center mr-3 group-hover:from-blue-500/30 group-hover:to-indigo-600/30 transition-all duration-200">
                                        <x-heroicon name="document-chart-bar" class="w-4 h-4 text-blue-400" />
                                    </div>
                                    Hesap Geçmişi
                                </a>
                                <a href="{{ route('support') }}" class="group flex items-center px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-gradient-to-r hover:from-cyan-600/20 hover:to-blue-600/20 rounded-xl transition-all duration-200">
                                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-cyan-500/20 to-blue-600/20 flex items-center justify-center mr-3 group-hover:from-cyan-500/30 group-hover:to-blue-600/30 transition-all duration-200">
                                        <x-heroicon name="chat-bubble-left-ellipsis" class="w-4 h-4 text-cyan-400" />
                                    </div>
                                    Destek Merkezi
                                </a>
                                
                                <div class="border-t border-slate-700/50 dark:border-gray-600 my-2"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="group w-full flex items-center px-4 py-3 text-sm text-red-400 hover:text-white hover:bg-gradient-to-r hover:from-red-600/20 hover:to-pink-600/20 rounded-xl transition-all duration-200">
                                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-red-500/20 to-pink-600/20 flex items-center justify-center mr-3 group-hover:from-red-500/30 group-hover:to-pink-600/30 transition-all duration-200">
                                            <x-heroicon name="arrow-right-on-rectangle" class="w-4 h-4 text-red-400" />
                                        </div>
                                        Güvenli Çıkış
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Enhanced Header JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quick Actions Dropdown
    window.toggleQuickActions = function() {
        const dropdown = document.getElementById('quickActionsDropdown');
        const otherDropdowns = ['profileDropdown', 'notificationsDropdown'];
        
        // Close other dropdowns
        otherDropdowns.forEach(id => {
            const element = document.getElementById(id);
            if (element) element.classList.add('hidden');
        });
        
        dropdown.classList.toggle('hidden');
    };

    // Profile Dropdown
    window.toggleProfileDropdown = function() {
        const dropdown = document.getElementById('profileDropdown');
        const otherDropdowns = ['quickActionsDropdown', 'notificationsDropdown'];
        
        // Close other dropdowns
        otherDropdowns.forEach(id => {
            const element = document.getElementById(id);
            if (element) element.classList.add('hidden');
        });
        
        dropdown.classList.toggle('hidden');
    };

    // Notifications Dropdown
    window.toggleNotifications = function() {
        const dropdown = document.getElementById('notificationsDropdown');
        const otherDropdowns = ['quickActionsDropdown', 'profileDropdown'];
        
        // Close other dropdowns
        otherDropdowns.forEach(id => {
            const element = document.getElementById(id);
            if (element) element.classList.add('hidden');
        });
        
        dropdown.classList.toggle('hidden');
    };

    // Enhanced Theme Toggle
    window.toggleTheme = function() {
        const html = document.documentElement;
        const sunIcon = document.getElementById('sunIcon');
        const moonIcon = document.getElementById('moonIcon');
        
        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.setItem('theme', 'light');
            sunIcon.classList.remove('hidden');
            moonIcon.classList.add('hidden');
        } else {
            html.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            sunIcon.classList.add('hidden');
            moonIcon.classList.remove('hidden');
        }
    };

    // Enhanced Dashboard Sidebar Toggle
    if (typeof window.toggleDashboardSidebar === 'undefined') {
        window.toggleDashboardSidebar = function() {
            const sidebar = document.getElementById('dashboard-sidebar');
            const overlay = document.getElementById('dashboard-sidebar-overlay');
            
            if (sidebar && overlay) {
                const isHidden = sidebar.classList.contains('-translate-x-full');
                
                if (isHidden) {
                    // Show sidebar with enhanced animation
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                    overlay.classList.remove('hidden');
                    overlay.classList.add('bg-black/70');
                    // Prevent body scroll on mobile
                    if (window.innerWidth < 768) {
                        document.body.style.overflow = 'hidden';
                    }
                } else {
                    // Hide sidebar with enhanced animation
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                    overlay.classList.add('hidden');
                    overlay.classList.remove('bg-black/70');
                    // Restore body scroll
                    document.body.style.overflow = '';
                }
            }
        };
    }

    // Enhanced click away functionality
    document.addEventListener('click', function(event) {
        const dropdowns = ['quickActionsDropdown', 'profileDropdown', 'notificationsDropdown'];
        const toggleButtons = [
            'button[onclick="toggleQuickActions()"]',
            'button[onclick="toggleProfileDropdown()"]',
            'button[onclick="toggleNotifications()"]'
        ];
        
        dropdowns.forEach((dropdownId, index) => {
            const dropdown = document.getElementById(dropdownId);
            const button = document.querySelector(toggleButtons[index]);
            
            if (dropdown && !dropdown.contains(event.target) && 
                (!button || !button.contains(event.target))) {
                dropdown.classList.add('hidden');
            }
        });
    });

    // Initialize theme on page load with enhanced animation
    const savedTheme = localStorage.getItem('theme') ||
        (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    
    const html = document.documentElement;
    const sunIcon = document.getElementById('sunIcon');
    const moonIcon = document.getElementById('moonIcon');
    
    if (savedTheme === 'dark') {
        html.classList.add('dark');
        if (sunIcon) sunIcon.classList.add('hidden');
        if (moonIcon) moonIcon.classList.remove('hidden');
    } else {
        html.classList.remove('dark');
        if (sunIcon) sunIcon.classList.remove('hidden');
        if (moonIcon) moonIcon.classList.add('hidden');
    }

    // Enhanced responsive behavior
    function handleResize() {
        if (window.innerWidth >= 768) {
            // Desktop: ensure body scroll is restored
            document.body.style.overflow = '';
            
            // Close all dropdowns on resize
            const dropdowns = ['quickActionsDropdown', 'profileDropdown', 'notificationsDropdown'];
            dropdowns.forEach(id => {
                const element = document.getElementById(id);
                if (element) element.classList.add('hidden');
            });
        }
    }
    
    window.addEventListener('resize', handleResize);
    
    // ESC key support for closing dropdowns
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const dropdowns = ['quickActionsDropdown', 'profileDropdown', 'notificationsDropdown'];
            dropdowns.forEach(id => {
                const element = document.getElementById(id);
                if (element) element.classList.add('hidden');
            });
        }
    });

    // Add smooth scroll behavior to dropdowns
    const dropdowns = document.querySelectorAll('[id$="Dropdown"]');
    dropdowns.forEach(dropdown => {
        if (dropdown) {
            dropdown.style.scrollBehavior = 'smooth';
        }
    });

    // Bildirim işlevleri
    window.markAsRead = function(notificationId) {
        fetch('/notifications/ajax/mark-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                notification_id: notificationId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // İlgili bildirimi okunmuş olarak işaretle
                const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notificationElement) {
                    notificationElement.classList.remove('bg-blue-50');
                    notificationElement.classList.add('bg-white');
                }
                
                // Sayacı güncelle
                const currentCount = parseInt(document.querySelector('#notification-count').textContent) || 0;
                if (currentCount > 0) {
                    updateNotificationCount(currentCount - 1);
                }
                
                console.log(data.message || 'Bildirim okundu olarak işaretlendi');
            } else {
                console.error('Hata:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    };

    window.markAllAsRead = function() {
        fetch('/notifications/ajax/mark-all-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Tüm bildirimleri okunmuş olarak işaretle
                document.querySelectorAll('.notification-item').forEach(item => {
                    item.classList.remove('bg-blue-50');
                    item.classList.add('bg-white');
                });
                
                // Sayacı sıfırla
                updateNotificationCount(0);
                
                console.log(data.message || 'Tüm bildirimler okundu olarak işaretlendi');
            } else {
                console.error('Hata:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    };

    window.showAllNotifications = function() {
        // Bildirimler sayfasına yönlendir
        window.location.href = '/notifications';
    };

    // Mobil uyumluluk için dropdown pozisyonlarını ayarla
    function adjustDropdownPositions() {
        const dropdowns = document.querySelectorAll('[id$="Dropdown"]');
        
        dropdowns.forEach(dropdown => {
            if (!dropdown.classList.contains('hidden')) {
                const rect = dropdown.getBoundingClientRect();
                const viewportWidth = window.innerWidth;
                
                // Eğer dropdown ekrandan taşıyorsa pozisyonunu ayarla
                if (rect.right > viewportWidth) {
                    dropdown.style.right = '0';
                    dropdown.style.left = 'auto';
                }
            }
        });
    }

    // Dropdown açılırken pozisyon ayarlaması yap
    const originalToggleFunctions = {
        toggleNotifications: window.toggleNotifications,
        toggleQuickActions: window.toggleQuickActions,
        toggleProfileDropdown: window.toggleProfileDropdown
    };

    window.toggleNotifications = function() {
        originalToggleFunctions.toggleNotifications();
        setTimeout(adjustDropdownPositions, 10);
    };

    window.toggleQuickActions = function() {
        originalToggleFunctions.toggleQuickActions();
        setTimeout(adjustDropdownPositions, 10);
    };

    window.toggleProfileDropdown = function() {
        originalToggleFunctions.toggleProfileDropdown();
        setTimeout(adjustDropdownPositions, 10);
    };

    // Pencere boyutu değiştiğinde dropdown pozisyonlarını ayarla
    window.addEventListener('resize', adjustDropdownPositions);
});
</script>