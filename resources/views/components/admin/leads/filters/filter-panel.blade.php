<div 
    x-show="showFilters" 
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="transform opacity-0 translate-y-[-10px]"
    x-transition:enter-end="transform opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="transform opacity-100 translate-y-0"
    x-transition:leave-end="transform opacity-0 translate-y-[-10px]"
    class="bg-white dark:bg-admin-800 border-b border-gray-200 dark:border-admin-700 shadow-sm"
    style="display: none;"
>
    <div class="p-6">
        <!-- Filter Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
                <i data-lucide="filter" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Gelişmiş Filtreler
                </h3>
                <span 
                    x-show="getActiveFiltersCount() > 0"
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200"
                    x-text="getActiveFiltersCount() + ' aktif filtre'"
                ></span>
            </div>
            
            <div class="flex items-center space-x-3">
                <!-- Quick Filter Presets -->
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Hızlı:</span>
                    <select 
                        class="text-sm border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                        @change="applyQuickFilter($event.target.value)"
                    >
                        <option value="">Seçiniz</option>
                        <option value="today">Bugün Eklenen</option>
                        <option value="this_week">Bu Hafta</option>
                        <option value="high_priority">Yüksek Öncelik</option>
                        <option value="unassigned">Atanmamış</option>
                        <option value="hot_leads">Sıcak Leadler</option>
                    </select>
                </div>
                
                <button 
                    @click="clearAllFilters()"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white"
                    :class="{ 'opacity-50 cursor-not-allowed': getActiveFiltersCount() === 0 }"
                    :disabled="getActiveFiltersCount() === 0"
                >
                    <i data-lucide="x-circle" class="w-4 h-4 mr-1"></i>
                    Temizle
                </button>
            </div>
        </div>
        
        <!-- Filter Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Status Filter -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Durum
                </label>
                <div class="relative">
                    <select 
                        class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                        x-model="filters.status"
                        @change="applyFilters()"
                    >
                        <option value="">Tüm Durumlar</option>
                        <option value="new">Yeni</option>
                        <option value="contacted">İletişimde</option>
                        <option value="qualified">Nitelikli</option>
                        <option value="converted">Dönüştürüldü</option>
                        <option value="lost">Kaybedilen</option>
                    </select>
                    <i data-lucide="chevron-down" class="absolute right-3 top-3 w-4 h-4 text-gray-400 pointer-events-none"></i>
                </div>
            </div>
            
            <!-- Lead Source Filter -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Kaynak
                </label>
                <div class="relative">
                    <select 
                        class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                        x-model="filters.source"
                        @change="applyFilters()"
                    >
                        <option value="">Tüm Kaynaklar</option>
                        <template x-for="source in leadSources" :key="source.id">
                            <option :value="source.id" x-text="source.name"></option>
                        </template>
                    </select>
                    <i data-lucide="chevron-down" class="absolute right-3 top-3 w-4 h-4 text-gray-400 pointer-events-none"></i>
                </div>
            </div>
            
            <!-- Assigned User Filter -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Atanan Kişi
                </label>
                <div class="relative">
                    <select 
                        class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                        x-model="filters.assigned_to"
                        @change="applyFilters()"
                    >
                        <option value="">Tümü</option>
                        <option value="unassigned">Atanmamış</option>
                        <template x-for="admin in adminUsers" :key="admin.id">
                            <option :value="admin.id" x-text="admin.name"></option>
                        </template>
                    </select>
                    <i data-lucide="chevron-down" class="absolute right-3 top-3 w-4 h-4 text-gray-400 pointer-events-none"></i>
                </div>
            </div>
            
            <!-- Priority Filter -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Öncelik
                </label>
                <div class="relative">
                    <select 
                        class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                        x-model="filters.priority"
                        @change="applyFilters()"
                    >
                        <option value="">Tüm Öncelikler</option>
                        <option value="low">Düşük</option>
                        <option value="medium">Orta</option>
                        <option value="high">Yüksek</option>
                        <option value="urgent">Acil</option>
                    </select>
                    <i data-lucide="chevron-down" class="absolute right-3 top-3 w-4 h-4 text-gray-400 pointer-events-none"></i>
                </div>
            </div>
        </div>
        
        <!-- Advanced Filters Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mt-6">
            <!-- Date Range -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Başlangıç Tarihi
                </label>
                <input 
                    type="date" 
                    class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                    x-model="filters.date_from"
                    @change="applyFilters()"
                >
            </div>
            
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Bitiş Tarihi
                </label>
                <input 
                    type="date" 
                    class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                    x-model="filters.date_to"
                    @change="applyFilters()"
                >
            </div>
            
            <!-- Score Range -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Min. Puan
                </label>
                <div class="relative">
                    <input 
                        type="number" 
                        min="0" 
                        max="100" 
                        class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                        x-model.number="filters.min_score"
                        @input="applyFilters()"
                        placeholder="0"
                    >
                </div>
            </div>
            
            <!-- Tags -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Etiketler
                </label>
                <div class="relative" x-data="{ tagInput: '', showTagSuggestions: false }">
                    <input 
                        type="text" 
                        class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                        x-model="tagInput"
                        @focus="showTagSuggestions = true"
                        @blur="setTimeout(() => showTagSuggestions = false, 200)"
                        @keydown.enter.prevent="addTag(tagInput)"
                        placeholder="Etiket ara..."
                    >
                    
                    <!-- Tag Suggestions -->
                    <div 
                        x-show="showTagSuggestions && tagInput.length > 0"
                        class="absolute z-10 w-full mt-1 bg-white dark:bg-admin-700 border border-gray-200 dark:border-admin-600 rounded-md shadow-lg max-h-32 overflow-y-auto"
                    >
                        <template x-for="tag in getFilteredTags(tagInput)" :key="tag">
                            <button 
                                @click="addTag(tag); tagInput = ''"
                                class="w-full px-3 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-600"
                                x-text="tag"
                            ></button>
                        </template>
                    </div>
                </div>
                
                <!-- Selected Tags -->
                <div class="flex flex-wrap gap-1 mt-2">
                    <template x-for="tag in filters.tags" :key="tag">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            <span x-text="tag"></span>
                            <button 
                                @click="removeTag(tag)"
                                class="ml-1 inline-flex items-center p-0.5 text-blue-400 hover:text-blue-600 dark:text-blue-300 dark:hover:text-blue-100"
                            >
                                <i data-lucide="x" class="w-3 h-3"></i>
                            </button>
                        </span>
                    </template>
                </div>
            </div>
            
            <!-- Custom Field -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Özel Alan
                </label>
                <select 
                    class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                    x-model="filters.custom_field"
                    @change="applyFilters()"
                >
                    <option value="">Seçiniz</option>
                    <option value="has_phone">Telefonu Var</option>
                    <option value="has_email">E-postası Var</option>
                    <option value="verified">Doğrulanmış</option>
                    <option value="premium">Premium</option>
                </select>
            </div>
        </div>
        
        <!-- Filter Actions -->
        <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200 dark:border-admin-700">
            <div class="flex items-center space-x-4">
                <button 
                    @click="saveFilterPreset()"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white"
                    :disabled="getActiveFiltersCount() === 0"
                >
                    <i data-lucide="bookmark" class="w-4 h-4 mr-2"></i>
                    Kayıtlı Filtrelere Ekle
                </button>
                
                <div class="relative" x-data="{ showPresets: false }">
                    <button 
                        @click="showPresets = !showPresets"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white"
                    >
                        <i data-lucide="folder" class="w-4 h-4 mr-2"></i>
                        Kayıtlı Filtreler
                        <i data-lucide="chevron-down" class="w-4 h-4 ml-1"></i>
                    </button>
                    
                    <div 
                        x-show="showPresets"
                        @click.away="showPresets = false"
                        class="absolute left-0 mt-2 w-48 bg-white dark:bg-admin-700 border border-gray-200 dark:border-admin-600 rounded-md shadow-lg z-10"
                    >
                        <template x-for="preset in filterPresets" :key="preset.id">
                            <button 
                                @click="loadFilterPreset(preset); showPresets = false"
                                class="w-full px-3 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-600"
                                x-text="preset.name"
                            ></button>
                        </template>
                        
                        <div 
                            x-show="filterPresets.length === 0"
                            class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400"
                        >
                            Kayıtlı filtre yok
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    <span x-text="filteredCount"></span> kayıt bulundu
                </span>
                
                <button 
                    @click="exportFilteredData()"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md"
                    :disabled="filteredCount === 0"
                >
                    <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                    Excel'e Aktar
                </button>
            </div>
        </div>
    </div>
</div>

@pushOnce('scripts')
<script>
// Filter management functions
window.filterHelpers = {
    getFilteredTags(input) {
        const availableTags = ['vip', 'premium', 'yeni-kayıt', 'telefon-doğrulandı', 'email-doğrulandı', 'sıcak-lead', 'soğuk-lead'];
        return availableTags.filter(tag => 
            tag.toLowerCase().includes(input.toLowerCase()) && 
            !this.filters.tags.includes(tag)
        );
    },
    
    addTag(tag) {
        if (tag.trim() && !this.filters.tags.includes(tag.trim())) {
            this.filters.tags.push(tag.trim());
            this.applyFilters();
        }
    },
    
    removeTag(tag) {
        const index = this.filters.tags.indexOf(tag);
        if (index > -1) {
            this.filters.tags.splice(index, 1);
            this.applyFilters();
        }
    },
    
    applyQuickFilter(preset) {
        const today = new Date().toISOString().split('T')[0];
        const weekAgo = new Date(Date.now() - 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0];
        
        switch (preset) {
            case 'today':
                this.filters.date_from = today;
                this.filters.date_to = today;
                break;
            case 'this_week':
                this.filters.date_from = weekAgo;
                this.filters.date_to = today;
                break;
            case 'high_priority':
                this.filters.priority = 'high';
                break;
            case 'unassigned':
                this.filters.assigned_to = 'unassigned';
                break;
            case 'hot_leads':
                this.filters.min_score = 70;
                this.filters.tags = ['sıcak-lead'];
                break;
        }
        
        this.applyFilters();
    }
};
</script>
@endPushOnce

@pushOnce('styles')
<style>
/* Custom date input styling */
input[type="date"]::-webkit-calendar-picker-indicator {
    background: transparent;
    bottom: 0;
    color: transparent;
    cursor: pointer;
    height: auto;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    width: auto;
}

/* Filter badge animations */
.filter-badge-enter {
    animation: fadeInScale 0.2s ease-out;
}

.filter-badge-leave {
    animation: fadeOutScale 0.2s ease-in;
}

@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes fadeOutScale {
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