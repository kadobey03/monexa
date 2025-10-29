/**
 * Leads Module Index - Vanilla JavaScript Implementation
 * Tüm lead yönetimi modüllerini yükler ve entegre eder
 * Alpine.js bağımlılığı kaldırılmış modüler yapı
 */

// Import all modules
import LeadsTableManager from './LeadsTableManager.js';
import ColumnManager from './ColumnManager.js';
import FilterManager from './FilterManager.js';
import BulkActionManager from './BulkActionManager.js';
import { LeadsDataManager } from './leads-data-manager.js';

/**
 * Initialize Leads Module
 * Bu fonksiyon sayfa yüklendiğinde çağrılmalı
 */
function initializeLeadsModule() {
    // Check if we're on the leads page
    if (!document.querySelector('[data-leads-table]')) {
        return;
    }
    
    console.log('🚀 Lead Yönetim Sistemi başlatılıyor (Vanilla JS)...');
    
    // Initialize Lucide icons if available
    if (window.lucide) {
        window.lucide.createIcons();
    }
    
    // Initialize the main data manager
    const dataManager = window.initializeLeadsDataManager();
    
    if (!dataManager) {
        console.error('Failed to initialize Leads Data Manager');
        return;
    }
    
    // Setup global error handling for the module
    setupErrorHandling();
    
    // Setup auto-refresh if user is idle
    setupAutoRefresh(dataManager);
    
    // Setup keyboard shortcuts
    setupKeyboardShortcuts(dataManager);
    
    // Setup performance monitoring
    setupPerformanceMonitoring();
    
    console.log('✅ Lead Yönetim Sistemi hazır (Vanilla JS)');
}

/**
 * Global error handling for the module
 */
function setupErrorHandling() {
    // Capture and handle JavaScript errors in the leads module
    window.addEventListener('error', (event) => {
        if (event.filename && event.filename.includes('/admin/leads/')) {
            console.error('Leads Module Error:', {
                message: event.message,
                filename: event.filename,
                line: event.lineno,
                column: event.colno,
                stack: event.error?.stack
            });
            
            // Show user-friendly error message
            showGlobalNotification('Bir hata oluştu. Sayfa yenilenmesi gerekebilir.', 'error');
        }
    });
    
    // Capture unhandled promise rejections
    window.addEventListener('unhandledrejection', (event) => {
        console.error('Unhandled Promise Rejection in Leads Module:', event.reason);
        
        if (event.reason?.message?.includes('fetch')) {
            showGlobalNotification('Sunucu ile bağlantı sorunu. Lütfen internet bağlantınızı kontrol edin.', 'error');
        }
    });
}

/**
 * Auto-refresh setup for idle users
 */
function setupAutoRefresh(dataManager) {
    let idleTime = 0;
    let idleTimer;
    const maxIdleTime = 30; // 30 minutes
    
    // Reset idle timer on user activity
    const resetIdleTimer = () => {
        idleTime = 0;
        clearInterval(idleTimer);
        
        idleTimer = setInterval(() => {
            idleTime++;
            
            // Auto-refresh data if user has been idle for too long
            if (idleTime >= maxIdleTime && dataManager) {
                console.log('Auto-refreshing leads data due to inactivity');
                dataManager.loadLeads();
                idleTime = 0; // Reset after refresh
            }
        }, 60000); // Check every minute
    };
    
    // Listen for user activity
    ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'].forEach(event => {
        document.addEventListener(event, resetIdleTimer, true);
    });
    
    resetIdleTimer(); // Start the timer
}

/**
 * Keyboard shortcuts setup
 */
function setupKeyboardShortcuts(dataManager) {
    document.addEventListener('keydown', (e) => {
        // Only work if we're on the leads page and not in an input field
        if (!document.querySelector('[data-leads-table]') || 
            ['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName)) {
            return;
        }
        
        if (!dataManager) return;
        
        // Keyboard shortcuts
        switch (e.key) {
            case 'n':
            case 'N':
                if (e.ctrlKey || e.metaKey) {
                    e.preventDefault();
                    dataManager.openEditModal();
                }
                break;
                
            case 'f':
            case 'F':
                if (e.ctrlKey || e.metaKey) {
                    e.preventDefault();
                    dataManager.toggleFilters();
                }
                break;
                
            case 'r':
            case 'R':
                if (e.ctrlKey || e.metaKey) {
                    e.preventDefault();
                    dataManager.loadLeads();
                }
                break;
                
            case 'a':
            case 'A':
                if (e.ctrlKey || e.metaKey) {
                    e.preventDefault();
                    dataManager.selectAllLeads();
                }
                break;
                
            case 'c':
            case 'C':
                if (e.ctrlKey || e.metaKey && e.shiftKey) {
                    e.preventDefault();
                    dataManager.toggleColumnSettings();
                }
                break;
                
            case 'Escape':
                // Close modals and filters
                dataManager.setState({
                    showFilters: false,
                    showColumnSettings: false,
                    showLeadModal: false,
                    showEditModal: false
                });
                dataManager.clearSelection();
                break;
        }
    });
}

/**
 * Performance monitoring
 */
function setupPerformanceMonitoring() {
    // Monitor API response times
    const originalFetch = window.fetch;
    
    window.fetch = async function(...args) {
        const startTime = performance.now();
        const url = args[0];
        
        try {
            const response = await originalFetch.apply(this, args);
            const endTime = performance.now();
            const duration = endTime - startTime;
            
            // Log slow requests (over 2 seconds)
            if (duration > 2000 && url.includes('/admin/dashboard/leads/')) {
                console.warn(`Slow API request: ${url} took ${duration.toFixed(2)}ms`);
                
                if (duration > 5000) {
                    showGlobalNotification('API yanıtı yavaş. Sunucu yoğunluğu olabilir.', 'warning');
                }
            }
            
            return response;
        } catch (error) {
            const endTime = performance.now();
            console.error(`API request failed: ${url} after ${(endTime - startTime).toFixed(2)}ms`, error);
            throw error;
        }
    };
    
    // Monitor memory usage
    if ('memory' in performance) {
        setInterval(() => {
            const memory = performance.memory;
            const usedMB = Math.round(memory.usedJSHeapSize / 1024 / 1024);
            const limitMB = Math.round(memory.jsHeapSizeLimit / 1024 / 1024);
            
            // Warn if memory usage is over 80%
            if (usedMB / limitMB > 0.8) {
                console.warn(`High memory usage: ${usedMB}MB / ${limitMB}MB`);
            }
        }, 30000); // Check every 30 seconds
    }
}

/**
 * Show global notification
 */
function showGlobalNotification(message, type = 'info') {
    const dataManager = window.leadsDataManagerInstance;
    
    if (dataManager && dataManager.showNotification) {
        dataManager.showNotification(message, type);
    } else {
        // Fallback notification
        console.log(`${type.toUpperCase()}: ${message}`);
        
        // Create a simple toast notification
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm ${
            type === 'error' ? 'bg-red-100 text-red-800 border border-red-200' :
            type === 'warning' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' :
            type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' :
            'bg-blue-100 text-blue-800 border border-blue-200'
        }`;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }
}

/**
 * Settings management utilities
 */
window.leadsModuleSettings = {
    export() {
        const dataManager = window.leadsDataManagerInstance;
        
        if (!dataManager) {
            return null;
        }

        return {
            columns: dataManager.state.availableColumns || [],
            filters: dataManager.state.filters || {},
            perPage: dataManager.state.perPage || 25,
            sortColumn: dataManager.state.sortColumn || 'created_at',
            sortDirection: dataManager.state.sortDirection || 'desc',
            timestamp: new Date().toISOString(),
            version: '3.0'
        };
    },
    
    import(settings) {
        try {
            const dataManager = window.leadsDataManagerInstance;
            
            if (!dataManager) {
                throw new Error('Leads Data Manager not found');
            }
            
            if (settings.columns) {
                dataManager.state.availableColumns = settings.columns;
            }
            
            if (settings.filters) {
                dataManager.state.filters = { ...dataManager.state.filters, ...settings.filters };
            }
            
            if (settings.perPage) {
                dataManager.state.perPage = settings.perPage;
            }
            
            if (settings.sortColumn) {
                dataManager.state.sortColumn = settings.sortColumn;
            }
            
            if (settings.sortDirection) {
                dataManager.state.sortDirection = settings.sortDirection;
            }
            
            // Save to localStorage
            dataManager.saveSettings();
            
            // Reload data
            dataManager.loadLeads();
            
            return {
                success: true,
                message: 'Settings imported successfully'
            };
            
        } catch (error) {
            return {
                success: false,
                error: error.message
            };
        }
    },
    
    reset() {
        if (confirm('Tüm ayarlar sıfırlanacak. Devam etmek istiyor musunuz?')) {
            // Clear localStorage
            localStorage.removeItem('leads_table_columns');
            localStorage.removeItem('leads_table_filters');
            localStorage.removeItem('leads_table_per_page');
            localStorage.removeItem('leads_table_sort');
            
            showGlobalNotification('Tüm ayarlar sıfırlandı', 'success');
            
            // Reload page to apply changes
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }
    }
};

/**
 * Debug utilities for development
 */
if (process.env.NODE_ENV === 'development' || window.location.hostname === 'localhost') {
    window.leadsDebug = {
        getDataManager() {
            return window.leadsDataManagerInstance;
        },
        
        getState() {
            const dataManager = this.getDataManager();
            return dataManager ? dataManager.state : null;
        },
        
        getManagers() {
            const dataManager = this.getDataManager();
            return dataManager ? {
                table: dataManager.tableManager,
                column: dataManager.columnManager,
                filter: dataManager.filterManager,
                bulkAction: dataManager.bulkActionManager
            } : null;
        },
        
        simulate: {
            slowApi() {
                const originalFetch = window.fetch;
                window.fetch = async function(...args) {
                    await new Promise(resolve => setTimeout(resolve, 3000));
                    return originalFetch.apply(this, args);
                };
                console.log('API calls will now be delayed by 3 seconds');
            },
            
            networkError() {
                window.fetch = async function() {
                    throw new Error('Simulated network error');
                };
                console.log('All API calls will now fail with network error');
            },
            
            reset() {
                window.location.reload();
            }
        },
        
        performance: {
            measure: (name, fn) => {
                const start = performance.now();
                const result = fn();
                const end = performance.now();
                console.log(`${name} took ${end - start} milliseconds`);
                return result;
            }
        },
        
        shortcuts: {
            'Ctrl+N': 'New lead',
            'Ctrl+F': 'Toggle filters',
            'Ctrl+R': 'Reload leads',
            'Ctrl+A': 'Select all',
            'Ctrl+Shift+C': 'Column settings',
            'Escape': 'Close modals/clear selection'
        }
    };
    
    console.log('🛠️ Leads Debug utilities available at window.leadsDebug');
    console.table(window.leadsDebug.shortcuts);
}

/**
 * Module health check
 */
function healthCheck() {
    const dataManager = window.leadsDataManagerInstance;
    
    const checks = [
        { name: 'Data Manager Instance', test: () => !!dataManager },
        { name: 'CSRF Token', test: () => !!document.querySelector('meta[name="csrf-token"]') },
        { name: 'Leads Container', test: () => !!document.querySelector('[data-leads-table]') },
        { name: 'Table Manager', test: () => !!dataManager?.tableManager },
        { name: 'Column Manager', test: () => !!dataManager?.columnManager },
        { name: 'Filter Manager', test: () => !!dataManager?.filterManager },
        { name: 'Bulk Action Manager', test: () => !!dataManager?.bulkActionManager },
        { name: 'CSS File', test: () => !!document.querySelector('link[href*="leads-table.css"]') }
    ];
    
    const results = checks.map(check => ({
        name: check.name,
        status: check.test() ? 'OK' : 'FAIL'
    }));
    
    const allPassed = results.every(r => r.status === 'OK');
    
    console.table(results);
    
    if (!allPassed) {
        console.error('⚠️ Some components failed health check. The system may not work properly.');
    } else {
        console.log('✅ All components passed health check');
    }
    
    return allPassed;
}

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeLeadsModule);
} else {
    initializeLeadsModule();
}

// Export for manual initialization if needed
export { 
    initializeLeadsModule,
    healthCheck,
    LeadsTableManager,
    ColumnManager,
    FilterManager,
    BulkActionManager,
    LeadsDataManager
};

// Add to window for global access
window.leadsModule = {
    initialize: initializeLeadsModule,
    healthCheck: healthCheck
};

console.log('📦 Leads Module loaded with Vanilla JavaScript');