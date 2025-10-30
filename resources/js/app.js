/**
 * Monexa Financial - Main Entry Point
 * Vite-optimized application entry point with modern ES6+ imports
 * Hot Module Replacement (HMR) support and advanced asset management
 */

// Core CSS imports - Vite will handle optimization and tree-shaking
import '../css/app.css';

// Essential polyfills for older browsers (conditionally loaded)
if (!window.Promise) {
    import('es6-promise/auto');
}

// Core application initialization
import './main.js';

// Modern ES6 imports with dynamic loading
import axios from 'axios';
import { CSRFManager } from './utils/csrf-manager.js';
import { NotificationManager } from './utils/notification-manager.js';
import { EntryPointManager, autoPreload } from './utils/EntryPointManager.js';
import { DependencyManager, loadSwal, loadLucide, loadChart, loadQR } from './utils/DependencyManager.js';
import { HMRManager, registerHMR, registerVueHMR, registerCSSHMR, registerAdminHMR } from './utils/HMRManager.js';

// Initialize managers for better module and dependency management
const entryPointManager = new EntryPointManager();
const dependencyManager = new DependencyManager();
const hmrManager = new HMRManager();

// Auto-preload based on page type
Promise.all([
    autoPreload(),
    dependencyManager.preloadDependencies(['sweetalert2', 'lucide'])
])
    .then(() => {
        console.log('✅ Auto-preload and dependency preload completed');
    })
    .catch(error => {
        console.warn('⚠️  Auto-preload or dependency preload failed:', error);
    });

// Enhanced conditional loading with EntryPointManager
const isAdminArea = window.location.pathname.includes('/admin/');
const needsVue = document.querySelector('[data-vue-component]') !== null;

if (isAdminArea || needsVue) {
    // Load admin modules using EntryPointManager
    if (isAdminArea) {
        const adminSection = detectAdminSection();
        entryPointManager.loadAdminModule(adminSection)
            .then(module => {
                console.log(`✅ Admin ${adminSection} module loaded via EntryPointManager`);
                
                // Make admin modules globally available for backward compatibility
                if (module.ManagerOperations) window.AdminManager = module.ManagerOperations;
                if (module.RoleOperations) window.RoleManager = module.RoleOperations;
                if (module.PermissionOperations) window.PermissionManager = module.PermissionOperations;
            })
            .catch(error => {
                console.warn(`⚠️  Admin ${adminSection} module could not be loaded:`, error);
            });
    }
    
    // Load Vue components using EntryPointManager
    if (needsVue) {
        const vueContainers = document.querySelectorAll('[data-vue-app]');
        vueContainers.forEach(async (container) => {
            const appType = container.dataset.vueApp;
            
            try {
                const module = await entryPointManager.loadVueComponent(appType);
                
                // Mount Vue applications
                switch (appType) {
                    case 'lead-assignment':
                        if (module.createLeadAssignmentApp) {
                            const app = await module.createLeadAssignmentApp();
                            app.mount(container);
                            console.log(`✅ Vue ${appType} mounted via EntryPointManager`);
                        }
                        break;
                    
                    default:
                        console.warn(`Unknown Vue app type: ${appType}`);
                }
            } catch (error) {
                console.warn(`⚠️  Vue component ${appType} could not be loaded:`, error);
            }
        });
    }
}

/**
 * Detect admin section from URL
 */
function detectAdminSection() {
    const path = window.location.pathname;
    
    if (path.includes('/admin/leads')) {
        return 'leads';
    } else if (path.includes('/admin/users')) {
        return 'users';
    } else {
        return 'management';
    }
}

// Enhanced global utilities with modern syntax
class GlobalUtilities {
    static showToast(message, type = 'success', options = {}) {
        const defaultOptions = {
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        };

        const Toast = Swal.mixin({ ...defaultOptions, ...options });

        return Toast.fire({
            icon: type,
            title: message
        });
    }

    static confirmAction(title, text, confirmText = 'Evet', cancelText = 'İptal', options = {}) {
        const defaultOptions = {
            title,
            text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            confirmButtonText: confirmText,
            cancelButtonText: cancelText,
            reverseButtons: true
        };

        return Swal.fire({ ...defaultOptions, ...options });
    }

    static async loadScript(src) {
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = src;
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
        });
    }

    static debounce(func, wait = 300) {
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
}

// Enhanced axios configuration with better error handling
class AxiosConfig {
    static configure() {
        // Default headers for all requests
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.defaults.headers.common['Accept'] = 'application/json';
        axios.defaults.timeout = 30000; // 30 seconds

        // Configure CSRF token management
        CSRFManager.configureAxios(axios);

        // Enhanced request interceptor
        axios.interceptors.request.use(
            (config) => {
                // Add loading state management
                if (window.MonexaApp?.showLoader) {
                    window.MonexaApp.showLoader();
                }

                // Log requests in development
                if (import.meta.env.DEV) {
                    console.log(`🚀 API Request: ${config.method?.toUpperCase()} ${config.url}`);
                }

                return config;
            },
            (error) => {
                if (window.MonexaApp?.hideLoader) {
                    window.MonexaApp.hideLoader();
                }
                return Promise.reject(error);
            }
        );

        // Enhanced response interceptor with comprehensive error handling
        axios.interceptors.response.use(
            (response) => {
                if (window.MonexaApp?.hideLoader) {
                    window.MonexaApp.hideLoader();
                }

                if (import.meta.env.DEV) {
                    console.log(`✅ API Response: ${response.status} ${response.config.url}`);
                }

                return response;
            },
            (error) => {
                if (window.MonexaApp?.hideLoader) {
                    window.MonexaApp.hideLoader();
                }

                // Handle specific error cases
                if (error.response) {
                    const { status, data } = error.response;
                    
                    switch (status) {
                        case 401:
                            // Unauthorized - redirect to login
                            if (!window.location.pathname.includes('/login')) {
                                window.location.href = '/login';
                            }
                            break;
                        
                        case 403:
                            GlobalUtilities.showToast(
                                'Bu işlem için yetkiniz bulunmamaktadır.',
                                'error'
                            );
                            break;
                        
                        case 419:
                            // CSRF token mismatch - refresh and retry
                            CSRFManager.refreshToken()
                                .then(() => axios.request(error.config))
                                .catch(() => window.location.reload());
                            break;
                        
                        case 422:
                            // Validation errors
                            if (data?.errors && typeof NotificationManager !== 'undefined') {
                                NotificationManager.showValidationErrors(data.errors);
                            }
                            break;
                        
                        case 429:
                            GlobalUtilities.showToast(
                                'Çok fazla istek gönderdiniz. Lütfen biraz bekleyin.',
                                'warning'
                            );
                            break;
                        
                        case 500:
                        case 502:
                        case 503:
                        case 504:
                            GlobalUtilities.showToast(
                                'Sunucu hatası oluştu. Lütfen daha sonra tekrar deneyin.',
                                'error'
                            );
                            break;
                    }
                } else if (error.request) {
                    // Network error
                    GlobalUtilities.showToast(
                        'Bağlantı hatası. İnternet bağlantınızı kontrol edin.',
                        'error'
                    );
                } else {
                    console.error('❌ Request Error:', error.message);
                }

                return Promise.reject(error);
            }
        );
    }
}

// Initialize axios configuration
AxiosConfig.configure();

// Make utilities available globally (for backward compatibility)
window.showToast = GlobalUtilities.showToast;
window.confirmAction = GlobalUtilities.confirmAction;
window.axios = axios;
window.EntryPointManager = entryPointManager;
window.DependencyManager = dependencyManager;
window.HMRManager = hmrManager;

// Make dependency loaders globally available
window.loadSwal = loadSwal;
window.loadLucide = loadLucide;
window.loadChart = loadChart;
window.loadQR = loadQR;

// Make HMR helpers globally available
window.registerHMR = registerHMR;
window.registerVueHMR = registerVueHMR;
window.registerCSSHMR = registerCSSHMR;
window.registerAdminHMR = registerAdminHMR;

// Export utilities for modern imports
export { GlobalUtilities, AxiosConfig, entryPointManager, dependencyManager, hmrManager, loadSwal, loadLucide, loadChart, loadQR, registerHMR, registerVueHMR, registerCSSHMR, registerAdminHMR };
export default axios;

// Enhanced HMR support for development
if (import.meta.hot) {
    import.meta.hot.accept(['./main.js'], () => {
        console.log('🔥 HMR: Main application reloaded');
    });
    
    import.meta.hot.accept(['./utils/csrf-manager.js'], () => {
        console.log('🔥 HMR: CSRF Manager reloaded');
        CSRFManager.init();
    });
    
    import.meta.hot.accept(['./utils/EntryPointManager.js'], () => {
        console.log('🔥 HMR: EntryPointManager reloaded');
        // Reset and reinitialize EntryPointManager
        entryPointManager.reset();
        autoPreload().catch(console.error);
    });
    
    // HMR for Vue components
    import.meta.hot.accept(['./admin/leads/vue/LeadAssignmentApp.js'], () => {
        console.log('🔥 HMR: Vue Lead Assignment App reloaded');
    });
    
    // HMR for admin modules
    import.meta.hot.accept(['./admin-management.js'], () => {
        console.log('🔥 HMR: Admin management reloaded');
    });
    
    // HMR for dependency manager
    import.meta.hot.accept(['./utils/DependencyManager.js'], () => {
        console.log('🔥 HMR: DependencyManager reloaded');
        // Reset and reinitialize dependency manager
        dependencyManager.reset();
        dependencyManager.preloadDependencies(['sweetalert2', 'lucide']).catch(console.error);
    });
    
    // HMR for HMR manager itself
    import.meta.hot.accept(['./utils/HMRManager.js'], () => {
        console.log('🔥 HMR: HMRManager reloaded');
        // Reset HMR stats
        hmrManager.resetStats();
    });
    
    // Register enhanced HMR for CSS
    registerCSSHMR('../css/app.css', () => {
        console.log('🔥 HMR: Main CSS reloaded');
    });
    
    // Register enhanced HMR for admin CSS
    registerCSSHMR('../css/admin/leads-table.css', () => {
        console.log('🔥 HMR: Admin leads CSS reloaded');
    });
}

// Performance monitoring for all managers
if (import.meta.env.DEV) {
    // Log performance metrics every 30 seconds in development
    setInterval(() => {
        const entryMetrics = entryPointManager.getPerformanceMetrics();
        const depMetrics = dependencyManager.getMetrics();
        const hmrStats = hmrManager.getStats();
        
        if (entryMetrics.loadedModules.length > 0 || depMetrics.loadedCount > 0 || hmrStats.reloadCount > 0) {
            console.log('📊 Performance Metrics:', {
                entryPoint: entryMetrics,
                dependencies: depMetrics,
                hmr: hmrStats
            });
        }
    }, 30000);
}

