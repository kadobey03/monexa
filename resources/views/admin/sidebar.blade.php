<!-- Stored in resources/views/child.blade.php -->

<!-- Sidebar -->
<div class="sidebar sidebar-style-2" data-background-color="{{ Auth('admin')->User()->dashboard_style }}">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ Auth('admin')->User()->firstName }} {{ Auth('admin')->User()->lastName }}
                            <span class="user-level"> Yönetici</span>
                            {{-- <span class="caret"></span> --}}
                        </span>
                    </a>
                </div>
            </div>

            <ul class="nav nav-primary">
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ url('/admin/dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Kontrol Paneli</p>
                    </a>
                </li>

                @if (Auth('admin')->User()->type == 'Super Admin' || Auth('admin')->User()->type == 'Admin')
                  <li
                        class="nav-item {{ request()->routeIs('manageusers') ? 'active' : '' }} {{ request()->routeIs('loginactivity') ? 'active' : '' }} {{ request()->routeIs('user.plans') ? 'active' : '' }} {{ request()->routeIs('viewuser') ? 'active' : '' }}">
                        <a href="{{ url('/admin/dashboard/manageusers') }}">
                            <i class="fa fa-user-circle" aria-hidden="true"></i>
                            <p>Kullanıcıları Yönet</p>
                        </a>
                    </li>

                  <li
                        class="nav-item {{ request()->routeIs('mdeposits') ? 'active' : '' }} {{ request()->routeIs('viewdepositimage') ? 'active' : '' }} {{ request()->routeIs('mdeposits') ? 'active' : '' }}">
                        <a href="{{ url('/admin/dashboard/mdeposits') }}">
                            <i class="fa fa-download" aria-hidden="true"></i>
                            <p>Yatırımları Yönet</p>
                        </a>
                    </li>

                    <li
                        class="nav-item {{ request()->routeIs('mwithdrawals') ? 'active' : '' }}   {{ request()->routeIs('processwithdraw') ? 'active' : '' }}">
                        <a href="{{ url('/admin/dashboard/mwithdrawals') }}">
                            <i class="fa fa-arrow-alt-circle-up" aria-hidden="true"></i>
                            <p>Çekimleri Yönet</p>
                        </a>
                    </li>

                    <li
                        class="nav-item {{ request()->routeIs('admin.trades.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.trades.index') }}">
                            <i class="fas fa-chart-line" aria-hidden="true"></i>
                            <p>İşlemleri Yönet</p>
                        </a>
                    </li>

                  <li
                        class="nav-item {{ request()->routeIs('admin.bots.*') ? 'active' : '' }}">
                        <a data-toggle="collapse" href="#bots">
                            <i class="fas fa-robot"></i>
                            <p>Bot Ticareti</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="bots">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ route('admin.bots.index') }}">
                                        <span class="sub-item">Tüm Ticaret Botları</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.bots.create') }}">
                                        <span class="sub-item">Yeni Bot Ekle</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.bots.dashboard') }}">
                                        <span class="sub-item">Bot Analitiği</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <li
                    class="nav-item {{ request()->routeIs('plans') ? 'active' : '' }} {{ request()->routeIs('newplan') ? 'active' : '' }} {{ request()->routeIs('editplan') ? 'active' : '' }} {{ request()->routeIs('investments') ? 'active' : '' }} {{ request()->routeIs('admin.plans.*') ? 'active' : '' }}">
                    <a data-toggle="collapse" href="#pln">
                        <i class="fas fa-cubes "></i>
                        <p>Yatırım</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="pln">
                        <ul class="nav nav-collapse">
                            {{-- <li>
                                <a href="{{ route('admin.plans.index') }}">
                                    <span class="sub-item">New Investment Plans <span class="badge badge-success">New</span></span>
                                </a>
                            </li> --}}
                            <li>
                                <a href="{{ url('/admin/dashboard/plans') }}">
                                    <span class="sub-item">Eski Planlar</span>
                                </a>
                            </li>
                            {{-- <li>
                                <a href="{{ route('admin.plans.categories') }}">
                                    <span class="sub-item">Plan Categories</span>
                                </a>
                            </li>  --}}
                            <li>
                                <a href="{{ url('/admin/dashboard/active-investments') }}">
                                    <span class="sub-item">Aktif Yatırımlar</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Demo Trading Section -->
                <li class="nav-item {{ request()->routeIs('admin.demo.*') ? 'active' : '' }}">
                    <a data-toggle="collapse" href="#demo">
                        <i class="fas fa-graduation-cap"></i>
                        <p>Demo Ticareti</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="demo">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('admin.demo.users') }}">
                                    <span class="sub-item">Demo Kullanıcıları Yönet</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.demo.trades') }}">
                                    <span class="sub-item">Demo İşlemleri</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li
                        class="nav-item {{ request()->routeIs('copytradings') ? 'active' : '' }} {{ request()->routeIs('newcopytrading') ? 'active' : '' }} {{ request()->routeIs('editcopytrading') ? 'active' : '' }} {{ request()->routeIs('activecopytrading') ? 'active' : '' }} ">
                        <a data-toggle="collapse" href="#cpy">
                            <i class="fa fa-copyright "></i>
                            <p>Kopya Ticareti</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="cpy">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ url('/admin/dashboard/copytrading') }}">
                                        <span class="sub-item">Kopya Ticaret Planları</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/admin/dashboard/active-copytrading') }}">
                                        <span class="sub-item">Aktif Kopya İşlemleri</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                @endif
                @if (Auth('admin')->User()->type == 'Super Admin' || Auth('admin')->User()->type == 'Admin')
                    {{-- <li
                        class="nav-item  {{ request()->routeIs('activeinvestments') ? 'active' : '' }}">
                        <a data-toggle="collapse" href="#trades">
                            <i class="fas fa-cubes "></i>
                            <p> Clients Trades</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="trades">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ url('/admin/dashboard/plans') }}">
                                        <span class="sub-item">Investment Plans</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/admin/dashboard/investments') }}">
                                        <span class="sub-item">Active Trades</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}


                    <li class="nav-item {{ request()->routeIs('emailservices') ? 'active' : '' }}">
                        <a href="{{ route('emailservices') }}">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <p>E-posta Servisleri</p>
                        </a>
                    </li>

                    <li
                        class="nav-item {{ request()->routeIs('kyc') ? 'active' : '' }} {{ request()->routeIs('viewkyc') ? 'active' : '' }}">
                        <a href="{{ route('kyc') }}">
                            <i class="fa fa-user-check" aria-hidden="true"></i>
                            <p>KYC Başvuruları</p>
                        </a>
                    </li>


                    <li
                        class="nav-item {{ request()->routeIs('mwalletconnect') ? 'active' : '' }} {{ request()->routeIs('madmin') ? 'active' : '' }}">
                        <a data-toggle="collapse" href="#wal">
                        <i class="fa fa-sync-alt" aria-hidden="true"></i>
                            <p>Cümleler</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="wal">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ url('/admin/dashboard/mwalletconnect') }}">
                                        <span class="sub-item">Müşteri Cümle Anahtarları</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/admin/dashboard/mwalletsettings') }}">
                                        <span class="sub-item">Cümle Ayarları</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

<li
                        class="nav-item {{ request()->routeIs('loans') ? 'active' : '' }} ">
                        <a data-toggle="collapse" href="#lon">
                            <i class="fas fa-cubes "></i>
                            <p>Kredi Başvuruları</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="lon">
                            <ul class="nav nav-collapse">
                                {{-- <li>
                                    <a href="{{ url('/admin/dashboard/plans') }}">
                                        <span class="sub-item">Investment Plans</span>
                                    </a>
                                </li> --}}
                                <li>
                                    <a href="{{ url('/admin/dashboard/active-loans') }}">
                                        <span class="sub-item">Aktif Krediler</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li
                    class="nav-item {{ request()->routeIs('signals') ? 'active' : '' }} {{ request()->routeIs('signal.settings') ? 'active' : '' }} {{ request()->routeIs('signal.subs') ? 'active' : '' }}">
                    <a data-toggle="collapse" href="#signals">
                        <i class="fa fa-signal"></i>
                        <p>Sinyal Sağlayıcı</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="signals">
                        <ul class="nav nav-collapse">

                            <li>
                                <a href="{{ url('/admin/dashboard/signals') }}">
                                    <span class="sub-item">Sinyaller</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/admin/dashboard/activesignals') }}">
                                    <span class="sub-item">Aktif Sinyaller</span>
                                </a>
                            </li>
                            {{-- <li>
                                <a href="{{ route('signals') }}">
                                    <span class="sub-item">Trade Signals</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('signal.subs') }}">
                                    <span class="sub-item">Subscribers</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('signal.settings') }}">
                                    <span class="sub-item">Settings</span>
                                </a>
                            </li> --}}
                        </ul>
                    </div>
                </li>
                    {{-- <li
                        class="nav-item {{ request()->routeIs('msubtrade') ? 'active' : '' }} {{ request()->routeIs('tsettings') ? 'active' : '' }} {{ request()->routeIs('tacnts') ? 'active' : '' }} {{ request()->routeIs('subview') ? 'active' : '' }}">
                        <a data-toggle="collapse" href="#mgacnt">
                            <i class="fa fa-sync-alt"></i>
                            <p>Manage Accounts</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="mgacnt">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ route('msubtrade') }}">
                                        <span class="sub-item">Trading-Accounts</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('subview') }}">
                                        <span class="sub-item">Fee Settings</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}


                @endif
                <li
                    class="nav-item {{ request()->routeIs('task') ? 'active' : '' }} {{ request()->routeIs('mtask') ? 'active' : '' }} {{ request()->routeIs('viewtask') ? 'active' : '' }}">
                    <a data-toggle="collapse" href="#task">
                        <i class="fas fa-align-center"></i>
                        <p>Görev</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="task">
                        <ul class="nav nav-collapse">
                            @if (Auth('admin')->User()->type == 'Super Admin')
                                <li>
                                    <a href="{{ url('/admin/dashboard/task') }}">
                                        <span class="sub-item">Görev Oluştur</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/admin/dashboard/mtask') }}">
                                        <span class="sub-item">Görevleri Yönet</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth('admin')->User()->type != 'Super Admin')
                                <li>
                                    <a href="{{ url('/admin/dashboard/viewtask') }}">
                                        <span class="sub-item">Görevlerimi Görüntüle</span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </li>
                @if (Auth('admin')->User()->type == 'Super Admin' || Auth('admin')->User()->type == 'Admin')
                    <li class="nav-item {{ request()->routeIs('leads') ? 'active' : '' }}">
                        <a href="{{ url('/admin/dashboard/leads') }}">
                            <i class="fas fa-user-slash " aria-hidden="true"></i>
                            <p>Müşteri Adayları</p>
                        </a>
                    </li>
                @endif

                @if (Auth('admin')->User()->type == 'Rentention Agent' || Auth('admin')->User()->type == 'Conversion Agent')
                    <li class="nav-item {{ request()->routeIs('leadsassign') ? 'active' : '' }}">
                        <a href="{{ url('/admin/dashboard/leadsassign') }}">
                            <i class="fas fa-user-slash " aria-hidden="true"></i>
                            <p>Müşteri Adaylarım</p>
                        </a>
                    </li>
                @endif
                @if (Auth('admin')->User()->type == 'Super Admin')
                    <li
                        class="nav-item {{ request()->routeIs('addmanager') ? 'active' : '' }} {{ request()->routeIs('madmin') ? 'active' : '' }}">
                        <a data-toggle="collapse" href="#adm">
                            <i class="fa fa-user"></i>
                            <p>Yöneticiler</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="adm">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ url('/admin/dashboard/addmanager') }}">
                                        <span class="sub-item">Yönetici Ekle</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/admin/dashboard/madmin') }}">
                                        <span class="sub-item">Yöneticileri Yönet</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li
                        class="nav-item {{ request()->routeIs('appsettingshow') ? 'active' : '' }} {{ request()->routeIs('termspolicy') ? 'active' : '' }} {{ request()->routeIs('refsetshow') ? 'active' : '' }} {{ request()->routeIs('paymentview') ? 'active' : '' }} {{ request()->routeIs('frontpage') ? 'active' : '' }} {{ request()->routeIs('allipaddress') ? 'active' : '' }} {{ request()->routeIs('ipaddress') ? 'active' : '' }} {{ request()->routeIs('editpaymethod') ? 'active' : '' }} {{ request()->routeIs('managecryptoasset') ? 'active' : '' }}">
                        <a data-toggle="collapse" href="#settings">
                            <i class="fa fa-cog"></i>
                            <p>Ayarlar</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="settings">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="{{ route('appsettingshow') }}">
                                        <span class="sub-item">Uygulama Ayarları</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('refsetshow') }}">
                                        <span class="sub-item">Tavsiye/Bonus Ayarları</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('paymentview') }}">
                                        <span class="sub-item">Ödeme Ayarları</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('managecryptoasset') }}">
                                        <span class="sub-item">Takas Ayarları</span>
                                    </a>
                                </li>


                                <!--<li>-->
                                <!--    <a href="{{ route('termspolicy') }}">-->
                                <!--        <span class="sub-item">Terms and Privacy</span>-->
                                <!--    </a>-->
                                <!--</li>-->
                                <li>
                                    <a href="{{ url('/admin/dashboard/ipaddress') }}">
                                        <span class="sub-item">IP Adresi</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif


                    <li class="nav-item {{ request()->routeIs('aboutonlinetrade') ? 'active' : '' }}">
                        <a href="{{ url('/admin/dashboard/about') }}">
                            <i class=" fa fa-info-circle" aria-hidden="true"></i>
                            <p>Daha Fazla Script İçin</p>
                        </a>
                    </li>

            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
