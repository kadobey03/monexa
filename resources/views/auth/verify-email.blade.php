@extends('layouts.guest1')
@section('title', 'E-posta Doğrulama - Ticaret Hesabınızı Güvenceye Alın')
@section('content')

<!-- Email Verification Interface -->
<div class="min-h-screen bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">

        <!-- Email Verification Card -->
        <div class="bg-gray-900 rounded-2xl p-8 shadow-2xl border border-gray-700">

            <!-- Header Section -->
            <div class="text-center mb-8">
                <!-- Email Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-500/10 mb-4">
                    <x-heroicon name="mail-check" class="h-8 w-8 text-green-400" />
                </div>

                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
                    E-posta Adresinizi Doğrulayın
                </h1>
                <p class="text-gray-400 text-sm md:text-base">
                    E-posta adresinizi doğrulayarak ticaret hesabınızı güvenceye alın
                </p>
            </div>

            <!-- Success Messages -->
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl">
                    <div class="flex items-start gap-3">
                        <x-heroicon name="check-circle" class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" />
                        <div class="text-sm">
                            <p class="text-green-300 font-bold mb-1">Doğrulama E-postası Gönderildi</p>
                            <p class="text-gray-300">
                                E-posta adresinize bir doğrulama bağlantısı gönderildi. Hesabınızı doğrulamak için lütfen gelen kutunuzu kontrol edin ve bağlantıya tıklayın.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('message'))
                <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl">
                    <div class="flex items-start gap-3">
                        <x-heroicon name="information-circle" class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" />
                        <div class="text-sm">
                            <p class="text-green-300 font-bold mb-1">Güncelleme</p>
                            <p class="text-gray-300">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Email Verification Instructions -->
            <div class="mb-8 p-6 bg-blue-500/10 border border-blue-500/20 rounded-xl">
                <div class="flex items-start gap-4">
                    <x-heroicon name="envelope" class="w-6 h-6 text-blue-400 mt-1 flex-shrink-0" />
                    <div>
                        <h3 class="text-blue-300 font-bold text-lg mb-3">E-postanızı Kontrol Edin</h3>
                        <p class="text-gray-300 text-sm mb-4 leading-relaxed">
                            Kayıtlı e-posta adresinize güvenli bir doğrulama bağlantısı gönderdik.
                            Ticaret hesabınızı etkinleştirmek ve tüm özelliklere erişmek için e-postadaki bağlantıya tıklayın.
                        </p>

                        <!-- Email Steps -->
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <span class="flex-shrink-0 w-6 h-6 bg-blue-500/20 rounded-full flex items-center justify-center text-blue-400 font-bold text-xs">1</span>
                                <span>Doğrulama e-postamız için gelen kutunuzu kontrol edin</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <span class="flex-shrink-0 w-6 h-6 bg-blue-500/20 rounded-full flex items-center justify-center text-blue-400 font-bold text-xs">2</span>
                                <span>E-postadaki "E-postayı Doğrula" düğmesine tıklayın</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-300">
                                <span class="flex-shrink-0 w-6 h-6 bg-blue-500/20 rounded-full flex items-center justify-center text-blue-400 font-bold text-xs">3</span>
                                <span>Hesap kurulumunu tamamlamak için geri dönün</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="space-y-4">

                <!-- Resend Verification Email -->
                <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
                    @csrf

                    <!-- Resend Button -->
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-blue-500/25 focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                    >
                        <span class="flex items-center justify-center gap-2">
                            <x-heroicon name="arrow-path" class="w-5 h-5" />
                            Doğrulama E-postasını Tekrar Gönder
                        </span>
                    </button>
                </form>

                <!-- Logout Option -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="w-full bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 border border-gray-600 hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500/50"
                    >
                        <span class="flex items-center justify-center gap-2">
                            <x-heroicon name="arrow-left-on-rectangle" class="w-5 h-5" />
                            Çıkış Yap
                        </span>
                    </button>
                </form>
            </div>

            <!-- Troubleshooting Tips -->
            <div class="mt-8 bg-gray-800/50 rounded-lg p-4 border border-gray-700">
                <h4 class="text-white font-bold text-sm mb-3 flex items-center gap-2">
                    <x-heroicon name="question-mark-circle" class="w-4 h-4 text-yellow-400" />
                    E-posta Bulamıyor musunuz?
                </h4>
                <ul class="text-gray-300 text-xs space-y-2">
                    <li class="flex items-start gap-2">
                        <span class="text-yellow-400 mt-1">•</span>
                        Spam veya gereksiz klasörünüzü kontrol edin
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-yellow-400 mt-1">•</span>
                        E-posta adresinin doğru olduğundan emin olun
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-yellow-400 mt-1">•</span>
                        Teslimat için birkaç dakika bekleyin
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-yellow-400 mt-1">•</span>
                        Gerekirse 2 dakikadan sonra "Tekrar Gönder"e tıklayın
                    </li>
                </ul>
            </div>

            <!-- Security Notice -->
            <div class="mt-6 pt-6 border-t border-gray-700">
                <div class="text-center">
                    <p class="text-xs text-gray-500 mb-3">E-posta neden doğrulanıyor?</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                        <div class="flex flex-col items-center gap-1 text-gray-400">
                            <x-heroicon name="shield-check" class="w-4 h-4 text-green-400" />
                            <span>Hesap Güvenliği</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 text-gray-400">
                            <x-heroicon name="bell" class="w-4 h-4 text-blue-400" />
                            <span>Ticaret Uyarıları</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 text-gray-400">
                            <x-heroicon name="key" class="w-4 h-4 text-purple-400" />
                            <span>Şifre Kurtarma</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Background Pattern -->
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-green-900/5 via-gray-900 to-blue-900/5"></div>
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-96 h-96 bg-green-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/2 translate-x-1/2 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl"></div>
        </div>

        <!-- Support Contact -->
        <div class="text-center mt-6">
            <p class="text-gray-500 text-sm">
                Yardıma ihtiyacınız var mı?
                <a href="mailto:support@bluetrade.com" class="text-blue-400 hover:text-blue-300 font-medium ml-1 transition-colors duration-200">
                    Destek ile İletişime Geç
                </a>
            </p>
        </div>
    </div>
</div>

<!-- Add Heroicons Script -->

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Auto-check email status periodically (optional enhancement)
        let checkCount = 0;
        const maxChecks = 5;

        function showEmailTip() {
            if (checkCount < maxChecks) {
                setTimeout(() => {
                    const tipElement = document.querySelector('[data-email-tip]');
                    if (tipElement) {
                        tipElement.classList.add('animate-pulse');
                        setTimeout(() => {
                            tipElement.classList.remove('animate-pulse');
                        }, 2000);
                    }
                    checkCount++;
                    showEmailTip();
                }, 30000); // Show tip every 30 seconds
            }
        }

        // Start the tip system after 1 minute
        setTimeout(showEmailTip, 60000);

        // Add click tracking for resend button
        const resendButton = document.querySelector('button[type="submit"]');
        if (resendButton) {
            resendButton.addEventListener('click', function() {
                // Reset check count when resending
                checkCount = 0;

                // Visual feedback
                this.innerHTML = '<span class="flex items-center justify-center gap-2"><x-heroicon name="loader-2" class="w-5 h-5 animate-spin" />Gönderiliyor...</span>';

                // Re-initialize icons after content change
                setTimeout(() => {
                    
                }, 100);
            });
        }
    });
</script>
@endsection
