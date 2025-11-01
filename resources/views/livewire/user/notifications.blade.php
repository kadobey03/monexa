<div class="user-notifications-container"
     role="region"
     aria-label="Kullanıcı bildirimleri listesi"
     data-notifications-count="{{ $notifications->count() }}"
     data-accessibility-enhanced="true">
    
    <h3 class="sr-only">Bildirimler</h3>
    
    @forelse ($notifications as $item)
        <article
            class="notification-item list-group-item list-group-item-action {{ !$item->is_read ? 'bg-light' : '' }} {{ $item->is_read ? 'opacity-75' : '' }}"
            role="listitem"
            aria-labelledby="user-notification-title-{{ $item->id }}"
            aria-describedby="user-notification-message-{{ $item->id }}"
            data-notification-id="{{ $item->id }}"
            data-read="{{ $item->is_read ? 'true' : 'false' }}"
            tabindex="0"
            >
            
            <header class="d-flex w-100 justify-content-between align-items-start mb-2">
                <h5
                    id="user-notification-title-{{ $item->id }}"
                    class="mb-1 user-notification-title {{ !$item->is_read ? 'font-weight-bold' : '' }}">
                    {{ $item->title }}
                    @if(!$item->is_read)
                        <span class="sr-only">(okunmamış bildirim)</span>
                        <span aria-hidden="true" class="ml-2 badge badge-primary badge-pill">Yeni</span>
                    @endif
                </h5>
                
                <small
                    class="text-muted user-notification-time"
                    datetime="{{ $item->created_at->toIso8601String() }}"
                    aria-label="Bildirim zamanı: {{ $item->created_at->diffForHumans() }}">
                    {{ $item->created_at->diffForHumans() }}
                </small>
            </header>
            
            <div class="d-flex flex-column mb-3">
                <p
                    id="user-notification-message-{{ $item->id }}"
                    class="text-secondary user-notification-message mb-0">
                    {{ $item->message }}
                </p>
            </div>
            
            <nav class="d-flex justify-content-end align-items-center"
                 role="group"
                 aria-label="Bildirim işlemleri">
                
                @if (!$item->is_read)
                    <div class="mr-2">
                        <button
                            wire:click.prevent="markAsRead('{{ $item->id }}')"
                            class="notification-action-btn user-notification-read-btn btn btn-link p-0 text-decoration-none"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            data-bs-title="Mark as read"
                            aria-label="Bildirimi okundu olarak işaretle: {{ $item->title }}">
                            <i class="bi bi-eye fs-3 text-primary" aria-hidden="true"></i>
                            <span class="sr-only">Okundu olarak işaretle</span>
                        </button>
                    </div>
                @endif
                
                <div>
                    <button
                        wire:click.prevent="deleteNotification('{{ $item->id }}')"
                        class="notification-action-btn user-notification-delete-btn btn btn-link p-0 text-decoration-none"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        data-bs-title="Delete notification"
                        aria-label="Bildirimi sil: {{ $item->title }}">
                        <i class="bi bi-trash fs-3 text-danger" aria-hidden="true"></i>
                        <span class="sr-only">Sil</span>
                    </button>
                </div>
            </nav>
        </article>
        
        @if ($loop->last)
            <div class="user-notification-footer text-center p-3" role="navigation" aria-label="Bildirim toplu işlemleri">
                <button
                    wire:click.prevent="markAllAsRead"
                    class="mark-all-btn btn btn-outline-primary user-mark-all-btn"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    data-bs-title="Mark all as read"
                    aria-label="Tüm bildirimleri okundu olarak işaretle">
                    <i class="bi bi-eye fs-4 mr-2" aria-hidden="true"></i>
                    Tümünü okundu olarak işaretle
                </button>
            </div>
        @endif
    @empty
        <div class="empty-user-notifications text-center py-5 mt-5" role="status" aria-live="polite">
            <i class="bi bi-bell-slash fs-1 text-secondary mb-3" aria-hidden="true"></i>
            <h4 class="h5 text-secondary mb-2">Bildirim bulunamadı</h4>
            <p class="text-secondary">Henüz bildiriminiz bulunmuyor.</p>
            <span class="sr-only">Bildirimler listesi boş</span>
        </div>
    @endforelse
    
    <!-- Screen reader announcements -->
    <div class="sr-only" id="user-notifications-announcements" aria-live="polite" aria-label="Kullanıcı bildirim güncellemeleri"></div>
    
    <!-- Navigation helper for screen readers -->
    <nav class="sr-only" aria-label="Bildirim listesi navigasyonu">
        <p>Toplam {{ $notifications->count() }} bildirim bulundu.</p>
        @if($notifications->where('is_read', false)->count() > 0)
            <p>{{ $notifications->where('is_read', false)->count() }} okunmamış bildirim var.</p>
        @else
            <p>Tüm bildirimler okundu.</p>
        @endif
    </nav>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const notificationsContainer = document.querySelector('.user-notifications-container');
    
    if (notificationsContainer && window.LiveAnnouncer) {
        // Initialize Bootstrap tooltips with accessibility
        if (typeof bootstrap !== 'undefined') {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    animation: false,
                    delay: { show: 0, hide: 100 }
                });
            });
        }
        
        // Listen for Livewire events
        document.addEventListener('livewire:load', function() {
            // Notification added
            window.Livewire.on('userNotificationAdded', (data) => {
                const notification = data.notification;
                window.LiveAnnouncer.announce(
                    `Yeni bildirim eklendi: ${notification.title}`,
                    'notification',
                    'notification-announcements'
                );
                
                // Update screen reader navigation info
                const nav = notificationsContainer.querySelector('nav[aria-label="Bildirim listesi navigasyonu"] p:last-child');
                if (nav) {
                    nav.textContent = `${notification.count} bildirim bulundu.`;
                }
            });
            
            // Notification marked as read
            window.Livewire.on('userNotificationMarkedAsRead', (data) => {
                window.LiveAnnouncer.announce(
                    `Bildirim okundu olarak işaretlendi: ${data.title}`,
                    'status_update',
                    'notification-announcements'
                );
            });
            
            // Notification deleted
            window.Livewire.on('userNotificationDeleted', (data) => {
                window.LiveAnnouncer.announce(
                    `Bildirim silindi: ${data.title}`,
                    'status_update',
                    'notification-announcements'
                );
            });
            
            // All notifications marked as read
            window.Livewire.on('userAllNotificationsMarkedAsRead', () => {
                window.LiveAnnouncer.announce(
                    'Tüm bildirimler okundu olarak işaretlendi',
                    'status_update',
                    'notification-announcements'
                );
                
                // Update navigation info
                const nav = notificationsContainer.querySelector('nav[aria-label="Bildirim listesi navigasyonu"]');
                if (nav) {
                    const ps = nav.querySelectorAll('p');
                    if (ps.length >= 2) {
                        ps[1].textContent = 'Tüm bildirimler okundu.';
                    }
                }
            });
        });
        
        // Keyboard navigation enhancement
        const notificationItems = notificationsContainer.querySelectorAll('.notification-item');
        notificationItems.forEach((item, index) => {
            item.addEventListener('keydown', function(event) {
                switch(event.key) {
                    case 'Enter':
                    case ' ':
                        // Activate the first action button
                        const firstAction = item.querySelector('.notification-action-btn');
                        if (firstAction) {
                            event.preventDefault();
                            firstAction.click();
                        }
                        break;
                    case 'ArrowDown':
                        event.preventDefault();
                        if (index < notificationItems.length - 1) {
                            notificationItems[index + 1].focus();
                        }
                        break;
                    case 'ArrowUp':
                        event.preventDefault();
                        if (index > 0) {
                            notificationItems[index - 1].focus();
                        }
                        break;
                }
            });
        });
    }
});
</script>
@endpush
