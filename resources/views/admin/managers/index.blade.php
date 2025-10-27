@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="managersIndex()">
    
    <!-- Page Header -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <i data-lucide="user-cog" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-admin-900 dark:text-white">Yöneticiler</h1>
                        <p class="text-admin-600 dark:text-admin-400">Yönetici hesaplarını görüntüle ve yönet</p>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <!-- Add Manager Button -->
                <a href="{{ route('admin.managers.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium rounded-xl transition-all duration-200 shadow-lg hover:shadow-green-500/25">
                    <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                    Yeni Yönetici
                </a>
                
                <!-- Export Button -->
                <button type="button"
                        class="inline-flex items-center px-4 py-2 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 text-admin-700 dark:text-admin-300 font-medium rounded-xl transition-all duration-200">
                    <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                    Dışa Aktar
                </button>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Toplam Yönetici</p>
                        <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $stats['total_admins'] }}</p>
                    </div>
                    <i data-lucide="users" class="w-8 h-8 text-blue-500"></i>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-4 border border-green-200 dark:border-green-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-green-600 dark:text-green-400 font-medium">Aktif</p>
                        <p class="text-2xl font-bold text-green-900 dark:text-green-100">{{ $stats['active_admins'] }}</p>
                    </div>
                    <i data-lucide="user-check" class="w-8 h-8 text-green-500"></i>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 rounded-xl p-4 border border-amber-200 dark:border-amber-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-amber-600 dark:text-amber-400 font-medium">Müsait</p>
                        <p class="text-2xl font-bold text-amber-900 dark:text-amber-100">{{ $stats['available_admins'] }}</p>
                    </div>
                    <i data-lucide="clock" class="w-8 h-8 text-amber-500"></i>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl p-4 border border-purple-200 dark:border-purple-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-purple-600 dark:text-purple-400 font-medium">Yüksek Performans</p>
                        <p class="text-2xl font-bold text-purple-900 dark:text-purple-100">{{ $stats['high_performers'] }}</p>
                    </div>
                    <i data-lucide="trending-up" class="w-8 h-8 text-purple-500"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
        <form method="GET" class="space-y-4" x-ref="filtersForm">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <i data-lucide="search" class="w-4 h-4 inline mr-1"></i>
                        Arama
                    </label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Ad, email, çalışan ID..."
                           class="admin-input w-full"
                           x-on:input.debounce.500ms="$refs.filtersForm.submit()">
                </div>
                
                <!-- Role Filter -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <i data-lucide="shield" class="w-4 h-4 inline mr-1"></i>
                        Rol
                    </label>
                    <select name="role_id" 
                            class="admin-input w-full"
                            x-on:change="$refs.filtersForm.submit()">
                        <option value="">Tüm Roller</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Department Filter -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <i data-lucide="building" class="w-4 h-4 inline mr-1"></i>
                        Departman
                    </label>
                    <select name="department" 
                            class="admin-input w-full"
                            x-on:change="$refs.filtersForm.submit()">
                        <option value="">Tüm Departmanlar</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                                {{ ucfirst($dept) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <i data-lucide="activity" class="w-4 h-4 inline mr-1"></i>
                        Durum
                    </label>
                    <select name="status" 
                            class="admin-input w-full"
                            x-on:change="$refs.filtersForm.submit()">
                        <option value="">Tüm Durumlar</option>
                        <option value="{{ \App\Models\Admin::STATUS_ACTIVE }}" {{ request('status') == \App\Models\Admin::STATUS_ACTIVE ? 'selected' : '' }}>Aktif</option>
                        <option value="{{ \App\Models\Admin::STATUS_INACTIVE }}" {{ request('status') == \App\Models\Admin::STATUS_INACTIVE ? 'selected' : '' }}>Pasif</option>
                        <option value="{{ \App\Models\Admin::STATUS_SUSPENDED }}" {{ request('status') == \App\Models\Admin::STATUS_SUSPENDED ? 'selected' : '' }}>Askıya Alınmış</option>
                    </select>
                </div>
            </div>
            
            <div class="flex items-center justify-between pt-4 border-t border-admin-200 dark:border-admin-700">
                <div class="flex items-center space-x-3">
                    <!-- Clear Filters -->
                    <a href="{{ route('admin.managers.index') }}" 
                       class="text-sm text-admin-500 hover:text-admin-700 dark:hover:text-admin-300">
                        Filtreleri Temizle
                    </a>
                    
                    <!-- Results Count -->
                    <span class="text-sm text-admin-600 dark:text-admin-400">
                        {{ $admins->total() }} sonuç bulundu
                    </span>
                </div>
                
                <!-- Bulk Actions -->
                <div class="flex items-center space-x-3" x-show="selectedAdmins.length > 0" x-transition>
                    <span class="text-sm text-admin-600 dark:text-admin-400" x-text="`${selectedAdmins.length} seçili`"></span>
                    
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="inline-flex items-center px-3 py-1.5 bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-sm font-medium rounded-lg hover:bg-primary-200 dark:hover:bg-primary-900/50 transition-colors">
                            <i data-lucide="settings" class="w-4 h-4 mr-1"></i>
                            Toplu İşlem
                            <i data-lucide="chevron-down" class="w-3 h-3 ml-1"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-0 mt-2 w-48 bg-white dark:bg-admin-800 rounded-xl shadow-elegant border border-admin-200 dark:border-admin-700 py-2 z-10">
                            <button @click="bulkAction('activate')" class="w-full px-4 py-2 text-left text-sm text-admin-700 dark:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 transition-colors">
                                <i data-lucide="play" class="w-4 h-4 inline mr-2 text-green-500"></i>
                                Aktifleştir
                            </button>
                            <button @click="bulkAction('deactivate')" class="w-full px-4 py-2 text-left text-sm text-admin-700 dark:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 transition-colors">
                                <i data-lucide="pause" class="w-4 h-4 inline mr-2 text-amber-500"></i>
                                Devre Dışı Bırak
                            </button>
                            <button @click="bulkAction('delete')" class="w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <i data-lucide="trash-2" class="w-4 h-4 inline mr-2"></i>
                                Sil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Managers Table -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-admin-50 dark:bg-admin-900/50 border-b border-admin-200 dark:border-admin-700">
                    <tr>
                        <th class="px-6 py-4 text-left">
                            <input type="checkbox" 
                                   class="admin-checkbox"
                                   x-model="selectAll"
                                   @change="toggleSelectAll()">
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-admin-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'firstName', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="flex items-center space-x-1 hover:text-admin-700 dark:hover:text-admin-300">
                                <span>Yönetici</span>
                                @if(request('sort_by') === 'firstName')
                                    <i data-lucide="chevron-{{ request('sort_direction') === 'asc' ? 'up' : 'down' }}" class="w-4 h-4"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-admin-500 uppercase tracking-wider">Rol & Departman</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-admin-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'hierarchy_level', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="flex items-center space-x-1 hover:text-admin-700 dark:hover:text-admin-300">
                                <span>Hiyerarşi</span>
                                @if(request('sort_by') === 'hierarchy_level')
                                    <i data-lucide="chevron-{{ request('sort_direction') === 'asc' ? 'up' : 'down' }}" class="w-4 h-4"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-admin-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'current_performance', 'sort_direction' => request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                               class="flex items-center space-x-1 hover:text-admin-700 dark:hover:text-admin-300">
                                <span>Performans</span>
                                @if(request('sort_by') === 'current_performance')
                                    <i data-lucide="chevron-{{ request('sort_direction') === 'asc' ? 'up' : 'down' }}" class="w-4 h-4"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-admin-500 uppercase tracking-wider">Durum</th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-admin-500 uppercase tracking-wider">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-admin-200 dark:divide-admin-700">
                    @forelse($admins as $admin)
                    <tr class="hover:bg-admin-50 dark:hover:bg-admin-700/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" 
                                   class="admin-checkbox"
                                   value="{{ $admin->id }}"
                                   x-model="selectedAdmins">
                        </td>
                        
                        <!-- Admin Info -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if($admin->avatar)
                                        <img src="{{ asset('storage/' . $admin->avatar) }}" 
                                             alt="{{ $admin->getFullName() }}"
                                             class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                            {{ substr($admin->firstName, 0, 1) }}{{ substr($admin->lastName, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center space-x-2">
                                        <p class="text-sm font-medium text-admin-900 dark:text-white">
                                            {{ $admin->getFullName() }}
                                        </p>
                                        @if($admin->is_available)
                                            <span class="w-2 h-2 bg-green-400 rounded-full" title="Müsait"></span>
                                        @else
                                            <span class="w-2 h-2 bg-gray-400 rounded-full" title="Meşgul"></span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-admin-500 truncate">{{ $admin->email }}</p>
                                    @if($admin->employee_id)
                                        <p class="text-xs text-admin-400">ID: {{ $admin->employee_id }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        
                        <!-- Role & Department -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-admin-900 dark:text-white">
                                @if($admin->role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                        {{ $admin->role->display_name }}
                                    </span>
                                @else
                                    <span class="text-admin-400">Rol atanmamış</span>
                                @endif
                            </div>
                            @if($admin->department)
                                <p class="text-xs text-admin-500 mt-1">{{ ucfirst($admin->department) }}</p>
                            @endif
                        </td>
                        
                        <!-- Hierarchy -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-admin-600 dark:text-admin-400">
                                    Seviye {{ $admin->hierarchy_level }}
                                </span>
                                @if($admin->supervisor)
                                    <i data-lucide="arrow-up" class="w-3 h-3 text-admin-400" title="Rapor Veriyor: {{ $admin->supervisor->getFullName() }}"></i>
                                @endif
                            </div>
                            <div class="text-xs text-admin-500">
                                {{ $admin->subordinates_count }} alt çalışan
                            </div>
                        </td>
                        
                        <!-- Performance -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between text-xs mb-1">
                                        <span class="text-admin-600 dark:text-admin-400">Performans</span>
                                        <span class="font-medium text-admin-900 dark:text-white">{{ number_format($admin->current_performance, 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-admin-200 dark:bg-admin-700 rounded-full h-1.5">
                                        <div class="bg-gradient-to-r from-green-400 to-green-500 h-1.5 rounded-full" 
                                             style="width: {{ min(100, $admin->current_performance) }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-xs text-admin-500 mt-1">
                                {{ $admin->leads_assigned_count }}/{{ $admin->leads_converted_count }} lead
                            </div>
                        </td>
                        
                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'Active' => 'green',
                                    'Inactive' => 'gray',
                                    'Suspended' => 'red',
                                ];
                                $statusLabels = [
                                    'Active' => 'Aktif',
                                    'Inactive' => 'Pasif', 
                                    'Suspended' => 'Askıya Alınmış',
                                ];
                                $color = $statusColors[$admin->status] ?? 'gray';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 dark:bg-{{ $color }}-900/30 text-{{ $color }}-800 dark:text-{{ $color }}-300">
                                {{ $statusLabels[$admin->status] ?? $admin->status }}
                            </span>
                            @if($admin->last_activity)
                                <p class="text-xs text-admin-500 mt-1">
                                    {{ $admin->last_activity->diffForHumans() }}
                                </p>
                            @endif
                        </td>
                        
                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <!-- Edit Modal -->
                                @if($currentAdmin->canManageAdmin($admin))
                                    <button @click="openEditModal({{ $admin->id }})"
                                            class="text-admin-400 hover:text-amber-500 transition-colors"
                                            title="Düzenle">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                @endif
                                
                                <!-- More Actions -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" 
                                            class="text-admin-400 hover:text-admin-600 dark:hover:text-admin-300 transition-colors">
                                        <i data-lucide="more-vertical" class="w-4 h-4"></i>
                                    </button>
                                    
                                    <div x-show="open" @click.away="open = false" x-transition
                                         class="absolute right-0 mt-2 w-48 bg-white dark:bg-admin-800 rounded-xl shadow-elegant border border-admin-200 dark:border-admin-700 py-2 z-10">
                                        @if($admin->status === 'Active')
                                            <a href="{{ route('admin.managers.deactivate', $admin) }}" 
                                               class="block px-4 py-2 text-sm text-admin-700 dark:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 transition-colors">
                                                <i data-lucide="pause" class="w-4 h-4 inline mr-2 text-amber-500"></i>
                                                Devre Dışı Bırak
                                            </a>
                                        @else
                                            <a href="{{ route('admin.managers.activate', $admin) }}" 
                                               class="block px-4 py-2 text-sm text-admin-700 dark:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 transition-colors">
                                                <i data-lucide="play" class="w-4 h-4 inline mr-2 text-green-500"></i>
                                                Aktifleştir
                                            </a>
                                        @endif
                                        
                                        @if($currentAdmin->canManageAdmin($admin))
                                            <button @click="openResetPasswordModal({{ $admin->id }}, '{{ $admin->getFullName() }}')"
                                                    class="w-full text-left px-4 py-2 text-sm text-admin-700 dark:text-admin-300 hover:bg-admin-100 dark:hover:bg-admin-700 transition-colors">
                                                <i data-lucide="key" class="w-4 h-4 inline mr-2 text-purple-500"></i>
                                                Şifre Sıfırla
                                            </button>
                                        @endif
                                        
                                        @if($currentAdmin->canManageAdmin($admin) && $currentAdmin->id !== $admin->id)
                                            <button @click="deleteAdmin({{ $admin->id }}, '{{ $admin->getFullName() }}')"
                                                    class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                <i data-lucide="trash-2" class="w-4 h-4 inline mr-2"></i>
                                                Sil
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-admin-500">
                            <div class="flex flex-col items-center space-y-3">
                                <i data-lucide="users-x" class="w-12 h-12 text-admin-400"></i>
                                <p class="text-lg font-medium">Yönetici bulunamadı</p>
                                <p class="text-sm">Arama kriterlerinizi değiştirmeyi deneyin</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($admins->hasPages())
            <div class="px-6 py-4 border-t border-admin-200 dark:border-admin-700">
                {{ $admins->links() }}
            </div>
        @endif
    </div>

    <!-- Edit Manager Modal -->
    <div id="editManagerModal" x-data="{ open: false, manager: { firstName: '', lastName: '', email: '', phone: '', role_id: '', supervisor_id: '', department: '', status: '' } }" x-show="open" @open-edit-manager-modal.window="open = true; manager = $event.detail.manager; console.log('🚀 Modal received data:', manager);"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" @click="open = false">
                <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
            </div>
            <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-amber-600 dark:bg-amber-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                    <h4 class="text-lg font-semibold text-white flex items-center">
                        <i data-lucide="user-pen" class="h-5 w-5 mr-2"></i>Yönetici Düzenle
                    </h4>
                    <button @click="open = false" class="absolute top-4 right-4 text-white hover:text-gray-200">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>
                <div class="p-6">
                    <form id="editManagerForm" method="POST" x-ref="editForm" @submit.prevent="submitEditForm">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- First Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i data-lucide="user" class="h-4 w-4 inline mr-2 text-amber-600"></i>Ad *
                                </label>
                                <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-admin-700 dark:text-white"
                                       type="text" name="firstName" x-model="manager.firstName" required>
                            </div>
                            
                            <!-- Last Name -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i data-lucide="user-circle" class="h-4 w-4 inline mr-2 text-amber-600"></i>Soyad *
                                </label>
                                <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-admin-700 dark:text-white"
                                       type="text" name="lastName" x-model="manager.lastName" required>
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i data-lucide="mail" class="h-4 w-4 inline mr-2 text-amber-600"></i>E-posta *
                                </label>
                                <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-admin-700 dark:text-white"
                                       type="email" name="email" x-model="manager.email" required>
                            </div>
                            
                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i data-lucide="phone" class="h-4 w-4 inline mr-2 text-amber-600"></i>Telefon
                                </label>
                                <input class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-admin-700 dark:text-white"
                                       type="tel" name="phone" x-model="manager.phone">
                            </div>
                            
                            <!-- Role -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i data-lucide="shield" class="h-4 w-4 inline mr-2 text-amber-600"></i>Rol
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-admin-700 dark:text-white"
                                        name="role_id" x-model="manager.role_id">
                                    <option value="">Rol Seçin</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Supervisor -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i data-lucide="user-check" class="h-4 w-4 inline mr-2 text-amber-600"></i>Süpervizör
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-admin-700 dark:text-white"
                                        name="supervisor_id" x-model="manager.supervisor_id">
                                    <option value="">Süpervizör Seçin</option>
                                    @foreach($supervisors as $supervisor)
                                        <option value="{{ $supervisor->id }}">{{ $supervisor->getFullName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Department -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i data-lucide="building" class="h-4 w-4 inline mr-2 text-amber-600"></i>Departman
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-admin-700 dark:text-white"
                                        name="department" x-model="manager.department">
                                    <option value="">Departman Seçin</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept }}">{{ ucfirst($dept) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <i data-lucide="activity" class="h-4 w-4 inline mr-2 text-amber-600"></i>Durum
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500 dark:bg-admin-700 dark:text-white"
                                        name="status" x-model="manager.status">
                                    <option value="{{ \App\Models\Admin::STATUS_ACTIVE }}">Aktif</option>
                                    <option value="{{ \App\Models\Admin::STATUS_INACTIVE }}">Pasif</option>
                                    <option value="{{ \App\Models\Admin::STATUS_SUSPENDED }}">Askıya Alınmış</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                <i data-lucide="save" class="h-4 w-4 mr-2"></i>Yönetici Bilgilerini Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Password Modal -->
    <div id="resetPasswordModal" x-data="{ open: false, admin: { id: '', fullName: '', newPassword: '' } }"
         x-show="open"
         @open-reset-password-modal.window="open = true; admin = $event.detail.admin;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" @click="open = false">
                <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
            </div>
            <div class="inline-block align-bottom bg-white dark:bg-admin-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-purple-600 dark:bg-purple-700 px-6 py-4 border-b border-gray-200 dark:border-admin-600">
                    <h4 class="text-lg font-semibold text-white flex items-center">
                        <i data-lucide="key" class="h-5 w-5 mr-2"></i>Şifre Sıfırla
                    </h4>
                    <button @click="open = false" class="absolute top-4 right-4 text-white hover:text-gray-200">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>
                </div>
                <div class="p-6">
                    <div class="mb-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                                <i data-lucide="user" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <p class="text-lg font-medium text-admin-900 dark:text-white" x-text="admin.fullName"></p>
                                <p class="text-sm text-admin-500">için yeni şifre oluşturuluyor</p>
                            </div>
                        </div>
                        
                        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4 mb-4">
                            <div class="flex">
                                <i data-lucide="info" class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5 mr-3"></i>
                                <div class="text-sm">
                                    <h4 class="font-medium text-amber-800 dark:text-amber-300 mb-1">Güvenlik Bilgisi</h4>
                                    <p class="text-amber-700 dark:text-amber-400">
                                        Sistem otomatik olarak güçlü bir şifre oluşturacak. Yeni şifre aşağıda görüntülenecektir.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Generated Password Display -->
                        <div x-show="admin.newPassword" x-transition class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600 dark:text-green-400"></i>
                                    <div>
                                        <p class="font-medium text-green-800 dark:text-green-300">Yeni Şifre Oluşturuldu</p>
                                        <p class="text-sm text-green-700 dark:text-green-400">Şifre başarıyla güncellendi.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 p-3 bg-white dark:bg-admin-700 rounded border">
                                <div class="flex items-center justify-between">
                                    <code class="text-sm font-mono text-admin-900 dark:text-white" x-text="admin.newPassword"></code>
                                    <button @click="copyPassword()" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">
                                        <i data-lucide="copy" class="w-4 h-4 inline mr-1"></i>Kopyala
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <button @click="generateNewPassword()"
                                x-show="!admin.newPassword"
                                class="flex-1 flex justify-center items-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            <i data-lucide="refresh-cw" class="h-4 w-4 mr-2"></i>Yeni Şifre Oluştur
                        </button>
                        
                        <button @click="open = false"
                                class="px-4 py-2 border border-gray-300 dark:border-admin-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-admin-300 bg-white dark:bg-admin-700 hover:bg-gray-50 dark:hover:bg-admin-600">
                            <span x-show="!admin.newPassword">İptal</span>
                            <span x-show="admin.newPassword">Kapat</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function managersIndex() {
    return {
        selectedAdmins: [],
        selectAll: false,
        
        toggleSelectAll() {
            if (this.selectAll) {
                this.selectedAdmins = Array.from(document.querySelectorAll('input[type="checkbox"][value]')).map(cb => cb.value);
            } else {
                this.selectedAdmins = [];
            }
        },
        
        openEditModal(managerId) {
            console.log('🚀 DEBUG: openEditModal called with managerId:', managerId);
            console.log('🚀 DEBUG: Attempting to fetch:', `/admin/dashboard/managers/edit-data/${managerId}`);
            
            // Fetch manager data via AJAX
            fetch(`/admin/dashboard/managers/edit-data/${managerId}`)
                .then(response => {
                    console.log('🚀 DEBUG: Response status:', response.status);
                    console.log('🚀 DEBUG: Response headers:', response.headers);
                    return response.json();
                })
                .then(data => {
                    console.log('🚀 DEBUG: Response data:', data);
                    
                    if (data.success) {
                        // Set form action to AJAX endpoint to avoid nginx 404
                        document.getElementById('editManagerForm').action = `/admin/dashboard/managers/${managerId}/update-data`;
                        console.log('🚀 DEBUG: Form action set to:', `/admin/dashboard/managers/${managerId}/update-data`);
                        
                        // Open modal and set data via custom event
                        console.log('🚀 DEBUG: Dispatching modal event with data:', data.manager);
                        window.dispatchEvent(new CustomEvent('open-edit-manager-modal', {
                            detail: {
                                manager: data.manager
                            }
                        }));
                    } else {
                        console.error('🚨 DEBUG: Request failed with message:', data.message);
                        Swal.fire('Hata!', data.message || 'Yönetici bilgileri alınamadı.', 'error');
                    }
                })
                .catch(error => {
                    console.error('🚨 DEBUG: Fetch error:', error);
                    console.error('🚨 DEBUG: Error details:', error.message, error.stack);
                    Swal.fire('Hata!', 'Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
                });
        },
        
        bulkAction(action) {
            if (this.selectedAdmins.length === 0) {
                return;
            }
            
            const actionMessages = {
                'activate': 'aktifleştirmek',
                'deactivate': 'devre dışı bırakmak', 
                'delete': 'silmek'
            };
            
            Swal.fire({
                title: 'Emin misiniz?',
                text: `Seçilen ${this.selectedAdmins.length} yöneticiyi ${actionMessages[action]} istiyorsunuz?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: action === 'delete' ? '#dc2626' : '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Evet, devam et',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.performBulkAction(action);
                }
            });
        },
        
        performBulkAction(action) {
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('action', action);
            this.selectedAdmins.forEach(id => {
                formData.append('admin_ids[]', id);
            });
            
            fetch('{{ route("admin.managers.bulk-action") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Başarılı!', data.message, 'success')
                        .then(() => window.location.reload());
                } else {
                    Swal.fire('Hata!', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Hata!', 'Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
            });
        },
        
        deleteAdmin(id, name) {
            Swal.fire({
                title: 'Yönetici Sil',
                text: `${name} adlı yöneticiyi kalıcı olarak silmek istediğinizden emin misiniz?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Evet, Sil',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/dashboard/managers/${id}`;
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        },
        
        submitEditForm() {
            console.log('🚀 DEBUG: submitEditForm called');
            const form = this.$refs.editForm;
            const formData = new FormData(form);
            
            console.log('🚀 DEBUG: Form action:', form.action);
            console.log('🚀 DEBUG: Form data entries:');
            for (let [key, value] of formData.entries()) {
                console.log(`  ${key}: ${value}`);
            }
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('🚀 DEBUG: Submit response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('🚀 DEBUG: Submit response data:', data);
                if (data.success) {
                    Swal.fire('Başarılı!', data.message, 'success')
                        .then(() => {
                            // Reload page to show changes
                            window.location.reload();
                        });
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        console.log('🚨 DEBUG: Validation errors:', data.errors);
                        let errorMsg = 'Doğrulama hataları:\n\n';
                        Object.keys(data.errors).forEach(field => {
                            const fieldNames = {
                                'email': 'E-posta',
                                'firstName': 'Ad',
                                'lastName': 'Soyad',
                                'employee_id': 'Çalışan ID'
                            };
                            const fieldName = fieldNames[field] || field;
                            errorMsg += `• ${fieldName}: ${data.errors[field].join(', ')}\n`;
                        });
                        Swal.fire('Doğrulama Hatası!', errorMsg, 'error');
                    } else {
                        Swal.fire('Hata!', data.message || 'Güncelleme sırasında bir hata oluştu.', 'error');
                    }
                }
            })
            .catch(error => {
                console.error('🚨 DEBUG: Submit error:', error);
                Swal.fire('Hata!', 'Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
            });
        },
        
        openResetPasswordModal(adminId, fullName) {
            console.log('🚀 DEBUG: openResetPasswordModal called with:', { adminId, fullName });
            
            // Dispatch modal event
            window.dispatchEvent(new CustomEvent('open-reset-password-modal', {
                detail: {
                    admin: {
                        id: adminId,
                        fullName: fullName,
                        newPassword: ''
                    }
                }
            }));
        },
        
        generateNewPassword() {
            console.log('🚀 DEBUG: generateNewPassword called');
            const modal = document.querySelector('#resetPasswordModal');
            const adminData = Alpine.evaluate(modal, 'admin');
            
            if (!adminData.id) {
                Swal.fire('Hata!', 'Admin ID bulunamadı.', 'error');
                return;
            }
            
            // Show loading
            Swal.fire({
                title: 'Şifre Oluşturuluyor...',
                text: 'Yeni şifre oluşturuluyor ve e-posta gönderiliyor.',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            
            fetch(`{{ secure_url('/admin/dashboard/managers') }}/${adminData.id}/reset-password`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('🚀 DEBUG: Reset password response:', data);
                
                if (data.success) {
                    // Update modal data with new password
                    adminData.newPassword = data.newPassword || 'Şifre oluşturuldu ve e-posta gönderildi';
                    
                    Swal.fire({
                        title: 'Başarılı!',
                        text: data.message || 'Yeni şifre oluşturuldu ve kullanıcıya e-posta ile gönderildi.',
                        icon: 'success',
                        confirmButtonText: 'Tamam'
                    });
                } else {
                    Swal.fire('Hata!', data.message || 'Şifre sıfırlanırken bir hata oluştu.', 'error');
                }
            })
            .catch(error => {
                console.error('🚨 DEBUG: Reset password error:', error);
                Swal.fire('Hata!', 'Bir hata oluştu. Lütfen tekrar deneyin.', 'error');
            });
        },
        
        copyPassword() {
            const modal = document.querySelector('#resetPasswordModal');
            const adminData = Alpine.evaluate(modal, 'admin');
            
            if (adminData.newPassword && navigator.clipboard) {
                navigator.clipboard.writeText(adminData.newPassword).then(() => {
                    Swal.fire({
                        title: 'Kopyalandı!',
                        text: 'Şifre panoya kopyalandı.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                });
            }
        }
    }
}

// Initialize Lucide icons
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
});
</script>
@endpush