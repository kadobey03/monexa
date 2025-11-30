@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="rolePermissionManager()">
    
    <!-- Role Header -->
    <div class="bg-gradient-to-r from-{{ $role->getColorClass() }}-500 via-{{ $role->getColorClass() }}-600 to-{{ $role->getColorClass() }}-700 rounded-2xl shadow-elegant p-8 text-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <a href="{{ route('admin.permissions.index') }}" 
                   class="p-2 rounded-lg bg-white/20 hover:bg-white/30 transition-colors">
                    <x-heroicon name="arrow-left" class="w-5 h-5" />
                </a>
                
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                    <x-heroicon name="shield-check" class="w-8 h-8 text-white/90" />
                </div>
                
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ $role->display_name }}</h1>
                    <div class="flex items-center space-x-4 text-white/80">
                        <span class="flex items-center">
                            <x-heroicon name="layers" class="w-4 h-4 mr-2" />
                            {{ __('admin.permissions.role_permissions.level') }} {{ $role->hierarchy_level }}
                        </span>
                        <span class="flex items-center">
                            <x-heroicon name="key" class="w-4 h-4 mr-2" />
                            {{ $role->permissions->count() }} {{ __('admin.permissions.role_permissions.permission_count') }}
                        </span>
                        @if($role->users_count > 0)
                            <span class="flex items-center">
                                <x-heroicon name="users" class="w-4 h-4 mr-2" />
                                {{ $role->users_count }} {{ __('admin.permissions.role_permissions.user_count') }}
                            </span>
                        @endif
                    </div>
                    @if($role->description)
                        <p class="text-white/70 text-lg mt-2">{{ $role->description }}</p>
                    @endif
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <button @click="showRoleSettings()" 
                        class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-xl transition-all duration-200">
                    <x-heroicon name="cog-6-tooth" class="w-4 h-4 mr-2" />
                    {{ __('admin.permissions.role_permissions.role_settings') }}
                </button>
                
                <button @click="cloneRole()" 
                        class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-xl transition-all duration-200">
                    <x-heroicon name="copy" class="w-4 h-4 mr-2" />
                    {{ __('admin.permissions.role_permissions.clone_role') }}
                </button>
                
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-xl transition-all duration-200">
                        <x-heroicon name="more-horizontal" class="w-4 h-4" />
                    </button>
                    
                    <div x-show="open" 
                         x-transition 
                         @click.away="open = false"
                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-admin-800 rounded-xl shadow-elegant border border-admin-200 dark:border-admin-700 py-1 z-10">
                        <a href="{{ route('admin.roles.edit', $role) }}" class="flex items-center px-4 py-2 text-sm text-admin-700 dark:text-admin-300 hover:bg-admin-50 dark:hover:bg-admin-700">
                            <x-heroicon name="edit-3" class="w-4 h-4 mr-3" />
                            {{ __('admin.permissions.role_permissions.edit_role') }}
                        </a>
                        <a href="#" @click="exportRolePermissions()" class="flex items-center px-4 py-2 text-sm text-admin-700 dark:text-admin-300 hover:bg-admin-50 dark:hover:bg-admin-700">
                            <x-heroicon name="arrow-down-tray" class="w-4 h-4 mr-3" />
                            {{ __('admin.permissions.role_permissions.download_permissions') }}
                        </a>
                        <hr class="my-1 border-admin-200 dark:border-admin-600">
                        <a href="#" @click="deleteRole()" class="flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                            <x-heroicon name="trash-2" class="w-4 h-4 mr-3" />
                            {{ __('admin.permissions.role_permissions.delete_role') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-admin-800 rounded-xl shadow-elegant p-4 border border-admin-200 dark:border-admin-700">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <x-heroicon name="check-circle" class="w-5 h-5 text-green-600 dark:text-green-400" />
                </div>
                <div>
                    <p class="text-sm text-admin-600 dark:text-admin-400">{{ __('admin.permissions.role_permissions.active_permissions') }}</p>
                    <p class="text-xl font-bold text-admin-900 dark:text-white">{{ $role->permissions->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-admin-800 rounded-xl shadow-elegant p-4 border border-admin-200 dark:border-admin-700">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <x-heroicon name="arrow-down" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                </div>
                <div>
                    <p class="text-sm text-admin-600 dark:text-admin-400">{{ __('admin.permissions.role_permissions.inherited_permissions') }}</p>
                    <p class="text-xl font-bold text-admin-900 dark:text-white">{{ $inheritedPermissionsCount }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-admin-800 rounded-xl shadow-elegant p-4 border border-admin-200 dark:border-admin-700">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                    <x-heroicon name="exclamation-triangle" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                </div>
                <div>
                    <p class="text-sm text-admin-600 dark:text-admin-400">{{ __('admin.permissions.role_permissions.conflicts') }}</p>
                    <p class="text-xl font-bold text-admin-900 dark:text-white">{{ $conflictsCount }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-admin-800 rounded-xl shadow-elegant p-4 border border-admin-200 dark:border-admin-700">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <x-heroicon name="percent" class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                </div>
                <div>
                    <p class="text-sm text-admin-600 dark:text-admin-400">{{ __('admin.permissions.role_permissions.coverage') }}</p>
                    <p class="text-xl font-bold text-admin-900 dark:text-white">{{ number_format($coveragePercentage, 1) }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
        <div class="border-b border-admin-200 dark:border-admin-700">
            <nav class="flex space-x-8 px-6">
                <button @click="activeTab = 'permissions'" 
                        :class="activeTab === 'permissions' ? 'border-blue-500 text-blue-600' : 'border-transparent text-admin-500 hover:text-admin-700 hover:border-admin-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <x-heroicon name="key" class="w-4 h-4 inline mr-2" />
                    {{ __('admin.permissions.role_permissions.permission_management') }}
                </button>
                <button @click="activeTab = 'inheritance'" 
                        :class="activeTab === 'inheritance' ? 'border-blue-500 text-blue-600' : 'border-transparent text-admin-500 hover:text-admin-700 hover:border-admin-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <x-heroicon name="git-branch" class="w-4 h-4 inline mr-2" />
                    {{ __('admin.permissions.role_permissions.inheritance_hierarchy') }}
                </button>
                <button @click="activeTab = 'dependencies'" 
                        :class="activeTab === 'dependencies' ? 'border-blue-500 text-blue-600' : 'border-transparent text-admin-500 hover:text-admin-700 hover:border-admin-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <x-heroicon name="link" class="w-4 h-4 inline mr-2" />
                    {{ __('admin.permissions.role_permissions.dependencies') }}
                </button>
                <button @click="activeTab = 'users'" 
                        :class="activeTab === 'users' ? 'border-blue-500 text-blue-600' : 'border-transparent text-admin-500 hover:text-admin-700 hover:border-admin-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <x-heroicon name="users" class="w-4 h-4 inline mr-2" />
                    {{ __('admin.permissions.role_permissions.users') }} ({{ $role->users_count }})
                </button>
                <button @click="activeTab = 'audit'" 
                        :class="activeTab === 'audit' ? 'border-blue-500 text-blue-600' : 'border-transparent text-admin-500 hover:text-admin-700 hover:border-admin-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    <x-heroicon name="history" class="w-4 h-4 inline mr-2" />
                    {{ __('admin.permissions.role_permissions.change_history') }}
                </button>
            </nav>
        </div>
    </div>

    <!-- Permissions Tab -->
    <div x-show="activeTab === 'permissions'" x-transition class="space-y-6">
        <!-- Search and Filter -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant p-4 border border-admin-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" 
                               x-model="searchQuery" 
                               @input="filterPermissions()"
                               placeholder="{{ __('admin.permissions.role_permissions.search_permission_placeholder') }}"
                               class="admin-input pl-10 w-64">
                        <x-heroicon name="magnifying-glass" class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-admin-400" />
                    </div>
                    
                    <select x-model="categoryFilter" @change="filterPermissions()" class="admin-input">
                        <option value="">{{ __('admin.permissions.role_permissions.all_categories') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                        @endforeach
                    </select>
                    
                    <select x-model="statusFilter" @change="filterPermissions()" class="admin-input">
                        <option value="">{{ __('admin.permissions.role_permissions.all_statuses') }}</option>
                        <option value="granted">{{ __('admin.permissions.role_permissions.granted') }}</option>
                        <option value="denied">{{ __('admin.permissions.role_permissions.denied') }}</option>
                        <option value="inherited">{{ __('admin.permissions.role_permissions.inherited') }}</option>
                    </select>
                </div>
                
                <div class="flex items-center space-x-3">
                    <button @click="selectAll()" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                        <x-heroicon name="check-square" class="w-4 h-4 inline mr-1" />
                        {{ __('admin.permissions.role_permissions.select_all') }}
                    </button>
                    <button @click="deselectAll()" class="text-sm text-admin-600 hover:text-admin-700 dark:text-admin-400 dark:hover:text-admin-300">
                        <x-heroicon name="square" class="w-4 h-4 inline mr-1" />
                        {{ __('admin.permissions.role_permissions.deselect_all') }}
                    </button>
                    <button @click="showBulkActions = !showBulkActions" 
                            x-show="selectedPermissions.length > 0"
                            class="inline-flex items-center px-3 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                        <x-heroicon name="cog-6-tooth" class="w-4 h-4 mr-2" />
                        {{ __('admin.permissions.role_permissions.bulk_action') }} (<span x-text="selectedPermissions.length"></span>)
                    </button>
                </div>
            </div>
            
            <!-- Bulk Actions -->
            <div x-show="showBulkActions" x-transition class="mt-4 p-4 bg-admin-50 dark:bg-admin-700/50 rounded-lg border border-admin-200 dark:border-admin-600">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-admin-600 dark:text-admin-400">
                        <span x-text="selectedPermissions.length"></span> {{ __('admin.permissions.role_permissions.permissions_selected') }}
                    </p>
                    <div class="flex items-center space-x-2">
                        <button @click="bulkGrant()" 
                                class="px-3 py-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-200 dark:hover:bg-green-900/50 text-sm">
                            <x-heroicon name="check" class="w-4 h-4 inline mr-1" />
                            {{ __('admin.permissions.role_permissions.grant_all') }}
                        </button>
                        <button @click="bulkRevoke()" 
                                class="px-3 py-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 text-sm">
                            <x-heroicon name="x-mark" class="w-4 h-4 inline mr-1" />
                            {{ __('admin.permissions.role_permissions.revoke_all') }}
                        </button>
                        <button @click="showBulkActions = false" 
                                class="px-3 py-2 text-admin-600 dark:text-admin-400 hover:text-admin-800 dark:hover:text-admin-200 text-sm">
                            <x-heroicon name="x-mark" class="w-4 h-4 inline mr-1" />
                            {{ __('admin.permissions.role_permissions.close') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Permissions Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($permissionsByCategory as $category => $permissions)
                <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant border border-admin-200 dark:border-admin-700 permission-category" 
                     data-category="{{ $category }}">
                    <div class="p-6 border-b border-admin-200 dark:border-admin-700">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-{{ $categoryColors[$category] ?? 'blue' }}-100 dark:bg-{{ $categoryColors[$category] ?? 'blue' }}-900/30 rounded-lg flex items-center justify-center">
                                    <x-heroicon name="question-mark-circle" class="w-5 h-5 text-{{ $categoryColors[$category] ?? 'blue' }}-600 dark:text-{{ $categoryColors[$category] ?? 'blue' }}-400" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-admin-900 dark:text-white">{{ ucfirst($category) }}</h3>
                                    <p class="text-sm text-admin-600 dark:text-admin-400">{{ count($permissions) }} {{ __('admin.permissions.role_permissions.permission_count') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                @php
                                    $categoryGranted = $permissions->intersect($role->permissions)->count();
                                    $categoryProgress = count($permissions) > 0 ? ($categoryGranted / count($permissions)) * 100 : 0;
                                @endphp
                                <div class="text-right">
                                    <p class="text-sm font-medium text-admin-900 dark:text-white">{{ $categoryGranted }}/{{ count($permissions) }}</p>
                                    <p class="text-xs text-admin-500">{{ number_format($categoryProgress, 1) }}%</p>
                                </div>
                                <div class="w-12 h-12 relative">
                                    <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 100 100">
                                        <circle cx="50" cy="50" r="40" stroke="currentColor" 
                                                stroke-width="8" fill="transparent" 
                                                class="text-admin-200 dark:text-admin-600"/>
                                        <circle cx="50" cy="50" r="40" stroke="currentColor" 
                                                stroke-width="8" fill="transparent" 
                                                stroke-dasharray="{{ 2 * pi() * 40 }}" 
                                                stroke-dashoffset="{{ 2 * pi() * 40 * (100 - $categoryProgress) / 100 }}"
                                                class="text-{{ $categoryColors[$category] ?? 'blue' }}-500 transition-all duration-1000"/>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-xs font-medium text-admin-900 dark:text-white">{{ number_format($categoryProgress, 0) }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-3">
                            @foreach($permissions as $permission)
                                @php
                                    $hasPermission = $role->hasPermissionTo($permission);
                                    $isInherited = $role->hasInheritedPermission($permission);
                                    $hasDependencies = $permission->dependencies->count() > 0;
                                    $dependenciesMet = $permission->areDependenciesMet($role);
                                @endphp
                                
                                <div class="flex items-center justify-between p-3 border border-admin-200 dark:border-admin-600 rounded-lg permission-item transition-all duration-200 hover:shadow-sm"
                                     data-permission-id="{{ $permission->id }}"
                                     data-category="{{ $category }}"
                                     data-name="{{ strtolower($permission->display_name) }}"
                                     data-status="{{ $hasPermission ? 'granted' : ($isInherited ? 'inherited' : 'denied') }}">
                                    
                                    <div class="flex items-center space-x-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" 
                                                   x-model="selectedPermissions" 
                                                   value="{{ $permission->id }}"
                                                   class="rounded border-admin-300 dark:border-admin-600">
                                        </label>
                                        
                                        <div class="w-8 h-8 bg-{{ $permission->getColorClass() }}-100 dark:bg-{{ $permission->getColorClass() }}-900/30 rounded-lg flex items-center justify-center">
                                            <x-heroicon name="{{ $permission->getIcon() }}" class="w-4 h-4 text-{{ $permission->getColorClass() }}-600 dark:text-{{ $permission->getColorClass() }}-400" />
                                        </div>
                                        
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2">
                                                <p class="font-medium text-admin-900 dark:text-white">{{ $permission->display_name }}</p>
                                                @if($isInherited)
                                                    <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-xs rounded-lg">
                                                        {{ __('admin.permissions.role_permissions.inherited') }}
                                                    </span>
                                                @endif
                                                @if($hasDependencies && !$dependenciesMet)
                                                    <span class="px-2 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-xs rounded-lg">
                                                        {{ __('admin.permissions.role_permissions.missing_dependency') }}
                                                    </span>
                                                @endif
                                            </div>
                                            @if($permission->description)
                                                <p class="text-sm text-admin-600 dark:text-admin-400 mt-1">{{ $permission->description }}</p>
                                            @endif
                                            @if($hasDependencies)
                                                <p class="text-xs text-admin-500 mt-1">
                                                    <x-heroicon name="link" class="w-3 h-3 inline mr-1" />
                                                    {{ $permission->dependencies->count() }} {{ __('admin.permissions.role_permissions.dependencies_exist') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        @if($hasDependencies)
                                            <button @click="showDependencies({{ $permission->id }})" 
                                                    class="p-2 text-admin-400 hover:text-admin-600 dark:hover:text-admin-300">
                                                <x-heroicon name="information-circle" class="w-4 h-4" />
                                            </button>
                                        @endif
                                        
                                        <!-- Permission Toggle -->
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                   {{ $hasPermission ? 'checked' : '' }}
                                                   {{ $isInherited ? 'disabled' : '' }}
                                                   @change="togglePermission({{ $permission->id }}, $event.target.checked)"
                                                   class="sr-only">
                                            <div class="w-11 h-6 rounded-full relative transition-colors duration-200"
                                                 :class="{
                                                     'bg-green-500': {{ $hasPermission ? 'true' : 'false' }},
                                                     'bg-amber-500': {{ $isInherited ? 'true' : 'false' }},
                                                     'bg-admin-300 dark:bg-admin-600': {{ !$hasPermission && !$isInherited ? 'true' : 'false' }}
                                                 }">
                                                <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-200"
                                                     :class="{
                                                         'transform translate-x-5': {{ $hasPermission || $isInherited ? 'true' : 'false' }}
                                                     }">
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Inheritance Tab -->
    <div x-show="activeTab === 'inheritance'" x-transition class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant p-6 border border-admin-200 dark:border-admin-700">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-admin-900 dark:text-white mb-2">{{ __('admin.permissions.role_permissions.hierarchy_permission_inheritance') }}</h2>
            <p class="text-admin-600 dark:text-admin-400">{{ __('admin.permissions.role_permissions.inheritance_description') }}</p>
        </div>
        
        <!-- Hierarchy Chain -->
        <div class="space-y-4">
            @forelse($hierarchyChain as $hierarchyRole)
                <div class="flex items-center space-x-4 p-4 border border-admin-200 dark:border-admin-600 rounded-xl">
                    <div class="w-12 h-12 bg-gradient-to-br from-{{ $hierarchyRole->getColorClass() }}-500 to-{{ $hierarchyRole->getColorClass() }}-600 rounded-xl flex items-center justify-center">
                        <x-heroicon name="shield-check" class="w-6 h-6 text-white" />
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex items-center space-x-2">
                            <h3 class="text-lg font-semibold text-admin-900 dark:text-white">{{ $hierarchyRole->display_name }}</h3>
                            <span class="px-2 py-1 bg-admin-100 dark:bg-admin-700 text-admin-700 dark:text-admin-300 text-sm rounded-lg">
                                {{ __('admin.permissions.role_permissions.level') }} {{ $hierarchyRole->hierarchy_level }}
                            </span>
                            @if($hierarchyRole->id === $role->id)
                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-sm rounded-lg">
                                    {{ __('admin.permissions.role_permissions.current_role') }}
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-admin-600 dark:text-admin-400 mt-1">
                            {{ $hierarchyRole->permissions->count() }} {{ __('admin.permissions.role_permissions.permission_count') }}
                            @if($hierarchyRole->id !== $role->id)
                                • {{ $hierarchyRole->getInheritablePermissions()->count() }} {{ __('admin.permissions.role_permissions.inheritable') }}
                            @endif
                        </p>
                    </div>
                    
                    <div class="text-right">
                        @if($hierarchyRole->id !== $role->id)
                            <button @click="viewInheritedPermissions({{ $hierarchyRole->id }})"
                                    class="px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                                <x-heroicon name="eye" class="w-4 h-4 inline mr-2" />
                                {{ __('admin.permissions.role_permissions.view_permissions') }}
                            </button>
                        @endif
                    </div>
                </div>
                
                @if(!$loop->last)
                    <div class="flex justify-center">
                        <x-heroicon name="arrow-down" class="w-6 h-6 text-admin-400" />
                    </div>
                @endif
            @empty
                <div class="text-center py-12">
                    <x-heroicon name="git-branch" class="w-12 h-12 text-admin-400 mx-auto mb-4" />
                    <p class="text-admin-600 dark:text-admin-400">{{ __('admin.permissions.role_permissions.no_hierarchy_inheritance') }}</p>
                </div>
            @endforelse
        </div>
        
        <!-- Inherited Permissions Details -->
        <div x-show="showInheritedDetails" x-transition class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
            <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-3">{{ __('admin.permissions.role_permissions.inherited_permissions') }}</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($inheritedPermissions as $permission)
                    <div class="flex items-center space-x-2 p-2 bg-white dark:bg-admin-800 rounded-lg">
                        <x-heroicon name="{{ $permission->getIcon() }}" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                        <span class="text-sm text-admin-900 dark:text-white">{{ $permission->display_name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Dependencies Tab -->
    <div x-show="activeTab === 'dependencies'" x-transition class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant p-6 border border-admin-200 dark:border-admin-700">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-admin-900 dark:text-white mb-2">{{ __('admin.permissions.role_permissions.permission_dependencies') }}</h2>
            <p class="text-admin-600 dark:text-admin-400">{{ __('admin.permissions.role_permissions.dependencies_description') }}</p>
        </div>
        
        <!-- Dependencies Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Required Dependencies -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-admin-900 dark:text-white flex items-center">
                    <x-heroicon name="arrow-right" class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" />
                    {{ __('admin.permissions.role_permissions.required_by_role') }}
                </h3>
                
                @forelse($dependencyRequirements as $permission => $dependencies)
                    <div class="p-4 border border-admin-200 dark:border-admin-600 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-medium text-admin-900 dark:text-white">{{ $permission }}</h4>
                            @if($dependencies['all_met'])
                                <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs rounded-lg">
                                    <x-heroicon name="check-circle" class="w-3 h-3 inline mr-1" />
                                    {{ __('admin.permissions.role_permissions.satisfied') }}
                                </span>
                            @else
                                <span class="px-2 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-xs rounded-lg">
                                    <x-heroicon name="x-circle" class="w-3 h-3 inline mr-1" />
                                    {{ __('admin.permissions.role_permissions.missing') }}
                                </span>
                            @endif
                        </div>
                        
                        <div class="space-y-1">
                            @foreach($dependencies['required'] as $dep)
                                <div class="flex items-center text-sm">
                                    @if($dependencies['met']->contains($dep['id']))
                                        <x-heroicon name="check" class="w-3 h-3 text-green-500 mr-2" />
                                        <span class="text-admin-700 dark:text-admin-300">{{ $dep['name'] }}</span>
                                    @else
                                        <x-heroicon name="x-mark" class="w-3 h-3 text-red-500 mr-2" />
                                        <span class="text-admin-500">{{ $dep['name'] }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <x-heroicon name="check-circle" class="w-8 h-8 text-green-500 mx-auto mb-2" />
                        <p class="text-admin-600 dark:text-admin-400">{{ __('admin.permissions.role_permissions.all_dependencies_satisfied') }}</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Provided Dependencies -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-admin-900 dark:text-white flex items-center">
                    <x-heroicon name="arrow-left" class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" />
                    {{ __('admin.permissions.role_permissions.provided_by_role') }}
                </h3>
                
                @forelse($providedDependencies as $permission => $dependents)
                    <div class="p-4 border border-admin-200 dark:border-admin-600 rounded-lg">
                        <h4 class="font-medium text-admin-900 dark:text-white mb-2">{{ $permission }}</h4>
                        <p class="text-sm text-admin-600 dark:text-admin-400 mb-2">
                            {{ __('admin.permissions.role_permissions.required_for_other_permissions', ['count' => count($dependents)]) }}:
                        </p>
                        <div class="space-y-1">
                            @foreach($dependents as $dependent)
                                <div class="flex items-center text-sm">
                                    <x-heroicon name="arrow-right" class="w-3 h-3 text-blue-500 mr-2" />
                                    <span class="text-admin-700 dark:text-admin-300">{{ $dependent }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <x-heroicon name="information-circle" class="w-8 h-8 text-admin-400 mx-auto mb-2" />
                        <p class="text-admin-600 dark:text-admin-400">{{ __('admin.permissions.role_permissions.no_dependencies_provided') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Users Tab -->
    <div x-show="activeTab === 'users'" x-transition class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant p-6 border border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-semibold text-admin-900 dark:text-white">{{ __('admin.permissions.role_permissions.users_with_role') }}</h2>
                <p class="text-admin-600 dark:text-admin-400">{{ __('admin.permissions.role_permissions.users_count_text', ['count' => $role->users_count]) }}</p>
            </div>
            <button @click="assignUsersToRole()" 
                    class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl">
                <x-heroicon name="user-plus" class="w-4 h-4 mr-2" />
                {{ __('admin.permissions.role_permissions.assign_user') }}
            </button>
        </div>
        
        <!-- Users List -->
        <div class="space-y-4">
            @forelse($roleUsers as $user)
                <div class="flex items-center justify-between p-4 border border-admin-200 dark:border-admin-600 rounded-lg hover:bg-admin-50 dark:hover:bg-admin-700/20 transition-colors">
                    <div class="flex items-center space-x-4">
                        @if($user->getProfileImage())
                            <img src="{{ $user->getProfileImage() }}" 
                                 class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 bg-admin-200 dark:bg-admin-700 rounded-full flex items-center justify-center">
                                <x-heroicon name="user" class="w-5 h-5 text-admin-400" />
                            </div>
                        @endif
                        
                        <div>
                            <h4 class="font-medium text-admin-900 dark:text-white">{{ $user->getFullName() }}</h4>
                            <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                                <span>{{ $user->email }}</span>
                                @if($user->department)
                                    <span>•</span>
                                    <span>{{ $user->getDepartmentName() }}</span>
                                @endif
                                @if($user->last_login_at)
                                    <span>•</span>
                                    <span>{{ __('admin.permissions.role_permissions.last_login') }}: {{ $user->last_login_at->format('d.m.Y') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <span class="px-2 py-1 text-xs font-medium rounded-lg {{ $user->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' }}">
                            {{ $user->is_active ? __('admin.permissions.role_permissions.active') : __('admin.permissions.role_permissions.inactive') }}
                        </span>
                        
                        <a href="{{ route('admin.managers.show', $user) }}" 
                           class="p-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            <x-heroicon name="external-link" class="w-4 h-4" />
                        </a>
                        
                        <button @click="removeUserFromRole({{ $user->id }})" 
                                class="p-2 text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                            <x-heroicon name="user-minus" class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <x-heroicon name="users" class="w-12 h-12 text-admin-400 mx-auto mb-4" />
                    <p class="text-admin-600 dark:text-admin-400">{{ __('admin.permissions.role_permissions.no_users_assigned') }}</p>
                </div>
            @endforelse
        </div>
        
        @if($roleUsers->hasPages())
            <div class="mt-6">
                {{ $roleUsers->links() }}
            </div>
        @endif
    </div>

    <!-- Audit Tab -->
    <div x-show="activeTab === 'audit'" x-transition class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant p-6 border border-admin-200 dark:border-admin-700">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-admin-900 dark:text-white">{{ __('admin.permissions.role_permissions.role_change_history') }}</h2>
            <p class="text-admin-600 dark:text-admin-400">{{ __('admin.permissions.role_permissions.change_history_description') }}</p>
        </div>
        
        <!-- Audit Log -->
        <div class="space-y-4">
            @forelse($auditLog as $log)
                <div class="flex items-start space-x-4 p-4 border border-admin-200 dark:border-admin-600 rounded-lg">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $log->getTypeColorClass() }}">
                        <x-heroicon name="{{ $log->getTypeIcon() }}" class="w-4 h-4 {{ $log->getTypeTextColorClass() }}" />
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h4 class="font-medium text-admin-900 dark:text-white">{{ $log->getDescription() }}</h4>
                            <span class="text-sm text-admin-500">{{ $log->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        
                        <div class="mt-1 text-sm text-admin-600 dark:text-admin-400">
                            @if($log->user)
                                <span>{{ __('admin.permissions.role_permissions.by_user', ['user' => $log->user->getFullName()]) }}</span>
                            @endif
                            @if($log->ip_address)
                                <span>• IP: {{ $log->ip_address }}</span>
                            @endif
                        </div>
                        
                        @if($log->details)
                            <div class="mt-2 p-3 bg-admin-50 dark:bg-admin-700/50 rounded-lg">
                                <pre class="text-xs text-admin-700 dark:text-admin-300 whitespace-pre-wrap">{{ json_encode($log->details, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <x-heroicon name="history" class="w-12 h-12 text-admin-400 mx-auto mb-4" />
                    <p class="text-admin-600 dark:text-admin-400">{{ __('admin.permissions.role_permissions.no_change_records') }}</p>
                </div>
            @endforelse
        </div>
        
        @if($auditLog->hasPages())
            <div class="mt-6">
                {{ $auditLog->links() }}
            </div>
        @endif
    </div>

    <!-- Change Tracker -->
    <div x-show="hasChanges" x-transition class="fixed bottom-6 right-6 bg-white dark:bg-admin-800 rounded-2xl shadow-2xl border border-admin-200 dark:border-admin-700 p-6 max-w-md">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-admin-900 dark:text-white">{{ __('admin.permissions.role_permissions.pending_changes') }}</h3>
            <button @click="clearChanges()" class="text-admin-400 hover:text-admin-600">
                <x-heroicon name="x-mark" class="w-5 h-5" />
            </button>
        </div>
        
        <div class="space-y-2 max-h-48 overflow-y-auto">
            <template x-for="change in pendingChanges" :key="change.id">
                <div class="flex items-center justify-between p-2 bg-admin-50 dark:bg-admin-700/50 rounded-lg">
                    <span class="text-sm text-admin-900 dark:text-white" x-text="change.description"></span>
                    <span class="px-2 py-1 text-xs font-medium rounded-lg"
                          :class="change.type === 'grant' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300'"
                          x-text="change.type === 'grant' ? 'Ver' : 'Al'"></span>
                </div>
            </template>
        </div>
        
        <div class="flex items-center space-x-3 mt-6">
            <button @click="clearChanges()" 
                    class="flex-1 px-4 py-2 border border-admin-300 dark:border-admin-600 text-admin-700 dark:text-admin-300 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700/50">
                {{ __('admin.permissions.role_permissions.cancel') }}
            </button>
            <button @click="saveChanges()" 
                    class="flex-1 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl">
                {{ __('admin.permissions.role_permissions.save') }} (<span x-text="pendingChanges.length"></span>)
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function rolePermissionManager() {
    return {
        activeTab: 'permissions',
        searchQuery: '',
        categoryFilter: '',
        statusFilter: '',
        selectedPermissions: [],
        showBulkActions: false,
        showInheritedDetails: false,
        pendingChanges: [],
        
        get hasChanges() {
            return this.pendingChanges.length > 0;
        },
        
        init() {
            this.$nextTick(() => {
                
            });
        },
        
        filterPermissions() {
            const items = document.querySelectorAll('.permission-item');
            
            items.forEach(item => {
                const name = item.dataset.name || '';
                const category = item.dataset.category || '';
                const status = item.dataset.status || '';
                
                let show = true;
                
                // Search filter
                if (this.searchQuery && !name.includes(this.searchQuery.toLowerCase())) {
                    show = false;
                }
                
                // Category filter
                if (this.categoryFilter && category !== this.categoryFilter) {
                    show = false;
                }
                
                // Status filter
                if (this.statusFilter && status !== this.statusFilter) {
                    show = false;
                }
                
                item.style.display = show ? 'flex' : 'none';
            });
            
            // Show/hide category containers
            document.querySelectorAll('.permission-category').forEach(container => {
                const visibleItems = container.querySelectorAll('.permission-item[style="display: flex;"], .permission-item:not([style*="display: none"])');
                container.style.display = visibleItems.length > 0 ? 'block' : 'none';
            });
        },
        
        selectAll() {
            const visibleItems = document.querySelectorAll('.permission-item:not([style*="display: none"]) input[type="checkbox"]');
            this.selectedPermissions = Array.from(visibleItems).map(item => item.value);
        },
        
        deselectAll() {
            this.selectedPermissions = [];
            this.showBulkActions = false;
        },
        
        togglePermission(permissionId, granted) {
            const change = {
                id: permissionId,
                type: granted ? 'grant' : 'revoke',
                description: this.getPermissionName(permissionId),
                permissionId: permissionId
            };
            
            // Remove existing change for this permission
            this.pendingChanges = this.pendingChanges.filter(c => c.id !== permissionId);
            
            // Add new change
            this.pendingChanges.push(change);
        },
        
        getPermissionName(permissionId) {
            const permissions = @json($allPermissions->pluck('display_name', 'id'));
            return permissions[permissionId] || 'Unknown Permission';
        },
        
        bulkGrant() {
            this.selectedPermissions.forEach(permissionId => {
                const change = {
                    id: permissionId,
                    type: 'grant',
                    description: this.getPermissionName(permissionId),
                    permissionId: permissionId
                };
                
                // Remove existing change
                this.pendingChanges = this.pendingChanges.filter(c => c.id !== permissionId);
                this.pendingChanges.push(change);
            });
            
            this.showBulkActions = false;
            this.selectedPermissions = [];
        },
        
        bulkRevoke() {
            this.selectedPermissions.forEach(permissionId => {
                const change = {
                    id: permissionId,
                    type: 'revoke',
                    description: this.getPermissionName(permissionId),
                    permissionId: permissionId
                };
                
                // Remove existing change
                this.pendingChanges = this.pendingChanges.filter(c => c.id !== permissionId);
                this.pendingChanges.push(change);
            });
            
            this.showBulkActions = false;
            this.selectedPermissions = [];
        },
        
        saveChanges() {
            if (this.pendingChanges.length === 0) return;
            
            Swal.fire({
                title: '{{ __("admin.permissions.role_permissions.js.save_changes_title") }}',
                text: `${this.pendingChanges.length} {{ __("admin.permissions.role_permissions.js.changes_will_be_saved") }}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '{{ __("admin.permissions.role_permissions.js.yes_save") }}',
                cancelButtonText: '{{ __("admin.permissions.role_permissions.js.cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX call to save changes
                    fetch('{{ route("admin.permissions.role-permissions", $role) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            changes: this.pendingChanges
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.pendingChanges = [];
                            Swal.fire('{{ __("admin.permissions.role_permissions.js.success") }}', '{{ __("admin.permissions.role_permissions.js.changes_saved") }}', 'success').then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('{{ __("admin.permissions.role_permissions.js.error") }}', data.message || '{{ __("admin.permissions.role_permissions.js.an_error_occurred") }}', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('{{ __("admin.permissions.role_permissions.js.error") }}', '{{ __("admin.permissions.role_permissions.js.an_error_occurred") }}', 'error');
                    });
                }
            });
        },
        
        clearChanges() {
            this.pendingChanges = [];
        },
        
        showRoleSettings() {
            window.location.href = '{{ route("admin.roles.edit", $role) }}';
        },
        
        cloneRole() {
            Swal.fire({
                title: '{{ __("admin.permissions.role_permissions.js.clone_role_title") }}',
                html: `
                    <input id="newRoleName" class="swal2-input" placeholder="{{ __("admin.permissions.role_permissions.js.new_role_name_placeholder") }}" value="{{ $role->display_name }} - {{ __("admin.permissions.role_permissions.js.copy_suffix") }}">
                `,
                showCancelButton: true,
                confirmButtonText: '{{ __("admin.permissions.role_permissions.js.clone") }}',
                cancelButtonText: '{{ __("admin.permissions.role_permissions.js.cancel") }}',
                preConfirm: () => {
                    const name = document.getElementById('newRoleName').value;
                    if (!name) {
                        Swal.showValidationMessage('{{ __("admin.permissions.role_permissions.js.please_enter_role_name") }}');
                    }
                    return { name: name };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX call to clone role
                    fetch('{{ route("admin.roles.clone", $role) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            name: result.value.name
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('{{ __("admin.permissions.role_permissions.js.success") }}', '{{ __("admin.permissions.role_permissions.js.role_cloned") }}', 'success').then(() => {
                                window.location.href = data.redirect_url;
                            });
                        }
                    });
                }
            });
        },
        
        exportRolePermissions() {
            window.open('{{ route("admin.permissions.export") }}?role={{ $role->id }}', '_blank');
        },
        
        deleteRole() {
            if ({{ $role->users_count }} > 0) {
                Swal.fire('{{ __("admin.permissions.role_permissions.js.warning") }}', '{{ __("admin.permissions.role_permissions.js.users_assigned_warning") }}', 'warning');
                return;
            }
            
            Swal.fire({
                title: '{{ __("admin.permissions.role_permissions.js.delete_role_title") }}',
                text: '{{ __("admin.permissions.role_permissions.js.delete_role_text") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __("admin.permissions.role_permissions.js.yes_delete") }}',
                cancelButtonText: '{{ __("admin.permissions.role_permissions.js.cancel") }}',
                confirmButtonColor: '#ef4444'
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX call to delete role
                    fetch('{{ route("admin.roles.destroy", $role) }}', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('{{ __("admin.permissions.role_permissions.js.deleted") }}', '{{ __("admin.permissions.role_permissions.js.role_deleted_successfully") }}', 'success').then(() => {
                                window.location.href = '{{ route("admin.permissions.index") }}';
                            });
                        }
                    });
                }
            });
        },
        
        viewInheritedPermissions(roleId) {
            this.showInheritedDetails = !this.showInheritedDetails;
        },
        
        showDependencies(permissionId) {
            // Show permission dependencies modal
            console.log('Showing dependencies for permission:', permissionId);
        },
        
        assignUsersToRole() {
            // Show user assignment modal
            console.log('Assigning users to role');
        },
        
        removeUserFromRole(userId) {
            Swal.fire({
                title: '{{ __("admin.permissions.role_permissions.js.remove_user_title") }}',
                text: '{{ __("admin.permissions.role_permissions.js.remove_user_text") }}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '{{ __("admin.permissions.role_permissions.js.yes_remove") }}',
                cancelButtonText: '{{ __("admin.permissions.role_permissions.js.cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX call to remove user from role
                    fetch(`{{ route("admin.roles.remove-user", $role) }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            user_id: userId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('{{ __("admin.permissions.role_permissions.js.success") }}', '{{ __("admin.permissions.role_permissions.js.user_removed_from_role") }}', 'success').then(() => {
                                window.location.reload();
                            });
                        }
                    });
                }
            });
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    
});
</script>
@endpush