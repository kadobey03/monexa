
@extends('layouts.dasht')
@section('title', $title)
@section('content')

<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="container mx-auto px-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Fon Çek</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Fonlarınızı hızlı ve güvenli bir şekilde çekin</p>
            </div>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                Gösterge Paneline Dön
            </a>
        </div>

        <!-- Alert Messages -->
        <x-danger-alert />
        <x-success-alert />

        <!-- Breadcrumbs -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                        <i data-lucide="home" class="w-4 h-4 mr-2"></i>
                        Ana Sayfa
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 text-gray-400 mx-1"></i>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Çekim</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Withdrawal Form Card -->
        <div class="bg-gray-900 dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-700 dark:border-gray-700 max-w-3xl mx-auto">
            <div class="p-6 border-b border-gray-700 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-full
                        @if($payment_mode == 'Bitcoin' || $payment_mode == 'Ethereum') bg-blue-100 dark:bg-blue-900/30
                        @elseif($payment_mode == 'Bank Transfer') bg-green-100 dark:bg-green-900/30
                        @elseif($payment_mode == 'USDT') bg-purple-100 dark:bg-purple-900/30
                        @endif">
                        <i data-lucide="{{ $payment_mode == 'Bitcoin' ? 'bitcoin' : ($payment_mode == 'Ethereum' ? 'zap' : ($payment_mode == 'USDT' ? 'circle-dollar-sign' : 'building-bank')) }}"
                           class="w-6 h-6
                           @if($payment_mode == 'Bitcoin' || $payment_mode == 'Ethereum') text-blue-600 dark:text-blue-400
                           @elseif($payment_mode == 'Bank Transfer') text-green-600 dark:text-green-400
                           @elseif($payment_mode == 'USDT') text-purple-600 dark:text-purple-400
                           @endif"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white dark:text-white">{{ $payment_mode }} Çekimi</h2>
                        <p class="text-sm text-gray-300 dark:text-gray-400">Çekim talebinizi tamamlayın</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('completewithdrawal') }}" class="p-6" id="withdrawalForm">
                @csrf
                <input type="hidden" name="method" value="{{ $payment_mode }}">

                <!-- Amount Field -->
                <div class="mb-6">
                    <label for="amount" class="block text-sm font-medium text-gray-300 dark:text-gray-300 mb-2">
                        Çekilecek tutar ({{ Auth::user()->currency }})
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">{{ $settings->currency }}</span>
                        </div>
                        <input type="number"
                               name="amount"
                               id="amount"
                               required
                               min="1"
                               placeholder="Çekilecek tutarı girin"
                               class="pl-10 block w-full rounded-xl border-gray-600 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-800 dark:bg-gray-700 text-white dark:text-white sm:text-sm py-3"
                        />
                    </div>
                    <p class="mt-2 text-xs text-gray-400 dark:text-gray-400">
                        Kullanılabilir bakiye: {{ Auth::user()->currency }}{{ number_format(Auth::user()->account_bal, 2, '.', ',') }}
                    </p>
                </div>
                <!-- Payment Method Specific Fields -->
                @if($payment_mode=="Bank Transfer")
                    <div class="bg-gray-800 dark:bg-gray-700/50 p-4 rounded-xl mb-6">
                        <h3 class="text-lg font-semibold text-white dark:text-white mb-4">Bank Detayları</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-300 dark:text-gray-300 mb-2">
                                    Bank Adı
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="building-bank" class="h-5 w-5 text-gray-400"></i>
                                    </div>
                                    <input type="text"
                                           name="bank_name"
                                           id="bank_name"
                                           placeholder="Bank adını girin"
                                           class="pl-10 block w-full rounded-xl border-gray-600 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-700 dark:bg-gray-700 text-white dark:text-white sm:text-sm py-3"
                                    />
                                </div>
                            </div>

                            <div>
                                <label for="account_name" class="block text-sm font-medium text-gray-300 dark:text-gray-300 mb-2">
                                    Hesap Adı
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="user" class="h-5 w-5 text-gray-400"></i>
                                    </div>
                                    <input type="text"
                                           name="account_name"
                                           id="account_name"
                                           placeholder="Hesap adını girin"
                                           class="pl-10 block w-full rounded-xl border-gray-600 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-700 dark:bg-gray-700 text-white dark:text-white sm:text-sm py-3"
                                    />
                                </div>
                            </div>

                            <div>
                                <label for="account_no" class="block text-sm font-medium text-gray-300 dark:text-gray-300 mb-2">
                                    Hesap Numarası
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="hash" class="h-5 w-5 text-gray-400"></i>
                                    </div>
                                    <input type="text"
                                           name="account_no"
                                           id="account_no"
                                           placeholder="Hesap numarasını girin"
                                           class="pl-10 block w-full rounded-xl border-gray-600 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-700 dark:bg-gray-700 text-white dark:text-white sm:text-sm py-3"
                                    />
                                </div>
                            </div>

                            <div>
                                <label for="swiftcode" class="block text-sm font-medium text-gray-300 dark:text-gray-300 mb-2">
                                    Swift Kodu
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="code" class="h-5 w-5 text-gray-400"></i>
                                    </div>
                                    <input type="text"
                                           name="swiftcode"
                                           id="swiftcode"
                                           placeholder="Swift kodunu girin"
                                           class="pl-10 block w-full rounded-xl border-gray-600 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-700 dark:bg-gray-700 text-white dark:text-white sm:text-sm py-3"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mb-6">
                        <label for="details" class="block text-sm font-medium text-gray-300 dark:text-gray-300 mb-2">
                            {{ $payment_mode }} Wallet Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="wallet" class="h-5 w-5 text-gray-400"></i>
                            </div>
                            <input type="text"
                                   name="details"
                                   id="details"
                                   required
                                   placeholder="{{ $payment_mode }} cüzdan adresini girin"
                                   class="pl-10 block w-full rounded-xl border-gray-600 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-700 dark:bg-gray-700 text-white dark:text-white sm:text-sm py-3"
                            />
                        </div>
                        <p class="mt-2 text-xs text-gray-400 dark:text-gray-400">
                            Fon kaybından kaçınmak için lütfen doğru cüzdan adresini girdiğinizden emin olun
                        </p>
                    </div>
                @endif

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit" class="w-full inline-flex justify-center items-center gap-2 py-3 px-5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors duration-200 shadow-lg hover:shadow-xl">
                        <i data-lucide="arrow-right-circle" class="h-5 w-5"></i>
                        <span>Çekimi Tamamla</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Withdrawal Information Card -->
        <div class="bg-gray-900 dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-700 dark:border-gray-700 max-w-3xl mx-auto mt-8 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-blue-500/20 dark:bg-blue-900/30 rounded-lg">
                    <i data-lucide="info" class="w-5 h-5 text-blue-400 dark:text-blue-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-white dark:text-white">Çekim Bilgileri</h3>
            </div>

            <div class="pl-10 space-y-3">
                <div class="flex items-start">
                    <i data-lucide="check-circle" class="w-4 h-4 text-green-400 dark:text-green-400 mr-2 mt-0.5"></i>
                    <p class="text-sm text-gray-300 dark:text-gray-300">Çekimler genellikle 24 saat içinde işlenir</p>
                </div>
                <div class="flex items-start">
                    <i data-lucide="check-circle" class="w-4 h-4 text-green-400 dark:text-green-400 mr-2 mt-0.5"></i>
                    <p class="text-sm text-gray-300 dark:text-gray-300">Minimum çekim tutarı: {{ Auth::user()->currency }}50</p>
                </div>
                <div class="flex items-start">
                    <i data-lucide="check-circle" class="w-4 h-4 text-green-400 dark:text-green-400 mr-2 mt-0.5"></i>
                    <p class="text-sm text-gray-300 dark:text-gray-300">Tüm çekimlere {{ Auth::user()->currency }}5 ücret uygulanır</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 z-50 overflow-y-auto hidden opacity-0 transition-all duration-300">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" id="modalBackdrop"></div>

            <div id="modalContent" class="bg-gray-900 dark:bg-gray-900 rounded-2xl shadow-xl transform transition-all max-w-md w-full p-6 z-10 scale-95 opacity-0">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-500/20 dark:bg-blue-900/30 mb-4">
                        <i data-lucide="alert-circle" class="h-8 w-8 text-blue-400 dark:text-blue-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white dark:text-white mb-2">Çekimi Onayla</h3>
                    <p class="mb-6 text-gray-300 dark:text-gray-400">
                        {{ Auth::user()->currency }}<span id="confirmAmount"></span> tutarı {{ $payment_mode }} hesabınıza çekmek istediğinizden emin misiniz?
                    </p>
                    <div class="flex justify-center gap-4">
                        <button id="cancelButton"
                                class="px-4 py-2 bg-gray-700 dark:bg-gray-700 text-gray-300 dark:text-gray-300 rounded-lg hover:bg-gray-600 dark:hover:bg-gray-600 focus:outline-none transition-colors">
                            İptal
                        </button>
                        <button id="confirmButton"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none transition-colors">
                            Çekimi Onayla
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Lucide icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Withdrawal Manager
            class WithdrawalManager {
                constructor() {
                    this.amount = '';
                    this.showConfirmModal = false;
                    this.init();
                }

                init() {
                    this.bindEvents();
                    this.setupFormValidation();
                }

                bindEvents() {
                    const form = document.getElementById('withdrawalForm');
                    const amountInput = document.getElementById('amount');
                    const confirmModal = document.getElementById('confirmModal');
                    const modalBackdrop = document.getElementById('modalBackdrop');
                    const cancelButton = document.getElementById('cancelButton');
                    const confirmButton = document.getElementById('confirmButton');
                    const confirmAmount = document.getElementById('confirmAmount');

                    // Form submission
                    if (form) {
                        form.addEventListener('submit', (e) => {
                            e.preventDefault();
                            this.showConfirmation();
                        });
                    }

                    // Amount input
                    if (amountInput) {
                        amountInput.addEventListener('input', (e) => {
                            this.amount = e.target.value;
                        });
                    }

                    // Modal close events
                    if (modalBackdrop) {
                        modalBackdrop.addEventListener('click', () => this.hideConfirmation());
                    }

                    if (cancelButton) {
                        cancelButton.addEventListener('click', () => this.hideConfirmation());
                    }

                    // Confirm withdrawal
                    if (confirmButton) {
                        confirmButton.addEventListener('click', () => {
                            this.confirmWithdrawal();
                        });
                    }

                    // Escape key to close modal
                    document.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape' && this.showConfirmModal) {
                            this.hideConfirmation();
                        }
                    });
                }

                showConfirmation() {
                    if (!this.amount || parseFloat(this.amount) <= 0) {
                        this.showError('Lütfen geçerli bir tutar girin.');
                        return;
                    }

                    const userBalance = {{ Auth::user()->account_bal ?? 0 }};
                    if (parseFloat(this.amount) > userBalance) {
                        this.showError('Yetersiz bakiye.');
                        return;
                    }

                    const minWithdrawal = 50;
                    if (parseFloat(this.amount) < minWithdrawal) {
                        this.showError('Minimum çekim tutarı {{ Auth::user()->currency }}' + minWithdrawal + ' olmalıdır.');
                        return;
                    }

                    this.showConfirmModal = true;
                    const modal = document.getElementById('confirmModal');
                    const modalContent = document.getElementById('modalContent');
                    const confirmAmount = document.getElementById('confirmAmount');

                    if (confirmAmount) {
                        confirmAmount.textContent = this.formatNumber(this.amount);
                    }

                    if (modal && modalContent) {
                        modal.classList.remove('hidden');
                        
                        // Animate in
                        setTimeout(() => {
                            modal.classList.remove('opacity-0');
                            modal.classList.add('opacity-100');
                            modalContent.classList.remove('scale-95', 'opacity-0');
                            modalContent.classList.add('scale-100', 'opacity-100');
                        }, 10);
                    }

                    // Prevent body scroll
                    document.body.style.overflow = 'hidden';
                }

                hideConfirmation() {
                    this.showConfirmModal = false;
                    const modal = document.getElementById('confirmModal');
                    const modalContent = document.getElementById('modalContent');

                    if (modal && modalContent) {
                        // Animate out
                        modal.classList.remove('opacity-100');
                        modal.classList.add('opacity-0');
                        modalContent.classList.remove('scale-100', 'opacity-100');
                        modalContent.classList.add('scale-95', 'opacity-0');

                        setTimeout(() => {
                            modal.classList.add('hidden');
                        }, 300);
                    }

                    // Restore body scroll
                    document.body.style.overflow = '';
                }

                confirmWithdrawal() {
                    const form = document.getElementById('withdrawalForm');
                    if (form) {
                        // Add loading state
                        const confirmButton = document.getElementById('confirmButton');
                        if (confirmButton) {
                            confirmButton.disabled = true;
                            confirmButton.innerHTML = '<i class="animate-spin w-4 h-4 mr-2" data-lucide="loader"></i>İşleniyor...';
                            lucide.createIcons();
                        }

                        // Submit the form
                        form.submit();
                    }
                }

                setupFormValidation() {
                    const amountInput = document.getElementById('amount');
                    if (amountInput) {
                        amountInput.addEventListener('blur', () => {
                            this.validateAmount();
                        });

                        amountInput.addEventListener('input', () => {
                            this.clearErrors();
                        });
                    }

                    // Bank transfer fields validation
                    const bankFields = ['bank_name', 'account_name', 'account_no', 'swiftcode'];
                    bankFields.forEach(fieldId => {
                        const field = document.getElementById(fieldId);
                        if (field) {
                            field.addEventListener('blur', () => {
                                this.validateField(field);
                            });
                        }
                    });

                    // Wallet address validation
                    const detailsField = document.getElementById('details');
                    if (detailsField) {
                        detailsField.addEventListener('blur', () => {
                            this.validateWalletAddress(detailsField);
                        });
                    }
                }

                validateAmount() {
                    const amountInput = document.getElementById('amount');
                    if (!amountInput) return true;

                    const amount = parseFloat(amountInput.value);
                    const userBalance = {{ Auth::user()->account_bal ?? 0 }};
                    const minWithdrawal = 50;

                    this.clearFieldError(amountInput);

                    if (isNaN(amount) || amount <= 0) {
                        this.showFieldError(amountInput, 'Geçerli bir tutar girin.');
                        return false;
                    }

                    if (amount < minWithdrawal) {
                        this.showFieldError(amountInput, 'Minimum çekim tutarı {{ Auth::user()->currency }}' + minWithdrawal + ' olmalıdır.');
                        return false;
                    }

                    if (amount > userBalance) {
                        this.showFieldError(amountInput, 'Yetersiz bakiye.');
                        return false;
                    }

                    return true;
                }

                validateField(field) {
                    this.clearFieldError(field);

                    if (!field.value.trim()) {
                        this.showFieldError(field, 'Bu alan gereklidir.');
                        return false;
                    }

                    return true;
                }

                validateWalletAddress(field) {
                    this.clearFieldError(field);

                    const address = field.value.trim();
                    if (!address) {
                        this.showFieldError(field, 'Cüzdan adresi gereklidir.');
                        return false;
                    }

                    // Basic wallet address validation (length check)
                    if (address.length < 20) {
                        this.showFieldError(field, 'Geçersiz cüzdan adresi formatı.');
                        return false;
                    }

                    return true;
                }

                showFieldError(field, message) {
                    const errorId = `${field.id}-error`;
                    let errorElement = document.getElementById(errorId);
                    
                    if (!errorElement) {
                        errorElement = document.createElement('p');
                        errorElement.id = errorId;
                        errorElement.className = 'mt-2 text-sm text-red-400';
                        field.parentNode.parentNode.appendChild(errorElement);
                    }
                    
                    errorElement.textContent = message;
                    field.classList.add('border-red-500');
                }

                clearFieldError(field) {
                    const errorId = `${field.id}-error`;
                    const errorElement = document.getElementById(errorId);
                    
                    if (errorElement) {
                        errorElement.remove();
                    }
                    
                    field.classList.remove('border-red-500');
                }

                clearErrors() {
                    const errorElements = document.querySelectorAll('[id$="-error"]');
                    errorElements.forEach(element => element.remove());
                    
                    const errorFields = document.querySelectorAll('.border-red-500');
                    errorFields.forEach(field => field.classList.remove('border-red-500'));
                }

                showError(message) {
                    // You can implement a toast notification here or use a simple alert
                    alert(message);
                }

                formatNumber(num) {
                    return parseFloat(num).toLocaleString('tr-TR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
            }

            // Initialize withdrawal manager
            window.withdrawalManager = new WithdrawalManager();
        });
    </script>
@endsection
