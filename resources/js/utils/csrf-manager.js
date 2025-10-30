/**
 * CSRF Manager - Modernized Version
 * Vite standardına uygun ES6+ modül olarak yazılmış
 */

class ModernCSRFManager {
    constructor() {
        this.token = null;
        this.initialized = false;
        this.refreshInterval = null;
    }

    /**
     * Initialize CSRF token management
     */
    init() {
        if (this.initialized) return;
        
        // Get token from meta tag
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            this.token = metaToken.getAttribute('content');
        }
        
        // Fallback: get from Laravel session cookie
        if (!this.token) {
            this.token = this.getTokenFromCookie();
        }
        
        if (!this.token) {
            console.warn('CSRF token not found. Some requests may fail.');
            return false;
        }
        
        this.initialized = true;
        this.setupGlobalDefaults();
        this.startTokenRefresh();
        
        console.log('✅ CSRF Manager initialized');
        return true;
    }

    /**
     * Get current CSRF token
     */
    getToken() {
        if (!this.initialized) {
            this.init();
        }
        return this.token;
    }

    /**
     * Update CSRF token
     */
    updateToken(newToken) {
        this.token = newToken;
        
        // Update meta tag
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            metaToken.setAttribute('content', newToken);
        }
        
        // Update axios defaults if available
        if (window.axios) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = newToken;
        }
        
        console.log('🔄 CSRF token updated');
    }

    /**
     * Get token from cookie (fallback)
     */
    getTokenFromCookie() {
        const name = 'XSRF-TOKEN=';
        const decodedCookie = decodeURIComponent(document.cookie);
        const ca = decodedCookie.split(';');
        
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }
        return null;
    }

    /**
     * Create fetch request with CSRF token
     */
    async fetch(url, options = {}) {
        const defaults = {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.getToken(),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        };

        const config = {
            ...defaults,
            ...options,
            headers: {
                ...defaults.headers,
                ...(options.headers || {})
            }
        };

        try {
            const response = await fetch(url, config);
            
            // Handle CSRF token mismatch
            if (response.status === 419) {
                await this.refreshToken();
                // Retry with new token
                config.headers['X-CSRF-TOKEN'] = this.getToken();
                return fetch(url, config);
            }
            
            return response;
        } catch (error) {
            console.error('Fetch request failed:', error);
            throw error;
        }
    }

    /**
     * Helper methods for different HTTP verbs
     */
    async get(url, options = {}) {
        return this.fetch(url, { ...options, method: 'GET' });
    }

    async post(url, data = {}, options = {}) {
        return this.fetch(url, {
            ...options,
            method: 'POST',
            body: JSON.stringify(data)
        });
    }

    async put(url, data = {}, options = {}) {
        return this.fetch(url, {
            ...options,
            method: 'PUT',
            body: JSON.stringify(data)
        });
    }

    async delete(url, options = {}) {
        return this.fetch(url, { ...options, method: 'DELETE' });
    }

    /**
     * Submit form with CSRF protection
     */
    async submitForm(form, options = {}) {
        if (!(form instanceof HTMLFormElement)) {
            throw new Error('First argument must be a form element');
        }

        const formData = new FormData(form);
        
        // Add CSRF token if not present
        if (!formData.has('_token')) {
            formData.append('_token', this.getToken());
        }

        const config = {
            method: form.method || 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': this.getToken(),
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin',
            ...options
        };

        return fetch(form.action, config);
    }

    /**
     * Setup global defaults for axios and jQuery
     */
    setupGlobalDefaults() {
        // Setup for axios if available
        if (window.axios) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = this.getToken();
            window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            
            // Add response interceptor to handle token refresh
            window.axios.interceptors.response.use(
                response => response,
                async error => {
                    if (error.response?.status === 419) {
                        await this.refreshToken();
                        // Update the failed request with new token
                        error.config.headers['X-CSRF-TOKEN'] = this.getToken();
                        return window.axios.request(error.config);
                    }
                    return Promise.reject(error);
                }
            );
        }

        // Setup for jQuery if available
        if (window.$ && window.$.ajaxSetup) {
            window.$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': this.getToken(),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        }
    }

    /**
     * Auto-refresh token periodically
     */
    startTokenRefresh(intervalMinutes = 30) {
        if (this.refreshInterval) {
            clearInterval(this.refreshInterval);
        }
        
        this.refreshInterval = setInterval(() => {
            this.refreshToken().catch(error => {
                console.warn('Token refresh failed:', error);
            });
        }, intervalMinutes * 60 * 1000);
    }

    /**
     * Refresh CSRF token from server
     */
    async refreshToken() {
        try {
            const response = await fetch('/csrf-token', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                if (data.token) {
                    this.updateToken(data.token);
                    return data.token;
                }
            }
            
            throw new Error('Token refresh failed');
        } catch (error) {
            console.error('Failed to refresh CSRF token:', error);
            throw error;
        }
    }

    /**
     * Auto-add CSRF tokens to forms
     */
    autoProtectForms() {
        const forms = document.querySelectorAll('form:not([data-csrf-skip])');
        
        forms.forEach(form => {
            const tokenInput = form.querySelector('input[name="_token"]');
            if (!tokenInput && form.method.toLowerCase() !== 'get') {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = this.getToken();
                form.appendChild(csrfInput);
            }
        });
    }

    /**
     * Cleanup resources
     */
    cleanup() {
        if (this.refreshInterval) {
            clearInterval(this.refreshInterval);
            this.refreshInterval = null;
        }
        
        this.initialized = false;
        console.log('🧹 CSRF Manager cleaned up');
    }
}

// Create singleton instance
const CSRFManager = new ModernCSRFManager();

// Auto-initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        CSRFManager.init();
        CSRFManager.autoProtectForms();
    });
} else {
    CSRFManager.init();
    CSRFManager.autoProtectForms();
}

// Global convenience functions
window.getCSRFToken = () => CSRFManager.getToken();
window.csrfFetch = (url, options) => CSRFManager.fetch(url, options);
window.csrfPost = (url, data, options) => CSRFManager.post(url, data, options);
window.csrfPut = (url, data, options) => CSRFManager.put(url, data, options);
window.csrfDelete = (url, options) => CSRFManager.delete(url, options);

export { CSRFManager };
export default CSRFManager;