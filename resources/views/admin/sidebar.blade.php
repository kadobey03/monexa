<!-- Admin Sidebar -->
<div class="sidebar" data-background-color="dark" data-active-color="danger">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ url('admin/dashboard') }}" class="simple-text">
                {{ $settings->site_name ?? 'Admin Panel' }}
            </a>
        </div>
        
        <ul class="nav">
            <!-- Dashboard -->
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ url('admin/dashboard') }}">
                    <i class="ti-panel"></i>
                    <p>Kontrol Paneli</p>
                </a>
            </li>
            
            @if (Auth('admin')->user()->type == 'Super Admin' || Auth('admin')->user()->type == 'Admin')
                <!-- Kullanıcı Yönetimi -->
                <li class="{{ request()->routeIs('manageusers') ? 'active' : '' }}">
                    <a href="{{ url('admin/dashboard/manageusers') }}">
                        <i class="ti-user"></i>
                        <p>Kullanıcıları Yönet</p>
                    </a>
                </li>
                
                <!-- Finans Yönetimi -->
                <li class="{{ request()->routeIs('mdeposits') ? 'active' : '' }}">
                    <a href="{{ url('admin/dashboard/mdeposits') }}">
                        <i class="ti-wallet"></i>
                        <p>Yatırım Yönetimi</p>
                    </a>
                </li>
                
                <li class="{{ request()->routeIs('mwithdrawals') ? 'active' : '' }}">
                    <a href="{{ url('admin/dashboard/mwithdrawals') }}">
                        <i class="ti-money"></i>
                        <p>Çekim Yönetimi</p>
                    </a>
                </li>
                
                <!-- Diğer Yönetim -->
                <li class="{{ request()->routeIs('emailservices') ? 'active' : '' }}">
                    <a href="{{ route('emailservices') }}">
                        <i class="ti-email"></i>
                        <p>E-posta Servisleri</p>
                    </a>
                </li>
                
                <li class="{{ request()->routeIs('kyc') ? 'active' : '' }}">
                    <a href="{{ route('kyc') }}">
                        <i class="ti-check"></i>
                        <p>KYC Başvuruları</p>
                    </a>
                </li>
                
                <li class="{{ request()->routeIs('admin.trades.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.trades.index') }}">
                        <i class="ti-stats-up"></i>
                        <p>İşlem Yönetimi</p>
                    </a>
                </li>
                
                <li class="{{ request()->routeIs('admin.leads.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.leads.index') }}">
                        <i class="ti-user"></i>
                        <p>Müşteri Adayları</p>
                    </a>
                </li>
                
                <!-- İçerik Yönetimi -->
                <li class="{{ request()->routeIs('admin.phrases') ? 'active' : '' }}">
                    <a href="{{ route('admin.phrases') }}">
                        <i class="ti-text"></i>
                        <p>Dil/Cümleler</p>
                    </a>
                </li>
            @endif
            
            @if (Auth('admin')->user()->type == 'Super Admin')
                <!-- Sistem Yönetimi -->
                <li>
                    <a href="{{ url('admin/dashboard/addmanager') }}">
                        <i class="ti-settings"></i>
                        <p>Yönetici Ekle</p>
                    </a>
                </li>
                
                <li class="{{ request()->routeIs('admin.managers.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.managers.index') }}">
                        <i class="ti-user"></i>
                        <p>Yöneticileri Yönet</p>
                    </a>
                </li>
                
                <li class="{{ request()->routeIs('appsettingshow') ? 'active' : '' }}">
                    <a href="{{ route('appsettingshow') }}">
                        <i class="ti-settings"></i>
                        <p>Sistem Ayarları</p>
                    </a>
                </li>
                
                <li class="{{ request()->routeIs('refsetshow') ? 'active' : '' }}">
                    <a href="{{ route('refsetshow') }}">
                        <i class="ti-gift"></i>
                        <p>Tavsiye/Bonus Ayarları</p>
                    </a>
                </li>
                
                <li class="{{ request()->routeIs('paymentview') ? 'active' : '' }}">
                    <a href="{{ route('paymentview') }}">
                        <i class="ti-credit-card"></i>
                        <p>Ödeme Ayarları</p>
                    </a>
                </li>
                
                <!-- Görev Yönetimi -->
                <li>
                    <a href="{{ url('admin/dashboard/task') }}">
                        <i class="ti-check-box"></i>
                        <p>Görev Oluştur</p>
                    </a>
                </li>
                
                <li>
                    <a href="{{ url('admin/dashboard/mtask') }}">
                        <i class="ti-list"></i>
                        <p>Görevleri Yönet</p>
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ url('admin/dashboard/viewtask') }}">
                        <i class="ti-view-list"></i>
                        <p>Görevlerim</p>
                    </a>
                </li>
            @endif
            
            <!-- Profil -->
            <li class="{{ request()->url() == url('admin/dashboard/adminprofile') ? 'active' : '' }}">
                <a href="{{ url('admin/dashboard/adminprofile') }}">
                    <i class="ti-user"></i>
                    <p>Hesap Ayarları</p>
                </a>
            </li>
            
            <li class="{{ request()->url() == url('admin/dashboard/adminchangepassword') ? 'active' : '' }}">
                <a href="{{ url('admin/dashboard/adminchangepassword') }}">
                    <i class="ti-key"></i>
                    <p>Şifre Değiştir</p>
                </a>
            </li>
            
            <!-- Çıkış -->
            <li>
                <a href="{{ route('adminlogout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="ti-shift-right"></i>
                    <p>Çıkış Yap</p>
                </a>
                <form id="logout-form" action="{{ route('adminlogout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>
</div>

<style>
.sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    width: 260px;
    display: block;
    z-index: 1;
    color: #FFFFFF;
    font-weight: 200;
    background-size: cover;
    background-position: center center;
    transition: all .5s cubic-bezier(0.685, 0.0473, 0.346, 1);
}

.sidebar[data-background-color="dark"] {
    background-color: #34495e;
}

.sidebar .sidebar-wrapper {
    position: relative;
    height: auto;
    overflow: auto;
    width: 260px;
    z-index: 4;
    padding-bottom: 100px;
}

.sidebar .sidebar-wrapper .logo {
    position: relative;
    padding: 15px 15px;
    z-index: 4;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.sidebar .sidebar-wrapper .logo a.simple-text {
    text-transform: uppercase;
    margin: 10px 0px;
    color: #FFFFFF;
    text-decoration: none;
    font-weight: 400;
    line-height: 30px;
    font-size: 18px;
}

.sidebar .sidebar-wrapper .nav {
    margin-top: 20px;
    display: block;
}

.sidebar .sidebar-wrapper .nav li {
    position: relative;
    display: block;
    width: 260px;
    margin: 0;
    padding: 0;
}

.sidebar .sidebar-wrapper .nav li a {
    margin: 0px 15px;
    border-radius: 30px;
    color: rgba(255, 255, 255, 0.8);
    display: block;
    text-decoration: none;
    position: relative;
    cursor: pointer;
    font-size: 13px;
    padding: 10px 15px;
    line-height: 1.9em;
    background: transparent;
    transition: all 300ms linear;
}

.sidebar .sidebar-wrapper .nav li:hover > a {
    color: #FFFFFF;
    background: rgba(255, 255, 255, 0.13);
}

.sidebar .sidebar-wrapper .nav li.active > a {
    color: #FFFFFF;
    background: rgba(255, 255, 255, 0.2);
    font-weight: 500;
}

.sidebar .sidebar-wrapper .nav li a i {
    font-size: 20px;
    float: left;
    margin-right: 15px;
    line-height: 1.5em;
    width: 20px;
    text-align: center;
}

.sidebar .sidebar-wrapper .nav li a p {
    margin: 0;
    line-height: 30px;
    font-weight: 400;
    font-size: 12px;
}

@media (max-width: 991px) {
    .sidebar {
        transform: translate3d(-260px, 0, 0);
        -webkit-transform: translate3d(-260px, 0, 0);
        -moz-transform: translate3d(-260px, 0, 0);
        -ms-transform: translate3d(-260px, 0, 0);
        -o-transform: translate3d(-260px, 0, 0);
    }
    
    .sidebar.open {
        transform: translate3d(0px, 0, 0);
        -webkit-transform: translate3d(0px, 0, 0);
        -moz-transform: translate3d(0px, 0, 0);
        -ms-transform: translate3d(0px, 0, 0);
        -o-transform: translate3d(0px, 0, 0);
    }
}
</style>