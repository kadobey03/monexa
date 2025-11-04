<nav id="dashboard-nav" class="bg-white/98 dark:bg-gray-900/98 backdrop-blur-xl border-b border-gray-200/80 dark:border-gray-700/80 sticky top-0 z-50 shadow-sm">
    
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <!-- Left: Sidebar Toggle & Logo -->
            <div class="flex items-center space-x-4">
                <!-- Sidebar Toggle Button -->
                <button onclick="toggleDashboardSidebar()"
                        class="p-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200 md:hidden">
                    <x-heroicon name="bars-3" class="w-6 h-6" />
                </button>
                
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                    @isset($settings)
                        <img src="{{ asset('storage/'.$settings->logo) }}" class="h-8 w-auto" alt="Logo" />
                        <span class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            {{ $settings->site_name }}
                        </span>
                    @else
                        <div class="text-lg font-bold text-gray-900 dark:text-white">Monexa</div>
                    @endisset
                </a>
            </div>

            <!-- Center: Account Balance -->
            @auth
                <div class="hidden md:flex items-center space-x-6">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-4 py-2 rounded-lg border border-blue-100 dark:border-blue-800">
                        <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Hesap Bakiyesi</div>
                        <div class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ auth()->user()->currency }}{{ number_format(auth()->user()->account_bal, 2) }}
                        </div>
                    </div>
                </div>
            @endauth

            <!-- Right: Actions & User -->
            <div class="flex items-center space-x-3">
                
                <!-- Quick Actions Dropdown -->
                <div class="hidden md:block relative">
                    <button onclick="toggleQuickActions()"
                            class="flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
                        <x-heroicon name="bolt" class="w-4 h-4" />
                        <span>Hızlı İşlem</span>
                        <x-heroicon name="chevron-down" class="w-4 h-4" />
                    </button>

                    <div id="quickActionsDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-20">
                        <div class="p-2">
                            <a href="{{ route('deposits') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md">
                                <x-heroicon name="plus-circle" class="w-4 h-4 mr-3 text-green-500" />
                                Para Yatırma
                            </a>
                            <a href="{{ route('withdrawalsdeposits') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md">
                                <x-heroicon name="minus-circle" class="w-4 h-4 mr-3 text-red-500" />
                                Para Çekme
                            </a>
                            <a href="{{ route('trade.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md">
                                <x-heroicon name="arrow-trending-up" class="w-4 h-4 mr-3 text-blue-500" />
                                Piyasa İşlemleri
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Dark Mode Toggle -->
                <button onclick="toggleTheme()"
                        class="p-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
                    <x-heroicon name="sun" class="w-5 h-5" id="sunIcon" />
                    <x-heroicon name="moon" class="w-5 h-5 hidden" id="moonIcon" />
                </button>

                <!-- User Profile -->
                @auth
                    <div class="relative">
                        <button onclick="toggleProfileDropdown()"
                                class="flex items-center space-x-3 px-2 py-2 text-sm rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-all duration-200">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-medium">
                                {{ Str::upper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden sm:block text-left">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ auth()->user()->name }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    Ticaret Hesabı
                                </div>
                            </div>
                            <x-heroicon name="chevron-down" class="w-4 h-4 text-gray-400" />
                        </button>

                        <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-20">
                            
                            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white text-lg font-medium">
                                        {{ Str::upper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ auth()->user()->name }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ Auth::user()->currency }}{{ number_format(auth()->user()->account_bal, 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2">
                                <a href="{{ route('profile') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md">
                                    <x-heroicon name="user" class="w-4 h-4 mr-3" />
                                    Profil Ayarları
                                </a>
                                <a href="{{ route('accounthistory') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md">
                                    <x-heroicon name="receipt" class="w-4 h-4 mr-3" />
                                    Hesap Geçmişi
                                </a>
                                <a href="{{ route('support') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md">
                                    <x-heroicon name="question-mark-circle" class="w-4 h-4 mr-3" />
                                    Destek Merkezi
                                </a>
                                <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md">
                                        <x-heroicon name="arrow-left-on-rectangle" class="w-4 h-4 mr-3" />
                                        Çıkış Yap
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quick Actions Dropdown
    window.toggleQuickActions = function() {
        const dropdown = document.getElementById('quickActionsDropdown');
        dropdown.classList.toggle('hidden');
    };

    // Profile Dropdown
    window.toggleProfileDropdown = function() {
        const dropdown = document.getElementById('profileDropdown');
        dropdown.classList.toggle('hidden');
    };

    // Theme Toggle
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

    // Dashboard Sidebar Toggle (Ensure it's available globally)
    if (typeof window.toggleDashboardSidebar === 'undefined') {
        window.toggleDashboardSidebar = function() {
            const sidebar = document.getElementById('dashboard-sidebar');
            const overlay = document.getElementById('dashboard-sidebar-overlay');
            
            if (sidebar && overlay) {
                const isHidden = sidebar.classList.contains('-translate-x-full');
                
                if (isHidden) {
                    // Show sidebar
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                    overlay.classList.remove('hidden');
                    overlay.classList.add('bg-opacity-50');
                    // Prevent body scroll
                    document.body.style.overflow = 'hidden';
                } else {
                    // Hide sidebar
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                    overlay.classList.add('hidden');
                    overlay.classList.remove('bg-opacity-50');
                    // Restore body scroll
                    document.body.style.overflow = '';
                }
            }
        };
    }

    // Click away functionality
    document.addEventListener('click', function(event) {
        const quickActionsDropdown = document.getElementById('quickActionsDropdown');
        const profileDropdown = document.getElementById('profileDropdown');
        
        // Close quick actions dropdown if clicking outside
        if (quickActionsDropdown && !quickActionsDropdown.contains(event.target) &&
            !event.target.closest('button[onclick="toggleQuickActions()"]')) {
            quickActionsDropdown.classList.add('hidden');
        }
        
        // Close profile dropdown if clicking outside
        if (profileDropdown && !profileDropdown.contains(event.target) &&
            !event.target.closest('button[onclick="toggleProfileDropdown()"]')) {
            profileDropdown.classList.add('hidden');
        }
    });

    // Initialize theme on page load
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
});
</script>