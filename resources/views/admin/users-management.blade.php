@php
    $isDark = Auth('admin')->User()->dashboard_style !== 'light';
@endphp

@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-admin-50 {{ $isDark ? 'dark:bg-admin-900' : '' }}">
    <!-- Header Section -->
    <div class="bg-admin-100 {{ $isDark ? 'dark:bg-admin-800' : '' }} border-b border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }}">
        <div class="max-w-none mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} flex items-center">
                        <i class="fas fa-users text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} mr-4 text-4xl"></i>
                        Kullanıcı Yönetimi
                    </h1>
                    <p class="mt-2 text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">
                        Platform kullanıcılarını görüntüle, düzenle ve yönet
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="bg-admin-200 {{ $isDark ? 'dark:bg-admin-700' : '' }} px-4 py-2 rounded-full">
                        <span class="text-admin-800 {{ $isDark ? 'dark:text-admin-200' : '' }} font-semibold">
                            <i class="fas fa-user-check mr-2"></i>
                            {{ $user_count ?? 0 }} Toplam Kullanıcı
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="max-w-none mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white {{ $isDark ? 'dark:bg-admin-800' : '' }} rounded-xl shadow-sm border border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }} p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-r from-admin-500 to-admin-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">Toplam</p>
                        <p class="text-3xl font-bold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">{{ $user_count ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Active Users -->
            <div class="bg-white {{ $isDark ? 'dark:bg-admin-800' : '' }} rounded-xl shadow-sm border border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }} p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-check text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">Aktif</p>
                        <p class="text-3xl font-bold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">{{ $active_users ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Pending Verification -->
            <div class="bg-white {{ $isDark ? 'dark:bg-admin-800' : '' }} rounded-xl shadow-sm border border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }} p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">Bekleyen</p>
                        <p class="text-3xl font-bold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">{{ $pending_verification ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Blocked Users -->
            <div class="bg-white {{ $isDark ? 'dark:bg-admin-800' : '' }} rounded-xl shadow-sm border border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }} p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-times text-white text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">Engellenen</p>
                        <p class="text-3xl font-bold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">{{ $blocked_users ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advanced Filter Section -->
        <div class="bg-white {{ $isDark ? 'dark:bg-admin-800' : '' }} rounded-lg shadow-sm border border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }} mb-6 p-6">
            <form method="GET" action="{{ route('manageusers') }}" class="space-y-4">
                
                <!-- Filter Header -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-admin-500 to-admin-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-filter text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">
                                Gelişmiş Filtreleme
                            </h3>
                            <p class="text-sm text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">
                                Kullanıcıları status, admin, tarih aralığı ile filtreleyin
                            </p>
                        </div>
                    </div>
                    
                    <!-- Active Filters Count -->
                    @php
                        $activeFilters = collect([request('status'), request('admin'), request('date_from'), request('date_to')])->filter()->count();
                    @endphp
                    @if($activeFilters > 0)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-admin-100 text-admin-800 {{ $isDark ? 'dark:bg-admin-700 dark:text-admin-200' : '' }}">
                            <i class="fas fa-filter mr-1"></i>
                            {{ $activeFilters }} Aktif Filtre
                        </span>
                    @endif
                </div>

                <!-- Filter Controls Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                    
                    <!-- STATUS Filter -->
                    <div class="lg:col-span-1">
                        <label class="block text-xs font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} mb-2">
                            <i class="fas fa-flag text-admin-500 mr-1"></i>
                            LEAD STATUS
                        </label>
                        <select name="status" class="w-full text-sm border-admin-300 {{ $isDark ? 'dark:border-admin-600 dark:bg-admin-700' : '' }} rounded-md focus:border-indigo-500 focus:ring-indigo-500 bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">
                            <option value="">Tüm Durumlar</option>
                            @if(isset($leadStatuses) && $leadStatuses->count() > 0)
                                @foreach($leadStatuses as $status)
                                    <option value="{{ $status->name }}" {{ request('status') == $status->name ? 'selected' : '' }}>
                                        {{ $status->display_name ?: $status->name }}
                                    </option>
                                @endforeach
                            @else
                                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>Yeni</option>
                                <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>İletişimde</option>
                                <option value="qualified" {{ request('status') == 'qualified' ? 'selected' : '' }}>Nitelikli</option>
                                <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>Dönüştürülmüş</option>
                                <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>Kayıp</option>
                            @endif
                        </select>
                    </div>

                    <!-- ADMIN Filter -->
                    <div class="lg:col-span-1">
                        <label class="block text-xs font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} mb-2">
                            <i class="fas fa-user-tie text-admin-500 mr-1"></i>
                            ASSIGNED ADMIN
                        </label>
                        <select name="admin" class="w-full text-sm border-admin-300 {{ $isDark ? 'dark:border-admin-600 dark:bg-admin-700' : '' }} rounded-md focus:border-indigo-500 focus:ring-indigo-500 bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">
                            <option value="">Tüm Adminler</option>
                            @if(isset($admins) && $admins->count() > 0)
                                @foreach($admins as $admin)
                                    <option value="{{ is_array($admin) ? $admin['id'] : $admin->id }}" {{ request('admin') == (is_array($admin) ? $admin['id'] : $admin->id) ? 'selected' : '' }}>
                                        {{ is_array($admin) ? ($admin['name'] ?? $admin['label']) : $admin->getDisplayName() }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- DATE FROM Filter -->
                    <div class="lg:col-span-1">
                        <label class="block text-xs font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} mb-2">
                            <i class="fas fa-calendar text-admin-500 mr-1"></i>
                            BAŞLANGIÇ TARİHİ
                        </label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                               class="w-full text-sm border-admin-300 {{ $isDark ? 'dark:border-admin-600 dark:bg-admin-700' : '' }} rounded-md focus:border-indigo-500 focus:ring-indigo-500 bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">
                    </div>

                    <!-- DATE TO Filter -->
                    <div class="lg:col-span-1">
                        <label class="block text-xs font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} mb-2">
                            <i class="fas fa-calendar text-admin-500 mr-1"></i>
                            BİTİŞ TARİHİ
                        </label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                               class="w-full text-sm border-admin-300 {{ $isDark ? 'dark:border-admin-600 dark:bg-admin-700' : '' }} rounded-md focus:border-indigo-500 focus:ring-indigo-500 bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">
                    </div>

                    <!-- Action Buttons -->
                    <div class="lg:col-span-2 flex items-end space-x-3">
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2.5 bg-admin-600 hover:bg-admin-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Filtrele
                        </button>
                        
                        <a href="{{ route('manageusers') }}"
                           class="inline-flex items-center px-4 py-2.5 bg-admin-100 hover:bg-admin-200 {{ $isDark ? 'dark:bg-admin-700 dark:hover:bg-admin-600' : '' }} text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} font-medium rounded-lg shadow-sm transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Temizle
                        </a>
                    </div>

                </div>

                <!-- Filter Summary -->
                @if(request()->hasAny(['status', 'admin', 'date_from', 'date_to']))
                    <div class="mt-4 pt-4 border-t border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }}">
                        <div class="flex items-center space-x-4 flex-wrap">
                            <span class="text-xs font-medium text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">
                                Aktif Filtreler:
                            </span>
                            
                            @if(request('status'))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 {{ $isDark ? 'dark:bg-blue-800 dark:text-blue-100' : '' }}">
                                    Status: {{ ucfirst(request('status')) }}
                                </span>
                            @endif
                            
                            @if(request('admin'))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 {{ $isDark ? 'dark:bg-green-800 dark:text-green-100' : '' }}">
                                    Admin: {{ isset($admins) ? ($admins->first(function($admin) { return (is_array($admin) ? $admin['id'] : $admin->id) == request('admin'); })['name'] ?? $admins->first(function($admin) { return (is_array($admin) ? $admin['id'] : $admin->id) == request('admin'); })['label'] ?? 'ID ' . request('admin')) : 'ID ' . request('admin') }}
                                </span>
                            @endif
                            
                            @if(request('date_from'))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 {{ $isDark ? 'dark:bg-yellow-800 dark:text-yellow-100' : '' }}">
                                    Başlangıç: {{ \Carbon\Carbon::parse(request('date_from'))->format('d.m.Y') }}
                                </span>
                            @endif
                            
                            @if(request('date_to'))
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 {{ $isDark ? 'dark:bg-purple-800 dark:text-purple-100' : '' }}">
                                    Bitiş: {{ \Carbon\Carbon::parse(request('date_to'))->format('d.m.Y') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

            </form>
        </div>

        <!-- Main Table Container -->
        <div class="bg-white {{ $isDark ? 'dark:bg-admin-800' : '' }} rounded-xl shadow-lg border border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }} overflow-hidden">
            
            <!-- Enhanced Table Header with Results Display -->
            <div class="bg-gradient-to-r from-admin-600 to-admin-700 px-6 py-5">
                <!-- Users Table Header Enhancement -->
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-lg font-medium text-white">Kullanıcı Listesi</h3>
                        <div class="text-sm text-admin-200">
                            @if(isset($users))
                                @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                    {{ $users->total() }} kullanıcı bulundu
                                    @if(request()->hasAny(['status', 'admin', 'date_from', 'date_to']))
                                        <span class="text-admin-300">
                                            <i class="fas fa-filter ml-1 mr-1"></i>(filtrelenmiş)
                                        </span>
                                    @endif
                                @else
                                    {{ $users->count() }} kullanıcı gösteriliyor
                                    @if(request()->hasAny(['status', 'admin', 'date_from', 'date_to']))
                                        <span class="text-admin-300">
                                            <i class="fas fa-filter ml-1 mr-1"></i>(filtrelenmiş)
                                        </span>
                                    @endif
                                @endif
                            @else
                                0 kullanıcı gösteriliyor
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                    <!-- Search Section -->
                    <div class="flex-1 lg:max-w-md">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-admin-300"></i>
                            </div>
                            <input type="search"
                                   id="user-search"
                                   class="block w-full pl-10 pr-12 py-3 border border-admin-400 rounded-lg bg-white/90 placeholder-admin-500 focus:outline-none focus:ring-2 focus:ring-admin-300 focus:border-transparent text-sm font-medium text-admin-900"
                                   placeholder="🔍 İsim, e-posta veya telefon ile ara..."
                                   onkeyup="filterTable()"
                                   autocomplete="off">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-3">
                        <button onclick="exportUsers()"
                                class="inline-flex items-center px-4 py-2 bg-admin-500 hover:bg-admin-600 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                            <i class="fas fa-download mr-2"></i>Dışa Aktar
                        </button>
                        <button onclick="openAddUserModal()"
                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                            <i class="fas fa-user-plus mr-2"></i>Yeni Kullanıcı
                        </button>
                    </div>
                </div>
            </div>

            <!-- Enhanced Table Design -->
            <div class="overflow-x-auto">
                <table class="min-w-full table-fixed" id="users-table">
                    <!-- Enhanced Table Header -->
                    <thead class="bg-gradient-to-r from-admin-100 to-admin-50 {{ $isDark ? 'dark:from-admin-700 dark:to-admin-750' : '' }} border-b-2 border-admin-200 {{ $isDark ? 'dark:border-admin-600' : '' }}">
                        <tr>
                            <th scope="col" class="w-10 px-4 py-4 text-left">
                                <input type="checkbox" id="select-all"
                                       class="w-4 h-4 rounded border-admin-300 text-admin-600 shadow-sm focus:border-admin-500 focus:ring-admin-500 focus:ring-2"
                                       onchange="toggleAllUsers(this)">
                            </th>
                            <th scope="col" class="w-44 px-4 py-4 text-left text-sm font-semibold text-admin-800 {{ $isDark ? 'dark:text-admin-200' : '' }} uppercase tracking-wide">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} text-sm"></i>
                                    <span class="font-bold">Kullanıcı</span>
                                </div>
                            </th>
                            <th scope="col" class="w-36 px-4 py-4 text-left text-sm font-semibold text-admin-800 {{ $isDark ? 'dark:text-admin-200' : '' }} uppercase tracking-wide">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-envelope text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} text-sm"></i>
                                    <span class="font-bold">Email</span>
                                </div>
                            </th>
                            <th scope="col" class="w-28 px-4 py-4 text-left text-sm font-semibold text-admin-800 {{ $isDark ? 'dark:text-admin-200' : '' }} uppercase tracking-wide">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-phone text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} text-sm"></i>
                                    <span class="font-bold">Telefon</span>
                                </div>
                            </th>
                            <th scope="col" class="w-28 px-4 py-4 text-left text-sm font-semibold text-admin-800 {{ $isDark ? 'dark:text-admin-200' : '' }} uppercase tracking-wide">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-calendar text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} text-sm"></i>
                                    <span class="font-bold">Tarih</span>
                                </div>
                            </th>
                            <th scope="col" class="w-36 px-4 py-4 text-center text-sm font-semibold text-admin-800 {{ $isDark ? 'dark:text-admin-200' : '' }} uppercase tracking-wide">
                                <div class="flex items-center justify-center space-x-2">
                                    <i class="fas fa-flag text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} text-sm"></i>
                                    <span class="font-bold">Lead Status</span>
                                </div>
                            </th>
                            <th scope="col" class="w-36 px-4 py-4 text-center text-sm font-semibold text-admin-800 {{ $isDark ? 'dark:text-admin-200' : '' }} uppercase tracking-wide">
                                <div class="flex items-center justify-center space-x-2">
                                    <i class="fas fa-user-tie text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} text-sm"></i>
                                    <span class="font-bold">Admin</span>
                                </div>
                            </th>
                            <th scope="col" class="w-32 px-4 py-4 text-left text-sm font-semibold text-admin-800 {{ $isDark ? 'dark:text-admin-200' : '' }} uppercase tracking-wide">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-external-link-alt text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} text-sm"></i>
                                    <span class="font-bold">UTM Kaynak</span>
                                </div>
                            </th>
                            <th scope="col" class="w-24 px-4 py-4 text-center text-sm font-semibold text-admin-800 {{ $isDark ? 'dark:text-admin-200' : '' }} uppercase tracking-wide">
                                <div class="flex items-center justify-center space-x-2">
                                    <i class="fas fa-toggle-on text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} text-sm"></i>
                                    <span class="font-bold">Durum</span>
                                </div>
                            </th>
                            <th scope="col" class="w-28 px-4 py-4 text-center text-sm font-semibold text-admin-800 {{ $isDark ? 'dark:text-admin-200' : '' }} uppercase tracking-wide">
                                <div class="flex items-center justify-center space-x-2">
                                    <i class="fas fa-cogs text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} text-sm"></i>
                                    <span class="font-bold">İşlemler</span>
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <!-- Enhanced Table Body -->
                    <tbody class="bg-white {{ $isDark ? 'dark:bg-admin-800' : '' }} divide-y divide-admin-200 {{ $isDark ? 'dark:divide-admin-700' : '' }}">
                        @forelse ($users ?? [] as $user)
                            <tr class="hover:bg-gradient-to-r hover:from-admin-50 hover:to-white {{ $isDark ? 'dark:hover:from-admin-700 dark:hover:to-admin-750' : '' }} transition-all duration-200 group border-l-4 border-transparent hover:border-admin-400">
                                <!-- Enhanced Selection Checkbox -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                                           class="user-checkbox w-4 h-4 rounded border-admin-300 text-admin-600 shadow-sm focus:border-admin-500 focus:ring-admin-500 focus:ring-2"
                                           onchange="updateBulkActions()">
                                </td>

                                <!-- Enhanced User Info with Larger Avatar -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-admin-500 to-admin-600 {{ $isDark ? 'dark:from-admin-400 dark:to-admin-500' : '' }} flex items-center justify-center shadow-lg border-2 border-white {{ $isDark ? 'dark:border-admin-600' : '' }}">
                                                <span class="text-sm font-bold text-white uppercase">
                                                    {{ substr($user->name ?? '', 0, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="text-sm font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} truncate" title="{{ $user->name ?? 'Ad Soyad Yok' }}">
                                                {{ Str::limit($user->name ?? 'Ad Soyad Yok', 25) }}
                                            </div>
                                            <div class="text-xs text-admin-500 {{ $isDark ? 'dark:text-admin-400' : '' }} font-medium">
                                                <i class="fas fa-hashtag mr-1"></i>{{ $user->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Enhanced Contact Information -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} font-medium truncate" title="{{ $user->email ?? '-' }}">
                                        {{ Str::limit($user->email ?? '-', 30) }}
                                    </div>
                                    @if($user->email_verified_at)
                                        <div class="text-xs text-green-600 font-medium mt-1">
                                            <i class="fas fa-check-circle mr-1"></i>Doğrulandı
                                        </div>
                                    @else
                                        <div class="text-xs text-amber-600 font-medium mt-1">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>Bekliyor
                                        </div>
                                    @endif
                                </td>

                                <!-- Enhanced Phone -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} font-medium">
                                        {{ $user->phone ?? '-' }}
                                    </div>
                                </td>

                                <!-- Enhanced Registration Date -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} font-medium">
                                        {{ $user->created_at ? $user->created_at->format('d.m.Y') : '-' }}
                                    </div>
                                    <div class="text-xs text-admin-500 {{ $isDark ? 'dark:text-admin-400' : '' }} mt-1">
                                        {{ $user->created_at ? $user->created_at->diffForHumans() : '-' }}
                                    </div>
                                </td>

                                <!-- Enhanced Lead Status Dropdown -->
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center">
                                        <select onchange="updateLeadStatus({{ $user->id }}, this.value)"
                                                class="px-3 py-2 border border-admin-300 {{ $isDark ? 'dark:border-admin-600 dark:bg-admin-700' : '' }} rounded-lg bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} text-sm font-medium focus:outline-none focus:ring-2 focus:ring-admin-500 focus:border-transparent shadow-sm transition-all duration-200"
                                                style="background-color: {{ $user->leadStatus->color ?? '#6B7280' }}; color: white;">
                                            @if(isset($leadStatuses) && $leadStatuses->count() > 0)
                                                @foreach($leadStatuses as $status)
                                                    <option value="{{ $status->name }}"
                                                            style="background-color: {{ $status->color }}; color: white;"
                                                            {{ ($user->lead_status == $status->name) ? 'selected' : '' }}>
                                                        {{ $status->display_name ?: $status->name }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="new" {{ ($user->lead_status == 'new' || !$user->lead_status) ? 'selected' : '' }}>Yeni</option>
                                                <option value="contacted" {{ ($user->lead_status == 'contacted') ? 'selected' : '' }}>İletişimde</option>
                                                <option value="qualified" {{ ($user->lead_status == 'qualified') ? 'selected' : '' }}>Nitelikli</option>
                                                <option value="converted" {{ ($user->lead_status == 'converted') ? 'selected' : '' }}>Dönüştürülmüş</option>
                                                <option value="lost" {{ ($user->lead_status == 'lost') ? 'selected' : '' }}>Kayıp</option>
                                            @endif
                                        </select>
                                    </div>
                                </td>

                                <!-- Enhanced Assigned Admin Dropdown -->
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center">
                                        <select onchange="updateAssignedAdmin({{ $user->id }}, this.value)"
                                                class="px-3 py-2 border border-admin-300 {{ $isDark ? 'dark:border-admin-600 dark:bg-admin-700' : '' }} rounded-lg bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} text-sm font-medium focus:outline-none focus:ring-2 focus:ring-admin-500 focus:border-transparent text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} shadow-sm transition-all duration-200">
                                            @if(isset($admins) && $admins->count() > 0)
                                                <option value="" {{ !$user->assign_to ? 'selected' : '' }}>Atanmamış</option>
                                                @foreach($admins as $admin)
                                                    <option value="{{ is_array($admin) ? $admin['id'] : $admin->id }}"
                                                            {{ ($user->assign_to == (is_array($admin) ? $admin['id'] : $admin->id)) ? 'selected' : '' }}>
                                                        {{ Str::limit(is_array($admin) ? ($admin['name'] ?? $admin['label']) : $admin->getDisplayName(), 18) }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="" selected>Atanmamış</option>
                                            @endif
                                        </select>
                                    </div>
                                </td>

                                <!-- UTM Information -->
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm space-y-1">
                                        @if($user->utm_source || $user->utm_campaign)
                                            @if($user->utm_source)
                                                <div class="text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} font-medium flex items-center">
                                                    <i class="fas fa-external-link-alt text-admin-500 {{ $isDark ? 'dark:text-admin-400' : '' }} mr-2 text-xs"></i>
                                                    <span class="text-xs">Kaynak:</span>
                                                    <span class="ml-1 px-2 py-0.5 bg-blue-100 text-blue-800 {{ $isDark ? 'dark:bg-blue-800 dark:text-blue-100' : '' }} rounded text-xs font-semibold">{{ Str::limit($user->utm_source, 12) }}</span>
                                                </div>
                                            @endif
                                            @if($user->utm_campaign)
                                                <div class="text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} font-medium flex items-center">
                                                    <i class="fas fa-bullhorn text-admin-500 {{ $isDark ? 'dark:text-admin-400' : '' }} mr-2 text-xs"></i>
                                                    <span class="text-xs">Kampanya:</span>
                                                    <span class="ml-1 px-2 py-0.5 bg-green-100 text-green-800 {{ $isDark ? 'dark:bg-green-800 dark:text-green-100' : '' }} rounded text-xs font-semibold">{{ Str::limit($user->utm_campaign, 10) }}</span>
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-admin-500 {{ $isDark ? 'dark:text-admin-400' : '' }} text-xs italic">
                                                UTM bilgisi yok
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Enhanced Status Badge -->
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    @switch($user->status ?? 'active')
                                        @case('active')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-green-100 text-green-800 {{ $isDark ? 'dark:bg-green-800 dark:text-green-100' : '' }} shadow-sm border border-green-200 {{ $isDark ? 'dark:border-green-700' : '' }}">
                                                <i class="fas fa-check-circle mr-2"></i>
                                                Aktif
                                            </span>
                                            @break
                                        @case('blocked')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-red-100 text-red-800 {{ $isDark ? 'dark:bg-red-800 dark:text-red-100' : '' }} shadow-sm border border-red-200 {{ $isDark ? 'dark:border-red-700' : '' }}">
                                                <i class="fas fa-times-circle mr-2"></i>
                                                Engelli
                                            </span>
                                            @break
                                        @case('pending')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 {{ $isDark ? 'dark:bg-yellow-800 dark:text-yellow-100' : '' }} shadow-sm border border-yellow-200 {{ $isDark ? 'dark:border-yellow-700' : '' }}">
                                                <i class="fas fa-clock mr-2"></i>
                                                Bekliyor
                                            </span>
                                            @break
                                        @default
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-gray-100 text-gray-800 {{ $isDark ? 'dark:bg-gray-700 dark:text-gray-200' : '' }} shadow-sm border border-gray-200 {{ $isDark ? 'dark:border-gray-600' : '' }}">
                                                <i class="fas fa-question-circle mr-2"></i>
                                                Belirsiz
                                            </span>
                                    @endswitch
                                </td>

                                <!-- Enhanced Action Buttons -->
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button onclick="viewUser({{ $user->id }})"
                                                class="p-2 rounded-lg text-admin-600 hover:bg-admin-100 {{ $isDark ? 'dark:text-admin-400 dark:hover:bg-admin-700' : '' }} transition-all duration-200 hover:shadow-md hover:scale-110"
                                                title="Görüntüle">
                                            <i class="fas fa-eye text-sm"></i>
                                        </button>
                                        <button onclick="editUser({{ $user->id }})"
                                                class="p-2 rounded-lg text-blue-600 hover:bg-blue-100 {{ $isDark ? 'dark:text-blue-400 dark:hover:bg-blue-800' : '' }} transition-all duration-200 hover:shadow-md hover:scale-110"
                                                title="Düzenle">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                        @if($user->status == 'active')
                                            <button onclick="blockUser({{ $user->id }})"
                                                    class="p-2 rounded-lg text-red-600 hover:bg-red-100 {{ $isDark ? 'dark:text-red-400 dark:hover:bg-red-800' : '' }} transition-all duration-200 hover:shadow-md hover:scale-110"
                                                    title="Engelle">
                                                <i class="fas fa-ban text-sm"></i>
                                            </button>
                                        @else
                                            <button onclick="unblockUser({{ $user->id }})"
                                                    class="p-2 rounded-lg text-green-600 hover:bg-green-100 {{ $isDark ? 'dark:text-green-400 dark:hover:bg-green-800' : '' }} transition-all duration-200 hover:shadow-md hover:scale-110"
                                                    title="Aktifleştir">
                                                <i class="fas fa-check text-sm"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-4 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-4 max-w-md mx-auto">
                                        <div class="w-24 h-24 bg-gradient-to-br from-admin-400 to-admin-500 {{ $isDark ? 'dark:from-admin-500 dark:to-admin-600' : '' }} rounded-full flex items-center justify-center shadow-lg">
                                            <i class="fas fa-users text-white text-3xl"></i>
                                        </div>
                                        <div class="text-center space-y-2">
                                            <h3 class="text-xl font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">
                                                Kullanıcı Bulunamadı
                                            </h3>
                                            <p class="text-sm text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} leading-relaxed">
                                                Henüz hiç kullanıcı eklenmemiş veya arama kriterlerinize uygun kullanıcı bulunamadı.
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-3 mt-6">
                                            <button onclick="openAddUserModal()"
                                                    class="inline-flex items-center px-4 py-2 bg-admin-600 hover:bg-admin-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200">
                                                <i class="fas fa-user-plus mr-2"></i>
                                                Yeni Kullanıcı Ekle
                                            </button>
                                            <a href="{{ route('manageusers') }}"
                                               class="inline-flex items-center px-4 py-2 text-admin-600 hover:text-admin-700 text-sm font-medium transition-colors duration-200">
                                                <i class="fas fa-refresh mr-2"></i>
                                                Filtreleri Temizle
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Enhanced Pagination Footer with Per-Page Selector -->
            <div class="bg-admin-50 {{ $isDark ? 'dark:bg-admin-750' : '' }} px-6 py-4 border-t border-admin-200 {{ $isDark ? 'dark:border-admin-600' : '' }}">
                <div class="flex flex-col space-y-3 sm:flex-row sm:items-center sm:justify-between sm:space-y-0">
                    
                    <!-- Results Info ve Per-Page Selector -->
                    <div class="flex flex-col space-y-2 sm:flex-row sm:items-center sm:space-y-0 sm:space-x-4">
                        <!-- Results Counter -->
                        <div class="text-sm text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">
                            @if(isset($users))
                                @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                    <p>
                                        Gösterilen: <span class="font-medium text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">{{ $users->firstItem() ?? 0 }}</span>
                                        - <span class="font-medium text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">{{ $users->lastItem() ?? 0 }}</span>
                                        / Toplam: <span class="font-medium text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">{{ $users->total() }}</span> kayıt
                                    </p>
                                @else
                                    <p>Toplam: <span class="font-medium text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">{{ $users->count() }}</span> kayıt gösteriliyor (Filtresiz Tümü)</p>
                                @endif
                            @else
                                <p>Toplam: <span class="font-medium text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">0</span> kayıt gösteriliyor</p>
                            @endif
                        </div>

                        <!-- Per Page Selector -->
                        <div class="flex items-center space-x-2">
                            <label for="per_page" class="text-sm font-medium text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">Sayfa başı:</label>
                            <select name="per_page" id="per_page" onchange="changePerPage(this.value)"
                                    class="text-sm border-admin-300 {{ $isDark ? 'dark:border-admin-600 dark:bg-admin-700' : '' }} rounded-md focus:border-indigo-500 focus:ring-indigo-500 bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">
                                <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="75" {{ request('per_page') == 75 ? 'selected' : '' }}>75</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Hepsini Göster</option>
                            </select>
                        </div>
                    </div>

                    <!-- Pagination Links (sadece paginate edilmiş sonuçlar için) -->
                    @if(isset($users) && $users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="flex justify-center sm:justify-end">
                            <x-admin-pagination :paginator="$users" />
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sticky Floating Bulk Actions Bubble (Hidden by default) -->
        <div id="bulk-actions-bar" class="hidden fixed bottom-6 right-6 z-50 bg-admin-600 {{ $isDark ? 'dark:bg-admin-700' : '' }} rounded-2xl shadow-2xl border border-admin-500 {{ $isDark ? 'dark:border-admin-600' : '' }} max-w-sm">
            <!-- Compact Header with Selected Count -->
            <div class="px-4 py-3 bg-admin-700 {{ $isDark ? 'dark:bg-admin-800' : '' }} rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-white text-sm"></i>
                        </div>
                        <span class="text-white font-medium text-sm">
                            <span id="selected-count" class="text-yellow-300 font-bold">0</span> seçildi
                        </span>
                    </div>
                    <button onclick="updateBulkActions()"
                            class="text-white hover:text-red-300 transition-colors p-1 rounded"
                            title="Kapat">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
            </div>
            
            <!-- Compact Action Buttons Grid -->
            <div class="p-4">
                <div class="grid grid-cols-2 gap-2 mb-3">
                    <button onclick="bulkActivate()"
                            class="flex items-center justify-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200 text-xs font-medium shadow-sm hover:shadow-md transform hover:scale-105">
                        <i class="fas fa-check mr-1"></i>
                        <span class="hidden sm:inline">Aktifleştir</span>
                        <span class="sm:hidden">Aktif</span>
                    </button>
                    <button onclick="bulkBlock()"
                            class="flex items-center justify-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all duration-200 text-xs font-medium shadow-sm hover:shadow-md transform hover:scale-105">
                        <i class="fas fa-ban mr-1"></i>
                        <span class="hidden sm:inline">Engelle</span>
                        <span class="sm:hidden">Engel</span>
                    </button>
                </div>
                <div class="grid grid-cols-2 gap-2 mb-2">
                    <button onclick="bulkUpdateLeadStatus()"
                            class="flex items-center justify-center px-3 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition-all duration-200 text-xs font-medium shadow-sm hover:shadow-md transform hover:scale-105">
                        <i class="fas fa-flag mr-1"></i>
                        <span class="hidden sm:inline">Status</span>
                        <span class="sm:hidden">St.</span>
                    </button>
                    <button onclick="bulkAssignAdmin()"
                            class="flex items-center justify-center px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-all duration-200 text-xs font-medium shadow-sm hover:shadow-md transform hover:scale-105">
                        <i class="fas fa-user-tie mr-1"></i>
                        <span class="hidden sm:inline">Admin</span>
                        <span class="sm:hidden">Ad.</span>
                    </button>
                </div>
                <div class="grid grid-cols-1 gap-2">
                    <button onclick="exportSelected()"
                            class="flex items-center justify-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-200 text-xs font-medium shadow-sm hover:shadow-md transform hover:scale-105">
                        <i class="fas fa-download mr-2"></i>Dışa Aktar
                    </button>
                </div>
            </div>
            
            <!-- Mobile Responsive Adjustments -->
            <style>
                @media (max-width: 640px) {
                    #bulk-actions-bar {
                        bottom: 1rem;
                        right: 1rem;
                        left: 1rem;
                        max-width: none;
                    }
                }
                
                /* Floating animation */
                #bulk-actions-bar:not(.hidden) {
                    animation: slideInUp 0.3s ease-out;
                }
                
                @keyframes slideInUp {
                    from {
                        transform: translateY(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateY(0);
                        opacity: 1;
                    }
                }
                
                /* Pulse effect for selected count */
                #selected-count {
                    animation: pulse 2s infinite;
                }
                
                @keyframes pulse {
                    0%, 100% {
                        opacity: 1;
                    }
                    50% {
                        opacity: 0.7;
                    }
                }
            </style>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div id="add-user-modal" class="fixed inset-0 z-50 hidden">
    <div class="modal-backdrop fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 opacity-0"></div>
    
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="modal-content bg-white {{ $isDark ? 'dark:bg-admin-800' : '' }} rounded-xl shadow-xl w-full max-w-2xl transform transition-all duration-300 opacity-0 scale-95">
                
                <div class="flex items-center justify-between px-6 py-4 border-b border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }}">
                    <h3 class="text-lg font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">Yeni Kullanıcı Ekle</h3>
                    <button onclick="closeAddUserModal()" class="p-2 hover:bg-admin-100 {{ $isDark ? 'dark:hover:bg-admin-700' : '' }} rounded-lg transition-colors">
                        <i class="fas fa-times text-admin-500"></i>
                    </button>
                </div>

                <form id="add-user-form" onsubmit="submitAddUser(event)">
                    <div class="px-6 py-6 space-y-6">
                        
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }}">Ad Soyad</label>
                                <input type="text" name="name" required
                                       class="block w-full px-3 py-2 border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} placeholder-admin-500 focus:outline-none focus:ring-2 focus:ring-admin-500 focus:border-transparent">
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }}">E-posta</label>
                                <input type="email" name="email" required
                                       class="block w-full px-3 py-2 border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} placeholder-admin-500 focus:outline-none focus:ring-2 focus:ring-admin-500 focus:border-transparent">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }}">Telefon</label>
                                <input type="tel" name="phone"
                                       class="block w-full px-3 py-2 border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} placeholder-admin-500 focus:outline-none focus:ring-2 focus:ring-admin-500 focus:border-transparent">
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }}">Rol</label>
                                <select name="role"
                                        class="block w-full px-3 py-2 border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} focus:outline-none focus:ring-2 focus:ring-admin-500 focus:border-transparent">
                                    <option value="user">Kullanıcı</option>
                                    <option value="premium">Premium</option>
                                    <option value="vip">VIP</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }}">Şifre</label>
                            <input type="password" name="password" required
                                   class="block w-full px-3 py-2 border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} placeholder-admin-500 focus:outline-none focus:ring-2 focus:ring-admin-500 focus:border-transparent">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }}">Şifre Tekrar</label>
                            <input type="password" name="password_confirmation" required
                                   class="block w-full px-3 py-2 border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} placeholder-admin-500 focus:outline-none focus:ring-2 focus:ring-admin-500 focus:border-transparent">
                        </div>

                    </div>

                    <div class="flex items-center justify-end space-x-3 px-6 py-4 border-t border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }}">
                        <button type="button" onclick="closeAddUserModal()"
                                class="px-4 py-2 text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} hover:bg-admin-100 {{ $isDark ? 'dark:hover:bg-admin-700' : '' }} rounded-lg transition-colors">
                            İptal
                        </button>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-admin-600 hover:bg-admin-700 text-white font-medium rounded-lg shadow-sm transition-colors">
                            <i class="fas fa-user-plus mr-2"></i>
                            Kullanıcı Ekle
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Admin Assignment Modal -->
<div id="admin-assignment-modal" class="fixed inset-0 z-50 hidden">
    <div class="modal-backdrop fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 opacity-0"></div>
    
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="modal-content bg-white {{ $isDark ? 'dark:bg-admin-800' : '' }} rounded-xl shadow-xl w-full max-w-md transform transition-all duration-300 opacity-0 scale-95">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }}">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-tie text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">
                                Admin Ataması
                            </h3>
                            <p class="text-sm text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">
                                <span id="modal-selected-count" class="font-medium text-purple-600">0</span> kullanıcı seçildi
                            </p>
                        </div>
                    </div>
                    <button onclick="closeAdminAssignModal()"
                            class="p-2 hover:bg-admin-100 {{ $isDark ? 'dark:hover:bg-admin-700' : '' }} rounded-lg transition-colors">
                        <i class="fas fa-times text-admin-500 {{ $isDark ? 'dark:text-admin-400' : '' }}"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6">
                    <div class="space-y-4">
                        <!-- Admin Selection -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }}">
                                <i class="fas fa-user-tie text-purple-500 mr-2"></i>
                                Admin Seçimi
                            </label>
                            <select id="admin-select"
                                    class="block w-full px-4 py-3 border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Atamayı kaldır (Atanmamış)</option>
                                @if(isset($admins) && $admins->count() > 0)
                                    @foreach($admins as $admin)
                                        <option value="{{ is_array($admin) ? $admin['id'] : $admin->id }}">
                                            {{ is_array($admin) ? ($admin['name'] ?? $admin['label']) : $admin->getDisplayName() }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Selected Users Preview -->
                        <div class="bg-admin-50 {{ $isDark ? 'dark:bg-admin-700' : '' }} rounded-lg p-4">
                            <div class="flex items-center space-x-2 mb-2">
                                <i class="fas fa-users text-admin-500 {{ $isDark ? 'dark:text-admin-400' : '' }}"></i>
                                <span class="text-sm font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }}">
                                    Seçili Kullanıcılar
                                </span>
                            </div>
                            <div id="selected-users-preview" class="text-sm text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} max-h-20 overflow-y-auto">
                                <!-- Bu alan JavaScript ile doldurulacak -->
                            </div>
                        </div>

                        <!-- Warning Message -->
                        <div class="bg-yellow-50 {{ $isDark ? 'dark:bg-yellow-900/20' : '' }} border border-yellow-200 {{ $isDark ? 'dark:border-yellow-700' : '' }} rounded-lg p-3">
                            <div class="flex items-start space-x-2">
                                <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5"></i>
                                <div class="text-sm text-yellow-800 {{ $isDark ? 'dark:text-yellow-200' : '' }}">
                                    <strong>Dikkat:</strong> Bu işlem seçili tüm kullanıcıların admin atamasını değiştirecek ve geçmişe dönük kayıt oluşturacaktır.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end space-x-3 px-6 py-4 border-t border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }}">
                    <button type="button"
                            onclick="closeAdminAssignModal()"
                            class="px-4 py-2 text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} hover:bg-admin-100 {{ $isDark ? 'dark:hover:bg-admin-700' : '' }} rounded-lg transition-colors font-medium">
                        İptal
                    </button>
                    <button type="button"
                            onclick="submitAdminAssignment()"
                            class="inline-flex items-center px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200 hover:shadow-md">
                        <i class="fas fa-user-tie mr-2"></i>
                        Admin Ata
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lead Status Change Modal -->
<div id="status-change-modal" class="fixed inset-0 z-50 hidden">
    <div class="modal-backdrop fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300 opacity-0"></div>
    
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="modal-content bg-white {{ $isDark ? 'dark:bg-admin-800' : '' }} rounded-xl shadow-xl w-full max-w-md transform transition-all duration-300 opacity-0 scale-95">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }}">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-flag text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">
                                Toplu Status Değişimi
                            </h3>
                            <p class="text-sm text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">
                                <span id="status-modal-selected-count" class="font-medium text-orange-600">0</span> kullanıcı seçildi
                            </p>
                        </div>
                    </div>
                    <button onclick="closeStatusChangeModal()"
                            class="p-2 hover:bg-admin-100 {{ $isDark ? 'dark:hover:bg-admin-700' : '' }} rounded-lg transition-colors">
                        <i class="fas fa-times text-admin-500 {{ $isDark ? 'dark:text-admin-400' : '' }}"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6">
                    <div class="space-y-4">
                        <!-- Lead Status Selection -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }}">
                                <i class="fas fa-flag text-orange-500 mr-2"></i>
                                Yeni Lead Status
                            </label>
                            <select id="status-select"
                                    class="block w-full px-4 py-3 border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-lg bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                <option value="">Lütfen status seçin</option>
                                @if(isset($leadStatuses) && $leadStatuses->count() > 0)
                                    @foreach($leadStatuses as $status)
                                        <option value="{{ $status->name }}"
                                                style="background-color: {{ $status->color ?? '#6B7280' }}; color: white;">
                                            {{ $status->display_name ?: $status->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="new">Yeni</option>
                                    <option value="contacted">İletişimde</option>
                                    <option value="qualified">Nitelikli</option>
                                    <option value="converted">Dönüştürülmüş</option>
                                    <option value="lost">Kayıp</option>
                                @endif
                            </select>
                        </div>

                        <!-- Selected Users Preview -->
                        <div class="bg-admin-50 {{ $isDark ? 'dark:bg-admin-700' : '' }} rounded-lg p-4">
                            <div class="flex items-center space-x-2 mb-2">
                                <i class="fas fa-users text-admin-500 {{ $isDark ? 'dark:text-admin-400' : '' }}"></i>
                                <span class="text-sm font-medium text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }}">
                                    Seçili Kullanıcılar
                                </span>
                            </div>
                            <div id="status-selected-users-preview" class="text-sm text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }} max-h-20 overflow-y-auto">
                                <!-- Bu alan JavaScript ile doldurulacak -->
                            </div>
                        </div>

                        <!-- Warning Message -->
                        <div class="bg-orange-50 {{ $isDark ? 'dark:bg-orange-900/20' : '' }} border border-orange-200 {{ $isDark ? 'dark:border-orange-700' : '' }} rounded-lg p-3">
                            <div class="flex items-start space-x-2">
                                <i class="fas fa-exclamation-triangle text-orange-600 mt-0.5"></i>
                                <div class="text-sm text-orange-800 {{ $isDark ? 'dark:text-orange-200' : '' }}">
                                    <strong>Dikkat:</strong> Bu işlem seçili tüm kullanıcıların lead status'unu değiştirecek ve sistem kayıt tutacaktır.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end space-x-3 px-6 py-4 border-t border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }}">
                    <button type="button"
                            onclick="closeStatusChangeModal()"
                            class="px-4 py-2 text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} hover:bg-admin-100 {{ $isDark ? 'dark:hover:bg-admin-700' : '' }} rounded-lg transition-colors font-medium">
                        İptal
                    </button>
                    <button type="button"
                            onclick="submitStatusChange()"
                            class="inline-flex items-center px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200 hover:shadow-md">
                        <i class="fas fa-flag mr-2"></i>
                        Status Değiştir
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Modern Table Functionality - No Alpine.js, No Livewire
document.addEventListener('DOMContentLoaded', function() {
    initializeTable();
});

function initializeTable() {
    // Initialize any needed functionality
    updateBulkActions();
}

// Search and Filter Functions
function filterTable() {
    const searchTerm = document.getElementById('user-search').value.toLowerCase();
    const rows = document.querySelectorAll('#users-table tbody tr:not(:last-child)');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
}

// Selection Functions
function toggleAllUsers(checkbox) {
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    userCheckboxes.forEach(cb => cb.checked = checkbox.checked);
    updateBulkActions();
}

function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
    const bulkActionsBar = document.getElementById('bulk-actions-bar');
    const selectedCount = document.getElementById('selected-count');
    
    selectedCount.textContent = checkedBoxes.length;
    
    if (checkedBoxes.length > 0) {
        bulkActionsBar.classList.remove('hidden');
    } else {
        bulkActionsBar.classList.add('hidden');
    }
}

// User Action Functions
function viewUser(userId) {
    window.location.href = `/admin/dashboard/user-details/${userId}`;
}

function editUser(userId) {
    window.location.href = `/admin/viewuser/${userId}`;
}

function blockUser(userId) {
    if (confirm('Bu kullanıcıyı engellemek istediğinizden emin misiniz?')) {
        window.location.href = `/admin/dashboard/uublock/${userId}`;
    }
}

function unblockUser(userId) {
    if (confirm('Bu kullanıcının engellemesini kaldırmak istediğinizden emin misiniz?')) {
        window.location.href = `/admin/dashboard/uublock/${userId}`;
    }
}

// Bulk Action Functions
function bulkActivate() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    if (selectedUsers.length === 0) {
        showNotification('Lütfen en az bir kullanıcı seçin.', 'error');
        return;
    }
    
    if (confirm(`${selectedUsers.length} kullanıcıyı aktifleştirmek istediğinizden emin misiniz?`)) {
        bulkUpdateUserStatus(selectedUsers, 'active', 'aktifleştir');
    }
}

function bulkBlock() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    if (selectedUsers.length === 0) {
        showNotification('Lütfen en az bir kullanıcı seçin.', 'error');
        return;
    }
    
    if (confirm(`${selectedUsers.length} kullanıcıyı engellemek istediğinizden emin misiniz?`)) {
        bulkUpdateUserStatus(selectedUsers, 'blocked', 'engelle');
    }
}

// Generic bulk status update function
function bulkUpdateUserStatus(userIds, status, actionName) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    // Loading göster
    showNotification(`${userIds.length} kullanıcı ${actionName} işlemi başlatılıyor...`, 'info');
    
    fetch('{{ route("admin.manageusers.bulk-status") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            user_ids: userIds,
            new_status: status
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            // Sayfayı yenile
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            showNotification(data.message || `${actionName} işlemi başarısız oldu.`, 'error');
        }
    })
    .catch(error => {
        console.error('Bulk operation error:', error);
        showNotification(`${actionName} işlemi sırasında bir hata oluştu: ${error.message}`, 'error');
    });
}

function exportUsers() {
    // Mevcut filtreleri al
    const currentUrl = new URL(window.location.href);
    const filters = {
        status: currentUrl.searchParams.get('status') || '',
        admin: currentUrl.searchParams.get('admin') || '',
        date_from: currentUrl.searchParams.get('date_from') || '',
        date_to: currentUrl.searchParams.get('date_to') || ''
    };
    
    // Export URL'sini oluştur
    const exportUrl = new URL('{{ route("admin.manageusers.export") }}', window.location.origin);
    
    // Filtreleri export URL'sine ekle
    Object.keys(filters).forEach(key => {
        if (filters[key]) {
            exportUrl.searchParams.set(key, filters[key]);
        }
    });
    
    // Loading göster
    showNotification('Excel dosyası hazırlanıyor... Lütfen bekleyin.', 'info');
    
    // Export işlemini başlat
    window.location.href = exportUrl.toString();
    
    // Success message (dosya indirilmeye başladığında)
    setTimeout(() => {
        showNotification('Excel dosyası başarıyla oluşturuldu ve indirilmeye başlandı.', 'success');
    }, 1000);
}

function exportSelected() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    if (selectedUsers.length === 0) {
        showNotification('Lütfen en az bir kullanıcı seçin.', 'error');
        return;
    }
    
    // Form oluştur ve POST ile gönder
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("admin.manageusers.export") }}';
    form.style.display = 'none';
    
    // CSRF token ekle
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (csrfToken) {
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = csrfToken;
        form.appendChild(tokenInput);
    }
    
    // Mevcut filtreleri ekle
    const currentUrl = new URL(window.location.href);
    const filters = {
        status: currentUrl.searchParams.get('status') || '',
        admin: currentUrl.searchParams.get('admin') || '',
        date_from: currentUrl.searchParams.get('date_from') || '',
        date_to: currentUrl.searchParams.get('date_to') || ''
    };
    
    // Filtreleri form'a ekle
    Object.keys(filters).forEach(key => {
        if (filters[key]) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = filters[key];
            form.appendChild(input);
        }
    });
    
    // Seçili kullanıcı ID'lerini ekle
    selectedUsers.forEach(userId => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'selected_users[]';
        input.value = userId;
        form.appendChild(input);
    });
    
    // Export type belirt
    const typeInput = document.createElement('input');
    typeInput.type = 'hidden';
    typeInput.name = 'export_type';
    typeInput.value = 'selected';
    form.appendChild(typeInput);
    
    showNotification(`${selectedUsers.length} seçili kullanıcı için Excel dosyası hazırlanıyor...`, 'info');
    
    // Form'u DOM'a ekle ve submit et
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
    
    setTimeout(() => {
        showNotification('Seçili kullanıcılar için Excel dosyası başarıyla oluşturuldu.', 'success');
    }, 1000);
}

// Bulk Admin Assignment Function - Şimdi Modal Açıyor
function bulkAssignAdmin() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    if (selectedUsers.length === 0) {
        showNotification('Lütfen en az bir kullanıcı seçin.', 'error');
        return;
    }
    
    // Modal'ı aç
    openAdminAssignModal(selectedUsers);
}

// Admin Assignment Modal Functions
function openAdminAssignModal(selectedUsers) {
    const modal = document.getElementById('admin-assignment-modal');
    const selectedCount = document.getElementById('modal-selected-count');
    const userPreview = document.getElementById('selected-users-preview');
    
    // Seçili kullanıcı sayısını güncelle
    selectedCount.textContent = selectedUsers.length;
    
    // Seçili kullanıcıları preview kısmında göster
    updateSelectedUsersPreview(selectedUsers);
    
    // Modal'ı göster
    modal.classList.remove('hidden');
    modal.querySelector('.modal-backdrop').classList.remove('opacity-0');
    modal.querySelector('.modal-content').classList.remove('opacity-0', 'scale-95');
    modal.querySelector('.modal-backdrop').classList.add('opacity-100');
    modal.querySelector('.modal-content').classList.add('opacity-100', 'scale-100');
}

function closeAdminAssignModal() {
    const modal = document.getElementById('admin-assignment-modal');
    modal.querySelector('.modal-backdrop').classList.remove('opacity-100');
    modal.querySelector('.modal-content').classList.remove('opacity-100', 'scale-100');
    modal.querySelector('.modal-backdrop').classList.add('opacity-0');
    modal.querySelector('.modal-content').classList.add('opacity-0', 'scale-95');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        // Modal'ı sıfırla
        document.getElementById('admin-select').value = '';
    }, 300);
}

function updateSelectedUsersPreview(selectedUserIds) {
    const userPreview = document.getElementById('selected-users-preview');
    const userNames = [];
    
    // Her seçili kullanıcının adını bul
    selectedUserIds.forEach(userId => {
        const userRow = document.querySelector(`input[value="${userId}"]`).closest('tr');
        const userName = userRow.querySelector('td:nth-child(2) .text-admin-900').textContent.trim();
        userNames.push(userName);
    });
    
    if (userNames.length <= 3) {
        userPreview.innerHTML = userNames.join(', ');
    } else {
        const displayNames = userNames.slice(0, 2).join(', ');
        userPreview.innerHTML = `${displayNames} ve ${userNames.length - 2} kişi daha...`;
    }
}

function submitAdminAssignment() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    const selectedAdmin = document.getElementById('admin-select').value;
    
    if (selectedUsers.length === 0) {
        showNotification('Lütfen en az bir kullanıcı seçin.', 'error');
        return;
    }
    
    // Modal'ı kapat
    closeAdminAssignModal();
    
    // Admin atama işlemini başlat
    const adminIdValue = selectedAdmin.trim() === '' ? null : selectedAdmin.trim();
    bulkAssignAdminToUsers(selectedUsers, adminIdValue);
}

// Generic bulk admin assignment function
function bulkAssignAdminToUsers(userIds, adminId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    const actionText = adminId ? `admin (ID: ${adminId})` : 'atanmamış duruma';
    
    showNotification(`${userIds.length} kullanıcı ${actionText} atanıyor...`, 'info');
    
    fetch('{{ route("admin.manageusers.bulk-assign") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            user_ids: userIds,
            admin_id: adminId
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            // Sayfayı yenile
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            showNotification(data.message || 'Admin atama işlemi başarısız oldu.', 'error');
        }
    })
    .catch(error => {
        console.error('Bulk admin assignment error:', error);
        showNotification(`Admin atama işlemi sırasında bir hata oluştu: ${error.message}`, 'error');
    });
}

// Bulk Lead Status Update Function - Modal Açıyor
function bulkUpdateLeadStatus() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    if (selectedUsers.length === 0) {
        showNotification('Lütfen en az bir kullanıcı seçin.', 'error');
        return;
    }
    
    // Modal'ı aç
    openStatusChangeModal(selectedUsers);
}

// Lead Status Change Modal Functions
function openStatusChangeModal(selectedUsers) {
    const modal = document.getElementById('status-change-modal');
    const selectedCount = document.getElementById('status-modal-selected-count');
    const userPreview = document.getElementById('status-selected-users-preview');
    
    // Seçili kullanıcı sayısını güncelle
    selectedCount.textContent = selectedUsers.length;
    
    // Seçili kullanıcıları preview kısmında göster
    updateStatusSelectedUsersPreview(selectedUsers);
    
    // Modal'ı göster
    modal.classList.remove('hidden');
    modal.querySelector('.modal-backdrop').classList.remove('opacity-0');
    modal.querySelector('.modal-content').classList.remove('opacity-0', 'scale-95');
    modal.querySelector('.modal-backdrop').classList.add('opacity-100');
    modal.querySelector('.modal-content').classList.add('opacity-100', 'scale-100');
}

function closeStatusChangeModal() {
    const modal = document.getElementById('status-change-modal');
    modal.querySelector('.modal-backdrop').classList.remove('opacity-100');
    modal.querySelector('.modal-content').classList.remove('opacity-100', 'scale-100');
    modal.querySelector('.modal-backdrop').classList.add('opacity-0');
    modal.querySelector('.modal-content').classList.add('opacity-0', 'scale-95');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        // Modal'ı sıfırla
        document.getElementById('status-select').value = '';
    }, 300);
}

function updateStatusSelectedUsersPreview(selectedUserIds) {
    const userPreview = document.getElementById('status-selected-users-preview');
    const userNames = [];
    
    // Her seçili kullanıcının adını bul
    selectedUserIds.forEach(userId => {
        const userRow = document.querySelector(`input[value="${userId}"]`).closest('tr');
        const userName = userRow.querySelector('td:nth-child(2) .text-admin-900').textContent.trim();
        userNames.push(userName);
    });
    
    if (userNames.length <= 3) {
        userPreview.innerHTML = userNames.join(', ');
    } else {
        const displayNames = userNames.slice(0, 2).join(', ');
        userPreview.innerHTML = `${displayNames} ve ${userNames.length - 2} kişi daha...`;
    }
}

function submitStatusChange() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    const selectedStatus = document.getElementById('status-select').value;
    
    if (selectedUsers.length === 0) {
        showNotification('Lütfen en az bir kullanıcı seçin.', 'error');
        return;
    }
    
    if (!selectedStatus.trim()) {
        showNotification('Lütfen bir lead status seçin.', 'error');
        return;
    }
    
    // Modal'ı kapat
    closeStatusChangeModal();
    
    // Status değişim işlemini başlat
    bulkChangeLeadStatus(selectedUsers, selectedStatus.trim());
}

// Generic bulk lead status change function
function bulkChangeLeadStatus(userIds, newStatus) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    showNotification(`${userIds.length} kullanıcının lead status'u "${newStatus}" olarak değiştiriliyor...`, 'info');
    
    fetch('{{ route("admin.manageusers.bulk-status") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            user_ids: userIds,
            new_status: newStatus
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            // Sayfayı yenile
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            showNotification(data.message || 'Lead status değişimi başarısız oldu.', 'error');
        }
    })
    .catch(error => {
        console.error('Bulk status change error:', error);
        showNotification(`Lead status değişimi sırasında bir hata oluştu: ${error.message}`, 'error');
    });
}

function openAddUserModal() {
    const modal = document.getElementById('add-user-modal');
    modal.classList.remove('hidden');
    modal.querySelector('.modal-backdrop').classList.remove('opacity-0');
    modal.querySelector('.modal-content').classList.remove('opacity-0', 'scale-95');
    modal.querySelector('.modal-backdrop').classList.add('opacity-100');
    modal.querySelector('.modal-content').classList.add('opacity-100', 'scale-100');
}

function closeAddUserModal() {
    const modal = document.getElementById('add-user-modal');
    modal.querySelector('.modal-backdrop').classList.remove('opacity-100');
    modal.querySelector('.modal-content').classList.remove('opacity-100', 'scale-100');
    modal.querySelector('.modal-backdrop').classList.add('opacity-0');
    modal.querySelector('.modal-content').classList.add('opacity-0', 'scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

function submitAddUser(event) {
    event.preventDefault();
    const form = event.target;
    
    // CSRF token ekle
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (csrfToken) {
        let csrfInput = form.querySelector('input[name="_token"]');
        if (!csrfInput) {
            csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
        }
    }
    
    // Form action ve method ayarla
    form.action = '{{ route("createuser") }}';
    form.method = 'POST';
    
    // Form'u submit et
    form.submit();
}

// Status Update Function
function updateLeadStatus(userId, newStatus) {
    // CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch(`/admin/dashboard/users/${userId}/update-lead-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            lead_status: newStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification('Lead status başarıyla güncellendi.', 'success');
        } else {
            showNotification(data.message || 'Bir hata oluştu.', 'error');
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Bir hata oluştu.', 'error');
        location.reload();
    });
}

// Assigned Admin Update Function
function updateAssignedAdmin(userId, adminId) {
    // CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch(`/admin/dashboard/users/${userId}/update-assigned-admin`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            admin_id: adminId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification('Admin ataması başarıyla güncellendi!', 'success');
        } else {
            showNotification(data.message || 'Bir hata oluştu.', 'error');
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Bir hata oluştu.', 'error');
        location.reload();
    });
}

// Simple notification function
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-600 text-white' :
        type === 'error' ? 'bg-red-600 text-white' : 'bg-blue-600 text-white'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Listen for checkbox changes
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('user-checkbox')) {
        updateBulkActions();
    }
});
// Per-Page Change Function
function changePerPage(perPageValue) {
    // Mevcut URL'yi al ve per_page parametresini güncelle
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', perPageValue);
    url.searchParams.set('page', '1'); // Yeni per_page seçildiğinde 1. sayfaya git
    
    // Sayfayı yenile
    window.location.href = url.toString();
}
</script>
@endsection