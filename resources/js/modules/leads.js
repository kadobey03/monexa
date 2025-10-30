/**
 * Leads Module - Modern Vanilla JavaScript Implementation
 * Complete lead management system with modern ES6+ patterns
 */

import { CSRFManager } from '../utils/csrf-manager.js';
import { NotificationManager } from '../utils/notification-manager.js';

/**
 * Leads Module Main Class
 */
class LeadsModule {
    constructor() {
        this.initialized = false;
        this.container = null;
        this.eventListeners = [];
        
        // State management
        this.state = {
            leads: [],
            selectedLeads: [],
            totalLeads: 0,
            currentPage: 1,
            totalPages: 1,
            perPage: 25,
            loading: false,
            searchQuery: '',
            filters: {
                status: '',
                source: '',
                assigned_to: '',
                priority: '',
                date_from: '',
                date_to: '',
                country: '',
                tags: []
            },
            sortColumn: 'created_at',
            sortDirection: 'desc',
            
            // UI State
            showFilters: false,
            showColumnSettings: false,
            showBulkActions: false,
            
            // Modal states
            showLeadModal: false,
            showEditModal: false,
            selectedLead: null
        };

        // Managers
        this.dataManager = null;
        this.tableManager = null;
        this.filterManager = null;
        this.bulkActionManager = null;
    }

    /**
     * Initialize the leads module
     */
    async init() {
        if (this.initialized) return;

        this.container = document.querySelector('[data-leads-table]');
        if (!this.container) {
            console.log('Leads table container not found, skipping initialization');
            return;
        }

        console.log('🎯 Leads Module initializing...');

        try {
            await this.initializeManagers();
            this.setupEventListeners();
            this.setupKeyboardShortcuts();
            await this.loadInitialData();
            
            this.initialized = true;
            console.log('✅ Leads Module initialized successfully');
            
        } catch (error) {
            console.error('❌ Leads Module initialization failed:', error);
            NotificationManager.error('Lead yönetim sistemi başlatılamadı');
        }
    }

    /**
     * Initialize sub-managers
     */
    async initializeManagers() {
        this.dataManager = new LeadsDataManager(this);
        this.tableManager = new LeadsTableManager(this);
        this.filterManager = new LeadsFilterManager(this);
        this.bulkActionManager = new LeadsBulkActionManager(this);

        await Promise.all([
            this.dataManager.init(),
            this.tableManager.init(),
            this.filterManager.init(),
            this.bulkActionManager.init()
        ]);
    }

    /**
     * Setup event listeners
     */
    setupEventListeners() {
        // Search functionality
        const searchInput = this.container.querySelector('[data-search-input]');
        if (searchInput) {
            const handler = this.debounce(() => this.handleSearch(), 300);
            searchInput.addEventListener('input', handler);
            this.addEventListenerTracker(searchInput, 'input', handler);
        }

        // Filter toggle
        const filterToggle = this.container.querySelector('[data-toggle-filters]');
        if (filterToggle) {
            const handler = () => this.toggleFilters();
            filterToggle.addEventListener('click', handler);
            this.addEventListenerTracker(filterToggle, 'click', handler);
        }

        // Column settings toggle
        const columnToggle = this.container.querySelector('[data-toggle-columns]');
        if (columnToggle) {
            const handler = () => this.toggleColumnSettings();
            columnToggle.addEventListener('click', handler);
            this.addEventListenerTracker(columnToggle, 'click', handler);
        }

        // Export buttons
        const exportBtns = this.container.querySelectorAll('[data-export]');
        exportBtns.forEach(btn => {
            const handler = () => this.exportLeads(btn.dataset.export);
            btn.addEventListener('click', handler);
            this.addEventListenerTracker(btn, 'click', handler);
        });

        // Refresh button
        const refreshBtn = this.container.querySelector('[data-refresh]');
        if (refreshBtn) {
            const handler = () => this.refreshData();
            refreshBtn.addEventListener('click', handler);
            this.addEventListenerTracker(refreshBtn, 'click', handler);
        }
    }

    /**
     * Setup keyboard shortcuts
     */
    setupKeyboardShortcuts() {
        const handler = (e) => {
            // Only work if we're in the leads area and not in input fields
            if (!this.container.contains(document.activeElement) || 
                ['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName)) {
                return;
            }

            switch (e.key) {
                case 'f':
                case 'F':
                    if (e.ctrlKey || e.metaKey) {
                        e.preventDefault();
                        this.toggleFilters();
                    }
                    break;
                    
                case 'r':
                case 'R':
                    if (e.ctrlKey || e.metaKey) {
                        e.preventDefault();
                        this.refreshData();
                    }
                    break;
                    
                case 'a':
                case 'A':
                    if (e.ctrlKey || e.metaKey) {
                        e.preventDefault();
                        this.selectAllLeads();
                    }
                    break;
                    
                case 'Escape':
                    this.closeModals();
                    this.clearSelection();
                    break;
            }
        };

        document.addEventListener('keydown', handler);
        this.addEventListenerTracker(document, 'keydown', handler);
    }

    /**
     * Load initial data
     */
    async loadInitialData() {
        await this.dataManager.loadLeads();
        this.renderTable();
        this.updateUI();
    }

    /**
     * Data operations
     */
    async handleSearch() {
        const searchInput = this.container.querySelector('[data-search-input]');
        this.state.searchQuery = searchInput ? searchInput.value : '';
        this.state.currentPage = 1;
        await this.dataManager.loadLeads();
        this.renderTable();
        this.updateUI();
    }

    async applyFilters(filters) {
        this.state.filters = { ...this.state.filters, ...filters };
        this.state.currentPage = 1;
        await this.dataManager.loadLeads();
        this.renderTable();
        this.updateUI();
    }

    async sortBy(column) {
        if (this.state.sortColumn === column) {
            this.state.sortDirection = this.state.sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            this.state.sortColumn = column;
            this.state.sortDirection = 'asc';
        }
        
        await this.dataManager.loadLeads();
        this.renderTable();
        this.updateUI();
    }

    async changePage(page) {
        if (page >= 1 && page <= this.state.totalPages) {
            this.state.currentPage = page;
            await this.dataManager.loadLeads();
            this.renderTable();
            this.updateUI();
        }
    }

    async changePerPage(perPage) {
        this.state.perPage = parseInt(perPage);
        this.state.currentPage = 1;
        await this.dataManager.loadLeads();
        this.renderTable();
        this.updateUI();
    }

    /**
     * UI operations
     */
    toggleFilters() {
        this.state.showFilters = !this.state.showFilters;
        this.updateFiltersPanel();
    }

    toggleColumnSettings() {
        this.state.showColumnSettings = !this.state.showColumnSettings;
        this.updateColumnSettings();
    }

    selectAllLeads() {
        if (this.state.selectedLeads.length === this.state.leads.length) {
            this.state.selectedLeads = [];
        } else {
            this.state.selectedLeads = [...this.state.leads.map(lead => lead.id)];
        }
        this.updateBulkActions();
        this.updateTableSelection();
    }

    toggleLeadSelection(leadId) {
        const index = this.state.selectedLeads.indexOf(leadId);
        if (index > -1) {
            this.state.selectedLeads.splice(index, 1);
        } else {
            this.state.selectedLeads.push(leadId);
        }
        this.updateBulkActions();
        this.updateTableSelection();
    }

    clearSelection() {
        this.state.selectedLeads = [];
        this.updateBulkActions();
        this.updateTableSelection();
    }

    closeModals() {
        this.state.showLeadModal = false;
        this.state.showEditModal = false;
        this.state.selectedLead = null;
        this.updateModals();
    }

    /**
     * Export functionality
     */
    async exportLeads(format = 'excel') {
        try {
            const params = new URLSearchParams({
                format,
                search: this.state.searchQuery,
                ...this.state.filters,
                selected_ids: this.state.selectedLeads.join(',')
            });

            const response = await CSRFManager.get(`/admin/leads/export?${params}`, {
                responseType: 'blob'
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
                
                NotificationManager.success(`${format.toUpperCase()} dosyası indiriliyor...`);
            }
        } catch (error) {
            console.error('Export error:', error);
            NotificationManager.error('Export işlemi başarısız');
        }
    }

    /**
     * Render methods
     */
    renderTable() {
        if (this.tableManager) {
            this.tableManager.render();
        }
    }

    updateUI() {
        this.updateCounters();
        this.updatePagination();
        this.updateSortIndicators();
    }

    updateCounters() {
        const counter = this.container.querySelector('[data-results-counter]');
        if (counter) {
            counter.textContent = `${this.state.totalLeads} lead`;
        }

        const selectedCounter = this.container.querySelector('[data-selected-counter]');
        if (selectedCounter) {
            selectedCounter.textContent = `${this.state.selectedLeads.length} seçili`;
        }
    }

    updatePagination() {
        const pagination = this.container.querySelector('[data-pagination]');
        if (pagination && this.state.totalPages > 1) {
            pagination.innerHTML = this.generatePaginationHTML();
            this.setupPaginationEvents();
        }
    }

    updateSortIndicators() {
        const headers = this.container.querySelectorAll('[data-sort]');
        headers.forEach(header => {
            const column = header.dataset.sort;
            const indicator = header.querySelector('.sort-indicator');
            
            if (indicator) {
                if (column === this.state.sortColumn) {
                    indicator.className = `sort-indicator active ${this.state.sortDirection}`;
                } else {
                    indicator.className = 'sort-indicator';
                }
            }
        });
    }

    updateBulkActions() {
        this.state.showBulkActions = this.state.selectedLeads.length > 0;
        const bulkPanel = this.container.querySelector('[data-bulk-actions]');
        
        if (bulkPanel) {
            bulkPanel.style.display = this.state.showBulkActions ? 'block' : 'none';
            
            const countElement = bulkPanel.querySelector('[data-selected-count]');
            if (countElement) {
                countElement.textContent = this.state.selectedLeads.length;
            }
        }
    }

    updateTableSelection() {
        const checkboxes = this.container.querySelectorAll('input[data-lead-checkbox]');
        const selectAllCheckbox = this.container.querySelector('[data-select-all]');
        
        checkboxes.forEach(checkbox => {
            const leadId = parseInt(checkbox.dataset.leadCheckbox);
            checkbox.checked = this.state.selectedLeads.includes(leadId);
        });

        if (selectAllCheckbox) {
            selectAllCheckbox.checked = this.state.selectedLeads.length === this.state.leads.length && this.state.leads.length > 0;
        }
    }

    updateFiltersPanel() {
        const panel = this.container.querySelector('[data-filters-panel]');
        if (panel) {
            panel.style.display = this.state.showFilters ? 'block' : 'none';
        }
    }

    updateColumnSettings() {
        const panel = this.container.querySelector('[data-column-settings]');
        if (panel) {
            panel.style.display = this.state.showColumnSettings ? 'block' : 'none';
        }
    }

    updateModals() {
        const leadModal = this.container.querySelector('[data-lead-modal]');
        if (leadModal) {
            leadModal.style.display = this.state.showLeadModal ? 'block' : 'none';
        }

        const editModal = this.container.querySelector('[data-edit-modal]');
        if (editModal) {
            editModal.style.display = this.state.showEditModal ? 'block' : 'none';
        }
    }

    /**
     * Helper methods
     */
    generatePaginationHTML() {
        const pages = this.getVisiblePages();
        
        return `
            <nav class="flex items-center justify-between">
                <div class="hidden sm:block">
                    <p class="text-sm text-gray-700">
                        Showing ${((this.state.currentPage - 1) * this.state.perPage) + 1} to 
                        ${Math.min(this.state.currentPage * this.state.perPage, this.state.totalLeads)} of 
                        ${this.state.totalLeads} results
                    </p>
                </div>
                <div class="flex space-x-1">
                    ${pages.map(page => {
                        if (page === '...') {
                            return '<span class="px-3 py-2 text-gray-500">...</span>';
                        }
                        return `
                            <button data-page="${page}" 
                                    class="px-3 py-2 rounded ${page === this.state.currentPage ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'}">
                                ${page}
                            </button>
                        `;
                    }).join('')}
                </div>
            </nav>
        `;
    }

    getVisiblePages() {
        const pages = [];
        const current = this.state.currentPage;
        const total = this.state.totalPages;

        if (total <= 7) {
            for (let i = 1; i <= total; i++) {
                pages.push(i);
            }
        } else {
            if (current <= 4) {
                for (let i = 1; i <= 5; i++) pages.push(i);
                pages.push('...');
                pages.push(total);
            } else if (current >= total - 3) {
                pages.push(1);
                pages.push('...');
                for (let i = total - 4; i <= total; i++) pages.push(i);
            } else {
                pages.push(1);
                pages.push('...');
                for (let i = current - 1; i <= current + 1; i++) pages.push(i);
                pages.push('...');
                pages.push(total);
            }
        }

        return pages;
    }

    setupPaginationEvents() {
        const pageButtons = this.container.querySelectorAll('[data-page]');
        pageButtons.forEach(btn => {
            const handler = () => {
                const page = parseInt(btn.dataset.page);
                if (page && page !== this.state.currentPage) {
                    this.changePage(page);
                }
            };
            btn.addEventListener('click', handler);
        });
    }

    async refreshData() {
        this.state.loading = true;
        try {
            await this.dataManager.loadLeads();
            this.renderTable();
            this.updateUI();
            NotificationManager.success('Veriler yenilendi');
        } catch (error) {
            NotificationManager.error('Veriler yenilenirken hata oluştu');
        } finally {
            this.state.loading = false;
        }
    }

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

    addEventListenerTracker(element, event, handler) {
        this.eventListeners.push({ element, event, handler });
    }

    /**
     * Cleanup resources
     */
    cleanup() {
        // Remove event listeners
        this.eventListeners.forEach(({ element, event, handler }) => {
            element.removeEventListener(event, handler);
        });
        this.eventListeners = [];

        // Cleanup managers
        [this.dataManager, this.tableManager, this.filterManager, this.bulkActionManager].forEach(manager => {
            if (manager && manager.cleanup) {
                manager.cleanup();
            }
        });

        this.initialized = false;
        console.log('🧹 Leads Module cleaned up');
    }
}

/**
 * Simplified manager classes for leads
 */
class LeadsDataManager {
    constructor(module) {
        this.module = module;
    }

    async init() {
        console.log('✅ Leads Data Manager initialized');
    }

    async loadLeads() {
        try {
            const params = new URLSearchParams({
                page: this.module.state.currentPage,
                per_page: this.module.state.perPage,
                search: this.module.state.searchQuery,
                sort_column: this.module.state.sortColumn,
                sort_direction: this.module.state.sortDirection,
                ...this.module.state.filters
            });

            const response = await CSRFManager.get(`/admin/leads/api?${params}`);
            const data = await response.json();

            if (data.success) {
                this.module.state.leads = data.data.data || [];
                this.module.state.totalLeads = data.data.total || 0;
                this.module.state.totalPages = data.data.last_page || 1;
                this.module.state.currentPage = data.data.current_page || 1;
            }
        } catch (error) {
            console.error('Error loading leads:', error);
            throw error;
        }
    }

    cleanup() {
        console.log('🧹 Leads Data Manager cleaned up');
    }
}

class LeadsTableManager {
    constructor(module) {
        this.module = module;
    }

    async init() {
        console.log('✅ Leads Table Manager initialized');
    }

    render() {
        const tbody = this.module.container.querySelector('[data-table-body]');
        if (!tbody) return;

        if (this.module.state.leads.length === 0) {
            tbody.innerHTML = '<tr><td colspan="10" class="text-center py-8">Hiç lead bulunamadı</td></tr>';
            return;
        }

        tbody.innerHTML = this.module.state.leads.map(lead => this.renderRow(lead)).join('');
        this.setupRowEvents();
    }

    renderRow(lead) {
        return `
            <tr data-lead-id="${lead.id}" class="border-b hover:bg-gray-50">
                <td class="px-4 py-3">
                    <input type="checkbox" data-lead-checkbox="${lead.id}" 
                           class="rounded border-gray-300 text-blue-600">
                </td>
                <td class="px-4 py-3">${lead.country || ''}</td>
                <td class="px-4 py-3 font-medium">${lead.name || ''}</td>
                <td class="px-4 py-3">${lead.phone || ''}</td>
                <td class="px-4 py-3">${lead.email || ''}</td>
                <td class="px-4 py-3">${lead.assigned_to || ''}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 text-xs rounded-full ${this.getStatusClass(lead.status)}">
                        ${this.getStatusLabel(lead.status)}
                    </span>
                </td>
                <td class="px-4 py-3">${lead.organization || ''}</td>
                <td class="px-4 py-3">${lead.source || ''}</td>
                <td class="px-4 py-3">
                    <div class="flex space-x-2">
                        <button data-action="edit" data-lead-id="${lead.id}" 
                                class="text-blue-600 hover:text-blue-800">Edit</button>
                        <button data-action="delete" data-lead-id="${lead.id}" 
                                class="text-red-600 hover:text-red-800">Delete</button>
                    </div>
                </td>
            </tr>
        `;
    }

    setupRowEvents() {
        // Selection checkboxes
        const checkboxes = this.module.container.querySelectorAll('[data-lead-checkbox]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                const leadId = parseInt(e.target.dataset.leadCheckbox);
                this.module.toggleLeadSelection(leadId);
            });
        });

        // Action buttons
        const actionButtons = this.module.container.querySelectorAll('[data-action]');
        actionButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const action = e.target.dataset.action;
                const leadId = parseInt(e.target.dataset.leadId);
                this.handleAction(action, leadId);
            });
        });
    }

    async handleAction(action, leadId) {
        switch (action) {
            case 'edit':
                // Open edit modal
                break;
            case 'delete':
                const confirmed = await NotificationManager.confirm(
                    'Lead Silme',
                    'Bu lead\'i silmek istediğinizden emin misiniz?'
                );
                if (confirmed) {
                    await this.deleteLead(leadId);
                }
                break;
        }
    }

    async deleteLead(leadId) {
        try {
            await CSRFManager.delete(`/admin/leads/${leadId}`);
            NotificationManager.success('Lead başarıyla silindi');
            await this.module.dataManager.loadLeads();
            this.module.renderTable();
        } catch (error) {
            NotificationManager.error('Lead silinirken hata oluştu');
        }
    }

    getStatusClass(status) {
        const classes = {
            'new': 'bg-blue-100 text-blue-800',
            'contacted': 'bg-yellow-100 text-yellow-800',
            'qualified': 'bg-green-100 text-green-800',
            'converted': 'bg-purple-100 text-purple-800',
            'lost': 'bg-red-100 text-red-800'
        };
        return classes[status] || 'bg-gray-100 text-gray-800';
    }

    getStatusLabel(status) {
        const labels = {
            'new': 'Yeni',
            'contacted': 'İletişimde',
            'qualified': 'Nitelikli',
            'converted': 'Dönüştürüldü',
            'lost': 'Kaybedilen'
        };
        return labels[status] || status || 'Bilinmeyen';
    }

    cleanup() {
        console.log('🧹 Leads Table Manager cleaned up');
    }
}

class LeadsFilterManager {
    constructor(module) {
        this.module = module;
    }

    async init() {
        console.log('✅ Leads Filter Manager initialized');
    }

    cleanup() {
        console.log('🧹 Leads Filter Manager cleaned up');
    }
}

class LeadsBulkActionManager {
    constructor(module) {
        this.module = module;
    }

    async init() {
        console.log('✅ Leads Bulk Action Manager initialized');
    }

    cleanup() {
        console.log('🧹 Leads Bulk Action Manager cleaned up');
    }
}

// Global functions for backward compatibility
window.LeadsModule = LeadsModule;
window.toggleLeadSelection = (leadId) => {
    if (window.leadsModuleInstance) {
        window.leadsModuleInstance.toggleLeadSelection(leadId);
    }
};

export { LeadsModule };
export default LeadsModule;