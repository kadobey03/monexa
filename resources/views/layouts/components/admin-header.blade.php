<header class="h-16 bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 flex items-center justify-between px-4 lg:px-6">
    <!-- Left Side -->
    <div class="flex items-center space-x-4">
        <!-- Mobile Menu Button -->
        <button @click="toggleSidebar()" 
                class="lg:hidden p-2 rounded-lg text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
            <x-heroicon name="bars-3" class="w-5 h-5" />
        </button>

        <!-- Page Title -->
        <div class="hidden sm:block">
            <h1 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $pageTitle ?? 'Dashboard' }}</h1>
        </div>
    </div>

    <!-- Right Side -->
    <div class="flex items-center space-x-3">
        
        <!-- Notifications -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open; toggleNotifications()"
                    class="relative p-2 rounded-lg text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <x-heroicon name="bell" class="w-5 h-5" />
                @php
                    $notificationCount = Auth::guard('admin')->user() ? 
                        \App\Models\Notification::where('admin_id', Auth::guard('admin')->user()->id)
                            ->where('is_read', 0)->count() : 0;
                @endphp
                @if($notificationCount > 0)
                    <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
                        {{ $notificationCount > 9 ? '9+' : $notificationCount }}
                    </span>
                @endif
            </button>

            <!-- Notifications Dropdown -->
            <div x-show="open" 
                 @click.away="open = false"
                 class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50"
                 x-transition>
                
                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Bildirimler</h3>
                </div>

                <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                    <x-heroicon name="bell" class="w-8 h-8 mx-auto mb-2 opacity-50" />
                    <p class="text-sm">Yeni bildirim yok</p>
                </div>
            </div>
        </div>

        <!-- Theme Toggle -->
        <button @click="toggleTheme()"
                class="p-2 rounded-lg text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
            <x-heroicon name="sun" class="w-5 h-5" :class="{ 'hidden': isDarkMode }" />
            <x-heroicon name="moon" class="w-5 h-5" :class="{ 'hidden': !isDarkMode }" />
        </button>

        <!-- Profile Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                    class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-medium">
                    {{ substr(Auth::guard('admin')->user()?->firstName ?? 'A', 0, 1) }}
                </div>
                <div class="hidden sm:block text-left">
                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ Auth::guard('admin')->user()?->firstName ?? 'Admin' }}</div>
                    <div class="text-xs text-gray-500">{{ Auth::guard('admin')->user()?->type ?? 'User' }}</div>
                </div>
                <x-heroicon name="chevron-down" class="w-4 h-4 text-gray-400" />
            </button>

            <!-- Profile Dropdown Menu -->
            <div x-show="open" 
                 @click.away="open = false"
                 class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50"
                 x-transition>
                
                <div class="p-2">
                    <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <x-heroicon name="user-cog" class="w-4 h-4 mr-3" />
                        Hesap Ayarları
                    </a>
                    <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                    <form action="{{ route('adminlogout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                            <x-heroicon name="arrow-left-on-rectangle" class="w-4 h-4 mr-3" />
                            Çıkış Yap
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>