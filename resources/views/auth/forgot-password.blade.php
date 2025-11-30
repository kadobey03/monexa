@extends('layouts.guest1')
@section('title', __('auth.forgot.page_title'))
@section('content')
<div class="min-h-screen bg-gray-900 flex items-center justify-center p-4">
    <div class="w-full max-w-md space-y-8">
        <!-- Logo and Header -->
        <div class="text-center space-y-6">
            <div class="flex justify-center">
                <a href="/" class="inline-block">
                    <img src="{{ asset('storage/' . $settings->logo) }}"
                         alt="{{ $settings->site_name }}"
                         class="h-12 sm:h-16 w-auto">
                </a>
            </div>

            <!-- Header Section -->
            <div class="space-y-3">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <div class="p-2 bg-blue-500/20 rounded-lg">
                        <x-heroicon name="envelope" class="w-6 h-6 text-blue-400" />
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ __('auth.forgot.main_title') }}</h1>
                </div>
                <p class="text-gray-400 text-sm sm:text-base max-w-sm mx-auto leading-relaxed">
                    {{ __('auth.forgot.description') }}
                </p>
            </div>
        </div>

        <!-- Forgot Password Form -->
        <div class="bg-gray-900 backdrop-blur-sm border border-gray-700 rounded-2xl p-6 sm:p-8 space-y-6">
            <!-- Error Message -->
            @error('email')
                <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-xl">
                    <div class="flex items-center gap-3">
                        <x-heroicon name="exclamation-circle" class="w-5 h-5 text-red-400" />
                        <p class="text-red-300 text-sm font-bold">{{ $message }}</p>
                    </div>
                </div>
            @enderror

            <form action="{{ route('password.email') }}" method="post" class="space-y-6">
                @csrf

                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-bold text-gray-200">
                        {{ __('auth.forms.email') }} <span class="text-red-400">*</span>
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <x-heroicon name="envelope" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-400 transition-colors" />
                        </div>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email') }}"
                               required
                               class="block w-full rounded-xl border border-gray-600 bg-gray-900 pl-12 pr-4 py-4 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:bg-gray-800 transition-all duration-200 text-sm font-bold"
                               placeholder="{{ __('auth.forms.email_placeholder') }}">
                    </div>
                    <p class="text-xs text-gray-400">
                        {{ __('auth.forgot.email_help') }}
                    </p>
                </div>

                <input type="hidden" name="subStep" value="1" />

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:ring-2 focus:ring-blue-400/20">
                    <x-heroicon name="send" class="w-5 h-5" />
                    <span>{{ __('auth.forgot.send_reset_link') }}</span>
                </button>
            </form>

            <!-- Additional Options -->
            <div class="space-y-4 pt-4 border-t border-gray-700">
                <!-- Back to Login -->
                <div class="text-center">
                    <p class="text-gray-400 text-sm">
                        {{ __('auth.forgot.remember_password') }}
                        <a href="{{ route('login') }}"
                           class="font-bold text-blue-400 hover:text-blue-300 transition-colors underline underline-offset-2">
                            {{ __('auth.forgot.back_to_login') }}
                        </a>
                    </p>
                </div>

                <!-- Sign Up Link -->
                <div class="text-center">
                    <p class="text-gray-400 text-sm">
                        {{ __('auth.forgot.no_account') }}
                        <a href="{{ route('register') }}"
                           class="font-bold text-green-400 hover:text-green-300 transition-colors underline underline-offset-2">
                            {{ __('auth.forgot.create_account') }}
                        </a>
                    </p>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="p-4 bg-amber-500/10 rounded-xl border border-amber-500/20">
                <div class="flex items-start gap-3">
                    <x-heroicon name="shield-check" class="w-5 h-5 text-amber-400 mt-0.5 flex-shrink-0" />
                    <div>
                        <h4 class="text-sm font-bold text-amber-300 mb-1">{{ __('auth.security.warning_title') }}</h4>
                        <p class="text-xs text-gray-300">
                            {{ __('auth.forgot.security_notice') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trust Indicators -->
        <div class="flex items-center justify-center gap-6 text-xs text-gray-500">
            <div class="flex items-center gap-1">
                <x-heroicon name="shield-check" class="w-3 h-3" />
                <span>{{ __('auth.security.ssl_secure') }}</span>
            </div>
            <div class="flex items-center gap-1">
                <x-heroicon name="lock-closed" class="w-3 h-3" />
                <span>{{ __('auth.security.encryption_256') }}</span>
            </div>
            <div class="flex items-center gap-1">
                <x-heroicon name="award" class="w-3 h-3" />
                <span>{{ __('auth.security.regulated_platform') }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center">
            <p class="text-xs text-gray-500">
                © {{ date('Y') }} {{ $settings->site_name }}. {{ __('footer.copyright') }} |
                {{ __('auth.security.licensed_platform') }}
            </p>
        </div>
    </div>
</div>
@endsection
