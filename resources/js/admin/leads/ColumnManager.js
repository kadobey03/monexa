/**
 * Column Manager
 * Dinamik sütun yönetimi, sıralama, boyutlandırma ve sabitleme işlemleri
 */
class ColumnManager {
    constructor() {
        this.storageKey = 'leads_table_column_settings';
        this.defaultColumns = [
            { key: 'select', label: 'Seç', width: 50, resizable: false, pinnable: false, visible: true, order: 0 },
            { key: 'name', label: 'İsim', width: 200, resizable: true, pinnable: true, visible: true, order: 1, description: 'Lead ismi ve temel bilgileri' },
            { key: 'email', label: 'E-posta', width: 250, resizable: true, pinnable: true, visible: true, order: 2, description: 'İletişim e-posta adresi' },
            { key: 'phone', label: 'Telefon', width: 150, resizable: true, pinnable: false, visible: true, order: 3, description: 'İletişim telefon numarası' },
            { key: 'status', label: 'Durum', width: 120, resizable: true, pinnable: false, visible: true, order: 4, description: 'Lead durumu ve aşaması' },
            { key: 'priority', label: 'Öncelik', width: 100, resizable: true, pinnable: false, visible: true, order: 5, description: 'Lead öncelik seviyesi' },
            { key: 'lead_score', label: 'Puan', width: 80, resizable: true, pinnable: false, visible: true, order: 6, description: 'Otomatik lead puanlama' },
            { key: 'assigned_to', label: 'Atanan', width: 150, resizable: true, pinnable: false, visible: true, order: 7, description: 'Sorumlu admin kullanıcı' },
            { key: 'source', label: 'Kaynak', width: 120, resizable: true, pinnable: false, visible: true, order: 8, description: 'Lead kaynağı' },
            { key: 'created_at', label: 'Eklenme Tarihi', width: 130, resizable: true, pinnable: false, visible: true, order: 9, description: 'Lead oluşturulma tarihi' },
            { key: 'actions', label: 'İşlemler', width: 150, resizable: false, pinnable: false, visible: true, order: 10 }
        ];
        
        this.currentColumns = [];
        this.pinnedColumns = [];
        
        this.init();
    }
    
    init() {
        this.loadSettings();
        this.setupEventListeners();
    }
    
    /**
     * Load column settings from localStorage
     */
    loadSettings() {
        try {
            const saved = localStorage.getItem(this.storageKey);
            
            if (saved) {
                const settings = JSON.parse(saved);
                this.currentColumns = this.mergeWithDefaults(settings.columns || []);
                this.pinnedColumns = settings.pinnedColumns || [];
            } else {
                this.currentColumns = [...this.defaultColumns];
                this.pinnedColumns = ['name']; // Default pinned column
            }
            
            // Sort columns by order
            this.currentColumns.sort((a, b) => a.order - b.order);
            
        } catch (error) {
            console.error('Error loading column settings:', error);
            this.resetToDefaults();
        }
    }
    
    /**
     * Merge saved settings with default columns
     * This ensures new columns are added when the system is updated
     */
    mergeWithDefaults(savedColumns) {
        const merged = [];
        
        // Start with defaults
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
                    pinnable: defaultCol.pinnable
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
                timestamp: Date.now()
            };
            
            localStorage.setItem(this.storageKey, JSON.stringify(settings));
            
            // Emit event for components to update
            this.emit('columnSettingsUpdated', {
                visibleColumns: this.getVisibleColumns(),
                pinnedColumns: this.pinnedColumns
            });
            
        } catch (error) {
            console.error('Error saving column settings:', error);
        }
    }
    
    /**
     * Get all columns
     */
    getAllColumns() {
        return [...this.currentColumns];
    }
    
    /**
     * Get visible columns only
     */
    getVisibleColumns() {
        return this.currentColumns
            .filter(col => col.visible)
            .sort((a, b) => a.order - b.order);
    }
    
    /**
     * Get pinned columns
     */
    getPinnedColumns() {
        return [...this.pinnedColumns];
    }
    
    /**
     * Toggle column visibility
     */
    toggleColumnVisibility(columnKey) {
        const column = this.currentColumns.find(col => col.key === columnKey);
        
        if (column) {
            column.visible = !column.visible;
            
            // If hiding a pinned column, unpin it
            if (!column.visible && this.pinnedColumns.includes(columnKey)) {
                this.unpinColumn(columnKey);
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
            column.width = Math.max(50, Math.min(500, parseInt(width)));
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
        return column ? column.visible : false;
    }
    
    /**
     * Reset to default settings
     */
    resetToDefaults() {
        this.currentColumns = [...this.defaultColumns];
        this.pinnedColumns = ['name'];
        this.saveSettings();
    }
    
    /**
     * Get table style for column
     */
    getColumnStyle(columnKey) {
        const column = this.getColumn(columnKey);
        if (!column) return '';
        
        const styles = [`width: ${column.width}px`];
        
        if (this.isColumnPinned(columnKey)) {
            styles.push('position: sticky');
            styles.push('left: 0');
            styles.push('z-index: 10');
            styles.push('background: inherit');
        }
        
        return styles.join('; ');
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
        if (column && column.resizable) {
            classes.push('column-resizable');
        }
        
        return classes.join(' ');
    }
    
    /**
     * Setup drag and drop for column reordering
     */
    setupDragAndDrop(container) {
        if (!container) return;
        
        let draggedElement = null;
        let placeholder = null;
        
        container.addEventListener('dragstart', (e) => {
            if (!e.target.classList.contains('column-header')) return;
            
            draggedElement = e.target;
            e.target.style.opacity = '0.5';
            
            // Create placeholder
            placeholder = document.createElement('div');
            placeholder.className = 'column-placeholder';
            placeholder.style.width = e.target.offsetWidth + 'px';
            placeholder.style.height = e.target.offsetHeight + 'px';
            placeholder.style.background = 'rgba(59, 130, 246, 0.2)';
            placeholder.style.border = '2px dashed #3b82f6';
        });
        
        container.addEventListener('dragend', (e) => {
            if (e.target === draggedElement) {
                e.target.style.opacity = '';
                if (placeholder && placeholder.parentNode) {
                    placeholder.parentNode.removeChild(placeholder);
                }
                draggedElement = null;
                placeholder = null;
            }
        });
        
        container.addEventListener('dragover', (e) => {
            e.preventDefault();
            
            if (!draggedElement || !e.target.classList.contains('column-header')) return;
            
            const afterElement = this.getDragAfterElement(container, e.clientX);
            
            if (afterElement == null) {
                container.appendChild(placeholder);
            } else {
                container.insertBefore(placeholder, afterElement);
            }
        });
        
        container.addEventListener('drop', (e) => {
            e.preventDefault();
            
            if (!draggedElement || !placeholder) return;
            
            const fromIndex = Array.from(container.children).indexOf(draggedElement);
            const toIndex = Array.from(container.children).indexOf(placeholder);
            
            if (fromIndex !== toIndex) {
                this.reorderColumns(fromIndex, toIndex);
            }
        });
    }
    
    /**
     * Get element after drag position
     */
    getDragAfterElement(container, x) {
        const draggableElements = [...container.querySelectorAll('.column-header:not(.dragging)')];
        
        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = x - box.left - box.width / 2;
            
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }
    
    /**
     * Setup column resizing
     */
    setupColumnResizing(container) {
        if (!container) return;
        
        let isResizing = false;
        let currentColumn = null;
        let startX = 0;
        let startWidth = 0;
        
        container.addEventListener('mousedown', (e) => {
            if (!e.target.classList.contains('resize-handle')) return;
            
            isResizing = true;
            currentColumn = e.target.closest('.column-header');
            startX = e.clientX;
            startWidth = parseInt(document.defaultView.getComputedStyle(currentColumn).width, 10);
            
            document.addEventListener('mousemove', handleResize);
            document.addEventListener('mouseup', stopResize);
            
            e.preventDefault();
        });
        
        const handleResize = (e) => {
            if (!isResizing || !currentColumn) return;
            
            const width = startWidth + e.clientX - startX;
            const columnKey = currentColumn.dataset.columnKey;
            
            if (columnKey) {
                const newWidth = this.updateColumnWidth(columnKey, width);
                if (newWidth) {
                    currentColumn.style.width = newWidth + 'px';
                }
            }
        };
        
        const stopResize = () => {
            isResizing = false;
            currentColumn = null;
            
            document.removeEventListener('mousemove', handleResize);
            document.removeEventListener('mouseup', stopResize);
        };
    }
    
    /**
     * Event system
     */
    setupEventListeners() {
        // Listen for window resize to adjust column widths
        window.addEventListener('resize', this.debounce(() => {
            this.adjustColumnsToContainer();
        }, 250));
    }
    
    /**
     * Adjust columns to fit container
     */
    adjustColumnsToContainer() {
        const container = document.querySelector('.table-container');
        if (!container) return;
        
        const containerWidth = container.offsetWidth;
        const visibleColumns = this.getVisibleColumns();
        const totalWidth = visibleColumns.reduce((sum, col) => sum + col.width, 0);
        
        // If columns overflow, proportionally reduce widths
        if (totalWidth > containerWidth) {
            const ratio = containerWidth / totalWidth;
            
            visibleColumns.forEach(col => {
                if (col.resizable) {
                    col.width = Math.max(80, Math.floor(col.width * ratio));
                }
            });
            
            this.saveSettings();
        }
    }
    
    /**
     * Emit custom event
     */
    emit(eventName, data) {
        const event = new CustomEvent(eventName, {
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
     * Get column settings for export
     */
    getSettingsForExport() {
        return {
            columns: this.currentColumns,
            pinnedColumns: this.pinnedColumns
        };
    }
    
    /**
     * Import column settings
     */
    importSettings(settings) {
        try {
            if (settings.columns) {
                this.currentColumns = this.mergeWithDefaults(settings.columns);
            }
            
            if (settings.pinnedColumns) {
                this.pinnedColumns = settings.pinnedColumns;
            }
            
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

// Alpine.js integration helpers
window.columnManagerHelpers = {
    // Get all available columns for settings modal
    getAvailableColumns() {
        return window.columnManager.getAllColumns();
    },
    
    // Get visible columns for table rendering
    getVisibleColumns() {
        return window.columnManager.getVisibleColumns();
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
        
        // Update Alpine.js data
        this.availableColumns = window.columnManager.getAllColumns();
        this.visibleColumns = window.columnManager.getVisibleColumns();
        this.pinnedColumns = window.columnManager.getPinnedColumns();
    },
    
    // Save column settings
    saveColumnSettings() {
        window.columnManager.saveSettings();
        this.showColumnSettings = false;
        this.showNotification('Sütun ayarları kaydedildi', 'success');
    },
    
    // Load settings into Alpine.js component
    loadColumnSettings() {
        this.availableColumns = window.columnManager.getAllColumns();
        this.visibleColumns = window.columnManager.getVisibleColumns();
        this.pinnedColumns = window.columnManager.getPinnedColumns();
    }
};

export default ColumnManager;