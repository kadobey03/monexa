@extends('layouts.admin')

@section('content')
<div class="space-y-6" id="permissionsContainer">
    
    <!-- Page Header -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-admin-900 dark:text-white">{{ __('admin.permissions.index.title') }}</h1>
                    <p class="text-admin-600 dark:text-admin-400">{{ __('admin.permissions.index.description') }}</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <button id="auditLogBtn" class="inline-flex items-center px-4 py-2 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 text-admin-700 dark:text-admin-300 rounded-xl transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ __('admin.permissions.index.audit_log') }}
                </button>
                
                <a href="{{ route('admin.permissions.hierarchy') }}" 
                   class="inline-flex items-center px-4 py-2 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 text-admin-700 dark:text-admin-300 rounded-xl transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                    </svg>
                    {{ __('admin.permissions.index.hierarchy_view') }}
                </a>
                
                <button id="bulkAssignBtn" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl shadow-lg hover:shadow-blue-500/25 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    {{ __('admin.permissions.index.bulk_assign') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl p-6 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">{{ __('admin.permissions.index.total_roles') }}</p>
                    <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $totalRoles ?? 0 }}</p>
                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                        {{ $activeRoles ?? 0 }} {{ __('admin.permissions.index.active') }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-2xl p-6 border border-green-200 dark:border-green-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-600 dark:text-green-400 font-medium">{{ __('admin.permissions.index.total_permissions') }}</p>
                    <p class="text-2xl font-bold text-green-700 dark:text-green-300">{{ $totalPermissions ?? 0 }}</p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                        {{ $permissionCategories ?? 0 }} {{ __('admin.permissions.index.categories') }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 01-2 2m2-2h3m-3 0h-3m-2-5a2 2 0 01-2 2H9a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2v2zM7 21h10a2 2 0 002-2v-2a2 2 0 00-2-2H7a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 rounded-2xl p-6 border border-amber-200 dark:border-amber-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-amber-600 dark:text-amber-400 font-medium">{{ __('admin.permissions.index.assigned_permissions') }}</p>
                    <p class="text-2xl font-bold text-amber-700 dark:text-amber-300">{{ $assignedPermissions ?? 0 }}</p>
                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-1">
                        {{ number_format(($assignedPermissions ?? 0) / (($totalRoles ?? 1) * ($totalPermissions ?? 1)) * 100, 1) }}% {{ __('admin.permissions.index.filled') }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-2xl p-6 border border-purple-200 dark:border-purple-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-purple-600 dark:text-purple-400 font-medium">{{ __('admin.permissions.index.last_change') }}</p>
                    <p class="text-lg font-bold text-purple-700 dark:text-purple-300">{{ $lastChangeAgo ?? 'N/A' }}</p>
                    <p class="text-xs text-purple-600 dark:text-purple-400 mt-1">
                        {{ $lastChangeUser ?? 'System' }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Filters -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-admin-900 dark:text-white">{{ __('admin.permissions.index.quick_actions') }}</h2>
            <div class="flex items-center space-x-3">
                <!-- Filter Dropdown -->
                <div class="relative" id="filterDropdown">
                    <button id="filterToggle" class="inline-flex items-center px-4 py-2 bg-admin-100 dark:bg-admin-700 text-admin-700 dark:text-admin-300 rounded-xl hover:bg-admin-200 dark:hover:bg-admin-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                        </svg>
                        {{ __('admin.permissions.index.filter') }}
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div id="filterPanel" class="hidden absolute right-0 mt-2 w-64 bg-white dark:bg-admin-800 rounded-xl shadow-elegant border border-admin-200 dark:border-admin-700 p-4 z-10">
                        <div class="space-y-3">
                            <!-- Role Filter -->
                            <div>
                                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-1">{{ __('admin.permissions.index.role') }}</label>
                                <select id="roleFilter" class="admin-input w-full text-sm">
                                    <option value="">{{ __('admin.permissions.index.all') }}</option>
                                    @foreach($roles ?? [] as $role)
                                        <option value="{{ $role->id }}">{{ $role->display_name ?? $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Category Filter -->
                            <div>
                                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-1">{{ __('admin.permissions.index.category') }}</label>
                                <select id="categoryFilter" class="admin-input w-full text-sm">
                                    <option value="">{{ __('admin.permissions.index.all') }}</option>
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Status Filter -->
                            <div>
                                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-1">{{ __('admin.permissions.index.status') }}</label>
                                <select id="statusFilter" class="admin-input w-full text-sm">
                                    <option value="">{{ __('admin.permissions.index.all') }}</option>
                                    <option value="assigned">{{ __('admin.permissions.index.assigned') }}</option>
                                    <option value="unassigned">{{ __('admin.permissions.index.unassigned') }}</option>
                                </select>
                            </div>
                            
                            <hr class="border-admin-200 dark:border-admin-600">
                            
                            <button id="resetFiltersBtn" class="w-full text-sm text-admin-600 dark:text-admin-400 hover:text-admin-800 dark:hover:text-admin-200">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('admin.permissions.index.clear_filters') }}
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- View Mode Toggle -->
                <div class="flex items-center bg-admin-100 dark:bg-admin-700 rounded-xl p-1" id="viewModeToggle">
                    <button data-view="matrix" class="view-mode-btn px-3 py-1 text-sm font-medium text-admin-700 dark:text-admin-300 rounded-lg transition-all active">
                        <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        {{ __('admin.permissions.index.matrix_view') }}
                    </button>
                    <button data-view="list" class="view-mode-btn px-3 py-1 text-sm font-medium text-admin-700 dark:text-admin-300 rounded-lg transition-all">
                        <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        {{ __('admin.permissions.index.list_view') }}
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Quick Action Buttons -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <button id="createRoleBtn" class="flex items-center justify-center p-4 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 border border-blue-200 dark:border-blue-800 rounded-xl transition-colors">
                <div class="text-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <p class="text-sm font-medium text-blue-700 dark:text-blue-300">{{ __('admin.permissions.index.new_role') }}</p>
                </div>
            </button>
            
            <button id="importPermissionsBtn" class="flex items-center justify-center p-4 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/40 border border-green-200 dark:border-green-800 rounded-xl transition-colors">
                <div class="text-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <p class="text-sm font-medium text-green-700 dark:text-green-300">{{ __('admin.permissions.index.import_permissions') }}</p>
                </div>
            </button>
            
            <button id="exportPermissionsBtn" class="flex items-center justify-center p-4 bg-amber-50 dark:bg-amber-900/20 hover:bg-amber-100 dark:hover:bg-amber-900/40 border border-amber-200 dark:border-amber-800 rounded-xl transition-colors">
                <div class="text-center">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 12l2 2 4-4m6-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-medium text-amber-700 dark:text-amber-300">{{ __('admin.permissions.index.download_report') }}</p>
                </div>
            </button>
            
            <button id="syncPermissionsBtn" class="flex items-center justify-center p-4 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/40 border border-purple-200 dark:border-purple-800 rounded-xl transition-colors">
                <div class="text-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <p class="text-sm font-medium text-purple-700 dark:text-purple-300">{{ __('admin.permissions.index.sync_permissions') }}</p>
                </div>
            </button>
        </div>
    </div>

    <!-- Permission Matrix View -->
    <div id="matrixView" class="view-panel bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
        <div class="p-6 border-b border-admin-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-admin-900 dark:text-white">{{ __('admin.permissions.index.role_permission_matrix') }}</h2>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                        <span>{{ __('admin.permissions.index.has_permission') }}</span>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                        <span>{{ __('admin.permissions.index.no_permission') }}</span>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-amber-500 rounded-full"></div>
                        <span>{{ __('admin.permissions.index.conditional') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Matrix Table -->
            <div class="overflow-x-auto">
                <table class="w-full" id="permissionMatrix">
                    <thead class="bg-admin-50 dark:bg-admin-700/50">
                        <tr>
                            <th class="sticky left-0 bg-admin-50 dark:bg-admin-700/50 px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider border-r border-admin-200 dark:border-admin-600">
                                {{ __('admin.permissions.index.permissions') }}
                            </th>
                            @foreach($roles ?? [] as $role)
                                <th class="px-3 py-3 text-center text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider border-r border-admin-200 dark:border-admin-600 min-w-24">
                                    <div class="transform -rotate-45 origin-center">
                                        <span class="block">{{ $role->display_name ?? $role->name }}</span>
                                        <span class="block text-xs text-admin-400 dark:text-admin-500">L{{ $role->hierarchy_level ?? 0 }}</span>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-admin-800 divide-y divide-admin-200 dark:divide-admin-600">
                        @foreach($permissionsByCategory ?? [] as $category => $permissions)
                            <!-- Category Header -->
                            <tr class="bg-admin-100 dark:bg-admin-700/30 category-header" data-category="{{ $category }}">
                                <td colspan="{{ count($roles ?? []) + 1 }}" class="px-6 py-3 text-sm font-medium text-admin-900 dark:text-white">
                                    <div class="flex items-center cursor-pointer" onclick="window.permissionsManager.toggleCategory('{{ $category }}')">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ ucfirst($category) }} ({{ count($permissions) }})
                                        <svg class="w-4 h-4 ml-2 category-icon transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Permission Rows -->
                            @foreach($permissions as $permission)
                                <tr class="hover:bg-admin-50 dark:hover:bg-admin-700/20 transition-colors permission-row category-{{ $category }}" 
                                    data-permission-id="{{ $permission->id }}"
                                    data-category="{{ $category }}">
                                    <td class="sticky left-0 bg-white dark:bg-admin-800 px-6 py-4 text-sm text-admin-900 dark:text-white border-r border-admin-200 dark:border-admin-600">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center mr-3">
                                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 01-2 2m2-2h3m-3 0h-3m-2-5a2 2 0 01-2 2H9a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2v2zM7 21h10a2 2 0 002-2v-2a2 2 0 00-2-2H7a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium">{{ $permission->display_name ?? $permission->name }}</p>
                                                @if($permission->description ?? false)
                                                    <p class="text-xs text-admin-500 mt-1">{{ $permission->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    @foreach($roles ?? [] as $role)
                                        <td class="px-3 py-4 text-center border-r border-admin-200 dark:border-admin-600">
                                            @php
                                                $hasPermission = method_exists($role, 'hasPermissionTo') ? $role->hasPermissionTo($permission) : false;
                                                $isInherited = method_exists($role, 'hasInheritedPermission') ? $role->hasInheritedPermission($permission) : false;
                                                $isDependency = method_exists($role, 'hasDependentPermission') ? $role->hasDependentPermission($permission) : false;
                                            @endphp
                                            
                                            <button class="permission-toggle w-8 h-8 rounded-full flex items-center justify-center transition-all duration-200 transform hover:scale-110 {{ $hasPermission ? 'bg-green-500 hover:bg-green-600' : 'bg-red-200 dark:bg-red-800 hover:bg-red-300 dark:hover:bg-red-700' }} {{ $isInherited ? 'bg-amber-500 hover:bg-amber-600' : '' }} {{ $isDependency ? 'ring-2 ring-blue-500 ring-offset-2' : '' }}"
                                                    data-role-id="{{ $role->id }}"
                                                    data-permission-id="{{ $permission->id }}"
                                                    title="{{ $hasPermission ? 'İzin verilmiş - Kaldırmak için tıklayın' : 'İzin yok - Vermek için tıklayın' }}">
                                                
                                                @if($hasPermission)
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @elseif($isInherited)
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                                    </svg>
                                                @elseif($isDependency)
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-3 h-3 text-admin-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- List View -->
    <div id="listView" class="view-panel space-y-6 hidden">
        @foreach($roles ?? [] as $role)
            <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
                <div class="p-6 border-b border-admin-200 dark:border-admin-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-admin-900 dark:text-white">{{ $role->display_name ?? $role->name }}</h3>
                                <div class="flex items-center space-x-3 text-sm text-admin-600 dark:text-admin-400">
                                    <span>{{ __('admin.permissions.index.level') }} {{ $role->hierarchy_level ?? 0 }}</span>
                                    <span>•</span>
                                    <span>{{ isset($role->permissions) ? $role->permissions->count() : 0 }} {{ __('admin.permissions.index.permission_count') }}</span>
                                    @if($role->description ?? false)
                                        <span>•</span>
                                        <span>{{ Str::limit($role->description, 50) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('admin.permissions.role-permissions', $role) }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-xl hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            {{ __('admin.permissions.index.edit') }}
                        </a>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($permissionsByCategory ?? [] as $category => $permissions)
                            @php
                                $categoryPermissions = isset($role->permissions) ? $role->permissions->intersect($permissions) : collect();
                            @endphp
                            @if($categoryPermissions->count() > 0)
                                <div class="border border-admin-200 dark:border-admin-600 rounded-xl p-4">
                                    <h4 class="font-medium text-admin-900 dark:text-white mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ ucfirst($category) }}
                                        <span class="ml-auto text-xs text-admin-500">{{ $categoryPermissions->count() }}/{{ count($permissions) }}</span>
                                    </h4>
                                    <div class="space-y-2">
                                        @foreach($categoryPermissions as $permission)
                                            <div class="flex items-center text-sm">
                                                <svg class="w-3 h-3 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span class="text-admin-700 dark:text-admin-300">{{ $permission->display_name ?? $permission->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Change Preview -->
    <div id="changePreview" class="fixed bottom-6 right-6 bg-white dark:bg-admin-800 rounded-2xl shadow-2xl border border-admin-200 dark:border-admin-700 p-6 max-w-md hidden">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-admin-900 dark:text-white">{{ __('admin.permissions.index.pending_changes') }}</h3>
            <button id="clearChangesBtn" class="text-admin-400 hover:text-admin-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div id="changesList" class="space-y-3 max-h-64 overflow-y-auto">
            <!-- Changes will be populated dynamically -->
        </div>
        
        <div class="flex items-center space-x-3 mt-6">
            <button id="cancelChangesBtn" class="flex-1 px-4 py-2 border border-admin-300 dark:border-admin-600 text-admin-700 dark:text-admin-300 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700/50">
                {{ __('admin.permissions.index.cancel') }}
            </button>
            <button id="saveChangesBtn" class="flex-1 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl">
                {{ __('admin.permissions.index.save') }} (<span id="changesCount">0</span>)
            </button>
        </div>
    </div>
</div>

<!-- Bulk Assignment Modal -->
<div id="bulkModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-2xl max-w-2xl w-full m-4 max-h-[90vh] overflow-hidden">
        <div class="p-6 border-b border-admin-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-semibold text-admin-900 dark:text-white">{{ __('admin.permissions.index.bulk_permission_assignment') }}</h3>
                <button id="closeBulkModal" class="text-admin-400 hover:text-admin-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="p-6 overflow-y-auto max-h-96">
            <div class="space-y-6">
                <!-- Template Selection -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.permissions.index.select_template') }}</label>
                    <select id="bulkTemplate" class="admin-input w-full">
                        <option value="">{{ __('admin.permissions.index.custom_assignment') }}</option>
                        <option value="admin">{{ __('admin.permissions.index.template_admin') }}</option>
                        <option value="manager">{{ __('admin.permissions.index.template_manager') }}</option>
                        <option value="sales">{{ __('admin.permissions.index.template_sales') }}</option>
                        <option value="support">{{ __('admin.permissions.index.template_support') }}</option>
                    </select>
                </div>
                
                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.permissions.index.target_roles') }}</label>
                    <div class="space-y-2 max-h-32 overflow-y-auto border border-admin-200 dark:border-admin-600 rounded-lg p-3">
                        @foreach($roles ?? [] as $role)
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       class="bulk-role-checkbox rounded border-admin-300 dark:border-admin-600"
                                       value="{{ $role->id }}">
                                <span class="ml-2 text-sm text-admin-700 dark:text-admin-300">{{ $role->display_name ?? $role->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Permission Selection -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.permissions.index.permissions') }}</label>
                    <div class="space-y-3 max-h-48 overflow-y-auto border border-admin-200 dark:border-admin-600 rounded-lg p-3">
                        @foreach($permissionsByCategory ?? [] as $category => $permissions)
                            <div>
                                <label class="flex items-center font-medium text-admin-900 dark:text-white">
                                    <input type="checkbox" 
                                           class="category-checkbox rounded border-admin-300 dark:border-admin-600"
                                           data-category="{{ $category }}">
                                    <span class="ml-2">{{ ucfirst($category) }}</span>
                                </label>
                                <div class="ml-6 mt-2 space-y-1">
                                    @foreach($permissions as $permission)
                                        <label class="flex items-center">
                                            <input type="checkbox" 
                                                   class="bulk-permission-checkbox rounded border-admin-300 dark:border-admin-600"
                                                   value="{{ $permission->id }}"
                                                   data-category="{{ $category }}">
                                            <span class="ml-2 text-sm text-admin-600 dark:text-admin-400">{{ $permission->display_name ?? $permission->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6 border-t border-admin-200 dark:border-admin-700">
            <div class="flex items-center justify-end space-x-3">
                <button id="cancelBulkAssignment" class="px-6 py-2 border border-admin-300 dark:border-admin-600 text-admin-700 dark:text-admin-300 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700/50">
                    {{ __('admin.permissions.index.cancel') }}
                </button>
                <button id="applyBulkAssignment" class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl">
                    {{ __('admin.permissions.index.apply') }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
class PermissionsManager {
    constructor() {
        this.viewMode = 'matrix';
        this.filters = { role: '', category: '', status: '' };
        this.expandedCategories = @json(isset($permissionsByCategory) ? array_keys(is_array($permissionsByCategory) ? $permissionsByCategory : $permissionsByCategory->toArray()) : []);
        this.permissions = @json(isset($rolePermissions) ? (is_array($rolePermissions) ? $rolePermissions : $rolePermissions->toArray()) : []);
        this.changes = [];
        this.roles = @json(isset($roles) ? $roles->pluck('display_name', 'id')->toArray() : []);
        this.allPermissions = @json(isset($allPermissions) ? $allPermissions->pluck('display_name', 'id')->toArray() : []);
        
        this.initializeEventListeners();
        this.updateChangesDisplay();
    }
    
    initializeEventListeners() {
        // View mode toggle
        document.querySelectorAll('.view-mode-btn').forEach(btn => {
            btn.addEventListener('click', () => this.switchView(btn.dataset.view));
        });
        
        // Filter dropdown
        document.getElementById('filterToggle').addEventListener('click', () => this.toggleFilterPanel());
        document.getElementById('roleFilter').addEventListener('change', () => this.applyFilters());
        document.getElementById('categoryFilter').addEventListener('change', () => this.applyFilters());
        document.getElementById('statusFilter').addEventListener('change', () => this.applyFilters());
        document.getElementById('resetFiltersBtn').addEventListener('click', () => this.resetFilters());
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!document.getElementById('filterDropdown').contains(e.target)) {
                document.getElementById('filterPanel').classList.add('hidden');
            }
        });
        
        // Permission toggles
        document.querySelectorAll('.permission-toggle').forEach(btn => {
            btn.addEventListener('click', () => {
                const roleId = parseInt(btn.dataset.roleId);
                const permissionId = parseInt(btn.dataset.permissionId);
                this.togglePermission(roleId, permissionId);
            });
        });
        
        // Quick action buttons
        document.getElementById('createRoleBtn').addEventListener('click', () => this.createRoleTemplate());
        document.getElementById('importPermissionsBtn').addEventListener('click', () => this.importPermissions());
        document.getElementById('exportPermissionsBtn').addEventListener('click', () => this.exportPermissions());
        document.getElementById('syncPermissionsBtn').addEventListener('click', () => this.syncPermissions());
        document.getElementById('auditLogBtn').addEventListener('click', () => this.showAuditLog());
        
        // Bulk assignment
        document.getElementById('bulkAssignBtn').addEventListener('click', () => this.showBulkModal());
        document.getElementById('closeBulkModal').addEventListener('click', () => this.closeBulkModal());
        document.getElementById('cancelBulkAssignment').addEventListener('click', () => this.closeBulkModal());
        document.getElementById('applyBulkAssignment').addEventListener('click', () => this.applyBulkAssignment());
        document.getElementById('bulkTemplate').addEventListener('change', () => this.loadTemplate());
        
        // Category checkboxes for bulk assignment
        document.querySelectorAll('.category-checkbox').forEach(cb => {
            cb.addEventListener('change', (e) => this.toggleCategoryPermissions(e.target.dataset.category));
        });
        
        // Changes management
        document.getElementById('clearChangesBtn').addEventListener('click', () => this.clearChanges());
        document.getElementById('cancelChangesBtn').addEventListener('click', () => this.clearChanges());
        document.getElementById('saveChangesBtn').addEventListener('click', () => this.saveChanges());
    }
    
    switchView(mode) {
        this.viewMode = mode;
        
        // Update button states
        document.querySelectorAll('.view-mode-btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.view === mode);
            if (btn.dataset.view === mode) {
                btn.classList.add('bg-white', 'dark:bg-admin-600', 'shadow-sm');
            } else {
                btn.classList.remove('bg-white', 'dark:bg-admin-600', 'shadow-sm');
            }
        });
        
        // Show/hide view panels
        document.querySelectorAll('.view-panel').forEach(panel => {
            if (panel.id === `${mode}View`) {
                panel.classList.remove('hidden');
            } else {
                panel.classList.add('hidden');
            }
        });
    }
    
    toggleFilterPanel() {
        const panel = document.getElementById('filterPanel');
        panel.classList.toggle('hidden');
    }
    
    applyFilters() {
        const roleFilter = document.getElementById('roleFilter').value;
        const categoryFilter = document.getElementById('categoryFilter').value;
        const statusFilter = document.getElementById('statusFilter').value;
        
        this.filters = { role: roleFilter, category: categoryFilter, status: statusFilter };
        
        // Apply filters to permission rows
        document.querySelectorAll('.permission-row').forEach(row => {
            let show = true;
            
            if (categoryFilter && !row.dataset.category.includes(categoryFilter)) {
                show = false;
            }
            
            // Add more filter logic as needed
            
            row.style.display = show ? '' : 'none';
        });
    }
    
    resetFilters() {
        document.getElementById('roleFilter').value = '';
        document.getElementById('categoryFilter').value = '';
        document.getElementById('statusFilter').value = '';
        
        this.filters = { role: '', category: '', status: '' };
        this.applyFilters();
    }
    
    toggleCategory(category) {
        const index = this.expandedCategories.indexOf(category);
        const categoryRows = document.querySelectorAll(`.category-${category}`);
        const categoryIcon = document.querySelector(`[data-category="${category}"] .category-icon`);
        
        if (index > -1) {
            this.expandedCategories.splice(index, 1);
            categoryRows.forEach(row => row.style.display = 'none');
            if (categoryIcon) categoryIcon.style.transform = 'rotate(-90deg)';
        } else {
            this.expandedCategories.push(category);
            categoryRows.forEach(row => row.style.display = '');
            if (categoryIcon) categoryIcon.style.transform = 'rotate(0deg)';
        }
    }
    
    togglePermission(roleId, permissionId) {
        if (!this.permissions[roleId]) {
            this.permissions[roleId] = [];
        }
        
        const index = this.permissions[roleId].indexOf(permissionId);
        let action;
        
        if (index > -1) {
            this.permissions[roleId].splice(index, 1);
            action = 'revoke';
        } else {
            this.permissions[roleId].push(permissionId);
            action = 'grant';
        }
        
        // Update UI
        const button = document.querySelector(`[data-role-id="${roleId}"][data-permission-id="${permissionId}"]`);
        if (button) {
            if (action === 'grant') {
                button.className = button.className.replace(/bg-red-\d+/, 'bg-green-500');
                button.className = button.className.replace(/hover:bg-red-\d+/, 'hover:bg-green-600');
                button.innerHTML = `<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
            } else {
                button.className = button.className.replace(/bg-green-\d+/, 'bg-red-200 dark:bg-red-800');
                button.className = button.className.replace(/hover:bg-green-\d+/, 'hover:bg-red-300 dark:hover:bg-red-700');
                button.innerHTML = `<svg class="w-3 h-3 text-admin-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`;
            }
        }
        
        // Add to changes
        const change = {
            id: `${roleId}-${permissionId}`,
            roleId: roleId,
            permissionId: permissionId,
            action: action,
            role: this.roles[roleId] || 'Unknown Role',
            permission: this.allPermissions[permissionId] || 'Unknown Permission'
        };
        
        // Remove existing change for this role-permission pair
        this.changes = this.changes.filter(c => c.id !== change.id);
        
        // Add new change
        this.changes.push(change);
        
        this.updateChangesDisplay();
    }
    
    updateChangesDisplay() {
        const preview = document.getElementById('changePreview');
        const changesList = document.getElementById('changesList');
        const changesCount = document.getElementById('changesCount');
        
        if (this.changes.length > 0) {
            preview.classList.remove('hidden');
            changesCount.textContent = this.changes.length;
            
            changesList.innerHTML = this.changes.map(change => `
                <div class="flex items-center justify-between p-3 bg-admin-50 dark:bg-admin-700/50 rounded-lg">
                    <div class="text-sm">
                        <p class="font-medium text-admin-900 dark:text-white">${change.role}</p>
                        <p class="text-admin-600 dark:text-admin-400">${change.permission}</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium rounded-lg ${change.action === 'grant' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300'}">
                        ${change.action === 'grant' ? '{{ __("admin.permissions.index.js.grant") }}' : '{{ __("admin.permissions.index.js.revoke") }}'}
                    </span>
                </div>
            `).join('');
        } else {
            preview.classList.add('hidden');
        }
    }
    
    clearChanges() {
        this.changes = [];
        
        // Reset permissions to original state
        this.permissions = @json(isset($rolePermissions) ? (is_array($rolePermissions) ? $rolePermissions : $rolePermissions->toArray()) : []);
        
        // Reset UI
        window.location.reload(); // Simple approach to reset UI state
    }
    
    saveChanges() {
        if (this.changes.length === 0) return;
        
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: '{{ __("admin.permissions.index.js.save_changes_title") }}',
                text: `${this.changes.length} {{ __("admin.permissions.index.js.changes_will_be_saved") }}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '{{ __("admin.permissions.index.js.yes_save") }}',
                cancelButtonText: '{{ __("admin.permissions.index.js.cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.performSaveChanges();
                }
            });
        } else {
            if (confirm(`${this.changes.length} {{ __("admin.permissions.index.js.changes_will_be_saved") }}`)) {
                this.performSaveChanges();
            }
        }
    }
    
    performSaveChanges() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        fetch('{{ route("admin.permissions.bulk-update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken || ''
            },
            body: JSON.stringify({
                changes: this.changes
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.changes = [];
                this.updateChangesDisplay();
                
                if (typeof Swal !== 'undefined') {
                    Swal.fire('{{ __("admin.permissions.index.js.success") }}', '{{ __("admin.permissions.index.js.changes_saved") }}', 'success');
                } else {
                    alert('{{ __("admin.permissions.index.js.changes_saved") }}');
                }
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire('{{ __("admin.permissions.index.js.error") }}', data.message || '{{ __("admin.permissions.index.js.an_error_occurred") }}', 'error');
                } else {
                    alert('{{ __("admin.permissions.index.js.error") }}: ' + (data.message || '{{ __("admin.permissions.index.js.an_error_occurred") }}'));
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof Swal !== 'undefined') {
                Swal.fire('{{ __("admin.permissions.index.js.error") }}', '{{ __("admin.permissions.index.js.an_error_occurred") }}', 'error');
            } else {
                alert('{{ __("admin.permissions.index.js.an_error_occurred") }}');
            }
        });
    }
    
    showBulkModal() {
        const modal = document.getElementById('bulkModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Reset form
        document.getElementById('bulkTemplate').value = '';
        document.querySelectorAll('.bulk-role-checkbox').forEach(cb => cb.checked = false);
        document.querySelectorAll('.bulk-permission-checkbox').forEach(cb => cb.checked = false);
        document.querySelectorAll('.category-checkbox').forEach(cb => cb.checked = false);
    }
    
    closeBulkModal() {
        const modal = document.getElementById('bulkModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    
    loadTemplate() {
        const template = document.getElementById('bulkTemplate').value;
        if (!template) return;
        
        // Define template permissions (this should ideally come from the server)
        const templates = {
            admin: @json(isset($allPermissions) ? $allPermissions->pluck('id')->toArray() : []),
            manager: [],
            sales: [],
            support: []
        };
        
        // Load selected template
        const permissionIds = templates[template] || [];
        
        document.querySelectorAll('.bulk-permission-checkbox').forEach(cb => {
            cb.checked = permissionIds.includes(parseInt(cb.value));
        });
        
        // Update category checkboxes
        this.updateCategoryCheckboxes();
    }
    
    toggleCategoryPermissions(category) {
        const categoryCheckbox = document.querySelector(`[data-category="${category}"]`);
        const permissionCheckboxes = document.querySelectorAll(`[data-category="${category}"].bulk-permission-checkbox`);
        
        const allSelected = Array.from(permissionCheckboxes).every(cb => cb.checked);
        
        permissionCheckboxes.forEach(cb => {
            cb.checked = !allSelected;
        });
        
        categoryCheckbox.checked = !allSelected;
    }
    
    updateCategoryCheckboxes() {
        document.querySelectorAll('.category-checkbox').forEach(categoryCheckbox => {
            const category = categoryCheckbox.dataset.category;
            const permissionCheckboxes = document.querySelectorAll(`[data-category="${category}"].bulk-permission-checkbox`);
            const checkedCount = Array.from(permissionCheckboxes).filter(cb => cb.checked).length;
            
            categoryCheckbox.checked = checkedCount === permissionCheckboxes.length;
            categoryCheckbox.indeterminate = checkedCount > 0 && checkedCount < permissionCheckboxes.length;
        });
    }
    
    applyBulkAssignment() {
        const selectedRoles = Array.from(document.querySelectorAll('.bulk-role-checkbox:checked')).map(cb => parseInt(cb.value));
        const selectedPermissions = Array.from(document.querySelectorAll('.bulk-permission-checkbox:checked')).map(cb => parseInt(cb.value));
        
        if (selectedRoles.length === 0 || selectedPermissions.length === 0) {
            if (typeof Swal !== 'undefined') {
                Swal.fire('{{ __("admin.permissions.index.js.warning") }}', '{{ __("admin.permissions.index.js.select_role_permission") }}', 'warning');
            } else {
                alert('{{ __("admin.permissions.index.js.select_role_permission") }}');
            }
            return;
        }
        
        // Apply bulk changes
        selectedRoles.forEach(roleId => {
            selectedPermissions.forEach(permissionId => {
                if (!this.permissions[roleId]) {
                    this.permissions[roleId] = [];
                }
                
                if (!this.permissions[roleId].includes(permissionId)) {
                    this.permissions[roleId].push(permissionId);
                    
                    const change = {
                        id: `${roleId}-${permissionId}`,
                        roleId: roleId,
                        permissionId: permissionId,
                        action: 'grant',
                        role: this.roles[roleId] || 'Unknown Role',
                        permission: this.allPermissions[permissionId] || 'Unknown Permission'
                    };
                    
                    // Remove existing change
                    this.changes = this.changes.filter(c => c.id !== change.id);
                    this.changes.push(change);
                }
            });
        });
        
        this.closeBulkModal();
        this.updateChangesDisplay();
        
        if (typeof Swal !== 'undefined') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            
            Toast.fire({
                icon: 'success',
                title: `${selectedRoles.length} {{ __("admin.permissions.index.js.roles_for") }} ${selectedPermissions.length} {{ __("admin.permissions.index.js.permissions_added") }}`
            });
        } else {
            alert(`${selectedRoles.length} {{ __("admin.permissions.index.js.roles_for") }} ${selectedPermissions.length} {{ __("admin.permissions.index.js.permissions_added") }}`);
        }
    }
    
    createRoleTemplate() {
        window.location.href = '{{ route("admin.roles.create") }}';
    }
    
    importPermissions() {
        if (typeof Swal !== 'undefined') {
            Swal.fire('{{ __("admin.permissions.index.js.info") }}', '{{ __("admin.permissions.index.js.import_feature_coming_soon") }}', 'info');
        } else {
            alert('{{ __("admin.permissions.index.js.import_feature_coming_soon") }}');
        }
    }
    
    exportPermissions() {
        window.open('{{ route("admin.permissions.export") }}', '_blank');
    }
    
    syncPermissions() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: '{{ __("admin.permissions.index.js.sync_permissions_title") }}',
                text: '{{ __("admin.permissions.index.js.sync_permissions_text") }}',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: '{{ __("admin.permissions.index.js.synchronize") }}',
                cancelButtonText: '{{ __("admin.permissions.index.js.cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.performSyncPermissions();
                }
            });
        } else {
            if (confirm('{{ __("admin.permissions.index.js.sync_permissions_confirm") }}')) {
                this.performSyncPermissions();
            }
        }
    }
    
    performSyncPermissions() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        fetch('{{ route("admin.permissions.sync") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire('{{ __("admin.permissions.index.js.success") }}', '{{ __("admin.permissions.index.js.permissions_synchronized") }}', 'success').then(() => {
                        window.location.reload();
                    });
                } else {
                    alert('{{ __("admin.permissions.index.js.permissions_synchronized") }}');
                    window.location.reload();
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof Swal !== 'undefined') {
                Swal.fire('{{ __("admin.permissions.index.js.error") }}', '{{ __("admin.permissions.index.js.sync_error") }}', 'error');
            } else {
                alert('{{ __("admin.permissions.index.js.sync_error") }}');
            }
        });
    }
    
    showAuditLog() {
        window.location.href = '{{ route("admin.permissions.audit-log") }}';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    window.permissionsManager = new PermissionsManager();
});
</script>
@endpush