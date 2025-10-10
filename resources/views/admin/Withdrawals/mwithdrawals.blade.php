<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
} else {
    $text = 'light';
}
?>
@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <!-- Modern Header Section -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="mb-2" style="color: #2c3e50; font-weight: 700; font-size: 2.2rem;">
                            <i class="fas fa-wallet mr-3" style="color: #007bff;"></i>
                            Müşteri Çekimlerini Yönet
                        </h1>
                        <p class="text-muted" style="font-size: 1.1rem; margin-bottom: 0;">
                            Tüm müşteri çekim taleplerini buradan yönetebilirsiniz
                        </p>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="stats-card bg-gradient-primary text-white p-3 rounded-lg mr-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-chart-line mr-2"></i>
                                <div>
                                    <div style="font-size: 1.5rem; font-weight: bold;">{{ count($withdrawals) }}</div>
                                    <div style="font-size: 0.85rem; opacity: 0.9;">Toplam Talep</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <x-danger-alert />
                <x-success-alert />

                <!-- Modern Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card stats-card bg-gradient-info text-white shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Bekleyen</h6>
                                        <h3 class="mb-0">{{ collect($withdrawals)->where('status', '!=', 'Processed')->count() }}</h3>
                                    </div>
                                    <i class="fas fa-clock fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stats-card bg-gradient-success text-white shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">İşlenen</h6>
                                        <h3 class="mb-0">{{ collect($withdrawals)->where('status', 'Processed')->count() }}</h3>
                                    </div>
                                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stats-card bg-gradient-warning text-white shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Toplam Tutar</h6>
                                        <h3 class="mb-0">{{ $settings->currency }}{{ number_format(collect($withdrawals)->sum('amount')) }}</h3>
                                    </div>
                                    <i class="fas fa-dollar-sign fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stats-card bg-gradient-danger text-white shadow-sm">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Bu Ay</h6>
                                        <h3 class="mb-0">{{ collect($withdrawals)->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                                    </div>
                                    <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modern Table Card -->
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-list mr-2"></i>
                                Çekim Talepleri
                            </h5>
                            <div class="card-header-actions">
                                <button class="btn btn-light btn-sm" onclick="refreshTable()">
                                    <i class="fas fa-sync-alt mr-1"></i>
                                    Yenile
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="withdrawalsTable" class="table table-hover mb-0 modern-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0 py-3 px-4">
                                            <i class="fas fa-user mr-2 text-primary"></i>
                                            Müşteri Adı
                                        </th>
                                        <th class="border-0 py-3 px-4 text-center">
                                            <i class="fas fa-money-bill-wave mr-2 text-success"></i>
                                            Talep Edilen Tutar
                                        </th>
                                        <th class="border-0 py-3 px-4 text-center">
                                            <i class="fas fa-calculator mr-2 text-info"></i>
                                            Tutar + Masraflar
                                        </th>
                                        <th class="border-0 py-3 px-4 text-center">
                                            <i class="fas fa-credit-card mr-2 text-warning"></i>
                                            Ödeme Yöntemi
                                        </th>
                                        <th class="border-0 py-3 px-4">
                                            <i class="fas fa-envelope mr-2 text-secondary"></i>
                                            E-posta
                                        </th>
                                        <th class="border-0 py-3 px-4 text-center">
                                            <i class="fas fa-info-circle mr-2 text-primary"></i>
                                            Durum
                                        </th>
                                        <th class="border-0 py-3 px-4 text-center">
                                            <i class="fas fa-calendar mr-2 text-muted"></i>
                                            Tarih
                                        </th>
                                        <th class="border-0 py-3 px-4 text-center">
                                            <i class="fas fa-cogs mr-2 text-dark"></i>
                                            İşlemler
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($withdrawals as $withdrawal)
                                        <tr class="table-row-hover">
                                            @if (isset($withdrawal->duser->name) && $withdrawal->duser->name != null)
                                                <td class="py-3 px-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                                             style="width: 40px; height: 40px; font-size: 0.9rem; font-weight: bold;">
                                                            {{ strtoupper(substr($withdrawal->duser->name, 0, 2)) }}
                                                        </div>
                                                        <div>
                                                            <div class="font-weight-bold">{{ $withdrawal->duser->name }}</div>
                                                            <small class="text-muted">ID: {{ $withdrawal->duser->id ?? 'N/A' }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                            @else
                                                <td class="py-3 px-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-avatar bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                                             style="width: 40px; height: 40px;">
                                                            <i class="fas fa-user-slash"></i>
                                                        </div>
                                                        <div>
                                                            <div class="font-weight-bold text-muted">Kullanıcı Silindi</div>
                                                            <small class="text-muted">Hesap mevcut değil</small>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif

                                            <td class="py-3 px-4 text-center">
                                                <div class="amount-badge bg-success-light text-success px-3 py-2 rounded-lg">
                                                    <strong>{{ $settings->currency }}{{ number_format($withdrawal->amount) }}</strong>
                                                </div>
                                            </td>

                                            <td class="py-3 px-4 text-center">
                                                <div class="amount-badge bg-info-light text-info px-3 py-2 rounded-lg">
                                                    <strong>{{ $settings->currency }}{{ number_format($withdrawal->to_deduct) }}</strong>
                                                </div>
                                            </td>

                                            <td class="py-3 px-4 text-center">
                                                <span class="payment-method-badge bg-light border px-3 py-2 rounded-lg">
                                                    <i class="fas fa-{{ strtolower($withdrawal->payment_mode) == 'bank' ? 'university' : 'wallet' }} mr-2"></i>
                                                    {{ $withdrawal->payment_mode }}
                                                </span>
                                            </td>

                                            <td class="py-3 px-4">
                                                <span class="email-text" title="{{ $withdrawal->duser->email ?? 'N/A' }}">
                                                    {{ Str::limit($withdrawal->duser->email ?? 'N/A', 20) }}
                                                </span>
                                            </td>

                                            <td class="py-3 px-4 text-center">
                                                @if ($withdrawal->status == 'Processed')
                                                    <span class="status-badge badge-success-modern px-3 py-2 rounded-pill">
                                                        <i class="fas fa-check-circle mr-1"></i>
                                                        İşlendi
                                                    </span>
                                                @else
                                                    <span class="status-badge badge-danger-modern px-3 py-2 rounded-pill">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        Bekliyor
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="py-3 px-4 text-center">
                                                <div class="date-info">
                                                    <div class="font-weight-bold">{{ \Carbon\Carbon::parse($withdrawal->created_at)->format('d M Y') }}</div>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($withdrawal->created_at)->format('H:i') }}</small>
                                                </div>
                                            </td>

                                            <td class="py-3 px-4 text-center">
                                                <div class="action-buttons">
                                                    <a href="{{ route('processwithdraw', $withdrawal->id) }}"
                                                       class="btn btn-primary btn-sm btn-action"
                                                       title="Çekim talebini görüntüle ve işle">
                                                        <i class="fas fa-eye mr-1"></i>
                                                        Görüntüle
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">Henüz çekim talebi yok</h5>
                                                    <p class="text-muted">Müşterilerden gelen çekim talepleri burada listelenecek.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Custom Styles -->
                <style>
                    .stats-card {
                        transition: transform 0.2s ease, box-shadow 0.2s ease;
                    }
                    .stats-card:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
                    }

                    .bg-gradient-primary {
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    }

                    .bg-gradient-info {
                        background: linear-gradient(135deg, #2196F3 0%, #21CBF3 100%);
                    }

                    .bg-gradient-success {
                        background: linear-gradient(135deg, #4CAF50 0%, #45B7D1 100%);
                    }

                    .bg-gradient-warning {
                        background: linear-gradient(135deg, #ff9800 0%, #f44336 100%);
                    }

                    .bg-gradient-danger {
                        background: linear-gradient(135deg, #f44336 0%, #e91e63 100%);
                    }

                    .modern-table {
                        border-radius: 0;
                    }

                    .modern-table thead th {
                        background-color: #f8f9fa;
                        border-bottom: 2px solid #dee2e6;
                        font-weight: 600;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                        font-size: 0.85rem;
                    }

                    .table-row-hover {
                        transition: all 0.2s ease;
                    }

                    .table-row-hover:hover {
                        background-color: #f8f9fa;
                        transform: scale(1.01);
                        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    }

                    .user-avatar {
                        transition: transform 0.2s ease;
                    }

                    .user-avatar:hover {
                        transform: scale(1.1);
                    }

                    .amount-badge {
                        display: inline-block;
                        min-width: 80px;
                        text-align: center;
                    }

                    .bg-success-light {
                        background-color: rgba(76, 175, 80, 0.1);
                    }

                    .bg-info-light {
                        background-color: rgba(33, 150, 243, 0.1);
                    }

                    .payment-method-badge {
                        font-size: 0.85rem;
                        font-weight: 500;
                    }

                    .status-badge {
                        font-size: 0.8rem;
                        font-weight: 600;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                    }

                    .badge-success-modern {
                        background-color: #28a745;
                        color: white;
                    }

                    .badge-danger-modern {
                        background-color: #dc3545;
                        color: white;
                    }

                    .btn-action {
                        transition: all 0.2s ease;
                        border-radius: 20px;
                        padding: 0.5rem 1rem;
                    }

                    .btn-action:hover {
                        transform: translateY(-1px);
                        box-shadow: 0 4px 12px rgba(0,123,255,0.3);
                    }

                    .empty-state {
                        padding: 3rem 1rem;
                    }

                    .card-header-actions .btn {
                        border-radius: 20px;
                    }

                    .email-text {
                        font-family: 'Courier New', monospace;
                        font-size: 0.9rem;
                    }

                    .date-info {
                        line-height: 1.2;
                    }

                    @media (max-width: 768px) {
                        .stats-card h3 {
                            font-size: 1.5rem !important;
                        }

                        .amount-badge {
                            min-width: 60px;
                            font-size: 0.85rem;
                        }

                        .btn-action {
                            padding: 0.4rem 0.8rem;
                            font-size: 0.8rem;
                        }
                    }
                </style>
            </div>
        </div>
    </div>

    <script>
        function refreshTable() {
            // Add loading state
            document.getElementById('withdrawalsTable').style.opacity = '0.6';

            // Simulate refresh (you can replace this with actual AJAX call)
            setTimeout(() => {
                document.getElementById('withdrawalsTable').style.opacity = '1';
                // Show success message
                if (typeof toastr !== 'undefined') {
                    toastr.success('Tablo yenilendi');
                }
            }, 1000);
        }
    </script>
@endsection
