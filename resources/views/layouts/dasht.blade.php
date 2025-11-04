<!DOCTYPE html>
<html lang="en" class="dark bg-gray-900" data-theme="">
<head>
    <meta charset="UTF-8">
    <title>{{$title}}</title>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="{{ $settings->favicon ? asset('storage/' . $settings->favicon) : asset('favicon.ico') }}" rel="icon" type="image/x-icon" />
    <!-- Inter Font - Local -->
    <link href="{{ asset('vendor/fonts/inter.css') }}" rel="stylesheet">
    <!-- SweetAlert2 with CDN fallback -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" media="none" onload="if(!window.Swal)this.media='all'">
    
    <!-- jQuery with CDN fallback -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="{{ asset('vendor/jquery/jquery-3.7.1.min.js') }}"><\/script>');
    </script>
    
    <!-- SweetAlert2 with fallback -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js" crossorigin="anonymous"></script>
    <script>
        window.Swal || document.write('<script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"><\/script>');
    </script>
    
    <!-- Bootstrap Bundle for modal support -->
    

    <!-- Tailwind CSS Local -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwind configured via Vite - no CDN config needed -->

    <script>
        // Set dark mode as default if no preference is stored
        if (!localStorage.getItem('theme')) {
            localStorage.setItem('theme', 'dark');
            document.documentElement.classList.add('dark');
        }

        // Theme Management - Vanilla JavaScript
        let isDarkMode = localStorage.getItem('theme') === 'dark' || !localStorage.getItem('theme');
        
        function updateTheme() {
            const html = document.documentElement;
            if (isDarkMode) {
                html.classList.add('dark');
                html.setAttribute('data-theme', 'dark');
            } else {
                html.classList.remove('dark');
                html.setAttribute('data-theme', 'light');
            }
            localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
        }
        
        function toggleTheme() {
            isDarkMode = !isDarkMode;
            updateTheme();
        }
        
        // Initialize theme immediately
        updateTheme();
    </script>

    <!-- Console Error Fixes - Ultimate System -->
    
    
    
    
    <!-- Heroicons Component - Pure SVG icons with no JavaScript dependencies -->

</head>
<body class="dark text-gray-100 bg-gray-900 js-hidden" id="main-body" data-sidebar-open="false">
      <style>
          body {
      overflow-x: hidden;
    }
  
    .js-hidden {
      display: none !important;
    }
  
    /* Custom CSS Classes for Dark Theme */
    .card-dark {
      @apply bg-gray-800/50 border border-gray-700/50 rounded-lg backdrop-blur-sm;
    }
  
    .btn-primary {
      @apply bg-primary hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-200;
    }
  
    .btn-secondary {
      @apply bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-200;
    }
  
    .heading-accent {
      @apply text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400;
    }
  
    .animate-ticker {
      animation: ticker 60s linear infinite;
    }
  
    @keyframes ticker {
      0% { transform: translateX(0); }
      100% { transform: translateX(-100%); }
    }
  
    .animate-float {
      animation: float 6s ease-in-out infinite;
    }
  
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }
          </style>
<!-- Professional Trading Navbar -->
<nav id="main-nav" class="bg-white/98 dark:bg-gray-900/98 backdrop-blur-xl border-b border-gray-200/80 dark:border-gray-700/80 sticky top-0 z-50 shadow-sm dark:shadow-gray-900/20">

  <!-- Main Navigation Container -->
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="flex justify-between items-center h-20">

      <!-- Left Section: Logo & Quick Market Info -->
      <div class="flex items-center space-x-4">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
          <img src="{{ asset('storage/'.$settings->logo)}}" class="h-8 w-auto" alt="Logo" />
          <div class="hidden sm:block">
            <span class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
             {{$settings->site_name}}
            </span>
            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">
              Profesyonel Ticaret
            </div>
          </div>
        </a>

        <!-- Live Market Ticker (Hidden on small screens) -->
        <div class="hidden lg:flex items-center space-x-4 ml-8 pl-8 border-l border-gray-200 dark:border-gray-700" id="crypto-prices">
          <div class="flex items-center space-x-2">
            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
            <span class="text-xs font-medium text-gray-600 dark:text-gray-300">LIVE</span>
          </div>
          <div class="text-sm">
            <span class="text-gray-500 dark:text-gray-400">BTC:</span>
            <span class="font-mono ml-1 text-green-600 dark:text-green-400" id="btc-price">$...</span>
          </div>
          <div class="text-sm">
            <span class="text-gray-500 dark:text-gray-400">ETH:</span>
            <span class="font-mono ml-1 text-green-600 dark:text-green-400" id="eth-price">$...</span>
          </div>
        </div>
      </div>

      <!-- Center Section: Account Balance (Desktop) -->
      <div class="hidden md:flex items-center space-x-6">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 px-4 py-2 rounded-lg border border-blue-100 dark:border-blue-800">
          <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Hesap Bakiyesi</div>
          <div class="text-lg font-bold text-gray-900 dark:text-white">
            {{ Auth::user()->currency }}{{ number_format(auth()->user()->account_bal, 2) }}
          </div>
        </div>
      </div>

      <!-- Right Section: Actions & User -->
      <div class="flex items-center space-x-2">

        <!-- Quick Actions Dropdown (Desktop) -->
        <div class="hidden md:block relative" id="quick-actions-dropdown">
          <button id="quick-actions-btn"
                  class="flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
            <x-heroicon name="zap" class="w-4 h-4" />
            <span>Hızlı İşlem</span>
            <x-heroicon name="chevron-down" class="w-4 h-4" id="quick-actions-chevron" />
          </button>

          <div id="quick-actions-menu" class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-20 js-hidden">
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
                <x-heroicon name="trending-up" class="w-4 h-4 mr-3 text-blue-500" />
                Piyasa İşlemleri
              </a>
            </div>
          </div>
        </div>

        <!-- Notifications -->
        <div class="relative" id="notifications-dropdown">
          <button id="notifications-btn"
                  class="relative p-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
            <x-heroicon name="bell" class="w-5 h-5" />
            @php
                $unreadCount = \App\Models\Notification::where('user_id', Auth::id())
                    ->where('is_read', 0)
                    ->count();
            @endphp
            @if($unreadCount > 0)
                <span class="absolute -top-1 -right-1 flex items-center justify-center min-w-[18px] h-[18px] text-xs font-medium text-white bg-red-500 rounded-full px-1 border-2 border-white dark:border-gray-900">
                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                </span>
            @endif
          </button>

          <div id="notifications-menu" class="absolute right-0 sm:right-0 sm:left-auto left-1/2 sm:transform-none transform -translate-x-1/2 mt-2 w-80 max-w-[90vw] bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-20 js-hidden">
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
              <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                Bildirimler
                @if($unreadCount > 0)
                  <span class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-500 rounded-full">
                    {{ $unreadCount }}
                  </span>
                @endif
              </h3>
              {{-- @if($unreadCount > 0)
              <a href="{{ route('notifications.mark-all-read') }}" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">
                Mark all read
              </a>
              @endif --}}
            </div>

            <div class="max-h-[60vh] overflow-y-auto">
              @php
                  $notifications = \App\Models\Notification::where('user_id', Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->take(5)
                      ->get();
              @endphp

              @forelse($notifications as $notification)
                <a href="{{ route('notifications.show', $notification->id) }}" class="block border-b border-gray-100 dark:border-gray-700 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                  <div class="px-4 py-3 {{ !$notification->is_read ? 'bg-blue-50 dark:bg-blue-900/10' : '' }}">
                    <div class="flex items-start">
                      <div class="flex-shrink-0 mt-0.5">
                        <span class="flex h-8 w-8 rounded-full items-center justify-center {{ $notification->type === 'warning' ? 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/20 dark:text-yellow-500' : ($notification->type === 'success' ? 'bg-green-100 text-green-600 dark:bg-green-900/20 dark:text-green-500' : ($notification->type === 'danger' ? 'bg-red-100 text-red-600 dark:bg-red-900/20 dark:text-red-500' : 'bg-blue-100 text-blue-600 dark:bg-blue-900/20 dark:text-blue-500')) }}">
                          <x-heroicon name="question-mark-circle" class="w-4 h-4" />
                        </span>
                      </div>
                      <div class="ml-3 w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-white {{ !$notification->is_read ? 'font-semibold' : '' }}">
                          {{ $notification->title }}
                        </p>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                          {{ \Illuminate\Support\Str::limit($notification->message, 100) }}
                        </p>
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                          {{ $notification->created_at->diffForHumans() }}
                        </p>
                      </div>
                    </div>
                  </div>
                </a>
              @empty
                <div class="py-8 text-center">
                  <div class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 dark:text-gray-500 mb-4">
                    <x-heroicon name="bell-off" class="h-6 w-6" />
                  </div>
                  <p class="text-sm text-gray-600 dark:text-gray-400">Bildirim yok</p>
                      <p class="mt-1 text-xs text-gray-500 dark:text-gray-500">Bir şey olduğunda size haber vereceğiz</p>
                </div>
              @endforelse
            </div>

            @if(count($notifications) > 0)
              <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 text-center">
                <a href="{{ route('notifications') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Tüm bildirimleri görüntüle</a>
              </div>
            @endif
          </div>
        </div>

        <!-- Dark Mode Toggle -->
        <button id="theme-toggle"
          class="p-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
          <x-heroicon name="sun" id="sun-icon" class="w-5 h-5 js-hidden" />
          <x-heroicon name="moon" id="moon-icon" class="w-5 h-5" />
        </button>

        <!-- Language Translator (Desktop) -->


        <!-- User Profile Dropdown -->
        <div class="relative" id="user-dropdown">
          <button id="user-dropdown-btn"
                  class="flex items-center space-x-3 px-2 py-2 text-sm rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-all duration-200 focus:outline-none">
            <div class="flex items-center space-x-2">
              <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-medium">
                {{ Str::upper(substr(Auth::user()->name, 0, 1)) }}
              </div>
              <div class="hidden sm:block text-left">
                <div class="text-sm font-medium text-gray-900 dark:text-white truncate max-w-[120px]">
                  {{ auth()->user()->name }}
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                  Ticaret Hesabı
                </div>
              </div>
            </div>
            <x-heroicon name="chevron-down" class="w-4 h-4 text-gray-400" id="user-dropdown-chevron" />
          </button>

          <div id="user-dropdown-menu" class="absolute right-0 mt-2 w-64 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-20 js-hidden">

            <!-- User Info Header -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
              <div class="flex items-center space-x-3">
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white text-lg font-medium">
                  {{ Str::upper(substr(Auth::user()->name, 0, 1)) }}
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

            <!-- Menu Items -->
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
                <x-heroicon name="help-circle" class="w-4 h-4 mr-3" />
                Destek Merkezi
              </a>
              <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md">
                  <x-heroicon name="log-out" class="w-4 h-4 mr-3" />
                  Çıkış Yap
                </button>
              </form>
            </div>
          </div>
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn"
                class="md:hidden p-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-all duration-200">
          <x-heroicon name="menu" id="menu-icon" class="w-5 h-5" />
          <x-heroicon name="x" id="close-icon" class="w-5 h-5 js-hidden" />
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile Market Ticker -->
  <div class="lg:hidden bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700 px-4 py-2" id="mobile-crypto-prices">
    <div class="flex items-center justify-between text-xs">
      <div class="flex items-center space-x-4">
        <div class="flex items-center space-x-1">
          <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></div>
          <span class="text-gray-600 dark:text-gray-400">LIVE</span>
        </div>
        <div>
          <span class="text-gray-500 dark:text-gray-400">BTC:</span>
          <span class="font-mono ml-1 text-green-600 dark:text-green-400" id="mobile-btc-price">$...</span>
        </div>
        <div>
          <span class="text-gray-500 dark:text-gray-400">ETH:</span>
          <span class="font-mono ml-1 text-green-600 dark:text-green-400" id="mobile-eth-price">$...</span>
        </div>
      </div>
      <div class="md:hidden">
        <div class="text-gray-500 dark:text-gray-400">Balance:</div>
        <div class="font-semibold text-gray-900 dark:text-white">
          {{ Auth::user()->currency }}{{ number_format(auth()->user()->account_bal, 2) }}
        </div>
      </div>
    </div>
  </div>
</nav>



<!-- Sidebar Toggle Wrapper -->
<div class="flex min-h-screen bg-gray-900">

  <!-- Sidebar -->
<aside id="sidebar"
  class="fixed z-50 md:z-40 top-0 left-0 w-72 h-full bg-white dark:bg-gray-900 shadow-xl transform transition-transform duration-300 ease-in-out md:translate-x-0 overflow-y-auto -translate-x-full">

    <!-- User Profile Section -->
    <div class="relative p-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-4">
            <div class="relative">

<div class="w-16 h-16 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 text-lg font-medium mx-auto mb-3">
    {{ Str::upper(substr(Auth::user()->name, 0, 1)) }}
</div>
                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white dark:border-gray-900"></div>
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                    {{ auth()->user()->name }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Hesap Bakiyesi: {{ Auth::user()->currency }}{{ number_format(auth()->user()->account_bal, 2) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Live Market Prices -->
    <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Live Market</h3>
            <span class="flex items-center text-xs text-green-600 dark:text-green-400">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse mr-2"></div>
                <span class="font-medium">Canlı</span>
            </span>
        </div>
        <div class="space-y-2">
            <coingecko-coin-price-marquee-widget
                coin-ids="bitcoin,ethereum,eos,ripple,litecoin"
                currency="usd"
                background-color="transparent"
                locale="en"
                font-color="#333">
            </coingecko-coin-price-marquee-widget>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-4 space-y-6 text-sm pb-20">
        <!-- Overview Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <x-heroicon name="layout-dashboard" class="w-4 h-4" />
                <span>Genel Bakış</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('dashboard') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <x-heroicon name="layout-dashboard" class="w-5 h-5 mr-3" />
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
                <li>
                    <a href="{{ route('tradinghistory') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('tradinghistory') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <x-heroicon name="activity" class="w-5 h-5 mr-3" />
                        İşlem Geçmişi
                    </a>
                </li>
            </ul>
        </div>





        <!-- Wallet & Funds Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
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
                    <a href="{{ route('withdrawalsdeposits') }}"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('withdrawalsdeposits') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <x-heroicon name="minus-circle" class="w-5 h-5 mr-3" />
                        Para Çekme
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('assetbalance') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('assetbalance') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <x-heroicon name="arrow-path" class="w-5 h-5 mr-3" />
                        Currency Exchange
                        <span class="ml-auto px-2 py-0.5 text-xs font-medium text-white bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full">Swap</span>
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Exchange between cryptocurrencies and fiat
                        </div>
                    </a>
                </li> --}}
                <li>
                    <a href="/dashboard/trade"
                       class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('dashboard.trade') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <x-heroicon name="zap" class="w-5 h-5 mr-3" />
                        İşlem Yap
                    </a>
                </li>
                </ul>
        </div>

        <!-- Account Management Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
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
                @if(isset($settings->enable_kyc) && $settings->enable_kyc === 'yes')
                <li id="kyc-section">
                    @if(Auth::user()->account_verify === 'Verified')
                        <!-- Verified Status -->
                        <div class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800">
                            <x-heroicon name="shield-check" class="w-5 h-5 mr-3 text-green-600 dark:text-green-400" />
                            <span class="font-medium text-green-700 dark:text-green-300">Hesap Doğrulandı</span>
                        </div>
                    @else
                        <!-- KYC Dropdown -->
                        <div class="relative">
                            <button id="kyc-toggle-btn"
                                    class="flex items-center w-full px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200 {{ request()->routeIs('account.verify') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                                <x-heroicon name="shield-alert" class="w-5 h-5 mr-3" />
                                <span class="flex-1 text-left">Kimlik Doğrulama</span>
                                <x-heroicon name="chevron-down" id="kyc-chevron"
                                   class="w-4 h-4 transition-transform duration-200" />
                            </button>

                            <!-- Dropdown Content -->
                            <div id="kyc-dropdown" class="mt-2 ml-8 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700 shadow-sm js-hidden">

                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">
                                    Kimlik Doğrulama
                                </h4>

                                @if(Auth::user()->account_verify === 'Under review')
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                                        Doğrulamanız inceleniyor
                                                    </p>
                                                    <div class="flex items-center text-xs text-yellow-600 dark:text-yellow-400">
                                                        <x-heroicon name="clock" class="w-3 h-3 mr-1" />
                                                        <span>İşleniyor</span>
                                                    </div>
                                                @else
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                                        Tüm ticaret özelliklerini kullanmak için kimlik doğrulaması tamamlayın
                                                    </p>
                                                    <a href="{{ route('account.verify') }}"
                                                       class="inline-flex items-center gap-2 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                        <x-heroicon name="shield-check" class="w-4 h-4" />
                                                        <span>Şimdi Doğrula</span>
                                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </li>
                @endif
            </ul>
        </div>

        <!-- Growth & Referrals Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <x-heroicon name="trending-up" class="w-4 h-4" />
                <span>Büyüme ve Ödüller</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('referuser') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('referuser') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <x-heroicon name="users" class="w-5 h-5 mr-3" />
                        Tavsiye Programı
                        <span class="ml-auto px-2 py-0.5 text-xs font-medium text-white bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-full">{{$settings->referral_commission}}%</span>
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Tavsiyelerden {{$settings->referral_commission}}% komisyon kazanın
                        </div>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Support & Help Section -->
        <div class="space-y-2">
            <div class="flex items-center gap-2 px-2 mt-6 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                <x-heroicon name="help-circle" class="w-4 h-4" />
                <span>Destek ve Yardım</span>
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('support') }}"
                       class="group relative flex items-center px-3 py-2 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/50 transition-colors duration-150 {{ request()->routeIs('support') ? 'bg-blue-50 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 font-medium' : '' }}">
                        <x-heroicon name="headphones" class="w-5 h-5 mr-3" />
                        Destek Merkezi
                        <div class="hidden group-hover:block absolute left-full ml-2 px-2 py-1 bg-gray-900 text-xs text-white rounded whitespace-nowrap">
                            Destek ekibimizden yardım alın
                        </div>
                    </a>
                </li>
            </ul>
        </div>

            <!-- Account Actions -->
            <div class="mt-6 p-4 border-t border-gray-200 dark:border-gray-700">
                <!-- Language Translator (Mobile/Sidebar) -->

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center w-full px-3 py-2 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/50 transition-colors duration-150">
                        <x-heroicon name="log-out" class="w-5 h-5 mr-3" />
                        <span>Çıkış Yap</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

  <!-- Sidebar overlay for mobile -->
  <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden js-hidden">
  </div>

  <!-- Main content placeholder -->
  <div class="flex-1 ml-0 md:ml-64 p-4 pb-20 md:pb-4">
    <!-- Your main dashboard content goes here -->
    @yield('content')
  </div>
</div>





<!-- Modern Mobile Navigation with Glassmorphism -->

<div class="fixed bottom-0 w-full z-30 md:hidden" id="mobile-nav">
  <!-- Bottom Navigation Bar with Enhanced Glassmorphism -->
  <div class="flex justify-between items-center bg-white/90 dark:bg-gray-900/90 backdrop-blur-xl px-6 py-4 shadow-[0_-8px_30px_rgba(0,0,0,0.15)] relative border-t border-gray-200/30 dark:border-gray-700/30">
    <!-- Language Selector (Mobile) -->

    <a href="{{ route('deposits') }}"
       class="group flex flex-col items-center relative">
      <div class="p-2 rounded-xl transition-all duration-300 ease-out
                  {{ request()->routeIs('deposits')
                     ? 'bg-blue-500/10 dark:bg-blue-400/10 scale-110'
                     : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
        <x-heroicon name="banknote" class="w-6 h-6
           {{ request()->routeIs('deposits')
              ? 'text-blue-600 dark:text-blue-400'
              : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
           transition-colors duration-300" />
      </div>
      <span class="text-xs font-medium mt-1
             {{ request()->routeIs('deposits')
                ? 'text-blue-600 dark:text-blue-400'
                : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
             transition-colors duration-300">Yatırma</span>
    </a>

    <a href="{{ route('profile') }}"
       class="group flex flex-col items-center relative">
      <div class="p-2 rounded-xl transition-all duration-300 ease-out
                  {{ request()->routeIs('profile')
                     ? 'bg-blue-500/10 dark:bg-blue-400/10 scale-110'
                     : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
        <x-heroicon name="user" class="w-6 h-6
           {{ request()->routeIs('profile')
              ? 'text-blue-600 dark:text-blue-400'
              : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
           transition-colors duration-300" />
      </div>
      <span class="text-xs font-medium mt-1
             {{ request()->routeIs('profile')
                ? 'text-blue-600 dark:text-blue-400'
                : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
             transition-colors duration-300">Profil</span>
    </a>

    <a href="{{ route('trade.index') }}"
       class="group flex flex-col items-center relative">
      <div class="p-2 rounded-xl transition-all duration-300 ease-out
                  {{ request()->routeIs('trade.index')
                     ? 'bg-blue-500/10 dark:bg-blue-400/10 scale-110'
                     : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
        <x-heroicon name="zap" class="w-6 h-6
           {{ request()->routeIs('trade.index')
              ? 'text-blue-600 dark:text-blue-400'
              : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
           transition-colors duration-300" />
      </div>
      <span class="text-xs font-medium mt-1
             {{ request()->routeIs('trade.index')
                ? 'text-blue-600 dark:text-blue-400'
                : 'text-gray-500 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-blue-400' }}
             transition-colors duration-300">İşlem Aç</span>
    </a>
<a href="{{ route('support') }}"
   class="flex flex-col items-center
          {{ request()->routeIs('support') ? 'text-blue-600 font-semibold' : 'text-gray-500' }}
          hover:text-blue-600">
  <x-heroicon name="life-buoy" class="w-6 h-6" />
  <span class="text-xs mt-1">Destek</span>
</a>



   <a href="{{ route('dashboard') }}"
   class="flex flex-col items-center
          {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-500' }} hover:text-blue-600">
 <x-heroicon name="home" class="w-6 h-6 transition-colors duration-200" />
  <span class="text-xs mt-1">Anasayfa</span>
</a>
  </div>

  <!-- Modern FAB Overlay Menu -->
  <div id="fab-overlay" class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm z-40 flex items-center justify-center p-4 js-hidden">

    <!-- Menu Card -->
    <div class="bg-gray-900 p-6 rounded-2xl
                shadow-[0_8px_30px_rgba(0,0,0,0.3)]
                space-y-4 w-72 max-w-full
                border border-gray-700
                transform transition-all duration-300
                animate-slideUp">

      
      <!-- Menu Links -->
      <div class="space-y-2">


        {{-- <a href="{{ route('assetbalance') }}" class="flex items-center p-3 rounded-lg text-gray-100
                          hover:bg-gray-800
                          transition-colors duration-200 group">
          <x-heroicon name="repeat" class="w-5 h-5 mr-3 text-indigo-400
                                        group-hover:scale-110 transition-transform duration-300" />
          <span class="font-medium">Currency Exchange</span>
          <span class="ml-auto text-xs font-bold text-indigo-400">Swap</span>
        </a> --}}

        <a href="#" class="flex items-center p-3 rounded-lg text-gray-100
                          hover:bg-gray-800
                          transition-colors duration-200 group">
          <x-heroicon name="users" class="w-5 h-5 mr-3 text-orange-400
                                      group-hover:scale-110 transition-transform duration-300" />
          <span class="font-medium">Arkadaş Tavsiye Et</span>
          <span class="ml-auto text-xs font-bold text-orange-400">+{{$settings->referral_commission}}%</span>
        </a>

        <a href="{{ route('support') }}" class="flex items-center p-3 rounded-lg text-gray-100
                                               hover:bg-gray-800
                                               transition-colors duration-200 group">
          <x-heroicon name="life-buoy" class="w-5 h-5 mr-3 text-cyan-400
                                           group-hover:scale-110 transition-transform duration-300" />
          <span class="font-medium">Destek</span>
        </a>

      </div>

      <!-- Close Button -->
      <button id="fab-close"
              class="absolute top-2 right-2 p-2 rounded-full
                     text-gray-400 hover:text-gray-200
                     hover:bg-gray-800
                     transition-colors duration-200">
        <x-heroicon name="x" class="w-5 h-5" />
      </button>
    </div>
  </div>

  <style>
    @keyframes slideUp {
      from { opacity: 0; transform: scale(0.95) translateY(10px); }
      to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .animate-slideUp {
      animation: slideUp 0.3s ease-out forwards;
    }
  </style>
</div>

<!-- Heroicons - Pure SVG icons with no JavaScript dependencies -->
<script>
  // Heroicons Component - No initialization needed
  // Icons rendered as pure SVG via Laravel Blade component
  document.addEventListener('DOMContentLoaded', function() {
    console.log('Heroicons loaded successfully - no JS initialization required');
  });
</script>

<style>
  @keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
  }
  .animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
  }
</style>

<!-- SweetAlert2 already loaded above -->

<!-- Live Crypto Prices Script -->
<script>
// Vanilla JavaScript functionality

let sidebarOpen = false;
let quickActionsOpen = false;
let notificationsOpen = false;
let userDropdownOpen = false;
let kycOpen = false;
let fabOpen = false;

// Crypto prices data
let cryptoData = {
    btcPrice: null,
    ethPrice: null,
    btcChange: 0,
    ethChange: 0
};

// Theme functions already defined above

// Sidebar functions
function toggleSidebar() {
    sidebarOpen = !sidebarOpen;
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    
    if (sidebarOpen) {
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        overlay.classList.remove('js-hidden');
        menuIcon.classList.add('js-hidden');
        closeIcon.classList.remove('js-hidden');
    } else {
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
        overlay.classList.add('js-hidden');
        menuIcon.classList.remove('js-hidden');
        closeIcon.classList.add('js-hidden');
    }
}

// Dropdown functions
function toggleDropdown(dropdownId, isOpen, setOpen) {
    const dropdown = document.getElementById(dropdownId);
    if (dropdown) {
        if (isOpen) {
            dropdown.classList.add('js-hidden');
            setOpen(false);
        } else {
            dropdown.classList.remove('js-hidden');
            setOpen(true);
        }
    }
}

function toggleQuickActions() {
    quickActionsOpen = !quickActionsOpen;
    toggleDropdown('quick-actions-menu', !quickActionsOpen, (val) => quickActionsOpen = val);
    
    const chevron = document.getElementById('quick-actions-chevron');
    if (chevron) {
        chevron.classList.toggle('rotate-180', quickActionsOpen);
    }
}

function toggleNotifications() {
    notificationsOpen = !notificationsOpen;
    toggleDropdown('notifications-menu', !notificationsOpen, (val) => notificationsOpen = val);
}

function toggleUserDropdown() {
    userDropdownOpen = !userDropdownOpen;
    toggleDropdown('user-dropdown-menu', !userDropdownOpen, (val) => userDropdownOpen = val);
    
    const chevron = document.getElementById('user-dropdown-chevron');
    if (chevron) {
        chevron.classList.toggle('rotate-180', userDropdownOpen);
    }
}

function toggleKyc() {
    kycOpen = !kycOpen;
    toggleDropdown('kyc-dropdown', !kycOpen, (val) => kycOpen = val);
    
    const chevron = document.getElementById('kyc-chevron');
    if (chevron) {
        chevron.classList.toggle('rotate-180', kycOpen);
    }
}

function toggleFab() {
    fabOpen = !fabOpen;
    const overlay = document.getElementById('fab-overlay');
    if (overlay) {
        if (fabOpen) {
            overlay.classList.remove('js-hidden');
        } else {
            overlay.classList.add('js-hidden');
        }
    }
}

// Crypto prices function
async function fetchCryptoPrices() {
    try {
        const response = await fetch('/api/crypto/prices');
        const data = await response.json();

        if (data.bitcoin && data.ethereum) {
            cryptoData.btcPrice = Math.round(data.bitcoin.usd);
            cryptoData.ethPrice = Math.round(data.ethereum.usd);
            cryptoData.btcChange = data.bitcoin.usd_24h_change || 0;
            cryptoData.ethChange = data.ethereum.usd_24h_change || 0;
            
            updateCryptoPrices();
        }
    } catch (error) {
        console.error('Error fetching crypto prices:', error);
        // Fallback values
        cryptoData.btcPrice = cryptoData.btcPrice || 45320;
        cryptoData.ethPrice = cryptoData.ethPrice || 2850;
        updateCryptoPrices();
    }

    // Update every 30 seconds
    setTimeout(fetchCryptoPrices, 30000);
}

function updateCryptoPrices() {
    // Desktop prices
    const btcPriceEl = document.getElementById('btc-price');
    const ethPriceEl = document.getElementById('eth-price');
    
    if (btcPriceEl && cryptoData.btcPrice) {
        btcPriceEl.textContent = '$' + cryptoData.btcPrice.toLocaleString();
        btcPriceEl.className = `font-mono ml-1 ${cryptoData.btcChange >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}`;
    }
    
    if (ethPriceEl && cryptoData.ethPrice) {
        ethPriceEl.textContent = '$' + cryptoData.ethPrice.toLocaleString();
        ethPriceEl.className = `font-mono ml-1 ${cryptoData.ethChange >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}`;
    }
    
    // Mobile prices
    const mobileBtcPriceEl = document.getElementById('mobile-btc-price');
    const mobileEthPriceEl = document.getElementById('mobile-eth-price');
    
    if (mobileBtcPriceEl && cryptoData.btcPrice) {
        mobileBtcPriceEl.textContent = '$' + cryptoData.btcPrice.toLocaleString();
        mobileBtcPriceEl.className = `font-mono ml-1 ${cryptoData.btcChange >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}`;
    }
    
    if (mobileEthPriceEl && cryptoData.ethPrice) {
        mobileEthPriceEl.textContent = '$' + cryptoData.ethPrice.toLocaleString();
        mobileEthPriceEl.className = `font-mono ml-1 ${cryptoData.ethChange >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}`;
    }
}

// Close dropdowns when clicking outside
function handleOutsideClick(event) {
    // Quick actions
    const quickActionsDropdown = document.getElementById('quick-actions-dropdown');
    if (quickActionsDropdown && !quickActionsDropdown.contains(event.target) && quickActionsOpen) {
        toggleQuickActions();
    }
    
    // Notifications
    const notificationsDropdown = document.getElementById('notifications-dropdown');
    if (notificationsDropdown && !notificationsDropdown.contains(event.target) && notificationsOpen) {
        toggleNotifications();
    }
    
    // User dropdown
    const userDropdown = document.getElementById('user-dropdown');
    if (userDropdown && !userDropdown.contains(event.target) && userDropdownOpen) {
        toggleUserDropdown();
    }
    
    // FAB overlay
    const fabOverlay = document.getElementById('fab-overlay');
    if (fabOverlay && event.target === fabOverlay && fabOpen) {
        toggleFab();
    }
}

// Initialize everything
document.addEventListener('DOMContentLoaded', () => {
    // Show body
    const body = document.getElementById('main-body');
    if (body) {
        body.classList.remove('js-hidden');
    }
    
    // Initialize theme
    updateTheme();
    
    // Event listeners
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            toggleTheme();
            // Update icons
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');
            if (isDarkMode) {
                sunIcon.classList.add('js-hidden');
                moonIcon.classList.remove('js-hidden');
            } else {
                sunIcon.classList.remove('js-hidden');
                moonIcon.classList.add('js-hidden');
            }
        });
    }
    
    // Mobile menu
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', toggleSidebar);
    }
    
    // Sidebar overlay
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', toggleSidebar);
    }
    
    // Quick actions
    const quickActionsBtn = document.getElementById('quick-actions-btn');
    if (quickActionsBtn) {
        quickActionsBtn.addEventListener('click', toggleQuickActions);
    }
    
    // Notifications
    const notificationsBtn = document.getElementById('notifications-btn');
    if (notificationsBtn) {
        notificationsBtn.addEventListener('click', toggleNotifications);
    }
    
    // User dropdown
    const userDropdownBtn = document.getElementById('user-dropdown-btn');
    if (userDropdownBtn) {
        userDropdownBtn.addEventListener('click', toggleUserDropdown);
    }
    
    // KYC toggle
    const kycToggleBtn = document.getElementById('kyc-toggle-btn');
    if (kycToggleBtn) {
        kycToggleBtn.addEventListener('click', toggleKyc);
    }
    
    // FAB close
    const fabClose = document.getElementById('fab-close');
    if (fabClose) {
        fabClose.addEventListener('click', toggleFab);
    }
    
    // Outside click handler
    document.addEventListener('click', handleOutsideClick);
    
    // Initialize crypto prices
    fetchCryptoPrices();
    
    // Heroicons - No initialization needed (pure SVG components)
    console.log('Heroicons: Pure SVG icons loaded - no JavaScript initialization required');
    
    // Initialize Bootstrap components
    if (typeof bootstrap !== 'undefined') {
        // Initialize modals
        const modalElements = document.querySelectorAll('.modal');
        modalElements.forEach(modalEl => {
            new bootstrap.Modal(modalEl);
        });
        
        // Initialize dropdowns
        const dropdownElements = document.querySelectorAll('.dropdown-toggle');
        dropdownElements.forEach(dropdownEl => {
            new bootstrap.Dropdown(dropdownEl);
        });
        
        // Initialize tooltips
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        
        console.log('Bootstrap components initialized in dasht layout');
    }
    
    // Fix jQuery modal and dropdown functions
    if (typeof $ !== 'undefined' && typeof bootstrap !== 'undefined') {
        $.fn.modal = function(options) {
            return this.each(function() {
                if (options === 'show') {
                    const modal = new bootstrap.Modal(this);
                    modal.show();
                } else if (options === 'hide') {
                    const modal = bootstrap.Modal.getInstance(this);
                    if (modal) modal.hide();
                } else {
                    new bootstrap.Modal(this, options);
                }
            });
        };
        
        $.fn.dropdown = function(options) {
            return this.each(function() {
                if (options === 'toggle') {
                    const dropdown = new bootstrap.Dropdown(this);
                    dropdown.toggle();
                } else {
                    new bootstrap.Dropdown(this, options);
                }
            });
        };
    }
});
</script>

<!-- Livewire Scripts -->
@livewireScriptConfig
@livewireScripts

<!-- Enhanced Livewire Configuration for dasht layout -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configure Livewire if available
        if (typeof Livewire !== 'undefined') {
            // Configure Livewire 3 hooks for better UX
            Livewire.hook('request.error', ({ detail }) => {
                const { response } = detail;
                if (response && response.status === 419) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Oturum Süresi Doldu',
                            text: 'Sayfayı yeniden yüklemek için tamam\'a tıklayın.',
                            icon: 'warning',
                            confirmButtonText: 'Tamam'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        if (confirm('Oturum süresi doldu. Sayfayı yeniden yüklemek istiyor musunuz?')) {
                            window.location.reload();
                        }
                    }
                }
            });
            
            // Loading states using Livewire 3 hooks
            Livewire.hook('request', () => {
                document.body.classList.add('loading');
            });
            
            Livewire.hook('request.finished', () => {
                document.body.classList.remove('loading');
                
                // Heroicons - No re-initialization needed (pure SVG)
                console.log('Livewire update complete - Heroicons ready');
            });
            
            console.log('Livewire 3 configured successfully in dasht layout');
        } else {
            console.warn('Livewire not loaded in dasht layout');
        }
    });
</script>

@yield('scripts')
@include('layouts.lang')
@include('layouts.livechat')
</body>
</html>
