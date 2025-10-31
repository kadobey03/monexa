/**
 * Main Entry Point - Vite Standardına Uygun
 * Modern ES6+ import/export sistemine dayalı entry point
 */

// Core CSS imports
import '../css/app.css';

// Core JavaScript modules
import { CSRFManager } from './utils/csrf-manager';
import { NotificationManager } from './utils/notification-manager';
import { AdminManager } from './modules/admin-management';

// Page-specific modules
import { LeadsModule } from './modules/leads';
import { DashboardModule } from './modules/dashboard';

// Vue.js components (conditional loading)
import { createApp } from 'vue';
import { createPinia } from 'pinia';

// Global utilities
window.CSRFManager = CSRFManager;
window.NotificationManager = NotificationManager;
window.AdminManager = AdminManager;

/**
 * Application Initializer
 */
class Application {
    constructor() {
        this.modules = new Map();
        this.vueApps = new Map();
        this.initialized = false;
    }

    /**
     * Initialize the application
     */
    async init() {
        if (this.initialized) return;

        console.log('🚀 Monexa Application initializing...');
        
        try {
            // Initialize core utilities
            await this.initializeCore();
            
            // Initialize page-specific modules
            await this.initializeModules();
            
            // Initialize Vue.js components if needed
            await this.initializeVueComponents();
            
            this.initialized = true;
            console.log('✅ Monexa Application initialized successfully');
            
        } catch (error) {
            console.error('❌ Application initialization failed:', error);
            NotificationManager.error('Uygulama başlatılamadı. Sayfa yenilemeyi deneyin.');
        }
    }

    /**
     * Initialize core utilities
     */
    async initializeCore() {
        // Initialize CSRF manager
        CSRFManager.init();
        
        // Initialize notification system
        NotificationManager.init();
        
        // Setup global error handlers
        this.setupGlobalErrorHandlers();
        
        console.log('✅ Core utilities initialized');
    }

    /**
     * Initialize page-specific modules based on current page
     */
    async initializeModules() {
        const currentPath = window.location.pathname;
        
        // Admin leads module
        if (currentPath.includes('/admin/dashboard/leads') || document.querySelector('[data-leads-table]')) {
            const module = new LeadsModule();
            await module.init();
            this.modules.set('leads', module);
            console.log('✅ Leads module initialized');
        }
        
        // Dashboard module
        if (currentPath.includes('/dashboard') || document.querySelector('[data-dashboard]')) {
            const module = new DashboardModule();
            await module.init();
            this.modules.set('dashboard', module);
            console.log('✅ Dashboard module initialized');
        }

        // Admin management module (always available in admin area)
        if (currentPath.includes('/admin/')) {
            AdminManager.init();
            console.log('✅ Admin management module initialized');
        }
    }

    /**
     * Initialize Vue.js components conditionally
     */
    async initializeVueComponents() {
        const vueContainers = document.querySelectorAll('[data-vue-component]');
        
        if (vueContainers.length === 0) return;
        
        console.log(`Found ${vueContainers.length} Vue components to initialize`);
        
        for (const container of vueContainers) {
            const componentName = container.dataset.vueComponent;
            
            try {
                // Dynamic import based on component name
                const component = await this.loadVueComponent(componentName);
                
                if (component) {
                    const app = createApp(component.default || component);
                    app.use(createPinia());
                    
                    // Mount the app
                    app.mount(container);
                    this.vueApps.set(componentName, app);
                    
                    console.log(`✅ Vue component "${componentName}" mounted`);
                }
            } catch (error) {
                console.error(`Failed to load Vue component "${componentName}":`, error);
            }
        }
    }

    /**
     * Dynamically load Vue components
     */
    async loadVueComponent(componentName) {
        const componentMap = {
            'SmartDataTable': () => import('./components/common/SmartDataTable.vue'),
            // Add more components as needed
        };

        const loader = componentMap[componentName];
        if (!loader) {
            console.warn(`Vue component "${componentName}" not found`);
            return null;
        }

        return await loader();
    }

    /**
     * Setup global error handlers
     */
    setupGlobalErrorHandlers() {
        // Catch JavaScript errors
        window.addEventListener('error', (event) => {
            console.error('Global Error:', {
                message: event.message,
                filename: event.filename,
                line: event.lineno,
                column: event.colno,
                stack: event.error?.stack
            });
            
            NotificationManager.error('Bir hata oluştu. Sayfayı yenilemeyi deneyin.');
        });

        // Catch unhandled promise rejections
        window.addEventListener('unhandledrejection', (event) => {
            console.error('Unhandled Promise Rejection:', event.reason);
            
            if (event.reason?.message?.includes('fetch')) {
                NotificationManager.error('Sunucu bağlantısında sorun var. İnternet bağlantınızı kontrol edin.');
            }
        });
    }

    /**
     * Get initialized module
     */
    getModule(name) {
        return this.modules.get(name);
    }

    /**
     * Get Vue app instance
     */
    getVueApp(name) {
        return this.vueApps.get(name);
    }

    /**
     * Cleanup on page unload
     */
    cleanup() {
        // Cleanup modules
        this.modules.forEach((module, name) => {
            if (module.cleanup) {
                module.cleanup();
            }
        });

        // Unmount Vue apps
        this.vueApps.forEach((app, name) => {
            try {
                app.unmount();
            } catch (error) {
                console.warn(`Failed to unmount Vue app "${name}":`, error);
            }
        });

        // Cleanup utilities
        CSRFManager.cleanup?.();
        NotificationManager.cleanup?.();
        AdminManager.cleanup?.();

        console.log('🧹 Application cleanup completed');
    }
}

// Create global application instance
const app = new Application();

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => app.init());
} else {
    app.init();
}

// Cleanup on page unload
window.addEventListener('beforeunload', () => app.cleanup());

// Export for global access
window.MonexaApp = app;
export default app;