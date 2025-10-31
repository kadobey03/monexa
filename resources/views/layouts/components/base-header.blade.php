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
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Ana Sayfa</a>
                <a href="{{ route('cryptocurrencies') }}" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Kripto</a>
                <a href="{{ route('forex') }}" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Döviz</a>
                <a href="{{ route('shares') }}" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Hisseler</a>
                <a href="{{ route('about') }}" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Hakkımızda</a>
            </nav>

            <!-- Right Navigation -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="{{ route('login') }}" class="text-gray-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                    Giriş Yap
                </a>
                <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                    Kayıt Ol
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button @click="toggleMobileMenu()" class="text-gray-400 hover:text-white focus:outline-none focus:text-white">
                    <i data-lucide="menu" class="h-6 w-6"></i>
                </button>
            </div>
        </div>
    </div>
</header>