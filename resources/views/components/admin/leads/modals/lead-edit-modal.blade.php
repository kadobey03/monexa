<div
    id="lead-edit-modal"
    class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4"
    style="display: none;"
    onclick="closeEditModal(event)"
>
    <div
        class="bg-white dark:bg-admin-800 rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-hidden"
        onclick="event.stopPropagation()"
    >
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-admin-700">
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                    <span id="edit-modal-title">Lead Düzenle</span>
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Lead bilgilerini güncelleyin
                </p>
            </div>
            
            <button
                onclick="closeEditModal()"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
            >
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <!-- Modal Content -->
        <form onsubmit="event.preventDefault(); saveLead();" class="overflow-y-auto max-h-[calc(90vh-120px)]">
            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            İsim <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="edit-lead-name"
                            name="name"
                            required
                            class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Lead ismi"
                        >
                        <p id="error-name" class="mt-1 text-sm text-red-600 dark:text-red-400" style="display: none;"></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            E-posta <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="email"
                            id="edit-lead-email"
                            name="email"
                            required
                            class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                            placeholder="ornek@email.com"
                        >
                        <p id="error-email" class="mt-1 text-sm text-red-600 dark:text-red-400" style="display: none;"></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Telefon
                        </label>
                        <input
                            type="tel"
                            id="edit-lead-phone"
                            name="phone"
                            class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                            placeholder="+90 5XX XXX XX XX"
                        >
                        <p id="error-phone" class="mt-1 text-sm text-red-600 dark:text-red-400" style="display: none;"></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Durum
                        </label>
                        <select
                            id="edit-lead-status"
                            name="status"
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
                            id="edit-lead-priority"
                            name="priority"
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
                            id="edit-lead-source"
                            name="lead_source_id"
                            class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">Seçiniz</option>
                            @if(isset($leadSources))
                                @foreach($leadSources as $source)
                                    <option value="{{ $source->id }}">{{ $source->name }}</option>
                                @endforeach
                            @endif
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
                            id="edit-lead-assigned"
                            name="assigned_to"
                            class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                        >
                            <option value="">Atanmamış</option>
                            @if(isset($adminUsers))
                                @foreach($adminUsers as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Lead Skoru
                        </label>
                        <div class="flex items-center space-x-3">
                            <input
                                type="range"
                                id="edit-lead-score"
                                name="lead_score"
                                min="0"
                                max="100"
                                step="5"
                                value="0"
                                oninput="updateLeadScore(this.value)"
                                class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                            >
                            <span
                                id="lead-score-display"
                                class="text-sm font-medium text-gray-900 dark:text-white w-12 text-center"
                            >0</span>
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
                            id="edit-conversion-probability"
                            name="conversion_probability"
                            min="0"
                            max="100"
                            step="5"
                            value="0"
                            oninput="updateConversionProbability(this.value)"
                            class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                        >
                        <span
                            id="conversion-probability-display"
                            class="text-sm font-medium text-gray-900 dark:text-white w-12 text-center"
                        >0%</span>
                    </div>
                </div>
                
                <!-- Tags -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Etiketler
                    </label>
                    <div class="space-y-2">
                        <div class="flex flex-wrap gap-2" id="edit-tags-container">
                            <!-- Tags will be populated here -->
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            <input
                                type="text"
                                id="new-tag-input"
                                name="new_tag"
                                onkeypress="if(event.key === 'Enter') { event.preventDefault(); addEditTag(); }"
                                placeholder="Yeni etiket ekle..."
                                class="flex-1 text-sm border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                            >
                            <button
                                onclick="addEditTag()"
                                type="button"
                                class="px-3 py-1 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md"
                            >
                                Ekle
                            </button>
                        </div>
                        
                        <!-- Suggested Tags -->
                        <div class="flex flex-wrap gap-1" id="suggested-tags-container">
                            <button
                                onclick="addEditTag('vip')"
                                type="button"
                                class="inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 dark:bg-admin-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-blue-100 dark:hover:bg-blue-900 hover:text-blue-700 dark:hover:text-blue-300 transition-colors"
                            >vip</button>
                            <button
                                onclick="addEditTag('premium')"
                                type="button"
                                class="inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 dark:bg-admin-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-blue-100 dark:hover:bg-blue-900 hover:text-blue-700 dark:hover:text-blue-300 transition-colors"
                            >premium</button>
                            <button
                                onclick="addEditTag('sıcak-lead')"
                                type="button"
                                class="inline-flex items-center px-2 py-1 text-xs font-medium bg-gray-100 dark:bg-admin-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-blue-100 dark:hover:bg-blue-900 hover:text-blue-700 dark:hover:text-blue-300 transition-colors"
                            >sıcak-lead</button>
                        </div>
                    </div>
                </div>
                
                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Notlar
                    </label>
                    <textarea
                        id="edit-lead-notes"
                        name="notes"
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
                                id="edit-lead-verified"
                                name="is_verified"
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
                                id="edit-lead-premium"
                                name="is_premium"
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
                    <span id="edit-modal-footer-text">Lead düzenleniyor</span>
                </div>
                
                <div class="flex items-center space-x-3">
                    <button
                        onclick="closeEditModal()"
                        type="button"
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 border border-gray-300 dark:border-admin-600 rounded-md hover:bg-gray-50 dark:hover:bg-admin-600"
                    >
                        İptal
                    </button>
                    
                    <button
                        type="submit"
                        id="save-lead-btn"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span id="save-btn-text">
                            <i data-lucide="save" class="w-4 h-4 mr-2 inline"></i>
                            <span>Kaydet</span>
                        </span>
                        <span id="save-btn-loading" class="flex items-center" style="display: none;">
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