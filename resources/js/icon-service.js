/**
 * Unified Icon Service for MonexaFinans
 * Centralized icon management with performance optimization
 * 
 * @author MonexaFinans Development Team
 * @version 1.0.0
 */

class IconService {
    constructor() {
        this.initialized = false;
        this.iconCache = new Map();
        this.initPromise = null;
    }

    /**
     * Initialize Lucide icons with fallback
     */
    async initialize() {
        if (this.initPromise) {
            return this.initPromise;
        }

        this.initPromise = new Promise((resolve, reject) => {
            try {
                // Check if Lucide is already loaded
                if (typeof lucide !== 'undefined' && lucide.createIcons) {
                    this.performInit();
                    resolve();
                    return;
                }

                // Load Lucide from local source (fallback to CDN)
                this.loadLucide().then(() => {
                    this.performInit();
                    resolve();
                }).catch((error) => {
                    console.warn('Failed to load Lucide icons:', error);
                    // Continue without icons if loading fails
                    resolve();
                });

            } catch (error) {
                console.warn('Icon initialization failed:', error);
                resolve(); // Continue without icons
            }
        });

        return this.initPromise;
    }

    /**
     * Load Lucide icon library
     */
    loadLucide() {
        return new Promise((resolve, reject) => {
            // Try local source first
            const script = document.createElement('script');
            script.src = '/vendor/lucide/lucide.js';
            script.onload = () => resolve();
            script.onerror = () => {
                // Fallback to CDN
                const cdnScript = document.createElement('script');
                cdnScript.src = 'https://unpkg.com/lucide@latest/dist/umd/lucide.js';
                cdnScript.onload = () => resolve();
                cdnScript.onerror = () => reject(new Error('Failed to load Lucide from all sources'));
                document.head.appendChild(cdnScript);
            };
            document.head.appendChild(script);
        });
    }

    /**
     * Perform actual icon initialization
     */
    performInit() {
        try {
            if (typeof lucide !== 'undefined' && lucide.createIcons) {
                // Initialize with optimized settings
                lucide.createIcons({
                    nameAttr: 'data-lucide',
                    attrs: {
                        width: null,
                        height: null,
                        strokeWidth: null,
                        color: null
                    }
                });
                this.initialized = true;
                console.log('MonexaFinans Icon Service: Initialized successfully');
            }
        } catch (error) {
            console.warn('Icon initialization error:', error);
        }
    }

    /**
     * Refresh icons in container (for dynamic content)
     */
    refresh(container = document) {
        if (this.initialized && typeof lucide !== 'undefined') {
            try {
                lucide.createIcons({
                    nameAttr: 'data-lucide',
                    attrs: {}
                });
            } catch (error) {
                console.warn('Icon refresh failed:', error);
            }
        }
    }

    /**
     * Get icon HTML for server-side rendering
     */
    getIconHTML(name, options = {}) {
        const defaultOptions = {
            class: 'w-4 h-4',
            'aria-hidden': 'true'
        };

        const mergedOptions = { ...defaultOptions, ...options };
        const classString = mergedOptions.class;
        delete mergedOptions.class;

        const attrsString = Object.entries(mergedOptions)
            .map(([key, value]) => `${key}="${value}"`)
            .join(' ');

        return `<i data-lucide="${name}" class="${classString}" ${attrsString}></i>`;
    }

    /**
     * Standard icon sizes for consistent UI
     */
    getSizeClass(size) {
        const sizeMap = {
            'xs': 'w-3 h-3',
            'sm': 'w-4 h-4', 
            'md': 'w-5 h-5',
            'lg': 'w-6 h-6',
            'xl': 'w-8 h-8',
            '2xl': 'w-10 h-10'
        };
        return sizeMap[size] || sizeMap['sm'];
    }

    /**
     * Common icon presets for fintech UI
     */
    getCommonIcons() {
        return {
            // Navigation
            home: { name: 'home', size: 'sm', class: 'mr-2' },
            menu: { name: 'menu', size: 'sm', class: 'mr-2' },
            close: { name: 'x', size: 'sm', class: 'mr-2' },
            
            // Trading & Finance
            wallet: { name: 'wallet', size: 'sm', class: 'mr-2' },
            creditCard: { name: 'credit-card', size: 'sm', class: 'mr-2' },
            trendingUp: { name: 'trending-up', size: 'sm', class: 'mr-2' },
            trendingDown: { name: 'trending-down', size: 'sm', class: 'mr-2' },
            dollarSign: { name: 'dollar-sign', size: 'sm', class: 'mr-2' },
            banknote: { name: 'banknote', size: 'sm', class: 'mr-2' },
            
            // Actions
            plus: { name: 'plus', size: 'sm', class: 'mr-2' },
            minus: { name: 'minus', size: 'sm', class: 'mr-2' },
            edit: { name: 'edit', size: 'sm', class: 'mr-2' },
            delete: { name: 'trash-2', size: 'sm', class: 'mr-2' },
            search: { name: 'search', size: 'sm', class: 'mr-2' },
            
            // Status
            check: { name: 'check', size: 'sm', class: 'mr-2' },
            warning: { name: 'alert-triangle', size: 'sm', class: 'mr-2' },
            error: { name: 'x-circle', size: 'sm', class: 'mr-2' },
            info: { name: 'info', size: 'sm', class: 'mr-2' },
            
            // User & Security
            user: { name: 'user', size: 'sm', class: 'mr-2' },
            lock: { name: 'lock', size: 'sm', class: 'mr-2' },
            shield: { name: 'shield', size: 'sm', class: 'mr-2' },
            settings: { name: 'settings', size: 'sm', class: 'mr-2' }
        };
    }

    /**
     * Create icon element with common patterns
     */
    createIcon(iconName, options = {}) {
        const iconMap = this.getCommonIcons();
        const iconConfig = iconMap[iconName] || { name: iconName, size: 'sm', class: 'mr-2' };
        
        const sizeClass = this.getSizeClass(options.size || iconConfig.size);
        const customClass = options.class || iconConfig.class || '';
        
        return this.getIconHTML(iconConfig.name, {
            class: `${sizeClass} ${customClass}`.trim(),
            ...options
        });
    }

    /**
     * Global initialization on window load
     */
    static initGlobally() {
        window.MonexaIcons = new IconService();
        
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                window.MonexaIcons.initialize();
            });
        } else {
            window.MonexaIcons.initialize();
        }

        // Provide global refresh function
        window.refreshIcons = () => {
            if (window.MonexaIcons) {
                window.MonexaIcons.refresh();
            }
        };

        console.log('MonexaFinans Icon Service: Global initialization complete');
    }
}

// Auto-initialize if script is loaded directly
if (typeof window !== 'undefined') {
    IconService.initGlobally();
}

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = IconService;
}