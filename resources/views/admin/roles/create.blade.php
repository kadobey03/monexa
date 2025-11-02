@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="roleFormManager()">
    
    <!-- Page Header -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="plus-circle" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-admin-900 dark:text-white">Yeni Rol Oluştur</h1>
                    <p class="text-admin-600 dark:text-admin-400">Yeni bir sistem rolü tanımlayın ve izinlerini atayın</p>
                </div>
            </div>
            
            <a href="{{ route('admin.roles.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 text-admin-700 dark:text-admin-300 rounded-xl transition-all duration-200">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                Geri Dön
            </a>
        </div>
    </div>

    <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Basic Information -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
            <h2 class="text-lg font-semibold text-admin-900 dark:text-white mb-6">Temel Bilgiler</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        Rol Adı <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="admin-input w-full @error('name') border-red-500 @enderror"
                           placeholder="admin, manager, user..."
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="display_name" class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        Görünen Ad <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="display_name" 
                           name="display_name" 
                           value="{{ old('display_name') }}"
                           class="admin-input w-full @error('display_name') border-red-500 @enderror"
                           placeholder="Yönetici, Kullanıcı..."
                           required>
                    @error('display_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        Açıklama
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              class="admin-input w-full @error('description') border-red-500 @enderror"
                              placeholder="Bu rolün yetkilerini ve sorumluluklarını açıklayın...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Hierarchy & Settings -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
            <h2 class="text-lg font-semibold text-admin-900 dark:text-white mb-6">Hiyerarşi ve Ayarlar</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="parent_role_id" class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        Üst Rol
                    </label>
                    <select id="parent_role_id" 
                            name="parent_role_id" 
                            class="admin-input w-full @error('parent_role_id') border-red-500 @enderror">
                        <option value="">Üst rol yok (Kök seviye)</option>
                        @foreach($parentRoles as $role)
                            <option value="{{ $role->id }}" {{ old('parent_role_id') == $role->id ? 'selected' : '' }}>
                                {{ str_repeat('- ', $role->hierarchy_level) }}{{ $role->display_name }} (Seviye {{ $role->hierarchy_level }})
                            </option>
                        @endforeach
                    </select>
                    @error('parent_role_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="department" class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        Departman
                    </label>
                    <select id="department" 
                            name="department" 
                            class="admin-input w-full @error('department') border-red-500 @enderror">
                        <option value="">Departman seç</option>
                        @foreach($departments as $key => $value)
                            <option value="{{ $key }}" {{ old('department') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                    @error('department')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="hierarchy_level" class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        Manuel Hiyerarşi Seviyesi
                    </label>
                    <input type="number" 
                           id="hierarchy_level" 
                           name="hierarchy_level" 
                           value="{{ old('hierarchy_level') }}"
                           min="0" 
                           max="10"
                           class="admin-input w-full @error('hierarchy_level') border-red-500 @enderror"
                           placeholder="Otomatik hesaplanacak">
                    @error('hierarchy_level')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Additional Settings -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="max_subordinates" class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        Maksimum Alt Personel
                    </label>
                    <input type="number" 
                           id="max_subordinates" 
                           name="max_subordinates" 
                           value="{{ old('max_subordinates') }}"
                           min="0"
                           class="admin-input w-full"
                           placeholder="Sınırsız">
                </div>
                
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="can_manage_subordinates" 
                               value="1"
                               {{ old('can_manage_subordinates') ? 'checked' : '' }}
                               class="rounded border-admin-300 dark:border-admin-600 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-admin-700 dark:text-admin-300">Alt personeli yönetebilir</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="can_assign_leads" 
                               value="1"
                               {{ old('can_assign_leads') ? 'checked' : '' }}
                               class="rounded border-admin-300 dark:border-admin-600 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-admin-700 dark:text-admin-300">Lead atayabilir</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="auto_assign_leads" 
                               value="1"
                               {{ old('auto_assign_leads') ? 'checked' : '' }}
                               class="rounded border-admin-300 dark:border-admin-600 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-admin-700 dark:text-admin-300">Otomatik lead atama</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-admin-300 dark:border-admin-600 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-admin-700 dark:text-admin-300">Aktif</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Permissions -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-admin-900 dark:text-white">İzinler</h2>
                <div class="flex items-center space-x-3">
                    <button type="button" @click="selectAll()" 
                            class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                        Tümünü Seç
                    </button>
                    <button type="button" @click="deselectAll()" 
                            class="text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200">
                        Hiçbirini Seçme
                    </button>
                </div>
            </div>
            
            <div class="space-y-6">
                @foreach($permissions as $category => $categoryPermissions)
                    <div class="border border-admin-200 dark:border-admin-600 rounded-xl">
                        <div class="p-4 bg-admin-50 dark:bg-admin-700/20 rounded-t-xl border-b border-admin-200 dark:border-admin-600">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       @change="toggleCategory('{{ $category }}')"
                                       class="rounded border-admin-300 dark:border-admin-600 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 font-medium text-admin-900 dark:text-white">
                                    {{ ucfirst(str_replace('_', ' ', $category)) }} ({{ count($categoryPermissions) }})
                                </span>
                            </label>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($categoryPermissions as $permission)
                                    <label class="flex items-start space-x-3 p-3 border border-admin-200 dark:border-admin-600 rounded-lg hover:bg-admin-50 dark:hover:bg-admin-700/20 transition-colors">
                                        <input type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $permission->id }}"
                                               data-category="{{ $category }}"
                                               {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}
                                               class="mt-0.5 rounded border-admin-300 dark:border-admin-600 text-blue-600 focus:ring-blue-500">
                                        <div class="flex-1">
                                            <p class="font-medium text-admin-900 dark:text-white text-sm">
                                                {{ $permission->display_name }}
                                            </p>
                                            @if($permission->description)
                                                <p class="text-xs text-admin-600 dark:text-admin-400 mt-1">
                                                    {{ $permission->description }}
                                                </p>
                                            @endif
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span class="px-1.5 py-0.5 text-xs font-medium rounded-md
                                                    {{ $permission->type === 'basic' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : '' }}
                                                    {{ $permission->type === 'advanced' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : '' }}
                                                    {{ $permission->type === 'system' ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' : '' }}
                                                    {{ $permission->type === 'management' ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : '' }}">
                                                    {{ ucfirst($permission->type) }}
                                                </span>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Form Actions -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('admin.roles.index') }}" 
                   class="px-6 py-2 border border-admin-300 dark:border-admin-600 text-admin-700 dark:text-admin-300 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700/50 transition-colors">
                    İptal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl shadow-lg hover:shadow-blue-500/25 transition-all duration-200">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                    Rolü Oluştur
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function roleFormManager() {
    return {
        init() {
            this.$nextTick(() => {
                lucide.createIcons();
            });
        },
        
        selectAll() {
            const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            this.updateCategoryCheckboxes();
        },
        
        deselectAll() {
            const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            this.updateCategoryCheckboxes();
        },
        
        toggleCategory(category) {
            const categoryCheckboxes = document.querySelectorAll(`input[data-category="${category}"]`);
            const categoryHeaderCheckbox = event.target;
            
            categoryCheckboxes.forEach(checkbox => {
                checkbox.checked = categoryHeaderCheckbox.checked;
            });
        },
        
        updateCategoryCheckboxes() {
            const categories = @json(array_keys($permissions->toArray()));
            
            categories.forEach(category => {
                const categoryCheckboxes = document.querySelectorAll(`input[data-category="${category}"]`);
                const categoryHeaderCheckbox = document.querySelector(`input[onchange*="${category}"]`);
                
                if (categoryHeaderCheckbox) {
                    const checkedCount = Array.from(categoryCheckboxes).filter(cb => cb.checked).length;
                    categoryHeaderCheckbox.checked = checkedCount === categoryCheckboxes.length;
                    categoryHeaderCheckbox.indeterminate = checkedCount > 0 && checkedCount < categoryCheckboxes.length;
                }
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
    
    // Update category checkboxes when individual permissions change
    document.querySelectorAll('input[name="permissions[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // Update category checkbox state
            const category = this.getAttribute('data-category');
            const categoryCheckboxes = document.querySelectorAll(`input[data-category="${category}"]`);
            const categoryHeaderCheckbox = document.querySelector(`input[onchange*="${category}"]`);
            
            if (categoryHeaderCheckbox) {
                const checkedCount = Array.from(categoryCheckboxes).filter(cb => cb.checked).length;
                categoryHeaderCheckbox.checked = checkedCount === categoryCheckboxes.length;
                categoryHeaderCheckbox.indeterminate = checkedCount > 0 && checkedCount < categoryCheckboxes.length;
            }
        });
    });
});
</script>
@endpush