@extends('layouts.guest1')
@section('title', 'Yönetici Girişi - Ticaret Platformu')
@section('content')

<!-- Modern Admin Login Container -->
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-900">
    <div class="max-w-md w-full space-y-8">

        <!-- Admin Login Card -->
        <div class="trading-card rounded-2xl p-8 shadow-2xl">

            <!-- Logo Section -->
            <div class="text-center mb-8">
                <a href="/" class="inline-block group">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $settings->logo) }}"
                             alt="Logo"
                             class="h-16 w-auto mx-auto transition-transform duration-300 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-indigo-500/20 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                </a>

                <!-- Admin Badge -->
                <div class="mt-4 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20">
                    <x-heroicon name="shield-check" class="w-3 h-3 mr-2" />
                    Yönetici Erişimi
                </div>
            </div>

            <!-- Header Section -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">
                    Yönetici Girişi
                </h1>
                <p class="text-gray-400 text-sm">
                    Ticaret platformu yönetimine güvenli erişim
                </p>
            </div>

            <!-- Alert Messages -->
            @if (session('message'))
                <div class="mb-6 p-4 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400">
                    <div class="flex items-center">
                        <x-heroicon name="exclamation-circle" class="w-5 h-5 mr-3 flex-shrink-0" />
                        <span class="text-sm font-medium">{{ session('message') }}</span>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-500/10 border border-green-500/20 text-green-400">
                    <div class="flex items-center">
                        <x-heroicon name="check-circle" class="w-5 h-5 mr-3 flex-shrink-0" />
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            <!-- Login Form -->
            <form method="POST" action="{{ route('adminlogin') }}" class="space-y-6">
                @csrf

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-200 mb-3">
                        E-posta Adresi
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <x-heroicon name="envelope" class="h-5 w-5 text-gray-400" />
                        </div>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="username"
                            value="{{ old('email') }}"
                            required
                            class="block w-full pl-12 pr-4 py-4 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-base font-medium"
                            placeholder="admin@example.com">
                    </div>
                    @error('email')
                        <div class="mt-2 flex items-center text-red-400 text-sm">
                            <x-heroicon name="exclamation-circle" class="w-4 h-4 mr-2" />
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <label for="password" class="block text-sm font-bold text-gray-200">
                            Şifre
                        </label>
                        <a href="{{ route('admin.forgetpassword') }}"
                           class="text-sm text-blue-400 hover:text-blue-300 font-medium transition-colors duration-200">
                            Şifrenizi mi unuttunuz?
                        </a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <x-heroicon name="lock-closed" class="h-5 w-5 text-gray-400" />
                        </div>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            class="block w-full pl-12 pr-12 py-4 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-base font-medium"
                            placeholder="Enter your password">
                        <button
                            type="button"
                            onclick="togglePasswordVisibility('password')"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-300 transition-colors duration-200">
                            <x-heroicon name="eye" class="h-5 w-5" id="password-eye" />
                        </button>
                    </div>
                    @error('password')
                        <div class="mt-2 flex items-center text-red-400 text-sm">
                            <x-heroicon name="exclamation-circle" class="w-4 h-4 mr-2" />
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button
                        type="submit"
                        class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-base font-bold rounded-xl text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98]">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-4">
                            <x-heroicon name="shield-check" class="h-5 w-5 text-blue-300 group-hover:text-blue-200 transition-colors duration-200" />
                        </span>
                        Yönetici Paneline Giriş Yap
                    </button>
                </div>

                <!-- Security Notice -->
                <div class="mt-6 p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                    <div class="flex items-start">
                        <x-heroicon name="information-circle" class="w-5 h-5 text-yellow-400 mr-3 mt-0.5 flex-shrink-0" />
                        <div class="text-sm text-yellow-300">
                            <p class="font-medium mb-1">Güvenlik Bildirimi</p>
                            <p class="text-yellow-400">Bu kısıtlı bir alandır. Tüm erişim girişimleri günlüğe kaydedilir ve izlenir.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Additional Info -->
        <div class="text-center">
            <p class="text-gray-500 text-sm">
                Yardıma ihtiyacınız var mı? <a href="mailto:support@company.com" class="text-blue-400 hover:text-blue-300 font-medium">teknik destekle</a> iletişime geçin
            </p>
        </div>
    </div>
</div>

<!-- Initialize Heroicons -->
<script>
function togglePasswordVisibility(fieldId) {
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

document.addEventListener('DOMContentLoaded', function() {
    
});
</script>
@endsection
