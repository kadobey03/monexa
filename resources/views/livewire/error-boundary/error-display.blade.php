<div
    x-data="errorBoundary({
        error: @js($error),
        errorInfo: @js($errorInfo),
        errorType: @js($this->errorType),
        suggestions: @js($this->errorSuggestions),
        retryCount: @js($retryCount),
        maxRetries: @js($maxRetries)
    })"
    class="error-boundary-container"
    role="alert"
    aria-labelledby="error-title"
    aria-describedby="error-description error-suggestions"
    data-accessibility-enhanced="true"
>
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6 max-w-lg mx-auto">
        
        <!-- Error Icon with proper ARIA -->
        <div class="flex items-center justify-center mb-4" role="img" aria-label="Hata durumu">
            <div class="w-12 h-12 bg-red-100 dark:bg-red-800 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
        </div>

        <!-- Error Title -->
        <div class="text-center mb-4">
            <h3 id="error-title" class="text-lg font-semibold text-red-800 dark:text-red-200 mb-2" tabindex="-1">
                @lang('error.something_went_wrong')
            </h3>
            <div id="error-description" class="text-sm text-red-600 dark:text-red-400 font-mono" role="status" aria-live="polite">
                {{ $error }}
            </div>
        </div>

        <!-- Error Type Badge -->
        <div class="flex justify-center mb-4">
            <span
                class="error-type-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-200"
                role="status"
                :aria-label="'Hata türü: ' + errorType"
            >
                <svg class="w-3 h-3 mr-1" :class="getErrorIcon(errorType)" aria-hidden="true"></svg>
                <span x-text="errorType"></span>
            </span>
        </div>

        <!-- Error Suggestions -->
        <div id="error-suggestions" class="mb-6" role="region" aria-labelledby="error-suggestions-title">
            <h4 id="error-suggestions-title" class="text-sm font-medium text-red-700 dark:text-red-300 mb-2">
                @lang('error.suggestions'):
            </h4>
            <ul class="text-xs text-red-600 dark:text-red-400 space-y-1" role="list">
                <template x-for="(suggestion, index) in suggestions.tr" :key="index">
                    <li class="flex items-start" role="listitem">
                        <svg class="w-3 h-3 mr-2 mt-0.5 flex-shrink-0 text-red-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span x-text="suggestion"></span>
                    </li>
                </template>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col space-y-3" role="group" aria-label="Hata çözüm seçenekleri">
            
            <!-- Retry Button -->
            <button
                x-show="retryCount < maxRetries"
                @click="retry()"
                class="retry-button w-full inline-flex justify-center items-center px-4 py-2 border border-red-300 dark:border-red-600 text-sm font-medium rounded-md text-red-700 dark:text-red-300 bg-white dark:bg-red-900 hover:bg-red-50 dark:hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                aria-describedby="retry-button-help"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>@lang('error.retry') (<span x-text="retryCount"></span>/<span x-text="maxRetries"></span>)</span>
            </button>
            <div id="retry-button-help" class="sr-only">İşlemi tekrar deneyerek sorunu çözmeye çalışır</div>

            <!-- Refresh Page Button -->
            <button
                @click="refreshPage()"
                class="refresh-button w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                aria-describedby="refresh-button-help"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>@lang('error.refresh_page')</span>
            </button>
            <div id="refresh-button-help" class="sr-only">Sayfayı yenileyerek tüm durumu sıfırlar</div>

            <!-- Dismiss Button -->
            <button
                @click="resetError()"
                class="dismiss-button w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                aria-describedby="dismiss-button-help"
            >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span>@lang('error.dismiss')</span>
            </button>
            <div id="dismiss-button-help" class="sr-only">Bu hata mesajını kapatır ve devam eder</div>
        </div>

        <!-- Error Details (Collapsible) -->
        <div x-show="showDetails" x-collapse class="mt-4 pt-4 border-t border-red-200 dark:border-red-700" id="error-details">
            <div class="text-xs text-red-600 dark:text-red-400 space-y-2" role="region" aria-labelledby="error-details-title">
                <h5 id="error-details-title" class="text-xs font-medium text-red-700 dark:text-red-300 mb-2">Hata Detayları:</h5>
                <dl class="space-y-1">
                    <div class="flex">
                        <dt class="w-20 font-medium text-red-600 dark:text-red-400 mr-2">ID:</dt>
                        <dd class="text-red-600 dark:text-red-400" x-text="errorInfo?.request_id || 'N/A'"></dd>
                    </div>
                    <div class="flex">
                        <dt class="w-20 font-medium text-red-600 dark:text-red-400 mr-2">Zaman:</dt>
                        <dd class="text-red-600 dark:text-red-400" x-text="errorInfo?.timestamp || 'N/A'"></dd>
                    </div>
                    <div class="flex">
                        <dt class="w-20 font-medium text-red-600 dark:text-red-400 mr-2">Tür:</dt>
                        <dd class="text-red-600 dark:text-red-400" x-text="errorInfo?.type || 'N/A'"></dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-4 text-center">
            <button
                @click="showDetails = !showDetails"
                class="details-toggle text-xs text-red-500 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 underline focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 rounded px-2 py-1"
                :aria-expanded="showDetails.toString()"
                aria-controls="error-details"
            >
                <span x-show="!showDetails">@lang('error.show_details')</span>
                <span x-show="showDetails">@lang('error.hide_details')</span>
            </button>
        </div>
        
        <!-- Screen reader announcement for error state -->
        <div class="sr-only" id="error-announcements" aria-live="assertive" aria-label="Hata bildirimleri"></div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('errorBoundary', (props) => ({
        error: props.error,
        errorInfo: props.errorInfo,
        errorType: props.errorType,
        suggestions: props.suggestions,
        retryCount: props.retryCount,
        maxRetries: props.maxRetries,
        showDetails: false,

        init() {
            // Announce error to screen readers
            this.announceError();
            
            // Focus management
            this.manageFocus();
        },

        getErrorIcon(type) {
            const icons = {
                'financial': 'fa-wallet',
                'network': 'fa-wifi',
                'authentication': 'fa-lock',
                'validation': 'fa-exclamation-triangle',
                'server': 'fa-server',
                'unknown': 'fa-question-circle'
            };
            return icons[type] || icons.unknown;
        },

        announceError() {
            // Announce error to screen readers
            if (window.LiveAnnouncer) {
                const announcement = `Hata oluştu: ${this.error}. Hata türü: ${this.errorType}`;
                window.LiveAnnouncer.announce(announcement, 'modal', 'modal-announcements');
            }
            
            // Update ARIA announcements
            const announcements = document.getElementById('error-announcements');
            if (announcements) {
                announcements.textContent = `Hata oluştu: ${this.error}`;
            }
        },

        manageFocus() {
            // Focus on error title for screen readers
            this.$nextTick(() => {
                const errorTitle = document.getElementById('error-title');
                if (errorTitle) {
                    errorTitle.focus();
                }
            });
        },

        retry() {
            this.$wire.retryOperation();
            this.showNotification('Retrying operation...', 'info');
            
            // Announce retry action
            if (window.LiveAnnouncer) {
                window.LiveAnnouncer.announce(
                    `İşlem tekrar deniyor... Deneme ${this.retryCount + 1}/${this.maxRetries}`,
                    'status_update',
                    'notification-announcements'
                );
            }
        },

        refreshPage() {
            this.showNotification('Refreshing page...', 'info');
            window.location.reload();
        },

        resetError() {
            this.$wire.resetError();
            this.showNotification('Error dismissed', 'success');
            
            // Announce error dismissal
            if (window.LiveAnnouncer) {
                window.LiveAnnouncer.announce(
                    'Hata mesajı kapatıldı',
                    'status_update',
                    'notification-announcements'
                );
            }
        },

        showNotification(message, type = 'info') {
            console.log(`${type.toUpperCase()}: ${message}`);
            
            // Dispatch custom event for notification
            this.$dispatch('notify', {
                message: message,
                type: type
            });
            
            // Show visual notification for sighted users
            if (window.showNotification) {
                window.showNotification(message, type);
            }
        }
    }));
});

// Enhanced keyboard navigation for error boundary
document.addEventListener('DOMContentLoaded', function() {
    const errorContainer = document.querySelector('.error-boundary-container');
    if (errorContainer) {
        // Trap focus within error boundary
        if (window.AccessibilityUtils) {
            window.AccessibilityUtils.startFocusTrap(errorContainer, {
                initialFocus: '#error-title',
                trapStack: true
            });
        }
        
        // Escape key handling
        errorContainer.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const dismissButton = errorContainer.querySelector('.dismiss-button');
                if (dismissButton) {
                    dismissButton.click();
                }
            }
        });
    }
});
</script>
@endpush

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('errorBoundary', (props) => ({
        error: props.error,
        errorInfo: props.errorInfo,
        errorType: props.errorType,
        suggestions: props.suggestions,
        retryCount: props.retryCount,
        maxRetries: props.maxRetries,
        showDetails: false,

        getErrorIcon(type) {
            const icons = {
                'financial': 'fa-wallet',
                'network': 'fa-wifi',
                'authentication': 'fa-lock',
                'validation': 'fa-exclamation-triangle',
                'server': 'fa-server',
                'unknown': 'fa-question-circle'
            };
            return icons[type] || icons.unknown;
        },

        retry() {
            this.$wire.retryOperation();
            this.showNotification('Retrying operation...', 'info');
        },

        refreshPage() {
            window.location.reload();
        },

        resetError() {
            this.$wire.resetError();
            this.showNotification('Error dismissed', 'success');
        },

        showNotification(message, type = 'info') {
            // Integration with your notification system
            console.log(`${type.toUpperCase()}: ${message}`);
            
            // Example: dispatch custom event for notification
            this.$dispatch('notify', {
                message: message,
                type: type
            });
        }
    }));
});
</script>