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
                        <h1 class="page-title text-primary mb-2">
                            <i class="fas fa-chart-line mr-2"></i>Müşteri Yatırımlarını Yönetin
                        </h1>
                        <p class="text-muted mb-0">Sistemdeki tüm müşteri yatırımlarını görüntüleyin, onaylayın ve yönetin</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge badge-info px-3 py-2 mr-2">
                             <i class="fas fa-database mr-1"></i>{{ $deposits->count() }} Toplam Kayıt
                         </span>
                        <button class="btn btn-outline-primary" onclick="window.location.reload()">
                            <i class="fas fa-sync-alt mr-2"></i>Yenile
                        </button>
                    </div>
                </div>

                <!-- Alert Messages -->
                <x-danger-alert />
                <x-success-alert />

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card stats-card bg-gradient-primary text-white">
                            <div class="card-body text-center">
                                <div class="stats-icon mb-3">
                                    <i class="fas fa-dollar-sign fa-2x"></i>
                                </div>
                                <h3 class="stats-value">
                                    {{ $settings->currency }}{{ number_format($deposits->sum('amount')) }}
                                </h3>
                                <p class="stats-label">Toplam Tutar</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stats-card bg-gradient-success text-white">
                            <div class="card-body text-center">
                                <div class="stats-icon mb-3">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <h3 class="stats-value">
                                    {{ $deposits->where('status', 'Processed')->count() }}
                                </h3>
                                <p class="stats-label">İşlenmiş</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stats-card bg-gradient-warning text-white">
                            <div class="card-body text-center">
                                <div class="stats-icon mb-3">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                                <h3 class="stats-value">
                                    {{ $deposits->where('status', '!=', 'Processed')->count() }}
                                </h3>
                                <p class="stats-label">Beklemede</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stats-card bg-gradient-info text-white">
                            <div class="card-body text-center">
                                <div class="stats-icon mb-3">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                                <h3 class="stats-value">
                                    {{ $deposits->pluck('duser_id')->unique()->count() }}
                                </h3>
                                <p class="stats-label">Aktif Kullanıcı</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Card -->
                <div class="card modern-card">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0 text-dark font-weight-bold">
                                <i class="fas fa-list mr-2 text-primary"></i>Yatırım Listesi
                            </h5>
                            <div class="card-header-actions d-flex align-items-center gap-3">
                                <div class="input-group" style="width: 300px;">
                                    <input type="text" class="form-control" id="searchInput" placeholder="Müşteri, tutar veya durum ara..." aria-label="Yatırım arama" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-primary text-white" aria-hidden="true">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-filter mr-2"></i>Filtrele
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="filterDropdown">
                                        <a class="dropdown-item" href="#" onclick="filterDeposits('all')">Tümü</a>
                                        <a class="dropdown-item" href="#" onclick="filterDeposits('Processed')">İşlenmiş</a>
                                        <a class="dropdown-item" href="#" onclick="filterDeposits('pending')">Beklemede</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#" onclick="filterDeposits('investment')">Yatırım Ödemesi</a>
                                        <a class="dropdown-item" href="#" onclick="filterDeposits('signal')">Sinyal Ödemesi</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-container">
                            <div class="table-responsive">
                                <table id="depositsTable" class="table modern-table mb-0" role="table" aria-label="Müşteri yatırımları tablosu">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border-0">
                                                <i class="fas fa-user mr-1"></i>Müşteri
                                            </th>
                                            <th class="border-0">
                                                <i class="fas fa-envelope mr-1"></i>E-posta
                                            </th>
                                            <th class="border-0 text-right">
                                                <i class="fas fa-money-bill mr-1"></i>Tutar
                                            </th>
                                            <th class="border-0">
                                                <i class="fas fa-credit-card mr-1"></i>Ödeme Yöntemi
                                            </th>
                                            <th class="border-0">
                                                <i class="fas fa-tag mr-1"></i>Yatırım Türü
                                            </th>
                                            <th class="border-0">
                                                <i class="fas fa-info-circle mr-1"></i>Durum
                                            </th>
                                            <th class="border-0">
                                                <i class="fas fa-calendar mr-1"></i>Tarih
                                            </th>
                                            <th class="border-0 text-center">
                                                <i class="fas fa-cogs mr-1"></i>İşlemler
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($deposits as $deposit)
                                            <tr class="table-row-hover">
                                                <td class="font-weight-bold">
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-avatar mr-3">
                                                            <i class="fas fa-user-circle fa-lg text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <span class="user-name">
                                                                {{ isset($deposit->duser->name) && $deposit->duser->name != null ? $deposit->duser->name : "Kullanıcı silinmiş" }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="email-text">
                                                        {{ isset($deposit->duser->email) && $deposit->duser->email != null ? $deposit->duser->email : "Kullanıcı silinmiş" }}
                                                    </span>
                                                </td>
                                                <td class="text-right">
                                                    <span class="amount-badge">
                                                        {{ $settings->currency }}{{ number_format($deposit->amount) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="payment-method payment-{{ strtolower($deposit->payment_mode) }}">
                                                        <i class="fas fa-credit-card mr-1"></i>{{ $deposit->payment_mode }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($deposit->signals == Null)
                                                        <span class="badge badge-investment">
                                                            <i class="fas fa-piggy-bank mr-1"></i>Yatırım Ödemesi
                                                        </span>
                                                    @else
                                                        <span class="badge badge-signal">
                                                            <i class="fas fa-wave-square mr-1"></i>Sinyal Ödemesi
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($deposit->status == 'Processed')
                                                        <span class="status-badge status-processed">
                                                            <i class="fas fa-check-circle mr-1"></i>{{ $deposit->status }}
                                                        </span>
                                                    @else
                                                        <span class="status-badge status-pending">
                                                            <i class="fas fa-clock mr-1"></i>{{ $deposit->status }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="date-text">
                                                        <i class="fas fa-calendar-alt mr-1"></i>
                                                        {{ $deposit->created_at->format('d M Y') }}
                                                    </span>
                                                    <br>
                                                    <small class="text-muted">{{ $deposit->created_at->format('H:i') }}</small>
                                                </td>
                                                <td>
                                                    <div class="btn-group-vertical btn-group-sm" role="group">
                                                        <a href="{{ route('viewdepositimage', $deposit->id) }}"
                                                           class="btn btn-info btn-sm mb-1"
                                                           title="Ödeme ekran görüntüsünü görüntüle">
                                                            <i class="fas fa-image mr-1"></i>Görüntüle
                                                        </a>
                                                        <a href="{{ url('admin/dashboard/deldeposit') }}/{{ $deposit->id }}"
                                                           class="btn btn-danger btn-sm mb-1"
                                                           onclick="return confirm('Bu yatırımı silmek istediğinizden emin misiniz?')">
                                                            <i class="fas fa-trash mr-1"></i>Sil
                                                        </a>
                                                        @if ($deposit->status != 'Processed')
                                                            <a class="btn btn-success btn-sm"
                                                               href="{{ url('admin/dashboard/pdeposit') }}/{{ $deposit->id }}">
                                                                <i class="fas fa-play mr-1"></i>Onayla
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-5">
                                                    <div class="empty-state text-center">
                                                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                                                        <h5 class="text-muted">Henüz yatırım kaydı bulunmamaktadır</h5>
                                                        <p class="text-muted">Müşteriler yatırım yaptığında kayıtlar burada görünecektir.</p>
                                                        <button class="btn btn-primary mt-3" onclick="window.location.reload()">
                                                            <i class="fas fa-sync-alt mr-2"></i>Sayfayı Yenile
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination Info -->
                @if($deposits->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            <i class="fas fa-info-circle mr-1"></i>
                            {{ $deposits->firstItem() ?? 0 }} - {{ $deposits->lastItem() ?? 0 }} arası kayıt gösteriliyor
                            (Toplam {{ $deposits->total() ?? 0 }} kayıt)
                        </div>
                        <div class="d-flex align-items-center">
                            <label class="mr-2 mb-0 text-muted">Sayfa başına:</label>
                            <select class="form-control form-control-sm" style="width: 80px;" onchange="changePerPage(this.value)">
                                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        {{ $deposits->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        .stats-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-icon {
            opacity: 0.8;
        }

        .modern-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .modern-table {
            margin-bottom: 0;
        }

        .modern-table thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            padding: 1.2rem 1rem;
            border: none;
            position: relative;
        }

        .table-row-hover {
            transition: all 0.3s ease;
        }

        .table-row-hover:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .amount-badge {
            font-size: 1.1em;
            font-weight: bold;
            color: #28a745;
            background-color: #d4edda;
            padding: 0.5rem 0.75rem;
            border-radius: 10px;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .status-processed {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .badge-investment {
            background-color: #e7f3ff;
            color: #0066cc;
        }

        .badge-signal {
            background-color: #f0f0f0;
            color: #6c757d;
        }

        .payment-method {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.85em;
            font-weight: 500;
        }

        .payment-crypto {
            background-color: #fff3cd;
            color: #856404;
        }

        .payment-bank {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .btn-group-vertical .btn {
            border-radius: 8px !important;
            margin-bottom: 0.25rem;
        }

        .empty-state {
            padding: 3rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .email-text {
            color: #6c757d;
        }

        .date-text {
            font-size: 0.9em;
            color: #495057;
        }

        @media (max-width: 768px) {
            .stats-card {
                margin-bottom: 1rem;
            }

            .modern-card .card-header {
                padding: 1rem;
            }

            .modern-card .card-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .card-header-actions {
                margin-top: 1rem;
                width: 100%;
            }

            .card-header-actions .gap-3 {
                flex-direction: column;
                gap: 1rem !important;
            }

            .input-group {
                width: 100% !important;
            }

            .table-responsive {
                font-size: 0.875rem;
            }

            .btn-group-vertical .btn {
                font-size: 0.75rem;
                padding: 0.375rem 0.5rem;
            }

            .stats-value {
                font-size: 1.5rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .dropdown-menu {
                font-size: 0.875rem;
            }
        }

        @media (max-width: 576px) {
            .d-flex.justify-content-between {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .d-flex.justify-content-between .text-muted {
                margin-bottom: 1rem;
            }

            .modern-table thead th {
                padding: 0.75rem 0.5rem;
                font-size: 0.75rem;
            }

            .modern-table tbody td {
                padding: 0.75rem 0.5rem;
            }

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }

            .stats-card .card-body {
                padding: 1rem;
            }

            .stats-icon {
                margin-bottom: 1rem;
            }

            .stats-value {
                font-size: 1.25rem;
                margin-bottom: 0.5rem;
            }
        }
    </style>

    <!-- Search and Filter Functionality -->
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#depositsTable tbody tr');

            tableRows.forEach(row => {
                if (row.cells.length > 1) { // Skip empty state row
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                }
            });
        });

        // Filter functionality
        function filterDeposits(type) {
            const tableRows = document.querySelectorAll('#depositsTable tbody tr');

            tableRows.forEach(row => {
                if (row.cells.length > 1) { // Skip empty state row
                    let showRow = true;

                    switch(type) {
                        case 'Processed':
                            const statusText = row.cells[5].textContent.trim();
                            showRow = statusText.includes('İşlenmiş') || statusText.includes('Processed');
                            break;
                        case 'pending':
                            const statusTextPending = row.cells[5].textContent.trim();
                            showRow = !statusTextPending.includes('İşlenmiş') && !statusTextPending.includes('Processed');
                            break;
                        case 'investment':
                            const investmentText = row.cells[4].textContent.trim();
                            showRow = investmentText.includes('Yatırım Ödemesi');
                            break;
                        case 'signal':
                            const signalText = row.cells[4].textContent.trim();
                            showRow = signalText.includes('Sinyal Ödemesi');
                            break;
                        case 'all':
                        default:
                            showRow = true;
                            break;
                    }

                    row.style.display = showRow ? '' : 'none';
                }
            });
        }

        // Change per page functionality
        function changePerPage(perPage) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', perPage);
            window.location.href = url.toString();
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.display = 'none';
            });
        }, 5000);
    </script>
@endsection
