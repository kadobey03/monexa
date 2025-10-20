@extends('layouts.app')
@section('content')
@section('styles')
<style>
    .status-card {
        transition: all 0.3s ease;
        border-left: 4px solid #dee2e6;
    }
    .status-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .status-preview {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }
    .color-picker {
        width: 50px;
        height: 38px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .sortable-handle {
        cursor: move;
        color: #6c757d;
    }
    .sortable-handle:hover {
        color: #495057;
    }
    .badge-lg {
        font-size: 0.9rem;
        padding: 0.5rem 0.75rem;
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
                        <div class="page-icon bg-gradient-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-tags fa-2x"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="title1 mb-1">Lead Status Yönetimi</h1>
                        <p class="text-muted mb-0">Lead durumlarını oluşturun, düzenleyin ve yönetin</p>
                    </div>
                </div>
                <div class="ml-auto">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createStatusModal">
                        <i class="fas fa-plus me-2"></i>Yeni Status Ekle
                    </button>
                </div>
            </div>

            <x-danger-alert />
            <x-success-alert />

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="text-primary mb-2">
                                <i class="fas fa-list-ol fa-2x"></i>
                            </div>
                            <h3 class="mb-1">{{ $statuses->count() }}</h3>
                            <p class="text-muted mb-0">Toplam Status</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="text-success mb-2">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <h3 class="mb-1">{{ $statuses->where('is_active', true)->count() }}</h3>
                            <p class="text-muted mb-0">Aktif Status</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="text-warning mb-2">
                                <i class="fas fa-pause-circle fa-2x"></i>
                            </div>
                            <h3 class="mb-1">{{ $statuses->where('is_active', false)->count() }}</h3>
                            <p class="text-muted mb-0">Pasif Status</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="text-info mb-2">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                            <h3 class="mb-1">{{ $statuses->sum('user_count') }}</h3>
                            <p class="text-muted mb-0">Toplam Lead</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status List -->
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>Status Listesi
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 py-3" style="width: 50px;">
                                        <i class="fas fa-sort text-muted"></i>
                                    </th>
                                    <th class="border-0 py-3">Status</th>
                                    <th class="border-0 py-3">Görünen Ad</th>
                                    <th class="border-0 py-3">Açıklama</th>
                                    <th class="border-0 py-3">Kullanıcı Sayısı</th>
                                    <th class="border-0 py-3">Sıra</th>
                                    <th class="border-0 py-3">Durum</th>
                                    <th class="border-0 py-3 text-center">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-statuses">
                                @foreach($statuses as $status)
                                <tr data-id="{{ $status->id }}">
                                    <td class="text-center">
                                        <i class="fas fa-grip-vertical sortable-handle"></i>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="status-preview" style="background-color: {{ $status->color }};"></span>
                                            <code>{{ $status->name }}</code>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $status->display_name }}</strong>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ Str::limit($status->description, 50) }}</span>
                                    </td>
                                    <td>
                                        @if($status->user_count > 0)
                                            <span class="badge badge-info badge-lg">{{ $status->user_count }} lead</span>
                                        @else
                                            <span class="text-muted">0 lead</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $status->sort_order }}</span>
                                    </td>
                                    <td>
                                        @if($status->is_active)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-warning">Pasif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    onclick="editStatus({{ $status->id }}, '{{ $status->name }}', '{{ $status->display_name }}', '{{ $status->color }}', '{{ $status->description }}', {{ $status->sort_order }}, {{ $status->is_active ? 'true' : 'false' }})"
                                                    data-bs-toggle="modal" data-bs-target="#editStatusModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            
                                            <form method="POST" action="{{ route('admin.lead-statuses.toggle', $status) }}" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-{{ $status->is_active ? 'warning' : 'success' }}">
                                                    <i class="fas fa-{{ $status->is_active ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>

                                            @if(!in_array($status->name, ['new', 'converted', 'lost']) && $status->user_count == 0)
                                            <form method="POST" action="{{ route('admin.lead-statuses.destroy', $status) }}" 
                                                  onsubmit="return confirm('Bu statusu silmek istediğinizden emin misiniz?')" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Status Modal -->
<div class="modal fade" id="createStatusModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Yeni Lead Status
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.lead-statuses.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status Adı (Kod)</label>
                                <input type="text" name="name" class="form-control" placeholder="ornek: interested" required>
                                <small class="text-muted">Sadece küçük harf ve alt çizgi kullanın</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Görünen Ad</label>
                                <input type="text" name="display_name" class="form-control" placeholder="İlgileniyor" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Renk</label>
                                <input type="color" name="color" class="form-control color-picker" value="#6c757d">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Sıra</label>
                                <input type="number" name="sort_order" class="form-control" value="{{ $statuses->max('sort_order') + 1 }}" min="1">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Bu statusun açıklaması..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Status Modal -->
<div class="modal fade" id="editStatusModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Lead Status Düzenle
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="editStatusForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status Adı (Kod)</label>
                                <input type="text" name="name" id="edit_name" class="form-control" required>
                                <small class="text-muted">Sadece küçük harf ve alt çizgi kullanın</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Görünen Ad</label>
                                <input type="text" name="display_name" id="edit_display_name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Renk</label>
                                <input type="color" name="color" id="edit_color" class="form-control color-picker">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Sıra</label>
                                <input type="number" name="sort_order" id="edit_sort_order" class="form-control" min="1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Durum</label>
                                <select name="is_active" id="edit_is_active" class="form-control">
                                    <option value="1">Aktif</option>
                                    <option value="0">Pasif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Açıklama</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-warning">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editStatus(id, name, displayName, color, description, sortOrder, isActive) {
    document.getElementById('editStatusForm').action = `/admin/dashboard/lead-statuses/${id}`;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_display_name').value = displayName;
    document.getElementById('edit_color').value = color;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_sort_order').value = sortOrder;
    document.getElementById('edit_is_active').value = isActive ? '1' : '0';
}

// Sortable functionality (if needed)
// You can implement drag & drop sorting here using SortableJS or similar
</script>

@endsection