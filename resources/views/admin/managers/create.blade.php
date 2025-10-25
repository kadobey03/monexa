@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="createManagerForm()">
    
    <!-- Page Header -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.managers.index') }}" 
               class="p-2 rounded-lg bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5 text-admin-600 dark:text-admin-400"></i>
            </a>
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="user-plus" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-admin-900 dark:text-white">Yeni Yönetici Ekle</h1>
                    <p class="text-admin-600 dark:text-admin-400">Sisteme yeni bir yönetici hesabı ekleyin</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('admin.managers.store') }}" enctype="multipart/form-data" x-ref="createForm">
        @csrf
        
        <!-- Personal Information -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="user" class="w-4 h-4 text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-admin-900 dark:text-white">Kişisel Bilgiler</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <i data-lucide="user" class="w-4 h-4 inline mr-1"></i>
                        Ad *
                    </label>
                    <input type="text" 
                           name="firstName" 
                           value="{{ old('firstName') }}"
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
                        <i data-lucide="user" class="w-4 h-4 inline mr-1"></i>
                        Soyad *
                    </label>
                    <input type="text" 
                           name="lastName" 
                           value="{{ old('lastName') }}"
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
                        <i data-lucide="mail" class="w-4 h-4 inline mr-1"></i>
                        E-posta *
                    </label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}"
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
                        <i data-lucide="phone" class="w-4 h-4 inline mr-1"></i>
                        Telefon
                    </label>
                    <input type="text" 
                           name="phone" 
                           value="{{ old('phone') }}"
                           class="admin-input w-full @error('phone') border-red-500 @enderror"
                           placeholder="+90 555 123 45 67">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Employee ID -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <i data-lucide="id-card" class="w-4 h-4 inline mr-1"></i>
                        Çalışan ID
                    </label>
                    <input type="text" 
                           name="employee_id" 
                           value="{{ old('employee_id') }}"
                           class="admin-input w-full @error('employee_id') border-red-500 @enderror"
                           placeholder="EMP001">
                    @error('employee_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Position -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <i data-lucide="briefcase" class="w-4 h-4 inline mr-1"></i>
                        Pozisyon
                    </label>
                    <input type="text" 
                           name="position" 
                           value="{{ old('position') }}"
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
                    <i data-lucide="file-text" class="w-4 h-4 inline mr-1"></i>
                    Kısa Biografi
                </label>
                <textarea name="bio" 
                          rows="3"
                          class="admin-input w-full @error('bio') border-red-500 @enderror"
                          placeholder="Kısaca kendinizi tanıtın...">{{ old('bio') }}</textarea>
                @error('bio')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Avatar Upload -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                    <i data-lucide="camera" class="w-4 h-4 inline mr-1"></i>
                    Profil Fotoğrafı
                </label>
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        <div class="w-20 h-20 bg-admin-200 dark:bg-admin-700 rounded-full flex items-center justify-center" 
                             x-show="!avatarPreview">
                            <i data-lucide="user" class="w-8 h-8 text-admin-400"></i>
                        </div>
                        <img x-show="avatarPreview" 
                             :src="avatarPreview" 
                             class="w-20 h-20 rounded-full object-cover">
                    </div>
                    <div class="flex-1">
                        <input type="file" 
                               name="avatar" 
                               accept="image/*"
                               class="admin-input w-full @error('avatar') border-red-500 @enderror"
                               @change="previewAvatar($event)">
                        <p class="text-xs text-admin-500 mt-1">JPG, PNG, GIF formatında maksimum 2MB</p>
                        @error('avatar')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Role & Hierarchy -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700 mt-6">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="shield" class="w-4 h-4 text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-admin-900 dark:text-white">Rol ve Hiyerarşi</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <i data-lucide="shield" class="w-4 h-4 inline mr-1"></i>
                        Rol *
                    </label>
                    <select name="role_id" 
                            required
                            x-model="selectedRole"
                            @change="updateRoleInfo()"
                            class="admin-input w-full @error('role_id') border-red-500 @enderror">
                        <option value="">Rol seçin</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" 
                                    data-hierarchy="{{ $role->hierarchy_level }}"
                                    data-department="{{ $role->getDepartment() }}"
                                    {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name }} (Seviye {{ $role->hierarchy_level }})
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    
                    <!-- Role Info -->
                    <div x-show="roleInfo" x-transition class="mt-2 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <p class="text-sm text-blue-800 dark:text-blue-300" x-text="roleInfo"></p>
                    </div>
                </div>
                
                <!-- Supervisor -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <i data-lucide="user-check" class="w-4 h-4 inline mr-1"></i>
                        Süpervizör
                    </label>
                    <select name="supervisor_id" 
                            class="admin-input w-full @error('supervisor_id') border-red-500 @enderror">
                        <option value="">Süpervizör seçin (isteğe bağlı)</option>
                        @foreach($supervisors as $supervisor)
                            <option value="{{ $supervisor->id }}" 
                                    {{ old('supervisor_id') == $supervisor->id ? 'selected' : '' }}>
                                {{ $supervisor->getFullName() }} 
                                @if($supervisor->role)
                                    ({{ $supervisor->role->display_name }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('supervisor_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Department -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <i data-lucide="building" class="w-4 h-4 inline mr-1"></i>
                        Departman *
                    </label>
                    <select name="department" 
                            required
                            class="admin-input w-full @error('department') border-red-500 @enderror">
                        <option value="">Departman seçin</option>
                        @foreach($departments as $key => $dept)
                            <option value="{{ $key }}" {{ old('department') == $key ? 'selected' : '' }}>
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
                        <i data-lucide="users" class="w-4 h-4 inline mr-1"></i>
                        Yönetici Grubu
                    </label>
                    <select name="admin_group_id" 
                            class="admin-input w-full @error('admin_group_id') border-red-500 @enderror">
                        <option value="">Grup seçin (isteğe bağlı)</option>
                        @foreach($adminGroups as $group)
                            <option value="{{ $group->id }}" {{ old('admin_group_id') == $group->id ? 'selected' : '' }}>
                                {{ $group->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('admin_group_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Performance & Goals -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700 mt-6">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="target" class="w-4 h-4 text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-admin-900 dark:text-white">Performans ve Hedefler</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Monthly Target -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <i data-lucide="target" class="w-4 h-4 inline mr-1"></i>
                        Aylık Hedef
                    </label>
                    <div class="relative">
                        <input type="number" 
                               name="monthly_target" 
                               value="{{ old('monthly_target') }}"
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
                        <i data-lucide="users" class="w-4 h-4 inline mr-1"></i>
                        Günlük Max Lead
                    </label>
                    <input type="number" 
                           name="max_leads_per_day" 
                           value="{{ old('max_leads_per_day', 50) }}"
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
                        <i data-lucide="clock" class="w-4 h-4 inline mr-1"></i>
                        Saat Dilimi
                    </label>
                    <select name="time_zone" 
                            class="admin-input w-full @error('time_zone') border-red-500 @enderror">
                        <option value="Europe/Istanbul" {{ old('time_zone', 'Europe/Istanbul') == 'Europe/Istanbul' ? 'selected' : '' }}>
                            İstanbul (UTC+3)
                        </option>
                        <option value="UTC" {{ old('time_zone') == 'UTC' ? 'selected' : '' }}>
                            UTC (UTC+0)
                        </option>
                        <option value="Europe/London" {{ old('time_zone') == 'Europe/London' ? 'selected' : '' }}>
                            Londra (UTC+0/+1)
                        </option>
                        <option value="America/New_York" {{ old('time_zone') == 'America/New_York' ? 'selected' : '' }}>
                            New York (UTC-5/-4)
                        </option>
                    </select>
                    @error('time_zone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Security -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700 mt-6">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                    <i data-lucide="lock" class="w-4 h-4 text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-admin-900 dark:text-white">Güvenlik</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <i data-lucide="key" class="w-4 h-4 inline mr-1"></i>
                        Şifre *
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="password" 
                               required
                               x-ref="password"
                               @input="checkPasswordStrength()"
                               class="admin-input w-full pr-10 @error('password') border-red-500 @enderror"
                               placeholder="En az 8 karakter">
                        <button type="button" 
                                @click="togglePasswordVisibility('password')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i :data-lucide="showPassword ? 'eye-off' : 'eye'" 
                               class="w-4 h-4 text-admin-400 hover:text-admin-600"></i>
                        </button>
                    </div>
                    
                    <!-- Password Strength Indicator -->
                    <div class="mt-2" x-show="passwordStrength">
                        <div class="flex items-center space-x-2">
                            <div class="flex-1 bg-admin-200 dark:bg-admin-700 rounded-full h-1">
                                <div class="h-1 rounded-full transition-all duration-300"
                                     :class="{
                                         'bg-red-500 w-1/4': passwordStrength === 'weak',
                                         'bg-amber-500 w-2/4': passwordStrength === 'medium',
                                         'bg-green-500 w-3/4': passwordStrength === 'strong',
                                         'bg-emerald-500 w-full': passwordStrength === 'very-strong'
                                     }"></div>
                            </div>
                            <span class="text-xs font-medium"
                                  :class="{
                                      'text-red-600 dark:text-red-400': passwordStrength === 'weak',
                                      'text-amber-600 dark:text-amber-400': passwordStrength === 'medium',
                                      'text-green-600 dark:text-green-400': passwordStrength === 'strong',
                                      'text-emerald-600 dark:text-emerald-400': passwordStrength === 'very-strong'
                                  }"
                                  x-text="passwordStrengthText"></span>
                        </div>
                    </div>
                    
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <i data-lucide="lock" class="w-4 h-4 inline mr-1"></i>
                        Şifre Onayı *
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="password_confirmation" 
                               required
                               x-ref="passwordConfirmation"
                               @input="checkPasswordMatch()"
                               class="admin-input w-full pr-10 @error('password_confirmation') border-red-500 @enderror"
                               placeholder="Şifrenizi tekrar girin">
                        <button type="button" 
                                @click="togglePasswordVisibility('passwordConfirmation')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i :data-lucide="showPasswordConfirmation ? 'eye-off' : 'eye'" 
                               class="w-4 h-4 text-admin-400 hover:text-admin-600"></i>
                        </button>
                    </div>
                    
                    <!-- Password Match Indicator -->
                    <div x-show="passwordMatchStatus" class="mt-1">
                        <p class="text-sm" 
                           :class="passwordsMatch ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'">
                            <i :data-lucide="passwordsMatch ? 'check-circle' : 'x-circle'" class="w-3 h-3 inline mr-1"></i>
                            <span x-text="passwordsMatch ? 'Şifreler eşleşiyor' : 'Şifreler eşleşmiyor'"></span>
                        </p>
                    </div>
                    
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between pt-6">
            <a href="{{ route('admin.managers.index') }}" 
               class="inline-flex items-center px-6 py-3 border border-admin-300 dark:border-admin-600 shadow-sm text-sm font-medium rounded-xl text-admin-700 dark:text-admin-300 bg-white dark:bg-admin-800 hover:bg-admin-50 dark:hover:bg-admin-700 transition-all duration-200">
                <i data-lucide="x" class="w-4 h-4 mr-2"></i>
                İptal
            </a>
            
            <div class="flex items-center space-x-3">
                <!-- Save as Draft -->
                <button type="button" 
                        @click="saveDraft()"
                        class="inline-flex items-center px-6 py-3 border border-admin-300 dark:border-admin-600 shadow-sm text-sm font-medium rounded-xl text-admin-700 dark:text-admin-300 bg-white dark:bg-admin-800 hover:bg-admin-50 dark:hover:bg-admin-700 transition-all duration-200">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                    Taslak Kaydet
                </button>
                
                <!-- Submit -->
                <button type="submit" 
                        :disabled="!formValid"
                        :class="formValid ? 'opacity-100' : 'opacity-50 cursor-not-allowed'"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium rounded-xl shadow-lg hover:shadow-green-500/25 transition-all duration-200">
                    <i data-lucide="user-plus" class="w-4 h-4 mr-2"></i>
                    Yönetici Oluştur
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function createManagerForm() {
    return {
        selectedRole: '{{ old("role_id") }}',
        roleInfo: '',
        avatarPreview: null,
        passwordStrength: '',
        passwordStrengthText: '',
        showPassword: false,
        showPasswordConfirmation: false,
        passwordsMatch: false,
        passwordMatchStatus: false,
        
        get formValid() {
            // Basic validation - can be expanded
            return this.$refs.createForm.checkValidity() && this.passwordsMatch;
        },
        
        updateRoleInfo() {
            const select = document.querySelector('select[name="role_id"]');
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
        },
        
        previewAvatar(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.avatarPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.avatarPreview = null;
            }
        },
        
        togglePasswordVisibility(field) {
            if (field === 'password') {
                this.showPassword = !this.showPassword;
                this.$refs.password.type = this.showPassword ? 'text' : 'password';
            } else {
                this.showPasswordConfirmation = !this.showPasswordConfirmation;
                this.$refs.passwordConfirmation.type = this.showPasswordConfirmation ? 'text' : 'password';
            }
            
            // Re-init lucide icons
            lucide.createIcons();
        },
        
        checkPasswordStrength() {
            const password = this.$refs.password.value;
            
            if (password.length === 0) {
                this.passwordStrength = '';
                return;
            }
            
            let score = 0;
            
            // Length
            if (password.length >= 8) score++;
            if (password.length >= 12) score++;
            
            // Character types
            if (/[a-z]/.test(password)) score++;
            if (/[A-Z]/.test(password)) score++;
            if (/[0-9]/.test(password)) score++;
            if (/[^A-Za-z0-9]/.test(password)) score++;
            
            if (score <= 2) {
                this.passwordStrength = 'weak';
                this.passwordStrengthText = 'Zayıf';
            } else if (score <= 4) {
                this.passwordStrength = 'medium';
                this.passwordStrengthText = 'Orta';
            } else if (score <= 5) {
                this.passwordStrength = 'strong';
                this.passwordStrengthText = 'Güçlü';
            } else {
                this.passwordStrength = 'very-strong';
                this.passwordStrengthText = 'Çok Güçlü';
            }
        },
        
        checkPasswordMatch() {
            const password = this.$refs.password.value;
            const confirmation = this.$refs.passwordConfirmation.value;
            
            if (confirmation.length === 0) {
                this.passwordMatchStatus = false;
                return;
            }
            
            this.passwordMatchStatus = true;
            this.passwordsMatch = password === confirmation;
            
            lucide.createIcons();
        },
        
        saveDraft() {
            // Save form data to localStorage
            const formData = new FormData(this.$refs.createForm);
            const data = {};
            
            for (let [key, value] of formData.entries()) {
                if (key !== 'password' && key !== 'password_confirmation' && key !== '_token') {
                    data[key] = value;
                }
            }
            
            localStorage.setItem('admin_manager_draft', JSON.stringify(data));
            
            // Show success message
            Swal.fire({
                title: 'Taslak Kaydedildi!',
                text: 'Form verileriniz taslak olarak kaydedildi.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        }
    }
}

// Load draft on page load
document.addEventListener('DOMContentLoaded', function() {
    const draft = localStorage.getItem('admin_manager_draft');
    if (draft) {
        const data = JSON.parse(draft);
        
        // Fill form fields
        for (let [key, value] of Object.entries(data)) {
            const field = document.querySelector(`[name="${key}"]`);
            if (field) {
                field.value = value;
                // Trigger change event for selects
                if (field.tagName === 'SELECT') {
                    field.dispatchEvent(new Event('change'));
                }
            }
        }
        
        // Show draft notification
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        
        Toast.fire({
            icon: 'info',
            title: 'Taslak veriler yüklendi'
        });
    }
    
    lucide.createIcons();
});
</script>
@endpush