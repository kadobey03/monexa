@extends('layouts.admin')

@section('title', 'Lead Management')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div x-data="leadsManagement()" x-init="init()" class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Müşteri Adayları Yönetimi</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Lead'leri görüntüleyin, düzenleyin ve yönetin</p>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-3">
            @if(auth('admin')->user()->can('export_leads'))
            <button @click="exportLeads()" 
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                Export
            </button>
            @endif
            
            @if(auth('admin')->user()->can('create_leads'))
            <button @click="showCreateModal = true" 
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
                <input type="text" x-model="filters.search" @input.debounce.300ms="applyFilters()" 
                       placeholder="İsim, e-posta, telefon..." 
                       class="w-full px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
            </div>
            
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Durum</label>
                <select x-model="filters.status" @change="applyFilters()" 
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
                <select x-model="filters.assigned" @change="applyFilters()" 
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
                <input type="date" x-model="filters.date_from" @change="applyFilters()" 
                       class="w-full px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
            </div>
            
            <!-- Date To -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bitiş</label>
                <input type="date" x-model="filters.date_to" @change="applyFilters()" 
                       class="w-full px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-admin-700 dark:text-white">
            </div>
        </div>
        
        <!-- Clear Filters -->
        <div class="mt-4 flex justify-end">
            <button @click="clearFilters()" 
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
                    <span class="text-sm text-gray-500 dark:text-gray-400 ml-2" x-text="'(' + pagination.total + ' kayıt)'"></span>
                </h3>
            </div>
                
                <!-- Bulk Actions -->
                <div x-show="selectedLeads.length > 0" class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400" x-text="selectedLeads.length + ' seçili'"></span>
                    
                    @if(auth('admin')->user()->can('edit_leads'))
                    <select x-model="bulkAssignTo" @change="if(bulkAssignTo) bulkAssign()" 
                            class="px-3 py-1 text-sm border border-gray-300 dark:border-admin-600 rounded focus:ring-2 focus:ring-blue-500 dark:bg-admin-700 dark:text-white">
                        <option value="">Toplu Atama</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}">{{ $admin->firstName }} {{ $admin->lastName }}</option>
                        @endforeach
                    </select>
                    @endif
                    
                    <button @click="clearSelection()" 
                            class="px-3 py-1 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        Seçimi Temizle
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Loading State -->
        <div x-show="loading" class="flex items-center justify-center py-12">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <span class="ml-3 text-gray-600 dark:text-gray-400">Yükleniyor...</span>
        </div>
        
        <!-- Table -->
        <div x-show="!loading" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-admin-700">
                <thead class="bg-gray-50 dark:bg-admin-900">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" @change="toggleAll($event.target.checked)" 
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer" @click="sort('name')">
                            <div class="flex items-center space-x-1">
                                <span>İsim</span>
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">İletişim</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer" @click="sort('lead_status_id')">
                            <div class="flex items-center space-x-1">
                                <span>Durum</span>
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Atanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer" @click="sort('created_at')">
                            <div class="flex items-center space-x-1">
                                <span>Tarih</span>
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-admin-800 divide-y divide-gray-200 dark:divide-admin-700">
                    <template x-for="lead in leads" :key="lead.id">
                        <tr class="hover:bg-gray-50 dark:hover:bg-admin-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" :value="lead.id" x-model="selectedLeads" 
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white" x-text="lead.name"></div>
                                <div class="text-sm text-gray-500 dark:text-gray-400" x-text="lead.country || 'Belirtilmemiş'"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white" x-text="lead.email"></div>
                                <div class="text-sm text-gray-500 dark:text-gray-400" x-text="lead.phone"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap"
                                x-data="{
                                    editing: false,
                                    loading: false,
                                    originalStatus: lead.lead_status_id || '',
                                    selectedStatus: lead.lead_status_id || ''
                                }"
                                @click.away="if (editing && !loading) { selectedStatus = originalStatus; editing = false; }"
                                @keyup.escape="if (editing && !loading) { selectedStatus = originalStatus; editing = false; }">
                                
                                <!-- Display Mode -->
                                <div x-show="!editing"
                                     @click="if (!loading) { editing = true; $nextTick(() => $refs.statusSelect?.focus()); }"
                                     class="cursor-pointer hover:bg-gray-50 dark:hover:bg-admin-700 -mx-2 -my-1 px-2 py-1 rounded transition-colors">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full"
                                          :class="getStatusClass(lead.lead_status)"
                                          :style="lead.lead_status?.color ? `background-color: ${lead.lead_status.color}20; color: ${lead.lead_status.color};` : ''">
                                        <span x-text="lead.lead_status?.display_name || 'Belirlenmemiş'"></span>
                                        <i data-lucide="chevron-down" class="w-3 h-3 ml-1 opacity-50"></i>
                                    </span>
                                </div>

                                <!-- Edit Mode -->
                                <div x-show="editing" class="relative">
                                    <select x-ref="statusSelect"
                                            x-model="selectedStatus"
                                            @change="updateStatus(lead.id, selectedStatus, $el)"
                                            :disabled="loading"
                                            class="text-xs font-semibold rounded px-2 py-1 border border-gray-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:opacity-50 disabled:cursor-not-allowed min-w-[100px] md:min-w-[120px]">
                                        <option value="">Seçiniz</option>
                                        @foreach($leadStatuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->display_name }}</option>
                                        @endforeach
                                    </select>
                                    
                                    <!-- Loading spinner -->
                                    <div x-show="loading" class="absolute right-2 top-1/2 transform -translate-y-1/2">
                                        <svg class="animate-spin h-3 w-3 text-blue-600" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap"
                                x-data="{
                                    editing: false,
                                    loading: false,
                                    originalAssignment: lead.assign_to || '',
                                    selectedAssignment: lead.assign_to || ''
                                }"
                                @click.away="if (editing && !loading) { selectedAssignment = originalAssignment; editing = false; }"
                                @keyup.escape="if (editing && !loading) { selectedAssignment = originalAssignment; editing = false; }">
                                
                                <!-- Display Mode -->
                                <div x-show="!editing"
                                     @click="if (!loading) { editing = true; $nextTick(() => $refs.assignmentSelect?.focus()); }"
                                     class="cursor-pointer hover:bg-gray-50 dark:hover:bg-admin-700 -mx-2 -my-1 px-2 py-1 rounded transition-colors min-w-[120px] md:min-w-[160px]">
                                    
                                    <div x-show="lead.assigned_admin" class="flex items-center">
                                        <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-medium mr-2" x-text="getInitials(lead.assigned_admin?.firstName, lead.assigned_admin?.lastName)"></div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white" x-text="lead.assigned_admin?.firstName + ' ' + lead.assigned_admin?.lastName"></div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400" x-text="lead.assigned_admin?.type || 'Admin'"></div>
                                        </div>
                                        <i data-lucide="chevron-down" class="w-3 h-3 ml-1 opacity-50"></i>
                                    </div>
                                    
                                    <div x-show="!lead.assigned_admin" class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <span>Atanmamış</span>
                                        <i data-lucide="chevron-down" class="w-3 h-3 ml-1 opacity-50"></i>
                                    </div>
                                </div>

                                <!-- Edit Mode -->
                                <div x-show="editing" class="relative">
                                    <select x-ref="assignmentSelect"
                                            x-model="selectedAssignment"
                                            @change="updateAssignment(lead.id, selectedAssignment, $el)"
                                            :disabled="loading"
                                            class="text-sm rounded px-2 py-1 border border-gray-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:opacity-50 disabled:cursor-not-allowed min-w-[120px] md:min-w-[160px]">
                                        <option value="">Atanmamış</option>
                                        @foreach($admins as $admin)
                                            <option value="{{ $admin->id }}">{{ $admin->firstName }} {{ $admin->lastName }}</option>
                                        @endforeach
                                    </select>
                                    
                                    <!-- Loading spinner -->
                                    <div x-show="loading" class="absolute right-2 top-1/2 transform -translate-y-1/2">
                                        <svg class="animate-spin h-3 w-3 text-blue-600" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" x-text="formatDate(lead.created_at)"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <button @click="viewLead(lead)" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </button>
                                    @if(auth('admin')->user()->can('edit_leads'))
                                    <button @click="editLead(lead)" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    @endif
                                    @if(auth('admin')->user()->can('call_leads'))
                                    <button @click="callLead(lead)" class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300">
                                        <i data-lucide="phone" class="w-4 h-4"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        
        <!-- Empty State -->
        <div x-show="!loading && leads.length === 0" class="text-center py-12">
            <i data-lucide="users" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Lead bulunamadı</h3>
            <p class="text-gray-500 dark:text-gray-400">Filtreleri değiştirmeyi deneyin veya yeni bir lead ekleyin.</p>
        </div>
    </div>

    <!-- Pagination -->
    <div x-show="pagination.total > 0" class="bg-white dark:bg-admin-800 px-6 py-4 rounded-xl shadow-sm border border-gray-200 dark:border-admin-700">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700 dark:text-gray-300">
                <span x-text="pagination.from"></span> - <span x-text="pagination.to"></span> / <span x-text="pagination.total"></span> kayıt gösteriliyor
            </div>
            
            <div class="flex items-center space-x-2">
                <button @click="goToPage(pagination.current_page - 1)" :disabled="pagination.current_page <= 1"
                        class="px-3 py-2 text-sm border border-gray-300 dark:border-admin-600 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-admin-700 dark:text-white">
                    Önceki
                </button>
                
                <template x-for="page in getPageNumbers()" :key="page">
                    <button @click="goToPage(page)" 
                            :class="page === pagination.current_page ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-admin-700'"
                            class="px-3 py-2 text-sm border border-gray-300 dark:border-admin-600 rounded-lg"
                            x-text="page"></button>
                </template>
                
                <button @click="goToPage(pagination.current_page + 1)" :disabled="pagination.current_page >= pagination.last_page"
                        class="px-3 py-2 text-sm border border-gray-300 dark:border-admin-600 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-admin-700 dark:text-white">
                    Sonraki
                </button>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div x-show="showViewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-cloak>
        <div class="bg-white dark:bg-admin-800 rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto m-4">
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-admin-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Lead Detayları</h3>
                <button @click="showViewModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <div class="p-6 space-y-6" x-show="selectedLead">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white mb-3">Kişisel Bilgiler</h4>
                        <div class="space-y-2 text-sm">
                            <div><span class="text-gray-600 dark:text-gray-400">İsim:</span> <span x-text="selectedLead?.name"></span></div>
                            <div><span class="text-gray-600 dark:text-gray-400">E-posta:</span> <span x-text="selectedLead?.email"></span></div>
                            <div><span class="text-gray-600 dark:text-gray-400">Telefon:</span> <span x-text="selectedLead?.phone"></span></div>
                            <div><span class="text-gray-600 dark:text-gray-400">Ülke:</span> <span x-text="selectedLead?.country || 'Belirtilmemiş'"></span></div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-medium text-gray-900 dark:text-white mb-3">Lead Bilgileri</h4>
                        <div class="space-y-2 text-sm">
                            <div><span class="text-gray-600 dark:text-gray-400">Durum:</span> <span x-text="selectedLead?.lead_status?.display_name || 'Belirlenmemiş'"></span></div>
                            <div><span class="text-gray-600 dark:text-gray-400">Atanan:</span> <span x-text="selectedLead?.assigned_admin ? selectedLead.assigned_admin.firstName + ' ' + selectedLead.assigned_admin.lastName : 'Atanmamış'"></span></div>
                            <div><span class="text-gray-600 dark:text-gray-400">Kayıt Tarihi:</span> <span x-text="formatDate(selectedLead?.created_at)"></span></div>
                        </div>
                    </div>
                </div>
                
                <div x-show="selectedLead?.lead_notes">
                    <h4 class="font-medium text-gray-900 dark:text-white mb-3">Notlar</h4>
                    <p class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-admin-900 p-4 rounded-lg" x-text="selectedLead?.lead_notes"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-cloak>
        <div class="bg-white dark:bg-admin-800 rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto m-4">
            <form @submit.prevent="updateLead()">
                <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-admin-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Lead Düzenle</h3>
                    <button type="button" @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Durum</label>
                            <select x-model="editForm.lead_status_id" class="w-full px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-admin-700 dark:text-white">
                                <option value="">Seçiniz</option>
                                @foreach($leadStatuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->display_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Atama</label>
                            <select x-model="editForm.assign_to" class="w-full px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-admin-700 dark:text-white">
                                <option value="">Atanmamış</option>
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->firstName }} {{ $admin->lastName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notlar</label>
                        <textarea x-model="editForm.lead_notes" rows="4" class="w-full px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-admin-700 dark:text-white" placeholder="Lead hakkında notlarınız..."></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sonraki Takip Tarihi</label>
                        <input type="date" x-model="editForm.next_follow_up_date" class="w-full px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-admin-700 dark:text-white">
                    </div>
                </div>
                
                <div class="flex items-center justify-end space-x-3 p-6 border-t border-gray-200 dark:border-admin-700">
                    <button type="button" @click="showEditModal = false" class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        İptal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <span x-show="!editLoading">Güncelle</span>
                        <span x-show="editLoading" class="flex items-center">
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
function leadsManagement() {
    const data = {
        leads: @json($leads->items() ?: []),
        pagination: {
            total: {{ $leads->total() }},
            from: {{ $leads->firstItem() ?: 0 }},
            to: {{ $leads->lastItem() ?: 0 }},
            current_page: {{ $leads->currentPage() }},
            last_page: {{ $leads->lastPage() }},
            per_page: {{ $leads->perPage() }},
            has_pages: {{ $leads->hasPages() ? 'true' : 'false' }}
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
        
        // State
        loading: false,
        selectedLeads: [],
        bulkAssignTo: '',
        
        // Modals
        showViewModal: false,
        showEditModal: false,
        showCreateModal: false,
        selectedLead: null,
        editForm: {},
        editLoading: false,

        // Inline Editing State
        availableStatuses: @json($leadStatuses),
        availableAdmins: @json($admins),

        // Initialization
        init() {
            // Initialize Lucide icons after Alpine is ready
            this.$nextTick(() => {
                lucide.createIcons();
            });
        },

        // Filtering
        applyFilters() {
            const params = new URLSearchParams();
            
            Object.keys(this.filters).forEach(key => {
                if (this.filters[key]) {
                    params.append(key, this.filters[key]);
                }
            });
            
            if (this.sortBy) params.append('sort', this.sortBy);
            if (this.sortDirection) params.append('direction', this.sortDirection);
            
            window.location.href = `{{ route('admin.leads.index') }}?${params.toString()}`;
        },

        clearFilters() {
            this.filters = {
                search: '',
                status: '',
                assigned: '',
                date_from: '',
                date_to: ''
            };
            this.applyFilters();
        },

        // Sorting
        sort(column) {
            if (this.sortBy === column) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortBy = column;
                this.sortDirection = 'asc';
            }
            this.applyFilters();
        },

        // Pagination
        goToPage(page) {
            if (!this.pagination || page < 1 || page > this.pagination.last_page) return;
            
            const params = new URLSearchParams(window.location.search);
            params.set('page', page);
            window.location.href = `{{ route('admin.leads.index') }}?${params.toString()}`;
        },

        getPageNumbers() {
            if (!this.pagination) return [];
            
            const current = this.pagination.current_page;
            const last = this.pagination.last_page;
            const pages = [];
            
            const start = Math.max(1, current - 2);
            const end = Math.min(last, current + 2);
            
            for (let i = start; i <= end; i++) {
                pages.push(i);
            }
            
            return pages;
        },

        // Selection
        toggleAll(checked) {
            if (checked) {
                this.selectedLeads = this.leads.map(lead => lead.id);
            } else {
                this.selectedLeads = [];
            }
        },

        clearSelection() {
            this.selectedLeads = [];
            this.bulkAssignTo = '';
        },

        // Actions
        viewLead(lead) {
            this.selectedLead = lead;
            this.showViewModal = true;
            this.$nextTick(() => lucide.createIcons());
        },

        editLead(lead) {
            this.selectedLead = lead;
            this.editForm = {
                lead_status_id: lead.lead_status_id || '',
                assign_to: lead.assign_to || '',
                lead_notes: lead.lead_notes || '',
                next_follow_up_date: lead.next_follow_up_date || ''
            };
            this.showEditModal = true;
            this.$nextTick(() => lucide.createIcons());
        },

        async updateLead() {
            if (!this.selectedLead) return;
            
            this.editLoading = true;
            
            try {
                const formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('_token', '{{ csrf_token() }}');
                
                Object.keys(this.editForm).forEach(key => {
                    if (this.editForm[key]) {
                        formData.append(key, this.editForm[key]);
                    }
                });

                const response = await fetch(`/admin/dashboard/leads/${this.selectedLead.id}`, {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    window.location.reload();
                } else {
                    console.error('Update failed');
                }
            } catch (error) {
                console.error('Error:', error);
            } finally {
                this.editLoading = false;
            }
        },

        async bulkAssign() {
            if (!this.bulkAssignTo || this.selectedLeads.length === 0) return;

            try {
                const response = await fetch('{{ route('admin.leads.bulk-assign') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        lead_ids: this.selectedLeads,
                        admin_id: this.bulkAssignTo
                    })
                });

                if (response.ok) {
                    window.location.reload();
                }
            } catch (error) {
                console.error('Bulk assign error:', error);
            }
        },

        callLead(lead) {
            if (lead.phone) {
                window.open(`tel:${lead.phone}`);
            }
        },

        exportLeads() {
            const params = new URLSearchParams();
            Object.keys(this.filters).forEach(key => {
                if (this.filters[key]) {
                    params.append(key, this.filters[key]);
                }
            });
            
            window.open(`{{ route('admin.leads.export') }}?${params.toString()}`);
        },

        // Inline Status Update
        async updateStatus(leadId, newStatusId, selectElement) {
            if (!leadId || newStatusId === '') return;
            
            try {
                const statusEditor = selectElement.closest('td').querySelector('[x-data]').__x?.$data;
                if (!statusEditor) {
                    console.error('Status editor not found');
                    return;
                }
                
                statusEditor.loading = true;
                statusEditor.editing = false;

                // Find the lead and status objects
                const lead = this.leads.find(l => l.id === leadId);
                if (!lead) {
                    throw new Error('Lead bulunamadı');
                }
                
                const newStatus = newStatusId ? this.availableStatuses.find(s => s.id == newStatusId) : null;
                const originalStatus = lead.lead_status;

                // Optimistic update
                if (newStatus) {
                    lead.lead_status = newStatus;
                    lead.lead_status_id = newStatus.id;
                } else {
                    lead.lead_status = null;
                    lead.lead_status_id = null;
                }

                const response = await fetch(`/admin/dashboard/leads/${leadId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        lead_status_id: newStatusId || null
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.message || `HTTP ${response.status}: Status güncellenemedi`);
                }

                const result = await response.json();

                // Update with actual response data if provided
                if (result.lead) {
                    const leadIndex = this.leads.findIndex(l => l.id === leadId);
                    if (leadIndex !== -1) {
                        Object.assign(this.leads[leadIndex], result.lead);
                    }
                }

                // Show success notification
                this.showNotification('success', result.message || 'Lead durumu başarıyla güncellendi');
                statusEditor.originalStatus = lead.lead_status_id;

            } catch (error) {
                console.error('Status update error:', error);
                
                // Revert to original state
                const lead = this.leads.find(l => l.id === leadId);
                const statusEditor = selectElement.closest('td').querySelector('[x-data]').__x?.$data;
                
                if (lead && statusEditor) {
                    const originalStatus = this.availableStatuses.find(s => s.id == statusEditor.originalStatus);
                    lead.lead_status = originalStatus || null;
                    lead.lead_status_id = originalStatus?.id || null;
                    statusEditor.selectedStatus = originalStatus?.id || '';
                }

                // Show error notification
                this.showNotification('error', error.message || 'Status güncellenirken hata oluştu');
            } finally {
                const statusEditor = selectElement.closest('td').querySelector('[x-data]').__x?.$data;
                if (statusEditor) {
                    statusEditor.loading = false;
                }
                this.$nextTick(() => lucide.createIcons());
            }
        },

        // Inline Assignment Update
        async updateAssignment(leadId, newAdminId, selectElement) {
            if (!leadId) return;
            
            try {
                const assignmentEditor = selectElement.closest('td').querySelector('[x-data]').__x?.$data;
                if (!assignmentEditor) {
                    console.error('Assignment editor not found');
                    return;
                }
                
                assignmentEditor.loading = true;
                assignmentEditor.editing = false;

                // Find the lead and admin objects
                const lead = this.leads.find(l => l.id === leadId);
                if (!lead) {
                    throw new Error('Lead bulunamadı');
                }
                
                const newAdmin = newAdminId ? this.availableAdmins.find(a => a.id == newAdminId) : null;
                const originalAdmin = lead.assigned_admin;

                // Optimistic update
                if (newAdmin) {
                    lead.assigned_admin = newAdmin;
                    lead.assign_to = newAdmin.id;
                } else {
                    lead.assigned_admin = null;
                    lead.assign_to = null;
                }

                const response = await fetch(`/admin/dashboard/leads/${leadId}/assignment`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        assigned_to_admin_id: newAdminId || null
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.message || `HTTP ${response.status}: Atama güncellenemedi`);
                }

                const result = await response.json();

                // Update with actual response data if provided
                if (result.lead) {
                    const leadIndex = this.leads.findIndex(l => l.id === leadId);
                    if (leadIndex !== -1) {
                        Object.assign(this.leads[leadIndex], result.lead);
                    }
                }

                // Show success notification
                this.showNotification('success', result.message || 'Lead ataması başarıyla güncellendi');
                assignmentEditor.originalAssignment = lead.assign_to;

            } catch (error) {
                console.error('Assignment update error:', error);
                
                // Revert to original state
                const lead = this.leads.find(l => l.id === leadId);
                const assignmentEditor = selectElement.closest('td').querySelector('[x-data]').__x?.$data;
                
                if (lead && assignmentEditor) {
                    const originalAdmin = this.availableAdmins.find(a => a.id == assignmentEditor.originalAssignment);
                    lead.assigned_admin = originalAdmin || null;
                    lead.assign_to = originalAdmin?.id || null;
                    assignmentEditor.selectedAssignment = originalAdmin?.id || '';
                }

                // Show error notification
                this.showNotification('error', error.message || 'Atama güncellenirken hata oluştu');
            } finally {
                const assignmentEditor = selectElement.closest('td').querySelector('[x-data]').__x?.$data;
                if (assignmentEditor) {
                    assignmentEditor.loading = false;
                }
                this.$nextTick(() => lucide.createIcons());
            }
        },

        // Notification System
        showNotification(type, message) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 translate-x-full ${
                type === 'success'
                    ? 'bg-green-500 text-white'
                    : 'bg-red-500 text-white'
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

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 5000);
        },

        // Utility functions
        getStatusClass(status) {
            if (!status) return 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
            
            const colors = {
                'new': 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-300',
                'contacted': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-300',
                'qualified': 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-300',
                'lost': 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-300'
            };
            
            return colors[status.name] || 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
        },

        getInitials(firstName, lastName) {
            if (!firstName) return 'U';
            const first = firstName.charAt(0).toUpperCase();
            const last = lastName ? lastName.charAt(0).toUpperCase() : '';
            return first + last;
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
    
    return data;
}
</script>
@endsection