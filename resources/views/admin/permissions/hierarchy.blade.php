@extends('layouts.admin')

@section('content')
<div class="space-y-6" id="hierarchyContainer">
    
    <!-- Page Header -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.permissions.index') }}" 
                   class="p-2 rounded-lg bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 transition-colors">
                    <svg class="w-5 h-5 text-admin-600 dark:text-admin-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-admin-900 dark:text-white">{{ __('admin.permissions.hierarchy.title') }}</h1>
                        <p class="text-admin-600 dark:text-admin-400">{{ __('admin.permissions.hierarchy.description') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <div class="flex items-center bg-admin-100 dark:bg-admin-700 rounded-xl p-1" id="viewModeContainer">
                    <button data-view="tree" class="view-mode-btn px-3 py-2 text-sm font-medium text-admin-700 dark:text-admin-300 rounded-lg transition-all active">
                        <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                        {{ __('admin.permissions.hierarchy.tree') }}
                    </button>
                    <button data-view="org" class="view-mode-btn px-3 py-2 text-sm font-medium text-admin-700 dark:text-admin-300 rounded-lg transition-all">
                        <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        {{ __('admin.permissions.hierarchy.organization') }}
                    </button>
                    <button data-view="matrix" class="view-mode-btn px-3 py-2 text-sm font-medium text-admin-700 dark:text-admin-300 rounded-lg transition-all">
                        <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        {{ __('admin.permissions.hierarchy.matrix') }}
                    </button>
                </div>
                
                <button id="exportBtn" class="inline-flex items-center px-4 py-2 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 text-admin-700 dark:text-admin-300 rounded-xl transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    {{ __('admin.permissions.hierarchy.export') }}
                </button>
                
                <button id="restructureBtn" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl shadow-lg hover:shadow-blue-500/25 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    {{ __('admin.permissions.hierarchy.restructure') }}
                </button>
            </div>
        </div>
    </div>

    <!-- Hierarchy Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl p-6 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">{{ __('admin.permissions.hierarchy.total_levels') }}</p>
                    <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $totalLevels ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-2xl p-6 border border-green-200 dark:border-green-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-600 dark:text-green-400 font-medium">{{ __('admin.permissions.hierarchy.active_roles') }}</p>
                    <p class="text-2xl font-bold text-green-700 dark:text-green-300">{{ $activeRoles ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-2xl p-6 border border-purple-200 dark:border-purple-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-purple-600 dark:text-purple-400 font-medium">{{ __('admin.permissions.hierarchy.departments') }}</p>
                    <p class="text-2xl font-bold text-purple-700 dark:text-purple-300">{{ $totalDepartments ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 rounded-2xl p-6 border border-amber-200 dark:border-amber-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-amber-600 dark:text-amber-400 font-medium">{{ __('admin.permissions.hierarchy.users') }}</p>
                    <p class="text-2xl font-bold text-amber-700 dark:text-amber-300">{{ $totalUsers ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-2xl p-6 border border-red-200 dark:border-red-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-red-600 dark:text-red-400 font-medium">{{ __('admin.permissions.hierarchy.conflicts') }}</p>
                    <p class="text-2xl font-bold text-red-700 dark:text-red-300">{{ $hierarchyConflicts ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tree View -->
    <div id="treeView" class="view-panel bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
        <div class="p-6 border-b border-admin-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-admin-900 dark:text-white">{{ __('admin.permissions.hierarchy.hierarchy_tree') }}</h2>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                        <span>{{ __('admin.permissions.hierarchy.active') }}</span>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                        <span>{{ __('admin.permissions.hierarchy.inactive') }}</span>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-amber-500 rounded-full"></div>
                        <span>{{ __('admin.permissions.hierarchy.pending') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Interactive Tree -->
            <div class="hierarchy-tree" id="hierarchyTree">
                @foreach($hierarchyTree ?? [] as $level => $roles)
                    <div class="hierarchy-level mb-8" data-level="{{ $level }}">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-3 py-1 rounded-lg">
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">{{ __('admin.permissions.hierarchy.level') }} {{ $level }}</span>
                            </div>
                            <div class="flex-1 h-px bg-admin-200 dark:bg-admin-600 ml-4"></div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach($roles as $role)
                                <div class="role-node relative bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4 transition-all duration-200 hover:shadow-lg cursor-pointer"
                                     data-role-id="{{ $role->id }}">
                                    
                                    <!-- Role Header -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-right">
                                            <span class="px-2 py-1 bg-blue-200 dark:bg-blue-700 text-blue-800 dark:text-blue-200 text-xs font-medium rounded-lg">
                                                L{{ $role->hierarchy_level ?? 0 }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Role Info -->
                                    <div>
                                        <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-1">
                                            {{ $role->display_name ?? $role->name }}
                                        </h3>
                                        <p class="text-sm text-blue-700 dark:text-blue-300 mb-2">
                                            {{ $role->users_count ?? 0 }} {{ __('admin.permissions.hierarchy.user_count') }} • {{ isset($role->permissions) ? $role->permissions->count() : 0 }} {{ __('admin.permissions.hierarchy.permission_count') }}
                                        </p>
                                        @if($role->description ?? false)
                                            <p class="text-xs text-blue-600 dark:text-blue-400 line-clamp-2">
                                                {{ $role->description }}
                                            </p>
                                        @endif
                                    </div>
                                    
                                    <!-- Role Status -->
                                    <div class="absolute top-2 right-2">
                                        <div class="w-3 h-3 {{ ($role->is_active ?? true) ? 'bg-green-500' : 'bg-red-500' }} rounded-full"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if(!$loop->last)
                            <div class="flex justify-center mt-6">
                                <svg class="w-6 h-6 text-admin-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Organization Chart View -->
    <div id="orgView" class="view-panel bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 hidden">
        <div class="p-6 border-b border-admin-200 dark:border-admin-700">
            <h2 class="text-lg font-semibold text-admin-900 dark:text-white">{{ __('admin.permissions.hierarchy.organization_chart') }}</h2>
        </div>
        
        <div class="p-6">
            <!-- Department-based Organization -->
            <div class="space-y-8">
                @foreach($departmentHierarchy ?? [] as $department => $structure)
                    <div class="department-section">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-admin-900 dark:text-white">{{ ucfirst($department) }}</h3>
                                <p class="text-admin-600 dark:text-admin-400">{{ $structure['total_users'] ?? 0 }} {{ __('admin.permissions.hierarchy.user_count') }}, {{ $structure['total_roles'] ?? 0 }} {{ __('admin.permissions.hierarchy.role_count') }}</p>
                            </div>
                        </div>
                        
                        <!-- Department Hierarchy -->
                        <div class="ml-8 space-y-6">
                            @foreach($structure['levels'] ?? [] as $level => $roles)
                                <div class="level-section">
                                    <div class="flex items-center mb-4">
                                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                        <div class="w-8 h-0.5 bg-admin-300 dark:bg-admin-600"></div>
                                        <span class="px-3 py-1 bg-admin-100 dark:bg-admin-700 text-admin-700 dark:text-admin-300 text-sm font-medium rounded-lg">
                                            {{ __('admin.permissions.hierarchy.level') }} {{ $level }}
                                        </span>
                                    </div>
                                    
                                    <div class="ml-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($roles as $role)
                                            <div class="flex items-center space-x-3 p-4 bg-admin-50 dark:bg-admin-700/50 rounded-xl border border-admin-200 dark:border-admin-600">
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <h4 class="font-medium text-admin-900 dark:text-white">{{ $role->display_name ?? $role->name }}</h4>
                                                    <p class="text-sm text-admin-600 dark:text-admin-400">{{ $role->users_count ?? 0 }} {{ __('admin.permissions.hierarchy.user_count') }}</p>
                                                </div>
                                                <a href="{{ route('admin.permissions.role-permissions', $role) }}"
                                                   class="p-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Matrix View -->
    <div id="matrixView" class="view-panel bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 hidden">
        <div class="p-6 border-b border-admin-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-admin-900 dark:text-white">{{ __('admin.permissions.hierarchy.hierarchy_matrix') }}</h2>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                        <span>{{ __('admin.permissions.hierarchy.parent_role') }}</span>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                        <span>{{ __('admin.permissions.hierarchy.child_role') }}</span>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-gray-300 rounded-full"></div>
                        <span>{{ __('admin.permissions.hierarchy.independent') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-admin-50 dark:bg-admin-700/50">
                        <tr>
                            <th class="sticky left-0 bg-admin-50 dark:bg-admin-700/50 px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider border-r border-admin-200 dark:border-admin-600">
                                {{ __('admin.permissions.hierarchy.roles') }}
                            </th>
                            @foreach($allRoles ?? [] as $role)
                                <th class="px-3 py-3 text-center text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider border-r border-admin-200 dark:border-admin-600 min-w-16">
                                    <div class="transform -rotate-45 origin-center">
                                        <span class="block">{{ Str::limit($role->display_name ?? $role->name, 8) }}</span>
                                        <span class="block text-xs">L{{ $role->hierarchy_level ?? 0 }}</span>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-admin-800 divide-y divide-admin-200 dark:divide-admin-600">
                        @foreach($allRoles ?? [] as $rowRole)
                            <tr class="hover:bg-admin-50 dark:hover:bg-admin-700/20 transition-colors">
                                <td class="sticky left-0 bg-white dark:bg-admin-800 px-6 py-4 text-sm font-medium text-admin-900 dark:text-white border-r border-admin-200 dark:border-admin-600">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $rowRole->display_name ?? $rowRole->name }}</p>
                                            <p class="text-xs text-admin-500">{{ __('admin.permissions.hierarchy.level') }} {{ $rowRole->hierarchy_level ?? 0 }}</p>
                                        </div>
                                    </div>
                                </td>
                                @foreach($allRoles ?? [] as $colRole)
                                    <td class="px-3 py-4 text-center border-r border-admin-200 dark:border-admin-600">
                                        @php
                                            $relationship = 'none';
                                            if(method_exists($rowRole, 'getRelationshipWith')) {
                                                $relationship = $rowRole->getRelationshipWith($colRole);
                                            }
                                        @endphp
                                        
                                        <div class="w-8 h-8 rounded-full mx-auto flex items-center justify-center">
                                            @if($rowRole->id === $colRole->id)
                                                <div class="w-6 h-6 bg-admin-300 dark:bg-admin-600 rounded-full"></div>
                                            @elseif($relationship === 'parent')
                                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                                    </svg>
                                                </div>
                                            @elseif($relationship === 'child')
                                                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </div>
                                            @elseif($relationship === 'sibling')
                                                <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-4 h-4 bg-gray-300 dark:bg-gray-600 rounded-full"></div>
                                            @endif
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Role Detail Panel -->
    <div id="roleDetailPanel" class="fixed inset-y-0 right-0 w-96 bg-white dark:bg-admin-800 shadow-2xl border-l border-admin-200 dark:border-admin-700 z-50 transform translate-x-full transition-transform duration-300">
        <div class="h-full flex flex-col">
            <!-- Header -->
            <div class="p-6 border-b border-admin-200 dark:border-admin-700 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-admin-900 dark:text-white">{{ __('admin.permissions.hierarchy.role_details') }}</h3>
                    <button id="closeRolePanel" class="p-2 text-admin-400 hover:text-admin-600 dark:hover:text-admin-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6" id="roleDetailContent">
                <div class="text-center text-admin-500 dark:text-admin-400 mt-8">
                    <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <p>{{ __('admin.permissions.hierarchy.select_role') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Restructure Modal -->
    <div id="restructureModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-2xl max-w-4xl w-full m-4 max-h-[90vh] overflow-hidden">
            <div class="p-6 border-b border-admin-200 dark:border-admin-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-admin-900 dark:text-white">{{ __('admin.permissions.hierarchy.restructure_hierarchy') }}</h3>
                    <button id="closeRestructureModal" class="text-admin-400 hover:text-admin-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-200px)]">
                <div class="space-y-6">
                    <!-- Restructure Options -->
                    <div>
                        <h4 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">{{ __('admin.permissions.hierarchy.configuration_options') }}</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="restructure-option p-4 border border-admin-200 dark:border-admin-600 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700/20 cursor-pointer transition-colors" data-type="department">
                                <div class="flex items-center space-x-3">
                                    <input type="radio" name="restructureType" value="department" class="text-blue-600">
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="font-medium text-admin-900 dark:text-white">{{ __('admin.permissions.hierarchy.department_based') }}</h5>
                                        <p class="text-sm text-admin-600 dark:text-admin-400">{{ __('admin.permissions.hierarchy.organize_by_departments') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="restructure-option p-4 border border-admin-200 dark:border-admin-600 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700/20 cursor-pointer transition-colors" data-type="function">
                                <div class="flex items-center space-x-3">
                                    <input type="radio" name="restructureType" value="function" class="text-green-600">
                                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="font-medium text-admin-900 dark:text-white">{{ __('admin.permissions.hierarchy.function_based') }}</h5>
                                        <p class="text-sm text-admin-600 dark:text-admin-400">{{ __('admin.permissions.hierarchy.organize_by_functions') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="restructure-option p-4 border border-admin-200 dark:border-admin-600 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700/20 cursor-pointer transition-colors" data-type="permission">
                                <div class="flex items-center space-x-3">
                                    <input type="radio" name="restructureType" value="permission" class="text-purple-600">
                                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 01-2 2m2-2h3m-3 0h-3m-2-5a2 2 0 01-2 2H9a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2v2zM7 21h10a2 2 0 002-2v-2a2 2 0 00-2-2H7a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="font-medium text-admin-900 dark:text-white">{{ __('admin.permissions.hierarchy.permission_based') }}</h5>
                                        <p class="text-sm text-admin-600 dark:text-admin-400">{{ __('admin.permissions.hierarchy.organize_by_permissions') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="restructure-option p-4 border border-admin-200 dark:border-admin-600 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700/20 cursor-pointer transition-colors" data-type="custom">
                                <div class="flex items-center space-x-3">
                                    <input type="radio" name="restructureType" value="custom" class="text-amber-600">
                                    <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="font-medium text-admin-900 dark:text-white">{{ __('admin.permissions.hierarchy.custom_configuration') }}</h5>
                                        <p class="text-sm text-admin-600 dark:text-admin-400">{{ __('admin.permissions.hierarchy.manual_hierarchy_editing') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Preview -->
                    <div id="restructurePreview" class="hidden">
                        <h4 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">{{ __('admin.permissions.hierarchy.change_preview') }}</h4>
                        <div class="p-4 bg-admin-50 dark:bg-admin-700/50 rounded-xl border border-admin-200 dark:border-admin-600">
                            <p class="text-admin-700 dark:text-admin-300">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ __('admin.permissions.hierarchy.preview_description') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-6 border-t border-admin-200 dark:border-admin-700">
                <div class="flex items-center justify-end space-x-3">
                    <button id="cancelRestructure" class="px-6 py-2 border border-admin-300 dark:border-admin-600 text-admin-700 dark:text-admin-300 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700/50">
                        {{ __('admin.permissions.hierarchy.cancel') }}
                    </button>
                    <button id="applyRestructure" disabled class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ __('admin.permissions.hierarchy.apply') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
class HierarchyManager {
    constructor() {
        this.currentViewMode = 'tree';
        this.selectedRole = null;
        this.selectedRoleData = null;
        this.restructureType = '';
        
        this.initializeEventListeners();
        this.initializeD3Tree();
    }
    
    initializeEventListeners() {
        // View mode buttons
        document.querySelectorAll('.view-mode-btn').forEach(btn => {
            btn.addEventListener('click', () => this.switchView(btn.dataset.view));
        });
        
        // Role nodes
        document.querySelectorAll('.role-node').forEach(node => {
            node.addEventListener('click', () => this.selectRole(node.dataset.roleId));
        });
        
        // Export button
        document.getElementById('exportBtn').addEventListener('click', () => this.exportHierarchy());
        
        // Restructure button
        document.getElementById('restructureBtn').addEventListener('click', () => this.showRestructureModal());
        
        // Modal controls
        document.getElementById('closeRolePanel').addEventListener('click', () => this.closeRolePanel());
        document.getElementById('closeRestructureModal').addEventListener('click', () => this.closeRestructureModal());
        document.getElementById('cancelRestructure').addEventListener('click', () => this.closeRestructureModal());
        document.getElementById('applyRestructure').addEventListener('click', () => this.applyRestructure());
        
        // Restructure options
        document.querySelectorAll('.restructure-option').forEach(option => {
            option.addEventListener('click', () => this.selectRestructureOption(option.dataset.type));
        });
        
        // Close modals on outside click
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('fixed') && e.target.classList.contains('inset-0')) {
                this.closeRestructureModal();
            }
        });
    }
    
    switchView(mode) {
        this.currentViewMode = mode;
        
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
                // Add fade in animation
                panel.style.opacity = '0';
                requestAnimationFrame(() => {
                    panel.style.transition = 'opacity 0.3s ease-in-out';
                    panel.style.opacity = '1';
                });
            } else {
                panel.classList.add('hidden');
            }
        });
    }
    
    selectRole(roleId) {
        this.selectedRole = roleId;
        
        // Show loading state
        const panel = document.getElementById('roleDetailPanel');
        const content = document.getElementById('roleDetailContent');
        
        content.innerHTML = `
            <div class="flex items-center justify-center py-8">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                <span class="ml-3 text-admin-600 dark:text-admin-400">{{ __('admin.permissions.hierarchy.loading') }}</span>
            </div>
        `;
        
        // Show panel
        panel.classList.remove('translate-x-full');
        
        // Fetch role data
        fetch(`/admin/dashboard/roles/${roleId}/data`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                this.selectedRoleData = data;
                this.renderRoleDetails();
            })
            .catch(error => {
                console.error('Error fetching role data:', error);
                content.innerHTML = `
                    <div class="text-center text-red-500 mt-8">
                        <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>{{ __('admin.permissions.hierarchy.role_data_failed') }}</p>
                    </div>
                `;
            });
    }
    
    renderRoleDetails() {
        const content = document.getElementById('roleDetailContent');
        const role = this.selectedRoleData;
        
        content.innerHTML = `
            <!-- Role Info -->
            <div class="bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4 mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-admin-900 dark:text-white">${role.display_name || role.name}</h4>
                        <p class="text-sm text-admin-600 dark:text-admin-400">
                            {{ __('admin.permissions.hierarchy.level') }} ${role.hierarchy_level || 0}
                        </p>
                    </div>
                </div>
                <p class="text-sm text-admin-700 dark:text-admin-300 mt-3">${role.description || '{{ __('admin.permissions.hierarchy.no_description') }}'}</p>
            </div>
            
            <!-- Statistics -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-200 dark:border-green-800">
                    <p class="text-2xl font-bold text-green-700 dark:text-green-300">${role.users_count || 0}</p>
                    <p class="text-sm text-green-600 dark:text-green-400">{{ __('admin.permissions.hierarchy.user') }}</p>
                </div>
                <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                    <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">${role.permissions_count || 0}</p>
                    <p class="text-sm text-blue-600 dark:text-blue-400">{{ __('admin.permissions.hierarchy.permission') }}</p>
                </div>
            </div>
            
            <!-- Hierarchy Relationships -->
            <div class="space-y-4">
                ${role.parent_roles && role.parent_roles.length > 0 ? `
                    <div>
                        <h5 class="font-medium text-admin-900 dark:text-white mb-2">{{ __('admin.permissions.hierarchy.parent_roles') }}</h5>
                        <div class="space-y-2">
                            ${role.parent_roles.map(parent => `
                                <div class="flex items-center space-x-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-green-900 dark:text-green-100">${parent.display_name}</p>
                                        <p class="text-sm text-green-700 dark:text-green-300">{{ __('admin.permissions.hierarchy.level') }} ${parent.hierarchy_level}</p>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                ` : ''}
                
                ${role.child_roles && role.child_roles.length > 0 ? `
                    <div>
                        <h5 class="font-medium text-admin-900 dark:text-white mb-2">{{ __('admin.permissions.hierarchy.child_roles') }}</h5>
                        <div class="space-y-2">
                            ${role.child_roles.map(child => `
                                <div class="flex items-center space-x-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-blue-900 dark:text-blue-100">${child.display_name}</p>
                                        <p class="text-sm text-blue-700 dark:text-blue-300">{{ __('admin.permissions.hierarchy.level') }} ${child.hierarchy_level}</p>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                ` : ''}
            </div>
            
            <!-- Actions -->
            <div class="space-y-3 pt-4 border-t border-admin-200 dark:border-admin-600">
                <button onclick="window.location.href='/admin/dashboard/permissions/role/${role.id}'" 
                        class="w-full flex items-center justify-center px-4 py-3 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-xl hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 01-2 2m2-2h3m-3 0h-3m-2-5a2 2 0 01-2 2H9a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2v2zM7 21h10a2 2 0 002-2v-2a2 2 0 00-2-2H7a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
                    </svg>
                    {{ __('admin.permissions.hierarchy.view_permissions') }}
                </button>
                
                <button onclick="window.location.href='/admin/dashboard/roles/${role.id}/edit'" 
                        class="w-full flex items-center justify-center px-4 py-3 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-xl hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('admin.permissions.hierarchy.edit_role') }}
                </button>
                
                <button onclick="window.location.href='{{ route('admin.managers.index') }}?role=${role.id}'" 
                        class="w-full flex items-center justify-center px-4 py-3 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-xl hover:bg-purple-200 dark:hover:bg-purple-900/50 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    {{ __('admin.permissions.hierarchy.manage_users') }}
                </button>
            </div>
        `;
    }
    
    closeRolePanel() {
        const panel = document.getElementById('roleDetailPanel');
        panel.classList.add('translate-x-full');
        this.selectedRole = null;
        this.selectedRoleData = null;
    }
    
    showRestructureModal() {
        const modal = document.getElementById('restructureModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        this.restructureType = '';
        
        // Reset form
        document.querySelectorAll('input[name="restructureType"]').forEach(input => {
            input.checked = false;
        });
        document.getElementById('restructurePreview').classList.add('hidden');
        document.getElementById('applyRestructure').disabled = true;
    }
    
    closeRestructureModal() {
        const modal = document.getElementById('restructureModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    
    selectRestructureOption(type) {
        this.restructureType = type;
        
        // Update radio button
        document.querySelector(`input[value="${type}"]`).checked = true;
        
        // Show preview
        document.getElementById('restructurePreview').classList.remove('hidden');
        document.getElementById('applyRestructure').disabled = false;
    }
    
    applyRestructure() {
        if (!this.restructureType) return;
        
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: '{{ __('admin.permissions.hierarchy.restructure_hierarchy') }}',
                text: '{{ __('admin.permissions.hierarchy.restructure_confirmation') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __('admin.permissions.hierarchy.yes_apply') }}',
                cancelButtonText: '{{ __('admin.permissions.hierarchy.cancel') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.performRestructure();
                }
            });
        } else {
            if (confirm('{{ __('admin.permissions.hierarchy.restructure_confirmation') }}')) {
                this.performRestructure();
            }
        }
    }
    
    performRestructure() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        fetch('{{ route("admin.permissions.restructure") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken || ''
            },
            body: JSON.stringify({
                type: this.restructureType
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.closeRestructureModal();
                if (typeof Swal !== 'undefined') {
                    Swal.fire('{{ __('admin.permissions.hierarchy.success') }}!', '{{ __('admin.permissions.hierarchy.hierarchy_restructured') }}.', 'success').then(() => {
                        window.location.reload();
                    });
                } else {
                    alert('{{ __('admin.permissions.hierarchy.hierarchy_restructured') }}.');
                    window.location.reload();
                }
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire('{{ __('admin.permissions.hierarchy.error') }}!', data.message || '{{ __('admin.permissions.hierarchy.an_error_occurred') }}.', 'error');
                } else {
                    alert('{{ __('admin.permissions.hierarchy.error') }}: ' + (data.message || '{{ __('admin.permissions.hierarchy.an_error_occurred') }}.'));
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (typeof Swal !== 'undefined') {
                Swal.fire('{{ __('admin.permissions.hierarchy.error') }}!', '{{ __('admin.permissions.hierarchy.an_error_occurred') }}.', 'error');
            } else {
                alert('{{ __('admin.permissions.hierarchy.an_error_occurred') }}.');
            }
        });
    }
    
    exportHierarchy() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: '{{ __('admin.permissions.hierarchy.export_hierarchy') }}',
                html: `
                    <select id="exportFormat" class="swal2-select">
                        <option value="json">JSON</option>
                        <option value="xlsx">Excel</option>
                        <option value="pdf">PDF</option>
                        <option value="png">PNG Görsel</option>
                    </select>
                `,
                showCancelButton: true,
                confirmButtonText: '{{ __('admin.permissions.hierarchy.export') }}',
                cancelButtonText: '{{ __('admin.permissions.hierarchy.cancel') }}',
                preConfirm: () => {
                    const format = document.getElementById('exportFormat')?.value || 'json';
                    return { format: format };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open(`{{ route('admin.permissions.hierarchy.export') }}?format=${result.value.format}`, '_blank');
                }
            });
        } else {
            const format = prompt('Export format (json, xlsx, pdf, png):', 'json');
            if (format) {
                window.open(`{{ route('admin.permissions.hierarchy.export') }}?format=${format}`, '_blank');
            }
        }
    }
    
    initializeD3Tree() {
        // Initialize D3.js tree visualization for complex hierarchy
        const hierarchyData = @json($d3HierarchyData ?? []);
        
        // D3 tree implementation would go here
        console.log('D3 Tree initialized with data:', hierarchyData);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    window.hierarchyManager = new HierarchyManager();
});
</script>
@endpush