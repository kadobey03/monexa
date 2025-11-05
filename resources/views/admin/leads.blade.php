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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                            </svg>
                            Lead Yönetimi
                        </h1>
                        <p class="text-gray-600 mt-1">Toplam: <span id="total-leads" class="font-semibold text-blue-600">-</span> lead</p>
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" id="refresh-btn">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Yenile
                        </button>
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" id="export-excel-btn">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                            </svg>
                            Excel
                        </button>
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm" id="add-lead-btn">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Yeni Lead Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div id="stats-section" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6" style="display: none;">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-sm font-medium text-gray-500">Toplam Lead</div>
                        <div class="text-lg font-semibold text-gray-900" id="stat-total">-</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-sm font-medium text-gray-500">Atanmamış</div>
                        <div class="text-lg font-semibold text-gray-900" id="stat-unassigned">-</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-sm font-medium text-gray-500">Bu Hafta</div>
                        <div class="text-lg font-semibold text-gray-900" id="stat-weekly">-</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-sm font-medium text-gray-500">Yüksek Puan</div>
                        <div class="text-lg font-semibold text-gray-900" id="stat-high-score">-</div>
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
                            <input type="text" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-400" id="search-input" placeholder="İsim, email, telefon...">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
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
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filtrele
                    </button>
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" id="clear-filters">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
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

        <!-- Error State -->
        <div id="error-state" class="bg-red-50 border border-red-200 rounded-xl p-6 mb-6" style="display: none;">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.99-.833-2.76 0L4.054 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Hata Oluştu</h3>
                    <p class="mt-1 text-sm text-red-700" id="error-message">Veriler yüklenirken bir hata oluştu.</p>
                    <div class="mt-3">
                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-red-800 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" id="retry-btn">
                            Tekrar Dene
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leads Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" id="select-all">
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ülke
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ad Soyad
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Telefon
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Atanan
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Durum
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kaynak
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tarih
                                </th>
                            </tr>
                        </thead>
                        <tbody id="leads-table-body" class="bg-white divide-y divide-gray-200">
                            <!-- Data will be loaded here via JavaScript -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Empty State -->
                <div id="empty-state" class="text-center py-16" style="display: none;">
                    <div class="mx-auto h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz lead yok</h3>
                    <p class="text-gray-500 mb-6 max-w-md mx-auto">Lead'ler bulunamadı. İlk lead'inizi eklemek için butona tıklayın.</p>
                    <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" id="empty-add-lead-btn">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        İlk Lead'i Ekle
                    </button>
                </div>

                <!-- Pagination -->
                <div id="pagination-wrapper" class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-200" style="display: none;">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <button id="prev-btn-mobile" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Önceki
                        </button>
                        <button id="next-btn-mobile" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            Sonraki
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700" id="pagination-info">-</p>
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('🪲 Lead Management DEBUG: Page loaded');
    
    // Global variables
    let currentPage = 1;
    let totalPages = 1;
    let leadStatuses = [];
    let leadSources = [];
    let adminUsers = [];
    let isLoading = false;
    
    // Debug mode
    const DEBUG = true;
    function debugLog(message, data = null) {
        if (DEBUG) {
            console.log('🪲 LEADS DEBUG:', message, data || '');
        }
    }
    
    // Initialize
    init();
    
    function init() {
        debugLog('Initializing lead management system');
        
        loadInitialData()
            .then(() => {
                debugLog('Initial data loaded, now loading leads');
                return loadLeads();
            })
            .then(() => {
                debugLog('Leads loaded, binding events');
                bindEvents();
            })
            .catch(error => {
                debugLog('Initialization error', error);
                showError('Sistem yüklenirken hata oluştu: ' + error.message);
            });
    }
    
    // Load initial data (statuses, sources, admins)
    async function loadInitialData() {
        debugLog('Loading initial data');
        
        try {
            const promises = [
                loadStatuses(),
                loadSources(), 
                loadAssignableAdmins()
            ];
            
            await Promise.allSettled(promises);
            debugLog('All initial data loaded');
            
        } catch (error) {
            debugLog('Error loading initial data', error);
            throw error;
        }
    }
    
    // Load lead statuses
    async function loadStatuses() {
        debugLog('Loading statuses');
        
        try {
            const response = await fetch('/admin/dashboard/leads/api/statuses', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            debugLog('Statuses response', data);
            
            if (data.success && data.data) {
                leadStatuses = data.data;
                populateStatusSelects();
                debugLog('Statuses loaded', leadStatuses.length + ' items');
            }
        } catch (error) {
            debugLog('Error loading statuses', error);
        }
    }
    
    // Load lead sources  
    async function loadSources() {
        debugLog('Loading sources');
        
        try {
            const response = await fetch('/admin/dashboard/leads/api/lead-sources', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            debugLog('Sources response', data);
            
            if (data.success && data.data) {
                leadSources = data.data;
                populateSourceSelects();
                debugLog('Sources loaded', leadSources.length + ' items');
            }
        } catch (error) {
            debugLog('Error loading sources', error);
        }
    }
    
    // Load assignable admins
    async function loadAssignableAdmins() {
        debugLog('Loading assignable admins');
        
        try {
            const response = await fetch('/admin/dashboard/leads/api/assignable-admins', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            debugLog('Assignable admins response', data);
            
            if (data.success && data.data) {
                adminUsers = data.data;
                populateAdminSelects();
                debugLog('Assignable admins loaded', adminUsers.length + ' items');
            }
        } catch (error) {
            debugLog('Error loading assignable admins', error);
        }
    }
    
    // Load leads data - MAIN API CALL
    async function loadLeads(page = 1) {
        debugLog('Loading leads for page', page);
        
        if (isLoading) {
            debugLog('Already loading, skipping');
            return;
        }
        
        isLoading = true;
        showLoading();
        hideError();
        
        const params = new URLSearchParams({
            page: page,
            per_page: 25,
            sort_by: 'created_at',
            sort_direction: 'desc'
        });
        
        // Add filters
        const search = document.getElementById('search-input').value;
        if (search) params.append('search', search);
        
        const status = document.getElementById('status-filter').value;
        if (status) params.append('status', status);
        
        const source = document.getElementById('source-filter').value; 
        if (source) params.append('source', source);
        
        const assigned = document.getElementById('assigned-filter').value;
        if (assigned) params.append('assigned_to', assigned);
        
        debugLog('API call parameters', Object.fromEntries(params));
        
        try {
            const response = await fetch(`/admin/leads/api?${params}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });
            
            debugLog('API response status', response.status);
            
            const data = await response.json();
            debugLog('API response data', data);
            
            if (data.success) {
                displayLeads(data.data);
                updatePagination(data.pagination);
                updateStatistics(data);
                showStats();
                debugLog('Leads loaded successfully', data.data.length + ' items');
            } else {
                throw new Error(data.message || 'API returned success=false');
            }
            
        } catch (error) {
            debugLog('Error loading leads', error);
            showError('Lead\'ler yüklenirken hata oluştu: ' + error.message);
        } finally {
            isLoading = false;
            hideLoading();
        }
    }
    
    // Display leads in table
    function displayLeads(leads) {
        debugLog('Displaying leads', leads.length + ' items');
        
        const tbody = document.getElementById('leads-table-body');
        tbody.innerHTML = '';
        
        if (leads.length === 0) {
            showEmptyState();
            return;
        }
        
        hideEmptyState();
        
        leads.forEach(lead => {
            const row = createLeadRow(lead);
            tbody.appendChild(row);
        });
        
        debugLog('Table rows created');
    }
    
    // Create lead row
    function createLeadRow(lead) {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-gray-50 transition-colors duration-200';
        tr.setAttribute('data-lead-id', lead.id);
        
        // Avatar initials
        const avatarText = lead.name ? lead.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase() : 'NN';
        const avatarColors = ['bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-pink-500', 'bg-indigo-500'];
        const avatarColor = avatarColors[lead.id % 5];
        
        // Status info
        const status = leadStatuses.find(s => s.id == lead.status?.id) || { display_name: 'Bilinmeyen', color: '#6b7280' };
        
        // Source info  
        const source = leadSources.find(s => s.id == lead.source?.id) || { name: 'Bilinmeyen' };
        
        // Assigned admin
        const assignedAdmin = lead.assigned_to ? adminUsers.find(a => a.id == lead.assigned_to.id) || lead.assigned_to : null;
        
        tr.innerHTML = `
            <!-- Checkbox -->
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="checkbox" class="lead-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" data-lead-id="${lead.id}">
            </td>
            
            <!-- Country -->
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    ${lead.country || 'Belirtilmemiş'}
                </span>
            </td>
            
            <!-- Name -->
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                        <div class="${avatarColor} rounded-full h-10 w-10 flex items-center justify-center">
                            <span class="text-sm font-medium text-white">${avatarText}</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">${lead.name || 'İsimsiz'}</div>
                        <div class="text-sm text-gray-500">ID: #${lead.id}</div>
                    </div>
                </div>
            </td>
            
            <!-- Phone -->
            <td class="px-6 py-4 whitespace-nowrap">
                ${lead.phone ? `
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <a href="tel:${lead.phone}" class="text-sm text-blue-600 hover:text-blue-900 transition-colors">
                            ${lead.phone}
                        </a>
                    </div>
                ` : `
                    <span class="text-sm text-gray-400 italic">Telefon yok</span>
                `}
            </td>
            
            <!-- Email -->
            <td class="px-6 py-4 whitespace-nowrap">
                ${lead.email ? `
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <a href="mailto:${lead.email}" class="text-sm text-blue-600 hover:text-blue-900 transition-colors truncate">
                            ${lead.email}
                        </a>
                    </div>
                ` : `
                    <span class="text-sm text-gray-400 italic">Email yok</span>
                `}
            </td>
            
            <!-- Assigned -->
            <td class="px-6 py-4 whitespace-nowrap">
                ${assignedAdmin ? `
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-xs font-medium text-blue-600">${assignedAdmin.name[0]}</span>
                        </div>
                        <div class="ml-2">
                            <div class="text-sm text-gray-900">${assignedAdmin.name}</div>
                        </div>
                    </div>
                ` : `
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Atanmamış
                    </span>
                `}
            </td>
            
            <!-- Status -->
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium" 
                      style="background-color: ${status.color || '#6b7280'}20; color: ${status.color || '#6b7280'}; border: 1px solid ${status.color || '#6b7280'}40;">
                    ${status.display_name || status.name || 'Bilinmeyen'}
                </span>
            </td>
            
            <!-- Source -->
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    ${source.name || 'Bilinmeyen'}
                </span>
            </td>
            
            <!-- Date -->
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                ${lead.created_at ? new Date(lead.created_at).toLocaleDateString('tr-TR') : '-'}
            </td>
        `;
        
        return tr;
    }
    
    // Populate selects
    function populateStatusSelects() {
        const statusFilter = document.getElementById('status-filter');
        statusFilter.innerHTML = '<option value="">Tüm Durumlar</option>';
        
        leadStatuses.forEach(status => {
            const option = document.createElement('option');
            option.value = status.id || status.name;
            option.textContent = status.display_name || status.name;
            if (status.color) {
                option.style.color = status.color;
            }
            statusFilter.appendChild(option);
        });
    }
    
    function populateSourceSelects() {
        const sourceFilter = document.getElementById('source-filter');
        sourceFilter.innerHTML = '<option value="">Tüm Kaynaklar</option>';
        
        leadSources.forEach(source => {
            const option = document.createElement('option');
            option.value = source.id;
            option.textContent = source.name;
            sourceFilter.appendChild(option);
        });
    }
    
    function populateAdminSelects() {
        const assignedFilter = document.getElementById('assigned-filter');
        // Keep existing options
        const existingOptions = assignedFilter.innerHTML;
        
        adminUsers.forEach(admin => {
            const option = document.createElement('option');
            option.value = admin.id;
            option.textContent = admin.name;
            assignedFilter.appendChild(option);
        });
    }
    
    // Event binding
    function bindEvents() {
        debugLog('Binding events');
        
        // Search with debouncing
        let searchTimeout;
        document.getElementById('search-input').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentPage = 1;
                loadLeads();
            }, 500);
        });
        
        // Filter buttons
        document.getElementById('apply-filters').addEventListener('click', function() {
            currentPage = 1;
            loadLeads();
        });
        
        document.getElementById('clear-filters').addEventListener('click', function() {
            document.getElementById('search-input').value = '';
            document.getElementById('status-filter').value = '';
            document.getElementById('source-filter').value = '';
            document.getElementById('assigned-filter').value = '';
            currentPage = 1;
            loadLeads();
        });
        
        // Refresh button
        document.getElementById('refresh-btn').addEventListener('click', function() {
            loadLeads(currentPage);
        });
        
        // Add lead buttons
        const addBtns = ['add-lead-btn', 'empty-add-lead-btn'];
        addBtns.forEach(btnId => {
            const btn = document.getElementById(btnId);
            if (btn) {
                btn.addEventListener('click', function() {
                    // Open modal functionality - to be implemented
                    debugLog('Add lead button clicked');
                    alert('Add lead functionality - to be implemented');
                });
            }
        });
        
        // Export button
        document.getElementById('export-excel-btn').addEventListener('click', function() {
            exportToExcel();
        });
        
        // Retry button
        const retryBtn = document.getElementById('retry-btn');
        if (retryBtn) {
            retryBtn.addEventListener('click', function() {
                loadLeads(currentPage);
            });
        }
        
        debugLog('Events bound successfully');
    }
    
    // Update pagination
    function updatePagination(pagination) {
        if (!pagination || pagination.total === 0) {
            hidePagination();
            return;
        }
        
        currentPage = pagination.current_page;
        totalPages = pagination.last_page;
        
        // Update info
        const start = pagination.from || 1;
        const end = pagination.to || pagination.total;
        document.getElementById('pagination-info').textContent = 
            `${start}-${end} arası gösteriliyor (Toplam: ${pagination.total})`;
        
        showPagination();
        debugLog('Pagination updated', pagination);
    }
    
    // Update statistics
    function updateStatistics(response) {
        if (response.statistics) {
            const stats = response.statistics;
            document.getElementById('stat-total').textContent = stats.total_leads || 0;
            document.getElementById('stat-unassigned').textContent = stats.unassigned_leads || 0;
            document.getElementById('stat-weekly').textContent = stats.new_leads_this_week || 0;
            document.getElementById('stat-high-score').textContent = stats.high_score_leads || 0;
        }
        
        // Also update header total
        document.getElementById('total-leads').textContent = response.pagination?.total || 0;
        
        debugLog('Statistics updated');
    }
    
    // Export to Excel
    function exportToExcel() {
        const params = new URLSearchParams();
        
        const search = document.getElementById('search-input').value;
        if (search) params.append('search', search);
        
        const status = document.getElementById('status-filter').value;
        if (status) params.append('status', status);
        
        const source = document.getElementById('source-filter').value;
        if (source) params.append('source', source);
        
        const assigned = document.getElementById('assigned-filter').value;
        if (assigned) params.append('assigned_to', assigned);
        
        const url = `/admin/leads/export?${params}`;
        debugLog('Exporting to Excel', url);
        
        window.open(url, '_blank');
    }
    
    // UI Helper functions
    function showLoading() {
        document.getElementById('loading').style.display = 'block';
        hideEmptyState();
        hideError();
    }
    
    function hideLoading() {
        document.getElementById('loading').style.display = 'none';
    }
    
    function showEmptyState() {
        document.getElementById('empty-state').style.display = 'block';
        hidePagination();
    }
    
    function hideEmptyState() {
        document.getElementById('empty-state').style.display = 'none';
    }
    
    function showPagination() {
        document.getElementById('pagination-wrapper').style.display = 'flex';
    }
    
    function hidePagination() {
        document.getElementById('pagination-wrapper').style.display = 'none';
    }
    
    function showStats() {
        document.getElementById('stats-section').style.display = 'grid';
    }
    
    function hideStats() {
        document.getElementById('stats-section').style.display = 'none';
    }
    
    function showError(message) {
        document.getElementById('error-message').textContent = message;
        document.getElementById('error-state').style.display = 'block';
        hideEmptyState();
        debugLog('Error shown', message);
    }
    
    function hideError() {
        document.getElementById('error-state').style.display = 'none';
    }
    
    debugLog('Lead management system initialized');
});
</script>
@endpush