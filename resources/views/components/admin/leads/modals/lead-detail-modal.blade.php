<div 
    x-show="showLeadModal" 
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="transform opacity-0"
    x-transition:enter-end="transform opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="transform opacity-100"
    x-transition:leave-end="transform opacity-0"
    class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4"
    style="display: none;"
    @click.self="closeLeadModal()"
>
    <div 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="bg-white dark:bg-admin-800 rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden"
    >
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-admin-700">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                        <i data-lucide="user" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white" x-text="selectedLead?.name || 'Lead Detayları'"></h2>
                    <div class="flex items-center space-x-4 mt-1">
                        <span 
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                            :class="getStatusBadgeClass(selectedLead?.status)"
                            x-text="getStatusLabel(selectedLead?.status)"
                        ></span>
                        <span 
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                            :class="getPriorityBadgeClass(selectedLead?.priority)"
                            x-text="getPriorityLabel(selectedLead?.priority)"
                        ></span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            ID: <span x-text="selectedLead?.id"></span>
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <!-- Action Buttons -->
                <button 
                    @click="callLead(selectedLead?.phone)"
                    x-show="selectedLead?.phone"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-green-700 dark:text-green-300 bg-green-100 dark:bg-green-900 hover:bg-green-200 dark:hover:bg-green-800 rounded-md"
                >
                    <i data-lucide="phone" class="w-4 h-4 mr-2"></i>
                    Ara
                </button>
                
                <button 
                    @click="emailLead(selectedLead?.email)"
                    x-show="selectedLead?.email"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-700 dark:text-blue-300 bg-blue-100 dark:bg-blue-900 hover:bg-blue-200 dark:hover:bg-blue-800 rounded-md"
                >
                    <i data-lucide="mail" class="w-4 h-4 mr-2"></i>
                    Mail
                </button>
                
                <button 
                    @click="editLead(selectedLead?.id)"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-admin-700 hover:bg-gray-200 dark:hover:bg-admin-600 rounded-md"
                >
                    <i data-lucide="edit-2" class="w-4 h-4 mr-2"></i>
                    Düzenle
                </button>
                
                <button 
                    @click="closeLeadModal()"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                >
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
        </div>
        
        <!-- Modal Content -->
        <div class="flex h-full max-h-[calc(90vh-120px)]">
            <!-- Left Panel - Lead Info -->
            <div class="flex-1 p-6 overflow-y-auto">
                <div class="space-y-8">
                    <!-- Basic Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                            Temel Bilgiler
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">İsim</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white" x-text="selectedLead?.name || 'Belirtilmemiş'"></p>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">E-posta</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        <a 
                                            :href="'mailto:' + selectedLead?.email" 
                                            x-show="selectedLead?.email"
                                            class="text-blue-600 dark:text-blue-400 hover:underline"
                                            x-text="selectedLead?.email"
                                        ></a>
                                        <span x-show="!selectedLead?.email" class="text-gray-500">Belirtilmemiş</span>
                                    </p>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Telefon</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">
                                        <a 
                                            :href="'tel:' + selectedLead?.phone" 
                                            x-show="selectedLead?.phone"
                                            class="text-green-600 dark:text-green-400 hover:underline"
                                            x-text="selectedLead?.phone"
                                        ></a>
                                        <span x-show="!selectedLead?.phone" class="text-gray-500">Belirtilmemiş</span>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Lead Kaynağı</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white" x-text="selectedLead?.source_name || 'Belirtilmemiş'"></p>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Atanan Kişi</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white" x-text="selectedLead?.assigned_to_name || 'Atanmamış'"></p>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Kayıt Tarihi</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white" x-text="formatDate(selectedLead?.created_at)"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Lead Score & Analytics -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                            Lead Analizi
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <div class="mx-auto w-20 h-20 relative">
                                    <svg class="transform -rotate-90 w-20 h-20">
                                        <circle 
                                            cx="40" cy="40" r="30" 
                                            stroke="currentColor" 
                                            stroke-width="6" 
                                            fill="transparent"
                                            class="text-gray-200 dark:text-gray-700"
                                        ></circle>
                                        <circle 
                                            cx="40" cy="40" r="30" 
                                            stroke="currentColor" 
                                            stroke-width="6" 
                                            fill="transparent"
                                            class="text-blue-500"
                                            :stroke-dasharray="188.4"
                                            :stroke-dashoffset="188.4 - (188.4 * (selectedLead?.lead_score || 0) / 100)"
                                        ></circle>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-xl font-semibold text-gray-900 dark:text-white" x-text="selectedLead?.lead_score || 0"></span>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm font-medium text-gray-700 dark:text-gray-300">Lead Skoru</p>
                            </div>
                            
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white" x-text="selectedLead?.conversion_probability || 0 + '%'"></div>
                                <p class="mt-1 text-sm font-medium text-gray-700 dark:text-gray-300">Dönüşüm Olasılığı</p>
                            </div>
                            
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white" x-text="selectedLead?.interaction_count || 0"></div>
                                <p class="mt-1 text-sm font-medium text-gray-700 dark:text-gray-300">Etkileşim Sayısı</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tags -->
                    <div x-show="selectedLead?.tags && selectedLead.tags.length > 0">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                            Etiketler
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="tag in selectedLead?.tags || []" :key="tag">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    <span x-text="tag"></span>
                                </span>
                            </template>
                        </div>
                    </div>
                    
                    <!-- Notes -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                            Notlar
                        </h3>
                        <div class="bg-gray-50 dark:bg-admin-900 rounded-lg p-4">
                            <p 
                                class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap"
                                x-text="selectedLead?.notes || 'Not eklenmemiş'"
                            ></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Panel - Activity Timeline -->
            <div class="w-80 border-l border-gray-200 dark:border-admin-700 p-6 overflow-y-auto">
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                            Aktivite Geçmişi
                        </h3>
                        
                        <!-- Add New Activity -->
                        <div class="mb-6">
                            <div class="flex items-center space-x-2 mb-2">
                                <select 
                                    x-model="newActivity.type"
                                    class="text-sm border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                                >
                                    <option value="call">Arama</option>
                                    <option value="email">E-posta</option>
                                    <option value="meeting">Toplantı</option>
                                    <option value="note">Not</option>
                                </select>
                                
                                <button 
                                    @click="addActivity()"
                                    class="px-3 py-1 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md"
                                >
                                    <i data-lucide="plus" class="w-4 h-4"></i>
                                </button>
                            </div>
                            
                            <textarea 
                                x-model="newActivity.description"
                                placeholder="Aktivite açıklaması..."
                                rows="2"
                                class="w-full text-sm border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                            ></textarea>
                        </div>
                        
                        <!-- Activity Timeline -->
                        <div class="space-y-4">
                            <template x-for="activity in selectedLead?.activities || []" :key="activity.id">
                                <div class="flex space-x-3">
                                    <div class="flex-shrink-0">
                                        <div 
                                            class="w-8 h-8 rounded-full flex items-center justify-center"
                                            :class="getActivityIconClass(activity.type)"
                                        >
                                            <i :data-lucide="getActivityIcon(activity.type)" class="w-4 h-4"></i>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="text-sm">
                                            <span class="font-medium text-gray-900 dark:text-white" x-text="getActivityTypeLabel(activity.type)"></span>
                                            <span class="text-gray-500 dark:text-gray-400" x-text="formatDateTime(activity.created_at)"></span>
                                        </div>
                                        <div class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                                            <p x-text="activity.description"></p>
                                        </div>
                                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                            <span x-text="activity.admin_name"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            
                            <div 
                                x-show="!selectedLead?.activities || selectedLead.activities.length === 0"
                                class="text-center py-6 text-gray-500 dark:text-gray-400"
                            >
                                <i data-lucide="clock" class="w-8 h-8 mx-auto mb-2"></i>
                                <p class="text-sm">Henüz aktivite yok</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@pushOnce('scripts')
<script>
// Lead detail modal functionality
window.leadModalHelpers = {
    newActivity: {
        type: 'note',
        description: ''
    },
    
    async addActivity() {
        if (!this.newActivity.description.trim()) return;
        
        try {
            const response = await fetch(`/admin/leads/${this.selectedLead.id}/activities`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(this.newActivity)
            });
            
            if (response.ok) {
                const activity = await response.json();
                
                // Add to activities array
                if (!this.selectedLead.activities) {
                    this.selectedLead.activities = [];
                }
                this.selectedLead.activities.unshift(activity);
                
                // Clear form
                this.newActivity = { type: 'note', description: '' };
                
                this.showNotification('Aktivite eklendi', 'success');
            }
        } catch (error) {
            this.showNotification('Aktivite eklenemedi', 'error');
        }
    },
    
    getActivityIcon(type) {
        const icons = {
            call: 'phone',
            email: 'mail',
            meeting: 'calendar',
            note: 'file-text'
        };
        return icons[type] || 'circle';
    },
    
    getActivityIconClass(type) {
        const classes = {
            call: 'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-400',
            email: 'bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-400',
            meeting: 'bg-purple-100 text-purple-600 dark:bg-purple-900 dark:text-purple-400',
            note: 'bg-gray-100 text-gray-600 dark:bg-admin-700 dark:text-gray-400'
        };
        return classes[type] || 'bg-gray-100 text-gray-600';
    },
    
    getActivityTypeLabel(type) {
        const labels = {
            call: 'Arama',
            email: 'E-posta',
            meeting: 'Toplantı',
            note: 'Not'
        };
        return labels[type] || 'Aktivite';
    },
    
    callLead(phone) {
        if (phone) {
            window.location.href = `tel:${phone}`;
            this.addActivity('call', `${phone} numarası arandı`);
        }
    },
    
    emailLead(email) {
        if (email) {
            window.location.href = `mailto:${email}`;
            this.addActivity('email', `${email} adresine e-posta gönderildi`);
        }
    }
};
</script>
@endPushOnce