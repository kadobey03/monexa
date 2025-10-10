@extends('layouts.app')
@section('title', $title)
@section('content')

@include('admin.topmenu')
@include('admin.sidebar')

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="page-title mb-2">
                            <i class="fas fa-chart-line mr-2 text-primary"></i>
                            Kullanıcı İşlemler Yönetimi
                        </h4>
                        <p class="text-muted mb-0">Tüm kullanıcı işlemlerini yönetin ve takip edin</p>
                    </div>
                    <div class="btn-toolbar">
                        <button type="button" class="btn btn-info btn-sm mr-2" onclick="testRoutes()">
                            <i class="fas fa-bug mr-1"></i>Rotaları Test Et
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-download mr-1"></i>Dışa Aktar
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('admin.trades.export', ['format' => 'csv'] + request()->all()) }}">
                                    <i class="fas fa-file-csv mr-2"></i>CSV
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.trades.export', ['format' => 'excel'] + request()->all()) }}">
                                    <i class="fas fa-file-excel mr-2"></i>Excel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="breadcrumbs mt-3">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Yönetim</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">İşlemler</a>
                    </li>
                </ul>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="background: linear-gradient(135deg, #28a745, #20c997); color: white;">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: white; opacity: 0.8;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="background: linear-gradient(135deg, #dc3545, #fd7e14); color: white;">
                    <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: white; opacity: 0.8;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Trades Statistics -->
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round shadow-lg border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center bubble-shadow-small" style="background: rgba(255,255,255,0.2); border-radius: 15px; padding: 15px;">
                                        <i class="fas fa-chart-line fa-2x"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ml-3 ml-sm-0">
                                    <div class="numbers">
                                        <p class="card-category mb-1" style="color: rgba(255,255,255,0.8);">Toplam İşlem</p>
                                        <h4 class="card-title mb-0" style="font-size: 1.8rem; font-weight: 700;">{{ number_format($stats['total'] ?? 0) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round shadow-lg border-0" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center bubble-shadow-small" style="background: rgba(255,255,255,0.2); border-radius: 15px; padding: 15px;">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ml-3 ml-sm-0">
                                    <div class="numbers">
                                        <p class="card-category mb-1" style="color: rgba(255,255,255,0.8);">Aktif İşlemler</p>
                                        <h4 class="card-title mb-0" style="font-size: 1.8rem; font-weight: 700;">{{ number_format($stats['active'] ?? 0) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round shadow-lg border-0" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center bubble-shadow-small" style="background: rgba(255,255,255,0.2); border-radius: 15px; padding: 15px;">
                                        <i class="fas fa-check-circle fa-2x"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ml-3 ml-sm-0">
                                    <div class="numbers">
                                        <p class="card-category mb-1" style="color: rgba(255,255,255,0.8);">Tamamlandı</p>
                                        <h4 class="card-title mb-0" style="font-size: 1.8rem; font-weight: 700;">{{ number_format($stats['expired'] ?? 0) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round shadow-lg border-0" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center bubble-shadow-small" style="background: rgba(255,255,255,0.2); border-radius: 15px; padding: 15px;">
                                        <i class="fas fa-dollar-sign fa-2x"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ml-3 ml-sm-0">
                                    <div class="numbers">
                                        <p class="card-category mb-1" style="color: rgba(255,255,255,0.8);">Toplam Hacim</p>
                                        <h4 class="card-title mb-0" style="font-size: 1.8rem; font-weight: 700;">${{ number_format($stats['total_volume'] ?? 0, 2) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                        <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="card-title mb-0">
                                    <i class="fas fa-filter mr-2"></i>Filtreler ve Arama
                                </h4>
                                <button class="btn btn-light btn-sm" data-toggle="collapse" data-target="#filtersCollapse" aria-expanded="false" style="border-radius: 25px; padding: 8px 16px;">
                                    <i class="fas fa-search mr-1"></i>
                                    Filtreleri Aç/Kapat
                                </button>
                            </div>
                        </div>
                        <div class="collapse show" id="filtersCollapse">
                            <div class="card-body" style="background: #f8f9fa;">
                                <form method="GET" action="{{ route('admin.trades.index') }}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="search" class="font-weight-bold text-dark">Kullanıcı Ara</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="background: #667eea; color: white; border: none;">
                                                            <i class="fas fa-user"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" id="search" name="search"
                                                           value="{{ request('search') }}" placeholder="Kullanıcı Adı veya E-posta" style="border-left: none;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="status" class="font-weight-bold text-dark">Durum</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="background: #f093fb; color: white; border: none;">
                                                            <i class="fas fa-info-circle"></i>
                                                        </span>
                                                    </div>
                                                    <select class="form-control" id="status" name="status" style="border-left: none;">
                                                        <option value="">Tümü</option>
                                                        <option value="yes" {{ request('status') == 'yes' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Süresi Dolmuş</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="type" class="font-weight-bold text-dark">İşlem Türü</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="background: #4facfe; color: white; border: none;">
                                                            <i class="fas fa-exchange-alt"></i>
                                                        </span>
                                                    </div>
                                                    <select class="form-control" id="type" name="type" style="border-left: none;">
                                                        <option value="">Tümü</option>
                                                        <option value="Buy" {{ request('type') == 'Buy' ? 'selected' : '' }}>Al</option>
                                                        <option value="Sell" {{ request('type') == 'Sell' ? 'selected' : '' }}>Sat</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="asset" class="font-weight-bold text-dark">Varlık</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="background: #43e97b; color: white; border: none;">
                                                            <i class="fas fa-coins"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" id="asset" name="asset"
                                                           value="{{ request('asset') }}" placeholder="Varlık adı" style="border-left: none;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="font-weight-bold text-dark">&nbsp;</label>
                                                <div>
                                                    <button type="submit" class="btn btn-primary btn-block" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 25px; padding: 12px;">
                                                        <i class="fas fa-search mr-2"></i>Filtrele
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trades Table -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                        <div class="card-header" style="background: linear-gradient(135deg, #36d1dc 0%, #5b86e5 100%); color: white; border: none;">
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="card-title mb-0">
                                    <i class="fas fa-table mr-2"></i>Kullanıcı İşlemleri ({{ $trades->total() }} kayıt)
                                </h4>
                                <div class="btn-toolbar">
                                    <button type="button" class="btn btn-warning btn-sm mr-2" onclick="testRoutes()" style="border-radius: 20px; background: linear-gradient(135deg, #ffa726 0%, #fb8c00 100%); border: none;">
                                        <i class="fas fa-bug mr-1"></i>Rotaları Test Et
                                    </button>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" style="border-radius: 20px; background: linear-gradient(135deg, #66bb6a 0%, #4caf50 100%); border: none;">
                                            <i class="fas fa-download mr-1"></i>Dışa Aktar
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('admin.trades.export', ['format' => 'csv'] + request()->all()) }}">
                                                <i class="fas fa-file-csv mr-2"></i>CSV
                                            </a>
                                            <a class="dropdown-item" href="{{ route('admin.trades.export', ['format' => 'excel'] + request()->all()) }}">
                                                <i class="fas fa-file-excel mr-2"></i>Excel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="tradesTable" class="display table table-hover" style="margin: 0;">
                                    <thead style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                                        <tr>
                                            <th style="border: none; padding: 20px 15px; font-weight: 600; color: #495057;">ID</th>
                                            <th style="border: none; padding: 20px 15px; font-weight: 600; color: #495057;">Kullanıcı</th>
                                            <th style="border: none; padding: 20px 15px; font-weight: 600; color: #495057;">Varlık</th>
                                            <th style="border: none; padding: 20px 15px; font-weight: 600; color: #495057;">Tür</th>
                                            <th style="border: none; padding: 20px 15px; font-weight: 600; color: #495057;">Miktar</th>
                                            <th style="border: none; padding: 20px 15px; font-weight: 600; color: #495057;">Kaldıraç</th>
                                            <th style="border: none; padding: 20px 15px; font-weight: 600; color: #495057;">Kâr/Zarar</th>
                                            <th style="border: none; padding: 20px 15px; font-weight: 600; color: #495057;">Durum</th>
                                            <th style="border: none; padding: 20px 15px; font-weight: 600; color: #495057;">Oluşturuldu</th>
                                            <th style="border: none; padding: 20px 15px; font-weight: 600; color: #495057;">Süresi Doluyor</th>
                                            <th style="border: none; padding: 20px 15px; font-weight: 600; color: #495057;" class="no-sort">İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($trades as $trade)
                                            <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='transparent'">
                                                <td style="padding: 15px;">
                                                    <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 8px 12px; border-radius: 20px;">#{{ $trade->id }}</span>
                                                </td>
                                                <td style="padding: 15px;">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-sm mr-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; padding: 10px;">
                                                            <i class="fas fa-user text-white fa-lg"></i>
                                                        </div>
                                                        <div>
                                                            <strong class="text-dark">{{ $trade->user ? $trade->user->name : 'Kullanıcı Bulunamadı' }}</strong><br>
                                                            <small class="text-muted">{{ $trade->user ? $trade->user->email : 'Belirtilmemiş' }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="padding: 15px;">
                                                    <span class="badge" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 6px 10px; border-radius: 15px;">{{ $trade->assets ?? 'Belirtilmemiş' }}</span>
                                                    @if($trade->symbol)
                                                        <br><small class="text-muted mt-1">{{ $trade->symbol }}</small>
                                                    @else
                                                        <br><small class="text-muted mt-1">Belirtilmemiş</small>
                                                    @endif
                                                </td>
                                                <td style="padding: 15px;">
                                                    @if($trade->type)
                                                        <span class="badge {{ $trade->type == 'Buy' ? 'badge-success' : 'badge-danger' }}" style="padding: 8px 12px; border-radius: 20px; font-size: 0.85rem;">
                                                            <i class="fas {{ $trade->type == 'Buy' ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                                                            {{ $trade->type }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-secondary" style="padding: 8px 12px; border-radius: 20px;">Belirtilmemiş</span>
                                                    @endif
                                                </td>
                                                <td style="padding: 15px;">
                                                    <strong class="text-dark" style="font-size: 1.1rem;">${{ number_format($trade->amount, 2) }}</strong>
                                                </td>
                                                <td style="padding: 15px;">
                                                    <span class="badge" style="background: linear-gradient(135deg, #ffa726 0%, #fb8c00 100%); color: white; padding: 6px 10px; border-radius: 15px;">1:{{ $trade->leverage ?? 'Belirtilmemiş' }}</span>
                                                </td>
                                                <td style="padding: 15px;">
                                                    @if($trade->profit_earned)
                                                        @if($trade->profit_earned > 0)
                                                            <span class="text-success" style="font-weight: 600;">
                                                                <i class="fas fa-arrow-up mr-1"></i>
                                                                +${{ number_format($trade->profit_earned, 2) }}
                                                            </span>
                                                        @else
                                                            <span class="text-danger" style="font-weight: 600;">
                                                                <i class="fas fa-arrow-down mr-1"></i>
                                                                ${{ number_format($trade->profit_earned, 2) }}
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">$0.00</span>
                                                    @endif
                                                </td>
                                                <td style="padding: 15px;">
                                                    @if($trade->active == 'yes')
                                                        <span class="badge" style="background: linear-gradient(135deg, #ffa726 0%, #fb8c00 100%); color: white; padding: 6px 12px; border-radius: 20px;">
                                                            <i class="fas fa-clock mr-1"></i>Aktif
                                                        </span>
                                                    @elseif($trade->active == 'expired')
                                                        <span class="badge" style="background: linear-gradient(135deg, #66bb6a 0%, #4caf50 100%); color: white; padding: 6px 12px; border-radius: 20px;">
                                                            <i class="fas fa-check mr-1"></i>Tamamlandı
                                                        </span>
                                                    @else
                                                        <span class="badge badge-secondary" style="padding: 6px 12px; border-radius: 20px;">{{ ucfirst($trade->active ?? 'Belirtilmemiş') }}</span>
                                                    @endif
                                                </td>
                                                <td style="padding: 15px;">
                                                    <div class="d-flex flex-column">
                                                        <small class="font-weight-bold text-dark">{{ $trade->created_at->format('M d, Y') }}</small>
                                                        <small class="text-muted">{{ $trade->created_at->format('H:i') }}</small>
                                                    </div>
                                                </td>
                                                <td style="padding: 15px;">
                                                    @if($trade->expire_date)
                                                        <div class="d-flex flex-column">
                                                            <small class="font-weight-bold text-dark">{{ \Carbon\Carbon::parse($trade->expire_date)->format('M d, Y') }}</small>
                                                            <small class="text-muted">{{ \Carbon\Carbon::parse($trade->expire_date)->format('H:i') }}</small>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">Belirtilmemiş</span>
                                                    @endif
                                                </td>
                                                <td style="padding: 15px;">
                                                    <div class="form-button-action d-flex">
                                                        <a href="{{ route('admin.trades.edit', $trade->id) }}"
                                                           class="btn btn-link btn-primary btn-sm mr-1"
                                                           data-original-title="İşlemi Düzenle"
                                                           title="İşlemi Düzenle"
                                                           style="border-radius: 20px; padding: 8px 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-link btn-success btn-sm mr-1"
                                                                onclick="showAddProfitForm({{ $trade->id }})"
                                                                data-original-title="Kâr Ekle"
                                                                title="Kâr Ekle"
                                                                style="border-radius: 20px; padding: 8px 12px; background: linear-gradient(135deg, #66bb6a 0%, #4caf50 100%); color: white; border: none;">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-link btn-danger btn-sm"
                                                                onclick="deleteTrade({{ $trade->id }})"
                                                                data-original-title="Sil"
                                                                title="İşlemi Sil"
                                                                style="border-radius: 20px; padding: 8px 12px; background: linear-gradient(135deg, #ef5350 0%, #e53935 100%); color: white; border: none;">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-center" style="padding: 80px 20px;">
                                                    <div class="empty-state">
                                                        <div class="empty-state-icon mb-4">
                                                            <i class="fas fa-chart-line fa-5x mb-4" style="color: #dee2e6; opacity: 0.5;"></i>
                                                        </div>
                                                        <div class="empty-state-title mb-3">
                                                            <h3 class="text-muted" style="font-size: 1.5rem; font-weight: 600;">İşlem bulunamadı</h3>
                                                        </div>
                                                        <div class="empty-state-subtitle text-muted mb-4" style="font-size: 1.1rem;">
                                                            Filtrelerinizi veya arama kriterlerinizi ayarlamayı deneyin.
                                                        </div>
                                                        <button class="btn" onclick="window.location.reload()" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 25px; padding: 12px 24px;">
                                                            <i class="fas fa-refresh mr-2"></i>Yenile
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if($trades->hasPages())
                                <div class="card-footer" style="background: #f8f9fa; border: none; border-radius: 0 0 20px 20px;">
                                    <div class="d-flex justify-content-center">
                                        {{ $trades->appends(request()->query())->links() }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Profit Modal -->
<div class="modal fade" id="addProfitModal" tabindex="-1" role="dialog" aria-labelledby="addProfitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: none; border-radius: 20px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                <h5 class="modal-title" id="addProfitModalLabel">
                    <i class="fas fa-plus-circle mr-2"></i>Kullanıcı ROI'sine Kâr Ekle
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.8;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addProfitForm" method="POST" action="">
                @csrf
                <div class="modal-body" style="padding: 30px;">
                    <div class="alert" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border: none; border-radius: 15px; color: #1565c0;">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Bu, belirtilen miktarı hem işlemin kârına hem de kullanıcının ROI'sine ekleyecek.</strong>
                    </div>
                    <div class="form-group mb-4">
                        <label for="profit_amount" class="font-weight-bold text-dark">Kâr Miktarı ($)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="background: linear-gradient(135deg, #66bb6a 0%, #4caf50 100%); color: white; border: none;">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                            </div>
                            <input type="number" class="form-control" id="profit_amount" name="profit_amount"
                                   step="0.01" required placeholder="Eklenecek miktarı girin" style="border-left: none; border-radius: 0 10px 10px 0; font-size: 1.1rem; font-weight: 500;">
                        </div>
                        <small class="form-text text-muted mt-2">
                            <i class="fas fa-lightbulb mr-1 text-warning"></i>
                            Kâr için pozitif sayılar kullanın, zarar için negatif değer girin
                        </small>
                    </div>
                    <div class="form-group mb-4">
                        <label for="profit_note" class="font-weight-bold text-dark">Not (İsteğe Bağlı)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="background: linear-gradient(135deg, #ffa726 0%, #fb8c00 100%); color: white; border: none;">
                                    <i class="fas fa-sticky-note"></i>
                                </span>
                            </div>
                            <textarea class="form-control" id="profit_note" name="note" rows="3"
                                      placeholder="Bu kâr ayarlaması hakkında bir not ekleyin..." style="border-left: none; border-radius: 0 10px 10px 0; resize: vertical;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8f9fa; border: none; border-radius: 0 0 20px 20px;">
                    <button type="button" class="btn" data-dismiss="modal" style="background: linear-gradient(135deg, #78909c 0%, #607d8b 100%); color: white; border: none; border-radius: 25px; padding: 10px 20px;">
                        <i class="fas fa-times mr-2"></i>İptal
                    </button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #66bb6a 0%, #4caf50 100%); color: white; border: none; border-radius: 25px; padding: 10px 20px;">
                        <i class="fas fa-plus mr-2"></i>Kâr Ekle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<style>
/* Modern Animations and Transitions */
* {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Enhanced Sidebar Toggle Styles */
.sidebar {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.main-panel {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* When sidebar is hidden */
body.sidebar-hide .sidebar {
    transform: translateX(-100%);
}

body.sidebar-hide .main-panel {
    margin-left: 0 !important;
    width: 100% !important;
}

/* Mobile sidebar overlay with blur effect */
.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    z-index: 1040;
}

/* Enhanced hover effects for cards */
.card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none !important;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
}

/* Modern button hover effects */
.btn {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none !important;
    font-weight: 500;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

/* Enhanced table styling */
.table tbody tr {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.table tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.05) !important;
    transform: scale(1.01);
}

/* Custom scrollbar for modern look */
.table-responsive::-webkit-scrollbar {
    height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
}

/* Modern form controls */
.form-control {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 12px 16px;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    transform: translateY(-1px);
}

/* Enhanced badges */
.badge {
    font-weight: 500;
    letter-spacing: 0.5px;
    padding: 8px 12px;
    border-radius: 20px;
}

/* Modern alerts */
.alert {
    border: none;
    border-radius: 15px;
    font-weight: 500;
    padding: 20px;
}

/* Responsive behavior */
@media (max-width: 768px) {
    .sidebar {
        position: fixed;
        left: -270px;
        z-index: 1050;
        box-shadow: 0 0 30px rgba(0,0,0,0.2);
    }

    .sidebar.sidebar-show {
        left: 0;
    }

    .main-panel {
        margin-left: 0 !important;
    }

    .card {
        margin: 10px;
        border-radius: 15px !important;
    }

    .btn {
        padding: 12px 20px;
        font-size: 14px;
    }
}

/* Loading animation for better UX */
@keyframes shimmer {
    0% { background-position: -1000px 0; }
    100% { background-position: 1000px 0; }
}

.loading-shimmer {
    animation: shimmer 2s infinite linear;
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 1000px 100%;
}

/* Enhanced modal animations */
.modal.fade .modal-dialog {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    transform: translate(0, -50px);
}

.modal.show .modal-dialog {
    transform: translate(0, 0);
}

/* Stats cards pulse animation */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

.card-stats {
    animation: pulse 3s infinite;
}

/* Modern gradient text */
.gradient-text {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Enhanced focus states */
button:focus,
.btn:focus,
.form-control:focus {
    outline: none;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

/* Better spacing for mobile */
@media (max-width: 576px) {
    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }

    .card-body {
        padding: 20px 15px;
    }

    .btn-sm {
        padding: 8px 16px;
        font-size: 12px;
    }
}
</style>

<script>
// Test Routes function
window.testRoutes = function() {
    console.log('Rotalar test ediliyor...');
    const baseUrl = '{{ url('/') }}';
    const routes = [
        baseUrl + '/admin/trades',
        baseUrl + '/admin/trades/1',
        baseUrl + '/admin/trades/1/edit'
    ];

    routes.forEach(url => {
        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log(`Rota ${url}: Durum ${response.status}`);
        })
        .catch(error => {
            console.log(`Rota ${url}: Hata ${error.message}`);
        });
    });
};

$(document).ready(function() {
    // Debug button clicks
    $('button[data-toggle="modal"]').on('click', function() {
        console.log('Modal butonuna tıklandı:', $(this).data());
        console.log('Buton hedefi:', $(this).data('target'));
    });

    // Test onclick buttons
    $('button[onclick]').on('click', function() {
        console.log('Onclick butonuna tıklandı:', this.getAttribute('onclick'));
    });

    // Atlantis Theme Sidebar Toggle Functionality
    $('.toggle-sidebar').on('click', function(e) {
        e.preventDefault();
        console.log('Sidebar açılır butonuna tıklandı');

        // Toggle sidebar classes
        $('body').toggleClass('sidebar-hide');
        $('.sidebar').toggleClass('sidebar-show');
        $('.main-panel').toggleClass('full-height');

        // Check if sidebar is now hidden/shown
        if ($('body').hasClass('sidebar-hide')) {
            console.log('Sidebar gizlendi');
        } else {
            console.log('Sidebar gösterildi');
        }
    });

    // Mobile sidebar toggle (sidenav-toggler)
    $('.sidenav-toggler').on('click', function(e) {
        e.preventDefault();
        console.log('Mobil sidebar açılır butonuna tıklandı');

        // For mobile, use different classes
        $('.sidebar').toggleClass('sidebar-show');
        $('body').toggleClass('sidebar-show');

        // Add overlay for mobile
        if ($('.sidebar').hasClass('sidebar-show')) {
            if (!$('.sidebar-overlay').length) {
                $('<div class="sidebar-overlay"></div>').appendTo('body');
            }
        } else {
            $('.sidebar-overlay').remove();
        }
    });

    // Close sidebar when clicking overlay (mobile)
    $(document).on('click', '.sidebar-overlay', function() {
        $('.sidebar').removeClass('sidebar-show');
        $('body').removeClass('sidebar-show');
        $(this).remove();
    });

    // Initialize DataTable with responsive design
    $('#tradesTable').DataTable({
        "pageLength": 25,
        "responsive": true,
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            { "orderable": false, "targets": [-1] } // Disable ordering on Actions column
        ],
        "language": {
            "emptyTable": "İşlem bulunamadı"
        }
    });    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Debug: Log base URL
    console.log('Ana URL: {{ url("/") }}');
    console.log('Yönetim İşlemler URL: {{ url("/admin/trades") }}');

    // Make functions globally available
    window.showAddProfitForm = showAddProfitForm;
    window.deleteTrade = deleteTrade;

    console.log('Fonksiyonlar window nesnesine atandı:', {
        showAddProfitForm: typeof window.showAddProfitForm,
        deleteTrade: typeof window.deleteTrade
    });
});

// Simple function to show add profit modal
function showAddProfitForm(tradeId) {
    console.log('Kâr ekleme formu açılıyor, işlem ID:', tradeId);

    // Set form action
    var profitUrl = '{{ url("/admin/trades") }}/' + tradeId + '/add-profit';
    $('#addProfitForm').attr('action', profitUrl);

    // Clear form
    $('#profit_amount').val('');
    $('#profit_note').val('');

    // Show the modal
    $('#addProfitModal').modal('show');
}

// Delete Trade Function
function deleteTrade(tradeId) {
    console.log('Silinecek İşlem ID:', tradeId);

    var deleteUrl = '{{ url("/admin/trades") }}/' + tradeId;
    console.log('Silme URL:', deleteUrl);

    swal({
        title: "İşlemi Sil?",
        text: "Bu işlem geri alınamaz. İşlem kaydı kalıcı olarak silinecek.",
        type: "warning",
        buttons: {
            cancel: {
                visible: true,
                text: "İptal",
                className: "btn btn-secondary"
            },
            confirm: {
                text: "Evet, sil!",
                className: "btn btn-danger"
            }
        }
    }).then((willDelete) => {
        if (willDelete) {
            console.log('İşlem siliniyor, URL:', deleteUrl);

            // Create and submit form with proper Laravel URL
            var form = $('<form method="POST" action="' + deleteUrl + '">' +
                        '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                        '<input type="hidden" name="_method" value="DELETE">' +
                        '</form>');
            $('body').append(form);
            form.submit();
        }
    });
}
</script>
@endsection
