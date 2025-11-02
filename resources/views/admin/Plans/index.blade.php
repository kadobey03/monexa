@extends('layouts.admin', ['title' => 'Yatırım Planları'])

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Yatırım Planları</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Tüm yatırım planlarını görüntüleyin ve yönetin</p>
        </div>
        
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 mt-4 sm:mt-0">
            <a href="{{ route('admin.plans.categories') }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                <i data-lucide="grid" class="h-4 w-4 mr-2"></i>
                Plan Kategorileri
            </a>
            <a href="{{ route('admin.plans.create') }}"
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                <i data-lucide="plus" class="h-4 w-4 mr-2"></i>
                Yeni Plan Ekle
            </a>
        </div>
    </div>

    <x-danger-alert />
    <x-success-alert />
            
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total Plans -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <i data-lucide="credit-card" class="h-6 w-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Toplam Plan</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ count($plans) }}</p>
                </div>
            </div>
        </div>
        
        <!-- Active Plans -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                        <i data-lucide="check-circle" class="h-6 w-6 text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aktif Plan</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $plans->where('is_active', true)->count() }}</p>
                </div>
            </div>
        </div>
        
        <!-- Featured Plans -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                        <i data-lucide="star" class="h-6 w-6 text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Öne Çıkan</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $plans->where('is_featured', true)->count() }}</p>
                </div>
            </div>
        </div>
        
        <!-- Inactive Plans -->
        <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                        <i data-lucide="x-circle" class="h-6 w-6 text-red-600 dark:text-red-400"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pasif Plan</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $plans->where('is_active', false)->count() }}</p>
                </div>
            </div>
        </div>
    </div>
                
    <!-- Main Table -->
    <div class="bg-white dark:bg-admin-800 rounded-lg shadow-sm border border-gray-200 dark:border-admin-700 overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Plan Listesi</h3>
                <div class="flex items-center space-x-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="h-4 w-4 text-gray-400"></i>
                        </div>
                        <input type="text"
                               placeholder="Plan ara..."
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md leading-5 bg-white dark:bg-admin-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm"
                               id="searchInput">
                    </div>
                </div>
            </div>
        </div>
                    
        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table id="plansTable" class="min-w-full divide-y divide-gray-200 dark:divide-admin-700">
                <thead class="bg-gray-50 dark:bg-admin-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Plan Adı
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Kategori
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Fiyat Aralığı
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Getiri Oranı
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Süre
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Durum
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Öne Çıkan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            İşlemler
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-admin-800 divide-y divide-gray-200 dark:divide-admin-700">
                    @forelse($plans as $plan)
                        <tr class="hover:bg-gray-50 dark:hover:bg-admin-700 transition-colors duration-200">
                            <!-- Plan Name -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($plan->icon)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $plan->icon) }}" alt="{{ $plan->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $plan->name }}</div>
                                        </div>
                                    @else
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                <span class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ substr($plan->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $plan->name }}</div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Category -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($plan->category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                        {{ $plan->category->name }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300">
                                        Kategori Yok
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Price Range -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i data-lucide="dollar-sign" class="w-4 h-4 text-green-600 dark:text-green-400 mr-2"></i>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $settings->currency }}{{ number_format($plan->min_amount, 2) }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $settings->currency }}{{ number_format($plan->max_amount, 2) }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- ROI -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <i data-lucide="trending-up" class="w-4 h-4 text-purple-600 dark:text-purple-400 mr-2"></i>
                                    <span class="text-sm font-semibold text-purple-700 dark:text-purple-300">{{ $plan->roi_percentage }}%</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">/ {{ $plan->roi_interval }}</span>
                                </div>
                            </td>
                            
                            <!-- Duration -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-300">
                                    {{ $plan->duration }} {{ $plan->duration_unit }}
                                </span>
                            </td>
                            
                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.plans.toggle', $plan) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-all duration-200 {{ $plan->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200 dark:bg-green-900 dark:text-green-300 dark:hover:bg-green-800' : 'bg-red-100 text-red-800 hover:bg-red-200 dark:bg-red-900 dark:text-red-300 dark:hover:bg-red-800' }}">
                                        @if($plan->is_active)
                                            <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>
                                            Aktif
                                        @else
                                            <i data-lucide="x-circle" class="w-3 h-3 mr-1"></i>
                                            Pasif
                                        @endif
                                    </button>
                                </form>
                            </td>
                            
                            <!-- Featured -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($plan->is_featured)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                        <i data-lucide="star" class="w-3 h-3 mr-1"></i>
                                        Öne Çıkan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300">
                                        Hayır
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.plans.edit', $plan) }}"
                                       class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                                        <i data-lucide="edit" class="w-3 h-3 mr-1"></i>
                                        Düzenle
                                    </a>
                                    <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('Bu planı silmek istediğinizden emin misiniz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-admin-800">
                                            <i data-lucide="trash-2" class="w-3 h-3 mr-1"></i>
                                            Sil
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="credit-card" class="h-12 w-12 text-gray-400 dark:text-gray-500 mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-500 dark:text-gray-400">Yatırım Planı Bulunamadı</h3>
                                    <p class="text-gray-400 dark:text-gray-500 text-sm mt-1 mb-6">Henüz hiç yatırım planı oluşturulmamış.</p>
                                    <a href="{{ route('admin.plans.create') }}"
                                       class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-admin-800">
                                        <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                                        İlk Planı Oluştur
                                    </a>
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
        const rows = document.querySelectorAll('#plansTable tbody tr');
        
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