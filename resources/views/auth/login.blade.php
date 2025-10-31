@extends('layouts.guest')
@section('title', 'Giriş Yap')
@section('content')

<div class="w-full max-w-md">
    <!-- Status Alert -->
    @if (Session::has('status'))
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-xl">
            <div class="flex items-center gap-3">
                <i data-lucide="info" class="h-5 w-5 text-blue-600 dark:text-blue-400"></i>
                <div class="text-sm text-blue-800 dark:text-blue-200">
                    {{ session('status') }}
                </div>
            </div>
        </div>
    @endif

    <!-- Login Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl ring-1 ring-gray-200 dark:ring-gray-700 p-8">
        <div class="text-center mb-8">
            <!-- Logo -->
            @if($settings && $settings->logo)
                <img src="{{ asset('storage/'.$settings->logo)}}"
                     class="h-16 w-auto mx-auto mb-4"
                     alt="{{ $settings->site_name ?? 'Site Logo' }}" />
            @else
                <div class="h-16 w-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-white font-bold text-xl">{{ substr($settings->site_name ?? 'M', 0, 1) }}</span>
                </div>
            @endif

            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                Hoş Geldiniz
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                {{ $settings->site_name ?? 'Monexa' }} Paneline Giriş Yapın
            </p>
        </div>

        <!-- Error Messages -->
        @error('email')
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-xl">
                <div class="flex items-center gap-3">
                    <i data-lucide="alert-circle" class="h-5 w-5 text-red-600 dark:text-red-400"></i>
                    <div class="text-sm text-red-800 dark:text-red-200">
                        {{ $message }}
                    </div>
                </div>
            </div>
        @enderror

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="post" class="space-y-6">
            @csrf

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    E-posta Adresi
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="mail" class="h-5 w-5 text-gray-400"></i>
                    </div>
                    <input type="email" name="email" id="email" required
                           autocomplete="email"
                           class="block w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="ornek@email.com"
                           value="{{ old('email') }}">
                </div>
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Şifre
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="lock" class="h-5 w-5 text-gray-400"></i>
                    </div>
                    <input type="password" name="password" id="password" required
                           autocomplete="current-password"
                           class="block w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                           placeholder="Şifrenizi giriniz">
                    <button type="button" onclick="togglePasswordVisibility('password')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i data-lucide="eye" class="h-5 w-5" id="password-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                        Beni hatırla
                    </label>
                </div>
                <a href="{{ route('password.request') }}"
                   class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">
                    Şifremi unuttum
                </a>
            </div>

            <!-- Login Button -->
            <button type="submit"
                    class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <i data-lucide="log-in" class="h-4 w-4"></i>
                Giriş Yap
            </button>
        </form>

        <!-- Register Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Hesabınız yok mu?
                <a href="{{ route('register') }}"
                   class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">
                    Kayıt olun
                </a>
            </p>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const eye = document.getElementById(fieldId + '-eye');
        
        if (field.type === 'password') {
            field.type = 'text';
            eye.setAttribute('data-lucide', 'eye-off');
        } else {
            field.type = 'password';
            eye.setAttribute('data-lucide', 'eye');
        }
        
        // Re-initialize lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Auto focus email field
        const emailField = document.getElementById('email');
        if (emailField) {
            emailField.focus();
        }
    });
</script>

@endsection
