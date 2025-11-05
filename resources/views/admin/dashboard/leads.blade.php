@extends('layouts.admin')

@section('title', 'Lead Yönetimi')

@section('page_title', 'Lead Yönetimi')
@section('page_subtitle', 'Müşteri adaylarınızı yönetin ve takip edin')

@push('styles')
<style>
    /* Custom CSS for Lead Management - Minimal additions to Tailwind */
    .lead-score-badge {
        @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
    }
    .lead-score-high { @apply bg-red-100 text-red-800; }
    .lead-score-medium { @apply bg-yellow-100 text-yellow-800; }
    .lead-score-low { @apply bg-gray-100 text-gray-800; }
    
    .data-table-container {
        @apply bg-white shadow-sm rounded-lg border border-gray-200;
    }
    
    .lead-actions-dropdown {
        @apply absolute right-0 z-10 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none;
    }
    
    .lead-status-badge {
        @apply inline-flex items-center px-2 py-1 rounded-full text-xs font-medium;
    }
    
    .virtual-scroll-container {
        @apply overflow-y-auto;
        height: calc(100vh - 300px);
    }
    
    .filter-panel {
        @apply bg-gray-50 border-b border-gray-200 p-4;
    }
    
    .loading-spinner {
        @apply animate-spin h-4 w-4 text-blue-600;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header Section with Stats Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Total Leads -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Toplam Lead</dt>
                            <dd id="total-leads-count" class="text-lg font-medium text-gray-900">-</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Leads Today -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Bugün Yeni</dt>
                            <dd id="new-leads-today" class="text-lg font-medium text-gray-900">-</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- High Score Leads -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Sıcak Lead</dt>
                            <dd id="hot-leads-count" class="text-lg font-medium text-gray-900">-</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Follow-ups Today -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Bugün Takip</dt>
                            <dd id="followups-today" class="text-lg font-medium text-gray-900">-</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="data-table-container">
        <!-- Filter Panel -->
        <div class="filter-panel">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="col-span-1 md:col-span-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input id="lead-search-input" type="text" placeholder="Lead ara... (isim, email, telefon)" 
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <select id="status-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Tüm Durumlar</option>
                    </select>
                </div>

                <!-- Assigned Admin Filter -->
                <div>
                    <select id="assigned-filter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Tüm Adminler</option>
                        <option value="unassigned">Atanmamış</option>
                    </select>
                </div>
            </div>

            <!-- Advanced Filters (Collapsible) -->
            <div id="advanced-filters" class="mt-4 hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <!-- Date Range -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Başlangıç Tarihi</label>
                        <input id="date-from" type="date" class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Bitiş Tarihi</label>
                        <input id="date-to" type="date" class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <!-- Priority Filter -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Öncelik</label>
                        <select id="priority-filter" class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Tümü</option>
                            <option value="urgent">Acil</option>
                            <option value="high">Yüksek</option>
                            <option value="medium">Orta</option>
                            <option value="low">Düşük</option>
                        </select>
                    </div>
                    
                    <!-- Score Range -->
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Min Skor</label>
                        <input id="min-score" type="number" min="0" max="100" placeholder="0" 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Max Skor</label>
                        <input id="max-score" type="number" min="0" max="100" placeholder="100" 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Filter Actions -->
            <div class="mt-4 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <button id="toggle-advanced-filters" type="button" 
                            class="text-sm text-blue-600 hover:text-blue-500 focus:outline-none focus:underline">
                        Gelişmiş Filtreler
                    </button>
                    <button id="clear-filters" type="button" 
                            class="text-sm text-gray-500 hover:text-gray-700 focus:outline-none focus:underline">
                        Filtreleri Temizle
                    </button>
                </div>
                <div class="flex items-center space-x-2">
                    <!-- Bulk Actions -->
                    <div class="relative">
                        <button id="bulk-actions-btn" type="button" 
                                class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" 
                                disabled>
                            <span id="bulk-actions-text">Toplu İşlemler</span>
                            <svg class="-mr-1 ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="bulk-actions-menu" class="lead-actions-dropdown hidden">
                            <div class="py-1" role="menu">
                                <button id="bulk-assign-btn" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left" role="menuitem">Toplu Atama</button>
                                <button id="bulk-status-btn" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left" role="menuitem">Durum Güncelle</button>
                                <button id="bulk-export-btn" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left" role="menuitem">Export Et</button>
                                <button id="bulk-delete-btn" class="block px-4 py-2 text-sm text-red-700 hover:bg-red-50 w-full text-left" role="menuitem">Sil</button>
                            </div>
                        </div>
                    </div>

                    <!-- Add New Lead -->
                    <button id="add-lead-btn" type="button" 
                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Yeni Lead
                    </button>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="virtual-scroll-container">
            <!-- Table Header (Sticky) -->
            <div class="sticky top-0 bg-gray-50 border-b border-gray-200 z-10">
                <div class="grid grid-cols-12 gap-4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <div class="col-span-1">
                        <input id="select-all-leads" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    </div>
                    <div class="col-span-2 cursor-pointer hover:text-gray-700" data-sort="name">
                        <span>Ad Soyad</span>
                        <svg class="inline w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                        </svg>
                    </div>
                    <div class="col-span-2 cursor-pointer hover:text-gray-700" data-sort="email">
                        <span>Email</span>
                        <svg class="inline w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                        </svg>
                    </div>
                    <div class="col-span-1 cursor-pointer hover:text-gray-700" data-sort="phone">
                        <span>Telefon</span>
                        <svg class="inline w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                        </svg>
                    </div>
                    <div class="col-span-1 cursor-pointer hover:text-gray-700" data-sort="lead_score">
                        <span>Skor</span>
                        <svg class="inline w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                        </svg>
                    </div>
                    <div class="col-span-2 cursor-pointer hover:text-gray-700" data-sort="lead_status">
                        <span>Durum</span>
                        <svg class="inline w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                        </svg>
                    </div>
                    <div class="col-span-2 cursor-pointer hover:text-gray-700" data-sort="assign_to">
                        <span>Atanmış</span>
                        <svg class="inline w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                        </svg>
                    </div>
                    <div class="col-span-1">
                        <span>İşlemler</span>
                    </div>
                </div>
            </div>

            <!-- Table Body -->
            <div id="leads-table-body" class="divide-y divide-gray-200">
                <!-- Loading Placeholder -->
                <div id="loading-placeholder" class="px-6 py-4 text-center">
                    <svg class="loading-spinner mx-auto" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Lead'ler yükleniyor...</p>
                </div>

                <!-- No Data Placeholder -->
                <div id="no-data-placeholder" class="px-6 py-12 text-center hidden">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Hiç lead bulunamadı</h3>
                    <p class="mt-1 text-sm text-gray-500">Yeni bir lead ekleyerek başlayın.</p>
                    <div class="mt-6">
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            İlk Lead'i Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div id="pagination-container" class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    <button id="prev-mobile" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Önceki
                    </button>
                    <button id="next-mobile" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Sonraki
                    </button>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            <span id="pagination-info">Toplam 0 kayıttan 0-0 arası gösteriliyor</span>
                        </p>
                    </div>
                    <div>
                        <nav id="pagination-nav" class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <!-- Pagination will be generated by JavaScript -->
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lead Detail Modal -->
<div id="lead-detail-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full sm:p-6">
            <div>
                <div class="flex items-start justify-between">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Lead Detayları
                    </h3>
                    <button id="close-modal" type="button" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <span class="sr-only">Kapat</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div id="modal-content" class="mt-4">
                    <!-- Modal content will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Lead Modal -->
<div id="add-edit-lead-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="add-edit-modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-6">
            <form id="add-edit-lead-form">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="add-edit-modal-title">
                        Yeni Lead Ekle
                    </h3>
                    <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Form fields will be populated by JavaScript -->
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:col-start-2 sm:text-sm">
                        Kaydet
                    </button>
                    <button id="cancel-add-edit" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                        İptal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- CSRF Token for Ajax Requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Lead Management Configuration -->
<script>
    window.MonexaLeadConfig = {
        csrfToken: '{{ csrf_token() }}',
        apiEndpoints: {
            leads: '{{ route('admin.leads.api') }}',
            statuses: '{{ route('admin.leads.api.statuses') }}',
            assignableAdmins: '{{ route('admin.leads.api.assignable-admins') }}',
            leadDetail: '{{ route('admin.leads.api.detail', ['lead' => '__ID__']) }}',
            leadStore: '{{ route('admin.leads.api.store') }}',
            leadUpdate: '{{ route('admin.leads.api.update', ['lead' => '__ID__']) }}',
            leadDelete: '{{ route('admin.leads.api.delete', ['lead' => '__ID__']) }}',
            bulkActions: '{{ route('admin.leads.api.bulk-actions') }}'
        },
        locale: 'tr-TR',
        timezone: 'Europe/Istanbul',
        pagination: {
            perPage: 25,
            maxPageButtons: 5
        },
        virtualScroll: {
            itemHeight: 60,
            bufferSize: 5,
            threshold: 1000
        },
        debounce: {
            search: 300,
            filter: 150
        },
        features: {
            virtualScrolling: true,
            bulkActions: true,
            advancedFiltering: true,
            exportOptions: true,
            realTimeUpdates: false
        }
    };
</script>

<!-- ES6 Modules: Load in dependency order -->
<script type="module">
    // Import utilities first
    import { domHelpers } from '/js/admin/leads/utils/DomHelpers.js';
    import { dateUtils } from '/js/admin/leads/utils/DateUtils.js';
    import { a11y } from '/js/admin/leads/utils/AccessibilityHelpers.js';

    // Import core modules
    import { Config } from '/js/admin/leads/core/Config.js';
    import { EventBus } from '/js/admin/leads/core/EventBus.js';
    
    // Import services
    import { ApiService } from '/js/admin/leads/services/ApiService.js';
    import { CacheService } from '/js/admin/leads/services/CacheService.js';
    import { ValidationService } from '/js/admin/leads/services/ValidationService.js';
    
    // Import components
    import { DataTable } from '/js/admin/leads/components/DataTable.js';
    import { FilterPanel } from '/js/admin/leads/components/FilterPanel.js';
    import { ModalSystem } from '/js/admin/leads/components/ModalSystem.js';
    import { BulkActions } from '/js/admin/leads/components/BulkActions.js';
    
    // Import main application
    import { App } from '/js/admin/leads/core/App.js';

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', async () => {
        try {
            // Global access for debugging and external integrations
            window.MonexaLead = {
                // Core instances
                app: null,
                eventBus: null,
                
                // Services
                api: null,
                cache: null,
                validator: null,
                
                // Components
                dataTable: null,
                filterPanel: null,
                modalSystem: null,
                bulkActions: null,
                
                // Utilities
                domHelpers,
                dateUtils,
                a11y,
                
                // Helper functions
                helpers: {
                    refreshData: () => window.MonexaLead.app?.loadLeads(),
                    getSelectedLeads: () => window.MonexaLead.dataTable?.getSelectedRows() || [],
                    clearSelection: () => window.MonexaLead.dataTable?.clearSelection(),
                    showNotification: (message, type = 'info') => {
                        // Integration point for notification system
                        console.log(`[${type.toUpperCase()}] ${message}`);
                    },
                    exportData: (format = 'csv') => window.MonexaLead.bulkActions?.exportSelected(format),
                    validateForm: (formData) => window.MonexaLead.validator?.validateLeadForm(formData)
                }
            };
            
            // Initialize main application
            const app = new App();
            await app.initialize();
            
            // Store app instance globally
            window.MonexaLead.app = app;
            window.MonexaLead.eventBus = app.eventBus;
            window.MonexaLead.api = app.api;
            window.MonexaLead.cache = app.cache;
            window.MonexaLead.validator = app.validator;
            window.MonexaLead.dataTable = app.dataTable;
            window.MonexaLead.filterPanel = app.filterPanel;
            window.MonexaLead.modalSystem = app.modalSystem;
            window.MonexaLead.bulkActions = app.bulkActions;
            
            // Announce successful initialization to screen readers
            a11y.announce('Lead yönetim sistemi başarıyla yüklendi', 'polite');
            
            console.log('✅ Monexa Lead Management System initialized successfully');
            
        } catch (error) {
            console.error('❌ Failed to initialize Monexa Lead Management System:', error);
            
            // Show fallback error message
            const errorContainer = document.createElement('div');
            errorContainer.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50';
            errorContainer.innerHTML = `
                <strong class="font-bold">Hata!</strong>
                <span class="block sm:inline">Lead yönetim sistemi yüklenemedi. Lütfen sayfayı yenileyin.</span>
                <button onclick="location.reload()" class="ml-4 bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                    Yenile
                </button>
            `;
            document.body.appendChild(errorContainer);
            
            // Announce error to screen readers
            a11y.announce('Lead yönetim sistemi yüklenirken hata oluştu', 'assertive');
            
            // Remove error after 10 seconds
            setTimeout(() => {
                errorContainer.remove();
            }, 10000);
        }
    });

    // Handle page visibility changes (performance optimization)
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            // Pause any animations or periodic updates
            window.MonexaLead.app?.pause();
        } else {
            // Resume operations
            window.MonexaLead.app?.resume();
        }
    });

    // Handle before unload (cleanup)
    window.addEventListener('beforeunload', () => {
        window.MonexaLead.app?.destroy();
    });
</script>

<!-- Legacy Support for Non-Module Browsers -->
<script nomodule>
    document.addEventListener('DOMContentLoaded', () => {
        const errorContainer = document.createElement('div');
        errorContainer.className = 'fixed top-4 right-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded z-50';
        errorContainer.innerHTML = `
            <strong class="font-bold">Uyarı!</strong>
            <span class="block sm:inline">Tarayıcınız modern JavaScript özelliklerini desteklemiyor. Lütfen tarayıcınızı güncelleyin.</span>
        `;
        document.body.appendChild(errorContainer);
    });
</script>
@endpush

@push('meta')
<meta name="description" content="Monexa Finance CRM - Lead Yönetimi Paneli. Müşteri adaylarınızı etkili bir şekilde yönetin ve takip edin.">
<meta name="keywords" content="lead management, CRM, müşteri adayları, fintech, monexa">
<meta property="og:title" content="Lead Yönetimi - Monexa Finance">
<meta property="og:description" content="Müşteri adaylarınızı profesyonel CRM sistemi ile yönetin">
<meta property="og:type" content="website">

<!-- Preload critical resources -->
<link rel="preload" href="{{ route('admin.leads.api') }}" as="fetch">
@endpush