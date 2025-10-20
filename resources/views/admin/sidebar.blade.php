<!-- Modern Tailwind Sidebar -->
<aside id="admin-sidebar" class="fixed left-0 top-16 w-64 bg-white shadow-2xl z-50 transform transition-transform duration-300 ease-in-out md:translate-x-0 -translate-x-full flex flex-col" style="height: calc(100vh - 4rem);">
    
    <!-- Sidebar Header -->
    <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100 flex-shrink-0">
        <div class="flex items-center space-x-3">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-3 rounded-xl text-white">
                <i class="fas fa-user-shield text-lg"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800">{{ Auth('admin')->User()->firstName }} {{ Auth('admin')->User()->lastName }}</h3>
                <p class="text-sm text-gray-600">{{ Auth('admin')->User()->type }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1 min-h-0">
        
        <!-- Dashboard -->
        <a href="{{ url('/admin/dashboard') }}" 
           class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-indigo-600' }}">
            <i class="fas fa-home mr-3 text-lg {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-indigo-500' }}"></i>
            <span>Kontrol Paneli</span>
            @if(request()->routeIs('admin.dashboard'))
                <div class="ml-auto w-2 h-2 bg-white rounded-full animate-pulse"></div>
            @endif
        </a>

        @if (Auth('admin')->User()->type == 'Super Admin' || Auth('admin')->User()->type == 'Admin')
            <!-- Users Management -->
            <div class="sidebar-dropdown" data-dropdown="users">
                <button class="dropdown-toggle w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs(['manageusers', 'loginactivity', 'user.plans', 'viewuser']) ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-indigo-600' }}">
                    <div class="flex items-center">
                        <i class="fas fa-users mr-3 text-lg {{ request()->routeIs(['manageusers', 'loginactivity', 'user.plans', 'viewuser']) ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-500' }}"></i>
                        <span>Kullanıcıları Yönet</span>
                    </div>
                    <i class="fas fa-chevron-down transform transition-transform duration-200"></i>
                </button>
                
                <div class="dropdown-content mt-1 ml-8 space-y-1 {{ request()->routeIs(['manageusers', 'loginactivity', 'user.plans', 'viewuser']) ? '' : 'hidden' }}">
                    <a href="{{ url('/admin/dashboard/manageusers') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors duration-200">
                        Tüm Kullanıcılar
                    </a>
                </div>
            </div>

            <!-- Deposits Management -->
            <a href="{{ url('/admin/dashboard/mdeposits') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs(['mdeposits', 'viewdepositimage']) ? 'bg-gradient-to-r from-green-500 to-teal-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-green-600' }}">
                <i class="fas fa-download mr-3 text-lg {{ request()->routeIs(['mdeposits', 'viewdepositimage']) ? 'text-white' : 'text-gray-400 group-hover:text-green-500' }}"></i>
                <span>Yatırımları Yönet</span>
            </a>

            <!-- Withdrawals Management -->
            <a href="{{ url('/admin/dashboard/mwithdrawals') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs(['mwithdrawals', 'processwithdraw']) ? 'bg-gradient-to-r from-red-500 to-pink-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-red-600' }}">
                <i class="fas fa-arrow-alt-circle-up mr-3 text-lg {{ request()->routeIs(['mwithdrawals', 'processwithdraw']) ? 'text-white' : 'text-gray-400 group-hover:text-red-500' }}"></i>
                <span>Çekimleri Yönet</span>
            </a>

            <!-- Trades Management -->
            <a href="{{ route('admin.trades.index') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.trades.*') ? 'bg-gradient-to-r from-blue-500 to-cyan-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                <i class="fas fa-chart-line mr-3 text-lg {{ request()->routeIs('admin.trades.*') ? 'text-white' : 'text-gray-400 group-hover:text-blue-500' }}"></i>
                <span>İşlemleri Yönet</span>
            </a>

            <!-- Bot Trading -->
            <div class="sidebar-dropdown" data-dropdown="bots">
                <button class="dropdown-toggle w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.bots.*') ? 'bg-purple-50 text-purple-700' : 'text-gray-700 hover:bg-gray-100 hover:text-purple-600' }}">
                    <div class="flex items-center">
                        <i class="fas fa-robot mr-3 text-lg {{ request()->routeIs('admin.bots.*') ? 'text-purple-600' : 'text-gray-400 group-hover:text-purple-500' }}"></i>
                        <span>Bot Ticareti</span>
                    </div>
                    <i class="fas fa-chevron-down transform transition-transform duration-200"></i>
                </button>
                
                <div class="dropdown-content mt-1 ml-8 space-y-1 {{ request()->routeIs('admin.bots.*') ? '' : 'hidden' }}">
                    <a href="{{ route('admin.bots.index') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors duration-200">
                        Tüm Ticaret Botları
                    </a>
                    <a href="{{ route('admin.bots.create') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors duration-200">
                        Yeni Bot Ekle
                    </a>
                    <a href="{{ route('admin.bots.dashboard') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors duration-200">
                        Bot Analitiği
                    </a>
                </div>
            </div>

            <!-- Investment Plans -->
            <div class="sidebar-dropdown" data-dropdown="plans">
                <button class="dropdown-toggle w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs(['plans', 'newplan', 'editplan', 'investments', 'admin.plans.*']) ? 'bg-emerald-50 text-emerald-700' : 'text-gray-700 hover:bg-gray-100 hover:text-emerald-600' }}">
                    <div class="flex items-center">
                        <i class="fas fa-cubes mr-3 text-lg {{ request()->routeIs(['plans', 'newplan', 'editplan', 'investments', 'admin.plans.*']) ? 'text-emerald-600' : 'text-gray-400 group-hover:text-emerald-500' }}"></i>
                        <span>Yatırım Planları</span>
                    </div>
                    <i class="fas fa-chevron-down transform transition-transform duration-200"></i>
                </button>
                
                <div class="dropdown-content mt-1 ml-8 space-y-1 {{ request()->routeIs(['plans', 'newplan', 'editplan', 'investments', 'admin.plans.*']) ? '' : 'hidden' }}">
                    <a href="{{ url('/admin/dashboard/plans') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors duration-200">
                        Planlar
                    </a>
                    <a href="{{ url('/admin/dashboard/active-investments') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors duration-200">
                        Aktif Yatırımlar
                    </a>
                </div>
            </div>

            <!-- Demo Trading -->
            <div class="sidebar-dropdown" data-dropdown="demo">
                <button class="dropdown-toggle w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.demo.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-700 hover:bg-gray-100 hover:text-orange-600' }}">
                    <div class="flex items-center">
                        <i class="fas fa-graduation-cap mr-3 text-lg {{ request()->routeIs('admin.demo.*') ? 'text-orange-600' : 'text-gray-400 group-hover:text-orange-500' }}"></i>
                        <span>Demo Ticareti</span>
                    </div>
                    <i class="fas fa-chevron-down transform transition-transform duration-200"></i>
                </button>
                
                <div class="dropdown-content mt-1 ml-8 space-y-1 {{ request()->routeIs('admin.demo.*') ? '' : 'hidden' }}">
                    <a href="{{ route('admin.demo.users') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors duration-200">
                        Demo Kullanıcıları
                    </a>
                    <a href="{{ route('admin.demo.trades') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors duration-200">
                        Demo İşlemleri
                    </a>
                </div>
            </div>

            <!-- Copy Trading -->
            <div class="sidebar-dropdown" data-dropdown="copy">
                <button class="dropdown-toggle w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs(['copytradings', 'newcopytrading', 'editcopytrading', 'activecopytrading']) ? 'bg-cyan-50 text-cyan-700' : 'text-gray-700 hover:bg-gray-100 hover:text-cyan-600' }}">
                    <div class="flex items-center">
                        <i class="fas fa-copy mr-3 text-lg {{ request()->routeIs(['copytradings', 'newcopytrading', 'editcopytrading', 'activecopytrading']) ? 'text-cyan-600' : 'text-gray-400 group-hover:text-cyan-500' }}"></i>
                        <span>Kopya Ticareti</span>
                    </div>
                    <i class="fas fa-chevron-down transform transition-transform duration-200"></i>
                </button>
                
                <div class="dropdown-content mt-1 ml-8 space-y-1 {{ request()->routeIs(['copytradings', 'newcopytrading', 'editcopytrading', 'activecopytrading']) ? '' : 'hidden' }}">
                    <a href="{{ url('/admin/dashboard/copytrading') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-cyan-600 hover:bg-cyan-50 rounded-lg transition-colors duration-200">
                        Kopya Ticaret Planları
                    </a>
                    <a href="{{ url('/admin/dashboard/active-copytrading') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-cyan-600 hover:bg-cyan-50 rounded-lg transition-colors duration-200">
                        Aktif Kopya İşlemleri
                    </a>
                </div>
            </div>

            <!-- Email Services -->
            <a href="{{ route('emailservices') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('emailservices') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
                <i class="fas fa-envelope mr-3 text-lg {{ request()->routeIs('emailservices') ? 'text-white' : 'text-gray-400 group-hover:text-blue-500' }}"></i>
                <span>E-posta Servisleri</span>
            </a>

            <!-- KYC Applications -->
            <a href="{{ route('kyc') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs(['kyc', 'viewkyc']) ? 'bg-gradient-to-r from-teal-500 to-green-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-teal-600' }}">
                <i class="fas fa-user-check mr-3 text-lg {{ request()->routeIs(['kyc', 'viewkyc']) ? 'text-white' : 'text-gray-400 group-hover:text-teal-500' }}"></i>
                <span>KYC Başvuruları</span>
            </a>

            <!-- Wallet Phrases -->
            <div class="sidebar-dropdown" data-dropdown="wallet">
                <button class="dropdown-toggle w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs(['mwalletconnect', 'madmin']) ? 'bg-yellow-50 text-yellow-700' : 'text-gray-700 hover:bg-gray-100 hover:text-yellow-600' }}">
                    <div class="flex items-center">
                        <i class="fas fa-sync-alt mr-3 text-lg {{ request()->routeIs(['mwalletconnect', 'madmin']) ? 'text-yellow-600' : 'text-gray-400 group-hover:text-yellow-500' }}"></i>
                        <span>Cümleler</span>
                    </div>
                    <i class="fas fa-chevron-down transform transition-transform duration-200"></i>
                </button>
                
                <div class="dropdown-content mt-1 ml-8 space-y-1 {{ request()->routeIs(['mwalletconnect', 'madmin']) ? '' : 'hidden' }}">
                    <a href="{{ url('/admin/dashboard/mwalletconnect') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors duration-200">
                        Müşteri Cümle Anahtarları
                    </a>
                    <a href="{{ url('/admin/dashboard/mwalletsettings') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors duration-200">
                        Cümle Ayarları
                    </a>
                </div>
            </div>

            <!-- Loan Applications -->
            <div class="sidebar-dropdown" data-dropdown="loans">
                <button class="dropdown-toggle w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('loans') ? 'bg-rose-50 text-rose-700' : 'text-gray-700 hover:bg-gray-100 hover:text-rose-600' }}">
                    <div class="flex items-center">
                        <i class="fas fa-handshake mr-3 text-lg {{ request()->routeIs('loans') ? 'text-rose-600' : 'text-gray-400 group-hover:text-rose-500' }}"></i>
                        <span>Kredi Başvuruları</span>
                    </div>
                    <i class="fas fa-chevron-down transform transition-transform duration-200"></i>
                </button>
                
                <div class="dropdown-content mt-1 ml-8 space-y-1 {{ request()->routeIs('loans') ? '' : 'hidden' }}">
                    <a href="{{ url('/admin/dashboard/active-loans') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors duration-200">
                        Aktif Krediler
                    </a>
                </div>
            </div>

            <!-- Signal Provider -->
            <div class="sidebar-dropdown" data-dropdown="signals">
                <button class="dropdown-toggle w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs(['signals', 'signal.settings', 'signal.subs']) ? 'bg-violet-50 text-violet-700' : 'text-gray-700 hover:bg-gray-100 hover:text-violet-600' }}">
                    <div class="flex items-center">
                        <i class="fas fa-signal mr-3 text-lg {{ request()->routeIs(['signals', 'signal.settings', 'signal.subs']) ? 'text-violet-600' : 'text-gray-400 group-hover:text-violet-500' }}"></i>
                        <span>Sinyal Sağlayıcı</span>
                    </div>
                    <i class="fas fa-chevron-down transform transition-transform duration-200"></i>
                </button>
                
                <div class="dropdown-content mt-1 ml-8 space-y-1 {{ request()->routeIs(['signals', 'signal.settings', 'signal.subs']) ? '' : 'hidden' }}">
                    <a href="{{ url('/admin/dashboard/signals') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-violet-600 hover:bg-violet-50 rounded-lg transition-colors duration-200">
                        Sinyaller
                    </a>
                    <a href="{{ url('/admin/dashboard/activesignals') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-violet-600 hover:bg-violet-50 rounded-lg transition-colors duration-200">
                        Aktif Sinyaller
                    </a>
                </div>
            </div>

            <!-- Leads -->
            <a href="{{ url('/admin/dashboard/leads') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs(['admin.leads.*', 'leads']) ? 'bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-amber-600' }}">
                <i class="fas fa-user-plus mr-3 text-lg {{ request()->routeIs(['admin.leads.*', 'leads']) ? 'text-white' : 'text-gray-400 group-hover:text-amber-500' }}"></i>
                <span>Müşteri Adayları</span>
            </a>
        @endif

        <!-- Task Management -->
        <div class="sidebar-dropdown" data-dropdown="tasks">
            <button class="dropdown-toggle w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs(['task', 'mtask', 'viewtask']) ? 'bg-slate-50 text-slate-700' : 'text-gray-700 hover:bg-gray-100 hover:text-slate-600' }}">
                <div class="flex items-center">
                    <i class="fas fa-tasks mr-3 text-lg {{ request()->routeIs(['task', 'mtask', 'viewtask']) ? 'text-slate-600' : 'text-gray-400 group-hover:text-slate-500' }}"></i>
                    <span>Görevler</span>
                </div>
                <i class="fas fa-chevron-down transform transition-transform duration-200"></i>
            </button>
            
            <div class="dropdown-content mt-1 ml-8 space-y-1 {{ request()->routeIs(['task', 'mtask', 'viewtask']) ? '' : 'hidden' }}">
                @if (Auth('admin')->User()->type == 'Super Admin')
                    <a href="{{ url('/admin/dashboard/task') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-slate-600 hover:bg-slate-50 rounded-lg transition-colors duration-200">
                        Görev Oluştur
                    </a>
                    <a href="{{ url('/admin/dashboard/mtask') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-slate-600 hover:bg-slate-50 rounded-lg transition-colors duration-200">
                        Görevleri Yönet
                    </a>
                @else
                    <a href="{{ url('/admin/dashboard/viewtask') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-slate-600 hover:bg-slate-50 rounded-lg transition-colors duration-200">
                        Görevlerimi Görüntüle
                    </a>
                @endif
            </div>
        </div>

        @if (Auth('admin')->User()->type == 'Super Admin')
            <!-- Admin Management -->
            <div class="sidebar-dropdown" data-dropdown="admins">
                <button class="dropdown-toggle w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs(['addmanager', 'madmin']) ? 'bg-red-50 text-red-700' : 'text-gray-700 hover:bg-gray-100 hover:text-red-600' }}">
                    <div class="flex items-center">
                        <i class="fas fa-user-cog mr-3 text-lg {{ request()->routeIs(['addmanager', 'madmin']) ? 'text-red-600' : 'text-gray-400 group-hover:text-red-500' }}"></i>
                        <span>Yöneticiler</span>
                    </div>
                    <i class="fas fa-chevron-down transform transition-transform duration-200"></i>
                </button>
                
                <div class="dropdown-content mt-1 ml-8 space-y-1 {{ request()->routeIs(['addmanager', 'madmin']) ? '' : 'hidden' }}">
                    <a href="{{ url('/admin/dashboard/addmanager') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200">
                        Yönetici Ekle
                    </a>
                    <a href="{{ url('/admin/dashboard/madmin') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200">
                        Yöneticileri Yönet
                    </a>
                </div>
            </div>

            <!-- Settings -->
            <div class="sidebar-dropdown" data-dropdown="settings">
                <button class="dropdown-toggle w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs(['appsettingshow', 'termspolicy', 'refsetshow', 'paymentview', 'frontpage', 'allipaddress', 'ipaddress', 'editpaymethod', 'managecryptoasset']) ? 'bg-gray-50 text-gray-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-800' }}">
                    <div class="flex items-center">
                        <i class="fas fa-cog mr-3 text-lg {{ request()->routeIs(['appsettingshow', 'termspolicy', 'refsetshow', 'paymentview', 'frontpage', 'allipaddress', 'ipaddress', 'editpaymethod', 'managecryptoasset']) ? 'text-gray-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                        <span>Ayarlar</span>
                    </div>
                    <i class="fas fa-chevron-down transform transition-transform duration-200"></i>
                </button>
                
                <div class="dropdown-content mt-1 ml-8 space-y-1 {{ request()->routeIs(['appsettingshow', 'termspolicy', 'refsetshow', 'paymentview', 'frontpage', 'allipaddress', 'ipaddress', 'editpaymethod', 'managecryptoasset']) ? '' : 'hidden' }}">
                    <a href="{{ route('appsettingshow') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        Uygulama Ayarları
                    </a>
                    <a href="{{ route('refsetshow') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        Tavsiye/Bonus Ayarları
                    </a>
                    <a href="{{ route('paymentview') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        Ödeme Ayarları
                    </a>
                    <a href="{{ route('managecryptoasset') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        Takas Ayarları
                    </a>
                    <a href="{{ url('/admin/dashboard/ipaddress') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                        IP Adresi
                    </a>
                </div>
            </div>
        @endif

        <!-- About -->
        <a href="{{ url('/admin/dashboard/about') }}" 
           class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('aboutonlinetrade') ? 'bg-gradient-to-r from-pink-500 to-rose-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100 hover:text-pink-600' }}">
            <i class="fas fa-info-circle mr-3 text-lg {{ request()->routeIs('aboutonlinetrade') ? 'text-white' : 'text-gray-400 group-hover:text-pink-500' }}"></i>
            <span>Daha Fazla Script İçin</span>
        </a>

    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-gray-200 bg-gray-50 flex-shrink-0">
        <div class="text-center">
            <p class="text-xs text-gray-500">{{ $settings->site_name }}</p>
            <p class="text-xs text-gray-400">{{ date('Y') }}</p>
        </div>
    </div>
    
</aside>

<!-- Mobile Sidebar Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-50 z-40 md:hidden hidden"></div>

<script>
// Sidebar functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize sidebar dropdowns
    const sidebarDropdowns = document.querySelectorAll('.sidebar-dropdown');
    
    sidebarDropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        const content = dropdown.querySelector('.dropdown-content');
        const chevron = toggle.querySelector('.fas.fa-chevron-down');
        
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            const isOpen = !content.classList.contains('hidden');
            
            if (isOpen) {
                // Close
                content.classList.add('hidden');
                chevron.classList.remove('rotate-180');
            } else {
                // Open
                content.classList.remove('hidden');
                chevron.classList.add('rotate-180');
            }
        });
    });
});

// Global sidebar control functions
window.toggleSidebar = function() {
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    
    if (window.innerWidth < 768) {
        // Mobile behavior
        sidebar.classList.toggle('-translate-x-full');
        sidebar.classList.toggle('translate-x-0');
        overlay.classList.toggle('hidden');
    } else {
        // Desktop behavior
        sidebar.classList.toggle('-translate-x-full');
        const mainContent = document.querySelector('.main-panel');
        if (mainContent) {
            mainContent.classList.toggle('ml-0');
            mainContent.classList.toggle('ml-64');
        }
    }
};

window.closeSidebar = function() {
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    
    if (window.innerWidth < 768) {
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
        overlay.classList.add('hidden');
    }
};

// Close sidebar when clicking overlay
document.getElementById('sidebar-overlay')?.addEventListener('click', window.closeSidebar);

// Handle window resize
window.addEventListener('resize', function() {
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    
    if (window.innerWidth >= 768) {
        // Desktop - always show sidebar
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        overlay.classList.add('hidden');
    } else {
        // Mobile - hide sidebar by default
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
    }
});
</script>

<style>
/* Sidebar Critical Fixes */
#admin-sidebar {
    z-index: 9999 !important;
    pointer-events: all !important;
    position: fixed !important;
    visibility: visible !important;
}

#admin-sidebar * {
    pointer-events: all !important;
}

/* Ensure sidebar stays on top */
#admin-sidebar {
    isolation: isolate;
}

/* Custom Scrollbar for Sidebar */
aside::-webkit-scrollbar {
    width: 6px;
}

aside::-webkit-scrollbar-track {
    background: #f1f1f1;
}

aside::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 10px;
}

aside::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #5a6fd8, #6a4190);
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .main-panel {
        margin-left: 0 !important;
    }
}

/* Smooth transitions */
.transition-transform {
    transition-property: transform;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}

/* Force sidebar interaction */
.sidebar-nav-item {
    position: relative;
    z-index: 10000 !important;
}

.sidebar-nav-item:hover {
    transform: scale(1.02);
    z-index: 10001 !important;
}
</style>