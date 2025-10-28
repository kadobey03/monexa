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
                            <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                            Lead Yönetimi
                        </h1>
                        <p class="text-gray-600 mt-1">Toplam: <span id="total-leads" class="font-semibold text-blue-600">0</span> lead</p>
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" id="refresh-btn">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Yenile
                        </button>
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm" id="add-lead-btn">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
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
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400" id="search-input" placeholder="İsim, email, telefon...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Durum</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="status-filter">
                            <option value="">Tüm Durumlar</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Atanan</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="assigned-filter">
                            <option value="">Tümü</option>
                            <option value="unassigned">Atanmamış</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Öncelik</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="priority-filter">
                            <option value="">Tüm Öncelikler</option>
                            <option value="low">Düşük</option>
                            <option value="medium">Orta</option>
                            <option value="high">Yüksek</option>
                            <option value="urgent">Acil</option>
                        </select>
                    </div>
                </div>
                <div class="flex space-x-3 mt-4">
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" id="apply-filters">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filtrele
                    </button>
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" id="clear-filters">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Temizle
                    </button>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loading" class="text-center py-12" style="display: none;">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <p class="mt-4 text-gray-600">Lead'ler yükleniyor...</p>
        </div>

        <!-- Leads Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left">
                                    <input type="checkbox" id="select-all" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İsim</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefon</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ülke</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statüs</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kaynak</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Atanan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarih</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Not</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody id="leads-table-body" class="bg-white divide-y divide-gray-200">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Empty State -->
                <div id="empty-state" class="text-center py-12" style="display: none;">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Lead bulunamadı</h3>
                    <p class="mt-1 text-sm text-gray-500">Henüz hiç lead eklenmemiş veya filtrelenmiş sonuç bulunamadı.</p>
                    <div class="mt-6">
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" id="empty-add-lead-btn">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            İlk Lead'inizi Ekleyin
                        </button>
                    </div>
                </div>

                <!-- Pagination -->
                <div id="pagination-wrapper" class="bg-gray-50 px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6" style="display: none;">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <button id="prev-btn-mobile" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Önceki</button>
                        <button id="next-btn-mobile" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Sonraki</button>
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                <span id="pagination-info"></span>
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" id="pagination">
                                <!-- Pagination buttons -->
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
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
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
                        <label for="lead-status" class="block text-sm font-medium text-gray-700 mb-2">Durum</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="lead-status">
                            <!-- Options loaded dynamically -->
                        </select>
                    </div>
                    <div>
                        <label for="lead-priority" class="block text-sm font-medium text-gray-700 mb-2">Öncelik</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="lead-priority">
                            <option value="low">Düşük</option>
                            <option value="medium" selected>Orta</option>
                            <option value="high">Yüksek</option>
                            <option value="urgent">Acil</option>
                        </select>
                    </div>
                    <div>
                        <label for="lead-assigned" class="block text-sm font-medium text-gray-700 mb-2">Atanan Admin</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="lead-assigned">
                            <option value="">Atanmamış</option>
                            <!-- Options loaded dynamically -->
                        </select>
                    </div>
                    <div>
                        <label for="lead-score" class="block text-sm font-medium text-gray-700 mb-2">Lead Puanı (0-100)</label>
                        <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="lead-score" min="0" max="100" value="0">
                    </div>
                </div>
                <div class="mt-4">
                    <label for="lead-notes" class="block text-sm font-medium text-gray-700 mb-2">Notlar</label>
                    <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="lead-notes" rows="3"></textarea>
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

<!-- Lead Detail Modal -->
<div id="leadDetailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" style="display: none;">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-xl bg-white">
        <div class="mt-3">
            <!-- Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900" id="leadDetailModalLabel">Lead Detayları</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none" id="close-detail-modal">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Content -->
            <div class="mt-6" id="lead-detail-content">
                <!-- Content loaded dynamically -->
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
/* Custom animations and tweaks for Tailwind */
.modal-enter {
    animation: modalEnter 0.15s ease-out;
}

.modal-exit {
    animation: modalExit 0.15s ease-in;
}

@keyframes modalEnter {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

@keyframes modalExit {
    from { opacity: 1; transform: scale(1); }
    to { opacity: 0; transform: scale(0.95); }
}

/* Custom scrollbar */
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: #f1f5f9; }
::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Global variables
    let currentPage = 1;
    let totalPages = 1;
    let leadStatuses = [];
    let adminUsers = [];
    let leadSources = [];
    
    // Initialize
    init();
    
    function init() {
        loadInitialData();
        loadLeads();
        bindEvents();
    }
    
    // Load initial data (statuses, admins)
    function loadInitialData() {
        // Load dropdown options
        $.ajax({
            url: '/api/admin/leads/options',
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        })
        .done(function(response) {
            if (response.success && response.data) {
                // Store global data for dropdown rendering
                if (response.data.lead_status) {
                    leadStatuses = response.data.lead_status;
                    const statusFilter = $('#status-filter');
                    const leadStatus = $('#lead-status');
                    response.data.lead_status.forEach(function(status) {
                        const option = `<option value="${status.id}">${status.display_name || status.name}</option>`;
                        statusFilter.append(option);
                        leadStatus.append(option);
                    });
                }
                
                // Populate assignable admins
                if (response.data.assigned_admin) {
                    adminUsers = response.data.assigned_admin;
                    populateAdminSelects();
                }
                
                // Store lead sources
                if (response.data.lead_source) {
                    leadSources = response.data.lead_source;
                }
            }
        })
        .fail(function(xhr) {
            console.error('Failed to load options:', xhr);
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
                assigned_to: $('#assigned-filter').val(),
                priority: $('#priority-filter').val()
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
    
    // Display leads in table
    function displayLeads(leads) {
        const tbody = $('#leads-table-body');
        tbody.empty();
        
        if (leads.length === 0) {
            $('#empty-state').show();
            return;
        }
        
        leads.forEach(function(lead) {
            const row = createLeadRow(lead);
            tbody.append(row);
        });
    }
    
    // Create lead table row - Tailwind version
    function createLeadRow(lead) {
        // FIX: Status object'ini düzgün handle et
        let statusForBadge = 'Bilinmiyor';
        if (lead.cstatus && typeof lead.cstatus === 'object') {
            statusForBadge = lead.cstatus.display_name || lead.cstatus.name || lead.cstatus.toString();
        } else if (lead.cstatus && typeof lead.cstatus === 'string') {
            statusForBadge = lead.cstatus;
        } else if (lead.lead_status) {
            statusForBadge = lead.lead_status;
        }
        
        const statusBadge = getStatusBadge(statusForBadge);
        const priorityBadge = getPriorityBadge(lead.lead_priority);
        const assignedName = lead.assignedAdmin ? `${lead.assignedAdmin.firstName} ${lead.assignedAdmin.lastName}` : '<span class="text-gray-500">Atanmamış</span>';
        const createdDate = new Date(lead.created_at).toLocaleDateString('tr-TR');
        
        const leadSourceName = lead.leadSource ? (lead.leadSource.display_name || lead.leadSource.name) : (lead.lead_source || 'Panda');
        const leadNotes = lead.lead_notes ? (lead.lead_notes.length > 50 ? lead.lead_notes.substring(0, 50) + '...' : lead.lead_notes) : '-';
        
        return `
            <tr class="hover:bg-gray-50 transition-colors duration-200" data-lead-id="${lead.id}">
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded lead-checkbox" value="${lead.id}">
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">${lead.name || lead.firstName + ' ' + (lead.lastName || '')}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <a href="mailto:${lead.email}" class="text-sm text-blue-600 hover:text-blue-900">${lead.email}</a>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${lead.phone ? `<a href="tel:${lead.phone}" class="text-blue-600 hover:text-blue-900">${lead.phone}</a>` : '-'}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${lead.country || '-'}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="inline-dropdown">
                        <div class="dropdown-display cursor-pointer hover:bg-gray-50 -mx-2 -my-1 px-2 py-1 rounded transition-colors" onclick="toggleStatusDropdown(this, ${lead.id})">
                            ${statusBadge}
                            <i class="fas fa-chevron-down text-xs ml-1 opacity-50"></i>
                        </div>
                        <select class="dropdown-select hidden text-xs font-semibold rounded px-2 py-1 border border-gray-300 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 min-w-[100px]"
                                onchange="updateLeadStatus(${lead.id}, this.value, this)" data-original="${lead.lead_status_id || ''}">
                            <option value="">Seçiniz</option>
                            ${leadStatuses.map(status => `<option value="${status.id}" ${(lead.lead_status_id == status.id) ? 'selected' : ''}>${status.display_name || status.name}</option>`).join('')}
                        </select>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="inline-dropdown">
                        <div class="dropdown-display cursor-pointer hover:bg-gray-50 -mx-2 -my-1 px-2 py-1 rounded transition-colors" onclick="toggleSourceDropdown(this, ${lead.id})">
                            <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">${leadSourceName}</span>
                            <i class="fas fa-chevron-down text-xs ml-1 opacity-50"></i>
                        </div>
                        <select class="dropdown-select hidden text-xs font-semibold rounded px-2 py-1 border border-gray-300 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 min-w-[100px]"
                                onchange="updateLeadSource(${lead.id}, this.value, this)" data-original="${lead.lead_source_id || ''}">
                            <option value="">Seçiniz</option>
                            ${leadSources.map(source => `<option value="${source.id}" ${(lead.lead_source_id == source.id) ? 'selected' : ''}>${source.display_name || source.name}</option>`).join('')}
                        </select>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="inline-dropdown">
                        <div class="dropdown-display cursor-pointer hover:bg-gray-50 -mx-2 -my-1 px-2 py-1 rounded transition-colors min-w-[120px]" onclick="toggleAssignmentDropdown(this, ${lead.id})">
                            ${assignedName}
                            <i class="fas fa-chevron-down text-xs ml-1 opacity-50"></i>
                        </div>
                        <select class="dropdown-select hidden text-sm rounded px-2 py-1 border border-gray-300 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 min-w-[120px]"
                                onchange="updateLeadAssignment(${lead.id}, this.value, this)" data-original="${lead.assign_to || ''}">
                            <option value="">Atanmamış</option>
                            ${adminUsers.map(admin => `<option value="${admin.id}" ${(lead.assign_to == admin.id) ? 'selected' : ''}>${admin.name}</option>`).join('')}
                        </select>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${createdDate}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" title="${lead.lead_notes || ''}">${leadNotes}</td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex space-x-2">
                        <button type="button" class="text-blue-600 hover:text-blue-900 p-1 rounded view-lead" data-id="${lead.id}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                        <button type="button" class="text-amber-600 hover:text-amber-900 p-1 rounded edit-lead" data-id="${lead.id}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>
                        <button type="button" class="text-red-600 hover:text-red-900 p-1 rounded delete-lead" data-id="${lead.id}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }
    
    // Helper functions for Tailwind styling
    function getStatusBadge(status) {
        const statusMap = {
            'Lead': { class: 'bg-blue-100 text-blue-800', text: 'Lead' },
            'Contacted': { class: 'bg-yellow-100 text-yellow-800', text: 'İletişimde' },
            'Qualified': { class: 'bg-purple-100 text-purple-800', text: 'Nitelikli' },
            'Customer': { class: 'bg-green-100 text-green-800', text: 'Müşteri' },
            'Lost': { class: 'bg-red-100 text-red-800', text: 'Kayıp' },
            'New': { class: 'bg-indigo-100 text-indigo-800', text: 'Yeni' },
            'Hot': { class: 'bg-red-100 text-red-800', text: 'Sıcak' },
            'Warm': { class: 'bg-orange-100 text-orange-800', text: 'Ilık' },
            'Cold': { class: 'bg-blue-100 text-blue-800', text: 'Soğuk' },
            'Aktif': { class: 'bg-green-100 text-green-800', text: 'Aktif' },
            'Pasif': { class: 'bg-gray-100 text-gray-800', text: 'Pasif' }
        };
        
        const statusInfo = statusMap[status] || { class: 'bg-gray-100 text-gray-800', text: status || 'Bilinmiyor' };
        return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusInfo.class}">${statusInfo.text}</span>`;
    }
    
    function getPriorityBadge(priority) {
        const priorityMap = {
            'low': { class: 'bg-gray-100 text-gray-800', text: 'Düşük' },
            'medium': { class: 'bg-blue-100 text-blue-800', text: 'Orta' },
            'high': { class: 'bg-orange-100 text-orange-800', text: 'Yüksek' },
            'urgent': { class: 'bg-red-100 text-red-800', text: 'Acil' }
        };
        
        const priorityInfo = priorityMap[priority] || { class: 'bg-gray-100 text-gray-800', text: 'Orta' };
        return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${priorityInfo.class}">${priorityInfo.text}</span>`;
    }
    
    function getScoreClass(score) {
        if (score >= 80) return 'text-green-600';
        if (score >= 60) return 'text-yellow-600';
        if (score >= 40) return 'text-blue-600';
        return 'text-gray-500';
    }

    // Modal functions
    function showModal(modalId) {
        const modal = $(`#${modalId}`);
        modal.removeClass('modal-exit').addClass('modal-enter').show();
    }
    
    function hideModal(modalId) {
        const modal = $(`#${modalId}`);
        modal.removeClass('modal-enter').addClass('modal-exit');
        setTimeout(() => {
            modal.hide().removeClass('modal-exit');
        }, 150);
    }
    
    // Update statistics, pagination etc. (keeping same logic)
    function updatePagination(pagination) {
        currentPage = pagination.current_page;
        totalPages = pagination.last_page;
        
        if (totalPages <= 1) {
            $('#pagination-wrapper').hide();
            return;
        }
        
        $('#pagination-info').text(`${pagination.from}-${pagination.to} arası gösteriliyor, toplam ${pagination.total} kayıt`);
        const paginationHtml = createPaginationHtml(pagination);
        $('#pagination').html(paginationHtml);
        $('#pagination-wrapper').show();
    }
    
    function createPaginationHtml(pagination) {
        let html = '';
        
        // Previous button
        html += `<a href="#" class="${pagination.current_page === 1 ? 'pointer-events-none text-gray-300' : 'text-gray-500 hover:text-gray-700'} relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium" data-page="${pagination.current_page - 1}">
            <span class="sr-only">Önceki</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
        </a>`;
        
        // Page numbers
        for (let i = 1; i <= pagination.last_page; i++) {
            if (i === pagination.current_page) {
                html += `<span class="bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">${i}</span>`;
            } else if (Math.abs(i - pagination.current_page) <= 2 || i === 1 || i === pagination.last_page) {
                html += `<a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium" data-page="${i}">${i}</a>`;
            } else if (Math.abs(i - pagination.current_page) === 3) {
                html += `<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>`;
            }
        }
        
        // Next button
        html += `<a href="#" class="${pagination.current_page === pagination.last_page ? 'pointer-events-none text-gray-300' : 'text-gray-500 hover:text-gray-700'} relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium" data-page="${pagination.current_page + 1}">
            <span class="sr-only">Sonraki</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        </a>`;
        
        return html;
    }
    
    function updateStatistics(response) {
        if (response.pagination) {
            $('#total-leads').text(response.pagination.total || 0);
        } else if (response.meta && response.meta.statistics) {
            $('#total-leads').text(response.meta.statistics.total_leads || 0);
        } else {
            $('#total-leads').text(response.data ? response.data.length : 0);
        }
    }
    
    function populateAdminSelects() {
        const assignedFilter = $('#assigned-filter');
        const leadAssigned = $('#lead-assigned');
        
        adminUsers.forEach(function(admin) {
            const option = `<option value="${admin.id}">${admin.name}</option>`;
            assignedFilter.append(option);
            leadAssigned.append(option);
        });
    }
    
    // Event bindings - Updated for Tailwind
    function bindEvents() {
        // Modal events
        $('#add-lead-btn, #empty-add-lead-btn').on('click', function() {
            showModal('addLeadModal');
        });
        
        $('#close-modal, #cancel-lead').on('click', function() {
            hideModal('addLeadModal');
        });
        
        $('#close-detail-modal').on('click', function() {
            hideModal('leadDetailModal');
        });
        
        // Click outside modal to close
        $('#addLeadModal, #leadDetailModal').on('click', function(e) {
            if (e.target === this) {
                hideModal(this.id);
            }
        });
        
        // Search
        $('#search-input').on('input', debounce(function() {
            currentPage = 1;
            loadLeads();
        }, 500));
        
        // Filter buttons
        $('#apply-filters').on('click', function() {
            currentPage = 1;
            loadLeads();
        });
        
        $('#clear-filters').on('click', function() {
            $('#search-input').val('');
            $('#status-filter').val('');
            $('#assigned-filter').val('');
            $('#priority-filter').val('');
            currentPage = 1;
            loadLeads();
        });
        
        // Refresh button
        $('#refresh-btn').on('click', function() {
            loadLeads(currentPage);
        });
        
        // Pagination
        $(document).on('click', '#pagination a', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            if (page && page !== currentPage) {
                loadLeads(page);
            }
        });
        
        // Select all checkbox
        $('#select-all').on('change', function() {
            $('.lead-checkbox').prop('checked', this.checked);
        });
        
        // Lead form submission
        $('#lead-form').on('submit', function(e) {
            e.preventDefault();
            saveLead();
        });
        
        // Table actions
        $(document).on('click', '.view-lead', function() {
            const leadId = $(this).data('id');
            viewLead(leadId);
        });
        
        $(document).on('click', '.edit-lead', function() {
            const leadId = $(this).data('id');
            editLead(leadId);
        });
        
        $(document).on('click', '.delete-lead', function() {
            const leadId = $(this).data('id');
            deleteLead(leadId);
        });
    }
    
    // CRUD functions (keeping same logic, updating modal handling)
    function saveLead() {
        const leadId = $('#lead-id').val();
        const isEdit = !!leadId;
        const url = isEdit ? `/api/admin/leads/${leadId}` : '/api/admin/leads';
        const method = isEdit ? 'PUT' : 'POST';
        
        const formData = {
            name: $('#lead-name').val(),
            email: $('#lead-email').val(),
            phone: $('#lead-phone').val(),
            country: $('#lead-country').val(),
            lead_status_id: $('#lead-status').val(),
            lead_priority: $('#lead-priority').val(),
            assign_to: $('#lead-assigned').val() || null,
            lead_score: parseInt($('#lead-score').val()) || 0,
            lead_notes: $('#lead-notes').val()
        };
        
        $('#save-spinner').show();
        
        $.ajax({
            url: url,
            method: method,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            dataType: 'json',
            data: JSON.stringify(formData)
        })
        .done(function(response) {
            if (response.success) {
                hideModal('addLeadModal');
                showSuccess(isEdit ? 'Lead başarıyla güncellendi' : 'Lead başarıyla eklendi');
                loadLeads(currentPage);
                resetLeadForm();
            } else {
                showError(response.message || 'İşlem başarısız');
            }
        })
        .fail(function(xhr) {
            const errors = xhr.responseJSON?.errors;
            if (errors) {
                showValidationErrors(errors);
            } else {
                showError('İşlem başarısız: ' + (xhr.responseJSON?.message || 'Bilinmeyen hata'));
            }
        })
        .always(function() {
            $('#save-spinner').hide();
        });
    }
    
    function viewLead(leadId) {
        $.ajax({
            url: `/api/admin/leads/${leadId}`,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        })
        .done(function(response) {
            if (response.success) {
                displayLeadDetails(response.data);
                showModal('leadDetailModal');
            } else {
                showError('Lead detayları yüklenemedi');
            }
        })
        .fail(function(xhr) {
            console.error('View lead failed:', xhr);
            showError('Lead detayları yüklenemedi');
        });
    }
    
    function displayLeadDetails(lead) {
        const html = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">İsim</dt>
                    <dd class="mt-1 text-sm text-gray-900">${lead.name || lead.firstName + ' ' + (lead.lastName || '')}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <a href="mailto:${lead.email}" class="text-blue-600 hover:text-blue-900">${lead.email}</a>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Telefon</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        ${lead.phone ? `<a href="tel:${lead.phone}" class="text-blue-600 hover:text-blue-900">${lead.phone}</a>` : '-'}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Ülke</dt>
                    <dd class="mt-1 text-sm text-gray-900">${lead.country || '-'}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Durum</dt>
                    <dd class="mt-1">${getStatusBadge(lead.cstatus)}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Lead Puanı</dt>
                    <dd class="mt-1 text-sm font-semibold ${getScoreClass(lead.lead_score)}">${lead.lead_score || 0}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Atanan Admin</dt>
                    <dd class="mt-1 text-sm text-gray-900">${lead.assignedAdmin ? lead.assignedAdmin.firstName + ' ' + lead.assignedAdmin.lastName : 'Atanmamış'}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Kayıt Tarihi</dt>
                    <dd class="mt-1 text-sm text-gray-900">${new Date(lead.created_at).toLocaleString('tr-TR')}</dd>
                </div>
                ${lead.lead_notes ? `
                <div class="md:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Notlar</dt>
                    <dd class="mt-1 text-sm text-gray-900">${lead.lead_notes}</dd>
                </div>
                ` : ''}
            </div>
        `;
        
        $('#lead-detail-content').html(html);
    }
    
    function editLead(leadId) {
        $.ajax({
            url: `/api/admin/leads/${leadId}`,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        })
        .done(function(response) {
            if (response.success) {
                populateLeadForm(response.data);
                $('#addLeadModalLabel').text('Lead Düzenle');
                showModal('addLeadModal');
            } else {
                showError('Lead bilgileri yüklenemedi');
            }
        })
        .fail(function(xhr) {
            console.error('Edit lead failed:', xhr);
            showError('Lead bilgileri yüklenemedi');
        });
    }
    
    function populateLeadForm(lead) {
        $('#lead-id').val(lead.id);
        $('#lead-name').val(lead.name || lead.firstName + ' ' + (lead.lastName || ''));
        $('#lead-email').val(lead.email);
        $('#lead-phone').val(lead.phone || '');
        $('#lead-country').val(lead.country || '');
        $('#lead-status').val(lead.lead_status_id || '');
        $('#lead-priority').val(lead.lead_priority || 'medium');
        $('#lead-assigned').val(lead.assign_to || '');
        $('#lead-score').val(lead.lead_score || 0);
        $('#lead-notes').val(lead.lead_notes || '');
    }
    
    function deleteLead(leadId) {
        if (!confirm('Bu lead\'i silmek istediğinizden emin misiniz?')) {
            return;
        }
        
        $.ajax({
            url: `/api/admin/leads/${leadId}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            }
        })
        .done(function(response) {
            if (response.success) {
                showSuccess('Lead başarıyla silindi');
                loadLeads(currentPage);
            } else {
                showError('Lead silinemedi');
            }
        })
        .fail(function() {
            showError('Lead silinemedi');
        });
    }
    
    function resetLeadForm() {
        $('#lead-form')[0].reset();
        $('#lead-id').val('');
        $('#addLeadModalLabel').text('Yeni Lead Ekle');
        $('.border-red-300').removeClass('border-red-300');
        $('.text-red-600').remove();
    }
    
    // Utility functions
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    function showSuccess(message) {
        // Simple alert for now - could be replaced with a toast library
        alert('✅ ' + message);
    }
    
    function showError(message) {
        alert('❌ ' + message);
    }
    
    function showValidationErrors(errors) {
        $('.border-red-300').removeClass('border-red-300');
        $('.text-red-600').remove();
        
        Object.keys(errors).forEach(function(field) {
            const input = $(`#lead-${field.replace('_', '-')}`);
            input.addClass('border-red-300 focus:border-red-300 focus:ring-red-500');
            input.after(`<p class="mt-1 text-sm text-red-600">${errors[field][0]}</p>`);
        });
    }
    
    // Dropdown toggle functions
    function toggleStatusDropdown(element, leadId) {
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
    }
    
    function toggleAssignmentDropdown(element, leadId) {
        // Close all other dropdowns first
        document.querySelectorAll('.dropdown-select').forEach(select => {
            if (!select.closest('td').contains(element)) {
                select.classList.add('hidden');
                select.parentElement.querySelector('.dropdown-display').style.display = 'block';
            }
        });
        
        const dropdown = element.parentElement;
        const display = dropdown.querySelector('.dropdown-display');
        const select = dropdown.querySelector('.dropdown-select');
        
        if (!select) {
            console.error('Assignment dropdown select element not found for lead:', leadId);
            return;
        }
        
        // FIX: Admin listesi boşsa yeniden yükle
        if (adminUsers.length === 0) {
            console.log('AdminUsers empty, reloading...');
            loadInitialData();
            return;
        }
        
        // Toggle dropdown visibility
        display.style.display = display.style.display === 'none' ? 'block' : 'none';
        select.classList.toggle('hidden');
        
        if (!select.classList.contains('hidden')) {
            select.focus();
        }
    }
    
    function toggleSourceDropdown(element, leadId) {
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
    }
    
    // AJAX PUT requests for inline editing
    function updateLeadStatus(leadId, newStatusId, selectElement) {
        if (!leadId || !newStatusId) {
            showError('Geçerli bir status seçiniz');
            return;
        }
        
        $.ajax({
            url: `/api/admin/leads/${leadId}`,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            dataType: 'json',
            data: JSON.stringify({
                lead_status_id: parseInt(newStatusId)
            })
        })
        .done(function(response) {
            if (response.success) {
                showSuccess('Lead status başarıyla güncellendi');
                
                // Hide dropdown
                selectElement.classList.add('hidden');
                const displayElement = selectElement.parentElement.querySelector('.dropdown-display');
                displayElement.style.display = 'block';
                
                // Update display with new status
                if (response.data && response.data.leadStatus) {
                    const status = response.data.leadStatus;
                    const statusBadge = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">${status.display_name || status.name}</span>`;
                    displayElement.innerHTML = statusBadge + '<i class="fas fa-chevron-down text-xs ml-1 opacity-50"></i>';
                    selectElement.dataset.original = status.id;
                }
            } else {
                showError(response.message || 'Status güncellenirken hata oluştu');
                selectElement.value = selectElement.dataset.original || '';
            }
        })
        .fail(function(xhr) {
            console.error('Status update error:', xhr);
            showError('Status güncellenirken hata oluştu: ' + (xhr.responseJSON?.message || 'Bilinmeyen hata'));
            selectElement.value = selectElement.dataset.original || '';
            selectElement.classList.add('hidden');
            selectElement.parentElement.querySelector('.dropdown-display').style.display = 'block';
        });
    }
    
    function updateLeadAssignment(leadId, newAdminId, selectElement) {
        if (!leadId) return;
        
        $.ajax({
            url: `/api/admin/leads/${leadId}`,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            dataType: 'json',
            data: JSON.stringify({
                assign_to: newAdminId ? parseInt(newAdminId) : null
            })
        })
        .done(function(response) {
            if (response.success) {
                showSuccess('Lead atama başarıyla güncellendi');
                
                // Hide dropdown
                selectElement.classList.add('hidden');
                const displayElement = selectElement.parentElement.querySelector('.dropdown-display');
                displayElement.style.display = 'block';
                
                // Update display with new assignment
                if (response.data && response.data.assignedAdmin) {
                    const admin = response.data.assignedAdmin;
                    displayElement.innerHTML = `${admin.firstName} ${admin.lastName} <i class="fas fa-chevron-down text-xs ml-1 opacity-50"></i>`;
                    selectElement.dataset.original = admin.id;
                } else {
                    displayElement.innerHTML = '<span class="text-gray-500">Atanmamış</span> <i class="fas fa-chevron-down text-xs ml-1 opacity-50"></i>';
                    selectElement.dataset.original = '';
                }
            } else {
                showError(response.message || 'Atama güncellenirken hata oluştu');
                selectElement.value = selectElement.dataset.original || '';
            }
        })
        .fail(function(xhr) {
            console.error('Assignment update error:', xhr);
            showError('Atama güncellenirken hata oluştu: ' + (xhr.responseJSON?.message || 'Bilinmeyen hata'));
            selectElement.value = selectElement.dataset.original || '';
            selectElement.classList.add('hidden');
            selectElement.parentElement.querySelector('.dropdown-display').style.display = 'block';
        });
    }
    
    function updateLeadSource(leadId, newSourceId, selectElement) {
        if (!leadId || !newSourceId) {
            showError('Geçerli bir kaynak seçiniz');
            return;
        }
        
        $.ajax({
            url: `/api/admin/leads/${leadId}`,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            dataType: 'json',
            data: JSON.stringify({
                lead_source_id: parseInt(newSourceId)
            })
        })
        .done(function(response) {
            if (response.success) {
                showSuccess('Lead kaynağı başarıyla güncellendi');
                
                // Hide dropdown
                selectElement.classList.add('hidden');
                const displayElement = selectElement.parentElement.querySelector('.dropdown-display');
                displayElement.style.display = 'block';
                
                // Update display with new source
                if (response.data && response.data.leadSource) {
                    const source = response.data.leadSource;
                    const sourceBadge = `<span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">${source.display_name || source.name}</span>`;
                    displayElement.innerHTML = sourceBadge + '<i class="fas fa-chevron-down text-xs ml-1 opacity-50"></i>';
                    selectElement.dataset.original = source.id;
                }
            } else {
                showError(response.message || 'Kaynak güncellenirken hata oluştu');
                selectElement.value = selectElement.dataset.original || '';
            }
        })
        .fail(function(xhr) {
            console.error('Source update error:', xhr);
            showError('Kaynak güncellenirken hata oluştu: ' + (xhr.responseJSON?.message || 'Bilinmeyen hata'));
            selectElement.value = selectElement.dataset.original || '';
            selectElement.classList.add('hidden');
            selectElement.parentElement.querySelector('.dropdown-display').style.display = 'block';
        });
    }
    
    // Close dropdowns when clicking outside
    $(document).on('click', function(event) {
        if (!$(event.target).closest('.inline-dropdown').length) {
            $('.dropdown-select').addClass('hidden');
            $('.dropdown-display').show();
        }
    });
});
</script>
@endpush