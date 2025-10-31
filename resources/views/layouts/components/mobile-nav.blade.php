<div class="fixed bottom-0 w-full z-30 md:hidden" id="mobile-nav">
    <!-- Bottom Navigation Bar -->
    <div class="flex justify-between items-center bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl px-6 py-4 shadow-[0_-8px_30px_rgba(0,0,0,0.15)] border-t border-gray-200/30 dark:border-gray-700/30">
        
        <a href="{{ route('dashboard') }}"
           class="group flex flex-col items-center relative">
            <div class="p-2 rounded-xl transition-all duration-300 ease-out
                        {{ request()->routeIs('dashboard') 
                           ? 'bg-blue-500/10 dark:bg-blue-400/10 scale-110' 
                           : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <i data-lucide="home" class="w-6 h-6
                    {{ request()->routeIs('dashboard')
                       ? 'text-blue-600 dark:text-blue-400'
                       : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
                    transition-colors duration-300"></i>
            </div>
            <span class="text-xs font-medium mt-1
                   {{ request()->routeIs('dashboard')
                      ? 'text-blue-600 dark:text-blue-400'
                      : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
                   transition-colors duration-300">Ana Sayfa</span>
        </a>

        <a href="{{ route('deposits') }}"
           class="group flex flex-col items-center relative">
            <div class="p-2 rounded-xl transition-all duration-300 ease-out
                        {{ request()->routeIs('deposits')
                           ? 'bg-blue-500/10 dark:bg-blue-400/10 scale-110'
                           : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <i data-lucide="plus-circle" class="w-6 h-6
                    {{ request()->routeIs('deposits')
                       ? 'text-blue-600 dark:text-blue-400'
                       : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
                    transition-colors duration-300"></i>
            </div>
            <span class="text-xs font-medium mt-1
                   {{ request()->routeIs('deposits')
                      ? 'text-blue-600 dark:text-blue-400'
                      : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
                   transition-colors duration-300">Para Yatır</span>
        </a>

        <a href="{{ route('trade.index') }}"
           class="group flex flex-col items-center relative">
            <div class="p-2 rounded-xl transition-all duration-300 ease-out
                        {{ request()->routeIs('trade.index')
                           ? 'bg-blue-500/10 dark:bg-blue-400/10 scale-110'
                           : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <i data-lucide="zap" class="w-6 h-6
                    {{ request()->routeIs('trade.index')
                       ? 'text-blue-600 dark:text-blue-400'
                       : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
                    transition-colors duration-300"></i>
            </div>
            <span class="text-xs font-medium mt-1
                   {{ request()->routeIs('trade.index')
                      ? 'text-blue-600 dark:text-blue-400'
                      : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
                   transition-colors duration-300">İşlem Aç</span>
        </a>

        <a href="{{ route('profile') }}"
           class="group flex flex-col items-center relative">
            <div class="p-2 rounded-xl transition-all duration-300 ease-out
                        {{ request()->routeIs('profile')
                           ? 'bg-blue-500/10 dark:bg-blue-400/10 scale-110'
                           : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                <i data-lucide="user" class="w-6 h-6
                    {{ request()->routeIs('profile')
                       ? 'text-blue-600 dark:text-blue-400'
                       : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
                    transition-colors duration-300"></i>
            </div>
            <span class="text-xs font-medium mt-1
                   {{ request()->routeIs('profile')
                      ? 'text-blue-600 dark:text-blue-400'
                      : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
                   transition-colors duration-300">Profil</span>
        </a>
    </div>
</div>