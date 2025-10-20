<!-- Admin Header -->
<header class="bg-white shadow-sm border-b border-gray-200 fixed w-full top-0 z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <!-- Left side -->
            <div class="flex items-center">
                <!-- Sidebar toggle button - both mobile and desktop -->
                <button type="button"
                        id="sidebar-toggle"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition-colors duration-200"
                        onclick="toggleSidebar()">
                    <span class="sr-only">Menüyü aç/kapat</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Logo/Brand -->
                <div class="flex-shrink-0 flex items-center ml-4 lg:ml-0">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-tachometer-alt text-white text-sm"></i>
                            </div>
                            <span class="hidden sm:block text-xl font-semibold text-gray-900">{{ $settings->site_name ?? 'Admin Panel' }}</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Center - Search (hidden on mobile) -->
            <div class="hidden md:block flex-1 max-w-lg mx-8">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" 
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           placeholder="Kullanıcıları ara..."
                           onclick="window.location.href='{{ route('manageusers') }}'">
                </div>
            </div>

            <!-- Right side -->
            <div class="flex items-center space-x-4">
                
                <!-- Search button (mobile) -->
                <button type="button" 
                        class="md:hidden p-2 rounded-lg text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <i class="fas fa-search h-5 w-5"></i>
                </button>

                <!-- Notifications -->
                <div class="relative">
                    <button type="button" 
                            class="notification-btn p-2 rounded-lg text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            id="notifications-button">
                        <i class="fas fa-bell h-5 w-5"></i>
                        @php
                            try {
                                $notifications = \App\Models\Notification::where('admin_id', Auth::guard('admin')->id())
                                    ->where('is_read', 0)
                                    ->orderBy('created_at', 'desc')
                                    ->get();
                                
                                if($notifications->isEmpty()) {
                                    $notifications = \App\Models\Notification::where('admin_id', Auth::guard('admin')->id())
                                        ->where('type', 'admin')
                                        ->where('is_read', 0)
                                        ->orderBy('created_at', 'desc')
                                        ->get();
                                }

                                if($notifications->isEmpty()) {
                                    $notifications = \App\Models\Notification::where('admin_id', Auth::guard('admin')->id())
                                        ->where('notifiable_type', 'App\Models\Admin')
                                        ->whereNull('read_at')
                                        ->orderBy('created_at', 'desc')
                                        ->get();
                                }

                                $notificationCount = $notifications->count();
                            } catch (\Exception $e) {
                                \Log::error('Admin notification fetch error: ' . $e->getMessage());
                                $notifications = collect([]);
                                $notificationCount = 0;
                            }
                        @endphp
                        
                        @if($notificationCount > 0)
                            <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
                                {{ $notificationCount > 9 ? '9+' : $notificationCount }}
                            </span>
                        @endif
                    </button>

                    <!-- Notifications Dropdown -->
                    <div id="notifications-dropdown" 
                         class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50 max-h-96 overflow-y-auto">
                         
                        <!-- Header -->
                        <div class="px-4 py-3 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-gray-900">Bildirimler</h3>
                                @if($notificationCount > 0)
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{ $notificationCount }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Notifications List -->
                        <div class="py-2">
                            @forelse($notifications as $notification)
                                @php
                                    $type = $notification->data['type'] ?? $notification->type ?? 'info';
                                    $title = $notification->data['title'] ?? $notification->title ?? 'Notification';
                                    $message = Str::limit($notification->data['message'] ?? $notification->message ?? 'New notification received', 60);
                                    $icon = match($type) {
                                        'success' => 'check-circle',
                                        'warning' => 'exclamation-triangle',
                                        'danger' => 'exclamation-circle',
                                        default => 'bell',
                                    };
                                    $textColor = match($type) {
                                        'success' => 'text-green-600',
                                        'warning' => 'text-yellow-600',
                                        'danger' => 'text-red-600',
                                        default => 'text-blue-600',
                                    };
                                @endphp

                                <div class="px-4 py-3 hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-{{ $icon }} {{ $textColor }}"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900">{{ $title }}</p>
                                            <p class="text-sm text-gray-500">{{ $message }}</p>
                                            <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-8 text-center">
                                    <i class="fas fa-bell-slash text-gray-400 text-2xl mb-2"></i>
                                    <p class="text-sm text-gray-500">Yeni bildirim yok</p>
                                </div>
                            @endforelse
                        </div>

                        @if($notificationCount > 0)
                            <div class="px-4 py-3 border-t border-gray-200">
                                <a href="{{ route('admin.notifications') }}" 
                                   class="block w-full text-center px-4 py-2 text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                                    Tüm bildirimleri görüntüle
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Profile dropdown -->
                <div class="relative">
                    <button type="button" 
                            class="profile-btn flex items-center space-x-2 p-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            id="profile-button">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-gray-600 text-sm"></i>
                        </div>
                        <span class="hidden sm:block">{{ Auth('admin')->user()->firstName }}</span>
                        <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                    </button>

                    <!-- Profile Dropdown -->
                    <div id="profile-dropdown" 
                         class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                        <div class="py-2">
                            <a href="{{ url('admin/dashboard/adminprofile') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                <i class="fas fa-user-cog w-4 h-4 mr-3 text-gray-400"></i>
                                Hesap Ayarları
                            </a>
                            <a href="{{ url('admin/dashboard/adminchangepassword') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                <i class="fas fa-key w-4 h-4 mr-3 text-gray-400"></i>
                                Şifre Değiştir
                            </a>
                            <hr class="my-2 border-gray-200">
                            <a href="{{ route('adminlogout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                <i class="fas fa-sign-out-alt w-4 h-4 mr-3"></i>
                                Çıkış Yap
                            </a>
                            <form id="logout-form" action="{{ route('adminlogout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Header spacer -->
<div class="h-16"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Notifications dropdown
    const notificationsButton = document.getElementById('notifications-button');
    const notificationsDropdown = document.getElementById('notifications-dropdown');
    
    // Profile dropdown  
    const profileButton = document.getElementById('profile-button');
    const profileDropdown = document.getElementById('profile-dropdown');
    
    // Toggle notifications dropdown
    if (notificationsButton && notificationsDropdown) {
        notificationsButton.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationsDropdown.classList.toggle('hidden');
            // Close profile dropdown if open
            if (profileDropdown) {
                profileDropdown.classList.add('hidden');
            }
        });
    }
    
    // Toggle profile dropdown
    if (profileButton && profileDropdown) {
        profileButton.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
            // Close notifications dropdown if open
            if (notificationsDropdown) {
                notificationsDropdown.classList.add('hidden');
            }
        });
    }
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.relative')) {
            if (notificationsDropdown) {
                notificationsDropdown.classList.add('hidden');
            }
            if (profileDropdown) {
                profileDropdown.classList.add('hidden');
            }
        }
    });
    
    // Auto-refresh notification count every 30 seconds
    setInterval(refreshNotificationCount, 30000);
    
    function refreshNotificationCount() {
        fetch('{{ url("/admin/notifications/count") }}')
            .then(response => response.json())
            .then(data => {
                const count = data.count || 0;
                const badge = notificationsButton.querySelector('span');
                
                if (count > 0) {
                    if (!badge) {
                        const newBadge = document.createElement('span');
                        newBadge.className = 'absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold';
                        newBadge.textContent = count > 9 ? '9+' : count;
                        notificationsButton.appendChild(newBadge);
                    } else {
                        badge.textContent = count > 9 ? '9+' : count;
                        badge.classList.remove('hidden');
                    }
                } else {
                    if (badge) {
                        badge.classList.add('hidden');
                    }
                }
            })
            .catch(error => console.error('Error refreshing notification count:', error));
    }
});
</script>