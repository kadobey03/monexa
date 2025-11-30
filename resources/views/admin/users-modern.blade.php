@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    
    <!-- Page Header -->
    <div class="flex flex-col items-start justify-between space-y-4 sm:flex-row sm:items-center sm:space-y-0">
        <div>
            <h1 class="text-3xl font-bold text-admin-900 dark:text-admin-100">{{ __('admin.users.user_management') }}</h1>
            <p class="mt-2 text-admin-600 dark:text-admin-400">{{ __('admin.users.view_and_manage_platform_users') }}</p>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center space-x-3">
            <button class="admin-btn admin-btn-secondary flex items-center space-x-2" onclick="exportUsers()">
                <x-heroicon name="arrow-down-tray" class="h-4 w-4" />
                <span>{{ __('admin.actions.export') }}</span>
            </button>
            
            <button class="admin-btn admin-btn-primary flex items-center space-x-2" onclick="openAddUserModal()">
                <x-heroicon name="plus" class="h-4 w-4" />
                <span>{{ __('admin.users.new_user') }}</span>
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="admin-card p-6">
            <div class="flex items-center">
                <div class="rounded-2xl bg-blue-100 dark:bg-blue-900/20 p-3">
                    <x-heroicon name="users" class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.users.total_users') }}</p>
                    <p class="text-2xl font-bold text-admin-900 dark:text-admin-100">{{ $user_count ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="admin-card p-6">
            <div class="flex items-center">
                <div class="rounded-2xl bg-emerald-100 dark:bg-emerald-900/20 p-3">
                    <x-heroicon name="user-check" class="h-6 w-6 text-emerald-600 dark:text-emerald-400" />
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.users.active_users') }}</p>
                    <p class="text-2xl font-bold text-admin-900 dark:text-admin-100">{{ $active_users ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="admin-card p-6">
            <div class="flex items-center">
                <div class="rounded-2xl bg-amber-100 dark:bg-amber-900/20 p-3">
                    <x-heroicon name="clock" class="h-6 w-6 text-amber-600 dark:text-amber-400" />
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.users.pending_verification') }}</p>
                    <p class="text-2xl font-bold text-admin-900 dark:text-admin-100">{{ $pending_verification ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="admin-card p-6">
            <div class="flex items-center">
                <div class="rounded-2xl bg-red-100 dark:bg-red-900/20 p-3">
                    <x-heroicon name="user-minus" class="h-6 w-6 text-red-600 dark:text-red-400" />
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-admin-600 dark:text-admin-400">{{ __('admin.status.blocked') }}</p>
                    <p class="text-2xl font-bold text-admin-900 dark:text-admin-100">{{ $blocked_users ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="admin-card p-6">
        <div class="flex flex-col space-y-4 lg:flex-row lg:items-center lg:justify-between lg:space-y-0">
            <!-- Search -->
            <div class="relative flex-1 max-w-md">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <x-heroicon name="magnifying-glass" class="h-4 w-4 text-admin-400" />
                </div>
                <input 
                    type="text" 
                    id="user-search"
                    class="admin-input w-full pl-10 pr-4" 
                    placeholder="{{ __('admin.filters.search_users') }}"
                    oninput="filterUsers(this.value)"
                >
            </div>

            <!-- Filters -->
            <div class="flex items-center space-x-4">
                <select id="status-filter" class="admin-input" onchange="filterByStatus(this.value)">
                    <option value="">{{ __('admin.filters.all_statuses') }}</option>
                    <option value="active">{{ __('admin.status.active') }}</option>
                    <option value="inactive">{{ __('admin.status.inactive') }}</option>
                    <option value="blocked">{{ __('admin.status.blocked') }}</option>
                    <option value="pending">{{ __('admin.status.pending') }}</option>
                </select>

                <select id="role-filter" class="admin-input" onchange="filterByRole(this.value)">
                    <option value="">{{ __('admin.filters.all_roles') }}</option>
                    <option value="user">{{ __('admin.users.user') }}</option>
                    <option value="premium">{{ __('admin.users.premium') }}</option>
                    <option value="vip">{{ __('admin.users.vip') }}</option>
                </select>

                <button class="admin-btn admin-btn-secondary" onclick="resetFilters()">
                    <x-heroicon name="x-mark" class="h-4 w-4" />
                </button>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="admin-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th class="w-4">
                            <input type="checkbox" class="rounded" id="select-all" onchange="toggleSelectAll(this)">
                        </th>
                        <th>{{ __('admin.users.user') }}</th>
                        <th>{{ __('admin.users.email') }}</th>
                        <th>{{ __('admin.users.phone') }}</th>
                        <th>{{ __('admin.users.registration_date') }}</th>
                        <th>{{ __('admin.users.last_activity') }}</th>
                        <th>{{ __('admin.users.balance') }}</th>
                        <th>{{ __('admin.users.status') }}</th>
                        <th>{{ __('admin.actions.operations') }}</th>
                    </tr>
                </thead>
                <tbody id="users-table-body">
                    @forelse($users ?? [] as $user)
                    <tr data-user-id="{{ $user->id }}" class="user-row">
                        <td>
                            <input type="checkbox" class="rounded user-checkbox" value="{{ $user->id }}">
                        </td>
                        <td>
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-semibold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-admin-900 dark:text-admin-100">{{ $user->name }}</div>
                                    <div class="text-sm text-admin-500 dark:text-admin-400">ID: {{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-sm text-admin-900 dark:text-admin-100">{{ $user->email }}</td>
                        <td class="text-sm text-admin-900 dark:text-admin-100">{{ $user->phone ?? '-' }}</td>
                        <td class="text-sm text-admin-500 dark:text-admin-400">
                            {{ $user->created_at?->format('d.m.Y H:i') }}
                        </td>
                        <td class="text-sm text-admin-500 dark:text-admin-400">
                            {{ $user->last_seen?->diffForHumans() ?? __('admin.users.never') }}
                        </td>
                        <td class="text-sm font-mono text-admin-900 dark:text-admin-100">
                            {{ $user->currency ?? '$' }}{{ number_format($user->account_bal ?? 0, 2) }}
                        </td>
                        <td>
                            @switch($user->status ?? 'active')
                                @case('active')
                                    <span class="badge badge-success">
                                        <x-heroicon name="check-circle" class="mr-1 h-3 w-3" />
                                        {{ __('admin.status.active') }}
                                    </span>
                                    @break
                                @case('blocked')
                                    <span class="badge badge-error">
                                        <x-heroicon name="x-circle" class="mr-1 h-3 w-3" />
                                        {{ __('admin.status.blocked') }}
                                    </span>
                                    @break
                                @case('pending')
                                    <span class="badge badge-warning">
                                        <x-heroicon name="clock" class="mr-1 h-3 w-3" />
                                        {{ __('admin.status.pending') }}
                                    </span>
                                    @break
                                @default
                                    <span class="badge badge-info">
                                        <x-heroicon name="user" class="mr-1 h-3 w-3" />
                                        {{ __('admin.status.unknown') }}
                                    </span>
                            @endswitch
                        </td>
                        <td>
                            <div class="flex items-center space-x-2">
                                <button class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors" 
                                        onclick="viewUser({{ $user->id }})" title="{{ __('admin.actions.view') }}">
                                    <x-heroicon name="eye" class="h-4 w-4" />
                                </button>
                                <button class="p-2 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-lg transition-colors" 
                                        onclick="editUser({{ $user->id }})" title="{{ __('admin.actions.edit') }}">
                                    <x-heroicon name="edit" class="h-4 w-4" />
                                </button>
                                <button class="p-2 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-lg transition-colors" 
                                        onclick="toggleUserStatus({{ $user->id }})" title="{{ __('admin.actions.change_status') }}">
                                    <x-heroicon name="power" class="h-4 w-4" />
                                </button>
                                <button class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" 
                                        onclick="deleteUser({{ $user->id }})" title="{{ __('admin.actions.delete') }}">
                                    <x-heroicon name="trash-2" class="h-4 w-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <x-heroicon name="users" class="h-12 w-12 text-admin-400 mb-4" />
                                <h3 class="text-lg font-medium text-admin-900 dark:text-admin-100 mb-2">{{ __('admin.users.user_not_found') }}</h3>
                                <p class="text-admin-500 dark:text-admin-400">{{ __('admin.users.no_users_added_yet') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($users) && method_exists($users, 'links'))
        <div class="border-t border-admin-200 dark:border-admin-700 px-6 py-4">
            {{ $users->links('components.paginator') }}
        </div>
        @endif
    </div>

    <!-- Bulk Actions (Hidden by default) -->
    <div id="bulk-actions" class="hidden admin-card p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-admin-900 dark:text-admin-100">
                    <span id="selected-count">0</span> {{ __('admin.users.users_selected') }}
                </span>
            </div>
            <div class="flex items-center space-x-2">
                <button class="admin-btn admin-btn-secondary" onclick="bulkActivate()">
                    <x-heroicon name="check" class="mr-2 h-4 w-4" />
                    {{ __('admin.actions.activate') }}
                </button>
                <button class="admin-btn admin-btn-secondary" onclick="bulkDeactivate()">
                    <x-heroicon name="x-mark" class="mr-2 h-4 w-4" />
                    {{ __('admin.actions.deactivate') }}
                </button>
                <button class="admin-btn admin-btn-secondary" onclick="bulkExport()">
                    <x-heroicon name="arrow-down-tray" class="mr-2 h-4 w-4" />
                    {{ __('admin.actions.export') }}
                </button>
                <button class="admin-btn admin-btn-secondary text-red-600" onclick="bulkDelete()">
                    <x-heroicon name="trash-2" class="mr-2 h-4 w-4" />
                    {{ __('admin.actions.delete') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div id="add-user-modal" class="fixed inset-0 z-50 hidden" x-data="{ open: false }">
    <div class="modal-backdrop" x-show="open" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"></div>
    
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="modal-content w-full max-w-2xl" x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                
                <div class="modal-header">
                    <h3 class="text-lg font-semibold text-admin-900 dark:text-admin-100">{{ __('admin.users.add_new_user') }}</h3>
                    <button onclick="closeAddUserModal()" class="p-2 hover:bg-admin-100 dark:hover:bg-admin-700 rounded-lg transition-colors">
                        <x-heroicon name="x-mark" class="h-5 w-5" />
                    </button>
                </div>

                <form id="add-user-form" onsubmit="submitAddUser(event)">
                    <div class="modal-body space-y-6">
                        
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="form-group">
                                <label class="form-label">{{ __('admin.forms.full_name') }}</label>
                                <input type="text" name="name" class="form-input" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">{{ __('admin.users.email') }}</label>
                                <input type="email" name="email" class="form-input" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="form-group">
                                <label class="form-label">{{ __('admin.users.phone') }}</label>
                                <input type="tel" name="phone" class="form-input">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">{{ __('admin.users.role') }}</label>
                                <select name="role" class="form-select">
                                    <option value="user">{{ __('admin.users.user') }}</option>
                                    <option value="premium">{{ __('admin.users.premium') }}</option>
                                    <option value="vip">{{ __('admin.users.vip') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{ __('admin.forms.password') }}</label>
                            <input type="password" name="password" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{ __('admin.forms.password_confirmation') }}</label>
                            <input type="password" name="password_confirmation" class="form-input" required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" onclick="closeAddUserModal()" class="admin-btn admin-btn-secondary">{{ __('admin.actions.cancel') }}</button>
                        <button type="submit" class="admin-btn admin-btn-primary">
                            <x-heroicon name="plus" class="mr-2 h-4 w-4" />
                            {{ __('admin.users.add_user') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize functionality
    initializeUserManagement();
});

function initializeUserManagement() {
    // Initialize tooltips, modals, etc.
    
}

// Modal Functions
function openAddUserModal() {
    const modal = document.getElementById('add-user-modal');
    modal.classList.remove('hidden');
    // Trigger Alpine.js state
    modal.querySelector('[x-data]').__x.$data.open = true;
}

function closeAddUserModal() {
    const modal = document.getElementById('add-user-modal');
    modal.querySelector('[x-data]').__x.$data.open = false;
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

// Filter Functions
function filterUsers(searchTerm) {
    const rows = document.querySelectorAll('.user-row');
    const term = searchTerm.toLowerCase();
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(term) ? '' : 'none';
    });
}

function filterByStatus(status) {
    const rows = document.querySelectorAll('.user-row');
    
    rows.forEach(row => {
        if (status === '') {
            row.style.display = '';
        } else {
            const badge = row.querySelector('.badge');
            const badgeText = badge?.textContent.toLowerCase().trim();
            row.style.display = badgeText?.includes(status) ? '' : 'none';
        }
    });
}

function filterByRole(role) {
    // Implement role-based filtering
    console.log('{{ __("admin.notifications.filtering_by_role") }}:', role);
}

function resetFilters() {
    document.getElementById('user-search').value = '';
    document.getElementById('status-filter').value = '';
    document.getElementById('role-filter').value = '';
    
    const rows = document.querySelectorAll('.user-row');
    rows.forEach(row => row.style.display = '');
}

// Selection Functions
function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(cb => cb.checked = checkbox.checked);
    updateBulkActions();
}

function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
    const bulkActions = document.getElementById('bulk-actions');
    const selectedCount = document.getElementById('selected-count');
    
    selectedCount.textContent = checkedBoxes.length;
    
    if (checkedBoxes.length > 0) {
        bulkActions.classList.remove('hidden');
    } else {
        bulkActions.classList.add('hidden');
    }
}

// Listen for checkbox changes
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('user-checkbox')) {
        updateBulkActions();
    }
});

// User Action Functions
function viewUser(userId) {
    window.location.href = `/admin/dashboard/user-details/${userId}`;
}

function editUser(userId) {
    // Henüz edit route'u yok, geçici olarak view sayfasına yönlendir
    window.location.href = `/admin/dashboard/user-details/${userId}`;
}

function toggleUserStatus(userId) {
    Swal.fire({
        title: '{{ __("admin.users.change_user_status") }}',
        text: '{{ __("admin.users.confirm_change_user_status") }}',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '{{ __("admin.actions.yes_change") }}',
        cancelButtonText: '{{ __("admin.actions.cancel") }}'
    }).then((result) => {
        if (result.isConfirmed) {
            // Kullanıcı durumunu toggle et (block/unblock)
            window.location.href = `/admin/dashboard/uublock/${userId}`;
        }
    });
}

function deleteUser(userId) {
    Swal.fire({
        title: '{{ __("admin.users.delete_user") }}',
        text: '{{ __("admin.users.confirm_delete_user_irreversible") }}',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: '{{ __("admin.actions.yes_delete") }}',
        cancelButtonText: '{{ __("admin.actions.cancel") }}'
    }).then((result) => {
        if (result.isConfirmed) {
            // Kullanıcıyı sil
            window.location.href = `/admin/dashboard/delsystemuser/${userId}`;
        }
    });
}

// Bulk Action Functions
function bulkActivate() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    if (selectedUsers.length === 0) {
        Swal.fire('{{ __("admin.notifications.warning") }}', '{{ __("admin.users.please_select_at_least_one_user") }}', 'warning');
        return;
    }
    
    Swal.fire({
        title: '{{ __("admin.users.bulk_activate") }}',
        text: `${selectedUsers.length} {{ __("admin.users.users_to_activate_confirm") }}`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '{{ __("admin.actions.yes_activate") }}',
        cancelButtonText: '{{ __("admin.actions.cancel") }}'
    }).then((result) => {
        if (result.isConfirmed) {
            // Her kullanıcıyı ayrı ayrı aktifleştir (bulk API yok)
            selectedUsers.forEach(userId => {
                window.location.href = `/admin/dashboard/uunblock/${userId}`;
            });
        }
    });
}

function bulkDeactivate() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    if (selectedUsers.length === 0) {
        Swal.fire('{{ __("admin.notifications.warning") }}', '{{ __("admin.users.please_select_at_least_one_user") }}', 'warning');
        return;
    }
    
    Swal.fire({
        title: '{{ __("admin.users.bulk_deactivate") }}',
        text: `${selectedUsers.length} {{ __("admin.users.users_to_deactivate_confirm") }}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '{{ __("admin.actions.yes_deactivate") }}',
        cancelButtonText: '{{ __("admin.actions.cancel") }}'
    }).then((result) => {
        if (result.isConfirmed) {
            // Her kullanıcıyı ayrı ayrı deaktifleştir
            selectedUsers.forEach(userId => {
                window.location.href = `/admin/dashboard/uublock/${userId}`;
            });
        }
    });
}

function bulkExport() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    if (selectedUsers.length === 0) {
        Swal.fire('{{ __("admin.notifications.warning") }}', '{{ __("admin.users.please_select_at_least_one_user") }}', 'warning');
        return;
    }
    // Export fonksiyonu için özel route gerekli - şimdilik basit uyarı
    Swal.fire('{{ __("admin.notifications.info") }}', '{{ __("admin.features.export_feature_coming_soon") }}', 'info');
}

function bulkDelete() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    if (selectedUsers.length === 0) {
        Swal.fire('{{ __("admin.notifications.warning") }}', '{{ __("admin.users.please_select_at_least_one_user") }}', 'warning');
        return;
    }
    
    Swal.fire({
        title: '{{ __("admin.users.delete_selected_users") }}',
        text: `${selectedUsers.length} {{ __("admin.users.users_to_delete_irreversible_confirm") }}`,
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: '{{ __("admin.actions.yes_delete") }}',
        cancelButtonText: '{{ __("admin.actions.cancel") }}'
    }).then((result) => {
        if (result.isConfirmed) {
            // Her kullanıcıyı ayrı ayrı sil
            selectedUsers.forEach(userId => {
                window.location.href = `/admin/dashboard/delsystemuser/${userId}`;
            });
        }
    });
}

// Form Submission
function submitAddUser(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    
    // Form action ve method ekle
    form.action = '/admin/dashboard/saveuser';
    form.method = 'POST';
    
    // CSRF token ekle
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (csrfToken) {
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);
    }
    
    // Form'u submit et
    form.submit();
}

// Export Functions
function exportUsers() {
    // Henüz export route'u yok, geçici bilgi mesajı
    Swal.fire({
        title: '{{ __("admin.notifications.info") }}',
        text: '{{ __("admin.features.user_export_feature_coming_soon") }}',
        icon: 'info'
    });
}
</script>
@endpush