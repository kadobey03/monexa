@extends('layouts.admin')

@section('content')
<div class="space-y-6" id="managersIndex">
    
    <!-- Page Header -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <x-heroicon name="user-cog" class="w-6 h-6 text-white" />
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-admin-900 dark:text-white">Yöneticiler</h1>
                        <p class="text-admin-600 dark:text-admin-400">Yönetici hesaplarını görüntüle ve yönet</p>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <!-- Add Manager Button -->
                <a href="{{ route('admin.managers.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium rounded-xl transition-all duration-200 shadow-lg hover:shadow-green-500/25">
                    <x-heroicon name="user-plus" class="w-4 h-4 mr-2" />
                    Yeni Yönetici
                </a>
                
                <!-- Export Button -->
                <button type="button" id="exportButton"
                        class="inline-flex items-center px-4 py-2 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 text-admin-700 dark:text-admin-300 font-medium rounded-xl transition-all duration-200">
                    <x-heroicon name="arrow-down-tray" class="w-4 h-4 mr-2" />
                    Dışa Aktar
                </button>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Toplam Yönetici</p>
                        <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $stats['total_admins'] }}</p>
                    </div>
                    <x-heroicon name="users" class="w-8 h-8 text-blue-500" />
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-4 border border-green-200 dark:border-green-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-green-600 dark:text-green-400 font-medium">Aktif</p>
                        <p class="text-2xl font-bold text-green-900 dark:text-green-100">{{ $stats['active_admins'] }}</p>
                    </div>
                    <x-heroicon name="user-check" class="w-8 h-8 text-green-500" />
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 rounded-xl p-4 border border-amber-200 dark:border-amber-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-amber-600 dark:text-amber-400 font-medium">Müsait</p>
                        <p class="text-2xl font-bold text-amber-900 dark:text-amber-100">{{ $stats['available_admins'] }}</p>
                    </div>
                    <x-heroicon name="clock" class="w-8 h-8 text-amber-500" />
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl p-4 border border-purple-200 dark:border-purple-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-purple-600 dark:text-purple-400 font-medium">Yüksek Performans</p>
                        <p class="text-2xl font-bold text-purple-900 dark:text-purple-100">{{ $stats['high_performers'] }}</p>
                    </div>
                    <x-heroicon name="arrow-trending-up" class="w-8 h-8 text-purple-500" />
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
        <form method="GET" class="space-y-4" id="filtersForm">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="magnifying-glass" class="w-4 h-4 inline mr-1" />
                        Arama
                    </label>
                    <input type="text" 
                           name="search" 
                           id="searchInput"
                           value="{{ request('search') }}"
                           placeholder="Ad, email, çalışan ID..."
                           class="admin-input w-full">
                </div>
                
                <!-- Role Filter -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="shield-check" class="w-4 h-4 inline mr-1" />
                        Rol
                    </label>
                    <select name="role_id" 
                            id="roleFilter"
                            class="admin-input w-full">
                        <option value="">Tüm Roller</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Department Filter -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="building" class="w-4 h-4 inline mr-1" />
                        Departman
                    </label>
                    <select name="department" 
                            id="departmentFilter"
                            class="admin-input w-full">
                        <option value="">Tüm Departmanlar</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                                {{ ucfirst($dept) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="activity" class="w-4 h-4 inline mr-1" />
                        Durum
                    </label>
                    <select name="status" 
                            id="statusFilter"
                            class="admin-input w-full">
                        <option value="">Tüm Durumlar</option>
                        <option value="{{ \App\Models\Admin::STATUS_ACTIVE }}" {{ request('status') == \App\Models\Admin::STATUS_ACTIVE ? 'selected' : '' }}>Aktif</option>
                        <option value="{{ \App\Models\Admin::STATUS_INACTIVE }}" {{ request('status') == \App\Models\Admin::STATUS_INACTIVE ? 'selected' : '' }}>Pasif</option>
                        <option value="{{ \App\Models\Admin::STATUS_SUSPENDED }}" {{ request('status') == \App\Models\Admin::STATUS_SUSPENDED ? 'selected' : '' }}>Askıya Alınmış</option>
                    </select>
                </div>
            </div>
            
            <div class="flex items-center justify-between pt-4 border-t border-admin-200 dark:border-admin-700">
                <div class="flex items-center space-x-3">
                    <!-- Clear Filters -->
                    <a href="{{ route('admin.managers.index') }}" 
                       class="text-sm text-admin-500 hover:text-admin-700 dark:hover:text-admin-300">
                        Filtreleri Temizle
                    </a>
                    
                    <!-- Results Count -->
                    <span class="text-sm text-admin-600 dark:text-admin-400">
                        {{ $admins->total() }} sonuç bulundu
                    </span>
                </div>
                
                <!-- Bulk Actions -->
                <div class="flex items-center space-x-3 hidden" id="bulkActionsContainer">
                    <span class="text-sm text-admin-600 dark:text-admin-400" id="selectedCount">0 seçili</span>
                    
                    <div class="relative">
                        <button type="button" id="bulkActionsButton"
                                class="inline-flex items-center px-3 py-1.5 bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-sm font-medium rounded-lg hover:bg-primary-200 dark:hover:bg-primary-900/50 transition-colors">
                            <x-heroicon name="cog-6-tooth" class="w-4 h-4 mr-1" />
                            Toplu İşlem
                            <x-heroicon name="chevron-down" class="w-3 h-3 ml-1" />
                        </button>
                        
                        <div id="bulkActionsDropdown" 
                             class="absolute right-0 mt-2 w-48 bg-white dark:bg-admin-800 rounded-xl shadow-elegant border border-admin-200 dark:border-admin-700 py-2 z-10 hidden">
                            <button type="button" data-action="activate" class="bulk-action-btn w-full px-4 py-2 text-left text-sm text-admin-700 dark:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 transition-colors">
                                <x-heroicon name="play" class="w-4 h-4 inline mr-2 text-green-500" />
                                Aktifleştir
                            </button>
                            <button type="button" data-action="deactivate" class="bulk-action-btn w-full px-4 py-2 text-left text-sm text-admin-700 dark:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 transition-colors">
                                <x-heroicon name="pause" class="w-4 h-4 inline mr-2 text-amber-500" />
                                Devre Dışı Bırak
                            </button>
                            <button type="button" data-action="delete" class="bulk-action-btn w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <x-heroicon name="trash-2" class="w-4 h-4 inline mr-2" />
                                Sil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Managers Table -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-admin-50 dark:bg-admin-900/50 border-b border-admin-200 dark:border-admin-700">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            <input type="checkbox" 
                                   class="admin-checkbox"
                                   id="selectAllCheckbox">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-admin-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'firstName', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="flex items-center space-x-1 hover:text-admin-700 dark:hover:text-admin-300">
                                <span>Yönetici</span>
                                @if(request('sort_by') === 'firstName')
                                    <x-heroicon name="question-mark-circle" class="w-4 h-4" />
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-admin-500 uppercase tracking-wider">Rol & Departman</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-admin-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'hierarchy_level', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="flex items-center space-x-1 hover:text-admin-700 dark:hover:text-admin-300">
                                <span>Hiyerarşi</span>
                                @if(request('sort_by') === 'hierarchy_level')
                                    <x-heroicon name="question-mark-circle" class="w-4 h-4" />
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-admin-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'current_performance', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="flex items-center space-x-1 hover:text-admin-700 dark:hover:text-admin-300">
                                <span>Performans</span>
                                @if(request('sort_by') === 'current_performance')
                                    <x-heroicon name="question-mark-circle" class="w-4 h-4" />
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-admin-500 uppercase tracking-wider">Durum</th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-admin-500 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-200 dark:divide-admin-700">
                    @forelse($admins as $admin)
                    <tr class="hover:bg-admin-50 dark:hover:bg-admin-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" 
                                   class="admin-checkbox row-checkbox"
                                   value="{{ $admin->id }}">
                        </td>
                        
                        <!-- Admin Info -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if($admin->avatar)
                                        <img src="{{ asset('storage/' . $admin->avatar) }}" 
                                             alt="{{ $admin->getFullName() }}"
                                             class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                            {{ substr($admin->firstName, 0, 1) }}{{ substr($admin->lastName, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center space-x-2">
                                        <p class="text-sm font-medium text-admin-900 dark:text-white">
                                            {{ $admin->getFullName() }}
                                        </p>
                                        @if($admin->is_available)
                                            <span class="w-2 h-2 bg-green-400 rounded-full" title="Müsait"></span>
                                        @else
                                            <span class="w-2 h-2 bg-gray-400 rounded-full" title="Meşgul"></span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-admin-500 truncate">{{ $admin->email }}</p>
                                    @if($admin->employee_id)
                                        <p class="text-xs text-admin-400">ID: {{ $admin->employee_id }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        
                        <!-- Role & Department -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-admin-900 dark:text-white">
                                @if($admin->role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                        {{ $admin->role->display_name }}
                                    </span>
                                @else
                                    <span class="text-admin-400">Rol atanmamış</span>
                                @endif
                            </div>
                            @if($admin->department)
                                <p class="text-xs text-admin-500 mt-1">{{ ucfirst($admin->department) }}</p>
                            @endif
                        </td>
                        
                        <!-- Hierarchy -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-admin-600 dark:text-admin-400">
                                    Seviye {{ $admin->hierarchy_level }}
                                </span>
                                @if($admin->supervisor)
                                    <x-heroicon name="arrow-up" class="w-3 h-3 text-admin-400" title="Rapor Veriyor: {{ $admin->supervisor->getFullName() }}" />
                                @endif
                            </div>
                            <div class="text-xs text-admin-500">
                                {{ $admin->subordinates_count }} alt çalışan
                            </div>
                        </td>
                        
                        <!-- Performance -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between text-xs mb-1">
                                        <span class="text-admin-600 dark:text-admin-400">Performans</span>
                                        <span class="font-medium text-admin-900 dark:text-white">{{ number_format($admin->current_performance, 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-admin-200 dark:bg-admin-700 rounded-full h-1.5">
                                        <div class="bg-gradient-to-r from-green-400 to-green-500 h-1.5 rounded-full" 
                                             style="width: {{ min(100, $admin->current_performance) }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-xs text-admin-500 mt-1">
                                {{ $admin->leads_assigned_count }}/{{ $admin->leads_converted_count }} lead
                            </div>
                        </td>
                        
                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'Active' => 'green',
                                    'Inactive' => 'gray',
                                    'Suspended' => 'red',
                                ];
                                $statusLabels = [
                                    'Active' => 'Aktif',
                                    'Inactive' => 'Pasif', 
                                    'Suspended' => 'Askıya Alınmış',
                                ];
                                $color = $statusColors[$admin->status] ?? 'gray';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 dark:bg-{{ $color }}-900/30 text-{{ $color }}-800 dark:text-{{ $color }}-300">
                                {{ $statusLabels[$admin->status] ?? $admin->status }}
                            </span>
                            @if($admin->last_activity)
                                <p class="text-xs text-admin-500 mt-1">
                                    {{ $admin->last_activity->diffForHumans() }}
                                </p>
                            @endif
                        </td>
                        
                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <!-- Edit Modal -->
                                @if($currentAdmin->canManageAdmin($admin))
                                    <button class="text-admin-400 hover:text-amber-500 transition-colors edit-admin-btn"
                                            data-admin-id="{{ $admin->id }}"
                                            title="Düzenle">
                                        <x-heroicon name="edit" class="w-4 h-4" />
                                    </button>
                                @endif
                                
                                <!-- More Actions -->
                                <div class="relative action-dropdown">
                                    <button class="text-admin-400 hover:text-admin-600 dark:hover:text-admin-300 transition-colors action-dropdown-button">
                                        <x-heroicon name="more-vertical" class="w-4 h-4" />
                                    </button>
                                    
                                    <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-admin-800 rounded-xl shadow-elegant border border-admin-200 dark:border-admin-700 py-2 z-10 hidden action-dropdown-menu">
                                        @if($admin->status === 'Active')
                                            <a href="{{ route('admin.managers.deactivate', $admin) }}" 
                                               class="block px-4 py-2 text-sm text-admin-700 dark:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 transition-colors">
                                                <x-heroicon name="pause" class="w-4 h-4 inline mr-2 text-amber-500" />
                                                Devre Dışı Bırak
                                            </a>
                                        @else
                                            <a href="{{ route('admin.managers.activate', $admin) }}" 
                                               class="block px-4 py-2 text-sm text-admin-700 dark:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 transition-colors">
                                                <x-heroicon name="play" class="w-4 h-4 inline mr-2 text-green-500" />
                                                Aktifleştir
                                            </a>
                                        @endif
                                        
                                        @if($currentAdmin->canManageAdmin($admin))
                                            <button class="w-full text-left px-4 py-2 text-sm text-admin-700 dark:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 transition-colors reset-password-btn"
                                                    data-admin-id="{{ $admin->id }}"
                                                    data-admin-name="{{ $admin->getFullName() }}">
                                                <x-heroicon name="key" class="w-4 h-4 inline mr-2 text-purple-500" />
                                                Şifre Sıfırla
                                            </button>
                                        @endif
                                        
                                        @if($currentAdmin->canManageAdmin($admin) && $currentAdmin->id !== $admin->id)
                                            <button class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors delete-admin-btn"
                                                    data-admin-id="{{ $admin->id }}"
                                                    data-admin-name="{{ $admin->getFullName() }}">
                                                <x-heroicon name="trash-2" class="w-4 h-4 inline mr-2" />
                                                Sil
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-admin-500">
                            <div class="flex flex-col items-center space-y-3">
                                <x-heroicon name="users-x" class="w-12 h-12 text-admin-400" />
                                <p class="text-lg font-medium">Yönetici bulunamadı</p>
                                <p class="text-sm">Arama kriterlerinizi değiştirmeyi deneyin</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($admins->hasPages())
            <div class="px-6 py-4 border-t border-admin-200 dark:border-admin-700">
                {{ $admins->links() }}
            </div>
        @endif
    </div>

    <!-- Edit Manager Modal -->
    <div id="editManagerModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity modal-backdrop">
                <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
            </div>
            <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-amber-600 dark:bg-amber-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                    <h4 class="text-lg font-semibold text-white flex items-center">
                        <x-heroicon name="user-pen" class="h-5 w-5 mr-2" />Yönetici Düzenle
                    </h4>
                    <button class="absolute top-4 right-4 text-white hover:text-gray-200 modal-close-btn">
                        <x-heroicon name="x-mark" class="h-5 w-5" />
                    </button>
                </div>
                <div class="p-6">
                    <form id="editManagerForm" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- First Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <x-heroicon name="user" class="h-4 w-4 inline mr-2 text-amber-600" />Ad *
                                </label>
                                <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-admin-700 dark:text-white"
                                       type="text" name="firstName" id="edit-firstName" required>
                            </div>
                            
                            <!-- Last Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <x-heroicon name="user-circle" class="h-4 w-4 inline mr-2 text-amber-600" />Soyad *
                                </label>
                                <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-admin-700 dark:text-white"
                                       type="text" name="lastName" id="edit-lastName" required>
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <x-heroicon name="envelope" class="h-4 w-4 inline mr-2 text-amber-600" />E-posta *
                                </label>
                                <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-admin-700 dark:text-white"
                                       type="email" name="email" id="edit-email" required>
                            </div>
                            
                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <x-heroicon name="phone" class="h-4 w-4 inline mr-2 text-amber-600" />Telefon
                                </label>
                                <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-admin-700 dark:text-white"
                                       type="tel" name="phone" id="edit-phone">
                            </div>
                            
                            <!-- Role -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <x-heroicon name="shield-check" class="h-4 w-4 inline mr-2 text-amber-600" />Rol
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-admin-700 dark:text-white"
                                        name="role_id" id="edit-role_id">
                                    <option value="">Rol Seçin</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Supervisor -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <x-heroicon name="user-check" class="h-4 w-4 inline mr-2 text-amber-600" />Süpervizör
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-admin-700 dark:text-white"
                                        name="supervisor_id" id="edit-supervisor_id">
                                    <option value="">Süpervizör Seçin</option>
                                    @foreach($supervisors as $supervisor)
                                        <option value="{{ $supervisor->id }}">{{ $supervisor->getFullName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Department -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <x-heroicon name="building" class="h-4 w-4 inline mr-2 text-amber-600" />Departman
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-admin-700 dark:text-white"
                                        name="department" id="edit-department">
                                    <option value="">Departman Seçin</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept }}">{{ ucfirst($dept) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <x-heroicon name="activity" class="h-4 w-4 inline mr-2 text-amber-600" />Durum
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-admin-700 dark:text-white"
                                        name="status" id="edit-status">
                                    <option value="{{ \App\Models\Admin::STATUS_ACTIVE }}">Aktif</option>
                                    <option value="{{ \App\Models\Admin::STATUS_INACTIVE }}">Pasif</option>
                                    <option value="{{ \App\Models\Admin::STATUS_SUSPENDED }}">Askıya Alınmış</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                <x-heroicon name="save" class="h-4 w-4 mr-2" />Yönetici Bilgilerini Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div id="resetPasswordModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity modal-backdrop">
                <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
            </div>
            <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-purple-600 dark:bg-purple-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                    <h4 class="text-lg font-semibold text-white flex items-center">
                        <x-heroicon name="key" class="h-5 w-5 mr-2" />Şifre Sıfırla
                    </h4>
                    <button class="absolute top-4 right-4 text-white hover:text-gray-200 modal-close-btn">
                        <x-heroicon name="x-mark" class="h-5 w-5" />
                    </button>
                </div>
                <div class="p-6">
                    <div class="mb-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                                <x-heroicon name="user" class="w-6 h-6 text-white" />
                            </div>
                            <div>
                                <p class="text-lg font-medium text-admin-900 dark:text-white" id="reset-admin-name"></p>
                                <p class="text-sm text-admin-500">için yeni şifre oluşturuluyor</p>
                            </div>
                        </div>
                        
                        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4 mb-4">
                            <div class="flex">
                                <x-heroicon name="information-circle" class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5 mr-3" />
                                <div class="text-sm">
                                    <h4 class="font-medium text-amber-800 dark:text-amber-300 mb-1">Güvenlik Bilgisi</h4>
                                    <p class="text-amber-700 dark:text-amber-400">
                                        Sistem otomatik olarak güçlü bir şifre oluşturacak. Yeni şifre aşağıda görüntülenecektir.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Generated Password Display -->
                        <div id="passwordDisplay" class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-4 hidden">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <x-heroicon name="check-circle" class="w-5 h-5 text-green-600 dark:text-green-400" />
                                    <div>
                                        <p class="font-medium text-green-800 dark:text-green-300">Yeni Şifre Oluşturuldu</p>
                                        <p class="text-sm text-green-700 dark:text-green-400">Şifre başarıyla güncellendi.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 p-3 bg-white dark:bg-admin-700 rounded border">
                                <div class="flex items-center justify-between">
                                    <code class="text-sm font-mono text-admin-900 dark:text-white" id="newPassword"></code>
                                    <button id="copyPasswordBtn" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">
                                        <x-heroicon name="copy" class="w-4 h-4 inline mr-1" />Kopyala
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <button id="generatePasswordBtn"
                                class="flex-1 flex justify-center items-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            <x-heroicon name="arrow-path" class="h-4 w-4 mr-2" />Yeni Şifre Oluştur
                        </button>
                        
                        <button class="px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-admin-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600 modal-close-btn">
                            İptal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
class ManagersIndex {
    constructor() {
        this.selectedAdmins = [];
        this.searchTimeout = null;
        this.init();
    }
    
    init() {
        this.bindEvents();
    }
    
    bindEvents() {
        // Search input with debounce
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => {
                    document.getElementById('filtersForm').submit();
                }, 500);
            });
        }
        
        // Filter selects
        const filters = ['roleFilter', 'departmentFilter', 'statusFilter'];
        filters.forEach(filterId => {
            const element = document.getElementById(filterId);
            if (element) {
                element.addEventListener('change', () => {
                    document.getElementById('filtersForm').submit();
                });
            }
        });
        
        // Select all checkbox
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', () => {
                this.toggleSelectAll();
            });
        }
        
        // Row checkboxes
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                this.updateSelection();
            });
        });
        
        // Bulk actions
        const bulkActionsButton = document.getElementById('bulkActionsButton');
        if (bulkActionsButton) {
            bulkActionsButton.addEventListener('click', () => {
                this.toggleBulkActionsDropdown();
            });
        }
        
        // Bulk action buttons
        const bulkActionBtns = document.querySelectorAll('.bulk-action-btn');
        bulkActionBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                this.bulkAction(btn.dataset.action);
            });
        });
        
        // Edit admin buttons
        const editBtns = document.querySelectorAll('.edit-admin-btn');
        editBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                this.openEditModal(btn.dataset.adminId);
            });
        });
        
        // Reset password buttons
        const resetPasswordBtns = document.querySelectorAll('.reset-password-btn');
        resetPasswordBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                this.openResetPasswordModal(btn.dataset.adminId, btn.dataset.adminName);
            });
        });
        
        // Delete admin buttons
        const deleteBtns = document.querySelectorAll('.delete-admin-btn');
        deleteBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                this.deleteAdmin(btn.dataset.adminId, btn.dataset.adminName);
            });
        });
        
        // Action dropdowns
        const actionDropdowns = document.querySelectorAll('.action-dropdown');
        actionDropdowns.forEach(dropdown => {
            const button = dropdown.querySelector('.action-dropdown-button');
            const menu = dropdown.querySelector('.action-dropdown-menu');
            
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleActionDropdown(dropdown);
            });
        });
        
        // Close dropdowns on click outside
        document.addEventListener('click', () => {
            this.closeAllDropdowns();
        });
        
        // Modal events
        const modalCloseBtns = document.querySelectorAll('.modal-close-btn');
        modalCloseBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                this.closeModals();
            });
        });
        
        const modalBackdrops = document.querySelectorAll('.modal-backdrop');
        modalBackdrops.forEach(backdrop => {
            backdrop.addEventListener('click', () => {
                this.closeModals();
            });
        });
        
        // Edit form submission
        const editForm = document.getElementById('editManagerForm');
        if (editForm) {
            editForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.submitEditForm();
            });
        }
        
        // Password generation
        const generatePasswordBtn = document.getElementById('generatePasswordBtn');
        if (generatePasswordBtn) {
            generatePasswordBtn.addEventListener('click', () => {
                this.generateNewPassword();
            });
        }
        
        // Copy password
        const copyPasswordBtn = document.getElementById('copyPasswordBtn');
        if (copyPasswordBtn) {
            copyPasswordBtn.addEventListener('click', () => {
                this.copyPassword();
            });
        }
    }
    
    toggleSelectAll() {
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        
        if (selectAllCheckbox.checked) {
            this.selectedAdmins = Array.from(rowCheckboxes).map(cb => cb.value);
            rowCheckboxes.forEach(cb => cb.checked = true);
        } else {
            this.selectedAdmins = [];
            rowCheckboxes.forEach(cb => cb.checked = false);
        }
        
        this.updateBulkActionsVisibility();
    }
    
    updateSelection() {
        const rowCheckboxes = document.querySelectorAll('.row-checkbox:checked');
        this.selectedAdmins = Array.from(rowCheckboxes).map(cb => cb.value);
        
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const totalCheckboxes = document.querySelectorAll('.row-checkbox').length;
        
        selectAllCheckbox.checked = this.selectedAdmins.length === totalCheckboxes;
        selectAllCheckbox.indeterminate = this.selectedAdmins.length > 0 && this.selectedAdmins.length < totalCheckboxes;
        
        this.updateBulkActionsVisibility();
    }
    
    updateBulkActionsVisibility() {
        const bulkActionsContainer = document.getElementById('bulkActionsContainer');
        const selectedCount = document.getElementById('selectedCount');
        
        if (this.selectedAdmins.length > 0) {
            bulkActionsContainer.classList.remove('hidden');
            selectedCount.textContent = `${this.selectedAdmins.length} seçili`;
        } else {
            bulkActionsContainer.classList.add('hidden');
        }
    }
    
    toggleBulkActionsDropdown() {
        const dropdown = document.getElementById('bulkActionsDropdown');
        dropdown.classList.toggle('hidden');
    }
    
    toggleActionDropdown(dropdown) {
        const menu = dropdown.querySelector('.action-dropdown-menu');
        
        // Close other dropdowns
        document.querySelectorAll('.action-dropdown-menu').forEach(otherMenu => {
            if (otherMenu !== menu) {
                otherMenu.classList.add('hidden');
            }
        });
        
        menu.classList.toggle('hidden');
    }
    
    closeAllDropdowns() {
        document.querySelectorAll('.action-dropdown-menu').forEach(menu => {
            menu.classList.add('hidden');
        });
        
        const bulkDropdown = document.getElementById('bulkActionsDropdown');
        if (bulkDropdown) {
            bulkDropdown.classList.add('hidden');
        }
    }
    
    async openEditModal(managerId) {
        try {
            console.log('🚀 DEBUG: openEditModal called with managerId:', managerId);
            
            const response = await fetch(`/admin/dashboard/managers/edit-data/${managerId}`);
            const data = await response.json();
            
            console.log('🚀 DEBUG: Response data:', data);
            
            if (data.success) {
                // Set form action - Yeni temiz endpoint kullanıyoruz
                const editForm = document.getElementById('editManagerForm');
                editForm.action = `/admin/dashboard/managers/${managerId}`;
                
                // Populate form
                document.getElementById('edit-firstName').value = data.manager.firstName || '';
                document.getElementById('edit-lastName').value = data.manager.lastName || '';
                document.getElementById('edit-email').value = data.manager.email || '';
                document.getElementById('edit-phone').value = data.manager.phone || '';
                document.getElementById('edit-role_id').value = data.manager.role_id || '';
                document.getElementById('edit-supervisor_id').value = data.manager.supervisor_id || '';
                document.getElementById('edit-department').value = data.manager.department || '';
                document.getElementById('edit-status').value = data.manager.status || '';
                
                // Show modal
                document.getElementById('editManagerModal').classList.remove('hidden');
            } else {
                console.error('🚨 DEBUG: Request failed with message:', data.message);
                Swal.fire('Hata!', data.message || 'Yönetici bilgileri alınamadı.', 'error');
            }
        } catch (error) {
            console.error('🚨 DEBUG: Fetch error:', error);
            Swal.fire('Hata!', 'Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
        }
    }
    
    async submitEditForm() {
        const form = document.getElementById('editManagerForm');
        const formData = new FormData(form);
        
        // Laravel'da PUT methodu için _method alanını ekle
        formData.append('_method', 'PUT');
        
        try {
            const response = await fetch(form.action, {
                method: 'POST', // Laravel'da PUT için POST + _method kullanılır
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                Swal.fire('Başarılı!', data.message, 'success').then(() => {
                    window.location.reload();
                });
            } else {
                if (data.errors) {
                    let errorMsg = 'Doğrulama hataları:\n\n';
                    Object.keys(data.errors).forEach(field => {
                        const fieldNames = {
                            'email': 'E-posta',
                            'firstName': 'Ad',
                            'lastName': 'Soyad',
                            'employee_id': 'Çalışan ID'
                        };
                        const fieldName = fieldNames[field] || field;
                        errorMsg += `• ${fieldName}: ${data.errors[field].join(', ')}\n`;
                    });
                    Swal.fire('Doğrulama Hatası!', errorMsg, 'error');
                } else {
                    Swal.fire('Hata!', data.message || 'Güncelleme sırasında bir hata oluştu.', 'error');
                }
            }
        } catch (error) {
            console.error('🚨 DEBUG: Submit error:', error);
            Swal.fire('Hata!', 'Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
        }
    }
    
    openResetPasswordModal(adminId, fullName) {
        document.getElementById('reset-admin-name').textContent = fullName;
        document.getElementById('resetPasswordModal').classList.remove('hidden');
        
        // Reset modal state
        document.getElementById('passwordDisplay').classList.add('hidden');
        document.getElementById('newPassword').textContent = '';
        
        // Store admin id for password generation
        this.currentResetAdminId = adminId;
    }
    
    async generateNewPassword() {
        if (!this.currentResetAdminId) {
            Swal.fire('Hata!', 'Admin ID bulunamadı.', 'error');
            return;
        }
        
        // Show loading
        Swal.fire({
            title: 'Şifre Oluşturuluyor...',
            text: 'Yeni şifre oluşturuluyor ve e-posta gönderiliyor.',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
        
        try {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            const response = await fetch(`/admin/dashboard/managers/${this.currentResetAdminId}/reset-password`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Show new password
                document.getElementById('newPassword').textContent = data.newPassword || 'Şifre oluşturuldu ve e-posta gönderildi';
                document.getElementById('passwordDisplay').classList.remove('hidden');
                document.getElementById('generatePasswordBtn').classList.add('hidden');
                
                Swal.fire({
                    title: 'Başarılı!',
                    text: data.message || 'Yeni şifre oluşturuldu ve kullanıcıya e-posta ile gönderildi.',
                    icon: 'success',
                    confirmButtonText: 'Tamam'
                });
            } else {
                Swal.fire('Hata!', data.message || 'Şifre sıfırlanırken bir hata oluştu.', 'error');
            }
        } catch (error) {
            console.error('🚨 DEBUG: Reset password error:', error);
            Swal.fire('Hata!', 'Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
        }
    }
    
    copyPassword() {
        const passwordText = document.getElementById('newPassword').textContent;
        
        if (passwordText && navigator.clipboard) {
            navigator.clipboard.writeText(passwordText).then(() => {
                Swal.fire({
                    title: 'Kopyalandı!',
                    text: 'Şifre panoya kopyalandı.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        }
    }
    
    deleteAdmin(id, name) {
        Swal.fire({
            title: 'Yönetici Sil',
            text: `${name} adlı yöneticiyi kalıcı olarak silmek istediğinizden emin misiniz?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Evet, Sil',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/dashboard/managers/${id}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    
    bulkAction(action) {
        if (this.selectedAdmins.length === 0) {
            return;
        }
        
        const actionMessages = {
            'activate': 'aktifleştirmek',
            'deactivate': 'devre dışı bırakmak', 
            'delete': 'silmek'
        };
        
        Swal.fire({
            title: 'Emin misiniz?',
            text: `Seçilen ${this.selectedAdmins.length} yöneticiyi ${actionMessages[action]} istiyorsunuz?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: action === 'delete' ? '#dc2626' : '#3b82f6',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Evet, devam et',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.performBulkAction(action);
            }
        });
    }
    
    async performBulkAction(action) {
        try {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('action', action);
            this.selectedAdmins.forEach(id => {
                formData.append('admin_ids[]', id);
            });
            
            const response = await fetch('{{ route("admin.managers.bulk-action") }}', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                Swal.fire('Başarılı!', data.message, 'success').then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire('Hata!', data.message, 'error');
            }
        } catch (error) {
            Swal.fire('Hata!', 'Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
        }
    }
    
    closeModals() {
        document.getElementById('editManagerModal').classList.add('hidden');
        document.getElementById('resetPasswordModal').classList.add('hidden');
        
        // Reset password modal state
        document.getElementById('generatePasswordBtn').classList.remove('hidden');
        this.currentResetAdminId = null;
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new ManagersIndex();
});
</script>
@endpush