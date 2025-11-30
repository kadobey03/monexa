@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-sm dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl flex items-center justify-center">
                    <x-heroicon name="tag" class="w-8 h-8 text-white" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-admin-900 dark:text-admin-100">{{ __('admin.leads.status_management') }}</h1>
                    <p class="text-admin-600 dark:text-admin-400">{{ __('admin.leads.status_management_desc') }}</p>
                </div>
            </div>
            <button type="button"
                    class="flex items-center px-6 py-3 bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 text-white font-medium rounded-xl transition-all duration-200 hover:shadow-lg hover:scale-105"
                    onclick="openCreateModal()">
                <x-heroicon name="plus" class="w-5 h-5 mr-2" />
                {{ __('admin.leads.add_new_status') }}
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-admin-800 rounded-xl shadow-sm dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30">
                    <x-heroicon name="list-bullet" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.leads.total_statuses') }}</p>
                    <p class="text-2xl font-bold text-admin-900 dark:text-admin-100">{{ $statuses->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-admin-800 rounded-xl shadow-sm dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/30">
                    <x-heroicon name="check-circle" class="w-6 h-6 text-green-600 dark:text-green-400" />
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.leads.active_statuses') }}</p>
                    <p class="text-2xl font-bold text-admin-900 dark:text-admin-100">{{ $statuses->where('is_active', true)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-admin-800 rounded-xl shadow-sm dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                    <x-heroicon name="pause-circle" class="w-6 h-6 text-yellow-600 dark:text-yellow-400" />
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.leads.inactive_statuses') }}</p>
                    <p class="text-2xl font-bold text-admin-900 dark:text-admin-100">{{ $statuses->where('is_active', false)->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-admin-800 rounded-xl shadow-sm dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/30">
                    <x-heroicon name="users" class="w-6 h-6 text-purple-600 dark:text-purple-400" />
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.leads.total_leads') }}</p>
                    <p class="text-2xl font-bold text-admin-900 dark:text-admin-100">{{ $statuses->sum('user_count') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Status List -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-sm dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
        <div class="px-6 py-4 border-b border-admin-200 dark:border-admin-700">
            <h2 class="text-lg font-semibold text-admin-900 dark:text-admin-100 flex items-center">
                <x-heroicon name="list-bullet" class="w-5 h-5 mr-2" />
                {{ __('admin.leads.status_list') }}
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-admin-200 dark:divide-admin-700">
                <thead class="bg-admin-50 dark:bg-admin-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">
                            <x-heroicon name="arrows-up-down" class="w-4 h-4" />
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.leads.status') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.leads.display_name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.leads.description') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.leads.user_count') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.leads.sort_order') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.leads.status_state') }}</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-admin-500 dark:text-admin-400 uppercase tracking-wider">{{ __('admin.users.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-admin-800 divide-y divide-admin-200 dark:divide-admin-700" id="sortable-statuses">
                    @foreach($statuses as $status)
                    <tr data-id="{{ $status->id }}" class="hover:bg-admin-50 dark:hover:bg-admin-700/50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <x-heroicon name="bars-3" class="w-4 h-4 text-admin-400 cursor-move sortable-handle" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $status->color }};"></div>
                                <code class="px-2 py-1 text-xs bg-admin-100 dark:bg-admin-700 text-admin-800 dark:text-admin-200 rounded">{{ $status->name }}</code>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-admin-900 dark:text-admin-100">{{ $status->display_name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-admin-500 dark:text-admin-400 max-w-xs truncate">
                                {{ Str::limit($status->description, 50) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($status->user_count > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    {{ $status->user_count }} {{ __('admin.leads.lead') }}
                                </span>
                            @else
                                <span class="text-sm text-admin-400">0 {{ __('admin.leads.lead') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-admin-100 text-admin-800 dark:bg-admin-700 dark:text-admin-200">
                                {{ $status->sort_order }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($status->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    {{ __('admin.leads.active') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                    {{ __('admin.leads.inactive') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <button type="button" 
                                        class="inline-flex items-center p-2 text-sm font-medium text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 transition-colors duration-150"
                                        onclick="editStatus({{ $status->id }}, '{{ $status->name }}', '{{ $status->display_name }}', '{{ $status->color }}', '{{ $status->description }}', {{ $status->sort_order }}, {{ $status->is_active ? 'true' : 'false' }})">
                                    <x-heroicon name="pencil" class="w-4 h-4" />
                                </button>
                                
                                <form method="POST" action="{{ route('admin.lead-statuses.toggle', $status) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="inline-flex items-center p-2 text-sm font-medium {{ $status->is_active ? 'text-yellow-600 bg-yellow-100 hover:bg-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400 dark:hover:bg-yellow-900/50' : 'text-green-600 bg-green-100 hover:bg-green-200 dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50' }} rounded-lg transition-colors duration-150">
                                        @if($status->is_active)
                                            <x-heroicon name="pause" class="w-4 h-4" />
                                        @else
                                            <x-heroicon name="play" class="w-4 h-4" />
                                        @endif
                                    </button>
                                </form>

                                @if(!in_array($status->name, ['new', 'converted', 'lost']) && $status->user_count == 0)
                                <form method="POST" action="{{ route('admin.lead-statuses.destroy', $status) }}" 
                                      onsubmit="return confirm('{{ __('admin.leads.confirm_delete_status') }}')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center p-2 text-sm font-medium text-red-600 bg-red-100 rounded-lg hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50 transition-colors duration-150">
                                        <x-heroicon name="trash" class="w-4 h-4" />
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Status Modal -->
<div id="createStatusModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-admin-500 bg-opacity-75 transition-opacity" onclick="closeCreateModal()"></div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-gradient-to-r from-cyan-600 to-cyan-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-white flex items-center">
                        <x-heroicon name="plus" class="w-5 h-5 mr-2" />
                        {{ __('admin.leads.new_lead_status') }}
                    </h3>
                    <button type="button" class="text-white hover:text-admin-200 transition-colors duration-150" onclick="closeCreateModal()">
                        <x-heroicon name="x-mark" class="w-6 h-6" />
                    </button>
                </div>
            </div>
            
            <form method="POST" action="{{ route('admin.lead-statuses.store') }}" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.leads.status_name_code') }}</label>
                        <input type="text" name="name" class="w-full px-3 py-2 border border-admin-300 dark:border-admin-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 dark:bg-admin-700 dark:text-admin-100" placeholder="{{ __('admin.leads.status_name_placeholder') }}" required>
                        <p class="mt-1 text-xs text-admin-500 dark:text-admin-400">{{ __('admin.leads.only_lowercase_underscore') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.leads.display_name') }}</label>
                        <input type="text" name="display_name" class="w-full px-3 py-2 border border-admin-300 dark:border-admin-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 dark:bg-admin-700 dark:text-admin-100" placeholder="{{ __('admin.leads.display_name_placeholder') }}" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.leads.color') }}</label>
                        <input type="color" name="color" class="w-full h-10 border border-admin-300 dark:border-admin-600 rounded-lg cursor-pointer" value="#6c757d">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.leads.sort_order') }}</label>
                        <input type="number" name="sort_order" class="w-full px-3 py-2 border border-admin-300 dark:border-admin-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 dark:bg-admin-700 dark:text-admin-100" value="{{ $statuses->max('sort_order') + 1 }}" min="1">
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.leads.description') }}</label>
                    <textarea name="description" rows="3" class="w-full px-3 py-2 border border-admin-300 dark:border-admin-600 rounded-lg focus:ring-cyan-500 focus:border-cyan-500 dark:bg-admin-700 dark:text-admin-100" placeholder="{{ __('admin.leads.description_placeholder') }}"></textarea>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" class="px-4 py-2 text-sm font-medium text-admin-700 dark:text-admin-300 bg-admin-100 dark:bg-admin-700 rounded-lg hover:bg-admin-200 dark:hover:bg-admin-600 transition-colors duration-150" onclick="closeCreateModal()">
                        {{ __('common.cancel') }}
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 rounded-lg transition-all duration-150">
                        {{ __('common.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Status Modal -->
<div id="editStatusModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-admin-500 bg-opacity-75 transition-opacity" onclick="closeEditModal()"></div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-white flex items-center">
                        <x-heroicon name="pencil" class="w-5 h-5 mr-2" />
                        {{ __('admin.leads.edit_lead_status') }}
                    </h3>
                    <button type="button" class="text-white hover:text-admin-200 transition-colors duration-150" onclick="closeEditModal()">
                        <x-heroicon name="x-mark" class="w-6 h-6" />
                    </button>
                </div>
            </div>
            
            <form method="POST" id="editStatusForm" class="p-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.leads.status_name_code') }}</label>
                        <input type="text" name="name" id="edit_name" class="w-full px-3 py-2 border border-admin-300 dark:border-admin-600 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 dark:bg-admin-700 dark:text-admin-100" required>
                        <p class="mt-1 text-xs text-admin-500 dark:text-admin-400">{{ __('admin.leads.only_lowercase_underscore') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.leads.display_name') }}</label>
                        <input type="text" name="display_name" id="edit_display_name" class="w-full px-3 py-2 border border-admin-300 dark:border-admin-600 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 dark:bg-admin-700 dark:text-admin-100" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.leads.color') }}</label>
                        <input type="color" name="color" id="edit_color" class="w-full h-10 border border-admin-300 dark:border-admin-600 rounded-lg cursor-pointer">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.leads.sort_order') }}</label>
                        <input type="number" name="sort_order" id="edit_sort_order" class="w-full px-3 py-2 border border-admin-300 dark:border-admin-600 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 dark:bg-admin-700 dark:text-admin-100" min="1">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.leads.status_state') }}</label>
                        <select name="is_active" id="edit_is_active" class="w-full px-3 py-2 border border-admin-300 dark:border-admin-600 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 dark:bg-admin-700 dark:text-admin-100">
                            <option value="1">{{ __('admin.leads.active') }}</option>
                            <option value="0">{{ __('admin.leads.inactive') }}</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">{{ __('admin.leads.description') }}</label>
                    <textarea name="description" id="edit_description" rows="3" class="w-full px-3 py-2 border border-admin-300 dark:border-admin-600 rounded-lg focus:ring-yellow-500 focus:border-yellow-500 dark:bg-admin-700 dark:text-admin-100"></textarea>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" class="px-4 py-2 text-sm font-medium text-admin-700 dark:text-admin-300 bg-admin-100 dark:bg-admin-700 rounded-lg hover:bg-admin-200 dark:hover:bg-admin-600 transition-colors duration-150" onclick="closeEditModal()">
                        {{ __('common.cancel') }}
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 rounded-lg transition-all duration-150">
                        {{ __('common.update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Modal Functions
function openCreateModal() {
    document.getElementById('createStatusModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCreateModal() {
    document.getElementById('createStatusModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function openEditModal() {
    document.getElementById('editStatusModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('editStatusModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function editStatus(id, name, displayName, color, description, sortOrder, isActive) {
    document.getElementById('editStatusForm').action = `/admin/dashboard/lead-statuses/${id}`;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_display_name').value = displayName;
    document.getElementById('edit_color').value = color;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_sort_order').value = sortOrder;
    document.getElementById('edit_is_active').value = isActive ? '1' : '0';
    openEditModal();
}

// Close modal when clicking outside
window.onclick = function(event) {
    const createModal = document.getElementById('createStatusModal');
    const editModal = document.getElementById('editStatusModal');
    
    if (event.target === createModal) {
        closeCreateModal();
    }
    if (event.target === editModal) {
        closeEditModal();
    }
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeCreateModal();
        closeEditModal();
    }
});
</script>
@endsection