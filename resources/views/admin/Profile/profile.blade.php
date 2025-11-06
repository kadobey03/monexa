@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center text-white text-2xl font-bold">
                {{ Auth('admin')->user() ? substr(Auth('admin')->user()->firstName, 0, 1) : 'A' }}
            </div>
            <div>
                <h1 class="text-2xl font-bold text-admin-900 dark:text-admin-100">Hesap Profil Bilgileri</h1>
                <p class="text-admin-600 dark:text-admin-400 mt-1">Kişisel bilgilerinizi ve güvenlik ayarlarınızı yönetin</p>
            </div>
        </div>
    </div>

    <!-- Profile Form -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 overflow-hidden">
        <div class="p-6 border-b border-admin-200 dark:border-admin-700 bg-gradient-to-r from-primary-50 to-blue-50 dark:from-primary-900/20 dark:to-blue-900/20">
            <div class="flex items-center space-x-3">
                <x-heroicon name="user-cog" class="w-6 h-6 text-primary-600 dark:text-primary-400" />
                <h2 class="text-lg font-semibold text-admin-900 dark:text-admin-100">Profil Bilgileri</h2>
            </div>
        </div>

        <form method="POST" action="{{ route('upadprofile') }}" class="p-6" id="profileForm">
            @csrf
            <div class="space-y-6">
                <!-- Name Fields Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div class="space-y-2">
                        <label for="firstName" class="block text-sm font-medium text-admin-700 dark:text-admin-300">
                            <x-heroicon name="user" class="w-4 h-4 inline mr-2 text-admin-500" />
                            Ad
                        </label>
                        <input type="text" 
                               id="firstName" 
                               name="name" 
                               value="{{ Auth('admin')->user()->firstName }}"
                               class="w-full px-4 py-3 rounded-xl border border-admin-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-admin-900 dark:text-admin-100 placeholder-admin-500 dark:placeholder-admin-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                               placeholder="Adınızı girin"
                               required>
                        <div id="firstName-error" class="hidden text-sm text-red-600 dark:text-red-400"></div>
                    </div>

                    <!-- Last Name -->
                    <div class="space-y-2">
                        <label for="lastName" class="block text-sm font-medium text-admin-700 dark:text-admin-300">
                            <x-heroicon name="user" class="w-4 h-4 inline mr-2 text-admin-500" />
                            Soyad
                        </label>
                        <input type="text" 
                               id="lastName" 
                               name="lname" 
                               value="{{ Auth('admin')->user()->lastName }}"
                               class="w-full px-4 py-3 rounded-xl border border-admin-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-admin-900 dark:text-admin-100 placeholder-admin-500 dark:placeholder-admin-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                               placeholder="Soyadınızı girin"
                               required>
                        <div id="lastName-error" class="hidden text-sm text-red-600 dark:text-red-400"></div>
                    </div>
                </div>

                <!-- Phone Number -->
                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-medium text-admin-700 dark:text-admin-300">
                        <x-heroicon name="phone" class="w-4 h-4 inline mr-2 text-admin-500" />
                        Telefon Numarası
                    </label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           value="{{ Auth('admin')->user()->phone }}"
                           class="w-full px-4 py-3 rounded-xl border border-admin-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-admin-900 dark:text-admin-100 placeholder-admin-500 dark:placeholder-admin-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                           placeholder="+90 555 123 45 67">
                    <div id="phone-error" class="hidden text-sm text-red-600 dark:text-red-400"></div>
                </div>

                <!-- Two Factor Authentication -->
                <div class="space-y-2">
                    <label for="twoFactor" class="block text-sm font-medium text-admin-700 dark:text-admin-300">
                        <x-heroicon name="shield-check" class="w-4 h-4 inline mr-2 text-admin-500" />
                        İki Faktörlü Kimlik Doğrulama
                    </label>
                    <select id="twoFactor" 
                            name="token"
                            class="w-full px-4 py-3 rounded-xl border border-admin-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-admin-900 dark:text-admin-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                        <option value="{{ Auth('admin')->user()->enable_2fa }}">{{ Auth('admin')->user()->enable_2fa }}</option>
                        <option value="enabled">Etkinleştir</option>
                        <option value="disabled">Devre Dışı Bırak</option>
                    </select>
                    <p class="text-sm text-admin-500 dark:text-admin-400">
                        <x-heroicon name="info" class="w-4 h-4 inline mr-1" />
                        Ek güvenlik için iki faktörlü kimlik doğrulamayı etkinleştirin
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-admin-200 dark:border-admin-700">
                    <button type="button" 
                            onclick="resetForm()"
                            class="px-6 py-3 text-admin-700 dark:text-admin-300 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 rounded-xl font-medium transition-all duration-200 flex items-center space-x-2">
                        <x-heroicon name="arrow-path" class="w-4 h-4" />
                        <span>Sıfırla</span>
                    </button>
                    <button type="submit" 
                            id="submitBtn"
                            class="px-8 py-3 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white rounded-xl font-medium transition-all duration-200 flex items-center space-x-2 shadow-elegant">
                        <x-heroicon name="check" class="w-4 h-4" />
                        <span>Güncelle</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Security Info Card -->
    <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-2xl p-6 border border-amber-200 dark:border-amber-700/50">
        <div class="flex items-start space-x-4">
            <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/50 rounded-xl flex items-center justify-center flex-shrink-0">
                <x-heroicon name="exclamation-triangle" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
            </div>
            <div>
                <h3 class="font-semibold text-amber-800 dark:text-amber-200 mb-2">Güvenlik Bilgisi</h3>
                <ul class="text-sm text-amber-700 dark:text-amber-300 space-y-1">
                    <li>• Profil bilgilerinizi güncel tutun</li>
                    <li>• Güvenliğiniz için iki faktörlü kimlik doğrulamayı etkinleştirin</li>
                    <li>• Telefon numaranızın doğru olduğundan emin olun</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profileForm');
    const submitBtn = document.getElementById('submitBtn');
    
    // Form validation
    function validateField(field, errorElement) {
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';
        
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'Bu alan zorunludur.';
        } else if (field.type === 'tel' && value && !isValidPhone(value)) {
            isValid = false;
            errorMessage = 'Geçerli bir telefon numarası girin.';
        }
        
        if (isValid) {
            field.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            field.classList.add('border-admin-300', 'dark:border-admin-600', 'focus:border-primary-500', 'focus:ring-primary-500');
            errorElement.classList.add('hidden');
        } else {
            field.classList.remove('border-admin-300', 'dark:border-admin-600', 'focus:border-primary-500', 'focus:ring-primary-500');
            field.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            errorElement.textContent = errorMessage;
            errorElement.classList.remove('hidden');
        }
        
        return isValid;
    }
    
    function isValidPhone(phone) {
        const phoneRegex = /^[\+]?[\d\s\-\(\)]+$/;
        return phoneRegex.test(phone) && phone.replace(/\D/g, '').length >= 10;
    }
    
    // Real-time validation
    const fields = [
        { field: document.getElementById('firstName'), error: document.getElementById('firstName-error') },
        { field: document.getElementById('lastName'), error: document.getElementById('lastName-error') },
        { field: document.getElementById('phone'), error: document.getElementById('phone-error') }
    ];
    
    fields.forEach(({ field, error }) => {
        if (field && error) {
            field.addEventListener('blur', () => validateField(field, error));
            field.addEventListener('input', () => {
                if (!error.classList.contains('hidden')) {
                    validateField(field, error);
                }
            });
        }
    });
    
    // Form submission
    form.addEventListener('submit', function(e) {
        let isFormValid = true;
        
        fields.forEach(({ field, error }) => {
            if (field && error) {
                if (!validateField(field, error)) {
                    isFormValid = false;
                }
            }
        });
        
        if (!isFormValid) {
            e.preventDefault();
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle>
                <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" class="opacity-75"></path>
            </svg>
            <span>Güncelliyor...</span>
        `;
        
        // Re-enable button after 3 seconds (fallback)
        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = `
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Güncelle</span>
            `;
        }, 3000);
    });
});

// Reset form function
function resetForm() {
    const form = document.getElementById('profileForm');
    const fields = form.querySelectorAll('input, select');
    
    // Reset to original values
    document.getElementById('firstName').value = "{{ Auth('admin')->user()->firstName }}";
    document.getElementById('lastName').value = "{{ Auth('admin')->user()->lastName }}";
    document.getElementById('phone').value = "{{ Auth('admin')->user()->phone }}";
    document.getElementById('twoFactor').value = "{{ Auth('admin')->user()->enable_2fa }}";
    
    // Clear error states
    fields.forEach(field => {
        field.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        field.classList.add('border-admin-300', 'dark:border-admin-600', 'focus:border-primary-500', 'focus:ring-primary-500');
    });
    
    document.querySelectorAll('[id$="-error"]').forEach(error => {
        error.classList.add('hidden');
    });
}
</script>
@endsection