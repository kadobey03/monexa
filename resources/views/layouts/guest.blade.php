<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full bg-gray-50" data-layout="guest">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $settings->site_name ?? 'Monexa' }} | @yield('title', 'Authentication')</title>
    
    <!-- Favicon -->
    <link rel="icon" 
          href="{{ (isset($settings) && $settings->favicon) ? asset('storage/' . $settings->favicon) : asset('favicon.ico') }}" 
          type="image/png" />
    
    <!-- Preconnect for Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Lucide Icons - Loaded via unified Icon Service -->
    
    @stack('head-scripts')
    @stack('head-styles')
</head>

<body class="h-full antialiased">
    <!-- Theme Management -->
    <script>
        const getPreferredTheme = () => {
            if (localStorage.getItem('theme')) {
                return localStorage.getItem('theme');
            }
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        };
        
        const setTheme = (theme) => {
            localStorage.setItem('theme', theme);
            document.documentElement.classList.toggle('dark', theme === 'dark');
        };
        
        // Initialize theme
        document.addEventListener('DOMContentLoaded', () => {
            setTheme(getPreferredTheme());
        });
    </script>

    <!-- Main Content -->
    <div class="min-h-screen flex flex-col">
        <!-- Header (if needed) -->
        <header class="bg-white dark:bg-gray-900 shadow-sm border-b border-gray-200 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        @if($settings && $settings->logo)
                            <img src="{{ asset('storage/'.$settings->logo)}}" class="h-8 w-auto" alt="{{$settings->site_name}}">
                        @else
                            <span class="text-2xl font-bold text-blue-600">{{ $settings->site_name ?? 'Monexa' }}</span>
                        @endif
                    </div>
                    
                    <!-- Theme Toggle -->
                    <button onclick="toggleTheme()" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                        <i data-lucide="moon" class="w-5 h-5 dark:hidden"></i>
                        <i data-lucide="sun" class="w-5 h-5 hidden dark:block"></i>
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                    <p>© {{ date('Y') }} {{ $settings->site_name ?? 'Monexa' }}. Tüm hakları saklıdır.</p>
                    @if ($settings && $settings->google_translate == 'on')
                        @include('layouts.lang')
                    @endif
                </div>
            </div>
        </footer>
    </div>

    <!-- Global Scripts -->
    @stack('scripts')
    
    <!-- Theme Toggle Function -->
    <script>
        function toggleTheme() {
            const currentTheme = localStorage.getItem('theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
            
            // Dispatch custom event for components that need to listen
            document.dispatchEvent(new CustomEvent('theme-changed', { 
                detail: { theme: newTheme } 
            }));
        }
        
        // Initialize Lucide icons after DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Icons initialized via unified Icon Service
        });
    </script>
</body>

</html>