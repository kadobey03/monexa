@extends('layouts.app')
@section('title', 'Investment Plans')

@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    
    <!-- Main Content -->
    <div class="flex-1 ml-0 md:ml-64 transition-all duration-300">
        <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
            <!-- Header Section -->
            <div class="bg-white border-b border-gray-200 shadow-sm">
                <div class="px-4 py-6 sm:px-6 lg:px-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                            <div class="p-3 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Yatırım Planları</h1>
                                <p class="text-gray-600 mt-1">Tüm yatırım planlarını görüntüleyin ve yönetin</p>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                            <a href="{{ route('admin.plans.categories') }}" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                                Plan Kategorileri
                            </a>
                            <a href="{{ route('admin.plans.create') }}" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                </svg>
                                Yeni Plan Ekle
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Alert Messages -->
            <div class="px-4 sm:px-6 lg:px-8 pt-4">
                @include('admin.atlantis.layout.alert')
            </div>
            
            <!-- Statistics Cards -->
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Total Plans -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Toplam Plan</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ count($plans) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Active Plans -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Aktif Plan</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $plans->where('is_active', true)->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Featured Plans -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Öne Çıkan</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $plans->where('is_featured', true)->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Inactive Plans -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 bg-gradient-to-r from-red-500 to-rose-600 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Pasif Plan</p>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $plans->where('is_active', false)->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Main Table -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <!-- Table Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold text-gray-900">Plan Listesi</h2>
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center space-x-2 bg-white px-3 py-2 rounded-lg border border-gray-200">
                                    <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                    <input type="text" placeholder="Plan ara..." class="border-0 focus:ring-0 focus:outline-none text-sm w-32" id="searchInput">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Table Content -->
                    <div class="overflow-x-auto">
                        <table id="plansTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Plan Adı
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kategori
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fiyat Aralığı
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Getiri Oranı
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Süre
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Durum
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Öne Çıkan
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        İşlemler
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($plans as $plan)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <!-- Plan Name -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($plan->icon)
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $plan->icon) }}" alt="{{ $plan->name }}">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $plan->name }}</div>
                                                    </div>
                                                @else
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                                            <span class="text-sm font-medium text-white">{{ substr($plan->name, 0, 1) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $plan->name }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        
                                        <!-- Category -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($plan->category)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                    {{ $plan->category->name }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                    Kategori Yok
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <!-- Price Range -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="p-1 bg-green-100 rounded-lg mr-2">
                                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-semibold text-gray-900">{{ $settings->currency }}{{ number_format($plan->min_amount, 2) }}</div>
                                                    <div class="text-xs text-gray-500">{{ $settings->currency }}{{ number_format($plan->max_amount, 2) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- ROI -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="p-1 bg-purple-100 rounded-lg mr-2">
                                                    <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <span class="text-sm font-semibold text-purple-700">{{ $plan->roi_percentage }}%</span>
                                                <span class="text-xs text-gray-500 ml-1">/ {{ $plan->roi_interval }}</span>
                                            </div>
                                        </td>
                                        
                                        <!-- Duration -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-teal-100 text-teal-800">
                                                {{ $plan->duration }} {{ $plan->duration_unit }}
                                            </span>
                                        </td>
                                        
                                        <!-- Status -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('admin.plans.toggle', $plan) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ $plan->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                                    @if($plan->is_active)
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        Aktif
                                                    @else
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        Pasif
                                                    @endif
                                                </button>
                                            </form>
                                        </td>
                                        
                                        <!-- Featured -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($plan->is_featured)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    Öne Çıkan
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    Hayır
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('admin.plans.edit', $plan) }}" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                                    </svg>
                                                    Düzenle
                                                </a>
                                                <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('Bu planı silmek istediğinizden emin misiniz?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                        </svg>
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
                                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                    <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                                    </svg>
                                                </div>
                                                <h3 class="text-lg font-medium text-gray-900 mb-2">Yatırım Planı Bulunamadı</h3>
                                                <p class="text-gray-500 mb-6">Henüz hiç yatırım planı oluşturulmamış.</p>
                                                <a href="{{ route('admin.plans.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                    </svg>
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