/**
 * Icon Service for MonexaFinans - Heroicons Integration
 * Pure SVG icon system with no JavaScript dependencies
 * 
 * @author MonexaFinans Development Team
 * @version 2.0.0 (Heroicons Migration)
 */

class IconService {
    constructor() {
        this.initialized = true; // Always initialized since we use pure SVG
        console.log('MonexaFinans Icon Service: Using Heroicons - No JS initialization needed');
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
     * Common icon presets for fintech UI (Heroicons mapping)
     */
    getCommonIcons() {
        return {
            // Navigation
            home: { name: 'home', size: 'sm', class: 'mr-2' },
            menu: { name: 'bars-3', size: 'sm', class: 'mr-2' },
            close: { name: 'x-mark', size: 'sm', class: 'mr-2' },
            
            // Trading & Finance
            wallet: { name: 'wallet', size: 'sm', class: 'mr-2' },
            creditCard: { name: 'credit-card', size: 'sm', class: 'mr-2' },
            trendingUp: { name: 'arrow-trending-up', size: 'sm', class: 'mr-2' },
            trendingDown: { name: 'arrow-trending-down', size: 'sm', class: 'mr-2' },
            dollarSign: { name: 'currency-dollar', size: 'sm', class: 'mr-2' },
            banknote: { name: 'banknotes', size: 'sm', class: 'mr-2' },
            
            // Actions
            plus: { name: 'plus', size: 'sm', class: 'mr-2' },
            minus: { name: 'minus', size: 'sm', class: 'mr-2' },
            edit: { name: 'pencil', size: 'sm', class: 'mr-2' },
            delete: { name: 'trash', size: 'sm', class: 'mr-2' },
            search: { name: 'magnifying-glass', size: 'sm', class: 'mr-2' },
            
            // Status
            check: { name: 'check', size: 'sm', class: 'mr-2' },
            warning: { name: 'exclamation-triangle', size: 'sm', class: 'mr-2' },
            error: { name: 'x-circle', size: 'sm', class: 'mr-2' },
            info: { name: 'information-circle', size: 'sm', class: 'mr-2' },
            
            // User & Security
            user: { name: 'user', size: 'sm', class: 'mr-2' },
            lock: { name: 'lock-closed', size: 'sm', class: 'mr-2' },
            shield: { name: 'shield-check', size: 'sm', class: 'mr-2' },
            settings: { name: 'cog-6-tooth', size: 'sm', class: 'mr-2' }
        };
    }

    /**
     * Global initialization - No-op since we use Heroicons
     */
    static initGlobally() {
        window.MonexaIcons = new IconService();
        
        // Provide empty refresh function for backward compatibility
        window.refreshIcons = () => {
            console.log('MonexaFinans: Using Heroicons - No icon refresh needed');
        };

        console.log('MonexaFinans Icon Service: Heroicons integration active');
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