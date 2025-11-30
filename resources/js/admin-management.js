/**
 * Admin Management System - Modern ES6+ Module
 * Vite-optimized advanced functionality for admin panel management
 * Hot Module Replacement support and performance optimizations
 */

import axios from 'axios';
import { NotificationManager } from './utils/notification-manager.js';

/**
 * Manager Operations Module
 */
export class ManagerOperations {
    static async toggleStatus(adminId) {
        try {
            const titleText = typeof window.__ === 'function' ? window.__('confirmations.status_change') : 'Durum Değişikliği';
            const messageText = typeof window.__ === 'function' ? window.__('confirmations.admin_status_change') : 'Yöneticinin durumunu değiştirmek istediğinizden emin misiniz?';
            
            const result = await this.confirmAction(titleText, messageText);

            if (result.isConfirmed) {
                const response = await axios.post(`/admin/dashboard/managers/${adminId}/toggle-status`);
                NotificationManager.showToast('Yönetici durumu başarıyla güncellendi', 'success');
                return response.data;
            }
        } catch (error) {
            NotificationManager.showToast('Durum güncellenirken bir hata oluştu', 'error');
            throw error;
        }
    }

    static async delete(adminId, adminName) {
        try {
            const result = await Swal.fire({
                title: 'Yönetici Silme',
                text: `${adminName} isimli yöneticiyi silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Evet, Sil',
                cancelButtonText: 'İptal',
                reverseButtons: true
            });

            if (result.isConfirmed) {
                const response = await axios.delete(`/admin/dashboard/managers/${adminId}`);
                NotificationManager.showToast('Yönetici başarıyla silindi', 'success');
                
                // Reload page with delay
                setTimeout(() => window.location.reload(), 1500);
                return response.data;
            }
        } catch (error) {
            NotificationManager.showToast('Yönetici silinirken bir hata oluştu', 'error');
            throw error;
        }
    }

    static async bulkAction(action, selectedIds) {
        if (selectedIds.length === 0) {
            NotificationManager.showToast('Lütfen işlem yapmak istediğiniz yöneticileri seçin', 'warning');
            return;
        }

        const actionTexts = {
            activate: 'aktif yapma',
            deactivate: 'pasif yapma',
            delete: 'silme'
        };

        const actionText = actionTexts[action] || action;

        try {
            const result = await this.confirmAction(
                'Toplu İşlem',
                `${selectedIds.length} yönetici için ${actionText} işlemini gerçekleştirmek istediğinizden emin misiniz?`
            );

            if (result.isConfirmed) {
                const response = await axios.post('/admin/dashboard/managers/bulk-action', {
                    action,
                    ids: selectedIds
                });

                NotificationManager.showToast(`Toplu ${actionText} işlemi başarıyla tamamlandı`, 'success');
                setTimeout(() => window.location.reload(), 1500);
                return response.data;
            }
        } catch (error) {
            NotificationManager.showToast('Toplu işlem sırasında bir hata oluştu', 'error');
            throw error;
        }
    }

    static async export(format = 'csv') {
        const loading = Swal.fire({
            title: 'Dışa Aktarılıyor',
            text: 'Yönetici verileri hazırlanıyor...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        try {
            const response = await axios.get(`/admin/dashboard/managers/export/${format}`, {
                responseType: 'blob'
            });

            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', `managers_${new Date().toISOString().split('T')[0]}.${format}`);
            document.body.appendChild(link);
            link.click();
            link.remove();
            window.URL.revokeObjectURL(url);

            loading.close();
            NotificationManager.showToast('Veriler başarıyla dışa aktarıldı', 'success');
        } catch (error) {
            loading.close();
            NotificationManager.showToast('Dışa aktarım sırasında bir hata oluştu', 'error');
            throw error;
        }
    }

    static confirmAction(title, text, confirmText = 'Evet', cancelText = 'İptal') {
        return Swal.fire({
            title,
            text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            confirmButtonText: confirmText,
            cancelButtonText: cancelText,
            reverseButtons: true
        });
    }
}

/**
 * Role Management Operations
 */
export class RoleOperations {
    static async assignPermissions(roleId, permissionIds) {
        try {
            const response = await axios.post(`/admin/dashboard/roles/${roleId}/assign-permissions`, {
                permissions: permissionIds
            });

            NotificationManager.showToast('İzinler başarıyla atandı', 'success');
            return response.data;
        } catch (error) {
            NotificationManager.showToast('İzin atanırken bir hata oluştu', 'error');
            throw error;
        }
    }

    static async removePermission(roleId, permissionId) {
        try {
            const result = await ManagerOperations.confirmAction(
                'İzin Kaldırma',
                'Bu izni rolden kaldırmak istediğinizden emin misiniz?'
            );

            if (result.isConfirmed) {
                const response = await axios.delete(`/admin/dashboard/roles/${roleId}/remove-permission/${permissionId}`);
                NotificationManager.showToast('İzin başarıyla kaldırıldı', 'success');
                return response.data;
            }
        } catch (error) {
            NotificationManager.showToast('İzin kaldırılırken bir hata oluştu', 'error');
            throw error;
        }
    }

    static async clone(roleId, newName) {
        try {
            const response = await axios.post(`/admin/dashboard/roles/${roleId}/clone`, {
                name: newName
            });

            NotificationManager.showToast('Rol başarıyla kopyalandı', 'success');
            return response.data;
        } catch (error) {
            NotificationManager.showToast('Rol kopyalanırken bir hata oluştu', 'error');
            throw error;
        }
    }
}

/**
 * Permission Management Operations
 */
export class PermissionOperations {
    static async bulkAssign(roleIds, permissionIds) {
        try {
            const response = await axios.post('/admin/dashboard/permissions/bulk-assign', {
                roles: roleIds,
                permissions: permissionIds
            });

            NotificationManager.showToast('Toplu izin ataması başarıyla tamamlandı', 'success');
            return response.data;
        } catch (error) {
            NotificationManager.showToast('Toplu izin ataması sırasında bir hata oluştu', 'error');
            throw error;
        }
    }

    static async validateAssignment(roleId, permissionId) {
        const response = await axios.post('/admin/dashboard/permissions/validate-assignment', {
            role_id: roleId,
            permission_id: permissionId
        });

        return response.data;
    }

    static async syncRolePermissions(roleId, permissionIds) {
        try {
            const response = await axios.post('/admin/dashboard/permissions/sync-role-permissions', {
                role_id: roleId,
                permissions: permissionIds
            });

            NotificationManager.showToast('İzinler başarıyla senkronize edildi', 'success');
            return response.data;
        } catch (error) {
            NotificationManager.showToast('İzin senkronizasyonu sırasında bir hata oluştu', 'error');
            throw error;
        }
    }
}

/**
 * Hierarchy Management Operations
 */
export class HierarchyOperations {
    static async validateMove(adminId, newSupervisorId) {
        const response = await axios.post('/admin/dashboard/hierarchy/validate-move', {
            admin_id: adminId,
            new_supervisor_id: newSupervisorId
        });

        return response.data;
    }

    static async restructure(changes) {
        try {
            const result = await ManagerOperations.confirmAction(
                'Hiyerarşi Yeniden Yapılandırma',
                'Hiyerarşi değişikliklerini kaydetmek istediğinizden emin misiniz?'
            );

            if (result.isConfirmed) {
                const response = await axios.post('/admin/dashboard/hierarchy/restructure', {
                    changes
                });

                NotificationManager.showToast('Hiyerarşi başarıyla güncellendi', 'success');
                return response.data;
            }
        } catch (error) {
            NotificationManager.showToast('Hiyerarşi güncellenirken bir hata oluştu', 'error');
            throw error;
        }
    }

    static async exportChart(format = 'png') {
        const loading = Swal.fire({
            title: 'Grafik Hazırlanıyor',
            text: 'Hiyerarşi grafiği dışa aktarılıyor...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        try {
            const response = await axios.get(`/admin/dashboard/hierarchy/export/${format}`, {
                responseType: 'blob'
            });

            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', `hierarchy_chart_${new Date().toISOString().split('T')[0]}.${format}`);
            document.body.appendChild(link);
            link.click();
            link.remove();
            window.URL.revokeObjectURL(url);

            loading.close();
            NotificationManager.showToast('Grafik başarıyla dışa aktarıldı', 'success');
        } catch (error) {
            loading.close();
            NotificationManager.showToast('Grafik dışa aktarımı sırasında bir hata oluştu', 'error');
            throw error;
        }
    }
}

/**
 * Form Management Operations
 */
export class FormOperations {
    static autoSave = {
        interval: null,
        formData: {},

        start(formSelector, saveUrl, interval = 30000) {
            this.stop(); // Clear existing interval

            this.interval = setInterval(() => {
                const form = document.querySelector(formSelector);
                if (form) {
                    const formData = new FormData(form);
                    const data = Object.fromEntries(formData.entries());

                    // Only save if form data has changed
                    if (JSON.stringify(data) !== JSON.stringify(this.formData)) {
                        this.formData = data;
                        this.save(saveUrl, data);
                    }
                }
            }, interval);
        },

        stop() {
            if (this.interval) {
                clearInterval(this.interval);
                this.interval = null;
            }
        },

        async save(url, data) {
            try {
                await axios.post(url, {
                    ...data,
                    _draft: true
                });

                // Show subtle indication of auto-save
                const indicator = document.querySelector('.auto-save-indicator');
                if (indicator) {
                    indicator.textContent = `Son kayıt: ${new Date().toLocaleTimeString()}`;
                }
            } catch (error) {
                // Silent fail for auto-save
                console.warn('Auto-save failed:', error);
            }
        }
    };

    static validation = {
        checkPasswordStrength(password) {
            let score = 0;
            const feedback = [];

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
            const colors = ['red', 'orange', 'yellow', 'blue', 'green'][score];

            return { score, strength, feedback, color: colors };
        },

        validateEmail(email) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        },

        validatePhone(phone) {
            const regex = /^(\+90|0)?5\d{9}$/;
            return regex.test(phone.replace(/\s/g, ''));
        }
    };
}

/**
 * UI Helper Operations
 */
export class UIOperations {
    static showLoading(message = 'Yükleniyor...') {
        return Swal.fire({
            title: message,
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
    }

    static hideLoading() {
        Swal.close();
    }

    static confirm(options = {}) {
        const defaults = {
            title: 'Emin misiniz?',
            text: 'Bu işlemi gerçekleştirmek istediğinizden emin misiniz?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Evet',
            cancelButtonText: 'İptal',
            reverseButtons: true
        };

        return Swal.fire({ ...defaults, ...options });
    }

    static loadImage(src) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            img.onload = () => resolve(img);
            img.onerror = reject;
            img.src = src;
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

/**
 * Main Admin Manager Class - Modern Implementation
 */
export class AdminManager {
    static managers = ManagerOperations;
    static roles = RoleOperations;
    static permissions = PermissionOperations;
    static hierarchy = HierarchyOperations;
    static forms = FormOperations;
    static ui = UIOperations;

    static init() {
        console.log('✅ Admin Manager initialized');
        
        // Initialize UI components
        this.initializeTooltips();
        this.initializeAutoSave();
        this.initializePasswordStrengthChecker();
        this.initializeDebouncedSearch();

        // Make available globally for backward compatibility
        window.AdminManager = this;
    }

    static initializeTooltips() {
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        }
    }

    static initializeAutoSave() {
        const autoSaveForms = document.querySelectorAll('[data-auto-save]');
        autoSaveForms.forEach(form => {
            const saveUrl = form.dataset.autoSave;
            this.forms.autoSave.start(`#${form.id}`, saveUrl);
        });
    }

    static initializePasswordStrengthChecker() {
        const passwordInputs = document.querySelectorAll('input[type="password"][data-strength-check]');
        passwordInputs.forEach(input => {
            const strengthIndicator = document.querySelector(`#${input.id}-strength`);
            if (strengthIndicator) {
                input.addEventListener('input', function() {
                    const result = AdminManager.forms.validation.checkPasswordStrength(this.value);
                    strengthIndicator.innerHTML = `
                        <div class="flex items-center space-x-2">
                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                <div class="bg-${result.color}-500 h-2 rounded-full transition-all duration-300" 
                                     style="width: ${(result.score / 5) * 100}%"></div>
                            </div>
                            <span class="text-sm font-medium text-${result.color}-600">${result.strength}</span>
                        </div>
                        ${result.feedback.length > 0 ? `<ul class="text-xs text-gray-500 mt-1">${result.feedback.map(fb => `<li>• ${fb}</li>`).join('')}</ul>` : ''}
                    `;
                });
            }
        });
    }

    static initializeDebouncedSearch() {
        const searchInputs = document.querySelectorAll('input[data-search-url]');
        searchInputs.forEach(input => {
            const searchUrl = input.dataset.searchUrl;
            const targetContainer = input.dataset.searchTarget;

            const debouncedSearch = this.ui.debounce(async function(query) {
                if (query.length >= 2) {
                    try {
                        const response = await axios.get(searchUrl, { params: { q: query } });
                        if (targetContainer) {
                            document.querySelector(targetContainer).innerHTML = response.data.html;
                        }
                    } catch (error) {
                        console.warn('Search failed:', error);
                    }
                }
            }, 300);

            input.addEventListener('input', function() {
                debouncedSearch(this.value);
            });
        });
    }

    static cleanup() {
        this.forms.autoSave.stop();
        console.log('🧹 Admin Manager cleanup completed');
    }
}

// Legacy compatibility object for backward compatibility
const LegacyAdminManager = {
    managers: ManagerOperations,
    roles: RoleOperations,
    permissions: PermissionOperations,
    hierarchy: HierarchyOperations,
    forms: FormOperations,
    ui: UIOperations
};

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => AdminManager.init());
} else {
    AdminManager.init();
}

// Cleanup on page unload
window.addEventListener('beforeunload', () => AdminManager.cleanup());

// HMR support
if (import.meta.hot) {
    import.meta.hot.accept(() => {
        console.log('🔥 HMR: Admin Manager reloaded');
        AdminManager.init();
    });
}

// Export modern classes
export default AdminManager;

// Export legacy object for backward compatibility
export { LegacyAdminManager };