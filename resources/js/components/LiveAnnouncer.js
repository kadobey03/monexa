/**
 * LiveAnnouncer Component - ARIA Live Regions Yöneticisi
 * 
 * Gerçek zamanlı bildirimleri screen reader'lara duyurur
 * ARIA live regions'ı yönetir ve günceller
 * Spam önleme ve debounce mekanizmaları içerir
 */

class LiveAnnouncer {
    constructor() {
        this.announcementQueue = [];
        this.processingQueue = false;
        this.debounceDelay = 100;
        this.maxQueueSize = 10;
        this.lastAnnouncement = null;
        this.supportedRegions = new Set();
        
        this.init();
    }

    /**
     * LiveAnnouncer'ı başlat
     */
    init() {
        this.createLiveRegions();
        this.bindEvents();
        this.setupMutationObserver();
        
        console.log('LiveAnnouncer initialized');
    }

    /**
     * Live regions'ları oluştur
     */
    createLiveRegions() {
        const regions = [
            { id: 'financial-announcements', priority: 'assertive' },
            { id: 'notification-announcements', priority: 'polite' },
            { id: 'form-error-announcements', priority: 'assertive' },
            { id: 'modal-announcements', priority: 'assertive' }
        ];

        regions.forEach(region => {
            this.createLiveRegion(region.id, region.priority);
            this.supportedRegions.add(region.id);
        });
    }

    /**
     * Tek bir live region oluştur
     */
    createLiveRegion(id, priority) {
        // Region zaten varsa güncelle
        let region = document.getElementById(id);
        if (!region) {
            region = document.createElement('div');
            region.id = id;
            document.body.appendChild(region);
        }

        // ARIA attributes ayarla
        region.setAttribute('aria-live', priority);
        region.setAttribute('aria-atomic', 'true');
        region.setAttribute('role', 'status');
        region.className = 'sr-only';
        
        // Bölgeye özel etiketler
        const labels = {
            'financial-announcements': 'Finansal veri bildirimleri',
            'notification-announcements': 'Sistem bildirimleri', 
            'form-error-announcements': 'Form hata mesajları',
            'modal-announcements': 'Modal pencere bildirimleri'
        };
        
        if (labels[id]) {
            region.setAttribute('aria-label', labels[id]);
        }

        return region;
    }

    /**
     * Announcement yap
     */
    announce(message, type = 'notification', regionId = null) {
        // Kuyruk limitini kontrol et
        if (this.announcementQueue.length >= this.maxQueueSize) {
            console.warn('Announcement queue full, dropping message');
            return false;
        }

        // Spam önleme
        if (this.isSpam(message, type)) {
            return false;
        }

        const announcement = {
            id: this.generateId(),
            message: this.sanitizeMessage(message),
            type,
            regionId: regionId || this.getDefaultRegionByType(type),
            timestamp: Date.now(),
            processed: false
        };

        this.announcementQueue.push(announcement);
        this.scheduleProcessing();
        
        return announcement.id;
    }

    /**
     * Finansal veri güncelleme announcement'ı
     */
    announceFinancialUpdate(symbol, oldValue, newValue, change = null) {
        let message;
        const locale = this.getUserLocale();
        
        if (locale === 'tr') {
            const direction = newValue > oldValue ? 'arttı' : (newValue < oldValue ? 'azaldı' : 'değişmedi');
            message = `${symbol} fiyatı ${oldValue} değerinden ${newValue} değerine ${direction}`;
            if (change) {
                message += ` (%${change})`;
            }
        } else {
            const direction = newValue > oldValue ? 'increased to' : (newValue < oldValue ? 'decreased to' : 'remained at');
            message = `${symbol} price ${direction} ${newValue}`;
            if (change) {
                message += ` (${change}%)`;
            }
        }

        return this.announce(message, 'price_update', 'financial-announcements');
    }

    /**
     * Balance güncelleme announcement'ı
     */
    announceBalanceUpdate(oldBalance, newBalance, currency = 'USD') {
        const locale = this.getUserLocale();
        const change = newBalance - oldBalance;
        let message;
        
        if (locale === 'tr') {
            const changeText = change > 0 
                ? `artışla ${number_format(change, 2)} ${currency}`
                : `azalışla ${number_format(Math.abs(change), 2)} ${currency}`;
            message = `Hesap bakiyeniz ${number_format(oldBalance, 2)} ${currency}'den ${number_format(newBalance, 2)} ${currency}'ye ${changeText} güncellendi`;
        } else {
            const changeText = change > 0 
                ? `increased by ${number_format(change, 2)} ${currency}`
                : `decreased by ${number_format(Math.abs(change), 2)} ${currency}`;
            message = `Your account balance has been updated from ${number_format(oldBalance, 2)} ${currency} to ${number_format(newBalance, 2)} ${currency}, ${changeText}`;
        }

        return this.announce(message, 'financial', 'financial-announcements');
    }

    /**
     * Transaction başarı announcement'ı
     */
    announceTransactionSuccess(type, amount, currency = 'USD') {
        const locale = this.getUserLocale();
        let message;
        
        if (locale === 'tr') {
            const typeText = type === 'deposit' ? 'yatırma' : (type === 'withdrawal' ? 'çekme' : 'işlem');
            message = `${typeText} işleminiz başarıyla tamamlandı. ${amount} ${currency} işleme alındı.`;
        } else {
            const typeText = type === 'deposit' ? 'deposit' : (type === 'withdrawal' ? 'withdrawal' : 'transaction');
            message = `Your ${typeText} has been completed successfully. ${amount} ${currency} has been processed.`;
        }

        return this.announce(message, 'status_update', 'notification-announcements');
    }

    /**
     * Form error announcement'ı
     */
    announceFormError(field, error) {
        const locale = this.getUserLocale();
        let message;
        
        if (locale === 'tr') {
            message = `${field} alanında hata: ${error}`;
        } else {
            message = `Error in ${field} field: ${error}`;
        }

        return this.announce(message, 'form_error', 'form-error-announcements');
    }

    /**
     * Form success announcement'ı
     */
    announceFormSuccess(action) {
        const locale = this.getUserLocale();
        let message;
        
        if (locale === 'tr') {
            message = `${action} işlemi başarıyla tamamlandı.`;
        } else {
            message = `${action} completed successfully.`;
        }

        return this.announce(message, 'form_success', 'notification-announcements');
    }

    /**
     * Modal açılma announcement'ı
     */
    announceModalOpen(title) {
        const locale = this.getUserLocale();
        let message;
        
        if (locale === 'tr') {
            message = `${title} penceresi açıldı. İçeriğe odaklanmak için Tab tuşuna basın.`;
        } else {
            message = `${title} dialog opened. Press Tab to focus on content.`;
        }

        return this.announce(message, 'modal', 'modal-announcements');
    }

    /**
     * Kuyruktaki announcement'ları işle
     */
    processQueue() {
        if (this.processingQueue || this.announcementQueue.length === 0) {
            return;
        }

        this.processingQueue = true;
        const announcement = this.announcementQueue.shift();
        
        this.updateLiveRegion(announcement).then(() => {
            this.processingQueue = false;
            
            // Bir sonraki announcement'ı işle
            if (this.announcementQueue.length > 0) {
                setTimeout(() => this.processQueue(), this.debounceDelay);
            }
        });
    }

    /**
     * Live region'ı güncelle
     */
    async updateLiveRegion(announcement) {
        const region = document.getElementById(announcement.regionId);
        if (!region) {
            console.warn(`Live region ${announcement.regionId} not found`);
            return;
        }

        try {
            // Region'ı temizle
            region.innerHTML = '';
            
            // Yeni announcement'ı ekle
            const announcementEl = document.createElement('div');
            announcementEl.textContent = announcement.message;
            announcementEl.setAttribute('data-announcement-id', announcement.id);
            announcementEl.setAttribute('data-announcement-type', announcement.type);
            region.appendChild(announcementEl);

            this.lastAnnouncement = announcement;
            
            console.log(`Announcement processed: ${announcement.message} (${announcement.type})`);
        } catch (error) {
            console.error('Error updating live region:', error);
        }
    }

    /**
     * Event listeners bağla
     */
    bindEvents() {
        // Livewire events'leri dinle
        if (window.Livewire) {
            Livewire.on('accessibility-announcement', (data) => {
                this.announce(data.message, data.type, data.regionId);
            });

            Livewire.on('financial-update', (data) => {
                this.announceFinancialUpdate(data.symbol, data.oldValue, data.newValue, data.change);
            });

            Livewire.on('balance-update', (data) => {
                this.announceBalanceUpdate(data.oldBalance, data.newBalance, data.currency);
            });

            Livewire.on('transaction-update', (data) => {
                if (data.success) {
                    this.announceTransactionSuccess(data.type, data.amount, data.currency);
                }
            });

            Livewire.on('form-error', (data) => {
                this.announceFormError(data.field, data.error);
            });

            Livewire.on('form-success', (data) => {
                this.announceFormSuccess(data.action);
            });

            Livewire.on('modal-open', (data) => {
                this.announceModalOpen(data.title);
            });
        }

        // Custom events
        document.addEventListener('accessibility-announce', (event) => {
            const { message, type, regionId } = event.detail;
            this.announce(message, type, regionId);
        });
    }

    /**
     * DOM değişikliklerini gözlemle
     */
    setupMutationObserver() {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    this.checkForAccessibilityChanges(mutation.addedNodes);
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }

    /**
     * Accessibility değişikliklerini kontrol et
     */
    checkForAccessibilityChanges(nodes) {
        nodes.forEach((node) => {
            if (node.nodeType === Node.ELEMENT_NODE) {
                // Form validation error'ları kontrol et
                if (node.classList.contains('error') || node.querySelector('.error')) {
                    this.handleFormError(node);
                }

                // Success mesajlarını kontrol et
                if (node.classList.contains('success') || node.querySelector('.success')) {
                    this.handleSuccessMessage(node);
                }

                // Modal'ları kontrol et
                if (node.classList.contains('modal') || node.getAttribute('role') === 'dialog') {
                    this.handleModalChange(node);
                }
            }
        });
    }

    /**
     * Form error'larını işle
     */
    handleFormError(node) {
        const errorElement = node.classList.contains('error') ? node : node.querySelector('.error');
        if (errorElement && !errorElement.hasAttribute('data-accessibility-processed')) {
            const fieldName = errorElement.previousElementSibling?.textContent || 'Form field';
            const errorMessage = errorElement.textContent;
            
            this.announceFormError(fieldName, errorMessage);
            errorElement.setAttribute('data-accessibility-processed', 'true');
        }
    }

    /**
     * Success mesajlarını işle
     */
    handleSuccessMessage(node) {
        const successElement = node.classList.contains('success') ? node : node.querySelector('.success');
        if (successElement && !successElement.hasAttribute('data-accessibility-processed')) {
            const message = successElement.textContent;
            this.announce(message, 'form_success', 'notification-announcements');
            successElement.setAttribute('data-accessibility-processed', 'true');
        }
    }

    /**
     * Modal değişikliklerini işle
     */
    handleModalChange(node) {
        if (!node.hasAttribute('data-accessibility-processed')) {
            const title = node.querySelector('h1, h2, h3, .modal-title')?.textContent || 'Modal';
            this.announceModalOpen(title);
            node.setAttribute('data-accessibility-processed', 'true');
        }
    }

    /**
     * Spam kontrolü yap
     */
    isSpam(message, type) {
        if (!this.lastAnnouncement) return false;
        
        const timeDiff = Date.now() - this.lastAnnouncement.timestamp;
        const isSameMessage = this.lastAnnouncement.message === message;
        const isSameType = this.lastAnnouncement.type === type;
        
        // Aynı mesaj 3 saniyeden kısa sürede tekrar gönderilmiş mi?
        return isSameMessage && isSameType && timeDiff < 3000;
    }

    /**
     * Mesajı sanitize et
     */
    sanitizeMessage(message) {
        return message
            .replace(/[<>]/g, '') // HTML tag'leri temizle
            .replace(/\s+/g, ' ') // Çoklu boşlukları temizle
            .trim()
            .substring(0, 200); // Maksimum uzunluk sınırla
    }

    /**
     * Type'a göre varsayılan region belirle
     */
    getDefaultRegionByType(type) {
        const mapping = {
            'financial': 'financial-announcements',
            'price_update': 'financial-announcements',
            'notification': 'notification-announcements',
            'status_update': 'notification-announcements',
            'form_error': 'form-error-announcements',
            'form_success': 'notification-announcements',
            'modal': 'modal-announcements'
        };
        
        return mapping[type] || 'notification-announcements';
    }

    /**
     * Kullanıcının locale'ini al
     */
    getUserLocale() {
        return document.documentElement.lang || 'en';
    }

    /**
     * Unique ID oluştur
     */
    generateId() {
        return 'announcement_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }

    /**
     * Kuyruktaki announcement'ları planla
     */
    scheduleProcessing() {
        if (!this.processingQueue) {
            setTimeout(() => this.processQueue(), this.debounceDelay);
        }
    }

    /**
     * Queue'yu temizle
     */
    clearQueue() {
        this.announcementQueue = [];
        console.log('Announcement queue cleared');
    }

    /**
     * LiveAnnouncer'ı sıfırla
     */
    reset() {
        this.clearQueue();
        this.lastAnnouncement = null;
        
        // Live regions'ları temizle
        this.supportedRegions.forEach(regionId => {
            const region = document.getElementById(regionId);
            if (region) {
                region.innerHTML = '';
            }
        });
    }

    /**
     * Live regions'ı getir
     */
    getLiveRegions() {
        return Array.from(this.supportedRegions).map(regionId => ({
            id: regionId,
            element: document.getElementById(regionId)
        }));
    }

    /**
     * Queue durumunu al
     */
    getQueueStatus() {
        return {
            queueLength: this.announcementQueue.length,
            processing: this.processingQueue,
            lastAnnouncement: this.lastAnnouncement
        };
    }
}

/**
 * Helper fonksiyonu - sayı formatı
 */
function number_format(number, decimals = 2, decimal = '.', thousands = ',') {
    number = parseFloat(number);
    if (isNaN(number)) return '0';
    
    const formatted = number.toFixed(decimals);
    return formatted.replace(/\B(?=(\d{3})+(?!\d))/g, thousands);
}

// Global instance
window.LiveAnnouncer = new LiveAnnouncer();

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = LiveAnnouncer;
}

// Make it available globally
if (typeof window !== 'undefined') {
    window.LiveAnnouncerInstance = window.LiveAnnouncer;
}