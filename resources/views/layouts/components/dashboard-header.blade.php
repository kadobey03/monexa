<nav id="dashboard-nav" class="bg-white/98 dark:bg-gray-900/98 backdrop-blur-xl border-b border-gray-200/80 dark:border-gray-700/80 sticky top-0 z-50 shadow-sm">
    
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <!-- Left: Logo & Market Info -->
            <div class="flex items-center space-x-4">
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
                <div class="hidden md:block relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
                        <x-heroicon name="bolt" class="w-4 h-4" />
                        <span>Hızlı İşlem</span>
                        <x-heroicon name="chevron-down" class="w-4 h-4" />
                    </button>

                    <div x-show="open" @click.away="open = false"
                         class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-20">
                        <div class="p-2">
                            <a href="{{ route('deposits') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md">
                                <x-heroicon name="plus-circle" class="w-4 h-4 mr-3 text-green-500" />
                                Para Yatırma
                            </a>
                            <a href="{{ route('withdrawals') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-md">
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
                <button @click="toggleTheme()"
                        class="p-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
                    <x-heroicon name="sun" class="w-5 h-5" :class="{ 'hidden': isDarkMode }" />
                    <x-heroicon name="moon" class="w-5 h-5" :class="{ 'hidden': !isDarkMode }" />
                </button>

                <!-- User Profile -->
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
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

                        <div x-show="open" @click.away="open = false"
                             class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-20">
                            
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

                <!-- Mobile Menu Button -->
                <button @click="toggleMobileMenu()"
                        class="md:hidden p-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
                    <x-heroicon name="bars-3" class="w-5 h-5" />
                </button>
            </div>
        </div>
    </div>
</nav>