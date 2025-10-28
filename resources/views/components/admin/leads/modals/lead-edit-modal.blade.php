<div 
    x-show="showEditModal" 
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="transform opacity-0"
    x-transition:enter-end="transform opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="transform opacity-100"
    x-transition:leave-end="transform opacity-0"
    class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4"
    style="display: none;"
    @click.self="closeEditModal()"
>
    <div 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="bg-white dark:bg-admin-800 rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-hidden"
    >
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-admin-700">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                    <span x-show="editingLead?.id">Lead Düzenle</span>
                    <span x-show="!editingLead?.id">Yeni Lead</span>
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Lead bilgilerini güncelleyin
                </p>
            </div>
            
            <button 
                @click="closeEditModal()"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
            >
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <!-- Modal Content -->
        <form @submit.prevent="saveLead()" class="overflow-y-auto max-h-[calc(90vh-120px)]">
            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            İsim <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            x-model="editingLead.name"
                            required
                            class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Lead ismi"
                        >
                        <p x-show="errors.name" class="mt-1 text-sm text-red-600 dark:text-red-400" x-text="errors.name"></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            E-posta <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            x-model="editingLead.email"
                            required
                            class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                            placeholder="ornek@email.com"
                        >
                        <p x-show="errors.email" class="mt-1 text-sm text-red-600 dark:text-red-400" x-text="errors.email"></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Telefon
                        </label>
                        <input 
                            type="tel" 
                            x-model="editingLead.phone"
                            class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                            placeholder="+90 5XX XXX XX XX"
                        >
                        <p x-show="errors.phone" class="mt-1 text-sm text-red-600 dark:text-red-400" x-text="errors.phone"></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Durum
                        </label>
                        <select 
                            x-model="editingLead.status"
                            class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="new">Yeni</option>
                            <option value="contacted">İletişimde</option>
                            <option value="qualified">Nitelikli</option>
                            <option value="converted">Dönüştürüldü</option>
                            <option value="lost">Kaybedilen</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Öncelik
                        </label>
                        <select 
                            x-model="editingLead.priority"
                            class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="low">Düşük</option>
                            <option value="medium">Orta</option>
                            <option value="high">Yüksek</option>
                            <option value="urgent">Acil</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Lead Kaynağı
                        </label>
                        <select 
                            x-model="editingLead.lead_source_id"
                            class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">Seçiniz</option>
                            <template x-for="source in leadSources" :key="source.id">
                                <option :value="source.id" x-text="source.name"></option>
                            </template>
                        </select>
                    </div>
                </div>
                
                <!-- Assignment -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Atanan Kişi
                        </label>
                        <select 
                            x-model="editingLead.assigned_to"
                            class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">Atanmamış</option>
                            <template x-for="admin in adminUsers" :key="admin.id">
                                <option :value="admin.id" x-text="admin.name"></option>
                            </template>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Lead Skoru
                        </label>
                        <div class="flex items-center space-x-3">
                            <input 
                                type="range" 
                                x-model.number="editingLead.lead_score"
                                min="0" 
                                max="100" 
                                step="5"
                                class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                            >
                            <span 
                                class="text-sm font-medium text-gray-900 dark:text-white w-12 text-center"
                                x-text="editingLead.lead_score || 0"
                            ></span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                            <span>Soğuk</span>
                            <span>Sıcak</span>
                        </div>
                    </div>
                </div>
                
                <!-- Conversion Probability -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Dönüşüm Olasılığı (%)
                    </label>
                    <div class="flex items-center space-x-3">
                        <input 
                            type="range" 
                            x-model.number="editingLead.conversion_probability"
                            min="0" 
                            max="100" 
                            step="5"
                            class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                        >
                        <span 
                            class="text-sm font-medium text-gray-900 dark:text-white w-12 text-center"
                            x-text="editingLead.conversion_probability || 0 + '%'"
                        ></span>
                    </div>
                </div>
                
                <!-- Tags -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Etiketler
                    </label>
                    <div class="space-y-2">
                        <div class="flex flex-wrap gap-2">
                            <template x-for="tag in editingLead.tags || []" :key="tag">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    <span x-text="tag"></span>
                                    <button 
                                        @click="removeEditTag(tag)"
                                        type="button"
                                        class="ml-1 inline-flex items-center p-0.5 text-blue-400 hover:text-blue-600 dark:text-blue-300 dark:hover:text-blue-100"
                                    >
                                        <i data-lucide="x" class="w-3 h-3"></i>
                                    </button>
                                </span>
                            </template>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <input 
                                type="text" 
                                x-model="newTag"
                                @keydown.enter.prevent="addEditTag()"
                                placeholder="Yeni etiket ekle..."
                                class="flex-1 text-sm border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                            >
                            <button 
                                @click="addEditTag()"
                                type="button"
                                class="px-3 py-1 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md"
                            >
                                Ekle
                            </button>
                        </div>
                        
                        <!-- Suggested Tags -->
                        <div class="flex flex-wrap gap-1">
                            <template x-for="tag in getSuggestedTags()" :key="tag">
                                <button 
                                    @click="addEditTag(tag)"
                                    type="button"
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 dark:bg-admin-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-blue-100 dark:hover:bg-blue-900 hover:text-blue-700 dark:hover:text-blue-300 transition-colors"
                                    x-text="tag"
                                ></button>
                            </template>
                        </div>
                    </div>
                </div>
                
                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Notlar
                    </label>
                    <textarea 
                        x-model="editingLead.notes"
                        rows="4"
                        class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Lead hakkında notlar..."
                    ></textarea>
                </div>
                
                <!-- Custom Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="flex items-center space-x-2">
                            <input 
                                type="checkbox" 
                                x-model="editingLead.is_verified"
                                class="rounded border-gray-300 dark:border-admin-600 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-admin-700"
                            >
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Doğrulanmış
                            </span>
                        </label>
                    </div>
                    
                    <div>
                        <label class="flex items-center space-x-2">
                            <input 
                                type="checkbox" 
                                x-model="editingLead.is_premium"
                                class="rounded border-gray-300 dark:border-admin-600 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-admin-700"
                            >
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Premium Aday
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex items-center justify-between p-6 bg-gray-50 dark:bg-admin-900 border-t border-gray-200 dark:border-admin-700">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <span x-show="editingLead?.id">Son güncelleme: <span x-text="formatDate(editingLead?.updated_at)"></span></span>
                    <span x-show="!editingLead?.id">Yeni lead oluşturuluyor</span>
                </div>
                
                <div class="flex items-center space-x-3">
                    <button 
                        @click="closeEditModal()"
                        type="button"
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 border border-gray-300 dark:border-admin-600 rounded-md hover:bg-gray-50 dark:hover:bg-admin-600"
                    >
                        İptal
                    </button>
                    
                    <button 
                        type="submit"
                        :disabled="saving"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span x-show="!saving">
                            <i data-lucide="save" class="w-4 h-4 mr-2 inline"></i>
                            <span x-show="editingLead?.id">Güncelle</span>
                            <span x-show="!editingLead?.id">Oluştur</span>
                        </span>
                        <span x-show="saving" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Kaydediliyor...
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@pushOnce('scripts')
<script>
// Lead edit modal functionality
window.leadEditHelpers = {
    editingLead: {},
    newTag: '',
    errors: {},
    saving: false,
    
    openEditModal(lead = null) {
        if (lead) {
            // Edit existing lead
            this.editingLead = { ...lead };
            if (!this.editingLead.tags) {
                this.editingLead.tags = [];
            }
        } else {
            // Create new lead
            this.editingLead = {
                name: '',
                email: '',
                phone: '',
                status: 'new',
                priority: 'medium',
                lead_source_id: '',
                assigned_to: '',
                lead_score: 0,
                conversion_probability: 0,
                notes: '',
                tags: [],
                is_verified: false,
                is_premium: false
            };
        }
        
        this.errors = {};
        this.newTag = '';
        this.showEditModal = true;
    },
    
    closeEditModal() {
        this.showEditModal = false;
        this.editingLead = {};
        this.errors = {};
        this.newTag = '';
        this.saving = false;
    },
    
    addEditTag(tag = null) {
        const tagToAdd = tag || this.newTag.trim();
        if (tagToAdd && !this.editingLead.tags.includes(tagToAdd)) {
            this.editingLead.tags.push(tagToAdd);
            this.newTag = '';
        }
    },
    
    removeEditTag(tag) {
        const index = this.editingLead.tags.indexOf(tag);
        if (index > -1) {
            this.editingLead.tags.splice(index, 1);
        }
    },
    
    getSuggestedTags() {
        const allTags = ['vip', 'premium', 'sıcak-lead', 'soğuk-lead', 'yeni-kayıt', 'telefon-doğrulandı', 'email-doğrulandı'];
        return allTags.filter(tag => !this.editingLead.tags.includes(tag));
    },
    
    async saveLead() {
        this.saving = true;
        this.errors = {};
        
        try {
            const url = this.editingLead.id 
                ? `/admin/leads/${this.editingLead.id}`
                : '/admin/leads';
            
            const method = this.editingLead.id ? 'PUT' : 'POST';
            
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(this.editingLead)
            });
            
            const result = await response.json();
            
            if (response.ok) {
                this.showNotification(
                    this.editingLead.id ? 'Lead başarıyla güncellendi' : 'Lead başarıyla oluşturuldu',
                    'success'
                );
                
                this.closeEditModal();
                this.loadLeads(); // Refresh the table
            } else {
                if (result.errors) {
                    this.errors = result.errors;
                } else {
                    throw new Error(result.message || 'Kayıt başarısız');
                }
            }
        } catch (error) {
            this.showNotification(
                this.editingLead.id ? 'Lead güncellenemedi' : 'Lead oluşturulamadı',
                'error'
            );
        } finally {
            this.saving = false;
        }
    }
};
</script>
@endPushOnce

@pushOnce('styles')
<style>
/* Custom range slider styles for lead edit form */
input[type="range"] {
    background: linear-gradient(to right, #3b82f6 0%, #3b82f6 var(--range-percent, 0%), #e5e7eb var(--range-percent, 0%), #e5e7eb 100%);
}

input[type="range"]::-webkit-slider-thumb {
    appearance: none;
    height: 20px;
    width: 20px;
    border-radius: 50%;
    background: #3b82f6;
    cursor: pointer;
    border: 3px solid #ffffff;
    box-shadow: 0 2px 6px 0 rgba(0, 0, 0, 0.2);
}

input[type="range"]::-moz-range-thumb {
    height: 20px;
    width: 20px;
    border-radius: 50%;
    background: #3b82f6;
    cursor: pointer;
    border: 3px solid #ffffff;
    box-shadow: 0 2px 6px 0 rgba(0, 0, 0, 0.2);
}

/* Dark mode range styles */
.dark input[type="range"] {
    background: linear-gradient(to right, #3b82f6 0%, #3b82f6 var(--range-percent, 0%), #4b5563 var(--range-percent, 0%), #4b5563 100%);
}

/* Tag animation */
.tag-enter {
    animation: tagFadeIn 0.2s ease-out;
}

.tag-leave {
    animation: tagFadeOut 0.2s ease-in;
}

@keyframes tagFadeIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes tagFadeOut {
    from {
        opacity: 1;
        transform: scale(1);
    }
    to {
        opacity: 0;
        transform: scale(0.8);
    }
}
</style>
@endPushOnce