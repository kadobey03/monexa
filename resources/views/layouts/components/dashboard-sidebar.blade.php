<aside id="dashboard-sidebar"
       class="fixed z-50 md:z-40 top-0 left-0 w-72 h-full bg-white dark:bg-gray-900 shadow-xl transform transition-transform duration-300 ease-in-out md:translate-x-0 overflow-y-auto -translate-x-full">
    
    <!-- User Profile Section -->
    <div class="relative p-4 border-b border-gray-200 dark:border-gray-700">
        @auth
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 text-lg font-medium">
                    {{ Str::upper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                        {{ auth()->user()->name }}
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        Bakiye: {{ Auth::user()->currency }}{{ number_format(auth()->user()->account_bal, 2) }}
                    </p>
                </div>
            </div>
        @endauth
    </div>

    <!-- Navigation Menu -->
    <nav class="p-4 space-y-6 text-sm pb-20">
        <!-- Overview Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <x-heroicon name="squares-2x2" class="w-4 h-4" />
                <span>Genel Bakış</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('dashboard') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <x-heroicon name="squares-2x2" class="w-5 h-5 mr-3" />
                        Ana Sayfa
                    </a>
                </li>
                <li>
                    <a href="{{ route('accounthistory') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('accounthistory') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <x-heroicon name="receipt" class="w-5 h-5 mr-3" />
                        Hesap Özeti
                    </a>
                </li>
            </ul>
        </div>

        <!-- Wallet & Funds Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <x-heroicon name="wallet" class="w-4 h-4" />
                <span>Cüzdan ve Fonlar</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('deposits') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('deposits') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <x-heroicon name="plus-circle" class="w-5 h-5 mr-3" />
                        Para Yatırma
                    </a>
                </li>
                <li>
                    <a href="{{ route('withdrawals') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('withdrawals') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <x-heroicon name="minus-circle" class="w-5 h-5 mr-3" />
                        Para Çekme
                    </a>
                </li>
                <li>
                    <a href="{{ route('trade.index') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('trade.index') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <x-heroicon name="bolt" class="w-5 h-5 mr-3" />
                        İşlem Yap
                    </a>
                </li>
            </ul>
        </div>

        <!-- Account Management Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <x-heroicon name="user-circle" class="w-4 h-4" />
                <span>Hesap Yönetimi</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('profile') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('profile') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <x-heroicon name="user" class="w-5 h-5 mr-3" />
                        Profil Ayarları
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 dark:border-gray-700">
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center w-full px-3 py-2 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/50 transition-colors duration-150">
                    <x-heroicon name="arrow-left-on-rectangle" class="w-5 h-5 mr-3" />
                    <span>Çıkış Yap</span>
                </button>
            </form>
        @endauth
    </div>
</aside>

<!-- Mobile Overlay -->
<div id="dashboard-sidebar-overlay" 
     class="fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden">
</div>