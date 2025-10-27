<div class="leads-table-container">
    
    <!-- Table Wrapper -->
    <div class="table-wrapper bg-white dark:bg-admin-800 rounded-xl shadow-sm border border-gray-200 dark:border-admin-700 overflow-hidden">
        <!-- Table Header Info -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Lead Listesi
                    <span class="text-sm text-gray-500 dark:text-gray-400 ml-2" 
                          x-text="`(${pagination.total} kayıt)`"></span>
                </h3>
                
                <div class="flex items-center space-x-3">
                    <!-- Table Settings -->
                    <button 
                        @click="showColumnSettings = !showColumnSettings"
                        class="inline-flex items-center px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white border border-gray-300 dark:border-admin-600 rounded-lg hover:bg-gray-50 dark:hover:bg-admin-700">
                        <i data-lucide="settings" class="w-4 h-4 mr-2"></i>
                        Sütunlar
                    </button>
                    
                    <!-- Export Button -->
                    @can('export_leads')
                    <button 
                        @click="exportLeads()"
                        class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                        Export
                    </button>
                    @endcan
                </div>
            </div>
        </div>
        
        <!-- Loading Indicator -->
        <div x-show="loading" class="flex items-center justify-center py-12">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <span class="ml-3 text-gray-600 dark:text-gray-400">Yükleniyor...</span>
        </div>
        
        <!-- Table Content -->
        <div x-show="!loading" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-admin-700">
                <!-- Table Header -->
                <x-admin.leads.table.table-header />
                
                <!-- Table Body -->
                <tbody class="bg-white dark:bg-admin-800 divide-y divide-gray-200 dark:divide-admin-700">
                    <template x-for="lead in leads" :key="lead.id">
                        <x-admin.leads.table.table-row />
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
    <div x-show="pagination.total > 0" class="bg-white dark:bg-admin-800 px-6 py-4 rounded-xl shadow-sm border border-gray-200 dark:border-admin-700 mt-6">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700 dark:text-gray-300">
                <span x-text="`${pagination.from || 0} - ${pagination.to || 0} / ${pagination.total} kayıt gösteriliyor`"></span>
            </div>
            
            <div class="flex items-center space-x-2">
                <button 
                    @click="goToPage(pagination.current_page - 1)"
                    :disabled="pagination.current_page <= 1"
                    class="px-3 py-2 text-sm border border-gray-300 dark:border-admin-600 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-admin-700 dark:text-white">
                    Önceki
                </button>
                
                <template x-for="page in getVisiblePages()" :key="page">
                    <button 
                        @click="goToPage(page)"
                        :class="{
                            'bg-blue-600 text-white': page === pagination.current_page,
                            'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-admin-700': page !== pagination.current_page
                        }"
                        class="px-3 py-2 text-sm border border-gray-300 dark:border-admin-600 rounded-lg"
                        x-text="page">
                    </button>
                </template>
                
                <button 
                    @click="goToPage(pagination.current_page + 1)"
                    :disabled="pagination.current_page >= pagination.last_page"
                    class="px-3 py-2 text-sm border border-gray-300 dark:border-admin-600 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:hover:bg-admin-700 dark:text-white">
                    Sonraki
                </button>
            </div>
        </div>
    </div>
</div>

</div>