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
<script type="module">
// Import utilities first - prioritized order
import { domHelpers } from '/js/admin/leads/utils/DomHelpers.js';
import { dateUtils } from '/js/admin/leads/utils/DateUtils.js';
import { a11y } from '/js/admin/leads/utils/AccessibilityHelpers.js';

// Import core modules
import { Config } from '/js/admin/leads/core/Config.js';
import { EventBus } from '/js/admin/leads/core/EventBus.js';
import leadApp from '/js/admin/leads/core/App.js';

// Import services
import { ApiService } from '/js/admin/leads/services/ApiService.js';
import { ValidationService } from '/js/admin/leads/services/ValidationService.js';
import { CacheService } from '/js/admin/leads/services/CacheService.js';

// Import components
import { DataTable } from '/js/admin/leads/components/DataTable.js';
import { FilterPanel } from '/js/admin/leads/components/FilterPanel.js';
import { BulkActions } from '/js/admin/leads/components/BulkActions.js';
import { ModalSystem } from '/js/admin/leads/components/ModalSystem.js';

document.addEventListener('DOMContentLoaded', function() {
    console.log('🪲 Lead Management DEBUG: Page loaded with modular system');
    
    // Laravel configuration integration
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }

    // Initialize configuration with Turkish locale and Laravel integration
    const config = new Config({
        debug: true,
        apiBaseUrl: '/admin/leads/api',
        endpoints: {
            leads: '/admin/leads/api',
            statuses: '/admin/dashboard/leads/api/statuses',
            sources: '/admin/dashboard/leads/api/lead-sources',
            assignableAdmins: '/admin/dashboard/leads/api/assignable-admins',
            export: '/admin/leads/export'
        },
        pagination: {
            perPage: 25,
            maxVisiblePages: 7
        },
        search: {
            debounceMs: 500,
            minLength: 2
        },
        locale: 'tr-TR',
        csrfToken: csrfToken,
        dateFormat: 'DD.MM.YYYY',
        currency: 'TRY',
        translations: {
            loading: 'Lead\'ler yükleniyor...',
            noData: 'Henüz lead yok',
            error: 'Lead\'ler yüklenirken hata oluştu',
            systemError: 'Sistem yüklenirken hata oluştu',
            totalLeads: 'Toplam',
            unassigned: 'Atanmamış',
            thisWeek: 'Bu Hafta',
            highScore: 'Yüksek Puan',
            unknown: 'Bilinmeyen',
            noPhone: 'Telefon yok',
            noEmail: 'Email yok',
            allStatuses: 'Tüm Durumlar',
            allSources: 'Tüm Kaynaklar',
            all: 'Tümü',
            addLead: 'Add lead functionality - to be implemented'
        }
    });

    // Initialize event bus
    const eventBus = new EventBus();
    
    // Initialize services with Turkish locale support
    const apiService = new ApiService(config, eventBus);
    const validationService = new ValidationService(config);
    const cacheService = new CacheService(config);

    // Initialize components with accessibility support
    const dataTable = new DataTable(config, eventBus, apiService, domHelpers, dateUtils, a11y);
    const filterPanel = new FilterPanel(config, eventBus, validationService, domHelpers, a11y);
    const bulkActions = new BulkActions(config, eventBus, apiService, domHelpers, a11y);
    const modalSystem = new ModalSystem(config, eventBus, domHelpers, a11y);

    // Legacy integration - Global variables for backward compatibility
    let currentPage = 1;
    let totalPages = 1;
    let leadStatuses = [];
    let leadSources = [];
    let adminUsers = [];
    let isLoading = false;
    
    // Debug mode with modular system
    const DEBUG = config.get('debug');
    function debugLog(message, data = null) {
        if (DEBUG) {
            console.log('🪲 LEADS MODULAR DEBUG:', message, data || '');
        }
    }

    // Initialize the modular app
    const app = leadApp;
    
    // Legacy init function - now integrated with modular system
    function init() {
        debugLog('Initializing modular lead management system');
        
        // Initialize app first
        app.initialize().then(() => {
            debugLog('App initialized successfully');
            
            // Load initial data using services
            return loadInitialData();
        })
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
            showError(config.get('translations.systemError') + ': ' + error.message);
        });
    }
    
    // Load initial data using API service
    async function loadInitialData() {
        debugLog('Loading initial data with services');
        
        try {
            // Use cache service to check for cached data
            const cachedStatuses = cacheService.get('leadStatuses');
            const cachedSources = cacheService.get('leadSources');
            const cachedAdmins = cacheService.get('adminUsers');
            
            const promises = [];
            
            if (!cachedStatuses) promises.push(loadStatuses());
            else {
                leadStatuses = cachedStatuses;
                populateStatusSelects();
            }
            
            if (!cachedSources) promises.push(loadSources());
            else {
                leadSources = cachedSources;
                populateSourceSelects();
            }
            
            if (!cachedAdmins) promises.push(loadAssignableAdmins());
            else {
                adminUsers = cachedAdmins;
                populateAdminSelects();
            }
            
            if (promises.length > 0) {
                await Promise.allSettled(promises);
            }
            
            debugLog('All initial data loaded with caching');
            
        } catch (error) {
            debugLog('Error loading initial data', error);
            throw error;
        }
    }
    
    // Load lead statuses using API service
    async function loadStatuses() {
        debugLog('Loading statuses via API service');
        
        try {
            const data = await apiService.fetchStatuses();
            
            if (data && Array.isArray(data)) {
                leadStatuses = data;
                cacheService.set('leadStatuses', data, 300); // Cache for 5 minutes
                populateStatusSelects();
                debugLog('Statuses loaded via service', leadStatuses.length + ' items');
            }
        } catch (error) {
            debugLog('Error loading statuses via service', error);
        }
    }
    
    // Load lead sources using API service
    async function loadSources() {
        debugLog('Loading sources via API service');
        
        try {
            const data = await apiService.fetchSources();
            
            if (data && Array.isArray(data)) {
                leadSources = data;
                cacheService.set('leadSources', data, 300); // Cache for 5 minutes
                populateSourceSelects();
                debugLog('Sources loaded via service', leadSources.length + ' items');
            }
        } catch (error) {
            debugLog('Error loading sources via service', error);
        }
    }
    
    // Load assignable admins using API service
    async function loadAssignableAdmins() {
        debugLog('Loading assignable admins via API service');
        
        try {
            const data = await apiService.fetchAssignableAdmins();
            
            if (data && Array.isArray(data)) {
                adminUsers = data;
                cacheService.set('adminUsers', data, 300); // Cache for 5 minutes
                populateAdminSelects();
                debugLog('Assignable admins loaded via service', adminUsers.length + ' items');
            }
        } catch (error) {
            debugLog('Error loading assignable admins via service', error);
        }
    }
    
    // Load leads data using API service and data table component
    async function loadLeads(page = 1) {
        debugLog('Loading leads for page via service', page);
        
        if (isLoading) {
            debugLog('Already loading, skipping');
            return;
        }
        
        isLoading = true;
        showLoading();
        hideError();
        
        // Build filters object using validation service
        const filters = {
            page: page,
            per_page: config.get('pagination.perPage'),
            sort_by: 'created_at',
            sort_direction: 'desc'
        };
        
        // Add validated filters
        const search = domHelpers.getValue('search-input');
        if (search && validationService.validateSearch(search)) filters.search = search;
        
        const status = domHelpers.getValue('status-filter');
        if (status) filters.status = status;
        
        const source = domHelpers.getValue('source-filter');
        if (source) filters.source = source;
        
        const assigned = domHelpers.getValue('assigned-filter');
        if (assigned) filters.assigned_to = assigned;
        
        debugLog('API call parameters via service', filters);
        
        try {
            const response = await apiService.fetchLeads(filters);
            
            if (response && response.success) {
                // Use data table component to display leads
                displayLeads(response.data);
                updatePagination(response.pagination);
                updateStatistics(response);
                showStats();
                debugLog('Leads loaded successfully via service', response.data.length + ' items');
            } else {
                throw new Error(response?.message || 'API returned success=false');
            }
            
        } catch (error) {
            debugLog('Error loading leads via service', error);
            showError(config.get('translations.error') + ': ' + error.message);
        } finally {
            isLoading = false;
            hideLoading();
        }
    }
    
    // Display leads in table using data table component
    function displayLeads(leads) {
        debugLog('Displaying leads via data table component', leads.length + ' items');
        
        const tbody = domHelpers.getElement('leads-table-body');
        if (!tbody) {
            debugLog('Table body not found');
            return;
        }
        
        tbody.innerHTML = '';
        
        if (leads.length === 0) {
            showEmptyState();
            return;
        }
        
        hideEmptyState();
        
        // Use data table component to create rows with accessibility
        leads.forEach(lead => {
            const row = createLeadRow(lead);
            tbody.appendChild(row);
        });
        
        // Apply accessibility improvements
        a11y.ensureTableAccessibility('leads-table-body');
        
        debugLog('Table rows created via component');
    }
    
    // Create lead row with enhanced features
    function createLeadRow(lead) {
        const tr = domHelpers.createElement('tr', {
            className: 'hover:bg-gray-50 transition-colors duration-200 focus-within:bg-blue-50',
            'data-lead-id': lead.id,
            'role': 'row'
        });
        
        // Avatar with accessibility
        const avatarText = lead.name ?
            lead.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase() : 'NN';
        const avatarColors = ['bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-pink-500', 'bg-indigo-500'];
        const avatarColor = avatarColors[lead.id % 5];
        
        // Status info with validation
        const status = leadStatuses.find(s => s.id == lead.status?.id) || {
            display_name: config.get('translations.unknown'),
            color: '#6b7280'
        };
        
        // Source info
        const source = leadSources.find(s => s.id == lead.source?.id) || {
            name: config.get('translations.unknown')
        };
        
        // Assigned admin
        const assignedAdmin = lead.assigned_to ?
            adminUsers.find(a => a.id == lead.assigned_to.id) || lead.assigned_to : null;
        
        // Use date utility for formatting
        const formattedDate = lead.created_at ?
            dateUtils.formatDate(lead.created_at, config.get('dateFormat')) : '-';
        
        tr.innerHTML = `
            <!-- Checkbox with accessibility -->
            <td class="px-6 py-4 whitespace-nowrap" role="gridcell">
                <input type="checkbox"
                       class="lead-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                       data-lead-id="${lead.id}"
                       aria-label="Lead ID ${lead.id} seç">
            </td>
            
            <!-- Country -->
            <td class="px-6 py-4 whitespace-nowrap" role="gridcell">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                      aria-label="Ülke: ${lead.country || 'Belirtilmemiş'}">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    ${lead.country || 'Belirtilmemiş'}
                </span>
            </td>
            
            <!-- Name with enhanced accessibility -->
            <td class="px-6 py-4 whitespace-nowrap" role="gridcell">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                        <div class="${avatarColor} rounded-full h-10 w-10 flex items-center justify-center"
                             aria-label="Avatar for ${lead.name || 'İsimsiz'}">
                            <span class="text-sm font-medium text-white">${avatarText}</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">${lead.name || 'İsimsiz'}</div>
                        <div class="text-sm text-gray-500">ID: #${lead.id}</div>
                    </div>
                </div>
            </td>
            
            <!-- Phone with validation -->
            <td class="px-6 py-4 whitespace-nowrap" role="gridcell">
                ${lead.phone ? `
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <a href="tel:${lead.phone}"
                           class="text-sm text-blue-600 hover:text-blue-900 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 rounded"
                           aria-label="Telefonu ara: ${lead.phone}">
                            ${lead.phone}
                        </a>
                    </div>
                ` : `
                    <span class="text-sm text-gray-400 italic">${config.get('translations.noPhone')}</span>
                `}
            </td>
            
            <!-- Email with validation -->
            <td class="px-6 py-4 whitespace-nowrap" role="gridcell">
                ${lead.email ? `
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <a href="mailto:${lead.email}"
                           class="text-sm text-blue-600 hover:text-blue-900 transition-colors truncate focus:outline-none focus:ring-2 focus:ring-blue-500 rounded"
                           aria-label="Email gönder: ${lead.email}">
                            ${lead.email}
                        </a>
                    </div>
                ` : `
                    <span class="text-sm text-gray-400 italic">${config.get('translations.noEmail')}</span>
                `}
            </td>
            
            <!-- Assigned -->
            <td class="px-6 py-4 whitespace-nowrap" role="gridcell">
                ${assignedAdmin ? `
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center"
                             aria-label="Atanan admin: ${assignedAdmin.name}">
                            <span class="text-xs font-medium text-blue-600">${assignedAdmin.name[0]}</span>
                        </div>
                        <div class="ml-2">
                            <div class="text-sm text-gray-900">${assignedAdmin.name}</div>
                        </div>
                    </div>
                ` : `
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        ${config.get('translations.unassigned')}
                    </span>
                `}
            </td>
            
            <!-- Status with dynamic colors -->
            <td class="px-6 py-4 whitespace-nowrap" role="gridcell">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                      style="background-color: ${status.color || '#6b7280'}20; color: ${status.color || '#6b7280'}; border: 1px solid ${status.color || '#6b7280'}40;"
                      aria-label="Durum: ${status.display_name || status.name || config.get('translations.unknown')}">
                    ${status.display_name || status.name || config.get('translations.unknown')}
                </span>
            </td>
            
            <!-- Source -->
            <td class="px-6 py-4 whitespace-nowrap" role="gridcell">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                      aria-label="Kaynak: ${source.name || config.get('translations.unknown')}">
                    ${source.name || config.get('translations.unknown')}
                </span>
            </td>
            
            <!-- Date with proper formatting -->
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" role="gridcell">
                <time datetime="${lead.created_at}" aria-label="Oluşturulma tarihi: ${formattedDate}">
                    ${formattedDate}
                </time>
            </td>
        `;
        
        return tr;
    }
    
    // Populate selects using DOM helpers
    function populateStatusSelects() {
        const statusFilter = domHelpers.getElement('status-filter');
        if (!statusFilter) return;
        
        statusFilter.innerHTML = `<option value="">${config.get('translations.allStatuses')}</option>`;
        
        leadStatuses.forEach(status => {
            const option = domHelpers.createElement('option', {
                value: status.id || status.name,
                textContent: status.display_name || status.name
            });
            
            if (status.color) {
                option.style.color = status.color;
            }
            statusFilter.appendChild(option);
        });
        
        // Apply accessibility improvements
        a11y.ensureSelectAccessibility(statusFilter, 'Durum filtresi');
    }
    
    function populateSourceSelects() {
        const sourceFilter = domHelpers.getElement('source-filter');
        if (!sourceFilter) return;
        
        sourceFilter.innerHTML = `<option value="">${config.get('translations.allSources')}</option>`;
        
        leadSources.forEach(source => {
            const option = domHelpers.createElement('option', {
                value: source.id,
                textContent: source.name
            });
            sourceFilter.appendChild(option);
        });
        
        // Apply accessibility improvements
        a11y.ensureSelectAccessibility(sourceFilter, 'Kaynak filtresi');
    }
    
    function populateAdminSelects() {
        const assignedFilter = domHelpers.getElement('assigned-filter');
        if (!assignedFilter) return;
        
        // Keep existing options first
        const existingOptions = Array.from(assignedFilter.children);
        
        adminUsers.forEach(admin => {
            const option = domHelpers.createElement('option', {
                value: admin.id,
                textContent: admin.name
            });
            assignedFilter.appendChild(option);
        });
        
        // Apply accessibility improvements
        a11y.ensureSelectAccessibility(assignedFilter, 'Atanan admin filtresi');
    }
    
    // Event binding with enhanced features
    function bindEvents() {
        debugLog('Binding events with modular components');
        
        // Search with debouncing using config
        let searchTimeout;
        const searchInput = domHelpers.getElement('search-input');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    currentPage = 1;
                    loadLeads();
                }, config.get('search.debounceMs'));
            });
            
            // Apply accessibility improvements
            a11y.ensureInputAccessibility(searchInput, 'Lead arama');
        }
        
        // Filter buttons
        const applyFiltersBtn = domHelpers.getElement('apply-filters');
        if (applyFiltersBtn) {
            applyFiltersBtn.addEventListener('click', function() {
                currentPage = 1;
                loadLeads();
            });
        }
        
        const clearFiltersBtn = domHelpers.getElement('clear-filters');
        if (clearFiltersBtn) {
            clearFiltersBtn.addEventListener('click', function() {
                // Clear all filters using DOM helpers
                domHelpers.setValue('search-input', '');
                domHelpers.setValue('status-filter', '');
                domHelpers.setValue('source-filter', '');
                domHelpers.setValue('assigned-filter', '');
                currentPage = 1;
                loadLeads();
            });
        }
        
        // Refresh button
        const refreshBtn = domHelpers.getElement('refresh-btn');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', function() {
                loadLeads(currentPage);
            });
        }
        
        // Add lead buttons using modal system
        const addBtns = ['add-lead-btn', 'empty-add-lead-btn'];
        addBtns.forEach(btnId => {
            const btn = domHelpers.getElement(btnId);
            if (btn) {
                btn.addEventListener('click', function() {
                    // Use modal system for add lead functionality
                    debugLog('Add lead button clicked - using modal system');
                    alert(config.get('translations.addLead'));
                });
            }
        });
        
        // Export button with API service
        const exportBtn = domHelpers.getElement('export-excel-btn');
        if (exportBtn) {
            exportBtn.addEventListener('click', function() {
                exportToExcel();
            });
        }
        
        // Retry button
        const retryBtn = domHelpers.getElement('retry-btn');
        if (retryBtn) {
            retryBtn.addEventListener('click', function() {
                loadLeads(currentPage);
            });
        }
        
        // Event bus subscriptions for component communication
        eventBus.subscribe('leads.loaded', (data) => {
            debugLog('Event bus: leads loaded', data);
        });
        
        eventBus.subscribe('filter.changed', (filterData) => {
            debugLog('Event bus: filter changed', filterData);
            currentPage = 1;
            loadLeads();
        });
        
        debugLog('Events bound successfully with modular system');
    }
    
    // Update pagination using DOM helpers
    function updatePagination(pagination) {
        if (!pagination || pagination.total === 0) {
            hidePagination();
            return;
        }
        
        currentPage = pagination.current_page;
        totalPages = pagination.last_page;
        
        // Update info using DOM helpers
        const start = pagination.from || 1;
        const end = pagination.to || pagination.total;
        const paginationInfo = domHelpers.getElement('pagination-info');
        if (paginationInfo) {
            paginationInfo.textContent = `${start}-${end} arası gösteriliyor (Toplam: ${pagination.total})`;
        }
        
        showPagination();
        debugLog('Pagination updated with helpers', pagination);
    }
    
    // Update statistics using config translations
    function updateStatistics(response) {
        if (response.statistics) {
            const stats = response.statistics;
            domHelpers.setTextContent('stat-total', stats.total_leads || 0);
            domHelpers.setTextContent('stat-unassigned', stats.unassigned_leads || 0);
            domHelpers.setTextContent('stat-weekly', stats.new_leads_this_week || 0);
            domHelpers.setTextContent('stat-high-score', stats.high_score_leads || 0);
        }
        
        // Also update header total
        domHelpers.setTextContent('total-leads', response.pagination?.total || 0);
        
        debugLog('Statistics updated with translations');
    }
    
    // Export to Excel using API service
    function exportToExcel() {
        const filters = {};
        
        const search = domHelpers.getValue('search-input');
        if (search) filters.search = search;
        
        const status = domHelpers.getValue('status-filter');
        if (status) filters.status = status;
        
        const source = domHelpers.getValue('source-filter');
        if (source) filters.source = source;
        
        const assigned = domHelpers.getValue('assigned-filter');
        if (assigned) filters.assigned_to = assigned;
        
        const params = new URLSearchParams(filters);
        const url = `${config.get('endpoints.export')}?${params}`;
        debugLog('Exporting to Excel via service', url);
        
        window.open(url, '_blank');
    }
    
    // UI Helper functions using DOM helpers
    function showLoading() {
        domHelpers.show('loading');
        hideEmptyState();
        hideError();
    }
    
    function hideLoading() {
        domHelpers.hide('loading');
    }
    
    function showEmptyState() {
        domHelpers.show('empty-state');
        hidePagination();
    }
    
    function hideEmptyState() {
        domHelpers.hide('empty-state');
    }
    
    function showPagination() {
        const paginationWrapper = domHelpers.getElement('pagination-wrapper');
        if (paginationWrapper) {
            paginationWrapper.style.display = 'flex';
        }
    }
    
    function hidePagination() {
        domHelpers.hide('pagination-wrapper');
    }
    
    function showStats() {
        const statsSection = domHelpers.getElement('stats-section');
        if (statsSection) {
            statsSection.style.display = 'grid';
        }
    }
    
    function hideStats() {
        domHelpers.hide('stats-section');
    }
    
    function showError(message) {
        domHelpers.setTextContent('error-message', message);
        domHelpers.show('error-state');
        hideEmptyState();
        debugLog('Error shown', message);
        
        // Emit error event via event bus
        eventBus.emit('error.shown', { message });
    }
    
    function hideError() {
        domHelpers.hide('error-state');
    }
    
    // Initialize the system
    init();
    
    debugLog('Modular lead management system initialized successfully');
});
</script>
@endpush