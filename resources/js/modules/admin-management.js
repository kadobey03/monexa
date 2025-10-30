/**
 * Admin Management Module - Modern ES6+ Version
 * Modernized admin panel management with modular architecture
 */

import { CSRFManager } from '../utils/csrf-manager.js';
import { NotificationManager } from '../utils/notification-manager.js';

/**
 * Admin Management Class
 */
class ModernAdminManager {
    constructor() {
        this.initialized = false;
        this.eventListeners = [];
        this.managers = {
            users: null,
            roles: null,
            permissions: null,
            hierarchy: null
        };
    }

    /**
     * Initialize admin management system
     */
    async init() {
        if (this.initialized) return;

        console.log('🔧 Admin Management Module initializing...');
        
        try {
            await this.initializeManagers();
            this.setupEventListeners();
            this.setupFormHandlers();
            this.initializeFeatures();
            
            this.initialized = true;
            console.log('✅ Admin Management Module initialized');
            
        } catch (error) {
            console.error('❌ Admin Management initialization failed:', error);
            NotificationManager.error('Admin yönetim sistemi başlatılamadı');
        }
    }

    /**
     * Initialize sub-managers
     */
    async initializeManagers() {
        // Initialize user manager
        this.managers.users = new UserManager();
        await this.managers.users.init();

        // Initialize role manager
        this.managers.roles = new RoleManager();
        await this.managers.roles.init();

        // Initialize permission manager
        this.managers.permissions = new PermissionManager();
        await this.managers.permissions.init();

        // Initialize hierarchy manager
        this.managers.hierarchy = new HierarchyManager();
        await this.managers.hierarchy.init();
    }

    /**
     * Setup global event listeners
     */
    setupEventListeners() {
        // Auto-save functionality for forms
        const autoSaveForms = document.querySelectorAll('[data-auto-save]');
        autoSaveForms.forEach(form => this.setupAutoSave(form));

        // Password strength checker
        const passwordInputs = document.querySelectorAll('input[type="password"][data-strength-check]');
        passwordInputs.forEach(input => this.setupPasswordStrength(input));

        // Search functionality
        const searchInputs = document.querySelectorAll('input[data-search-url]');
        searchInputs.forEach(input => this.setupDebouncedSearch(input));
    }

    /**
     * Setup form handlers
     */
    setupFormHandlers() {
        // Generic form submission handler
        const ajaxForms = document.querySelectorAll('[data-ajax-form]');
        ajaxForms.forEach(form => this.setupAjaxForm(form));

        // Confirmation handlers for dangerous actions
        const confirmButtons = document.querySelectorAll('[data-confirm]');
        confirmButtons.forEach(button => this.setupConfirmation(button));
    }

    /**
     * Initialize admin-specific features
     */
    initializeFeatures() {
        this.setupTooltips();
        this.setupModals();
        this.setupDataTables();
        this.setupFileUploads();
    }

    /**
     * User Management Methods
     */
    async toggleUserStatus(userId) {
        const confirmed = await NotificationManager.confirm(
            'Durum Değişikliği',
            'Kullanıcının durumunu değiştirmek istediğinizden emin misiniz?'
        );

        if (!confirmed) return;

        try {
            const response = await CSRFManager.post(`/admin/users/${userId}/toggle-status`);
            const data = await response.json();

            if (data.success) {
                NotificationManager.success('Kullanıcı durumu başarıyla güncellendi');
                this.refreshUsersList();
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error toggling user status:', error);
            NotificationManager.error('Durum güncellenirken hata oluştu');
        }
    }

    async deleteUser(userId, userName) {
        const confirmed = await NotificationManager.confirm(
            'Kullanıcı Silme',
            `${userName} kullanıcısını silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.`
        );

        if (!confirmed) return;

        try {
            const response = await CSRFManager.delete(`/admin/users/${userId}`);
            const data = await response.json();

            if (data.success) {
                NotificationManager.success('Kullanıcı başarıyla silindi');
                this.refreshUsersList();
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error deleting user:', error);
            NotificationManager.error('Kullanıcı silinirken hata oluştu');
        }
    }

    async bulkAction(action, selectedIds) {
        if (selectedIds.length === 0) {
            NotificationManager.warning('Lütfen işlem yapmak istediğiniz kullanıcıları seçin');
            return;
        }

        const actionTexts = {
            activate: 'aktif yapma',
            deactivate: 'pasif yapma',
            delete: 'silme'
        };

        const actionText = actionTexts[action] || action;
        const confirmed = await NotificationManager.confirm(
            'Toplu İşlem',
            `${selectedIds.length} kullanıcı için ${actionText} işlemini gerçekleştirmek istediğinizden emin misiniz?`
        );

        if (!confirmed) return;

        try {
            const response = await CSRFManager.post('/admin/users/bulk-action', {
                action: action,
                ids: selectedIds
            });

            const data = await response.json();

            if (data.success) {
                NotificationManager.success(`Toplu ${actionText} işlemi başarıyla tamamlandı`);
                this.refreshUsersList();
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error performing bulk action:', error);
            NotificationManager.error('Toplu işlem sırasında hata oluştu');
        }
    }

    /**
     * Auto-save setup
     */
    setupAutoSave(form) {
        const saveUrl = form.dataset.autoSave;
        const interval = parseInt(form.dataset.autoSaveInterval) || 30000;
        let formData = {};
        let autoSaveTimer;

        const autoSave = () => {
            const currentData = new FormData(form);
            const currentDataObj = Object.fromEntries(currentData.entries());

            // Only save if form data has changed
            if (JSON.stringify(currentDataObj) !== JSON.stringify(formData)) {
                formData = currentDataObj;
                
                CSRFManager.post(saveUrl, { ...currentDataObj, _draft: true })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const indicator = form.querySelector('.auto-save-indicator');
                            if (indicator) {
                                indicator.textContent = `Son kayıt: ${new Date().toLocaleTimeString()}`;
                                indicator.classList.add('text-green-600');
                                setTimeout(() => indicator.classList.remove('text-green-600'), 2000);
                            }
                        }
                    })
                    .catch(() => {
                        // Silent fail for auto-save
                    });
            }
        };

        autoSaveTimer = setInterval(autoSave, interval);

        // Clear timer when form is submitted or page unloads
        form.addEventListener('submit', () => clearInterval(autoSaveTimer));
        window.addEventListener('beforeunload', () => clearInterval(autoSaveTimer));
        
        this.addEventListenerTracker(window, 'beforeunload', () => clearInterval(autoSaveTimer));
    }

    /**
     * Password strength checker
     */
    setupPasswordStrength(input) {
        const strengthIndicator = document.querySelector(`#${input.id}-strength`);
        if (!strengthIndicator) return;

        const checkStrength = () => {
            const password = input.value;
            let score = 0;
            let feedback = [];

            if (password.length >= 8) score++;
            else feedback.push('En az 8 karakter olmalı');

            if (/[a-z]/.test(password)) score++;
            else feedback.push('Küçük harf içermeli');

            if (/[A-Z]/.test(password)) score++;
            else feedback.push('Büyük harf içermeli');

            if (/[0-9]/.test(password)) score++;
            else feedback.push('Sayı içermeli');

            if (/[^A-Za-z0-9]/.test(password)) score++;
            else feedback.push('Özel karakter içermeli');

            const strength = ['Çok Zayıf', 'Zayıf', 'Orta', 'İyi', 'Güçlü'][score];
            const colors = ['red', 'red', 'yellow', 'blue', 'green'][score];

            strengthIndicator.innerHTML = `
                <div class="flex items-center space-x-2">
                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                        <div class="bg-${colors}-500 h-2 rounded-full transition-all duration-300" 
                             style="width: ${(score / 5) * 100}%"></div>
                    </div>
                    <span class="text-sm font-medium text-${colors}-600">${strength}</span>
                </div>
                ${feedback.length > 0 ? `<ul class="text-xs text-gray-500 mt-1">${feedback.map(fb => `<li>• ${fb}</li>`).join('')}</ul>` : ''}
            `;
        };

        const handler = this.debounce(checkStrength, 300);
        input.addEventListener('input', handler);
        this.addEventListenerTracker(input, 'input', handler);
    }

    /**
     * Debounced search setup
     */
    setupDebouncedSearch(input) {
        const searchUrl = input.dataset.searchUrl;
        const targetContainer = input.dataset.searchTarget;

        const search = async (query) => {
            if (query.length >= 2) {
                try {
                    const response = await CSRFManager.get(`${searchUrl}?q=${encodeURIComponent(query)}`);
                    const data = await response.json();
                    
                    if (data.success && targetContainer) {
                        const container = document.querySelector(targetContainer);
                        if (container) {
                            container.innerHTML = data.html || '';
                        }
                    }
                } catch (error) {
                    console.error('Search error:', error);
                }
            }
        };

        const handler = this.debounce(search, 300);
        input.addEventListener('input', (e) => handler(e.target.value));
        this.addEventListenerTracker(input, 'input', handler);
    }

    /**
     * AJAX form setup
     */
    setupAjaxForm(form) {
        const handler = async (e) => {
            e.preventDefault();
            
            const submitBtn = form.querySelector('[type="submit"]');
            const originalText = submitBtn?.textContent;
            
            try {
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Gönderiliyor...';
                }

                const response = await CSRFManager.submitForm(form);
                const data = await response.json();

                if (data.success) {
                    NotificationManager.success(data.message || 'İşlem başarıyla tamamlandı');
                    
                    // Reset form if specified
                    if (form.dataset.resetOnSuccess) {
                        form.reset();
                    }
                    
                    // Redirect if specified
                    if (data.redirect) {
                        setTimeout(() => window.location.href = data.redirect, 1000);
                    }
                    
                    // Reload specific sections
                    if (form.dataset.reloadTarget) {
                        this.reloadSection(form.dataset.reloadTarget);
                    }
                } else {
                    NotificationManager.error(data.message || 'İşlem başarısız');
                }
            } catch (error) {
                console.error('Form submission error:', error);
                NotificationManager.error('Form gönderilirken hata oluştu');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            }
        };

        form.addEventListener('submit', handler);
        this.addEventListenerTracker(form, 'submit', handler);
    }

    /**
     * Confirmation setup
     */
    setupConfirmation(button) {
        const handler = async (e) => {
            e.preventDefault();
            
            const message = button.dataset.confirm;
            const confirmed = await NotificationManager.confirm('Onay', message);
            
            if (confirmed) {
                // If it's a link, navigate to href
                if (button.href) {
                    window.location.href = button.href;
                }
                // If it's in a form, submit the form
                else if (button.form) {
                    button.form.submit();
                }
                // If it has onclick, execute it
                else if (button.onclick) {
                    button.onclick();
                }
            }
        };

        button.addEventListener('click', handler);
        this.addEventListenerTracker(button, 'click', handler);
    }

    /**
     * Utility Methods
     */
    setupTooltips() {
        // Initialize tooltips if library is available
        if (window.bootstrap && window.bootstrap.Tooltip) {
            const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltipElements.forEach(el => new window.bootstrap.Tooltip(el));
        }
    }

    setupModals() {
        // Initialize modals if library is available
        if (window.bootstrap && window.bootstrap.Modal) {
            const modalElements = document.querySelectorAll('.modal');
            modalElements.forEach(el => new window.bootstrap.Modal(el));
        }
    }

    setupDataTables() {
        // Initialize DataTables if library is available
        if (window.$ && window.$.fn.DataTable) {
            const tables = document.querySelectorAll('[data-datatable]');
            tables.forEach(table => {
                window.$(table).DataTable({
                    responsive: true,
                    language: {
                        url: '/assets/js/datatables-turkish.json'
                    }
                });
            });
        }
    }

    setupFileUploads() {
        const fileInputs = document.querySelectorAll('input[type="file"][data-preview]');
        fileInputs.forEach(input => this.setupFilePreview(input));
    }

    setupFilePreview(input) {
        const previewContainer = document.querySelector(input.dataset.preview);
        if (!previewContainer) return;

        const handler = (e) => {
            const files = e.target.files;
            previewContainer.innerHTML = '';

            Array.from(files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.className = 'w-20 h-20 object-cover rounded border';
                    img.src = URL.createObjectURL(file);
                    previewContainer.appendChild(img);
                }
            });
        };

        input.addEventListener('change', handler);
        this.addEventListenerTracker(input, 'change', handler);
    }

    /**
     * Helper Methods
     */
    debounce(func, wait) {
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

    addEventListenerTracker(element, event, handler) {
        this.eventListeners.push({ element, event, handler });
    }

    async refreshUsersList() {
        const usersContainer = document.querySelector('[data-users-list]');
        if (usersContainer) {
            try {
                const response = await CSRFManager.get('/admin/users/list');
                const data = await response.json();
                
                if (data.success) {
                    usersContainer.innerHTML = data.html;
                }
            } catch (error) {
                console.error('Error refreshing users list:', error);
            }
        }
    }

    async reloadSection(selector) {
        const section = document.querySelector(selector);
        if (section) {
            const url = section.dataset.reloadUrl;
            if (url) {
                try {
                    const response = await CSRFManager.get(url);
                    const data = await response.json();
                    
                    if (data.success) {
                        section.innerHTML = data.html;
                    }
                } catch (error) {
                    console.error('Error reloading section:', error);
                }
            }
        }
    }

    /**
     * Cleanup resources
     */
    cleanup() {
        // Remove event listeners
        this.eventListeners.forEach(({ element, event, handler }) => {
            element.removeEventListener(event, handler);
        });
        this.eventListeners = [];

        // Cleanup managers
        Object.values(this.managers).forEach(manager => {
            if (manager && manager.cleanup) {
                manager.cleanup();
            }
        });

        this.initialized = false;
        console.log('🧹 Admin Management Module cleaned up');
    }

    /**
     * Public API
     */
    getManager(name) {
        return this.managers[name];
    }
}

/**
 * Sub-manager classes (simplified versions)
 */
class UserManager {
    constructor() {
        this.users = [];
    }

    async init() {
        console.log('✅ User Manager initialized');
    }

    async loadUsers() {
        // Implementation
    }

    cleanup() {
        console.log('🧹 User Manager cleaned up');
    }
}

class RoleManager {
    constructor() {
        this.roles = [];
    }

    async init() {
        console.log('✅ Role Manager initialized');
    }

    cleanup() {
        console.log('🧹 Role Manager cleaned up');
    }
}

class PermissionManager {
    constructor() {
        this.permissions = [];
    }

    async init() {
        console.log('✅ Permission Manager initialized');
    }

    cleanup() {
        console.log('🧹 Permission Manager cleaned up');
    }
}

class HierarchyManager {
    constructor() {
        this.hierarchy = {};
    }

    async init() {
        console.log('✅ Hierarchy Manager initialized');
    }

    cleanup() {
        console.log('🧹 Hierarchy Manager cleaned up');
    }
}

// Create singleton instance
const AdminManager = new ModernAdminManager();

// Global convenience functions (for backwards compatibility)
window.AdminManager = AdminManager;
window.toggleUserStatus = (userId) => AdminManager.toggleUserStatus(userId);
window.deleteUser = (userId, userName) => AdminManager.deleteUser(userId, userName);
window.bulkAction = (action, selectedIds) => AdminManager.bulkAction(action, selectedIds);

export { AdminManager, ModernAdminManager };
export default AdminManager;