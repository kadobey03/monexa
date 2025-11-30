<!DOCTYPE html>
<html lang="tr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('admin.notifications.admin_notifications') }} - Monexa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full font-sans antialiased">
    <div class="min-h-full flex">
        <!-- Sidebar -->
        <div class="hidden lg:flex lg:flex-shrink-0">
            <div class="flex flex-col w-64 bg-white border-r border-gray-200">
                <div class="flex flex-col h-0 flex-1">
                    <!-- Logo -->
                    <div class="flex items-center h-16 flex-shrink-0 px-4 bg-primary-600">
                        <h1 class="text-xl font-bold text-white">{{ __('admin.notifications.monexa_admin') }}</h1>
                    </div>
                    
                    <!-- Navigation -->
                    <nav class="flex-1 px-2 py-4 bg-white space-y-1">
                        <a href="/admin/dashboard" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <i class="fas fa-tachometer-alt mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            {{ __('admin.notifications.dashboard') }}
                        </a>
                        <a href="/admin/users" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <i class="fas fa-users mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            {{ __('admin.notifications.users') }}
                        </a>
                        <a href="/admin/notifications" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md bg-primary-100 text-primary-700">
                            <i class="fas fa-bell mr-3 text-primary-500"></i>
                            {{ __('admin.notifications.notifications') }}
                        </a>
                        <a href="/admin/leads" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                            <i class="fas fa-chart-line mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            {{ __('admin.notifications.leads') }}
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Mobile sidebar backdrop -->
        <div id="mobile-sidebar-backdrop" class="fixed inset-0 flex z-40 lg:hidden hidden" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75" onclick="closeMobileSidebar()"></div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <!-- Top navigation -->
            <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
                <button type="button" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 lg:hidden" onclick="openMobileSidebar()">
                    <i class="fas fa-bars h-6 w-6"></i>
                </button>
                
                <div class="flex-1 px-4 flex justify-between">
                    <div class="flex-1 flex">
                        <div class="w-full flex md:ml-0">
                            <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                                <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                    <i class="fas fa-search h-5 w-5"></i>
                                </div>
                                <input id="search-field" class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent" placeholder="{{ __('admin.notifications.search_notifications') }}" type="search">
                            </div>
                        </div>
                    </div>
                    
                    <div class="ml-4 flex items-center md:ml-6">
                        <button type="button" class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <i class="fas fa-bell h-6 w-6"></i>
                        </button>
                        
                        <div class="ml-3 relative">
                            <div>
                                <button type="button" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" id="user-menu-button" onclick="toggleUserMenu()">
                                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name=Admin&background=3b82f6&color=fff" alt="">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <main class="flex-1 relative overflow-y-auto focus:outline-none">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <!-- Page header -->
                        <div class="md:flex md:items-center md:justify-between mb-8">
                            <div class="flex-1 min-w-0">
                                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                                    <i class="fas fa-bell mr-3 text-primary-600"></i>
                                    {{ __('admin.notifications.notification_management') }}
                                </h2>
                                <p class="mt-1 text-gray-500">{{ __('admin.notifications.view_and_manage_notifications') }}</p>
                            </div>
                            <div class="mt-4 flex md:mt-0 md:ml-4">
                                <button type="button" onclick="markAllAsRead()" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-200">
                                    <i class="fas fa-check-double mr-2"></i>
                                    {{ __('admin.notifications.mark_all_as_read') }}
                                </button>
                            </div>
                        </div>

                        <!-- Alert Messages -->
                        @if(session('success'))
                            <div id="success-alert" class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                                    </div>
                                    <div class="ml-auto pl-3">
                                        <button onclick="closeAlert('success-alert')" class="text-green-400 hover:text-green-600">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div id="error-alert" class="mb-6 rounded-md bg-red-50 p-4 border border-red-200">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-circle text-red-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                                    </div>
                                    <div class="ml-auto pl-3">
                                        <button onclick="closeAlert('error-alert')" class="text-red-400 hover:text-red-600">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Stats Overview -->
                        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500">
                                                <i class="fas fa-bell text-white text-xl"></i>
                                            </div>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 truncate">{{ __('admin.notifications.total_notifications') }}</dt>
                                                <dd class="text-lg font-medium text-gray-900">{{ $notifications->total() }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-500">
                                                <i class="fas fa-check text-white text-xl"></i>
                                            </div>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 truncate">{{ __('admin.notifications.read') }}</dt>
                                                <dd class="text-lg font-medium text-gray-900">{{ $notifications->where('is_read', true)->count() }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-orange-500">
                                                <i class="fas fa-dot-circle text-white text-xl"></i>
                                            </div>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 truncate">{{ __('admin.notifications.unread') }}</dt>
                                                <dd class="text-lg font-medium text-gray-900">{{ $notifications->where('is_read', false)->count() }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
                                <div class="p-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-purple-500">
                                                <i class="fas fa-calendar text-white text-xl"></i>
                                            </div>
                                        </div>
                                        <div class="ml-5 w-0 flex-1">
                                            <dl>
                                                <dt class="text-sm font-medium text-gray-500 truncate">{{ __('admin.notifications.today') }}</dt>
                                                <dd class="text-lg font-medium text-gray-900">{{ $notifications->where('created_at', '>=', now()->startOfDay())->count() }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="mt-8 bg-white shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                    <div class="mb-4 sm:mb-0">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('admin.notifications.filter_notifications') }}</h3>
                                    </div>
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <select id="filter-type" class="block rounded-md border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                            <option value="all">{{ __('admin.notifications.all_types') }}</option>
                                            <option value="info">{{ __('admin.notifications.info') }}</option>
                                            <option value="success">{{ __('admin.notifications.success') }}</option>
                                            <option value="warning">{{ __('admin.notifications.warning') }}</option>
                                            <option value="danger">{{ __('admin.notifications.important') }}</option>
                                        </select>
                                        <select id="filter-status" class="block rounded-md border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                            <option value="all">{{ __('admin.notifications.all_statuses') }}</option>
                                            <option value="read">{{ __('admin.notifications.read') }}</option>
                                            <option value="unread">{{ __('admin.notifications.unread') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notifications List -->
                        <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-md">
                            @if(count($notifications) > 0)
                                <ul id="notifications-list" class="divide-y divide-gray-200">
                                    @foreach($notifications as $notification)
                                        <li class="notification-item {{ !$notification->is_read ? 'bg-blue-50' : 'bg-white' }}" 
                                            data-type="{{ $notification->type }}" 
                                            data-status="{{ $notification->is_read ? 'read' : 'unread' }}">
                                            <div class="px-4 py-4 sm:px-6">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-start">
                                                        @if(!$notification->is_read)
                                                            <div class="flex-shrink-0 mr-3 mt-1">
                                                                <div class="h-2 w-2 bg-blue-500 rounded-full animate-pulse"></div>
                                                            </div>
                                                        @endif
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                                {{ $notification->title }}
                                                            </p>
                                                            <p class="text-sm text-gray-600 mt-1">
                                                                {{ $notification->message }}
                                                            </p>
                                                            <div class="flex items-center mt-2 space-x-4">
                                                                @php
                                                                    $typeConfig = [
                                                                        'info' => ['bg-blue-100', 'text-blue-800', 'fas fa-info-circle'],
                                                                        'success' => ['bg-green-100', 'text-green-800', 'fas fa-check-circle'],
                                                                        'warning' => ['bg-yellow-100', 'text-yellow-800', 'fas fa-exclamation-triangle'],
                                                                        'danger' => ['bg-red-100', 'text-red-800', 'fas fa-times-circle']
                                                                    ];
                                                                    $config = $typeConfig[$notification->type] ?? $typeConfig['info'];
                                                                @endphp
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config[0] }} {{ $config[1] }}">
                                                                    <i class="{{ $config[2] }} mr-1"></i>
                                                                    {{ ucfirst($notification->type === 'danger' ? __('admin.notifications.important') : ($notification->type === 'warning' ? __('admin.notifications.warning') : ($notification->type === 'success' ? __('admin.notifications.success') : __('admin.notifications.info')))) }}
                                                                </span>
                                                                <span class="text-xs text-gray-500">
                                                                    {{ $notification->created_at->diffForHumans() }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        @if(!$notification->is_read)
                                                            <button type="button" onclick="markAsRead({{ $notification->id }})" class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                                                <i class="fas fa-check mr-1"></i>
                                                                {{ __('admin.notifications.mark_read') }}
                                                            </button>
                                                        @endif
                                                        <button type="button" onclick="deleteNotification({{ $notification->id }})" class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-200">
                                                            <i class="fas fa-trash mr-1"></i>
                                                            {{ __('admin.notifications.delete') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                
                                <!-- Pagination -->
                                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                                    {{ $notifications->links() }}
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="mx-auto h-24 w-24 text-gray-400">
                                        <i class="fas fa-bell-slash text-6xl"></i>
                                    </div>
                                    <h3 class="mt-4 text-lg font-medium text-gray-900">{{ __('admin.notifications.no_notifications_found') }}</h3>
                                    <p class="mt-2 text-sm text-gray-500">{{ __('admin.notifications.no_notifications_received_yet') }}</p>
                                    <div class="mt-6">
                                        <button type="button" onclick="location.href='{{ route('admin.send.message') }}'" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            <i class="fas fa-plus mr-2"></i>
                                            {{ __('admin.notifications.send_new_message') }}
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 shadow-xl">
            <div class="flex items-center">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600 mr-3"></div>
                <span class="text-gray-700">{{ __('admin.notifications.processing') }}</span>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">{{ __('admin.notifications.delete_notification') }}</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">{{ __('admin.notifications.delete_confirmation') }}</p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirm-delete" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        {{ __('admin.notifications.delete') }}
                    </button>
                    <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        {{ __('admin.notifications.cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // State management
        let currentDeleteId = null;
        let isMobileSidebarOpen = false;
        let isUserMenuOpen = false;

        // Mobile sidebar functions
        function openMobileSidebar() {
            document.getElementById('mobile-sidebar-backdrop').classList.remove('hidden');
            isMobileSidebarOpen = true;
        }

        function closeMobileSidebar() {
            document.getElementById('mobile-sidebar-backdrop').classList.add('hidden');
            isMobileSidebarOpen = false;
        }

        // User menu toggle
        function toggleUserMenu() {
            isUserMenuOpen = !isUserMenuOpen;
            // Add user menu dropdown logic here if needed
        }

        // Alert functions
        function closeAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.style.transition = 'opacity 0.3s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        }

        // Loading overlay
        function showLoading() {
            document.getElementById('loading-overlay').classList.remove('hidden');
        }

        function hideLoading() {
            document.getElementById('loading-overlay').classList.add('hidden');
        }

        // Notification actions
        async function markAsRead(notificationId) {
            showLoading();
            try {
                const response = await fetch(`{{ url('admin/markasread') }}/${notificationId}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    location.reload();
                } else {
                    throw new Error('Failed to mark as read');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('error', '{{ __('admin.notifications.error_marking_as_read') }}');
            } finally {
                hideLoading();
            }
        }

        async function markAllAsRead() {
            if (!confirm('{{ __('admin.notifications.confirm_mark_all_as_read') }}')) {
                return;
            }

            showLoading();
            try {
                const response = await fetch('{{ route("admin.markallasread") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                });

                if (response.ok) {
                    location.reload();
                } else {
                    throw new Error('Failed to mark all as read');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('error', '{{ __('admin.notifications.error_marking_notifications') }}');
            } finally {
                hideLoading();
            }
        }

        function deleteNotification(notificationId) {
            currentDeleteId = notificationId;
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            currentDeleteId = null;
        }

        // Confirm delete
        document.getElementById('confirm-delete').addEventListener('click', async function() {
            if (!currentDeleteId) return;

            showLoading();
            closeDeleteModal();

            try {
                window.location.href = `{{ url('admin/deletenotification') }}/${currentDeleteId}`;
            } catch (error) {
                console.error('Error:', error);
                showToast('error', '{{ __('admin.notifications.error_deleting_notification') }}');
                hideLoading();
            }
        });

        // Filtering functionality
        function filterNotifications() {
            const typeFilter = document.getElementById('filter-type').value;
            const statusFilter = document.getElementById('filter-status').value;
            const notifications = document.querySelectorAll('.notification-item');

            notifications.forEach(notification => {
                const type = notification.getAttribute('data-type');
                const status = notification.getAttribute('data-status');
                
                let showItem = true;

                if (typeFilter !== 'all' && type !== typeFilter) {
                    showItem = false;
                }

                if (statusFilter !== 'all' && status !== statusFilter) {
                    showItem = false;
                }

                notification.style.display = showItem ? 'block' : 'none';
            });
        }

        // Search functionality
        function searchNotifications() {
            const searchTerm = document.getElementById('search-field').value.toLowerCase();
            const notifications = document.querySelectorAll('.notification-item');

            notifications.forEach(notification => {
                const title = notification.querySelector('.font-medium').textContent.toLowerCase();
                const message = notification.querySelector('.text-gray-600').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || message.includes(searchTerm)) {
                    notification.style.display = 'block';
                } else {
                    notification.style.display = 'none';
                }
            });
        }

        // Toast notification function
        function showToast(type, message) {
            const toast = document.createElement('div');
            const bgColor = type === 'error' ? 'bg-red-500' : 'bg-green-500';
            
            toast.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300 translate-x-full`;
            toast.textContent = message;
            
            document.body.appendChild(toast);
            
            // Slide in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            // Remove after 3 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Filter event listeners
            document.getElementById('filter-type').addEventListener('change', filterNotifications);
            document.getElementById('filter-status').addEventListener('change', filterNotifications);
            
            // Search with debouncing
            let searchTimeout;
            document.getElementById('search-field').addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(searchNotifications, 300);
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll('[id$="-alert"]');
                alerts.forEach(alert => {
                    closeAlert(alert.id);
                });
            }, 5000);
        });

        // Auto refresh every 5 minutes
        setInterval(function() {
            // Optional: implement WebSocket or check for new notifications
        }, 300000);
    </script>
</body>
</html>