<!-- Modern Admin Sidebar -->
<div class="sidebar sidebar-redesign" x-data="{ activeSection: null }">
    <div class="sidebar-wrapper">
        <!-- Admin Profile Card -->
        <div class="admin-profile p-4 mb-3">
            <div class="d-flex align-items-center">
                <div class="avatar-container me-3">
                    <div class="avatar-circle bg-primary bg-gradient text-white">
                        {{ substr(Auth('admin')->User()->firstName, 0, 1) }}{{ substr(Auth('admin')->User()->lastName, 0, 1) }}
                    </div>
                    <span class="status-dot bg-success"></span>
                </div>
                <div class="admin-info">
                    <h5 class="mb-1 fw-bold">{{ Auth('admin')->User()->firstName }} {{ Auth('admin')->User()->lastName }}</h5>
                    <div class="admin-role">
                        <span class="badge bg-primary-soft text-primary">{{ Auth('admin')->User()->type }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Navigation -->
        <div class="sidebar-nav">
            <ul class="nav-list">
                
                <!-- Admin Category Header -->
                @if (Auth('admin')->user()->type == 'Admin')
                <li class="nav-category-header">
                    <div class="category-title">
                        <i class="fas fa-shield-alt category-icon"></i>
                        <span class="category-text">Admin</span>
                    </div>
                </li>
                @endif

                <!-- Super Admin Category Header -->
                @if (Auth('admin')->user()->type == 'Super Admin')
                <li class="nav-category-header">
                    <div class="category-title">
                        <i class="fas fa-crown category-icon"></i>
                        <span class="category-text">Super Admin deneme</span>
                    </div>
                </li>
                @endif

                <!-- Dashboard (Kontrol Paneli) -->
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                        <div class="nav-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <span class="nav-text">Kontrol Paneli</span>
                    </a>
                </li>

                @if (Auth('admin')->user()->type == 'Super Admin' || Auth('admin')->user()->type == 'Admin')
                    <!-- User Management (Kullanıcı Yönetimi) -->
                    <li class="nav-section" @click="activeSection = activeSection === 'users' ? null : 'users'">
                        <div class="nav-section-header">
                            <div class="nav-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <span class="nav-text">Kullanıcı Yönetimi</span>
                            <div class="nav-arrow" :class="{ 'rotated': activeSection === 'users' }">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                        <ul class="nav-section-items" x-show="activeSection === 'users'" x-collapse>
                            <li class="nav-item {{ request()->routeIs('manageusers') ? 'active' : '' }}">
                                <a href="{{ url('/admin/dashboard/manageusers') }}" class="nav-link">
                                    <span class="nav-text">Tüm Kullanıcılar</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Finance Management (Finans Yönetimi) -->
                    <li class="nav-section" @click="activeSection = activeSection === 'finance' ? null : 'finance'">
                        <div class="nav-section-header">
                            <div class="nav-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <span class="nav-text">Finans Yönetimi</span>
                            <div class="nav-arrow" :class="{ 'rotated': activeSection === 'finance' }">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                        <ul class="nav-section-items" x-show="activeSection === 'finance'" x-collapse>
                            <li class="nav-item {{ request()->routeIs('mdeposits') ? 'active' : '' }}">
                                <a href="{{ url('/admin/dashboard/mdeposits') }}" class="nav-link">
                                    <span class="nav-text">Yatırım Yönetimi</span>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('mwithdrawals') ? 'active' : '' }}">
                                <a href="{{ url('/admin/dashboard/mwithdrawals') }}" class="nav-link">
                                    <span class="nav-text">Çekim Yönetimi</span>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('admin.trades.index') ? 'active' : '' }}">
                                <a href="{{ route('admin.trades.index') }}" class="nav-link">
                                    <span class="nav-text">İşlem Yönetimi</span>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->url() == url('/admin/trades') ? 'active' : '' }}">
                                <a href="{{ url('/admin/trades') }}" class="nav-link">
                                    <span class="nav-text">Trades</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <!-- Communication (İletişim) -->
                    <li class="nav-section" @click="activeSection = activeSection === 'communication' ? null : 'communication'">
                        <div class="nav-section-header">
                            <div class="nav-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <span class="nav-text">İletişim</span>
                            <div class="nav-arrow" :class="{ 'rotated': activeSection === 'communication' }">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                        <ul class="nav-section-items" x-show="activeSection === 'communication'" x-collapse>
                            <li class="nav-item">
                                <a href="{{ route('emailservices') }}" class="nav-link">
                                    <span class="nav-text">E-posta Servisleri</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Compliance (Uyumluluk) -->
                    <li class="nav-section" @click="activeSection = activeSection === 'compliance' ? null : 'compliance'">
                        <div class="nav-section-header">
                            <div class="nav-icon">
                                <i class="fas fa-shield-check"></i>
                            </div>
                            <span class="nav-text">Uyumluluk</span>
                            <div class="nav-arrow" :class="{ 'rotated': activeSection === 'compliance' }">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                        <ul class="nav-section-items" x-show="activeSection === 'compliance'" x-collapse>
                            <li class="nav-item">
                                <a href="{{ route('kyc') }}" class="nav-link">
                                    <span class="nav-text">KYC Başvuruları</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Content Management (İçerik Yönetimi) -->
                    <li class="nav-section" @click="activeSection = activeSection === 'content' ? null : 'content'">
                        <div class="nav-section-header">
                            <div class="nav-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <span class="nav-text">İçerik Yönetimi</span>
                            <div class="nav-arrow" :class="{ 'rotated': activeSection === 'content' }">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                        <ul class="nav-section-items" x-show="activeSection === 'content'" x-collapse>
                            <li class="nav-item">
                                <a href="{{ route('admin.phrases') }}" class="nav-link">
                                    <span class="nav-text">Dil/Cümleler</span>
                                </a>
                            </li>
                            @if (Auth('admin')->user()->type == 'Super Admin')
                            <li class="nav-item">
                                <a href="{{ url('/admin/dashboard/task') }}" class="nav-link">
                                    <span class="nav-text">Görev Oluştur</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/admin/dashboard/mtask') }}" class="nav-link">
                                    <span class="nav-text">Görevleri Yönet</span>
                                </a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a href="{{ url('/admin/dashboard/viewtask') }}" class="nav-link">
                                    <span class="nav-text">Görevlerim</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>

                    <!-- Leads & Marketing (Potansiyel Müşteriler) -->
                    <li class="nav-section" @click="activeSection = activeSection === 'leads' ? null : 'leads'">
                        <div class="nav-section-header">
                            <div class="nav-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <span class="nav-text">Potansiyel Müşteriler</span>
                            <div class="nav-arrow" :class="{ 'rotated': activeSection === 'leads' }">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                        <ul class="nav-section-items" x-show="activeSection === 'leads'" x-collapse>
                            <li class="nav-item">
                                <a href="{{ route('admin.leads.index') }}" class="nav-link">
                                    <span class="nav-text">Müşteri Adayları</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (Auth('admin')->user()->type == 'Super Admin')
                    <!-- System Management (Sistem Yönetimi) -->
                    <li class="nav-section" @click="activeSection = activeSection === 'system' ? null : 'system'">
                        <div class="nav-section-header">
                            <div class="nav-icon">
                                <i class="fas fa-server"></i>
                            </div>
                            <span class="nav-text">Sistem Yönetimi</span>
                            <div class="nav-arrow" :class="{ 'rotated': activeSection === 'system' }">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                        <ul class="nav-section-items" x-show="activeSection === 'system'" x-collapse>
                            <li class="nav-item">
                                <a href="{{ url('/admin/dashboard/addmanager') }}" class="nav-link">
                                    <span class="nav-text">Yönetici Ekle</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.managers.index') }}" class="nav-link">
                                    <span class="nav-text">Yöneticileri Yönet (Modern)</span>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('appsettingshow') ? 'active' : '' }}">
                                <a href="{{ route('appsettingshow') }}" class="nav-link">
                                    <span class="nav-text">Uygulama Ayarları</span>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('refsetshow') ? 'active' : '' }}">
                                <a href="{{ route('refsetshow') }}" class="nav-link">
                                    <span class="nav-text">Tavsiye/Bonus Ayarları</span>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('paymentview') ? 'active' : '' }}">
                                <a href="{{ route('paymentview') }}" class="nav-link">
                                    <span class="nav-text">Ödeme Ayarları</span>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('managecryptoasset') ? 'active' : '' }}">
                                <a href="{{ route('managecryptoasset') }}" class="nav-link">
                                    <span class="nav-text">Takas Ayarları</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/admin/dashboard/ipaddress') }}" class="nav-link">
                                    <span class="nav-text">IP Adresi</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/admin/dashboard/about') }}" class="nav-link">
                                    <span class="nav-text">Daha Fazla Script İçin</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Logout -->
                <li class="nav-divider"></li>
                <li class="nav-item">
                    <a href="{{ route('adminlogout') }}" class="nav-link text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <div class="nav-icon">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <span class="nav-text">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('adminlogout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
/* Modern Sidebar Styling */
.sidebar-redesign {
    background-color: #ffffff;
    width: 260px;
    height: 100vh !important;
    max-height: 100vh !important;
    position: fixed;
    left: 0;
    top: 0;
    overflow-y: auto !important;
    overflow-x: hidden !important;
    z-index: 100;
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    scrollbar-width: thin;
    scrollbar-color: rgba(0,0,0,0.2) transparent;
    display: flex;
    flex-direction: column;
}

/* Dark Mode Support */
.dark .sidebar-redesign {
    background-color: #1a1a27;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
}

/* Admin Profile Styling */
.admin-profile {
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.dark .admin-profile {
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.avatar-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1.1rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.avatar-container {
    position: relative;
}

.status-dot {
    position: absolute;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #ffffff;
    bottom: 0;
    right: 0;
}

.dark .status-dot {
    border-color: #1a1a27;
}

.admin-info h5 {
    color: #111827;
    font-size: 0.95rem;
}

.dark .admin-info h5 {
    color: #f3f4f6;
}

.admin-role {
    font-size: 0.8rem;
}

.bg-primary-soft {
    background-color: rgba(79, 70, 229, 0.1);
}

/* Category Headers */
.nav-category-header {
    margin: 1.5rem 0 1rem 0;
    padding: 0 1.5rem;
}

.category-title {
    display: flex;
    align-items: center;
    color: #374151;
    font-weight: 700;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    opacity: 0.8;
}

.dark .category-title {
    color: #9ca3af;
}

.category-icon {
    margin-right: 0.5rem;
    font-size: 1rem;
    color: #4f46e5;
}

.dark .category-icon {
    color: #818cf8;
}

.category-text {
    position: relative;
}

.category-text::after {
    content: '';
    position: absolute;
    bottom: -0.25rem;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, #4f46e5, transparent);
    border-radius: 1px;
}

.dark .category-text::after {
    background: linear-gradient(90deg, #818cf8, transparent);
}

/* Sidebar Wrapper */
.sidebar-wrapper {
    display: flex;
    flex-direction: column;
    height: 100%;
    /* overflow: hidden; REMOVED - This was blocking scroll */
}

/* Sidebar Navigation Styling */
.sidebar-nav {
    padding: 1.5rem 0;
    flex: 1;
    overflow-y: auto !important;
    overflow-x: hidden;
    scrollbar-width: thin;
    scrollbar-color: rgba(0,0,0,0.2) transparent;
    max-height: calc(100vh - 120px); /* Ensure scrollable area */
}

/* Navigation Scrollbar - Made more visible */
.sidebar-nav::-webkit-scrollbar {
    width: 6px;
}

.sidebar-nav::-webkit-scrollbar-track {
    background: rgba(0,0,0,0.03);
}

.sidebar-nav::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.25) !important;
    border-radius: 3px;
}

.sidebar-nav::-webkit-scrollbar-thumb:hover {
    background-color: rgba(0,0,0,0.4) !important;
}

.dark .sidebar-nav::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.03);
}

.dark .sidebar-nav::-webkit-scrollbar-thumb {
    background-color: rgba(255,255,255,0.15) !important;
}

.dark .sidebar-nav::-webkit-scrollbar-thumb:hover {
    background-color: rgba(255,255,255,0.25) !important;
}

.nav-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav-item {
    margin: 2px 0;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 0.7rem 1.5rem;
    color: #6b7280;
    text-decoration: none;
    font-size: 0.875rem;
    border-radius: 0.375rem;
    margin: 0 0.75rem;
    transition: all 0.2s ease;
}

.dark .nav-link {
    color: #9ca3af;
}

.nav-link:hover {
    color: #4f46e5;
    background-color: rgba(79, 70, 229, 0.05);
}

.dark .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.05);
}

.nav-item.active .nav-link {
    color: #4f46e5;
    background-color: rgba(79, 70, 229, 0.1);
    font-weight: 500;
}

.dark .nav-item.active .nav-link {
    color: #818cf8;
    background-color: rgba(129, 140, 248, 0.1);
}

.nav-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    margin-right: 0.75rem;
    font-size: 0.875rem;
}

.nav-text {
    flex: 1;
}

.nav-badge {
    font-size: 0.65rem;
    padding: 0.15rem 0.4rem;
    border-radius: 10px;
}

/* Section Headers */
.nav-section {
    margin-bottom: 0.5rem;
}

.nav-section-header {
    display: flex;
    align-items: center;
    padding: 0.7rem 1.5rem;
    color: #374151;
    cursor: pointer;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease;
    margin: 0 0.75rem;
    border-radius: 0.375rem;
}

.dark .nav-section-header {
    color: #d1d5db;
}

.nav-section-header:hover {
    color: #4f46e5;
    background-color: rgba(79, 70, 229, 0.05);
}

.dark .nav-section-header:hover {
    background-color: rgba(255, 255, 255, 0.05);
}

.nav-arrow {
    margin-left: 0.5rem;
    font-size: 0.75rem;
    transition: transform 0.3s ease;
}

.nav-arrow.rotated {
    transform: rotate(90deg);
}

/* Section Items */
.nav-section-items {
    padding-left: 2.5rem;
}

/* Divider */
.nav-divider {
    height: 1px;
    margin: 1rem 1.5rem;
    background-color: rgba(0,0,0,0.05);
}

.dark .nav-divider {
    background-color: rgba(255,255,255,0.05);
}

/* Scrollbar Styling - Made more visible */
.sidebar-redesign::-webkit-scrollbar {
    width: 8px;
}

.sidebar-redesign::-webkit-scrollbar-track {
    background: rgba(0,0,0,0.05);
}

.sidebar-redesign::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.3) !important;
    border-radius: 4px;
}

.sidebar-redesign::-webkit-scrollbar-thumb:hover {
    background-color: rgba(0,0,0,0.5) !important;
}

.dark .sidebar-redesign::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.05);
}

.dark .sidebar-redesign::-webkit-scrollbar-thumb {
    background-color: rgba(255,255,255,0.2) !important;
}

.dark .sidebar-redesign::-webkit-scrollbar-thumb:hover {
    background-color: rgba(255,255,255,0.3) !important;
}

/* Responsive Adjustments */
@media (max-width: 992px) {
    .sidebar-redesign {
        transform: translateX(-100%);
        box-shadow: none;
    }

    .sidebar-redesign.active {
        transform: translateX(0);
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
}

/* Alpine.js Transitions */
[x-cloak] { display: none !important; }
</style>
