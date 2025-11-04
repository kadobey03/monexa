@extends('layouts.admin', ['title' => 'Aktif Müşteri İşlemleri'])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Aktif Müşteri İşlemleri</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Müşteri yatırımlarını ve aktif işlemlerini görüntüleyin</p>
    </div>

    <x-danger-alert />
    <x-success-alert />
            
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total Active Trades -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <x-heroicon name="activity" class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Toplam Aktif İşlem</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ count($plans) }}</p>
                </div>
            </div>
        </div>
        
        <!-- Total Investment -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                        <x-heroicon name="currency-dollar" class="h-6 w-6 text-green-600 dark:text-green-400" />
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Toplam Yatırım</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $settings->currency }}{{ number_format($plans->sum('amount')) }}</p>
                </div>
            </div>
        </div>
        
        <!-- Total Profit -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                        <x-heroicon name="arrow-trending-up" class="h-6 w-6 text-purple-600 dark:text-purple-400" />
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Toplam Kâr</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $settings->currency }}{{ number_format($plans->sum('profit_earned')) }}</p>
                </div>
            </div>
        </div>
        
        <!-- Active Users -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                        <x-heroicon name="users" class="h-6 w-6 text-orange-600 dark:text-orange-400" />
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aktif Kullanıcı</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $plans->where('puser')->count() }}</p>
                </div>
            </div>
        </div>
    </div>
                
    <!-- Main Table -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Aktif Yatırım İşlemleri</h3>
                <div class="flex items-center space-x-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon name="magnifying-glass" class="h-4 w-4 text-gray-400" />
                        </div>
                        <input type="text"
                               placeholder="Arama..."
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md leading-5 bg-white dark:bg-admin-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm"
                               id="searchInput">
                    </div>
                </div>
            </div>
        </div>
                    
        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table id="investmentTable" class="min-w-full divide-y divide-gray-200 dark:divide-admin-700">
                <thead class="bg-gray-50 dark:bg-admin-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>Müşteri Adı</span>
                                <x-heroicon name="chevron-down" class="h-3 w-3 text-gray-400" />
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Varlıklar
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Yatırım Miktarı
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Süre
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Kâr Getirisi
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Başlangıç Tarihi
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Bitiş Tarihi
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            İşlemler
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-admin-800 divide-y divide-gray-200 dark:divide-admin-700">
                    @forelse($plans as $plan)
                        <tr class="hover:bg-gray-50 dark:hover:bg-admin-700 transition-colors duration-200">
                            <!-- Customer Name -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if(isset($plan->puser->name) && $plan->puser->name != null)
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ substr($plan->puser->name, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $plan->puser->name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $plan->puser->email ?? 'Email not available' }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                                    <x-heroicon name="user-minus" class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                                    Kullanıcı Silindi
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Assets -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                    {{ $plan->assets }}
                                </span>
                            </td>
                            
                            <!-- Investment Amount -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(isset($plan->puser->currency) && $plan->puser->currency != null)
                                    <div class="flex items-center">
                                        <x-heroicon name="currency-dollar" class="w-4 h-4 text-green-600 dark:text-green-400 mr-2" />
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $plan->puser->currency }}{{ number_format($plan->amount) }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">N/A</span>
                                @endif
                            </td>
                            
                            <!-- Duration -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                    {{ $plan->inv_duration }}
                                </span>
                            </td>
                            
                            <!-- ROI -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(isset($plan->puser->currency) && $plan->puser->currency != null)
                                    <div class="flex items-center">
                                        <x-heroicon name="arrow-trending-up" class="w-4 h-4 text-emerald-600 dark:text-emerald-400 mr-2" />
                                        <span class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">{{ $plan->puser->currency }}{{ $plan->profit_earned ? number_format($plan->profit_earned) : '0' }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">N/A</span>
                                @endif
                            </td>
                            
                            <!-- Start Date -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                <div class="flex items-center">
                                    <x-heroicon name="calendar-days" class="w-4 h-4 text-gray-400 dark:text-gray-500 mr-2" />
                                    {{ $plan->created_at->format('d/m/Y H:i') }}
                                </div>
                            </td>
                            
                            <!-- End Date -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                <div class="flex items-center">
                                    <x-heroicon name="calendar-x" class="w-4 h-4 text-gray-400 dark:text-gray-500 mr-2" />
                                    {{ \Carbon\Carbon::parse($plan->expire_date)->format('d/m/Y H:i') }}
                                </div>
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open"
                                            class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                                        İşlemler
                                        <x-heroicon name="chevron-down" class="ml-2 h-4 w-4" />
                                    </button>
                                    <div x-show="open"
                                         @click.away="open = false"
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-admin-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                                         role="menu">
                                        <div class="py-1" role="none">
                                            <a href="{{ route('deleteplan', $plan->id) }}"
                                               onclick="return confirm('Bu işlemi silmek istediğinizden emin misiniz?')"
                                               class="flex items-center px-4 py-2 text-sm text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-admin-700 hover:text-red-900 dark:hover:text-red-300"
                                               role="menuitem">
                                                <x-heroicon name="trash-2" class="w-4 h-4 mr-3" />
                                                Sil
                                            </a>
                                            @if(isset($plan->puser) && $plan->puser)
                                                <a href="{{ route('user.plans', $plan->puser->id) }}"
                                                   class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-admin-700 hover:text-gray-900 dark:hover:text-white"
                                                   role="menuitem">
                                                    <x-heroicon name="user" class="w-4 h-4 mr-3" />
                                                    Kullanıcı Detayları
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <x-heroicon name="activity" class="h-12 w-12 text-gray-400 dark:text-gray-500 mb-4" />
                                    <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Aktif İşlem Bulunamadı</h3>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">Şu anda hiç aktif yatırım işlemi bulunmuyor.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- JavaScript for Search Functionality -->
<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#investmentTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection