@extends('layouts.master', ['layoutType' => 'dashboard'])
@section('title', 'İşlem Pazarları')
@section('content')

<div class="w-full max-w-6xl mx-auto px-2 sm:px-3 md:px-4 py-2 sm:py-3 md:py-4" id="tradingMarketsContainer">
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

    <x-danger-alert />
    <x-success-alert />
    <x-notify-alert />

    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">İşlem Pazarları</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Çoklu varlık sınıflarında binlerce işlem enstrümanından seçin</p>
            </div>

            <!-- Search and Stats -->
            <div class="flex items-center gap-4">
                <div class="relative">
                    <input type="text"
                           id="searchInput"
                           placeholder="Enstrüman ara..."
                           class="w-64 pl-10 pr-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 dark:text-white">
                    <x-heroicon name="magnifying-glass" class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" />
                </div>

                <div class="hidden md:flex items-center gap-4 text-sm">
                    <div class="text-center">
                        <div class="text-gray-900 dark:text-white font-semibold" id="totalInstruments">0</div>
                        <div class="text-gray-500 dark:text-gray-400">Enstrümanlar</div>
                    </div>
                    <div class="w-px h-8 bg-gray-300 dark:bg-gray-600"></div>
                    <div class="text-center">
                        <div class="text-green-600 dark:text-green-400 font-semibold">7/24</div>
                        <div class="text-gray-500 dark:text-gray-400">İşlem</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Asset Type Filters -->
    <div class="mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-1.5">
            <div class="flex flex-wrap gap-1">
                <button onclick="setSelectedType('all')"
                        data-filter="all"
                        class="px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center gap-2 bg-blue-500 text-white shadow-md">
                    <x-heroicon name="squares-plus" class="w-4 h-4" />
                    Tüm Pazarlar
                </button>

                <button onclick="setSelectedType('crypto')"
                        data-filter="crypto"
                        class="px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <x-heroicon name="bitcoin" class="w-4 h-4" />
                    Kripto Para
                </button>

                <button onclick="setSelectedType('stock')"
                        data-filter="stock"
                        class="px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <x-heroicon name="arrow-trending-up" class="w-4 h-4" />
                    Hisseler
                </button>

                <button onclick="setSelectedType('forex')"
                        data-filter="forex"
                        class="px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <x-heroicon name="globe" class="w-4 h-4" />
                    Döviz
                </button>

                <button onclick="setSelectedType('commodity')"
                        data-filter="commodity"
                        class="px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <x-heroicon name="bolt" class="w-4 h-4" />
                    Emtialar
                </button>

                <button onclick="setSelectedType('bond')"
                        data-filter="bond"
                        class="px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <x-heroicon name="landmark" class="w-4 h-4" />
                    Tahviller
                </button>
            </div>
        </div>
    </div>

    <!-- Instruments Grid -->
    <div class="space-y-6">
        <!-- Loading State -->
        <div id="loadingState" class="flex items-center justify-center py-12" style="display: none;">
            <div class="flex items-center gap-3">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                <span class="text-gray-600 dark:text-gray-400">Loading instruments...</span>
            </div>
        </div>

        <!-- No Results -->
        <div id="noResultsState" class="text-center py-12" style="display: none;">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-8">
                <x-heroicon name="search-x" class="w-16 h-16 text-gray-400 mx-auto mb-4" />
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No instruments found</h3>
                <p class="text-gray-600 dark:text-gray-400">Try adjusting your search or filter criteria</p>
            </div>
        </div>

        <!-- Instruments List -->
        <div id="instrumentsContainer" class="space-y-6">
            <!-- Instruments will be dynamically generated here -->
        </div>
                <!-- Section Header -->
                <div class="flex items-center gap-3 px-2">
                    <div class="flex items-center gap-2">
                        <template x-if="type === 'crypto'">
                            <x-heroicon name="bitcoin" class="w-5 h-5 text-orange-500" />
                        </template>
                        <template x-if="type === 'stock'">
                            <x-heroicon name="arrow-trending-up" class="w-5 h-5 text-green-500" />
                        </template>
                        <template x-if="type === 'forex'">
                            <x-heroicon name="globe" class="w-5 h-5 text-blue-500" />
                        </template>
                        <template x-if="type === 'commodity'">
                            <x-heroicon name="bolt" class="w-5 h-5 text-yellow-500" />
                        </template>
                        <template x-if="type === 'bond'">
                            <x-heroicon name="landmark" class="w-5 h-5 text-purple-500" />
                        </template>

                        <h2 class="text-xl font-bold text-gray-900 dark:text-white capitalize" x-text="getTypeDisplayName(type)"></h2>
                        <span class="text-sm text-gray-500 dark:text-gray-400" x-text="`(${typeGroup.length} enstrüman)`"></span>
                    </div>
                </div>

                <!-- Instruments Grid -->
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- Table Header -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                        <div class="grid grid-cols-12 gap-4 items-center text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            <div class="col-span-8 md:col-span-3">Varlık</div>
                            <div class="col-span-2 text-right hidden md:block">Fiyat</div>
                            <div class="col-span-2 text-right hidden md:block">24s Değişim</div>
                            <div class="col-span-2 text-right hidden md:block">Hacim</div>
                            <div class="col-span-4 md:col-span-3 text-right">İşlem</div>
                        </div>
                    </div>

                    <!-- Table Body -->
                    <div class="divide-y divide-gray-200 dark:divide-gray-600">
                        <template x-for="instrument in typeGroup" :key="instrument.id">
                            <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                <div class="grid grid-cols-12 gap-4 items-center">
                                    <!-- Asset Info -->
                                    <div class="col-span-8 md:col-span-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center flex-shrink-0">
                                                <template x-if="instrument.logo">
                                                    <img :src="instrument.logo" :alt="instrument.name" class="w-8 h-8 rounded-full object-cover">
                                                </template>
                                                <template x-if="!instrument.logo">
                                                    <span class="text-gray-500 dark:text-gray-400 font-semibold text-sm" x-text="instrument.symbol.substring(0, 2)"></span>
                                                </template>
                                            </div>
                                            <div class="min-w-0">
                                                <div class="font-semibold text-gray-900 dark:text-white truncate" x-text="instrument.name"></div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400" x-text="instrument.symbol"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="col-span-2 text-right hidden md:block">
                                        <div class="font-semibold text-gray-900 dark:text-white" x-text="formatPrice(instrument.price)"></div>
                                    </div>

                                    <!-- 24h Change -->
                                    <div class="col-span-2 text-right hidden md:block">
                                        <div class="flex flex-col items-end gap-1">
                                            <span :class="instrument.percent_change_24h >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'"
                                                  class="font-semibold flex items-center gap-1">
                                                <template x-if="instrument.percent_change_24h >= 0">
                                                    <x-heroicon name="arrow-trending-up" class="w-3 h-3" />
                                                </template>
                                                <template x-if="instrument.percent_change_24h < 0">
                                                    <x-heroicon name="arrow-trending-down" class="w-3 h-3" />
                                                </template>
                                                <span x-text="formatPercentage(instrument.percent_change_24h)"></span>
                                            </span>
                                            <span :class="instrument.change >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'"
                                                  class="text-sm" x-text="formatChange(instrument.change)"></span>
                                        </div>
                                    </div>

                                    <!-- Volume (hidden on mobile) -->
                                    <div class="col-span-2 text-right hidden md:block">
                                        <div class="text-gray-600 dark:text-gray-400" x-text="formatVolume(instrument.volume)"></div>
                                    </div>

                                    <!-- Trade Button -->
                                    <div class="col-span-4 md:col-span-3 text-right">
                                        <a :href="`{{ url('/dashboard/trade') }}/${instrument.id}`"
                                           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200 shadow-sm hover:shadow-md">
                                            <x-heroicon name="arrow-trending-up" class="w-4 h-4" />
                                            <span>İşle</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
// Trading Markets Vanilla JavaScript
const TradingMarkets = {
    instruments: {!! json_encode($instruments ?? []) !!},
    selectedType: 'all',
    searchQuery: '',
    loading: false,

    init() {
        this.setupEventListeners();
        this.updateDisplay();
    },

    setupEventListeners() {
        // Search input
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.searchQuery = e.target.value;
                this.updateDisplay();
            });
        }
    },

    setSelectedType(type) {
        this.selectedType = type;
        this.updateFilterButtons();
        this.updateDisplay();
    },

    updateFilterButtons() {
        document.querySelectorAll('[data-filter]').forEach(btn => {
            const filterType = btn.getAttribute('data-filter');
            if (filterType === this.selectedType) {
                btn.className = btn.className.replace(/text-gray-600.*hover:bg-gray-700/, 'bg-blue-500 text-white shadow-md');
            } else {
                btn.className = btn.className.replace(/bg-blue-500.*shadow-md/, 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700');
            }
        });
    },

    get filteredInstruments() {
        let filtered = this.instruments;

        if (this.searchQuery) {
            const query = this.searchQuery.toLowerCase();
            filtered = filtered.filter(instrument =>
                instrument.name.toLowerCase().includes(query) ||
                instrument.symbol.toLowerCase().includes(query)
            );
        }

        if (this.selectedType !== 'all') {
            filtered = filtered.filter(instrument => instrument.type === this.selectedType);
        }

        return filtered;
    },

    get groupedInstruments() {
        const grouped = {};
        this.filteredInstruments.forEach(instrument => {
            if (!grouped[instrument.type]) {
                grouped[instrument.type] = [];
            }
            grouped[instrument.type].push(instrument);
        });

        Object.keys(grouped).forEach(type => {
            grouped[type].sort((a, b) => (b.volume || 0) - (a.volume || 0));
        });

        return grouped;
    },

    updateDisplay() {
        const totalInstrumentsEl = document.getElementById('totalInstruments');
        const loadingState = document.getElementById('loadingState');
        const noResultsState = document.getElementById('noResultsState');
        const instrumentsContainer = document.getElementById('instrumentsContainer');

        if (totalInstrumentsEl) {
            totalInstrumentsEl.textContent = this.instruments.length;
        }

        if (this.loading) {
            loadingState.style.display = 'flex';
            noResultsState.style.display = 'none';
            instrumentsContainer.innerHTML = '';
            return;
        }

        loadingState.style.display = 'none';

        const filtered = this.filteredInstruments;
        if (filtered.length === 0) {
            noResultsState.style.display = 'block';
            instrumentsContainer.innerHTML = '';
            return;
        }

        noResultsState.style.display = 'none';
        this.renderInstruments();
    },

    renderInstruments() {
        const container = document.getElementById('instrumentsContainer');
        const grouped = this.groupedInstruments;
        let html = '';

        Object.entries(grouped).forEach(([type, instruments]) => {
            if ((this.selectedType === 'all' || this.selectedType === type) && instruments.length > 0) {
                html += this.renderTypeSection(type, instruments);
            }
        });

        container.innerHTML = html;
    },

    renderTypeSection(type, instruments) {
        const typeDisplayNames = {
            'crypto': 'Cryptocurrency',
            'stock': 'Stocks',
            'forex': 'Foreign Exchange',
            'commodity': 'Commodities',
            'bond': 'Bonds'
        };

        const displayName = typeDisplayNames[type] || type;
        const iconMap = {
            'crypto': 'bitcoin',
            'stock': 'trending-up',
            'forex': 'globe',
            'commodity': 'zap',
            'bond': 'landmark'
        };

        let html = `
            <div class="space-y-4">
                <div class="flex items-center gap-3 px-2">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-${type === 'crypto' ? 'orange' : type === 'stock' ? 'green' : type === 'forex' ? 'blue' : type === 'commodity' ? 'yellow' : 'purple'}-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            ${this.getIconPath(iconMap[type] || 'circle')}
                        </svg>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white capitalize">${displayName}</h2>
                        <span class="text-sm text-gray-500 dark:text-gray-400">(${instruments.length} enstrüman)</span>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                        <div class="grid grid-cols-12 gap-4 items-center text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                            <div class="col-span-8 md:col-span-3">Varlık</div>
                            <div class="col-span-2 text-right hidden md:block">Fiyat</div>
                            <div class="col-span-2 text-right hidden md:block">24s Değişim</div>
                            <div class="col-span-2 text-right hidden md:block">Hacim</div>
                            <div class="col-span-4 md:col-span-3 text-right">İşlem</div>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-600">
        `;

        instruments.forEach(instrument => {
            html += this.renderInstrumentRow(instrument);
        });

        html += `
                    </div>
                </div>
            </div>
        `;

        return html;
    },

    renderInstrumentRow(instrument) {
        const changeClass = (instrument.percent_change_24h >= 0) ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400';
        const changeIcon = (instrument.percent_change_24h >= 0) ? 'trending-up' : 'trending-down';
        
        return `
            <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                <div class="grid grid-cols-12 gap-4 items-center">
                    <div class="col-span-8 md:col-span-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center flex-shrink-0">
                                ${instrument.logo ?
                                    `<img src="${instrument.logo}" alt="${instrument.name}" class="w-8 h-8 rounded-full object-cover">` :
                                    `<span class="text-gray-500 dark:text-gray-400 font-semibold text-sm">${instrument.symbol.substring(0, 2)}</span>`
                                }
                            </div>
                            <div class="min-w-0">
                                <div class="font-semibold text-gray-900 dark:text-white truncate">${instrument.name}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">${instrument.symbol}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2 text-right hidden md:block">
                        <div class="font-semibold text-gray-900 dark:text-white">${this.formatPrice(instrument.price)}</div>
                    </div>
                    <div class="col-span-2 text-right hidden md:block">
                        <div class="flex flex-col items-end gap-1">
                            <span class="${changeClass} font-semibold flex items-center gap-1">
                                <x-heroicon name="${changeIcon}" class="w-3 h-3" />
                                <span>${this.formatPercentage(instrument.percent_change_24h)}</span>
                            </span>
                            <span class="${changeClass} text-sm">${this.formatChange(instrument.change)}</span>
                        </div>
                    </div>
                    <div class="col-span-2 text-right hidden md:block">
                        <div class="text-gray-600 dark:text-gray-400">${this.formatVolume(instrument.volume)}</div>
                    </div>
                    <div class="col-span-4 md:col-span-3 text-right">
                        <a href="{{ url('/dashboard/trade') }}/${instrument.id}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200 shadow-sm hover:shadow-md">
                            <x-heroicon name="arrow-trending-up" class="w-4 h-4" />
                            <span>İşle</span>
                        </a>
                    </div>
                </div>
            </div>
        `;
    },

    formatPrice(price) {
        if (!price) return 'N/A';
        const num = parseFloat(price);
        if (num >= 1) {
            return '$' + num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        } else {
            return '$' + num.toFixed(6);
        }
    },

    formatPercentage(percent) {
        if (!percent) return '0.00%';
        const num = parseFloat(percent);
        return (num >= 0 ? '+' : '') + num.toFixed(2) + '%';
    },

    formatChange(change) {
        if (!change) return '$0.00';
        const num = parseFloat(change);
        return (num >= 0 ? '+$' : '-$') + Math.abs(num).toFixed(2);
    },

    formatVolume(volume) {
        if (!volume) return 'N/A';
        const num = parseFloat(volume);
        if (num >= 1e9) {
            return '$' + (num / 1e9).toFixed(1) + 'B';
        } else if (num >= 1e6) {
            return '$' + (num / 1e6).toFixed(1) + 'M';
        } else if (num >= 1e3) {
            return '$' + (num / 1e3).toFixed(1) + 'K';
        }
        return '$' + num.toLocaleString();
    },

    getIconPath(iconName) {
        const iconPaths = {
            'bitcoin': '<path stroke-linecap="round" stroke-linejoin="round" d="M12 1.5c-5.79 0-10.5 4.71-10.5 10.5s4.71 10.5 10.5 10.5 10.5-4.71 10.5-10.5-4.71-10.5-10.5-10.5zM8.5 8.5h2c.55 0 1 .45 1 1s-.45 1-1 1h-2v-2zm0 4h2.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-2.5v-3z"/>',
            'trending-up': '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.94"/>',
            'globe': '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3s-4.5 4.03-4.5 9 2.015 9 4.5 9zm0 0V9m0 12l-8.716-6.747M3.284 14.253L12 9m8.716 5.253L12 9"/>',
            'zap': '<path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
            'landmark': '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21h-7.5M3 9l9-6 9 6m-1 10V10a1 1 0 00-1-1H4a1 1 0 00-1 1v9a1 1 0 001 1h1m0-10V9a1 1 0 011-1h2a1 1 0 011 1v1m-4 0h4m0 0v1m0-1h4m-4 3v.01"/>',
            'circle': '<circle cx="12" cy="12" r="10"/>'
        };
        return iconPaths[iconName] || iconPaths['circle'];
    },

};

// Global functions for onclick handlers
function setSelectedType(type) {
    TradingMarkets.setSelectedType(type);
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    TradingMarkets.init();
});
</script>

@endsection
