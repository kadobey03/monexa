<!-- Modern Sidebar - Pure Tailwind -->
<div id="sidenav-main" class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-gray-900 via-gray-800 to-gray-900 transform transition-transform duration-300 ease-in-out">
    <!-- Header -->
    <div class="flex items-center justify-between p-6 border-b border-gray-700">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
            <img src="{{ asset('storage/' . $settings->logo) }}" class="h-10 w-auto" alt="logo">
        </a>
        <!-- Mobile toggle -->
        <button class="md:hidden text-gray-400 hover:text-white transition-colors">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>

    <!-- User Profile -->
    <div class="p-6 border-b border-gray-700">
        <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                <i class="fas fa-user-circle text-2xl text-white"></i>
            </div>
            <h5 class="text-white font-semibold text-lg">{{ Auth::user()->name }}</h5>
            <span class="text-green-400 text-sm flex items-center justify-center">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                {{ __('user.sidebar.online') }}
            </span>
            
            <!-- Live Balance -->
            <a href="#" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 mt-3 bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white rounded-xl transition-all duration-200 border border-white/20">
                <i class="fas fa-coins text-yellow-400"></i>
                <span class="text-sm font-medium">{{ __('user.sidebar.live_balance') }}: {{ Auth::user()->currency }}{{ number_format(Auth::user()->account_bal, 2, '.', ',') }}</span>
            </a>

            <!-- Demo Balance -->
            @if(Auth::user()->demo_balance > 0)
            <a href="{{ route('demo.dashboard') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 mt-2 bg-gradient-to-r from-green-500/20 to-emerald-500/20 hover:from-green-500/30 hover:to-emerald-500/30 text-white rounded-xl transition-all duration-200 border border-green-400/30">
                <i class="fas fa-graduation-cap text-green-400"></i>
                <span class="text-sm font-medium">{{ __('user.sidebar.demo_balance') }}: {{ Auth::user()->currency }}{{ number_format(Auth::user()->demo_balance, 2, '.', ',') }}</span>
            </a>
            @endif
        </div>
    </div>
    <!-- Navigation Menu -->
    <nav class="flex-1 p-6 overflow-y-auto">
        <div class="space-y-2">
            <!-- Home -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : '' }}">
                <i class="fas fa-home text-xl group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">{{ __('user.sidebar.dashboard') }}</span>
            </a>

            <!-- Deposit -->
            <a href="{{ route('deposits') }}"
               class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group {{ request()->routeIs('deposits') || request()->routeIs('payment') || request()->routeIs('pay.crypto') ? 'bg-gradient-to-r from-green-600 to-green-700 text-white shadow-lg' : '' }}">
                <i class="fas fa-download text-xl group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">{{ __('user.sidebar.deposit') }}</span>
            </a>

            @if ($mod['investment'] || $mod['cryptoswap'])
            <!-- Withdraw -->
            <a href="{{ route('withdrawalsdeposits') }}"
               class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group {{ request()->routeIs('withdrawalsdeposits') || request()->routeIs('withdrawfunds') ? 'bg-gradient-to-r from-red-600 to-red-700 text-white shadow-lg' : '' }}">
                <i class="fas fa-arrow-alt-circle-up text-xl group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">{{ __('user.sidebar.withdraw') }}</span>
            </a>
            @endif

            @if ($mod['investment'])
            <!-- Trading History -->
            <a href="{{ route('tradinghistory') }}"
               class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group {{ request()->routeIs('tradinghistory') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : '' }}">
                <i class="fas fa-history text-xl group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">{{ __('user.sidebar.trading_history') }}</span>
            </a>
            @endif

            <!-- Transactions -->
            <a href="{{ route('accounthistory') }}"
               class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group {{ request()->routeIs('accounthistory') ? 'bg-gradient-to-r from-indigo-600 to-indigo-700 text-white shadow-lg' : '' }}">
                <i class="fas fa-money-check-alt text-xl group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">{{ __('user.sidebar.transactions') }}</span>
            </a>

            <!-- Notifications -->
            <a href="{{ route('notifications') }}"
               class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group {{ request()->routeIs('notifications') ? 'bg-gradient-to-r from-amber-600 to-amber-700 text-white shadow-lg' : '' }}">
                <div class="relative">
                    <i class="fas fa-bell text-xl group-hover:scale-110 transition-transform"></i>
                    @livewire('user.notifications-count')
                </div>
                <span class="font-medium">{{ __('user.sidebar.notifications') }}</span>
            </a>

            @if ($mod['cryptoswap'])
            <!-- Crypto Swap -->
            <a href="{{ route('assetbalance') }}"
               class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group {{ request()->routeIs('assetbalance') || request()->routeIs('swaphistory') ? 'bg-gradient-to-r from-orange-600 to-orange-700 text-white shadow-lg' : '' }}">
                <i class="fab fa-stack-exchange text-xl group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">{{ __('user.sidebar.crypto_swap') }}</span>
            </a>
            @endif

            @if ($moresettings->use_transfer)
            <!-- Transfer -->
            <a href="{{ route('transferview') }}"
               class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group {{ request()->routeIs('transferview') ? 'bg-gradient-to-r from-cyan-600 to-cyan-700 text-white shadow-lg' : '' }}">
                <i class="fas fa-exchange text-xl group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">{{ __('user.sidebar.transfer_funds') }}</span>
            </a>
            @endif

            @if ($mod['subscription'])
            <!-- Managed Accounts -->
            <a href="{{ route('subtrade') }}"
               class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group {{ request()->routeIs('subtrade') ? 'bg-gradient-to-r from-pink-600 to-pink-700 text-white shadow-lg' : '' }}">
                <i class="fas fa-receipt text-xl group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">{{ __('user.sidebar.managed_accounts') }}</span>
            </a>
            @endif

            <!-- Profile -->
            <a href="{{ route('profile') }}"
               class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group {{ request()->routeIs('profile') ? 'bg-gradient-to-r from-gray-600 to-gray-700 text-white shadow-lg' : '' }}">
                <i class="fas fa-address-card text-xl group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">{{ __('user.sidebar.profile') }}</span>
            </a>

            @if ($mod['investment'])
            <!-- Trading Plans -->
            <a href="{{ route('mplans') }}"
               class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group {{ request()->routeIs('mplans') ? 'bg-gradient-to-r from-emerald-600 to-emerald-700 text-white shadow-lg' : '' }}">
                <i class="fas fa-hand-holding-seedling text-xl group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">{{ __('user.sidebar.investment_plans') }}</span>
            </a>

            <!-- My Plans -->
            <a href="{{ route('myplans', 'All') }}"
               class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group {{ request()->routeIs('myplans') || request()->routeIs('plandetails') ? 'bg-gradient-to-r from-green-600 to-green-700 text-white shadow-lg' : '' }}">
                <i class="fas fa-chart-line text-xl group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">{{ __('user.sidebar.my_investments') }}</span>
            </a>

            <!-- Demo Trading -->
            <a href="{{ route('demo.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group {{ request()->routeIs('demo.dashboard') || request()->routeIs('demo.trade') ? 'bg-gradient-to-r from-blue-500 to-purple-600 text-white shadow-lg' : '' }}">
                <i class="fas fa-graduation-cap text-xl group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">{{ __('user.sidebar.demo_trading') }}</span>
            </a>
            @endif

            @if ($mod['membership'])
            <!-- Education -->
            <a href="{{ route('user.courses') }}"
               class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group {{ request()->routeIs('user.mycourses') || request()->routeIs('user.courses') || request()->routeIs('user.course.details') ? 'bg-gradient-to-r from-purple-600 to-purple-700 text-white shadow-lg' : '' }}">
                <i class="fas fa-graduation-cap text-xl group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">{{ __('user.sidebar.education') }}</span>
            </a>
            @endif

            @if ($mod['signal'])
            <!-- Trade Signals -->
            <a href="{{ route('tsignals') }}"
               class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group {{ request()->routeIs('tsignals') ? 'bg-gradient-to-r from-red-500 to-pink-600 text-white shadow-lg' : '' }}">
                <i class="fas fa-wave-square text-xl group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">{{ __('user.sidebar.trade_signals') }}</span>
            </a>
            @endif

            <!-- Referrals -->
            <a href="{{ route('referuser') }}"
               class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200 group {{ request()->routeIs('referuser') ? 'bg-gradient-to-r from-yellow-600 to-orange-600 text-white shadow-lg' : '' }}">
                <i class="fas fa-retweet text-xl group-hover:scale-110 transition-transform"></i>
                <span class="font-medium">{{ __('user.sidebar.referrals') }}</span>
            </a>
        </div>
    </nav>
    <!-- Help Section -->
    <div class="p-6 border-t border-gray-700">
        <div class="bg-gradient-to-br from-amber-500/20 to-orange-500/20 rounded-2xl p-4 border border-amber-400/30">
            <div class="flex items-start gap-3 mb-3">
                <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-headset text-white text-lg"></i>
                </div>
                <div>
                    <h5 class="text-white font-semibold text-sm">{{ __('user.sidebar.need_help') }}</h5>
                    <p class="text-gray-300 text-xs leading-relaxed">
                        {{ __('user.sidebar.support_available') }}
                    </p>
                </div>
            </div>
            <a href="{{ route('support') }}"
               class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-medium text-sm rounded-xl transition-all duration-200 border border-white/30 hover:border-white/50">
                <i class="fas fa-comment text-xs"></i>
                {{ __('user.sidebar.contact_support') }}
            </a>
        </div>
    </div>
</div>
