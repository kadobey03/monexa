@extends('layouts.admin')

@section('title', 'Lead Management')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div id="leadsManagement" class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Müşteri Adayları Yönetimi</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Lead'leri görüntüleyin, düzenleyin ve yönetin</p>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-3">
            @if(auth('admin')->user()->can('export_leads'))
            <button onclick="LeadsManager.exportLeads()"
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                Export
            </button>
            @endif
            
            @if(auth('admin')->user()->can('create_leads'))
            <button onclick="LeadsManager.showCreateModal()"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                Yeni Lead Ekle
            </button>
            @endif
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-admin-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-admin-700">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                    <i data-lucide="users" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_leads'] }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Toplam Lead</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-admin-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-admin-700">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 dark:bg-orange-900/20 rounded-lg">
                    <i data-lucide="user-plus" class="w-6 h-6 text-orange-600 dark:text-orange-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['unassigned_leads'] }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Atanmamış</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-admin-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-admin-700">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900/20 rounded-lg">
                    <i data-lucide="calendar" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['new_leads_today'] }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Bugün Eklenen</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-admin-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-admin-700">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 dark:bg-red-900/20 rounded-lg">
                    <i data-lucide="clock" class="w-6 h-6 text-red-600 dark:text-red-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['follow_ups_today'] }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Bugün Takip</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-admin-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-admin-700">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
            <!-- Search -->
            <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Arama</label>
                <input type="text" id="searchInput" onkeyup="LeadsManager.debounceSearch(this.value)"
                       placeholder="İsim, e-posta, telefon..."
                       class="w-full px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
            </div>
            
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Durum</label>
                <select id="statusFilter" onchange="LeadsManager.applyFilters()"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
                    <option value="">Tümü</option>
                    @foreach($leadStatuses as $status)
                        <option value="{{ $status->id }}">{{ $status->display_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Assigned Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Atanan</label>
                <select id="assignedFilter" onchange="LeadsManager.applyFilters()"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
                    <option value="">Tümü</option>
                    <option value="unassigned">Atanmamış</option>
                    @foreach($admins as $admin)
                        <option value="{{ $admin->id }}">{{ $admin->firstName }} {{ $admin->lastName }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Date From -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Başlangıç</label>
                <input type="date" id="dateFromFilter" onchange="LeadsManager.applyFilters()"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
            </div>
            
            <!-- Date To -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bitiş</label>
                <input type="date" id="dateToFilter" onchange="LeadsManager.applyFilters()"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
            </div>
        </div>
        
        <!-- Clear Filters -->
        <div class="mt-4 flex justify-end">
            <button onclick="LeadsManager.clearFilters()"
                    class="inline-flex items-center px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                <i data-lucide="x-circle" class="w-4 h-4 mr-2"></i>
                Filtreleri Temizle
            </button>
        </div>
    </div>

    <!-- Leads Table -->
    <div class="bg-white dark:bg-admin-800 rounded-xl shadow-sm border border-gray-200 dark:border-admin-700 overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Lead Listesi
                    <span id="totalRecords" class="text-sm text-gray-500 dark:text-gray-400 ml-2"></span>
                </h3>
            </div>
                
                <!-- Bulk Actions -->
                <div id="bulkActions" class="flex items-center space-x-2" style="display: none;">
                    <span id="selectedCount" class="text-sm text-gray-600 dark:text-gray-400"></span>
                    
                    @if(auth('admin')->user()->can('edit_leads'))
                    <select id="bulkAssignTo" onchange="LeadsManager.bulkAssign()"
                            class="px-3 py-1 text-sm border border-gray-300 dark:border-admin-600 rounded focus:ring-2 focus:ring-blue-500 dark:bg-admin-700 dark:text-white">
                        <option value="">Toplu Atama</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}">{{ $admin->firstName }} {{ $admin->lastName }}</option>
                        @endforeach
                    </select>
                    @endif
                    
                    <button onclick="LeadsManager.clearSelection()"
                            class="px-3 py-1 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        Seçimi Temizle
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Loading State -->
        <div id="loadingIndicator" class="flex items-center justify-center py-12" style="display: none;">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <span class="ml-3 text-gray-600 dark:text-gray-400">Yükleniyor...</span>
        </div>
        
        <!-- Table -->
        <div id="leadsTable" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-admin-700">
                <thead class="bg-gray-50 dark:bg-admin-900">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="selectAll" onchange="LeadsManager.toggleAll(this.checked)"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer" onclick="LeadsManager.sort('name')">
                            <div class="flex items-center space-x-1">
                                <span>İsim</span>
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">İletişim</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer" onclick="LeadsManager.sort('lead_status')">
                            <div class="flex items-center space-x-1">
                                <span>Durum</span>
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Atanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer" onclick="LeadsManager.sort('created_at')">
                            <div class="flex items-center space-x-1">
                                <span>Tarih</span>
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody id="leadsTableBody" class="bg-white dark:bg-admin-800 divide-y divide-gray-200 dark:divide-admin-700">
                    @foreach($leads as $lead)
                        <tr class="hover:bg-gray-50 dark:hover:bg-admin-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" value="{{ $lead->id }}" class="lead-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" onchange="LeadsManager.updateSelection()">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $lead->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $lead->country ?: 'Belirtilmemiş' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $lead->email }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $lead->phone }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="inline-dropdown">
                                    <div class="dropdown-display cursor-pointer hover:bg-gray-50 dark:hover:bg-admin-700 -mx-2 -my-1 px-2 py-1 rounded transition-colors" onclick="LeadsManager.toggleStatusDropdown(this, {{ $lead->id }})">
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full {{ $lead->leadStatus ? 'text-white' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300' }}"
                                              @if($lead->leadStatus) style="background-color: {{ $lead->leadStatus->color }};" @endif>
                                            <span>{{ $lead->leadStatus ? $lead->leadStatus->display_name : 'Belirlenmemiş' }}</span>
                                            <i data-lucide="chevron-down" class="w-3 h-3 ml-1 opacity-50"></i>
                                        </span>
                                    </div>
                                    <select class="dropdown-select hidden text-xs font-semibold rounded px-2 py-1 border border-gray-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 min-w-[100px] md:min-w-[120px]"
                                            onchange="LeadsManager.updateStatus({{ $lead->id }}, this.value, this)" data-original="{{ $lead->lead_status }}">
                                        <option value="">Seçiniz</option>
                                        @foreach($leadStatuses as $status)
                                            <option value="{{ $status->name }}" {{ $lead->lead_status == $status->name ? 'selected' : '' }}>{{ $status->display_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="inline-dropdown">
                                    <div class="dropdown-display cursor-pointer hover:bg-gray-50 dark:hover:bg-admin-700 -mx-2 -my-1 px-2 py-1 rounded transition-colors min-w-[120px] md:min-w-[160px]" onclick="LeadsManager.toggleAssignmentDropdown(this, {{ $lead->id }})">
                                        @if($lead->assignedAdmin)
                                        <div class="flex items-center">
                                            <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-medium mr-2">
                                                {{ substr($lead->assignedAdmin->firstName, 0, 1) }}{{ substr($lead->assignedAdmin->lastName, 0, 1) }}
                                            </div>
                                            <div class="flex-1">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $lead->assignedAdmin->firstName }} {{ $lead->assignedAdmin->lastName }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $lead->assignedAdmin->type ?: 'Admin' }}</div>
                                            </div>
                                            <i data-lucide="chevron-down" class="w-3 h-3 ml-1 opacity-50"></i>
                                        </div>
                                        @else
                                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                            <span>Atanmamış</span>
                                            <i data-lucide="chevron-down" class="w-3 h-3 ml-1 opacity-50"></i>
                                        </div>
                                        @endif
                                    </div>
                                    <select class="dropdown-select hidden text-sm rounded px-2 py-1 border border-gray-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 min-w-[120px] md:min-w-[160px]"
                                            onchange="LeadsManager.updateAssignment({{ $lead->id }}, this.value, this)" data-original="{{ $lead->assign_to }}">
                                        <option value="">Atanmamış</option>
                                        @foreach($admins as $admin)
                                            <option value="{{ $admin->id }}" {{ $lead->assign_to == $admin->id ? 'selected' : '' }}>{{ $admin->firstName }} {{ $admin->lastName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($lead->created_at)->format('d.m.Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button onclick="LeadsManager.viewLead({{ $lead->id }})" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </button>
                                    @if(auth('admin')->user()->can('edit_leads'))
                                    <button onclick="LeadsManager.editLead({{ $lead->id }})" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    @endif
                                    @if(auth('admin')->user()->can('call_leads'))
                                    <button onclick="LeadsManager.callLead('{{ $lead->phone }}')" class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300">
                                        <i data-lucide="phone" class="w-4 h-4"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Empty State -->
        <div id="emptyState" class="text-center py-12" style="display: {{ $leads->count() == 0 ? 'block' : 'none' }};">
            <i data-lucide="users" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Lead bulunamadı</h3>
            <p class="text-gray-500 dark:text-gray-400">Filtreleri değiştirmeyi deneyin veya yeni bir lead ekleyin.</p>
        </div>
    </div>

    <!-- Pagination -->
    @if($leads->total() > 0)
    <div class="bg-white dark:bg-admin-800 px-6 py-4 rounded-xl shadow-sm border border-gray-200 dark:border-admin-700">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700 dark:text-gray-300">
                {{ $leads->firstItem() ?: 0 }} - {{ $leads->lastItem() ?: 0 }} / {{ $leads->total() }} kayıt gösteriliyor
            </div>
            
            <div class="flex items-center space-x-2">
                <button onclick="LeadsManager.goToPage({{ $leads->currentPage() - 1 }})" {{ $leads->currentPage() <= 1 ? 'disabled' : '' }}
                        class="px-3 py-2 text-sm border border-gray-300 dark:border-admin-600 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-admin-700 dark:text-white">
                    Önceki
                </button>
                
                @foreach(range(max(1, $leads->currentPage() - 2), min($leads->lastPage(), $leads->currentPage() + 2)) as $page)
                    <button onclick="LeadsManager.goToPage({{ $page }})"
                            class="px-3 py-2 text-sm border border-gray-300 dark:border-admin-600 rounded-lg {{ $page == $leads->currentPage() ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-admin-700' }}">
                        {{ $page }}
                    </button>
                @endforeach
                
                <button onclick="LeadsManager.goToPage({{ $leads->currentPage() + 1 }})" {{ $leads->currentPage() >= $leads->lastPage() ? 'disabled' : '' }}
                        class="px-3 py-2 text-sm border border-gray-300 dark:border-admin-600 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-admin-700 dark:text-white">
                    Sonraki
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- View Modal -->
    <div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
        <div class="bg-white dark:bg-admin-800 rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto m-4">
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-admin-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Lead Detayları</h3>
                <button onclick="LeadsManager.closeViewModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <div id="viewModalContent" class="p-6 space-y-6">
                <!-- Content will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
        <div class="bg-white dark:bg-admin-800 rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto m-4">
            <form id="editForm" onsubmit="LeadsManager.updateLead(event)">
                <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-admin-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Lead Düzenle</h3>
                    <button type="button" onclick="LeadsManager.closeEditModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Durum</label>
                            <select id="editLeadStatus" name="lead_status" class="w-full px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-admin-700 dark:text-white">
                                <option value="">Seçiniz</option>
                                @foreach($leadStatuses as $status)
                                    <option value="{{ $status->name }}">{{ $status->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Atama</label>
                            <select id="editAssignTo" name="assign_to" class="w-full px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-admin-700 dark:text-white">
                                <option value="">Atanmamış</option>
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->firstName }} {{ $admin->lastName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notlar</label>
                        <textarea id="editLeadNotes" name="lead_notes" rows="4" class="w-full px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-admin-700 dark:text-white" placeholder="Lead hakkında notlarınız..."></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sonraki Takip Tarihi</label>
                        <input type="date" id="editNextFollowUp" name="next_follow_up_date" class="w-full px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-admin-700 dark:text-white">
                    </div>
                </div>
                
                <div class="flex items-center justify-end space-x-3 p-6 border-t border-gray-200 dark:border-admin-700">
                    <button type="button" onclick="LeadsManager.closeEditModal()" class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        İptal
                    </button>
                    <button type="submit" id="editSubmitBtn" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <span id="editSubmitText">Güncelle</span>
                        <span id="editSubmitLoading" class="flex items-center" style="display: none;">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Güncelleniyor...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
// Leads Management Vanilla JavaScript
const LeadsManager = {
    data: {
        leads: @json($leads->items() ?? []),
        pagination: {
            total: {{ $leads->total() ?? 0 }},
            from: {{ $leads->firstItem() ?? 0 }},
            to: {{ $leads->lastItem() ?? 0 }},
            current_page: {{ $leads->currentPage() ?? 1 }},
            last_page: {{ $leads->lastPage() ?? 1 }}
        },
        filters: {
            search: '{{ request("search", "") }}',
            status: '{{ request("status", "") }}',
            assigned: '{{ request("assigned", "") }}',
            date_from: '{{ request("date_from", "") }}',
            date_to: '{{ request("date_to", "") }}'
        },
        sortBy: '{{ request("sort", "created_at") }}',
        sortDirection: '{{ request("direction", "desc") }}',
        selectedLeads: [],
        selectedLead: null,
        searchTimeout: null,
        availableStatuses: @json($leadStatuses ?? []),
        availableAdmins: @json($admins ?? [])
    },

    init() {
        this.updateUI();
        this.initializeFilters();
        lucide.createIcons();
    },

    updateUI() {
        // Update total records
        const totalEl = document.getElementById('totalRecords');
        if (totalEl) {
            totalEl.textContent = `(${this.data.pagination.total} kayıt)`;
        }
        
        this.updateSelection();
    },

    initializeFilters() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const assignedFilter = document.getElementById('assignedFilter');
        const dateFromFilter = document.getElementById('dateFromFilter');
        const dateToFilter = document.getElementById('dateToFilter');
        
        if (searchInput) searchInput.value = this.data.filters.search;
        if (statusFilter) statusFilter.value = this.data.filters.status;
        if (assignedFilter) assignedFilter.value = this.data.filters.assigned;
        if (dateFromFilter) dateFromFilter.value = this.data.filters.date_from;
        if (dateToFilter) dateToFilter.value = this.data.filters.date_to;
    },

    debounceSearch(value) {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            this.data.filters.search = value;
            this.applyFilters();
        }, 300);
    },

    applyFilters() {
        const params = new URLSearchParams();
        
        Object.keys(this.data.filters).forEach(key => {
            const value = key === 'search' ?
                document.getElementById('searchInput')?.value || '' :
                document.getElementById(key + 'Filter')?.value || this.data.filters[key];
            
            if (value) {
                params.append(key, value);
            }
        });
        
        if (this.data.sortBy) params.append('sort', this.data.sortBy);
        if (this.data.sortDirection) params.append('direction', this.data.sortDirection);
        
        window.location.href = `{{ route('admin.leads.index') }}?${params.toString()}`;
    },

    clearFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('assignedFilter').value = '';
        document.getElementById('dateFromFilter').value = '';
        document.getElementById('dateToFilter').value = '';
        
        this.data.filters = {
            search: '', status: '', assigned: '', date_from: '', date_to: ''
        };
        this.applyFilters();
    },

    sort(column) {
        if (this.data.sortBy === column) {
            this.data.sortDirection = this.data.sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            this.data.sortBy = column;
            this.data.sortDirection = 'asc';
        }
        this.applyFilters();
    },

    goToPage(page) {
        if (page < 1 || page > this.data.pagination.last_page) return;
        
        const params = new URLSearchParams(window.location.search);
        params.set('page', page);
        window.location.href = `{{ route('admin.leads.index') }}?${params.toString()}`;
    },

    toggleAll(checked) {
        const checkboxes = document.querySelectorAll('.lead-checkbox');
        this.data.selectedLeads = [];
        
        checkboxes.forEach(cb => {
            cb.checked = checked;
            if (checked) {
                this.data.selectedLeads.push(parseInt(cb.value));
            }
        });
        
        this.updateSelection();
    },

    updateSelection() {
        const checkboxes = document.querySelectorAll('.lead-checkbox');
        this.data.selectedLeads = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => parseInt(cb.value));
            
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');
        const selectAll = document.getElementById('selectAll');
        
        if (this.data.selectedLeads.length > 0) {
            bulkActions.style.display = 'flex';
            selectedCount.textContent = `${this.data.selectedLeads.length} seçili`;
        } else {
            bulkActions.style.display = 'none';
        }
        
        selectAll.checked = this.data.selectedLeads.length === checkboxes.length && checkboxes.length > 0;
        selectAll.indeterminate = this.data.selectedLeads.length > 0 && this.data.selectedLeads.length < checkboxes.length;
    },

    clearSelection() {
        this.data.selectedLeads = [];
        document.querySelectorAll('.lead-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('selectAll').checked = false;
        document.getElementById('bulkAssignTo').value = '';
        this.updateSelection();
    },

    async bulkAssign() {
        const bulkAssignTo = document.getElementById('bulkAssignTo').value;
        if (!bulkAssignTo || this.data.selectedLeads.length === 0) return;

        try {
            const response = await fetch('{{ route('admin.leads.bulk-assign') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    lead_ids: this.data.selectedLeads,
                    admin_id: bulkAssignTo
                })
            });

            if (response.ok) {
                window.location.reload();
            }
        } catch (error) {
            console.error('Bulk assign error:', error);
        }
    },

    toggleStatusDropdown(element, leadId) {
        // Close all other dropdowns
        document.querySelectorAll('.dropdown-select').forEach(select => {
            if (!select.closest('td').contains(element)) {
                select.classList.add('hidden');
                select.parentElement.querySelector('.dropdown-display').style.display = 'block';
            }
        });
        
        const dropdown = element.parentElement;
        const display = dropdown.querySelector('.dropdown-display');
        const select = dropdown.querySelector('.dropdown-select');
        
        display.style.display = display.style.display === 'none' ? 'block' : 'none';
        select.classList.toggle('hidden');
        
        if (!select.classList.contains('hidden')) {
            select.focus();
        }
    },

    toggleAssignmentDropdown(element, leadId) {
        // Close all other dropdowns
        document.querySelectorAll('.dropdown-select').forEach(select => {
            if (!select.closest('td').contains(element)) {
                select.classList.add('hidden');
                select.parentElement.querySelector('.dropdown-display').style.display = 'block';
            }
        });
        
        const dropdown = element.parentElement;
        const display = dropdown.querySelector('.dropdown-display');
        const select = dropdown.querySelector('.dropdown-select');
        
        display.style.display = display.style.display === 'none' ? 'block' : 'none';
        select.classList.toggle('hidden');
        
        if (!select.classList.contains('hidden')) {
            select.focus();
        }
    },

    async updateStatus(leadId, newStatusId, selectElement) {
        if (!leadId || !newStatusId) {
            this.showNotification('error', 'Geçerli bir status seçiniz');
            return;
        }
        
        try {
            const response = await fetch(`/admin/dashboard/leads/${leadId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    lead_status: newStatusId
                })
            });

            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(errorData.message || `HTTP ${response.status}: Status güncellenemedi`);
            }

            const result = await response.json();
            this.showNotification('success', result.message || 'Status başarıyla güncellendi');
            
            // Hide dropdown
            selectElement.classList.add('hidden');
            const displayElement = selectElement.parentElement.querySelector('.dropdown-display');
            displayElement.style.display = 'block';

            // Update display with new status (anlık güncelleme)
            if (result.data && result.data.new_status) {
                const statusSpan = displayElement.querySelector('span');
                statusSpan.textContent = result.data.new_status.display_name;
                statusSpan.style.backgroundColor = result.data.new_status.color;
                statusSpan.className = 'inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full text-white';
                
                // Update data attribute for future reference
                selectElement.dataset.original = result.data.new_status.id;
            }

        } catch (error) {
            console.error('Status update error:', error);
            this.showNotification('error', error.message || 'Status güncellenirken hata oluştu');
            
            // Revert to original value
            selectElement.value = selectElement.dataset.original || '';
            selectElement.classList.add('hidden');
            selectElement.parentElement.querySelector('.dropdown-display').style.display = 'block';
        }
    },

    async updateAssignment(leadId, newAdminId, selectElement) {
        if (!leadId) return;
        
        try {
            const adminId = newAdminId && newAdminId !== '' ? parseInt(newAdminId) : null;
            
            const response = await fetch(`/admin/dashboard/leads/assignment/${leadId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    assigned_to_admin_id: adminId
                })
            });

            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(errorData.message || `HTTP ${response.status}: Atama güncellenemedi`);
            }

            const result = await response.json();
            this.showNotification('success', result.message || 'Atama başarıyla güncellendi');
            
            // Hide dropdown
            selectElement.classList.add('hidden');
            const displayElement = selectElement.parentElement.querySelector('.dropdown-display');
            displayElement.style.display = 'block';

            // Update display with new assignment (anlık güncelleme)
            if (result.data && result.data.new_admin) {
                const admin = result.data.new_admin;
                const initials = admin.name.split(' ').map(n => n[0]).join('');
                
                displayElement.innerHTML = `
                    <div class="flex items-center">
                        <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-medium mr-2">
                            ${initials}
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">${admin.name}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Admin</div>
                        </div>
                        <i data-lucide="chevron-down" class="w-3 h-3 ml-1 opacity-50"></i>
                    </div>
                `;
                
                // Update data attribute for future reference
                selectElement.dataset.original = result.data.new_admin.id;
            } else {
                // If unassigned
                displayElement.innerHTML = `
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <span>Atanmamış</span>
                        <i data-lucide="chevron-down" class="w-3 h-3 ml-1 opacity-50"></i>
                    </div>
                `;
                selectElement.dataset.original = '';
            }
            
            // Recreate icons for the updated elements
            lucide.createIcons();

        } catch (error) {
            console.error('Assignment update error:', error);
            this.showNotification('error', error.message || 'Atama güncellenirken hata oluştu');
            
            // Revert to original value
            selectElement.value = selectElement.dataset.original || '';
            selectElement.classList.add('hidden');
            selectElement.parentElement.querySelector('.dropdown-display').style.display = 'block';
        }
    },

    viewLead(leadId) {
        const lead = this.data.leads.find(l => l.id === leadId);
        if (!lead) return;
        
        this.data.selectedLead = lead;
        
        // Update modal content
        const content = document.getElementById('viewModalContent');
        content.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-3">Kişisel Bilgiler</h4>
                    <div class="space-y-2 text-sm">
                        <div><span class="text-gray-600 dark:text-gray-400">İsim:</span> <span>${lead.name || ''}</span></div>
                        <div><span class="text-gray-600 dark:text-gray-400">E-posta:</span> <span>${lead.email || ''}</span></div>
                        <div><span class="text-gray-600 dark:text-gray-400">Telefon:</span> <span>${lead.phone || ''}</span></div>
                        <div><span class="text-gray-600 dark:text-gray-400">Ülke:</span> <span>${lead.country || 'Belirtilmemiş'}</span></div>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white mb-3">Lead Bilgileri</h4>
                    <div class="space-y-2 text-sm">
                        <div><span class="text-gray-600 dark:text-gray-400">Durum:</span> <span>${lead.lead_status?.display_name || 'Belirlenmemiş'}</span></div>
                        <div><span class="text-gray-600 dark:text-gray-400">Atanan:</span> <span>${lead.assigned_admin ? lead.assigned_admin.firstName + ' ' + lead.assigned_admin.lastName : 'Atanmamış'}</span></div>
                        <div><span class="text-gray-600 dark:text-gray-400">Kayıt Tarihi:</span> <span>${this.formatDate(lead.created_at)}</span></div>
                    </div>
                </div>
            </div>
            
            ${lead.lead_notes ? `
            <div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-3">Notlar</h4>
                <p class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-admin-900 p-4 rounded-lg">${lead.lead_notes}</p>
            </div>
            ` : ''}
        `;
        
        document.getElementById('viewModal').style.display = 'flex';
        lucide.createIcons();
    },

    editLead(leadId) {
        const lead = this.data.leads.find(l => l.id === leadId);
        if (!lead) return;
        
        this.data.selectedLead = lead;
        
        // Populate form
        document.getElementById('editLeadStatus').value = lead.lead_status || '';
        document.getElementById('editAssignTo').value = lead.assign_to || '';
        document.getElementById('editLeadNotes').value = lead.lead_notes || '';
        document.getElementById('editNextFollowUp').value = lead.next_follow_up_date || '';
        
        document.getElementById('editModal').style.display = 'flex';
        lucide.createIcons();
    },

    async updateLead(event) {
        event.preventDefault();
        if (!this.data.selectedLead) return;
        
        const submitBtn = document.getElementById('editSubmitBtn');
        const submitText = document.getElementById('editSubmitText');
        const submitLoading = document.getElementById('editSubmitLoading');
        
        submitBtn.disabled = true;
        submitText.style.display = 'none';
        submitLoading.style.display = 'flex';
        
        try {
            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('lead_status', document.getElementById('editLeadStatus').value);
            formData.append('assign_to', document.getElementById('editAssignTo').value);
            formData.append('lead_notes', document.getElementById('editLeadNotes').value);
            formData.append('next_follow_up_date', document.getElementById('editNextFollowUp').value);

            const response = await fetch(`/admin/dashboard/leads/${this.data.selectedLead.id}`, {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                window.location.reload();
            } else {
                throw new Error('Güncelleme başarısız');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('error', 'Lead güncellenirken hata oluştu');
        } finally {
            submitBtn.disabled = false;
            submitText.style.display = 'inline';
            submitLoading.style.display = 'none';
        }
    },

    closeViewModal() {
        document.getElementById('viewModal').style.display = 'none';
        this.data.selectedLead = null;
    },

    closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
        this.data.selectedLead = null;
    },

    showCreateModal() {
        // Implement create modal functionality
        console.log('Show create modal');
    },

    callLead(phone) {
        if (phone) {
            window.open(`tel:${phone}`);
        }
    },

    exportLeads() {
        const params = new URLSearchParams();
        Object.keys(this.data.filters).forEach(key => {
            if (this.data.filters[key]) {
                params.append(key, this.data.filters[key]);
            }
        });
        
        window.open(`{{ route('admin.leads.export') }}?${params.toString()}`);
    },

    showNotification(type, message) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 translate-x-full ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        
        notification.innerHTML = `
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    ${type === 'success'
                        ? '<i data-lucide="check-circle" class="w-5 h-5"></i>'
                        : '<i data-lucide="alert-circle" class="w-5 h-5"></i>'
                    }
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">${message}</p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()"
                            class="inline-flex text-white hover:text-gray-200 focus:outline-none">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(notification);
        lucide.createIcons();

        setTimeout(() => notification.classList.remove('translate-x-full'), 100);
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    },

    formatDate(dateString) {
        if (!dateString) return '';
        try {
            const date = new Date(dateString);
            return date.toLocaleDateString('tr-TR', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
        } catch (error) {
            return dateString;
        }
    }
};

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    LeadsManager.init();
});

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.inline-dropdown')) {
        document.querySelectorAll('.dropdown-select').forEach(select => {
            select.classList.add('hidden');
            select.parentElement.querySelector('.dropdown-display').style.display = 'block';
        });
    }
});
</script>
@endsection