/**
 * Leads Data Manager - Vanilla JavaScript Implementation
 * Modern vanilla JavaScript leads table yönetim sistemi
 */

// Import core modules
import { LeadsTableManager } from './LeadsTableManager.js';
import { ColumnManager } from './ColumnManager.js';
import { FilterManager } from './FilterManager.js';
import { BulkActionManager } from './BulkActionManager.js';

/**
 * Leads Table Data Manager Class
 */
class LeadsDataManager {
    constructor(containerElement) {
        this.container = containerElement;
        this.eventListeners = [];
        
        // Core Managers
        this.tableManager = null;
        this.columnManager = null;
        this.filterManager = null;
        this.bulkActionManager = null;

        // State Management
        this.state = {
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
                { key: 'select', label: 'Seç', width: 50, resizable: false, pinnable: false, visible: true, priority: 1 },
                { key: 'country', label: 'ÜLKE', width: 100, resizable: true, pinnable: false, visible: true, priority: 2 },
                { key: 'name', label: 'AD SOYAD', width: 180, resizable: true, pinnable: true, visible: true, priority: 3 },
                { key: 'phone', label: 'TELEFON NUMARASI', width: 150, resizable: true, pinnable: false, visible: true, priority: 4 },
                { key: 'email', label: 'EMAİL', width: 200, resizable: true, pinnable: true, visible: true, priority: 5 },
                { key: 'assigned_to', label: 'ASSIGNED', width: 140, resizable: true, pinnable: false, visible: true, priority: 6 },
                { key: 'status', label: 'STATUS', width: 120, resizable: true, pinnable: false, visible: true, priority: 7 },
                { key: 'organization', label: 'VARONKA', width: 150, resizable: true, pinnable: false, visible: true, priority: 8 },
                { key: 'source', label: 'KAYNAK', width: 120, resizable: true, pinnable: false, visible: true, priority: 9 },
                { key: 'company_name', label: 'ŞİRKET', width: 150, resizable: true, pinnable: false, visible: true, priority: 10 },
                { key: 'actions', label: 'İŞLEMLER', width: 100, resizable: false, pinnable: false, visible: true, priority: 11 }
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
            sortDirection: 'desc'
        };
        
        this.initialize();
    }

    /**
     * Initialize the table and all managers
     */
    async initialize() {
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
            
            // Setup event listeners
            this.setupEventListeners();
            
            console.log('Leads table initialized successfully');
        } catch (error) {
            console.error('Failed to initialize leads table:', error);
            this.showNotification('Tablo yüklenirken hata oluştu', 'error');
        }
    }

    /**
     * Setup all event listeners
     */
    setupEventListeners() {
        // Search input
        const searchInput = this.container.querySelector('[data-search-input]');
        if (searchInput) {
            const searchHandler = this.debounce((e) => this.searchLeads(), 300);
            searchInput.addEventListener('input', searchHandler);
            this.addEventListenerTracker(searchInput, 'input', searchHandler);
        }

        // Filter toggles
        const filterToggle = this.container.querySelector('[data-filter-toggle]');
        if (filterToggle) {
            const handler = () => this.toggleFilters();
            filterToggle.addEventListener('click', handler);
            this.addEventListenerTracker(filterToggle, 'click', handler);
        }

        // Column settings toggle
        const columnToggle = this.container.querySelector('[data-column-toggle]');
        if (columnToggle) {
            const handler = () => this.toggleColumnSettings();
            columnToggle.addEventListener('click', handler);
            this.addEventListenerTracker(columnToggle, 'click', handler);
        }

        // Pagination events
        this.setupPaginationEvents();
        
        // Bulk selection events
        this.setupBulkSelectionEvents();
    }

    /**
     * Setup pagination event listeners
     */
    setupPaginationEvents() {
        // Previous page
        const prevButton = this.container.querySelector('[data-prev-page]');
        if (prevButton) {
            const handler = () => this.previousPage();
            prevButton.addEventListener('click', handler);
            this.addEventListenerTracker(prevButton, 'click', handler);
        }

        // Next page
        const nextButton = this.container.querySelector('[data-next-page]');
        if (nextButton) {
            const handler = () => this.nextPage();
            nextButton.addEventListener('click', handler);
            this.addEventListenerTracker(nextButton, 'click', handler);
        }

        // Page number buttons (dynamic, will be updated when pages render)
    }

    /**
     * Setup bulk selection event listeners
     */
    setupBulkSelectionEvents() {
        // Select all checkbox
        const selectAllCheckbox = this.container.querySelector('[data-select-all]');
        if (selectAllCheckbox) {
            const handler = (e) => {
                if (e.target.checked) {
                    this.selectAllLeads();
                } else {
                    this.clearSelection();
                }
            };
            selectAllCheckbox.addEventListener('change', handler);
            this.addEventListenerTracker(selectAllCheckbox, 'change', handler);
        }
    }

    /**
     * Add event listener and track it for cleanup
     */
    addEventListenerTracker(element, event, handler) {
        this.eventListeners.push({ element, event, handler });
    }

    /**
     * Load settings from localStorage
     */
    loadSettings() {
        try {
            // Load column preferences
            const savedColumns = localStorage.getItem('leads_table_columns');
            if (savedColumns) {
                const columnData = JSON.parse(savedColumns);
                this.state.availableColumns = this.state.availableColumns.map(col => {
                    const saved = columnData.find(c => c.key === col.key);
                    return saved ? { ...col, ...saved } : col;
                });
            }

            // Load filter preferences
            const savedFilters = localStorage.getItem('leads_table_filters');
            if (savedFilters) {
                this.state.filters = { ...this.state.filters, ...JSON.parse(savedFilters) };
            }

            // Load per page preference
            const savedPerPage = localStorage.getItem('leads_table_per_page');
            if (savedPerPage) {
                this.state.perPage = parseInt(savedPerPage);
            }

            // Load sort preferences
            const savedSort = localStorage.getItem('leads_table_sort');
            if (savedSort) {
                const { column, direction } = JSON.parse(savedSort);
                this.state.sortColumn = column;
                this.state.sortDirection = direction;
            }

            console.log('Settings loaded from localStorage');
        } catch (error) {
            console.warn('Failed to load settings from localStorage:', error);
        }
    }

    /**
     * Load initial data (sources, admins, etc.)
     */
    async loadInitialData() {
        try {
            // Load lead sources
            const sourcesResponse = await fetch('/admin/dashboard/leads/api/lead-sources');
            if (sourcesResponse.ok) {
                const sourcesData = await sourcesResponse.json();
                this.state.leadSources = sourcesData.success ? sourcesData.data : [];
            }

            // Load assignable admins
            const adminsResponse = await fetch('/admin/dashboard/leads/api/assignable-admins');
            if (adminsResponse.ok) {
                const adminsData = await adminsResponse.json();
                this.state.adminUsers = adminsData.success ? adminsData.data : [];
            }

            // Load filter presets
            const presetsResponse = await fetch('/admin/dashboard/leads/api/filter-presets');
            if (presetsResponse.ok) {
                const presetsData = await presetsResponse.json();
                this.state.filterPresets = presetsData.success ? presetsData.data : [];
            }

            console.log('Initial data loaded');
        } catch (error) {
            console.error('Failed to load initial data:', error);
            // Set empty arrays as fallback
            this.state.leadSources = [];
            this.state.adminUsers = [];
            this.state.filterPresets = [];
        }
    }

    /**
     * Load leads data
     */
    async loadLeads() {
        if (window.leadsTableCore && window.leadsTableCore.loadLeads) {
            await window.leadsTableCore.loadLeads.call(this);
        } else {
            // Fallback implementation
            await this.defaultLoadLeads();
        }
        this.renderTable();
    }

    /**
     * Default load leads implementation
     */
    async defaultLoadLeads() {
        try {
            this.setState({ loading: true });
            
            const params = new URLSearchParams({
                page: this.state.currentPage,
                per_page: this.state.perPage,
                search: this.state.searchQuery,
                sort_column: this.state.sortColumn,
                sort_direction: this.state.sortDirection,
                ...this.state.filters
            });

            const response = await fetch(`/admin/dashboard/leads/api/leads?${params}`);
            const data = await response.json();

            if (data.success) {
                this.setState({
                    leads: data.data.data,
                    totalLeads: data.data.total,
                    filteredCount: data.data.total,
                    currentPage: data.data.current_page,
                    totalPages: data.data.last_page,
                    loading: false
                });
            } else {
                throw new Error(data.message || 'Failed to load leads');
            }
        } catch (error) {
            console.error('Failed to load leads:', error);
            this.setState({ loading: false });
            this.showNotification('Leads yüklenirken hata oluştu', 'error');
        }
    }

    /**
     * Search leads with debounced input
     */
    async searchLeads() {
        this.state.searchQuery = this.container.querySelector('[data-search-input]')?.value || '';
        if (this.tableManager) {
            await this.tableManager.search(this.state.searchQuery);
        } else {
            await this.loadLeads();
        }
    }

    /**
     * Toggle filters panel
     */
    toggleFilters() {
        this.setState({ showFilters: !this.state.showFilters });
        this.renderFiltersPanel();
    }

    /**
     * Toggle column settings panel
     */
    toggleColumnSettings() {
        this.setState({ showColumnSettings: !this.state.showColumnSettings });
        this.renderColumnSettings();
    }

    /**
     * Select all visible leads
     */
    selectAllLeads() {
        if (this.bulkActionManager) {
            this.bulkActionManager.selectAll();
        } else {
            this.state.selectedLeads = this.state.leads.map(lead => lead.id);
            this.renderBulkActions();
        }
    }

    /**
     * Clear all selections
     */
    clearSelection() {
        if (this.bulkActionManager) {
            this.bulkActionManager.clearSelection();
        } else {
            this.state.selectedLeads = [];
            this.renderBulkActions();
        }
    }

    /**
     * Pagination methods
     */
    async goToPage(page) {
        if (this.tableManager) {
            await this.tableManager.goToPage(page);
        } else {
            this.setState({ currentPage: page });
            await this.loadLeads();
        }
    }

    async previousPage() {
        if (this.state.currentPage > 1) {
            await this.goToPage(this.state.currentPage - 1);
        }
    }

    async nextPage() {
        if (this.state.currentPage < this.state.totalPages) {
            await this.goToPage(this.state.currentPage + 1);
        }
    }

    /**
     * Show notification
     */
    showNotification(message, type = 'info') {
        this.setState({
            notification: {
                show: true,
                message: message,
                type: type
            }
        });

        this.renderNotification();

        // Auto-hide after 5 seconds
        setTimeout(() => {
            this.setState({ 
                notification: { ...this.state.notification, show: false }
            });
            this.renderNotification();
        }, 5000);
    }

    /**
     * State management
     */
    setState(newState) {
        this.state = { ...this.state, ...newState };
    }

    /**
     * Render methods
     */
    renderTable() {
        // Update table body
        const tableBody = this.container.querySelector('[data-table-body]');
        if (tableBody && this.state.leads) {
            tableBody.innerHTML = this.state.leads.map(lead => this.renderTableRow(lead)).join('');
            this.setupRowEventListeners();
        }

        // Update pagination
        this.renderPagination();
        
        // Update counters
        this.renderCounters();
    }

    renderTableRow(lead) {
        return `
            <tr data-lead-id="${lead.id}" class="border-b border-gray-200 hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="checkbox" 
                           data-lead-select="${lead.id}"
                           ${this.state.selectedLeads.includes(lead.id) ? 'checked' : ''}
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${lead.country || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${lead.name || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${lead.phone || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${lead.email || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${lead.assigned_to || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${this.getStatusBadgeClass(lead.status)}">
                        ${this.getStatusLabel(lead.status)}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${lead.organization || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${lead.source || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${lead.company_name || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button data-lead-action="edit" data-lead-id="${lead.id}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</button>
                    <button data-lead-action="delete" data-lead-id="${lead.id}" class="text-red-600 hover:text-red-900">Delete</button>
                </td>
            </tr>
        `;
    }

    setupRowEventListeners() {
        // Lead selection checkboxes
        this.container.querySelectorAll('[data-lead-select]').forEach(checkbox => {
            const handler = (e) => {
                const leadId = parseInt(e.target.dataset.leadSelect);
                this.toggleLeadSelection(leadId);
            };
            checkbox.addEventListener('change', handler);
        });

        // Action buttons
        this.container.querySelectorAll('[data-lead-action]').forEach(button => {
            const handler = (e) => {
                const action = e.target.dataset.leadAction;
                const leadId = parseInt(e.target.dataset.leadId);
                this.handleLeadAction(action, leadId);
            };
            button.addEventListener('click', handler);
        });
    }

    toggleLeadSelection(leadId) {
        const index = this.state.selectedLeads.indexOf(leadId);
        if (index > -1) {
            this.state.selectedLeads.splice(index, 1);
        } else {
            this.state.selectedLeads.push(leadId);
        }
        this.renderBulkActions();
    }

    handleLeadAction(action, leadId) {
        const lead = this.state.leads.find(l => l.id === leadId);
        
        switch (action) {
            case 'edit':
                this.openEditModal(lead);
                break;
            case 'delete':
                if (confirm('Bu lead\'i silmek istediğinizden emin misiniz?')) {
                    this.deleteLead(leadId);
                }
                break;
        }
    }

    renderPagination() {
        const paginationContainer = this.container.querySelector('[data-pagination]');
        if (!paginationContainer) return;

        const pages = this.getVisiblePages();
        
        paginationContainer.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    <button ${this.state.currentPage <= 1 ? 'disabled' : ''} 
                            data-prev-page
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Previous
                    </button>
                    <button ${this.state.currentPage >= this.state.totalPages ? 'disabled' : ''} 
                            data-next-page
                            class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Next
                    </button>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing <span class="font-medium">${((this.state.currentPage - 1) * this.state.perPage) + 1}</span> to 
                            <span class="font-medium">${Math.min(this.state.currentPage * this.state.perPage, this.state.totalLeads)}</span> of 
                            <span class="font-medium">${this.state.totalLeads}</span> results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                            ${pages.map(page => {
                                if (page === '...') {
                                    return '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>';
                                }
                                return `
                                    <button data-page="${page}" 
                                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium ${page === this.state.currentPage ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:bg-gray-50'}">
                                        ${page}
                                    </button>
                                `;
                            }).join('')}
                        </nav>
                    </div>
                </div>
            </div>
        `;
        
        // Setup pagination event listeners
        paginationContainer.querySelectorAll('[data-page]').forEach(button => {
            button.addEventListener('click', (e) => {
                const page = parseInt(e.target.dataset.page);
                if (page && page !== this.state.currentPage) {
                    this.goToPage(page);
                }
            });
        });
    }

    renderCounters() {
        const counter = this.container.querySelector('[data-results-counter]');
        if (counter) {
            counter.textContent = `${this.state.totalLeads} leads`;
        }
    }

    renderBulkActions() {
        const bulkContainer = this.container.querySelector('[data-bulk-actions]');
        if (bulkContainer) {
            const selectedCount = this.state.selectedLeads.length;
            bulkContainer.style.display = selectedCount > 0 ? 'block' : 'none';
            
            const countElement = bulkContainer.querySelector('[data-selected-count]');
            if (countElement) {
                countElement.textContent = selectedCount;
            }
        }
    }

    renderFiltersPanel() {
        const filtersPanel = this.container.querySelector('[data-filters-panel]');
        if (filtersPanel) {
            filtersPanel.style.display = this.state.showFilters ? 'block' : 'none';
        }
    }

    renderColumnSettings() {
        const columnPanel = this.container.querySelector('[data-column-settings]');
        if (columnPanel) {
            columnPanel.style.display = this.state.showColumnSettings ? 'block' : 'none';
        }
    }

    renderNotification() {
        let notificationContainer = this.container.querySelector('[data-notification]');
        
        if (!notificationContainer) {
            notificationContainer = document.createElement('div');
            notificationContainer.setAttribute('data-notification', '');
            notificationContainer.className = 'fixed top-4 right-4 z-50';
            document.body.appendChild(notificationContainer);
        }

        if (this.state.notification.show) {
            notificationContainer.innerHTML = `
                <div class="p-4 rounded-lg shadow-lg max-w-sm ${this.getNotificationClasses(this.state.notification.type)}">
                    ${this.state.notification.message}
                </div>
            `;
            notificationContainer.style.display = 'block';
        } else {
            notificationContainer.style.display = 'none';
        }
    }

    getNotificationClasses(type) {
        switch (type) {
            case 'error': return 'bg-red-100 text-red-800 border border-red-200';
            case 'warning': return 'bg-yellow-100 text-yellow-800 border border-yellow-200';
            case 'success': return 'bg-green-100 text-green-800 border border-green-200';
            default: return 'bg-blue-100 text-blue-800 border border-blue-200';
        }
    }

    /**
     * Get visible page numbers for pagination
     */
    getVisiblePages() {
        const pages = [];
        const totalPages = this.state.totalPages;
        const current = this.state.currentPage;

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
    }

    /**
     * Modal methods
     */
    openLeadModal(lead = null) {
        this.setState({ 
            selectedLead: lead,
            showLeadModal: true 
        });
    }

    closeLeadModal() {
        this.setState({ 
            selectedLead: null,
            showLeadModal: false 
        });
    }

    openEditModal(lead = null) {
        this.setState({ 
            selectedLead: lead,
            showEditModal: true 
        });
    }

    closeEditModal() {
        this.setState({ 
            selectedLead: null,
            showEditModal: false 
        });
    }

    /**
     * Save current settings to localStorage
     */
    saveSettings() {
        try {
            localStorage.setItem('leads_table_columns', JSON.stringify(this.state.availableColumns));
            localStorage.setItem('leads_table_filters', JSON.stringify(this.state.filters));
            localStorage.setItem('leads_table_per_page', this.state.perPage.toString());
            localStorage.setItem('leads_table_sort', JSON.stringify({
                column: this.state.sortColumn,
                direction: this.state.sortDirection
            }));
            console.log('Settings saved to localStorage');
        } catch (error) {
            console.warn('Failed to save settings to localStorage:', error);
        }
    }

    /**
     * Utility methods
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

    /**
     * Get status badge CSS classes
     */
    getStatusBadgeClass(status) {
        const classes = {
            'new': 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            'contacted': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'qualified': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'converted': 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
            'lost': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
        };
        
        return classes[status] || 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
    }

    /**
     * Get status label in Turkish
     */
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

    /**
     * Get priority badge CSS classes
     */
    getPriorityBadgeClass(priority) {
        const classes = {
            'low': 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300',
            'medium': 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            'high': 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300',
            'urgent': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
        };
        
        return classes[priority] || 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
    }

    /**
     * Get priority label in Turkish
     */
    getPriorityLabel(priority) {
        const labels = {
            'low': 'Düşük',
            'medium': 'Orta',
            'high': 'Yüksek',
            'urgent': 'Acil'
        };
        
        return labels[priority] || priority || 'Belirsiz';
    }

    /**
     * Cleanup on page unload
     */
    cleanup() {
        // Remove event listeners
        this.eventListeners.forEach(({ element, event, handler }) => {
            element.removeEventListener(event, handler);
        });
        this.eventListeners = [];

        // Save current state to localStorage
        this.saveSettings();
        
        // Cleanup managers
        if (this.tableManager && this.tableManager.cleanup) this.tableManager.cleanup();
        if (this.columnManager && this.columnManager.cleanup) this.columnManager.cleanup();
        if (this.filterManager && this.filterManager.cleanup) this.filterManager.cleanup();
        if (this.bulkActionManager && this.bulkActionManager.cleanup) this.bulkActionManager.cleanup();
    }
}

// Global initialization function for vanilla JavaScript
window.initializeLeadsDataManager = function(containerSelector = '[data-leads-table]') {
    const container = document.querySelector(containerSelector);
    if (!container) {
        console.error('Leads table container not found:', containerSelector);
        return null;
    }

    const manager = new LeadsDataManager(container);
    
    // Store reference for cleanup
    window.leadsDataManagerInstance = manager;

    return manager;
};

// =============================================================================
// GLOBAL BRIDGE FUNCTIONS FOR TEMPLATE ONCLICK HANDLERS
// =============================================================================

/**
 * Template'lerde onclick="functionName()" şeklinde çağrılan global fonksiyonlar
 * Bu fonksiyonlar ilgili manager'lardaki metodları çağırır
 */

// Column Management Functions
window.toggleColumnSettings = function() {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.toggleColumnSettings();
    }
};

// Export Functions
window.exportLeads = function() {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.exportLeads();
    }
};

// Refresh Functions
window.refreshLeads = function() {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.loadLeads();
    }
};

// Pagination Functions
window.goToPage = function(page) {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.changePage(page);
    }
};

window.changePerPage = function(value) {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.changePerPage(parseInt(value));
    }
};

window.changePage = function(page) {
    window.goToPage(page);
};

// Filter Functions
window.applyFilters = function() {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.filterManager.applyFilters();
    }
};

window.clearAllFilters = function() {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.filterManager.clearAllFilters();
    }
};

// Bulk Action Functions
window.bulkUpdateStatus = function(status) {
    if (window.bulkActionHelpers) {
        window.bulkActionHelpers.bulkUpdateStatus(status);
    }
};

window.bulkAssign = function(userId) {
    if (window.bulkActionHelpers) {
        window.bulkActionHelpers.bulkAssign(userId);
    }
};

window.bulkDelete = function() {
    if (window.bulkActionHelpers) {
        window.bulkActionHelpers.bulkDelete();
    }
};

// Modal Functions
window.showLeadModal = function(leadId) {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.showLeadModal(leadId);
    }
};

window.hideLeadModal = function() {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.hideLeadModal();
    }
};

window.showEditModal = function(leadId = null) {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.showEditModal(leadId);
    }
};

window.hideEditModal = function() {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.hideEditModal();
    }
};

// Form Functions
window.submitEditForm = function() {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.submitEditForm();
    }
};

// Selection Functions
window.toggleLeadSelection = function(leadId) {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.toggleLeadSelection(leadId);
    }
};

window.toggleSelectAll = function() {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.toggleSelectAll();
    }
};

window.selectAllLeads = function() {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.selectAllLeads();
    }
};

window.clearSelection = function() {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.clearSelection();
    }
};

// Sorting Functions
window.sortBy = function(column) {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.sortBy(column);
    }
};

// Search Functions
window.searchLeads = function(query) {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.search(query);
    }
};

// Filter Toggle Functions
window.toggleFilters = function() {
    const dataManager = window.leadsDataManagerInstance;
    if (dataManager) {
        dataManager.toggleFilters();
    }
};

console.log('🌉 Global bridge functions initialized for template onclick handlers');

// Auto-cleanup on page unload
window.addEventListener('beforeunload', () => {
    if (window.leadsDataManagerInstance && typeof window.leadsDataManagerInstance.cleanup === 'function') {
        window.leadsDataManagerInstance.cleanup();
    }
});

console.log('Leads Data Manager (Vanilla JS) loaded');

export { LeadsDataManager };