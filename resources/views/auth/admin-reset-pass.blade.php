@extends('layouts.guest1')
@section('title', '{{ __('auth.admin.reset.page_title') }}')
@section('content')

<!-- Admin Password Reset Interface -->
<div class="min-h-screen bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">

        <!-- Admin Password Reset Card -->
        <div class="bg-gray-900 rounded-2xl p-8 shadow-2xl border border-gray-700">

            <!-- Header Section -->
            <div class="text-center mb-8">
                <!-- Brand Logo -->
                <div class="mb-6">
                    <a href="/" class="inline-block">
                        <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo" class="h-12 md:h-16 mx-auto">
                    </a>
                </div>

                <!-- Admin Badge -->
                <div class="inline-flex items-center gap-2 bg-red-500/10 border border-red-500/20 rounded-full px-4 py-2 mb-4">
                    <x-heroicon name="shield-exclamation" class="w-4 h-4 text-red-400" />
                    <span class="text-red-300 text-sm font-bold">{{ __('auth.admin.reset.admin_recovery_badge') }}</span>
                </div>

                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
                    {{ __('auth.admin.reset.main_title') }}
                </h1>
                <p class="text-gray-400 text-sm md:text-base">
                    {{ __('auth.admin.reset.subtitle') }}
                </p>
            </div>

            <!-- Status Messages -->
            @if (Session::has('status'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl">
                    <div class="flex items-start gap-3">
                        <x-heroicon name="check-circle" class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" />
                        <div class="text-sm">
                            <p class="text-green-300 font-bold mb-1">{{ __('auth.admin.reset.success') }}</p>
                            <p class="text-gray-300">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (Session::has('message'))
                <div class="mb-6 p-4 bg-blue-500/10 border border-blue-500/20 rounded-xl">
                    <div class="flex items-start gap-3">
                        <x-heroicon name="information-circle" class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0" />
                        <div class="text-sm">
                            <p class="text-blue-300 font-bold mb-1">{{ __('auth.admin.reset.info') }}</p>
                            <p class="text-gray-300">{{ Session::get('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Security Notice -->
            <div class="mb-6 p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-xl">
                <div class="flex items-start gap-3">
                    <x-heroicon name="exclamation-triangle" class="w-5 h-5 text-yellow-400 mt-0.5 flex-shrink-0" />
                    <div class="text-sm">
                        <p class="text-yellow-300 font-bold mb-1">{{ __('auth.admin.reset.security_notice_title') }}</p>
                        <p class="text-gray-300">
                            {{ __('auth.admin.reset.security_instructions') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Password Reset Form -->
            <form method="POST" action="{{ route('restpass') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-bold text-gray-200">
                        {{ __('auth.admin.reset.admin_email') }}
                    </label>
                    <div class="relative">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="w-full px-4 py-3 bg-gray-900 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all duration-200"
                            placeholder="{{ __('auth.admin.reset.admin_email_placeholder') }}"
                            autocomplete="email"
                            required
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <x-heroicon name="envelope" class="h-5 w-5 text-gray-400" />
                        </div>
                    </div>
                    @error('email')
                        <div class="flex items-center gap-2 text-red-400 text-sm">
                            <x-heroicon name="exclamation-circle" class="w-4 h-4" />
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Security Token -->
                <div class="space-y-2">
                    <label for="token" class="block text-sm font-bold text-gray-200">
                        {{ __('auth.admin.reset.security_token') }}
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            id="token"
                            name="token"
                            class="w-full px-4 py-3 bg-gray-900 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all duration-200 text-center font-mono tracking-wider"
                            placeholder="{{ __('auth.admin.reset.token_placeholder') }}"
                            maxlength="6"
                            pattern="[0-9]{6}"
                            autocomplete="one-time-code"
                            required
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <x-heroicon name="key" class="h-5 w-5 text-gray-400" />
                        </div>
                    </div>
                    @error('token')
                        <div class="flex items-center gap-2 text-red-400 text-sm">
                            <x-heroicon name="exclamation-circle" class="w-4 h-4" />
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                    <p class="text-xs text-gray-500">{{ __('auth.admin.reset.token_help') }}</p>
                </div>

                <!-- New Password -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-bold text-gray-200">
                        {{ __('auth.admin.reset.new_password') }}
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            autocomplete="new-password"
                            name="password"
                            class="w-full px-4 py-3 bg-gray-900 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all duration-200 pr-12"
                            placeholder="{{ __('auth.admin.reset.strong_password_placeholder') }}"
                            autocomplete="new-password"
                            required
                        >
                        <button
                            type="button"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-300 focus:outline-none"
                            onclick="togglePassword('password')"
                        >
                            <x-heroicon name="eye" class="h-5 w-5" id="password-eye" />
                        </button>
                    </div>
                    @error('password')
                        <div class="flex items-center gap-2 text-red-400 text-sm">
                            <x-heroicon name="exclamation-circle" class="w-4 h-4" />
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-200">
                        {{ __('auth.admin.reset.confirm_password') }}
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password_confirmation"
                            autocomplete="new-password"
                            name="password_confirmation"
                            class="w-full px-4 py-3 bg-gray-900 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all duration-200 pr-12"
                            placeholder="{{ __('auth.admin.reset.confirm_password_placeholder') }}"
                            autocomplete="new-password"
                            required
                        >
                        <button
                            type="button"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-300 focus:outline-none"
                            onclick="togglePassword('password_confirmation')"
                        >
                            <x-heroicon name="eye" class="h-5 w-5" id="password_confirmation-eye" />
                        </button>
                    </div>
                </div>

                <!-- Password Requirements -->
                <div class="bg-gray-800/50 rounded-lg p-4 border border-gray-700">
                    <h4 class="text-white font-bold text-sm mb-2 flex items-center gap-2">
                        <x-heroicon name="shield-check" class="w-4 h-4 text-green-400" />
                        {{ __('auth.admin.reset.password_requirements') }}
                    </h4>
                    <ul class="text-gray-300 text-xs space-y-1">
                        <li class="flex items-start gap-2">
                            <span class="text-green-400 mt-1">•</span>
                            {{ __('auth.admin.reset.min_8_chars') }}
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-400 mt-1">•</span>
                            {{ __('auth.admin.reset.include_mixed_case') }}
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-400 mt-1">•</span>
                            {{ __('auth.admin.reset.include_number') }}
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-400 mt-1">•</span>
                            {{ __('auth.admin.reset.include_special_char') }}
                        </li>
                    </ul>
                </div>

                <!-- Reset Button -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-red-500/25 focus:outline-none focus:ring-2 focus:ring-red-500/50"
                >
                    <span class="flex items-center justify-center gap-2">
                        <x-heroicon name="shield-check" class="w-5 h-5" />
                        {{ __('auth.admin.reset.reset_admin_password') }}
                    </span>
                </button>
            </form>

            <!-- Back to Admin Login -->
            <div class="mt-6 text-center">
                <a href="{{ route('adminlogin') }}"
                   class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors duration-200">
                    <x-heroicon name="arrow-left" class="w-4 h-4" />
                    {{ __('auth.admin.reset.back_to_admin_login') }}
                </a>
            </div>

            <!-- Security Features -->
            <div class="mt-8 pt-6 border-t border-gray-700">
                <div class="text-center">
                    <p class="text-xs text-gray-500 mb-2">{{ __('auth.admin.reset.enterprise_security') }}</p>
                    <div class="flex items-center justify-center gap-4 text-gray-600">
                        <span class="flex items-center gap-1">
                            <x-heroicon name="shield-check" class="w-3 h-3" />
                            <span class="text-xs">{{ __('auth.admin.reset.admin_only') }}</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <x-heroicon name="lock-closed" class="w-3 h-3" />
                            <span class="text-xs">{{ __('auth.admin.reset.token_verified') }}</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <x-heroicon name="eye-slash" class="w-3 h-3" />
                            <span class="text-xs">{{ __('auth.admin.reset.secure_reset') }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Background Pattern -->
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-red-900/5 via-gray-900 to-purple-900/5"></div>
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-96 h-96 bg-red-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/2 translate-x-1/2 w-96 h-96 bg-purple-500/5 rounded-full blur-3xl"></div>
        </div>
    </div>
</div>

<!-- Add Heroicons Script -->

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Token input formatting
        const tokenInput = document.getElementById('token');
        if (tokenInput) {
            tokenInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
                if (value.length > 6) value = value.substring(0, 6);
                e.target.value = value;
            });
        }

        // Password strength indicator (optional enhancement)
        const passwordInput = document.getElementById('password');
        if (passwordInput) {
            passwordInput.addEventListener('input', function(e) {
                // Add visual feedback for password strength
                const value = e.target.value;
                const border = e.target.parentElement;

                if (value.length >= 8 && /[A-Z]/.test(value) && /[a-z]/.test(value) && /\d/.test(value) && /[^A-Za-z0-9]/.test(value)) {
                    border.classList.remove('border-gray-600', 'border-yellow-500');
                    border.classList.add('border-green-500');
                } else if (value.length >= 6) {
                    border.classList.remove('border-gray-600', 'border-green-500');
                    border.classList.add('border-yellow-500');
                } else {
                    border.classList.remove('border-green-500', 'border-yellow-500');
                    border.classList.add('border-gray-600');
                }
            });
        }
    });

    // Password visibility toggle
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const eye = document.getElementById(fieldId + '-eye');

        if (field.type === 'password') {
            field.type = 'text';
            // Heroicon: eye icon changed to eye-slash;
        } else {
            field.type = 'password';
            // Heroicon: eye icon changed to eye;
        }

    }
</script>

@endsection
