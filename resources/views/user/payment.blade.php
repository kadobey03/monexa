
@extends('layouts.dasht')
@section('title', $title)
@section('content')

<!-- Notification Alerts -->

<!-- Main Payment Container -->
<div class="min-h-screen bg-gray-900" x-data="paymentHandler()">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
<div class="space-y-4 mb-6">

    <x-danger-alert />
    <x-success-alert />
</div>

        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-3 px-4 py-2 bg-blue-500/10 rounded-full border border-blue-500/20 mb-6">
                <i data-lucide="shield-check" class="w-5 h-5 text-blue-400"></i>
                <span class="text-sm font-medium text-blue-300">Secure Payment Gateway</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                Complete Your Deposit
            </h1>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">i
                Securely deposit funds using <span class="text-blue-400 font-semibold">{{ $payment_mode->name }}</span>
                to start trading immediately
            </p>
        </div>

        <!-- Progress Steps -->
        <div class="flex items-center justify-center mb-8 sm:mb-12 overflow-x-auto pb-4">
            <div class="flex items-center space-x-2 sm:space-x-4 lg:space-x-8 min-w-max">
                <div class="flex items-center">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-500 rounded-full flex items-center justify-center">
                        <i data-lucide="check" class="w-4 h-4 sm:w-5 sm:h-5 text-white"></i>
                    </div>
                    <span class="ml-2 sm:ml-3 text-xs sm:text-sm font-medium text-blue-400 hidden sm:inline">Payment Method</span>
                    <span class="ml-2 text-xs font-medium text-blue-400 sm:hidden">Method</span>
                </div>
                <div class="w-4 sm:w-8 h-0.5 bg-blue-500"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-500/20 border-2 border-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-xs sm:text-sm font-bold text-blue-400">2</span>
                    </div>
                    <span class="ml-2 sm:ml-3 text-xs sm:text-sm font-medium text-white hidden sm:inline">Send Payment</span>
                    <span class="ml-2 text-xs font-medium text-white sm:hidden">Payment</span>
                </div>
                <div class="w-4 sm:w-8 h-0.5 bg-gray-600"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-700 rounded-full flex items-center justify-center">
                        <span class="text-xs sm:text-sm font-bold text-gray-400">3</span>
                    </div>
                    <span class="ml-2 sm:ml-3 text-xs sm:text-sm font-medium text-gray-400 hidden sm:inline">Confirmation</span>
                    <span class="ml-2 text-xs font-medium text-gray-400 sm:hidden">Confirm</span>
                </div>
            </div>
        </div>

        <form method="POST" enctype="multipart/form-data" action="{{ route('savedeposit') }}" class="space-y-8">
            @csrf

            <!-- Main Payment Card -->
            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">

                <!-- Card Header -->
                <div class="bg-gradient-to-r from-blue-600/10 to-purple-600/10 border-b border-gray-800 p-4 sm:p-6">
                    <div class="flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0 gap-4">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                                <i data-lucide="credit-card" class="w-5 h-5 sm:w-6 sm:h-6 text-blue-400"></i>
                            </div>
                            <div>
                                <h2 class="text-lg sm:text-xl font-bold text-white">Payment Details</h2>
                                <p class="text-sm sm:text-base text-gray-400">{{ $payment_mode->name }} Deposit</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                <i data-lucide="shield" class="w-3 h-3 mr-1"></i>
                                SSL Secured
                            </span>
                            <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                                24/7 Support
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-4 sm:p-6 space-y-6 sm:space-y-8">

                    <!-- Amount Display -->
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-2xl blur-xl"></div>
                        <div class="relative bg-gray-800/50 backdrop-blur-sm rounded-2xl p-4 sm:p-8 border border-gray-700">
                            <div class="text-center">
                                <div class="inline-flex items-center gap-2 text-xs sm:text-sm text-gray-400 mb-2">
                                    <i data-lucide="banknote" class="w-3 h-3 sm:w-4 sm:h-4"></i>
                                    <span>Amount to Deposit</span>
                                </div>
                                <div class="text-2xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 break-all">
                                    {{ $amount }}<span class="text-lg sm:text-2xl text-gray-400">{{ Auth::user()->currency }}</span>
                                </div>
                                <div class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 bg-amber-500/20 rounded-full border border-amber-500/30">
                                    <i data-lucide="alert-triangle" class="w-3 h-3 sm:w-4 sm:h-4 text-amber-400"></i>
                                    <span class="text-xs sm:text-sm text-amber-300">Send exact amount to avoid delays</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    <div class="bg-gray-800/30 rounded-2xl p-4 sm:p-6 border border-gray-700">
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                <i data-lucide="info" class="w-4 h-4 sm:w-5 sm:h-5 text-blue-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base sm:text-lg font-semibold text-white mb-3">How to Complete Your Payment</h3>
                                <div class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <div class="flex items-start gap-3">
                                        <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">1</div>
                                        <div class="min-w-0">
                                            <h4 class="font-medium text-white text-sm sm:text-base">Send Payment</h4>
                                            @if($payment_mode->methodtype == 'crypto')
                                                <p class="text-xs sm:text-sm text-gray-400 break-words">Transfer {{ $amount }}{{ Auth::user()->currency }} to the wallet address</p>
                                            @else
                                                <p class="text-xs sm:text-sm text-gray-400 break-words">Transfer {{ $amount }}{{ Auth::user()->currency }} to the bank account details</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">2</div>
                                        <div class="min-w-0">
                                            <h4 class="font-medium text-white text-sm sm:text-base">Upload Proof</h4>
                                            <p class="text-xs sm:text-sm text-gray-400">Take a screenshot of your transaction</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">3</div>
                                        <div class="min-w-0">
                                            <h4 class="font-medium text-white text-sm sm:text-base">Submit & Wait</h4>
                                            <p class="text-xs sm:text-sm text-gray-400">Submit proof and wait for confirmation</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details Grid -->
                    <div class="space-y-6 lg:space-y-0 lg:grid lg:grid-cols-2 lg:gap-8">

                        @if($payment_mode->methodtype == 'crypto')
                        <!-- QR Code Section (Crypto only) -->
                        <div class="space-y-4 sm:space-y-6">
                            <h3 class="text-base sm:text-lg font-semibold text-white flex items-center gap-2">
                                <i data-lucide="qr-code" class="w-4 h-4 sm:w-5 sm:h-5 text-blue-400"></i>
                                QR Code Payment
                            </h3>

                            <div class="relative group">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-2xl blur-lg"></div>
                                <div class="relative bg-white p-4 sm:p-6 rounded-2xl">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ $payment_mode->wallet_address }}"
                                         alt="Payment QR Code"
                                         class="w-full h-auto max-w-[200px] sm:max-w-[250px] mx-auto rounded-lg">
                                    <button type="button"
                                            @click="downloadQR()"
                                            class="absolute top-2 right-2 p-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200">
                                        <i data-lucide="download" class="w-3 h-3 sm:w-4 sm:h-4 text-gray-600"></i>
                                    </button>
                                </div>
                            </div>

                            <p class="text-xs sm:text-sm text-gray-400 text-center">
                                Scan with your wallet app to send payment instantly
                            </p>
                        </div>
                        @else
                        <!-- Bank Details Section (Currency only) -->
                        <div class="space-y-4 sm:space-y-6">
                            <h3 class="text-base sm:text-lg font-semibold text-white flex items-center gap-2">
                                <i data-lucide="building-2" class="w-4 h-4 sm:w-5 sm:h-5 text-blue-400"></i>
                                Bank Transfer Details
                            </h3>

                            <div class="relative group">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-2xl blur-lg"></div>
                                <div class="relative bg-gray-800/50 backdrop-blur-sm rounded-2xl p-4 sm:p-6 border border-gray-700 space-y-4">

                                    <!-- Bank Name -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-gray-400">Bank Name</label>
                                        <div class="flex items-center gap-2">
                                            <input type="text" value="{{ $payment_mode->bankname }}" readonly
                                                   class="flex-1 bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white text-sm">
                                            <button type="button" @click="copyToClipboard('{{ $payment_mode->bankname }}')"
                                                    class="p-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white transition-colors">
                                                <i data-lucide="copy" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Account Name -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-gray-400">Account Name</label>
                                        <div class="flex items-center gap-2">
                                            <input type="text" value="{{ $payment_mode->account_name }}" readonly
                                                   class="flex-1 bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white text-sm">
                                            <button type="button" @click="copyToClipboard('{{ $payment_mode->account_name }}')"
                                                    class="p-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white transition-colors">
                                                <i data-lucide="copy" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Account Number -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-gray-400">Account Number</label>
                                        <div class="flex items-center gap-2">
                                            <input type="text" value="{{ $payment_mode->account_number }}" readonly
                                                   class="flex-1 bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white text-sm">
                                            <button type="button" @click="copyToClipboard('{{ $payment_mode->account_number }}')"
                                                    class="p-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white transition-colors">
                                                <i data-lucide="copy" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </div>

                                    @if($payment_mode->swift_code)
                                    <!-- Swift Code -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-gray-400">Swift Code</label>
                                        <div class="flex items-center gap-2">
                                            <input type="text" value="{{ $payment_mode->swift_code }}" readonly
                                                   class="flex-1 bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white text-sm">
                                            <button type="button" @click="copyToClipboard('{{ $payment_mode->swift_code }}')"
                                                    class="p-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white transition-colors">
                                                <i data-lucide="copy" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <p class="text-xs sm:text-sm text-gray-400 text-center">
                                Transfer funds using your bank's online banking or mobile app
                            </p>
                        </div>
                        @endif

                        <!-- Wallet Address & Upload Section or Upload Section -->
                        <div class="space-y-4 sm:space-y-6">

                            @if($payment_mode->methodtype == 'crypto')
                            <!-- Wallet Address (Crypto only) -->
                            <div class="space-y-3">
                                <label class="text-base sm:text-lg font-semibold text-white flex items-center gap-2">
                                    <i data-lucide="wallet" class="w-4 h-4 sm:w-5 sm:h-5 text-blue-400"></i>
                                    Wallet Address
                                </label>
                                <div class="relative group">
                                    <div class="flex flex-col sm:flex-row">
                                        <input type="text"
                                               value="{{ $payment_mode->wallet_address }}"
                                               class="w-full sm:flex-1 bg-gray-800 border border-gray-700 rounded-xl sm:rounded-l-xl sm:rounded-r-none px-3 sm:px-4 py-3 text-white text-xs sm:text-sm focus:outline-none focus:border-blue-500 transition-colors duration-200 break-all"
                                               readonly>
                                        <button type="button"
                                                @click="copyToClipboard('{{ $payment_mode->wallet_address }}')"
                                                class="mt-2 sm:mt-0 px-4 py-3 bg-blue-600 hover:bg-blue-700 border border-blue-600 rounded-xl sm:rounded-l-none sm:rounded-r-xl text-white transition-all duration-200 flex items-center justify-center gap-2">
                                            <i data-lucide="copy" class="w-3 h-3 sm:w-4 sm:h-4"></i>
                                            <span x-text="copied ? 'Copied!' : 'Copy'" class="text-xs sm:text-sm font-medium"></span>
                                        </button>
                                    </div>
                                </div>

                                @if($payment_mode->network)
                                <div class="mt-2 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                        <i data-lucide="network" class="w-3 h-3 mr-1"></i>
                                        Network: {{ $payment_mode->network }}
                                    </span>
                                </div>
                                @endif
                            </div>
                            @endif

                            <!-- File Upload -->
                            <div class="space-y-3">
                                <label class="text-base sm:text-lg font-semibold text-white flex items-center gap-2">
                                    <i data-lucide="upload" class="w-4 h-4 sm:w-5 sm:h-5 text-blue-400"></i>
                                    Upload Payment Proof
                                </label>

                                <div class="relative">
                                    <input type="file"
                                           id="proof"
                                           name="proof"
                                           accept="image/*"
                                           required
                                           class="hidden"
                                           @change="handleFileUpload($event)">

                                    <label for="proof"
                                           class="relative block w-full border-2 border-dashed border-gray-600 hover:border-blue-500 rounded-2xl p-4 sm:p-8 text-center cursor-pointer transition-all duration-200 group"
                                           :class="{ 'border-blue-500 bg-blue-500/5': isDragOver }"
                                           @dragover.prevent="isDragOver = true"
                                           @dragleave.prevent="isDragOver = false"
                                           @drop.prevent="handleFileDrop($event)">

                                        <div class="space-y-3 sm:space-y-4">
                                            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto group-hover:bg-blue-500/30 transition-colors duration-200">
                                                <i data-lucide="upload-cloud" class="w-6 h-6 sm:w-8 sm:h-8 text-blue-400"></i>
                                            </div>

                                            <div x-show="!fileName">
                                                <p class="text-sm sm:text-lg font-medium text-white">Choose file or drag & drop</p>
                                                <p class="text-xs sm:text-sm text-gray-400">PNG, JPG, GIF up to 10MB</p>
                                            </div>

                                            <div x-show="fileName" class="text-center">
                                                <p class="text-sm sm:text-lg font-medium text-white break-all" x-text="fileName"></p>
                                                <p class="text-xs sm:text-sm text-gray-400" x-text="fileSize"></p>
                                                <button type="button"
                                                        @click.stop="removeFile()"
                                                        class="mt-2 text-red-400 hover:text-red-300 text-xs sm:text-sm">
                                                    Remove file
                                                </button>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="amount" value="{{ $amount }}">
                    <input type="hidden" name="method" value="{{ $payment_mode->name }}">
                    <input type="hidden" name="paymethd_method" value="{{ $payment_mode->name }}">
                    @if($asset)
                    <input type="hidden" name="asset" value="{{ $asset }}">
                    @endif

                    <!-- Submit Button -->
                    <div class="pt-4 sm:pt-6">
                        <button type="submit"
                                :disabled="!fileName"
                                class="w-full relative group overflow-hidden"
                                :class="!fileName ? 'opacity-50 cursor-not-allowed' : 'hover:scale-[1.02] active:scale-[0.98]'">
                            <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl blur-lg opacity-50 group-hover:opacity-75 transition-opacity duration-200"></div>
                            <div class="relative bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-2xl flex items-center justify-center gap-2 sm:gap-3 transition-all duration-200">
                                <i data-lucide="send" class="w-4 h-4 sm:w-5 sm:h-5"></i>
                                <span class="text-sm sm:text-lg font-semibold">Submit Payment Proof</span>
                            </div>
                        </button>

                        <!-- Security Notice -->
                        <div class="mt-4 sm:mt-6 flex items-center justify-center gap-2 sm:gap-3 text-xs sm:text-sm text-gray-400">
                            <i data-lucide="shield-check" class="w-4 h-4 sm:w-5 sm:h-5 text-green-400"></i>
                            <span>Protected by 256-bit SSL encryption</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Help Section -->
        <div class="mt-8 sm:mt-12 grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
            <div class="bg-gray-900 rounded-xl p-4 sm:p-6 border border-gray-800 text-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <i data-lucide="headphones" class="w-5 h-5 sm:w-6 sm:h-6 text-blue-400"></i>
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-white mb-2">24/7 Support</h3>
                <p class="text-gray-400 text-xs sm:text-sm">Need help? Our support team is available around the clock</p>
            </div>

            <div class="bg-gray-900 rounded-xl p-4 sm:p-6 border border-gray-800 text-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <i data-lucide="zap" class="w-5 h-5 sm:w-6 sm:h-6 text-green-400"></i>
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-white mb-2">Instant Processing</h3>
                <p class="text-gray-400 text-xs sm:text-sm">Deposits are processed within minutes of confirmation</p>
            </div>

            <div class="bg-gray-900 rounded-xl p-4 sm:p-6 border border-gray-800 text-center md:col-span-1">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <i data-lucide="shield" class="w-5 h-5 sm:w-6 sm:h-6 text-purple-400"></i>
                </div>
                <h3 class="text-base sm:text-lg font-semibold text-white mb-2">Bank-Grade Security</h3>
                <p class="text-gray-400 text-xs sm:text-sm">Your funds and data are protected with enterprise security</p>
            </div>
        </div>
    </div>
</div>

<script>
    function paymentHandler() {
        return {
            copied: false,
            fileName: '',
            fileSize: '',
            isDragOver: false,

            copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(() => {
                    this.copied = true;
                    setTimeout(() => {
                        this.copied = false;
                    }, 2000);
                });
            },

            handleFileUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    this.fileName = file.name;
                    this.fileSize = `${(file.size / 1024 / 1024).toFixed(2)}MB`;
                }
            },

            handleFileDrop(event) {
                this.isDragOver = false;
                const file = event.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    document.getElementById('proof').files = event.dataTransfer.files;
                    this.fileName = file.name;
                    this.fileSize = `${(file.size / 1024 / 1024).toFixed(2)}MB`;
                }
            },

            removeFile() {
                document.getElementById('proof').value = '';
                this.fileName = '';
                this.fileSize = '';
            },

            downloadQR() {
                const img = document.querySelector('img[alt="Payment QR Code"]');
                const link = document.createElement('a');
                link.href = img.src;
                link.download = 'payment-qr-code.png';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }
    }

    // Initialize Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>

@endsection


