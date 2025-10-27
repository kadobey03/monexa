<div 
    x-show="selectedLeads.length > 0" 
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="transform opacity-0 translate-y-2"
    x-transition:enter-end="transform opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="transform opacity-100 translate-y-0"
    x-transition:leave-end="transform opacity-0 translate-y-2"
    class="fixed bottom-6 left-1/2 transform -translate-x-1/2 z-40"
    style="display: none;"
>
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-2xl border border-gray-200 dark:border-admin-700 p-4">
        <div class="flex items-center space-x-4">
            <!-- Selection Info -->
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full">
                    <i data-lucide="check" class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        <span x-text="selectedLeads.length"></span> lead seçildi
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Toplu işlem seçiniz
                    </p>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex items-center space-x-2">
                <!-- Status Update -->
                <div class="relative" x-data="{ showStatusMenu: false }">
                    <button 
                        @click="showStatusMenu = !showStatusMenu"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-admin-700 hover:bg-gray-200 dark:hover:bg-admin-600 rounded-md transition-colors"
                    >
                        <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                        Durum Güncelle
                        <i data-lucide="chevron-down" class="w-4 h-4 ml-1"></i>
                    </button>
                    
                    <div 
                        x-show="showStatusMenu"
                        @click.away="showStatusMenu = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        class="absolute bottom-full mb-2 right-0 w-48 bg-white dark:bg-admin-700 rounded-md shadow-lg border border-gray-200 dark:border-admin-600 py-1 z-50"
                    >
                        <template x-for="status in leadStatuses" :key="status.value">
                            <button 
                                @click="bulkUpdateStatus(status.value); showStatusMenu = false"
                                class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-600 flex items-center"
                            >
                                <span 
                                    class="w-2 h-2 rounded-full mr-3"
                                    :class="status.color"
                                ></span>
                                <span x-text="status.label"></span>
                            </button>
                        </template>
                    </div>
                </div>
                
                <!-- Assign User -->
                <div class="relative" x-data="{ showAssignMenu: false }">
                    <button 
                        @click="showAssignMenu = !showAssignMenu"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-admin-700 hover:bg-gray-200 dark:hover:bg-admin-600 rounded-md transition-colors"
                    >
                        <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                        Ata
                        <i data-lucide="chevron-down" class="w-4 h-4 ml-1"></i>
                    </button>
                    
                    <div 
                        x-show="showAssignMenu"
                        @click.away="showAssignMenu = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        class="absolute bottom-full mb-2 right-0 w-56 bg-white dark:bg-admin-700 rounded-md shadow-lg border border-gray-200 dark:border-admin-600 py-1 z-50"
                    >
                        <button 
                            @click="bulkAssign(null); showAssignMenu = false"
                            class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-admin-600 flex items-center"
                        >
                            <i data-lucide="user-x" class="w-4 h-4 mr-3"></i>
                            Atamasını Kaldır
                        </button>
                        
                        <div class="border-t border-gray-200 dark:border-admin-600 my-1"></div>
                        
                        <template x-for="admin in adminUsers" :key="admin.id">
                            <button 
                                @click="bulkAssign(admin.id); showAssignMenu = false"
                                class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-600 flex items-center"
                            >
                                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-xs text-white font-medium" x-text="admin.name.charAt(0).toUpperCase()"></span>
                                </div>
                                <div>
                                    <p x-text="admin.name"></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400" x-text="admin.email"></p>
                                </div>
                            </button>
                        </template>
                    </div>
                </div>
                
                <!-- Add Tags -->
                <div class="relative" x-data="{ showTagsMenu: false, newTag: '' }">
                    <button 
                        @click="showTagsMenu = !showTagsMenu"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-admin-700 hover:bg-gray-200 dark:hover:bg-admin-600 rounded-md transition-colors"
                    >
                        <i data-lucide="tag" class="w-4 h-4 mr-2"></i>
                        Etiket Ekle
                        <i data-lucide="chevron-down" class="w-4 h-4 ml-1"></i>
                    </button>
                    
                    <div 
                        x-show="showTagsMenu"
                        @click.away="showTagsMenu = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        class="absolute bottom-full mb-2 right-0 w-64 bg-white dark:bg-admin-700 rounded-md shadow-lg border border-gray-200 dark:border-admin-600 p-3 z-50"
                    >
                        <!-- Tag Input -->
                        <div class="mb-3">
                            <input 
                                type="text" 
                                x-model="newTag"
                                @keydown.enter.prevent="bulkAddTag(newTag); newTag = ''"
                                placeholder="Yeni etiket ekle..."
                                class="w-full text-sm border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>
                        
                        <!-- Common Tags -->
                        <div class="space-y-1">
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                Sık Kullanılanlar
                            </p>
                            <div class="flex flex-wrap gap-1">
                                <template x-for="tag in commonTags" :key="tag">
                                    <button 
                                        @click="bulkAddTag(tag)"
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 dark:bg-admin-800 text-gray-700 dark:text-gray-300 rounded-md hover:bg-blue-100 dark:hover:bg-blue-900 hover:text-blue-700 dark:hover:text-blue-300 transition-colors"
                                        x-text="tag"
                                    ></button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Export -->
                <button 
                    @click="exportSelectedLeads()"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-green-100 dark:bg-green-900 hover:bg-green-200 dark:hover:bg-green-800 text-green-700 dark:text-green-300 rounded-md transition-colors"
                >
                    <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                    Export
                </button>
                
                <!-- Delete -->
                <button 
                    @click="confirmBulkDelete()"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-700 dark:text-red-300 bg-red-100 dark:bg-red-900 hover:bg-red-200 dark:hover:bg-red-800 rounded-md transition-colors"
                >
                    <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                    Sil
                </button>
                
                <!-- Close/Cancel -->
                <button 
                    @click="clearSelection()"
                    class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-md transition-colors"
                    title="Seçimi Temizle"
                >
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
        
        <!-- Progress Bar for Bulk Operations -->
        <div 
            x-show="bulkOperationInProgress"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0"
            x-transition:enter-end="transform opacity-100"
            class="mt-3 pt-3 border-t border-gray-200 dark:border-admin-600"
        >
            <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                <span x-text="bulkOperationStatus"></span>
                <span x-text="bulkOperationProgress + '%'"></span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-admin-600 rounded-full h-2">
                <div 
                    class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                    :style="{ width: bulkOperationProgress + '%' }"
                ></div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Delete Confirmation Modal -->
<div 
    x-show="showBulkDeleteConfirm" 
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="transform opacity-0"
    x-transition:enter-end="transform opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="transform opacity-100"
    x-transition:leave-end="transform opacity-0"
    class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50"
    style="display: none;"
>
    <div 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="bg-white dark:bg-admin-800 rounded-lg shadow-xl max-w-md w-full mx-4"
    >
        <div class="p-6">
            <div class="flex items-center space-x-3 mb-4">
                <div class="flex-shrink-0 w-10 h-10 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600 dark:text-red-400"></i>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Toplu Silme Onayı
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Bu işlem geri alınamaz
                    </p>
                </div>
            </div>
            
            <div class="mb-6">
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    <span x-text="selectedLeads.length"></span> lead silinecek. Bu işlem geri alınamaz.
                    Silme işlemini onaylıyor musunuz?
                </p>
                
                <!-- Selected leads preview -->
                <div class="mt-3 p-3 bg-gray-50 dark:bg-admin-900 rounded-md max-h-32 overflow-y-auto">
                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">Silinecek Leadler:</div>
                    <template x-for="leadId in selectedLeads.slice(0, 5)" :key="leadId">
                        <div class="text-sm text-gray-700 dark:text-gray-300" x-text="getLeadName(leadId)"></div>
                    </template>
                    <div 
                        x-show="selectedLeads.length > 5"
                        class="text-xs text-gray-500 dark:text-gray-400 mt-1"
                        x-text="'ve ' + (selectedLeads.length - 5) + ' tane daha...'"
                    ></div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button 
                    @click="showBulkDeleteConfirm = false"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 border border-gray-300 dark:border-admin-600 rounded-md hover:bg-gray-50 dark:hover:bg-admin-600"
                >
                    İptal
                </button>
                <button 
                    @click="executeBulkDelete()"
                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md"
                >
                    <i data-lucide="trash-2" class="w-4 h-4 mr-2 inline"></i>
                    Sil
                </button>
            </div>
        </div>
    </div>
</div>

@pushOnce('scripts')
<script>
// Bulk actions functionality
window.bulkActionsData = {
    leadStatuses: [
        { value: 'new', label: 'Yeni', color: 'bg-blue-500' },
        { value: 'contacted', label: 'İletişimde', color: 'bg-yellow-500' },
        { value: 'qualified', label: 'Nitelikli', color: 'bg-green-500' },
        { value: 'converted', label: 'Dönüştürüldü', color: 'bg-purple-500' },
        { value: 'lost', label: 'Kaybedilen', color: 'bg-red-500' }
    ],
    
    commonTags: ['vip', 'premium', 'sıcak-lead', 'soğuk-lead', 'yeni-kayıt', 'telefon-doğrulandı'],
    
    bulkOperationInProgress: false,
    bulkOperationStatus: '',
    bulkOperationProgress: 0,
    showBulkDeleteConfirm: false,
    
    async bulkUpdateStatus(status) {
        if (this.selectedLeads.length === 0) return;
        
        this.bulkOperationInProgress = true;
        this.bulkOperationStatus = `Durum güncelleniyor...`;
        this.bulkOperationProgress = 0;
        
        try {
            const response = await fetch('/admin/leads/bulk-update-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    lead_ids: this.selectedLeads,
                    status: status
                })
            });
            
            if (response.ok) {
                const result = await response.json();
                this.bulkOperationProgress = 100;
                this.bulkOperationStatus = `${result.updated} lead güncellendi`;
                
                setTimeout(() => {
                    this.bulkOperationInProgress = false;
                    this.clearSelection();
                    this.loadLeads();
                }, 1000);
                
                this.showNotification('Durum başarıyla güncellendi', 'success');
            } else {
                throw new Error('Güncelleme başarısız');
            }
        } catch (error) {
            this.bulkOperationInProgress = false;
            this.showNotification('Durum güncellenirken hata oluştu', 'error');
        }
    },
    
    async bulkAssign(adminId) {
        if (this.selectedLeads.length === 0) return;
        
        this.bulkOperationInProgress = true;
        this.bulkOperationStatus = `Atama yapılıyor...`;
        this.bulkOperationProgress = 0;
        
        try {
            const response = await fetch('/admin/leads/bulk-assign', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    lead_ids: this.selectedLeads,
                    admin_id: adminId
                })
            });
            
            if (response.ok) {
                const result = await response.json();
                this.bulkOperationProgress = 100;
                this.bulkOperationStatus = `${result.assigned} lead atandı`;
                
                setTimeout(() => {
                    this.bulkOperationInProgress = false;
                    this.clearSelection();
                    this.loadLeads();
                }, 1000);
                
                this.showNotification('Atama başarıyla yapıldı', 'success');
            } else {
                throw new Error('Atama başarısız');
            }
        } catch (error) {
            this.bulkOperationInProgress = false;
            this.showNotification('Atama yapılırken hata oluştu', 'error');
        }
    },
    
    confirmBulkDelete() {
        if (this.selectedLeads.length === 0) return;
        this.showBulkDeleteConfirm = true;
    },
    
    async executeBulkDelete() {
        this.showBulkDeleteConfirm = false;
        this.bulkOperationInProgress = true;
        this.bulkOperationStatus = `Silme işlemi başlıyor...`;
        this.bulkOperationProgress = 0;
        
        try {
            const response = await fetch('/admin/leads/bulk-delete', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    lead_ids: this.selectedLeads
                })
            });
            
            if (response.ok) {
                const result = await response.json();
                this.bulkOperationProgress = 100;
                this.bulkOperationStatus = `${result.deleted} lead silindi`;
                
                setTimeout(() => {
                    this.bulkOperationInProgress = false;
                    this.clearSelection();
                    this.loadLeads();
                }, 1000);
                
                this.showNotification('Leadler başarıyla silindi', 'success');
            } else {
                throw new Error('Silme başarısız');
            }
        } catch (error) {
            this.bulkOperationInProgress = false;
            this.showNotification('Silme işlemi sırasında hata oluştu', 'error');
        }
    }
};
</script>
@endPushOnce

@pushOnce('styles')
<style>
/* Bulk actions bar styling */
.bulk-actions-bar {
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.95);
}

.dark .bulk-actions-bar {
    background: rgba(31, 41, 55, 0.95);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

/* Progress bar animation */
.progress-bar-fill {
    transition: width 0.3s ease-in-out;
}

/* Floating action animation */
@keyframes float-up {
    from {
        transform: translateX(-50%) translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }
}

.bulk-actions-container {
    animation: float-up 0.3s ease-out;
}
</style>
@endPushOnce