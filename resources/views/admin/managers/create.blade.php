@extends('layouts.admin')

@section('content')
<div class="space-y-6" id="createManagerContainer">
    
    <!-- Page Header -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.managers.index') }}" 
               class="p-2 rounded-lg bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 transition-colors">
                <x-heroicon name="arrow-left" class="w-5 h-5 text-admin-600 dark:text-admin-400" />
            </a>
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <x-heroicon name="user-plus" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-admin-900 dark:text-white">Yeni Yönetici Ekle</h1>
                    <p class="text-admin-600 dark:text-admin-400">Sisteme yeni bir yönetici hesabı ekleyin</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('admin.managers.store') }}" enctype="multipart/form-data" id="createManagerForm">
        @csrf
        
        <!-- Personal Information -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <x-heroicon name="user" class="w-4 h-4 text-white" />
                </div>
                <h2 class="text-xl font-bold text-admin-900 dark:text-white">Kişisel Bilgiler</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- First Name -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="user" class="w-4 h-4 inline mr-1" />
                        Ad *
                    </label>
                    <input type="text" 
                           name="firstName" 
                           value="{{ old('firstName') }}"
                           required
                           class="w-full px-4 py-3 border border-admin-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-admin-400 dark:placeholder-admin-500 @error('firstName') border-red-500 @enderror"
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
                           value="{{ old('lastName') }}"
                           required
                           class="w-full px-4 py-3 border border-admin-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-admin-400 dark:placeholder-admin-500 @error('lastName') border-red-500 @enderror"
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
                           value="{{ old('email') }}"
                           required
                           class="w-full px-4 py-3 border border-admin-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-admin-400 dark:placeholder-admin-500 @error('email') border-red-500 @enderror"
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
                           value="{{ old('phone') }}"
                           class="w-full px-4 py-3 border border-admin-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-admin-400 dark:placeholder-admin-500 @error('phone') border-red-500 @enderror"
                           placeholder="+90 555 123 45 67">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
            </div>
            
            
            <!-- Avatar Upload -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                    <x-heroicon name="camera" class="w-4 h-4 inline mr-1" />
                    Profil Fotoğrafı
                </label>
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        <div class="w-20 h-20 bg-admin-200 dark:bg-admin-700 rounded-full flex items-center justify-center" 
                             id="defaultAvatar">
                            <x-heroicon name="user" class="w-8 h-8 text-admin-400" />
                        </div>
                        <img id="avatarPreview" 
                             class="w-20 h-20 rounded-full object-cover hidden">
                    </div>
                    <div class="flex-1">
                        <input type="file" 
                               name="avatar" 
                               id="avatarInput"
                               accept="image/*"
                               class="w-full px-4 py-3 border border-admin-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-admin-600 dark:file:text-admin-200 @error('avatar') border-red-500 @enderror">
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
                    <x-heroicon name="shield-check" class="w-4 h-4 text-white" />
                </div>
                <h2 class="text-xl font-bold text-admin-900 dark:text-white">Rol ve Hiyerarşi</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="shield-check" class="w-4 h-4 inline mr-1" />
                        Rol *
                    </label>
                    <select name="role_id" 
                            id="roleSelect"
                            required
                            class="w-full px-4 py-3 border border-admin-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('role_id') border-red-500 @enderror">
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
                    <div id="roleInfo" class="mt-2 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800 hidden">
                        <p class="text-sm text-blue-800 dark:text-blue-300" id="roleInfoText"></p>
                    </div>
                </div>
                
                <!-- Supervisor -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="user-check" class="w-4 h-4 inline mr-1" />
                        Süpervizör
                    </label>
                    <select name="supervisor_id" 
                            class="w-full px-4 py-3 border border-admin-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('supervisor_id') border-red-500 @enderror">
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
                        <x-heroicon name="building" class="w-4 h-4 inline mr-1" />
                        Departman *
                    </label>
                    <select name="department" 
                            required
                            class="w-full px-4 py-3 border border-admin-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('department') border-red-500 @enderror">
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
                        <x-heroicon name="users" class="w-4 h-4 inline mr-1" />
                        Yönetici Grubu
                    </label>
                    <select name="admin_group_id" 
                            class="w-full px-4 py-3 border border-admin-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('admin_group_id') border-red-500 @enderror">
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


        <!-- Security -->
        <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark p-6 border border-admin-200 dark:border-admin-700 mt-6">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                    <x-heroicon name="lock-closed" class="w-4 h-4 text-white" />
                </div>
                <h2 class="text-xl font-bold text-admin-900 dark:text-white">Güvenlik</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-admin-700 dark:text-admin-300 mb-2">
                        <x-heroicon name="key" class="w-4 h-4 inline mr-1" />
                        Şifre *
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="password" 
                               id="passwordInput"
                               required
                               class="w-full px-4 py-3 pr-10 border border-admin-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-admin-400 dark:placeholder-admin-500 @error('password') border-red-500 @enderror"
                               placeholder="En az 8 karakter">
                        <button type="button" 
                                id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <x-heroicon name="eye" class="w-4 h-4 text-admin-400 hover:text-admin-600" />
                        </button>
                    </div>
                    
                    <!-- Password Strength Indicator -->
                    <div class="mt-2 hidden" id="passwordStrengthContainer">
                        <div class="flex items-center space-x-2">
                            <div class="flex-1 bg-admin-200 dark:bg-admin-700 rounded-full h-1">
                                <div class="h-1 rounded-full transition-all duration-300" id="passwordStrengthBar"></div>
                            </div>
                            <span class="text-xs font-medium" id="passwordStrengthText"></span>
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
                        Şifre Onayı *
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="password_confirmation" 
                               id="passwordConfirmationInput"
                               required
                               class="w-full px-4 py-3 pr-10 border border-admin-300 dark:border-admin-600 dark:bg-admin-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-admin-400 dark:placeholder-admin-500 @error('password_confirmation') border-red-500 @enderror"
                               placeholder="Şifrenizi tekrar girin">
                        <button type="button" 
                                id="togglePasswordConfirmation"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <x-heroicon name="eye" class="w-4 h-4 text-admin-400 hover:text-admin-600" />
                        </button>
                    </div>
                    
                    <!-- Password Match Indicator -->
                    <div class="mt-1 hidden" id="passwordMatchContainer">
                        <p class="text-sm flex items-center" id="passwordMatchText">
                            <x-heroicon name="check-circle" class="w-3 h-3 inline mr-1" />
                            <span id="passwordMatchStatus"></span>
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
                <x-heroicon name="x-mark" class="w-4 h-4 mr-2" />
                İptal
            </a>
            
            <div class="flex items-center space-x-3">
                <!-- Save as Draft -->
                <button type="button" 
                        id="saveDraftBtn"
                        class="inline-flex items-center px-6 py-3 border border-admin-300 dark:border-admin-600 shadow-sm text-sm font-medium rounded-xl text-admin-700 dark:text-admin-300 bg-white dark:bg-admin-800 hover:bg-admin-50 dark:hover:bg-admin-700 transition-all duration-200">
                    <x-heroicon name="document" class="w-4 h-4 mr-2" />
                    Taslak Kaydet
                </button>
                
                <!-- Submit -->
                <button type="submit" 
                        id="submitBtn"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium rounded-xl shadow-lg hover:shadow-green-500/25 transition-all duration-200">
                    <x-heroicon name="user-plus" class="w-4 h-4 mr-2" />
                    Yönetici Oluştur
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
class CreateManagerForm {
    constructor() {
        this.form = document.getElementById('createManagerForm');
        this.selectedRole = '{{ old("role_id") }}';
        this.avatarPreview = null;
        this.passwordStrength = '';
        this.showPassword = false;
        this.showPasswordConfirmation = false;
        this.passwordsMatch = false;
        this.passwordMatchStatus = false;
        
        this.init();
        this.bindEvents();
        this.loadDraft();
    }
    
    init() {
        // Initialize elements
        this.elements = {
            roleSelect: document.getElementById('roleSelect'),
            roleInfo: document.getElementById('roleInfo'),
            roleInfoText: document.getElementById('roleInfoText'),
            avatarInput: document.getElementById('avatarInput'),
            avatarPreview: document.getElementById('avatarPreview'),
            defaultAvatar: document.getElementById('defaultAvatar'),
            passwordInput: document.getElementById('passwordInput'),
            passwordConfirmationInput: document.getElementById('passwordConfirmationInput'),
            passwordStrengthContainer: document.getElementById('passwordStrengthContainer'),
            passwordStrengthBar: document.getElementById('passwordStrengthBar'),
            passwordStrengthText: document.getElementById('passwordStrengthText'),
            passwordMatchContainer: document.getElementById('passwordMatchContainer'),
            passwordMatchText: document.getElementById('passwordMatchText'),
            passwordMatchStatus: document.getElementById('passwordMatchStatus'),
            togglePassword: document.getElementById('togglePassword'),
            togglePasswordConfirmation: document.getElementById('togglePasswordConfirmation'),
            saveDraftBtn: document.getElementById('saveDraftBtn'),
            submitBtn: document.getElementById('submitBtn')
        };
    }
    
    bindEvents() {
        // Role selection
        this.elements.roleSelect.addEventListener('change', () => this.updateRoleInfo());
        
        // Avatar preview
        this.elements.avatarInput.addEventListener('change', (e) => this.previewAvatar(e));
        
        // Password functionality
        this.elements.passwordInput.addEventListener('input', () => this.checkPasswordStrength());
        this.elements.passwordConfirmationInput.addEventListener('input', () => this.checkPasswordMatch());
        
        // Toggle password visibility
        this.elements.togglePassword.addEventListener('click', () => this.togglePasswordVisibility('password'));
        this.elements.togglePasswordConfirmation.addEventListener('click', () => this.togglePasswordVisibility('passwordConfirmation'));
        
        // Save draft
        this.elements.saveDraftBtn.addEventListener('click', () => this.saveDraft());
        
        // Form submission validation
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        
        // Real-time form validation
        this.form.addEventListener('input', () => this.updateSubmitButton());
        this.form.addEventListener('change', () => this.updateSubmitButton());
    }
    
    updateRoleInfo() {
        const select = this.elements.roleSelect;
        const option = select.options[select.selectedIndex];
        
        if (option.value) {
            const hierarchy = option.getAttribute('data-hierarchy');
            const department = option.getAttribute('data-department');
            
            let roleInfoText = `Hiyerarşi Seviyesi: ${hierarchy}`;
            if (department) {
                roleInfoText += ` • Departman: ${department}`;
            }
            
            this.elements.roleInfoText.textContent = roleInfoText;
            this.elements.roleInfo.classList.remove('hidden');
        } else {
            this.elements.roleInfo.classList.add('hidden');
        }
    }
    
    previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.elements.avatarPreview.src = e.target.result;
                this.elements.avatarPreview.classList.remove('hidden');
                this.elements.defaultAvatar.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            this.elements.avatarPreview.classList.add('hidden');
            this.elements.defaultAvatar.classList.remove('hidden');
        }
    }
    
    togglePasswordVisibility(field) {
        if (field === 'password') {
            this.showPassword = !this.showPassword;
            this.elements.passwordInput.type = this.showPassword ? 'text' : 'password';
            this.elements.togglePassword.innerHTML = this.showPassword ? 
                '<x-heroicon name="eye-slash" class="w-4 h-4 text-admin-400 hover:text-admin-600" />' :
                '<x-heroicon name="eye" class="w-4 h-4 text-admin-400 hover:text-admin-600" />';
        } else {
            this.showPasswordConfirmation = !this.showPasswordConfirmation;
            this.elements.passwordConfirmationInput.type = this.showPasswordConfirmation ? 'text' : 'password';
            this.elements.togglePasswordConfirmation.innerHTML = this.showPasswordConfirmation ? 
                '<x-heroicon name="eye-slash" class="w-4 h-4 text-admin-400 hover:text-admin-600" />' :
                '<x-heroicon name="eye" class="w-4 h-4 text-admin-400 hover:text-admin-600" />';
        }
    }
    
    checkPasswordStrength() {
        const password = this.elements.passwordInput.value;
        
        if (password.length === 0) {
            this.elements.passwordStrengthContainer.classList.add('hidden');
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
        
        let strengthClass, strengthText;
        
        if (score <= 2) {
            strengthClass = 'bg-red-500 w-1/4';
            strengthText = 'Zayıf';
            this.elements.passwordStrengthText.className = 'text-xs font-medium text-red-600 dark:text-red-400';
        } else if (score <= 4) {
            strengthClass = 'bg-amber-500 w-2/4';
            strengthText = 'Orta';
            this.elements.passwordStrengthText.className = 'text-xs font-medium text-amber-600 dark:text-amber-400';
        } else if (score <= 5) {
            strengthClass = 'bg-green-500 w-3/4';
            strengthText = 'Güçlü';
            this.elements.passwordStrengthText.className = 'text-xs font-medium text-green-600 dark:text-green-400';
        } else {
            strengthClass = 'bg-emerald-500 w-full';
            strengthText = 'Çok Güçlü';
            this.elements.passwordStrengthText.className = 'text-xs font-medium text-emerald-600 dark:text-emerald-400';
        }
        
        this.elements.passwordStrengthBar.className = `h-1 rounded-full transition-all duration-300 ${strengthClass}`;
        this.elements.passwordStrengthText.textContent = strengthText;
        this.elements.passwordStrengthContainer.classList.remove('hidden');
    }
    
    checkPasswordMatch() {
        const password = this.elements.passwordInput.value;
        const confirmation = this.elements.passwordConfirmationInput.value;
        
        if (confirmation.length === 0) {
            this.elements.passwordMatchContainer.classList.add('hidden');
            this.passwordMatchStatus = false;
            return;
        }
        
        this.passwordMatchStatus = true;
        this.passwordsMatch = password === confirmation;
        
        if (this.passwordsMatch) {
            this.elements.passwordMatchText.className = 'text-sm flex items-center text-green-600 dark:text-green-400';
            this.elements.passwordMatchStatus.textContent = 'Şifreler eşleşiyor';
            this.elements.passwordMatchText.innerHTML = '<svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg><span>Şifreler eşleşiyor</span>';
        } else {
            this.elements.passwordMatchText.className = 'text-sm flex items-center text-red-600 dark:text-red-400';
            this.elements.passwordMatchStatus.textContent = 'Şifreler eşleşmiyor';
            this.elements.passwordMatchText.innerHTML = '<svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg><span>Şifreler eşleşmiyor</span>';
        }
        
        this.elements.passwordMatchContainer.classList.remove('hidden');
        this.updateSubmitButton();
    }
    
    updateSubmitButton() {
        const formValid = this.form.checkValidity() && this.passwordsMatch;
        
        if (formValid) {
            this.elements.submitBtn.disabled = false;
            this.elements.submitBtn.className = 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium rounded-xl shadow-lg hover:shadow-green-500/25 transition-all duration-200';
        } else {
            this.elements.submitBtn.disabled = true;
            this.elements.submitBtn.className = 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium rounded-xl shadow-lg hover:shadow-green-500/25 transition-all duration-200 opacity-50 cursor-not-allowed';
        }
    }
    
    handleSubmit(event) {
        if (!this.passwordsMatch && this.passwordMatchStatus) {
            event.preventDefault();
            
            Swal.fire({
                title: 'Şifreler Eşleşmiyor!',
                text: 'Lütfen şifre ve şifre onayının aynı olduğundan emin olun.',
                icon: 'error',
                confirmButtonText: 'Tamam'
            });
        }
    }
    
    saveDraft() {
        // Save form data to localStorage
        const formData = new FormData(this.form);
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
    
    loadDraft() {
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
    }
}

// Initialize the form when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new CreateManagerForm();
});
</script>
@endpush