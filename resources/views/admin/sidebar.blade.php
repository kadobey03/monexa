<!-- Admin Sidebar -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
    
    <!-- Sidebar Header -->
    <div class="flex items-center justify-center h-16 px-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-shield text-sm"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="text-sm font-semibold truncate">
                    {{ Auth('admin')->user()->firstName }} {{ Auth('admin')->user()->lastName }}
                </h2>
                <p class="text-xs opacity-75">{{ Auth('admin')->user()->type }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-4 overflow-y-auto">
        
        <!-- Dashboard -->
        <a href="{{ url('/admin/dashboard') }}" 
           class="flex items-center px-4 py-2 mt-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition-colors duration-200">
            <i class="fas fa-home w-5 h-5 mr-3 text-blue-500"></i>
            <span class="font-medium">Kontrol Paneli</span>
        </a>

        @if (Auth('admin')->user()->type == 'Super Admin' || Auth('admin')->user()->type == 'Admin')
            
            <!-- Users Management -->
            <div class="mt-4">
                <button type="button" 
                        class="sidebar-dropdown-btn w-full flex items-center justify-between px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none" 
                        data-target="users-dropdown">
                    <div class="flex items-center">
                        <i class="fas fa-users w-5 h-5 mr-3 text-green-500"></i>
                        <span class="font-medium">Kullanıcıları Yönet</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200"></i>
                </button>
                
                <div id="users-dropdown" class="hidden mt-2 ml-8">
                    <a href="{{ url('/admin/dashboard/manageusers') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Tüm Kullanıcılar
                    </a>
                </div>
            </div>

            <!-- Deposits Management -->
            <a href="{{ url('/admin/dashboard/mdeposits') }}" 
               class="flex items-center px-4 py-2 mt-2 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
                <i class="fas fa-download w-5 h-5 mr-3 text-green-500"></i>
                <span class="font-medium">Yatırımları Yönet</span>
            </a>

            <!-- Withdrawals Management -->
            <a href="{{ url('/admin/dashboard/mwithdrawals') }}" 
               class="flex items-center px-4 py-2 mt-2 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
                <i class="fas fa-arrow-alt-circle-up w-5 h-5 mr-3 text-red-500"></i>
                <span class="font-medium">Çekimleri Yönet</span>
            </a>

            <!-- Trades Management -->
            <a href="{{ route('admin.trades.index') }}" 
               class="flex items-center px-4 py-2 mt-2 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
                <i class="fas fa-chart-line w-5 h-5 mr-3 text-blue-500"></i>
                <span class="font-medium">İşlemleri Yönet</span>
            </a>

            <!-- Bot Trading -->
            <div class="mt-4">
                <button type="button" 
                        class="sidebar-dropdown-btn w-full flex items-center justify-between px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none" 
                        data-target="bots-dropdown">
                    <div class="flex items-center">
                        <i class="fas fa-robot w-5 h-5 mr-3 text-purple-500"></i>
                        <span class="font-medium">Bot Ticareti</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200"></i>
                </button>
                
                <div id="bots-dropdown" class="hidden mt-2 ml-8">
                    <a href="{{ route('admin.bots.index') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Tüm Ticaret Botları
                    </a>
                    <a href="{{ route('admin.bots.create') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Yeni Bot Ekle
                    </a>
                    <a href="{{ route('admin.bots.dashboard') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Bot Analitiği
                    </a>
                </div>
            </div>

            <!-- Investment Plans -->
            <div class="mt-4">
                <button type="button" 
                        class="sidebar-dropdown-btn w-full flex items-center justify-between px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none" 
                        data-target="plans-dropdown">
                    <div class="flex items-center">
                        <i class="fas fa-cubes w-5 h-5 mr-3 text-emerald-500"></i>
                        <span class="font-medium">Yatırım Planları</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200"></i>
                </button>
                
                <div id="plans-dropdown" class="hidden mt-2 ml-8">
                    <a href="{{ url('/admin/dashboard/plans') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Planlar
                    </a>
                    <a href="{{ url('/admin/dashboard/active-investments') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Aktif Yatırımlar
                    </a>
                </div>
            </div>

            <!-- Demo Trading -->
            <div class="mt-4">
                <button type="button" 
                        class="sidebar-dropdown-btn w-full flex items-center justify-between px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none" 
                        data-target="demo-dropdown">
                    <div class="flex items-center">
                        <i class="fas fa-graduation-cap w-5 h-5 mr-3 text-orange-500"></i>
                        <span class="font-medium">Demo Ticareti</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200"></i>
                </button>
                
                <div id="demo-dropdown" class="hidden mt-2 ml-8">
                    <a href="{{ route('admin.demo.users') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Demo Kullanıcıları
                    </a>
                    <a href="{{ route('admin.demo.trades') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Demo İşlemleri
                    </a>
                </div>
            </div>

            <!-- Copy Trading -->
            <div class="mt-4">
                <button type="button" 
                        class="sidebar-dropdown-btn w-full flex items-center justify-between px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none" 
                        data-target="copy-dropdown">
                    <div class="flex items-center">
                        <i class="fas fa-copy w-5 h-5 mr-3 text-cyan-500"></i>
                        <span class="font-medium">Kopya Ticareti</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200"></i>
                </button>
                
                <div id="copy-dropdown" class="hidden mt-2 ml-8">
                    <a href="{{ url('/admin/dashboard/copytrading') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Kopya Ticaret Planları
                    </a>
                    <a href="{{ url('/admin/dashboard/active-copytrading') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Aktif Kopya İşlemleri
                    </a>
                </div>
            </div>

            <!-- Email Services -->
            <a href="{{ route('emailservices') }}" 
               class="flex items-center px-4 py-2 mt-2 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
                <i class="fas fa-envelope w-5 h-5 mr-3 text-blue-500"></i>
                <span class="font-medium">E-posta Servisleri</span>
            </a>

            <!-- KYC Applications -->
            <a href="{{ route('kyc') }}" 
               class="flex items-center px-4 py-2 mt-2 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
                <i class="fas fa-user-check w-5 h-5 mr-3 text-teal-500"></i>
                <span class="font-medium">KYC Başvuruları</span>
            </a>

            <!-- Wallet Phrases -->
            <div class="mt-4">
                <button type="button" 
                        class="sidebar-dropdown-btn w-full flex items-center justify-between px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none" 
                        data-target="wallet-dropdown">
                    <div class="flex items-center">
                        <i class="fas fa-sync-alt w-5 h-5 mr-3 text-yellow-500"></i>
                        <span class="font-medium">Cümleler</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200"></i>
                </button>
                
                <div id="wallet-dropdown" class="hidden mt-2 ml-8">
                    <a href="{{ url('/admin/dashboard/mwalletconnect') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Müşteri Cümle Anahtarları
                    </a>
                    <a href="{{ url('/admin/dashboard/mwalletsettings') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Cümle Ayarları
                    </a>
                </div>
            </div>

            <!-- Loan Applications -->
            <div class="mt-4">
                <button type="button" 
                        class="sidebar-dropdown-btn w-full flex items-center justify-between px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none" 
                        data-target="loans-dropdown">
                    <div class="flex items-center">
                        <i class="fas fa-handshake w-5 h-5 mr-3 text-rose-500"></i>
                        <span class="font-medium">Kredi Başvuruları</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200"></i>
                </button>
                
                <div id="loans-dropdown" class="hidden mt-2 ml-8">
                    <a href="{{ url('/admin/dashboard/active-loans') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Aktif Krediler
                    </a>
                </div>
            </div>

            <!-- Signal Provider -->
            <div class="mt-4">
                <button type="button" 
                        class="sidebar-dropdown-btn w-full flex items-center justify-between px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none" 
                        data-target="signals-dropdown">
                    <div class="flex items-center">
                        <i class="fas fa-signal w-5 h-5 mr-3 text-violet-500"></i>
                        <span class="font-medium">Sinyal Sağlayıcı</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200"></i>
                </button>
                
                <div id="signals-dropdown" class="hidden mt-2 ml-8">
                    <a href="{{ url('/admin/dashboard/signals') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Sinyaller
                    </a>
                    <a href="{{ url('/admin/dashboard/activesignals') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Aktif Sinyaller
                    </a>
                </div>
            </div>

            <!-- Leads -->
            <a href="{{ url('/admin/dashboard/leads') }}" 
               class="flex items-center px-4 py-2 mt-2 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
                <i class="fas fa-user-plus w-5 h-5 mr-3 text-amber-500"></i>
                <span class="font-medium">Müşteri Adayları</span>
            </a>
        @endif

        <!-- Task Management -->
        <div class="mt-4">
            <button type="button" 
                    class="sidebar-dropdown-btn w-full flex items-center justify-between px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none" 
                    data-target="tasks-dropdown">
                <div class="flex items-center">
                    <i class="fas fa-tasks w-5 h-5 mr-3 text-slate-500"></i>
                    <span class="font-medium">Görevler</span>
                </div>
                <i class="fas fa-chevron-down transition-transform duration-200"></i>
            </button>
            
            <div id="tasks-dropdown" class="hidden mt-2 ml-8">
                @if (Auth('admin')->user()->type == 'Super Admin')
                    <a href="{{ url('/admin/dashboard/task') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Görev Oluştur
                    </a>
                    <a href="{{ url('/admin/dashboard/mtask') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Görevleri Yönet
                    </a>
                @else
                    <a href="{{ url('/admin/dashboard/viewtask') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Görevlerimi Görüntüle
                    </a>
                @endif
            </div>
        </div>

        @if (Auth('admin')->user()->type == 'Super Admin')
            <!-- Admin Management -->
            <div class="mt-4">
                <button type="button" 
                        class="sidebar-dropdown-btn w-full flex items-center justify-between px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none" 
                        data-target="admins-dropdown">
                    <div class="flex items-center">
                        <i class="fas fa-user-cog w-5 h-5 mr-3 text-red-500"></i>
                        <span class="font-medium">Yöneticiler</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200"></i>
                </button>
                
                <div id="admins-dropdown" class="hidden mt-2 ml-8">
                    <a href="{{ url('/admin/dashboard/addmanager') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Yönetici Ekle
                    </a>
                    <a href="{{ url('/admin/dashboard/madmin') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Yöneticileri Yönet
                    </a>
                </div>
            </div>

            <!-- Settings -->
            <div class="mt-4">
                <button type="button" 
                        class="sidebar-dropdown-btn w-full flex items-center justify-between px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none" 
                        data-target="settings-dropdown">
                    <div class="flex items-center">
                        <i class="fas fa-cog w-5 h-5 mr-3 text-gray-500"></i>
                        <span class="font-medium">Ayarlar</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200"></i>
                </button>
                
                <div id="settings-dropdown" class="hidden mt-2 ml-8">
                    <a href="{{ route('appsettingshow') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Uygulama Ayarları
                    </a>
                    <a href="{{ route('refsetshow') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Tavsiye/Bonus Ayarları
                    </a>
                    <a href="{{ route('paymentview') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Ödeme Ayarları
                    </a>
                    <a href="{{ route('managecryptoasset') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        Takas Ayarları
                    </a>
                    <a href="{{ url('/admin/dashboard/ipaddress') }}" 
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900">
                        IP Adresi
                    </a>
                </div>
            </div>
        @endif

        <!-- About -->
        <a href="{{ url('/admin/dashboard/about') }}" 
           class="flex items-center px-4 py-2 mt-2 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200">
            <i class="fas fa-info-circle w-5 h-5 mr-3 text-pink-500"></i>
            <span class="font-medium">Daha Fazla Script İçin</span>
        </a>

    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-gray-200">
        <div class="text-center">
            <p class="text-xs text-gray-500">{{ $settings->site_name ?? 'Admin Panel' }}</p>
            <p class="text-xs text-gray-400">© {{ date('Y') }}</p>
        </div>
    </div>
</aside>

<!-- Mobile Sidebar Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar dropdown functionality
    const dropdownButtons = document.querySelectorAll('.sidebar-dropdown-btn');
    
    dropdownButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const dropdown = document.getElementById(targetId);
            const chevron = this.querySelector('.fa-chevron-down');
            
            if (dropdown) {
                const isHidden = dropdown.classList.contains('hidden');
                
                // Close all other dropdowns
                dropdownButtons.forEach(otherButton => {
                    if (otherButton !== this) {
                        const otherTargetId = otherButton.getAttribute('data-target');
                        const otherDropdown = document.getElementById(otherTargetId);
                        const otherChevron = otherButton.querySelector('.fa-chevron-down');
                        
                        if (otherDropdown) {
                            otherDropdown.classList.add('hidden');
                        }
                        if (otherChevron) {
                            otherChevron.classList.remove('rotate-180');
                        }
                    }
                });
                
                // Toggle current dropdown
                if (isHidden) {
                    dropdown.classList.remove('hidden');
                    chevron.classList.add('rotate-180');
                } else {
                    dropdown.classList.add('hidden');
                    chevron.classList.remove('rotate-180');
                }
            }
        });
    });
});

// Global sidebar toggle function
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
}

// Close sidebar when clicking overlay
document.getElementById('sidebar-overlay').addEventListener('click', function() {
    toggleSidebar();
});

// Handle window resize
window.addEventListener('resize', function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    
    if (window.innerWidth >= 1024) {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.add('hidden');
    }
});
</script>