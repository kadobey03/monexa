@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Header -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 p-8 text-white">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <circle cx="20" cy="20" r="2" fill="currentColor" opacity="0.4"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)"/>
            </svg>
        </div>
        
        <div class="relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-6 lg:mb-0">
                    <!-- Welcome Badge -->
                    <div class="mb-6 inline-flex items-center rounded-full bg-white/20 px-4 py-2 text-sm font-medium backdrop-blur-sm">
                        <i data-lucide="shield-check" class="mr-2 h-4 w-4"></i>
                        Yönetim Paneli
                    </div>
                    
                    <!-- Title -->
                    <h1 class="mb-4 text-4xl font-bold lg:text-5xl">
                        Hoş Geldiniz!
                    </h1>
                    
                    <!-- Greeting -->
                    <p class="mb-4 text-xl text-primary-100">
                        {{ Auth('admin')->user()->firstName }} {{ Auth('admin')->user()->lastName }}
                    </p>
                    
                    <!-- Date Time -->
                    <div class="flex items-center space-x-4 text-primary-200">
                        <div class="flex items-center">
                            <i data-lucide="calendar" class="mr-2 h-4 w-4"></i>
                            {{ \Carbon\Carbon::now()->locale('tr')->isoFormat('dddd, D MMMM YYYY') }}
                        </div>
                        <div class="flex items-center">
                            <i data-lucide="clock" class="mr-2 h-4 w-4"></i>
                            <span id="live-clock">{{ now()->format('H:i:s') }}</span>
                        </div>
                    </div>
                </div>
                
                @if (Auth('admin')->user()->type == 'Super Admin' || Auth('admin')->user()->type == 'Admin')
                <!-- Quick Actions -->
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-3 lg:grid-cols-1">
                    <a href="{{ route('mdeposits') }}" 
                       class="group flex items-center justify-between rounded-2xl bg-white/10 p-4 backdrop-blur-sm transition-all duration-300 hover:bg-white/20 hover:scale-105">
                        <div class="flex items-center space-x-3">
                            <div class="rounded-xl bg-emerald-500 p-2">
                                <i data-lucide="trending-up" class="h-5 w-5 text-white"></i>
                            </div>
                            <span class="font-semibold">Yatırımlar</span>
                        </div>
                        <i data-lucide="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-1"></i>
                    </a>
                    
                    <a href="{{ route('mwithdrawals') }}" 
                       class="group flex items-center justify-between rounded-2xl bg-white/10 p-4 backdrop-blur-sm transition-all duration-300 hover:bg-white/20 hover:scale-105">
                        <div class="flex items-center space-x-3">
                            <div class="rounded-xl bg-rose-500 p-2">
                                <i data-lucide="trending-down" class="h-5 w-5 text-white"></i>
                            </div>
                            <span class="font-semibold">Çekimler</span>
                        </div>
                        <i data-lucide="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-1"></i>
                    </a>
                    
                    <a href="{{ route('manageusers') }}" 
                       class="group flex items-center justify-between rounded-2xl bg-white/10 p-4 backdrop-blur-sm transition-all duration-300 hover:bg-white/20 hover:scale-105">
                        <div class="flex items-center space-x-3">
                            <div class="rounded-xl bg-blue-500 p-2">
                                <i data-lucide="users" class="h-5 w-5 text-white"></i>
                            </div>
                            <span class="font-semibold">Kullanıcılar</span>
                        </div>
                        <i data-lucide="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-1"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Deposits -->
        <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-admin-800 p-6 shadow-elegant dark:shadow-glass-dark transition-all duration-300 hover:scale-105 hover:shadow-elegant-lg">
            <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-gradient-to-br from-emerald-500/20 to-emerald-600/20"></div>
            <div class="relative">
                <div class="mb-4 flex items-center justify-between">
                    <div class="rounded-2xl bg-emerald-100 dark:bg-emerald-900/20 p-3">
                        <i data-lucide="trending-up" class="h-8 w-8 text-emerald-600 dark:text-emerald-400"></i>
                    </div>
                    <div class="flex items-center space-x-1">
                        <div class="h-2 w-2 animate-pulse rounded-full bg-emerald-500"></div>
                        <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400">Aktif</span>
                    </div>
                </div>
                
                <h3 class="mb-2 text-sm font-semibold text-admin-600 dark:text-admin-400">Toplam Yatırımlar</h3>
                <p class="mb-3 text-3xl font-bold text-admin-900 dark:text-admin-100">
                    @foreach ($total_deposited as $deposited)
                        @if (!empty($deposited->count))
                            {{ $settings->currency }}{{ number_format($deposited->count, 2) }}
                        @else
                            {{ $settings->currency }}0.00
                        @endif
                    @endforeach
                </p>
                
                <div class="flex items-center text-xs text-admin-500 dark:text-admin-400">
                    <i data-lucide="calendar" class="mr-1 h-3 w-3"></i>
                    Tüm zamanlar toplamı
                </div>
            </div>
        </div>

        <!-- Pending Deposits -->
        <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-admin-800 p-6 shadow-elegant dark:shadow-glass-dark transition-all duration-300 hover:scale-105 hover:shadow-elegant-lg">
            <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-gradient-to-br from-amber-500/20 to-amber-600/20"></div>
            <div class="relative">
                <div class="mb-4 flex items-center justify-between">
                    <div class="rounded-2xl bg-amber-100 dark:bg-amber-900/20 p-3">
                        <i data-lucide="clock" class="h-8 w-8 text-amber-600 dark:text-amber-400"></i>
                    </div>
                    <div class="flex items-center space-x-1">
                        <div class="h-2 w-2 animate-bounce rounded-full bg-amber-500"></div>
                        <span class="text-xs font-medium text-amber-600 dark:text-amber-400">Bekliyor</span>
                    </div>
                </div>
                
                <h3 class="mb-2 text-sm font-semibold text-admin-600 dark:text-admin-400">Bekleyen Yatırımlar</h3>
                <p class="mb-3 text-3xl font-bold text-admin-900 dark:text-admin-100">
                    @foreach ($pending_deposited as $deposited)
                        @if (!empty($deposited->count))
                            {{ $settings->currency }}{{ number_format($deposited->count, 2) }}
                        @else
                            {{ $settings->currency }}0.00
                        @endif
                    @endforeach
                </p>
                
                <div class="flex items-center text-xs text-admin-500 dark:text-admin-400">
                    <i data-lucide="alert-triangle" class="mr-1 h-3 w-3"></i>
                    Onay bekliyor
                </div>
            </div>
        </div>

        <!-- Total Withdrawals -->
        <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-admin-800 p-6 shadow-elegant dark:shadow-glass-dark transition-all duration-300 hover:scale-105 hover:shadow-elegant-lg">
            <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-gradient-to-br from-rose-500/20 to-rose-600/20"></div>
            <div class="relative">
                <div class="mb-4 flex items-center justify-between">
                    <div class="rounded-2xl bg-rose-100 dark:bg-rose-900/20 p-3">
                        <i data-lucide="trending-down" class="h-8 w-8 text-rose-600 dark:text-rose-400"></i>
                    </div>
                    <div class="flex items-center space-x-1">
                        <div class="h-2 w-2 rounded-full bg-rose-500"></div>
                        <span class="text-xs font-medium text-rose-600 dark:text-rose-400">Tamamlandı</span>
                    </div>
                </div>
                
                <h3 class="mb-2 text-sm font-semibold text-admin-600 dark:text-admin-400">Toplam Çekimler</h3>
                <p class="mb-3 text-3xl font-bold text-admin-900 dark:text-admin-100">
                    @foreach ($total_withdrawn as $deposited)
                        @if (!empty($deposited->count))
                            {{ $settings->currency }}{{ number_format($deposited->count, 2) }}
                        @else
                            {{ $settings->currency }}0.00
                        @endif
                    @endforeach
                </p>
                
                <div class="flex items-center text-xs text-admin-500 dark:text-admin-400">
                    <i data-lucide="check-circle" class="mr-1 h-3 w-3"></i>
                    Tamamlanan işlemler
                </div>
            </div>
        </div>

        <!-- Pending Withdrawals -->
        <div class="group relative overflow-hidden rounded-3xl bg-white dark:bg-admin-800 p-6 shadow-elegant dark:shadow-glass-dark transition-all duration-300 hover:scale-105 hover:shadow-elegant-lg">
            <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-gradient-to-br from-blue-500/20 to-blue-600/20"></div>
            <div class="relative">
                <div class="mb-4 flex items-center justify-between">
                    <div class="rounded-2xl bg-blue-100 dark:bg-blue-900/20 p-3">
                        <i data-lucide="loader" class="h-8 w-8 animate-spin text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div class="flex items-center space-x-1">
                        <div class="h-2 w-2 animate-pulse rounded-full bg-blue-500"></div>
                        <span class="text-xs font-medium text-blue-600 dark:text-blue-400">İşleniyor</span>
                    </div>
                </div>
                
                <h3 class="mb-2 text-sm font-semibold text-admin-600 dark:text-admin-400">Bekleyen Çekimler</h3>
                <p class="mb-3 text-3xl font-bold text-admin-900 dark:text-admin-100">
                    @foreach ($pending_withdrawn as $deposited)
                        @if (!empty($deposited->count))
                            {{ $settings->currency }}{{ number_format($deposited->count, 2) }}
                        @else
                            {{ $settings->currency }}0.00
                        @endif
                    @endforeach
                </p>
                
                <div class="flex items-center text-xs text-admin-500 dark:text-admin-400">
                    <i data-lucide="clock" class="mr-1 h-3 w-3"></i>
                    İnceleniyor
                </div>
            </div>
        </div>
    </div>

    <!-- User Statistics -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Users -->
        <div class="admin-card group relative overflow-hidden p-6">
            <div class="absolute -right-4 -top-4 h-20 w-20 rounded-full bg-gradient-to-br from-purple-500/10 to-purple-600/10"></div>
            <div class="relative">
                <div class="mb-4 flex items-center justify-between">
                    <div class="rounded-2xl bg-purple-100 dark:bg-purple-900/20 p-3">
                        <i data-lucide="users" class="h-6 w-6 text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <span class="rounded-full bg-purple-100 dark:bg-purple-900/20 px-3 py-1 text-xs font-semibold text-purple-700 dark:text-purple-300">
                        Toplam
                    </span>
                </div>
                <h3 class="mb-2 text-sm font-semibold text-admin-600 dark:text-admin-400">Toplam Kullanıcılar</h3>
                <p class="mb-3 text-2xl font-bold text-admin-900 dark:text-admin-100">{{ number_format($user_count) }}</p>
                <p class="text-xs text-admin-500 dark:text-admin-400">Kayıtlı tüm kullanıcılar</p>
            </div>
        </div>

        <!-- Active Users -->
        <div class="admin-card group relative overflow-hidden p-6">
            <div class="absolute -right-4 -top-4 h-20 w-20 rounded-full bg-gradient-to-br from-emerald-500/10 to-emerald-600/10"></div>
            <div class="relative">
                <div class="mb-4 flex items-center justify-between">
                    <div class="rounded-2xl bg-emerald-100 dark:bg-emerald-900/20 p-3">
                        <i data-lucide="user-check" class="h-6 w-6 text-emerald-600 dark:text-emerald-400"></i>
                    </div>
                    <div class="flex items-center space-x-1">
                        <div class="h-2 w-2 animate-pulse rounded-full bg-emerald-500"></div>
                        <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400">Çevrimiçi</span>
                    </div>
                </div>
                <h3 class="mb-2 text-sm font-semibold text-admin-600 dark:text-admin-400">Aktif Kullanıcılar</h3>
                <p class="mb-3 text-2xl font-bold text-admin-900 dark:text-admin-100">{{ $activeusers }}</p>
                <p class="text-xs text-admin-500 dark:text-admin-400">Şu anda aktif</p>
            </div>
        </div>

        <!-- Blocked Users -->
        <div class="admin-card group relative overflow-hidden p-6">
            <div class="absolute -right-4 -top-4 h-20 w-20 rounded-full bg-gradient-to-br from-rose-500/10 to-rose-600/10"></div>
            <div class="relative">
                <div class="mb-4 flex items-center justify-between">
                    <div class="rounded-2xl bg-rose-100 dark:bg-rose-900/20 p-3">
                        <i data-lucide="user-x" class="h-6 w-6 text-rose-600 dark:text-rose-400"></i>
                    </div>
                    <span class="rounded-full bg-rose-100 dark:bg-rose-900/20 px-3 py-1 text-xs font-semibold text-rose-700 dark:text-rose-300">
                        Engelli
                    </span>
                </div>
                <h3 class="mb-2 text-sm font-semibold text-admin-600 dark:text-admin-400">Engellenen Kullanıcılar</h3>
                <p class="mb-3 text-2xl font-bold text-admin-900 dark:text-admin-100">{{ $blockeusers }}</p>
                <p class="text-xs text-admin-500 dark:text-admin-400">Askıya alınmış hesaplar</p>
            </div>
        </div>

        <!-- Investment Plans -->
        <div class="admin-card group relative overflow-hidden p-6">
            <div class="absolute -right-4 -top-4 h-20 w-20 rounded-full bg-gradient-to-br from-amber-500/10 to-amber-600/10"></div>
            <div class="relative">
                <div class="mb-4 flex items-center justify-between">
                    <div class="rounded-2xl bg-amber-100 dark:bg-amber-900/20 p-3">
                        <i data-lucide="briefcase" class="h-6 w-6 text-amber-600 dark:text-amber-400"></i>
                    </div>
                    <span class="rounded-full bg-amber-100 dark:bg-amber-900/20 px-3 py-1 text-xs font-semibold text-amber-700 dark:text-amber-300">
                        Planlar
                    </span>
                </div>
                <h3 class="mb-2 text-sm font-semibold text-admin-600 dark:text-admin-400">Yatırım Planları</h3>
                <p class="mb-3 text-2xl font-bold text-admin-900 dark:text-admin-100">{{ $plans }}</p>
                <p class="text-xs text-admin-500 dark:text-admin-400">Mevcut planlar</p>
            </div>
        </div>
    </div>

    <!-- Analytics Chart -->
    <div class="admin-card overflow-hidden">
        <!-- Chart Header -->
        <div class="border-b border-admin-200 dark:border-admin-700 bg-gradient-to-r from-admin-50 to-blue-50 dark:from-admin-800 dark:to-blue-900/20 px-8 py-6">
            <div class="flex flex-col items-start justify-between space-y-4 lg:flex-row lg:items-center lg:space-y-0">
                <div>
                    <h2 class="flex items-center text-2xl font-bold text-admin-900 dark:text-admin-100">
                        <div class="mr-4 flex h-8 w-8 items-center justify-center rounded-xl bg-primary-600">
                            <i data-lucide="bar-chart-3" class="h-5 w-5 text-white"></i>
                        </div>
                        Gelişmiş Sistem Analitiği
                    </h2>
                    <p class="mt-2 text-admin-600 dark:text-admin-400">Kapsamlı finansal performans analizi ve trend görünümü</p>
                </div>
                
                <!-- Period Selector -->
                <div class="inline-flex rounded-2xl bg-white dark:bg-admin-800 p-1 shadow-sm border border-admin-200 dark:border-admin-700" role="group">
                    <button type="button" class="rounded-xl bg-primary-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-all duration-200">
                        Bu Ay
                    </button>
                    <button type="button" class="px-4 py-2 text-sm font-medium text-admin-500 hover:bg-admin-100 dark:hover:bg-admin-700 hover:text-primary-600 dark:hover:text-primary-400 transition-all duration-200">
                        Bu Hafta
                    </button>
                    <button type="button" class="px-4 py-2 text-sm font-medium text-admin-500 hover:bg-admin-100 dark:hover:bg-admin-700 hover:text-primary-600 dark:hover:text-primary-400 transition-all duration-200">
                        Bu Yıl
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Chart Content -->
        <div class="p-8">
            <div class="relative mb-8">
                <canvas id="analyticsChart" class="h-96 w-full"></canvas>
            </div>
            
            <!-- Chart Summary -->
            <div class="grid grid-cols-2 gap-6 lg:grid-cols-4">
                <div class="rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 p-6 text-center">
                    <div class="text-2xl font-bold text-emerald-800 dark:text-emerald-200">{{ $settings->currency }}{{ number_format($chart_pdepsoit, 2) }}</div>
                    <div class="mt-1 text-sm font-medium text-emerald-600 dark:text-emerald-300">Toplam Yatırımlar</div>
                </div>
                <div class="rounded-2xl bg-gradient-to-br from-rose-50 to-rose-100 dark:from-rose-900/20 dark:to-rose-800/20 p-6 text-center">
                    <div class="text-2xl font-bold text-rose-800 dark:text-rose-200">{{ $settings->currency }}{{ number_format($chart_pwithdraw, 2) }}</div>
                    <div class="mt-1 text-sm font-medium text-rose-600 dark:text-rose-300">Toplam Çekimler</div>
                </div>
                <div class="rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 p-6 text-center">
                    <div class="text-2xl font-bold text-amber-800 dark:text-amber-200">{{ $settings->currency }}{{ number_format($chart_pendepsoit, 2) }}</div>
                    <div class="mt-1 text-sm font-medium text-amber-600 dark:text-amber-300">Bekleyen Yatırımlar</div>
                </div>
                <div class="rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 p-6 text-center">
                    <div class="text-2xl font-bold text-blue-800 dark:text-blue-200">{{ $settings->currency }}{{ number_format($chart_trans, 2) }}</div>
                    <div class="mt-1 text-sm font-medium text-blue-600 dark:text-blue-300">Toplam İşlemler</div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Live clock update
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('tr-TR', {
            hour12: false,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        
        const clockElement = document.getElementById('live-clock');
        if (clockElement) {
            clockElement.textContent = timeString;
        }
    }
    
    updateClock();
    setInterval(updateClock, 1000);
    
    // Initialize Chart
    const ctx = document.getElementById('analyticsChart');
    if (ctx) {
        const chartData = [
            {{ $chart_pdepsoit ?? 0 }},
            {{ $chart_pendepsoit ?? 0 }},
            {{ $chart_pwithdraw ?? 0 }},
            {{ $chart_pendwithdraw ?? 0 }},
            {{ $chart_trans ?? 0 }}
        ];
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Toplam Yatırımlar', 'Bekleyen Yatırımlar', 'Toplam Çekimler', 'Bekleyen Çekimler', 'Toplam İşlemler'],
                datasets: [{
                    data: chartData,
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)', 
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(139, 92, 246, 0.8)'
                    ],
                    borderColor: [
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)',
                        'rgb(239, 68, 68)',
                        'rgb(59, 130, 246)', 
                        'rgb(139, 92, 246)'
                    ],
                    borderWidth: 3,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 13,
                                family: "'Inter', sans-serif",
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.9)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: 'rgba(255, 255, 255, 0.2)',
                        borderWidth: 1,
                        cornerRadius: 12,
                        padding: 15,
                        titleFont: { size: 14, weight: '600' },
                        bodyFont: { size: 13 },
                        callbacks: {
                            label: function(context) {
                                const value = new Intl.NumberFormat('tr-TR').format(context.parsed);
                                return `${context.label}: {{ $settings->currency }}${value}`;
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1500,
                    easing: 'easeOutQuart'
                }
            }
        });
    }
});
</script>
@endpush