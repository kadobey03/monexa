@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl p-6 shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-rose-600 rounded-2xl flex items-center justify-center text-white text-2xl">
                <x-heroicon name="key" class="w-8 h-8" />
            </div>
            <div>
                <h1 class="text-2xl font-bold text-admin-900 dark:text-admin-100">{{ __('admin.profile.password.change_title') }}</h1>
                <p class="text-admin-600 dark:text-admin-400 mt-1">{{ __('admin.profile.password.change_description') }}</p>
            </div>
        </div>
    </div>

    <!-- Password Change Form -->
    <div class="bg-white dark:bg-admin-800 rounded-2xl shadow-elegant dark:shadow-glass-dark border border-admin-200 dark:border-admin-700 overflow-hidden">
        <div class="p-6 border-b border-admin-200 dark:border-admin-700 bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20">
            <div class="flex items-center space-x-3">
                <x-heroicon name="shield-check" class="w-6 h-6 text-red-600 dark:text-red-400" />
                <h2 class="text-lg font-semibold text-admin-900 dark:text-admin-100">{{ __('admin.profile.password.security_title') }}</h2>
            </div>
        </div>

        <form method="POST" action="{{ route('adminupdatepass') }}" class="p-6" id="passwordForm">
            @csrf
            <div class="space-y-6">
                <!-- Current Password -->
                <div class="space-y-2">
                    <label for="currentPassword" class="block text-sm font-medium text-admin-700 dark:text-admin-300">
                        <x-heroicon name="lock-closed" class="w-4 h-4 inline mr-2 text-admin-500" />
                        {{ __('admin.profile.password.current_password') }}
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="currentPassword" 
                               name="old_password" 
                               class="w-full px-4 py-3 pr-12 rounded-xl border border-admin-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-admin-900 dark:text-admin-100 placeholder-admin-500 dark:placeholder-admin-400 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                               placeholder="{{ __('admin.profile.password.current_password_placeholder') }}"
                               required>
                        <button type="button" 
                                onclick="togglePassword('currentPassword')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-admin-400 hover:text-admin-600 dark:hover:text-admin-200 transition-colors">
                            <x-heroicon name="eye" class="w-5 h-5" id="currentPassword-eye" />
                            <x-heroicon name="eye-slash" class="w-5 h-5 hidden" id="currentPassword-eye-slash" />
                        </button>
                    </div>
                    <div id="currentPassword-error" class="hidden text-sm text-red-600 dark:text-red-400"></div>
                </div>

                <!-- New Password -->
                <div class="space-y-2">
                    <label for="newPassword" class="block text-sm font-medium text-admin-700 dark:text-admin-300">
                        <x-heroicon name="key" class="w-4 h-4 inline mr-2 text-admin-500" />
                        {{ __('admin.profile.password.new_password') }}
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="newPassword" 
                               name="password" 
                               class="w-full px-4 py-3 pr-12 rounded-xl border border-admin-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-admin-900 dark:text-admin-100 placeholder-admin-500 dark:placeholder-admin-400 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                               placeholder="{{ __('admin.profile.password.new_password_placeholder') }}"
                               required>
                        <button type="button" 
                                onclick="togglePassword('newPassword')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-admin-400 hover:text-admin-600 dark:hover:text-admin-200 transition-colors">
                            <x-heroicon name="eye" class="w-5 h-5" id="newPassword-eye" />
                            <x-heroicon name="eye-slash" class="w-5 h-5 hidden" id="newPassword-eye-slash" />
                        </button>
                    </div>
                    <div id="newPassword-error" class="hidden text-sm text-red-600 dark:text-red-400"></div>
                    <!-- Password Strength Indicator -->
                    <div class="mt-2">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs text-admin-600 dark:text-admin-400">{{ __('admin.profile.password.strength_title') }}</span>
                            <span id="strengthText" class="text-xs font-medium">-</span>
                        </div>
                        <div class="w-full bg-admin-200 dark:bg-admin-700 rounded-full h-2">
                            <div id="strengthBar" class="h-2 rounded-full transition-all duration-300 w-0"></div>
                        </div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label for="confirmPassword" class="block text-sm font-medium text-admin-700 dark:text-admin-300">
                        <x-heroicon name="check-circle" class="w-4 h-4 inline mr-2 text-admin-500" />
                        {{ __('admin.profile.password.confirm_password') }}
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="confirmPassword" 
                               name="password_confirmation" 
                               class="w-full px-4 py-3 pr-12 rounded-xl border border-admin-300 dark:border-admin-600 bg-white dark:bg-admin-700 text-admin-900 dark:text-admin-100 placeholder-admin-500 dark:placeholder-admin-400 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                               placeholder="{{ __('admin.profile.password.confirm_password_placeholder') }}"
                               required>
                        <button type="button" 
                                onclick="togglePassword('confirmPassword')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-admin-400 hover:text-admin-600 dark:hover:text-admin-200 transition-colors">
                            <x-heroicon name="eye" class="w-5 h-5" id="confirmPassword-eye" />
                            <x-heroicon name="eye-slash" class="w-5 h-5 hidden" id="confirmPassword-eye-slash" />
                        </button>
                    </div>
                    <div id="confirmPassword-error" class="hidden text-sm text-red-600 dark:text-red-400"></div>
                </div>

                <!-- Hidden Fields -->
                <input type="hidden" name="id" value="{{ Auth('admin')->user()->id }}">
                <input type="hidden" name="current_password" value="{{ Auth('admin')->user()->password }}">

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-admin-200 dark:border-admin-700">
                    <button type="button" 
                            onclick="clearForm()"
                            class="px-6 py-3 text-admin-700 dark:text-admin-300 bg-admin-100 dark:bg-admin-700 hover:bg-admin-200 dark:hover:bg-admin-600 rounded-xl font-medium transition-all duration-200 flex items-center space-x-2">
                        <x-heroicon name="x-mark" class="w-4 h-4" />
                        <span>{{ __('admin.profile.password.clear_button') }}</span>
                    </button>
                    <button type="submit" 
                            id="submitBtn"
                            class="px-8 py-3 bg-gradient-to-r from-red-600 to-rose-700 hover:from-red-700 hover:to-rose-800 text-white rounded-xl font-medium transition-all duration-200 flex items-center space-x-2 shadow-elegant disabled:opacity-50 disabled:cursor-not-allowed">
                        <x-heroicon name="shield-check" class="w-4 h-4" />
                        <span>{{ __('admin.profile.password.update_button') }}</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Password Requirements Card -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-6 border border-blue-200 dark:border-blue-700/50">
        <div class="flex items-start space-x-4">
            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-xl flex items-center justify-center flex-shrink-0">
                <x-heroicon name="info" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
            </div>
            <div>
                <h3 class="font-semibold text-blue-800 dark:text-blue-200 mb-3">{{ __('admin.profile.password.requirements_title') }}</h3>
                <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-blue-700 dark:text-blue-300">
                    <li class="flex items-center space-x-2" id="req-length">
                        <x-heroicon name="x-circle" class="w-4 h-4 text-red-500" />
                        <span>{{ __('admin.profile.password.requirement_length') }}</span>
                    </li>
                    <li class="flex items-center space-x-2" id="req-uppercase">
                        <x-heroicon name="x-circle" class="w-4 h-4 text-red-500" />
                        <span>{{ __('admin.profile.password.requirement_uppercase') }}</span>
                    </li>
                    <li class="flex items-center space-x-2" id="req-lowercase">
                        <x-heroicon name="x-circle" class="w-4 h-4 text-red-500" />
                        <span>{{ __('admin.profile.password.requirement_lowercase') }}</span>
                    </li>
                    <li class="flex items-center space-x-2" id="req-number">
                        <x-heroicon name="x-circle" class="w-4 h-4 text-red-500" />
                        <span>{{ __('admin.profile.password.requirement_number') }}</span>
                    </li>
                    <li class="flex items-center space-x-2" id="req-special">
                        <x-heroicon name="x-circle" class="w-4 h-4 text-red-500" />
                        <span>{{ __('admin.profile.password.requirement_special') }}</span>
                    </li>
                    <li class="flex items-center space-x-2" id="req-match">
                        <x-heroicon name="x-circle" class="w-4 h-4 text-red-500" />
                        <span>{{ __('admin.profile.password.requirement_match') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
// Pass translations to JavaScript
window.passwordTranslations = {
    weak: @json(__('admin.profile.password.strength_weak')),
    medium: @json(__('admin.profile.password.strength_medium')),
    strong: @json(__('admin.profile.password.strength_strong')),
    updating: @json(__('admin.profile.password.updating_button'))
};

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('passwordForm');
    const submitBtn = document.getElementById('submitBtn');
    const currentPassword = document.getElementById('currentPassword');
    const newPassword = document.getElementById('newPassword');
    const confirmPassword = document.getElementById('confirmPassword');

    // Password visibility toggle
    window.togglePassword = function(fieldId) {
        const field = document.getElementById(fieldId);
        const eyeIcon = document.getElementById(fieldId + '-eye');
        const eyeSlashIcon = document.getElementById(fieldId + '-eye-slash');
        
        if (field.type === 'password') {
            field.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeSlashIcon.classList.remove('hidden');
        } else {
            field.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeSlashIcon.classList.add('hidden');
        }
    };

    // Password strength checker
    function checkPasswordStrength(password) {
        let score = 0;
        let requirements = {
            length: false,
            uppercase: false,
            lowercase: false,
            number: false,
            special: false
        };

        // Check length
        if (password.length >= 8) {
            score += 20;
            requirements.length = true;
        }

        // Check for uppercase
        if (/[A-Z]/.test(password)) {
            score += 20;
            requirements.uppercase = true;
        }

        // Check for lowercase
        if (/[a-z]/.test(password)) {
            score += 20;
            requirements.lowercase = true;
        }

        // Check for numbers
        if (/\d/.test(password)) {
            score += 20;
            requirements.number = true;
        }

        // Check for special characters
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
            score += 20;
            requirements.special = true;
        }

        return { score, requirements };
    }

    // Update password strength indicator
    function updateStrengthIndicator(password) {
        const { score, requirements } = checkPasswordStrength(password);
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');

        // Update progress bar
        strengthBar.style.width = score + '%';
        
        // Update colors and text based on strength
        if (score < 40) {
            strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-red-500';
            strengthText.textContent = window.passwordTranslations.weak;
            strengthText.className = 'text-xs font-medium text-red-600 dark:text-red-400';
        } else if (score < 80) {
            strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-yellow-500';
            strengthText.textContent = window.passwordTranslations.medium;
            strengthText.className = 'text-xs font-medium text-yellow-600 dark:text-yellow-400';
        } else {
            strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-green-500';
            strengthText.textContent = window.passwordTranslations.strong;
            strengthText.className = 'text-xs font-medium text-green-600 dark:text-green-400';
        }

        // Update requirement indicators
        Object.keys(requirements).forEach(req => {
            const element = document.getElementById('req-' + req);
            const icon = element.querySelector('svg');
            
            if (requirements[req]) {
                icon.className = 'w-4 h-4 text-green-500';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>';
            } else {
                icon.className = 'w-4 h-4 text-red-500';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
            }
        });

        return score >= 80;
    }

    // Check password match
    function checkPasswordMatch() {
        const match = newPassword.value === confirmPassword.value && confirmPassword.value !== '';
        const element = document.getElementById('req-match');
        const icon = element.querySelector('svg');
        
        if (match) {
            icon.className = 'w-4 h-4 text-green-500';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>';
        } else {
            icon.className = 'w-4 h-4 text-red-500';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
        }

        return match;
    }

    // Real-time validation
    newPassword.addEventListener('input', function() {
        updateStrengthIndicator(this.value);
        if (confirmPassword.value) {
            checkPasswordMatch();
        }
        validateSubmitButton();
    });

    confirmPassword.addEventListener('input', function() {
        checkPasswordMatch();
        validateSubmitButton();
    });

    currentPassword.addEventListener('input', validateSubmitButton);

    // Validate submit button state
    function validateSubmitButton() {
        const isCurrentValid = currentPassword.value.length > 0;
        const isNewValid = updateStrengthIndicator(newPassword.value);
        const isMatchValid = checkPasswordMatch();

        submitBtn.disabled = !(isCurrentValid && isNewValid && isMatchValid);
    }

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const isCurrentValid = currentPassword.value.length > 0;
        const isNewValid = updateStrengthIndicator(newPassword.value);
        const isMatchValid = checkPasswordMatch();

        if (!isCurrentValid || !isNewValid || !isMatchValid) {
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle>
                <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" class="opacity-75"></path>
            </svg>
            <span>${window.passwordTranslations.updating}</span>
        `;

        // Submit the form
        form.submit();
    });

    // Clear form function
    window.clearForm = function() {
        form.reset();
        updateStrengthIndicator('');
        checkPasswordMatch();
        validateSubmitButton();
        
        // Reset all password field types to password
        ['currentPassword', 'newPassword', 'confirmPassword'].forEach(id => {
            const field = document.getElementById(id);
            const eyeIcon = document.getElementById(id + '-eye');
            const eyeSlashIcon = document.getElementById(id + '-eye-slash');
            
            field.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeSlashIcon.classList.add('hidden');
        });
    };

    // Initial validation
    validateSubmitButton();
});
</script>
@endsection