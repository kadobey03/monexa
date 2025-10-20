@extends('layouts.app')
@section('title', 'Bildirimler')

@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <!-- Header Section -->
                <div class="relative overflow-hidden bg-gradient-to-br from-purple-600 via-blue-600 to-indigo-700 rounded-2xl p-8 mb-8">
                    <div class="absolute inset-0 bg-black opacity-20"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-600/10 to-blue-600/10"></div>
                    <div class="relative">
                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div>
                                <h1 class="text-4xl font-bold text-white mb-2">
                                    <i class="fas fa-bell mr-3 text-purple-200"></i>
                                    Bildirim Yönetimi
                                </h1>
                                <p class="text-purple-100 text-lg">
                                    Sistem bildirimlerini görüntüleyin ve yönetin
                                </p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <a href="{{ route('admin.markallasread') }}"
                                   class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-semibold rounded-xl hover:bg-white/30 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    <i class="fas fa-check-double mr-2"></i>
                                    Tümünü Okundu İşaretle
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="absolute -right-16 -bottom-16 w-32 h-32 bg-gradient-to-br from-white/10 to-blue-300/20 rounded-full blur-2xl"></div>
                    <div class="absolute -left-16 -top-16 w-24 h-24 bg-gradient-to-br from-purple-400/20 to-indigo-400/20 rounded-full blur-xl"></div>
                </div>

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-bell text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ $notifications->total() }}</div>
                                <div class="text-gray-500 text-sm">Toplam Bildirim</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-check text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ $notifications->where('is_read', true)->count() }}
                                </div>
                                <div class="text-gray-500 text-sm">Okunmuş</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-dot-circle text-orange-600 text-xl"></i>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ $notifications->where('is_read', false)->count() }}
                                </div>
                                <div class="text-gray-500 text-sm">Okunmamış</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-calendar text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ $notifications->where('created_at', '>=', now()->startOfDay())->count() }}
                                </div>
                                <div class="text-gray-500 text-sm">Bugün</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifications Content -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="p-6 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-list mr-3 text-blue-600"></i>
                            Bildirim Listesi
                        </h3>
                        <p class="text-gray-600 mt-1">Sistem bildirimlerini görüntüleyin ve yönetin</p>
                    </div>

                    @if(count($notifications) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">
                                            <i class="fas fa-heading mr-2 text-gray-400"></i>
                                            Başlık
                                        </th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">
                                            <i class="fas fa-comment mr-2 text-gray-400"></i>
                                            Mesaj
                                        </th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">
                                            <i class="fas fa-tag mr-2 text-gray-400"></i>
                                            Tür
                                        </th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">
                                            <i class="fas fa-clock mr-2 text-gray-400"></i>
                                            Tarih
                                        </th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">
                                            <i class="fas fa-cog mr-2 text-gray-400"></i>
                                            İşlemler
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($notifications as $notification)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200 {{ !$notification->is_read ? 'bg-blue-50' : '' }}">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    @if(!$notification->is_read)
                                                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3 animate-pulse"></div>
                                                    @endif
                                                    <div class="font-semibold text-gray-900 {{ !$notification->is_read ? 'font-bold' : '' }}">
                                                        {{ $notification->title }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-600 max-w-xs truncate">
                                                    {{ $notification->message }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $typeConfig = [
                                                        'info' => ['bg-blue-100', 'text-blue-800', 'border-blue-200', 'fas fa-info-circle'],
                                                        'success' => ['bg-green-100', 'text-green-800', 'border-green-200', 'fas fa-check-circle'],
                                                        'warning' => ['bg-yellow-100', 'text-yellow-800', 'border-yellow-200', 'fas fa-exclamation-triangle'],
                                                        'danger' => ['bg-red-100', 'text-red-800', 'border-red-200', 'fas fa-times-circle']
                                                    ];
                                                    $config = $typeConfig[$notification->type] ?? $typeConfig['info'];
                                                @endphp
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $config[0] }} {{ $config[1] }} border {{ $config[2] }}">
                                                    <i class="{{ $config[3] }} mr-1"></i>
                                                    {{ ucfirst($notification->type === 'danger' ? 'Önemli' : ($notification->type === 'warning' ? 'Uyarı' : ($notification->type === 'success' ? 'Başarılı' : 'Bilgi'))) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-600">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center space-x-2">
                                                    @if(!$notification->is_read)
                                                        <a href="{{ route('admin.markasread', $notification->id) }}"
                                                           class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 text-sm font-semibold rounded-lg hover:bg-blue-200 transition-colors duration-200">
                                                            <i class="fas fa-check mr-1"></i>
                                                            Okundu
                                                        </a>
                                                    @endif
                                                    <button onclick="deleteNotification({{ $notification->id }})"
                                                            class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 text-sm font-semibold rounded-lg hover:bg-red-200 transition-colors duration-200">
                                                        <i class="fas fa-trash mr-1"></i>
                                                        Sil
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="px-6 py-12">
                            <div class="text-center">
                                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <i class="fas fa-bell-slash text-4xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Bildirim bulunamadı</h3>
                                <p class="text-gray-500 mb-6">Henüz hiç bildirim almadınız.</p>
                                <a href="{{ route('admin.send.message') }}"
                                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <i class="fas fa-plus mr-2"></i>
                                    Yeni Mesaj Gönder
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteNotification(id) {
            if (confirm('Bu bildirimi silmek istediğinizden emin misiniz?')) {
                window.location.href = `{{ url('admin/deletenotification') }}/${id}`;
            }
        }

        // Auto refresh notifications every 5 minutes
        setInterval(function() {
            // You can implement WebSocket or AJAX polling here
        }, 300000);

        // Mark notification as read with AJAX
        function markAsRead(id) {
            fetch(`{{ url('admin/markasread') }}/${id}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                }
            });
        }
    </script>

    <style>
        @media (max-width: 768px) {
            .overflow-x-auto table {
                min-width: 800px;
            }
        }
    </style>
@endsection
