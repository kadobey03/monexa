/**
 * Admin Management System JavaScript Module
 * Advanced functionality for admin panel management
 */

// Admin Management Utilities
window.AdminManager = {
    
    // Manager Operations
    managers: {
        // Toggle manager status
        toggleStatus(adminId) {
            return confirmAction(
                'Durum Değişikliği',
                'Yöneticinin durumunu değiştirmek istediğinizden emin misiniz?'
            ).then((result) => {
                if (result.isConfirmed) {
                    return axios.post(`/admin/dashboard/managers/${adminId}/toggle-status`)
                        .then(response => {
                            showToast('Yönetici durumu başarıyla güncellendi', 'success');
                            return response.data;
                        })
                        .catch(error => {
                            showToast('Durum güncellenirken bir hata oluştu', 'error');
                            throw error;
                        });
                }
            });
        },

        // Delete manager with confirmation
        delete(adminId, adminName) {
            return Swal.fire({
                title: 'Yönetici Silme',
                text: `${adminName} isimli yöneticiyi silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Evet, Sil',
                cancelButtonText: 'İptal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    return axios.delete(`/admin/dashboard/managers/${adminId}`)
                        .then(response => {
                            showToast('Yönetici başarıyla silindi', 'success');
                            // Reload page or remove row
                            setTimeout(() => window.location.reload(), 1500);
                            return response.data;
                        })
                        .catch(error => {
                            showToast('Yönetici silinirken bir hata oluştu', 'error');
                            throw error;
                        });
                }
            });
        },

        // Bulk operations
        bulkAction(action, selectedIds) {
            if (selectedIds.length === 0) {
                showToast('Lütfen işlem yapmak istediğiniz yöneticileri seçin', 'warning');
                return;
            }

            const actionTexts = {
                activate: 'aktif yapma',
                deactivate: 'pasif yapma',
                delete: 'silme'
            };

            const actionText = actionTexts[action] || action;

            return confirmAction(
                'Toplu İşlem',
                `${selectedIds.length} yönetici için ${actionText} işlemini gerçekleştirmek istediğinizden emin misiniz?`
            ).then((result) => {
                if (result.isConfirmed) {
                    return axios.post('/admin/dashboard/managers/bulk-action', {
                        action: action,
                        ids: selectedIds
                    }).then(response => {
                        showToast(`Toplu ${actionText} işlemi başarıyla tamamlandı`, 'success');
                        setTimeout(() => window.location.reload(), 1500);
                        return response.data;
                    }).catch(error => {
                        showToast('Toplu işlem sırasında bir hata oluştu', 'error');
                        throw error;
                    });
                }
            });
        },

        // Export managers data
        export(format = 'csv') {
            const loading = Swal.fire({
                title: 'Dışa Aktarılıyor',
                text: 'Yönetici verileri hazırlanıyor...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            return axios.get(`/admin/dashboard/managers/export/${format}`, {
                responseType: 'blob'
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `managers_${new Date().toISOString().split('T')[0]}.${format}`);
                document.body.appendChild(link);
                link.click();
                link.remove();
                window.URL.revokeObjectURL(url);
                
                loading.close();
                showToast('Veriler başarıyla dışa aktarıldı', 'success');
            }).catch(error => {
                loading.close();
                showToast('Dışa aktarım sırasında bir hata oluştu', 'error');
                throw error;
            });
        }
    },

    // Role Management
    roles: {
        // Assign permissions to role
        assignPermissions(roleId, permissionIds) {
            return axios.post(`/admin/dashboard/roles/${roleId}/assign-permissions`, {
                permissions: permissionIds
            }).then(response => {
                showToast('İzinler başarıyla atandı', 'success');
                return response.data;
            }).catch(error => {
                showToast('İzin atanırken bir hata oluştu', 'error');
                throw error;
            });
        },

        // Remove permission from role
        removePermission(roleId, permissionId) {
            return confirmAction(
                'İzin Kaldırma',
                'Bu izni rolden kaldırmak istediğinizden emin misiniz?'
            ).then((result) => {
                if (result.isConfirmed) {
                    return axios.delete(`/admin/dashboard/roles/${roleId}/remove-permission/${permissionId}`)
                        .then(response => {
                            showToast('İzin başarıyla kaldırıldı', 'success');
                            return response.data;
                        })
                        .catch(error => {
                            showToast('İzin kaldırılırken bir hata oluştu', 'error');
                            throw error;
                        });
                }
            });
        },

        // Clone role
        clone(roleId, newName) {
            return axios.post(`/admin/dashboard/roles/${roleId}/clone`, {
                name: newName
            }).then(response => {
                showToast('Rol başarıyla kopyalandı', 'success');
                return response.data;
            }).catch(error => {
                showToast('Rol kopyalanırken bir hata oluştu', 'error');
                throw error;
            });
        }
    },

    // Permission Management
    permissions: {
        // Bulk assign permissions
        bulkAssign(roleIds, permissionIds) {
            return axios.post('/admin/dashboard/permissions/bulk-assign', {
                roles: roleIds,
                permissions: permissionIds
            }).then(response => {
                showToast('Toplu izin ataması başarıyla tamamlandı', 'success');
                return response.data;
            }).catch(error => {
                showToast('Toplu izin ataması sırasında bir hata oluştu', 'error');
                throw error;
            });
        },

        // Validate permission assignment
        validateAssignment(roleId, permissionId) {
            return axios.post('/admin/dashboard/permissions/validate-assignment', {
                role_id: roleId,
                permission_id: permissionId
            }).then(response => {
                return response.data;
            });
        },

        // Sync role permissions
        syncRolePermissions(roleId, permissionIds) {
            return axios.post('/admin/dashboard/permissions/sync-role-permissions', {
                role_id: roleId,
                permissions: permissionIds
            }).then(response => {
                showToast('İzinler başarıyla senkronize edildi', 'success');
                return response.data;
            }).catch(error => {
                showToast('İzin senkronizasyonu sırasında bir hata oluştu', 'error');
                throw error;
            });
        }
    },

    // Hierarchy Management
    hierarchy: {
        // Validate hierarchy move
        validateMove(adminId, newSupervisorId) {
            return axios.post('/admin/dashboard/hierarchy/validate-move', {
                admin_id: adminId,
                new_supervisor_id: newSupervisorId
            }).then(response => {
                return response.data;
            });
        },

        // Restructure hierarchy
        restructure(changes) {
            return confirmAction(
                'Hiyerarşi Yeniden Yapılandırma',
                'Hiyerarşi değişikliklerini kaydetmek istediğinizden emin misiniz?'
            ).then((result) => {
                if (result.isConfirmed) {
                    return axios.post('/admin/dashboard/hierarchy/restructure', {
                        changes: changes
                    }).then(response => {
                        showToast('Hiyerarşi başarıyla güncellendi', 'success');
                        return response.data;
                    }).catch(error => {
                        showToast('Hiyerarşi güncellenirken bir hata oluştu', 'error');
                        throw error;
                    });
                }
            });
        },

        // Export hierarchy chart
        exportChart(format = 'png') {
            const loading = Swal.fire({
                title: 'Grafik Hazırlanıyor',
                text: 'Hiyerarşi grafiği dışa aktarılıyor...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            return axios.get(`/admin/dashboard/hierarchy/export/${format}`, {
                responseType: 'blob'
            }).then(response => {
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `hierarchy_chart_${new Date().toISOString().split('T')[0]}.${format}`);
                document.body.appendChild(link);
                link.click();
                link.remove();
                window.URL.revokeObjectURL(url);
                
                loading.close();
                showToast('Grafik başarıyla dışa aktarıldı', 'success');
            }).catch(error => {
                loading.close();
                showToast('Grafik dışa aktarımı sırasında bir hata oluştu', 'error');
                throw error;
            });
        }
    },

    // Form Management
    forms: {
        // Auto-save draft functionality
        autoSave: {
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
            
            save(url, data) {
                axios.post(url, {
                    ...data,
                    _draft: true
                }).then(() => {
                    // Show subtle indication of auto-save
                    const indicator = document.querySelector('.auto-save-indicator');
                    if (indicator) {
                        indicator.textContent = `Son kayıt: ${new Date().toLocaleTimeString()}`;
                    }
                }).catch(() => {
                    // Silent fail for auto-save
                });
            }
        },

        // Form validation helpers
        validation: {
            // Real-time password strength checker
            checkPasswordStrength(password) {
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
                const colors = ['red', 'orange', 'yellow', 'blue', 'green'][score];

                return { score, strength, feedback, color: colors };
            },

            // Email validation
            validateEmail(email) {
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return regex.test(email);
            },

            // Phone validation (Turkish format)
            validatePhone(phone) {
                const regex = /^(\+90|0)?5\d{9}$/;
                return regex.test(phone.replace(/\s/g, ''));
            }
        }
    },

    // UI Helpers
    ui: {
        // Loading overlay
        showLoading(message = 'Yükleniyor...') {
            return Swal.fire({
                title: message,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },

        hideLoading() {
            Swal.close();
        },

        // Confirmation modal with custom options
        confirm(options = {}) {
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
        },

        // Progressive image loading
        loadImage(src) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                img.onload = () => resolve(img);
                img.onerror = reject;
                img.src = src;
            });
        },

        // Debounce function for search inputs
        debounce(func, wait = 300) {
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
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Initialize auto-save for forms with data-auto-save attribute
    const autoSaveForms = document.querySelectorAll('[data-auto-save]');
    autoSaveForms.forEach(form => {
        const saveUrl = form.dataset.autoSave;
        AdminManager.forms.autoSave.start(`#${form.id}`, saveUrl);
    });

    // Initialize password strength checker
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

    // Initialize debounced search
    const searchInputs = document.querySelectorAll('input[data-search-url]');
    searchInputs.forEach(input => {
        const searchUrl = input.dataset.searchUrl;
        const targetContainer = input.dataset.searchTarget;
        
        const debouncedSearch = AdminManager.ui.debounce(function(query) {
            if (query.length >= 2) {
                axios.get(searchUrl, { params: { q: query } })
                    .then(response => {
                        if (targetContainer) {
                            document.querySelector(targetContainer).innerHTML = response.data.html;
                        }
                    });
            }
        }, 300);

        input.addEventListener('input', function() {
            debouncedSearch(this.value);
        });
    });
});

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    AdminManager.forms.autoSave.stop();
});

// Export for use in other modules
export default AdminManager;