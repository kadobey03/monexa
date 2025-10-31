@extends('layouts.guest1')
@section('title', 'Giriş Yap')
@section('content')

<!-- Fintech Trading Platform Login -->
<div class="min-h-screen bg-gray-900 relative overflow-hidden">
    <!-- Remove animated background elements and floating orbs -->

    <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
        <div class="w-full max-w-lg">
            <!-- Trading Login Card -->
            <div class="relative bg-gray-900 border border-gray-700 rounded-3xl p-8 sm:p-10 shadow-2xl">
                <!-- Remove glow effect -->

                <div class="relative">
                    <!-- Status Alert -->
                    @if (Session::has('status'))
                        <div class="mb-6 p-4 bg-blue-500/20 border border-blue-400/30 rounded-2xl" role="alert">
                            <div class="flex items-center gap-3">
                                <i data-lucide="info" class="h-5 w-5 text-blue-400 flex-shrink-0"></i>
                                <div class="text-sm text-blue-100">
                                    {{ session('status') }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Header Section -->
                    <div class="text-center mb-8">
                        <!-- Logo -->
                        <div class="flex items-center justify-center mb-6">
                            <div class="relative">
                                <!-- Remove glow effect -->
                                @if($settings && $settings->logo)
                                    <img src="{{ asset('storage/'.$settings->logo)}}"
                                         class="relative h-16 w-auto"
                                         alt="{{ $settings->site_name ?? 'Site Logo' }}" />
                                @else
                                    <div class="relative h-16 w-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center">
                                        <span class="text-white font-bold text-xl">{{ substr($settings->site_name ?? 'SITE', 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Title -->
                        <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                            Tekrar Hoş Geldiniz
                        </h1>
                        <h2 class="text-lg sm:text-xl font-semibold mb-3">
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">{{ $settings->site_name ?? 'Trading Platform' }}</span>
                        </h2>
                        <p class="text-gray-300 text-sm sm:text-base">
                            Ticaret panelinize erişin
                        </p>

                        <!-- Trading Stats -->
                        <div class="flex items-center justify-center gap-6 mt-6 text-xs sm:text-sm">
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1 text-green-400 mb-1">
                                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                    <span class="font-medium">Canlı</span>
                                </div>
                                <div class="text-gray-400">7/24 Piyasalar</div>
                            </div>
                            <div class="w-px h-10 bg-white/20"></div>
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1 text-blue-400 mb-1">
                                    <i data-lucide="zap" class="w-3 h-3"></i>
                                    <span class="font-medium">Hızlı</span>
                                </div>
                                <div class="text-gray-400">Yürütme</div>
                            </div>
                            <div class="w-px h-10 bg-white/20"></div>
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-1 text-cyan-400 mb-1">
                                    <i data-lucide="shield" class="w-3 h-3"></i>
                                    <span class="font-medium">Güvenli</span>
                                </div>
                                <div class="text-gray-400">Platform</div>
                            </div>
                        </div>
                    </div>
                    <!-- Error Messages -->
                    @error('email')
                        <div class="mb-6 p-4 bg-red-500/20 border border-red-400/30 rounded-2xl">
                            <div class="flex items-center gap-3">
                                <i data-lucide="alert-circle" class="h-5 w-5 text-red-400 flex-shrink-0"></i>
                                <div class="text-sm text-red-100">
                                    {{ $message }}
                                </div>
                            </div>
                        </div>
                    @enderror

                    <!-- Login Form -->
                    <form action="{{ route('login') }}" method="post" class="space-y-6">
                        @csrf

                        <!-- Email Field -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-semibold text-gray-200">
                                E-posta Adresi veya Kullanıcı Adı
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                                    <i data-lucide="mail" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-400 transition-colors duration-200"></i>
                                </div>
                                <input type="text" name="email" id="email" required
                                       autocomplete="email"
                                       class="block w-full rounded-2xl border border-gray-600 bg-gray-900 pl-12 pr-4 py-4 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:bg-gray-800 transition-all duration-200 text-sm font-medium"
                                       placeholder="eposta@ornek.com"
                                       value="{{ old('email') }}">
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-semibold text-gray-200">
                                Şifre
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                                    <i data-lucide="lock" class="h-5 w-5 text-gray-400 group-focus-within:text-blue-400 transition-colors duration-200"></i>
                                </div>
                                <input type="password" name="password" id="password" required
                                       autocomplete="current-password"
                                       class="block w-full rounded-2xl border border-gray-600 bg-gray-900 pl-12 pr-12 py-4 text-white placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:bg-gray-800 transition-all duration-200 text-sm font-medium"
                                       placeholder="Şifrenizi giriniz">
                                <button type="button" onclick="togglePasswordVisibility('password')"
                                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-blue-400 transition-colors">
                                    <i data-lucide="eye" class="h-5 w-5" id="password-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center">
                                <input type="checkbox" name="remember" id="remember"
                                       class="h-4 w-4 rounded border-gray-600 bg-gray-900 text-blue-500 focus:ring-2 focus:ring-blue-400/20 transition-colors">
                                <label for="remember" class="ml-3 text-gray-300 font-medium">
                                    Beni hatırla
                                </label>
                            </div>
                            <a href="{{ route('password.request') }}"
                               class="text-blue-400 hover:text-blue-300 transition-colors underline underline-offset-2">
                                Şifremi unuttum?
                            </a>
                        </div>

                        <!-- Login Button -->
                        <div class="mt-8">
                            <button type="submit"
                                    class="group relative flex w-full justify-center items-center gap-3 rounded-2xl bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 px-6 py-4 text-base font-bold text-white transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-400/50 disabled:opacity-50 disabled:cursor-not-allowed">
                                <i data-lucide="log-in" class="h-5 w-5"></i>
                                <span>Panele Eriş</span>
                                <i data-lucide="arrow-right" class="h-4 w-4 group-hover:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Biometric Login Methods -->
                    <div class="mt-8">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-white/20"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="bg-gray-900 px-4 text-gray-300 font-medium">Hızlı Erişim</span>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-center space-x-4">
                            <button type="button"
                                    class="group relative inline-flex items-center justify-center w-14 h-14 rounded-2xl border border-gray-600 bg-gray-800 hover:bg-gray-700 hover:border-blue-400/50 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i data-lucide="fingerprint" class="h-6 w-6 text-blue-400 group-hover:text-blue-300 group-hover:scale-110 transition-all duration-200"></i>
                                <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 bg-gray-900/90 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                    Parmak İzi
                                </div>
                            </button>
                            <button type="button"
                                    class="group relative inline-flex items-center justify-center w-14 h-14 rounded-2xl border border-gray-600 bg-gray-800 hover:bg-gray-700 hover:border-cyan-400/50 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i data-lucide="scan-face" class="h-6 w-6 text-cyan-400 group-hover:text-cyan-300 group-hover:scale-110 transition-all duration-200"></i>
                                <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 bg-gray-900/90 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                    Yüz Tanıma
                                </div>
                            </button>
                            <button type="button"
                                    class="group relative inline-flex items-center justify-center w-14 h-14 rounded-2xl border border-gray-600 bg-gray-800 hover:bg-gray-700 hover:border-green-400/50 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i data-lucide="qr-code" class="h-6 w-6 text-green-400 group-hover:text-green-300 group-hover:scale-110 transition-all duration-200"></i>
                                <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 bg-gray-900/90 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                    QR Kod
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-10 text-center space-y-6">
                        <!-- Register Link -->
                        <div class="text-sm">
                            <span class="text-gray-300">Trading'e yeni misiniz? </span>
                            <a href="{{ route('register') }}"
                               class="font-semibold text-blue-400 hover:text-blue-300 transition-colors underline underline-offset-2">
                                Hesabınızı oluşturun
                            </a>
                        </div>

                        <!-- Security Badges -->
                        <div class="flex items-center justify-center gap-6 py-4 text-xs text-gray-400">
                            <div class="flex items-center gap-1">
                                <i data-lucide="shield-check" class="w-3 h-3 text-green-400"></i>
                                <span>SSL Güvenliği</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <i data-lucide="lock" class="w-3 h-3 text-blue-400"></i>
                                <span>256-bit Şifreleme</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <i data-lucide="award" class="w-3 h-3 text-cyan-400"></i>
                                <span>Düzenlenmiş</span>
                            </div>
                        </div>

                        <!-- Copyright -->
                        <p class="text-xs text-gray-500">
                            © {{ date('Y') }} {{ $settings->site_name ?? 'Trading Platform' }}. Tüm hakları saklıdır.
                        </p>
                    </div>
                </div>
            </div>
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
        // E-posta alanına otomatik odaklanma
        const emailField = document.getElementById('email');
        if (emailField) {
            emailField.focus();
        }

        // Lucide ikonlarını başlat
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>

@endsection
