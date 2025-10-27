@extends('layouts.admin', ['title' => 'Lead Yönetimi'])

@section('content')
<div 
    x-data="leadsTableData()" 
    x-init="initializeTable()"
    class="min-h-screen bg-gray-50 dark:bg-gray-900"
>
    <!-- Header Section -->
    <div class="bg-white dark:bg-admin-800 border-b border-gray-200 dark:border-admin-700 shadow-sm">
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                <!-- Left: Title and Summary -->
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                        <i data-lucide="users" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Lead Yönetimi</h1>
                        <div class="flex items-center space-x-4 mt-1">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Toplam: <span x-text="totalLeads" class="font-medium text-gray-700 dark:text-gray-300"></span>
                            </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                Seçilen: <span x-text="selectedLeads.length" class="font-medium text-gray-700 dark:text-gray-300"></span>
                            </span>
                            <span 
                                x-show="filteredCount !== totalLeads"
                                class="text-sm text-blue-600 dark:text-blue-400"
                            >
                                Filtrelenen: <span x-text="filteredCount" class="font-medium"></span>
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Right: Action Buttons -->
                <div class="flex items-center space-x-3">
                    <button 
                        @click="showFilters = !showFilters"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 border border-gray-300 dark:border-admin-600 rounded-lg hover:bg-gray-50 dark:hover:bg-admin-600 transition-colors"
                        :class="{ 'bg-blue-50 dark:bg-blue-900 border-blue-300 dark:border-blue-700 text-blue-700 dark:text-blue-300': showFilters }"
                    >
                        <i data-lucide="filter" class="w-4 h-4 mr-2"></i>
                        Filtreler
                        <span 
                            x-show="getActiveFiltersCount() > 0"
                            class="ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold text-blue-800 bg-blue-200 rounded-full"
                            x-text="getActiveFiltersCount()"
                        ></span>
                    </button>
                    
                    <button 
                        @click="showColumnSettings = true"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 border border-gray-300 dark:border-admin-600 rounded-lg hover:bg-gray-50 dark:hover:bg-admin-600 transition-colors"
                    >
                        <i data-lucide="columns" class="w-4 h-4 mr-2"></i>
                        Sütunlar
                    </button>
                    
                    <div class="relative" x-data="{ showExportMenu: false }">
                        <button 
                            @click="showExportMenu = !showExportMenu"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 border border-gray-300 dark:border-admin-600 rounded-lg hover:bg-gray-50 dark:hover:bg-admin-600 transition-colors"
                        >
                            <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                            Export
                            <i data-lucide="chevron-down" class="w-4 h-4 ml-2"></i>
                        </button>
                        
                        <div 
                            x-show="showExportMenu"
                            @click.away="showExportMenu = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-admin-700 rounded-md shadow-lg border border-gray-200 dark:border-admin-600 z-10"
                        >
                            <button 
                                @click="exportToExcel(); showExportMenu = false"
                                class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-600 flex items-center"
                            >
                                <i data-lucide="file-spreadsheet" class="w-4 h-4 mr-3"></i>
                                Excel Export
                            </button>
                            <button 
                                @click="exportToCSV(); showExportMenu = false"
                                class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-600 flex items-center"
                            >
                                <i data-lucide="file-text" class="w-4 h-4 mr-3"></i>
                                CSV Export
                            </button>
                        </div>
                    </div>
                    
                    <button 
                        @click="openEditModal()"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors"
                    >
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                        Yeni Lead
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter Panel -->
    <div x-show="showFilters">
        <x-admin.leads.filters.filter-panel />
    </div>
    
    <!-- Main Content Area -->
    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-full mx-auto">
            <!-- Search Bar -->
            <div class="mb-6">
                <div class="relative max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="search" class="h-5 w-5 text-gray-400"></i>
                    </div>
                    <input 
                        type="text" 
                        x-model="searchQuery"
                        @input.debounce.300ms="searchLeads()"
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-admin-600 rounded-lg bg-white dark:bg-admin-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        placeholder="Lead ara (isim, email, telefon...)"
                    >
                    <div 
                        x-show="searchQuery"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center"
                    >
                        <button 
                            @click="clearSearch()"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                        >
                            <i data-lucide="x" class="h-4 w-4"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Loading State -->
            <div 
                x-show="loading"
                class="text-center py-12"
            >
                <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm text-blue-600 dark:text-blue-400">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Lead'ler yükleniyor...
                </div>
            </div>
            
            <!-- Main Table -->
            <div x-show="!loading" class="bg-white dark:bg-admin-800 shadow-sm rounded-lg overflow-hidden">
                <x-admin.leads.table.leads-table />
            </div>
            
            <!-- Pagination -->
            <div 
                x-show="!loading && totalPages > 1"
                class="mt-6 flex items-center justify-between"
            >
                <div class="flex-1 flex justify-between sm:hidden">
                    <button 
                        @click="previousPage()"
                        :disabled="currentPage === 1"
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-admin-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Önceki
                    </button>
                    <button 
                        @click="nextPage()"
                        :disabled="currentPage === totalPages"
                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-admin-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Sonraki
                    </button>
                </div>
                
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            <span class="font-medium" x-text="((currentPage - 1) * perPage) + 1"></span>
                            -
                            <span class="font-medium" x-text="Math.min(currentPage * perPage, totalLeads)"></span>
                            arası gösteriliyor, toplam
                            <span class="font-medium" x-text="totalLeads"></span>
                            kayıt
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                            <button 
                                @click="previousPage()"
                                :disabled="currentPage === 1"
                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-admin-600 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <i data-lucide="chevron-left" class="h-5 w-5"></i>
                            </button>
                            
                            <template x-for="page in getVisiblePages()" :key="page">
                                <button 
                                    @click="goToPage(page)"
                                    :class="{
                                        'bg-blue-50 dark:bg-blue-900 border-blue-500 dark:border-blue-600 text-blue-600 dark:text-blue-400': page === currentPage,
                                        'bg-white dark:bg-admin-700 border-gray-300 dark:border-admin-600 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-admin-600': page !== currentPage
                                    }"
                                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                                    x-text="page"
                                ></button>
                            </template>
                            
                            <button 
                                @click="nextPage()"
                                :disabled="currentPage === totalPages"
                                class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-admin-600 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <i data-lucide="chevron-right" class="h-5 w-5"></i>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
            
            <!-- Empty State -->
            <div 
                x-show="!loading && leads.length === 0"
                class="text-center py-12 bg-white dark:bg-admin-800 rounded-lg shadow-sm"
            >
                <div class="max-w-md mx-auto">
                    <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 dark:bg-admin-700 rounded-full flex items-center justify-center">
                        <i data-lucide="users" class="w-10 h-10 text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                        <span x-show="searchQuery || getActiveFiltersCount() > 0">Arama kriterlerine uygun lead bulunamadı</span>
                        <span x-show="!searchQuery && getActiveFiltersCount() === 0">Henüz lead eklenmemiş</span>
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">
                        <span x-show="searchQuery || getActiveFiltersCount() > 0">Farklı kriterlerle tekrar deneyin</span>
                        <span x-show="!searchQuery && getActiveFiltersCount() === 0">İlk lead'inizi ekleyin ve yönetmeye başlayın</span>
                    </p>
                    <div class="flex justify-center space-x-3">
                        <button 
                            x-show="searchQuery || getActiveFiltersCount() > 0"
                            @click="clearAllFilters(); clearSearch()"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 border border-gray-300 dark:border-admin-600 rounded-lg hover:bg-gray-50 dark:hover:bg-admin-600"
                        >
                            <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i>
                            Filtreleri Temizle
                        </button>
                        <button 
                            @click="openEditModal()"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg"
                        >
                            <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                            Yeni Lead Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Components -->
    <div x-show="showColumnSettings">
        <x-admin.leads.table.column-toggle />
    </div>
    
    <div x-show="selectedLeads.length > 0">
        <x-admin.leads.actions.bulk-actions />
    </div>
    
    <div x-show="showLeadModal">
        <x-admin.leads.modals.lead-detail-modal />
    </div>
    
    <div x-show="showEditModal">
        <x-admin.leads.modals.lead-edit-modal />
    </div>
    
    <!-- Notification System -->
    <div 
        x-show="notification?.show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="transform opacity-0 translate-y-2"
        x-transition:enter-end="transform opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="transform opacity-100 translate-y-0"
        x-transition:leave-end="transform opacity-0 translate-y-2"
        class="fixed top-4 right-4 z-50"
        style="display: none;"
    >
        <div 
            class="rounded-lg shadow-lg p-4 max-w-sm w-full"
            :class="{
                'bg-green-100 border-green-500 text-green-700': notification?.type === 'success',
                'bg-red-100 border-red-500 text-red-700': notification?.type === 'error',
                'bg-yellow-100 border-yellow-500 text-yellow-700': notification?.type === 'warning',
                'bg-blue-100 border-blue-500 text-blue-700': notification?.type === 'info'
            }"
        >
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i
                        :data-lucide="notification?.type === 'success' ? 'check-circle' : notification?.type === 'error' ? 'alert-circle' : notification?.type === 'warning' ? 'alert-triangle' : 'info'"
                        class="h-5 w-5"
                    ></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium" x-text="notification?.message"></p>
                </div>
                <div class="ml-3 flex-shrink-0">
                    <button 
                        @click="notification.show = false"
                        class="inline-flex text-gray-400 hover:text-gray-600"
                    >
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@pushOnce('styles')
<link href="{{ asset('css/admin/leads-table.css') }}" rel="stylesheet">
@endPushOnce

@pushOnce('scripts')
<!-- Load Alpine.js data function first -->
<script src="{{ asset('js/admin/leads/alpine-data.js') }}"></script>
<!-- Load JavaScript modules -->
<script src="{{ asset('js/admin/leads/index.js') }}" type="module"></script>
@endPushOnce
@endsection