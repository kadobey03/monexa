@extends('layouts.guest1')
@section('title', 'Şifrenizi sıfırlayın')
@section('content')
<div class="min-h-screen bg-gray-900 flex items-center justify-center p-4">
    <div class="w-full max-w-md space-y-8">
        <!-- Status Messages -->
        @if (Session::has('status'))
            <div class="p-4 bg-green-500/10 border border-green-500/20 rounded-xl">
                <div class="flex items-center gap-3">
                    <x-heroicon name="check-circle" class="w-5 h-5 text-green-400" />
                    <p class="text-green-300 text-sm font-bold">{{ session('status') }}</p>
                </div>
            </div>
        @endif

        @if (Session::has('message'))
            <div class="p-4 bg-blue-500/10 border border-blue-500/20 rounded-xl">
                <div class="flex items-center gap-3">
                    <x-heroicon name="information-circle" class="w-5 h-5 text-blue-400" />
                    <p class="text-blue-300 text-sm font-bold">{{ Session::get('message') }}</p>
                </div>
            </div>
        @endif

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
                        <x-heroicon name="key-round" class="w-6 h-6 text-blue-400" />
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">Şifre Sıfırlama</h1>
                </div>
                <p class="text-gray-400 text-sm sm:text-base max-w-sm mx-auto leading-relaxed">
                    E-posta adresinizi girin ve ticaret hesabınız için yeni güvenli bir şifre oluşturun.
                </p>
            </div>
        </div>

        <!-- Reset Password Form -->
        <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-2xl p-6 sm:p-8 space-y-6">
            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-bold text-gray-200">
                        E-posta Adresi <span class="text-red-400">*</span>
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
                               placeholder="your.email@example.com">
                    </div>
                    @error('email')
                        <p class="text-sm text-red-400 flex items-center gap-1">
                            <x-heroicon name="exclamation-circle" class="w-4 h-4" />{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- New Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-bold text-gray-200">
                        Yeni Şifre <span class="text-red-400">*</span>
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <x-heroicon name="lock-closed" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-400 transition-colors" />
                        </div>
                        <input type="password"
                               name="password"
                               autocomplete="new-password"
                               id="password"
                               required
                               autocomplete="new-password"
                               class="block w-full rounded-xl border border-gray-600 bg-gray-900 pl-12 pr-12 py-4 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:bg-gray-800 transition-all duration-200 text-sm font-bold"
                               placeholder="Güçlü şifre oluşturun">
                        <button type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-blue-400 transition-colors"
                                onclick="togglePassword('password')">
                            <x-heroicon name="eye" class="h-5 w-5" id="password-eye" />
                        </button>
                    </div>
                    @error('password')
                        <p class="text-sm text-red-400 flex items-center gap-1">
                            <x-heroicon name="exclamation-circle" class="w-4 h-4" />{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-200">
                        Şifreyi Onayla <span class="text-red-400">*</span>
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <x-heroicon name="key" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-400 transition-colors" />
                        </div>
                        <input type="password"
                               name="password_confirmation"
                               autocomplete="new-password"
                               id="password_confirmation"
                               required
                               autocomplete="new-password"
                               class="block w-full rounded-xl border border-gray-600 bg-gray-900 pl-12 pr-12 py-4 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:bg-gray-800 transition-all duration-200 text-sm font-bold"
                               placeholder="Şifrenizi onaylayın">
                        <button type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-blue-400 transition-colors"
                                onclick="togglePassword('password_confirmation')">
                            <x-heroicon name="eye" class="h-5 w-5" id="password_confirmation-eye" />
                        </button>
                    </div>
                </div>

                <!-- Password Requirements -->
                <div class="p-4 bg-gray-900/50 rounded-xl border border-gray-700">
                    <p class="text-sm font-bold text-gray-200 mb-2">Şifre Gereksinimleri:</p>
                    <ul class="text-xs text-gray-300 space-y-1">
                        <li class="flex items-center gap-2">
                            <x-heroicon name="check" class="w-3 h-3 text-green-400" />
                            En az 8 karakter uzunluğunda
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon name="check" class="w-3 h-3 text-green-400" />
                            Büyük ve küçük harf içeriyor
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon name="check" class="w-3 h-3 text-green-400" />
                            En az bir rakam veya özel karakter içeriyor
                        </li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:ring-2 focus:ring-blue-400/20">
                    <x-heroicon name="key-round" class="w-5 h-5" />
                    <span>Şifreyi Sıfırla</span>
                </button>
            </form>

            <!-- Back to Login Link -->
            <div class="text-center pt-4 border-t border-gray-700">
                <p class="text-gray-400 text-sm">
                    Şifrenizi hatırlıyor musunuz?
                    <a href="{{ route('login') }}"
                       class="font-bold text-blue-400 hover:text-blue-300 transition-colors underline underline-offset-2">
                        Girişe Dön
                    </a>
                </p>
            </div>

            <!-- Security Notice -->
            <div class="p-4 bg-amber-500/10 rounded-xl border border-amber-500/20">
                <div class="flex items-start gap-3">
                    <x-heroicon name="shield-exclamation" class="w-5 h-5 text-amber-400 mt-0.5 flex-shrink-0" />
                    <div>
                        <h4 class="text-sm font-bold text-amber-300 mb-1">Güvenlik Uyarısı</h4>
                        <p class="text-xs text-gray-300">
                            Güvenliğiniz için bu şifre sıfırlama bağlantısı 60 dakika içinde geçerliliğini yitirecektir.
                            Ticaret hesabınız için güçlü ve benzersiz bir şifre seçin.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trust Indicators -->
        <div class="flex items-center justify-center gap-6 text-xs text-gray-500">
            <div class="flex items-center gap-1">
                <x-heroicon name="shield-check" class="w-3 h-3" />
                <span>SSL Güvenli</span>
            </div>
            <div class="flex items-center gap-1">
                <x-heroicon name="lock-closed" class="w-3 h-3" />
                <span>256-bit Şifreleme</span>
            </div>
            <div class="flex items-center gap-1">
                <x-heroicon name="award" class="w-3 h-3" />
                <span>Düzenlenmiş Platform</span>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eyeIcon = document.getElementById(fieldId + '-eye');

    if (field.type === 'password') {
        field.type = 'text';
        // Heroicon: eyeIcon icon changed to eye-slash;
    } else {
        field.type = 'password';
        // Heroicon: eyeIcon icon changed to eye;
    }

}
</script>
@endsection
