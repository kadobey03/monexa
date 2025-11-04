@extends('layouts.master', ['layoutType' => 'dashboard'])
@section('title', 'Trade ' . $instrument->name)
@section('content')

<div class="container mx-auto px-4 py-8" id="tradingSingleContainer">
    <!-- TradingView Ticker Tape Widget -->
    <!--<div class="mb-6">-->
    <!--    <div class="tradingview-widget-container">-->
    <!--        <div class="tradingview-widget-container__widget"></div>-->
    <!--        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>-->
    <!--        {-->
    <!--            "symbols": [-->
    <!--                {"proName": "BINANCE:BTCUSDT", "title": "BTC/USDT"},-->
    <!--                {"proName": "BINANCE:ETHUSDT", "title": "ETH/USDT"},-->
    <!--                {"proName": "FX:EURUSD", "title": "EUR/USD"},-->
    <!--                {"proName": "NASDAQ:AAPL", "title": "APPLE"},-->
    <!--                {"proName": "NASDAQ:TSLA", "title": "TESLA"},-->
    <!--                {"proName": "TVC:GOLD", "title": "GOLD"}-->
    <!--            ],-->
    <!--            "showSymbolLogo": true,-->
    <!--            "colorTheme": "dark",-->
    <!--            "isTransparent": true,-->
    <!--            "displayMode": "adaptive",-->
    <!--            "locale": "en"-->
    <!--        }-->
    <!--        </script>-->
    <!--    </div>-->
    <!--</div>-->

    <x-notify-alert />
    <x-danger-alert />
    <x-success-alert />

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('trade.index') }}"
           class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
            <x-heroicon name="arrow-left" class="w-4 h-4" />
            Pazarlara Dön
        </a>
    </div>

    <!-- Trading Interface -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Chart Section (Left Side) -->
        <div class="xl:col-span-2 space-y-6">
            <!-- Instrument Header -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                            @if($instrument->logo)
                                <img src="{{ $instrument->logo }}" alt="{{ $instrument->name }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <span class="text-gray-500 dark:text-gray-400 font-semibold">{{ substr($instrument->symbol, 0, 2) }}</span>
                            @endif
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $instrument->name }}</h1>
                            <p class="text-gray-600 dark:text-gray-400">{{ $instrument->symbol }}</p>
                        </div>
                    </div>

                    <!-- Price Info -->
                    <div class="text-right">
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                            ${{ number_format($instrument->price, $instrument->price >= 1 ? 2 : 6) }}
                        </div>
                        <div class="flex items-center gap-1 {{ $instrument->percent_change_24h >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            @if($instrument->percent_change_24h >= 0)
                                <x-heroicon name="arrow-trending-up" class="w-4 h-4" />
                            @else
                                <x-heroicon name="arrow-trending-down" class="w-4 h-4" />
                            @endif
                            <span>{{ number_format($instrument->percent_change_24h, 2) }}%</span>
                            <span class="text-sm">({{ $instrument->change >= 0 ? '+' : '' }}${{ number_format($instrument->change, 2) }})</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Widget -->
           <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
    <div class="mb-4">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Fiyat Grafiği</h2>
    </div>

    <!-- TradingView Chart -->
    <div class="tradingview-widget-container h-[600px]">
        <div class="tradingview-widget-container__widget"></div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
        {
            "height": 600,
            "symbol": "{{ $instrument->symbol }}",
            "interval": "D",
            "timezone": "Etc/UTC",
            "theme": "dark",
            "style": "1",
            "locale": "en",
            "toolbar_bg": "#f1f3f6",
            "enable_publishing": false,
            "allow_symbol_change": true,
            "studies": [],
            "show_popup_button": true,
            "popup_width": "1000",
            "popup_height": "650",
            "hide_side_toolbar": false,
            "hide_top_toolbar": false,
            "hide_legend": false,
            "save_image": false,
            "hide_volume": false,
            "support_host": "https://www.tradingview.com",
            "container_id": "tradingview_chart"
        }
        </script>
    </div>
</div>
           <!-- Market Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pazar İstatistikleri</h3>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">24s Yüksek</div>
                        <div class="font-semibold text-gray-900 dark:text-white">
                            ${{ number_format($instrument->high ?? 0, $instrument->price >= 1 ? 2 : 6) }}
                        </div>
                    </div>

                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">24s Düşük</div>
                        <div class="font-semibold text-gray-900 dark:text-white">
                            ${{ number_format($instrument->low ?? 0, $instrument->price >= 1 ? 2 : 6) }}
                        </div>
                    </div>

                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">24s Hacim</div>
                        <div class="font-semibold text-gray-900 dark:text-white">
                            @if($instrument->volume >= 1e9)
                                ${{ number_format($instrument->volume / 1e9, 1) }}B
                            @elseif($instrument->volume >= 1e6)
                                ${{ number_format($instrument->volume / 1e6, 1) }}M
                            @elseif($instrument->volume >= 1e3)
                                ${{ number_format($instrument->volume / 1e3, 1) }}K
                            @else
                                ${{ number_format($instrument->volume ?? 0) }}
                            @endif
                        </div>
                    </div>

                    <div class="text-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Pazar Değeri</div>
                        <div class="font-semibold text-gray-900 dark:text-white">
                            @if($instrument->market_cap >= 1e9)
                                ${{ number_format($instrument->market_cap / 1e9, 1) }}B
                            @elseif($instrument->market_cap >= 1e6)
                                ${{ number_format($instrument->market_cap / 1e6, 1) }}M
                            @else
                                ${{ number_format($instrument->market_cap ?? 0) }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trade History Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">

                <!-- Trade History Tabs -->
                <div class="flex bg-gray-100 dark:bg-gray-700 rounded-lg p-1 mb-6">
                    <button onclick="setActiveTab('open')"
                            id="openTab"
                            class="flex-1 py-2 px-4 rounded-md font-medium transition-colors text-sm bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-sm">
                        Açık İşlemler ({{ $openTrades->count() }})
                    </button>
                    <button onclick="setActiveTab('closed')"
                            id="closedTab"
                            class="flex-1 py-2 px-4 rounded-md font-medium transition-colors text-sm text-gray-600 dark:text-gray-400">
                        Kapalı İşlemler ({{ $closedTrades->count() }})
                    </button>
                </div>

                <!-- Open Trades -->
                <div id="openTradesContent">
                    @if($openTrades->count() > 0)
                        <div class="grid gap-4 sm:grid-cols-1 lg:grid-cols-2">
                            @foreach($openTrades as $trade)
                                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-300 group">
                                    <!-- Active Trade Indicator -->
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            <div class="relative">
                                                <!-- Spinning yellow loader for active trades -->
                                                <div class="w-8 h-8 border-2 border-yellow-200 border-t-yellow-500 rounded-full animate-spin"></div>
                                                <!-- Pulsing ring for extra attention -->
                                                <div class="absolute inset-0 w-8 h-8 border-2 border-yellow-300 rounded-full animate-pulse opacity-50"></div>
                                            </div>
                                            <div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                    <x-heroicon name="activity" class="w-3 h-3 mr-1" />
                                                    Aktif
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-lg font-bold {{ $trade->type === 'Buy' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{Auth::user()->currency}}{{ number_format($trade->amount, 2) }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($trade->created_at)->format('M d, H:i') }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Trade Details -->
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full {{ $trade->type === 'Buy' ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} flex items-center justify-center">
                                                    @if($trade->type === 'Buy')
                                                        <x-heroicon name="arrow-trending-up" class="w-5 h-5 text-green-600 dark:text-green-400" />
                                                    @else
                                                        <x-heroicon name="arrow-trending-down" class="w-5 h-5 text-red-600 dark:text-red-400" />
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-900 dark:text-white">
                                                        {{ $trade->type }} {{ $trade->assets }}
                                                    </div>
                                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                                        Leverage: 1:{{ $trade->leverage ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Progress Section -->
                                        @if($trade->expire_date)
                                            @php
                                                $start = \Carbon\Carbon::parse($trade->activated_at ?? $trade->created_at);
                                                $end = \Carbon\Carbon::parse($trade->expire_date);
                                                $now = \Carbon\Carbon::now();
                                                $total = $start->diffInMinutes($end);
                                                $elapsed = $start->diffInMinutes($now);
                                                $progress = $total > 0 ? min(($elapsed / $total) * 100, 100) : 0;
                                                $timeLeft = $now < $end ? $now->diffForHumans($end) : 'Expired';
                                                $randomProgress = rand(15, 85); // Random completion percentage for visual appeal
                                            @endphp

                                            <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-3">
                                                <div class="flex justify-between items-center mb-2">
                                                    <span class="text-xs font-medium text-gray-600 dark:text-gray-400">Zaman İlerlemesi</span>
                                                    <span class="text-xs text-gray-600 dark:text-gray-400">{{ $timeLeft }}</span>
                                                </div>
                                                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                                    <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                                                </div>
                                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    <span>Started {{ \Carbon\Carbon::parse($trade->created_at)->diffForHumans() }}</span>
                                                    <span>{{ number_format($progress, 1) }}%</span>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Trade Info Grid -->
                                        <div class="grid grid-cols-2 gap-3 text-sm">
                                            <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-2">
                                                <div class="text-gray-600 dark:text-gray-400 text-xs">Süre</div>
                                                <div class="font-medium text-gray-900 dark:text-white">{{ $trade->inv_duration ?? 'N/A' }}</div>
                                            </div>
                                            <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-2">
                                                <div class="text-gray-600 dark:text-gray-400 text-xs">Mevcut Kar/Zarar</div>
                                                <div class="font-medium {{ ($trade->profit_earned ?? 0) >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                    {{ ($trade->profit_earned ?? 0) >= 0 ? '+' : '' }}{{Auth::user()->currency}}{{ number_format($trade->profit_earned ?? 0, 2) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                        <a href="{{ route('trade.monitor', $trade->id) }}" class="w-full py-2 px-4 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors text-sm font-medium group-hover:bg-blue-50 group-hover:text-blue-600 dark:group-hover:bg-blue-900/30 dark:group-hover:text-blue-400 block text-center">
                                            <x-heroicon name="eye" class="w-4 h-4 inline mr-2" />
                                            İşlemi İzle
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <x-heroicon name="chart-line" class="w-8 h-8 text-gray-400" />
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Açık İşlem Yok</h4>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">You don't have any open trades for {{ $instrument->symbol }}</p>
                            <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium">
                                İşleme Başla
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Closed Trades -->
                <div id="closedTradesContent" style="display: none;">
                    @if($closedTrades->count() > 0)
                        <div class="grid gap-4 sm:grid-cols-1 lg:grid-cols-2">
                            @foreach($closedTrades as $trade)
                                @php
                                    // Use actual profit_earned from user_plans table
                                    $actualProfitEarned = $trade->profit_earned ?? 0;
                                    $isProfit = $actualProfitEarned >= 0;
                                    $profitAmount = abs($actualProfitEarned);

                                    // Determine if trade was successful based on profit_earned
                                    $isSuccessful = $actualProfitEarned > 0;
                                @endphp
                                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-300 group">
                                    <!-- Trade Status Header -->
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            @if($trade->active === 'yes')
                                                <!-- Active Trade -->
                                                <div class="w-8 h-8 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                                                    <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></div>
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                    <div class="w-2 h-2 rounded-full bg-yellow-500 mr-1 animate-pulse"></div>
                                                    Aktif İşlem
                                                </span>
                                            @elseif($trade->active === 'expired')
                                                <!-- Closed Trade -->
                                                <div class="w-8 h-8 rounded-full {{ $isSuccessful ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} flex items-center justify-center">
                                                    @if($isSuccessful)
                                                        <x-heroicon name="check" class="w-4 h-4 text-green-600 dark:text-green-400" />
                                                    @else
                                                        <x-heroicon name="x-mark" class="w-4 h-4 text-red-600 dark:text-red-400" />
                                                    @endif
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $isSuccessful ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                    <div class="w-2 h-2 rounded-full {{ $isSuccessful ? 'bg-green-500' : 'bg-red-500' }} mr-1"></div>
                                                    {{ $isSuccessful ? 'Tamamlandı' : 'Kapalı' }}
                                                </span>
                                            @else
                                                <!-- Unknown Status -->
                                                <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                    <x-heroicon name="question-mark-circle" class="w-4 h-4 text-gray-500" />
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400">
                                                    <div class="w-2 h-2 rounded-full bg-gray-500 mr-1"></div>
                                                    Unknown
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <div class="text-lg font-bold text-gray-900 dark:text-white">
                                                {{Auth::user()->currency}}{{ number_format($trade->amount, 2) }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($trade->created_at)->format('M d, H:i') }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Trade Details -->
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full {{ $trade->type === 'Buy' ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} flex items-center justify-center">
                                                    @if($trade->type === 'Buy')
                                                        <x-heroicon name="arrow-trending-up" class="w-5 h-5 text-green-600 dark:text-green-400" />
                                                    @else
                                                        <x-heroicon name="arrow-trending-down" class="w-5 h-5 text-red-600 dark:text-red-400" />
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-900 dark:text-white">
                                                        {{ $trade->type }} {{ $trade->assets }}
                                                    </div>
                                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                                        Leverage: 1:{{ $trade->leverage ?? 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Performance Metrics -->
                                        <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-3">
                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">Kar/Zarar</div>
                                                    @if($trade->active === 'expired')
                                                        <div class="font-semibold {{ $isProfit ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                            {{ $isProfit ? '+' : '-' }}{{Auth::user()->currency}}{{ number_format($profitAmount, 2) }}
                                                        </div>
                                                    @else
                                                        <div class="font-semibold text-yellow-600 dark:text-yellow-400">
                                                            Beklemede
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="text-xs text-gray-600 dark:text-gray-400 mb-1">Getiri</div>
                                                    @if($trade->active === 'expired' && $trade->amount > 0)
                                                        <div class="font-semibold {{ $isProfit ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                            {{ $isProfit ? '+' : '-' }}{{ number_format(($profitAmount / $trade->amount) * 100, 1) }}%
                                                        </div>
                                                    @else
                                                        <div class="font-semibold text-yellow-600 dark:text-yellow-400">
                                                            ---%
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Trade Timeline -->
                                        <div class="grid grid-cols-2 gap-3 text-sm">
                                            <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-2">
                                                <div class="text-gray-600 dark:text-gray-400 text-xs">Süre</div>
                                                <div class="font-medium text-gray-900 dark:text-white">{{ $trade->inv_duration ?? 'N/A' }}</div>
                                            </div>
                                            <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-2">
                                                @if($trade->active === 'yes')
                                                    <div class="text-gray-600 dark:text-gray-400 text-xs">Sona Eriyor</div>
                                                    <div class="font-medium text-yellow-600 dark:text-yellow-400">
                                                        {{ $trade->expire_date ? \Carbon\Carbon::parse($trade->expire_date)->format('M d, H:i') : 'N/A' }}
                                                    </div>
                                                @else
                                                    <div class="text-gray-600 dark:text-gray-400 text-xs">Kapalı</div>
                                                    <div class="font-medium text-gray-900 dark:text-white">
                                                        {{ \Carbon\Carbon::parse($trade->expire_date ?? $trade->updated_at)->format('M d, H:i') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                        <a href="{{ route('trade.monitor', $trade->id) }}" class="w-full py-2 px-4 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors text-sm font-medium group-hover:bg-blue-50 group-hover:text-blue-600 dark:group-hover:bg-blue-900/30 dark:group-hover:text-blue-400 block text-center">
                                            <x-heroicon name="bar-chart-3" class="w-4 h-4 inline mr-2" />
                                            Detayları Görüntüle
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($closedTrades->count() >= 10)
                            <div class="text-center mt-6 p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Son 10 işlem gösteriliyor</p>
                                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium">
                                    <x-heroicon name="history" class="w-4 h-4 inline mr-2" />
                                    Tüm Geçmişi Görüntüle
                                </button>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <x-heroicon name="history" class="w-8 h-8 text-gray-400" />
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">İşlem Geçmişi Yok</h4>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">You haven't completed any trades for {{ $instrument->symbol }} yet</p>
                            <div class="space-y-3">
                                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium">
                                    İşleme Başla
                                </button>
                                <div>
                                    <a href="{{ url('user-trades-debug.php') }}" class="text-sm text-blue-600 hover:underline">
                                        Tüm İşlemlerinizi Görüntüle
                                    </a>
                                </div>
                            </div>
                            @if(config('app.debug') && auth()->user()->is_admin)
                                <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                    <div class="text-xs text-yellow-800 dark:text-yellow-400">
                                        <strong>Hata Ayıklama Bilgisi:</strong> Şu işlemler aranıyor: {{ $instrument->symbol }}, {{ $instrument->name }},
                                        {{ str_replace('/', '', $instrument->symbol) }}, and other variations.
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Trading Panel (Right Side) -->
        <div class="xl:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 sticky top-8">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Sipariş Ver</h3>

                <!-- Order Type Tabs -->
                <div class="flex bg-gray-100 dark:bg-gray-700 rounded-lg p-1 mb-6">
                    <button onclick="setOrderType('Buy')"
                            id="buyButton"
                            class="flex-1 py-2 px-4 rounded-md font-medium transition-colors bg-green-500 text-white">
                        Al
                    </button>
                    <button onclick="setOrderType('Sell')"
                            id="sellButton"
                            class="flex-1 py-2 px-4 rounded-md font-medium transition-colors text-gray-600 dark:text-gray-400">
                        Sat
                    </button>
                </div>

                <!-- Order Form -->
                <form action="{{ route('joinplan') }}" method="POST" class="space-y-4" id="orderForm" onsubmit="return submitOrder(event)">
                    @csrf
                    <!-- Hidden fields for instrument data -->
                    <input type="hidden" name="plan_id" value="{{ $instrument->id }}">
                    <input type="hidden" name="symbol" value="{{ $instrument->symbol }}">
                    <input type="hidden" name="asset" value="{{ $instrument->name }}">
                    <input type="hidden" name="instrument_price" value="{{ $instrument->price }}">
                    <input type="hidden" name="order_type" id="orderTypeInput" value="Buy">
                    <input type="hidden" name="trade_type" value="market">
                    <input type="hidden" name="leverage" value="100">
                    <input type="hidden" name="expire" value="7 Days">

                    <!-- Price Input (for limit/stop orders) -->
                    <div >
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fiyat ($)</label>
                        <input type="number"
                               id="priceInput"
                               name="price"
                               step="any"
                               min="0"
                               placeholder="{{ $instrument->price }}"
                               value="{{ $instrument->price }}"
                               class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">
                    </div>

                    <!-- Amount Input (Total Investment) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Yatırım Miktarı ($)</label>
                        <input type="number"
                               id="amountInput"
                               name="amount"
                               step="0.01"
                               min="0"
                               placeholder="0.00"
                               required
                               onchange="updateSummary()"
                               oninput="updateSummary()"
                               class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">
                    </div>                    <!-- Investment Summary -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Yatırım Miktarı:</span>
                            <span class="font-semibold text-gray-900 dark:text-white" id="summaryAmount">$0.00</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Birimler:</span>
                            <span class="text-sm text-gray-900 dark:text-white" id="summaryUnits">0</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Mevcut Bakiye:</span>
                            <span class="text-sm text-gray-900 dark:text-white">${{ number_format(auth()->user()->account_bal ?? 0, 2) }}</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            id="submitButton"
                            class="w-full py-3 px-4 text-white font-semibold rounded-lg transition-colors disabled:cursor-not-allowed flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 disabled:bg-green-300">
                        <span id="submitButtonText">Al {{ $instrument->symbol }}</span>
                    </button>
                </form>

                <!-- Quick Amount Buttons -->
                <div class="mt-4">
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Hızlı miktarlar:</div>
                    <div class="grid grid-cols-4 gap-2">
                        <button onclick="setQuickAmount(25)" class="py-1 px-2 text-xs bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded text-gray-700 dark:text-gray-300 transition-colors">25%</button>
                        <button onclick="setQuickAmount(50)" class="py-1 px-2 text-xs bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded text-gray-700 dark:text-gray-300 transition-colors">50%</button>
                        <button onclick="setQuickAmount(75)" class="py-1 px-2 text-xs bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded text-gray-700 dark:text-gray-300 transition-colors">75%</button>
                        <button onclick="setQuickAmount(100)" class="py-1 px-2 text-xs bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded text-gray-700 dark:text-gray-300 transition-colors">Max</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Trading Single Vanilla JavaScript
const TradingSingle = {
    instrument: {!! json_encode($instrument) !!},
    orderType: 'Buy',
    tradeType: 'market',
    amount: '',
    price: '{{ $instrument->price }}',
    loading: false,
    activeTab: 'open',

    init() {
        this.setupEventListeners();
        this.updateSummary();
        this.initializeLucideIcons();
    },

    setupEventListeners() {
        const amountInput = document.getElementById('amountInput');
        const priceInput = document.getElementById('priceInput');
        
        if (amountInput) {
            amountInput.addEventListener('input', () => {
                this.amount = amountInput.value;
                this.updateSummary();
            });
        }

        if (priceInput) {
            priceInput.addEventListener('input', () => {
                this.price = priceInput.value;
                this.updateSummary();
            });
        }
    },

    formatAmount() {
        if (!this.amount) return '$0.00';
        const amount = parseFloat(this.amount);
        return '$' + amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    },

    formatUnits() {
        if (!this.amount) return '0';
        const amount = parseFloat(this.amount);
        const price = this.tradeType === 'market' ? this.instrument.price : (this.price || this.instrument.price);
        const units = amount / parseFloat(price);
        return units.toLocaleString('en-US', { minimumFractionDigits: 6, maximumFractionDigits: 6 });
    },

    updateSummary() {
        const summaryAmount = document.getElementById('summaryAmount');
        const summaryUnits = document.getElementById('summaryUnits');
        
        if (summaryAmount) {
            summaryAmount.textContent = this.formatAmount();
        }
        
        if (summaryUnits) {
            summaryUnits.textContent = this.formatUnits();
        }
    },

    setQuickAmount(percentage) {
        const balance = {{ auth()->user()->account_bal ?? 0 }};
        this.amount = (balance * percentage / 100).toFixed(2);
        const amountInput = document.getElementById('amountInput');
        if (amountInput) {
            amountInput.value = this.amount;
        }
        this.updateSummary();
    },

    setOrderType(type) {
        this.orderType = type;
        const orderTypeInput = document.getElementById('orderTypeInput');
        const buyButton = document.getElementById('buyButton');
        const sellButton = document.getElementById('sellButton');
        const submitButton = document.getElementById('submitButton');
        const submitButtonText = document.getElementById('submitButtonText');

        if (orderTypeInput) {
            orderTypeInput.value = type;
        }

        if (type === 'Buy') {
            if (buyButton) {
                buyButton.className = buyButton.className.replace(/text-gray-600.*dark:text-gray-400/, 'bg-green-500 text-white');
            }
            if (sellButton) {
                sellButton.className = sellButton.className.replace(/bg-red-500.*text-white/, 'text-gray-600 dark:text-gray-400');
            }
            if (submitButton) {
                submitButton.className = submitButton.className.replace(/bg-red-600.*disabled:bg-red-300/, 'bg-green-600 hover:bg-green-700 disabled:bg-green-300');
            }
            if (submitButtonText) {
                submitButtonText.textContent = `Al ${this.instrument.symbol}`;
            }
        } else {
            if (sellButton) {
                sellButton.className = sellButton.className.replace(/text-gray-600.*dark:text-gray-400/, 'bg-red-500 text-white');
            }
            if (buyButton) {
                buyButton.className = buyButton.className.replace(/bg-green-500.*text-white/, 'text-gray-600 dark:text-gray-400');
            }
            if (submitButton) {
                submitButton.className = submitButton.className.replace(/bg-green-600.*disabled:bg-green-300/, 'bg-red-600 hover:bg-red-700 disabled:bg-red-300');
            }
            if (submitButtonText) {
                submitButtonText.textContent = `Sat ${this.instrument.symbol}`;
            }
        }
    },

    setActiveTab(tab) {
        this.activeTab = tab;
        const openTab = document.getElementById('openTab');
        const closedTab = document.getElementById('closedTab');
        const openContent = document.getElementById('openTradesContent');
        const closedContent = document.getElementById('closedTradesContent');

        if (tab === 'open') {
            if (openTab) {
                openTab.className = openTab.className.replace(/text-gray-600.*dark:text-gray-400/, 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-sm');
            }
            if (closedTab) {
                closedTab.className = closedTab.className.replace(/bg-white.*shadow-sm/, 'text-gray-600 dark:text-gray-400');
            }
            if (openContent) openContent.style.display = 'block';
            if (closedContent) closedContent.style.display = 'none';
        } else {
            if (closedTab) {
                closedTab.className = closedTab.className.replace(/text-gray-600.*dark:text-gray-400/, 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-sm');
            }
            if (openTab) {
                openTab.className = openTab.className.replace(/bg-white.*shadow-sm/, 'text-gray-600 dark:text-gray-400');
            }
            if (openContent) openContent.style.display = 'none';
            if (closedContent) closedContent.style.display = 'block';
        }
    },

    submitOrder(event) {
        event.preventDefault();
        
        if (!this.amount || this.amount <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Geçersiz Miktar',
                text: 'Lütfen işlem yapmak için geçerli bir miktar girin.',
                confirmButtonColor: '#3B82F6'
            });
            return false;
        }

        const total = this.formatAmount();
        const units = this.formatUnits();
        const action = this.orderType.toUpperCase();

        Swal.fire({
            title: `Al/Sat Siparişini Onayla`,
            html: `
                <div class="text-left space-y-2">
                    <p><strong>Enstrüman:</strong> ${this.instrument.symbol}</p>
                    <p><strong>İşlem:</strong> ${action}</p>
                    <p><strong>Yatırım Miktarı:</strong> ${total}</p>
                    <p><strong>Birimler:</strong> ${units}</p>
                    <p><strong>Kaldıraç:</strong> 1:100</p>
                    <p><strong>Süre:</strong> 7 Gün</p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: this.orderType === 'Buy' ? '#10B981' : '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: `Evet, ${action}!`,
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.loading = true;

                Swal.fire({
                    title: 'Sipariş İşleniyor...',
                    text: 'Lütfen işleminiz işlenirken bekleyin.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                document.getElementById('orderForm').submit();
            }
        });
        return false;
    },

};

// Global functions
function setOrderType(type) {
    TradingSingle.setOrderType(type);
}

function setActiveTab(tab) {
    TradingSingle.setActiveTab(tab);
}

function setQuickAmount(percentage) {
    TradingSingle.setQuickAmount(percentage);
}

function updateSummary() {
    TradingSingle.updateSummary();
}

function submitOrder(event) {
    return TradingSingle.submitOrder(event);
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    TradingSingle.init();
});
</script>

@endsection
