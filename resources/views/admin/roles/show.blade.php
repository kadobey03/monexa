@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="roleShowManager()">
    
    <!-- Page Header -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <x-heroicon name="shield-check" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-admin-900 dark:text-white">{{ $role->display_name }}</h1>
                    <p class="text-admin-600 dark:text-admin-400">{{ __('admin.roles.show.description') }}</p>
                </div>
                <div class="flex items-center space-x-2">
                    @if($role->is_active)
                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full text-sm font-medium">
                            <x-heroicon name="check-circle" class="w-4 h-4 inline mr-1" />
                            {{ __('admin.roles.show.active') }}
                        </span>
                    @else
                        <span class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-full text-sm font-medium">
                            <x-heroicon name="x-circle" class="w-4 h-4 inline mr-1" />
                            {{ __('admin.roles.show.inactive') }}
                        </span>
                    @endif
                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm font-medium">
                        {{ __('admin.roles.show.level') }} {{ $role->hierarchy_level }}
                    </span>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.roles.edit', $role) }}" 
                   class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl transition-all duration-200">
                    <x-heroicon name="edit-3" class="w-4 h-4 mr-2" />
                    {{ __('admin.roles.show.edit') }}
                </a>
                <a href="{{ route('admin.roles.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 text-admin-700 dark:text-admin-300 rounded-xl transition-all duration-200">
                    <x-heroicon name="arrow-left" class="w-4 h-4 mr-2" />
                    {{ __('admin.roles.show.back') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.roles.show.total_admins') }}</p>
                    <p class="text-2xl font-bold text-admin-900 dark:text-white">{{ $statistics['total_admins'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <x-heroicon name="users" class="w-6 h-6 text-white" />
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center">
                    <span class="text-sm text-green-600 dark:text-green-400 font-medium">{{ $statistics['active_admins'] }} {{ __('admin.roles.show.active') }}</span>
                    <span class="text-sm text-admin-500 dark:text-admin-400 ml-2">{{ $statistics['inactive_admins'] }} {{ __('admin.roles.show.inactive') }}</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.roles.show.permission_count') }}</p>
                    <p class="text-2xl font-bold text-admin-900 dark:text-white">{{ $statistics['total_permissions'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <x-heroicon name="shield-check" class="w-6 h-6 text-white" />
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center">
                    <span class="text-sm text-green-600 dark:text-green-400 font-medium">{{ $statistics['granted_permissions'] }} {{ __('admin.roles.show.granted') }}</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.roles.show.child_roles') }}</p>
                    <p class="text-2xl font-bold text-admin-900 dark:text-white">{{ $statistics['child_roles'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <x-heroicon name="git-branch" class="w-6 h-6 text-white" />
                </div>
            </div>
            <div class="mt-4">
                @if($role->childRoles->count() > 0)
                    <div class="text-sm text-admin-600 dark:text-admin-400">
                        {{ $role->childRoles->pluck('display_name')->take(2)->implode(', ') }}
                        @if($role->childRoles->count() > 2)
                            {{ __('admin.roles.show.and_others', ['count' => $role->childRoles->count() - 2]) }}
                        @endif
                    </div>
                @else
                    <span class="text-sm text-admin-500 dark:text-admin-400">{{ __('admin.roles.show.no_child_roles') }}</span>
                @endif
            </div>
        </div>
        
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.roles.show.created') }}</p>
                    <p class="text-2xl font-bold text-admin-900 dark:text-white">{{ $role->created_at->diffInDays() }}g</p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center">
                    <x-heroicon name="calendar-days" class="w-6 h-6 text-white" />
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-admin-600 dark:text-admin-400">{{ $role->created_at->format('d.m.Y H:i') }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Basic Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Role Details -->
            <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
                <h2 class="text-lg font-semibold text-admin-900 dark:text-white mb-6">{{ __('admin.roles.show.role_information') }}</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.roles.show.role_name') }}</label>
                        <p class="mt-1 text-admin-900 dark:text-white font-mono bg-admin-50 dark:bg-admin-700/30 px-3 py-2 rounded-lg">{{ $role->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.roles.show.display_name') }}</label>
                        <p class="mt-1 text-admin-900 dark:text-white">{{ $role->display_name }}</p>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.roles.show.description_label') }}</label>
                        <p class="mt-1 text-admin-700 dark:text-admin-300">
                            {{ $role->description ?: __('admin.roles.show.no_description') }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.roles.show.hierarchy_level') }}</label>
                        <p class="mt-1 text-admin-900 dark:text-white">{{ $role->hierarchy_level }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.roles.show.department') }}</label>
                        <p class="mt-1 text-admin-900 dark:text-white">
                            {{ $role->settings['department'] ?? __('admin.roles.show.not_specified') }}
                        </p>
                    </div>
                    
                    @if($role->parentRole)
                        <div>
                            <label class="block text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.roles.show.parent_role') }}</label>
                            <a href="{{ route('admin.roles.show', $role->parentRole) }}" 
                               class="mt-1 inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                <x-heroicon name="external-link" class="w-4 h-4 mr-1" />
                                {{ $role->parentRole->display_name }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Permissions -->
            <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
                <div class="p-6 border-b border-admin-200 dark:border-admin-600">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-admin-900 dark:text-white">{{ __('admin.roles.show.permissions') }}</h2>
                        <div class="flex items-center space-x-2">
                            <button @click="showAllPermissions = !showAllPermissions" 
                                    class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                <span x-text="showAllPermissions ? '{{ __('admin.roles.show.only_granted_permissions') }}' : '{{ __('admin.roles.show.show_all_permissions') }}'"></span>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    @if($role->permissions->count() > 0)
                        <div class="space-y-4">
                            @foreach($permissionsByCategory as $category => $permissions)
                                <div x-show="showAllPermissions || {{ $permissions->where('pivot.is_granted', true)->count() }} > 0" 
                                     class="border border-admin-200 dark:border-admin-600 rounded-xl">
                                    <div class="p-4 bg-admin-50 dark:bg-admin-700/20 rounded-t-xl border-b border-admin-200 dark:border-admin-600">
                                        <h3 class="font-medium text-admin-900 dark:text-white">
                                            {{ ucfirst(str_replace('_', ' ', $category)) }}
                                            <span class="ml-2 px-2 py-1 text-xs bg-admin-200 dark:bg-admin-600 text-admin-700 dark:text-admin-300 rounded">
                                                {{ $permissions->where('pivot.is_granted', true)->count() }}/{{ $permissions->count() }}
                                            </span>
                                        </h3>
                                    </div>
                                    <div class="p-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            @foreach($permissions as $permission)
                                                @if($showAllPermissions || $permission->pivot->is_granted)
                                                    <div class="flex items-center justify-between p-3 border border-admin-200 dark:border-admin-600 rounded-lg
                                                        {{ $permission->pivot->is_granted ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800' : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800' }}">
                                                        <div class="flex-1">
                                                            <p class="font-medium text-admin-900 dark:text-white text-sm">
                                                                {{ $permission->display_name }}
                                                            </p>
                                                            @if($permission->description)
                                                                <p class="text-xs text-admin-600 dark:text-admin-400 mt-1">
                                                                    {{ $permission->description }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <div class="flex items-center space-x-2">
                                                            @if($permission->pivot->is_granted)
                                                                <x-heroicon name="check-circle" class="w-5 h-5 text-green-600 dark:text-green-400" />
                                                            @else
                                                                <x-heroicon name="x-circle" class="w-5 h-5 text-red-600 dark:text-red-400" />
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <x-heroicon name="shield-off" class="w-16 h-16 text-admin-400 dark:text-admin-500 mx-auto mb-4" />
                            <p class="text-admin-600 dark:text-admin-400">{{ __('admin.roles.show.no_permissions_assigned') }}</p>
                            <a href="{{ route('admin.roles.edit', $role) }}" 
                               class="mt-4 inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                                <x-heroicon name="plus" class="w-4 h-4 mr-2" />
                                {{ __('admin.roles.show.add_permission') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Hierarchy -->
            <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
                <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">{{ __('admin.roles.show.hierarchy') }}</h3>
                
                @if($role->parentRole || $role->childRoles->count() > 0)
                    <div class="space-y-4">
                        @if($role->parentRole)
                            <div>
                                <p class="text-sm text-admin-600 dark:text-admin-400 mb-2">{{ __('admin.roles.show.parent_role') }}</p>
                                <a href="{{ route('admin.roles.show', $role->parentRole) }}" 
                                   class="flex items-center p-3 border border-admin-200 dark:border-admin-600 rounded-lg hover:bg-admin-50 dark:hover:bg-admin-700/30 transition-colors">
                                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-3">
                                        <x-heroicon name="arrow-up" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                                    </div>
                                    <div>
                                        <p class="font-medium text-admin-900 dark:text-white">{{ $role->parentRole->display_name }}</p>
                                        <p class="text-xs text-admin-600 dark:text-admin-400">{{ __('admin.roles.show.level') }} {{ $role->parentRole->hierarchy_level }}</p>
                                    </div>
                                </a>
                            </div>
                        @endif
                        
                        @if($role->childRoles->count() > 0)
                            <div>
                                <p class="text-sm text-admin-600 dark:text-admin-400 mb-2">{{ __('admin.roles.show.child_roles') }} ({{ $role->childRoles->count() }})</p>
                                <div class="space-y-2">
                                    @foreach($role->childRoles->take(5) as $childRole)
                                        <a href="{{ route('admin.roles.show', $childRole) }}" 
                                           class="flex items-center p-3 border border-admin-200 dark:border-admin-600 rounded-lg hover:bg-admin-50 dark:hover:bg-admin-700/30 transition-colors">
                                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-3">
                                                <x-heroicon name="arrow-down" class="w-4 h-4 text-green-600 dark:text-green-400" />
                                            </div>
                                            <div>
                                                <p class="font-medium text-admin-900 dark:text-white">{{ $childRole->display_name }}</p>
                                                <p class="text-xs text-admin-600 dark:text-admin-400">{{ $childRole->admins->count() }} {{ __('admin.roles.show.admins') }}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                    @if($role->childRoles->count() > 5)
                                        <p class="text-sm text-admin-600 dark:text-admin-400 text-center py-2">
                                            {{ __('admin.roles.show.and_other_child_roles', ['count' => $role->childRoles->count() - 5]) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-4">
                        <x-heroicon name="git-branch-plus" class="w-12 h-12 text-admin-400 dark:text-admin-500 mx-auto mb-2" />
                        <p class="text-sm text-admin-600 dark:text-admin-400">{{ __('admin.roles.show.no_hierarchy_connection') }}</p>
                    </div>
                @endif
            </div>

            <!-- Recent Admins -->
            <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-admin-900 dark:text-white">{{ __('admin.roles.show.admins_in_role') }}</h3>
                    @if($role->admins->count() > 5)
                        <a href="{{ route('admin.managers.index', ['role' => $role->id]) }}" 
                           class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                            {{ __('admin.roles.show.view_all') }}
                        </a>
                    @endif
                </div>
                
                @if($role->admins->count() > 0)
                    <div class="space-y-3">
                        @foreach($role->admins->take(5) as $admin)
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-admin-900 dark:text-white">{{ $admin->name }}</p>
                                    <p class="text-xs text-admin-600 dark:text-admin-400">{{ $admin->email }}</p>
                                </div>
                                <div class="text-right">
                                    @if($admin->is_active)
                                        <span class="w-2 h-2 bg-green-500 rounded-full inline-block"></span>
                                    @else
                                        <span class="w-2 h-2 bg-red-500 rounded-full inline-block"></span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <x-heroicon name="user-minus" class="w-12 h-12 text-admin-400 dark:text-admin-500 mx-auto mb-2" />
                        <p class="text-sm text-admin-600 dark:text-admin-400">{{ __('admin.roles.show.no_admins_assigned') }}</p>
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
                <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">{{ __('admin.roles.show.quick_actions') }}</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.roles.edit', $role) }}" 
                       class="w-full flex items-center px-4 py-3 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 rounded-lg hover:bg-amber-100 dark:hover:bg-amber-900/30 transition-colors">
                        <x-heroicon name="edit-3" class="w-5 h-5 mr-3" />
                        {{ __('admin.roles.show.edit_role') }}
                    </a>
                    
                    <a href="{{ route('admin.permissions.role', $role) }}" 
                       class="w-full flex items-center px-4 py-3 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                        <x-heroicon name="shield-check" class="w-5 h-5 mr-3" />
                        {{ __('admin.roles.show.manage_permissions') }}
                    </a>
                    
                    <a href="{{ route('admin.managers.create', ['role' => $role->id]) }}" 
                       class="w-full flex items-center px-4 py-3 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                        <x-heroicon name="user-plus" class="w-5 h-5 mr-3" />
                        {{ __('admin.roles.show.add_admin') }}
                    </a>
                    
                    @if(!$role->is_system_role)
                        <button @click="confirmDelete()" 
                                class="w-full flex items-center px-4 py-3 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">
                            <x-heroicon name="trash-2" class="w-5 h-5 mr-3" />
                            {{ __('admin.roles.show.delete_role') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function roleShowManager() {
    return {
        showAllPermissions: false,
        
        init() {
            this.$nextTick(() => {
                
            });
        },
        
        confirmDelete() {
            Swal.fire({
                title: '{{ __('admin.roles.show.delete_role_title') }}',
                text: "{{ __('admin.roles.show.delete_role_warning') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '{{ __('admin.roles.show.yes_delete') }}',
                cancelButtonText: '{{ __('admin.roles.show.cancel') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('admin.roles.destroy', $role) }}";
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = "{{ csrf_token() }}";
                    
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
    }
}

document.addEventListener('DOMContentLoaded', function() {
    
});
</script>
@endpush