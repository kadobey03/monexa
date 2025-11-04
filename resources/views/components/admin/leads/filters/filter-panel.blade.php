<div
    id="filters-panel"
    class="bg-white dark:bg-admin-800 border-b border-gray-200 dark:border-admin-700 shadow-sm"
    style="display: none;"
>
    <div class="p-6">
        <!-- Filter Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
                <x-heroicon name="funnel" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Gelişmiş Filtreler
                </h3>
                <span
                    id="active-filters-badge"
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200"
                    style="display: none;"
                >0 aktif filtre</span>
            </div>
            
            <div class="flex items-center space-x-3">
                <!-- Quick Filter Presets -->
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Hızlı:</span>
                    <select
                        class="text-sm border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                        onchange="applyQuickFilter(this.value)"
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
                    onclick="clearAllFilters()"
                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white"
                    id="clear-filters-btn"
                >
                    <x-heroicon name="x-circle" class="w-4 h-4 mr-1" />
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
                        name="status_filter"
                        onchange="applyFilters()"
                    >
                        <option value="">Tüm Durumlar</option>
                        <option value="new">Yeni</option>
                        <option value="contacted">İletişimde</option>
                        <option value="qualified">Nitelikli</option>
                        <option value="converted">Dönüştürüldü</option>
                        <option value="lost">Kaybedilen</option>
                    </select>
                    <x-heroicon name="chevron-down" class="absolute right-3 top-3 w-4 h-4 text-gray-400 pointer-events-none" />
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
                        name="source_filter"
                        onchange="applyFilters()"
                    >
                        <option value="">Tüm Kaynaklar</option>
                        @if(isset($leadSources))
                            @foreach($leadSources as $source)
                                <option value="{{ $source->id }}">{{ $source->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <x-heroicon name="chevron-down" class="absolute right-3 top-3 w-4 h-4 text-gray-400 pointer-events-none" />
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
                        name="assigned_to_filter"
                        onchange="applyFilters()"
                    >
                        <option value="">Tümü</option>
                        <option value="unassigned">Atanmamış</option>
                        @if(isset($adminUsers))
                            @foreach($adminUsers as $admin)
                                <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <x-heroicon name="chevron-down" class="absolute right-3 top-3 w-4 h-4 text-gray-400 pointer-events-none" />
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
                        name="priority_filter"
                        onchange="applyFilters()"
                    >
                        <option value="">Tüm Öncelikler</option>
                        <option value="low">Düşük</option>
                        <option value="medium">Orta</option>
                        <option value="high">Yüksek</option>
                        <option value="urgent">Acil</option>
                    </select>
                    <x-heroicon name="chevron-down" class="absolute right-3 top-3 w-4 h-4 text-gray-400 pointer-events-none" />
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
                    name="date_from_filter"
                    onchange="applyFilters()"
                >
            </div>
            
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Bitiş Tarihi
                </label>
                <input
                    type="date"
                    class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                    name="date_to_filter"
                    onchange="applyFilters()"
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
                        name="min_score_filter"
                        oninput="applyFilters()"
                        placeholder="0"
                    >
                </div>
            </div>
            
            <!-- Tags -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Etiketler
                </label>
                <div class="relative">
                    <input
                        type="text"
                        class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                        id="tag-input"
                        name="tag_input"
                        onfocus="showTagSuggestions()"
                        onblur="hideTagSuggestions()"
                        onkeypress="if(event.key === 'Enter') { event.preventDefault(); addTag(this.value); }"
                        placeholder="Etiket ara..."
                    >
                    
                    <!-- Tag Suggestions -->
                    <div
                        id="tag-suggestions"
                        class="absolute z-10 w-full mt-1 bg-white dark:bg-admin-700 border border-gray-200 dark:border-admin-600 rounded-md shadow-lg max-h-32 overflow-y-auto"
                        style="display: none;"
                    >
                        <button
                            onclick="addTag('vip'); document.getElementById('tag-input').value = '';"
                            class="w-full px-3 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-600"
                        >vip</button>
                        <button
                            onclick="addTag('premium'); document.getElementById('tag-input').value = '';"
                            class="w-full px-3 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-600"
                        >premium</button>
                        <button
                            onclick="addTag('sıcak-lead'); document.getElementById('tag-input').value = '';"
                            class="w-full px-3 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-600"
                        >sıcak-lead</button>
                    </div>
                </div>
                
                <!-- Selected Tags -->
                <div class="flex flex-wrap gap-1 mt-2" id="selected-tags">
                    <!-- Tags will be added here dynamically -->
                </div>
            </div>
            
            <!-- Custom Field -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Özel Alan
                </label>
                <select
                    class="w-full border-gray-300 dark:border-admin-600 rounded-md bg-white dark:bg-admin-700 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-blue-500"
                    name="custom_field_filter"
                    onchange="applyFilters()"
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
                    onclick="saveFilterPreset()"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white"
                    id="save-preset-btn"
                >
                    <x-heroicon name="bookmark" class="w-4 h-4 mr-2" />
                    Kayıtlı Filtrelere Ekle
                </button>
                
                <div class="relative">
                    <button
                        onclick="togglePresets()"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white"
                    >
                        <x-heroicon name="folder" class="w-4 h-4 mr-2" />
                        Kayıtlı Filtreler
                        <x-heroicon name="chevron-down" class="w-4 h-4 ml-1" />
                    </button>
                    
                    <div
                        id="presets-dropdown"
                        class="absolute left-0 mt-2 w-48 bg-white dark:bg-admin-700 border border-gray-200 dark:border-admin-600 rounded-md shadow-lg z-10"
                        style="display: none;"
                    >
                        @if(isset($filterPresets) && count($filterPresets) > 0)
                            @foreach($filterPresets as $preset)
                                <button
                                    onclick="loadFilterPreset({{ $preset }}); hidePresets();"
                                    class="w-full px-3 py-2 text-left text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-600"
                                >{{ $preset->name }}</button>
                            @endforeach
                        @else
                            <div class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">
                                Kayıtlı filtre yok
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    <span id="filtered-count">0</span> kayıt bulundu
                </span>
                
                <button
                    onclick="exportFilteredData()"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md"
                    id="export-btn"
                >
                    <x-heroicon name="arrow-down-tray" class="w-4 h-4 mr-2" />
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