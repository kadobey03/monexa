/**
 * Leads Table Manager
 * Ana tablo yönetimi ve AJAX işlemleri için merkezi sınıf
 */
class LeadsTableManager {
    constructor() {
        this.apiEndpoints = {
            list: '/admin/dashboard/leads/api/data',
            show: '/admin/leads/{id}',
            store: '/admin/leads',
            update: '/admin/leads/{id}',
            delete: '/admin/leads/{id}',
            bulkUpdate: '/admin/leads/bulk-update',
            bulkDelete: '/admin/leads/bulk-delete',
            export: '/admin/leads/export'
        };
        
        this.currentRequest = null;
        this.cache = new Map();
        this.cacheTimeout = 300000; // 5 minutes
        
        // Event listeners
        this.listeners = {
            leadUpdated: [],
            leadDeleted: [],
            bulkActionCompleted: [],
            dataLoaded: []
        };
        
        this.init();
    }
    
    init() {
        this.setupCSRF();
        this.setupInterceptors();
    }
    
    setupCSRF() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        if (!this.csrfToken) {
            console.error('CSRF token not found');
        }
    }
    
    setupInterceptors() {
        // Fetch interceptor for automatic error handling
        const originalFetch = window.fetch;
        
        window.fetch = async (...args) => {
            try {
                const response = await originalFetch.apply(window, args);
                
                if (!response.ok) {
                    await this.handleError(response);
                    throw new Error(`HTTP Error: ${response.status}`);
                }
                
                return response;
            } catch (error) {
                this.handleNetworkError(error);
                throw error;
            }
        };
    }
    
    /**
     * Load leads with pagination and filters
     * @param {Object} params - Search and filter parameters
     * @returns {Promise<Object>} API response
     */
    async loadLeads(params = {}) {
        // Cancel previous request if still pending
        if (this.currentRequest) {
            this.currentRequest.abort();
        }
        
        const controller = new AbortController();
        this.currentRequest = controller;
        
        try {
            const queryParams = new URLSearchParams({
                page: params.page || 1,
                per_page: params.per_page || 25,
                search: params.search || '',
                sort_by: params.sort_by || 'created_at',
                sort_direction: params.sort_direction || 'desc',
                ...params.filters
            });
            
            // Check cache first
            const cacheKey = queryParams.toString();
            const cached = this.getFromCache(cacheKey);
            
            if (cached) {
                this.emit('dataLoaded', cached);
                return cached;
            }
            
            const response = await fetch(`${this.apiEndpoints.list}?${queryParams}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                signal: controller.signal
            });
            
            const data = await response.json();
            
            // Cache the response
            this.setCache(cacheKey, data);
            
            // Emit event
            this.emit('dataLoaded', data);
            
            return data;
            
        } catch (error) {
            if (error.name !== 'AbortError') {
                console.error('Error loading leads:', error);
                throw error;
            }
        } finally {
            this.currentRequest = null;
        }
    }
    
    /**
     * Get single lead by ID
     * @param {number} id - Lead ID
     * @returns {Promise<Object>} Lead data
     */
    async getLead(id) {
        const cacheKey = `lead_${id}`;
        const cached = this.getFromCache(cacheKey);
        
        if (cached) {
            return cached;
        }
        
        try {
            const response = await fetch(this.apiEndpoints.show.replace('{id}', id), {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const data = await response.json();
            
            // Cache the lead data
            this.setCache(cacheKey, data, 600000); // 10 minutes for single items
            
            return data;
            
        } catch (error) {
            console.error('Error loading lead:', error);
            throw error;
        }
    }
    
    /**
     * Create new lead
     * @param {Object} leadData - Lead information
     * @returns {Promise<Object>} Created lead
     */
    async createLead(leadData) {
        try {
            const response = await fetch(this.apiEndpoints.store, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(leadData)
            });
            
            const data = await response.json();
            
            // Clear cache to ensure fresh data
            this.clearCache();
            
            this.emit('leadUpdated', { action: 'created', lead: data });
            
            return data;
            
        } catch (error) {
            console.error('Error creating lead:', error);
            throw error;
        }
    }
    
    /**
     * Update existing lead
     * @param {number} id - Lead ID
     * @param {Object} leadData - Updated lead information
     * @returns {Promise<Object>} Updated lead
     */
    async updateLead(id, leadData) {
        try {
            const response = await fetch(this.apiEndpoints.update.replace('{id}', id), {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(leadData)
            });
            
            const data = await response.json();
            
            // Update cache
            this.setCache(`lead_${id}`, data, 600000);
            this.clearCache(); // Clear list cache
            
            this.emit('leadUpdated', { action: 'updated', lead: data });
            
            return data;
            
        } catch (error) {
            console.error('Error updating lead:', error);
            throw error;
        }
    }
    
    /**
     * Delete lead
     * @param {number} id - Lead ID
     * @returns {Promise<boolean>} Success status
     */
    async deleteLead(id) {
        try {
            await fetch(this.apiEndpoints.delete.replace('{id}', id), {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            // Clear cache
            this.removeFromCache(`lead_${id}`);
            this.clearCache();
            
            this.emit('leadDeleted', { id });
            
            return true;
            
        } catch (error) {
            console.error('Error deleting lead:', error);
            throw error;
        }
    }
    
    /**
     * Perform bulk operations
     * @param {string} action - Action type (update, delete, assign)
     * @param {Array} leadIds - Array of lead IDs
     * @param {Object} data - Action specific data
     * @returns {Promise<Object>} Operation result
     */
    async bulkAction(action, leadIds, data = {}) {
        const endpoint = action === 'delete' ? this.apiEndpoints.bulkDelete : this.apiEndpoints.bulkUpdate;
        
        try {
            const response = await fetch(endpoint, {
                method: action === 'delete' ? 'DELETE' : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    action,
                    lead_ids: leadIds,
                    ...data
                })
            });
            
            const result = await response.json();
            
            // Clear cache
            this.clearCache();
            
            this.emit('bulkActionCompleted', { action, leadIds, result });
            
            return result;
            
        } catch (error) {
            console.error('Error performing bulk action:', error);
            throw error;
        }
    }
    
    /**
     * Export leads data
     * @param {string} format - Export format (excel, csv)
     * @param {Object} filters - Current filters to apply
     * @returns {Promise<void>} Triggers download
     */
    async exportLeads(format = 'excel', filters = {}) {
        try {
            const queryParams = new URLSearchParams({
                format,
                ...filters
            });
            
            const response = await fetch(`${this.apiEndpoints.export}?${queryParams}`, {
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (response.ok) {
                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                
                a.href = url;
                a.download = `leads_${new Date().toISOString().split('T')[0]}.${format === 'excel' ? 'xlsx' : 'csv'}`;
                document.body.appendChild(a);
                a.click();
                
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            }
            
        } catch (error) {
            console.error('Error exporting leads:', error);
            throw error;
        }
    }
    
    // Cache management
    setCache(key, data, timeout = this.cacheTimeout) {
        this.cache.set(key, {
            data,
            timestamp: Date.now(),
            timeout
        });
    }
    
    getFromCache(key) {
        const cached = this.cache.get(key);
        
        if (cached && (Date.now() - cached.timestamp) < cached.timeout) {
            return cached.data;
        }
        
        if (cached) {
            this.cache.delete(key);
        }
        
        return null;
    }
    
    removeFromCache(key) {
        this.cache.delete(key);
    }
    
    clearCache() {
        this.cache.clear();
    }
    
    // Event system
    on(event, callback) {
        if (!this.listeners[event]) {
            this.listeners[event] = [];
        }
        this.listeners[event].push(callback);
    }
    
    off(event, callback) {
        if (!this.listeners[event]) return;
        
        const index = this.listeners[event].indexOf(callback);
        if (index > -1) {
            this.listeners[event].splice(index, 1);
        }
    }
    
    emit(event, data) {
        if (!this.listeners[event]) return;
        
        this.listeners[event].forEach(callback => {
            try {
                callback(data);
            } catch (error) {
                console.error(`Error in event listener for ${event}:`, error);
            }
        });
    }
    
    // Error handling
    async handleError(response) {
        const contentType = response.headers.get('content-type');
        
        if (contentType && contentType.includes('application/json')) {
            const errorData = await response.json();
            console.error('API Error:', errorData);
            
            if (errorData.message) {
                this.showNotification(errorData.message, 'error');
            }
        } else {
            console.error('HTTP Error:', response.status, response.statusText);
            this.showNotification(`Sunucu hatası: ${response.status}`, 'error');
        }
    }
    
    handleNetworkError(error) {
        console.error('Network Error:', error);
        
        if (error.name === 'AbortError') {
            return; // Request was cancelled
        }
        
        this.showNotification('Bağlantı hatası. İnternet bağlantınızı kontrol edin.', 'error');
    }
    
    showNotification(message, type = 'info') {
        // Integrate with Alpine.js notification system if available
        const alpineComponent = document.querySelector('[x-data*="leadsTableData"]');
        
        if (alpineComponent && alpineComponent._x_dataStack) {
            const data = alpineComponent._x_dataStack[0];
            if (data.showNotification) {
                data.showNotification(message, type);
                return;
            }
        }
        
        // Fallback to console or custom notification
        console.log(`${type.toUpperCase()}: ${message}`);
    }
    
    // Utility methods
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
    
    throttle(func, limit) {
        let inThrottle;
        return function(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }
}

// Global instance
window.leadsTableManager = new LeadsTableManager();

// Core functions for Alpine.js integration
window.leadsTableCore = {
    async loadLeads() {
        this.loading = true;
        
        try {
            const params = {
                page: this.currentPage,
                per_page: this.perPage,
                search: this.searchQuery,
                sort_by: this.sortBy,
                sort_direction: this.sortDirection,
                filters: this.filters
            };
            
            const response = await window.leadsTableManager.loadLeads(params);
            
            this.leads = response.data || [];
            this.totalLeads = response.total || 0;
            this.filteredCount = response.filtered_count || this.totalLeads;
            this.totalPages = Math.ceil(this.totalLeads / this.perPage);
            this.currentPage = response.current_page || 1;
            
            // Load additional data if needed
            if (!this.leadSources.length) {
                this.leadSources = response.lead_sources || [];
            }
            
            if (!this.adminUsers.length) {
                this.adminUsers = response.admin_users || [];
            }
            
        } catch (error) {
            this.showNotification('Lead\'ler yüklenemedi', 'error');
        } finally {
            this.loading = false;
        }
    },
    
    async searchLeads() {
        this.currentPage = 1;
        await this.loadLeads();
    },
    
    clearSearch() {
        this.searchQuery = '';
        this.searchLeads();
    },
    
    async applyFilters() {
        this.currentPage = 1;
        await this.loadLeads();
    },
    
    clearAllFilters() {
        this.filters = {
            status: '',
            source: '',
            assigned_to: '',
            priority: '',
            date_from: '',
            date_to: '',
            min_score: '',
            tags: [],
            custom_field: ''
        };
        this.applyFilters();
    },
    
    getActiveFiltersCount() {
        let count = 0;
        
        Object.entries(this.filters).forEach(([key, value]) => {
            if (Array.isArray(value)) {
                count += value.length;
            } else if (value && value !== '') {
                count++;
            }
        });
        
        return count;
    },
    
    // Pagination
    async goToPage(page) {
        this.currentPage = page;
        await this.loadLeads();
    },
    
    async nextPage() {
        if (this.currentPage < this.totalPages) {
            await this.goToPage(this.currentPage + 1);
        }
    },
    
    async previousPage() {
        if (this.currentPage > 1) {
            await this.goToPage(this.currentPage - 1);
        }
    },
    
    getVisiblePages() {
        const pages = [];
        const start = Math.max(1, this.currentPage - 2);
        const end = Math.min(this.totalPages, this.currentPage + 2);
        
        for (let i = start; i <= end; i++) {
            pages.push(i);
        }
        
        return pages;
    },
    
    // Selection
    toggleLeadSelection(leadId) {
        const index = this.selectedLeads.indexOf(leadId);
        
        if (index > -1) {
            this.selectedLeads.splice(index, 1);
        } else {
            this.selectedLeads.push(leadId);
        }
    },
    
    toggleAllSelection() {
        if (this.selectedLeads.length === this.leads.length) {
            this.selectedLeads = [];
        } else {
            this.selectedLeads = this.leads.map(lead => lead.id);
        }
    },
    
    clearSelection() {
        this.selectedLeads = [];
    },
    
    // Export
    async exportToExcel() {
        try {
            await window.leadsTableManager.exportLeads('excel', this.filters);
            this.showNotification('Excel dosyası indiriliyor...', 'success');
        } catch (error) {
            this.showNotification('Export işlemi başarısız', 'error');
        }
    },
    
    async exportToCSV() {
        try {
            await window.leadsTableManager.exportLeads('csv', this.filters);
            this.showNotification('CSV dosyası indiriliyor...', 'success');
        } catch (error) {
            this.showNotification('Export işlemi başarısız', 'error');
        }
    },
    
    async exportSelectedLeads() {
        if (this.selectedLeads.length === 0) {
            this.showNotification('Lütfen export edilecek lead\'leri seçin', 'warning');
            return;
        }
        
        try {
            const filters = { ...this.filters, lead_ids: this.selectedLeads };
            await window.leadsTableManager.exportLeads('excel', filters);
            this.showNotification('Seçilen lead\'ler export ediliyor...', 'success');
        } catch (error) {
            this.showNotification('Export işlemi başarısız', 'error');
        }
    },
    
    // Notifications
    showNotification(message, type = 'info') {
        this.notification = {
            show: true,
            message: message,
            type: type
        };
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            this.notification.show = false;
        }, 5000);
    },
    
    // Utility functions
    formatDate(dateString) {
        if (!dateString) return '';
        
        return new Date(dateString).toLocaleDateString('tr-TR', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        });
    },
    
    formatDateTime(dateString) {
        if (!dateString) return '';
        
        return new Date(dateString).toLocaleString('tr-TR', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        });
    },
    
    getStatusBadgeClass(status) {
        const classes = {
            'new': 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            'contacted': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'qualified': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'converted': 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
            'lost': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
        };
        
        return classes[status] || 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
    },
    
    getStatusLabel(status) {
        const labels = {
            'new': 'Yeni',
            'contacted': 'İletişimde',
            'qualified': 'Nitelikli',
            'converted': 'Dönüştürüldü',
            'lost': 'Kaybedilen'
        };
        
        return labels[status] || status;
    },
    
    getPriorityBadgeClass(priority) {
        const classes = {
            'low': 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300',
            'medium': 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            'high': 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300',
            'urgent': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
        };
        
        return classes[priority] || 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
    },
    
    getPriorityLabel(priority) {
        const labels = {
            'low': 'Düşük',
            'medium': 'Orta',
            'high': 'Yüksek',
            'urgent': 'Acil'
        };
        
        return labels[priority] || priority;
    },
    
    getLeadName(leadId) {
        const lead = this.leads.find(l => l.id === leadId);
        return lead ? lead.name : `Lead #${leadId}`;
    }
};

export default LeadsTableManager;