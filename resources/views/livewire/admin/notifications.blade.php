<div class="notifications-container space-y-2"
     role="region"
     aria-label="Admin bildirimler listesi"
     data-notifications-count="{{ $notifications->count() }}"
     data-accessibility-enhanced="true">
    
    <h3 class="sr-only">Bildirimler</h3>
    
    @forelse ($notifications as $item)
        <article
            class="notification-item px-4 py-3 border-b border-admin-200 dark:border-admin-700 last:border-b-0 {{ !$item->is_read ? 'bg-admin-50 dark:bg-admin-700' : '' }} hover:bg-admin-100 dark:hover:bg-admin-600 transition-colors"
            role="listitem"
            aria-labelledby="notification-title-{{ $item->id }}"
            aria-describedby="notification-message-{{ $item->id }}"
            data-notification-id="{{ $item->id }}"
            data-read="{{ $item->is_read ? 'true' : 'false' }}"
            tabindex="0"
            >
            
            <header class="flex justify-between items-start mb-2">
                <h5
                    id="notification-title-{{ $item->id }}"
                    class="text-sm font-medium text-admin-900 dark:text-admin-100 mb-1 notification-title">
                    {{ $item->title }}
                    @if(!$item->is_read)
                        <span class="sr-only">(okunmamış)</span>
                        <span aria-hidden="true" class="ml-2 w-2 h-2 bg-blue-600 rounded-full inline-block"></span>
                    @endif
                </h5>
                
                <time
                    class="text-xs text-admin-500 dark:text-admin-400 ml-2 whitespace-nowrap notification-time"
                    datetime="{{ $item->created_at->toIso8601String() }}"
                    aria-label="Bildirim zamanı: {{ $item->created_at->diffForHumans() }}">
                    {{ $item->created_at->diffForHumans() }}
                </time>
            </header>
            
            <div class="flex flex-col mb-3">
                <p
                    id="notification-message-{{ $item->id }}"
                    class="text-sm text-admin-600 dark:text-admin-400 notification-message">
                    {{ $item->message }}
                </p>
            </div>
            
            <nav class="flex justify-end items-center mt-2 gap-2"
                 role="group"
                 aria-label="Bildirim işlemleri">
                
                @if (!$item->is_read)
                    <button
                        wire:click.prevent="markAsRead('{{ $item->id }}')"
                        class="notification-action-btn p-1 text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 rounded"
                        aria-label="Bildirimi okundu olarak işaretle: {{ $item->title }}"
                        title="Mark as read">
                        <i class="bi bi-eye text-lg" aria-hidden="true"></i>
                        <span class="sr-only">Okundu olarak işaretle</span>
                    </button>
                @endif
                
                <button
                    wire:click.prevent="deleteNotification('{{ $item->id }}')"
                    class="notification-action-btn p-1 text-red-600 hover:text-red-800 dark:hover:text-red-400 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 rounded"
                    aria-label="Bildirimi sil: {{ $item->title }}"
                    title="Delete notification">
                    <i class="bi bi-trash text-lg" aria-hidden="true"></i>
                    <span class="sr-only">Sil</span>
                </button>
            </nav>
        </article>
        
        @if ($loop->last)
            <div class="notification-footer text-center p-3">
                <button
                    wire:click.prevent="markAllAsRead"
                    class="mark-all-btn inline-flex items-center px-3 py-2 text-sm text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded"
                    aria-label="Tüm bildirimleri okundu olarak işaretle"
                    title="Mark all as read">
                    <i class="bi bi-eye mr-2" aria-hidden="true"></i>
                    Tümünü okundu olarak işaretle
                </button>
            </div>
        @endif
    @empty
        <div class="empty-notifications px-8 py-8 text-center" role="status" aria-live="polite">
            <i class="bi bi-bell-slash text-6xl text-admin-400 dark:text-admin-500 mb-4" aria-hidden="true"></i>
            <h4 class="text-lg font-medium text-admin-500 dark:text-admin-400 mb-2">Bildirim bulunamadı</h4>
            <p class="text-admin-500 dark:text-admin-400">Henüz yeni bildiriminiz bulunmuyor.</p>
            <span class="sr-only">Bildirimler listesi boş</span>
        </div>
    @endforelse
    
    <!-- Screen reader announcements -->
    <div class="sr-only" id="notifications-announcements" aria-live="polite" aria-label="Bildirim güncellemeleri"></div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const notificationsContainer = document.querySelector('.notifications-container');
    
    if (notificationsContainer && window.LiveAnnouncer) {
        // Listen for Livewire events
        document.addEventListener('livewire:load', function() {
            // Notification added
            window.Livewire.on('notificationAdded', (data) => {
                const notification = data.notification;
                window.LiveAnnouncer.announce(
                    `Yeni bildirim eklendi: ${notification.title}`,
                    'notification',
                    'notification-announcements'
                );
            });
            
            // Notification marked as read
            window.Livewire.on('notificationMarkedAsRead', (data) => {
                window.LiveAnnouncer.announce(
                    `Bildirim okundu olarak işaretlendi: ${data.title}`,
                    'status_update',
                    'notification-announcements'
                );
            });
            
            // Notification deleted
            window.Livewire.on('notificationDeleted', (data) => {
                window.LiveAnnouncer.announce(
                    `Bildirim silindi: ${data.title}`,
                    'status_update',
                    'notification-announcements'
                );
            });
            
            // All notifications marked as read
            window.Livewire.on('allNotificationsMarkedAsRead', () => {
                window.LiveAnnouncer.announce(
                    'Tüm bildirimler okundu olarak işaretlendi',
                    'status_update',
                    'notification-announcements'
                );
            });
        });
    }
});
</script>
@endpush
