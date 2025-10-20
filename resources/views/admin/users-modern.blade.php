@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    
    <!-- Page Header -->
    <div class="flex flex-col items-start justify-between space-y-4 sm:flex-row sm:items-center sm:space-y-0">
        <div>
            <h1 class="text-3xl font-bold text-admin-900 dark:text-admin-100">Kullanıcı Yönetimi</h1>
            <p class="mt-2 text-admin-600 dark:text-admin-400">Platform kullanıcılarını görüntüle ve yönet</p>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center space-x-3">
            <button class="admin-btn admin-btn-secondary flex items-center space-x-2" onclick="exportUsers()">
                <i data-lucide="download" class="h-4 w-4"></i>
                <span>Dışa Aktar</span>
            </button>
            
            <button class="admin-btn admin-btn-primary flex items-center space-x-2" onclick="openAddUserModal()">
                <i data-lucide="plus" class="h-4 w-4"></i>
                <span>Yeni Kullanıcı</span>
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="admin-card p-6">
            <div class="flex items-center">
                <div class="rounded-2xl bg-blue-100 dark:bg-blue-900/20 p-3">
                    <i data-lucide="users" class="h-6 w-6 text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-admin-600 dark:text-admin-400">Toplam Kullanıcılar</p>
                    <p class="text-2xl font-bold text-admin-900 dark:text-admin-100">{{ $user_count ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="admin-card p-6">
            <div class="flex items-center">
                <div class="rounded-2xl bg-emerald-100 dark:bg-emerald-900/20 p-3">
                    <i data-lucide="user-check" class="h-6 w-6 text-emerald-600 dark:text-emerald-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-admin-600 dark:text-admin-400">Aktif Kullanıcılar</p>
                    <p class="text-2xl font-bold text-admin-900 dark:text-admin-100">{{ $active_users ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="admin-card p-6">
            <div class="flex items-center">
                <div class="rounded-2xl bg-amber-100 dark:bg-amber-900/20 p-3">
                    <i data-lucide="clock" class="h-6 w-6 text-amber-600 dark:text-amber-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-admin-600 dark:text-admin-400">Bekleyen Doğrulama</p>
                    <p class="text-2xl font-bold text-admin-900 dark:text-admin-100">{{ $pending_verification ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="admin-card p-6">
            <div class="flex items-center">
                <div class="rounded-2xl bg-red-100 dark:bg-red-900/20 p-3">
                    <i data-lucide="user-x" class="h-6 w-6 text-red-600 dark:text-red-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-admin-600 dark:text-admin-400">Engellenen</p>
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
                    <i data-lucide="search" class="h-4 w-4 text-admin-400"></i>
                </div>
                <input 
                    type="text" 
                    id="user-search"
                    class="admin-input w-full pl-10 pr-4" 
                    placeholder="Kullanıcı ara..."
                    oninput="filterUsers(this.value)"
                >
            </div>

            <!-- Filters -->
            <div class="flex items-center space-x-4">
                <select id="status-filter" class="admin-input" onchange="filterByStatus(this.value)">
                    <option value="">Tüm Durumlar</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Pasif</option>
                    <option value="blocked">Engellenen</option>
                    <option value="pending">Bekleyen</option>
                </select>

                <select id="role-filter" class="admin-input" onchange="filterByRole(this.value)">
                    <option value="">Tüm Roller</option>
                    <option value="user">Kullanıcı</option>
                    <option value="premium">Premium</option>
                    <option value="vip">VIP</option>
                </select>

                <button class="admin-btn admin-btn-secondary" onclick="resetFilters()">
                    <i data-lucide="x" class="h-4 w-4"></i>
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
                        <th>Kullanıcı</th>
                        <th>E-posta</th>
                        <th>Telefon</th>
                        <th>Kayıt Tarihi</th>
                        <th>Son Aktivite</th>
                        <th>Bakiye</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
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
                            {{ $user->last_seen?->diffForHumans() ?? 'Hiçbir zaman' }}
                        </td>
                        <td class="text-sm font-mono text-admin-900 dark:text-admin-100">
                            {{ $user->currency ?? '$' }}{{ number_format($user->account_bal ?? 0, 2) }}
                        </td>
                        <td>
                            @switch($user->status ?? 'active')
                                @case('active')
                                    <span class="badge badge-success">
                                        <i data-lucide="check-circle" class="mr-1 h-3 w-3"></i>
                                        Aktif
                                    </span>
                                    @break
                                @case('blocked')
                                    <span class="badge badge-error">
                                        <i data-lucide="x-circle" class="mr-1 h-3 w-3"></i>
                                        Engelli
                                    </span>
                                    @break
                                @case('pending')
                                    <span class="badge badge-warning">
                                        <i data-lucide="clock" class="mr-1 h-3 w-3"></i>
                                        Bekliyor
                                    </span>
                                    @break
                                @default
                                    <span class="badge badge-info">
                                        <i data-lucide="user" class="mr-1 h-3 w-3"></i>
                                        Bilinmiyor
                                    </span>
                            @endswitch
                        </td>
                        <td>
                            <div class="flex items-center space-x-2">
                                <button class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors" 
                                        onclick="viewUser({{ $user->id }})" title="Görüntüle">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                </button>
                                <button class="p-2 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-lg transition-colors" 
                                        onclick="editUser({{ $user->id }})" title="Düzenle">
                                    <i data-lucide="edit" class="h-4 w-4"></i>
                                </button>
                                <button class="p-2 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-lg transition-colors" 
                                        onclick="toggleUserStatus({{ $user->id }})" title="Durum Değiştir">
                                    <i data-lucide="power" class="h-4 w-4"></i>
                                </button>
                                <button class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" 
                                        onclick="deleteUser({{ $user->id }})" title="Sil">
                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="users" class="h-12 w-12 text-admin-400 mb-4"></i>
                                <h3 class="text-lg font-medium text-admin-900 dark:text-admin-100 mb-2">Kullanıcı bulunamadı</h3>
                                <p class="text-admin-500 dark:text-admin-400">Henüz hiç kullanıcı eklenmemiş.</p>
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
                    <span id="selected-count">0</span> kullanıcı seçildi
                </span>
            </div>
            <div class="flex items-center space-x-2">
                <button class="admin-btn admin-btn-secondary" onclick="bulkActivate()">
                    <i data-lucide="check" class="mr-2 h-4 w-4"></i>
                    Aktifleştir
                </button>
                <button class="admin-btn admin-btn-secondary" onclick="bulkDeactivate()">
                    <i data-lucide="x" class="mr-2 h-4 w-4"></i>
                    Devre Dışı Bırak
                </button>
                <button class="admin-btn admin-btn-secondary" onclick="bulkExport()">
                    <i data-lucide="download" class="mr-2 h-4 w-4"></i>
                    Dışa Aktar
                </button>
                <button class="admin-btn admin-btn-secondary text-red-600" onclick="bulkDelete()">
                    <i data-lucide="trash-2" class="mr-2 h-4 w-4"></i>
                    Sil
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
                    <h3 class="text-lg font-semibold text-admin-900 dark:text-admin-100">Yeni Kullanıcı Ekle</h3>
                    <button onclick="closeAddUserModal()" class="p-2 hover:bg-admin-100 dark:hover:bg-admin-700 rounded-lg transition-colors">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>

                <form id="add-user-form" onsubmit="submitAddUser(event)">
                    <div class="modal-body space-y-6">
                        
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="form-group">
                                <label class="form-label">Ad Soyad</label>
                                <input type="text" name="name" class="form-input" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">E-posta</label>
                                <input type="email" name="email" class="form-input" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="form-group">
                                <label class="form-label">Telefon</label>
                                <input type="tel" name="phone" class="form-input">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Rol</label>
                                <select name="role" class="form-select">
                                    <option value="user">Kullanıcı</option>
                                    <option value="premium">Premium</option>
                                    <option value="vip">VIP</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Şifre</label>
                            <input type="password" name="password" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Şifre Tekrar</label>
                            <input type="password" name="password_confirmation" class="form-input" required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" onclick="closeAddUserModal()" class="admin-btn admin-btn-secondary">İptal</button>
                        <button type="submit" class="admin-btn admin-btn-primary">
                            <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
                            Kullanıcı Ekle
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
    lucide.createIcons();
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
    console.log('Filtering by role:', role);
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
    window.location.href = `/admin/users/${userId}`;
}

function editUser(userId) {
    window.location.href = `/admin/users/${userId}/edit`;
}

function toggleUserStatus(userId) {
    Swal.fire({
        title: 'Kullanıcı Durumunu Değiştir',
        text: 'Bu kullanıcının durumunu değiştirmek istediğinizden emin misiniz?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Evet, Değiştir',
        cancelButtonText: 'İptal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Implement status toggle
            console.log('Toggling status for user:', userId);
        }
    });
}

function deleteUser(userId) {
    Swal.fire({
        title: 'Kullanıcıyı Sil',
        text: 'Bu kullanıcıyı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Evet, Sil',
        cancelButtonText: 'İptal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Implement user deletion
            console.log('Deleting user:', userId);
        }
    });
}

// Bulk Action Functions
function bulkActivate() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    console.log('Bulk activating users:', selectedUsers);
}

function bulkDeactivate() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    console.log('Bulk deactivating users:', selectedUsers);
}

function bulkExport() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    console.log('Bulk exporting users:', selectedUsers);
}

function bulkDelete() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    
    Swal.fire({
        title: 'Seçilen Kullanıcıları Sil',
        text: `${selectedUsers.length} kullanıcıyı silmek istediğinizden emin misiniz?`,
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Evet, Sil',
        cancelButtonText: 'İptal'
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Bulk deleting users:', selectedUsers);
        }
    });
}

// Form Submission
function submitAddUser(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    
    // Implement user creation
    console.log('Creating user with data:', Object.fromEntries(formData));
    
    // Close modal on success
    closeAddUserModal();
    
    // Show success message
    Swal.fire({
        title: 'Başarılı!',
        text: 'Kullanıcı başarıyla eklendi.',
        icon: 'success'
    });
}

// Export Functions
function exportUsers() {
    // Implement user export
    console.log('Exporting users...');
}
</script>
@endpush