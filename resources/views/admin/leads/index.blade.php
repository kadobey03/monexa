@extends('layouts.app')
@section('content')
@section('styles')
<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    corePlugins: {
      preflight: false,
    }
  }
</script>

<!-- Tailwind ve Bootstrap uyumlu hybrid stil -->
<style>
    /* Lead Card Styles */
    .lead-card {
        transition: all 0.3s ease;
        border-left: 4px solid #dee2e6;
        border-radius: 0.75rem;
        overflow: hidden;
    }
    .lead-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Status Badge */
    .status-badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
        border-radius: 9999px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: inline-block;
    }

    /* Lead Score Circle */
    .lead-score {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.875rem;
    }
    .lead-score.high {
        background-color: #dcfce7;
        color: #166534;
        border: 2px solid #22c55e;
    }
    .lead-score.medium {
        background-color: #fef3c7;
        color: #92400e;
        border: 2px solid #f59e0b;
    }
    .lead-score.low {
        background-color: #fee2e2;
        color: #991b1b;
        border: 2px solid #ef4444;
    }

    /* Cards */
    .filters-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 1rem;
        border: none;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    .stat-card {
        border-radius: 1rem;
        overflow: hidden;
        position: relative;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }

    /* Table Actions */
    .table-actions {
        white-space: nowrap;
    }

    /* Bulk Actions */
    .bulk-actions {
        background: #f8fafc;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 1rem;
        display: none;
        border: 2px dashed #cbd5e1;
    }
    .bulk-actions.show {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    /* Contact Method Icon */
    .contact-method-icon {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }

    /* Modern Button Styles */
    .btn-modern {
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border: none;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }
    .btn-modern:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Input Styles */
    .form-control-modern {
        border-radius: 0.5rem;
        border: 2px solid #e2e8f0;
        transition: all 0.2s ease;
    }
    .form-control-modern:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Table Enhancements */
    .table-modern {
        border-radius: 0.75rem;
        overflow: hidden;
    }
    .table-modern thead th {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 1rem;
        border: none;
    }
    .table-modern tbody tr {
        transition: all 0.2s ease;
    }
    .table-modern tbody tr:hover {
        background-color: #f8fafc;
        transform: scale(1.001);
    }

    /* Responsive helpers */
    @media (max-width: 768px) {
        .stat-card {
            margin-bottom: 1rem;
        }
        .filters-card .row {
            gap: 1rem;
        }
    }
</style>
@endsection

@include('admin.topmenu')
@include('admin.sidebar')

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <!-- Header -->
            <div class="page-header mb-4">
                <div class="d-flex align-items-center">
                    <div class="page-icon-wrapper me-3">
                        <div class="page-icon bg-gradient-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="fas fa-users-cog fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="title1 mb-1">Lead Yönetimi</h1>
                        <p class="text-muted mb-0">Potansiyel müşterilerinizi yönetin ve takip edin</p>
                    </div>
                </div>
                <div class="ml-auto d-flex gap-2">
                    @if($isSuperAdmin)
                    <a href="{{ route('admin.leads.export', request()->query()) }}" class="btn btn-success">
                        <i class="fas fa-download me-2"></i>Export
                    </a>
                    <a href="{{ route('admin.lead-statuses.index') }}" class="btn btn-info">
                        <i class="fas fa-tags me-2"></i>Status Yönetimi
                    </a>
                    @endif
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fas fa-upload me-2"></i>Import
                    </button>
                </div>
            </div>

            <x-danger-alert />
            <x-success-alert />

            <!-- Statistics -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="text-primary mb-3">
                                <i class="fas fa-users fa-3x"></i>
                            </div>
                            <h2 class="mb-1 font-weight-bold">{{ number_format($stats['total_leads']) }}</h2>
                            <p class="text-muted mb-0">Toplam Lead</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="text-warning mb-3">
                                <i class="fas fa-user-plus fa-3x"></i>
                            </div>
                            <h2 class="mb-1 font-weight-bold">{{ number_format($stats['new_leads_today']) }}</h2>
                            <p class="text-muted mb-0">Bugünkü Yeni Lead</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="text-danger mb-3">
                                <i class="fas fa-user-times fa-3x"></i>
                            </div>
                            <h2 class="mb-1 font-weight-bold">{{ number_format($stats['unassigned_leads']) }}</h2>
                            <p class="text-muted mb-0">Atanmamış Lead</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="text-success mb-3">
                                <i class="fas fa-trophy fa-3x"></i>
                            </div>
                            <h2 class="mb-1 font-weight-bold">{{ number_format($stats['high_score_leads']) }}</h2>
                            <p class="text-muted mb-0">Yüksek Skor Lead</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-clock text-info fa-2x mb-2"></i>
                            <h5>{{ number_format($stats['follow_ups_today']) }}</h5>
                            <p class="text-muted mb-0">Bugünkü Takipler</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-exclamation-triangle text-warning fa-2x mb-2"></i>
                            <h5>{{ number_format($stats['overdue_follow_ups']) }}</h5>
                            <p class="text-muted mb-0">Gecikmiş Takipler</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-calendar-week text-primary fa-2x mb-2"></i>
                            <h5>{{ number_format($stats['new_leads_this_week']) }}</h5>
                            <p class="text-muted mb-0">Bu Haftaki Yeni Leadler</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card filters-card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.leads.index') }}">
                        <div class="row align-items-end">
                            <div class="col-md-2">
                                <label class="form-label text-white-50">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">Tüm Statuslar</option>
                                    @foreach($leadStatuses as $status)
                                    <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                                        {{ $status->display_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label text-white-50">Atama</label>
                                <select name="assigned" class="form-control">
                                    <option value="">Tümü</option>
                                    <option value="unassigned" {{ request('assigned') == 'unassigned' ? 'selected' : '' }}>Atanmamış</option>
                                    @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}" {{ request('assigned') == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->firstName }} {{ $admin->lastName }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label text-white-50">Kaynak</label>
                                <select name="source" class="form-control">
                                    <option value="">Tüm Kaynaklar</option>
                                    <option value="import" {{ request('source') == 'import' ? 'selected' : '' }}>Import</option>
                                    <option value="manual" {{ request('source') == 'manual' ? 'selected' : '' }}>Manuel</option>
                                    <option value="web_form" {{ request('source') == 'web_form' ? 'selected' : '' }}>Web Formu</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label text-white-50">Başlangıç</label>
                                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label text-white-50">Bitiş</label>
                                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-light w-100">
                                    <i class="fas fa-search me-2"></i>Filtrele
                                </button>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-md-10">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Ad, e-posta veya telefon ile ara..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('admin.leads.index') }}" class="btn btn-outline-light w-100">
                                    <i class="fas fa-times me-2"></i>Temizle
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bulk Actions -->
            <div class="bulk-actions" id="bulkActions">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <strong><span id="selectedCount">0</span></strong> lead seçildi
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#bulkAssignModal">
                            <i class="fas fa-user-plus me-1"></i>Toplu Atama
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="clearSelection()">
                            <i class="fas fa-times me-1"></i>Seçimi Temizle
                        </button>
                    </div>
                </div>
            </div>

            <!-- Leads Table -->
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white py-3 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2 text-primary"></i>Lead Listesi
                            <span class="text-muted">({{ $leads->total() }} toplam)</span>
                        </h5>
                        <div class="d-flex gap-2">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-sort me-1"></i>Tarih
                                </a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'lead_score', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-star me-1"></i>Skor
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 py-3" style="width: 30px;">
                                        <input type="checkbox" class="form-check-input" id="selectAll">
                                    </th>
                                    <th class="border-0 py-3">Lead Bilgileri</th>
                                    <th class="border-0 py-3">Status</th>
                                    <th class="border-0 py-3">Skor</th>
                                    <th class="border-0 py-3">Atanan</th>
                                    <th class="border-0 py-3">Son İletişim</th>
                                    <th class="border-0 py-3">Kaynak</th>
                                    <th class="border-0 py-3 text-center">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leads as $lead)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input lead-checkbox" value="{{ $lead->id }}">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-start">
                                            <div class="flex-fill">
                                                <div class="d-flex align-items-center mb-1">
                                                    <strong class="me-2">{{ $lead->name }}</strong>
                                                    @if($lead->preferred_contact_method)
                                                    <span class="contact-method-icon text-white"
                                                          style="background-color: {{ $lead->preferred_contact_method === 'phone' ? '#0d6efd' : '#198754' }};"
                                                          title="{{ ucfirst($lead->preferred_contact_method) }}">
                                                        <i class="fas fa-{{ $lead->preferred_contact_method === 'phone' ? 'phone' : 'envelope' }}"></i>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="text-muted small">
                                                    <i class="fas fa-envelope me-1"></i>{{ $lead->email }}
                                                </div>
                                                @if($lead->phone)
                                                <div class="text-muted small">
                                                    <i class="fas fa-phone me-1"></i>{{ $lead->phone }}
                                                </div>
                                                @endif
                                                @if($lead->country)
                                                <div class="text-muted small">
                                                    <i class="fas fa-flag me-1"></i>{{ $lead->country }}
                                                </div>
                                                @endif
                                                @if($lead->lead_tags)
                                                <div class="mt-1">
                                                    @foreach($lead->lead_tags as $tag)
                                                    <span class="badge badge-light badge-sm">{{ $tag }}</span>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($lead->leadStatus)
                                        <span class="status-badge" style="background-color: {{ $lead->leadStatus->color }}; color: white;">
                                            {{ $lead->leadStatus->display_name }}
                                        </span>
                                        @else
                                        <span class="badge badge-secondary">Belirlenmemiş</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="lead-score {{ $lead->lead_score >= 70 ? 'high' : ($lead->lead_score >= 40 ? 'medium' : 'low') }}">
                                            {{ $lead->lead_score }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($lead->assignedAdmin)
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                {{ substr($lead->assignedAdmin->firstName, 0, 1) }}{{ substr($lead->assignedAdmin->lastName, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="small font-weight-bold">{{ $lead->assignedAdmin->firstName }} {{ $lead->assignedAdmin->lastName }}</div>
                                            </div>
                                        </div>
                                        @else
                                        <span class="text-muted small">Atanmamış</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($lead->last_contact_date)
                                        <div class="small">
                                            <div>{{ $lead->last_contact_date->format('d.m.Y') }}</div>
                                            <div class="text-muted">{{ $lead->last_contact_date->diffForHumans() }}</div>
                                        </div>
                                        @else
                                        <span class="text-muted small">Hiçbir zaman</span>
                                        @endif
                                        
                                        @if($lead->next_follow_up_date)
                                        <div class="small mt-1">
                                            <span class="badge badge-{{ $lead->next_follow_up_date->isPast() ? 'danger' : 'info' }} badge-sm">
                                                Sonraki: {{ $lead->next_follow_up_date->format('d.m.Y') }}
                                            </span>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($lead->lead_source)
                                        <span class="badge bg-secondary text-white">
                                            {{ ucfirst($lead->lead_source) }}
                                        </span>
                                        @endif
                                        <div class="text-muted small">
                                            {{ $lead->created_at->format('d.m.Y H:i') }}
                                        </div>
                                    </td>
                                    <td class="text-center table-actions">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.leads.show', $lead->id) }}" 
                                               class="btn btn-outline-primary btn-sm" 
                                               title="Detaylar">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(!$lead->isAssigned() || $isSuperAdmin || $lead->assign_to === auth('admin')->id())
                                            <button type="button" 
                                                    class="btn btn-outline-success btn-sm" 
                                                    onclick="quickAssign({{ $lead->id }}, '{{ $lead->name }}')"
                                                    title="Hızlı Atama">
                                                <i class="fas fa-user-plus"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <h5>Henüz lead bulunmuyor</h5>
                                            <p>Filtreleri değiştirmeyi deneyin veya yeni lead ekleyin.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if($leads->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $leads->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-upload me-2"></i>Excel Import
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('fileImport') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Excel dosyanızın şu sütunları içermesi gerekir: <strong>name, email, phone_number, country, username (opsiyonel)</strong>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Excel Dosyası</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('downlddoc') }}" class="btn btn-outline-primary">
                            <i class="fas fa-download me-2"></i>Örnek Dosyayı İndir
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i>Import Et
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Assign Modal -->
<div class="modal fade" id="bulkAssignModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-users-cog me-2"></i>Toplu Atama
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.leads.bulk-assign') }}" method="POST" id="bulkAssignForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Admin Seçin</label>
                        <select name="admin_id" class="form-control" required>
                            <option value="">Admin seçin...</option>
                            @foreach($admins as $admin)
                            <option value="{{ $admin->id }}">
                                {{ $admin->firstName }} {{ $admin->lastName }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Seçilen <strong><span id="bulkSelectedCount">0</span></strong> lead belirtilen admin'e atanacak.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-2"></i>Ata
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Checkbox handling
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.lead-checkbox');
    const bulkActions = document.getElementById('bulkActions');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    
    updateSelectedCount();
    toggleBulkActions();
});

document.querySelectorAll('.lead-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        updateSelectedCount();
        toggleBulkActions();
        
        // Update select all checkbox
        const allCheckboxes = document.querySelectorAll('.lead-checkbox');
        const checkedCheckboxes = document.querySelectorAll('.lead-checkbox:checked');
        const selectAllCheckbox = document.getElementById('selectAll');
        
        if (checkedCheckboxes.length === allCheckboxes.length) {
            selectAllCheckbox.checked = true;
            selectAllCheckbox.indeterminate = false;
        } else if (checkedCheckboxes.length > 0) {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = true;
        } else {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
        }
    });
});

function updateSelectedCount() {
    const checkedBoxes = document.querySelectorAll('.lead-checkbox:checked');
    const count = checkedBoxes.length;
    
    document.getElementById('selectedCount').textContent = count;
    document.getElementById('bulkSelectedCount').textContent = count;
    
    // Update form with selected IDs
    const form = document.getElementById('bulkAssignForm');
    
    // Remove existing hidden inputs
    const existingInputs = form.querySelectorAll('input[name="lead_ids[]"]');
    existingInputs.forEach(input => input.remove());
    
    // Add new hidden inputs
    checkedBoxes.forEach(checkbox => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'lead_ids[]';
        input.value = checkbox.value;
        form.appendChild(input);
    });
}

function toggleBulkActions() {
    const checkedBoxes = document.querySelectorAll('.lead-checkbox:checked');
    const bulkActions = document.getElementById('bulkActions');
    
    if (checkedBoxes.length > 0) {
        bulkActions.classList.add('show');
    } else {
        bulkActions.classList.remove('show');
    }
}

function clearSelection() {
    document.querySelectorAll('.lead-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAll').checked = false;
    document.getElementById('selectAll').indeterminate = false;
    updateSelectedCount();
    toggleBulkActions();
}

function quickAssign(leadId, leadName) {
    // This could open a quick assign modal or dropdown
    // For now, redirect to detail page
    window.location.href = `/admin/dashboard/leads/${leadId}`;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateSelectedCount();
    toggleBulkActions();
});
</script>

@endsection