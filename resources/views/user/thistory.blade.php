@extends('layouts.dasht')
@section('title', $title)
@section('content')

<div class="min-h-screen bg-white dark:bg-gray-900">
    <!-- Simple Header -->
    <div class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="text-center">
                <h1 class="text-2xl font-medium text-gray-900 dark:text-white">İşlem Geçmişi</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">İşlem aktivitelerinizi takip edin</p>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <div class="max-w-7xl mx-auto px-6 py-4">
        <x-danger-alert />
        <x-success-alert />
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Trading History Card -->
        <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-800">
            <!-- Header -->
            <div class="p-6 border-b border-gray-100 dark:border-gray-800" id="trading-header">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-1">İşlem Genel Bakışı</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">İşlem performansınızı takip edin</p>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="text-center">
                             <div class="text-xl font-medium text-gray-900 dark:text-white" id="stat-total">{{ isset($t_history) ? $t_history->total() : 0 }}</div>
                             <div class="text-xs text-gray-500 dark:text-gray-400">Toplam</div>
                         </div>
                         <div class="text-center">
                             <div class="text-xl font-medium text-green-600 dark:text-green-400" id="stat-wins">{{ isset($t_history) ? $t_history->where('type', 'WIN')->count() : 0 }}</div>
                             <div class="text-xs text-gray-500 dark:text-gray-400">Kazanç</div>
                         </div>
                         <div class="text-center">
                             <div class="text-xl font-medium text-red-600 dark:text-red-400" id="stat-losses">{{ isset($t_history) ? $t_history->where('type', 'LOSE')->count() : 0 }}</div>
                             <div class="text-xs text-gray-500 dark:text-gray-400">Kayıp</div>
                         </div>
                         <div class="text-center">
                             <div class="text-xl font-medium text-blue-600 dark:text-blue-400" id="stat-trades">{{ isset($t_history) ? $t_history->whereIn('type', ['Buy', 'Sell'])->count() : 0 }}</div>
                             <div class="text-xs text-gray-500 dark:text-gray-400">Aktif</div>
                         </div>
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-2 mt-4">
                    <button onclick="setTradeFilter('all')" id="filter-all"
                             class="px-3 py-2 rounded-lg text-sm font-medium transition-colors bg-blue-600 text-white">
                         Tümü
                     </button>
                     <button onclick="setTradeFilter('WIN')" id="filter-WIN"
                             class="px-3 py-2 rounded-lg text-sm font-medium transition-colors bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
                         Kazançlar
                     </button>
                     <button onclick="setTradeFilter('LOSE')" id="filter-LOSE"
                             class="px-3 py-2 rounded-lg text-sm font-medium transition-colors bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
                         Kayıplar
                     </button>
                     <button onclick="setTradeFilter('Buy')" id="filter-Buy"
                             class="px-3 py-2 rounded-lg text-sm font-medium transition-colors bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
                         Alış
                     </button>
                     <button onclick="setTradeFilter('Sell')" id="filter-Sell"
                             class="px-3 py-2 rounded-lg text-sm font-medium transition-colors bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
                         Satış
                     </button>
                </div>
            </div>

            <!-- Trading History List -->
            <div class="p-6">
                <div class="space-y-3" id="trading-history">
                    @if(isset($t_history) && $t_history->count() > 0)
                        @foreach($t_history as $history)
                            <div class="trading-item bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-100 dark:border-gray-700"
                                 data-type="{{ $history->type }}">

                                <div class="flex items-center justify-between">
                                    <!-- Trade Details -->
                                    <div class="flex items-center gap-3">
                                        <!-- Icon -->
                                        <div class="flex-shrink-0">
                                            @if($history->type == 'LOSE')
                                                <div class="w-8 h-8 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @elseif($history->type == 'WIN')
                                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @elseif($history->type == 'Buy')
                                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                                        <path fill-rule="evenodd" d="M9 3a1 1 0 012 0v8.586l2.293-2.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 11.586V3z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="17 10a1 1 0 01-1 1H4a1 1 0 110-2h12a1 1 0 011 1z" clip-rule="evenodd"></path>
                                                        <path fill-rule="evenodd" d="M11 17a1 1 0 01-2 0V8.414L6.707 10.707a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 8.414V17z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Trade Info -->
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center gap-2">
                                                <h3 class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                    {{ $history->plan }}
                                                </h3>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                    @if($history->type == 'LOSE') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                                    @elseif($history->type == 'WIN') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                                    @elseif($history->type == 'Buy') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                                    @else bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400 @endif">
                                                    {{ $history->type }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $history->created_at->format('M d, Y • g:i A') }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Amount and Monitor -->
                                    <div class="text-right flex items-center gap-2">
                                        <div class="flex-1">
                                            @if($history->type == 'LOSE')
                                                <div class="text-sm font-medium text-red-600 dark:text-red-400">
                                                    -{{ Auth::user()->currency }} {{ number_format($history->amount, 2) }}
                                                </div>
                                            @elseif($history->type == 'WIN')
                                                <div class="text-sm font-medium text-green-600 dark:text-green-400">
                                                    +{{ Auth::user()->currency }} {{ number_format($history->amount, 2) }}
                                                </div>
                                            @else
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ Auth::user()->currency }} {{ number_format($history->amount, 2) }}
                                                </div>
                                            @endif
                                            @if($history->leverage)
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    1:{{ $history->leverage }}
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Individual Monitor Button -->
                                        @php
                                            $planId = DB::table('user_plans')
                                                ->where('user', auth()->id())
                                                ->where('assets', $history->plan)
                                                ->first()?->id ?? $history->plan;
                                        @endphp
                                        <a href="/dashboard/trade/monitor/{{ $planId }}"
                                           class="inline-flex items-center gap-1 px-2 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded text-xs font-medium transition-colors">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                            </svg>
                                            Monitör
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">İşlem geçmişi yok</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                                İşlem aktiviteleriniz burada görünecek
                            </p>
                            <a href="{{ route('dashboard') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Ana Sayfaya Dön
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Modern Pagination -->
                @if(isset($t_history) && $t_history->hasPages())
                    <div class="mt-8 px-6 py-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <!-- Pagination Info -->
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>Showing</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $t_history->firstItem() ?? 0 }}</span>
                                <span>to</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $t_history->lastItem() ?? 0 }}</span>
                                <span>of</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $t_history->total() }}</span>
                                <span>işlem</span>
                            </div>

                            <!-- Pagination Controls -->
                            <div class="flex items-center gap-1">
                                <!-- Previous Button -->
                                @if ($t_history->onFirstPage())
                                    <div class="px-3 py-2 text-gray-400 dark:text-gray-600 cursor-not-allowed rounded-lg">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </div>
                                @else
                                    <a href="{{ $t_history->previousPageUrl() }}"
                                       class="px-3 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-white dark:hover:bg-gray-700 rounded-lg transition-all duration-200 flex items-center gap-1 group">
                                        <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                        <span class="hidden sm:inline">Önceki</span>
                                    </a>
                                @endif

                                <!-- Page Numbers -->
                                <div class="flex items-center gap-1 mx-2">
                                    @php
                                        $start = max(1, $t_history->currentPage() - 2);
                                        $end = min($t_history->lastPage(), $t_history->currentPage() + 2);
                                    @endphp

                                    @if ($start > 1)
                                        <a href="{{ $t_history->url(1) }}"
                                           class="px-3 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-white dark:hover:bg-gray-700 rounded-lg transition-all duration-200 text-sm font-medium">
                                            1
                                        </a>
                                        @if ($start > 2)
                                            <span class="px-2 text-gray-400 dark:text-gray-600 text-sm">...</span>
                                        @endif
                                    @endif

                                    @for ($page = $start; $page <= $end; $page++)
                                        @if ($page == $t_history->currentPage())
                                            <div class="px-3 py-2 bg-blue-600 text-white rounded-lg shadow-md font-medium text-sm relative overflow-hidden">
                                                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-700"></div>
                                                <span class="relative">{{ $page }}</span>
                                            </div>
                                        @else
                                            <a href="{{ $t_history->url($page) }}"
                                               class="px-3 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-white dark:hover:bg-gray-700 rounded-lg transition-all duration-200 text-sm font-medium">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endfor

                                    @if ($end < $t_history->lastPage())
                                        @if ($end < $t_history->lastPage() - 1)
                                            <span class="px-2 text-gray-400 dark:text-gray-600 text-sm">...</span>
                                        @endif
                                        <a href="{{ $t_history->url($t_history->lastPage()) }}"
                                           class="px-3 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-white dark:hover:bg-gray-700 rounded-lg transition-all duration-200 text-sm font-medium">
                                            {{ $t_history->lastPage() }}
                                        </a>
                                    @endif
                                </div>

                                <!-- Next Button -->
                                @if ($t_history->hasMorePages())
                                    <a href="{{ $t_history->nextPageUrl() }}"
                                       class="px-3 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-white dark:hover:bg-gray-700 rounded-lg transition-all duration-200 flex items-center gap-1 group">
                                        <span class="hidden sm:inline">Sonraki</span>
                                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @else
                                    <div class="px-3 py-2 text-gray-400 dark:text-gray-600 cursor-not-allowed rounded-lg">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Mobile Page Selector -->
                            <div class="sm:hidden w-full">
                                <div class="flex items-center gap-2">
                                    <label class="text-sm text-gray-600 dark:text-gray-400">Sayfaya git:</label>
                                    <select onchange="window.location.href = this.value"
                                            class="flex-1 px-3 py-2 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                                        @for ($page = 1; $page <= $t_history->lastPage(); $page++)
                                            <option value="{{ $t_history->url($page) }}"
                                                    {{ $page == $t_history->currentPage() ? 'selected' : '' }}>
                                                {{ $t_history->lastPage() }} sayfanın {{ $page }}. sayfası
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Metrics -->
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                <div class="flex items-center gap-1">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                    <span>Sayfa başına {{ $t_history->perPage() }} öğe</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span>{{ $t_history->lastPage() }} sayfanın {{ $t_history->currentPage() }}. sayfası</span>
                                </div>
                                @if($t_history->hasMorePages())
                                    <div class="flex items-center gap-1">
                                        <div class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></div>
                                        <span>{{ $t_history->total() - $t_history->lastItem() }} daha fazla öğe</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentFilter = 'all';

function setTradeFilter(filterValue) {
    currentFilter = filterValue;
    
    // Update button styles
    const buttons = ['all', 'WIN', 'LOSE', 'Buy', 'Sell'];
    buttons.forEach(button => {
        const btnElement = document.getElementById('filter-' + button);
        if (button === filterValue) {
            // Active button styles
            btnElement.className = 'px-3 py-2 rounded-lg text-sm font-medium transition-colors';
            if (button === 'all') {
                btnElement.className += ' bg-blue-600 text-white';
            } else if (button === 'WIN') {
                btnElement.className += ' bg-green-600 text-white';
            } else if (button === 'LOSE') {
                btnElement.className += ' bg-red-600 text-white';
            } else if (button === 'Buy') {
                btnElement.className += ' bg-blue-600 text-white';
            } else if (button === 'Sell') {
                btnElement.className += ' bg-orange-600 text-white';
            }
        } else {
            // Inactive button styles
            btnElement.className = 'px-3 py-2 rounded-lg text-sm font-medium transition-colors bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400';
        }
    });
    
    // Filter trading items
    const tradingItems = document.querySelectorAll('.trading-item');
    tradingItems.forEach(item => {
        const itemType = item.getAttribute('data-type');
        if (filterValue === 'all' || itemType === filterValue) {
            item.style.display = 'block';
            // Add fade in animation
            item.style.opacity = '0';
            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transition = 'opacity 0.3s ease-in-out';
            }, 50);
        } else {
            item.style.display = 'none';
        }
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    setTradeFilter('all');
});
</script>
@endpush

@endsection