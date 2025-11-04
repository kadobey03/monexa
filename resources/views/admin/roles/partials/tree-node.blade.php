@php
    $hasChildren = $role->childRoles->count() > 0;
    $indentClass = 'ml-' . ($level * 6);
@endphp

<div class="role-tree-node {{ $indentClass }}" 
     data-role-id="{{ $role->id }}" 
     data-level="{{ $level }}">
    
    <div class="flex items-center space-x-3 p-4 bg-white dark:bg-admin-800 border border-admin-200 dark:border-admin-700 rounded-xl mb-2 hover:shadow-md dark:hover:shadow-glass-dark transition-all duration-200">
        
        <!-- Expand/Collapse Toggle -->
        <div class="flex items-center justify-center w-8 h-8">
            @if($hasChildren)
                <button @click="toggleNode({{ $role->id }})" 
                        class="w-6 h-6 flex items-center justify-center rounded-full border border-admin-300 dark:border-admin-600 hover:bg-admin-100 dark:hover:bg-admin-700 transition-colors">
                    <x-heroicon name="chevron-right"
                       class="w-4 h-4 text-admin-600 dark:text-admin-400 transition-transform duration-200"
                       :class="{ 'rotate-90': isExpanded({{ $role->id }}) }" />
                </button>
            @else
                <div class="w-6 h-6 flex items-center justify-center">
                    <div class="w-2 h-2 bg-admin-300 dark:bg-admin-600 rounded-full"></div>
                </div>
            @endif
        </div>
        
        <!-- Role Icon -->
        <div class="w-10 h-10 bg-gradient-to-br 
            {{ $role->hierarchy_level == 0 ? 'from-red-500 to-red-600' : '' }}
            {{ $role->hierarchy_level == 1 ? 'from-blue-500 to-blue-600' : '' }}
            {{ $role->hierarchy_level == 2 ? 'from-green-500 to-green-600' : '' }}
            {{ $role->hierarchy_level == 3 ? 'from-yellow-500 to-yellow-600' : '' }}
            {{ $role->hierarchy_level >= 4 ? 'from-purple-500 to-purple-600' : '' }}
            rounded-lg flex items-center justify-center">
            <x-heroicon name="shield-check" class="w-5 h-5 text-white" />
        </div>
        
        <!-- Role Information -->
        <div class="flex-1">
            <div class="flex items-center space-x-3 mb-1">
                <h4 class="font-semibold text-admin-900 dark:text-white">{{ $role->display_name }}</h4>
                
                <!-- Status Badge -->
                @if($role->is_active)
                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-medium rounded-full">
                        Aktif
                    </span>
                @else
                    <span class="px-2 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-xs font-medium rounded-full">
                        Pasif
                    </span>
                @endif
                
                <!-- Level Badge -->
                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-medium rounded-full">
                    L{{ $role->hierarchy_level }}
                </span>
            </div>
            
            <div class="flex items-center space-x-4 text-sm text-admin-600 dark:text-admin-400">
                <span class="flex items-center">
                    <x-heroicon name="users" class="w-4 h-4 mr-1" />
                    {{ $role->admins->count() }} admin
                </span>
                
                <span class="flex items-center">
                    <x-heroicon name="shield-check" class="w-4 h-4 mr-1" />
                    {{ $role->permissions->where('pivot.is_granted', true)->count() }} izin
                </span>
                
                @if($hasChildren)
                    <span class="flex items-center">
                        <x-heroicon name="git-branch" class="w-4 h-4 mr-1" />
                        {{ $role->childRoles->count() }} alt rol
                    </span>
                @endif
                
                @if($role->settings && isset($role->settings['department']))
                    <span class="flex items-center">
                        <x-heroicon name="building" class="w-4 h-4 mr-1" />
                        {{ $role->settings['department'] }}
                    </span>
                @endif
            </div>
            
            @if($role->description)
                <p class="text-sm text-admin-500 dark:text-admin-400 mt-1">{{ Str::limit($role->description, 100) }}</p>
            @endif
        </div>
        
        <!-- Quick Actions -->
        <div class="flex items-center space-x-2">
            <!-- View Button -->
            <a href="{{ route('admin.roles.show', $role) }}" 
               class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors" 
               title="Detayları Görüntüle">
                <x-heroicon name="eye" class="w-4 h-4" />
            </a>
            
            <!-- Edit Button -->
            <a href="{{ route('admin.roles.edit', $role) }}" 
               class="w-8 h-8 flex items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-900/50 transition-colors" 
               title="Düzenle">
                <x-heroicon name="edit-3" class="w-4 h-4" />
            </a>
            
            <!-- Permissions Button -->
            <a href="{{ route('admin.permissions.role-permissions', $role) }}"
               class="w-8 h-8 flex items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors" 
               title="İzinleri Yönet">
                <x-heroicon name="shield-check" class="w-4 h-4" />
            </a>
            
            <!-- Status Toggle -->
            @if($role->is_active)
                <button onclick="toggleRoleStatus({{ $role->id }}, false)" 
                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors" 
                        title="Pasif Yap">
                    <x-heroicon name="user-minus" class="w-4 h-4" />
                </button>
            @else
                <button onclick="toggleRoleStatus({{ $role->id }}, true)" 
                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors" 
                        title="Aktif Yap">
                    <x-heroicon name="user-check" class="w-4 h-4" />
                </button>
            @endif
            
            <!-- Delete Button (only for non-system roles) -->
            @if(!$role->is_system_role && $role->admins->count() == 0)
                <button onclick="deleteRole({{ $role->id }})" 
                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors" 
                        title="Sil">
                    <x-heroicon name="trash-2" class="w-4 h-4" />
                </button>
            @endif
        </div>
    </div>
    
    <!-- Child Roles -->
    @if($hasChildren)
        <div class="child-roles" 
             x-show="isExpanded({{ $role->id }})" 
             x-transition:enter="transition ease-out duration-200" 
             x-transition:enter-start="opacity-0 transform -translate-y-2" 
             x-transition:enter-end="opacity-100 transform translate-y-0" 
             x-transition:leave="transition ease-in duration-150" 
             x-transition:leave-start="opacity-100 transform translate-y-0" 
             x-transition:leave-end="opacity-0 transform -translate-y-2">
            
            <!-- Connection Lines -->
            <div class="relative">
                <div class="absolute left-8 top-0 w-px h-4 bg-admin-300 dark:bg-admin-600"></div>
            </div>
            
            @foreach($role->childRoles as $childRole)
                <div class="relative">
                    <!-- Horizontal line -->
                    <div class="absolute left-8 top-6 w-6 h-px bg-admin-300 dark:bg-admin-600"></div>
                    <!-- Vertical line -->
                    @if(!$loop->last)
                        <div class="absolute left-8 top-6 w-px h-full bg-admin-300 dark:bg-admin-600"></div>
                    @endif
                    
                    @include('admin.roles.partials.tree-node', ['role' => $childRole, 'level' => $level + 1])
                </div>
            @endforeach
        </div>
    @endif
</div>

@if($level == 0)
    @push('scripts')
    <script>
    function toggleRoleStatus(roleId, status) {
        Swal.fire({
            title: status ? 'Rolü Aktif Yap?' : 'Rolü Pasif Yap?',
            text: status ? 
                "Bu rol aktif hale getirilecek ve adminler bu rolün izinlerini kullanabilecek." : 
                "Bu rol pasif hale getirilecek ve adminler geçici olarak kısıtlanacak.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: status ? '#10b981' : '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: status ? 'Evet, Aktif Yap' : 'Evet, Pasif Yap',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/dashboard/roles/${roleId}/${status ? 'activate' : 'deactivate'}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Başarılı!',
                            text: data.message,
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Bir hata oluştu');
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Hata!',
                        text: error.message,
                        icon: 'error'
                    });
                });
            }
        });
    }
    
    function deleteRole(roleId) {
        Swal.fire({
            title: 'Rolü Sil?',
            text: "Bu işlem geri alınamaz. Rol kalıcı olarak silinecek.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Evet, Sil',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/dashboard/roles/${roleId}`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    </script>
    @endpush
@endif