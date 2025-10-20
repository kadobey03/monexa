@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    
    <!-- Main Content -->
    <div class="admin-main-content flex-1 lg:ml-64 transition-all duration-300">
        <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
            <!-- Header Section -->
            <div class="bg-white border-b border-gray-200 shadow-sm">
                <div class="px-4 py-6 sm:px-6 lg:px-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                            <div class="p-3 bg-gradient-to-r from-red-500 to-rose-600 rounded-xl shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Müşteri Çekimlerini Yönet</h1>
                                <p class="text-gray-600 mt-1">Tüm müşteri çekim taleplerini buradan yönetebilirsiniz</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="bg-red-100 text-red-800 px-4 py-2 rounded-full font-semibold">
                                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                {{ count($withdrawals) }} Toplam Talep
                            </div>
                            <button onclick="refreshTable()" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                </svg>
                                Yenile
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Alert Messages -->
            <div class="px-4 sm:px-6 lg:px-8 pt-4">
                <x-danger-alert />
                <x-success-alert />
            </div>
            
            <!-- Statistics Cards -->
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Pending -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-yellow-500 to-orange-600 p-6 text-white relative">
                            <div class="absolute inset-0 bg-white/10 transform -skew-y-3 translate-y-8"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-yellow-100 text-sm font-medium">Bekleyen</p>
                                        <p class="text-2xl font-bold mt-1">{{ collect($withdrawals)->where('status', '!=', 'Processed')->count() }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-yellow-50">
                            <div class="flex items-center text-yellow-600 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                Onay bekliyor
                            </div>
                        </div>
                    </div>
                    
                    <!-- Processed -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6 text-white relative">
                            <div class="absolute inset-0 bg-white/10 transform -skew-y-3 translate-y-8"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-green-100 text-sm font-medium">İşlenen</p>
                                        <p class="text-2xl font-bold mt-1">{{ collect($withdrawals)->where('status', 'Processed')->count() }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-green-50">
                            <div class="flex items-center text-green-600 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Tamamlananlar
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Amount -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-6 text-white relative">
                            <div class="absolute inset-0 bg-white/10 transform -skew-y-3 translate-y-8"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-blue-100 text-sm font-medium">Toplam Tutar</p>
                                        <p class="text-2xl font-bold mt-1">{{ $settings->currency }}{{ number_format(collect($withdrawals)->sum('amount')) }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-blue-50">
                            <div class="flex items-center text-blue-600 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                </svg>
                                Tüm çekimler
                            </div>
                        </div>
                    </div>
                    
                    <!-- This Month -->
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-6 text-white relative">
                            <div class="absolute inset-0 bg-white/10 transform -skew-y-3 translate-y-8"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-purple-100 text-sm font-medium">Bu Ay</p>
                                        <p class="text-2xl font-bold mt-1">{{ collect($withdrawals)->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                                    </div>
                                    <div class="p-3 bg-white/20 rounded-full">
                                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-purple-50">
                            <div class="flex items-center text-purple-600 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                Son 30 gün
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Main Table -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <!-- Table Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold text-gray-900">Çekim Talepleri</h2>
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center space-x-2 bg-white px-3 py-2 rounded-lg border border-gray-200">
                                    <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                    <input type="text" placeholder="Çekim ara..." class="border-0 focus:ring-0 focus:outline-none text-sm w-32" id="searchInput">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Table Content -->
                    <div class="overflow-x-auto">
                        <table id="withdrawalsTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Müşteri Adı
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Talep Edilen Tutar
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tutar + Masraflar
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ödeme Yöntemi
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        E-posta
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Durum
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tarih
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        İşlemler
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($withdrawals as $withdrawal)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <!-- Customer Name -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if (isset($withdrawal->duser->name) && $withdrawal->duser->name != null)
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                                            <span class="text-sm font-medium text-white">{{ strtoupper(substr($withdrawal->duser->name, 0, 2)) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $withdrawal->duser->name }}</div>
                                                        <div class="text-sm text-gray-500">ID: {{ $withdrawal->duser->id ?? 'N/A' }}</div>
                                                    </div>
                                                @else
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-500">Kullanıcı Silindi</div>
                                                        <div class="text-sm text-gray-400">Hesap mevcut değil</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        
                                        <!-- Requested Amount -->
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                                {{ $settings->currency }}{{ number_format($withdrawal->amount) }}
                                            </div>
                                        </td>
                                        
                                        <!-- Amount + Fees -->
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                                {{ $settings->currency }}{{ number_format($withdrawal->to_deduct) }}
                                            </div>
                                        </td>
                                        
                                        <!-- Payment Method -->
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    @if(strtolower($withdrawal->payment_mode) == 'bank')
                                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                                                    @else
                                                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    @endif
                                                </svg>
                                                {{ $withdrawal->payment_mode }}
                                            </span>
                                        </td>
                                        
                                        <!-- Email -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900" title="{{ $withdrawal->duser->email ?? 'N/A' }}">
                                                {{ Str::limit($withdrawal->duser->email ?? 'N/A', 25) }}
                                            </div>
                                        </td>
                                        
                                        <!-- Status -->
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if ($withdrawal->status == 'Processed')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    İşlendi
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Bekliyor
                                                </span>
                                            @endif
                                        </td>
                                        
                                        <!-- Date -->
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center text-sm text-gray-900">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                                </svg>
                                                <div>
                                                    <div class="font-medium">{{ \Carbon\Carbon::parse($withdrawal->created_at)->format('d M Y') }}</div>
                                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($withdrawal->created_at)->format('H:i') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <a href="{{ route('processwithdraw', $withdrawal->id) }}"
                                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                Görüntüle
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                    <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz Çekim Talebi Yok</h3>
                                                <p class="text-gray-500 mb-6">Müşterilerden gelen çekim talepleri burada listelenecek.</p>
                                                <button onclick="refreshTable()" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Sayfayı Yenile
                                                </button>
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
    
    <!-- JavaScript -->
    <script>
        function refreshTable() {
            // Add loading state
            const table = document.getElementById('withdrawalsTable');
            table.style.opacity = '0.6';
            
            // Simulate refresh (replace with actual AJAX call if needed)
            setTimeout(() => {
                table.style.opacity = '1';
                // Show success message if you have a notification system
                console.log('Tablo yenilendi');
            }, 1000);
        }
        
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#withdrawalsTable tbody tr');
            
            rows.forEach(row => {
                if (row.cells.length > 1) { // Skip empty state row
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    </script>
@endsection