@extends('layouts.admin')

@section('title', 'İzin Denetim Kaydı')

@section('content')
<div x-data="auditLogApp()" class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">İzin Denetim Kaydı</h1>
                <p class="text-gray-600 mt-1">Sistem üzerinde yapılan izin değişikliklerini görüntüleyin</p>
            </div>
            
            <div class="flex space-x-3">
                <button @click="exportLogs" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Dışa Aktar</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tarih Aralığı</label>
                <input x-model="filters.date_from" type="date" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Bitiş Tarihi</label>
                <input x-model="filters.date_to" type="date" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">İşlem Tipi</label>
                <select x-model="filters.action" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tümü</option>
                    <option value="granted">İzin Verildi</option>
                    <option value="revoked">İzin Kaldırıldı</option>
                    <option value="updated">Güncellendi</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kullanıcı</label>
                <input x-model="filters.user" type="text" placeholder="Kullanıcı adı ara..." class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
        
        <div class="flex justify-end mt-4 space-x-2">
            <button @click="resetFilters" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Temizle
            </button>
            <button @click="applyFilters" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Filtrele
            </button>
        </div>
    </div>

    <!-- Audit Log Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Denetim Kayıtları</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarih/Saat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kullanıcı</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlem</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İzin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Adresi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-for="log in auditLogs" :key="log.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="formatDateTime(log.created_at)"></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <img class="h-8 w-8 rounded-full" :src="log.admin.avatar || '/dash/img/user-placeholder.png'" :alt="log.admin.name">
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900" x-text="log.admin.name"></div>
                                        <div class="text-sm text-gray-500" x-text="log.admin.email"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                      :class="{
                                          'bg-green-100 text-green-800': log.action === 'granted',
                                          'bg-red-100 text-red-800': log.action === 'revoked',
                                          'bg-blue-100 text-blue-800': log.action === 'updated'
                                      }"
                                      x-text="getActionText(log.action)">
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" x-text="log.role?.name || '-'"></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900" x-text="log.permission?.name"></div>
                                <div class="text-sm text-gray-500" x-text="log.permission?.category"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                                      :class="{
                                          'bg-green-100 text-green-800': log.status === 'success',
                                          'bg-red-100 text-red-800': log.status === 'failed',
                                          'bg-yellow-100 text-yellow-800': log.status === 'pending'
                                      }"
                                      x-text="log.status">
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="log.ip_address"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        
        <!-- Empty State -->
        <div x-show="auditLogs.length === 0" class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Denetim kaydı bulunamadı</h3>
            <p class="mt-1 text-sm text-gray-500">Seçilen kriterlere uygun denetim kaydı bulunmuyor.</p>
        </div>

        <!-- Pagination -->
        <div x-show="pagination.total > 0" class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    <button @click="prevPage" :disabled="pagination.current_page <= 1" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50">
                        Önceki
                    </button>
                    <button @click="nextPage" :disabled="pagination.current_page >= pagination.last_page" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50">
                        Sonraki
                    </button>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            <span x-text="pagination.from"></span>
                            -
                            <span x-text="pagination.to"></span>
                            arası gösteriliyor, toplam
                            <span x-text="pagination.total"></span>
                            kayıt
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                            <button @click="prevPage" :disabled="pagination.current_page <= 1" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50">
                                <span class="sr-only">Önceki</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <template x-for="page in getPageNumbers()" :key="page">
                                <button @click="goToPage(page)" 
                                        :class="page === pagination.current_page ? 'bg-blue-50 border-blue-500 text-blue-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'"
                                        class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                                        x-text="page">
                                </button>
                            </template>
                            <button @click="nextPage" :disabled="pagination.current_page >= pagination.last_page" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50">
                                <span class="sr-only">Sonraki</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function auditLogApp() {
    return {
        auditLogs: @json(isset($auditLogs) && $auditLogs ? $auditLogs->items() : []),
        pagination: {
            current_page: {{ isset($auditLogs) && $auditLogs ? $auditLogs->currentPage() : 1 }},
            last_page: {{ isset($auditLogs) && $auditLogs ? $auditLogs->lastPage() : 1 }},
            total: {{ isset($auditLogs) && $auditLogs ? $auditLogs->total() : 0 }},
            from: {{ isset($auditLogs) && $auditLogs ? ($auditLogs->firstItem() ?? 0) : 0 }},
            to: {{ isset($auditLogs) && $auditLogs ? ($auditLogs->lastItem() ?? 0) : 0 }}
        },
        filters: {
            date_from: '',
            date_to: '',
            action: '',
            user: ''
        },

        init() {
            this.loadAuditLogs();
        },

        async loadAuditLogs() {
            try {
                const params = new URLSearchParams(this.filters);
                const response = await fetch(`{{ route('admin.permissions.audit-log') }}?${params}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    this.auditLogs = data.data;
                    this.pagination = data.pagination;
                }
            } catch (error) {
                console.error('Audit log yüklenirken hata:', error);
            }
        },

        applyFilters() {
            this.loadAuditLogs();
        },

        resetFilters() {
            this.filters = {
                date_from: '',
                date_to: '',
                action: '',
                user: ''
            };
            this.loadAuditLogs();
        },

        formatDateTime(dateTime) {
            return new Date(dateTime).toLocaleString('tr-TR', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            });
        },

        getActionText(action) {
            const actions = {
                'granted': 'İzin Verildi',
                'revoked': 'İzin Kaldırıldı',
                'updated': 'Güncellendi'
            };
            return actions[action] || action;
        },

        prevPage() {
            if (this.pagination.current_page > 1) {
                this.goToPage(this.pagination.current_page - 1);
            }
        },

        nextPage() {
            if (this.pagination.current_page < this.pagination.last_page) {
                this.goToPage(this.pagination.current_page + 1);
            }
        },

        goToPage(page) {
            this.pagination.current_page = page;
            this.loadAuditLogs();
        },

        getPageNumbers() {
            const current = this.pagination.current_page;
            const last = this.pagination.last_page;
            const pages = [];
            
            let start = Math.max(1, current - 2);
            let end = Math.min(last, current + 2);
            
            for (let i = start; i <= end; i++) {
                pages.push(i);
            }
            
            return pages;
        },

        async exportLogs() {
            try {
                const params = new URLSearchParams(this.filters);
                const response = await fetch(`{{ route('admin.permissions.audit-log') }}/export?${params}`, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                if (response.ok) {
                    const blob = await response.blob();
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `audit-log-${new Date().toISOString().split('T')[0]}.xlsx`;
                    a.click();
                    window.URL.revokeObjectURL(url);
                }
            } catch (error) {
                console.error('Export hatası:', error);
                alert('Export işlemi sırasında hata oluştu.');
            }
        }
    }
}
</script>
@endsection