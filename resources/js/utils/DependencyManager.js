/**
 * Dependency Manager - CDN to NPM Package Migration Helper
 * Handles dynamic imports and bundle optimization for better performance
 */

export class DependencyManager {
    constructor() {
        this.loadedDependencies = new Map();
        this.loadingPromises = new Map();
        this.fallbacks = new Map();
        
        this.initializeFallbacks();
    }

    /**
     * Initialize CDN fallbacks for critical dependencies
     * @private
     */
    initializeFallbacks() {
        this.fallbacks.set('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11');
        this.fallbacks.set('chart.js', 'https://cdn.jsdelivr.net/npm/chart.js');
        this.fallbacks.set('qrcode', 'https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js');
        this.fallbacks.set('vue', 'https://unpkg.com/vue@3/dist/vue.global.js');
        this.fallbacks.set('pinia', 'https://unpkg.com/pinia@2/dist/pinia.iife.js');
        this.fallbacks.set('axios', 'https://unpkg.com/axios/dist/axios.min.js');
    }

    /**
     * Load SweetAlert2 with NPM package priority
     * @returns {Promise<Object>} SweetAlert2 instance
     */
    async loadSweetAlert2() {
        const key = 'sweetalert2';
        
        if (this.loadedDependencies.has(key)) {
            return this.loadedDependencies.get(key);
        }

        if (this.loadingPromises.has(key)) {
            return this.loadingPromises.get(key);
        }

        const loadingPromise = this._loadWithFallback(key, async () => {
            const { default: Swal } = await import('sweetalert2');
            return Swal;
        });

        this.loadingPromises.set(key, loadingPromise);

        try {
            const swal = await loadingPromise;
            this.loadedDependencies.set(key, swal);
            
            // Make globally available for backward compatibility
            if (!window.Swal) {
                window.Swal = swal;
            }
            
            return swal;
        } catch (error) {
            this.loadingPromises.delete(key);
            throw error;
        } finally {
            this.loadingPromises.delete(key);
        }
    }


    /**
     * Load Chart.js with NPM package priority
     * @returns {Promise<Object>} Chart.js instance
     */
    async loadChartJS() {
        const key = 'chart.js';
        
        if (this.loadedDependencies.has(key)) {
            return this.loadedDependencies.get(key);
        }

        if (this.loadingPromises.has(key)) {
            return this.loadingPromises.get(key);
        }

        const loadingPromise = this._loadWithFallback(key, async () => {
            const {
                Chart,
                CategoryScale,
                LinearScale,
                PointElement,
                LineElement,
                BarElement,
                Title,
                Tooltip,
                Legend,
                ArcElement
            } = await import('chart.js/auto');
            
            // Register necessary components
            Chart.register(
                CategoryScale,
                LinearScale,
                PointElement,
                LineElement,
                BarElement,
                Title,
                Tooltip,
                Legend,
                ArcElement
            );
            
            return Chart;
        });

        this.loadingPromises.set(key, loadingPromise);

        try {
            const Chart = await loadingPromise;
            this.loadedDependencies.set(key, Chart);
            
            // Make globally available for backward compatibility
            if (!window.Chart) {
                window.Chart = Chart;
            }
            
            return Chart;
        } catch (error) {
            this.loadingPromises.delete(key);
            throw error;
        } finally {
            this.loadingPromises.delete(key);
        }
    }

    /**
     * Load QRCode with NPM package priority
     * @returns {Promise<Object>} QRCode instance
     */
    async loadQRCode() {
        const key = 'qrcode';
        
        if (this.loadedDependencies.has(key)) {
            return this.loadedDependencies.get(key);
        }

        if (this.loadingPromises.has(key)) {
            return this.loadingPromises.get(key);
        }

        const loadingPromise = this._loadWithFallback(key, async () => {
            const QRCode = await import('qrcode');
            return QRCode;
        });

        this.loadingPromises.set(key, loadingPromise);

        try {
            const QRCode = await loadingPromise;
            this.loadedDependencies.set(key, QRCode);
            
            // Make globally available for backward compatibility
            if (!window.QRCode) {
                window.QRCode = QRCode;
            }
            
            return QRCode;
        } catch (error) {
            this.loadingPromises.delete(key);
            throw error;
        } finally {
            this.loadingPromises.delete(key);
        }
    }

    /**
     * Load dependency with CDN fallback
     * @private
     */
    async _loadWithFallback(key, npmLoader) {
        try {
            console.log(`📦 Loading ${key} from NPM package...`);
            return await npmLoader();
        } catch (error) {
            console.warn(`⚠️ NPM package failed for ${key}, falling back to CDN:`, error);
            return await this._loadFromCDN(key);
        }
    }

    /**
     * Load dependency from CDN as fallback
     * @private
     */
    async _loadFromCDN(key) {
        const cdnUrl = this.fallbacks.get(key);
        
        if (!cdnUrl) {
            throw new Error(`No fallback CDN available for ${key}`);
        }

        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = cdnUrl;
            script.onload = () => {
                console.log(`✅ ${key} loaded from CDN fallback`);
                
                // Return the appropriate global variable
                switch (key) {
                    case 'sweetalert2':
                        resolve(window.Swal);
                        break;
                    case 'chart.js':
                        resolve(window.Chart);
                        break;
                    case 'qrcode':
                        resolve(window.QRCode);
                        break;
                    case 'vue':
                        resolve(window.Vue);
                        break;
                    case 'pinia':
                        resolve(window.Pinia);
                        break;
                    case 'axios':
                        resolve(window.axios);
                        break;
                    default:
                        resolve(window[key]);
                }
            };
            script.onerror = () => {
                reject(new Error(`Failed to load ${key} from CDN: ${cdnUrl}`));
            };
            document.head.appendChild(script);
        });
    }

    /**
     * Preload commonly used dependencies
     * @param {Array<string>} dependencies - Array of dependency names
     */
    async preloadDependencies(dependencies = []) {
        const preloadTasks = dependencies.map(dep => {
            switch (dep) {
                case 'sweetalert2':
                    return this.loadSweetAlert2().catch(() => {});
                case 'chart.js':
                    return this.loadChartJS().catch(() => {});
                case 'qrcode':
                    return this.loadQRCode().catch(() => {});
                default:
                    return Promise.resolve();
            }
        });

        await Promise.allSettled(preloadTasks);
    }

    /**
     * Get loaded dependency
     * @param {string} key - Dependency key
     * @returns {Object|null}
     */
    getDependency(key) {
        return this.loadedDependencies.get(key) || null;
    }

    /**
     * Check if dependency is loaded
     * @param {string} key - Dependency key
     * @returns {boolean}
     */
    isDependencyLoaded(key) {
        return this.loadedDependencies.has(key);
    }

    /**
     * Clear all loaded dependencies
     */
    reset() {
        this.loadedDependencies.clear();
        this.loadingPromises.clear();
    }

    /**
     * Get loading performance metrics
     * @returns {Object}
     */
    getMetrics() {
        return {
            loadedCount: this.loadedDependencies.size,
            loadedDependencies: Array.from(this.loadedDependencies.keys()),
            availableFallbacks: Array.from(this.fallbacks.keys()),
        };
    }
}

// Create global instance
export const dependencyManager = new DependencyManager();

// Helper functions for common dependencies
export const loadSwal = () => dependencyManager.loadSweetAlert2();
export const loadChart = () => dependencyManager.loadChartJS();
export const loadQR = () => dependencyManager.loadQRCode();

export default DependencyManager;