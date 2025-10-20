<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $bgmenu = 'blue';
    $bg = 'light';
    $text = 'dark';
} else {
    $bgmenu = 'dark';
    $bg = 'dark';
    $text = 'light';
}
?>

<!-- Tailwind Admin Header -->
<header class="fixed top-0 right-0 left-0 z-30 bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-800 shadow-2xl backdrop-blur-lg">
    <div class="flex items-center justify-between h-16 px-6">
        
        <!-- Left Side - Logo & Menu Toggle -->
        <div class="flex items-center space-x-4">
            <!-- Mobile Menu Toggle -->
            <button id="mobile-menu-toggle" class="md:hidden p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-300 text-white" onclick="toggleSidebar()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
            <!-- Desktop Sidebar Toggle -->
            <button id="sidebar-toggle" class="hidden md:block p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-300 text-white" onclick="toggleSidebar()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
            <!-- Logo -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 text-white hover:text-gray-200 transition-colors duration-300">
                <div class="bg-white/20 p-2 rounded-xl backdrop-blur-sm">
                    <i class="fas fa-tachometer-alt text-xl"></i>
                </div>
                <span class="text-xl font-bold hidden sm:block">{{ $settings->site_name }}</span>
            </a>
        </div>

        <!-- Center - Search Bar (Desktop) -->
        <div class="hidden lg:flex flex-1 max-w-md mx-8">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-white/60"></i>
                </div>
                <input type="text" 
                       class="block w-full pl-10 pr-4 py-2 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent backdrop-blur-sm transition-all duration-300"
                       placeholder="Kullanıcıları yönet..."
                       onclick="window.location.href='{{ route('manageusers') }}'">
            </div>
        </div>

        <!-- Right Side - Navigation Items -->
        <div class="flex items-center space-x-4">
            
            <!-- Search Button (Mobile) -->
            <button class="lg:hidden p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-300 text-white">
                <i class="fas fa-search text-lg"></i>
            </button>

            <!-- Notifications -->
            <div class="relative dropdown-container">
                <button class="dropdown-toggle relative p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-300 text-white" data-dropdown="notifications">
                    <i class="fas fa-bell text-lg"></i>
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
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold animate-pulse notification-badge">
                            {{ $notificationCount > 99 ? '99+' : $notificationCount }}
                        </span>
                    @endif
                </button>

                <!-- Notifications Dropdown -->
                <div class="dropdown-content absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border-0 backdrop-blur-xl z-50 max-h-96 overflow-y-auto hidden">
                     
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 rounded-t-2xl">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-bell"></i>
                                <h3 class="font-bold">Bildirimler</h3>
                                @if($notificationCount > 0)
                                    <span class="bg-white/20 text-xs px-2 py-1 rounded-full">{{ $notificationCount }}</span>
                                @endif
                            </div>
                            @if($notificationCount > 0)
                                <button class="text-white/80 hover:text-white text-sm font-medium transition-colors">
                                    Tümünü Okundu İşaretle
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Notifications List -->
                    <div class="p-2">
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
                                $bgColor = match($type) {
                                    'success' => 'bg-green-500',
                                    'warning' => 'bg-yellow-500',
                                    'danger' => 'bg-red-500',
                                    default => 'bg-blue-500',
                                };
                            @endphp

                            <div class="flex items-start space-x-3 p-3 rounded-xl hover:bg-gray-50 transition-colors duration-200 group">
                                <div class="{{ $bgColor }} p-2 rounded-full text-white group-hover:scale-110 transition-transform duration-200">
                                    <i class="fas fa-{{ $icon }} text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-900 text-sm">{{ $title }}</h4>
                                    <p class="text-gray-600 text-xs mt-1">{{ $message }}</p>
                                    <div class="flex items-center text-gray-400 text-xs mt-2">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <button class="text-gray-400 hover:text-red-500 transition-colors p-1 opacity-0 group-hover:opacity-100">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <div class="text-gray-400 mb-3">
                                    <i class="fas fa-bell-slash text-3xl"></i>
                                </div>
                                <h4 class="font-bold text-gray-700">Yeni bildirim yok</h4>
                                <p class="text-gray-500 text-sm">Her şey güncel!</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Footer -->
                    @if($notificationCount > 0)
                        <div class="p-3 bg-gray-50 rounded-b-2xl border-t">
                            <a href="{{ route('admin.notifications') }}" 
                               class="block w-full text-center py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-medium hover:from-blue-700 hover:to-purple-700 transition-all duration-300">
                                <i class="fas fa-list mr-2"></i>
                                Tüm Bildirimleri Görüntüle
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- User Profile -->
            <div class="relative dropdown-container">
                <button class="dropdown-toggle flex items-center space-x-2 p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-all duration-300 text-white" data-dropdown="profile">
                    <div class="bg-white/20 p-2 rounded-lg">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="hidden sm:block font-medium">{{ Auth('admin')->user()->firstName }}</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                </button>

                <!-- User Dropdown -->
                <div class="dropdown-content absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-2xl border-0 backdrop-blur-xl z-50 hidden">
                     
                    <div class="p-2">
                        <a href="{{ url('admin/dashboard/adminprofile') }}" 
                           class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-xl transition-colors duration-200">
                            <i class="fas fa-user-cog text-blue-500"></i>
                            <span>Hesap Ayarları</span>
                        </a>
                        
                        <a href="{{ url('admin/dashboard/adminchangepassword') }}" 
                           class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-xl transition-colors duration-200">
                            <i class="fas fa-key text-green-500"></i>
                            <span>Şifre Değiştir</span>
                        </a>
                        
                        <hr class="my-2 border-gray-200">
                        
                        <a href="{{ route('adminlogout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logoutform').submit();"
                           class="flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition-colors duration-200">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Çıkış Yap</span>
                        </a>
                        
                        <form id="logoutform" action="{{ route('adminlogout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Spacer for fixed header -->
<div class="h-16"></div>

<script>
// Header dropdown functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize header dropdowns
    const dropdownContainers = document.querySelectorAll('.dropdown-container');
    
    dropdownContainers.forEach(container => {
        const toggle = container.querySelector('.dropdown-toggle');
        const content = container.querySelector('.dropdown-content');
        const chevron = toggle.querySelector('.fas.fa-chevron-down');
        
        if (toggle && content) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Close all other dropdowns
                dropdownContainers.forEach(otherContainer => {
                    if (otherContainer !== container) {
                        const otherContent = otherContainer.querySelector('.dropdown-content');
                        const otherChevron = otherContainer.querySelector('.fas.fa-chevron-down');
                        if (otherContent) {
                            otherContent.classList.add('hidden');
                        }
                        if (otherChevron) {
                            otherChevron.classList.remove('rotate-180');
                        }
                    }
                });
                
                const isOpen = !content.classList.contains('hidden');
                
                if (isOpen) {
                    // Close
                    content.classList.add('hidden');
                    if (chevron) chevron.classList.remove('rotate-180');
                } else {
                    // Open
                    content.classList.remove('hidden');
                    if (chevron) chevron.classList.add('rotate-180');
                }
            });
        }
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-container')) {
            dropdownContainers.forEach(container => {
                const content = container.querySelector('.dropdown-content');
                const chevron = container.querySelector('.fas.fa-chevron-down');
                if (content) {
                    content.classList.add('hidden');
                }
                if (chevron) {
                    chevron.classList.remove('rotate-180');
                }
            });
        }
    });
    
    // Auto-refresh notifications every 30 seconds
    setInterval(refreshNotificationCount, 30000);
    
    function refreshNotificationCount() {
        fetch('{{ url("/admin/notifications/count") }}')
            .then(response => response.json())
            .then(data => {
                const count = data.count || 0;
                const badge = document.querySelector('.notification-badge');
                
                if (count > 0) {
                    if (!badge) {
                        // Create badge if it doesn't exist
                        const newBadge = document.createElement('span');
                        newBadge.className = 'absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold animate-pulse notification-badge';
                        newBadge.textContent = count > 99 ? '99+' : count;
                        document.querySelector('[data-dropdown="notifications"]').appendChild(newBadge);
                    } else {
                        badge.textContent = count > 99 ? '99+' : count;
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

<style>
/* Custom animations and effects */
/* Glass morphism effect */
.backdrop-blur-xl {
    backdrop-filter: blur(20px);
}

/* Custom scrollbar for notifications */
.max-h-96::-webkit-scrollbar {
    width: 6px;
}

.max-h-96::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.max-h-96::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 10px;
}

.max-h-96::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #5a6fd8, #6a4190);
}

/* Dropdown transitions */
.dropdown-content {
    transition: all 0.3s ease;
    transform-origin: top;
}

.dropdown-content.hidden {
    opacity: 0;
    transform: scale(0.95) translateY(-10px);
    pointer-events: none;
}

.dropdown-content:not(.hidden) {
    opacity: 1;
    transform: scale(1) translateY(0);
    pointer-events: all;
}

/* Button hover effects */
button {
    transition: all 0.2s ease;
}

button:hover {
    transform: translateY(-1px);
}

button:active {
    transform: translateY(0);
}
</style>