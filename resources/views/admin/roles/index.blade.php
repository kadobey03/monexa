@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="rolesManager()">
    
    <!-- Page Header -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="shield" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-admin-900 dark:text-white">Rol Yönetimi</h1>
                    <p class="text-admin-600 dark:text-admin-400">Sistem rollerini ve hiyerarşilerini yönetin</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.roles.hierarchy') }}" 
                   class="inline-flex items-center px-4 py-2 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 text-admin-700 dark:text-admin-300 rounded-xl transition-all duration-200">
                    <i data-lucide="git-branch" class="w-4 h-4 mr-2"></i>
                    Hiyerarşi
                </a>
                
                <a href="{{ route('admin.roles.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl shadow-lg hover:shadow-blue-500/25 transition-all duration-200">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    Yeni Rol
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl p-6 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Toplam Rol</p>
                    <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $stats['total_roles'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="shield" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-2xl p-6 border border-green-200 dark:border-green-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-600 dark:text-green-400 font-medium">Aktif Rol</p>
                    <p class="text-2xl font-bold text-green-700 dark:text-green-300">{{ $stats['active_roles'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 rounded-2xl p-6 border border-amber-200 dark:border-amber-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-amber-600 dark:text-amber-400 font-medium">Admin Rolleri</p>
                    <p class="text-2xl font-bold text-amber-700 dark:text-amber-300">{{ $stats['admin_roles'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-2xl p-6 border border-purple-200 dark:border-purple-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-purple-600 dark:text-purple-400 font-medium">Hiyerarşi Seviyesi</p>
                    <p class="text-2xl font-bold text-purple-700 dark:text-purple-300">{{ $hierarchyLevels->max() + 1 ?? 1 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                    <i data-lucide="layers" class="w-6 h-6 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-admin-900 dark:text-white">Rolleri Filtrele</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-1">Ara</label>
                <input type="text" 
                       x-model="search" 
                       @input="applyFilters()"
                       placeholder="Rol adı veya açıklama..."
                       class="admin-input w-full">
            </div>
            
            <!-- Department Filter -->
            <div>
                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-1">Departman</label>
                <select x-model="filters.department" @change="applyFilters()" class="admin-input w-full">
                    <option value="">Tümü</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}">{{ ucfirst($dept) }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Level Filter -->
            <div>
                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-1">Hiyerarşi Seviyesi</label>
                <select x-model="filters.level" @change="applyFilters()" class="admin-input w-full">
                    <option value="">Tümü</option>
                    @foreach($hierarchyLevels as $level)
                        <option value="{{ $level }}">Seviye {{ $level }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-1">Durum</label>
                <select x-model="filters.status" @change="applyFilters()" class="admin-input w-full">
                    <option value="">Tümü</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Pasif</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Roles List -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
        <div class="p-6 border-b border-admin-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-admin-900 dark:text-white">Roller</h2>
                <div class="flex items-center space-x-3">
                    <!-- View Toggle -->
                    <div class="flex items-center bg-admin-100 dark:bg-admin-700 rounded-xl p-1">
                        <button @click="viewMode = 'list'" 
                                :class="viewMode === 'list' ? 'bg-white dark:bg-admin-600 shadow-sm' : ''"
                                class="px-3 py-1 text-sm font-medium text-admin-700 dark:text-admin-300 rounded-lg transition-all">
                            <i data-lucide="list" class="w-4 h-4 mr-1"></i>
                            Liste
                        </button>
                        <button @click="viewMode = 'tree'" 
                                :class="viewMode === 'tree' ? 'bg-white dark:bg-admin-600 shadow-sm' : ''"
                                class="px-3 py-1 text-sm font-medium text-admin-700 dark:text-admin-300 rounded-lg transition-all">
                            <i data-lucide="git-branch" class="w-4 h-4 mr-1"></i>
                            Ağaç
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <!-- List View -->
            <div x-show="viewMode === 'list'" x-transition class="space-y-4">
                @foreach($roles as $role)
                    <div class="border border-admin-200 dark:border-admin-600 rounded-xl p-6 hover:bg-admin-50 dark:hover:bg-admin-700/20 transition-colors"
                         data-role-id="{{ $role->id }}"
                         data-department="{{ $role->settings['department'] ?? '' }}"
                         data-level="{{ $role->hierarchy_level }}"
                         data-status="{{ $role->is_active ? 'active' : 'inactive' }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <!-- Role Icon -->
                                <div class="w-12 h-12 bg-gradient-to-br from-{{ $role->hierarchy_level % 6 === 0 ? 'blue' : ($role->hierarchy_level % 6 === 1 ? 'green' : ($role->hierarchy_level % 6 === 2 ? 'amber' : ($role->hierarchy_level % 6 === 3 ? 'red' : ($role->hierarchy_level % 6 === 4 ? 'purple' : 'indigo')))) }}-500 to-{{ $role->hierarchy_level % 6 === 0 ? 'blue' : ($role->hierarchy_level % 6 === 1 ? 'green' : ($role->hierarchy_level % 6 === 2 ? 'amber' : ($role->hierarchy_level % 6 === 3 ? 'red' : ($role->hierarchy_level % 6 === 4 ? 'purple' : 'indigo')))) }}-600 rounded-xl flex items-center justify-center">
                                    <i data-lucide="shield" class="w-6 h-6 text-white"></i>
                                </div>
                                
                                <!-- Role Info -->
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <h3 class="text-lg font-semibold text-admin-900 dark:text-white">{{ $role->display_name }}</h3>
                                        <span class="px-2 py-1 text-xs font-medium rounded-lg
                                            {{ $role->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' }}">
                                            {{ $role->is_active ? 'Aktif' : 'Pasif' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm text-admin-600 dark:text-admin-400 mt-1">
                                        <span>Seviye {{ $role->hierarchy_level }}</span>
                                        <span>•</span>
                                        <span>{{ $role->admins_count }} admin</span>
                                        <span>•</span>
                                        <span>{{ $role->active_permissions_count }} izin</span>
                                        @if($role->parentRole)
                                            <span>•</span>
                                            <span>Üst: {{ $role->parentRole->display_name }}</span>
                                        @endif
                                        @if($role->settings['department'] ?? false)
                                            <span>•</span>
                                            <span>{{ ucfirst($role->settings['department']) }}</span>
                                        @endif
                                    </div>
                                    @if($role->description)
                                        <p class="text-sm text-admin-600 dark:text-admin-400 mt-2">{{ $role->description }}</p>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.roles.show', $role) }}" 
                                   class="p-2 text-admin-600 dark:text-admin-400 hover:bg-admin-100 dark:hover:bg-admin-700 rounded-lg transition-colors">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('admin.roles.edit', $role) }}" 
                                   class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <button @click="deleteRole({{ $role->id }})" 
                                        class="p-2 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Child Roles -->
                        @if($role->childRoles->count() > 0)
                            <div class="mt-4 pl-4 border-l-2 border-admin-200 dark:border-admin-600">
                                <p class="text-sm text-admin-600 dark:text-admin-400 mb-2">Alt Roller:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($role->childRoles as $childRole)
                                        <a href="{{ route('admin.roles.show', $childRole) }}" 
                                           class="px-3 py-1 bg-admin-100 dark:bg-admin-700 text-admin-700 dark:text-admin-300 rounded-lg text-sm hover:bg-admin-200 dark:hover:bg-admin-600 transition-colors">
                                            {{ $childRole->display_name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <!-- Tree View -->
            <div x-show="viewMode === 'tree'" x-transition class="space-y-4">
                <div class="bg-admin-50 dark:bg-admin-700/20 rounded-xl p-4">
                    <h3 class="font-medium text-admin-900 dark:text-white mb-4">Rol Hiyerarşisi</h3>
                    <div id="role-tree" class="role-hierarchy">
                        @include('admin.roles.partials.tree', ['roles' => $roleTree, 'level' => 0])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function rolesManager() {
    return {
        viewMode: 'list',
        search: '',
        filters: {
            department: '',
            level: '',
            status: ''
        },
        
        init() {
            this.$nextTick(() => {
                lucide.createIcons();
            });
        },
        
        applyFilters() {
            const roles = document.querySelectorAll('[data-role-id]');
            
            roles.forEach(role => {
                let show = true;
                
                // Search filter
                if (this.search) {
                    const text = role.textContent.toLowerCase();
                    if (!text.includes(this.search.toLowerCase())) {
                        show = false;
                    }
                }
                
                // Department filter
                if (this.filters.department && role.dataset.department !== this.filters.department) {
                    show = false;
                }
                
                // Level filter
                if (this.filters.level && role.dataset.level !== this.filters.level) {
                    show = false;
                }
                
                // Status filter
                if (this.filters.status && role.dataset.status !== this.filters.status) {
                    show = false;
                }
                
                role.style.display = show ? '' : 'none';
            });
        },
        
        deleteRole(roleId) {
            Swal.fire({
                title: 'Rolü Sil',
                text: 'Bu rolü silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Evet, Sil',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('/admin/dashboard/roles') }}/${roleId}`;
                    
                    // Add CSRF token
                    const csrfField = document.createElement('input');
                    csrfField.type = 'hidden';
                    csrfField.name = '_token';
                    csrfField.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    form.appendChild(csrfField);
                    
                    // Add DELETE method
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
});
</script>
@endpush