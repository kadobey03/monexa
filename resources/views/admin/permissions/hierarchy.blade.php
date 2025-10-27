@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="hierarchyManager()">
    
    <!-- Page Header -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.permissions.index') }}" 
                   class="p-2 rounded-lg bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 transition-colors">
                    <i data-lucide="arrow-left" class="w-5 h-5 text-admin-600 dark:text-admin-400"></i>
                </a>
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <i data-lucide="git-branch" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-admin-900 dark:text-white">Hiyerarşi Görünümü</h1>
                        <p class="text-admin-600 dark:text-admin-400">Organizasyonel yapı ve rol hiyerarşisi</p>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <div class="flex items-center bg-admin-100 dark:bg-admin-700 rounded-xl p-1">
                    <button @click="viewMode = 'tree'" 
                            :class="viewMode === 'tree' ? 'bg-white dark:bg-admin-600 shadow-sm' : ''"
                            class="px-3 py-2 text-sm font-medium text-admin-700 dark:text-admin-300 rounded-lg transition-all">
                        <i data-lucide="git-branch" class="w-4 h-4 mr-1"></i>
                        Ağaç
                    </button>
                    <button @click="viewMode = 'org'" 
                            :class="viewMode === 'org' ? 'bg-white dark:bg-admin-600 shadow-sm' : ''"
                            class="px-3 py-2 text-sm font-medium text-admin-700 dark:text-admin-300 rounded-lg transition-all">
                        <i data-lucide="users" class="w-4 h-4 mr-1"></i>
                        Organizasyon
                    </button>
                    <button @click="viewMode = 'matrix'" 
                            :class="viewMode === 'matrix' ? 'bg-white dark:bg-admin-600 shadow-sm' : ''"
                            class="px-3 py-2 text-sm font-medium text-admin-700 dark:text-admin-300 rounded-lg transition-all">
                        <i data-lucide="grid" class="w-4 h-4 mr-1"></i>
                        Matrix
                    </button>
                </div>
                
                <button @click="exportHierarchy()" 
                        class="inline-flex items-center px-4 py-2 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 text-admin-700 dark:text-admin-300 rounded-xl transition-all duration-200">
                    <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                    Dışa Aktar
                </button>
                
                <button @click="showRestructure()" 
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl shadow-lg hover:shadow-blue-500/25 transition-all duration-200">
                    <i data-lucide="shuffle" class="w-4 h-4 mr-2"></i>
                    Yeniden Yapılandır
                </button>
            </div>
        </div>
    </div>

    <!-- Hierarchy Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl p-6 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Toplam Seviye</p>
                    <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $totalLevels ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="layers" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-2xl p-6 border border-green-200 dark:border-green-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-600 dark:text-green-400 font-medium">Aktif Roller</p>
                    <p class="text-2xl font-bold text-green-700 dark:text-green-300">{{ $activeRoles ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="shield" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-2xl p-6 border border-purple-200 dark:border-purple-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-purple-600 dark:text-purple-400 font-medium">Departman</p>
                    <p class="text-2xl font-bold text-purple-700 dark:text-purple-300">{{ $totalDepartments ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="building" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 rounded-2xl p-6 border border-amber-200 dark:border-amber-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-amber-600 dark:text-amber-400 font-medium">Kullanıcılar</p>
                    <p class="text-2xl font-bold text-amber-700 dark:text-amber-300">{{ $totalUsers ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-2xl p-6 border border-red-200 dark:border-red-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-red-600 dark:text-red-400 font-medium">Çakışmalar</p>
                    <p class="text-2xl font-bold text-red-700 dark:text-red-300">{{ $hierarchyConflicts ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tree View -->
    <div x-show="viewMode === 'tree'" x-transition class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
        <div class="p-6 border-b border-admin-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-admin-900 dark:text-white">Hiyerarşi Ağacı</h2>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                        <span>Aktif</span>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                        <span>Pasif</span>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-amber-500 rounded-full"></div>
                        <span>Beklemede</span>
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
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Seviye {{ $level }}</span>
                            </div>
                            <div class="flex-1 h-px bg-admin-200 dark:bg-admin-600 ml-4"></div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach($roles as $role)
                                <div class="role-node relative bg-gradient-to-br from-{{ $role->getColorClass() }}-50 to-{{ $role->getColorClass() }}-100 dark:from-{{ $role->getColorClass() }}-900/20 dark:to-{{ $role->getColorClass() }}-800/20 border border-{{ $role->getColorClass() }}-200 dark:border-{{ $role->getColorClass() }}-800 rounded-xl p-4 transition-all duration-200 hover:shadow-lg cursor-pointer"
                                     data-role-id="{{ $role->id }}"
                                     @click="selectRole({{ $role->id }})">
                                    
                                    <!-- Role Header -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-{{ $role->getColorClass() }}-500 to-{{ $role->getColorClass() }}-600 rounded-lg flex items-center justify-center">
                                            <i data-lucide="shield" class="w-5 h-5 text-white"></i>
                                        </div>
                                        <div class="text-right">
                                            <span class="px-2 py-1 bg-{{ $role->getColorClass() }}-200 dark:bg-{{ $role->getColorClass() }}-700 text-{{ $role->getColorClass() }}-800 dark:text-{{ $role->getColorClass() }}-200 text-xs font-medium rounded-lg">
                                                L{{ $role->hierarchy_level }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Role Info -->
                                    <div>
                                        <h3 class="font-semibold text-{{ $role->getColorClass() }}-900 dark:text-{{ $role->getColorClass() }}-100 mb-1">
                                            {{ $role->display_name }}
                                        </h3>
                                        <p class="text-sm text-{{ $role->getColorClass() }}-700 dark:text-{{ $role->getColorClass() }}-300 mb-2">
                                            {{ $role->users_count }} kullanıcı • {{ $role->permissions->count() }} izin
                                        </p>
                                        @if($role->description)
                                            <p class="text-xs text-{{ $role->getColorClass() }}-600 dark:text-{{ $role->getColorClass() }}-400 line-clamp-2">
                                                {{ $role->description }}
                                            </p>
                                        @endif
                                    </div>
                                    
                                    <!-- Role Status -->
                                    <div class="absolute top-2 right-2">
                                        <div class="w-3 h-3 {{ $role->is_active ? 'bg-green-500' : 'bg-red-500' }} rounded-full"></div>
                                    </div>
                                    
                                    <!-- Connection Lines -->
                                    @if($role->parent_roles->count() > 0)
                                        <div class="absolute -top-4 left-1/2 w-0.5 h-4 bg-admin-300 dark:bg-admin-600"></div>
                                    @endif
                                    
                                    @if($role->child_roles->count() > 0)
                                        <div class="absolute -bottom-4 left-1/2 w-0.5 h-4 bg-admin-300 dark:bg-admin-600"></div>
                                        <div class="absolute -bottom-4 left-1/4 right-1/4 h-0.5 bg-admin-300 dark:bg-admin-600"></div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        @if(!$loop->last)
                            <div class="flex justify-center mt-6">
                                <i data-lucide="chevron-down" class="w-6 h-6 text-admin-400"></i>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Organization Chart View -->
    <div x-show="viewMode === 'org'" x-transition class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
        <div class="p-6 border-b border-admin-200 dark:border-admin-700">
            <h2 class="text-lg font-semibold text-admin-900 dark:text-white">Organizasyon Şeması</h2>
        </div>
        
        <div class="p-6">
            <!-- Department-based Organization -->
            <div class="space-y-8">
                @foreach($departmentHierarchy ?? [] as $department => $structure)
                    <div class="department-section">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                <i data-lucide="building" class="w-6 h-6 text-white"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-admin-900 dark:text-white">{{ ucfirst($department) }}</h3>
                                <p class="text-admin-600 dark:text-admin-400">{{ $structure['total_users'] }} kullanıcı, {{ $structure['total_roles'] }} rol</p>
                            </div>
                        </div>
                        
                        <!-- Department Hierarchy -->
                        <div class="ml-8 space-y-6">
                            @foreach($structure['levels'] as $level => $roles)
                                <div class="level-section">
                                    <div class="flex items-center mb-4">
                                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                        <div class="w-8 h-0.5 bg-admin-300 dark:bg-admin-600"></div>
                                        <span class="px-3 py-1 bg-admin-100 dark:bg-admin-700 text-admin-700 dark:text-admin-300 text-sm font-medium rounded-lg">
                                            Seviye {{ $level }}
                                        </span>
                                    </div>
                                    
                                    <div class="ml-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($roles as $role)
                                            <div class="flex items-center space-x-3 p-4 bg-admin-50 dark:bg-admin-700/50 rounded-xl border border-admin-200 dark:border-admin-600">
                                                <div class="w-10 h-10 bg-gradient-to-br from-{{ $role->getColorClass() }}-500 to-{{ $role->getColorClass() }}-600 rounded-lg flex items-center justify-center">
                                                    <i data-lucide="shield" class="w-5 h-5 text-white"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <h4 class="font-medium text-admin-900 dark:text-white">{{ $role->display_name }}</h4>
                                                    <p class="text-sm text-admin-600 dark:text-admin-400">{{ $role->users_count }} kullanıcı</p>
                                                </div>
                                                <a href="{{ route('admin.permissions.role-permissions', $role) }}"
                                                   class="p-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                                    <i data-lucide="external-link" class="w-4 h-4"></i>
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
    <div x-show="viewMode === 'matrix'" x-transition class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
        <div class="p-6 border-b border-admin-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-admin-900 dark:text-white">Hiyerarşi Matrix</h2>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                        <span>Üst Rol</span>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                        <span>Alt Rol</span>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-gray-300 rounded-full"></div>
                        <span>Bağımsız</span>
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
                                Roller
                            </th>
                            @foreach($allRoles ?? [] as $role)
                                <th class="px-3 py-3 text-center text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider border-r border-admin-200 dark:border-admin-600 min-w-16">
                                    <div class="transform -rotate-45 origin-center">
                                        <span class="block">{{ Str::limit($role->display_name, 8) }}</span>
                                        <span class="block text-xs">L{{ $role->hierarchy_level }}</span>
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
                                        <div class="w-8 h-8 bg-gradient-to-br from-{{ $rowRole->getColorClass() }}-500 to-{{ $rowRole->getColorClass() }}-600 rounded-lg flex items-center justify-center mr-3">
                                            <i data-lucide="shield" class="w-4 h-4 text-white"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $rowRole->display_name }}</p>
                                            <p class="text-xs text-admin-500">Seviye {{ $rowRole->hierarchy_level }}</p>
                                        </div>
                                    </div>
                                </td>
                                @foreach($allRoles ?? [] as $colRole)
                                    <td class="px-3 py-4 text-center border-r border-admin-200 dark:border-admin-600">
                                        @php
                                            $relationship = $rowRole->getRelationshipWith($colRole);
                                        @endphp
                                        
                                        <div class="w-8 h-8 rounded-full mx-auto flex items-center justify-center">
                                            @if($rowRole->id === $colRole->id)
                                                <div class="w-6 h-6 bg-admin-300 dark:bg-admin-600 rounded-full"></div>
                                            @elseif($relationship === 'parent')
                                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                                    <i data-lucide="arrow-up" class="w-3 h-3 text-white"></i>
                                                </div>
                                            @elseif($relationship === 'child')
                                                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                                    <i data-lucide="arrow-down" class="w-3 h-3 text-white"></i>
                                                </div>
                                            @elseif($relationship === 'sibling')
                                                <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center">
                                                    <i data-lucide="arrow-right" class="w-3 h-3 text-white"></i>
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
    <div x-show="selectedRole" x-transition class="fixed inset-y-0 right-0 w-96 bg-white dark:bg-admin-800 shadow-2xl border-l border-admin-200 dark:border-admin-700 z-50">
        <div class="h-full flex flex-col">
            <!-- Header -->
            <div class="p-6 border-b border-admin-200 dark:border-admin-700 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-admin-900 dark:text-white">Rol Detayları</h3>
                    <button @click="selectedRole = null" class="p-2 text-admin-400 hover:text-admin-600 dark:hover:text-admin-300">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
            
            <!-- Content -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                <template x-if="selectedRoleData">
                    <div>
                        <!-- Role Info -->
                        <div class="bg-admin-50 dark:bg-admin-700/50 rounded-xl p-4 mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                    <i data-lucide="shield" class="w-6 h-6 text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-admin-900 dark:text-white" x-text="selectedRoleData.display_name"></h4>
                                    <p class="text-sm text-admin-600 dark:text-admin-400">
                                        Seviye <span x-text="selectedRoleData.hierarchy_level"></span>
                                    </p>
                                </div>
                            </div>
                            <p class="text-sm text-admin-700 dark:text-admin-300 mt-3" x-text="selectedRoleData.description"></p>
                        </div>
                        
                        <!-- Statistics -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-200 dark:border-green-800">
                                <p class="text-2xl font-bold text-green-700 dark:text-green-300" x-text="selectedRoleData.users_count"></p>
                                <p class="text-sm text-green-600 dark:text-green-400">Kullanıcı</p>
                            </div>
                            <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                                <p class="text-2xl font-bold text-blue-700 dark:text-blue-300" x-text="selectedRoleData.permissions_count"></p>
                                <p class="text-sm text-blue-600 dark:text-blue-400">İzin</p>
                            </div>
                        </div>
                        
                        <!-- Hierarchy Relationships -->
                        <div class="space-y-4">
                            <div x-show="selectedRoleData.parent_roles && selectedRoleData.parent_roles.length > 0">
                                <h5 class="font-medium text-admin-900 dark:text-white mb-2">Üst Roller</h5>
                                <div class="space-y-2">
                                    <template x-for="parent in selectedRoleData.parent_roles" :key="parent.id">
                                        <div class="flex items-center space-x-3 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                                <i data-lucide="arrow-up" class="w-4 h-4 text-white"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-green-900 dark:text-green-100" x-text="parent.display_name"></p>
                                                <p class="text-sm text-green-700 dark:text-green-300">Seviye <span x-text="parent.hierarchy_level"></span></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            
                            <div x-show="selectedRoleData.child_roles && selectedRoleData.child_roles.length > 0">
                                <h5 class="font-medium text-admin-900 dark:text-white mb-2">Alt Roller</h5>
                                <div class="space-y-2">
                                    <template x-for="child in selectedRoleData.child_roles" :key="child.id">
                                        <div class="flex items-center space-x-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                                <i data-lucide="arrow-down" class="w-4 h-4 text-white"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-blue-900 dark:text-blue-100" x-text="child.display_name"></p>
                                                <p class="text-sm text-blue-700 dark:text-blue-300">Seviye <span x-text="child.hierarchy_level"></span></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="space-y-3 pt-4 border-t border-admin-200 dark:border-admin-600">
                            <button @click="viewRolePermissions(selectedRoleData.id)" 
                                    class="w-full flex items-center justify-center px-4 py-3 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-xl hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                                <i data-lucide="key" class="w-4 h-4 mr-2"></i>
                                İzinleri Görüntüle
                            </button>
                            
                            <button @click="editRole(selectedRoleData.id)" 
                                    class="w-full flex items-center justify-center px-4 py-3 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-xl hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors">
                                <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                                Rolü Düzenle
                            </button>
                            
                            <button @click="manageUsers(selectedRoleData.id)" 
                                    class="w-full flex items-center justify-center px-4 py-3 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-xl hover:bg-purple-200 dark:hover:bg-purple-900/50 transition-colors">
                                <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                                Kullanıcıları Yönet
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Restructure Modal -->
    <div x-show="showRestructureModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-2xl max-w-4xl w-full m-4 max-h-[90vh] overflow-hidden">
            <div class="p-6 border-b border-admin-200 dark:border-admin-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-admin-900 dark:text-white">Hiyerarşi Yeniden Yapılandırma</h3>
                    <button @click="showRestructureModal = false" class="text-admin-400 hover:text-admin-600">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
            
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-200px)]">
                <div class="space-y-6">
                    <!-- Restructure Options -->
                    <div>
                        <h4 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">Yapılandırma Seçenekleri</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 border border-admin-200 dark:border-admin-600 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700/20 cursor-pointer transition-colors"
                                 @click="restructureType = 'department'">
                                <div class="flex items-center space-x-3">
                                    <input type="radio" x-model="restructureType" value="department" class="text-blue-600">
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                        <i data-lucide="building" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-medium text-admin-900 dark:text-white">Departman Bazlı</h5>
                                        <p class="text-sm text-admin-600 dark:text-admin-400">Rolleri departmanlara göre organize et</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-4 border border-admin-200 dark:border-admin-600 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700/20 cursor-pointer transition-colors"
                                 @click="restructureType = 'function'">
                                <div class="flex items-center space-x-3">
                                    <input type="radio" x-model="restructureType" value="function" class="text-green-600">
                                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                        <i data-lucide="layers" class="w-5 h-5 text-green-600 dark:text-green-400"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-medium text-admin-900 dark:text-white">Fonksiyon Bazlı</h5>
                                        <p class="text-sm text-admin-600 dark:text-admin-400">Rolleri işlevlere göre organize et</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-4 border border-admin-200 dark:border-admin-600 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700/20 cursor-pointer transition-colors"
                                 @click="restructureType = 'permission'">
                                <div class="flex items-center space-x-3">
                                    <input type="radio" x-model="restructureType" value="permission" class="text-purple-600">
                                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                        <i data-lucide="key" class="w-5 h-5 text-purple-600 dark:text-purple-400"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-medium text-admin-900 dark:text-white">İzin Bazlı</h5>
                                        <p class="text-sm text-admin-600 dark:text-admin-400">Rolleri izin seviyelerine göre organize et</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-4 border border-admin-200 dark:border-admin-600 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700/20 cursor-pointer transition-colors"
                                 @click="restructureType = 'custom'">
                                <div class="flex items-center space-x-3">
                                    <input type="radio" x-model="restructureType" value="custom" class="text-amber-600">
                                    <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                                        <i data-lucide="settings" class="w-5 h-5 text-amber-600 dark:text-amber-400"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-medium text-admin-900 dark:text-white">Özel Yapılandırma</h5>
                                        <p class="text-sm text-admin-600 dark:text-admin-400">Manuel hiyerarşi düzenleme</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Preview -->
                    <div x-show="restructureType" x-transition>
                        <h4 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">Değişiklik Önizlemesi</h4>
                        <div class="p-4 bg-admin-50 dark:bg-admin-700/50 rounded-xl border border-admin-200 dark:border-admin-600">
                            <p class="text-admin-700 dark:text-admin-300">
                                <i data-lucide="info" class="w-4 h-4 inline mr-2"></i>
                                Seçilen yapılandırma tipine göre hiyerarşi değişiklikleri burada gösterilecek.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-6 border-t border-admin-200 dark:border-admin-700">
                <div class="flex items-center justify-end space-x-3">
                    <button @click="showRestructureModal = false" 
                            class="px-6 py-2 border border-admin-300 dark:border-admin-600 text-admin-700 dark:text-admin-300 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700/50">
                        İptal
                    </button>
                    <button @click="applyRestructure()" 
                            :disabled="!restructureType"
                            class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl disabled:opacity-50 disabled:cursor-not-allowed">
                        Uygula
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://d3js.org/d3.v7.min.js"></script>
<script>
function hierarchyManager() {
    return {
        viewMode: 'tree',
        selectedRole: null,
        selectedRoleData: null,
        showRestructureModal: false,
        restructureType: '',
        
        init() {
            this.$nextTick(() => {
                lucide.createIcons();
                this.initializeD3Tree();
            });
        },
        
        selectRole(roleId) {
            this.selectedRole = roleId;
            
            // Fetch role data
            fetch(`/admin/dashboard/roles/${roleId}/data`)
                .then(response => response.json())
                .then(data => {
                    this.selectedRoleData = data;
                })
                .catch(error => {
                    console.error('Error fetching role data:', error);
                });
        },
        
        initializeD3Tree() {
            // Initialize D3.js tree visualization for complex hierarchy
            const hierarchyData = @json($d3HierarchyData ?? []);
            
            // D3 tree implementation would go here
            console.log('D3 Tree initialized with data:', hierarchyData);
        },
        
        viewRolePermissions(roleId) {
            window.location.href = `/admin/dashboard/permissions/role/${roleId}`;
        },
        
        editRole(roleId) {
            window.location.href = `/admin/dashboard/roles/${roleId}/edit`;
        },
        
        manageUsers(roleId) {
            window.location.href = `{{ route('admin.managers.index') }}?role=${roleId}`;
        },
        
        showRestructure() {
            this.showRestructureModal = true;
            this.restructureType = '';
        },
        
        applyRestructure() {
            if (!this.restructureType) return;
            
            Swal.fire({
                title: 'Hiyerarşiyi Yeniden Yapılandır',
                text: 'Bu işlem mevcut hiyerarşiyi değiştirecek. Emin misiniz?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Evet, Uygula',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX call to restructure hierarchy
                    fetch('{{ route("admin.permissions.restructure") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            type: this.restructureType
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.showRestructureModal = false;
                            Swal.fire('Başarılı!', 'Hiyerarşi yeniden yapılandırıldı.', 'success').then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Hata!', data.message || 'Bir hata oluştu.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Hata!', 'Bir hata oluştu.', 'error');
                    });
                }
            });
        },
        
        exportHierarchy() {
            const format = 'json'; // Could be made selectable
            
            Swal.fire({
                title: 'Hiyerarşiyi Dışa Aktar',
                html: `
                    <select id="exportFormat" class="swal2-select">
                        <option value="json">JSON</option>
                        <option value="xlsx">Excel</option>
                        <option value="pdf">PDF</option>
                        <option value="png">PNG Görsel</option>
                    </select>
                `,
                showCancelButton: true,
                confirmButtonText: 'Dışa Aktar',
                cancelButtonText: 'İptal',
                preConfirm: () => {
                    const format = document.getElementById('exportFormat').value;
                    return { format: format };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open(`{{ route('admin.permissions.hierarchy.export') }}?format=${result.value.format}`, '_blank');
                }
            });
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
});
</script>
@endpush