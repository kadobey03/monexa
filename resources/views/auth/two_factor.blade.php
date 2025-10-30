@extends('layouts.guest1')
@section('title', 'İki Faktörlü Kimlik Doğrulama - Güvenli Doğrulama')
@section('content')

<!-- Advanced 2FA Challenge -->
<div class="min-h-screen bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" id="twoFactorContainer">
    <div class="max-w-md w-full space-y-8">

        <!-- 2FA Challenge Card -->
        <div class="bg-gray-900 rounded-2xl p-8 shadow-2xl border border-gray-700">

            <!-- Header Section -->
            <div class="text-center mb-8">
                <!-- Dynamic Security Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-500/10 mb-4">
                    <i data-lucide="smartphone" id="normalIcon" class="h-8 w-8 text-blue-400"></i>
                    <i data-lucide="key-round" id="recoveryIcon" class="h-8 w-8 text-amber-400" style="display: none;"></i>
                </div>

                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
                    İki Adımlı Doğrulama
                </h1>

                <!-- Dynamic Descriptions -->
                <p class="text-gray-400 text-sm md:text-base" id="normalDescription">
                    Ticaret hesabınızı güvenceye almak için kimlik doğrulayıcı uygulamanızdan 6 haneli kodu girin
                </p>
                <p class="text-gray-400 text-sm md:text-base" id="recoveryDescription" style="display: none;">
                    Hesabınıza erişimi geri kazanmak için acil kurtarma kodlarınızdan birini kullanın
                </p>
            </div>

            <!-- Dynamic Security Notice -->
            <div class="mb-6 p-4 rounded-xl border transition-all duration-300 bg-blue-500/10 border-blue-500/20" id="securityNotice">
                <div class="flex items-start gap-3">
                    <i data-lucide="shield-alert" id="normalNoticeIcon" class="w-5 h-5 text-blue-400 mt-0.5 flex-shrink-0"></i>
                    <i data-lucide="alert-triangle" id="recoveryNoticeIcon" class="w-5 h-5 text-amber-400 mt-0.5 flex-shrink-0" style="display: none;"></i>
                    <div class="text-sm">
                        <p class="font-bold mb-1 text-blue-300" id="noticeTitle">
                            <span id="normalNoticeTitle">Kimlik Doğrulayıcı Gerekli</span>
                            <span id="recoveryNoticeTitle" style="display: none;">Kurtarma Modu</span>
                        </p>
                        <p class="text-gray-300" id="normalNoticeText">
                            Kimlik doğrulayıcı uygulamanızı açın (Google Authenticator, Authy vb.) ve mevcut 6 haneli kodu girin.
                        </p>
                        <p class="text-gray-300" id="recoveryNoticeText" style="display: none;">
                            Kurtarma kodları tek kullanımlıktır. Kullandıktan sonra kalan kodları güvenli bir yerde saklayın.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl">
                    <div class="space-y-2">
                        @foreach ($errors->all() as $error)
                            <div class="flex items-center gap-3">
                                <i data-lucide="alert-circle" class="w-5 h-5 text-red-400 flex-shrink-0"></i>
                                <span class="text-red-300 text-sm font-medium">{{ $error }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-12" id="normalCodeSection">
                        <div class="mb-5">
                            <label class="form-label">
                                Kod
                            </label>
                            <!-- Input -->
                            <input type="text" inputmode="numeric" class="form-control"
                                placeholder="Enter auth code from your app" name="code" autofocus id="codeInput"
                                autocomplete="one-time-code">
                        </div>
                    </div>
                    <!--end col-->

                    <div class="col-lg-12" id="recoveryCodeSection" style="display: none;">
                        <div class="mb-5">
                            <label class="form-label">
                                Kurtarma Kodu
                            </label>
                            <input id="recovery_code" class="form-control" type="text" name="recovery_code"
                                autocomplete="one-time-code">
                        </div>
                    </div>
                    <!--end col-->

                    <div class="my-2 col-lg-12 text-center">
                        <button class="btn btn-link" type="button" id="useRecoveryBtn">
                            Bir kurtarma kodu kullan
                        </button>
                    </div>

                    <div class="my-2 col-lg-12 text-center">
                        <button class="btn btn-link" type="button" id="useNormalBtn" style="display: none;">
                            Bir kimlik doğrulama kodu kullan
                        </button>
                    </div>
                </div>
                <div class="row align-items-center text-center">
                    <div class="col-12">
                        <!-- Button -->
                        <button type="submit" class="btn w-100 btn-primary mt-3 mb-2">Doğrula ve giriş yap</button>
                    </div>
                </div> <!-- / .row -->
                <!--end row-->
            </form>

        </div>
    </div> <!-- / .row -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    let recovery = false;
    
    // DOM elements
    const normalIcon = document.getElementById('normalIcon');
    const recoveryIcon = document.getElementById('recoveryIcon');
    const normalDescription = document.getElementById('normalDescription');
    const recoveryDescription = document.getElementById('recoveryDescription');
    const securityNotice = document.getElementById('securityNotice');
    const normalNoticeIcon = document.getElementById('normalNoticeIcon');
    const recoveryNoticeIcon = document.getElementById('recoveryNoticeIcon');
    const noticeTitle = document.getElementById('noticeTitle');
    const normalNoticeTitle = document.getElementById('normalNoticeTitle');
    const recoveryNoticeTitle = document.getElementById('recoveryNoticeTitle');
    const normalNoticeText = document.getElementById('normalNoticeText');
    const recoveryNoticeText = document.getElementById('recoveryNoticeText');
    const normalCodeSection = document.getElementById('normalCodeSection');
    const recoveryCodeSection = document.getElementById('recoveryCodeSection');
    const useRecoveryBtn = document.getElementById('useRecoveryBtn');
    const useNormalBtn = document.getElementById('useNormalBtn');
    const codeInput = document.getElementById('codeInput');
    const recoveryCodeInput = document.getElementById('recovery_code');

    function updateUI() {
        if (recovery) {
            // Show recovery mode
            normalIcon.style.display = 'none';
            recoveryIcon.style.display = 'block';
            normalDescription.style.display = 'none';
            recoveryDescription.style.display = 'block';
            
            // Update notice styling and content
            securityNotice.className = 'mb-6 p-4 rounded-xl border transition-all duration-300 bg-amber-500/10 border-amber-500/20';
            normalNoticeIcon.style.display = 'none';
            recoveryNoticeIcon.style.display = 'block';
            noticeTitle.className = 'font-bold mb-1 text-amber-300';
            normalNoticeTitle.style.display = 'none';
            recoveryNoticeTitle.style.display = 'block';
            normalNoticeText.style.display = 'none';
            recoveryNoticeText.style.display = 'block';
            
            // Show/hide form sections
            normalCodeSection.style.display = 'none';
            recoveryCodeSection.style.display = 'block';
            useRecoveryBtn.style.display = 'none';
            useNormalBtn.style.display = 'block';
            
            // Focus recovery code input
            setTimeout(() => {
                if (recoveryCodeInput) {
                    recoveryCodeInput.focus();
                }
            }, 100);
        } else {
            // Show normal mode
            normalIcon.style.display = 'block';
            recoveryIcon.style.display = 'none';
            normalDescription.style.display = 'block';
            recoveryDescription.style.display = 'none';
            
            // Update notice styling and content
            securityNotice.className = 'mb-6 p-4 rounded-xl border transition-all duration-300 bg-blue-500/10 border-blue-500/20';
            normalNoticeIcon.style.display = 'block';
            recoveryNoticeIcon.style.display = 'none';
            noticeTitle.className = 'font-bold mb-1 text-blue-300';
            normalNoticeTitle.style.display = 'block';
            recoveryNoticeTitle.style.display = 'none';
            normalNoticeText.style.display = 'block';
            recoveryNoticeText.style.display = 'none';
            
            // Show/hide form sections
            normalCodeSection.style.display = 'block';
            recoveryCodeSection.style.display = 'none';
            useRecoveryBtn.style.display = 'block';
            useNormalBtn.style.display = 'none';
            
            // Focus normal code input
            setTimeout(() => {
                if (codeInput) {
                    codeInput.focus();
                }
            }, 100);
        }
        
        // Re-initialize Lucide icons if available
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    // Event listeners
    if (useRecoveryBtn) {
        useRecoveryBtn.addEventListener('click', function() {
            recovery = true;
            updateUI();
        });
    }

    if (useNormalBtn) {
        useNormalBtn.addEventListener('click', function() {
            recovery = false;
            updateUI();
        });
    }

    // Initialize UI
    updateUI();
    
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>

@endsection
{{-- <div x-data="{ recovery: false }">
    <section class=" auth">
        <div class="container">
            <div class="pb-3 row justify-content-center">

                <div class="col-12 col-md-6 col-lg-6 col-sm-10 col-xl-6">
                    <a href="/"><img src="{{ asset('storage/' . $settings->logo) }}" alt=""
                            class="mb-3 img-fluid auth__logo"></a>

                    <div class="bg-white shadow card login-page roundedd border-1 ">
                        <div class="card-body">
                            <div class="mb-4 text-center">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="mb-4 text-sm text-center text-dark" x-show="! recovery">
                                    {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                                </div>

                                <div class="mb-4 text-sm text-center text-dark" x-show="recovery">
                                    {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                                </div>
                            </div>

                        </div>
                    </div>
                    <!---->
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>
    <!--end section-->
</div> --}}
