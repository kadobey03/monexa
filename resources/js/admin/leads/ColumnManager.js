/**
 * Modern Column Manager - 9 Column Layout Support
 * Yeni sütun yapısı için optimized dinamik sütun yönetimi
 * Updated for: ÜLKE, AD SOYAD, TELEFON, EMAİL, ASSIGNED, STATUS, VARONKA, KAYNAK, ŞİRKET
 */
class ColumnManager {
    constructor() {
        this.storageKey = 'leads_table_column_settings_v2'; // Updated key for new structure
        this.defaultColumns = [
            { 
                key: 'select', 
                label: 'Seç', 
                width: 60, 
                resizable: false, 
                pinnable: false, 
                visible: true, 
                order: 0,
                required: true,
                description: 'Toplu işlemler için seçim checkbox\'u'
            },
            { 
                key: 'country', 
                label: 'Ülke', 
                width: 120, 
                resizable: true, 
                pinnable: true, 
                visible: true, 
                order: 1,
                sortable: true,
                description: 'Lead\'in bulunduğu ülke bilgisi'
            },
            { 
                key: 'name', 
                label: 'Ad Soyad', 
                width: 200, 
                resizable: true, 
                pinnable: true, 
                visible: true, 
                order: 2,
                sortable: true,
                description: 'Lead\'in tam adı ve soyadı'
            },
            { 
                key: 'phone', 
                label: 'Telefon Numarası', 
                width: 160, 
                resizable: true, 
                pinnable: true, 
                visible: true, 
                order: 3,
                sortable: true,
                description: 'İletişim telefon numarası'
            },
            { 
                key: 'email', 
                label: 'E-posta', 
                width: 220, 
                resizable: true, 
                pinnable: true, 
                visible: true, 
                order: 4,
                sortable: true,
                description: 'İletişim e-posta adresi'
            },
            { 
                key: 'assigned', 
                label: 'Atanan', 
                width: 150, 
                resizable: true, 
                pinnable: false, 
                visible: true, 
                order: 5,
                sortable: true,
                description: 'Sorumlu admin kullanıcı'
            },
            { 
                key: 'status', 
                label: 'Durum', 
                width: 140, 
                resizable: true, 
                pinnable: false, 
                visible: true, 
                order: 6,
                sortable: true,
                description: 'Lead durumu ve aşaması'
            },
            { 
                key: 'varonka', 
                label: 'Varonka', 
                width: 160, 
                resizable: true, 
                pinnable: false, 
                visible: true, 
                order: 7,
                sortable: true,
                description: 'Organizasyon/şirket bilgisi'
            },
            { 
                key: 'source', 
                label: 'Kaynak', 
                width: 130, 
                resizable: true, 
                pinnable: false, 
                visible: true, 
                order: 8,
                sortable: true,
                description: 'Lead kaynağı'
            },
            { 
                key: 'company', 
                label: 'Şirket', 
                width: 180, 
                resizable: true, 
                pinnable: false, 
                visible: true, 
                order: 9,
                sortable: true,
                description: 'Şirket adı'
            }
        ];
        
        this.currentColumns = [];
        this.pinnedColumns = [];
        this.hiddenColumns = [];
        
        // Mobile breakpoints and column priority
        this.breakpoints = {
            mobile: 480,
            tablet: 768,
            desktop: 1024,
            wide: 1440
        };
        
        // Column priorities for responsive hiding (1 = most important, 10 = least important)
        this.columnPriorities = {
            'select': 1,
            'name': 2,
            'phone': 3,
            'email': 4,
            'status': 5,
            'country': 6,
            'assigned': 7,
            'source': 8,
            'varonka': 9,
            'company': 10
        };
        
        this.init();
    }
    
    init() {
        this.loadSettings();
        this.setupEventListeners();
        this.setupResponsiveHandling();
    }
    
    /**
     * Load column settings from localStorage with migration support
     */
    loadSettings() {
        try {
            const saved = localStorage.getItem(this.storageKey);
            
            if (saved) {
                const settings = JSON.parse(saved);
                this.currentColumns = this.mergeWithDefaults(settings.columns || []);
                this.pinnedColumns = settings.pinnedColumns || [];
                this.hiddenColumns = settings.hiddenColumns || [];
            } else {
                // Check for old settings and migrate
                this.migrateOldSettings();
                this.currentColumns = [...this.defaultColumns];
                this.pinnedColumns = ['name']; // Default pinned column
                this.hiddenColumns = [];
            }
            
            // Sort columns by order
            this.currentColumns.sort((a, b) => a.order - b.order);
            
            // Apply responsive adjustments
            this.adjustForCurrentViewport();
            
        } catch (error) {
            console.error('Error loading column settings:', error);
            this.resetToDefaults();
        }
    }
    
    /**
     * Migrate old column settings to new structure
     */
    migrateOldSettings() {
        try {
            const oldKey = 'leads_table_column_settings';
            const oldSettings = localStorage.getItem(oldKey);
            
            if (oldSettings) {
                console.log('🔄 Migrating old column settings to new 9-column structure...');
                // Remove old settings
                localStorage.removeItem(oldKey);
                console.log('✅ Migration completed');
            }
        } catch (error) {
            console.warn('Migration failed, using defaults:', error);
        }
    }
    
    /**
     * Merge saved settings with default columns
     */
    mergeWithDefaults(savedColumns) {
        const merged = [];
        
        // Start with defaults to ensure all new columns are included
        this.defaultColumns.forEach(defaultCol => {
            const saved = savedColumns.find(col => col.key === defaultCol.key);
            
            if (saved) {
                // Use saved settings but preserve default properties for new features
                merged.push({
                    ...defaultCol,
                    ...saved,
                    // Always use default for these properties to allow updates
                    label: defaultCol.label,
                    resizable: defaultCol.resizable,
                    pinnable: defaultCol.pinnable,
                    required: defaultCol.required,
                    sortable: defaultCol.sortable
                });
            } else {
                merged.push({ ...defaultCol });
            }
        });
        
        return merged;
    }
    
    /**
     * Save column settings to localStorage
     */
    saveSettings() {
        try {
            const settings = {
                columns: this.currentColumns,
                pinnedColumns: this.pinnedColumns,
                hiddenColumns: this.hiddenColumns,
                timestamp: Date.now(),
                version: '2.0'
            };
            
            localStorage.setItem(this.storageKey, JSON.stringify(settings));
            
            // Emit event for components to update
            this.emit('columnSettingsUpdated', {
                visibleColumns: this.getVisibleColumns(),
                pinnedColumns: this.pinnedColumns,
                hiddenColumns: this.hiddenColumns
            });
            
        } catch (error) {
            console.error('Error saving column settings:', error);
        }
    }
    
    /**
     * Setup responsive handling for different screen sizes
     */
    setupResponsiveHandling() {
        // Setup media queries for responsive behavior
        const mobileQuery = window.matchMedia(`(max-width: ${this.breakpoints.tablet}px)`);
        const tabletQuery = window.matchMedia(`(max-width: ${this.breakpoints.desktop}px)`);
        
        mobileQuery.addListener((e) => {
            if (e.matches) {
                this.applyMobileLayout();
            }
        });
        
        tabletQuery.addListener((e) => {
            if (e.matches && !mobileQuery.matches) {
                this.applyTabletLayout();
            } else if (!e.matches) {
                this.applyDesktopLayout();
            }
        });
        
        // Apply initial layout
        this.adjustForCurrentViewport();
    }
    
    /**
     * Adjust columns for current viewport
     */
    adjustForCurrentViewport() {
        const width = window.innerWidth;
        
        if (width <= this.breakpoints.mobile) {
            this.applyMobileLayout();
        } else if (width <= this.breakpoints.tablet) {
            this.applyTabletLayout();
        } else {
            this.applyDesktopLayout();
        }
    }
    
    /**
     * Apply mobile layout (show only essential columns)
     */
    applyMobileLayout() {
        const essentialColumns = ['select', 'name', 'phone', 'status'];
        
        this.currentColumns.forEach(col => {
            if (!essentialColumns.includes(col.key)) {
                col.hidden = true;
            } else {
                col.hidden = false;
                // Adjust widths for mobile
                if (col.key === 'name') col.width = 150;
                if (col.key === 'phone') col.width = 130;
                if (col.key === 'status') col.width = 100;
            }
        });
        
        this.emit('layoutChanged', { layout: 'mobile', visibleColumns: this.getVisibleColumns() });
    }
    
    /**
     * Apply tablet layout (show important columns)
     */
    applyTabletLayout() {
        const importantColumns = ['select', 'name', 'phone', 'email', 'status', 'assigned'];
        
        this.currentColumns.forEach(col => {
            if (!importantColumns.includes(col.key)) {
                col.hidden = true;
            } else {
                col.hidden = false;
                // Adjust widths for tablet
                if (col.key === 'name') col.width = 160;
                if (col.key === 'email') col.width = 180;
                if (col.key === 'phone') col.width = 140;
            }
        });
        
        this.emit('layoutChanged', { layout: 'tablet', visibleColumns: this.getVisibleColumns() });
    }
    
    /**
     * Apply desktop layout (show all user-preferred columns)
     */
    applyDesktopLayout() {
        this.currentColumns.forEach(col => {
            col.hidden = this.hiddenColumns.includes(col.key);
            // Reset to user-preferred or default widths
            const defaultCol = this.defaultColumns.find(dc => dc.key === col.key);
            if (defaultCol && !col.width) {
                col.width = defaultCol.width;
            }
        });
        
        this.emit('layoutChanged', { layout: 'desktop', visibleColumns: this.getVisibleColumns() });
    }
    
    /**
     * Get all columns
     */
    getAllColumns() {
        return [...this.currentColumns];
    }
    
    /**
     * Get visible columns only (excluding hidden ones)
     */
    getVisibleColumns() {
        return this.currentColumns
            .filter(col => col.visible && !col.hidden)
            .sort((a, b) => a.order - b.order);
    }
    
    /**
     * Get columns for current screen size
     */
    getResponsiveColumns() {
        const width = window.innerWidth;
        const visibleColumns = this.getVisibleColumns();
        
        if (width <= this.breakpoints.mobile) {
            // Mobile: show only essential columns
            return visibleColumns.filter(col => 
                ['select', 'name', 'phone', 'status'].includes(col.key)
            );
        } else if (width <= this.breakpoints.tablet) {
            // Tablet: show important columns
            return visibleColumns.filter(col => 
                ['select', 'name', 'phone', 'email', 'status', 'assigned'].includes(col.key)
            );
        }
        
        return visibleColumns; // Desktop: show all visible
    }
    
    /**
     * Toggle column visibility
     */
    toggleColumnVisibility(columnKey) {
        const column = this.currentColumns.find(col => col.key === columnKey);
        
        if (column && !column.required) {
            column.visible = !column.visible;
            
            // Update hidden columns array
            if (!column.visible) {
                if (!this.hiddenColumns.includes(columnKey)) {
                    this.hiddenColumns.push(columnKey);
                }
                // If hiding a pinned column, unpin it
                if (this.pinnedColumns.includes(columnKey)) {
                    this.unpinColumn(columnKey);
                }
            } else {
                const index = this.hiddenColumns.indexOf(columnKey);
                if (index > -1) {
                    this.hiddenColumns.splice(index, 1);
                }
            }
            
            this.saveSettings();
            return column.visible;
        }
        
        return false;
    }
    
    /**
     * Update column width
     */
    updateColumnWidth(columnKey, width) {
        const column = this.currentColumns.find(col => col.key === columnKey);
        
        if (column && column.resizable) {
            const minWidth = columnKey === 'select' ? 50 : 80;
            const maxWidth = 600;
            
            column.width = Math.max(minWidth, Math.min(maxWidth, parseInt(width)));
            this.saveSettings();
            return column.width;
        }
        
        return null;
    }
    
    /**
     * Reorder columns
     */
    reorderColumns(fromIndex, toIndex) {
        const visibleColumns = this.getVisibleColumns();
        
        if (fromIndex < 0 || fromIndex >= visibleColumns.length || 
            toIndex < 0 || toIndex >= visibleColumns.length) {
            return false;
        }
        
        // Don't allow moving the select column
        if (visibleColumns[fromIndex].key === 'select' || visibleColumns[toIndex].key === 'select') {
            return false;
        }
        
        // Update order values
        const movedColumn = visibleColumns[fromIndex];
        visibleColumns.splice(fromIndex, 1);
        visibleColumns.splice(toIndex, 0, movedColumn);
        
        // Re-assign order values
        visibleColumns.forEach((col, index) => {
            col.order = index;
        });
        
        this.saveSettings();
        return true;
    }
    
    /**
     * Pin/Unpin column
     */
    toggleColumnPin(columnKey) {
        const column = this.currentColumns.find(col => col.key === columnKey);
        
        if (!column || !column.pinnable || !column.visible) {
            return false;
        }
        
        if (this.pinnedColumns.includes(columnKey)) {
            this.unpinColumn(columnKey);
        } else {
            this.pinColumn(columnKey);
        }
        
        return this.pinnedColumns.includes(columnKey);
    }
    
    /**
     * Pin column
     */
    pinColumn(columnKey) {
        if (!this.pinnedColumns.includes(columnKey)) {
            this.pinnedColumns.push(columnKey);
            this.saveSettings();
        }
    }
    
    /**
     * Unpin column
     */
    unpinColumn(columnKey) {
        const index = this.pinnedColumns.indexOf(columnKey);
        if (index > -1) {
            this.pinnedColumns.splice(index, 1);
            this.saveSettings();
        }
    }
    
    /**
     * Get column by key
     */
    getColumn(columnKey) {
        return this.currentColumns.find(col => col.key === columnKey);
    }
    
    /**
     * Get column width
     */
    getColumnWidth(columnKey) {
        const column = this.getColumn(columnKey);
        return column ? column.width : 120;
    }
    
    /**
     * Check if column is pinned
     */
    isColumnPinned(columnKey) {
        return this.pinnedColumns.includes(columnKey);
    }
    
    /**
     * Check if column is visible
     */
    isColumnVisible(columnKey) {
        const column = this.getColumn(columnKey);
        return column ? (column.visible && !column.hidden) : false;
    }
    
    /**
     * Reset to default settings
     */
    resetToDefaults() {
        this.currentColumns = [...this.defaultColumns];
        this.pinnedColumns = ['name'];
        this.hiddenColumns = [];
        this.adjustForCurrentViewport();
        this.saveSettings();
    }
    
    /**
     * Get CSS classes for column
     */
    getColumnClasses(columnKey) {
        const classes = ['table-column'];
        
        if (this.isColumnPinned(columnKey)) {
            classes.push('column-pinned');
        }
        
        const column = this.getColumn(columnKey);
        if (column) {
            if (column.resizable) classes.push('column-resizable');
            if (column.sortable) classes.push('column-sortable');
            if (column.required) classes.push('column-required');
        }
        
        return classes.join(' ');
    }
    
    /**
     * Get table style for column
     */
    getColumnStyle(columnKey) {
        const column = this.getColumn(columnKey);
        if (!column) return '';
        
        const styles = [`width: ${column.width}px`, `min-width: ${column.width}px`];
        
        if (this.isColumnPinned(columnKey)) {
            styles.push('position: sticky');
            styles.push('left: 0');
            styles.push('z-index: 10');
            styles.push('background: inherit');
        }
        
        return styles.join('; ');
    }
    
    /**
     * Get column configuration for table rendering
     */
    getTableConfiguration() {
        const visibleColumns = this.getResponsiveColumns();
        
        return {
            columns: visibleColumns,
            totalWidth: visibleColumns.reduce((sum, col) => sum + col.width, 0),
            hasPin: this.pinnedColumns.length > 0,
            layout: window.innerWidth <= this.breakpoints.mobile ? 'mobile' : 
                   window.innerWidth <= this.breakpoints.tablet ? 'tablet' : 'desktop'
        };
    }
    
    /**
     * Event system
     */
    setupEventListeners() {
        // Listen for window resize to adjust responsive layout
        window.addEventListener('resize', this.debounce(() => {
            this.adjustForCurrentViewport();
        }, 250));
        
        // Listen for orientation change on mobile
        window.addEventListener('orientationchange', () => {
            setTimeout(() => {
                this.adjustForCurrentViewport();
            }, 300);
        });
    }
    
    /**
     * Emit custom event
     */
    emit(eventName, data) {
        const event = new CustomEvent(`columns:${eventName}`, {
            detail: data,
            bubbles: true
        });
        
        document.dispatchEvent(event);
    }
    
    /**
     * Debounce utility
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
     * Get settings for export/import
     */
    getSettingsForExport() {
        return {
            columns: this.currentColumns,
            pinnedColumns: this.pinnedColumns,
            hiddenColumns: this.hiddenColumns,
            version: '2.0'
        };
    }
    
    /**
     * Import settings
     */
    importSettings(settings) {
        try {
            if (settings.version !== '2.0') {
                console.warn('Importing settings from older version, may need migration');
            }
            
            if (settings.columns) {
                this.currentColumns = this.mergeWithDefaults(settings.columns);
            }
            
            if (settings.pinnedColumns) {
                this.pinnedColumns = settings.pinnedColumns;
            }
            
            if (settings.hiddenColumns) {
                this.hiddenColumns = settings.hiddenColumns;
            }
            
            this.adjustForCurrentViewport();
            this.saveSettings();
            return true;
            
        } catch (error) {
            console.error('Error importing column settings:', error);
            return false;
        }
    }
}

// Global instance
window.columnManager = new ColumnManager();

// Alpine.js integration helpers - Updated for 9-column structure
window.columnManagerHelpers = {
    // Get all available columns for settings modal
    getAvailableColumns() {
        return window.columnManager.getAllColumns();
    },
    
    // Get visible columns for table rendering
    getVisibleColumns() {
        return window.columnManager.getResponsiveColumns(); // Use responsive columns
    },
    
    // Get columns configuration
    getTableConfiguration() {
        return window.columnManager.getTableConfiguration();
    },
    
    // Get pinned columns
    getPinnedColumns() {
        return window.columnManager.getPinnedColumns();
    },
    
    // Toggle column visibility
    toggleColumnVisibility(columnKey) {
        return window.columnManager.toggleColumnVisibility(columnKey);
    },
    
    // Update column width
    updateColumnWidth(columnKey, width) {
        return window.columnManager.updateColumnWidth(columnKey, width);
    },
    
    // Get column width
    getColumnWidth(columnKey) {
        return window.columnManager.getColumnWidth(columnKey);
    },
    
    // Toggle column pin
    toggleColumnPin(columnKey) {
        return window.columnManager.toggleColumnPin(columnKey);
    },
    
    // Reset to defaults
    resetToDefaults() {
        window.columnManager.resetToDefaults();
        
        // Update Alpine.js data if available
        const alpineComponent = document.querySelector('[x-data*="leadsTableData"]');
        if (alpineComponent && alpineComponent._x_dataStack) {
            const data = alpineComponent._x_dataStack[0];
            data.availableColumns = window.columnManager.getAllColumns();
            data.visibleColumns = window.columnManager.getResponsiveColumns();
            data.pinnedColumns = window.columnManager.getPinnedColumns();
        }
    },
    
    // Save column settings with Alpine.js integration
    saveColumnSettings() {
        window.columnManager.saveSettings();
        
        const alpineComponent = document.querySelector('[x-data*="leadsTableData"]');
        if (alpineComponent && alpineComponent._x_dataStack) {
            const data = alpineComponent._x_dataStack[0];
            if (data.showColumnSettings) {
                data.showColumnSettings = false;
            }
            if (data.showNotification) {
                data.showNotification('Sütun ayarları kaydedildi', 'success');
            }
        }
    },
    
    // Load settings into Alpine.js component
    loadColumnSettings() {
        const alpineComponent = document.querySelector('[x-data*="leadsTableData"]');
        if (alpineComponent && alpineComponent._x_dataStack) {
            const data = alpineComponent._x_dataStack[0];
            data.availableColumns = window.columnManager.getAllColumns();
            data.visibleColumns = window.columnManager.getResponsiveColumns();
            data.pinnedColumns = window.columnManager.getPinnedColumns();
        }
    },
    
    // Get responsive layout info
    getLayoutInfo() {
        const width = window.innerWidth;
        const breakpoints = window.columnManager.breakpoints;
        
        return {
            isMobile: width <= breakpoints.mobile,
            isTablet: width <= breakpoints.tablet && width > breakpoints.mobile,
            isDesktop: width > breakpoints.tablet,
            currentLayout: width <= breakpoints.mobile ? 'mobile' : 
                          width <= breakpoints.tablet ? 'tablet' : 'desktop',
            visibleColumnCount: window.columnManager.getResponsiveColumns().length
        };
    }
};

// Listen for column events and update Alpine.js
document.addEventListener('columns:columnSettingsUpdated', (event) => {
    const alpineComponent = document.querySelector('[x-data*="leadsTableData"]');
    if (alpineComponent && alpineComponent._x_dataStack) {
        const data = alpineComponent._x_dataStack[0];
        if (data.loadLeads) {
            data.loadLeads(); // Reload table data with new column settings
        }
    }
});

document.addEventListener('columns:layoutChanged', (event) => {
    console.log(`📱 Layout changed to: ${event.detail.layout}`);
    
    // Update any UI elements that depend on layout
    const layoutInfo = window.columnManagerHelpers.getLayoutInfo();
    document.body.classList.toggle('mobile-layout', layoutInfo.isMobile);
    document.body.classList.toggle('tablet-layout', layoutInfo.isTablet);
    document.body.classList.toggle('desktop-layout', layoutInfo.isDesktop);
});

// Initialize layout classes on load
document.addEventListener('DOMContentLoaded', () => {
    const layoutInfo = window.columnManagerHelpers.getLayoutInfo();
    document.body.classList.toggle('mobile-layout', layoutInfo.isMobile);
    document.body.classList.toggle('tablet-layout', layoutInfo.isTablet);
    document.body.classList.toggle('desktop-layout', layoutInfo.isDesktop);
});

export default ColumnManager;