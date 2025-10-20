<!-- Admin Sidebar -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out sidebar-default">
    
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
           class="no-underline flex items-center px-4 py-2 mt-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition-colors duration-200">
            <i class="fas fa-home w-5 h-5 mr-3 text-blue-500"></i>
            <span class="font-medium">Kontrol Paneli</span>
        </a>

        @if (Auth('admin')->user()->type == 'Super Admin' || Auth('admin')->user()->type == 'Admin')
            
            <!-- Users Management -->
            <div class="mt-4">
                <button type="button"
                        class="sidebar-dropdown-btn w-full flex items-center justify-between px-4 py-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:bg-blue-50 focus:text-blue-700 transition-colors duration-200"
                        data-target="users-dropdown">
                    <div class="flex items-center">
                        <i class="fas fa-users w-5 h-5 mr-3 text-green-500"></i>
                        <span class="font-medium">Kullanıcıları Yönet</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200"></i>
                </button>
                
                <div id="users-dropdown" class="hidden mt-2 ml-8 bg-white rounded-lg shadow-sm border-l-2 border-blue-200">
                    <a href="{{ url('/admin/dashboard/manageusers') }}"
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                        Tüm Kullanıcılar
                    </a>
                </div>
            </div>

            <!-- Deposits Management -->
            <a href="{{ url('/admin/dashboard/mdeposits') }}"
               class="no-underline flex items-center px-4 py-2 mt-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                <i class="fas fa-download w-5 h-5 mr-3 text-green-500"></i>
                <span class="font-medium">Yatırımları Yönet</span>
            </a>

            <!-- Withdrawals Management -->
            <a href="{{ url('/admin/dashboard/mwithdrawals') }}"
               class="no-underline flex items-center px-4 py-2 mt-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                <i class="fas fa-arrow-alt-circle-up w-5 h-5 mr-3 text-red-500"></i>
                <span class="font-medium">Çekimleri Yönet</span>
            </a>

            <!-- Trades Management -->
            <a href="{{ route('admin.trades.index') }}"
               class="no-underline flex items-center px-4 py-2 mt-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                <i class="fas fa-chart-line w-5 h-5 mr-3 text-blue-500"></i>
                <span class="font-medium">İşlemleri Yönet</span>
            </a>


            <!-- Email Services -->
            <a href="{{ route('emailservices') }}"
               class="no-underline flex items-center px-4 py-2 mt-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                <i class="fas fa-envelope w-5 h-5 mr-3 text-blue-500"></i>
                <span class="font-medium">E-posta Servisleri</span>
            </a>

            <!-- KYC Applications -->
            <a href="{{ route('kyc') }}"
               class="no-underline flex items-center px-4 py-2 mt-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                <i class="fas fa-user-check w-5 h-5 mr-3 text-teal-500"></i>
                <span class="font-medium">KYC Başvuruları</span>
            </a>


            <!-- Leads -->
            <a href="{{ url('/admin/dashboard/leads') }}"
               class="no-underline flex items-center px-4 py-2 mt-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                <i class="fas fa-user-plus w-5 h-5 mr-3 text-amber-500"></i>
                <span class="font-medium">Müşteri Adayları</span>
            </a>
        @endif

        <!-- Task Management -->
        <div class="mt-4">
            <button type="button"
                    class="sidebar-dropdown-btn w-full flex items-center justify-between px-4 py-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:bg-blue-50 focus:text-blue-700 transition-colors duration-200"
                    data-target="tasks-dropdown">
                <div class="flex items-center">
                    <i class="fas fa-tasks w-5 h-5 mr-3 text-slate-500"></i>
                    <span class="font-medium">Görevler</span>
                </div>
                <i class="fas fa-chevron-down transition-transform duration-200"></i>
            </button>
            
            <div id="tasks-dropdown" class="hidden mt-2 ml-8 bg-white rounded-lg shadow-sm border-l-2 border-slate-200">
                @if (Auth('admin')->user()->type == 'Super Admin')
                    <a href="{{ url('/admin/dashboard/task') }}"
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                        Görev Oluştur
                    </a>
                    <a href="{{ url('/admin/dashboard/mtask') }}"
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                        Görevleri Yönet
                    </a>
                @else
                    <a href="{{ url('/admin/dashboard/viewtask') }}"
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                        Görevlerimi Görüntüle
                    </a>
                @endif
            </div>
        </div>

        @if (Auth('admin')->user()->type == 'Super Admin')
            <!-- Admin Management -->
            <div class="mt-4">
                <button type="button"
                        class="sidebar-dropdown-btn w-full flex items-center justify-between px-4 py-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:bg-blue-50 focus:text-blue-700 transition-colors duration-200"
                        data-target="admins-dropdown">
                    <div class="flex items-center">
                        <i class="fas fa-user-cog w-5 h-5 mr-3 text-red-500"></i>
                        <span class="font-medium">Yöneticiler</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200"></i>
                </button>
                
                <div id="admins-dropdown" class="hidden mt-2 ml-8 bg-white rounded-lg shadow-sm border-l-2 border-red-200">
                    <a href="{{ url('/admin/dashboard/addmanager') }}"
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                        Yönetici Ekle
                    </a>
                    <a href="{{ url('/admin/dashboard/madmin') }}"
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                        Yöneticileri Yönet
                    </a>
                </div>
            </div>

            <!-- Settings -->
            <div class="mt-4">
                <button type="button"
                        class="sidebar-dropdown-btn w-full flex items-center justify-between px-4 py-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:bg-blue-50 focus:text-blue-700 transition-colors duration-200"
                        data-target="settings-dropdown">
                    <div class="flex items-center">
                        <i class="fas fa-cog w-5 h-5 mr-3 text-gray-500"></i>
                        <span class="font-medium">Ayarlar</span>
                    </div>
                    <i class="fas fa-chevron-down transition-transform duration-200"></i>
                </button>
                
                <div id="settings-dropdown" class="hidden mt-2 ml-8 bg-white rounded-lg shadow-sm border-l-2 border-gray-300">
                    <a href="{{ route('appsettingshow') }}"
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                        Uygulama Ayarları
                    </a>
                    <a href="{{ route('refsetshow') }}"
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                        Tavsiye/Bonus Ayarları
                    </a>
                    <a href="{{ route('paymentview') }}"
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                        Ödeme Ayarları
                    </a>
                    <a href="{{ route('managecryptoasset') }}"
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                        Takas Ayarları
                    </a>
                    <a href="{{ url('/admin/dashboard/ipaddress') }}"
                       class="block px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                        IP Adresi
                    </a>
                </div>
            </div>
        @endif

        <!-- About -->
        <a href="{{ url('/admin/dashboard/about') }}"
           class="no-underline flex items-center px-4 py-2 mt-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
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
    const mainContent = document.querySelector('.admin-main-content');
    const header = document.querySelector('header');
    
    if (window.innerWidth >= 1024) {
        // Desktop behavior - use custom CSS classes
        const isHidden = sidebar.classList.contains('sidebar-hidden');
        
        if (isHidden) {
            // Show sidebar
            sidebar.classList.remove('sidebar-hidden');
            sidebar.classList.add('sidebar-visible');
            if (mainContent) {
                mainContent.classList.remove('lg:ml-0');
                mainContent.classList.add('lg:ml-64');
            }
            if (header) {
                header.classList.remove('lg:left-0', 'lg:w-full');
                header.classList.add('lg:left-64', 'lg:w-[calc(100%-16rem)]');
            }
        } else {
            // Hide sidebar
            sidebar.classList.remove('sidebar-visible', 'sidebar-default');
            sidebar.classList.add('sidebar-hidden');
            if (mainContent) {
                mainContent.classList.remove('lg:ml-64');
                mainContent.classList.add('lg:ml-0');
            }
            if (header) {
                header.classList.remove('lg:left-64', 'lg:w-[calc(100%-16rem)]');
                header.classList.add('lg:left-0', 'lg:w-full');
            }
        }
    } else {
        // Mobile behavior
        const isHidden = sidebar.classList.contains('sidebar-visible');
        
        if (isHidden) {
            sidebar.classList.remove('sidebar-visible');
            sidebar.classList.add('sidebar-default');
            if (overlay) overlay.classList.add('hidden');
        } else {
            sidebar.classList.remove('sidebar-default');
            sidebar.classList.add('sidebar-visible');
            if (overlay) overlay.classList.remove('hidden');
        }
    }
}

// Close sidebar when clicking overlay (mobile only)
document.addEventListener('click', function(event) {
    if (event.target.id === 'sidebar-overlay') {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        
        sidebar.classList.remove('sidebar-visible');
        sidebar.classList.add('sidebar-default');
        if (overlay) overlay.classList.add('hidden');
    }
});

// Handle window resize
window.addEventListener('resize', function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const mainContent = document.querySelector('.admin-main-content');
    const header = document.querySelector('header');
    
    if (window.innerWidth >= 1024) {
        // Desktop - ensure proper state
        if (overlay) overlay.classList.add('hidden');
        
        const isHidden = sidebar.classList.contains('sidebar-hidden');
        if (!isHidden && !sidebar.classList.contains('sidebar-visible')) {
            // Default state - show sidebar
            sidebar.classList.remove('sidebar-default');
            sidebar.classList.add('sidebar-visible');
        }
        
        if (sidebar.classList.contains('sidebar-visible')) {
            // Sidebar is visible
            if (mainContent) {
                mainContent.classList.add('lg:ml-64');
                mainContent.classList.remove('lg:ml-0');
            }
            if (header) {
                header.classList.add('lg:left-64', 'lg:w-[calc(100%-16rem)]');
                header.classList.remove('lg:left-0', 'lg:w-full');
            }
        } else {
            // Sidebar is hidden
            if (mainContent) {
                mainContent.classList.remove('lg:ml-64');
                mainContent.classList.add('lg:ml-0');
            }
            if (header) {
                header.classList.remove('lg:left-64', 'lg:w-[calc(100%-16rem)]');
                header.classList.add('lg:left-0', 'lg:w-full');
            }
        }
    } else {
        // Mobile - reset to default
        sidebar.className = sidebar.className.replace(/sidebar-(visible|hidden)/g, '');
        sidebar.classList.add('sidebar-default');
        if (mainContent) {
            mainContent.classList.remove('lg:ml-64', 'lg:ml-0');
        }
        if (header) {
            header.classList.remove('lg:left-64', 'lg:w-[calc(100%-16rem)]', 'lg:left-0', 'lg:w-full');
        }
    }
});
</script>