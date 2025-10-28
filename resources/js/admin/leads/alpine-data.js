/**
 * Alpine.js Data Function for Leads Table
 * This module provides the main data structure for the leads management interface
 */

// Import core modules
import { LeadsTableManager } from './LeadsTableManager.js';
import { ColumnManager } from './ColumnManager.js';
import { FilterManager } from './FilterManager.js';
import { BulkActionManager } from './BulkActionManager.js';

/**
 * Main Alpine.js data function for leads table
 * @returns {Object} Alpine.js reactive data object
 */
window.leadsTableData = function() {
    return {
        // Core Managers
        tableManager: null,
        columnManager: null,
        filterManager: null,
        bulkActionManager: null,

        // State Management
        leads: [],
        selectedLeads: [],
        totalLeads: 0,
        filteredCount: 0,
        currentPage: 1,
        totalPages: 1,
        perPage: 25,
        loading: false,
        
        // UI State
        showFilters: false,
        showColumnSettings: false,
        showLeadModal: false,
        showEditModal: false,
        selectedLead: null,
        
        // Search & Filters
        searchQuery: '',
        filters: {
            status: '',
            source: '',
            assigned_to: '',
            priority: '',
            date_from: '',
            date_to: '',
            min_score: '',
            tags: [],
            custom_field: ''
        },
        
        // Column Management
        visibleColumns: [],
        availableColumns: [
            { key: 'select', label: 'Seç', width: 50, resizable: false, pinnable: false, visible: true },
            { key: 'name', label: 'İsim', width: 200, resizable: true, pinnable: true, visible: true },
            { key: 'email', label: 'E-posta', width: 250, resizable: true, pinnable: true, visible: true },
            { key: 'phone', label: 'Telefon', width: 150, resizable: true, pinnable: false, visible: true },
            { key: 'status', label: 'Durum', width: 120, resizable: true, pinnable: false, visible: true },
            { key: 'priority', label: 'Öncelik', width: 100, resizable: true, pinnable: false, visible: true },
            { key: 'lead_score', label: 'Puan', width: 80, resizable: true, pinnable: false, visible: true },
            { key: 'assigned_to', label: 'Atanan', width: 150, resizable: true, pinnable: false, visible: true },
            { key: 'source', label: 'Kaynak', width: 120, resizable: true, pinnable: false, visible: true },
            { key: 'created_at', label: 'Eklenme Tarihi', width: 130, resizable: true, pinnable: false, visible: true },
            { key: 'actions', label: 'İşlemler', width: 150, resizable: false, pinnable: false, visible: true }
        ],
        pinnedColumns: [],
        
        // Data Sources
        leadSources: [],
        adminUsers: [],
        filterPresets: [],
        
        // Notification System
        notification: {
            show: false,
            message: '',
            type: 'info'
        },

        // Sorting & Ordering
        sortColumn: 'created_at',
        sortDirection: 'desc',
        
        /**
         * Initialize the table and all managers
         */
        async initializeTable() {
            console.log('Initializing leads table...');
            
            try {
                // Initialize core managers
                this.tableManager = new LeadsTableManager(this);
                this.columnManager = new ColumnManager(this);
                this.filterManager = new FilterManager(this);
                this.bulkActionManager = new BulkActionManager(this);

                // Load settings from localStorage
                this.loadSettings();
                
                // Load initial data (sources, admins, etc.)
                await this.loadInitialData();
                
                // Load leads data
                await this.loadLeads();
                
                console.log('Leads table initialized successfully');
            } catch (error) {
                console.error('Failed to initialize leads table:', error);
                this.showNotification('Tablo yüklenirken hata oluştu', 'error');
            }
        },

        /**
         * Load settings from localStorage
         */
        loadSettings() {
            try {
                // Load column preferences
                const savedColumns = localStorage.getItem('leads_table_columns');
                if (savedColumns) {
                    const columnData = JSON.parse(savedColumns);
                    this.availableColumns = this.availableColumns.map(col => {
                        const saved = columnData.find(c => c.key === col.key);
                        return saved ? { ...col, ...saved } : col;
                    });
                }

                // Load filter preferences
                const savedFilters = localStorage.getItem('leads_table_filters');
                if (savedFilters) {
                    this.filters = { ...this.filters, ...JSON.parse(savedFilters) };
                }

                // Load per page preference
                const savedPerPage = localStorage.getItem('leads_table_per_page');
                if (savedPerPage) {
                    this.perPage = parseInt(savedPerPage);
                }

                // Load sort preferences
                const savedSort = localStorage.getItem('leads_table_sort');
                if (savedSort) {
                    const { column, direction } = JSON.parse(savedSort);
                    this.sortColumn = column;
                    this.sortDirection = direction;
                }

                console.log('Settings loaded from localStorage');
            } catch (error) {
                console.warn('Failed to load settings from localStorage:', error);
            }
        },

        /**
         * Load initial data (sources, admins, etc.)
         */
        async loadInitialData() {
            try {
                // Load lead sources
                const sourcesResponse = await fetch('/admin/dashboard/leads/api/lead-sources');
                if (sourcesResponse.ok) {
                    const sourcesData = await sourcesResponse.json();
                    this.leadSources = sourcesData.success ? sourcesData.data : [];
                }

                // Load assignable admins
                const adminsResponse = await fetch('/admin/dashboard/leads/api/assignable-admins');
                if (adminsResponse.ok) {
                    const adminsData = await adminsResponse.json();
                    this.adminUsers = adminsData.success ? adminsData.data : [];
                }

                // Load filter presets
                const presetsResponse = await fetch('/admin/dashboard/leads/api/filter-presets');
                if (presetsResponse.ok) {
                    const presetsData = await presetsResponse.json();
                    this.filterPresets = presetsData.success ? presetsData.data : [];
                }

                console.log('Initial data loaded');
            } catch (error) {
                console.error('Failed to load initial data:', error);
                // Set empty arrays as fallback
                this.leadSources = [];
                this.adminUsers = [];
                this.filterPresets = [];
            }
        },

        /**
         * Load leads data
         */
        async loadLeads() {
            // Use the core function instead of tableManager
            await window.leadsTableCore.loadLeads.call(this);
        },

        /**
         * Search leads with debounced input
         */
        async searchLeads() {
            if (this.tableManager) {
                await this.tableManager.search(this.searchQuery);
            }
        },

        /**
         * Clear search query and reload
         */
        async clearSearch() {
            this.searchQuery = '';
            await this.searchLeads();
        },

        /**
         * Toggle lead selection
         */
        toggleLeadSelection(leadId) {
            if (this.bulkActionManager) {
                this.bulkActionManager.toggleSelection(leadId);
            }
        },

        /**
         * Select all visible leads
         */
        selectAllLeads() {
            if (this.bulkActionManager) {
                this.bulkActionManager.selectAll();
            }
        },

        /**
         * Clear all selections
         */
        clearSelection() {
            if (this.bulkActionManager) {
                this.bulkActionManager.clearSelection();
            }
        },

        /**
         * Get active filters count
         */
        getActiveFiltersCount() {
            if (this.filterManager) {
                return this.filterManager.getActiveFiltersCount();
            }
            return 0;
        },

        /**
         * Clear all filters
         */
        async clearAllFilters() {
            if (this.filterManager) {
                await this.filterManager.clearAllFilters();
            }
        },

        /**
         * Apply filters
         */
        async applyFilters() {
            if (this.filterManager) {
                await this.filterManager.applyFilters();
            }
        },

        /**
         * Sort table by column
         */
        async sortBy(column) {
            if (this.tableManager) {
                await this.tableManager.sortBy(column);
            }
        },

        /**
         * Pagination methods
         */
        async goToPage(page) {
            if (this.tableManager) {
                await this.tableManager.goToPage(page);
            }
        },

        async previousPage() {
            if (this.currentPage > 1) {
                await this.goToPage(this.currentPage - 1);
            }
        },

        async nextPage() {
            if (this.currentPage < this.totalPages) {
                await this.goToPage(this.currentPage + 1);
            }
        },

        /**
         * Get visible page numbers for pagination
         */
        getVisiblePages() {
            const pages = [];
            const totalPages = this.totalPages;
            const current = this.currentPage;

            if (totalPages <= 7) {
                for (let i = 1; i <= totalPages; i++) {
                    pages.push(i);
                }
            } else {
                if (current <= 4) {
                    for (let i = 1; i <= 5; i++) {
                        pages.push(i);
                    }
                    pages.push('...');
                    pages.push(totalPages);
                } else if (current >= totalPages - 3) {
                    pages.push(1);
                    pages.push('...');
                    for (let i = totalPages - 4; i <= totalPages; i++) {
                        pages.push(i);
                    }
                } else {
                    pages.push(1);
                    pages.push('...');
                    for (let i = current - 1; i <= current + 1; i++) {
                        pages.push(i);
                    }
                    pages.push('...');
                    pages.push(totalPages);
                }
            }

            return pages;
        },

        /**
         * Export methods
         */
        async exportToExcel() {
            if (this.tableManager) {
                await this.tableManager.exportToExcel();
            }
        },

        async exportToCSV() {
            if (this.tableManager) {
                await this.tableManager.exportToCSV();
            }
        },

        /**
         * Modal methods
         */
        openLeadModal(lead = null) {
            this.selectedLead = lead;
            this.showLeadModal = true;
        },

        closeLeadModal() {
            this.selectedLead = null;
            this.showLeadModal = false;
        },

        openEditModal(lead = null) {
            this.selectedLead = lead;
            this.showEditModal = true;
        },

        closeEditModal() {
            this.selectedLead = null;
            this.showEditModal = false;
        },

        /**
         * Quick actions
         */
        async makeCall(phone) {
            if (phone) {
                window.location.href = `tel:${phone}`;
                // Log activity
                if (this.tableManager) {
                    await this.tableManager.logActivity(this.selectedLead?.id, 'call', `Telefon araması: ${phone}`);
                }
            }
        },

        async sendEmail(email) {
            if (email) {
                window.location.href = `mailto:${email}`;
                // Log activity
                if (this.tableManager) {
                    await this.tableManager.logActivity(this.selectedLead?.id, 'email', `E-posta gönderildi: ${email}`);
                }
            }
        },

        /**
         * Update lead status inline
         */
        async updateLeadStatus(leadId, newStatus) {
            if (this.tableManager) {
                await this.tableManager.updateLeadStatus(leadId, newStatus);
            }
        },

        /**
         * Update lead assignment inline
         */
        async updateLeadAssignment(leadId, newAssignee) {
            if (this.tableManager) {
                await this.tableManager.updateLeadAssignment(leadId, newAssignee);
            }
        },

        /**
         * Update lead priority inline
         */
        async updateLeadPriority(leadId, newPriority) {
            if (this.tableManager) {
                await this.tableManager.updateLeadPriority(leadId, newPriority);
            }
        },

        /**
         * Show notification
         */
        showNotification(message, type = 'info') {
            this.notification = {
                show: true,
                message: message,
                type: type
            };

            // Auto-hide after 5 seconds
            setTimeout(() => {
                this.notification.show = false;
            }, 5000);
        },

        /**
         * Column management methods
         */
        toggleColumnVisibility(columnKey) {
            if (this.columnManager) {
                this.columnManager.toggleVisibility(columnKey);
            }
        },

        updateColumnWidth(columnKey, width) {
            if (this.columnManager) {
                this.columnManager.updateWidth(columnKey, width);
            }
        },

        reorderColumns(fromIndex, toIndex) {
            if (this.columnManager) {
                this.columnManager.reorderColumns(fromIndex, toIndex);
            }
        },

        pinColumn(columnKey, position = 'left') {
            if (this.columnManager) {
                this.columnManager.pinColumn(columnKey, position);
            }
        },

        unpinColumn(columnKey) {
            if (this.columnManager) {
                this.columnManager.unpinColumn(columnKey);
            }
        },

        /**
         * Cleanup on page unload
         */
        cleanup() {
            // Save current state to localStorage
            this.saveSettings();
            
            // Cleanup managers
            if (this.tableManager) this.tableManager.cleanup();
            if (this.columnManager) this.columnManager.cleanup();
            if (this.filterManager) this.filterManager.cleanup();
            if (this.bulkActionManager) this.bulkActionManager.cleanup();
        },

        /**
         * Save current settings to localStorage
         */
        saveSettings() {
            try {
                localStorage.setItem('leads_table_columns', JSON.stringify(this.availableColumns));
                localStorage.setItem('leads_table_filters', JSON.stringify(this.filters));
                localStorage.setItem('leads_table_per_page', this.perPage.toString());
                localStorage.setItem('leads_table_sort', JSON.stringify({
                    column: this.sortColumn,
                    direction: this.sortDirection
                }));
                console.log('Settings saved to localStorage');
            } catch (error) {
                console.warn('Failed to save settings to localStorage:', error);
            }
        }
    }
};

// Auto-cleanup on page unload
window.addEventListener('beforeunload', () => {
    if (window.leadsTableInstance && typeof window.leadsTableInstance.cleanup === 'function') {
        window.leadsTableInstance.cleanup();
    }
});

console.log('Alpine.js leads table data function loaded');