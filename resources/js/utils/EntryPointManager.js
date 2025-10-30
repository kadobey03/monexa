/**
 * Vite Entry Point Manager
 * Handles conditional loading and lazy loading strategies for different application sections
 */

export class EntryPointManager {
    constructor() {
        this.loadedModules = new Map();
        this.loadingPromises = new Map();
        this.performance = {
            loadTimes: new Map(),
            errors: new Map(),
        };
    }

    /**
     * Dynamically load admin management modules based on current page
     * @param {string} section - Admin section identifier
     * @returns {Promise<Object>} Loaded module
     */
    async loadAdminModule(section) {
        const moduleKey = `admin-${section}`;
        
        if (this.loadedModules.has(moduleKey)) {
            return this.loadedModules.get(moduleKey);
        }

        if (this.loadingPromises.has(moduleKey)) {
            return this.loadingPromises.get(moduleKey);
        }

        const startTime = performance.now();
        const loadingPromise = this._loadAdminModuleInternal(section);
        this.loadingPromises.set(moduleKey, loadingPromise);

        try {
            const module = await loadingPromise;
            this.loadedModules.set(moduleKey, module);
            this.performance.loadTimes.set(moduleKey, performance.now() - startTime);
            return module;
        } catch (error) {
            this.performance.errors.set(moduleKey, error);
            this.loadingPromises.delete(moduleKey);
            throw error;
        } finally {
            this.loadingPromises.delete(moduleKey);
        }
    }

    /**
     * Internal admin module loading logic
     * @private
     */
    async _loadAdminModuleInternal(section) {
        switch (section) {
            case 'management':
                return await import('../admin-management.js');
            
            case 'leads':
                return await import('../admin/leads/vue/LeadAssignmentApp.js');
            
            case 'users':
                // Future admin user management module
                return await import('../modules/admin-management.js');
            
            default:
                throw new Error(`Unknown admin section: ${section}`);
        }
    }

    /**
     * Conditionally load Vue.js components based on page requirements
     * @param {string} component - Component identifier
     * @returns {Promise<Object>} Vue component
     */
    async loadVueComponent(component) {
        const componentKey = `vue-${component}`;
        
        if (this.loadedModules.has(componentKey)) {
            return this.loadedModules.get(componentKey);
        }

        const startTime = performance.now();
        
        try {
            let module;
            
            switch (component) {
                case 'lead-assignment':
                    module = await import('../admin/leads/vue/LeadAssignmentApp.js');
                    break;
                
                case 'lead-store':
                    module = await import('../admin/leads/vue/stores/leadStore.js');
                    break;
                
                default:
                    throw new Error(`Unknown Vue component: ${component}`);
            }

            this.loadedModules.set(componentKey, module);
            this.performance.loadTimes.set(componentKey, performance.now() - startTime);
            return module;
            
        } catch (error) {
            this.performance.errors.set(componentKey, error);
            throw error;
        }
    }

    /**
     * Preload critical modules based on page type
     * @param {string} pageType - Type of page (admin, user, public)
     */
    async preloadCriticalModules(pageType) {
        const preloadTasks = [];

        switch (pageType) {
            case 'admin':
                // Preload admin management modules
                preloadTasks.push(
                    this.loadAdminModule('management').catch(() => {}),
                    this.loadVueComponent('lead-assignment').catch(() => {})
                );
                break;

            case 'user':
                // Preload user-specific modules if any
                break;

            case 'public':
                // Minimal preloading for public pages
                break;
        }

        await Promise.allSettled(preloadTasks);
    }

    /**
     * Get performance metrics
     * @returns {Object} Performance data
     */
    getPerformanceMetrics() {
        return {
            loadTimes: Object.fromEntries(this.performance.loadTimes),
            errors: Object.fromEntries(this.performance.errors),
            loadedModules: Array.from(this.loadedModules.keys()),
            averageLoadTime: this._calculateAverageLoadTime(),
        };
    }

    /**
     * Calculate average load time
     * @private
     */
    _calculateAverageLoadTime() {
        const times = Array.from(this.performance.loadTimes.values());
        return times.length > 0 ? times.reduce((a, b) => a + b, 0) / times.length : 0;
    }

    /**
     * Clear cache and reset manager
     */
    reset() {
        this.loadedModules.clear();
        this.loadingPromises.clear();
        this.performance.loadTimes.clear();
        this.performance.errors.clear();
    }

    /**
     * Check if module is loaded
     * @param {string} moduleKey - Module identifier
     * @returns {boolean}
     */
    isModuleLoaded(moduleKey) {
        return this.loadedModules.has(moduleKey);
    }

    /**
     * Get loaded module
     * @param {string} moduleKey - Module identifier
     * @returns {Object|null}
     */
    getLoadedModule(moduleKey) {
        return this.loadedModules.get(moduleKey) || null;
    }
}

// Global instance
export const entryPointManager = new EntryPointManager();

// Helper functions for common use cases
export const loadAdminSection = (section) => entryPointManager.loadAdminModule(section);
export const loadVueApp = (component) => entryPointManager.loadVueComponent(component);
export const preloadForPage = (pageType) => entryPointManager.preloadCriticalModules(pageType);

// Auto-detect page type and preload
export const autoPreload = () => {
    const path = window.location.pathname;
    let pageType = 'public';

    if (path.includes('/admin')) {
        pageType = 'admin';
    } else if (path.includes('/user') || path.includes('/dashboard')) {
        pageType = 'user';
    }

    return preloadForPage(pageType);
};

export default EntryPointManager;