@extends('layouts.guest1')
@section('title', '{{ __('auth.admin.forgot.page_title') }}')
@section('content')

<!-- Admin Password Recovery Interface -->
<div class="min-h-screen bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">

        <!-- Admin Password Recovery Card -->
        <div class="bg-gray-900 rounded-2xl p-8 shadow-2xl border border-gray-700">

            <!-- Header Section -->
            <div class="text-center mb-8">
                <!-- Security Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-orange-500/10 mb-4">
                    <x-heroicon name="shield-question" class="h-8 w-8 text-orange-400" />
                </div>

                <!-- Admin Badge -->
                <div class="inline-flex items-center gap-2 bg-orange-500/10 border border-orange-500/20 rounded-full px-4 py-2 mb-4">
                    <x-heroicon name="key" class="w-4 h-4 text-orange-400" />
                    <span class="text-orange-300 text-sm font-bold">{{ __('auth.admin.forgot.admin_recovery_badge') }}</span>
                </div>

                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
                    {{ __('auth.admin.forgot.main_title') }}
                </h1>
                <p class="text-gray-400 text-sm md:text-base">
                    {{ __('auth.admin.forgot.subtitle') }}
                </p>
            </div>

            <!-- Alert Messages -->
            <x-danger-alert />
            <x-success-alert />

            @if (session('status'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl">
                    <div class="flex items-start gap-3">
                        <x-heroicon name="check-circle" class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" />
                        <div class="text-sm">
                            <p class="text-green-300 font-bold mb-1">{{ __('auth.admin.forgot.recovery_email_sent') }}</p>
                            <p class="text-gray-300">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Recovery Instructions -->
            <div class="mb-6 p-4 bg-blue-500/10 border border-blue-500/20 rounded-xl">
                <div class="flex items-start gap-3">
                    <x-heroicon name="information-circle" class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0" />
                    <div class="text-sm">
                        <p class="text-blue-300 font-bold mb-1">{{ __('auth.admin.forgot.recovery_process') }}</p>
                        <p class="text-gray-300">
                            {{ __('auth.admin.forgot.recovery_instructions') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Password Recovery Form -->
            <form method="POST" action="{{ route('sendpasswordrequest') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-bold text-gray-200">
                        {{ __('auth.admin.forgot.admin_email') }}
                    </label>
                    <div class="relative">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 bg-gray-900 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 focus:outline-none transition-all duration-200"
                            placeholder="{{ __('auth.admin.forgot.admin_email_placeholder') }}"
                            autocomplete="email"
                            required
                            autofocus
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
                    <p class="text-xs text-gray-500">{{ __('auth.admin.forgot.email_help') }}</p>
                </div>

                <!-- Security Notice -->
                <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <x-heroicon name="shield-exclamation" class="w-5 h-5 text-yellow-400 mt-0.5 flex-shrink-0" />
                        <div class="text-sm">
                            <p class="text-yellow-300 font-bold mb-1">{{ __('auth.admin.forgot.security_notice_title') }}</p>
                            <ul class="text-gray-300 space-y-1">
                                <li class="flex items-start gap-2">
                                    <span class="text-yellow-400 mt-1">•</span>
                                    {{ __('auth.admin.forgot.token_expires_15min') }}
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-yellow-400 mt-1">•</span>
                                    {{ __('auth.admin.forgot.only_admin_emails') }}
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-yellow-400 mt-1">•</span>
                                    {{ __('auth.admin.forgot.all_attempts_logged') }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Send Recovery Email Button -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-orange-500/25 focus:outline-none focus:ring-2 focus:ring-orange-500/50"
                >
                    <span class="flex items-center justify-center gap-2">
                        <x-heroicon name="send" class="w-5 h-5" />
                        {{ __('auth.admin.forgot.send_recovery_instructions') }}
                    </span>
                </button>

                <!-- Back to Admin Login -->
                <div class="text-center">
                    <a href="{{ route('adminloginform') }}"
                       class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors duration-200">
                        <x-heroicon name="arrow-left" class="w-4 h-4" />
                        {{ __('auth.admin.forgot.back_to_admin_login') }}
                    </a>
                </div>
            </form>

            <!-- Recovery Process Steps -->
            <div class="mt-8 bg-gray-800/50 rounded-lg p-4 border border-gray-700">
                <h4 class="text-white font-bold text-sm mb-3 flex items-center gap-2">
                    <x-heroicon name="check-list" class="w-4 h-4 text-blue-400" />
                    {{ __('auth.admin.forgot.recovery_process_steps') }}
                </h4>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <span class="flex-shrink-0 w-6 h-6 bg-orange-500/20 rounded-full flex items-center justify-center text-orange-400 font-bold text-xs">1</span>
                        <span>{{ __('auth.admin.forgot.step_1') }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <span class="flex-shrink-0 w-6 h-6 bg-orange-500/20 rounded-full flex items-center justify-center text-orange-400 font-bold text-xs">2</span>
                        <span>{{ __('auth.admin.forgot.step_2') }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <span class="flex-shrink-0 w-6 h-6 bg-orange-500/20 rounded-full flex items-center justify-center text-orange-400 font-bold text-xs">3</span>
                        <span>{{ __('auth.admin.forgot.step_3') }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-300">
                        <span class="flex-shrink-0 w-6 h-6 bg-orange-500/20 rounded-full flex items-center justify-center text-orange-400 font-bold text-xs">4</span>
                        <span>{{ __('auth.admin.forgot.step_4') }}</span>
                    </div>
                </div>
            </div>

            <!-- Admin Security Features -->
            <div class="mt-6 pt-6 border-t border-gray-700">
                <div class="text-center">
                    <p class="text-xs text-gray-500 mb-3">{{ __('auth.admin.forgot.enterprise_security') }}</p>
                    <div class="flex items-center justify-center gap-4 text-gray-600">
                        <span class="flex items-center gap-1">
                            <x-heroicon name="shield-check" class="w-3 h-3" />
                            <span class="text-xs">{{ __('auth.admin.forgot.encrypted') }}</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <x-heroicon name="clock" class="w-3 h-3" />
                            <span class="text-xs">{{ __('auth.admin.forgot.time_limited') }}</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <x-heroicon name="eye" class="w-3 h-3" />
                            <span class="text-xs">{{ __('auth.admin.forgot.audit_log') }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Background Pattern -->
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-900/5 via-gray-900 to-yellow-900/5"></div>
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-96 h-96 bg-orange-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/2 translate-x-1/2 w-96 h-96 bg-yellow-500/5 rounded-full blur-3xl"></div>
        </div>

        <!-- Support Information -->
        <div class="text-center mt-6">
            <p class="text-gray-500 text-sm">
                {{ __('auth.admin.forgot.need_help') }}
                <a href="mailto:admin-support@bluetrade.com" class="text-orange-400 hover:text-orange-300 font-medium ml-1 transition-colors duration-200">
                    {{ __('auth.admin.forgot.contact_admin_support') }}
                </a>
            </p>
        </div>
    </div>
</div>

<!-- Add Heroicons Script -->

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Auto-focus email input
        const emailInput = document.getElementById('email');
        if (emailInput) {
            emailInput.focus();
        }

        // Email validation feedback
        emailInput.addEventListener('input', function(e) {
            const value = e.target.value;
            const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
            const parent = e.target.parentElement;

            if (value && isValid) {
                parent.classList.remove('border-gray-600', 'border-red-500');
                parent.classList.add('border-green-500');
            } else if (value && !isValid) {
                parent.classList.remove('border-gray-600', 'border-green-500');
                parent.classList.add('border-red-500');
            } else {
                parent.classList.remove('border-green-500', 'border-red-500');
                parent.classList.add('border-gray-600');
            }
        });

        // Form submission feedback
        const form = document.querySelector('form');
        const submitButton = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function() {
            submitButton.innerHTML = '<span class="flex items-center justify-center gap-2"><x-heroicon name="loader-2" class="w-5 h-5 animate-spin" />Kurtarma E-postası Gönderiliyor...</span>';
            submitButton.disabled = true;

            // Re-initialize icons
            setTimeout(() => {
                
            }, 100);
        });
    });
</script>
@endsection
