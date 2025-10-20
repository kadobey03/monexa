@extends('layouts.app')
@section('content')
@section('styles')
@parent
<!-- Tailwind CSS artık app.blade.php'den gelir -->
<script>
  tailwind.config = {
    important: true,
    corePlugins: {
      preflight: false,
    }
  }
</script>
@endsection

@include('admin.topmenu')
@include('admin.sidebar')

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li>
                        <a href="{{ route('admin.leads.index') }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                            Lead Yönetimi
                        </a>
                    </li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-gray-900 font-medium">{{ $lead->name }}</li>
                </ol>
            </nav>

            <x-danger-alert />
            <x-success-alert />

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Lead Header -->
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 text-white shadow-xl">
                        <div class="flex flex-col md:flex-row items-start justify-between">
                            <div class="flex-1">
                                <h1 class="text-3xl font-bold mb-4">{{ $lead->name }}</h1>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope mr-3 text-indigo-200"></i>
                                        <span class="text-indigo-100">{{ $lead->email }}</span>
                                    </div>
                                    @if($lead->phone)
                                    <div class="flex items-center">
                                        <i class="fas fa-phone mr-3 text-indigo-200"></i>
                                        <span class="text-indigo-100">{{ $lead->phone }}</span>
                                    </div>
                                    @endif
                                    @if($lead->country)
                                    <div class="flex items-center">
                                        <i class="fas fa-flag mr-3 text-indigo-200"></i>
                                        <span class="text-indigo-100">{{ $lead->country }}</span>
                                    </div>
                                    @endif
                                </div>
                                
                                @if($lead->lead_tags)
                                <div class="flex flex-wrap gap-2 mt-4">
                                    @foreach($lead->lead_tags as $tag)
                                    <span class="px-3 py-1 bg-white/20 rounded-full text-sm font-medium backdrop-blur-sm">
                                        {{ $tag }}
                                    </span>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            
                            <div class="flex flex-col items-center mt-6 md:mt-0">
                                <div class="w-20 h-20 rounded-full flex items-center justify-center text-2xl font-bold border-4 {{ $lead->lead_score >= 70 ? 'bg-green-100 text-green-800 border-green-400' : ($lead->lead_score >= 40 ? 'bg-yellow-100 text-yellow-800 border-yellow-400' : 'bg-red-100 text-red-800 border-red-400') }}">
                                    {{ $lead->lead_score }}
                                </div>
                                <span class="text-indigo-200 text-sm mt-2">Lead Skoru</span>
                            </div>
                        </div>
                    </div>

                    <!-- Lead Details Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- General Info -->
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                            <div class="bg-blue-600 text-white px-6 py-4">
                                <h3 class="text-lg font-semibold flex items-center">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Genel Bilgiler
                                </h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">Kayıt Tarihi:</span>
                                    <span class="text-gray-900">{{ $lead->created_at->format('d.m.Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">Kaynak:</span>
                                    <div>
                                        @if($lead->lead_source)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($lead->lead_source) }}
                                        </span>
                                        @else
                                        <span class="text-gray-400">Bilinmiyor</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">İletişim Tercihi:</span>
                                    <div>
                                        @if($lead->preferred_contact_method)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-{{ $lead->preferred_contact_method === 'phone' ? 'phone' : 'envelope' }} mr-1"></i>
                                            {{ ucfirst($lead->preferred_contact_method) }}
                                        </span>
                                        @else
                                        <span class="text-gray-400">Belirlenmemiş</span>
                                        @endif
                                    </div>
                                </div>
                                @if($lead->estimated_value)
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">Tahmini Değer:</span>
                                    <span class="text-green-600 font-bold">
                                        {{ number_format($lead->estimated_value, 2) }} ₺
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Follow-up Info -->
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                            <div class="bg-cyan-600 text-white px-6 py-4">
                                <h3 class="text-lg font-semibold flex items-center">
                                    <i class="fas fa-clock mr-2"></i>
                                    Takip Bilgileri
                                </h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">Son İletişim:</span>
                                    <div class="text-right">
                                        @if($lead->last_contact_date)
                                        <div class="text-gray-900">{{ $lead->last_contact_date->format('d.m.Y H:i') }}</div>
                                        <div class="text-gray-500 text-sm">{{ $lead->last_contact_date->diffForHumans() }}</div>
                                        @else
                                        <span class="text-gray-400">Hiçbir zaman</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">Sonraki Takip:</span>
                                    <div class="text-right">
                                        @if($lead->next_follow_up_date)
                                        <div>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $lead->next_follow_up_date->isPast() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $lead->next_follow_up_date->format('d.m.Y') }}
                                            </span>
                                        </div>
                                        @if($lead->next_follow_up_date->isPast())
                                        <div class="text-red-500 text-sm">Gecikmiş!</div>
                                        @else
                                        <div class="text-gray-500 text-sm">{{ $lead->next_follow_up_date->diffForHumans() }}</div>
                                        @endif
                                        @else
                                        <span class="text-gray-400">Planlanmamış</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">İletişim Sayısı:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ count($lead->contact_history ?? []) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    @if($lead->lead_notes)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-amber-600 text-white px-6 py-4">
                            <h3 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-sticky-note mr-2"></i>
                                Notlar
                            </h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700 leading-relaxed">{{ $lead->lead_notes }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Contact History -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-gray-700 text-white px-6 py-4">
                            <h3 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-history mr-2"></i>
                                İletişim Geçmişi
                            </h3>
                        </div>
                        <div class="p-6">
                            @if($lead->contact_history && count($lead->contact_history) > 0)
                            <div class="space-y-6">
                                @foreach(collect($lead->contact_history)->sortByDesc('created_at') as $contact)
                                <div class="relative pl-8 pb-6 border-l-2 border-gray-200 last:border-l-0 last:pb-0">
                                    <div class="absolute -left-2 top-0 w-4 h-4 rounded-full border-2 border-white shadow-md
                                                {{ $contact['type'] === 'call' ? 'bg-green-500' : 
                                                   ($contact['type'] === 'email' ? 'bg-blue-500' : 
                                                   ($contact['type'] === 'meeting' ? 'bg-yellow-500' : 
                                                   ($contact['type'] === 'note' ? 'bg-purple-500' : 'bg-orange-500'))) }}">
                                    </div>
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="text-lg font-medium text-gray-900 capitalize">{{ ucfirst($contact['type']) }}</h4>
                                        <time class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($contact['created_at'])->format('d.m.Y H:i') }}
                                        </time>
                                    </div>
                                    <p class="text-gray-700 mb-2">{{ $contact['note'] }}</p>
                                    @if(isset($contact['admin_id']) && $contact['admin_id'])
                                    <div class="text-sm text-gray-500">
                                        <i class="fas fa-user mr-1"></i>
                                        @php
                                            $admin = \App\Models\Admin::find($contact['admin_id']);
                                        @endphp
                                        {{ $admin ? $admin->firstName . ' ' . $admin->lastName : 'Bilinmeyen Admin' }}
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-12">
                                <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500">Henüz iletişim kaydı bulunmuyor.</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Add Contact Form -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-plus-circle mr-3 text-blue-600"></i>
                            Yeni İletişim Kaydı
                        </h3>
                        <form method="POST" action="{{ route('admin.leads.add-contact', $lead->id) }}" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">İletişim Türü</label>
                                    <select name="contact_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                        <option value="call">Telefon Görüşmesi</option>
                                        <option value="email">E-posta</option>
                                        <option value="meeting">Toplantı</option>
                                        <option value="note">Not</option>
                                        <option value="sms">SMS</option>
                                        <option value="whatsapp">WhatsApp</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Sonraki Takip Tarihi</label>
                                    <input type="date" name="next_follow_up_date" min="{{ now()->format('Y-m-d') }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">İletişim Notu</label>
                                <textarea name="contact_note" rows="4" required
                                          placeholder="İletişim detaylarını buraya yazın..."
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                            </div>
                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                                <i class="fas fa-save mr-2"></i>Kaydet
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Current Status -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-emerald-600 text-white px-6 py-4">
                            <h3 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-flag mr-2"></i>
                                Mevcut Durum
                            </h3>
                        </div>
                        <div class="p-6 text-center">
                            @if($lead->leadStatus)
                            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold text-white mb-3"
                                 style="background-color: {{ $lead->leadStatus->color }};">
                                {{ $lead->leadStatus->display_name }}
                            </div>
                            @if($lead->leadStatus->description)
                            <p class="text-gray-600 text-sm">{{ $lead->leadStatus->description }}</p>
                            @endif
                            @else
                            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gray-500 text-white">
                                Belirlenmemiş
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Assignment Info -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-blue-600 text-white px-6 py-4">
                            <h3 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-user-tie mr-2"></i>
                                Atama Bilgisi
                            </h3>
                        </div>
                        <div class="p-6 text-center">
                            @if($lead->assignedAdmin)
                            <div class="flex items-center justify-center mb-4">
                                <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                    {{ substr($lead->assignedAdmin->firstName, 0, 1) }}{{ substr($lead->assignedAdmin->lastName, 0, 1) }}
                                </div>
                                <div class="text-left">
                                    <div class="text-gray-900 font-semibold">{{ $lead->assignedAdmin->firstName }} {{ $lead->assignedAdmin->lastName }}</div>
                                    <div class="text-gray-500 text-sm">{{ $lead->assignedAdmin->email ?? '' }}</div>
                                </div>
                            </div>
                            @else
                            <div class="text-gray-400 py-4">
                                <i class="fas fa-user-times text-4xl mb-3"></i>
                                <p>Henüz atanmamış</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-indigo-600 text-white px-6 py-4">
                            <h3 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-bolt mr-2"></i>
                                Hızlı İşlemler
                            </h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <button type="button" 
                                    class="w-full px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors flex items-center justify-center"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateLeadModal">
                                <i class="fas fa-edit mr-2"></i>Lead Bilgilerini Güncelle
                            </button>
                            
                            @if($lead->phone)
                            <a href="tel:{{ $lead->phone }}" 
                               class="w-full px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors flex items-center justify-center">
                                <i class="fas fa-phone mr-2"></i>Ara
                            </a>
                            @endif
                            
                            <a href="mailto:{{ $lead->email }}" 
                               class="w-full px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors flex items-center justify-center">
                                <i class="fas fa-envelope mr-2"></i>E-posta Gönder
                            </a>

                            @if($lead->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->phone) }}" 
                               target="_blank"
                               class="w-full px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors flex items-center justify-center">
                                <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Lead Score Breakdown -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        <div class="bg-amber-600 text-white px-6 py-4">
                            <h3 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-chart-line mr-2"></i>
                                Skor Detayları
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="mb-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">Toplam Skor</span>
                                    <span class="text-sm font-bold text-gray-900">{{ $lead->lead_score }}/100</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="h-3 rounded-full {{ $lead->lead_score >= 70 ? 'bg-green-500' : ($lead->lead_score >= 40 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                         style="width: {{ $lead->lead_score }}%"></div>
                                </div>
                            </div>
                            
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span>Temel Skor:</span>
                                    <span class="font-medium">10 puan</span>
                                </div>
                                @if($lead->phone)
                                <div class="flex justify-between">
                                    <span>Telefon:</span>
                                    <span class="font-medium text-green-600">+15 puan</span>
                                </div>
                                @endif
                                @if($lead->contact_history && count($lead->contact_history) > 0)
                                <div class="flex justify-between">
                                    <span>İletişim Geçmişi:</span>
                                    <span class="font-medium text-green-600">+{{ min(count($lead->contact_history) * 5, 30) }} puan</span>
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