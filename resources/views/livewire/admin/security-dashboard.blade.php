<div>
    <!-- Güvenlik Dashboard Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Güvenlik Dashboard</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                MonexaFinans Platform Güvenlik Durumu
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <select wire:model="selectedTimeframe" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="1h">Son 1 Saat</option>
                <option value="24h">Son 24 Saat</option>
                <option value="7d">Son 7 Gün</option>
                <option value="30d">Son 30 Gün</option>
            </select>
            <button wire:click="runSecurityScan" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                Güvenlik Taraması
            </button>
            <button wire:click="loadSecurityData" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                Yenile
            </button>
        </div>
    </div>

    <!-- Güvenlik Metrikleri -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Login Denemeleri -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Login Denemeleri</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($securityMetrics['login_attempts'] ?? 0) }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm">
                    <span class="text-red-600">{{ $securityMetrics['failed_logins'] ?? 0 }} başarısız</span>
                </div>
            </div>
        </div>

        <!-- Güvenlik İhlalleri -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Güvenlik İhlalleri</p>
                    <p class="text-2xl font-semibold text-red-600">{{ number_format($securityMetrics['security_violations'] ?? 0) }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm">
                    <span class="text-orange-600">{{ $securityMetrics['rate_limit_hits'] ?? 0 }} rate limit</span>
                </div>
            </div>
        </div>

        <!-- Finansal İşlemler -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Finansal İşlemler</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format(($securityMetrics['deposits'] ?? 0) + ($securityMetrics['withdrawals'] ?? 0)) }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm space-x-4">
                    <span class="text-green-600">{{ $securityMetrics['deposits'] ?? 0 }} yatırma</span>
                    <span class="text-red-600">{{ $securityMetrics['withdrawals'] ?? 0 }} çekme</span>
                </div>
            </div>
        </div>

        <!-- API Çağrıları -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">API Çağrıları</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($securityMetrics['api_calls'] ?? 0) }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm">
                    <span class="text-gray-600">Son 24 saat</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Rate Limit İstatistikleri -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Rate Limit İstatistikleri</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($rateLimitStats as $tier => $stats)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-medium text-gray-900 dark:text-white capitalize">{{ $tier }}</h3>
                            <button wire:click="resetRateLimits('{{ $tier }}')" class="text-xs text-red-600 hover:text-red-800">
                                Sıfırla
                            </button>
                        </div>
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Hit'ler:</span>
                                <span class="font-medium">{{ $stats['current_hits'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Engellenen:</span>
                                <span class="font-medium text-red-600">{{ $stats['blocked_requests'] }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Güvenlik Header Durumu -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Güvenlik Header Durumu</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($securityHeadersStatus as $header => $status)
                    <div class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ str_replace('_', ' ', ucfirst($header)) }}</p>
                            <p class="text-xs text-gray-500">{{ $status['last_checked'] ?? 'Hiç kontrol edilmedi' }}</p>
                        </div>
                        <div class="flex items-center">
                            @if($status['present'])
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ✓ OK
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    ✗ EKSİK
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Son Güvenlik Olayları -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Son Güvenlik Olayları</h2>
        </div>
        <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Zaman</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Olay</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Seviye</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">IP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($recentEvents as $event)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ \Carbon\Carbon::parse($event['timestamp'])->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $event['event'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($event['level'] === 'critical')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Kritik
                                    </span>
                                @elseif($event['level'] === 'warning')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Uyarı
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Bilgi
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $event['ip'] ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if(isset($event['ip']) && $event['ip'] !== 'N/A')
                                    <button wire:click="blockIP('{{ $event['ip'] }}')" class="text-red-600 hover:text-red-900 mr-3">
                                        Engelle
                                    </button>
                                @endif
                                <button class="text-blue-600 hover:text-blue-900">
                                    Detay
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                Henüz güvenlik olayı bulunmuyor.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Hızlı İşlemler -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Hızlı İşlemler</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <button wire:click="resetRateLimits()" class="flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                    Tüm Rate Limit'leri Sıfırla
                </button>
                <button wire:click="runSecurityScan" class="flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Güvenlik Taraması Yap
                </button>
                <a href="{{ route('admin.logs.security') }}" class="flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Güvenlik Loglarını Görüntüle
                </a>
                <a href="{{ route('admin.settings.security') }}" class="flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Güvenlik Ayarları
                </a>
            </div>
        </div>
    </div>

    <!-- Session Flash Message -->
    @if (session()->has('message'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Livewire polling for real-time updates -->
    <div wire:poll.30s="loadSecurityData"></div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-refresh every 30 seconds using Livewire
        setInterval(function() {
            @this.call('loadSecurityData');
        }, 30000);

        // Request notification permission
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
    });

    // Listen for critical security events
    document.addEventListener('livewire:initialized', function() {
        @this.on('showSecurityNotification', function(data) {
            // Show notification for security events
            if (Notification.permission === 'granted') {
                new Notification('MonexaFinans Güvenlik Uyarısı', {
                    body: data.message,
                    icon: '/favicon.ico'
                });
            }
        });
    });
</script>
@endpush

<style>
/* Custom styles for security dashboard */
.security-card {
    transition: all 0.3s ease;
}

.security-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 8px;
}

.status-ok {
    background-color: #10b981;
}

.status-warning {
    background-color: #f59e0b;
}

.status-error {
    background-color: #ef4444;
}

.metric-change {
    font-size: 0.75rem;
    font-weight: 600;
}

.metric-up {
    color: #ef4444;
}

.metric-down {
    color: #10b981;
}
</style>