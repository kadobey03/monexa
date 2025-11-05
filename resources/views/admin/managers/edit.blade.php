@extends('layouts.admin')

@section('content')
<div class="space-y-6" data-edit-manager-form>
    
    <!-- Page Header -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.managers.index') }}" 
                   class="p-2 rounded-lg bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 transition-colors">
                    <x-heroicon name="arrow-left" class="w-5 h-5 text-admin-600 dark:text-admin-400" />
                </a>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        @if($manager->getProfileImage())
                            <img src="{{ $manager->getProfileImage() }}" 
                                 alt="{{ $manager->getFullName() }}"
                                 class="w-12 h-12 rounded-xl object-cover border-2 border-white shadow-lg">
                        @else
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                                <x-heroicon name="user" class="w-6 h-6 text-white" />
                            </div>
                        @endif
                        <div class="absolute -top-1 -right-1 w-4 h-4 {{ $manager->is_active ? 'bg-green-500' : 'bg-red-500' }} rounded-full border-2 border-white"></div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-admin-900 dark:text-white">{{ $manager->getFullName() }}</h1>
                        <div class="flex items-center space-x-2">
                            @if($manager->role)
                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-medium rounded-lg">
                                    {{ $manager->role->display_name }}
                                </span>
                            @endif
                            @if($manager->department)
                                <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs font-medium rounded-lg">
                                    {{ $manager->getDepartmentName() }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.managers.show', $manager) }}" 
                   class="p-2 rounded-lg bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 transition-colors">
                    <x-heroicon name="eye" class="w-4 h-4 text-admin-600 dark:text-admin-400" />
                </a>
                <button data-toggle-status
                        class="p-2 rounded-lg transition-colors bg-green-100 dark:bg-green-900/30 hover:bg-green-200 dark:hover:bg-green-900/50">
                    <x-heroicon name="power" class="w-4 h-4 text-green-600 dark:text-green-400" />
                </button>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
        <div class="border-b border-admin-200 dark:border-admin-700">
            <nav class="flex space-x-8 px-6">
                <button data-tab="personal"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors border-blue-500 text-blue-600">
                    <x-heroicon name="user" class="w-4 h-4 inline mr-2" />
                    Kişisel Bilgiler
                </button>
                <button data-tab="role"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors border-transparent text-admin-500 hover:text-admin-700 hover:border-admin-300">
                    <x-heroicon name="shield-check" class="w-4 h-4 inline mr-2" />
                    Rol & Hiyerarşi
                </button>
                <button data-tab="performance"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors border-transparent text-admin-500 hover:text-admin-700 hover:border-admin-300">
                    <x-heroicon name="view-finder" class="w-4 h-4 inline mr-2" />
                    Performans
                </button>
                <button data-tab="security"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors border-transparent text-admin-500 hover:text-admin-700 hover:border-admin-300">
                    <x-heroicon name="lock-closed" class="w-4 h-4 inline mr-2" />
                    Güvenlik
                </button>
            </nav>
        </div>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('admin.managers.update', $manager) }}" enctype="multipart/form-data" data-edit-form>
        @csrf
        @method('PUT')
        
        <!-- Personal Information Tab -->
        <div data-tab-content="personal" class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="user" class="w-4 h-4 inline mr-1" />
                        Ad *
                    </label>
                    <input type="text" 
                           name="firstName" 
                           value="{{ old('firstName', $manager->firstName) }}"
                           required
                           class="admin-input w-full @error('firstName') border-red-500 @enderror"
                           placeholder="Adı girin">
                    @error('firstName')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Last Name -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="user" class="w-4 h-4 inline mr-1" />
                        Soyad *
                    </label>
                    <input type="text" 
                           name="lastName" 
                           value="{{ old('lastName', $manager->lastName) }}"
                           required
                           class="admin-input w-full @error('lastName') border-red-500 @enderror"
                           placeholder="Soyadı girin">
                    @error('lastName')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="envelope" class="w-4 h-4 inline mr-1" />
                        E-posta *
                    </label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email', $manager->email) }}"
                           required
                           class="admin-input w-full @error('email') border-red-500 @enderror"
                           placeholder="ornek@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="phone" class="w-4 h-4 inline mr-1" />
                        Telefon
                    </label>
                    <input type="text" 
                           name="phone" 
                           value="{{ old('phone', $manager->phone) }}"
                           class="admin-input w-full @error('phone') border-red-500 @enderror"
                           placeholder="+90 555 123 45 67">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Employee ID -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="id-card" class="w-4 h-4 inline mr-1" />
                        Çalışan ID
                    </label>
                    <input type="text" 
                           name="employee_id" 
                           value="{{ old('employee_id', $manager->employee_id) }}"
                           class="admin-input w-full @error('employee_id') border-red-500 @enderror"
                           placeholder="EMP001">
                    @error('employee_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Position -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="briefcase" class="w-4 h-4 inline mr-1" />
                        Pozisyon
                    </label>
                    <input type="text" 
                           name="position" 
                           value="{{ old('position', $manager->position) }}"
                           class="admin-input w-full @error('position') border-red-500 @enderror"
                           placeholder="Kıdemli Satış Uzmanı">
                    @error('position')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Bio -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                    <x-heroicon name="file-text" class="w-4 h-4 inline mr-1" />
                    Kısa Biografi
                </label>
                <textarea name="bio" 
                          rows="3"
                          class="admin-input w-full @error('bio') border-red-500 @enderror"
                          placeholder="Kısaca kendinizi tanıtın...">{{ old('bio', $manager->bio) }}</textarea>
                @error('bio')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Avatar Upload -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                    <x-heroicon name="camera" class="w-4 h-4 inline mr-1" />
                    Profil Fotoğrafı
                </label>
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        @if($manager->getProfileImage())
                            <img src="{{ $manager->getProfileImage() }}" 
                                 alt="{{ $manager->getFullName() }}"
                                 data-current-avatar
                                 class="w-20 h-20 rounded-full object-cover border-2 border-admin-200 dark:border-admin-700">
                        @else
                            <div class="w-20 h-20 bg-admin-200 dark:bg-admin-700 rounded-full flex items-center justify-center" 
                                 data-current-avatar>
                                <x-heroicon name="user" class="w-8 h-8 text-admin-400" />
                            </div>
                        @endif
                        <img data-avatar-preview
                             style="display: none;"
                             class="w-20 h-20 rounded-full object-cover border-2 border-admin-200 dark:border-admin-700">
                    </div>
                    <div class="flex-1">
                        <input type="file" 
                               name="avatar" 
                               accept="image/*"
                               class="admin-input w-full @error('avatar') border-red-500 @enderror"
                               data-avatar-input>
                        <p class="text-xs text-admin-500 mt-1">JPG, PNG, GIF formatında maksimum 2MB</p>
                        <div class="flex items-center space-x-2 mt-2">
                            @if($manager->getProfileImage())
                                <button type="button" 
                                        data-remove-current-avatar
                                        class="text-xs text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                    <x-heroicon name="trash-2" class="w-3 h-3 inline mr-1" />
                                    Mevcut fotoğrafı kaldır
                                </button>
                            @endif
                            <button type="button" 
                                    data-cancel-avatar-preview
                                    style="display: none;"
                                    class="text-xs text-admin-600 hover:text-admin-700 dark:text-admin-400 dark:hover:text-admin-300">
                                <x-heroicon name="x-mark" class="w-3 h-3 inline mr-1" />
                                İptal
                            </button>
                        </div>
                        @error('avatar')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Role & Hierarchy Tab -->
        <div data-tab-content="role" style="display: none;" class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="shield-check" class="w-4 h-4 inline mr-1" />
                        Rol *
                    </label>
                    <select name="role_id" 
                            required
                            data-role-select
                            class="admin-input w-full @error('role_id') border-red-500 @enderror">
                        <option value="">Rol seçin</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" 
                                    data-hierarchy="{{ $role->hierarchy_level }}"
                                    data-department="{{ $role->getDepartment() }}"
                                    {{ old('role_id', $manager->role_id) == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name }} (Seviye {{ $role->hierarchy_level }})
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    
                    <!-- Role Change Warning -->
                    @if($manager->role_id != old('role_id'))
                        <div data-role-changed-warning style="display: none;" class="mt-2 p-3 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-200 dark:border-amber-800">
                            <p class="text-sm text-amber-800 dark:text-amber-300">
                                <x-heroicon name="exclamation-triangle" class="w-4 h-4 inline mr-1" />
                                Rol değiştirme işlemi yetkileri de etkileyecektir.
                            </p>
                        </div>
                    @endif
                </div>
                
                <!-- Supervisor -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="user-check" class="w-4 h-4 inline mr-1" />
                        Süpervizör
                    </label>
                    <select name="supervisor_id" 
                            class="admin-input w-full @error('supervisor_id') border-red-500 @enderror">
                        <option value="">Süpervizör seçin (isteğe bağlı)</option>
                        @foreach($supervisors as $supervisor)
                            @if($supervisor->id !== $manager->id)
                                <option value="{{ $supervisor->id }}" 
                                        {{ old('supervisor_id', $manager->supervisor_id) == $supervisor->id ? 'selected' : '' }}>
                                    {{ $supervisor->getFullName() }} 
                                    @if($supervisor->role)
                                        ({{ $supervisor->role->display_name }})
                                    @endif
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('supervisor_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Department -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="building" class="w-4 h-4 inline mr-1" />
                        Departman *
                    </label>
                    <select name="department" 
                            required
                            class="admin-input w-full @error('department') border-red-500 @enderror">
                        <option value="">Departman seçin</option>
                        @foreach($departments as $key => $dept)
                            <option value="{{ $key }}" {{ old('department', $manager->department) == $key ? 'selected' : '' }}>
                                {{ $dept }}
                            </option>
                        @endforeach
                    </select>
                    @error('department')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Admin Group -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="users" class="w-4 h-4 inline mr-1" />
                        Yönetici Grubu
                    </label>
                    <select name="admin_group_id" 
                            class="admin-input w-full @error('admin_group_id') border-red-500 @enderror">
                        <option value="">Grup seçin (isteğe bağlı)</option>
                        @foreach($adminGroups as $group)
                            <option value="{{ $group->id }}" {{ old('admin_group_id', $manager->admin_group_id) == $group->id ? 'selected' : '' }}>
                                {{ $group->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('admin_group_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Subordinates Info -->
            @if($manager->subordinates()->count() > 0)
                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300 mb-2">
                        <x-heroicon name="users" class="w-4 h-4 inline mr-1" />
                        Alt Yöneticiler ({{ $manager->subordinates()->count() }})
                    </h3>
                    <div class="space-y-2">
                        @foreach($manager->subordinates()->take(5)->get() as $subordinate)
                            <div class="flex items-center space-x-3">
                                @if($subordinate->getProfileImage())
                                    <img src="{{ $subordinate->getProfileImage() }}" 
                                         class="w-6 h-6 rounded-full object-cover">
                                @else
                                    <div class="w-6 h-6 bg-admin-200 dark:bg-admin-700 rounded-full flex items-center justify-center">
                                        <x-heroicon name="user" class="w-3 h-3 text-admin-400" />
                                    </div>
                                @endif
                                <span class="text-sm text-blue-700 dark:text-blue-300">
                                    {{ $subordinate->getFullName() }}
                                </span>
                                @if($subordinate->role)
                                    <span class="text-xs text-blue-600 dark:text-blue-400">
                                        ({{ $subordinate->role->display_name }})
                                    </span>
                                @endif
                            </div>
                        @endforeach
                        @if($manager->subordinates()->count() > 5)
                            <p class="text-xs text-blue-600 dark:text-blue-400">
                                ve {{ $manager->subordinates()->count() - 5 }} kişi daha...
                            </p>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Performance Tab -->
        <div data-tab-content="performance" style="display: none;" class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
            <!-- Current Performance Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 p-4 rounded-xl border border-green-200 dark:border-green-800">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                            <x-heroicon name="arrow-trending-up" class="w-5 h-5 text-white" />
                        </div>
                        <div>
                            <p class="text-xs text-green-600 dark:text-green-400 font-medium">Bu Ay</p>
                            <p class="text-lg font-bold text-green-700 dark:text-green-300">
                                ₺{{ number_format($manager->getCurrentMonthRevenue(), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 p-4 rounded-xl border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                            <x-heroicon name="view-finder" class="w-5 h-5 text-white" />
                        </div>
                        <div>
                            <p class="text-xs text-blue-600 dark:text-blue-400 font-medium">Hedef</p>
                            <p class="text-lg font-bold text-blue-700 dark:text-blue-300">
                                ₺{{ number_format($manager->monthly_target ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 p-4 rounded-xl border border-purple-200 dark:border-purple-800">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                            <x-heroicon name="percent" class="w-5 h-5 text-white" />
                        </div>
                        <div>
                            <p class="text-xs text-purple-600 dark:text-purple-400 font-medium">Başarı</p>
                            <p class="text-lg font-bold text-purple-700 dark:text-purple-300">
                                {{ number_format($manager->getSuccessRate(), 1) }}%
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 p-4 rounded-xl border border-amber-200 dark:border-amber-800">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center">
                            <x-heroicon name="users" class="w-5 h-5 text-white" />
                        </div>
                        <div>
                            <p class="text-xs text-amber-600 dark:text-amber-400 font-medium">Toplam Lead</p>
                            <p class="text-lg font-bold text-amber-700 dark:text-amber-300">
                                {{ number_format($manager->getTotalLeads()) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Performance Settings -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Monthly Target -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="view-finder" class="w-4 h-4 inline mr-1" />
                        Aylık Hedef
                    </label>
                    <div class="relative">
                        <input type="number" 
                               name="monthly_target" 
                               value="{{ old('monthly_target', $manager->monthly_target) }}"
                               step="0.01"
                               min="0"
                               class="admin-input w-full pl-8 @error('monthly_target') border-red-500 @enderror"
                               placeholder="10000">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-admin-400">₺</span>
                    </div>
                    @error('monthly_target')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Max Leads Per Day -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="users" class="w-4 h-4 inline mr-1" />
                        Günlük Max Lead
                    </label>
                    <input type="number" 
                           name="max_leads_per_day" 
                           value="{{ old('max_leads_per_day', $manager->max_leads_per_day ?? 50) }}"
                           min="1"
                           max="500"
                           class="admin-input w-full @error('max_leads_per_day') border-red-500 @enderror"
                           placeholder="50">
                    @error('max_leads_per_day')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Time Zone -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="clock" class="w-4 h-4 inline mr-1" />
                        Saat Dilimi
                    </label>
                    <select name="time_zone" 
                            class="admin-input w-full @error('time_zone') border-red-500 @enderror">
                        <option value="Europe/Istanbul" {{ old('time_zone', $manager->time_zone ?? 'Europe/Istanbul') == 'Europe/Istanbul' ? 'selected' : '' }}>
                            İstanbul (UTC+3)
                        </option>
                        <option value="UTC" {{ old('time_zone', $manager->time_zone) == 'UTC' ? 'selected' : '' }}>
                            UTC (UTC+0)
                        </option>
                        <option value="Europe/London" {{ old('time_zone', $manager->time_zone) == 'Europe/London' ? 'selected' : '' }}>
                            Londra (UTC+0/+1)
                        </option>
                        <option value="America/New_York" {{ old('time_zone', $manager->time_zone) == 'America/New_York' ? 'selected' : '' }}>
                            New York (UTC-5/-4)
                        </option>
                    </select>
                    @error('time_zone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Security Tab -->
        <div data-tab-content="security" style="display: none;" class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
            <!-- Password Change -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- New Password -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="key" class="w-4 h-4 inline mr-1" />
                        Yeni Şifre
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="password" 
                               data-password-input
                               class="admin-input w-full pr-10 @error('password') border-red-500 @enderror"
                               placeholder="Boş bırakın değiştirmek istemiyorsanız">
                        <button type="button" 
                                data-toggle-password="password"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <x-heroicon name="question-mark-circle" class="w-4 h-4 text-admin-400 hover:text-admin-600" />
                        </button>
                    </div>
                    
                    <!-- Password Strength Indicator -->
                    <div class="mt-2" data-password-strength style="display: none;">
                        <div class="flex items-center space-x-2">
                            <div class="flex-1 bg-admin-200 dark:bg-admin-700 rounded-full h-1">
                                <div class="h-1 rounded-full transition-all duration-300 bg-red-500 w-1/4" data-strength-bar></div>
                            </div>
                            <span class="text-xs font-medium text-red-600 dark:text-red-400" data-strength-text>Zayıf</span>
                        </div>
                    </div>
                    
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="lock-closed" class="w-4 h-4 inline mr-1" />
                        Şifre Onayı
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="password_confirmation" 
                               data-password-confirmation
                               class="admin-input w-full pr-10 @error('password_confirmation') border-red-500 @enderror"
                               placeholder="Yeni şifrenizi tekrar girin">
                        <button type="button" 
                                data-toggle-password="confirmation"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <x-heroicon name="question-mark-circle" class="w-4 h-4 text-admin-400 hover:text-admin-600" />
                        </button>
                    </div>
                    
                    <!-- Password Match Indicator -->
                    <div data-password-match style="display: none;" class="mt-1">
                        <p class="text-sm text-red-600 dark:text-red-400">
                            <x-heroicon name="x-circle" class="w-3 h-3 inline mr-1" />
                            <span data-match-text>Şifreler eşleşmiyor</span>
                        </p>
                    </div>
                    
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Account Status -->
            <div class="mt-6 p-4 bg-admin-50 dark:bg-admin-700/50 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-admin-900 dark:text-white">Hesap Durumu</h3>
                        <p class="text-sm text-admin-600 dark:text-admin-400">
                            Hesap şu anda 
                            <span class="{{ $manager->is_active ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $manager->is_active ? 'aktif' : 'pasif' }}
                            </span>
                        </p>
                    </div>
                    <label class="flex items-center">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               data-is-active
                               {{ old('is_active', $manager->is_active) ? 'checked' : '' }}
                               class="sr-only">
                        <div class="relative">
                            <div class="block {{ $manager->is_active ? 'bg-green-500 dark:bg-green-600' : 'bg-admin-300 dark:bg-admin-600' }} w-14 h-8 rounded-full cursor-pointer"
                                 data-toggle-bg></div>
                            <div class="absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition {{ $manager->is_active ? 'transform translate-x-6' : '' }}"
                                 data-toggle-dot></div>
                        </div>
                    </label>
                </div>
            </div>
            
            <!-- Last Login Info -->
            @if($manager->last_login_at)
                <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                    <p class="text-sm text-blue-800 dark:text-blue-300">
                        <x-heroicon name="clock" class="w-4 h-4 inline mr-1" />
                        Son giriş: {{ $manager->last_login_at->format('d.m.Y H:i') }}
                        @if($manager->last_login_ip)
                            ({{ $manager->last_login_ip }})
                        @endif
                    </p>
                </div>
            @endif
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between pt-6">
            <a href="{{ route('admin.managers.index') }}" 
               class="inline-flex items-center px-6 py-3 border border-admin-300 dark:border-admin-600 shadow-sm text-sm font-medium rounded-xl text-admin-700 dark:text-admin-300 bg-white dark:bg-admin-800 hover:bg-admin-50 dark:hover:bg-admin-700 transition-all duration-200">
                <x-heroicon name="x-mark" class="w-4 h-4 mr-2" />
                İptal
            </a>
            
            <div class="flex items-center space-x-3">
                <!-- View Profile -->
                <a href="{{ route('admin.managers.show', $manager) }}"
                   class="inline-flex items-center px-6 py-3 border border-admin-300 dark:border-admin-600 shadow-sm text-sm font-medium rounded-xl text-admin-700 dark:text-admin-300 bg-white dark:bg-admin-800 hover:bg-admin-50 dark:hover:bg-admin-700 transition-all duration-200">
                    <x-heroicon name="eye" class="w-4 h-4 mr-2" />
                    Profili Görüntüle
                </a>
                
                <!-- Save Changes -->
                <button type="submit" 
                        data-save-button
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-xl shadow-lg hover:shadow-blue-500/25 transition-all duration-200">
                    <x-heroicon name="save" class="w-4 h-4 mr-2" />
                    Değişiklikleri Kaydet
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Remove Avatar Modal -->
<div data-remove-avatar-modal
     style="display: none;"
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold text-admin-900 dark:text-white mb-4">
            Profil Fotoğrafını Kaldır
        </h3>
        <p class="text-admin-600 dark:text-admin-400 mb-6">
            Bu yöneticinin profil fotoğrafını kalıcı olarak kaldırmak istediğinizden emin misiniz?
        </p>
        <div class="flex items-center justify-end space-x-3">
            <button data-cancel-remove-avatar
                    class="px-4 py-2 text-admin-600 dark:text-admin-400 hover:text-admin-800 dark:hover:text-admin-200">
                İptal
            </button>
            <button data-confirm-remove-avatar
                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg">
                Kaldır
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
class EditManagerForm {
    constructor() {
        this.activeTab = 'personal';
        this.selectedRole = '{{ old("role_id", $manager->role_id) }}';
        this.isActive = {{ old('is_active', $manager->is_active) ? 'true' : 'false' }};
        this.roleInfo = '';
        this.avatarPreview = null;
        this.showRemoveAvatarModal = false;
        this.passwordStrength = '';
        this.passwordStrengthText = '';
        this.showPassword = false;
        this.showPasswordConfirmation = false;
        this.passwordsMatch = false;
        this.passwordMatchStatus = false;
        this.originalFormData = {};
        
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.storeOriginalFormData();
        this.updateRoleInfo();
    }
    
    setupEventListeners() {
        // Tab switching
        document.querySelectorAll('[data-tab]').forEach(tab => {
            tab.addEventListener('click', (e) => {
                const tabName = e.target.getAttribute('data-tab');
                this.switchTab(tabName);
            });
        });
        
        // Toggle status
        const toggleButton = document.querySelector('[data-toggle-status]');
        if (toggleButton) {
            toggleButton.addEventListener('click', () => this.toggleStatus());
        }
        
        // Avatar handling
        const avatarInput = document.querySelector('[data-avatar-input]');
        if (avatarInput) {
            avatarInput.addEventListener('change', (e) => this.previewAvatar(e));
        }
        
        const removeCurrentAvatar = document.querySelector('[data-remove-current-avatar]');
        if (removeCurrentAvatar) {
            removeCurrentAvatar.addEventListener('click', () => this.removeCurrentAvatar());
        }
        
        const cancelAvatarPreview = document.querySelector('[data-cancel-avatar-preview]');
        if (cancelAvatarPreview) {
            cancelAvatarPreview.addEventListener('click', () => this.cancelAvatarPreview());
        }
        
        // Role select
        const roleSelect = document.querySelector('[data-role-select]');
        if (roleSelect) {
            roleSelect.addEventListener('change', () => this.updateRoleInfo());
        }
        
        // Password handling
        const passwordInput = document.querySelector('[data-password-input]');
        if (passwordInput) {
            passwordInput.addEventListener('input', () => this.checkPasswordStrength());
        }
        
        const passwordConfirmation = document.querySelector('[data-password-confirmation]');
        if (passwordConfirmation) {
            passwordConfirmation.addEventListener('input', () => this.checkPasswordMatch());
        }
        
        // Password visibility toggles
        document.querySelectorAll('[data-toggle-password]').forEach(toggle => {
            toggle.addEventListener('click', (e) => {
                const field = e.target.getAttribute('data-toggle-password');
                this.togglePasswordVisibility(field);
            });
        });
        
        // Modal handling
        const cancelRemoveAvatar = document.querySelector('[data-cancel-remove-avatar]');
        if (cancelRemoveAvatar) {
            cancelRemoveAvatar.addEventListener('click', () => this.closeRemoveAvatarModal());
        }
        
        const confirmRemoveAvatar = document.querySelector('[data-confirm-remove-avatar]');
        if (confirmRemoveAvatar) {
            confirmRemoveAvatar.addEventListener('click', () => this.confirmRemoveAvatar());
        }
        
        // Active status toggle
        const isActiveCheckbox = document.querySelector('[data-is-active]');
        if (isActiveCheckbox) {
            isActiveCheckbox.addEventListener('change', (e) => {
                this.isActive = e.target.checked;
                this.updateToggleVisuals();
            });
        }
        
        // Form change detection
        const form = document.querySelector('[data-edit-form]');
        if (form) {
            form.addEventListener('input', () => this.checkFormChanges());
        }
    }
    
    switchTab(tabName) {
        // Remove active class from all tabs
        document.querySelectorAll('[data-tab]').forEach(tab => {
            tab.classList.remove('border-blue-500', 'text-blue-600');
            tab.classList.add('border-transparent', 'text-admin-500');
        });
        
        // Hide all tab contents
        document.querySelectorAll('[data-tab-content]').forEach(content => {
            content.style.display = 'none';
        });
        
        // Show active tab
        const activeTab = document.querySelector(`[data-tab="${tabName}"]`);
        if (activeTab) {
            activeTab.classList.remove('border-transparent', 'text-admin-500');
            activeTab.classList.add('border-blue-500', 'text-blue-600');
        }
        
        const activeContent = document.querySelector(`[data-tab-content="${tabName}"]`);
        if (activeContent) {
            activeContent.style.display = 'block';
        }
        
        this.activeTab = tabName;
    }
    
    get hasChanges() {
        const currentData = this.getCurrentFormData();
        return JSON.stringify(currentData) !== JSON.stringify(this.originalFormData);
    }
    
    get roleChanged() {
        const roleSelect = document.querySelector('[data-role-select]');
        return roleSelect && roleSelect.value != '{{ $manager->role_id }}';
    }
    
    storeOriginalFormData() {
        const form = document.querySelector('[data-edit-form]');
        if (!form) return;
        
        const formData = new FormData(form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            if (key !== '_token' && key !== '_method') {
                data[key] = value;
            }
        }
        
        this.originalFormData = data;
    }
    
    getCurrentFormData() {
        const form = document.querySelector('[data-edit-form]');
        if (!form) return {};
        
        const formData = new FormData(form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            if (key !== '_token' && key !== '_method') {
                data[key] = value;
            }
        }
        
        return data;
    }
    
    checkFormChanges() {
        const saveButton = document.querySelector('[data-save-button]');
        if (saveButton) {
            if (this.hasChanges) {
                saveButton.disabled = false;
                saveButton.classList.remove('opacity-50', 'cursor-not-allowed');
                saveButton.classList.add('opacity-100');
            } else {
                saveButton.disabled = true;
                saveButton.classList.add('opacity-50', 'cursor-not-allowed');
                saveButton.classList.remove('opacity-100');
            }
        }
    }
    
    updateRoleInfo() {
        const select = document.querySelector('[data-role-select]');
        if (!select) return;
        
        const option = select.options[select.selectedIndex];
        
        if (option.value) {
            const hierarchy = option.getAttribute('data-hierarchy');
            const department = option.getAttribute('data-department');
            
            this.roleInfo = `Hiyerarşi Seviyesi: ${hierarchy}`;
            if (department) {
                this.roleInfo += ` • Departman: ${department}`;
            }
        } else {
            this.roleInfo = '';
        }
        
        // Show/hide role change warning
        const warning = document.querySelector('[data-role-changed-warning]');
        if (warning) {
            if (this.roleChanged) {
                warning.style.display = 'block';
            } else {
                warning.style.display = 'none';
            }
        }
    }
    
    toggleStatus() {
        this.isActive = !this.isActive;
        const checkbox = document.querySelector('[data-is-active]');
        if (checkbox) {
            checkbox.checked = this.isActive;
        }
        this.updateToggleVisuals();
    }
    
    updateToggleVisuals() {
        const toggleBg = document.querySelector('[data-toggle-bg]');
        const toggleDot = document.querySelector('[data-toggle-dot]');
        
        if (toggleBg) {
            if (this.isActive) {
                toggleBg.classList.remove('bg-admin-300', 'dark:bg-admin-600');
                toggleBg.classList.add('bg-green-500', 'dark:bg-green-600');
            } else {
                toggleBg.classList.add('bg-admin-300', 'dark:bg-admin-600');
                toggleBg.classList.remove('bg-green-500', 'dark:bg-green-600');
            }
        }
        
        if (toggleDot) {
            if (this.isActive) {
                toggleDot.classList.add('transform', 'translate-x-6');
            } else {
                toggleDot.classList.remove('transform', 'translate-x-6');
            }
        }
    }
    
    previewAvatar(event) {
        const file = event.target.files[0];
        const preview = document.querySelector('[data-avatar-preview]');
        const currentAvatars = document.querySelectorAll('[data-current-avatar]');
        const cancelButton = document.querySelector('[data-cancel-avatar-preview]');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.avatarPreview = e.target.result;
                if (preview) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                currentAvatars.forEach(avatar => {
                    avatar.style.display = 'none';
                });
                if (cancelButton) {
                    cancelButton.style.display = 'inline-block';
                }
            };
            reader.readAsDataURL(file);
        } else {
            this.cancelAvatarPreview();
        }
    }
    
    cancelAvatarPreview() {
        this.avatarPreview = null;
        const preview = document.querySelector('[data-avatar-preview]');
        const currentAvatars = document.querySelectorAll('[data-current-avatar]');
        const cancelButton = document.querySelector('[data-cancel-avatar-preview]');
        const avatarInput = document.querySelector('[data-avatar-input]');
        
        if (preview) {
            preview.style.display = 'none';
        }
        currentAvatars.forEach(avatar => {
            avatar.style.display = 'block';
        });
        if (cancelButton) {
            cancelButton.style.display = 'none';
        }
        if (avatarInput) {
            avatarInput.value = '';
        }
    }
    
    removeCurrentAvatar() {
        const modal = document.querySelector('[data-remove-avatar-modal]');
        if (modal) {
            modal.style.display = 'flex';
            this.showRemoveAvatarModal = true;
        }
    }
    
    closeRemoveAvatarModal() {
        const modal = document.querySelector('[data-remove-avatar-modal]');
        if (modal) {
            modal.style.display = 'none';
            this.showRemoveAvatarModal = false;
        }
    }
    
    confirmRemoveAvatar() {
        const form = document.querySelector('[data-edit-form]');
        if (form) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_avatar';
            input.value = '1';
            form.appendChild(input);
        }
        
        this.closeRemoveAvatarModal();
        
        // Show success message
        if (typeof Swal !== 'undefined') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            
            Toast.fire({
                icon: 'success',
                title: 'Profil fotoğrafı kaldırılacak'
            });
        }
    }
    
    togglePasswordVisibility(field) {
        if (field === 'password') {
            this.showPassword = !this.showPassword;
            const passwordInput = document.querySelector('[data-password-input]');
            if (passwordInput) {
                passwordInput.type = this.showPassword ? 'text' : 'password';
            }
        } else if (field === 'confirmation') {
            this.showPasswordConfirmation = !this.showPasswordConfirmation;
            const confirmationInput = document.querySelector('[data-password-confirmation]');
            if (confirmationInput) {
                confirmationInput.type = this.showPasswordConfirmation ? 'text' : 'password';
            }
        }
    }
    
    checkPasswordStrength() {
        const passwordInput = document.querySelector('[data-password-input]');
        const strengthContainer = document.querySelector('[data-password-strength]');
        const strengthBar = document.querySelector('[data-strength-bar]');
        const strengthText = document.querySelector('[data-strength-text]');
        
        if (!passwordInput || !strengthContainer || !strengthBar || !strengthText) return;
        
        const password = passwordInput.value;
        
        if (password.length === 0) {
            strengthContainer.style.display = 'none';
            this.passwordStrength = '';
            return;
        }
        
        strengthContainer.style.display = 'block';
        let score = 0;
        
        // Length
        if (password.length >= 8) score++;
        if (password.length >= 12) score++;
        
        // Character types
        if (/[a-z]/.test(password)) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;
        
        // Reset classes
        strengthBar.className = 'h-1 rounded-full transition-all duration-300';
        strengthText.className = 'text-xs font-medium';
        
        if (score <= 2) {
            this.passwordStrength = 'weak';
            this.passwordStrengthText = 'Zayıf';
            strengthBar.classList.add('bg-red-500', 'w-1/4');
            strengthText.classList.add('text-red-600', 'dark:text-red-400');
        } else if (score <= 4) {
            this.passwordStrength = 'medium';
            this.passwordStrengthText = 'Orta';
            strengthBar.classList.add('bg-amber-500', 'w-2/4');
            strengthText.classList.add('text-amber-600', 'dark:text-amber-400');
        } else if (score <= 5) {
            this.passwordStrength = 'strong';
            this.passwordStrengthText = 'Güçlü';
            strengthBar.classList.add('bg-green-500', 'w-3/4');
            strengthText.classList.add('text-green-600', 'dark:text-green-400');
        } else {
            this.passwordStrength = 'very-strong';
            this.passwordStrengthText = 'Çok Güçlü';
            strengthBar.classList.add('bg-emerald-500', 'w-full');
            strengthText.classList.add('text-emerald-600', 'dark:text-emerald-400');
        }
        
        strengthText.textContent = this.passwordStrengthText;
    }
    
    checkPasswordMatch() {
        const passwordInput = document.querySelector('[data-password-input]');
        const confirmationInput = document.querySelector('[data-password-confirmation]');
        const matchContainer = document.querySelector('[data-password-match]');
        const matchText = document.querySelector('[data-match-text]');
        
        if (!passwordInput || !confirmationInput || !matchContainer || !matchText) return;
        
        const password = passwordInput.value;
        const confirmation = confirmationInput.value;
        
        if (confirmation.length === 0 && password.length === 0) {
            matchContainer.style.display = 'none';
            this.passwordMatchStatus = false;
            return;
        }
        
        if (confirmation.length === 0) {
            matchContainer.style.display = 'none';
            return;
        }
        
        this.passwordMatchStatus = true;
        this.passwordsMatch = password === confirmation;
        matchContainer.style.display = 'block';
        
        const p = matchContainer.querySelector('p');
        if (this.passwordsMatch) {
            p.className = 'text-sm text-green-600 dark:text-green-400';
            matchText.textContent = 'Şifreler eşleşiyor';
            // Update icon to check
            const icon = p.querySelector('svg');
            if (icon) {
                icon.className = 'w-3 h-3 inline mr-1';
                // You might want to update the icon here
            }
        } else {
            p.className = 'text-sm text-red-600 dark:text-red-400';
            matchText.textContent = 'Şifreler eşleşmiyor';
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    new EditManagerForm();
});
</script>
@endpush