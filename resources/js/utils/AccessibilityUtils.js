/**
 * Accessibility Utilities - Odak Yönetimi ve Klavye Navigasyonu
 * 
 * Kapsamlı klavye navigasyon desteği
 * Odak yönetimi ve focus trap implementasyonu
 * WCAG 2.1 AA uyumlu interaksiyon patterns
 */

class AccessibilityUtils {
    constructor() {
        this.focusHistory = [];
        this.currentFocusTrap = null;
        this.keyboardShortcuts = new Map();
        this.skipLinks = [];
        this.focusableSelectors = [
            'a[href]',
            'button:not([disabled])',
            'input:not([disabled])',
            'select:not([disabled])',
            'textarea:not([disabled])',
            '[tabindex]:not([tabindex="-1"])',
            '[contenteditable="true"]'
        ].join(', ');
        
        this.init();
    }

    /**
     * Accessibility utils'leri başlat
     */
    init() {
        this.setupKeyboardNavigation();
        this.setupFocusManagement();
        this.setupSkipLinks();
        this.setupFocusTrap();
        this.bindEvents();
        
        console.log('Accessibility Utils initialized');
    }

    /**
     * Klavye navigasyonunu kur
     */
    setupKeyboardNavigation() {
        document.addEventListener('keydown', (event) => {
            this.handleKeyboardNavigation(event);
        });
    }

    /**
     * Temel klavye navigasyon event handler'ı
     */
    handleKeyboardNavigation(event) {
        const { key, ctrlKey, altKey, shiftKey } = event;
        const target = event.target;
        
        // Escape tuşu - genel işlemler
        if (key === 'Escape') {
            this.handleEscapeKey(event);
        }
        
        // Enter/Space - etkileşimli elementler
        if (key === 'Enter' || key === ' ') {
            this.handleActivationKey(event, target);
        }
        
        // Tab navigation
        if (key === 'Tab') {
            this.handleTabNavigation(event);
        }
        
        // Arrow keys - dropdown ve listeler
        if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'].includes(key)) {
            this.handleArrowNavigation(event, target);
        }
        
        // Home/End keys
        if (key === 'Home' || key === 'End') {
            this.handleHomeEndNavigation(event, target);
        }
        
        // Alt + kombinasyonlar - kısayollar
        if (altKey && !ctrlKey) {
            this.handleAltShortcuts(event);
        }
        
        // Ctrl + kombinasyonlar - sistem kısayolları
        if (ctrlKey && !altKey) {
            this.handleCtrlShortcuts(event);
        }
    }

    /**
     * Escape tuşu işlemleri
     */
    handleEscapeKey(event) {
        // Açık modal'ları kapat
        const openModal = document.querySelector('.modal[aria-modal="true"]');
        if (openModal) {
            this.closeModal(openModal);
            event.preventDefault();
            return;
        }
        
        // Açık dropdown'ları kapat
        const openDropdown = document.querySelector('[aria-expanded="true"]');
        if (openDropdown) {
            this.closeDropdown(openDropdown);
            event.preventDefault();
            return;
        }
        
        // Focus trap'ten çık
        if (this.currentFocusTrap) {
            this.exitFocusTrap();
            event.preventDefault();
            return;
        }
        
        // Açık context menu'leri kapat
        const openMenu = document.querySelector('[role="menu"][aria-hidden="false"]');
        if (openMenu) {
            this.closeMenu(openMenu);
            event.preventDefault();
            return;
        }
    }

    /**
     * Enter/Space tuşu aktivasyonları
     */
    handleActivationKey(event, target) {
        // Button elementi ise
        if (target.tagName === 'BUTTON' || target.getAttribute('role') === 'button') {
            target.click();
            event.preventDefault();
            return;
        }
        
        // Link ise
        if (target.tagName === 'A' && target.href) {
            window.location.href = target.href;
            event.preventDefault();
            return;
        }
        
        // Custom interactive elements
        if (this.isInteractiveElement(target)) {
            this.activateCustomElement(target);
            event.preventDefault();
        }
    }

    /**
     * Tab navigasyonu
     */
    handleTabNavigation(event) {
        const focusableElements = this.getFocusableElements();
        if (focusableElements.length === 0) return;
        
        const currentIndex = focusableElements.indexOf(document.activeElement);
        
        if (event.shiftKey) {
            // Shift + Tab - geriye doğru
            if (currentIndex <= 0) {
                // İlk elementteyiz, sona git
                const lastElement = focusableElements[focusableElements.length - 1];
                lastElement.focus();
                event.preventDefault();
            }
        } else {
            // Tab - ileriye doğru
            if (currentIndex === focusableElements.length - 1) {
                // Son elementteyiz, ilk elemente git
                const firstElement = focusableElements[0];
                firstElement.focus();
                event.preventDefault();
            }
        }
    }

    /**
     * Ok tuşu navigasyonu
     */
    handleArrowNavigation(event, target) {
        const { key } = event;
        
        // Dropdown navigation
        if (this.isDropdown(target)) {
            this.handleDropdownArrowNavigation(event, target, key);
            return;
        }
        
        // Menu navigation
        if (this.isMenu(target)) {
            this.handleMenuArrowNavigation(event, target, key);
            return;
        }
        
        // List navigation
        if (this.isList(target)) {
            this.handleListArrowNavigation(event, target, key);
            return;
        }
        
        // Grid navigation
        if (this.isGrid(target)) {
            this.handleGridArrowNavigation(event, target, key);
            return;
        }
    }

    /**
     * Dropdown ok tuşu navigasyonu
     */
    handleDropdownArrowNavigation(event, dropdown, key) {
        const options = dropdown.querySelectorAll('[role="option"], .dropdown-item');
        if (options.length === 0) return;
        
        const currentIndex = Array.from(options).indexOf(document.activeElement);
        let nextIndex;
        
        if (key === 'ArrowDown') {
            nextIndex = currentIndex < 0 ? 0 : (currentIndex + 1) % options.length;
        } else if (key === 'ArrowUp') {
            nextIndex = currentIndex <= 0 ? options.length - 1 : currentIndex - 1;
        }
        
        if (nextIndex !== undefined) {
            options[nextIndex].focus();
            event.preventDefault();
        }
    }

    /**
     * Menu ok tuşu navigasyonu
     */
    handleMenuArrowNavigation(event, menu, key) {
        const items = menu.querySelectorAll('[role="menuitem"]');
        if (items.length === 0) return;
        
        const currentIndex = Array.from(items).indexOf(document.activeElement);
        let nextIndex;
        
        if (key === 'ArrowDown') {
            nextIndex = currentIndex < 0 ? 0 : Math.min(currentIndex + 1, items.length - 1);
        } else if (key === 'ArrowUp') {
            nextIndex = currentIndex <= 0 ? 0 : currentIndex - 1;
        } else if (key === 'Home') {
            nextIndex = 0;
        } else if (key === 'End') {
            nextIndex = items.length - 1;
        }
        
        if (nextIndex !== undefined && nextIndex !== currentIndex) {
            items[nextIndex].focus();
            event.preventDefault();
        }
    }

    /**
     * List ok tuşu navigasyonu
     */
    handleListArrowNavigation(event, list, key) {
        const items = list.querySelectorAll('li, [role="listitem"]');
        if (items.length === 0) return;
        
        const currentIndex = Array.from(items).indexOf(document.activeElement.closest('li, [role="listitem"]'));
        let nextIndex;
        
        if (key === 'ArrowDown') {
            nextIndex = currentIndex < 0 ? 0 : Math.min(currentIndex + 1, items.length - 1);
        } else if (key === 'ArrowUp') {
            nextIndex = currentIndex <= 0 ? 0 : currentIndex - 1;
        }
        
        if (nextIndex !== undefined && nextIndex !== currentIndex) {
            items[nextIndex].focus();
            event.preventDefault();
        }
    }

    /**
     * Grid ok tuşu navigasyonu
     */
    handleGridArrowNavigation(event, grid, key) {
        const cells = grid.querySelectorAll('[role="gridcell"], .grid-cell');
        if (cells.length === 0) return;
        
        const currentIndex = Array.from(cells).indexOf(document.activeElement.closest('[role="gridcell"], .grid-cell'));
        const columns = this.getGridColumns(grid);
        
        let nextIndex;
        if (key === 'ArrowRight') {
            nextIndex = currentIndex < 0 ? 0 : Math.min(currentIndex + 1, cells.length - 1);
        } else if (key === 'ArrowLeft') {
            nextIndex = currentIndex <= 0 ? 0 : currentIndex - 1;
        } else if (key === 'ArrowDown') {
            nextIndex = currentIndex < 0 ? 0 : Math.min(currentIndex + columns, cells.length - 1);
        } else if (key === 'ArrowUp') {
            nextIndex = currentIndex <= 0 ? 0 : Math.max(currentIndex - columns, 0);
        }
        
        if (nextIndex !== undefined && nextIndex !== currentIndex) {
            cells[nextIndex].focus();
            event.preventDefault();
        }
    }

    /**
     * Home/End navigasyonu
     */
    handleHomeEndNavigation(event, target) {
        if (key === 'Home') {
            const firstFocusable = this.getFocusableElements()[0];
            if (firstFocusable) {
                firstFocusable.focus();
                event.preventDefault();
            }
        } else if (key === 'End') {
            const focusableElements = this.getFocusableElements();
            const lastFocusable = focusableElements[focusableElements.length - 1];
            if (lastFocusable) {
                lastFocusable.focus();
                event.preventDefault();
            }
        }
    }

    /**
     * Alt tuş kombinasyonları
     */
    handleAltShortcuts(event) {
        const shortcuts = {
            'm': () => this.focusMainContent(),
            'n': () => this.focusNavigation(),
            's': () => this.focusSearch(),
            'h': () => this.showHelp(),
            'k': () => this.showKeyboardShortcuts()
        };
        
        if (shortcuts[event.key]) {
            shortcuts[event.key]();
            event.preventDefault();
        }
    }

    /**
     * Ctrl tuş kombinasyonları
     */
    handleCtrlShortcuts(event) {
        // Ctrl + / - klavye kısayollarını göster
        if (event.key === '/') {
            this.showKeyboardShortcuts();
            event.preventDefault();
            return;
        }
        
        // Ctrl + Enter - form submit (livewire formlarında)
        if (event.key === 'Enter' && event.target.closest('[wire\\:submit]')) {
            const submitButton = event.target.closest('form').querySelector('[type="submit"]');
            if (submitButton) {
                submitButton.click();
            }
            event.preventDefault();
        }
    }

    /**
     * Odak yönetimini kur
     */
    setupFocusManagement() {
        // Focus değişikliklerini dinle
        document.addEventListener('focusin', (event) => {
            this.handleFocusIn(event);
        });
        
        document.addEventListener('focusout', (event) => {
            this.handleFocusOut(event);
        });
    }

    /**
     * Focus in event handler
     */
    handleFocusIn(event) {
        const target = event.target;
        
        // Focus history'ye ekle
        if (!target.matches('.skip-link')) {
            this.addToFocusHistory(target);
        }
        
        // Visual focus indicator göster
        this.showFocusIndicator(target);
        
        // Accessible name'i logla
        const accessibleName = this.getAccessibleName(target);
        if (accessibleName) {
            console.log(`Focused element: ${accessibleName}`);
        }
    }

    /**
     * Focus out event handler
     */
    handleFocusOut(event) {
        const target = event.target;
        
        // Visual focus indicator'ı gizle
        this.hideFocusIndicator(target);
    }

    /**
     * Skip link'leri kur
     */
    setupSkipLinks() {
        // Skip to main content link'i oluştur
        this.createSkipLink('Ana içeriğe git', '#main-content', 'main-content');
        
        // Skip to navigation link'i oluştur
        this.createSkipLink('Navigasyona git', '#navigation', 'navigation');
        
        // Skip to search link'i oluştur
        this.createSkipLink('Aramaya git', '#search-form', 'search');
    }

    /**
     * Skip link oluştur
     */
    createSkipLink(text, href, id) {
        const skipLink = document.createElement('a');
        skipLink.href = href;
        skipLink.textContent = text;
        skipLink.className = 'skip-link sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-blue-600 focus:text-white focus:px-4 focus:py-2 focus:rounded';
        skipLink.id = `skip-${id}`;
        
        skipLink.addEventListener('click', (event) => {
            event.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.focus();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
        
        document.body.insertBefore(skipLink, document.body.firstChild);
        this.skipLinks.push(skipLink);
    }

    /**
     * Focus trap kurulumu
     */
    setupFocusTrap() {
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Tab' && this.currentFocusTrap) {
                this.handleFocusTrap(event);
            }
        });
    }

    /**
     * Focus trap'i başlat
     */
    startFocusTrap(container, options = {}) {
        const defaultOptions = {
            initialFocus: null,
            fallbackFocus: null,
            trapStack: false
        };
        
        const config = { ...defaultOptions, ...options };
        
        const trap = {
            container,
            config,
            previousFocus: document.activeElement,
            focusableElements: [],
            isActive: true
        };
        
        if (config.trapStack && this.currentFocusTrap) {
            // Mevcut trap'i stack'e ekle
            this.focusHistory.push(this.currentFocusTrap);
        }
        
        this.currentFocusTrap = trap;
        
        // Focusable elementleri bul
        trap.focusableElements = this.getFocusableElements(container);
        
        // İlk odaklanacak elementi belirle
        let focusTarget = null;
        if (config.initialFocus) {
            focusTarget = typeof config.initialFocus === 'string' 
                ? container.querySelector(config.initialFocus)
                : config.initialFocus;
        } else if (trap.focusableElements.length > 0) {
            focusTarget = trap.focusableElements[0];
        }
        
        if (focusTarget) {
            focusTarget.focus();
        }
        
        return trap;
    }

    /**
     * Focus trap'ten çık
     */
    exitFocusTrap() {
        if (!this.currentFocusTrap) return;
        
        const trap = this.currentFocusTrap;
        trap.isActive = false;
        
        // Önceki odaklanan elemente dön
        if (trap.previousFocus && trap.previousFocus.focus) {
            trap.previousFocus.focus();
        }
        
        // Stack'ten bir önceki trap'i geri yükle
        if (this.focusHistory.length > 0) {
            this.currentFocusTrap = this.focusHistory.pop();
        } else {
            this.currentFocusTrap = null;
        }
    }

    /**
     * Focus trap navigation
     */
    handleFocusTrap(event) {
        const trap = this.currentFocusTrap;
        if (!trap || !trap.isActive) return;
        
        const focusableElements = this.getFocusableElements(trap.container);
        if (focusableElements.length === 0) return;
        
        const currentIndex = focusableElements.indexOf(document.activeElement);
        
        if (event.shiftKey) {
            // Shift + Tab
            if (currentIndex <= 0) {
                focusableElements[focusableElements.length - 1].focus();
                event.preventDefault();
            }
        } else {
            // Tab
            if (currentIndex === focusableElements.length - 1) {
                focusableElements[0].focus();
                event.preventDefault();
            }
        }
    }

    /**
     * Focusable elementleri al
     */
    getFocusableElements(container = document) {
        const selector = this.focusableSelectors;
        const elements = Array.from(container.querySelectorAll(selector));
        
        // Sadece görünür elementleri filtrele
        return elements.filter(element => {
            return this.isElementVisible(element) && !element.hasAttribute('disabled');
        });
    }

    /**
     * Element görünür mü kontrol et
     */
    isElementVisible(element) {
        const style = window.getComputedStyle(element);
        return style.display !== 'none' && 
               style.visibility !== 'hidden' && 
               style.opacity !== '0' &&
               element.offsetWidth > 0 && 
               element.offsetHeight > 0;
    }

    /**
     * Modal kapatma
     */
    closeModal(modal) {
        // Escape event'i emit et
        modal.dispatchEvent(new CustomEvent('modal-close', { bubbles: true }));
        
        // Focus trap'ten çık
        if (this.currentFocusTrap && this.currentFocusTrap.container === modal) {
            this.exitFocusTrap();
        }
    }

    /**
     * Dropdown kapatma
     */
    closeDropdown(dropdown) {
        dropdown.setAttribute('aria-expanded', 'false');
        
        // Toggle button'ı focusla
        const toggle = document.querySelector(`[aria-controls="${dropdown.id}"]`);
        if (toggle) {
            toggle.focus();
        }
    }

    /**
     * Menu kapatma
     */
    closeMenu(menu) {
        menu.setAttribute('aria-hidden', 'true');
        
        // Menu trigger'ı focusla
        const trigger = document.querySelector(`[aria-haspopup="menu"][aria-controls="${menu.id}"]`);
        if (trigger) {
            trigger.focus();
        }
    }

    /**
     * Ana içeriğe odaklan
     */
    focusMainContent() {
        const mainContent = document.querySelector('main, #main-content, [role="main"]');
        if (mainContent) {
            mainContent.focus();
            mainContent.scrollIntoView({ behavior: 'smooth' });
        }
    }

    /**
     * Navigasyona odaklan
     */
    focusNavigation() {
        const nav = document.querySelector('nav, #navigation, [role="navigation"]');
        const firstLink = nav?.querySelector('a, button');
        if (firstLink) {
            firstLink.focus();
        }
    }

    /**
     * Arama alanına odaklan
     */
    focusSearch() {
        const searchInput = document.querySelector('input[type="search"], #search, [name="search"]');
        if (searchInput) {
            searchInput.focus();
        }
    }

    /**
     * Yardım göster
     */
    showHelp() {
        // Yardım modal'ını aç
        console.log('Help functionality would be implemented here');
    }

    /**
     * Klavye kısayollarını göster
     */
    showKeyboardShortcuts() {
        const shortcuts = this.generateShortcutsList();
        
        // Kısayol modal'ını aç
        const modal = this.createShortcutsModal(shortcuts);
        this.startFocusTrap(modal);
    }

    /**
     * Kısayol listesini oluştur
     */
    generateShortcutsList() {
        return [
            { key: 'Tab', description: 'Sonraki elemente odaklan' },
            { key: 'Shift + Tab', description: 'Önceki elemente odaklan' },
            { key: 'Enter / Space', description: 'Seçili elementi aktif et' },
            { key: 'Escape', description: 'Açık menü/modalı kapat' },
            { key: 'Alt + M', description: 'Ana içeriğe git' },
            { key: 'Alt + N', description: 'Navigasyona git' },
            { key: 'Alt + S', description: 'Aramaya git' },
            { key: 'Ctrl + /', description: 'Klavye kısayollarını göster' },
            { key: '↑↓←→', description: 'Liste ve menü navigasyonu' }
        ];
    }

    /**
     * Kısayol modal'ı oluştur
     */
    createShortcutsModal(shortcuts) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        modal.setAttribute('role', 'dialog');
        modal.setAttribute('aria-modal', 'true');
        modal.setAttribute('aria-labelledby', 'shortcuts-title');
        
        const content = document.createElement('div');
        content.className = 'bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4';
        
        content.innerHTML = `
            <div class="flex justify-between items-center mb-4">
                <h2 id="shortcuts-title" class="text-lg font-semibold">Klavye Kısayolları</h2>
                <button class="text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" data-close>
                    <span class="sr-only">Kapat</span>
                    ×
                </button>
            </div>
            <div class="space-y-2">
                ${shortcuts.map(shortcut => `
                    <div class="flex justify-between items-center">
                        <span class="text-sm">${shortcut.description}</span>
                        <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs">${shortcut.key}</kbd>
                    </div>
                `).join('')}
            </div>
        `;
        
        modal.appendChild(content);
        document.body.appendChild(modal);
        
        // Close button event
        content.querySelector('[data-close]').addEventListener('click', () => {
            this.closeModal(modal);
        });
        
        return modal;
    }

    /**
     * Etkileşimli element kontrolü
     */
    isInteractiveElement(element) {
        return element.matches('[role="button"], [role="tab"], [role="menuitem"], [data-toggle]');
    }

    /**
     * Custom element aktivasyonu
     */
    activateCustomElement(element) {
        // Data-toggle attribute'u varsa toggle et
        if (element.hasAttribute('data-toggle')) {
            const target = element.getAttribute('data-toggle');
            const toggleTarget = document.querySelector(target);
            if (toggleTarget) {
                toggleTarget.click();
            }
        }
        
        // Custom event emit et
        element.dispatchEvent(new CustomEvent('custom-activate', { bubbles: true }));
    }

    /**
     * Dropdown kontrolü
     */
    isDropdown(element) {
        return element.matches('.dropdown, [role="combobox"], [aria-haspopup="listbox"]');
    }

    /**
     * Menu kontrolü
     */
    isMenu(element) {
        return element.matches('nav[role="menubar"], [role="menu"], .menu');
    }

    /**
     * List kontrolü
     */
    isList(element) {
        return element.matches('ul[role="listbox"], ol[role="listbox"], .listbox');
    }

    /**
     * Grid kontrolü
     */
    isGrid(element) {
        return element.matches('[role="grid"], .grid');
    }

    /**
     * Grid sütun sayısını al
     */
    getGridColumns(grid) {
        const firstRow = grid.querySelector('[role="row"]');
        if (firstRow) {
            return firstRow.querySelectorAll('[role="gridcell"]').length;
        }
        return 1;
    }

    /**
     * Accessible name al
     */
    getAccessibleName(element) {
        // Try aria-label first
        if (element.getAttribute('aria-label')) {
            return element.getAttribute('aria-label');
        }
        
        // Try aria-labelledby
        const labelledBy = element.getAttribute('aria-labelledby');
        if (labelledBy) {
            const labelElement = document.getElementById(labelledBy);
            if (labelElement) {
                return labelElement.textContent.trim();
            }
        }
        
        // Try associated label (for form elements)
        if (element.id) {
            const label = document.querySelector(`label[for="${element.id}"]`);
            if (label) {
                return label.textContent.trim();
            }
        }
        
        // Try parent label
        const parentLabel = element.closest('label');
        if (parentLabel) {
            return parentLabel.textContent.trim();
        }
        
        // Try text content as fallback
        return element.textContent.trim().substring(0, 50);
    }

    /**
     * Focus history'ye ekleme
     */
    addToFocusHistory(element) {
        this.focusHistory.push(element);
        
        // Maksimum geçmiş boyutunu sınırla
        if (this.focusHistory.length > 50) {
            this.focusHistory.shift();
        }
    }

    /**
     * Focus indicator gösterme
     */
    showFocusIndicator(element) {
        if (!element.hasAttribute('data-accessibility-enhanced')) {
            element.setAttribute('data-accessibility-enhanced', 'true');
            
            // Custom focus styles ekle
            const style = document.createElement('style');
            style.textContent = `
                [data-accessibility-enhanced]:focus {
                    outline: 3px solid #3b82f6 !important;
                    outline-offset: 2px !important;
                    border-radius: 2px !important;
                }
            `;
            document.head.appendChild(style);
        }
    }

    /**
     * Focus indicator gizleme
     */
    hideFocusIndicator(element) {
        // Custom implementation for hiding focus indicator
        // This could be expanded based on specific needs
    }

    /**
     * Event listeners bağlama
     */
    bindEvents() {
        // Livewire events'leri dinle
        if (window.Livewire) {
            Livewire.on('accessibility-focus', (data) => {
                this.focusElement(data.selector, data.scroll);
            });
            
            Livewire.on('accessibility-trap-focus', (data) => {
                const container = document.querySelector(data.container);
                if (container) {
                    this.startFocusTrap(container, data.options);
                }
            });
            
            Livewire.on('accessibility-release-focus', () => {
                this.exitFocusTrap();
            });
        }
    }

    /**
     * Element'e odaklan
     */
    focusElement(selector, scroll = true) {
        const element = typeof selector === 'string' 
            ? document.querySelector(selector)
            : selector;
            
        if (element) {
            element.focus();
            if (scroll) {
                element.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    }

    /**
     * Utility'yi sıfırla
     */
    reset() {
        this.focusHistory = [];
        this.currentFocusTrap = null;
        this.skipLinks.forEach(link => link.remove());
        this.skipLinks = [];
    }

    /**
     * Durum bilgilerini al
     */
    getStatus() {
        return {
            focusHistoryLength: this.focusHistory.length,
            currentFocusTrap: !!this.currentFocusTrap,
            skipLinksCount: this.skipLinks.length,
            lastFocused: this.focusHistory[this.focusHistory.length - 1]
        };
    }
}

// Global instance
window.AccessibilityUtils = new AccessibilityUtils();

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AccessibilityUtils;
}