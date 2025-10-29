<div class="leads-table-container">
    
    <!-- Table Wrapper -->
    <div class="table-wrapper bg-white dark:bg-admin-800 rounded-xl shadow-lg border border-gray-200 dark:border-admin-700 overflow-hidden">
        <!-- Modern Table Header Info -->
        <div class="px-6 py-5 border-b border-gray-200 dark:border-admin-700 bg-gradient-to-r from-gray-50 to-white dark:from-admin-900 dark:to-admin-800">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                        <i data-lucide="users" class="w-6 h-6 mr-3 text-blue-600"></i>
                        Lead Yönetimi
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" 
                       x-text="`Toplam ${pagination.total || 0} lead kayıt`"></p>
                </div>
                
                <div class="flex items-center space-x-3">
                    <!-- Column Settings -->
                    <div class="relative" x-data="{ showColumnSettings: false }">
                        <button 
                            @click="showColumnSettings = !showColumnSettings"
                            @click.outside="showColumnSettings = false"
                            class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 border border-gray-300 dark:border-admin-600 rounded-lg hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                            <i data-lucide="columns" class="w-4 h-4 mr-2"></i>
                            Sütunlar
                            <i data-lucide="chevron-down" class="w-4 h-4 ml-2 transition-transform duration-200" 
                               :class="{'rotate-180': showColumnSettings}"></i>
                        </button>
                        
                        <!-- Column Settings Dropdown -->
                        <div x-show="showColumnSettings"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 z-50 mt-2 w-64 bg-white dark:bg-admin-800 rounded-lg shadow-lg border border-gray-200 dark:border-admin-600 py-2"
                             style="display: none;">
                            <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-admin-600">
                                Görünür Sütunlar
                            </div>
                            
                            <div class="p-2 space-y-1">
                                <label class="flex items-center px-2 py-1 hover:bg-gray-50 dark:hover:bg-admin-700 rounded cursor-pointer">
                                    <input type="checkbox" checked disabled class="rounded border-gray-300 text-blue-600 mr-3">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Ülke</span>
                                </label>
                                <label class="flex items-center px-2 py-1 hover:bg-gray-50 dark:hover:bg-admin-700 rounded cursor-pointer">
                                    <input type="checkbox" checked disabled class="rounded border-gray-300 text-blue-600 mr-3">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Ad Soyad</span>
                                </label>
                                <label class="flex items-center px-2 py-1 hover:bg-gray-50 dark:hover:bg-admin-700 rounded cursor-pointer">
                                    <input type="checkbox" checked disabled class="rounded border-gray-300 text-blue-600 mr-3">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Telefon</span>
                                </label>
                                <label class="flex items-center px-2 py-1 hover:bg-gray-50 dark:hover:bg-admin-700 rounded cursor-pointer">
                                    <input type="checkbox" checked disabled class="rounded border-gray-300 text-blue-600 mr-3">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Email</span>
                                </label>
                                <label class="flex items-center px-2 py-1 hover:bg-gray-50 dark:hover:bg-admin-700 rounded cursor-pointer">
                                    <input type="checkbox" checked disabled class="rounded border-gray-300 text-blue-600 mr-3">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Assigned</span>
                                </label>
                                <label class="flex items-center px-2 py-1 hover:bg-gray-50 dark:hover:bg-admin-700 rounded cursor-pointer">
                                    <input type="checkbox" checked disabled class="rounded border-gray-300 text-blue-600 mr-3">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Status</span>
                                </label>
                                <label class="flex items-center px-2 py-1 hover:bg-gray-50 dark:hover:bg-admin-700 rounded cursor-pointer">
                                    <input type="checkbox" checked disabled class="rounded border-gray-300 text-blue-600 mr-3">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Varonka</span>
                                </label>
                                <label class="flex items-center px-2 py-1 hover:bg-gray-50 dark:hover:bg-admin-700 rounded cursor-pointer">
                                    <input type="checkbox" checked disabled class="rounded border-gray-300 text-blue-600 mr-3">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Kaynak</span>
                                </label>
                                <label class="flex items-center px-2 py-1 hover:bg-gray-50 dark:hover:bg-admin-700 rounded cursor-pointer">
                                    <input type="checkbox" checked disabled class="rounded border-gray-300 text-blue-600 mr-3">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Şirket</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Export Button -->
                    @can('export_leads')
                    <button 
                        @click="exportLeads()"
                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white text-sm font-medium rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 shadow-lg">
                        <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                        Export
                    </button>
                    @endcan
                    
                    <!-- Refresh Button -->
                    <button 
                        @click="refreshLeads()"
                        class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 border border-gray-300 dark:border-admin-600 rounded-lg hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                        <i data-lucide="refresh-cw" class="w-4 h-4" :class="{'animate-spin': loading}"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Loading Indicator -->
        <div x-show="loading" class="flex flex-col items-center justify-center py-16 bg-gray-50 dark:bg-admin-900/50">
            <div class="relative">
                <div class="w-16 h-16 border-4 border-blue-200 dark:border-blue-900 rounded-full animate-pulse"></div>
                <div class="absolute inset-0 w-16 h-16 border-4 border-transparent border-t-blue-600 rounded-full animate-spin"></div>
            </div>
            <div class="mt-4 text-center">
                <p class="text-lg font-medium text-gray-900 dark:text-white">Yükleniyor...</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Leads verisi getiriliyor</p>
            </div>
        </div>
        
        <!-- Table Content -->
        <div x-show="!loading" class="overflow-x-auto bg-white dark:bg-admin-800">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-admin-700 table-fixed">
                <!-- Table Header -->
                <x-admin.leads.table.table-header />
                
                <!-- Table Body -->
                <tbody id="leads-table-body" class="bg-white dark:bg-admin-800 divide-y divide-gray-200 dark:divide-admin-700">
                    <template x-for="lead in leads" :key="lead.id">
                        <x-admin.leads.table.table-row :lead="lead" :statuses="$statuses" :agents="$agents" />
                    </template>
                </tbody>
            </table>
        </div>
        
        <!-- Empty State -->
        <div x-show="!loading && leads.length === 0" class="text-center py-16 bg-gray-50 dark:bg-admin-900/50">
            <div class="mx-auto w-24 h-24 bg-gray-200 dark:bg-admin-700 rounded-full flex items-center justify-center mb-6">
                <i data-lucide="users" class="w-12 h-12 text-gray-400 dark:text-gray-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Lead bulunamadı</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-md mx-auto">
                Aradığınız kriterlere uygun lead bulunamadı. Filtreleri değiştirmeyi deneyin veya yeni bir lead ekleyin.
            </p>
            <button 
                @click="clearFilters()"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                <i data-lucide="filter-x" class="w-4 h-4 mr-2"></i>
                Filtreleri Temizle
            </button>
        </div>
        
        <!-- Selected Actions Bar -->
        <div id="bulk-actions" x-show="selectedLeads.length > 0" 
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 translate-y-2"
             x-transition:enter-end="transform opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 translate-y-0"
             x-transition:leave-end="transform opacity-0 translate-y-2"
             class="border-t border-gray-200 dark:border-admin-700 bg-blue-50 dark:bg-blue-900/20 px-6 py-4"
             style="display: none;">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i data-lucide="check-circle" class="w-5 h-5 text-blue-600 mr-2"></i>
                    <span class="text-sm font-medium text-blue-900 dark:text-blue-100">
                        <span id="selected-count" x-text="selectedLeads.length"></span> lead seçildi
                    </span>
                </div>
                
                <div class="flex items-center space-x-3">
                    <button 
                        @click="bulkAssign()"
                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-700 bg-blue-100 hover:bg-blue-200 rounded-lg transition-colors">
                        <i data-lucide="user-plus" class="w-4 h-4 mr-1"></i>
                        Toplu Atama
                    </button>
                    
                    <button 
                        @click="bulkStatusUpdate()"
                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-green-700 bg-green-100 hover:bg-green-200 rounded-lg transition-colors">
                        <i data-lucide="edit" class="w-4 h-4 mr-1"></i>
                        Durumu Değiştir
                    </button>
                    
                    <button 
                        @click="bulkDelete()"
                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-700 bg-red-100 hover:bg-red-200 rounded-lg transition-colors">
                        <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                        Sil
                    </button>
                    
                    <button 
                        @click="selectedLeads = []"
                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        <i data-lucide="x" class="w-4 h-4 mr-1"></i>
                        Seçimi Temizle
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modern Pagination -->
    <div x-show="pagination.total > 0" class="mt-6">
        <div class="bg-white dark:bg-admin-800 rounded-xl shadow-lg border border-gray-200 dark:border-admin-700 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white dark:from-admin-900 dark:to-admin-800 border-b border-gray-200 dark:border-admin-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            <span class="font-medium" x-text="pagination.from || 0"></span>
                            -
                            <span class="font-medium" x-text="pagination.to || 0"></span>
                            /
                            <span class="font-semibold text-blue-600" x-text="pagination.total || 0"></span>
                            kayıt gösteriliyor
                        </div>
                        
                        <!-- Per Page Selector -->
                        <div class="flex items-center space-x-2">
                            <label class="text-sm text-gray-600 dark:text-gray-400">Sayfa başına:</label>
                            <select @change="changePerPage($event.target.value)" 
                                    class="text-sm border border-gray-300 dark:border-admin-600 rounded-lg px-2 py-1 bg-white dark:bg-admin-700 text-gray-700 dark:text-gray-300">
                                <option value="10">10</option>
                                <option value="25" selected>25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-1">
                        <!-- First Page -->
                        <button 
                            @click="goToPage(1)"
                            :disabled="pagination.current_page <= 1"
                            class="p-2 text-sm border border-gray-300 dark:border-admin-600 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-admin-700 dark:text-white transition-colors">
                            <i data-lucide="chevrons-left" class="w-4 h-4"></i>
                        </button>
                        
                        <!-- Previous Page -->
                        <button 
                            @click="goToPage(pagination.current_page - 1)"
                            :disabled="pagination.current_page <= 1"
                            class="px-3 py-2 text-sm border border-gray-300 dark:border-admin-600 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-admin-700 dark:text-white transition-colors">
                            <i data-lucide="chevron-left" class="w-4 h-4 mr-1"></i>
                            Önceki
                        </button>
                        
                        <!-- Page Numbers -->
                        <template x-for="page in getVisiblePages()" :key="page">
                            <button 
                                @click="goToPage(page)"
                                :class="{
                                    'bg-blue-600 text-white border-blue-600 shadow-lg': page === pagination.current_page,
                                    'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-admin-700 border-gray-300 dark:border-admin-600': page !== pagination.current_page
                                }"
                                class="px-4 py-2 text-sm border rounded-lg font-medium transition-all duration-200 transform hover:scale-105"
                                x-text="page">
                            </button>
                        </template>
                        
                        <!-- Next Page -->
                        <button 
                            @click="goToPage(pagination.current_page + 1)"
                            :disabled="pagination.current_page >= pagination.last_page"
                            class="px-3 py-2 text-sm border border-gray-300 dark:border-admin-600 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-admin-700 dark:text-white transition-colors">
                            Sonraki
                            <i data-lucide="chevron-right" class="w-4 h-4 ml-1"></i>
                        </button>
                        
                        <!-- Last Page -->
                        <button 
                            @click="goToPage(pagination.last_page)"
                            :disabled="pagination.current_page >= pagination.last_page"
                            class="p-2 text-sm border border-gray-300 dark:border-admin-600 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-admin-700 dark:text-white transition-colors">
                            <i data-lucide="chevrons-right" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@pushOnce('styles')
<style>
/* Modern Table Container Styling */
.leads-table-container {
    position: relative;
}

.table-wrapper {
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.95);
}

.dark .table-wrapper {
    background: rgba(31, 41, 55, 0.95);
}

/* Enhanced table styling */
.table-fixed {
    table-layout: fixed;
}

.table-fixed th,
.table-fixed td {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Bulk actions bar animation */
#bulk-actions {
    backdrop-filter: blur(8px);
    background: rgba(239, 246, 255, 0.9);
}

.dark #bulk-actions {
    background: rgba(30, 58, 138, 0.2);
}

/* Loading animation enhancements */
.loading-spinner {
    position: relative;
    width: 4rem;
    height: 4rem;
}

.loading-spinner::before {
    content: '';
    position: absolute;
    inset: 0;
    border: 4px solid #e5e7eb;
    border-radius: 50%;
    animation: pulse 1.5s ease-in-out infinite;
}

.loading-spinner::after {
    content: '';
    position: absolute;
    inset: 0;
    border: 4px solid transparent;
    border-top-color: #3b82f6;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

/* Empty state enhancements */
.empty-state-icon {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
}

.dark .empty-state-icon {
    background: linear-gradient(135deg, #374151 0%, #4b5563 100%);
}

/* Pagination enhancements */
.pagination-container {
    backdrop-filter: blur(10px);
}

/* Column settings dropdown */
.column-settings-dropdown {
    max-height: 20rem;
    overflow-y: auto;
}

.column-settings-dropdown::-webkit-scrollbar {
    width: 6px;
}

.column-settings-dropdown::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.column-settings-dropdown::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.column-settings-dropdown::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Dark mode scrollbar */
.dark .column-settings-dropdown::-webkit-scrollbar-track {
    background: #374151;
}

.dark .column-settings-dropdown::-webkit-scrollbar-thumb {
    background: #6b7280;
}

.dark .column-settings-dropdown::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}

/* Button hover effects */
button {
    position: relative;
    overflow: hidden;
}

button::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
    transform: translateX(-100%);
    transition: transform 0.6s;
    pointer-events: none;
}

button:hover::before {
    transform: translateX(100%);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .leads-table-container {
        padding: 0 1rem;
    }
    
    .table-wrapper {
        border-radius: 0.5rem;
        margin: 0 -1rem;
    }
    
    .pagination-container {
        flex-direction: column;
        gap: 1rem;
    }
    
    .pagination-controls {
        justify-content: center;
    }
}

/* Animation keyframes */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideIn {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.1); }
}

/* Focus states */
button:focus,
select:focus,
input:focus {
    outline: none;
    ring: 2px;
    ring-color: #3b82f6;
    ring-offset: 2px;
}

/* Success states */
.success-animation {
    animation: slideIn 0.3s ease-out;
}

/* Modern shadows */
.shadow-modern {
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.shadow-modern-lg {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.05);
}
</style>
@endPushOnce

@pushOnce('scripts')
<script>
// Modern leads table functionality
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced pagination functionality
    function getVisiblePages() {
        const current = pagination.current_page;
        const total = pagination.last_page;
        const delta = 2; // Number of pages to show on each side
        
        let pages = [];
        
        // Always show first page
        pages.push(1);
        
        // Add dots if needed
        if (current - delta > 2) {
            pages.push('...');
        }
        
        // Add pages around current
        for (let i = Math.max(2, current - delta); i <= Math.min(total - 1, current + delta); i++) {
            pages.push(i);
        }
        
        // Add dots if needed
        if (current + delta < total - 1) {
            pages.push('...');
        }
        
        // Always show last page if there's more than one page
        if (total > 1) {
            pages.push(total);
        }
        
        return pages;
    }
    
    // Make function globally available
    window.getVisiblePages = getVisiblePages;
    
    // Enhanced loading states
    function showLoading(message = 'Yükleniyor...') {
        const loadingText = document.querySelector('.loading-message');
        if (loadingText) {
            loadingText.textContent = message;
        }
    }
    
    // Enhanced refresh functionality
    function refreshLeads() {
        showLoading('Veriler yenileniyor...');
        // Trigger refresh event
        window.dispatchEvent(new CustomEvent('refresh-leads'));
    }
    
    // Clear filters functionality
    function clearFilters() {
        // Reset all filters
        const filterInputs = document.querySelectorAll('.filter-input');
        filterInputs.forEach(input => {
            if (input.type === 'checkbox' || input.type === 'radio') {
                input.checked = false;
            } else {
                input.value = '';
            }
        });
        
        // Trigger filter clear event
        window.dispatchEvent(new CustomEvent('clear-filters'));
        
        // Show notification
        showNotification('Filtreler temizlendi', 'info');
    }
    
    // Per page change functionality
    function changePerPage(value) {
        // Update pagination
        pagination.per_page = parseInt(value);
        pagination.current_page = 1;
        
        // Trigger data reload
        window.dispatchEvent(new CustomEvent('per-page-changed', {
            detail: { perPage: value }
        }));
        
        showNotification(`Sayfa başına ${value} kayıt gösteriliyor`, 'info');
    }
    
    // Bulk action functions
    function bulkAssign() {
        const selectedCount = selectedLeads.length;
        if (selectedCount === 0) {
            showNotification('Lütfen atamak için lead seçin', 'warning');
            return;
        }
        
        // Show assignment modal or dropdown
        window.dispatchEvent(new CustomEvent('bulk-assign', {
            detail: { leadIds: selectedLeads }
        }));
    }
    
    function bulkStatusUpdate() {
        const selectedCount = selectedLeads.length;
        if (selectedCount === 0) {
            showNotification('Lütfen durum değiştirmek için lead seçin', 'warning');
            return;
        }
        
        // Show status update modal
        window.dispatchEvent(new CustomEvent('bulk-status-update', {
            detail: { leadIds: selectedLeads }
        }));
    }
    
    function bulkDelete() {
        const selectedCount = selectedLeads.length;
        if (selectedCount === 0) {
            showNotification('Lütfen silmek için lead seçin', 'warning');
            return;
        }
        
        if (confirm(`Seçilen ${selectedCount} lead'i silmek istediğinizden emin misiniz?`)) {
            // Trigger bulk delete
            window.dispatchEvent(new CustomEvent('bulk-delete', {
                detail: { leadIds: selectedLeads }
            }));
        }
    }
    
    // Export functionality enhancement
    function exportLeads() {
        showLoading('Export hazırlanıyor...');
        
        // Create form data with current filters
        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        
        // Add filter parameters if any
        const currentFilters = getCurrentFilters();
        Object.keys(currentFilters).forEach(key => {
            if (currentFilters[key]) {
                formData.append(key, currentFilters[key]);
            }
        });
        
        // Submit export request
        fetch('/admin/leads/export', {
            method: 'POST',
            body: formData
        })
        .then(response => response.blob())
        .then(blob => {
            // Download file
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = `leads_export_${new Date().toISOString().split('T')[0]}.xlsx`;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            
            showNotification('Export başarıyla tamamlandı', 'success');
        })
        .catch(error => {
            console.error('Export hatası:', error);
            showNotification('Export sırasında hata oluştu', 'error');
        });
    }
    
    // Get current filters helper
    function getCurrentFilters() {
        const filters = {};
        
        // Collect filter values from DOM
        document.querySelectorAll('.filter-input').forEach(input => {
            if (input.value && input.value !== '') {
                filters[input.name] = input.value;
            }
        });
        
        return filters;
    }
    
    // Make functions globally available
    window.refreshLeads = refreshLeads;
    window.clearFilters = clearFilters;
    window.changePerPage = changePerPage;
    window.bulkAssign = bulkAssign;
    window.bulkStatusUpdate = bulkStatusUpdate;
    window.bulkDelete = bulkDelete;
    window.exportLeads = exportLeads;
    
    // Initialize tooltips and other UI enhancements
    initializeTableEnhancements();
});

// Initialize additional table enhancements
function initializeTableEnhancements() {
    // Add loading state management
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'attributes' && mutation.attributeName === 'x-show') {
                const target = mutation.target;
                if (target.classList.contains('loading-indicator')) {
                    // Handle loading state changes
                    if (target.style.display !== 'none') {
                        document.body.style.cursor = 'wait';
                    } else {
                        document.body.style.cursor = 'default';
                    }
                }
            }
        });
    });
    
    // Start observing
    const loadingIndicator = document.querySelector('.loading-indicator');
    if (loadingIndicator) {
        observer.observe(loadingIndicator, { attributes: true });
    }
    
    // Add keyboard shortcuts
    document.addEventListener('keydown', function(event) {
        // Ctrl/Cmd + R for refresh
        if ((event.ctrlKey || event.metaKey) && event.key === 'r') {
            event.preventDefault();
            refreshLeads();
        }
        
        // Escape to clear selection
        if (event.key === 'Escape') {
            if (selectedLeads.length > 0) {
                selectedLeads.splice(0);
                updateBulkActionUI();
            }
        }
    });
}
</script>
@endPushOnce