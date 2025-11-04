@extends('layouts.master', ['layoutType' => 'dashboard'])
@section('title', $title)
@section('content')
<div class="container mx-auto px-3 sm:px-4 lg:px-6 py-4 sm:py-6 lg:py-8" data-dashboard="true">

    <x-danger-alert />
    <x-success-alert />
    <x-notify-alert />

    <!-- Dashboard Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6 sm:mb-8 gap-4">
        <div class="text-center lg:text-left">
           @php
    $userCreatedAt = \Carbon\Carbon::parse(Auth::user()->created_at);
    $secondsSinceCreated = now()->diffInSeconds($userCreatedAt);
@endphp

@if ($secondsSinceCreated <= 90)
    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
        Merhaba, {{ Auth::user()->name }}!
    </h1>
@else
    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">
        Tekrar hoş geldin, {{ Auth::user()->name }}!
    </h1>
@endif

            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 mt-1">Yatırım kontrol paneli genel bakışınız</p>
        </div>
        <div class="hidden sm:flex flex-col sm:flex-row gap-2 sm:gap-3">
            @if($settings->wallet_status == "on")
                <a href="{{ route('connect_wallet') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:py-3 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-lg shadow hover:from-indigo-700 transition animate-pulse text-sm sm:text-base">
                    <x-heroicon name="link" class="w-4 h-4 sm:w-5 sm:h-5" /> Cüzdanı Bağla
                </a>
            @else
                <div class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:py-3 bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-lg text-sm sm:text-base">
                    <x-heroicon name="check-circle" class="w-4 h-4 sm:w-5 sm:h-5" /> Cüzdan Bağlandı
                </div>
            @endif
            <a href="{{ route('trade.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:py-3 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition text-sm sm:text-base">
                <x-heroicon name="arrow-trending-up" class="w-4 h-4 sm:w-5 sm:h-5" /> Şimdi Yatırım Yap
            </a>
        </div>
    </div>




    <!-- Signal Strength -->
    @if(Auth::user()->progress > 2)
    <div class="mb-6 sm:mb-8">
        @php
            $signalStrength = Auth::user()->progress;
            $signalColor = '';
            $signalText = '';
            $signalIcon = '';

            if ($signalStrength < 25) {
                $signalColor = 'from-red-500 to-red-600';
                $signalText = 'Zayıf Sinyal';
                $signalIcon = 'signal-low';
            } elseif ($signalStrength >= 25 && $signalStrength < 50) {
                $signalColor = 'from-yellow-500 to-orange-500';
                $signalText = 'Orta Sinyal';
                $signalIcon = 'signal-medium';
            } else {
                $signalColor = 'from-green-500 to-emerald-600';
                $signalText = 'Güçlü Sinyal';
                $signalIcon = 'signal-high';
            }
        @endphp

        <div class="bg-white dark:bg-gray-900 rounded-xl p-4 sm:p-6 shadow-sm ring-1 ring-gray-200 dark:ring-gray-800">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <x-heroicon name="{{ $signalIcon }}" class="w-5 h-5 text-gray-600 dark:text-gray-300" />
                    <h2 class="text-sm sm:text-base font-semibold text-gray-800 dark:text-gray-100">Ticaret Sinyal Gücü</h2>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">{{ $signalStrength }}%</span>
                    <span class="px-2 py-1 text-xs font-medium rounded-full
                        {{ $signalStrength < 25 ? 'bg-red-100 text-red-700 dark:bg-red-900/20 dark:text-red-400' :
                           ($signalStrength < 50 ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/20 dark:text-yellow-400' :
                            'bg-green-100 text-green-700 dark:bg-green-900/20 dark:text-green-400') }}">
                        {{ $signalText }}
                    </span>
                </div>
            </div>

            <div class="w-full h-3 sm:h-4 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden relative">
                <div class="bg-gradient-to-r {{ $signalColor }} h-full rounded-full transition-all duration-700 ease-out relative"
                     style="width: {{ $signalStrength }}%">
                    <div class="absolute inset-0 bg-white/20 animate-pulse rounded-full"></div>
                </div>
            </div>

            <div class="flex justify-between items-center mt-2 text-xs text-gray-500 dark:text-gray-400">
                <span>0% Zayıf</span>
                <span>25% Orta</span>
                <span>50%+ Güçlü</span>
            </div>

            <p class="text-xs text-gray-600 dark:text-gray-400 mt-3 text-center">
                @if($signalStrength < 25)
                    ⚠️ Sinyal gücü düşük. Daha iyi piyasa koşulları için beklemeyi düşünün.
                @elseif($signalStrength < 50)
                    ⚡ Orta sinyal tespit edildi. Dikkatli ilerleyin ve uygun risk yönetimine dikkat edin.
                @else
                    🚀 Güçlü sinyal gücü! Ticaret fırsatları için optimum koşullar.
                @endif
            </p>
        </div>
    </div>
    @endif



 <!-- Investment Dashboard - Clean Modern Layout -->
<div class="grid grid-cols-1 xl:grid-cols-5 gap-4 sm:gap-6 items-stretch mb-6 sm:mb-8">
    <!-- Account Balance -->
    <div class="xl:col-span-2 h-full rounded-2xl bg-white dark:bg-gray-900 p-4 sm:p-5 lg:p-6 shadow-sm ring-1 ring-gray-200 dark:ring-gray-800 transition-all group" id="balanceCard">
        <div class="flex justify-between items-start mb-4">
            <div class="text-center sm:text-left w-full sm:w-auto">
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-white flex items-center justify-center sm:justify-start">
                    <x-heroicon name="wallet" class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-gray-500 dark:text-gray-300" />
                    Hesap Bakiyesi
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">Kullanılabilir fonlarınız</p>
            </div>
            {{-- <button id="toggleBalanceVisibility" class="text-gray-400 hover:text-gray-700 dark:hover:text-white">
                <x-heroicon name="eye" class="h-5 w-5" id="visibilityIcon" />
            </button> --}}
        </div>

        <div class="flex flex-col">
            <div class="flex items-center justify-center sm:justify-start mb-3">
                <h3 id="balanceAmount" class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mr-2 break-all">
                    {{ Auth::user()->currency }}{{ number_format(Auth::user()->account_bal, 2, '.', ',') }}
                </h3>
                <h3 id="hiddenBalance" class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mr-2 hidden">••••••</h3>
            </div>




              @if(isset($bitcoin_price) && $bitcoin_price && $btc_equivalent > 0)
            <!-- Bitcoin Equivalent -->
            <div class="flex items-center justify-center sm:justify-start mb-2">
                <div class="inline-flex items-center px-3 py-1 text-sm rounded-lg bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-800">
                    <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.638 14.904c-1.602 6.43-8.113 10.34-14.542 8.736C2.67 22.05-1.244 15.525.362 9.105 1.962 2.67 8.475-1.243 14.9.358c6.43 1.605 10.342 8.115 8.738 14.546z"/>
                        <path fill="#fff" d="M17.455 11.252c.234-1.569-.963-2.413-2.601-2.977l.531-2.131-1.297-.323-.518 2.075c-.341-.085-.691-.165-1.039-.243l.522-2.092-1.297-.324-.531 2.13c-.283-.065-.56-.128-.829-.196l.002-.007-1.788-.446-.345 1.385s.963.22.943.234c.525.131.62.478.605.753l-.606 2.43c.036.009.083.022.135.042l-.137-.034-.849 3.4c-.064.159-.227.398-.594.307.013.019-.944-.235-.944-.235l-.643 1.485 1.688.421c.314.078.621.16.923.238l-.536 2.153 1.297.323.531-2.131c.355.096.699.185 1.035.269l-.53 2.121 1.297.323.536-2.15c2.211.419 3.873.25 4.573-1.75.564-1.61-.028-2.538-1.191-3.144.847-.195 1.485-.752 1.656-1.902zm-2.961 4.15c-.401 1.61-3.11.74-3.99.521l.713-2.854c.879.219 3.695.653 3.277 2.333zm.401-4.176c-.365 1.464-2.621.72-3.353.538l.645-2.587c.732.183 3.089.524 2.708 2.049z"/>
                    </svg>
                    <span class="font-medium">{{ number_format($btc_equivalent, 6, '.', ',') }} BTC</span>
                    <!--@if($bitcoin_price->price)-->
                    <!--    <span class="text-xs ml-1 opacity-75">(₿{{ number_format($bitcoin_price->price, 2, '.', ',') }})</span>-->
                    <!--@endif-->
                </div>
            </div>
            @endif

            <div class="inline-flex items-center px-2 py-1 text-xs rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 mb-4 w-fit mx-auto sm:mx-0">
                <x-heroicon name="check-circle" class="w-3 h-3 mr-1" /> Çekim için Kullanılabilir
            </div>

            @if(isset($settings->enable_kyc) && $settings->enable_kyc === 'yes')
                <!-- KYC Status Notification -->
                <div class="mb-3 w-fit mx-auto sm:mx-0">
                    @if(Auth::user()->account_verify === 'Verified')
                        <div class="inline-flex items-center px-2 py-1 text-xs rounded-full bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 animate-pulse">
                            <x-heroicon name="shield-check" class="w-3 h-3 mr-1" />
                            <span class="font-medium">Doğrulanmış Hesap</span>
                        </div>
                    @elseif(Auth::user()->account_verify === 'Under review')
                        <div class="inline-flex items-center px-2 py-1 text-xs rounded-full bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400 animate-pulse">
                            <x-heroicon name="clock" class="w-3 h-3 mr-1" />
                            <span class="font-medium">İncelemede</span>
                        </div>
                    @else
                        <div class="inline-flex items-center px-2 py-1 text-xs rounded-full bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 animate-pulse">
                            <x-heroicon name="exclamation-circle" class="w-3 h-3 mr-1" />
                            <span class="font-medium">Doğrulanmamış</span>
                        </div>
                    @endif
                </div>
            @endif

            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 text-center sm:text-left">Son güncelleme: {{ now()->format('M d, Y h:i A') }}</p>

            <div class="mt-auto flex flex-col sm:flex-row gap-2">
                <a href="{{ route('deposits') }}" class="flex items-center justify-center w-full gap-1 text-xs sm:text-sm font-medium px-3 sm:px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-900 dark:text-white transition">
                    <x-heroicon name="plus-circle" class="w-4 h-4" /> Yatırım
                </a>
                <a href="{{ route('withdrawalsdeposits') }}" class="flex items-center justify-center w-full gap-1 text-xs sm:text-sm font-medium px-3 sm:px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-900 dark:text-white transition">
                    <x-heroicon name="arrow-up-right" class="w-4 h-4" /> Çekim
                </a>
            </div>
        </div>
    </div>

    <!-- Secondary Metrics -->
    <div class="xl:col-span-3 grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-2 gap-3 sm:gap-4">
        @php
            $cards = [
                ['label' => 'Toplam Kar', 'value' => Auth::user()->roi, 'icon' => 'dollar-sign'],
                ['label' => 'Toplam Yatırım', 'value' => $deposited, 'icon' => 'arrow-down'],
                ['label' => 'Toplam Çekim', 'value' => $total_withdrawal, 'icon' => 'arrow-up'],
                ['label' => 'Ödül', 'value' => Auth::user()->bonus ?? 0, 'icon' => 'gift'],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="rounded-2xl bg-white dark:bg-gray-900 p-3 sm:p-4 shadow-sm ring-1 ring-gray-200 dark:ring-gray-800 flex flex-col">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ $card['label'] }}</span>
                    <div class="w-6 h-6 sm:w-8 sm:h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                        <x-heroicon name="{{ $card['icon'] }}" class="w-3 h-3 sm:w-4 sm:h-4 text-gray-500 dark:text-gray-300" />
                    </div>
                </div>

                <h3 class="text-sm sm:text-lg font-semibold text-gray-900 dark:text-white mb-1 truncate">
                    {{ Auth::user()->currency }}{{ number_format($card['value'], 2, '.', ',') }}
                </h3>

                <div class="text-xs text-gray-500 dark:text-gray-400 mt-auto flex items-center gap-1">
                    <x-heroicon name="calendar-days" class="w-3 h-3" />
                    <span>{{ $card['label'] === 'Toplam Kar' ? 'Son dönem' : 'Tüm zaman' }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>




    @if(isset($settings->enable_kyc) && $settings->enable_kyc === 'yes')
        <!-- KYC Verification Component -->
        <div class="mb-6 sm:mb-8" data-kyc-dropdown="closed">
            @if(Auth::user()->account_verify === 'Verified')
                <!-- Verified Status -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-800 p-4 sm:p-6 shadow-sm">
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-50 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                            <x-heroicon name="check-circle" class="w-5 h-5 sm:w-6 sm:h-6 text-green-600 dark:text-green-400" />
                        </div>
                        <div class="flex-1 text-center sm:text-left">
                            <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white mb-1">
                                Hesap Doğrulandı
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">
                                Kimliğiniz doğrulandı. Tüm özellikler artık kullanılabilir.
                            </p>
                        </div>
                        <div class="px-3 py-1 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-full text-xs font-medium">
                            Doğrulandı
                        </div>
                    </div>
                </div>
            @else
                <!-- KYC Verification Needed -->
                <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-800 shadow-sm">
                    <!-- Header -->
                    <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-800">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-50 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                                    <x-heroicon name="shield-check" class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 dark:text-blue-400" />
                                </div>
                                <div>
                                    <h3 class="text-base sm:text-lg font-medium text-gray-900 dark:text-white mb-1">
                                        Kimlik Doğrulama
                                    </h3>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                                        Tüm özelliklere erişmek için doğrulamayı tamamlayın
                                    </p>
                                </div>
                            </div>

                            <!-- Toggle Button -->
                            <button onclick="toggleKycDropdown()"
                                    class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                <span class="flex items-center justify-center gap-2">
                                    <span>Detayları Görüntüle</span>
                                    <x-heroicon name="chevron-down" class="w-4 h-4 transition-transform" id="kycChevron" />
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Dropdown Content -->
                    <div id="kycDropdownContent" style="display: none;"
                         class="p-4 sm:p-6 border-t border-gray-100 dark:border-gray-800 transition-all duration-200">

                        @if(Auth::user()->account_verify === 'Under review')
                            <!-- Under Review State -->
                            <div class="text-center space-y-4">
                                <div class="w-16 h-16 mx-auto bg-yellow-50 dark:bg-yellow-900/20 rounded-full flex items-center justify-center">
                                    <x-heroicon name="clock" class="w-8 h-8 text-yellow-600 dark:text-yellow-400" />
                                </div>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                        İncelemede
                                    </h4>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm max-w-md mx-auto">
                                        Belgeleriniz inceleniyor. Doğrulama tamamlanır tamamlandıktan sonra size bildireceğiz.
                                    </p>
                                </div>

                                <!-- Simple Progress -->
                                <div class="max-w-xs mx-auto">
                                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mb-2">
                                        <span>Gönderildi</span>
                                        <span>İncelemede</span>
                                        <span>Tamamlandı</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                        <div class="bg-yellow-500 h-1.5 rounded-full w-2/3"></div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Verification Needed State -->
                            <div class="text-center space-y-6">
                                <div class="w-16 h-16 mx-auto bg-gray-50 dark:bg-gray-800 rounded-full flex items-center justify-center">
                                    <x-heroicon name="user-plus" class="w-8 h-8 text-gray-600 dark:text-gray-400" />
                                </div>

                                <div>
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                                        Doğrulamanızı Tamamlayın
                                    </h4>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm max-w-md mx-auto mb-6">
                                        Daha yüksek limitler ve gelişmiş güvenlik özelliklerini açmak için kimliğinizi doğrulayın.
                                    </p>
                                </div>

                                <!-- Benefits -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-sm mx-auto mb-6">
                                    <div class="text-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                        <x-heroicon name="shield-check" class="w-5 h-5 mx-auto mb-2 text-gray-600 dark:text-gray-400" />
                                        <span class="text-xs text-gray-600 dark:text-gray-400">Gelişmiş Güvenlik</span>
                                    </div>
                                    <div class="text-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                        <x-heroicon name="arrow-trending-up" class="w-5 h-5 mx-auto mb-2 text-gray-600 dark:text-gray-400" />
                                        <span class="text-xs text-gray-600 dark:text-gray-400">Daha Yüksek Limitler</span>
                                    </div>
                                </div>

                                <!-- Verify Button -->
                                <a href="{{ route('account.verify') }}"
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                    <x-heroicon name="user-check" class="w-4 h-4" />
                                    <span>Doğrulamayı Başlat</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    @endif

 @if($settings->wallet_status == 'on')
        <!-- Wallet Connection Prompt -->
        <div class="mb-6 sm:mb-8">
            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 rounded-2xl p-4 sm:p-6 border border-indigo-200 dark:border-indigo-700">
                <div class="flex flex-col sm:flex-row items-start gap-4">
                    <div class="p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl mx-auto sm:mx-0">
                        <x-heroicon name="wallet" class="w-6 h-6 sm:w-8 sm:h-8 text-indigo-600 dark:text-indigo-400" />
                    </div>
                    <div class="flex-1 text-center sm:text-left">
                        <h3 class="text-base sm:text-lg font-semibold text-indigo-900 dark:text-indigo-100 mb-2">Kazanç Elde Etmek İçin Cüzdanınızı Bağlayın</h3>
                        <p class="text-indigo-700 dark:text-indigo-300 text-sm mb-4">
                            Günlük kazanç fırsatlarını açmak için kripto para cüzdanınızı bağlayın, günde en fazla
                            <span class="font-semibold">{{ Auth::user()->currency }}{{ $settings->min_return ?? '0' }}</span> kadar.
                        </p>
                        <a href="{{ route('connect_wallet') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 sm:py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-all duration-200 transform hover:scale-[1.02] text-sm sm:text-base">
                            <x-heroicon name="plus" class="w-4 h-4" />
                            Cüzdanı Şimdi Bağla
                        </a>
                    </div>
                    <button onclick="this.parentElement.parentElement.parentElement.style.display='none'"
                            class="text-indigo-400 hover:text-indigo-600 dark:hover:text-indigo-300 absolute top-2 right-2 sm:relative sm:top-auto sm:right-auto">
                        <x-heroicon name="x-mark" class="w-5 h-5" />
                    </button>
                </div>
            </div>
        </div>
    @endif



 <!-- Quick Actions Grid (Tinker UI, Mature/Neutral) -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-8">
    <a href="{{ route('deposits') }}" class="flex flex-col items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 transition shadow-sm group py-3 px-2">
        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-gray-100 dark:bg-gray-800 mb-1">
            <x-heroicon name="plus-circle" class="w-5 h-5 text-gray-600 dark:text-gray-300" />
        </span>
        <span class="font-medium text-xs text-gray-800 dark:text-gray-200">Yatırım</span>
    </a>
    <a href="{{ route('withdrawalsdeposits') }}" class="flex flex-col items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 transition shadow-sm group py-3 px-2">
        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-gray-100 dark:bg-gray-800 mb-1">
            <x-heroicon name="arrow-up-right" class="w-5 h-5 text-gray-600 dark:text-gray-300" />
        </span>
        <span class="font-medium text-xs text-gray-800 dark:text-gray-200">Çekim</span>
    </a>
    <a href="{{ route('trade.index') }}" class="flex flex-col items-center justify-center rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 transition shadow-sm group py-3 px-2">
        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-gray-100 dark:bg-gray-800 mb-1">
            <x-heroicon name="arrow-trending-up" class="w-5 h-5 text-gray-600 dark:text-gray-300" />
        </span>
        <span class="font-medium text-xs text-gray-800 dark:text-gray-200">Yatırım</span>
    </a>
</div>







    <!-- Trading Chart & Quick Actions -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="xl:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-2">
                <h3 class="font-semibold text-base sm:text-lg text-gray-900 dark:text-white">Pazar Genel Bakışı</h3>
                <a href="{{ route('tradinghistory') }}" class="text-blue-600 hover:underline text-sm text-center sm:text-left">Geçmişi Görüntüle</a>
            </div>
            <!-- Asset Tickers -->
            <div class="mb-4">
                <div class="flex flex-wrap gap-2">
                    <!-- Crypto Assets -->
                    <div class="flex items-center gap-1 px-2 sm:px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                        <img src="https://assets.coingecko.com/coins/images/1/small/bitcoin.png" class="w-3 h-3 sm:w-4 sm:h-4 rounded-full" alt="BTC">
                        <span class="text-xs text-gray-700 dark:text-gray-200 font-semibold">BTC/USDT</span>
                        <span id="btc-price" class="text-xs text-green-600 dark:text-green-400 font-bold">$--</span>
                    </div>
                    <div class="flex items-center gap-1 px-2 sm:px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                        <img src="https://assets.coingecko.com/coins/images/279/small/ethereum.png" class="w-3 h-3 sm:w-4 sm:h-4 rounded-full" alt="ETH">
                        <span class="text-xs text-gray-700 dark:text-gray-200 font-semibold">ETH/USDT</span>
                        <span id="eth-price" class="text-xs text-green-600 dark:text-green-400 font-bold">$--</span>
                    </div>
                    <!-- Forex Assets -->
                    <div class="flex items-center gap-1 px-2 sm:px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                        <span class="text-xs text-gray-700 dark:text-gray-200 font-semibold">EUR/USD</span>
                        <span id="eurusd-price" class="text-xs text-blue-600 dark:text-blue-400 font-bold">--</span>
                    </div>
                    <div class="flex items-center gap-1 px-2 sm:px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                        <span class="text-xs text-gray-700 dark:text-gray-200 font-semibold">GBP/USD</span>
                        <span id="gbpusd-price" class="text-xs text-blue-600 dark:text-blue-400 font-bold">--</span>
                    </div>
                    <!-- Stock Assets -->
                    <div class="flex items-center gap-1 px-2 sm:px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                        <span class="text-xs text-gray-700 dark:text-gray-200 font-semibold">AAPL</span>
                        <span id="aapl-price" class="text-xs text-yellow-600 dark:text-yellow-400 font-bold">--</span>
                    </div>
                    <div class="flex items-center gap-1 px-2 sm:px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                        <span class="text-xs text-gray-700 dark:text-gray-200 font-semibold">TSLA</span>
                        <span id="tsla-price" class="text-xs text-yellow-600 dark:text-yellow-400 font-bold">--</span>
                    </div>
                </div>
            </div>
            <!-- Advanced TradingView Chart Widget -->
            <div id="tradingview_advanced" class="w-full" style="height: 300px; min-height: 300px;"></div>
            
            <script type="text/javascript">
                // Initialize TradingView widget with error handling
                function initializeTradingViewWidget() {
                    if (typeof TradingView !== 'undefined' && TradingView.widget) {
                        try {
                            new TradingView.widget({
                                autosize: true,
                                symbol: "BINANCE:BTCUSDT",
                                interval: "30",
                                timezone: "Etc/UTC",
                                theme: document.documentElement.classList.contains('dark') ? "dark" : "light",
                                style: "1",
                                locale: "en",
                                toolbar_bg: "#f1f3f6",
                                enable_publishing: false,
                                allow_symbol_change: true,
                                hide_side_toolbar: false,
                                container_id: "tradingview_advanced"
                            });
                        } catch (error) {
                            console.error('TradingView widget initialization failed:', error);
                            // Show fallback content
                            const container = document.getElementById('tradingview_advanced');
                            if (container) {
                                container.innerHTML = '<div class="flex items-center justify-center h-full text-gray-500 dark:text-gray-400"><p>Grafik yüklenemiyor. Lütfen sayfayı yenileyin.</p></div>';
                            }
                        }
                    } else {
                        // TradingView not loaded yet, retry after a short delay
                        setTimeout(initializeTradingViewWidget, 500);
                    }
                }
                
                // Initialize when DOM is ready
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initializeTradingViewWidget);
                } else {
                    initializeTradingViewWidget();
                }
                // Fetch live prices via unified API service
                async function fetchCryptoPrices() {
                    try {
                        const response = await fetch('/api/market-rates?type=crypto', {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        
                        if (response.ok) {
                            const result = await response.json();
                            if (result.success && result.data) {
                                if (result.data.bitcoin) {
                                    document.getElementById('btc-price').textContent = '$' + result.data.bitcoin.usd.toLocaleString();
                                }
                                if (result.data.ethereum) {
                                    document.getElementById('eth-price').textContent = '$' + result.data.ethereum.usd.toLocaleString();
                                }
                            }
                        }
                    } catch (error) {
                        console.log('Crypto prices fetch failed:', error);
                        // Fallback to static values
                        document.getElementById('btc-price').textContent = '$67,420';
                        document.getElementById('eth-price').textContent = '$3,240';
                    }
                }
                
                async function fetchForexPrices() {
                    try {
                        const response = await fetch('/api/market-rates?type=forex', {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        
                        if (response.ok) {
                            const result = await response.json();
                            if (result.success && result.data) {
                                if (result.data.USD) {
                                    document.getElementById('eurusd-price').textContent = result.data.USD.toFixed(4);
                                    if (result.data.GBP) {
                                        document.getElementById('gbpusd-price').textContent = (result.data.USD / result.data.GBP).toFixed(4);
                                    }
                                }
                            }
                        }
                    } catch (error) {
                        console.log('Forex prices fetch failed:', error);
                        // Fallback values
                        document.getElementById('eurusd-price').textContent = '1.0850';
                        document.getElementById('gbpusd-price').textContent = '1.2750';
                    }
                }
                
                async function fetchStockPrices() {
                    try {
                        const response = await fetch('/api/market-rates?type=stocks', {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        
                        if (response.ok) {
                            const result = await response.json();
                            if (result.success && result.data) {
                                if (result.data.AAPL) {
                                    document.getElementById('aapl-price').textContent = result.data.AAPL.price.toFixed(2);
                                }
                                if (result.data.TSLA) {
                                    document.getElementById('tsla-price').textContent = result.data.TSLA.price.toFixed(2);
                                }
                            }
                        }
                    } catch (error) {
                        console.log('Stock prices fetch failed:', error);
                        // Fallback values for demo
                        document.getElementById('aapl-price').textContent = '195.10';
                        document.getElementById('tsla-price').textContent = '850.20';
                    }
                }
                
                // Initialize price fetching
                fetchCryptoPrices();
                fetchForexPrices();
                fetchStockPrices();
                
                // Set up auto-refresh intervals
                setInterval(fetchCryptoPrices, 60000);
                setInterval(fetchForexPrices, 60000);
                setInterval(fetchStockPrices, 30000);
            </script>
        </div>
        <div class="xl:col-span-1 flex flex-col gap-4 sm:gap-6">
            <div class="bg-gradient-to-br from-indigo-600 to-blue-500 text-white rounded-xl shadow p-4 sm:p-6 text-center flex flex-col items-center justify-center min-h-[120px]">
                <x-heroicon name="bolt" class="w-8 h-8 sm:w-10 sm:h-10 mb-2" />
                <h3 class="text-base sm:text-lg font-semibold mb-1">Hızlı Ticaret</h3>
                <p class="text-xs sm:text-sm mb-3">Yeni bir işlem başlatın veya yatırım planlarını keşfedin.</p>
                {{-- <a href="{{ route('mplans') }}" class="inline-block bg-white dark:bg-gray-900 text-indigo-600 dark:text-indigo-300 font-semibold px-4 py-2 rounded-lg shadow hover:bg-gray-100 dark:hover:bg-gray-800 transition">Start Trading</a> --}}
            </div>
<form method="POST" action="{{ route('joinplan') }}" id="createTrade"
    class="bg-white dark:bg-gray-900 rounded-2xl shadow ring-1 ring-gray-200 dark:ring-gray-700 p-4 sm:p-6 space-y-4 sm:space-y-6">
    @csrf
    <h4 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
        <x-heroicon name="bar-chart-3" class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 dark:text-blue-400" />
        İşlem Yerleştir
    </h4>
    <div id="notifiAlert"></div>
    <!-- Asset Select -->
    <div>
        <label for="select_assetss" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Varlık</label>
        <select id="select_assetss" name="asset" required
            class="block w-full px-3 py-2 text-xs sm:text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
            @if(isset($instruments) && $instruments->count() > 0)
                @php
                    $typeLabels = [
                        'forex' => 'Döviz',
                        'crypto' => 'Kripto Para',
                        'stock' => 'Hisseler',
                        'commodity' => 'Emtialar',
                        'index' => 'Endeksler'
                    ];
                @endphp
                @foreach($instruments as $type => $typeInstruments)
                    <optgroup label="{{ $typeLabels[$type] ?? ucfirst($type) }}">
                        @foreach($typeInstruments as $instrument)
                            <option value="{{ $instrument->symbol }}"
                                    data-logo="{{ $instrument->logo }}"
                                    data-name="{{ $instrument->name }}"
                                    @if($loop->parent->first && $loop->first) selected @endif>
                                {{ $instrument->symbol }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            @else
                <!-- Fallback to hardcoded options if no instruments found -->
                <optgroup label="Döviz">
                    <option selected>EURUSD</option>
                    <option>EURJPY</option>
                    <option>USDJPY</option>
                    <option>USDCAD</option>
                    <option>AUDUSD</option>
                    <option>AUDJPY</option>
                    <option>NZDUSD</option>
                    <option>GBPUSD</option>
                    <option>GBPJPY</option>
                    <option>USDCHF</option>
                </optgroup>
                <optgroup label="Kripto Para">
                    <option>BTCUSD</option>
                    <option>ETHUSD</option>
                    <option>BCHUSD</option>
                    <option>XRPUSD</option>
                    <option>LTCUSD</option>
                    <option>ETHBTC</option>
                </optgroup>
                <optgroup label="Hisseler">
                    <option>CITI</option>
                    <option>SNAP</option>
                    <option>EA</option>
                    <option>MSFT</option>
                    <option>CSCO</option>
                    <option>GOOG</option>
                    <option>FB</option>
                    <option>SBUX</option>
                    <option>INTC</option>
                </optgroup>
                <optgroup label="Endeksler">
                    <option>SPX500USD</option>
                    <option>MXX</option>
                    <option>XAX</option>
                    <option>INDEX:STI</option>
                </optgroup>
                <optgroup label="Emtialar">
                    <option>GOLD</option>
                    <option>RB1!</option>
                    <option>USOIL</option>
                    <option>SILVER</option>
                </optgroup>
            @endif
        </select>
    </div>
    <!-- Amount -->
    <div>
        <label for="IAmount" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Miktar</label>
        <div class="flex rounded-lg shadow-sm overflow-hidden ring-1 ring-gray-300 dark:ring-gray-600 bg-gray-50 dark:bg-gray-800">
            <span class="px-3 sm:px-4 inline-flex items-center text-xs sm:text-sm text-gray-600 dark:text-gray-300 bg-gray-200 dark:bg-gray-700">
                {{ $settings->s_currency }}
            </span>
            <input type="number" name="amount" id="IAmount" placeholder="Yatırım Miktarı (0.00)" min="50" max="500000"
                class="w-full bg-transparent focus:outline-none px-3 sm:px-4 py-2 text-xs sm:text-sm text-gray-900 dark:text-white"
                required>
        </div>
        <span class="text-xs text-gray-400 mt-1 block">En Az: 50, En Çok: 500.000</span>
    </div>
    <!-- Leverage & Expiration -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
        <div class="hidden">
            <label for="leverage" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kaldıraç</label>
            <select name="leverage" id="leverage" required
                class="block w-full px-3 py-2 text-xs sm:text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                <option value="100" selected>1:100</option>
            </select>
        </div>
        <div class="hidden">
            <label for="expire" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Son Kullanma</label>
            <select name="expire" id="expire" required
                class="block w-full px-3 py-2 text-xs sm:text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                <option value="7 Days" selected>7 Gün</option>
            </select>
        </div>
    </div>
    <!-- Buy/Sell Buttons -->
    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-4">
        <button type="submit" name="order_type" value="Buy"
            class="flex-1 bg-gradient-to-br from-green-500 to-emerald-600 text-white py-2 sm:py-3 rounded-xl shadow hover:opacity-90 transition-all flex items-center justify-center gap-2 text-sm sm:text-base font-semibold">
            <x-heroicon name="arrow-up-right" class="w-4 h-4" /> SATIN AL
        </button>
        <button type="submit" name="order_type" value="Sell"
            class="flex-1 bg-gradient-to-br from-red-500 to-pink-600 text-white py-2 sm:py-3 rounded-xl shadow hover:opacity-90 transition-all flex items-center justify-center gap-2 text-sm sm:text-base font-semibold">
            <x-heroicon name="arrow-down-right" class="w-4 h-4" /> SAT
        </button>
    </div>
</form>
        </div>
    </div>

    <!-- Latest Trades & Referrals -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 sm:p-6">
            <h4 class="font-semibold text-base sm:text-lg mb-3 text-gray-900 dark:text-white">Son İşlemler</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs sm:text-sm">
                    <thead class="text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="px-2 sm:px-4 py-2 text-left">Detaylar</th>
                            <th class="px-2 sm:px-4 py-2">Miktar</th>
                            <th class="px-2 sm:px-4 py-2">Durum</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($t_history as $history)
                        <tr class="group hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                            <!-- Trade Details -->
                            <td class="py-3 px-2 sm:px-4 align-top">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold
                                        {{ $history->type == 'LOSE' ? 'bg-red-50 text-red-600 dark:bg-red-900/20' : 'bg-green-50 text-green-600 dark:bg-green-900/20' }}">
                                        <x-heroicon name="question-mark-circle" class="w-3 h-3 sm:w-4 sm:h-4 mr-1" />
                                        {{ $history->plan }}
                                    </span>
                                </div>
                                <div class="text-xs text-gray-400 mt-1">{{ $history->created_at->toDayDateTimeString() }}</div>
                            </td>
                            <!-- Amount -->
                            <td class="py-3 px-2 sm:px-4 align-top font-semibold {{ $history->type == 'LOSE' ? 'text-red-600' : 'text-green-600' }}">
                                {{ Auth::user()->currency }} {{ number_format($history->amount, 2, '.', ',') }}
                            </td>
                            <!-- Status/Leverage -->
                            <td class="py-3 px-2 sm:px-4 align-top">
                                @if($history->type == 'WIN')
                                    <span class="inline-flex items-center px-2 py-1 rounded bg-green-100 text-green-700 dark:bg-green-900/20 dark:text-green-400 text-xs font-medium">KAZANÇ +{{ $history->leverage }}%</span>
                                @elseif($history->type == 'LOSE')
                                    <span class="inline-flex items-center px-2 py-1 rounded bg-red-100 text-red-700 dark:bg-red-900/20 dark:text-red-400 text-xs font-medium">KAYIP -{{ $history->leverage }}%</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded bg-blue-100 text-red-700 dark:bg-blue-900/20 dark:text-red-400 text-xs font-medium">{{ $history->type }}</span>
                                    <span class="text-xs ml-1 hidden sm:inline">Kaldıraç: 1:{{ $history->leverage }}</span>
                                @endif
                                <div class="text-xs text-gray-400 mt-1 hidden sm:block">{{ $history->created_at->toDayDateTimeString() }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ route('tradinghistory') }}" class="block text-center mt-4 text-blue-600 font-semibold">Tümünü Görüntüle</a>
        </div>


        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 flex flex-col justify-between">
            <div>
                <h4 class="font-semibold text-lg mb-2 text-gray-900 dark:text-white">Referanslar</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Projemizi ağınıza sunun ve finansal avantajlardan yararlanın. Ortaklık komisyonları kazanmak için aktif bir yatırıma ihtiyacınız yok.</p>
                <a href="{{ route('referuser') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Daha Fazla Öğrenin</a>
             <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 sm:p-6 mt-4">
                <h4 class="font-semibold mb-2 text-gray-900 dark:text-white text-sm sm:text-base">Kişisel Referans Bağlantısı</h4>
                <div class="flex flex-col sm:flex-row items-stretch gap-2">
                    <input type="text" class="form-input flex-1 rounded border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-white text-xs sm:text-sm min-w-0" value="{{ Auth::user()->ref_link }}" readonly>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded text-xs sm:text-sm whitespace-nowrap" onclick="copyReferralLink()">Kopyala</button>
                </div>
                <p id="copiedMessage" class="text-xs sm:text-sm text-green-500 mt-1" style="display: none;">Panoya kopyalandı!</p>
            </div>

            </div>

        </div>
    </div>
  <!-- Asset Overview Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 mb-6 sm:mb-8">
        <!-- BTC Widget -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-3 sm:p-4 min-h-[120px] sm:min-h-[150px]">
            <div class="tradingview-widget-container h-full">
                <div class="tradingview-widget-container__widget h-full"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                {
                    "symbol": "BINANCE:BTCUSDT",
                    "width": "100%",
                    "height": "100%",
                    "locale": "en",
                    "dateRange": "1D",
                    "colorTheme": "dark",
                    "isTransparent": true,
                    "autosize": true,
                    "largeChartUrl": ""
                }
                </script>
            </div>
        </div>

        <!-- ETH Widget -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-3 sm:p-4 min-h-[120px] sm:min-h-[150px]">
            <div class="tradingview-widget-container h-full">
                <div class="tradingview-widget-container__widget h-full"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                {
                    "symbol": "BINANCE:ETHUSDT",
                    "width": "100%",
                    "height": "100%",
                    "locale": "en",
                    "dateRange": "1D",
                    "colorTheme": "dark",
                    "isTransparent": true,
                    "autosize": true,
                    "largeChartUrl": ""
                }
                </script>
            </div>
        </div>

        <!-- EUR/USD Widget -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-3 sm:p-4 min-h-[120px] sm:min-h-[150px]">
            <div class="tradingview-widget-container h-full">
                <div class="tradingview-widget-container__widget h-full"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                {
                    "symbol": "FX:EURUSD",
                    "width": "100%",
                    "height": "100%",
                    "locale": "en",
                    "dateRange": "1D",
                    "colorTheme": "dark",
                    "isTransparent": true,
                    "autosize": true,
                    "largeChartUrl": ""
                }
                </script>
            </div>
        </div>

        <!-- GBP/USD Widget -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-3 sm:p-4 min-h-[120px] sm:min-h-[150px]">
            <div class="tradingview-widget-container h-full">
                <div class="tradingview-widget-container__widget h-full"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                {
                    "symbol": "FX:GBPUSD",
                    "width": "100%",
                    "height": "100%",
                    "locale": "en",
                    "dateRange": "1D",
                    "colorTheme": "dark",
                    "isTransparent": true,
                    "autosize": true,
                    "largeChartUrl": ""
                }
                </script>
            </div>
        </div>

        <!-- AAPL Widget -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-3 sm:p-4 min-h-[120px] sm:min-h-[150px]">
            <div class="tradingview-widget-container h-full">
                <div class="tradingview-widget-container__widget h-full"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                {
                    "symbol": "NASDAQ:AAPL",
                    "width": "100%",
                    "height": "100%",
                    "locale": "en",
                    "dateRange": "1D",
                    "colorTheme": "dark",
                    "isTransparent": true,
                    "autosize": true,
                    "largeChartUrl": ""
                }
                </script>
            </div>
        </div>

        <!-- Gold Widget -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-3 sm:p-4 min-h-[120px] sm:min-h-[150px]">
            <div class="tradingview-widget-container h-full">
                <div class="tradingview-widget-container__widget h-full"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                {
                    "symbol": "TVC:GOLD",
                    "width": "100%",
                    "height": "100%",
                    "locale": "en",
                    "dateRange": "1D",
                    "colorTheme": "dark",
                    "isTransparent": true,
                    "autosize": true,
                    "largeChartUrl": ""
                }
                </script>
            </div>
        </div>
    </div>

<!-- Live Market Watch Widget -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-3 sm:p-4 mb-4 sm:mb-6">
    <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-quotes.js" async>
        {
            "width": "100%",
            "height": 400,
            "symbolsGroups": [
                {
                    "name": "Crypto",
                    "symbols": [
                        {"name": "BINANCE:BTCUSDT", "displayName": "Bitcoin"},
                        {"name": "BINANCE:ETHUSDT", "displayName": "Ethereum"},
                        {"name": "BINANCE:BNBUSDT", "displayName": "BNB"}
                    ]
                },
                {
                    "name": "Forex",
                    "symbols": [
                        {"name": "FX:EURUSD", "displayName": "EUR/USD"},
                        {"name": "FX:GBPUSD", "displayName": "GBP/USD"},
                        {"name": "FX:USDJPY", "displayName": "USD/JPY"}
                    ]
                }
            ],
            "showSymbolLogo": true,
            "colorTheme": "dark",
            "isTransparent": true,
            "locale": "en"
        }
        </script>
    </div>
</div>


<!-- News Feed Widget -->
<div class="mt-4 sm:mt-6">
    <div class="tradingview-widget-container bg-white dark:bg-gray-800 rounded-xl shadow p-3 sm:p-4">
        <div class="tradingview-widget-container__widget"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-timeline.js" async>
        {
            "feedMode": "all_symbols",
            "colorTheme": "dark",
            "isTransparent": true,
            "displayMode": "compact",
            "width": "100%",
            "height": "350",
            "locale": "tr"
        }
        </script>
    </div>
</div>
</div>

<script>
    // KYC Dropdown Toggle
    function toggleKycDropdown() {
        const dropdown = document.querySelector('[data-kyc-dropdown]');
        const content = document.getElementById('kycDropdownContent');
        const chevron = document.getElementById('kycChevron');
        
        if (content && chevron) {
            const isOpen = content.style.display !== 'none';
            
            if (isOpen) {
                content.style.display = 'none';
                chevron.classList.remove('rotate-180');
                dropdown.setAttribute('data-kyc-dropdown', 'closed');
            } else {
                content.style.display = 'block';
                chevron.classList.add('rotate-180');
                dropdown.setAttribute('data-kyc-dropdown', 'open');
            }
        }
    }

    // Copy Referral Link
    function copyReferralLink() {
        const refLink = '{{ Auth::user()->ref_link }}';
        const copiedMessage = document.getElementById('copiedMessage');
        
        if (navigator.clipboard) {
            navigator.clipboard.writeText(refLink).then(function() {
                showCopiedMessage();
            });
        } else {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = refLink;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showCopiedMessage();
        }
    }

    function showCopiedMessage() {
        const copiedMessage = document.getElementById('copiedMessage');
        if (copiedMessage) {
            copiedMessage.style.display = 'block';
            setTimeout(function() {
                copiedMessage.style.display = 'none';
            }, 3000);
        }
    }

    function changeTimeframe(interval) {
        if (widget) {
            widget.chart().setResolution(interval);
        }
    }

    // Asset selection enhancement with logo display
    document.addEventListener('DOMContentLoaded', function() {
        const assetSelect = document.getElementById('select_assetss');

        if (assetSelect) {
            // Create logo display element if it doesn't exist
            let logoDisplay = document.getElementById('asset-logo-display');
            if (!logoDisplay) {
                logoDisplay = document.createElement('div');
                logoDisplay.id = 'asset-logo-display';
                logoDisplay.className = 'flex items-center gap-2 mt-2';
                logoDisplay.innerHTML = '<img id="asset-logo" class="w-6 h-6 rounded-full hidden" alt="Asset Logo"><span id="asset-name" class="text-sm text-gray-600 dark:text-gray-400"></span>';
                assetSelect.parentNode.appendChild(logoDisplay);
            }

            // Function to update logo display
            function updateAssetLogo() {
                const selectedOption = assetSelect.options[assetSelect.selectedIndex];
                const logoImg = document.getElementById('asset-logo');
                const assetName = document.getElementById('asset-name');

                if (selectedOption && selectedOption.dataset.logo && selectedOption.dataset.logo !== 'null' && selectedOption.dataset.logo !== '') {
                    logoImg.src = selectedOption.dataset.logo;
                    logoImg.classList.remove('hidden');
                    logoImg.onerror = function() {
                        this.classList.add('hidden');
                    };
                } else {
                    logoImg.classList.add('hidden');
                }

                if (assetName) {
                    // Use instrument name if available, otherwise use symbol
                    const displayName = selectedOption.dataset.name || selectedOption.text;
                    assetName.textContent = displayName;
                }
            }

            // Update logo on selection change
            assetSelect.addEventListener('change', updateAssetLogo);

            // Initialize logo display
            updateAssetLogo();
        }
    });
</script>
@endsection
