/**
 * Filter Manager
 * Gelişmiş filtreleme, arama ve filter preset yönetimi
 */
class FilterManager {
    constructor() {
        this.storageKey = 'leads_table_filter_settings';
        this.presetStorageKey = 'leads_table_filter_presets';
        
        this.defaultFilters = {
            status: '',
            source: '',
            assigned_to: '',
            priority: '',
            date_from: '',
            date_to: '',
            min_score: '',
            max_score: '',
            tags: [],
            custom_field: '',
            has_phone: null,
            has_email: null,
            is_verified: null,
            is_premium: null,
            conversion_probability_min: '',
            conversion_probability_max: ''
        };
        
        this.currentFilters = { ...this.defaultFilters };
        this.filterPresets = [];
        this.searchHistory = [];
        this.maxSearchHistory = 10;
        
        // Advanced search options
        this.searchFields = [
            { key: 'name', label: 'İsim', type: 'text', searchable: true },
            { key: 'email', label: 'E-posta', type: 'email', searchable: true },
            { key: 'phone', label: 'Telefon', type: 'tel', searchable: true },
            { key: 'notes', label: 'Notlar', type: 'text', searchable: true },
            { key: 'tags', label: 'Etiketler', type: 'tags', searchable: true }
        ];
        
        this.availableTags = [
            'vip', 'premium', 'sıcak-lead', 'soğuk-lead', 'yeni-kayıt', 
            'telefon-doğrulandı', 'email-doğrulandı', 'takip-et', 'öncelikli'
        ];
        
        this.quickFilters = [
            {
                id: 'today',
                name: 'Bugün Eklenen',
                description: 'Bugün eklenen leadler',
                filters: { date_from: this.getTodayDate(), date_to: this.getTodayDate() }
            },
            {
                id: 'this_week',
                name: 'Bu Hafta',
                description: 'Bu hafta eklenen leadler',
                filters: { date_from: this.getWeekStartDate(), date_to: this.getTodayDate() }
            },
            {
                id: 'this_month',
                name: 'Bu Ay',
                description: 'Bu ay eklenen leadler',
                filters: { date_from: this.getMonthStartDate(), date_to: this.getTodayDate() }
            },
            {
                id: 'high_priority',
                name: 'Yüksek Öncelik',
                description: 'Yüksek ve acil öncelikli leadler',
                filters: { priority: 'high,urgent' }
            },
            {
                id: 'unassigned',
                name: 'Atanmamış',
                description: 'Henüz atanmamış leadler',
                filters: { assigned_to: 'unassigned' }
            },
            {
                id: 'hot_leads',
                name: 'Sıcak Leadler',
                description: 'Yüksek skorlu leadler (70+)',
                filters: { min_score: 70 }
            },
            {
                id: 'new_leads',
                name: 'Yeni Leadler',
                description: 'Yeni durumdaki leadler',
                filters: { status: 'new' }
            },
            {
                id: 'qualified_leads',
                name: 'Nitelikli Leadler',
                description: 'Nitelikli durumdaki leadler',
                filters: { status: 'qualified' }
            }
        ];
        
        this.init();
    }
    
    init() {
        this.loadSettings();
        this.loadPresets();
        this.loadSearchHistory();
    }
    
    /**
     * Load filter settings from localStorage
     */
    loadSettings() {
        try {
            const saved = localStorage.getItem(this.storageKey);
            
            if (saved) {
                const settings = JSON.parse(saved);
                this.currentFilters = { ...this.defaultFilters, ...settings.filters };
            }
        } catch (error) {
            console.error('Error loading filter settings:', error);
            this.currentFilters = { ...this.defaultFilters };
        }
    }
    
    /**
     * Save filter settings to localStorage
     */
    saveSettings() {
        try {
            const settings = {
                filters: this.currentFilters,
                timestamp: Date.now()
            };
            
            localStorage.setItem(this.storageKey, JSON.stringify(settings));
            
            // Emit event
            this.emit('filtersUpdated', this.currentFilters);
            
        } catch (error) {
            console.error('Error saving filter settings:', error);
        }
    }
    
    /**
     * Load filter presets
     */
    loadPresets() {
        try {
            const saved = localStorage.getItem(this.presetStorageKey);
            
            if (saved) {
                this.filterPresets = JSON.parse(saved);
            }
        } catch (error) {
            console.error('Error loading filter presets:', error);
            this.filterPresets = [];
        }
    }
    
    /**
     * Save filter presets
     */
    savePresets() {
        try {
            localStorage.setItem(this.presetStorageKey, JSON.stringify(this.filterPresets));
        } catch (error) {
            console.error('Error saving filter presets:', error);
        }
    }
    
    /**
     * Get current filters
     */
    getCurrentFilters() {
        return { ...this.currentFilters };
    }
    
    /**
     * Set filters
     */
    setFilters(filters, save = true) {
        this.currentFilters = { ...this.defaultFilters, ...filters };
        
        if (save) {
            this.saveSettings();
        }
        
        return this.currentFilters;
    }
    
    /**
     * Update single filter
     */
    updateFilter(key, value, save = true) {
        if (key in this.defaultFilters) {
            this.currentFilters[key] = value;
            
            if (save) {
                this.saveSettings();
            }
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Clear all filters
     */
    clearAllFilters() {
        this.currentFilters = { ...this.defaultFilters };
        this.saveSettings();
        return this.currentFilters;
    }
    
    /**
     * Clear specific filter
     */
    clearFilter(key) {
        if (key in this.currentFilters) {
            if (Array.isArray(this.defaultFilters[key])) {
                this.currentFilters[key] = [];
            } else {
                this.currentFilters[key] = this.defaultFilters[key];
            }
            
            this.saveSettings();
            return true;
        }
        
        return false;
    }
    
    /**
     * Check if any filters are active
     */
    hasActiveFilters() {
        return Object.entries(this.currentFilters).some(([key, value]) => {
            if (Array.isArray(value)) {
                return value.length > 0;
            }
            return value !== '' && value !== null && value !== this.defaultFilters[key];
        });
    }
    
    /**
     * Get active filters count
     */
    getActiveFiltersCount() {
        let count = 0;
        
        Object.entries(this.currentFilters).forEach(([key, value]) => {
            if (Array.isArray(value)) {
                count += value.length;
            } else if (value !== '' && value !== null && value !== this.defaultFilters[key]) {
                count++;
            }
        });
        
        return count;
    }
    
    /**
     * Apply quick filter
     */
    applyQuickFilter(quickFilterId) {
        const quickFilter = this.quickFilters.find(qf => qf.id === quickFilterId);
        
        if (quickFilter) {
            // Process special filter values
            const processedFilters = { ...quickFilter.filters };
            
            Object.entries(processedFilters).forEach(([key, value]) => {
                if (typeof value === 'string' && value.includes(',')) {
                    // Handle multiple values (like priority: 'high,urgent')
                    processedFilters[key] = value;
                }
            });
            
            this.setFilters(processedFilters);
            return processedFilters;
        }
        
        return null;
    }
    
    /**
     * Get quick filters
     */
    getQuickFilters() {
        return [...this.quickFilters];
    }
    
    /**
     * Tag management
     */
    addTag(tag) {
        if (!this.currentFilters.tags.includes(tag)) {
            this.currentFilters.tags.push(tag);
            this.saveSettings();
            return true;
        }
        return false;
    }
    
    removeTag(tag) {
        const index = this.currentFilters.tags.indexOf(tag);
        if (index > -1) {
            this.currentFilters.tags.splice(index, 1);
            this.saveSettings();
            return true;
        }
        return false;
    }
    
    getFilteredTags(input) {
        return this.availableTags.filter(tag => 
            tag.toLowerCase().includes(input.toLowerCase()) && 
            !this.currentFilters.tags.includes(tag)
        );
    }
    
    /**
     * Preset management
     */
    saveFilterPreset(name, description = '') {
        if (!name.trim()) {
            throw new Error('Preset adı gereklidir');
        }
        
        // Check if name already exists
        const existingIndex = this.filterPresets.findIndex(p => p.name === name);
        
        const preset = {
            id: existingIndex > -1 ? this.filterPresets[existingIndex].id : Date.now().toString(),
            name: name.trim(),
            description: description.trim(),
            filters: { ...this.currentFilters },
            created_at: existingIndex > -1 ? this.filterPresets[existingIndex].created_at : new Date().toISOString(),
            updated_at: new Date().toISOString()
        };
        
        if (existingIndex > -1) {
            this.filterPresets[existingIndex] = preset;
        } else {
            this.filterPresets.push(preset);
        }
        
        this.savePresets();
        return preset;
    }
    
    loadFilterPreset(presetId) {
        const preset = this.filterPresets.find(p => p.id === presetId);
        
        if (preset) {
            this.setFilters(preset.filters);
            return preset;
        }
        
        return null;
    }
    
    deleteFilterPreset(presetId) {
        const index = this.filterPresets.findIndex(p => p.id === presetId);
        
        if (index > -1) {
            const deleted = this.filterPresets.splice(index, 1)[0];
            this.savePresets();
            return deleted;
        }
        
        return null;
    }
    
    getFilterPresets() {
        return [...this.filterPresets];
    }
    
    /**
     * Search history management
     */
    loadSearchHistory() {
        try {
            const saved = localStorage.getItem('leads_search_history');
            if (saved) {
                this.searchHistory = JSON.parse(saved);
            }
        } catch (error) {
            console.error('Error loading search history:', error);
            this.searchHistory = [];
        }
    }
    
    saveSearchHistory() {
        try {
            localStorage.setItem('leads_search_history', JSON.stringify(this.searchHistory));
        } catch (error) {
            console.error('Error saving search history:', error);
        }
    }
    
    addToSearchHistory(query) {
        if (!query || query.length < 2) return;
        
        // Remove if already exists
        const existingIndex = this.searchHistory.findIndex(item => item.query === query);
        if (existingIndex > -1) {
            this.searchHistory.splice(existingIndex, 1);
        }
        
        // Add to beginning
        this.searchHistory.unshift({
            query,
            timestamp: Date.now()
        });
        
        // Limit history size
        if (this.searchHistory.length > this.maxSearchHistory) {
            this.searchHistory = this.searchHistory.slice(0, this.maxSearchHistory);
        }
        
        this.saveSearchHistory();
    }
    
    getSearchHistory() {
        return [...this.searchHistory];
    }
    
    clearSearchHistory() {
        this.searchHistory = [];
        this.saveSearchHistory();
    }
    
    /**
     * Advanced search
     */
    buildAdvancedSearchQuery(searchTerm, fields = []) {
        if (!searchTerm.trim()) return '';
        
        const terms = searchTerm.split(' ').filter(term => term.length > 0);
        const searchFields = fields.length > 0 ? fields : this.getSearchableFields();
        
        return {
            query: searchTerm,
            terms: terms,
            fields: searchFields
        };
    }
    
    getSearchableFields() {
        return this.searchFields.filter(field => field.searchable).map(field => field.key);
    }
    
    /**
     * Filter validation
     */
    validateFilters(filters) {
        const errors = {};
        
        // Date validation
        if (filters.date_from && filters.date_to) {
            const fromDate = new Date(filters.date_from);
            const toDate = new Date(filters.date_to);
            
            if (fromDate > toDate) {
                errors.date_range = 'Başlangıç tarihi bitiş tarihinden sonra olamaz';
            }
        }
        
        // Score validation
        if (filters.min_score && filters.max_score) {
            const minScore = parseInt(filters.min_score);
            const maxScore = parseInt(filters.max_score);
            
            if (minScore > maxScore) {
                errors.score_range = 'Minimum puan maksimum puandan büyük olamaz';
            }
        }
        
        // Conversion probability validation
        if (filters.conversion_probability_min && filters.conversion_probability_max) {
            const min = parseInt(filters.conversion_probability_min);
            const max = parseInt(filters.conversion_probability_max);
            
            if (min > max) {
                errors.conversion_range = 'Minimum olasılık maksimum olasılıktan büyük olamaz';
            }
        }
        
        return {
            isValid: Object.keys(errors).length === 0,
            errors
        };
    }
    
    /**
     * Export/Import filters
     */
    exportFilters() {
        return {
            filters: this.currentFilters,
            presets: this.filterPresets,
            version: '1.0',
            exported_at: new Date().toISOString()
        };
    }
    
    importFilters(data) {
        try {
            if (data.filters) {
                this.setFilters(data.filters);
            }
            
            if (data.presets && Array.isArray(data.presets)) {
                this.filterPresets = [...this.filterPresets, ...data.presets];
                this.savePresets();
            }
            
            return { success: true, message: 'Filtreler başarıyla içe aktarıldı' };
            
        } catch (error) {
            return { success: false, message: 'İçe aktarma başarısız: ' + error.message };
        }
    }
    
    /**
     * Utility methods
     */
    getTodayDate() {
        return new Date().toISOString().split('T')[0];
    }
    
    getWeekStartDate() {
        const today = new Date();
        const day = today.getDay();
        const diff = today.getDate() - day + (day === 0 ? -6 : 1); // Monday as start
        const monday = new Date(today.setDate(diff));
        return monday.toISOString().split('T')[0];
    }
    
    getMonthStartDate() {
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        return firstDay.toISOString().split('T')[0];
    }
    
    /**
     * Event system
     */
    emit(eventName, data) {
        const event = new CustomEvent(eventName, {
            detail: data,
            bubbles: true
        });
        
        document.dispatchEvent(event);
    }
    
    /**
     * Debounced filter update
     */
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}

// Global instance
window.filterManager = new FilterManager();

// Alpine.js integration helpers
window.filterManagerHelpers = {
    // Get current filters
    getCurrentFilters() {
        return window.filterManager.getCurrentFilters();
    },
    
    // Apply filters
    applyFilters() {
        this.filters = window.filterManager.getCurrentFilters();
        this.loadLeads();
    },
    
    // Clear all filters
    clearAllFilters() {
        window.filterManager.clearAllFilters();
        this.filters = window.filterManager.getCurrentFilters();
        this.loadLeads();
    },
    
    // Update single filter
    updateFilter(key, value) {
        window.filterManager.updateFilter(key, value);
        this.filters[key] = value;
        this.loadLeads();
    },
    
    // Get active filters count
    getActiveFiltersCount() {
        return window.filterManager.getActiveFiltersCount();
    },
    
    // Quick filters
    applyQuickFilter(quickFilterId) {
        const filters = window.filterManager.applyQuickFilter(quickFilterId);
        if (filters) {
            this.filters = filters;
            this.loadLeads();
        }
    },
    
    getQuickFilters() {
        return window.filterManager.getQuickFilters();
    },
    
    // Tag management
    addTag(tag) {
        if (window.filterManager.addTag(tag)) {
            this.filters.tags = [...window.filterManager.getCurrentFilters().tags];
            this.loadLeads();
        }
    },
    
    removeTag(tag) {
        if (window.filterManager.removeTag(tag)) {
            this.filters.tags = [...window.filterManager.getCurrentFilters().tags];
            this.loadLeads();
        }
    },
    
    getFilteredTags(input) {
        return window.filterManager.getFilteredTags(input);
    },
    
    // Preset management
    saveFilterPreset() {
        const name = prompt('Preset adını girin:');
        if (name) {
            try {
                const preset = window.filterManager.saveFilterPreset(name);
                this.filterPresets = window.filterManager.getFilterPresets();
                this.showNotification(`"${name}" preset'i kaydedildi`, 'success');
                return preset;
            } catch (error) {
                this.showNotification(error.message, 'error');
            }
        }
    },
    
    loadFilterPreset(presetId) {
        const preset = window.filterManager.loadFilterPreset(presetId);
        if (preset) {
            this.filters = window.filterManager.getCurrentFilters();
            this.loadLeads();
            this.showNotification(`"${preset.name}" preset'i yüklendi`, 'success');
        }
    },
    
    deleteFilterPreset(presetId) {
        if (confirm('Bu preset\'i silmek istediğinizden emin misiniz?')) {
            const deleted = window.filterManager.deleteFilterPreset(presetId);
            if (deleted) {
                this.filterPresets = window.filterManager.getFilterPresets();
                this.showNotification(`"${deleted.name}" preset'i silindi`, 'success');
            }
        }
    },
    
    getFilterPresets() {
        return window.filterManager.getFilterPresets();
    },
    
    // Search history
    addToSearchHistory(query) {
        window.filterManager.addToSearchHistory(query);
    },
    
    getSearchHistory() {
        return window.filterManager.getSearchHistory();
    },
    
    // Export filtered data
    async exportFilteredData() {
        try {
            const filters = window.filterManager.getCurrentFilters();
            await window.leadsTableManager.exportLeads('excel', filters);
            this.showNotification('Filtrelenmiş veriler export ediliyor...', 'success');
        } catch (error) {
            this.showNotification('Export işlemi başarısız', 'error');
        }
    },
    
    // Initialize filters in Alpine component
    initializeFilters() {
        this.filters = window.filterManager.getCurrentFilters();
        this.filterPresets = window.filterManager.getFilterPresets();
        
        // Load initial data
        this.loadLeads();
    }
};

export default FilterManager;