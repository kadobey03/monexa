@php
    $isDark = Auth('admin')->User()->dashboard_style !== 'light';
@endphp

@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-admin-50 {{ $isDark ? 'dark:bg-admin-900' : '' }}">
    <!-- Header Section -->
    <div class="bg-admin-100 {{ $isDark ? 'dark:bg-admin-800' : '' }} border-b border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
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
                            {{ isset($users) ? $users->total() : $user_count ?? 0 }} Toplam Kullanıcı
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
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

        <!-- Main Table Container -->
        <div class="bg-white {{ $isDark ? 'dark:bg-admin-800' : '' }} rounded-xl shadow-lg border border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }} overflow-hidden">
            
            <!-- Table Header with Search and Actions -->
            <div class="bg-gradient-to-r from-admin-600 to-admin-700 px-6 py-5">
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
                <table class="min-w-full" id="users-table">
                    <!-- Professional Table Header -->
                    <thead class="bg-admin-100 {{ $isDark ? 'dark:bg-admin-700' : '' }} border-b-2 border-admin-200 {{ $isDark ? 'dark:border-admin-600' : '' }}">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left">
                                <input type="checkbox" id="select-all" 
                                       class="rounded border-admin-300 text-admin-600 shadow-sm focus:border-admin-500 focus:ring-admin-500"
                                       onchange="toggleAllUsers(this)">
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user text-admin-500"></i>
                                    <span>Kullanıcı Bilgileri</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-envelope text-admin-500"></i>
                                    <span>İletişim</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-phone text-admin-500"></i>
                                    <span>Telefon</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-calendar text-admin-500"></i>
                                    <span>Kayıt Tarihi</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} uppercase tracking-wider">
                                <div class="flex items-center justify-center space-x-2">
                                    <i class="fas fa-toggle-on text-admin-500"></i>
                                    <span>Durum</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-admin-700 {{ $isDark ? 'dark:text-admin-300' : '' }} uppercase tracking-wider">
                                <div class="flex items-center justify-center space-x-2">
                                    <i class="fas fa-cogs text-admin-500"></i>
                                    <span>İşlemler</span>
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <!-- Professional Table Body -->
                    <tbody class="bg-white {{ $isDark ? 'dark:bg-admin-800' : '' }} divide-y divide-admin-200 {{ $isDark ? 'dark:divide-admin-700' : '' }}">
                        @forelse ($users ?? [] as $user)
                            <tr class="hover:bg-admin-50 {{ $isDark ? 'dark:hover:bg-admin-700' : '' }} transition-colors duration-150 group">
                                <!-- Selection Checkbox -->
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" 
                                           class="user-checkbox rounded border-admin-300 text-admin-600 shadow-sm focus:border-admin-500 focus:ring-admin-500"
                                           onchange="updateBulkActions()">
                                </td>

                                <!-- User Info with Professional Avatar -->
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <div class="h-12 w-12 rounded-full bg-gradient-to-br from-admin-500 to-admin-600 {{ $isDark ? 'dark:from-admin-400 dark:to-admin-500' : '' }} flex items-center justify-center shadow-lg">
                                                <span class="text-lg font-bold text-white">
                                                    {{ substr($user->name ?? '', 0, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">
                                                {{ $user->name ?? 'Ad Soyad Yok' }}
                                            </div>
                                            <div class="text-xs text-admin-500 {{ $isDark ? 'dark:text-admin-400' : '' }}">
                                                ID: {{ $user->id }} | @{{ $user->username ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Contact Information -->
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="text-sm text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">
                                        {{ $user->email ?? '-' }}
                                    </div>
                                    @if($user->email_verified_at)
                                        <div class="text-xs text-green-600">
                                            <i class="fas fa-check-circle mr-1"></i>Doğrulanmış
                                        </div>
                                    @else
                                        <div class="text-xs text-amber-600">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>Doğrulanmamış
                                        </div>
                                    @endif
                                </td>

                                <!-- Phone -->
                                <td class="px-6 py-5 whitespace-nowrap text-sm text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">
                                    {{ $user->phone ?? '-' }}
                                </td>

                                <!-- Registration Date -->
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="text-sm text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">
                                        {{ $user->created_at ? $user->created_at->format('d.m.Y') : '-' }}
                                    </div>
                                    <div class="text-xs text-admin-500 {{ $isDark ? 'dark:text-admin-400' : '' }}">
                                        {{ $user->created_at ? $user->created_at->diffForHumans() : '-' }}
                                    </div>
                                </td>

                                <!-- Enhanced Status Badge -->
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    @switch($user->status ?? 'active')
                                        @case('active')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 {{ $isDark ? 'dark:bg-green-800 dark:text-green-100' : '' }}">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Aktif
                                            </span>
                                            @break
                                        @case('blocked')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 {{ $isDark ? 'dark:bg-red-800 dark:text-red-100' : '' }}">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Engelli
                                            </span>
                                            @break
                                        @case('pending')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 {{ $isDark ? 'dark:bg-yellow-800 dark:text-yellow-100' : '' }}">
                                                <i class="fas fa-clock mr-1"></i>
                                                Bekliyor
                                            </span>
                                            @break
                                        @default
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 {{ $isDark ? 'dark:bg-gray-700 dark:text-gray-200' : '' }}">
                                                <i class="fas fa-question-circle mr-1"></i>
                                                Belirsiz
                                            </span>
                                    @endswitch
                                </td>

                                <!-- Modern Action Buttons -->
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button onclick="viewUser({{ $user->id }})"
                                                class="p-2 rounded-lg text-admin-600 hover:bg-admin-100 {{ $isDark ? 'dark:text-admin-400 dark:hover:bg-admin-700' : '' }} transition-colors duration-200"
                                                title="Görüntüle">
                                            <i class="fas fa-eye text-sm"></i>
                                        </button>
                                        <button onclick="editUser({{ $user->id }})"
                                                class="p-2 rounded-lg text-blue-600 hover:bg-blue-100 {{ $isDark ? 'dark:text-blue-400 dark:hover:bg-blue-800' : '' }} transition-colors duration-200"
                                                title="Düzenle">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                        @if($user->status == 'active')
                                            <button onclick="blockUser({{ $user->id }})"
                                                    class="p-2 rounded-lg text-red-600 hover:bg-red-100 {{ $isDark ? 'dark:text-red-400 dark:hover:bg-red-800' : '' }} transition-colors duration-200"
                                                    title="Engelle">
                                                <i class="fas fa-ban text-sm"></i>
                                            </button>
                                        @else
                                            <button onclick="unblockUser({{ $user->id }})"
                                                    class="p-2 rounded-lg text-green-600 hover:bg-green-100 {{ $isDark ? 'dark:text-green-400 dark:hover:bg-green-800' : '' }} transition-colors duration-200"
                                                    title="Aktifleştir">
                                                <i class="fas fa-check text-sm"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-users text-6xl text-admin-400 {{ $isDark ? 'dark:text-admin-500' : '' }} mb-4"></i>
                                        <h3 class="text-lg font-medium text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }} mb-2">
                                            Kullanıcı Bulunamadı
                                        </h3>
                                        <p class="text-admin-500 {{ $isDark ? 'dark:text-admin-400' : '' }} text-center">
                                            Henüz hiç kullanıcı eklenmemiş veya arama kriterlerinize uygun kullanıcı bulunamadı.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Enhanced Pagination Footer -->
            <div class="bg-admin-50 {{ $isDark ? 'dark:bg-admin-750' : '' }} px-6 py-4 border-t border-admin-200 {{ $isDark ? 'dark:border-admin-600' : '' }}">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-admin-600 {{ $isDark ? 'dark:text-admin-400' : '' }}">
                            @if(isset($users) && method_exists($users, 'total'))
                                {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} arası,
                                toplam <span class="font-semibold text-admin-900 {{ $isDark ? 'dark:text-admin-100' : '' }}">{{ $users->total() }}</span> kullanıcı
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        @if(isset($users) && method_exists($users, 'links'))
                            <x-admin-pagination :paginator="$users" />
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Bulk Actions Bar (Hidden by default) -->
        <div id="bulk-actions-bar" class="hidden mt-6 bg-admin-600 {{ $isDark ? 'dark:bg-admin-700' : '' }} rounded-xl shadow-lg p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-white font-medium">
                        <span id="selected-count">0</span> kullanıcı seçildi
                    </span>
                </div>
                <div class="flex items-center space-x-3">
                    <button onclick="bulkActivate()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-check mr-2"></i>Aktifleştir
                    </button>
                    <button onclick="bulkBlock()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-ban mr-2"></i>Engelle
                    </button>
                    <button onclick="exportSelected()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-download mr-2"></i>Seçilenleri Dışa Aktar
                    </button>
                </div>
            </div>
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
        alert('Lütfen en az bir kullanıcı seçin.');
        return;
    }
    
    if (confirm(`${selectedUsers.length} kullanıcıyı aktifleştirmek istediğinizden emin misiniz?`)) {
        // Implement bulk activation logic
        console.log('Bulk activate:', selectedUsers);
    }
}

function bulkBlock() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    if (selectedUsers.length === 0) {
        alert('Lütfen en az bir kullanıcı seçin.');
        return;
    }
    
    if (confirm(`${selectedUsers.length} kullanıcıyı engellemek istediğinizden emin misiniz?`)) {
        // Implement bulk block logic
        console.log('Bulk block:', selectedUsers);
    }
}

function exportUsers() {
    alert('Dışa aktarma özelliği yakında eklenecek.');
}

function exportSelected() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    if (selectedUsers.length === 0) {
        alert('Lütfen en az bir kullanıcı seçin.');
        return;
    }
    alert(`${selectedUsers.length} kullanıcı dışa aktarılacak.`);
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

// Listen for checkbox changes
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('user-checkbox')) {
        updateBulkActions();
    }
});
</script>
@endsection