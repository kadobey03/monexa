{{-- Modern Dashboard Sidebar with Fintech Theme --}}
<aside id="dashboard-sidebar"
       class="fixed z-50 md:static md:z-auto top-0 left-0 w-56 h-full md:h-screen md:w-56 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 shadow-2xl transform transition-all duration-300 ease-in-out md:translate-x-0 overflow-y-auto -translate-x-full border-r border-slate-700/50 dark:border-gray-700/50 flex flex-col md:flex-shrink-0">
    
    {{-- Brand Logo Section --}}
    <div class="relative p-3 border-b border-slate-700/50 dark:border-gray-700/50 bg-gradient-to-r from-blue-600/10 to-purple-600/10">
        <div class="flex items-center gap-2">
            <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
                <x-heroicon name="currency-dollar" class="w-3 h-3 text-white" />
            </div>
            <div>
                <h1 class="text-sm font-bold text-white">Monexa</h1>
            </div>
        </div>
    </div>

    {{-- User Profile Section --}}
    @auth
    <div class="relative p-2.5 border-b border-slate-700/50 dark:border-gray-700/50 bg-gradient-to-r from-emerald-600/5 to-blue-600/5">
        <div class="flex items-center gap-1.5">
            <div class="relative">
                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-emerald-400 to-blue-500 flex items-center justify-center text-white text-xs font-bold shadow-lg ring-1 ring-emerald-400/30">
                    {{ Str::upper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="absolute -bottom-0.5 -right-0.5 w-2 h-2 bg-emerald-500 rounded-full border-1 border-slate-800 dark:border-gray-800"></div>
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="text-xs font-semibold text-white truncate">
                    {{ auth()->user()->name }}
                </h2>
                <div class="flex items-center gap-1 mt-0.5">
                    <x-heroicon name="wallet" class="w-2.5 h-2.5 text-emerald-400" />
                    <p class="text-xs text-emerald-300 font-medium">
                        {{ Auth::user()->currency }}{{ number_format(auth()->user()->account_bal, 2) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endauth

    {{-- Navigation Menu --}}
    <nav class="flex-1 p-2.5 space-y-3 text-sm overflow-y-auto">
        
        {{-- Overview Section --}}
        <div class="space-y-1.5">
            <div class="flex items-center gap-1 px-2 py-1 text-xs font-bold text-slate-400 dark:text-gray-400 uppercase tracking-wider">
                <div class="w-1 h-1 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full"></div>
                <span>{{ __('user.sidebar.overview') }}</span>
            </div>
            <ul class="space-y-0.5">
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="group flex items-center px-2.5 py-1.5 text-slate-300 dark:text-gray-200 rounded-lg hover:bg-gradient-to-r hover:from-blue-600/20 hover:to-purple-600/20 hover:text-white transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-blue-600/30 to-purple-600/30 text-white shadow-lg ring-1 ring-blue-500/50' : '' }}">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-blue-500/20 to-purple-600/20 flex items-center justify-center mr-2 group-hover:from-blue-500/30 group-hover:to-purple-600/30 transition-all duration-200">
                            <x-heroicon name="squares-2x2" class="w-3.5 h-3.5" />
                        </div>
                        <span class="font-medium text-xs">{{ __('user.sidebar.dashboard') }}</span>
                        @if(request()->routeIs('dashboard'))
                            <div class="ml-auto w-1.5 h-1.5 bg-blue-400 rounded-full animate-pulse"></div>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('accounthistory') }}"
                       class="group flex items-center px-2.5 py-1.5 text-slate-300 dark:text-gray-200 rounded-lg hover:bg-gradient-to-r hover:from-emerald-600/20 hover:to-blue-600/20 hover:text-white transition-all duration-200 {{ request()->routeIs('accounthistory') ? 'bg-gradient-to-r from-emerald-600/30 to-blue-600/30 text-white shadow-lg ring-1 ring-emerald-500/50' : '' }}">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-emerald-500/20 to-blue-600/20 flex items-center justify-center mr-2 group-hover:from-emerald-500/30 group-hover:to-blue-600/30 transition-all duration-200">
                            <x-heroicon name="document-chart-bar" class="w-3.5 h-3.5" />
                        </div>
                        <span class="font-medium text-xs">{{ __('user.sidebar.account_summary') }}</span>
                        @if(request()->routeIs('accounthistory'))
                            <div class="ml-auto w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></div>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('tradinghistory') }}"
                       class="group flex items-center px-2.5 py-1.5 text-slate-300 dark:text-gray-200 rounded-lg hover:bg-gradient-to-r hover:from-orange-600/20 hover:to-red-600/20 hover:text-white transition-all duration-200 {{ request()->routeIs('tradinghistory') ? 'bg-gradient-to-r from-orange-600/30 to-red-600/30 text-white shadow-lg ring-1 ring-orange-500/50' : '' }}">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-orange-500/20 to-red-600/20 flex items-center justify-center mr-2 group-hover:from-orange-500/30 group-hover:to-red-600/30 transition-all duration-200">
                            <x-heroicon name="chart-bar" class="w-3.5 h-3.5" />
                        </div>
                        <span class="font-medium text-xs">{{ __('user.sidebar.transaction_history') }}</span>
                        @if(request()->routeIs('tradinghistory'))
                            <div class="ml-auto w-1.5 h-1.5 bg-orange-400 rounded-full animate-pulse"></div>
                        @endif
                    </a>
                </li>
            </ul>
        </div>

        {{-- Trading Section --}}
        <div class="space-y-1.5">
            <div class="flex items-center gap-1 px-2 py-1 text-xs font-bold text-slate-400 dark:text-gray-400 uppercase tracking-wider">
                <div class="w-1 h-1 bg-gradient-to-r from-emerald-400 to-blue-500 rounded-full"></div>
                <span>{{ __('user.sidebar.trading_investment') }}</span>
            </div>
            <ul class="space-y-0.5">
                <li>
                    <a href="{{ route('deposits') }}"
                       class="group flex items-center px-2.5 py-1.5 text-slate-300 dark:text-gray-200 rounded-lg hover:bg-gradient-to-r hover:from-emerald-600/20 hover:to-green-600/20 hover:text-white transition-all duration-200 {{ request()->routeIs('deposits') ? 'bg-gradient-to-r from-emerald-600/30 to-green-600/30 text-white shadow-lg ring-1 ring-emerald-500/50' : '' }}">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-emerald-500/20 to-green-600/20 flex items-center justify-center mr-2 group-hover:from-emerald-500/30 group-hover:to-green-600/30 transition-all duration-200">
                            <x-heroicon name="arrow-down-circle" class="w-3.5 h-3.5" />
                        </div>
                        <span class="font-medium text-xs">{{ __('user.sidebar.deposits') }}</span>
                        @if(request()->routeIs('deposits'))
                            <div class="ml-auto w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></div>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('withdrawalsdeposits') }}"
                       class="group flex items-center px-2.5 py-1.5 text-slate-300 dark:text-gray-200 rounded-lg hover:bg-gradient-to-r hover:from-red-600/20 hover:to-pink-600/20 hover:text-white transition-all duration-200 {{ request()->routeIs('withdrawalsdeposits') ? 'bg-gradient-to-r from-red-600/30 to-pink-600/30 text-white shadow-lg ring-1 ring-red-500/50' : '' }}">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-red-500/20 to-pink-600/20 flex items-center justify-center mr-2 group-hover:from-red-500/30 group-hover:to-pink-600/30 transition-all duration-200">
                            <x-heroicon name="arrow-up-circle" class="w-3.5 h-3.5" />
                        </div>
                        <span class="font-medium text-xs">{{ __('user.sidebar.withdrawals') }}</span>
                        @if(request()->routeIs('withdrawalsdeposits'))
                            <div class="ml-auto w-1.5 h-1.5 bg-red-400 rounded-full animate-pulse"></div>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('trade.index') }}"
                       class="group flex items-center px-2.5 py-1.5 text-slate-300 dark:text-gray-200 rounded-lg hover:bg-gradient-to-r hover:from-yellow-600/20 hover:to-orange-600/20 hover:text-white transition-all duration-200 {{ request()->routeIs('trade.index') ? 'bg-gradient-to-r from-yellow-600/30 to-orange-600/30 text-white shadow-lg ring-1 ring-yellow-500/50' : '' }}">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-yellow-500/20 to-orange-600/20 flex items-center justify-center mr-2 group-hover:from-yellow-500/30 group-hover:to-orange-600/30 transition-all duration-200">
                            <x-heroicon name="bolt" class="w-3.5 h-3.5" />
                        </div>
                        <span class="font-medium text-xs">{{ __('user.sidebar.live_trading') }}</span>
                        @if(request()->routeIs('trade.index'))
                            <div class="ml-auto w-1.5 h-1.5 bg-yellow-400 rounded-full animate-pulse"></div>
                        @endif
                    </a>
                </li>
            </ul>
        </div>

        {{-- Account Management Section --}}
        <div class="space-y-1.5">
            <div class="flex items-center gap-1 px-2 py-1 text-xs font-bold text-slate-400 dark:text-gray-400 uppercase tracking-wider">
                <div class="w-1 h-1 bg-gradient-to-r from-purple-400 to-pink-500 rounded-full"></div>
                <span>{{ __('user.sidebar.account_management') }}</span>
            </div>
            <ul class="space-y-0.5">
                <li>
                    <a href="{{ route('profile') }}"
                       class="group flex items-center px-2.5 py-1.5 text-slate-300 dark:text-gray-200 rounded-lg hover:bg-gradient-to-r hover:from-purple-600/20 hover:to-pink-600/20 hover:text-white transition-all duration-200 {{ request()->routeIs('profile') ? 'bg-gradient-to-r from-purple-600/30 to-pink-600/30 text-white shadow-lg ring-1 ring-purple-500/50' : '' }}">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-purple-500/20 to-pink-600/20 flex items-center justify-center mr-2 group-hover:from-purple-500/30 group-hover:to-pink-600/30 transition-all duration-200">
                            <x-heroicon name="user-circle" class="w-3.5 h-3.5" />
                        </div>
                        <span class="font-medium text-xs">{{ __('user.sidebar.profile_settings') }}</span>
                        @if(request()->routeIs('profile'))
                            <div class="ml-auto w-1.5 h-1.5 bg-purple-400 rounded-full animate-pulse"></div>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('account.verify') }}"
                       class="group flex items-center px-2.5 py-1.5 text-slate-300 dark:text-gray-200 rounded-lg hover:bg-gradient-to-r hover:from-indigo-600/20 hover:to-blue-600/20 hover:text-white transition-all duration-200 {{ request()->routeIs('account.verify') ? 'bg-gradient-to-r from-indigo-600/30 to-blue-600/30 text-white shadow-lg ring-1 ring-indigo-500/50' : '' }}">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-indigo-500/20 to-blue-600/20 flex items-center justify-center mr-2 group-hover:from-indigo-500/30 group-hover:to-blue-600/30 transition-all duration-200">
                            <x-heroicon name="shield-check" class="w-3.5 h-3.5" />
                        </div>
                        <span class="font-medium text-xs">{{ __('user.sidebar.kyc_verification') }}</span>
                        @if(request()->routeIs('account.verify'))
                            <div class="ml-auto w-1.5 h-1.5 bg-indigo-400 rounded-full animate-pulse"></div>
                        @endif
                    </a>
                </li>
            </ul>
        </div>

        {{-- Growth & Rewards Section --}}
        <div class="space-y-1.5">
            <div class="flex items-center gap-1 px-2 py-1 text-xs font-bold text-slate-400 dark:text-gray-400 uppercase tracking-wider">
                <div class="w-1 h-1 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full"></div>
                <span>{{ __('user.sidebar.rewards') }}</span>
            </div>
            <ul class="space-y-0.5">
                <li>
                    <a href="{{ route('referuser') }}"
                       class="group flex items-center px-2.5 py-1.5 text-slate-300 dark:text-gray-200 rounded-lg hover:bg-gradient-to-r hover:from-yellow-600/20 hover:to-orange-600/20 hover:text-white transition-all duration-200 {{ request()->routeIs('referuser') ? 'bg-gradient-to-r from-yellow-600/30 to-orange-600/30 text-white shadow-lg ring-1 ring-yellow-500/50' : '' }}">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-yellow-500/20 to-orange-600/20 flex items-center justify-center mr-2 group-hover:from-yellow-500/30 group-hover:to-orange-600/30 transition-all duration-200">
                            <x-heroicon name="gift" class="w-3.5 h-3.5" />
                        </div>
                        <div class="flex-1">
                            <span class="font-medium text-xs">{{ __('user.sidebar.referral_program') }}</span>
                            <div class="flex items-center gap-1 mt-0.5">
                                <span class="text-xs bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent font-bold">{{ __('user.sidebar.commission_percent') }}</span>
                            </div>
                        </div>
                        @if(request()->routeIs('referuser'))
                            <div class="ml-auto w-1.5 h-1.5 bg-yellow-400 rounded-full animate-pulse"></div>
                        @endif
                    </a>
                </li>
            </ul>
        </div>

        {{-- Support Section --}}
        <div class="space-y-1.5">
            <div class="flex items-center gap-1 px-2 py-1 text-xs font-bold text-slate-400 dark:text-gray-400 uppercase tracking-wider">
                <div class="w-1 h-1 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full"></div>
                <span>{{ __('user.sidebar.support') }}</span>
            </div>
            <ul class="space-y-0.5">
                <li>
                    <a href="{{ route('support') }}"
                       class="group flex items-center px-2.5 py-1.5 text-slate-300 dark:text-gray-200 rounded-lg hover:bg-gradient-to-r hover:from-cyan-600/20 hover:to-blue-600/20 hover:text-white transition-all duration-200 {{ request()->routeIs('support') ? 'bg-gradient-to-r from-cyan-600/30 to-blue-600/30 text-white shadow-lg ring-1 ring-cyan-500/50' : '' }}">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-cyan-500/20 to-blue-600/20 flex items-center justify-center mr-2 group-hover:from-cyan-500/30 group-hover:to-blue-600/30 transition-all duration-200">
                            <x-heroicon name="chat-bubble-left-ellipsis" class="w-3.5 h-3.5" />
                        </div>
                        <span class="font-medium text-xs">{{ __('user.sidebar.support_center') }}</span>
                        @if(request()->routeIs('support'))
                            <div class="ml-auto w-1.5 h-1.5 bg-cyan-400 rounded-full animate-pulse"></div>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    {{-- Sidebar Footer --}}
    <div class="flex-shrink-0 p-2.5 border-t border-slate-700/50 dark:border-gray-700/50 bg-gradient-to-t from-slate-900 via-slate-900/95 to-slate-900/80 backdrop-blur-sm">
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="group flex items-center w-full px-2.5 py-1.5 text-red-300 rounded-lg hover:bg-gradient-to-r hover:from-red-600/20 hover:to-pink-600/20 hover:text-white transition-all duration-200 bg-red-600/10 ring-1 ring-red-500/20">
                    <div class="w-6 h-6 rounded-lg bg-gradient-to-br from-red-500/20 to-pink-600/20 flex items-center justify-center mr-2 group-hover:from-red-500/30 group-hover:to-pink-600/30 transition-all duration-200">
                        <x-heroicon name="arrow-right-on-rectangle" class="w-3.5 h-3.5" />
                    </div>
                    <span class="font-medium text-xs">{{ __('user.sidebar.logout') }}</span>
                </button>
            </form>
        @endauth
    </div>
</aside>

{{-- Mobile Overlay --}}
<div id="dashboard-sidebar-overlay"
     class="fixed inset-0 z-40 bg-black/70 backdrop-blur-sm hidden transition-all duration-300 md:hidden">
</div>

{{-- Enhanced Sidebar JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Global sidebar toggle function
    window.toggleDashboardSidebar = function() {
        const sidebar = document.getElementById('dashboard-sidebar');
        const overlay = document.getElementById('dashboard-sidebar-overlay');
        
        if (sidebar && overlay) {
            const isHidden = sidebar.classList.contains('-translate-x-full');
            
            if (isHidden) {
                // Show sidebar with enhanced animation
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
                overlay.classList.add('bg-black/70');
                // Prevent body scroll on mobile
                if (window.innerWidth < 768) {
                    document.body.style.overflow = 'hidden';
                }
            } else {
                // Hide sidebar with enhanced animation
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                overlay.classList.add('hidden');
                overlay.classList.remove('bg-black/70');
                // Restore body scroll
                document.body.style.overflow = '';
            }
        }
    };

    // Enhanced overlay click handling
    const overlay = document.getElementById('dashboard-sidebar-overlay');
    const sidebar = document.getElementById('dashboard-sidebar');
    
    if (overlay && sidebar) {
        // Click on overlay closes sidebar
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                toggleDashboardSidebar();
            }
        });

        // Prevent sidebar clicks from closing
        sidebar.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    // Enhanced responsive behavior
    function handleResize() {
        const sidebar = document.getElementById('dashboard-sidebar');
        const overlay = document.getElementById('dashboard-sidebar-overlay');
        
        if (window.innerWidth >= 768) { // md breakpoint
            // Desktop: show sidebar, hide overlay
            if (sidebar) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
            }
            if (overlay) {
                overlay.classList.add('hidden');
                overlay.classList.remove('bg-black/70');
            }
            document.body.style.overflow = '';
        } else {
            // Mobile: hide sidebar by default
            if (sidebar) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
            }
            if (overlay) {
                overlay.classList.add('hidden');
                overlay.classList.remove('bg-black/70');
            }
            document.body.style.overflow = '';
        }
    }
    
    // Initialize and handle resize
    handleResize();
    window.addEventListener('resize', handleResize);
    
    // ESC key support
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && window.innerWidth < 768) {
            const sidebar = document.getElementById('dashboard-sidebar');
            if (sidebar && !sidebar.classList.contains('-translate-x-full')) {
                e.preventDefault();
                toggleDashboardSidebar();
            }
        }
    });
    
    // Enhanced touch gesture support
    let touchStartX = 0;
    let touchEndX = 0;
    let touchStartTime = 0;
    
    document.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
        touchStartTime = Date.now();
    }, { passive: true });
    
    document.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, { passive: true });
    
    function handleSwipe() {
        const sidebar = document.getElementById('dashboard-sidebar');
        if (!sidebar || window.innerWidth >= 768) return;
        
        const swipeDistance = touchEndX - touchStartX;
        const swipeTime = Date.now() - touchStartTime;
        const isOpen = !sidebar.classList.contains('-translate-x-full');
        const minSwipeDistance = 60;
        const maxSwipeTime = 400;
        
        if (swipeTime > maxSwipeTime) return;
        
        // Swipe right to open from left edge
        if (swipeDistance > minSwipeDistance && touchStartX < 50 && !isOpen) {
            toggleDashboardSidebar();
        }
        // Swipe left to close when open
        else if (swipeDistance < -minSwipeDistance && isOpen) {
            toggleDashboardSidebar();
        }
    }

    // Add smooth scroll behavior to sidebar
    const sidebarElement = document.getElementById('dashboard-sidebar');
    if (sidebarElement) {
        sidebarElement.style.scrollBehavior = 'smooth';
    }
});
</script>