@extends('layouts.app')
@section('content')
@section('styles')
@parent
<script src="https://cdn.tailwindcss.com"></script>
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
            <!-- Header -->
            <div class="flex items-center justify-between mb-8 p-6 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl text-white">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-users-cog text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold">Lead Yönetimi</h1>
                        <p class="text-blue-100">Potansiyel müşterilerinizi yönetin ve takip edin</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    @if($isSuperAdmin)
                    <a href="{{ route('admin.leads.export', request()->query()) }}" 
                       class="px-4 py-2 bg-green-500 hover:bg-green-600 rounded-lg transition-colors flex items-center">
                        <i class="fas fa-download mr-2"></i>Export
                    </a>
                    <a href="{{ route('admin.lead-statuses.index') }}" 
                       class="px-4 py-2 bg-blue-500 hover:bg-blue-600 rounded-lg transition-colors flex items-center">
                        <i class="fas fa-tags mr-2"></i>Status Yönetimi
                    </a>
                    @endif
                    <button type="button" 
                            class="px-4 py-2 bg-purple-500 hover:bg-purple-600 rounded-lg transition-colors flex items-center" 
                            data-bs-toggle="modal" 
                            data-bs-target="#importModal">
                        <i class="fas fa-upload mr-2"></i>Import
                    </button>
                </div>
            </div>

            <x-danger-alert />
            <x-success-alert />

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Toplam Lead</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_leads']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 h-2 bg-gray-200 rounded-full">
                        <div class="h-full bg-blue-600 rounded-full" style="width: 100%"></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Bugünkü Yeni</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['new_leads_today']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-plus text-amber-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 h-2 bg-gray-200 rounded-full">
                        <div class="h-full bg-amber-600 rounded-full" style="width: {{ $stats['total_leads'] > 0 ? ($stats['new_leads_today'] / $stats['total_leads'] * 100) : 0 }}%"></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Atanmamış</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['unassigned_leads']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-times text-red-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 h-2 bg-gray-200 rounded-full">
                        <div class="h-full bg-red-600 rounded-full" style="width: {{ $stats['total_leads'] > 0 ? ($stats['unassigned_leads'] / $stats['total_leads'] * 100) : 0 }}%"></div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Yüksek Skor</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['high_score_leads']) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-trophy text-green-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 h-2 bg-gray-200 rounded-full">
                        <div class="h-full bg-green-600 rounded-full" style="width: {{ $stats['total_leads'] > 0 ? ($stats['high_score_leads'] / $stats['total_leads'] * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gradient-to-r from-cyan-500 to-blue-500 rounded-2xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-cyan-100 text-sm">Bugünkü Takipler</p>
                            <p class="text-3xl font-bold">{{ number_format($stats['follow_ups_today']) }}</p>
                        </div>
                        <i class="fas fa-clock text-4xl text-cyan-200"></i>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm">Gecikmiş Takipler</p>
                            <p class="text-3xl font-bold">{{ number_format($stats['overdue_follow_ups']) }}</p>
                        </div>
                        <i class="fas fa-exclamation-triangle text-4xl text-orange-200"></i>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm">Bu Haftaki Yeni</p>
                            <p class="text-3xl font-bold">{{ number_format($stats['new_leads_this_week']) }}</p>
                        </div>
                        <i class="fas fa-calendar-week text-4xl text-purple-200"></i>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 mb-6">
                <form method="GET" action="{{ route('admin.leads.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div>
                            <label class="block text-white/70 text-sm font-medium mb-2">Status</label>
                            <select name="status" class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30">
                                <option value="">Tüm Statuslar</option>
                                @foreach($leadStatuses as $status)
                                <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                                    {{ $status->display_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-white/70 text-sm font-medium mb-2">Atama</label>
                            <select name="assigned" class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30">
                                <option value="">Tümü</option>
                                <option value="unassigned" {{ request('assigned') == 'unassigned' ? 'selected' : '' }}>Atanmamış</option>
                                @foreach($admins as $admin)
                                <option value="{{ $admin->id }}" {{ request('assigned') == $admin->id ? 'selected' : '' }}>
                                    {{ $admin->firstName }} {{ $admin->lastName }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-white/70 text-sm font-medium mb-2">Kaynak</label>
                            <select name="source" class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30">
                                <option value="">Tüm Kaynaklar</option>
                                <option value="import" {{ request('source') == 'import' ? 'selected' : '' }}>Import</option>
                                <option value="manual" {{ request('source') == 'manual' ? 'selected' : '' }}>Manuel</option>
                                <option value="web_form" {{ request('source') == 'web_form' ? 'selected' : '' }}>Web Formu</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-white/70 text-sm font-medium mb-2">Başlangıç</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                   class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30">
                        </div>
                        <div>
                            <label class="block text-white/70 text-sm font-medium mb-2">Bitiş</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                   class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full px-4 py-2 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                                <i class="fas fa-search mr-2"></i>Filtrele
                            </button>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        <div class="md:col-span-5">
                            <input type="text" name="search" placeholder="Ad, e-posta veya telefon ile ara..." value="{{ request('search') }}"
                                   class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30">
                        </div>
                        <div>
                            <a href="{{ route('admin.leads.index') }}" class="w-full px-4 py-3 bg-white/20 text-white font-semibold rounded-lg hover:bg-white/30 transition-colors flex items-center justify-center">
                                <i class="fas fa-times mr-2"></i>Temizle
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Bulk Actions -->
            <div id="bulkActions" class="hidden bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl p-4 mb-6">
                <div class="flex items-center justify-between">
                    <div class="text-gray-700">
                        <strong><span id="selectedCount">0</span></strong> lead seçildi
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center" 
                                data-bs-toggle="modal" 
                                data-bs-target="#bulkAssignModal">
                            <i class="fas fa-user-plus mr-2"></i>Toplu Atama
                        </button>
                        <button type="button" 
                                onclick="clearSelection()" 
                                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors flex items-center">
                            <i class="fas fa-times mr-2"></i>Seçimi Temizle
                        </button>
                    </div>
                </div>
            </div>

            <!-- Leads Table -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-list text-blue-600 text-xl mr-3"></i>
                            <h3 class="text-xl font-semibold text-gray-900">Lead Listesi</h3>
                            <span class="ml-2 text-gray-500">({{ $leads->total() }} toplam)</span>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors text-sm">
                                <i class="fas fa-sort mr-1"></i>Tarih
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'lead_score', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors text-sm">
                                <i class="fas fa-star mr-1"></i>Skor
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left">
                                    <input type="checkbox" id="selectAll" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lead Bilgileri</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skor</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Atanan</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Son İletişim</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kaynak</th>
                                <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($leads as $lead)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" class="lead-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" value="{{ $lead->id }}">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-start">
                                        <div>
                                            <div class="flex items-center">
                                                <div class="text-sm font-medium text-gray-900">{{ $lead->name }}</div>
                                                @if($lead->preferred_contact_method)
                                                <span class="ml-2 inline-flex items-center justify-center w-5 h-5 text-xs text-white rounded-full {{ $lead->preferred_contact_method === 'phone' ? 'bg-blue-500' : 'bg-green-500' }}">
                                                    <i class="fas fa-{{ $lead->preferred_contact_method === 'phone' ? 'phone' : 'envelope' }}"></i>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                <i class="fas fa-envelope mr-1"></i>{{ $lead->email }}
                                            </div>
                                            @if($lead->phone)
                                            <div class="text-sm text-gray-500">
                                                <i class="fas fa-phone mr-1"></i>{{ $lead->phone }}
                                            </div>
                                            @endif
                                            @if($lead->country)
                                            <div class="text-sm text-gray-500">
                                                <i class="fas fa-flag mr-1"></i>{{ $lead->country }}
                                            </div>
                                            @endif
                                            @if($lead->lead_tags)
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                @foreach($lead->lead_tags as $tag)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">{{ $tag }}</span>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($lead->leadStatus)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white"
                                          style="background-color: {{ $lead->leadStatus->color }};">
                                        {{ $lead->leadStatus->display_name }}
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-500 text-white">
                                        Belirlenmemiş
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full text-sm font-bold border-2
                                                {{ $lead->lead_score >= 70 ? 'bg-green-100 text-green-800 border-green-400' : 
                                                   ($lead->lead_score >= 40 ? 'bg-yellow-100 text-yellow-800 border-yellow-400' : 'bg-red-100 text-red-800 border-red-400') }}">
                                        {{ $lead->lead_score }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($lead->assignedAdmin)
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-8 h-8">
                                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-medium">
                                                {{ substr($lead->assignedAdmin->firstName, 0, 1) }}{{ substr($lead->assignedAdmin->lastName, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-2">
                                            <div class="text-sm font-medium text-gray-900">{{ $lead->assignedAdmin->firstName }} {{ $lead->assignedAdmin->lastName }}</div>
                                        </div>
                                    </div>
                                    @else
                                    <span class="text-sm text-gray-500">Atanmamış</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($lead->last_contact_date)
                                    <div>
                                        <div>{{ $lead->last_contact_date->format('d.m.Y') }}</div>
                                        <div class="text-gray-500">{{ $lead->last_contact_date->diffForHumans() }}</div>
                                    </div>
                                    @else
                                    <span class="text-gray-500">Hiçbir zaman</span>
                                    @endif
                                    
                                    @if($lead->next_follow_up_date)
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                     {{ $lead->next_follow_up_date->isPast() ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                            Sonraki: {{ $lead->next_follow_up_date->format('d.m.Y') }}
                                        </span>
                                    </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($lead->lead_source)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ ucfirst($lead->lead_source) }}
                                    </span>
                                    @endif
                                    <div class="text-sm text-gray-500 mt-1">
                                        {{ $lead->created_at->format('d.m.Y H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.leads.show', $lead->id) }}" 
                                           class="text-blue-600 hover:text-blue-900 transition-colors" 
                                           title="Detaylar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(!$lead->isAssigned() || $isSuperAdmin || $lead->assign_to === auth('admin')->id())
                                        <button type="button" 
                                                onclick="quickAssign({{ $lead->id }}, '{{ $lead->name }}')" 
                                                class="text-green-600 hover:text-green-900 transition-colors" 
                                                title="Hızlı Atama">
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="text-gray-400">
                                        <i class="fas fa-inbox text-4xl mb-4"></i>
                                        <h3 class="text-lg font-medium text-gray-900 mb-1">Henüz lead bulunmuyor</h3>
                                        <p class="text-gray-500">Filtreleri değiştirmeyi deneyin veya yeni lead ekleyin.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($leads->hasPages())
            <div class="flex justify-center mt-6">
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
        bulkActions.classList.remove('hidden');
    } else {
        bulkActions.classList.add('hidden');
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
    window.location.href = `/admin/dashboard/leads/${leadId}`;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateSelectedCount();
    toggleBulkActions();
});
</script>

@endsection