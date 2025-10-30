/**
 * Bootstrap - Modern Application Initialization
 * Vite-optimized Laravel application setup with advanced features
 * Hot Module Replacement support and performance optimizations
 */

import { Application } from './main.js';
import { CSRFManager } from './utils/csrf-manager.js';
import { NotificationManager } from './utils/notification-manager.js';

/**
 * Configure Axios HTTP library with modern defaults
 * Enhanced with better error handling and performance optimizations
 */
import axios from 'axios';

// Enhanced axios defaults for better performance
const configureAxios = () => {
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.headers.common['Accept'] = 'application/json';
    axios.defaults.timeout = import.meta.env.VITE_API_TIMEOUT || 30000;
    
    // Enable compression
    axios.defaults.headers.common['Accept-Encoding'] = 'gzip, deflate, br';
    
    // Configure CSRF token management
    CSRFManager.configureAxios(axios);
};

// Initialize axios configuration
configureAxios();

// Request interceptor for debugging and loading states
axios.interceptors.request.use(
  (config) => {
    // Add loading indicator if available
    if (window.App && typeof window.App.showLoader === 'function') {
      window.App.showLoader();
    }
    
    // Log requests in development
    if (import.meta.env.DEV) {
      console.log('🚀 Request:', config.method?.toUpperCase(), config.url);
    }
    
    return config;
  },
  (error) => {
    if (window.App && typeof window.App.hideLoader === 'function') {
      window.App.hideLoader();
    }
    
    console.error('❌ Request Error:', error);
    return Promise.reject(error);
  }
);

// Response interceptor for error handling and loading states
axios.interceptors.response.use(
  (response) => {
    // Hide loading indicator
    if (window.App && typeof window.App.hideLoader === 'function') {
      window.App.hideLoader();
    }
    
    // Log successful responses in development
    if (import.meta.env.DEV) {
      console.log('✅ Response:', response.status, response.config.url);
    }
    
    return response;
  },
  (error) => {
    // Hide loading indicator
    if (window.App && typeof window.App.hideLoader === 'function') {
      window.App.hideLoader();
    }
    
    // Handle common HTTP errors
    if (error.response) {
      const { status, data } = error.response;
      
      switch (status) {
        case 401:
          // Unauthorized - redirect to login
          if (window.location.pathname !== '/login') {
            window.location.href = '/login';
          }
          break;
        
        case 403:
          // Forbidden
          if (window.App && typeof window.App.showError === 'function') {
            window.App.showError('Bu işlem için yetkiniz bulunmamaktadır.');
          }
          break;
        
        case 404:
          // Not found
          console.warn('⚠️  Resource not found:', error.config.url);
          break;
        
        case 419:
          // CSRF token mismatch - refresh token and retry
          CSRFManager.refreshToken().then(() => {
            // Retry the original request
            return axios.request(error.config);
          });
          break;
        
        case 422:
          // Validation errors
          if (data && data.errors && window.App && typeof window.App.showValidationErrors === 'function') {
            window.App.showValidationErrors(data.errors);
          }
          break;
        
        case 429:
          // Rate limited
          if (window.App && typeof window.App.showError === 'function') {
            window.App.showError('Çok fazla istek gönderdiniz. Lütfen biraz bekleyin.');
          }
          break;
        
        case 500:
        case 502:
        case 503:
        case 504:
          // Server errors
          if (window.App && typeof window.App.showError === 'function') {
            window.App.showError('Sunucu hatası oluştu. Lütfen daha sonra tekrar deneyin.');
          }
          break;
        
        default:
          console.error('❌ HTTP Error:', status, data);
          if (window.App && typeof window.App.showError === 'function') {
            window.App.showError('Beklenmeyen bir hata oluştu.');
          }
      }
    } else if (error.request) {
      // Network error
      console.error('❌ Network Error:', error.message);
      if (window.App && typeof window.App.showError === 'function') {
        window.App.showError('Bağlantı hatası. İnternet bağlantınızı kontrol edin.');
      }
    } else {
      // Other errors
      console.error('❌ Error:', error.message);
    }
    
    return Promise.reject(error);
  }
);

// Make axios available globally
window.axios = axios;

/**
 * Echo (Laravel Broadcasting) setup with dynamic loading
 * Enhanced with connection management and fallback handling
 */
class BroadcastingManager {
    static instance = null;
    static echo = null;

    static async initialize() {
        if (this.instance) return this.instance;

        const driver = import.meta.env.VITE_BROADCAST_DRIVER;
        
        if (driver === 'pusher') {
            try {
                const [{ default: Echo }, { default: Pusher }] = await Promise.all([
                    import('laravel-echo'),
                    import('pusher-js')
                ]);

                window.Pusher = Pusher;
                
                this.echo = new Echo({
                    broadcaster: 'pusher',
                    key: import.meta.env.VITE_PUSHER_APP_KEY,
                    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
                    wsHost: import.meta.env.VITE_PUSHER_HOST ||
                           `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.channels`,
                    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
                    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
                    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
                    enabledTransports: ['ws', 'wss'],
                    
                    // Enhanced connection options
                    authEndpoint: '/api/broadcasting/auth',
                    auth: {
                        headers: {
                            Authorization: `Bearer ${window.authToken}`,
                        },
                    },
                });

                // Connection event listeners
                this.echo.connector.pusher.connection.bind('connected', () => {
                    console.log('✅ Broadcasting connected');
                });

                this.echo.connector.pusher.connection.bind('disconnected', () => {
                    console.log('🔌 Broadcasting disconnected');
                });

                this.echo.connector.pusher.connection.bind('error', (error) => {
                    console.error('❌ Broadcasting error:', error);
                });

                window.Echo = this.echo;
                this.instance = this;
                
                console.log('✅ Laravel Echo initialized successfully');
                
            } catch (error) {
                console.warn('⚠️  Laravel Echo initialization failed:', error);
                
                // Fallback for failed broadcasting
                window.Echo = {
                    channel: () => ({ listen: () => {}, whisper: () => {} }),
                    private: () => ({ listen: () => {}, whisper: () => {} }),
                    join: () => ({ listen: () => {}, whisper: () => {} }),
                };
            }
        }

        return this.instance;
    }

    static disconnect() {
        if (this.echo) {
            this.echo.disconnect();
            this.echo = null;
            this.instance = null;
            console.log('🔌 Broadcasting disconnected');
        }
    }
}

// Initialize broadcasting if needed
if (import.meta.env.VITE_BROADCAST_DRIVER) {
    BroadcastingManager.initialize();
}

/**
 * Enhanced Application Initialization with better error handling
 */
class ApplicationBootstrapper {
    static instance = null;
    static app = null;

    static async initialize() {
        if (this.instance) return this.instance;

        try {
            console.log('🚀 Monexa Application initializing...');
            
            // Initialize core utilities first
            await this.initializeCore();
            
            // Initialize the main application
            this.app = new Application();
            await this.app.init();
            
            // Development-specific setup
            if (import.meta.env.DEV) {
                window.MonexaApp = this.app;
                window.BroadcastingManager = BroadcastingManager;
                console.log('🎉 Application initialized successfully (Development Mode)');
            } else {
                // Production-specific setup
                console.log('✅ Application initialized successfully');
            }
            
            // Dispatch application ready event
            this.dispatchReadyEvent();
            
            this.instance = this;
            
        } catch (error) {
            console.error('❌ Application initialization failed:', error);
            this.showInitializationError(error);
        }

        return this.instance;
    }

    static async initializeCore() {
        // Initialize CSRF manager
        CSRFManager.init();
        
        // Initialize notification system
        NotificationManager.init();
        
        console.log('✅ Core utilities initialized');
    }

    static dispatchReadyEvent() {
        const readyEvent = new CustomEvent('monexa:ready', {
            detail: {
                app: this.app,
                timestamp: Date.now(),
                version: import.meta.env.VITE_APP_VERSION || '1.0.0'
            }
        });
        
        window.dispatchEvent(readyEvent);
        
        // Legacy event for backward compatibility
        window.dispatchEvent(new CustomEvent('app:ready', {
            detail: { app: this.app }
        }));
    }

    static showInitializationError(error) {
        // Create error overlay with better UX
        const errorOverlay = document.createElement('div');
        errorOverlay.className = 'fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50';
        errorOverlay.innerHTML = `
            <div class="bg-white rounded-lg shadow-2xl max-w-md mx-4 p-6 text-center">
                <div class="text-red-500 text-5xl mb-4">⚠️</div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Uygulama Başlatılamadı</h2>
                <p class="text-gray-600 mb-6">Teknik bir sorun nedeniyle uygulama başlatılamadı.</p>
                
                <div class="space-y-3">
                    <button
                        onclick="window.location.reload()"
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors font-medium"
                    >
                        Sayfayı Yenile
                    </button>
                    
                    ${import.meta.env.DEV ? `
                        <button
                            onclick="this.parentElement.parentElement.parentElement.remove()"
                            class="w-full bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition-colors"
                        >
                            Devam Et (Development)
                        </button>
                        <details class="text-left text-sm text-gray-500 mt-4">
                            <summary class="cursor-pointer">Teknik Detaylar</summary>
                            <pre class="mt-2 p-2 bg-gray-100 rounded text-xs overflow-auto">${error.stack}</pre>
                        </details>
                    ` : ''}
                </div>
            </div>
        `;
        
        document.body.appendChild(errorOverlay);
    }

    static cleanup() {
        if (this.app?.cleanup) {
            this.app.cleanup();
        }
        
        BroadcastingManager.disconnect();
        
        this.instance = null;
        this.app = null;
        
        console.log('🧹 Application cleanup completed');
    }
}

// Enhanced DOM ready handling with better error recovery
const initializeWhenReady = () => {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => ApplicationBootstrapper.initialize());
    } else {
        ApplicationBootstrapper.initialize();
    }
};

// Initialize application
initializeWhenReady();

/**
 * Enhanced Performance and Lifecycle Management
 */
class PerformanceManager {
    static init() {
        this.setupVisibilityHandling();
        this.setupConnectionHandling();
        this.setupPerformanceMonitoring();
        this.setupErrorHandling();
        this.setupServiceWorker();
    }

    static setupVisibilityHandling() {
        document.addEventListener('visibilitychange', () => {
            const app = window.MonexaApp || ApplicationBootstrapper.app;
            
            if (app) {
                if (document.hidden) {
                    // Page hidden - optimize performance
                    app.pause?.();
                    BroadcastingManager.disconnect();
                } else {
                    // Page visible - resume operations
                    app.resume?.();
                    if (import.meta.env.VITE_BROADCAST_DRIVER) {
                        BroadcastingManager.initialize();
                    }
                }
            }
        });
    }

    static setupConnectionHandling() {
        window.addEventListener('online', () => {
            NotificationManager.showToast('Bağlantı geri geldi.', 'success');
            
            // Refresh CSRF token and retry failed requests
            CSRFManager.refreshToken();
            
            // Reconnect broadcasting
            if (import.meta.env.VITE_BROADCAST_DRIVER) {
                BroadcastingManager.initialize();
            }
        });

        window.addEventListener('offline', () => {
            NotificationManager.showToast('İnternet bağlantısı kesildi.', 'warning');
            BroadcastingManager.disconnect();
        });
    }

    static setupPerformanceMonitoring() {
        if (import.meta.env.DEV && 'performance' in window) {
            // Monitor page load time
            window.addEventListener('load', () => {
                const navigation = performance.getEntriesByType('navigation')[0];
                if (navigation) {
                    const loadTime = navigation.loadEventEnd - navigation.loadEventStart;
                    console.log(`🚀 Page load time: ${loadTime.toFixed(2)}ms`);
                    
                    // Monitor Core Web Vitals
                    this.measureCoreWebVitals();
                }
            });

            // Monitor memory usage periodically
            setInterval(() => {
                if ('memory' in performance) {
                    const memory = performance.memory;
                    const memoryUsage = {
                        used: Math.round(memory.usedJSHeapSize / 1048576),
                        total: Math.round(memory.totalJSHeapSize / 1048576),
                        limit: Math.round(memory.jsHeapSizeLimit / 1048576)
                    };
                    
                    if (memoryUsage.used > 50) { // MB threshold
                        console.warn('⚠️  High memory usage detected:', memoryUsage);
                    }
                }
            }, 60000); // Check every minute
        }
    }

    static measureCoreWebVitals() {
        // Measure First Contentful Paint (FCP)
        new PerformanceObserver((list) => {
            list.getEntries().forEach((entry) => {
                if (entry.name === 'first-contentful-paint') {
                    console.log(`🎨 First Contentful Paint: ${entry.startTime.toFixed(2)}ms`);
                }
            });
        }).observe({ entryTypes: ['paint'] });

        // Measure Largest Contentful Paint (LCP)
        new PerformanceObserver((list) => {
            const entries = list.getEntries();
            const lastEntry = entries[entries.length - 1];
            console.log(`📏 Largest Contentful Paint: ${lastEntry.startTime.toFixed(2)}ms`);
        }).observe({ entryTypes: ['largest-contentful-paint'] });
    }

    static setupErrorHandling() {
        // Enhanced global error handling
        window.addEventListener('error', (event) => {
            const error = {
                message: event.message,
                filename: event.filename,
                line: event.lineno,
                column: event.colno,
                stack: event.error?.stack,
                timestamp: Date.now(),
                userAgent: navigator.userAgent,
                url: window.location.href
            };

            console.error('❌ Global Error:', error);

            // Report to error tracking service if configured
            if (typeof window.reportError === 'function') {
                window.reportError(error);
            }

            // Show user-friendly notification for critical errors
            if (error.message?.includes('ChunkLoadError') || error.message?.includes('Loading chunk')) {
                NotificationManager.showToast(
                    'Uygulama güncellemesi algılandı. Sayfa yenileniyor...',
                    'info'
                );
                setTimeout(() => window.location.reload(), 2000);
            }
        });

        // Enhanced promise rejection handling
        window.addEventListener('unhandledrejection', (event) => {
            const error = {
                reason: event.reason,
                promise: event.promise,
                timestamp: Date.now(),
                url: window.location.href
            };

            console.error('❌ Unhandled Promise Rejection:', error);

            // Prevent default browser console error
            event.preventDefault();

            // Handle specific promise rejection types
            if (error.reason?.name === 'ChunkLoadError') {
                NotificationManager.showToast(
                    'Uygulama güncellemesi algılandı. Sayfa yenileniyor...',
                    'info'
                );
                setTimeout(() => window.location.reload(), 2000);
            }

            // Report to error tracking service if configured
            if (typeof window.reportError === 'function') {
                window.reportError(error);
            }
        });
    }

    static setupServiceWorker() {
        if ('serviceWorker' in navigator && import.meta.env.PROD) {
            window.addEventListener('load', async () => {
                try {
                    const registration = await navigator.serviceWorker.register('/sw.js');
                    console.log('✅ Service Worker registered:', registration);

                    // Handle service worker updates
                    registration.addEventListener('updatefound', () => {
                        const newWorker = registration.installing;
                        newWorker?.addEventListener('statechange', () => {
                            if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                NotificationManager.showToast(
                                    'Yeni sürüm mevcut. Güncellemek için sayfayı yenileyin.',
                                    'info',
                                    { timer: 0, showConfirmButton: true }
                                );
                            }
                        });
                    });
                } catch (error) {
                    console.warn('⚠️  Service Worker registration failed:', error);
                }
            });
        }
    }
}

// Cleanup on page unload
window.addEventListener('beforeunload', () => {
    ApplicationBootstrapper.cleanup();
});

// Initialize performance management
PerformanceManager.init();

// HMR support for development
if (import.meta.hot) {
    import.meta.hot.accept(['./main.js'], () => {
        console.log('🔥 HMR: Main application reloaded');
        ApplicationBootstrapper.initialize();
    });

    import.meta.hot.accept(['./utils/csrf-manager.js'], () => {
        console.log('🔥 HMR: CSRF Manager reloaded');
        CSRFManager.init();
    });

    import.meta.hot.accept(['./utils/notification-manager.js'], () => {
        console.log('🔥 HMR: Notification Manager reloaded');
        NotificationManager.init();
    });
}

// Export for modern imports and testing
export { ApplicationBootstrapper, BroadcastingManager, PerformanceManager };
export default axios;