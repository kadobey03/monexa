// CSRF Token Management for Vanilla JavaScript
class CSRFManager {
    constructor() {
        this.token = null;
        this.initialized = false;
        this.init();
    }

    // Initialize CSRF token management
    init() {
        if (this.initialized) return;
        
        // Get token from meta tag
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            this.token = metaToken.getAttribute('content');
        }
        
        // Fallback: get from Laravel session cookie or other sources
        if (!this.token) {
            this.token = this.getTokenFromCookie();
        }
        
        this.initialized = true;
        console.log('CSRF Manager initialized');
    }

    // Get CSRF token
    getToken() {
        if (!this.token) {
            this.init();
        }
        return this.token;
    }

    // Update token (useful for SPA or long-running sessions)
    updateToken(newToken) {
        this.token = newToken;
        
        // Update meta tag if exists
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            metaToken.setAttribute('content', newToken);
        }
        
        console.log('CSRF token updated');
    }

    // Get token from cookie (fallback method)
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

    // Create AJAX request with CSRF token
    createAjaxRequest(url, options = {}) {
        const defaults = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.getToken(),
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        };

        // Merge options with defaults
        const config = {
            ...defaults,
            ...options,
            headers: {
                ...defaults.headers,
                ...(options.headers || {})
            }
        };

        return fetch(url, config);
    }

    // Helper method for GET requests
    get(url, options = {}) {
        return this.createAjaxRequest(url, {
            ...options,
            method: 'GET'
        });
    }

    // Helper method for POST requests
    post(url, data = {}, options = {}) {
        return this.createAjaxRequest(url, {
            ...options,
            method: 'POST',
            body: JSON.stringify(data)
        });
    }

    // Helper method for PUT requests
    put(url, data = {}, options = {}) {
        return this.createAjaxRequest(url, {
            ...options,
            method: 'PUT',
            body: JSON.stringify(data)
        });
    }

    // Helper method for DELETE requests
    delete(url, options = {}) {
        return this.createAjaxRequest(url, {
            ...options,
            method: 'DELETE'
        });
    }

    // Helper method for form submissions
    submitForm(form, options = {}) {
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

        // Remove Content-Type to let browser set it with boundary for FormData
        if (config.body instanceof FormData) {
            delete config.headers['Content-Type'];
        }

        return fetch(form.action, config);
    }

    // Setup global AJAX defaults (for jQuery compatibility if needed)
    setupGlobalDefaults() {
        // Setup for jQuery if available
        if (typeof $ !== 'undefined' && $.ajaxSetup) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': this.getToken()
                }
            });
        }

        // Setup for Axios if available
        if (typeof axios !== 'undefined') {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = this.getToken();
        }
    }

    // Auto-refresh token periodically (for long-running applications)
    startTokenRefresh(intervalMinutes = 30) {
        setInterval(() => {
            this.refreshToken();
        }, intervalMinutes * 60 * 1000);
    }

    // Refresh CSRF token from server
    async refreshToken() {
        try {
            const response = await fetch('/csrf-token', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                if (data.token) {
                    this.updateToken(data.token);
                }
            }
        } catch (error) {
            console.warn('Failed to refresh CSRF token:', error);
        }
    }
}

// Create global instance
window.CSRFManager = new CSRFManager();

// Convenience global functions
window.getCSRFToken = () => window.CSRFManager.getToken();
window.ajaxGet = (url, options) => window.CSRFManager.get(url, options);
window.ajaxPost = (url, data, options) => window.CSRFManager.post(url, data, options);
window.ajaxPut = (url, data, options) => window.CSRFManager.put(url, data, options);
window.ajaxDelete = (url, options) => window.CSRFManager.delete(url, options);
window.submitFormAjax = (form, options) => window.CSRFManager.submitForm(form, options);

// Auto-setup on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    window.CSRFManager.setupGlobalDefaults();
    
    // Auto-add CSRF tokens to all forms that don't have them
    const forms = document.querySelectorAll('form:not([data-csrf-skip])');
    forms.forEach(form => {
        const tokenInput = form.querySelector('input[name="_token"]');
        if (!tokenInput && form.method.toLowerCase() !== 'get') {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = window.CSRFManager.getToken();
            form.appendChild(csrfInput);
        }
    });
    
    console.log('CSRF protection applied to all forms');
});

export default CSRFManager;