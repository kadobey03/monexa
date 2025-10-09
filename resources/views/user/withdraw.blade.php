
@extends('layouts.dasht')
@section('title', $title)
@section('content')

<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8" x-data="{ showConfirmModal: false, amount: '' }">
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
                    <div class="p-3 rounded-full" :class="{'bg-blue-100 dark:bg-blue-900/30': '{{ $payment_mode }}' == 'Bitcoin' || '{{ $payment_mode }}' == 'Ethereum', 'bg-green-100 dark:bg-green-900/30': '{{ $payment_mode }}' == 'Bank Transfer', 'bg-purple-100 dark:bg-purple-900/30': '{{ $payment_mode }}' == 'USDT'}">
                        <i data-lucide="{{ $payment_mode == 'Bitcoin' ? 'bitcoin' : ($payment_mode == 'Ethereum' ? 'zap' : ($payment_mode == 'USDT' ? 'circle-dollar-sign' : 'building-bank')) }}" class="w-6 h-6" :class="{'text-blue-600 dark:text-blue-400': '{{ $payment_mode }}' == 'Bitcoin' || '{{ $payment_mode }}' == 'Ethereum', 'text-green-600 dark:text-green-400': '{{ $payment_mode }}' == 'Bank Transfer', 'text-purple-600 dark:text-purple-400': '{{ $payment_mode }}' == 'USDT'}"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white dark:text-white">{{ $payment_mode }} Çekimi</h2>
                        <p class="text-sm text-gray-300 dark:text-gray-400">Çekim talebinizi tamamlayın</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('completewithdrawal') }}" class="p-6" x-on:submit="showConfirmModal = true; return false;" id="withdrawalForm">
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
                               x-model="amount"
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
    <div x-show="showConfirmModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="showConfirmModal = false"></div>

            <div x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="bg-gray-900 dark:bg-gray-900 rounded-2xl shadow-xl transform transition-all max-w-md w-full p-6 z-10">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-500/20 dark:bg-blue-900/30 mb-4">
                        <i data-lucide="alert-circle" class="h-8 w-8 text-blue-400 dark:text-blue-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white dark:text-white mb-2">Çekimi Onayla</h3>
                    <p class="mb-6 text-gray-300 dark:text-gray-400">
                        {{ Auth::user()->currency }}<span x-text="amount"></span> tutarı {{ $payment_mode }} hesabınıza çekmek istediğinizden emin misiniz?
                    </p>
                    <div class="flex justify-center gap-4">
                        <button @click="showConfirmModal = false"
                                class="px-4 py-2 bg-gray-700 dark:bg-gray-700 text-gray-300 dark:text-gray-300 rounded-lg hover:bg-gray-600 dark:hover:bg-gray-600 focus:outline-none transition-colors">
                            İptal
                        </button>
                        <button @click="document.getElementById('withdrawalForm').submit()"
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
        });
    </script>
@endsection
