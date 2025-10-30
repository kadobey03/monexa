/**
 * Hot Module Replacement (HMR) Manager
 * Enhanced HMR support for both JavaScript and CSS modules
 */

export class HMRManager {
    constructor() {
        this.hmrHandlers = new Map();
        this.reloadCount = 0;
        this.lastReloadTime = Date.now();
        
        this.initializeHMR();
    }

    /**
     * Initialize HMR if available
     * @private
     */
    initializeHMR() {
        if (!import.meta.hot) {
            console.log('🔥 HMR not available - running in production mode');
            return;
        }

        console.log('🔥 HMR Manager initialized');
        this.setupGlobalHMRHandlers();
    }

    /**
     * Setup global HMR handlers
     * @private
     */
    setupGlobalHMRHandlers() {
        if (!import.meta.hot) return;

        // Handle HMR updates
        import.meta.hot.on('vite:beforeUpdate', (payload) => {
            console.log('🔥 HMR: About to update', payload);
            this.beforeUpdate(payload);
        });

        import.meta.hot.on('vite:afterUpdate', (payload) => {
            console.log('🔥 HMR: Updated', payload);
            this.afterUpdate(payload);
        });

        // Handle CSS updates
        import.meta.hot.on('vite:invalidate', (payload) => {
            console.log('🔥 HMR: Invalidating', payload);
            this.invalidate(payload);
        });

        // Error handling
        import.meta.hot.on('vite:error', (payload) => {
            console.error('🔥 HMR Error:', payload);
            this.handleError(payload);
        });
    }

    /**
     * Register a custom HMR handler
     * @param {string} modulePath - Path to the module
     * @param {Function} handler - Handler function
     */
    registerHandler(modulePath, handler) {
        if (!import.meta.hot) return;

        this.hmrHandlers.set(modulePath, handler);
        
        import.meta.hot.accept([modulePath], (modules) => {
            console.log(`🔥 HMR: ${modulePath} updated`);
            
            try {
                handler(modules);
                this.reloadCount++;
                this.lastReloadTime = Date.now();
            } catch (error) {
                console.error(`🔥 HMR Error in ${modulePath}:`, error);
                this.handleError({ error, module: modulePath });
            }
        });
    }

    /**
     * Register Vue component HMR
     * @param {string} componentPath - Path to Vue component
     * @param {Function} reloadFn - Component reload function
     */
    registerVueComponent(componentPath, reloadFn) {
        this.registerHandler(componentPath, () => {
            console.log(`🔥 HMR: Reloading Vue component ${componentPath}`);
            
            if (typeof reloadFn === 'function') {
                reloadFn();
            } else {
                // Default Vue component reload
                this.reloadVueComponents();
            }
        });
    }

    /**
     * Register CSS HMR
     * @param {string} cssPath - Path to CSS file
     * @param {Function} reloadFn - CSS reload function
     */
    registerCSS(cssPath, reloadFn) {
        this.registerHandler(cssPath, () => {
            console.log(`🔥 HMR: Reloading CSS ${cssPath}`);
            
            if (typeof reloadFn === 'function') {
                reloadFn();
            } else {
                // Default CSS reload behavior
                this.reloadStylesheets();
            }
        });
    }

    /**
     * Register admin module HMR
     * @param {string} modulePath - Path to admin module
     * @param {Function} reinitFn - Module reinitialization function
     */
    registerAdminModule(modulePath, reinitFn) {
        this.registerHandler(modulePath, () => {
            console.log(`🔥 HMR: Reloading admin module ${modulePath}`);
            
            if (typeof reinitFn === 'function') {
                reinitFn();
            }
        });
    }

    /**
     * Before update handler
     * @private
     */
    beforeUpdate(payload) {
        // Show loading indicator for major updates
        if (payload?.updates?.length > 3) {
            this.showHMRLoader();
        }
    }

    /**
     * After update handler
     * @private
     */
    afterUpdate(payload) {
        this.hideHMRLoader();
        
        // Auto-refresh if too many updates
        if (this.reloadCount > 50) {
            console.log('🔥 HMR: Too many reloads, refreshing page...');
            this.fullReload();
        }
    }

    /**
     * Invalidation handler
     * @private
     */
    invalidate(payload) {
        // Handle module invalidation
        if (payload?.path) {
            const handler = this.hmrHandlers.get(payload.path);
            if (handler) {
                try {
                    handler();
                } catch (error) {
                    console.error(`🔥 HMR Invalidation error for ${payload.path}:`, error);
                }
            }
        }
    }

    /**
     * Error handler
     * @private
     */
    handleError(payload) {
        const errorMessage = payload.error?.message || payload.message || 'Unknown HMR error';
        
        // Show user-friendly error notification
        if (window.showToast) {
            window.showToast(
                `HMR Hatası: ${errorMessage}`,
                'error',
                { timer: 5000 }
            );
        }

        // Log detailed error for debugging
        console.error('🔥 HMR Error Details:', payload);
    }

    /**
     * Reload Vue components
     * @private
     */
    reloadVueComponents() {
        const vueApps = document.querySelectorAll('[data-vue-app]');
        
        vueApps.forEach(app => {
            const appType = app.dataset.vueApp;
            console.log(`🔥 HMR: Reloading Vue app ${appType}`);
            
            // Trigger component reload if EntryPointManager is available
            if (window.EntryPointManager) {
                window.EntryPointManager.reset();
            }
        });
    }

    /**
     * Reload stylesheets
     * @private
     */
    reloadStylesheets() {
        const stylesheets = document.querySelectorAll('link[rel="stylesheet"]');
        
        stylesheets.forEach(link => {
            const href = link.href;
            const newLink = link.cloneNode();
            newLink.href = href.includes('?') ? `${href}&_t=${Date.now()}` : `${href}?_t=${Date.now()}`;
            
            newLink.onload = () => {
                link.remove();
                console.log(`🔥 HMR: CSS reloaded ${href}`);
            };
            
            link.parentNode.insertBefore(newLink, link.nextSibling);
        });
    }

    /**
     * Show HMR loading indicator
     * @private
     */
    showHMRLoader() {
        if (document.getElementById('hmr-loader')) return;

        const loader = document.createElement('div');
        loader.id = 'hmr-loader';
        loader.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #3b82f6;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            z-index: 10000;
            font-family: monospace;
            font-size: 12px;
        `;
        loader.textContent = '🔥 HMR Updating...';
        document.body.appendChild(loader);
    }

    /**
     * Hide HMR loading indicator
     * @private
     */
    hideHMRLoader() {
        const loader = document.getElementById('hmr-loader');
        if (loader) {
            loader.remove();
        }
    }

    /**
     * Force full page reload
     */
    fullReload() {
        window.location.reload();
    }

    /**
     * Get HMR statistics
     * @returns {Object}
     */
    getStats() {
        return {
            reloadCount: this.reloadCount,
            lastReloadTime: this.lastReloadTime,
            registeredHandlers: this.hmrHandlers.size,
            isHMRAvailable: !!import.meta.hot,
            uptime: Date.now() - (window.APP_START_TIME || Date.now())
        };
    }

    /**
     * Reset HMR statistics
     */
    resetStats() {
        this.reloadCount = 0;
        this.lastReloadTime = Date.now();
        console.log('🔥 HMR stats reset');
    }
}

// Create global instance
export const hmrManager = new HMRManager();

// Helper functions
export const registerHMR = (path, handler) => hmrManager.registerHandler(path, handler);
export const registerVueHMR = (path, reload) => hmrManager.registerVueComponent(path, reload);
export const registerCSSHMR = (path, reload) => hmrManager.registerCSS(path, reload);
export const registerAdminHMR = (path, reinit) => hmrManager.registerAdminModule(path, reinit);

// Global availability
if (typeof window !== 'undefined') {
    window.HMRManager = hmrManager;
    window.APP_START_TIME = Date.now();
}

export default HMRManager;