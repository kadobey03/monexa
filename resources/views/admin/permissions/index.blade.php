@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="permissionsManager()">
    
    <!-- Page Header -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <x-heroicon name="shield-check" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-admin-900 dark:text-white">Yetki Yönetimi</h1>
                    <p class="text-admin-600 dark:text-admin-400">Rol tabanlı erişim kontrolü ve izin yönetimi</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <button @click="showAuditLog()" 
                        class="inline-flex items-center px-4 py-2 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 text-admin-700 dark:text-admin-300 rounded-xl transition-all duration-200">
                    <x-heroicon name="history" class="w-4 h-4 mr-2" />
                    Değişim Geçmişi
                </button>
                
                <a href="{{ route('admin.permissions.hierarchy') }}" 
                   class="inline-flex items-center px-4 py-2 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 text-admin-700 dark:text-admin-300 rounded-xl transition-all duration-200">
                    <x-heroicon name="git-branch" class="w-4 h-4 mr-2" />
                    Hiyerarşi Görünümü
                </a>
                
                <button @click="showBulkAssign()" 
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl shadow-lg hover:shadow-blue-500/25 transition-all duration-200">
                    <x-heroicon name="users" class="w-4 h-4 mr-2" />
                    Toplu Atama
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl p-6 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Toplam Rol</p>
                    <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $totalRoles }}</p>
                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                        {{ $activeRoles }} aktif
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <x-heroicon name="shield-check" class="w-6 h-6 text-white" />
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-2xl p-6 border border-green-200 dark:border-green-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-600 dark:text-green-400 font-medium">Toplam İzin</p>
                    <p class="text-2xl font-bold text-green-700 dark:text-green-300">{{ $totalPermissions }}</p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                        {{ $permissionCategories }} kategori
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                    <x-heroicon name="key" class="w-6 h-6 text-white" />
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 rounded-2xl p-6 border border-amber-200 dark:border-amber-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-amber-600 dark:text-amber-400 font-medium">Atanmış İzin</p>
                    <p class="text-2xl font-bold text-amber-700 dark:text-amber-300">{{ $assignedPermissions }}</p>
                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-1">
                        {{ number_format(($assignedPermissions / ($totalRoles * $totalPermissions)) * 100, 1) }}% dolu
                    </p>
                </div>
                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center">
                    <x-heroicon name="check-circle" class="w-6 h-6 text-white" />
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-2xl p-6 border border-purple-200 dark:border-purple-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-purple-600 dark:text-purple-400 font-medium">Son Değişiklik</p>
                    <p class="text-lg font-bold text-purple-700 dark:text-purple-300">{{ $lastChangeAgo }}</p>
                    <p class="text-xs text-purple-600 dark:text-purple-400 mt-1">
                        {{ $lastChangeUser }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                    <x-heroicon name="clock" class="w-6 h-6 text-white" />
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Filters -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-admin-900 dark:text-white">Hızlı İşlemler</h2>
            <div class="flex items-center space-x-3">
                <!-- Filter Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="inline-flex items-center px-4 py-2 bg-admin-100 dark:bg-admin-700 text-admin-700 dark:text-admin-300 rounded-xl hover:bg-admin-200 dark:hover:bg-admin-600 transition-colors">
                        <x-heroicon name="funnel" class="w-4 h-4 mr-2" />
                        Filtrele
                        <x-heroicon name="chevron-down" class="w-4 h-4 ml-2" />
                    </button>
                    
                    <div x-show="open" 
                         x-transition 
                         @click.away="open = false"
                         class="absolute right-0 mt-2 w-64 bg-white dark:bg-admin-800 rounded-xl shadow-elegant border border-admin-200 dark:border-admin-700 p-4 z-10">
                        <div class="space-y-3">
                            <!-- Role Filter -->
                            <div>
                                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-1">Rol</label>
                                <select x-model="filters.role" @change="applyFilters()" class="admin-input w-full text-sm">
                                    <option value="">Tümü</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Category Filter -->
                            <div>
                                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-1">Kategori</label>
                                <select x-model="filters.category" @change="applyFilters()" class="admin-input w-full text-sm">
                                    <option value="">Tümü</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Status Filter -->
                            <div>
                                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-1">Durum</label>
                                <select x-model="filters.status" @change="applyFilters()" class="admin-input w-full text-sm">
                                    <option value="">Tümü</option>
                                    <option value="assigned">Atanmış</option>
                                    <option value="unassigned">Atanmamış</option>
                                </select>
                            </div>
                            
                            <hr class="border-admin-200 dark:border-admin-600">
                            
                            <button @click="resetFilters()" class="w-full text-sm text-admin-600 dark:text-admin-400 hover:text-admin-800 dark:hover:text-admin-200">
                                <x-heroicon name="x-circle" class="w-4 h-4 inline mr-1" />
                                Filtreleri Temizle
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- View Mode Toggle -->
                <div class="flex items-center bg-admin-100 dark:bg-admin-700 rounded-xl p-1">
                    <button @click="viewMode = 'matrix'" 
                            :class="viewMode === 'matrix' ? 'bg-white dark:bg-admin-600 shadow-sm' : ''"
                            class="px-3 py-1 text-sm font-medium text-admin-700 dark:text-admin-300 rounded-lg transition-all">
                        <x-heroicon name="grid" class="w-4 h-4 mr-1" />
                        Matrix
                    </button>
                    <button @click="viewMode = 'list'" 
                            :class="viewMode === 'list' ? 'bg-white dark:bg-admin-600 shadow-sm' : ''"
                            class="px-3 py-1 text-sm font-medium text-admin-700 dark:text-admin-300 rounded-lg transition-all">
                        <x-heroicon name="list-bullet" class="w-4 h-4 mr-1" />
                        Liste
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Quick Action Buttons -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <button @click="createRoleTemplate()" 
                    class="flex items-center justify-center p-4 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 border border-blue-200 dark:border-blue-800 rounded-xl transition-colors">
                <div class="text-center">
                    <x-heroicon name="plus-circle" class="w-6 h-6 text-blue-600 dark:text-blue-400 mx-auto mb-2" />
                    <p class="text-sm font-medium text-blue-700 dark:text-blue-300">Yeni Rol</p>
                </div>
            </button>
            
            <button @click="importPermissions()" 
                    class="flex items-center justify-center p-4 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/40 border border-green-200 dark:border-green-800 rounded-xl transition-colors">
                <div class="text-center">
                    <x-heroicon name="arrow-up-tray" class="w-6 h-6 text-green-600 dark:text-green-400 mx-auto mb-2" />
                    <p class="text-sm font-medium text-green-700 dark:text-green-300">İzinleri İçe Aktar</p>
                </div>
            </button>
            
            <button @click="exportPermissions()" 
                    class="flex items-center justify-center p-4 bg-amber-50 dark:bg-amber-900/20 hover:bg-amber-100 dark:hover:bg-amber-900/40 border border-amber-200 dark:border-amber-800 rounded-xl transition-colors">
                <div class="text-center">
                    <x-heroicon name="arrow-down-tray" class="w-6 h-6 text-amber-600 dark:text-amber-400 mx-auto mb-2" />
                    <p class="text-sm font-medium text-amber-700 dark:text-amber-300">Rapor İndir</p>
                </div>
            </button>
            
            <button @click="syncPermissions()" 
                    class="flex items-center justify-center p-4 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/40 border border-purple-200 dark:border-purple-800 rounded-xl transition-colors">
                <div class="text-center">
                    <x-heroicon name="arrow-path" class="w-6 h-6 text-purple-600 dark:text-purple-400 mx-auto mb-2" />
                    <p class="text-sm font-medium text-purple-700 dark:text-purple-300">İzinleri Senkronize Et</p>
                </div>
            </button>
        </div>
    </div>

    <!-- Permission Matrix View -->
    <div x-show="viewMode === 'matrix'" x-transition class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
        <div class="p-6 border-b border-admin-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-admin-900 dark:text-white">Rol-İzin Matrix</h2>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                        <span>İzin Var</span>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                        <span>İzin Yok</span>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-admin-600 dark:text-admin-400">
                        <div class="w-4 h-4 bg-amber-500 rounded-full"></div>
                        <span>Koşullu</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Matrix Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-admin-50 dark:bg-admin-700/50">
                        <tr>
                            <th class="sticky left-0 bg-admin-50 dark:bg-admin-700/50 px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider border-r border-admin-200 dark:border-admin-600">
                                İzinler
                            </th>
                            @foreach($roles as $role)
                                <th class="px-3 py-3 text-center text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider border-r border-admin-200 dark:border-admin-600 min-w-24">
                                    <div class="transform -rotate-45 origin-center">
                                        <span class="block">{{ $role->display_name }}</span>
                                        <span class="block text-xs text-admin-400 dark:text-admin-500">L{{ $role->hierarchy_level }}</span>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-admin-800 divide-y divide-admin-200 dark:divide-admin-600">
                        @foreach($permissionsByCategory as $category => $permissions)
                            <!-- Category Header -->
                            <tr class="bg-admin-100 dark:bg-admin-700/30">
                                <td colspan="{{ count($roles) + 1 }}" class="px-6 py-3 text-sm font-medium text-admin-900 dark:text-white">
                                    <div class="flex items-center">
                                        <x-heroicon name="{{ $categoryIcons[$category] ?? 'folder' }}" class="w-4 h-4 mr-2" />
                                        {{ ucfirst($category) }} ({{ count($permissions) }})
                                        <button @click="toggleCategory('{{ $category }}')" class="ml-2">
                                            <i :data-lucide="expandedCategories.includes('{{ $category }}') ? 'chevron-down' : 'chevron-right'" 
                                               class="w-4 h-4 text-admin-500"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Permission Rows -->
                            <template x-show="expandedCategories.includes('{{ $category }}')" x-transition>
                                @foreach($permissions as $permission)
                                    <tr class="hover:bg-admin-50 dark:hover:bg-admin-700/20 transition-colors" 
                                        data-permission-id="{{ $permission->id }}"
                                        data-category="{{ $category }}">
                                        <td class="sticky left-0 bg-white dark:bg-admin-800 px-6 py-4 text-sm text-admin-900 dark:text-white border-r border-admin-200 dark:border-admin-600">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-{{ $permission->getColorClass() }}-100 dark:bg-{{ $permission->getColorClass() }}-900/20 rounded-lg flex items-center justify-center mr-3">
                                                    <i data-lucide="{{ $permission->getIcon() }}" class="w-4 h-4 text-{{ $permission->getColorClass() }}-600 dark:text-{{ $permission->getColorClass() }}-400"></i>
                                                </div>
                                                <div>
                                                    <p class="font-medium">{{ $permission->display_name }}</p>
                                                    @if($permission->description)
                                                        <p class="text-xs text-admin-500 mt-1">{{ $permission->description }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        @foreach($roles as $role)
                                            <td class="px-3 py-4 text-center border-r border-admin-200 dark:border-admin-600">
                                                @php
                                                    $hasPermission = $role->hasPermissionTo($permission);
                                                    $isInherited = $role->hasInheritedPermission($permission);
                                                    $isDependency = $role->hasDependentPermission($permission);
                                                @endphp
                                                
                                                <button @click="togglePermission({{ $role->id }}, {{ $permission->id }})"
                                                        class="w-8 h-8 rounded-full flex items-center justify-center transition-all duration-200 transform hover:scale-110"
                                                        :class="{
                                                            'bg-green-500 hover:bg-green-600': permissions[{{ $role->id }}]?.includes({{ $permission->id }}),
                                                            'bg-red-200 dark:bg-red-800 hover:bg-red-300 dark:hover:bg-red-700': !permissions[{{ $role->id }}]?.includes({{ $permission->id }}),
                                                            'bg-amber-500 hover:bg-amber-600': {{ $isInherited ? 'true' : 'false' }},
                                                            'ring-2 ring-blue-500 ring-offset-2': {{ $isDependency ? 'true' : 'false' }}
                                                        }"
                                                        data-role-id="{{ $role->id }}"
                                                        data-permission-id="{{ $permission->id }}"
                                                        :title="getPermissionTooltip({{ $role->id }}, {{ $permission->id }})">
                                                    
                                                    @if($hasPermission)
                                                        <x-heroicon name="check" class="w-4 h-4 text-white" />
                                                    @elseif($isInherited)
                                                        <x-heroicon name="arrow-down" class="w-4 h-4 text-white" />
                                                    @elseif($isDependency)
                                                        <x-heroicon name="link" class="w-4 h-4 text-white" />
                                                    @else
                                                        <x-heroicon name="x-mark" class="w-3 h-3 text-admin-400" />
                                                    @endif
                                                </button>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </template>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- List View -->
    <div x-show="viewMode === 'list'" x-transition class="space-y-6">
        @foreach($roles as $role)
            <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
                <div class="p-6 border-b border-admin-200 dark:border-admin-700">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-{{ $role->getColorClass() }}-500 to-{{ $role->getColorClass() }}-600 rounded-xl flex items-center justify-center">
                                <x-heroicon name="shield-check" class="w-6 h-6 text-white" />
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-admin-900 dark:text-white">{{ $role->display_name }}</h3>
                                <div class="flex items-center space-x-3 text-sm text-admin-600 dark:text-admin-400">
                                    <span>Seviye {{ $role->hierarchy_level }}</span>
                                    <span>•</span>
                                    <span>{{ $role->permissions->count() }} izin</span>
                                    @if($role->description)
                                        <span>•</span>
                                        <span>{{ Str::limit($role->description, 50) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('admin.permissions.role-permissions', $role) }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-xl hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                            <x-heroicon name="edit-3" class="w-4 h-4 mr-2" />
                            Düzenle
                        </a>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($permissionsByCategory as $category => $permissions)
                            @php
                                $categoryPermissions = $role->permissions->intersect($permissions);
                            @endphp
                            @if($categoryPermissions->count() > 0)
                                <div class="border border-admin-200 dark:border-admin-600 rounded-xl p-4">
                                    <h4 class="font-medium text-admin-900 dark:text-white mb-3 flex items-center">
                                        <x-heroicon name="{{ $categoryIcons[$category] ?? 'folder' }}" class="w-4 h-4 mr-2" />
                                        {{ ucfirst($category) }}
                                        <span class="ml-auto text-xs text-admin-500">{{ $categoryPermissions->count() }}/{{ $permissions->count() }}</span>
                                    </h4>
                                    <div class="space-y-2">
                                        @foreach($categoryPermissions as $permission)
                                            <div class="flex items-center text-sm">
                                                <x-heroicon name="check" class="w-3 h-3 text-green-500 mr-2" />
                                                <span class="text-admin-700 dark:text-admin-300">{{ $permission->display_name }}</span>
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
    <div x-show="hasChanges" x-transition class="fixed bottom-6 right-6 bg-white dark:bg-admin-800 rounded-2xl shadow-2xl border border-admin-200 dark:border-admin-700 p-6 max-w-md">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-admin-900 dark:text-white">Bekleyen Değişiklikler</h3>
            <button @click="clearChanges()" class="text-admin-400 hover:text-admin-600">
                <x-heroicon name="x-mark" class="w-5 h-5" />
            </button>
        </div>
        
        <div class="space-y-3 max-h-64 overflow-y-auto">
            <template x-for="change in changes" :key="change.id">
                <div class="flex items-center justify-between p-3 bg-admin-50 dark:bg-admin-700/50 rounded-lg">
                    <div class="text-sm">
                        <p class="font-medium text-admin-900 dark:text-white" x-text="change.role"></p>
                        <p class="text-admin-600 dark:text-admin-400" x-text="change.permission"></p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium rounded-lg"
                          :class="change.action === 'grant' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300'"
                          x-text="change.action === 'grant' ? 'Ver' : 'Al'"></span>
                </div>
            </template>
        </div>
        
        <div class="flex items-center space-x-3 mt-6">
            <button @click="clearChanges()" 
                    class="flex-1 px-4 py-2 border border-admin-300 dark:border-admin-600 text-admin-700 dark:text-admin-300 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700/50">
                İptal
            </button>
            <button @click="saveChanges()" 
                    class="flex-1 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl">
                Kaydet (<span x-text="changes.length"></span>)
            </button>
        </div>
    </div>
</div>

<!-- Bulk Assignment Modal -->
<div x-show="showBulkModal" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-2xl max-w-2xl w-full m-4 max-h-[90vh] overflow-hidden">
        <div class="p-6 border-b border-admin-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-semibold text-admin-900 dark:text-white">Toplu İzin Atama</h3>
                <button @click="showBulkModal = false" class="text-admin-400 hover:text-admin-600">
                    <x-heroicon name="x-mark" class="w-6 h-6" />
                </button>
            </div>
        </div>
        
        <div class="p-6 overflow-y-auto max-h-96">
            <div class="space-y-6">
                <!-- Template Selection -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">Şablon Seç</label>
                    <select x-model="bulkTemplate" @change="loadTemplate()" class="admin-input w-full">
                        <option value="">Özel atama</option>
                        <option value="admin">Admin (Tüm İzinler)</option>
                        <option value="manager">Yönetici (Yönetim İzinleri)</option>
                        <option value="sales">Satış (Satış İzinleri)</option>
                        <option value="support">Destek (Destek İzinleri)</option>
                    </select>
                </div>
                
                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">Hedef Roller</label>
                    <div class="space-y-2 max-h-32 overflow-y-auto border border-admin-200 dark:border-admin-600 rounded-lg p-3">
                        @foreach($roles as $role)
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       x-model="bulkRoles" 
                                       value="{{ $role->id }}"
                                       class="rounded border-admin-300 dark:border-admin-600">
                                <span class="ml-2 text-sm text-admin-700 dark:text-admin-300">{{ $role->display_name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Permission Selection -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">İzinler</label>
                    <div class="space-y-3 max-h-48 overflow-y-auto border border-admin-200 dark:border-admin-600 rounded-lg p-3">
                        @foreach($permissionsByCategory as $category => $permissions)
                            <div>
                                <label class="flex items-center font-medium text-admin-900 dark:text-white">
                                    <input type="checkbox" 
                                           @change="toggleCategoryPermissions('{{ $category }}')"
                                           class="rounded border-admin-300 dark:border-admin-600">
                                    <span class="ml-2">{{ ucfirst($category) }}</span>
                                </label>
                                <div class="ml-6 mt-2 space-y-1">
                                    @foreach($permissions as $permission)
                                        <label class="flex items-center">
                                            <input type="checkbox" 
                                                   x-model="bulkPermissions" 
                                                   value="{{ $permission->id }}"
                                                   class="rounded border-admin-300 dark:border-admin-600">
                                            <span class="ml-2 text-sm text-admin-600 dark:text-admin-400">{{ $permission->display_name }}</span>
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
                <button @click="showBulkModal = false" 
                        class="px-6 py-2 border border-admin-300 dark:border-admin-600 text-admin-700 dark:text-admin-300 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700/50">
                    İptal
                </button>
                <button @click="applyBulkAssignment()" 
                        class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-xl">
                    Uygula
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function permissionsManager() {
    return {
        viewMode: 'matrix',
        filters: {
            role: '',
            category: '',
            status: ''
        },
        expandedCategories: @json(isset($permissionsByCategory) ? array_keys(is_array($permissionsByCategory) ? $permissionsByCategory : $permissionsByCategory->toArray()) : []),
        permissions: @json(isset($rolePermissions) ? (is_array($rolePermissions) ? $rolePermissions : $rolePermissions->toArray()) : []),
        changes: [],
        showBulkModal: false,
        bulkTemplate: '',
        bulkRoles: [],
        bulkPermissions: [],
        
        get hasChanges() {
            return this.changes.length > 0;
        },
        
        init() {
            // Initialize tooltips and other components
            this.$nextTick(() => {
                
            });
        },
        
        toggleCategory(category) {
            const index = this.expandedCategories.indexOf(category);
            if (index > -1) {
                this.expandedCategories.splice(index, 1);
            } else {
                this.expandedCategories.push(category);
            }
        },
        
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
            
            // Add to changes
            const change = {
                id: `${roleId}-${permissionId}`,
                roleId: roleId,
                permissionId: permissionId,
                action: action,
                role: this.getRoleName(roleId),
                permission: this.getPermissionName(permissionId)
            };
            
            // Remove existing change for this role-permission pair
            this.changes = this.changes.filter(c => c.id !== change.id);
            
            // Add new change
            this.changes.push(change);
        },
        
        getRoleName(roleId) {
            const roles = @json(isset($roles) ? $roles->pluck('display_name', 'id')->toArray() : []);
            return roles[roleId] || 'Unknown Role';
        },
        
        getPermissionName(permissionId) {
            const permissions = @json(isset($allPermissions) ? $allPermissions->pluck('display_name', 'id')->toArray() : []);
            return permissions[permissionId] || 'Unknown Permission';
        },
        
        getPermissionTooltip(roleId, permissionId) {
            const hasPermission = this.permissions[roleId]?.includes(permissionId);
            return hasPermission ? 'İzin verilmiş - Kaldırmak için tıklayın' : 'İzin yok - Vermek için tıklayın';
        },
        
        applyFilters() {
            // Filter implementation
            const rows = document.querySelectorAll('[data-permission-id]');
            rows.forEach(row => {
                let show = true;
                
                if (this.filters.category && !row.dataset.category.includes(this.filters.category)) {
                    show = false;
                }
                
                // Add more filter logic as needed
                
                row.style.display = show ? '' : 'none';
            });
        },
        
        resetFilters() {
            this.filters = { role: '', category: '', status: '' };
            this.applyFilters();
        },
        
        showBulkAssign() {
            this.showBulkModal = true;
            this.bulkTemplate = '';
            this.bulkRoles = [];
            this.bulkPermissions = [];
        },
        
        loadTemplate() {
            if (!this.bulkTemplate) return;
            
            const templates = {
                admin: @json(isset($allPermissions) ? $allPermissions->pluck('id')->toArray() : []),
                manager: [],
                sales: [],
                support: []
            };
            
            // Define template permissions
            const allPermissions = @json(isset($allPermissions) ? $allPermissions->toArray() : []);
            if (allPermissions.length > 0) {
                templates.manager = allPermissions.filter(p => ['user', 'role', 'report'].includes(p.category)).map(p => p.id);
                templates.sales = allPermissions.filter(p => ['lead', 'customer', 'sale'].includes(p.category)).map(p => p.id);
                templates.support = allPermissions.filter(p => ['ticket', 'customer'].includes(p.category)).map(p => p.id);
            }
            
            this.bulkPermissions = templates[this.bulkTemplate] || [];
        },
        
        toggleCategoryPermissions(category) {
            const categoryPermissions = @json(isset($permissionsByCategory) ? $permissionsByCategory->toArray() : []);
            const permissions = categoryPermissions[category] || [];
            const permissionIds = permissions.map(p => p.id);
            
            const allSelected = permissionIds.every(id => this.bulkPermissions.includes(id));
            
            if (allSelected) {
                // Remove all category permissions
                this.bulkPermissions = this.bulkPermissions.filter(id => !permissionIds.includes(id));
            } else {
                // Add all category permissions
                permissionIds.forEach(id => {
                    if (!this.bulkPermissions.includes(id)) {
                        this.bulkPermissions.push(id);
                    }
                });
            }
        },
        
        applyBulkAssignment() {
            if (this.bulkRoles.length === 0 || this.bulkPermissions.length === 0) {
                Swal.fire('Uyarı!', 'Lütfen en az bir rol ve izin seçin.', 'warning');
                return;
            }
            
            // Apply bulk changes
            this.bulkRoles.forEach(roleId => {
                this.bulkPermissions.forEach(permissionId => {
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
                            role: this.getRoleName(roleId),
                            permission: this.getPermissionName(permissionId)
                        };
                        
                        // Remove existing change
                        this.changes = this.changes.filter(c => c.id !== change.id);
                        this.changes.push(change);
                    }
                });
            });
            
            this.showBulkModal = false;
            
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            
            Toast.fire({
                icon: 'success',
                title: `${this.bulkRoles.length} role için ${this.bulkPermissions.length} izin eklendi`
            });
        },
        
        clearChanges() {
            this.changes = [];
            // Reset permissions to original state
            this.permissions = @json(isset($rolePermissions) ? (is_array($rolePermissions) ? $rolePermissions : $rolePermissions->toArray()) : []);
        },
        
        saveChanges() {
            if (this.changes.length === 0) return;
            
            Swal.fire({
                title: 'Değişiklikleri Kaydet',
                text: `${this.changes.length} değişiklik kaydedilecek. Emin misiniz?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Evet, Kaydet',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX call to save changes
                    fetch('{{ route("admin.permissions.bulk-update") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            changes: this.changes
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.changes = [];
                            Swal.fire('Başarılı!', 'Değişiklikler kaydedildi.', 'success');
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
        
        createRoleTemplate() {
            window.location.href = '{{ route("admin.roles.create") }}';
        },
        
        importPermissions() {
            // Import functionality
            Swal.fire('Bilgi', 'İçe aktarma özelliği yakında eklenecek.', 'info');
        },
        
        exportPermissions() {
            window.open('{{ route("admin.permissions.export") }}', '_blank');
        },
        
        syncPermissions() {
            Swal.fire({
                title: 'İzinleri Senkronize Et',
                text: 'Sistem izinleri güncellenecek. Bu işlem birkaç dakika sürebilir.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Senkronize Et',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX call to sync permissions
                    fetch('{{ route("admin.permissions.sync") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Başarılı!', 'İzinler senkronize edildi.', 'success').then(() => {
                                window.location.reload();
                            });
                        }
                    });
                }
            });
        },
        
        showAuditLog() {
            // Show audit log modal or redirect
            window.location.href = '{{ route("admin.permissions.audit-log") }}';
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    
});
</script>
@endpush