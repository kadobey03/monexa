@extends('layouts.admin', ['title' => 'Lead Yönetimi'])

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="mb-4 sm:mb-0">
                        <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                            <i data-lucide="users" class="w-8 h-8 text-blue-600 mr-3"></i>
                            Modern Lead Yönetimi
                        </h1>
                        <p class="text-gray-600 mt-1">Toplam: <span id="total-leads" class="font-semibold text-blue-600">0</span> lead</p>
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" id="refresh-btn">
                            <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i>
                            Yenile
                        </button>
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" id="export-excel-btn">
                            <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                            Excel
                        </button>
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm" id="add-lead-btn">
                            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                            Yeni Lead Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Arama</label>
                        <div class="relative">
                            <input type="text" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400" id="search-input" placeholder="İsim, email, telefon, şirket...">
                            <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Durum</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="status-filter">
                            <option value="">Tüm Durumlar</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kaynak</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="source-filter">
                            <option value="">Tüm Kaynaklar</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Atanan</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="assigned-filter">
                            <option value="">Tümü</option>
                            <option value="unassigned">Atanmamış</option>
                        </select>
                    </div>
                </div>
                <div class="flex space-x-3 mt-4">
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" id="apply-filters">
                        <i data-lucide="filter" class="w-4 h-4 mr-2"></i>
                        Filtrele
                    </button>
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" id="clear-filters">
                        <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                        Temizle
                    </button>
                </div>
            </div>
        </div>

        <!-- Bulk Actions Bar (Hidden by default) -->
        <div id="bulk-actions" class="bg-blue-50 border border-blue-200 rounded-xl shadow-sm mb-6 hidden">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i data-lucide="check-circle" class="w-5 h-5 text-blue-600 mr-2"></i>
                        <span class="text-sm font-medium text-blue-700">
                            <span id="selected-count">0</span> lead seçildi
                        </span>
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded-lg text-sm font-medium hover:bg-blue-200 transition-colors" id="bulk-assign-btn">
                            <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                            Ata
                        </button>
                        <button type="button" class="inline-flex items-center px-3 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-medium hover:bg-green-200 transition-colors" id="bulk-status-btn">
                            <i data-lucide="edit" class="w-4 h-4 mr-2"></i>
                            Durum
                        </button>
                        <button type="button" class="inline-flex items-center px-3 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-medium hover:bg-red-200 transition-colors" id="bulk-delete-btn">
                            <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                            Sil
                        </button>
                        <button type="button" class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors" id="clear-selection-btn">
                            <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                            Temizle
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loading" class="text-center py-12" style="display: none;">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <p class="mt-4 text-gray-600">Lead'ler yükleniyor...</p>
        </div>

        <!-- Modern 9-Column Leads Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <!-- Table Header Component -->
                        @include('components.admin.leads.table.table-header')

                        <!-- Table Body -->
                        <tbody id="leads-table-body" class="bg-white divide-y divide-gray-200">
                            <!-- Data will be loaded here via JavaScript -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Empty State -->
                <div id="empty-state" class="text-center py-16" style="display: none;">
                    <div class="mx-auto h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i data-lucide="users" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Lead bulunamadı</h3>
                    <p class="text-gray-500 mb-6 max-w-md mx-auto">Henüz hiç lead eklenmemiş veya filtrelenmiş sonuç bulunamadı.</p>
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" id="empty-add-lead-btn">
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                        İlk Lead'inizi Ekleyin
                    </button>
                </div>

                <!-- Pagination -->
                <div id="pagination-wrapper" class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-200" style="display: none;">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <button id="prev-btn-mobile" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            <i data-lucide="chevron-left" class="w-4 h-4 mr-2"></i>
                            Önceki
                        </button>
                        <button id="next-btn-mobile" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            Sonraki
                            <i data-lucide="chevron-right" class="w-4 h-4 ml-2"></i>
                        </button>
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                <span id="pagination-info"></span>
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" id="pagination">
                                <!-- Pagination buttons will be generated here -->
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Lead Modal -->
<div id="addLeadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" style="display: none;">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-xl bg-white">
        <div class="mt-3">
            <!-- Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900" id="addLeadModalLabel">Yeni Lead Ekle</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none" id="close-modal">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <!-- Form -->
            <form id="lead-form" class="mt-6">
                <input type="hidden" id="lead-id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="lead-name" class="block text-sm font-medium text-gray-700 mb-2">İsim *</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="lead-name" required>
                    </div>
                    <div>
                        <label for="lead-email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="lead-email" required>
                    </div>
                    <div>
                        <label for="lead-phone" class="block text-sm font-medium text-gray-700 mb-2">Telefon</label>
                        <input type="tel" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="lead-phone">
                    </div>
                    <div>
                        <label for="lead-country" class="block text-sm font-medium text-gray-700 mb-2">Ülke</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="lead-country">
                    </div>
                    <div>
                        <label for="lead-company" class="block text-sm font-medium text-gray-700 mb-2">Şirket</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="lead-company">
                    </div>
                    <div>
                        <label for="lead-organization" class="block text-sm font-medium text-gray-700 mb-2">Varonka</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="lead-organization">
                    </div>
                    <div>
                        <label for="lead-status" class="block text-sm font-medium text-gray-700 mb-2">Durum</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="lead-status">
                            <!-- Options loaded dynamically -->
                        </select>
                    </div>
                    <div>
                        <label for="lead-source" class="block text-sm font-medium text-gray-700 mb-2">Kaynak</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="lead-source">
                            <!-- Options loaded dynamically -->
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label for="lead-assigned" class="block text-sm font-medium text-gray-700 mb-2">Atanan Admin</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="lead-assigned">
                            <option value="">Atanmamış</option>
                            <!-- Options loaded dynamically -->
                        </select>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex items-center justify-end pt-6 border-t border-gray-200 mt-6 space-x-3">
                    <button type="button" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" id="cancel-lead">İptal</button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2" id="save-spinner" style="display: none;"></div>
                        Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('resources/css/admin/leads-table.css') }}">
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Global variables
    let currentPage = 1;
    let totalPages = 1;
    let leadStatuses = [];
    let leadSources = [];
    let adminUsers = [];
    
    // Initialize
    init();
    
    function init() {
        loadInitialData();
        loadLeads();
        bindEvents();
        initializeLucideIcons();
    }
    
    // Initialize Lucide Icons
    function initializeLucideIcons() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }
    
    // Load initial data (statuses, sources, admins)
    function loadInitialData() {
        // Load statuses
        loadStatuses();
        // Load sources
        loadSources();
        // Load assignable admins
        loadAssignableAdmins();
    }
    
    // Load lead statuses
    function loadStatuses() {
        $.ajax({
            url: '/admin/dashboard/lead-statuses/active',
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        })
        .done(function(response) {
            if (Array.isArray(response) && response.length > 0) {
                leadStatuses = response;
                const statusFilter = $('#status-filter');
                const leadStatus = $('#lead-status');
                response.forEach(function(status) {
                    // Validate status object
                    if (status && status.name && (status.display_name || status.name)) {
                        const displayName = status.display_name || status.name;
                        const colorStyle = status.color ? `style="color: ${status.color}; font-weight: 600;"` : '';
                        const option = `<option value="${status.name}" ${colorStyle}>${displayName}</option>`;
                        statusFilter.append(option);
                        leadStatus.append(option);
                    }
                });
            }
        })
        .fail(function(xhr) {
            console.error('Failed to load statuses:', xhr);
        });
    }
    
    // Load lead sources
    function loadSources() {
        $.ajax({
            url: '/api/admin/leads/options?field=lead_source',
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        })
        .done(function(response) {
            if (response.success && response.data) {
                leadSources = response.data;
                const sourceFilter = $('#source-filter');
                const leadSource = $('#lead-source');
                response.data.forEach(function(source) {
                    const option = `<option value="${source.id || source.value}">${source.display_name || source.label || source.name}</option>`;
                    sourceFilter.append(option);
                    leadSource.append(option);
                });
            }
        })
        .fail(function(xhr) {
            console.error('Failed to load sources:', xhr);
        });
    }
    
    // Load assignable admins
    function loadAssignableAdmins() {
        $.ajax({
            url: '/api/admin/leads/options?field=assigned_admin',
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        })
        .done(function(response) {
            if (response.success && response.data) {
                adminUsers = response.data;
                populateAdminSelects();
            }
        })
        .fail(function(xhr) {
            console.error('Failed to load assignable admins:', xhr);
        });
    }
    
    // Load leads data
    function loadLeads(page = 1) {
        $('#loading').show();
        $('#leads-table-body').empty();
        $('#pagination-wrapper').hide();
        $('#empty-state').hide();
        
        const params = {
            page: page,
            per_page: 25,
            search: $('#search-input').val(),
            filters: {
                status: $('#status-filter').val(),
                source: $('#source-filter').val(),
                assigned_to: $('#assigned-filter').val()
            },
            sort_column: 'created_at',
            sort_direction: 'desc'
        };
        
        $.ajax({
            url: '/api/admin/leads',
            method: 'GET',
            data: params,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        })
        .done(function(response) {
            if (response.success) {
                displayLeads(response.data);
                updatePagination(response.pagination);
                updateStatistics(response);
            } else {
                showError('Lead\'ler yüklenirken hata oluştu');
            }
        })
        .fail(function(xhr) {
            console.error('API Error:', xhr);
            showError('Lead\'ler yüklenirken hata oluştu: ' + (xhr.responseJSON?.message || 'Bilinmeyen hata'));
        })
        .always(function() {
            $('#loading').hide();
        });
    }
    
    // Display leads using Laravel Blade components
    function displayLeads(leads) {
        const tbody = $('#leads-table-body');
        tbody.empty();
        
        if (leads.length === 0) {
            $('#empty-state').show();
            return;
        }
        
        // For each lead, we'll need to render the Blade component on the server
        // This is a simplified version - in a real app, you'd use server-side rendering
        leads.forEach(function(lead) {
            const row = createLeadRow(lead);
            tbody.append(row);
        });
        
        // Reinitialize Lucide icons for new content
        initializeLucideIcons();
    }
    
    // Create lead row with proper 10-column structure (with checkbox)
    function createLeadRow(lead) {
        // Get status info with validation - using name field
        const statusObj = (leadStatuses && Array.isArray(leadStatuses)) ?
            leadStatuses.find(s => s && s.name === lead.lead_status) || { name: lead.lead_status || 'new', display_name: 'Bilinmeyen', color: '#6b7280' } :
            { name: lead.lead_status || 'new', display_name: 'Bilinmeyen', color: '#6b7280' };
            
        const sourceObj = (leadSources && Array.isArray(leadSources)) ?
            leadSources.find(s => s && s.id == lead.lead_source_id) || { name: 'Bilinmeyen', display_name: 'Bilinmeyen', color_class: 'gray' } :
            { name: 'Bilinmeyen', display_name: 'Bilinmeyen', color_class: 'gray' };
            
        const assignedObj = (adminUsers && Array.isArray(adminUsers)) ?
            adminUsers.find(a => a && a.id == lead.assign_to) || null : null;
        
        // Avatar initials
        const avatarText = lead.name ? lead.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase() : 'NN';
        const avatarColor = ['bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-pink-500', 'bg-indigo-500'][lead.id % 5];
        
        return `
            <tr class="leads-table-row hover:bg-gray-50 transition-colors duration-200" data-lead-id="${lead.id}">
                <!-- Checkbox Column -->
                <td class="px-6 py-4 w-12">
                    <input
                        type="checkbox"
                        class="lead-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        data-lead-id="${lead.id}"
                    >
                </td>
                
                <!-- ÜLKE Column -->
                <td class="column-ulke px-4 py-3 text-sm">
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <i data-lucide="globe" class="w-3 h-3 mr-1"></i>
                            ${lead.country || 'Belirtilmemiş'}
                        </span>
                    </div>
                </td>

                <!-- AD SOYAD Column -->
                <td class="column-name px-4 py-3">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8">
                            <div class="${avatarColor} rounded-full h-8 w-8 flex items-center justify-center">
                                <span class="text-xs font-medium text-white">${avatarText}</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900">${lead.name || 'İsimsiz'}</div>
                            <div class="text-xs text-gray-500">ID: #${lead.id}</div>
                        </div>
                    </div>
                </td>

                <!-- TELEFON Column -->
                <td class="column-phone px-4 py-3 text-sm text-gray-900">
                    ${lead.phone ? `
                        <div class="flex items-center">
                            <i data-lucide="phone" class="w-4 h-4 text-gray-400 mr-2"></i>
                            <a href="tel:${lead.phone}" class="text-blue-600 hover:text-blue-900 transition-colors">
                                ${lead.phone}
                            </a>
                        </div>
                    ` : `
                        <span class="text-gray-400 italic">Telefon yok</span>
                    `}
                </td>

                <!-- EMAIL Column -->
                <td class="column-email px-4 py-3 text-sm">
                    ${lead.email ? `
                        <div class="flex items-center">
                            <i data-lucide="mail" class="w-4 h-4 text-gray-400 mr-2"></i>
                            <a href="mailto:${lead.email}" class="text-blue-600 hover:text-blue-900 transition-colors truncate max-w-xs">
                                ${lead.email}
                            </a>
                        </div>
                    ` : `
                        <span class="text-gray-400 italic">Email yok</span>
                    `}
                </td>

                <!-- ASSIGNED Column -->
                <td class="column-assigned px-4 py-3">
                    <div class="inline-edit-dropdown" data-field="assigned_to" data-lead-id="${lead.id}">
                        <button class="assigned-display flex items-center px-3 py-2 text-sm rounded-lg border border-gray-200 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 w-full justify-between">
                            <span class="flex items-center">
                                ${assignedObj ? `
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                                            <span class="text-xs font-medium text-blue-600">${assignedObj.name[0]}</span>
                                        </div>
                                        <span class="text-gray-900">${assignedObj.name}</span>
                                    </div>
                                ` : `
                                    <span class="text-gray-500 italic">Atanmamış</span>
                                `}
                            </span>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                        </button>
                        <select class="assigned-select hidden w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Atanmamış</option>
                            ${(adminUsers && Array.isArray(adminUsers)) ? adminUsers.filter(admin => admin && admin.id && admin.name).map(admin => `
                                <option value="${admin.id}" ${admin.id == lead.assigned_to ? 'selected' : ''}>
                                    ${admin.name}
                                </option>
                            `).join('') : ''}
                        </select>
                    </div>
                </td>

                <!-- STATUS Column -->
                <td class="column-status px-4 py-3">
                    <div class="inline-edit-dropdown" data-field="lead_status" data-lead-id="${lead.id}">
                        <button class="status-display flex items-center px-3 py-2 text-sm rounded-lg border border-gray-200 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 w-full justify-between">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" style="background-color: ${statusObj.color || '#6b7280'}20; color: ${statusObj.color || '#6b7280'}; border: 1px solid ${statusObj.color || '#6b7280'}40;">
                                ${statusObj.display_name || statusObj.name || 'Bilinmeyen'}
                            </span>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                        </button>
                        <select class="status-select hidden w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            ${(leadStatuses && Array.isArray(leadStatuses)) ? leadStatuses.filter(status => status && status.name).map(status => `
                                 <option value="${status.name}" ${status.name === lead.lead_status ? 'selected' : ''}>
                                     ${status.display_name || status.name}
                                 </option>
                             `).join('') : ''}
                        </select>
                    </div>
                </td>

                <!-- VARONKA Column -->
                <td class="column-organization px-4 py-3 text-sm text-gray-900">
                    ${lead.organization ? `
                        <div class="flex items-center">
                            <i data-lucide="building" class="w-4 h-4 text-gray-400 mr-2"></i>
                            <span>${lead.organization}</span>
                        </div>
                    ` : `
                        <span class="text-gray-400 italic">Varonka yok</span>
                    `}
                </td>

                <!-- KAYNAK Column -->
                <td class="column-source px-4 py-3">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium source-badge-${sourceObj.color_class || 'gray'}">
                        ${sourceObj.display_name || sourceObj.name || 'Bilinmeyen'}
                    </span>
                </td>

                <!-- ŞİRKET Column -->
                <td class="column-company px-4 py-3 text-sm text-gray-900">
                    ${lead.company_name ? `
                        <div class="flex items-center">
                            <i data-lucide="briefcase" class="w-4 h-4 text-gray-400 mr-2"></i>
                            <span>${lead.company_name}</span>
                        </div>
                    ` : `
                        <span class="text-gray-400 italic">Şirket yok</span>
                    `}
                </td>
            </tr>
        `;
    }
    
    function populateAdminSelects() {
        const assignedFilter = $('#assigned-filter');
        const leadAssigned = $('#lead-assigned');
        
        // Clear existing options except default ones
        assignedFilter.find('option:not([value=""], [value="unassigned"])').remove();
        leadAssigned.find('option:not([value=""])').remove();
        
        // Add admin options with validation
        if (adminUsers && Array.isArray(adminUsers)) {
            adminUsers.forEach(function(admin) {
                if (admin && admin.id && admin.name) {
                    const option = `<option value="${admin.id}">${admin.name}</option>`;
                    assignedFilter.append(option);
                    leadAssigned.append(option);
                }
            });
        }
    }
    
    function bindEvents() {
        // Search with debouncing
        let searchTimeout;
        $('#search-input').on('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentPage = 1;
                loadLeads();
            }, 500);
        });
        
        // Filter buttons
        $('#apply-filters').on('click', function() {
            currentPage = 1;
            loadLeads();
        });
        
        $('#clear-filters').on('click', function() {
            $('#search-input').val('');
            $('#status-filter').val('');
            $('#source-filter').val('');
            $('#assigned-filter').val('');
            currentPage = 1;
            loadLeads();
        });
        
        // Refresh button
        $('#refresh-btn').on('click', function() {
            loadLeads(currentPage);
        });
        
        // Add lead button
        $('#add-lead-btn, #empty-add-lead-btn').on('click', function() {
            openLeadModal();
        });
        
        // Export button
        $('#export-excel-btn').on('click', function() {
            exportToExcel();
        });
        
        // Modal controls
        $('#close-modal, #cancel-lead').on('click', function() {
            closeLeadModal();
        });
        
        // Form submission
        $('#lead-form').on('submit', function(e) {
            e.preventDefault();
            saveLeadData();
        });
    }
    
    // Modal functions
    function openLeadModal(lead = null) {
        $('#addLeadModal').show();
        if (lead) {
            // Edit mode
            $('#addLeadModalLabel').text('Lead Düzenle');
            populateLeadForm(lead);
        } else {
            // Add mode
            $('#addLeadModalLabel').text('Yeni Lead Ekle');
            resetLeadForm();
        }
    }
    
    function closeLeadModal() {
        $('#addLeadModal').hide();
        resetLeadForm();
    }
    
    function resetLeadForm() {
        $('#lead-form')[0].reset();
        $('#lead-id').val('');
    }
    
    function populateLeadForm(lead) {
        $('#lead-id').val(lead.id);
        $('#lead-name').val(lead.name);
        $('#lead-email').val(lead.email);
        $('#lead-phone').val(lead.phone);
        $('#lead-country').val(lead.country);
        $('#lead-company').val(lead.company_name);
        $('#lead-organization').val(lead.organization);
        $('#lead-status').val(lead.lead_status);
        $('#lead-source').val(lead.lead_source_id);
        $('#lead-assigned').val(lead.assigned_to);
    }
    
    // Inline editing functionality
    $(document).on('click', '.assigned-display, .status-display', function() {
        const dropdown = $(this).closest('.inline-edit-dropdown');
        const display = dropdown.find('[class*="-display"]');
        const select = dropdown.find('[class*="-select"]');
        
        display.addClass('hidden');
        select.removeClass('hidden').focus();
    });
    
    $(document).on('blur change', '.assigned-select, .status-select', function() {
        const dropdown = $(this).closest('.inline-edit-dropdown');
        const display = dropdown.find('[class*="-display"]');
        const select = $(this);
        const leadId = dropdown.data('lead-id');
        const field = dropdown.data('field');
        const newValue = select.val();
        
        // Update via API
        updateLeadField(leadId, field, newValue, dropdown);
        
        // Hide select, show display
        select.addClass('hidden');
        display.removeClass('hidden');
    });
    
    // Update lead field via API
    function updateLeadField(leadId, field, value, dropdown) {
        $.ajax({
            url: `/api/admin/leads/${leadId}`,
            method: 'PATCH',
            data: { [field]: value },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        })
        .done(function(response) {
            if (response.success) {
                // Update display text
                updateDisplayText(dropdown, field, value, response.data);
                showSuccess(`${field === 'assigned_to' ? 'Atama' : 'Durum'} güncellendi`);
            } else {
                showError(response.message || 'Güncelleme başarısız oldu');
            }
        })
        .fail(function(xhr) {
            console.error('Update failed:', xhr);
            showError('Güncelleme sırasında hata oluştu');
        });
    }
    
    // Update display text after successful API call
    function updateDisplayText(dropdown, field, value, responseData) {
        const display = dropdown.find('[class*="-display"] span:first');
        
        if (field === 'assigned_to') {
            if (value) {
                const admin = adminUsers.find(a => a.id == value);
                if (admin) {
                    display.html(`
                        <div class="flex items-center">
                            <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                                <span class="text-xs font-medium text-blue-600">${admin.name[0]}</span>
                            </div>
                            <span class="text-gray-900">${admin.name}</span>
                        </div>
                    `);
                }
            } else {
                display.html('<span class="text-gray-500 italic">Atanmamış</span>');
            }
        } else if (field === 'lead_status') {
            const status = leadStatuses.find(s => s && s.name === value);
            if (status) {
                display.html(`
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" style="background-color: ${status.color || '#6b7280'}20; color: ${status.color || '#6b7280'}; border: 1px solid ${status.color || '#6b7280'}40;">
                        ${status.display_name || status.name}
                    </span>
                `);
            } else {
                display.html(`
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" style="background-color: #6b728020; color: #6b7280; border: 1px solid #6b728040;">
                        ${value || 'Bilinmeyen'}
                    </span>
                `);
            }
        }
    }
    
    // Pagination functions
    function updatePagination(pagination) {
        if (!pagination || pagination.total === 0) {
            $('#pagination-wrapper').hide();
            return;
        }
        
        currentPage = pagination.current_page;
        totalPages = pagination.last_page;
        
        // Update pagination info
        const start = ((currentPage - 1) * pagination.per_page) + 1;
        const end = Math.min(currentPage * pagination.per_page, pagination.total);
        $('#pagination-info').text(`${start}-${end} arası gösteriliyor (Toplam: ${pagination.total})`);
        
        // Generate pagination buttons
        generatePaginationButtons(pagination);
        $('#pagination-wrapper').show();
    }
    
    function generatePaginationButtons(pagination) {
        const paginationContainer = $('#pagination');
        paginationContainer.empty();
        
        const currentPage = pagination.current_page;
        const totalPages = pagination.last_page;
        
        // Previous button
        const prevDisabled = currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50';
        paginationContainer.append(`
            <button class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 ${prevDisabled}"
                    data-page="${currentPage - 1}" ${currentPage === 1 ? 'disabled' : ''}>
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </button>
        `);
        
        // Page numbers
        const startPage = Math.max(1, currentPage - 2);
        const endPage = Math.min(totalPages, currentPage + 2);
        
        for (let page = startPage; page <= endPage; page++) {
            const isActive = page === currentPage;
            const activeClass = isActive ? 'bg-blue-50 border-blue-500 text-blue-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50';
            
            paginationContainer.append(`
                <button class="relative inline-flex items-center px-4 py-2 border text-sm font-medium ${activeClass}"
                        data-page="${page}">${page}</button>
            `);
        }
        
        // Next button
        const nextDisabled = currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50';
        paginationContainer.append(`
            <button class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 ${nextDisabled}"
                    data-page="${currentPage + 1}" ${currentPage === totalPages ? 'disabled' : ''}>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </button>
        `);
        
        // Bind pagination clicks
        paginationContainer.find('button[data-page]').on('click', function() {
            if (!$(this).is(':disabled')) {
                loadLeads($(this).data('page'));
            }
        });
        
        // Reinitialize icons
        initializeLucideIcons();
    }
    
    // Update statistics
    function updateStatistics(response) {
        if (response.pagination) {
            $('#total-leads').text(response.pagination.total);
        }
    }
    
    // Save lead data (for modal form)
    function saveLeadData() {
        const leadId = $('#lead-id').val();
        const isEdit = leadId !== '';
        const url = isEdit ? `/api/admin/leads/${leadId}` : '/api/admin/leads';
        const method = isEdit ? 'PATCH' : 'POST';
        
        const formData = {
            name: $('#lead-name').val(),
            email: $('#lead-email').val(),
            phone: $('#lead-phone').val(),
            country: $('#lead-country').val(),
            company_name: $('#lead-company').val(),
            organization: $('#lead-organization').val(),
            lead_status: $('#lead-status').val() || 'new',
            lead_source_id: $('#lead-source').val() || null,
            assigned_to: $('#lead-assigned').val() || null
        };
        
        // Show loading
        $('#save-spinner').show();
        
        $.ajax({
            url: url,
            method: method,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        })
        .done(function(response) {
            if (response.success) {
                closeLeadModal();
                loadLeads(currentPage);
                showSuccess(isEdit ? 'Lead başarıyla güncellendi' : 'Yeni lead başarıyla eklendi');
            } else {
                showError(response.message || 'Kaydetme işlemi başarısız oldu');
            }
        })
        .fail(function(xhr) {
            console.error('Save failed:', xhr);
            showError('Kaydetme sırasında hata oluştu: ' + (xhr.responseJSON?.message || 'Bilinmeyen hata'));
        })
        .always(function() {
            $('#save-spinner').hide();
        });
    }
    
    // Export to Excel
    function exportToExcel() {
        const params = {
            search: $('#search-input').val(),
            filters: {
                status: $('#status-filter').val(),
                source: $('#source-filter').val(),
                assigned_to: $('#assigned-filter').val()
            }
        };
        
        const queryString = $.param(params);
        window.open(`/admin/leads/export?${queryString}`, '_blank');
    }
    
    // Utility functions
    function showSuccess(message) {
        // You can integrate with your notification system here
        console.log('Success:', message);
        alert(message); // Temporary - replace with your preferred notification
    }
    
    function showError(message) {
        // You can integrate with your notification system here
        console.error('Error:', message);
        alert('Hata: ' + message); // Temporary - replace with your preferred notification
    }
});
</script>
@endpush