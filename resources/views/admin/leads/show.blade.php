@extends('layouts.app')
@section('content')
@section('styles')
@parent

<style>
    .lead-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px 15px 0 0;
    }
    .info-card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }
    .lead-score-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
        position: relative;
        overflow: hidden;
    }
    .lead-score-circle::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: conic-gradient(from 0deg, #28a745 0%, #28a745 var(--percentage), #e9ecef var(--percentage));
        border-radius: 50%;
        z-index: -1;
    }
    .lead-score-circle.high { --percentage: 80%; background: rgba(40, 167, 69, 0.1); color: #28a745; }
    .lead-score-circle.medium { --percentage: 60%; background: rgba(255, 193, 7, 0.1); color: #ffc107; }
    .lead-score-circle.low { --percentage: 30%; background: rgba(220, 53, 69, 0.1); color: #dc3545; }
    .timeline-item {
        border-left: 2px solid #e9ecef;
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
        position: relative;
    }
    .timeline-item::before {
        content: '';
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #667eea;
        position: absolute;
        left: -7px;
        top: 0;
        border: 2px solid white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .timeline-item.timeline-call::before { background: #28a745; }
    .timeline-item.timeline-email::before { background: #17a2b8; }
    .timeline-item.timeline-meeting::before { background: #ffc107; }
    .timeline-item.timeline-note::before { background: #6f42c1; }
    .timeline-item.timeline-import::before { background: #fd7e14; }
    .status-badge {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .contact-form {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 1.5rem;
    }
    .quick-actions {
        position: sticky;
        top: 100px;
        z-index: 10;
    }
    .lead-tag {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 20px;
        padding: 0.25rem 0.75rem;
        font-size: 0.8rem;
        margin: 0.125rem;
    }
</style>
@endsection

@include('admin.topmenu')
@include('admin.sidebar')

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.leads.index') }}">Lead Yönetimi</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $lead->name }}</li>
                </ol>
            </nav>

            <x-danger-alert />
            <x-success-alert />

            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Lead Header -->
                    <div class="card info-card mb-4">
                        <div class="lead-header p-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h2 class="mb-2">{{ $lead->name }}</h2>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-envelope me-2"></i>
                                        <span>{{ $lead->email }}</span>
                                    </div>
                                    @if($lead->phone)
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-phone me-2"></i>
                                        <span>{{ $lead->phone }}</span>
                                    </div>
                                    @endif
                                    @if($lead->country)
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-flag me-2"></i>
                                        <span>{{ $lead->country }}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="lead-score-circle {{ $lead->lead_score >= 70 ? 'high' : ($lead->lead_score >= 40 ? 'medium' : 'low') }} mx-auto mb-2" 
                                         style="--percentage: {{ $lead->lead_score }}%;">
                                        {{ $lead->lead_score }}
                                    </div>
                                    <div class="small opacity-75">Lead Skoru</div>
                                </div>
                            </div>
                            
                            @if($lead->lead_tags)
                            <div class="mt-3">
                                @foreach($lead->lead_tags as $tag)
                                <span class="lead-tag">{{ $tag }}</span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Lead Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card info-card h-100">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-info-circle me-2"></i>Genel Bilgiler
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <strong>Kayıt Tarihi:</strong>
                                        </div>
                                        <div class="col-6">
                                            {{ $lead->created_at->format('d.m.Y H:i') }}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <strong>Kaynak:</strong>
                                        </div>
                                        <div class="col-6">
                                            @if($lead->lead_source)
                                            <span class="badge bg-secondary text-white">{{ ucfirst($lead->lead_source) }}</span>
                                            @else
                                            <span class="text-muted">Bilinmiyor</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <strong>İletişim Tercihi:</strong>
                                        </div>
                                        <div class="col-6">
                                            @if($lead->preferred_contact_method)
                                            <span class="badge bg-info text-white">
                                                <i class="fas fa-{{ $lead->preferred_contact_method === 'phone' ? 'phone' : 'envelope' }} me-1"></i>
                                                {{ ucfirst($lead->preferred_contact_method) }}
                                            </span>
                                            @else
                                            <span class="text-muted">Belirlenmemiş</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if($lead->estimated_value)
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <strong>Tahmini Değer:</strong>
                                        </div>
                                        <div class="col-6">
                                            <span class="text-success font-weight-bold">
                                                {{ number_format($lead->estimated_value, 2) }} ₺
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card info-card h-100">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-clock me-2"></i>Takip Bilgileri
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <strong>Son İletişim:</strong>
                                        </div>
                                        <div class="col-6">
                                            @if($lead->last_contact_date)
                                            <div>{{ $lead->last_contact_date->format('d.m.Y H:i') }}</div>
                                            <small class="text-muted">{{ $lead->last_contact_date->diffForHumans() }}</small>
                                            @else
                                            <span class="text-muted">Hiçbir zaman</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <strong>Sonraki Takip:</strong>
                                        </div>
                                        <div class="col-6">
                                            @if($lead->next_follow_up_date)
                                            <div>
                                                <span class="badge bg-{{ $lead->next_follow_up_date->isPast() ? 'danger' : 'success' }} text-white">
                                                    {{ $lead->next_follow_up_date->format('d.m.Y') }}
                                                </span>
                                            </div>
                                            @if($lead->next_follow_up_date->isPast())
                                            <small class="text-danger">Gecikmiş!</small>
                                            @else
                                            <small class="text-muted">{{ $lead->next_follow_up_date->diffForHumans() }}</small>
                                            @endif
                                            @else
                                            <span class="text-muted">Planlanmamış</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <strong>İletişim Sayısı:</strong>
                                        </div>
                                        <div class="col-6">
                                            <span class="badge bg-primary text-white">{{ count($lead->contact_history ?? []) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    @if($lead->lead_notes)
                    <div class="card info-card mb-4">
                        <div class="card-header bg-warning text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-sticky-note me-2"></i>Notlar
                            </h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $lead->lead_notes }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Contact History -->
                    <div class="card info-card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-history me-2"></i>İletişim Geçmişi
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($lead->contact_history && count($lead->contact_history) > 0)
                            <div class="timeline">
                                @foreach(collect($lead->contact_history)->sortByDesc('created_at') as $contact)
                                <div class="timeline-item timeline-{{ $contact['type'] }}">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <strong class="text-capitalize">{{ ucfirst($contact['type']) }}</strong>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($contact['created_at'])->format('d.m.Y H:i') }}
                                        </small>
                                    </div>
                                    <p class="mb-1">{{ $contact['note'] }}</p>
                                    @if(isset($contact['admin_id']) && $contact['admin_id'])
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>
                                        @php
                                            $admin = \App\Models\Admin::find($contact['admin_id']);
                                        @endphp
                                        {{ $admin ? $admin->firstName . ' ' . $admin->lastName : 'Bilinmeyen Admin' }}
                                    </small>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-comments fa-3x mb-3 opacity-50"></i>
                                <p>Henüz iletişim kaydı bulunmuyor.</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Add Contact Form -->
                    <div class="contact-form mb-4">
                        <h5 class="mb-3">
                            <i class="fas fa-plus-circle me-2 text-primary"></i>Yeni İletişim Kaydı
                        </h5>
                        <form method="POST" action="{{ route('admin.leads.add-contact', $lead->id) }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">İletişim Türü</label>
                                    <select name="contact_type" class="form-control" required>
                                        <option value="call">Telefon Görüşmesi</option>
                                        <option value="email">E-posta</option>
                                        <option value="meeting">Toplantı</option>
                                        <option value="note">Not</option>
                                        <option value="sms">SMS</option>
                                        <option value="whatsapp">WhatsApp</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Sonraki Takip Tarihi</label>
                                    <input type="date" name="next_follow_up_date" class="form-control" 
                                           min="{{ now()->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">İletişim Notu</label>
                                <textarea name="contact_note" class="form-control" rows="4" 
                                          placeholder="İletişim detaylarını buraya yazın..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Kaydet
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="quick-actions">
                        <!-- Current Status -->
                        <div class="card info-card mb-4">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-flag me-2"></i>Mevcut Durum
                                </h6>
                            </div>
                            <div class="card-body text-center">
                                @if($lead->leadStatus)
                                <div class="status-badge mb-3"
                                     style="background-color: {{ $lead->leadStatus->color }}; color: white; border: 2px solid {{ $lead->leadStatus->color }};">
                                    {{ $lead->leadStatus->display_name }}
                                </div>
                                <p class="text-muted small">{{ $lead->leadStatus->description }}</p>
                                @else
                                <div class="status-badge mb-3" style="background-color: #6c757d; color: white;">
                                    Belirlenmemiş
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Assignment Info -->
                        <div class="card info-card mb-4">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-user-tie me-2"></i>Atama Bilgisi
                                </h6>
                            </div>
                            <div class="card-body text-center">
                                @if($lead->assignedAdmin)
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                                         style="width: 50px; height: 50px;">
                                        {{ substr($lead->assignedAdmin->firstName, 0, 1) }}{{ substr($lead->assignedAdmin->lastName, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold">{{ $lead->assignedAdmin->firstName }} {{ $lead->assignedAdmin->lastName }}</div>
                                        <small class="text-muted">{{ $lead->assignedAdmin->email ?? '' }}</small>
                                    </div>
                                </div>
                                @else
                                <div class="text-muted">
                                    <i class="fas fa-user-times fa-3x mb-2 opacity-50"></i>
                                    <p>Henüz atanmamış</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="card info-card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-bolt me-2"></i>Hızlı İşlemler
                                </h6>
                            </div>
                            <div class="card-body">
                                <button type="button" class="btn btn-outline-primary btn-sm w-100 mb-2" 
                                        data-bs-toggle="modal" data-bs-target="#updateLeadModal">
                                    <i class="fas fa-edit me-2"></i>Lead Bilgilerini Güncelle
                                </button>
                                
                                @if($lead->phone)
                                <a href="tel:{{ $lead->phone }}" class="btn btn-outline-success btn-sm w-100 mb-2">
                                    <i class="fas fa-phone me-2"></i>Ara
                                </a>
                                @endif
                                
                                <a href="mailto:{{ $lead->email }}" class="btn btn-outline-info btn-sm w-100 mb-2">
                                    <i class="fas fa-envelope me-2"></i>E-posta Gönder
                                </a>

                                @if($lead->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" 
                                   target="_blank" class="btn btn-outline-success btn-sm w-100 mb-2">
                                    <i class="fab fa-whatsapp me-2"></i>WhatsApp
                                </a>
                                @endif
                            </div>
                        </div>

                        <!-- Lead Score Breakdown -->
                        <div class="card info-card">
                            <div class="card-header bg-warning text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-chart-line me-2"></i>Skor Detayları
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <small class="text-muted">Toplam Skor</small>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-{{ $lead->lead_score >= 70 ? 'success' : ($lead->lead_score >= 40 ? 'warning' : 'danger') }}" 
                                             style="width: {{ $lead->lead_score }}%"></div>
                                    </div>
                                    <small><strong>{{ $lead->lead_score }}/100</strong></small>
                                </div>
                                
                                <div class="small text-muted mt-3">
                                    <div class="d-flex justify-content-between">
                                        <span>Temel Skor:</span>
                                        <span>10 puan</span>
                                    </div>
                                    @if($lead->phone)
                                    <div class="d-flex justify-content-between">
                                        <span>Telefon:</span>
                                        <span>+15 puan</span>
                                    </div>
                                    @endif
                                    @if($lead->contact_history && count($lead->contact_history) > 0)
                                    <div class="d-flex justify-content-between">
                                        <span>İletişim Geçmişi:</span>
                                        <span>+{{ min(count($lead->contact_history) * 5, 30) }} puan</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Lead Modal -->
<div class="modal fade" id="updateLeadModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Lead Bilgilerini Güncelle
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.leads.update', $lead->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Lead Status</label>
                            <select name="lead_status_id" class="form-control">
                                <option value="">Status seçin...</option>
                                @foreach($leadStatuses as $status)
                                <option value="{{ $status->id }}" 
                                        {{ $lead->lead_status_id == $status->id ? 'selected' : '' }}>
                                    {{ $status->display_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Atanan Admin</label>
                            <select name="assign_to" class="form-control">
                                <option value="">Admin seçin...</option>
                                @foreach($admins as $admin)
                                <option value="{{ $admin->id }}" 
                                        {{ $lead->assign_to == $admin->id ? 'selected' : '' }}>
                                    {{ $admin->firstName }} {{ $admin->lastName }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tahmini Değer (₺)</label>
                            <input type="number" name="estimated_value" class="form-control" 
                                   value="{{ $lead->estimated_value }}" min="0" step="0.01">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">İletişim Tercihi</label>
                            <select name="preferred_contact_method" class="form-control">
                                <option value="">Seçin...</option>
                                <option value="phone" {{ $lead->preferred_contact_method == 'phone' ? 'selected' : '' }}>Telefon</option>
                                <option value="email" {{ $lead->preferred_contact_method == 'email' ? 'selected' : '' }}>E-posta</option>
                                <option value="whatsapp" {{ $lead->preferred_contact_method == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                <option value="sms" {{ $lead->preferred_contact_method == 'sms' ? 'selected' : '' }}>SMS</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sonraki Takip Tarihi</label>
                        <input type="date" name="next_follow_up_date" class="form-control" 
                               value="{{ $lead->next_follow_up_date ? $lead->next_follow_up_date->format('Y-m-d') : '' }}"
                               min="{{ now()->format('Y-m-d') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lead Etiketleri</label>
                        <input type="text" name="lead_tags[]" class="form-control" 
                               placeholder="Etiketleri virgülle ayırın" 
                               value="{{ $lead->lead_tags ? implode(', ', $lead->lead_tags) : '' }}">
                        <small class="text-muted">Örnek: yüksek potansiyel, acil, sıcak lead</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notlar</label>
                        <textarea name="lead_notes" class="form-control" rows="4" 
                                  placeholder="Lead ile ilgili notlarınızı buraya yazın...">{{ $lead->lead_notes }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Güncelle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Tag input handling
document.querySelector('input[name="lead_tags[]"]').addEventListener('blur', function() {
    // Convert comma-separated string to array
    const tags = this.value.split(',').map(tag => tag.trim()).filter(tag => tag.length > 0);
    this.setAttribute('data-tags', JSON.stringify(tags));
});

// Before form submission, convert tags to proper format
document.querySelector('#updateLeadModal form').addEventListener('submit', function(e) {
    const tagInput = this.querySelector('input[name="lead_tags[]"]');
    const tags = tagInput.value.split(',').map(tag => tag.trim()).filter(tag => tag.length > 0);
    
    // Remove the text input
    tagInput.remove();
    
    // Add hidden inputs for each tag
    tags.forEach((tag, index) => {
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'lead_tags[]';
        hiddenInput.value = tag;
        this.appendChild(hiddenInput);
    });
});
</script>

@endsection