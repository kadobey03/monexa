/**
 * Global JavaScript Error Boundary for MonexaFinans
 * Handles client-side errors and provides recovery mechanisms
 */

class GlobalErrorBoundary {
    constructor(options = {}) {
        this.options = {
            maxRetries: 3,
            retryDelay: 1000,
            logToServer: true,
            showNotifications: true,
            ...options
        };
        
        this.retryAttempts = new Map();
        this.setupGlobalHandlers();
    }

    setupGlobalHandlers() {
        // Global error handler
        window.addEventListener('error', (event) => {
            this.handleError({
                type: 'javascript',
                message: event.error?.message || event.message,
                filename: event.filename,
                lineno: event.lineno,
                colno: event.colno,
                stack: event.error?.stack,
                timestamp: new Date().toISOString()
            });
        });

        // Unhandled promise rejections
        window.addEventListener('unhandledrejection', (event) => {
            this.handleError({
                type: 'unhandled_rejection',
                message: event.reason?.message || 'Unhandled promise rejection',
                stack: event.reason?.stack,
                timestamp: new Date().toISOString()
            });
        });

        // Network errors
        this.setupNetworkErrorHandling();
    }

    setupNetworkErrorHandling() {
        const originalFetch = window.fetch;
        window.fetch = async (...args) => {
            try {
                const response = await originalFetch(...args);
                
                if (!response.ok) {
                    this.handleError({
                        type: 'network',
                        message: `HTTP ${response.status}: ${response.statusText}`,
                        url: args[0],
                        status: response.status,
                        timestamp: new Date().toISOString()
                    });
                }
                
                return response;
            } catch (error) {
                this.handleError({
                    type: 'network',
                    message: error.message,
                    url: args[0],
                    stack: error.stack,
                    timestamp: new Date().toISOString()
                });
                throw error;
            }
        };
    }

    handleError(errorData) {
        const errorId = this.generateErrorId();
        const enrichedError = {
            ...errorData,
            id: errorId,
            userAgent: navigator.userAgent,
            url: window.location.href,
            referrer: document.referrer,
            sessionId: this.getSessionId(),
            userId: this.getCurrentUserId()
        };

        // Log to server
        if (this.options.logToServer) {
            this.logToServer(enrichedError);
        }

        // Store for recovery
        this.retryAttempts.set(errorId, {
            error: enrichedError,
            attempts: 0,
            timestamp: Date.now()
        });

        // Show user notification
        if (this.options.showNotifications) {
            this.showNotification(enrichedError);
        }

        // Trigger custom event for other components
        window.dispatchEvent(new CustomEvent('globalError', {
            detail: enrichedError
        }));
    }

    retry(errorId) {
        const retryData = this.retryAttempts.get(errorId);
        
        if (!retryData || retryData.attempts >= this.options.maxRetries) {
            return false;
        }

        retryData.attempts++;
        
        // Exponential backoff
        const delay = this.options.retryDelay * Math.pow(2, retryData.attempts - 1);
        
        setTimeout(() => {
            window.dispatchEvent(new CustomEvent('globalRetry', {
                detail: {
                    errorId,
                    attempts: retryData.attempts,
                    error: retryData.error
                }
            }));
        }, delay);

        return true;
    }

    getErrorType(error) {
        if (error.type === 'network') {
            return 'network';
        }
        
        if (error.message?.toLowerCase().includes('financial')) {
            return 'financial';
        }
        
        if (error.message?.toLowerCase().includes('auth') || error.status === 401) {
            return 'authentication';
        }
        
        if (error.status === 422) {
            return 'validation';
        }
        
        if (error.status >= 500) {
            return 'server';
        }
        
        return 'general';
    }

    getErrorSuggestions(error) {
        const type = this.getErrorType(error);
        const locale = this.getCurrentLocale();
        
        const suggestions = {
            network: {
                tr: [
                    'İnternet bağlantınızı kontrol edin',
                    'Sayfayı yenilemeyi deneyin',
                    'VPN bağlantınızı kontrol edin'
                ],
                en: [
                    'Check your internet connection',
                    'Try refreshing the page',
                    'Check your VPN connection'
                ]
            },
            financial: {
                tr: [
                    'Bakiyenizi kontrol edin',
                    'Farklı bir ödeme yöntemi deneyin',
                    'Müşteri desteği ile iletişime geçin'
                ],
                en: [
                    'Check your balance',
                    'Try a different payment method',
                    'Contact customer support'
                ]
            },
            authentication: {
                tr: [
                    'Tekrar giriş yapmayı deneyin',
                    'Parolanızı sıfırlayın',
                    'Tarayıcı çerezlerini temizleyin'
                ],
                en: [
                    'Try logging in again',
                    'Reset your password',
                    'Clear browser cookies'
                ]
            },
            validation: {
                tr: [
                    'Form bilgilerinizi kontrol edin',
                    'Gerekli alanları doldurun',
                    'Format kontrolü yapın'
                ],
                en: [
                    'Check your form information',
                    'Fill in required fields',
                    'Verify format'
                ]
            },
            server: {
                tr: [
                    'Birkaç dakika bekleyin',
                    'Sayfayı yenileyin',
                    'Teknik destek ile iletişime geçin'
                ],
                en: [
                    'Wait a few minutes',
                    'Refresh the page',
                    'Contact technical support'
                ]
            },
            general: {
                tr: [
                    'Sayfayı yenileyin',
                    'Tarayıcıyı yeniden başlatın',
                    'Destek ekibi ile iletişime geçin'
                ],
                en: [
                    'Refresh the page',
                    'Restart your browser',
                    'Contact support team'
                ]
            }
        };

        return suggestions[type]?.[locale] || suggestions.general[locale];
    }

    async logToServer(error) {
        try {
            await fetch('/api/errors', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: JSON.stringify(error)
            });
        } catch (e) {
            console.error('Failed to log error to server:', e);
        }
    }

    showNotification(error) {
        const type = this.getErrorType(error);
        const suggestions = this.getErrorSuggestions(error);
        
        // Integration with your notification system
        const notification = {
            type: 'error',
            title: 'Bir Hata Oluştu',
            message: error.message,
            suggestions: suggestions,
            errorId: error.id,
            canRetry: this.retryAttempts.get(error.id)?.attempts < this.options.maxRetries
        };

        // Dispatch event for notification component
        window.dispatchEvent(new CustomEvent('showErrorNotification', {
            detail: notification
        }));
    }

    generateErrorId() {
        return 'err_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }

    getCurrentLocale() {
        return document.documentElement.lang || 'tr';
    }

    getSessionId() {
        return window.sessionStorage.getItem('sessionId') || 
               (() => {
                   const id = 'session_' + Date.now();
                   window.sessionStorage.setItem('sessionId', id);
                   return id;
               })();
    }

    getCurrentUserId() {
        // This would integrate with your authentication system
        return window.userId || null;
    }
}

// Network error retry utility
class NetworkRetryHandler {
    constructor(maxRetries = 3, baseDelay = 1000) {
        this.maxRetries = maxRetries;
        this.baseDelay = baseDelay;
    }

    async fetchWithRetry(url, options = {}, retryCount = 0) {
        try {
            const response = await fetch(url, options);
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            return response;
        } catch (error) {
            if (retryCount >= this.maxRetries) {
                throw error;
            }
            
            const delay = this.baseDelay * Math.pow(2, retryCount);
            await new Promise(resolve => setTimeout(resolve, delay));
            
            return this.fetchWithRetry(url, options, retryCount + 1);
        }
    }
}

// Initialize global error boundary
const globalErrorBoundary = new GlobalErrorBoundary();
const networkRetryHandler = new NetworkRetryHandler();

// Export for use in modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { GlobalErrorBoundary, NetworkRetryHandler };
} else {
    window.GlobalErrorBoundary = GlobalErrorBoundary;
    window.NetworkRetryHandler = NetworkRetryHandler;
}