<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
    $bg = 'light';
} else {
    $text = 'light';
    $bg = 'dark';
}
?>
@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content ">
            <div class="page-inner">
                <x-danger-alert />
                <x-success-alert />
                <!-- Beginning of  Dashboard Stats  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-3 card ">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <h1 class="d-inline text-primary">{{ $user->name }}</h1><span></span>
                                        <div class="d-inline">
                                            <div class="float-right btn-group">
                                                <a class="btn btn-primary btn-sm" href="{{ route('manageusers') }}"> <i
                                                        class="fa fa-arrow-left"></i> geri</a> &nbsp;
                                                <button type="button" class="btn btn-secondary dropdown-toggle btn-sm"
                                                    data-toggle="dropdown" data-display="static" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    İşlemler
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-lg-right">
                                                    <a class="dropdown-item"
                                                    href="{{ route('loginactivity', $user->id) }}">Giriş Aktivitesi</a>
                                                    @if ($user->status == null || $user->status == 'blocked' || $user->status == 'banned' || $user->status == 'disabled')
                                                        <a class="dropdown-item text-success"
                                                            href="{{ url('admin/dashboard/uunblock') }}/{{ $user->id }}">
                                                            <i class="fas fa-unlock mr-2"></i>Yasağı Kaldır / Hesabı Etkinleştir
                                                        </a>
                                                    @else
                                                        <a class="dropdown-item text-warning"
                                                            href="{{ url('admin/dashboard/uublock') }}/{{ $user->id }}">
                                                            <i class="fas fa-ban mr-2"></i>Yasakla / Hesabı Devre Dışı Bırak
                                                        </a>
                                                    @endif
                                                    <!--@if ($user->tradetype == 'Profit')-->
                                                    <!--    <a class="dropdown-item"-->
                                                    <!--        href="{{ url('admin/dashboard/usertrademode') }}/{{ $user->id }}/off">Turn-->
                                                    <!--        trade mode to Loss</a>-->
                                                    <!--@else-->
                                                    <!--    <a class="dropdown-item"-->
                                                    <!--        href="{{ url('admin/dashboard/usertrademode') }}/{{ $user->id }}/on">Turn trade mode to Profit</a>-->
                                                    <!--@endif-->
                                                    @if ($user->email_verified_at)
                                                    @else
                                                        <a href="{{ url('admin/dashboard/email-verify') }}/{{ $user->id }}"
                                                            class="dropdown-item">E-postayı Doğrula</a>
                                                    @endif
                                                    <a href="#" data-toggle="modal" data-target="#topupModal"
                                                        class="dropdown-item">Kredi/Debit</a>


                                                        @if ($user->signal_status == 'on')
                                                        <a href="#" data-toggle="modal" data-target="#ugpradeSignalStatus"
                                                        class="dropdown-item">Sinyal Yükseltme Durumunu Kapat</a>
                                                        @else
                                                        <a href="#" data-toggle="modal" data-target="#ugpradeSignalStatus"
                                                        class="dropdown-item">Sinyal Yükseltme Durumunu Aç</a>
                                                        @endif


                                                        @if ($user->plan_status=='on')
                                                        <a href="#" data-toggle="modal" data-target="#ugpradePlanStatus"
                                                        class="dropdown-item">Plan Yükseltme Durumunu Kapat</a>
                                                        @else
                                                        <a href="#" data-toggle="modal" data-target="#ugpradePlanStatus"
                                                        class="dropdown-item">Plan Yükseltme Durumunu Aç</a>
                                                        @endif

                                                         {{-- <a href="#" data-toggle="modal" data-target="#userTax"
                                                        class="dropdown-item">On/Off Tax </a> --}}
                                                        <a href="#" data-toggle="modal" data-target="#TradingModal"
                                                        class="dropdown-item">Bu müşteri için işlem yap</a>
                                                        @if($user->signals !=Null)
                                                        <a href="#" data-toggle="modal" data-target="#Signal"
                                                        class="dropdown-item"> Bu Müşteri İçin Sinyal Oluştur </a>
                                            @endif

                                                        <a href="#" data-toggle="modal" data-target="#Nostrades"
                                                        class="dropdown-item">Para Çekme İçin İşlem Sayısı Belirle </a>

                                                        <a href="#" data-toggle="modal" data-target="#Planhistory"
                                                        class="dropdown-item">Plan Geçmişi Ekle</a>
                                                        <a href="#" data-toggle="modal" data-target="#tradingProgressModal"  class="dropdown-item">Sinyal Gücü</a>
                                               <a href="#" data-toggle="modal" data-target="#withdrawalcode"
                                                        class="dropdown-item">Müşteri İçin Para Çekme Kodu Belirle </a>
                                                    <a href="#" data-toggle="modal" data-target="#resetpswdModal"
                                                        class="dropdown-item">Şifreyi Sıfırla</a>
                                                    <a href="#" data-toggle="modal" data-target="#clearacctModal"
                                                        class="dropdown-item">Hesabı Temizle</a>

                                                    <a href="#" data-toggle="modal" data-target="#edituser"
                                                        class="dropdown-item">Düzenle</a>
                                                    <a href="{{ route('showusers', $user->id) }}" class="dropdown-item">Referans
                                                        Ekle</a>
                                                        <a href="#" data-toggle="modal"
                                                        data-target="#notifyuser" class="dropdown-item">Kullanıcı Panelini Bilgilendir</a>
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#sendmailtooneuserModal" class="dropdown-item">E-posta
                                                        Gönder</a>
                                                    <a href="#" data-toggle="modal" data-target="#switchuserModal"
                                                        class="dropdown-item text-success">{{ $user->name }} olarak giriş yap</a>
                                                    <a href="#" data-toggle="modal" data-target="#deleteModal"
                                                        class="dropdown-item text-danger">{{ $user->name }} kullanıcısını sil</a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modern User Stats Cards - Enhanced Design -->
                                <div class="row g-3 mb-4">
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="card border-0 shadow-lg h-100 hover-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                            <div class="card-body text-center">
                                                <div class="mb-3">
                                                    <i class="fas fa-wallet fa-2x" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));"></i>
                                                </div>
                                                <h6 class="mb-2 opacity-75 small text-uppercase" style="letter-spacing: 0.5px;">Hesap Bakiyesi</h6>
                                                <h3 class="mb-0 fw-bold text-truncate" title="{{ $user->currency }}{{ number_format($user->account_bal, 2, '.', ',') }}" style="text-shadow: 0 1px 3px rgba(0,0,0,0.3);">
                                                    {{ $user->currency }}{{ number_format($user->account_bal, 2, '.', ',') }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="card border-0 shadow-lg h-100 hover-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                                            <div class="card-body text-center">
                                                <div class="mb-3">
                                                    <i class="fas fa-chart-line fa-2x" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));"></i>
                                                </div>
                                                <h6 class="mb-2 opacity-75 small text-uppercase" style="letter-spacing: 0.5px;">Kâr</h6>
                                                <h3 class="mb-0 fw-bold text-truncate" title="{{ $user->currency }}{{ number_format($user->roi, 2, '.', ',') }}" style="text-shadow: 0 1px 3px rgba(0,0,0,0.3);">
                                                    {{ $user->currency }}{{ number_format($user->roi, 2, '.', ',') }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="card border-0 shadow-lg h-100 hover-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                            <div class="card-body text-center">
                                                <div class="mb-3">
                                                    <i class="fas fa-signal fa-2x" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));"></i>
                                                </div>
                                                <h6 class="mb-2 opacity-75 small text-uppercase" style="letter-spacing: 0.5px;">Mevcut Sinyal</h6>
                                                <div class="mt-2">
                                                    @if($user->signals==Null)
                                                        <span class="badge bg-white bg-opacity-25 px-3 py-2 small fw-semibold" style="backdrop-filter: blur(10px);">Henüz Sinyal Yok</span>
                                                    @else
                                                        <span class="badge bg-white bg-opacity-25 px-3 py-2 small fw-semibold" style="backdrop-filter: blur(10px);">{{ $user->signals }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-3">
                                        <div class="card border-0 shadow-lg h-100 hover-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                                            <div class="card-body text-center">
                                                <div class="mb-3">
                                                    <i class="fas fa-gift fa-2x" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));"></i>
                                                </div>
                                                <h6 class="mb-2 opacity-75 small text-uppercase" style="letter-spacing: 0.5px;">Bonus</h6>
                                                <h3 class="mb-0 fw-bold text-truncate" title="{{ $user->currency }}{{ number_format($user->bonus, 2, '.', ',') }}" style="text-shadow: 0 1px 3px rgba(0,0,0,0.3);">
                                                    {{ $user->currency }}{{ number_format($user->bonus, 2, '.', ',') }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- User Plans & Trades Section - Enhanced Design -->
                                <div class="row g-3 mb-4">
                                    <div class="col-12 col-lg-6">
                                        <div class="card border-0 shadow-lg h-100 hover-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fas fa-chart-pie fa-lg me-3" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));"></i>
                                                    <h6 class="mb-0 fw-semibold">Müşteri Planları</h6>
                                                </div>
                                                @if ($user->plan != null)
                                                    <a class="btn btn-light btn-sm w-100 fw-semibold" href="{{ route('user.investments', $user->id) }}" style="box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                                        <i class="fas fa-eye me-2"></i>Planları Görüntüle
                                                    </a>
                                                @else
                                                    <div class="text-center py-4">
                                                        <i class="fas fa-inbox fa-3x mb-3 opacity-75" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));"></i>
                                                        <p class="mb-0 small opacity-75">Aktif Plan Yok</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="card border-0 shadow-lg h-100 hover-card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fas fa-exchange-alt fa-lg me-3" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));"></i>
                                                    <h6 class="mb-0 fw-semibold">Müşteri İşlemleri</h6>
                                                </div>
                                                @if ($user->trade != null)
                                                    <a class="btn btn-light btn-sm w-100 fw-semibold" href="{{ route('user.plans', $user->id) }}" style="box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                                        <i class="fas fa-eye me-2"></i>İşlemleri Görüntüle
                                                    </a>
                                                @else
                                                    <div class="text-center py-4">
                                                        <i class="fas fa-inbox fa-3x mb-3 opacity-75" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));"></i>
                                                        <p class="mb-0 small opacity-75">Henüz İşlem Yok</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Account Status Cards -->
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-body text-center">
                                                <div class="mb-2">
                                                    @if ($user->account_verify == 'Verified')
                                                        <i class="fas fa-check-circle fa-2x text-success"></i>
                                                    @else
                                                        <i class="fas fa-times-circle fa-2x text-danger"></i>
                                                    @endif
                                                </div>
                                                <h6 class="text-muted mb-1">KYC Durumu</h6>
                                                @if ($user->account_verify == 'Verified')
                                                    <span class="badge bg-success px-3 py-2">Doğrulanmış</span>
                                                @else
                                                    <span class="badge bg-danger px-3 py-2">Doğrulanmamış</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-body text-center">
                                                <div class="mb-2">
                                                    @if ($user->tradetype == 'Loss' || $user->trade_mode == null)
                                                        <i class="fas fa-arrow-down fa-2x text-danger"></i>
                                                    @else
                                                        <i class="fas fa-arrow-up fa-2x text-success"></i>
                                                    @endif
                                                </div>
                                                <h6 class="text-muted mb-1">İşlem Modu</h6>
                                                @if ($user->tradetype == 'Loss' || $user->trade_mode == null)
                                                    <span class="badge bg-danger px-3 py-2">Loss</span>
                                                @else
                                                    <span class="badge bg-success px-3 py-2">Profit</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-body text-center">
                                                <div class="mb-2">
                                                    @if (in_array($user->status, ['blocked', 'banned', 'disabled']))
                                                        <i class="fas fa-ban fa-2x text-danger"></i>
                                                    @elseif ($user->status == 'active')
                                                        <i class="fas fa-check-circle fa-2x text-success"></i>
                                                    @else
                                                        <i class="fas fa-clock fa-2x text-warning"></i>
                                                    @endif
                                                </div>
                                                <h6 class="text-muted mb-1">Hesap Durumu</h6>
                                                @if (in_array($user->status, ['blocked', 'banned', 'disabled']))
                                                    <span class="badge bg-danger px-3 py-2">
                                                        <i class="fas fa-ban me-1"></i>{{ ucfirst($user->status) }}
                                                    </span>
                                                @elseif ($user->status == 'active')
                                                    <span class="badge bg-success px-3 py-2">
                                                        <i class="fas fa-check-circle me-1"></i>Active
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning px-3 py-2">
                                                        <i class="fas fa-clock me-1"></i>Pending
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modern User Information Section -->
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">
                                            <i class="fas fa-user-circle me-2"></i>KULLANICI BİLGİLERİ
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex align-items-center p-3 rounded" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); border-left: 4px solid #667eea;">
                                                    <div class="flex-shrink-0 me-3">
                                                        <i class="fas fa-user fa-lg text-primary" style="filter: drop-shadow(0 1px 2px rgba(102, 126, 234, 0.3));"></i>
                                                    </div>
                                                    <div class="flex-grow-1 min-w-0">
                                                        <label class="text-muted mb-0 small fw-semibold">Ad Soyad</label>
                                                        <div class="fw-bold text-dark text-truncate" title="{{ $user->name }}">{{ $user->name }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex align-items-center p-3 rounded" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); border-left: 4px solid #667eea;">
                                                    <div class="flex-shrink-0 me-3">
                                                        <i class="fas fa-envelope fa-lg text-primary" style="filter: drop-shadow(0 1px 2px rgba(102, 126, 234, 0.3));"></i>
                                                    </div>
                                                    <div class="flex-grow-1 min-w-0">
                                                        <label class="text-muted mb-0 small fw-semibold">E-posta Adresi</label>
                                                        <div class="fw-bold text-dark text-truncate" title="{{ $user->email }}">{{ $user->email }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex align-items-center p-3 rounded" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); border-left: 4px solid #667eea;">
                                                    <div class="flex-shrink-0 me-3">
                                                        <i class="fas fa-phone fa-lg text-primary" style="filter: drop-shadow(0 1px 2px rgba(102, 126, 234, 0.3));"></i>
                                                    </div>
                                                    <div class="flex-grow-1 min-w-0">
                                                        <label class="text-muted mb-0 small fw-semibold">Cep Telefonu</label>
                                                        <div class="fw-bold text-dark text-truncate" title="{{ $user->phone }}">{{ $user->phone }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex align-items-center p-3 rounded" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); border-left: 4px solid #667eea;">
                                                    <div class="flex-shrink-0 me-3">
                                                        <i class="fas fa-birthday-cake fa-lg text-primary" style="filter: drop-shadow(0 1px 2px rgba(102, 126, 234, 0.3));"></i>
                                                    </div>
                                                    <div class="flex-grow-1 min-w-0">
                                                        <label class="text-muted mb-0 small fw-semibold">Doğum Tarihi</label>
                                                        <div class="fw-bold text-dark text-truncate" title="{{ $user->dob }}">{{ $user->dob }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex align-items-center p-3 rounded" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); border-left: 4px solid #667eea;">
                                                    <div class="flex-shrink-0 me-3">
                                                        <i class="fas fa-flag fa-lg text-primary" style="filter: drop-shadow(0 1px 2px rgba(102, 126, 234, 0.3));"></i>
                                                    </div>
                                                    <div class="flex-grow-1 min-w-0">
                                                        <label class="text-muted mb-0 small fw-semibold">Uyruk</label>
                                                        <div class="fw-bold text-dark text-truncate" title="{{ $user->country }}">{{ $user->country }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex align-items-center p-3 rounded" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); border-left: 4px solid #667eea;">
                                                    <div class="flex-shrink-0 me-3">
                                                        <i class="fas fa-calendar-check fa-lg text-primary" style="filter: drop-shadow(0 1px 2px rgba(102, 126, 234, 0.3));"></i>
                                                    </div>
                                                    <div class="flex-grow-1 min-w-0">
                                                        <label class="text-muted mb-0 small fw-semibold">Kayıt Tarihi</label>
                                                        <div class="fw-bold text-dark text-truncate" title="{{ \Carbon\Carbon::parse($user->created_at)->toDayDateTimeString() }}">
                                                            {{ \Carbon\Carbon::parse($user->created_at)->toDayDateTimeString() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.Users.users_actions')


        <style>
            .hover-card {
                transition: all 0.3s ease;
                cursor: pointer;
            }
            .hover-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
            }

            /* Enhanced mobile responsiveness */
            @media (max-width: 575.98px) {
                .card-body {
                    padding: 1rem !important;
                }

                .display-4 {
                    font-size: 2rem;
                }

                .btn-lg {
                    padding: 0.5rem 1rem;
                    font-size: 0.875rem;
                }

                .modal-dialog {
                    margin: 0.5rem;
                }
            }

            /* Smooth animations */
            .fade-in {
                animation: fadeIn 0.5s ease-in;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }

            /* Enhanced button styles */
            .btn-enhanced {
                border-radius: 25px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                transition: all 0.3s ease;
            }

            .btn-enhanced:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            }
        </style>

        <script>
            // Add fade-in animation on page load
            document.addEventListener('DOMContentLoaded', function() {
                const cards = document.querySelectorAll('.card');
                cards.forEach((card, index) => {
                    setTimeout(() => {
                        card.classList.add('fade-in');
                    }, index * 100);
                });
            });

            function changecurr() {
                var e = document.getElementById("select_c");
                var selected = e.options[e.selectedIndex].id;
                document.getElementById("s_c").value = selected;
                console.log(selected);
            }
        </script>
    @endsection
