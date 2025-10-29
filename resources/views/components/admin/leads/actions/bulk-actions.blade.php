<div
    id="bulk-actions-bar"
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
                        <span id="selected-count">0</span> lead seçildi
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Toplu işlem seçiniz
                    </p>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex items-center space-x-2">
                <!-- Status Update -->
                <div class="relative">
                    <button
                        onclick="toggleStatusMenu()"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-admin-700 hover:bg-gray-200 dark:hover:bg-admin-600 rounded-md transition-colors"
                    >
                        <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                        Durum Güncelle
                        <i data-lucide="chevron-down" class="w-4 h-4 ml-1"></i>
                    </button>
                    
                    <div
                        id="status-menu"
                        class="absolute bottom-full mb-2 right-0 w-48 bg-white dark:bg-admin-700 rounded-md shadow-lg border border-gray-200 dark:border-admin-600 py-1 z-50"
                        style="display: none;"
                    >
                        <button
                            onclick="bulkUpdateStatus('new'); hideStatusMenu();"
                            class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-600 flex items-center"
                        >
                            <span class="w-2 h-2 rounded-full mr-3 bg-blue-500"></span>
                            <span>Yeni</span>
                        </button>
                        <button
                            onclick="bulkUpdateStatus('contacted'); hideStatusMenu();"
                            class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-600 flex items-center"
                        >
                            <span class="w-2 h-2 rounded-full mr-3 bg-yellow-500"></span>
                            <span>İletişimde</span>
                        </button>
                        <button
                            onclick="bulkUpdateStatus('qualified'); hideStatusMenu();"
                            class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-600 flex items-center"
                        >
                            <span class="w-2 h-2 rounded-full mr-3 bg-green-500"></span>
                            <span>Nitelikli</span>
                        </button>
                        <button
                            onclick="bulkUpdateStatus('converted'); hideStatusMenu();"
                            class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-600 flex items-center"
                        >
                            <span class="w-2 h-2 rounded-full mr-3 bg-purple-500"></span>
                            <span>Dönüştürüldü</span>
                        </button>
                        <button
                            onclick="bulkUpdateStatus('lost'); hideStatusMenu();"
                            class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-600 flex items-center"
                        >
                            <span class="w-2 h-2 rounded-full mr-3 bg-red-500"></span>
                            <span>Kaybedilen</span>
                        </button>
                    </div>
                </div>
                
                <!-- Assign User -->
                <div class="relative">
                    <button
                        onclick="toggleAssignMenu()"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-admin-700 hover:bg-gray-200 dark:hover:bg-admin-600 rounded-md transition-colors"
                    >
                        <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                        Ata
                        <i data-lucide="chevron-down" class="w-4 h-4 ml-1"></i>
                    </button>
                    
                    <div
                        id="assign-menu"
                        class="absolute bottom-full mb-2 right-0 w-56 bg-white dark:bg-admin-700 rounded-md shadow-lg border border-gray-200 dark:border-admin-600 py-1 z-50"
                        style="display: none;"
                    >
                        <button
                            onclick="bulkAssign(null); hideAssignMenu();"
                            class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-admin-600 flex items-center"
                        >
                            <i data-lucide="user-x" class="w-4 h-4 mr-3"></i>
                            Atamasını Kaldır
                        </button>
                        
                        <div class="border-t border-gray-200 dark:border-admin-600 my-1"></div>
                        
                        <div id="admin-users-list">
                            @if(isset($adminUsers))
                                @foreach($adminUsers as $admin)
                                    <button
                                        onclick="bulkAssign({{ $admin->id }}); hideAssignMenu();"
                                        class="w-full px-4 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-600 flex items-center"
                                    >
                                        <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-xs text-white font-medium">{{ strtoupper(substr($admin->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <p>{{ $admin->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $admin->email }}</p>
                                        </div>
                                    </button>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Add Tags -->
                <div class="relative">
                    <button
                        onclick="toggleTagsMenu()"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-admin-700 hover:bg-gray-200 dark:hover:bg-admin-600 rounded-md transition-colors"
                    >
                        <i data-lucide="tag" class="w-4 h-4 mr-2"></i>
                        Etiket Ekle
                        <i data-lucide="chevron-down" class="w-4 h-4 ml-1"></i>
                    </button>
                    
                    <div
                        id="tags-menu"
                        class="absolute bottom-full mb-2 right-0 w-64 bg-white dark:bg-admin-700 rounded-md shadow-lg border border-gray-200 dark:border-admin-600 p-3 z-50"
                        style="display: none;"
                    >
                        <!-- Tag Input -->
                        <div class="mb-3">
                            <input
                                type="text"
                                id="new-tag-input"
                                onkeypress="if(event.key === 'Enter') { event.preventDefault(); bulkAddTag(); }"
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
                                <button
                                    onclick="bulkAddTag('vip')"
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 dark:bg-admin-800 text-gray-700 dark:text-gray-300 rounded-md hover:bg-blue-100 dark:hover:bg-blue-900 hover:text-blue-700 dark:hover:text-blue-300 transition-colors"
                                >vip</button>
                                <button
                                    onclick="bulkAddTag('premium')"
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 dark:bg-admin-800 text-gray-700 dark:text-gray-300 rounded-md hover:bg-blue-100 dark:hover:bg-blue-900 hover:text-blue-700 dark:hover:text-blue-300 transition-colors"
                                >premium</button>
                                <button
                                    onclick="bulkAddTag('sıcak-lead')"
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 dark:bg-admin-800 text-gray-700 dark:text-gray-300 rounded-md hover:bg-blue-100 dark:hover:bg-blue-900 hover:text-blue-700 dark:hover:text-blue-300 transition-colors"
                                >sıcak-lead</button>
                                <button
                                    onclick="bulkAddTag('soğuk-lead')"
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 dark:bg-admin-800 text-gray-700 dark:text-gray-300 rounded-md hover:bg-blue-100 dark:hover:bg-blue-900 hover:text-blue-700 dark:hover:text-blue-300 transition-colors"
                                >soğuk-lead</button>
                                <button
                                    onclick="bulkAddTag('yeni-kayıt')"
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 dark:bg-admin-800 text-gray-700 dark:text-gray-300 rounded-md hover:bg-blue-100 dark:hover:bg-blue-900 hover:text-blue-700 dark:hover:text-blue-300 transition-colors"
                                >yeni-kayıt</button>
                                <button
                                    onclick="bulkAddTag('telefon-doğrulandı')"
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 dark:bg-admin-800 text-gray-700 dark:text-gray-300 rounded-md hover:bg-blue-100 dark:hover:bg-blue-900 hover:text-blue-700 dark:hover:text-blue-300 transition-colors"
                                >telefon-doğrulandı</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Export -->
                <button
                    onclick="exportSelectedLeads()"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-green-100 dark:bg-green-900 hover:bg-green-200 dark:hover:bg-green-800 text-green-700 dark:text-green-300 rounded-md transition-colors"
                >
                    <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                    Export
                </button>
                
                <!-- Delete -->
                <button
                    onclick="confirmBulkDelete()"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-700 dark:text-red-300 bg-red-100 dark:bg-red-900 hover:bg-red-200 dark:hover:bg-red-800 rounded-md transition-colors"
                >
                    <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                    Sil
                </button>
                
                <!-- Close/Cancel -->
                <button
                    onclick="clearSelection()"
                    class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-md transition-colors"
                    title="Seçimi Temizle"
                >
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
        
        <!-- Progress Bar for Bulk Operations -->
        <div
            id="bulk-progress-container"
            class="mt-3 pt-3 border-t border-gray-200 dark:border-admin-600"
            style="display: none;"
        >
            <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                <span id="bulk-operation-status">İşlem yapılıyor...</span>
                <span id="bulk-operation-percentage">0%</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-admin-600 rounded-full h-2">
                <div
                    id="bulk-progress-bar"
                    class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                    style="width: 0%;"
                ></div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Delete Confirmation Modal -->
<div
    id="bulk-delete-confirm-modal"
    class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50"
    style="display: none;"
    onclick="hideBulkDeleteConfirm(event)"
>
    <div
        class="bg-white dark:bg-admin-800 rounded-lg shadow-xl max-w-md w-full mx-4"
        onclick="event.stopPropagation()"
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
                    <span id="delete-count">0</span> lead silinecek. Bu işlem geri alınamaz.
                    Silme işlemini onaylıyor musunuz?
                </p>
                
                <!-- Selected leads preview -->
                <div class="mt-3 p-3 bg-gray-50 dark:bg-admin-900 rounded-md max-h-32 overflow-y-auto">
                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">Silinecek Leadler:</div>
                    <div id="delete-preview-list">
                        <!-- Lead names will be populated here -->
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button
                    onclick="hideBulkDeleteConfirm()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 border border-gray-300 dark:border-admin-600 rounded-md hover:bg-gray-50 dark:hover:bg-admin-600"
                >
                    İptal
                </button>
                <button
                    onclick="executeBulkDelete()"
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