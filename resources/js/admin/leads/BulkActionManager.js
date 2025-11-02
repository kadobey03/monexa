/**
 * Bulk Action Manager
 * Toplu işlemler (bulk actions) yönetimi ve progress tracking
 */
class BulkActionManager {
    constructor() {
        this.activeOperations = new Map();
        this.operationHistory = [];
        this.maxHistorySize = 50;
        
        // Bulk action types
        this.actionTypes = {
            UPDATE_STATUS: 'update_status',
            ASSIGN_USER: 'assign_user',
            ADD_TAGS: 'add_tags',
            REMOVE_TAGS: 'remove_tags',
            UPDATE_PRIORITY: 'update_priority',
            DELETE: 'delete',
            EXPORT: 'export',
            MOVE_SOURCE: 'move_source',
            UPDATE_SCORE: 'update_score'
        };
        
        // Progress tracking
        this.progressCallbacks = new Map();
        
        this.init();
    }
    
    init() {
        this.loadOperationHistory();
        this.setupEventListeners();
    }
    
    /**
     * Execute bulk action with progress tracking
     */
    async executeBulkAction(actionType, leadIds, data = {}, options = {}) {
        if (!leadIds || leadIds.length === 0) {
            throw new Error('Seçili lead bulunamadı');
        }
        
        const operationId = this.generateOperationId();
        const operation = {
            id: operationId,
            type: actionType,
            leadIds: [...leadIds],
            data: { ...data },
            options: { ...options },
            status: 'pending',
            progress: 0,
            startTime: Date.now(),
            processedCount: 0,
            successCount: 0,
            errorCount: 0,
            errors: []
        };
        
        this.activeOperations.set(operationId, operation);
        this.emit('operationStarted', operation);
        
        try {
            const result = await this.performBulkAction(operation);
            
            operation.status = 'completed';
            operation.endTime = Date.now();
            operation.duration = operation.endTime - operation.startTime;
            
            this.addToHistory(operation);
            this.emit('operationCompleted', { operation, result });
            
            return result;
            
        } catch (error) {
            operation.status = 'failed';
            operation.error = error.message;
            operation.endTime = Date.now();
            operation.duration = operation.endTime - operation.startTime;
            
            this.addToHistory(operation);
            this.emit('operationFailed', { operation, error });
            
            throw error;
            
        } finally {
            this.activeOperations.delete(operationId);
        }
    }
    
    /**
     * Perform the actual bulk action
     */
    async performBulkAction(operation) {
        const { type, leadIds, data } = operation;
        
        switch (type) {
            case this.actionTypes.UPDATE_STATUS:
                return await this.bulkUpdateStatus(operation);
                
            case this.actionTypes.ASSIGN_USER:
                return await this.bulkAssignUser(operation);
                
            case this.actionTypes.ADD_TAGS:
                return await this.bulkAddTags(operation);
                
            case this.actionTypes.REMOVE_TAGS:
                return await this.bulkRemoveTags(operation);
                
            case this.actionTypes.UPDATE_PRIORITY:
                return await this.bulkUpdatePriority(operation);
                
            case this.actionTypes.DELETE:
                return await this.bulkDelete(operation);
                
            case this.actionTypes.EXPORT:
                return await this.bulkExport(operation);
                
            case this.actionTypes.MOVE_SOURCE:
                return await this.bulkMoveSource(operation);
                
            case this.actionTypes.UPDATE_SCORE:
                return await this.bulkUpdateScore(operation);
                
            default:
                throw new Error(`Bilinmeyen işlem türü: ${type}`);
        }
    }
    
    /**
     * Bulk update status
     */
    async bulkUpdateStatus(operation) {
        const { leadIds, data } = operation;
        const { status } = data;
        
        this.updateProgress(operation.id, 10, 'Durum güncelleme başlatılıyor...');
        
        try {
            const response = await fetch('/admin/leads/bulk-update-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    lead_ids: leadIds,
                    status_name: status
                })
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const result = await response.json();
            
            this.updateProgress(operation.id, 100, `${result.updated} lead durumu güncellendi`);
            
            operation.successCount = result.updated;
            operation.processedCount = leadIds.length;
            
            return result;
            
        } catch (error) {
            this.updateProgress(operation.id, 0, 'Durum güncelleme başarısız');
            throw error;
        }
    }
    
    /**
     * Bulk assign user
     */
    async bulkAssignUser(operation) {
        const { leadIds, data } = operation;
        const { admin_id } = data;
        
        this.updateProgress(operation.id, 10, 'Atama işlemi başlatılıyor...');
        
        try {
            const response = await fetch('/admin/leads/bulk-assign', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    lead_ids: leadIds,
                    admin_id: admin_id
                })
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const result = await response.json();
            
            this.updateProgress(operation.id, 100, `${result.assigned} lead atandı`);
            
            operation.successCount = result.assigned;
            operation.processedCount = leadIds.length;
            
            return result;
            
        } catch (error) {
            this.updateProgress(operation.id, 0, 'Atama işlemi başarısız');
            throw error;
        }
    }
    
    /**
     * Bulk add tags
     */
    async bulkAddTags(operation) {
        const { leadIds, data } = operation;
        const { tags } = data;
        
        this.updateProgress(operation.id, 10, 'Etiket ekleme başlatılıyor...');
        
        try {
            const response = await fetch('/admin/leads/bulk-add-tags', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    lead_ids: leadIds,
                    tags: tags
                })
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const result = await response.json();
            
            this.updateProgress(operation.id, 100, `${tags.length} etiket ${result.updated} lead'e eklendi`);
            
            operation.successCount = result.updated;
            operation.processedCount = leadIds.length;
            
            return result;
            
        } catch (error) {
            this.updateProgress(operation.id, 0, 'Etiket ekleme başarısız');
            throw error;
        }
    }
    
    /**
     * Bulk delete
     */
    async bulkDelete(operation) {
        const { leadIds } = operation;
        
        this.updateProgress(operation.id, 10, 'Silme işlemi başlatılıyor...');
        
        // Process in batches to avoid overwhelming the server
        const batchSize = 50;
        let totalDeleted = 0;
        let totalErrors = 0;
        
        for (let i = 0; i < leadIds.length; i += batchSize) {
            const batch = leadIds.slice(i, i + batchSize);
            const progress = Math.round(((i + batch.length) / leadIds.length) * 90) + 10;
            
            this.updateProgress(operation.id, progress, `${Math.min(i + batch.length, leadIds.length)}/${leadIds.length} lead işleniyor...`);
            
            try {
                const response = await fetch('/admin/leads/bulk-delete', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        lead_ids: batch
                    })
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                
                const result = await response.json();
                totalDeleted += result.deleted || 0;
                
            } catch (error) {
                totalErrors += batch.length;
                operation.errors.push(`Batch ${i / batchSize + 1}: ${error.message}`);
            }
            
            // Small delay between batches
            await new Promise(resolve => setTimeout(resolve, 100));
        }
        
        this.updateProgress(operation.id, 100, `${totalDeleted} lead silindi`);
        
        operation.successCount = totalDeleted;
        operation.errorCount = totalErrors;
        operation.processedCount = leadIds.length;
        
        return {
            deleted: totalDeleted,
            errors: totalErrors,
            total: leadIds.length
        };
    }
    
    /**
     * Bulk export
     */
    async bulkExport(operation) {
        const { leadIds, data } = operation;
        const { format = 'excel', filters = {} } = data;
        
        this.updateProgress(operation.id, 20, 'Export hazırlanıyor...');
        
        try {
            const queryParams = new URLSearchParams({
                format: format,
                lead_ids: leadIds.join(','),
                ...filters
            });
            
            this.updateProgress(operation.id, 50, 'Dosya oluşturuluyor...');
            
            const response = await fetch(`/admin/leads/export?${queryParams}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            this.updateProgress(operation.id, 80, 'Dosya indiriliyor...');
            
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            
            a.href = url;
            a.download = `leads_bulk_${new Date().toISOString().split('T')[0]}.${format === 'excel' ? 'xlsx' : 'csv'}`;
            document.body.appendChild(a);
            a.click();
            
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            
            this.updateProgress(operation.id, 100, `${leadIds.length} lead export edildi`);
            
            operation.successCount = leadIds.length;
            operation.processedCount = leadIds.length;
            
            return {
                exported: leadIds.length,
                format: format,
                filename: a.download
            };
            
        } catch (error) {
            this.updateProgress(operation.id, 0, 'Export başarısız');
            throw error;
        }
    }
    
    /**
     * Progress tracking
     */
    updateProgress(operationId, progress, status) {
        const operation = this.activeOperations.get(operationId);
        
        if (operation) {
            operation.progress = Math.max(0, Math.min(100, progress));
            operation.status_message = status;
            
            this.emit('progressUpdated', {
                operationId,
                progress: operation.progress,
                status: status
            });
            
            // Call registered callbacks
            const callbacks = this.progressCallbacks.get(operationId);
            if (callbacks) {
                callbacks.forEach(callback => {
                    try {
                        callback(operation.progress, status);
                    } catch (error) {
                        console.error('Error in progress callback:', error);
                    }
                });
            }
        }
    }
    
    /**
     * Register progress callback
     */
    onProgress(operationId, callback) {
        if (!this.progressCallbacks.has(operationId)) {
            this.progressCallbacks.set(operationId, []);
        }
        
        this.progressCallbacks.get(operationId).push(callback);
    }
    
    /**
     * Remove progress callbacks for operation
     */
    clearProgressCallbacks(operationId) {
        this.progressCallbacks.delete(operationId);
    }
    
    /**
     * Get active operations
     */
    getActiveOperations() {
        return Array.from(this.activeOperations.values());
    }
    
    /**
     * Get operation by ID
     */
    getOperation(operationId) {
        return this.activeOperations.get(operationId);
    }
    
    /**
     * Cancel operation
     */
    cancelOperation(operationId) {
        const operation = this.activeOperations.get(operationId);
        
        if (operation && operation.status === 'pending') {
            operation.status = 'cancelled';
            operation.endTime = Date.now();
            operation.duration = operation.endTime - operation.startTime;
            
            this.activeOperations.delete(operationId);
            this.addToHistory(operation);
            
            this.emit('operationCancelled', operation);
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Operation history management
     */
    addToHistory(operation) {
        // Create a clean copy for history
        const historyEntry = {
            id: operation.id,
            type: operation.type,
            leadCount: operation.leadIds.length,
            status: operation.status,
            startTime: operation.startTime,
            endTime: operation.endTime,
            duration: operation.duration,
            processedCount: operation.processedCount,
            successCount: operation.successCount,
            errorCount: operation.errorCount,
            data: operation.data
        };
        
        this.operationHistory.unshift(historyEntry);
        
        // Limit history size
        if (this.operationHistory.length > this.maxHistorySize) {
            this.operationHistory = this.operationHistory.slice(0, this.maxHistorySize);
        }
        
        this.saveOperationHistory();
    }
    
    loadOperationHistory() {
        try {
            const saved = localStorage.getItem('bulk_operations_history');
            if (saved) {
                this.operationHistory = JSON.parse(saved);
            }
        } catch (error) {
            console.error('Error loading operation history:', error);
            this.operationHistory = [];
        }
    }
    
    saveOperationHistory() {
        try {
            localStorage.setItem('bulk_operations_history', JSON.stringify(this.operationHistory));
        } catch (error) {
            console.error('Error saving operation history:', error);
        }
    }
    
    getOperationHistory() {
        return [...this.operationHistory];
    }
    
    clearOperationHistory() {
        this.operationHistory = [];
        this.saveOperationHistory();
    }
    
    /**
     * Utility methods
     */
    generateOperationId() {
        return `bulk_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;
    }
    
    formatDuration(milliseconds) {
        const seconds = Math.floor(milliseconds / 1000);
        
        if (seconds < 60) {
            return `${seconds} saniye`;
        }
        
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        
        return `${minutes} dakika ${remainingSeconds} saniye`;
    }
    
    getActionTypeLabel(type) {
        const labels = {
            [this.actionTypes.UPDATE_STATUS]: 'Durum Güncelle',
            [this.actionTypes.ASSIGN_USER]: 'Kullanıcı Ata',
            [this.actionTypes.ADD_TAGS]: 'Etiket Ekle',
            [this.actionTypes.REMOVE_TAGS]: 'Etiket Kaldır',
            [this.actionTypes.UPDATE_PRIORITY]: 'Öncelik Güncelle',
            [this.actionTypes.DELETE]: 'Sil',
            [this.actionTypes.EXPORT]: 'Export',
            [this.actionTypes.MOVE_SOURCE]: 'Kaynak Değiştir',
            [this.actionTypes.UPDATE_SCORE]: 'Puan Güncelle'
        };
        
        return labels[type] || type;
    }
    
    /**
     * Event system
     */
    setupEventListeners() {
        // Listen for page unload to cancel active operations
        window.addEventListener('beforeunload', () => {
            this.getActiveOperations().forEach(operation => {
                this.cancelOperation(operation.id);
            });
        });
    }
    
    emit(eventName, data) {
        const event = new CustomEvent(`bulkAction:${eventName}`, {
            detail: data,
            bubbles: true
        });
        
        document.dispatchEvent(event);
    }
    
    on(eventName, callback) {
        document.addEventListener(`bulkAction:${eventName}`, (e) => {
            callback(e.detail);
        });
    }
    
    off(eventName, callback) {
        document.removeEventListener(`bulkAction:${eventName}`, callback);
    }
}

// Global instance
window.bulkActionManager = new BulkActionManager();

// Vanilla JS integration helpers
window.bulkActionHelpers = {
    // Execute bulk actions
    async bulkUpdateStatus(status, dataManager = null) {
        const manager = dataManager || window.leadsDataManagerInstance;
        
        if (!manager || manager.state.selectedLeads.length === 0) {
            console.warn('No data manager or selected leads found');
            return;
        }
        
        try {
            manager.setState({ bulkOperationInProgress: true });
            
            const operationId = await window.bulkActionManager.executeBulkAction(
                window.bulkActionManager.actionTypes.UPDATE_STATUS,
                manager.state.selectedLeads,
                { status }
            );
            
            // Track progress
            window.bulkActionManager.onProgress(operationId, (progress, statusMessage) => {
                manager.setState({
                    bulkOperationProgress: progress,
                    bulkOperationStatus: statusMessage
                });
            });
            
            // Wait for completion
            const operation = await this.waitForOperationCompletion(operationId);
            
            manager.showNotification(`${operation.successCount} lead durumu güncellendi`, 'success');
            await manager.loadLeads();
            manager.clearSelection();
            
        } catch (error) {
            manager.showNotification('Durum güncellenemedi: ' + error.message, 'error');
        } finally {
            manager.setState({ bulkOperationInProgress: false });
        }
    },
    
    async bulkAssign(adminId, dataManager = null) {
        const manager = dataManager || window.leadsDataManagerInstance;
        
        if (!manager || manager.state.selectedLeads.length === 0) {
            console.warn('No data manager or selected leads found');
            return;
        }
        
        try {
            manager.setState({ bulkOperationInProgress: true });
            
            const operationId = await window.bulkActionManager.executeBulkAction(
                window.bulkActionManager.actionTypes.ASSIGN_USER,
                manager.state.selectedLeads,
                { admin_id: adminId }
            );
            
            window.bulkActionManager.onProgress(operationId, (progress, statusMessage) => {
                manager.setState({
                    bulkOperationProgress: progress,
                    bulkOperationStatus: statusMessage
                });
            });
            
            const operation = await this.waitForOperationCompletion(operationId);
            
            manager.showNotification(`${operation.successCount} lead atandı`, 'success');
            await manager.loadLeads();
            manager.clearSelection();
            
        } catch (error) {
            manager.showNotification('Atama işlemi başarısız: ' + error.message, 'error');
        } finally {
            manager.setState({ bulkOperationInProgress: false });
        }
    },
    
    async bulkAddTag(tag, dataManager = null) {
        const manager = dataManager || window.leadsDataManagerInstance;
        
        if (!manager || manager.state.selectedLeads.length === 0) {
            console.warn('No data manager or selected leads found');
            return;
        }
        
        if (!tag || !tag.trim()) {
            manager.showNotification('Lütfen etiket girin', 'warning');
            return;
        }
        
        try {
            manager.setState({ bulkOperationInProgress: true });
            
            const operationId = await window.bulkActionManager.executeBulkAction(
                window.bulkActionManager.actionTypes.ADD_TAGS,
                manager.state.selectedLeads,
                { tags: [tag.trim()] }
            );
            
            window.bulkActionManager.onProgress(operationId, (progress, statusMessage) => {
                manager.setState({
                    bulkOperationProgress: progress,
                    bulkOperationStatus: statusMessage
                });
            });
            
            const operation = await this.waitForOperationCompletion(operationId);
            
            manager.showNotification(`"${tag}" etiketi ${operation.successCount} lead'e eklendi`, 'success');
            await manager.loadLeads();
            
        } catch (error) {
            manager.showNotification('Etiket eklenemedi: ' + error.message, 'error');
        } finally {
            manager.setState({ bulkOperationInProgress: false });
        }
    },
    
    confirmBulkDelete(dataManager = null) {
        const manager = dataManager || window.leadsDataManagerInstance;
        
        if (!manager || manager.state.selectedLeads.length === 0) {
            manager.showNotification('Lütfen lead seçin', 'warning');
            return;
        }
        
        manager.setState({ showBulkDeleteConfirm: true });
    },
    
    async executeBulkDelete(dataManager = null) {
        const manager = dataManager || window.leadsDataManagerInstance;
        
        manager.setState({ showBulkDeleteConfirm: false });
        
        try {
            manager.setState({ bulkOperationInProgress: true });
            
            const operationId = await window.bulkActionManager.executeBulkAction(
                window.bulkActionManager.actionTypes.DELETE,
                manager.state.selectedLeads
            );
            
            window.bulkActionManager.onProgress(operationId, (progress, statusMessage) => {
                manager.setState({
                    bulkOperationProgress: progress,
                    bulkOperationStatus: statusMessage
                });
            });
            
            const operation = await this.waitForOperationCompletion(operationId);
            
            manager.showNotification(`${operation.successCount} lead silindi`, 'success');
            await manager.loadLeads();
            manager.clearSelection();
            
        } catch (error) {
            manager.showNotification('Silme işlemi başarısız: ' + error.message, 'error');
        } finally {
            manager.setState({ bulkOperationInProgress: false });
        }
    },
    
    async exportSelectedLeads(dataManager = null) {
        const manager = dataManager || window.leadsDataManagerInstance;
        
        if (!manager || manager.state.selectedLeads.length === 0) {
            manager.showNotification('Lütfen export edilecek lead\'leri seçin', 'warning');
            return;
        }
        
        try {
            const operationId = await window.bulkActionManager.executeBulkAction(
                window.bulkActionManager.actionTypes.EXPORT,
                manager.state.selectedLeads,
                { format: 'excel', filters: manager.state.filters }
            );
            
            window.bulkActionManager.onProgress(operationId, (progress, statusMessage) => {
                // You could show a progress modal here
                console.log(`Export progress: ${progress}% - ${statusMessage}`);
            });
            
            const operation = await this.waitForOperationCompletion(operationId);
            
            manager.showNotification(`${operation.successCount} lead export edildi`, 'success');
            
        } catch (error) {
            manager.showNotification('Export işlemi başarısız: ' + error.message, 'error');
        }
    },
    
    // Wait for operation completion
    async waitForOperationCompletion(operationId) {
        return new Promise((resolve, reject) => {
            const checkOperation = () => {
                const operation = window.bulkActionManager.getOperation(operationId);
                
                if (!operation) {
                    // Operation completed, check history
                    const history = window.bulkActionManager.getOperationHistory();
                    const completed = history.find(h => h.id === operationId);
                    
                    if (completed) {
                        if (completed.status === 'completed') {
                            resolve(completed);
                        } else {
                            reject(new Error(completed.error || 'İşlem başarısız'));
                        }
                    } else {
                        reject(new Error('İşlem bulunamadı'));
                    }
                } else {
                    // Still active, check again
                    setTimeout(checkOperation, 500);
                }
            };
            
            checkOperation();
        });
    },
    
    // Get bulk operation history for display
    getBulkOperationHistory() {
        return window.bulkActionManager.getOperationHistory();
    },
    
    // Get active operations
    getActiveBulkOperations() {
        return window.bulkActionManager.getActiveOperations();
    },
    
    // Cancel active operation
    cancelBulkOperation(operationId, dataManager = null) {
        const manager = dataManager || window.leadsDataManagerInstance;
        
        if (window.bulkActionManager.cancelOperation(operationId)) {
            manager.showNotification('İşlem iptal edildi', 'info');
            manager.setState({ bulkOperationInProgress: false });
        }
    }
};

export default BulkActionManager;