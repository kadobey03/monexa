<header class="bg-gray-900 border-b border-gray-800 relative z-50">
    <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center">
                    @isset($settings)
                        <img class="h-8 w-auto" src="{{ asset('storage/'.$settings->logo) }}" alt="{{ $settings->site_name }}">
                        <span class="ml-3 text-lg font-semibold text-white">{{ $settings->site_name }}</span>
                    @else
                        <span class="text-lg font-semibold text-white">Monexa</span>
                    @endisset
                </a>
            </div>

            <!-- Main Navigation -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">{{ __('nav.home') }}</a>
                <a href="{{ route('cryptocurrencies') }}" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">{{ __('nav.crypto') }}</a>
                <a href="{{ route('forex') }}" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">{{ __('nav.forex') }}</a>
                <a href="{{ route('shares') }}" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">{{ __('nav.shares') }}</a>
                <a href="{{ route('about') }}" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">{{ __('nav.about') }}</a>
            </nav>

            <!-- Right Navigation -->
            <div class="hidden md:flex items-center space-x-4">
                <!-- Language Switcher (Modern Style) -->
                <div class="relative">
                    <button onclick="toggleLanguageDropdown()"
                            class="group flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-xl transition-all duration-200">
                        <x-heroicon name="language" class="w-4 h-4 group-hover:scale-110 transition-transform duration-200" />
                        <span>
                            @if(session('locale') === 'ru')
                                {{ __('navigation.language_russian') }}
                            @else
                                {{ __('navigation.language_turkish') }}
                            @endif
                        </span>
                        <x-heroicon name="chevron-down" class="w-3 h-3 group-hover:rotate-180 transition-transform duration-200" />
                    </button>

                    <div id="languageDropdown" class="hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-2xl shadow-2xl backdrop-blur-xl z-30 border border-gray-700">
                        <div class="p-2">
                            <a href="{{ route('language.switch', 'tr') }}"
                               class="group flex items-center px-4 py-3 text-sm text-gray-300 hover:text-white hover:bg-gray-700 rounded-xl transition-all duration-200 {{ session('locale', 'tr') === 'tr' ? 'bg-gray-700 text-white' : '' }}">
                                <div class="w-8 h-8 rounded-xl bg-red-600/20 flex items-center justify-center mr-3 group-hover:bg-red-600/30 transition-all duration-200">
                                    <span class="text-xs font-bold">🇹🇷</span>
                                </div>
                                <div>
                                    <div class="font-medium">{{ __('navigation.language_turkish') }}</div>
                                    <div class="text-xs text-gray-400">Türkçe</div>
                                </div>
                                @if(session('locale', 'tr') === 'tr')
                                    <x-heroicon name="check" class="w-4 h-4 text-green-400 ml-auto" />
                                @endif
                            </a>
                            <a href="{{ route('language.switch', 'ru') }}"
                               class="group flex items-center px-4 py-3 text-sm text-gray-300 hover:text-white hover:bg-gray-700 rounded-xl transition-all duration-200 {{ session('locale') === 'ru' ? 'bg-gray-700 text-white' : '' }}">
                                <div class="w-8 h-8 rounded-xl bg-blue-600/20 flex items-center justify-center mr-3 group-hover:bg-blue-600/30 transition-all duration-200">
                                    <span class="text-xs font-bold">🇷🇺</span>
                                </div>
                                <div>
                                    <div class="font-medium">{{ __('navigation.language_russian') }}</div>
                                    <div class="text-xs text-gray-400">Русский</div>
                                </div>
                                @if(session('locale') === 'ru')
                                    <x-heroicon name="check" class="w-4 h-4 text-blue-400 ml-auto" />
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('login') }}" class="text-gray-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                    {{ __('auth.login.title') }}
                </a>
                <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    {{ __('auth.register.title') }}
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="toggleMobileMenu()" class="text-gray-400 hover:text-white focus:outline-none focus:text-white">
                    <x-heroicon name="bars-3" class="h-6 w-6" />
                </button>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="toggleMobileMenu()" class="text-gray-400 hover:text-white focus:outline-none focus:text-white">
                    <x-heroicon name="bars-3" class="h-6 w-6" />
                </button>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Language Dropdown Toggle
    window.toggleLanguageDropdown = function() {
        const dropdown = document.getElementById('languageDropdown');
        dropdown.classList.toggle('hidden');
    };

    // Click outside to close
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('languageDropdown');
        const button = document.querySelector('button[onclick="toggleLanguageDropdown()"]');
        
        if (dropdown && !dropdown.contains(event.target) &&
            (!button || !button.contains(event.target))) {
            dropdown.classList.add('hidden');
        }
    });

    // ESC key to close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const dropdown = document.getElementById('languageDropdown');
            if (dropdown) {
                dropdown.classList.add('hidden');
            }
        }
    });
});
</script>