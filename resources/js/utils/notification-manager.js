/**
 * Notification Manager - Modern Toast System
 * SweetAlert2 ve vanilla JS toast sistemini birleştiren modern bildirim yöneticisi
 */

class ModernNotificationManager {
    constructor() {
        this.container = null;
        this.notifications = [];
        this.defaultOptions = {
            duration: 5000,
            position: 'top-right',
            showClose: true,
            pauseOnHover: true,
            animation: 'slide-in',
            maxNotifications: 5
        };
        this.initialized = false;
    }

    /**
     * Initialize the notification system
     */
    init() {
        if (this.initialized) return;

        this.createContainer();
        this.setupStyles();
        this.initialized = true;
        
        console.log('✅ Notification Manager initialized');
    }

    /**
     * Create the notifications container
     */
    createContainer() {
        this.container = document.createElement('div');
        this.container.id = 'notification-container';
        this.container.className = 'fixed top-4 right-4 z-50 flex flex-col gap-3 max-w-sm';
        document.body.appendChild(this.container);
    }

    /**
     * Setup CSS styles for notifications
     */
    setupStyles() {
        if (document.getElementById('notification-styles')) return;

        const styles = document.createElement('style');
        styles.id = 'notification-styles';
        styles.textContent = `
            .notification {
                transform: translateX(100%);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                opacity: 0;
            }
            
            .notification.show {
                transform: translateX(0);
                opacity: 1;
            }
            
            .notification.hide {
                transform: translateX(100%);
                opacity: 0;
            }
            
            .notification-progress {
                position: absolute;
                bottom: 0;
                left: 0;
                height: 3px;
                background: rgba(255, 255, 255, 0.3);
                transition: width linear;
            }
        `;
        document.head.appendChild(styles);
    }

    /**
     * Show a notification
     */
    show(message, type = 'info', options = {}) {
        if (!this.initialized) this.init();

        const config = { ...this.defaultOptions, ...options };
        const id = this.generateId();
        
        const notification = this.createNotificationElement(id, message, type, config);
        this.notifications.push({ id, element: notification, config });
        
        // Limit max notifications
        if (this.notifications.length > config.maxNotifications) {
            this.remove(this.notifications[0].id);
        }
        
        this.container.appendChild(notification);
        
        // Trigger show animation
        setTimeout(() => notification.classList.add('show'), 10);
        
        // Auto-hide if duration is set
        if (config.duration > 0) {
            this.startAutoHide(id, config.duration);
        }
        
        return id;
    }

    /**
     * Create notification element
     */
    createNotificationElement(id, message, type, config) {
        const notification = document.createElement('div');
        notification.id = `notification-${id}`;
        notification.className = `notification p-4 rounded-lg shadow-lg border-l-4 ${this.getTypeClasses(type)} cursor-pointer`;
        
        const content = `
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    ${this.getTypeIcon(type)}
                </div>
                <div class="ml-3 flex-1">
                    <div class="text-sm font-medium">
                        ${message}
                    </div>
                </div>
                ${config.showClose ? `
                    <div class="flex-shrink-0 ml-4">
                        <button class="notification-close text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                ` : ''}
            </div>
            ${config.duration > 0 ? '<div class="notification-progress"></div>' : ''}
        `;
        
        notification.innerHTML = content;
        
        // Add event listeners
        this.setupNotificationEvents(notification, id, config);
        
        return notification;
    }

    /**
     * Setup event listeners for notification
     */
    setupNotificationEvents(notification, id, config) {
        // Close button
        const closeBtn = notification.querySelector('.notification-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                this.remove(id);
            });
        }
        
        // Click to dismiss
        notification.addEventListener('click', () => this.remove(id));
        
        // Pause on hover
        if (config.pauseOnHover && config.duration > 0) {
            notification.addEventListener('mouseenter', () => this.pauseAutoHide(id));
            notification.addEventListener('mouseleave', () => this.resumeAutoHide(id));
        }
    }

    /**
     * Start auto-hide timer
     */
    startAutoHide(id, duration) {
        const notificationData = this.notifications.find(n => n.id === id);
        if (!notificationData) return;

        const progressBar = notificationData.element.querySelector('.notification-progress');
        
        notificationData.timer = setTimeout(() => this.remove(id), duration);
        notificationData.startTime = Date.now();
        notificationData.duration = duration;
        
        if (progressBar) {
            progressBar.style.width = '100%';
            progressBar.style.transitionDuration = `${duration}ms`;
            setTimeout(() => {
                progressBar.style.width = '0%';
            }, 10);
        }
    }

    /**
     * Pause auto-hide timer
     */
    pauseAutoHide(id) {
        const notificationData = this.notifications.find(n => n.id === id);
        if (!notificationData || !notificationData.timer) return;

        clearTimeout(notificationData.timer);
        notificationData.remainingTime = notificationData.duration - (Date.now() - notificationData.startTime);
        
        const progressBar = notificationData.element.querySelector('.notification-progress');
        if (progressBar) {
            progressBar.style.transitionDuration = '0ms';
        }
    }

    /**
     * Resume auto-hide timer
     */
    resumeAutoHide(id) {
        const notificationData = this.notifications.find(n => n.id === id);
        if (!notificationData || !notificationData.remainingTime) return;

        const progressBar = notificationData.element.querySelector('.notification-progress');
        if (progressBar) {
            const remainingPercent = (notificationData.remainingTime / notificationData.duration) * 100;
            progressBar.style.width = `${remainingPercent}%`;
            progressBar.style.transitionDuration = `${notificationData.remainingTime}ms`;
            
            setTimeout(() => {
                progressBar.style.width = '0%';
            }, 10);
        }

        notificationData.timer = setTimeout(() => this.remove(id), notificationData.remainingTime);
        notificationData.startTime = Date.now();
        notificationData.duration = notificationData.remainingTime;
        delete notificationData.remainingTime;
    }

    /**
     * Remove a notification
     */
    remove(id) {
        const index = this.notifications.findIndex(n => n.id === id);
        if (index === -1) return;

        const notificationData = this.notifications[index];
        const element = notificationData.element;

        // Clear timer
        if (notificationData.timer) {
            clearTimeout(notificationData.timer);
        }

        // Hide animation
        element.classList.add('hide');
        
        setTimeout(() => {
            if (element.parentNode) {
                element.parentNode.removeChild(element);
            }
        }, 300);

        this.notifications.splice(index, 1);
    }

    /**
     * Clear all notifications
     */
    clear() {
        this.notifications.forEach(notification => {
            this.remove(notification.id);
        });
    }

    /**
     * Convenience methods for different types
     */
    success(message, options = {}) {
        return this.show(message, 'success', options);
    }

    error(message, options = {}) {
        return this.show(message, 'error', { ...options, duration: 0 }); // Errors don't auto-hide
    }

    warning(message, options = {}) {
        return this.show(message, 'warning', options);
    }

    info(message, options = {}) {
        return this.show(message, 'info', options);
    }

    /**
     * SweetAlert2 integration for complex dialogs
     */
    async confirm(title, text, options = {}) {
        if (!window.Swal) {
            console.warn('SweetAlert2 not available, falling back to native confirm');
            return confirm(`${title}\n\n${text}`);
        }

        const result = await window.Swal.fire({
            title: title,
            text: text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Evet',
            cancelButtonText: 'İptal',
            reverseButtons: true,
            ...options
        });

        return result.isConfirmed;
    }

    async alert(title, text, type = 'info', options = {}) {
        if (!window.Swal) {
            console.warn('SweetAlert2 not available, falling back to native alert');
            return alert(`${title}\n\n${text}`);
        }

        return await window.Swal.fire({
            title: title,
            text: text,
            icon: type,
            confirmButtonText: 'Tamam',
            ...options
        });
    }

    /**
     * Helper methods
     */
    getTypeClasses(type) {
        const classes = {
            success: 'bg-green-50 border-green-400 text-green-800',
            error: 'bg-red-50 border-red-400 text-red-800',
            warning: 'bg-yellow-50 border-yellow-400 text-yellow-800',
            info: 'bg-blue-50 border-blue-400 text-blue-800'
        };
        return classes[type] || classes.info;
    }

    getTypeIcon(type) {
        const icons = {
            success: '<svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
            error: '<svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>',
            warning: '<svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
            info: '<svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>'
        };
        return icons[type] || icons.info;
    }

    generateId() {
        return Date.now() + Math.random().toString(36).substr(2, 9);
    }

    /**
     * Cleanup resources
     */
    cleanup() {
        this.clear();
        
        if (this.container && this.container.parentNode) {
            this.container.parentNode.removeChild(this.container);
        }
        
        const styles = document.getElementById('notification-styles');
        if (styles && styles.parentNode) {
            styles.parentNode.removeChild(styles);
        }
        
        this.initialized = false;
        console.log('🧹 Notification Manager cleaned up');
    }
}

// Create singleton instance
const NotificationManager = new ModernNotificationManager();

// Global convenience functions
window.showToast = (message, type = 'info', options = {}) => NotificationManager.show(message, type, options);
window.showSuccess = (message, options = {}) => NotificationManager.success(message, options);
window.showError = (message, options = {}) => NotificationManager.error(message, options);
window.showWarning = (message, options = {}) => NotificationManager.warning(message, options);
window.showInfo = (message, options = {}) => NotificationManager.info(message, options);
window.confirmAction = (title, text, options = {}) => NotificationManager.confirm(title, text, options);
window.showAlert = (title, text, type = 'info', options = {}) => NotificationManager.alert(title, text, type, options);

export { NotificationManager };
export default NotificationManager;