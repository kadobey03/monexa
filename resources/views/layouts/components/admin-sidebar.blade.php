<aside class="fixed inset-y-0 left-0 z-50 bg-white dark:bg-gray-800 shadow-lg border-r border-gray-200 dark:border-gray-700 w-64 transform transition-transform duration-300 ease-in-out"
       :class="{ '-translate-x-full': !sidebarOpen && isMobile, 'translate-x-0': sidebarOpen || !isMobile }"
       id="admin-sidebar">
    
    <!-- Sidebar Header -->
    <div class="h-16 flex items-center justify-between px-4 border-b border-gray-200 dark:border-gray-700 bg-blue-600">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                <x-heroicon name="shield-check" class="w-5 h-5 text-white" />
            </div>
            <div class="text-white">
                <h2 class="text-sm font-bold truncate">{{ Auth::guard('admin')->user()?->firstName ?? 'Admin' }}</h2>
                <p class="text-xs text-blue-100">{{ Auth::guard('admin')->user()?->type ?? 'User' }}</p>
            </div>
        </div>
        
        <button @click="toggleSidebar()" 
                class="md:hidden p-1 rounded text-white hover:bg-white/20">
            <x-heroicon name="x-mark" class="w-5 h-5" />
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : '' }}">
            <x-heroicon name="squares-2x2" class="w-5 h-5 mr-3" />
            <span class="font-medium">Kontrol Paneli</span>
        </a>

        @php $adminUser = Auth::guard('admin')->user(); @endphp
        @if ($adminUser && in_array($adminUser->type, ['Super Admin', 'Admin']))
        
        <!-- Financial Management -->
        <div class="pt-4">
            <div class="px-3 mb-2">
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Finans Yönetimi</span>
            </div>
            
            <a href="{{ route('mdeposits') }}" 
               class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20 hover:text-green-600 dark:hover:text-green-400 transition-colors {{ request()->routeIs('mdeposits') ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : '' }}">
                <x-heroicon name="arrow-trending-up" class="w-5 h-5 mr-3" />
                <span class="font-medium">Yatırımlar</span>
            </a>

            <a href="{{ route('mwithdrawals') }}" 
               class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-400 transition-colors {{ request()->routeIs('mwithdrawals') ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' : '' }}">
                <x-heroicon name="arrow-trending-down" class="w-5 h-5 mr-3" />
                <span class="font-medium">Çekimler</span>
            </a>
        </div>

        <!-- Business Management -->
        <div class="pt-4">
            <div class="px-3 mb-2">
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">İş Yönetimi</span>
            </div>

            <a href="{{ route('kyc') }}"
               class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-teal-900/20 hover:text-teal-600 dark:hover:text-teal-400 transition-colors {{ request()->routeIs('kyc') ? 'bg-teal-100 dark:bg-teal-900/30 text-teal-700 dark:text-teal-300' : '' }}">
                <x-heroicon name="user-check" class="w-5 h-5 mr-3" />
                <span class="font-medium">KYC Başvuruları</span>
            </a>

        </div>

        @endif

        <!-- Settings -->
        <div class="pt-4">
            <div class="px-3 mb-2">
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sistem</span>
            </div>
            
            <a href="{{ route('appsettingshow') }}"
               class="flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-orange-50 dark:hover:bg-orange-900/20 hover:text-orange-600 dark:hover:text-orange-400 transition-colors {{ request()->routeIs('appsettingshow') ? 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300' : '' }}">
                <x-heroicon name="cog-6-tooth" class="w-5 h-5 mr-3" />
                <span class="font-medium">Sistem Ayarları</span>
            </a>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-center space-x-2">
            <button @click="toggleTheme()"
                    class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                <x-heroicon name="sun" class="w-4 h-4" />
                <x-heroicon name="moon" class="w-4 h-4 hidden" />
            </button>
        </div>
    </div>
</aside>

<!-- Mobile Overlay -->
<div x-show="sidebarOpen && isMobile" 
     @click="toggleSidebar()"
     class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
     x-transition>
</div>