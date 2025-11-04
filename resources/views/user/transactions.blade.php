@extends('layouts.master', ['layoutType' => 'dashboard'])

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-3 sm:p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-6 sm:mb-10">
            <div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-4 mb-6">
                <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-2xl sm:rounded-3xl bg-gradient-to-br from-blue-500/10 to-indigo-500/10 flex items-center justify-center backdrop-blur-sm">
                    <x-heroicon name="credit-card" class="w-6 h-6 sm:w-8 sm:h-8 text-blue-600 dark:text-blue-400" />
                </div>
                <div class="text-center sm:text-left">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-light text-slate-800 dark:text-white mb-1 sm:mb-2">
                        İşlem Geçmişi
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 font-light text-base sm:text-lg">
                        Tüm finansal faaliyetlerinizi izleyin
                    </p>
                </div>
            </div>
        </div>

        <!-- Modern Glass Card -->
        <div class="bg-gray-900 rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 border border-gray-700 shadow-xl floating-animation">
            <!-- Navigation Tabs -->
            <div class="w-full">
                <!-- Mobile-First Tab Navigation -->
                <div class="flex flex-col sm:flex-row gap-2 p-2 mb-6 sm:mb-8 bg-gray-800 rounded-xl sm:rounded-2xl backdrop-blur-sm">
                    <button id="deposits-tab"
                            class="w-full sm:w-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4 rounded-lg sm:rounded-xl font-medium transition-all duration-300 flex items-center justify-center sm:justify-start space-x-2 sm:space-x-3 transform hover:scale-105 bg-gray-700 text-white shadow-lg">
                        <x-heroicon name="arrow-down-circle" class="w-4 h-4 sm:w-5 sm:h-5" />
                        <span class="text-sm sm:text-base">Yatırımlar</span>
                    </button>
                    <button id="withdrawals-tab"
                            class="w-full sm:w-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4 rounded-lg sm:rounded-xl font-medium transition-all duration-300 flex items-center justify-center sm:justify-start space-x-2 sm:space-x-3 transform hover:scale-105 text-slate-300 hover:text-white hover:bg-gray-700/50">
                        <x-heroicon name="arrow-up-circle" class="w-4 h-4 sm:w-5 sm:h-5" />
                        <span class="text-sm sm:text-base">Çekimler</span>
                    </button>
                    <button id="others-tab"
                            class="w-full sm:w-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4 rounded-lg sm:rounded-xl font-medium transition-all duration-300 flex items-center justify-center sm:justify-start space-x-2 sm:space-x-3 transform hover:scale-105 text-slate-300 hover:text-white hover:bg-gray-700/50">
                        <x-heroicon name="activity" class="w-4 h-4 sm:w-5 sm:h-5" />
                        <span class="text-sm sm:text-base">Diğerleri</span>
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="p-2 sm:p-4 lg:p-6">
                    <!-- Deposits Tab -->
                    <div id="deposits-content" class="tab-content opacity-100 transform translate-y-0 transition-all duration-300">
                        <div class="mb-4 sm:mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 lg:gap-6">
                            <div class="text-center lg:text-left">
                                <h3 class="text-xl sm:text-2xl font-light text-white mb-1 sm:mb-2">Yatırım Geçmişi</h3>
                                <p class="text-slate-400 font-light text-sm sm:text-base">Yatırım işlemlerinizi takip edin</p>
                            </div>
                            <div class="relative">
                                <input type="text" placeholder="Yatırımları ara..." class="w-full lg:w-80 pl-10 sm:pl-12 pr-4 sm:pr-6 py-2 sm:py-3 bg-gray-800 border border-gray-600 rounded-xl sm:rounded-2xl text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-sm sm:text-base">
                                <x-heroicon name="magnifying-glass" class="absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 w-4 h-4 sm:w-5 sm:h-5 text-slate-400" />
                            </div>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="block lg:hidden space-y-4">
                            @if($deposits->count() > 0)
                                @foreach ($deposits as $deposit)
                                <div class="bg-gray-800 rounded-xl p-4 border border-gray-700 hover:border-gray-600 transition-colors duration-300">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500/20 to-green-500/20 flex items-center justify-center">
                                                <x-heroicon name="arrow-down" class="w-5 h-5 text-emerald-500" />
                                            </div>
                                            <div>
                                                <div class="text-white font-medium">{{ Auth::user()->currency }}{{ number_format($deposit->amount, 2) }}</div>
                                                <div class="text-slate-400 text-sm">Yatırım</div>
                                            </div>
                                        </div>
                                        @if ($deposit->status == 'Processed')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-900/30 text-emerald-400">
                                                <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></div>
                                                {{ $deposit->status }}
                                            </span>
                                        @elseif($deposit->status == 'Pending')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-900/30 text-amber-400">
                                                <div class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5"></div>
                                                {{ $deposit->status }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-slate-400">Ödeme Yöntemi</span>
                                        <span class="text-blue-400 bg-blue-900/30 px-2 py-1 rounded-lg">{{ $deposit->payment_mode }}</span>
                                    </div>
                                    <div class="mt-2 text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($deposit->created_at)->format('M d, Y \a\t g:i A') }}
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-12">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-800 mb-4">
                                        <x-heroicon name="arrow-down-circle" class="w-8 h-8 text-slate-400" />
                                    </div>
                                    <h4 class="text-lg font-light text-white mb-2">Henüz yatırım yok</h4>
                                    <p class="text-slate-400 font-light text-sm">Yatırım geçmişiniz burada görünecek</p>
                                </div>
                            @endif
                        </div>

                        <!-- Desktop Table View -->
                        <div class="hidden lg:block overflow-x-auto">
                            @if($deposits->count() > 0)
                                <table class="w-full">
                                    <thead class="bg-gray-800">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Miktar</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Ödeme Yöntemi</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Durum</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Tarih</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-700">
                                        @foreach ($deposits as $deposit)
                                        <tr class="hover:bg-gray-800/50 transition-colors duration-300">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500/20 to-green-500/20 flex items-center justify-center">
                                                        <x-heroicon name="arrow-down" class="w-5 h-5 text-emerald-500" />
                                                    </div>
                                                    <div>
                                                        <div class="text-white font-medium">{{ Auth::user()->currency }}{{ number_format($deposit->amount, 2) }}</div>
                                                        <div class="text-slate-400 text-sm">Yatırım</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-900/30 text-blue-400">
                                                    {{ $deposit->payment_mode }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($deposit->status == 'Processed')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-900/30 text-emerald-400">
                                                        <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></div>
                                                        {{ $deposit->status }}
                                                    </span>
                                                @elseif($deposit->status == 'Pending')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-900/30 text-amber-400">
                                                        <div class="w-2 h-2 bg-amber-500 rounded-full mr-2"></div>
                                                        {{ $deposit->status }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-slate-300 font-light">
                                                {{ \Carbon\Carbon::parse($deposit->created_at)->format('M d, Y \a\t g:i A') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-16">
                                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gray-800 mb-6">
                                        <x-heroicon name="arrow-down-circle" class="w-10 h-10 text-slate-400" />
                                    </div>
                                    <h4 class="text-xl font-light text-white mb-3">Henüz yatırım yok</h4>
                                    <p class="text-slate-400 font-light">Yatırım geçmişiniz burada görünecek</p>
                                </div>
                            @endif
                        </div>

                        <!-- Deposits Pagination -->
                        @if ($deposits->hasPages())
                            <div class="mt-8 border-t border-gray-700 pt-6">
                                <nav class="flex items-center justify-between">
                                    <div class="-mt-px flex w-0 flex-1">
                                        @if ($deposits->onFirstPage())
                                            <span class="inline-flex items-center pt-4 pr-1 text-sm font-medium text-gray-500 cursor-not-allowed">
                                                <svg class="mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0L2.586 11l3.707-3.707a1 1 0 011.414 1.414L5.414 11l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                                Önceki
                                            </span>
                                        @else
                                            <a href="{{ $deposits->previousPageUrl() }}" class="inline-flex items-center pt-4 pr-1 text-sm font-medium text-gray-300 hover:text-blue-400 transition-colors duration-200">
                                                <svg class="mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0L2.586 11l3.707-3.707a1 1 0 011.414 1.414L5.414 11l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                                Önceki
                                            </a>
                                        @endif
                                    </div>

                                    <div class="hidden md:-mt-px md:flex space-x-2">
                                        @foreach ($deposits->getUrlRange(1, $deposits->lastPage()) as $page => $url)
                                            @if ($page == $deposits->currentPage())
                                                <span class="inline-flex items-center px-4 pt-4 text-sm font-medium text-blue-400 border-t-2 border-blue-400">
                                                    {{ $page }}
                                                </span>
                                            @elseif ($page == 1 || $page == $deposits->lastPage() || ($page >= $deposits->currentPage() - 2 && $page <= $deposits->currentPage() + 2))
                                                <a href="{{ $url }}" class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-300 hover:text-blue-400 border-t-2 border-transparent hover:border-blue-300 transition-colors duration-200">
                                                    {{ $page }}
                                                </a>
                                            @elseif ($page == 2 && $deposits->currentPage() > 4)
                                                <span class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500">...</span>
                                            @elseif ($page == $deposits->lastPage() - 1 && $deposits->currentPage() < $deposits->lastPage() - 3)
                                                <span class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500">...</span>
                                            @endif
                                        @endforeach
                                    </div>

                                    <div class="-mt-px flex w-0 flex-1 justify-end">
                                        @if ($deposits->hasMorePages())
                                            <a href="{{ $deposits->nextPageUrl() }}" class="inline-flex items-center pt-4 pl-1 text-sm font-medium text-gray-300 hover:text-blue-400 transition-colors duration-200">
                                                Sonraki
                                                <svg class="ml-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4.707 4.707-4.707 4.707a1 1 0 01-1.414-1.414L15.586 10l-3.293-3.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                        @else
                                            <span class="inline-flex items-center pt-4 pl-1 text-sm font-medium text-gray-500 cursor-not-allowed">
                                                Next
                                                <svg class="ml-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4.707 4.707-4.707 4.707a1 1 0 01-1.414-1.414L15.586 10l-3.293-3.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        @endif
                                    </div>
                                </nav>

                                <!-- Mobile pagination info -->
                                <div class="flex justify-center mt-4 md:hidden">
                                    <div class="flex items-center space-x-4">
                                        <p class="text-sm text-gray-400">
                                            Sayfa {{ $deposits->currentPage() }} / {{ $deposits->lastPage() }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $deposits->total() }} toplam yatırım
                                        </p>
                                    </div>
                                </div>

                                <!-- Desktop pagination info -->
                                <div class="hidden md:flex justify-center mt-4">
                                    <p class="text-sm text-gray-400">
                                        {{ $deposits->firstItem() }}'den {{ $deposits->lastItem() }}'e kadar {{ $deposits->total() }} yatırım gösteriliyor
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Withdrawals Tab -->
                    <div id="withdrawals-content" class="tab-content opacity-0 transform translate-y-4 transition-all duration-300 hidden">
                        <div class="mb-4 sm:mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 lg:gap-6">
                            <div class="text-center lg:text-left">
                                <h3 class="text-xl sm:text-2xl font-light text-white mb-1 sm:mb-2">Çekim Geçmişi</h3>
                                <p class="text-slate-400 font-light text-sm sm:text-base">Çekim işlemlerinizi takip edin</p>
                            </div>
                            <div class="relative">
                                <input type="text" placeholder="Çekimleri ara..." class="w-full lg:w-80 pl-10 sm:pl-12 pr-4 sm:pr-6 py-2 sm:py-3 bg-gray-800 border border-gray-600 rounded-xl sm:rounded-2xl text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-sm sm:text-base">
                                <x-heroicon name="magnifying-glass" class="absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 w-4 h-4 sm:w-5 sm:h-5 text-slate-400" />
                            </div>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="block lg:hidden space-y-4">
                            @if($withdrawals->count() > 0)
                                @foreach ($withdrawals as $withdrawal)
                                <div class="bg-gray-800 rounded-xl p-4 border border-gray-700 hover:border-gray-600 transition-colors duration-300">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500/20 to-pink-500/20 flex items-center justify-center">
                                                <x-heroicon name="arrow-up" class="w-5 h-5 text-red-500" />
                                            </div>
                                            <div>
                                                <div class="text-white font-medium">{{ Auth::user()->currency }}{{ number_format($withdrawal->amount, 2) }}</div>
                                                <div class="text-slate-400 text-sm">Çekim</div>
                                            </div>
                                        </div>
                                        @if ($withdrawal->status == 'Processed')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-900/30 text-emerald-400">
                                                <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></div>
                                                {{ $withdrawal->status }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-900/30 text-red-400">
                                                <div class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></div>
                                                {{ $withdrawal->status }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-slate-400">Toplam Kesilen</span>
                                            <span class="text-white">{{ Auth::user()->currency }}{{ number_format($withdrawal->to_deduct, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-slate-400">Ödeme Yöntemi</span>
                                            <span class="text-blue-400 bg-blue-900/30 px-2 py-1 rounded-lg">{{ $withdrawal->payment_mode }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($withdrawal->created_at)->format('M d, Y \a\t g:i A') }}
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-12">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-800 mb-4">
                                        <x-heroicon name="arrow-up-circle" class="w-8 h-8 text-slate-400" />
                                    </div>
                                    <h4 class="text-lg font-light text-white mb-2">Henüz çekim yok</h4>
                                    <p class="text-slate-400 font-light text-sm">Çekim geçmişiniz burada görünecek</p>
                                </div>
                            @endif
                        </div>

                        <!-- Desktop Table View -->
                        <div class="hidden lg:block overflow-x-auto">
                            @if($withdrawals->count() > 0)
                                <table class="w-full">
                                    <thead class="bg-gray-800">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Talep Edilen Miktar</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Toplam Kesilen</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Ödeme Yöntemi</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Durum</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Tarih</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-700">
                                        @foreach ($withdrawals as $withdrawal)
                                        <tr class="hover:bg-gray-800/50 transition-colors duration-300">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500/20 to-pink-500/20 flex items-center justify-center">
                                                        <x-heroicon name="arrow-up" class="w-5 h-5 text-red-500" />
                                                    </div>
                                                    <div>
                                                        <div class="text-white font-medium">{{ Auth::user()->currency }}{{ number_format($withdrawal->amount, 2) }}</div>
                                                        <div class="text-slate-400 text-sm">Çekim</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-white font-medium">{{ Auth::user()->currency }}{{ number_format($withdrawal->to_deduct, 2) }}</div>
                                                <div class="text-slate-400 text-sm">Ücretler dahil</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-900/30 text-blue-400">
                                                    {{ $withdrawal->payment_mode }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($withdrawal->status == 'Processed')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-900/30 text-emerald-400">
                                                        <div class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></div>
                                                        {{ $withdrawal->status }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-900/30 text-red-400">
                                                        <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                                        {{ $withdrawal->status }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-slate-300 font-light">
                                                {{ \Carbon\Carbon::parse($withdrawal->created_at)->format('M d, Y \a\t g:i A') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-16">
                                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gray-800 mb-6">
                                        <x-heroicon name="arrow-up-circle" class="w-10 h-10 text-slate-400" />
                                    </div>
                                    <h4 class="text-xl font-light text-white mb-3">Henüz çekim yok</h4>
                                    <p class="text-slate-400 font-light">Çekim geçmişiniz burada görünecek</p>
                                </div>
                            @endif
                        </div>

                        <!-- Withdrawals Pagination -->
                        @if ($withdrawals->hasPages())
                            <div class="mt-8 border-t border-gray-700 pt-6">
                                <nav class="flex items-center justify-between">
                                    <div class="-mt-px flex w-0 flex-1">
                                        @if ($withdrawals->onFirstPage())
                                            <span class="inline-flex items-center pt-4 pr-1 text-sm font-medium text-gray-500 cursor-not-allowed">
                                                <svg class="mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0L2.586 11l3.707-3.707a1 1 0 011.414 1.414L5.414 11l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                                Önceki
                                            </span>
                                        @else
                                            <a href="{{ $withdrawals->previousPageUrl() }}" class="inline-flex items-center pt-4 pr-1 text-sm font-medium text-gray-300 hover:text-blue-400 transition-colors duration-200">
                                                <svg class="mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0L2.586 11l3.707-3.707a1 1 0 011.414 1.414L5.414 11l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                                Önceki
                                            </a>
                                        @endif
                                    </div>

                                    <div class="hidden md:-mt-px md:flex space-x-2">
                                        @foreach ($withdrawals->getUrlRange(1, $withdrawals->lastPage()) as $page => $url)
                                            @if ($page == $withdrawals->currentPage())
                                                <span class="inline-flex items-center px-4 pt-4 text-sm font-medium text-blue-400 border-t-2 border-blue-400">
                                                    {{ $page }}
                                                </span>
                                            @elseif ($page == 1 || $page == $withdrawals->lastPage() || ($page >= $withdrawals->currentPage() - 2 && $page <= $withdrawals->currentPage() + 2))
                                                <a href="{{ $url }}" class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-300 hover:text-blue-400 border-t-2 border-transparent hover:border-blue-300 transition-colors duration-200">
                                                    {{ $page }}
                                                </a>
                                            @elseif ($page == 2 && $withdrawals->currentPage() > 4)
                                                <span class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500">...</span>
                                            @elseif ($page == $withdrawals->lastPage() - 1 && $withdrawals->currentPage() < $withdrawals->lastPage() - 3)
                                                <span class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500">...</span>
                                            @endif
                                        @endforeach
                                    </div>

                                    <div class="-mt-px flex w-0 flex-1 justify-end">
                                        @if ($withdrawals->hasMorePages())
                                            <a href="{{ $withdrawals->nextPageUrl() }}" class="inline-flex items-center pt-4 pl-1 text-sm font-medium text-gray-300 hover:text-blue-400 transition-colors duration-200">
                                                Sonraki
                                                <svg class="ml-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4.707 4.707-4.707 4.707a1 1 0 01-1.414-1.414L15.586 10l-3.293-3.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                        @else
                                            <span class="inline-flex items-center pt-4 pl-1 text-sm font-medium text-gray-500 cursor-not-allowed">
                                                Next
                                                <svg class="ml-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4.707 4.707-4.707 4.707a1 1 0 01-1.414-1.414L15.586 10l-3.293-3.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        @endif
                                    </div>
                                </nav>

                                <!-- Mobile pagination info -->
                                <div class="flex justify-center mt-4 md:hidden">
                                    <div class="flex items-center space-x-4">
                                        <p class="text-sm text-gray-400">
                                            Sayfa {{ $withdrawals->currentPage() }} / {{ $withdrawals->lastPage() }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $withdrawals->total() }} toplam çekim
                                        </p>
                                    </div>
                                </div>

                                <!-- Desktop pagination info -->
                                <div class="hidden md:flex justify-center mt-4">
                                    <p class="text-sm text-gray-400">
                                        {{ $withdrawals->firstItem() }}'den {{ $withdrawals->lastItem() }}'e kadar {{ $withdrawals->total() }} çekim gösteriliyor
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Other Transactions Tab -->
                    <div id="others-content" class="tab-content opacity-0 transform translate-y-4 transition-all duration-300 hidden">
                        <div class="mb-4 sm:mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 lg:gap-6">
                            <div class="text-center lg:text-left">
                                <h3 class="text-xl sm:text-2xl font-light text-white mb-1 sm:mb-2">Diğer İşlemler</h3>
                                <p class="text-slate-400 font-light text-sm sm:text-base">Ek işlem geçmişi</p>
                            </div>
                            <div class="relative">
                                <input type="text" placeholder="İşlemleri ara..." class="w-full lg:w-80 pl-10 sm:pl-12 pr-4 sm:pr-6 py-2 sm:py-3 bg-gray-800 border border-gray-600 rounded-xl sm:rounded-2xl text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 text-sm sm:text-base">
                                <x-heroicon name="magnifying-glass" class="absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 w-4 h-4 sm:w-5 sm:h-5 text-slate-400" />
                            </div>
                        </div>

                        <!-- Mobile Card View -->
                        <div class="block lg:hidden space-y-4">
                            @if(isset($t_history) && $t_history->count() > 0)
                                @foreach ($t_history as $history)
                                <div class="bg-gray-800 rounded-xl p-4 border border-gray-700 hover:border-gray-600 transition-colors duration-300">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500/20 to-blue-500/20 flex items-center justify-center">
                                                <x-heroicon name="activity" class="w-5 h-5 text-indigo-500" />
                                            </div>
                                            <div>
                                                <div class="text-white font-medium">{{ $history->type }}</div>
                                                <div class="text-slate-400 text-sm">İşlem</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-white font-medium">
                                                @if(isset($settings))
                                                    {{ $settings->currency }}{{ number_format($history->amount, 2) }}
                                                @else
                                                    ${{ number_format($history->amount, 2) }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-slate-400">Açıklama</span>
                                        <span class="text-slate-300">{{ $history->plan ?? 'N/A' }}</span>
                                    </div>
                                    <div class="mt-2 text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($history->created_at)->format('M d, Y \a\t g:i A') }}
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-12">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-800 mb-4">
                                        <x-heroicon name="activity" class="w-8 h-8 text-slate-400" />
                                    </div>
                                    <h4 class="text-lg font-light text-white mb-2">Diğer işlem yok</h4>
                                    <p class="text-slate-400 font-light text-sm">Ek işlemler burada görünecek</p>
                                </div>
                            @endif
                        </div>

                        <!-- Desktop Table View -->
                        <div class="hidden lg:block overflow-x-auto">
                            @if(isset($t_history) && $t_history->count() > 0)
                                <table class="w-full">
                                    <thead class="bg-gray-800">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Tür</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Miktar</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Açıklama</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Tarih</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-700">
                                        @foreach ($t_history as $history)
                                        <tr class="hover:bg-gray-800/50 transition-colors duration-300">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500/20 to-blue-500/20 flex items-center justify-center">
                                                        <x-heroicon name="activity" class="w-5 h-5 text-indigo-500" />
                                                    </div>
                                                    <div>
                                                        <div class="text-white font-medium">{{ $history->type }}</div>
                                                        <div class="text-slate-400 text-sm">İşlem</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-white font-medium">
                                                    @if(isset($settings))
                                                        {{ $settings->currency }}{{ number_format($history->amount, 2) }}
                                                    @else
                                                        ${{ number_format($history->amount, 2) }}
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="text-slate-300 font-light">{{ $history->plan ?? 'Yok' }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-slate-300 font-light">
                                                {{ \Carbon\Carbon::parse($history->created_at)->format('M d, Y \a\t g:i A') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-16">
                                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gray-800 mb-6">
                                        <x-heroicon name="activity" class="w-10 h-10 text-slate-400" />
                                    </div>
                                    <h4 class="text-xl font-light text-white mb-3">Diğer işlem yok</h4>
                                    <p class="text-slate-400 font-light">Ek işlemler burada görünecek</p>
                                </div>
                            @endif
                        </div>

                        <!-- Other Transactions Pagination -->
                        @if (isset($t_history) && $t_history->hasPages())
                            <div class="mt-8 border-t border-gray-700 pt-6">
                                <nav class="flex items-center justify-between">
                                    <div class="-mt-px flex w-0 flex-1">
                                        @if ($t_history->onFirstPage())
                                            <span class="inline-flex items-center pt-4 pr-1 text-sm font-medium text-gray-500 cursor-not-allowed">
                                                <svg class="mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0L2.586 11l3.707-3.707a1 1 0 011.414 1.414L5.414 11l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                                Önceki
                                            </span>
                                        @else
                                            <a href="{{ $t_history->previousPageUrl() }}" class="inline-flex items-center pt-4 pr-1 text-sm font-medium text-gray-300 hover:text-blue-400 transition-colors duration-200">
                                                <svg class="mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0L2.586 11l3.707-3.707a1 1 0 011.414 1.414L5.414 11l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                                Önceki
                                            </a>
                                        @endif
                                    </div>

                                    <div class="hidden md:-mt-px md:flex space-x-2">
                                        @foreach ($t_history->getUrlRange(1, $t_history->lastPage()) as $page => $url)
                                            @if ($page == $t_history->currentPage())
                                                <span class="inline-flex items-center px-4 pt-4 text-sm font-medium text-blue-400 border-t-2 border-blue-400">
                                                    {{ $page }}
                                                </span>
                                            @elseif ($page == 1 || $page == $t_history->lastPage() || ($page >= $t_history->currentPage() - 2 && $page <= $t_history->currentPage() + 2))
                                                <a href="{{ $url }}" class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-300 hover:text-blue-400 border-t-2 border-transparent hover:border-blue-300 transition-colors duration-200">
                                                    {{ $page }}
                                                </a>
                                            @elseif ($page == 2 && $t_history->currentPage() > 4)
                                                <span class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500">...</span>
                                            @elseif ($page == $t_history->lastPage() - 1 && $t_history->currentPage() < $t_history->lastPage() - 3)
                                                <span class="inline-flex items-center px-4 pt-4 text-sm font-medium text-gray-500">...</span>
                                            @endif
                                        @endforeach
                                    </div>

                                    <div class="-mt-px flex w-0 flex-1 justify-end">
                                        @if ($t_history->hasMorePages())
                                            <a href="{{ $t_history->nextPageUrl() }}" class="inline-flex items-center pt-4 pl-1 text-sm font-medium text-gray-300 hover:text-blue-400 transition-colors duration-200">
                                                Sonraki
                                                <svg class="ml-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4.707 4.707-4.707 4.707a1 1 0 01-1.414-1.414L15.586 10l-3.293-3.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                        @else
                                            <span class="inline-flex items-center pt-4 pl-1 text-sm font-medium text-gray-500 cursor-not-allowed">
                                                Next
                                                <svg class="ml-3 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4.707 4.707-4.707 4.707a1 1 0 01-1.414-1.414L15.586 10l-3.293-3.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                        @endif
                                    </div>
                                </nav>

                                <!-- Mobile pagination info -->
                                <div class="flex justify-center mt-4 md:hidden">
                                    <div class="flex items-center space-x-4">
                                        <p class="text-sm text-gray-400">
                                            Sayfa {{ $t_history->currentPage() }} / {{ $t_history->lastPage() }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $t_history->total() }} toplam işlem
                                        </p>
                                    </div>
                                </div>

                                <!-- Desktop pagination info -->
                                <div class="hidden md:flex justify-center mt-4">
                                    <p class="text-sm text-gray-400">
                                        {{ $t_history->firstItem() }}'den {{ $t_history->lastItem() }}'e kadar {{ $t_history->total() }} işlem gösteriliyor
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Modern Mobile-First Responsive Styles */
    .glass-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 25px 45px rgba(0, 0, 0, 0.15);
    }

    .glass-input {
        background: rgba(31, 41, 55, 0.8);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(75, 85, 99, 0.6);
    }

    .glass-input:focus {
        background: rgba(31, 41, 55, 0.9);
        border-color: rgba(59, 130, 246, 0.8);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Floating Animation - Reduced for mobile */
    .floating-animation {
        animation: floating 8s ease-in-out infinite;
    }

    @keyframes floating {
        0%, 100% { transform: translate(0, 0px); }
        50% { transform: translate(0, -5px); }
    }

    /* Enhanced Mobile Responsiveness */
    @media (max-width: 640px) {
        .floating-animation {
            animation: none; /* Disable animation on mobile for better performance */
        }

        /* Reduce padding on mobile */
        .mobile-padding {
            padding: 0.75rem;
        }

        /* Better touch targets */
        button {
            min-height: 44px;
        }

        /* Improved readability */
        .mobile-text {
            font-size: 0.875rem;
            line-height: 1.5;
        }
    }

    @media (max-width: 768px) {
        /* Stack elements vertically on tablets */
        .tablet-stack {
            flex-direction: column;
            gap: 1rem;
        }

        /* Full width search on mobile */
        .mobile-search {
            width: 100%;
        }
    }

    /* Custom scrollbar for better mobile experience */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: rgba(75, 85, 99, 0.3);
        border-radius: 3px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.5);
        border-radius: 3px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: rgba(156, 163, 175, 0.7);
    }

    /* Enhanced focus states for accessibility */
    button:focus,
    input:focus {
        outline: 2px solid rgba(59, 130, 246, 0.5);
        outline-offset: 2px;
    }

    /* Smooth transitions for better UX */
    * {
        transition: all 0.2s ease-in-out;
    }

    /* Status indicators */
    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Card hover effects */
    .transaction-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .transaction-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Loading states */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    /* Print styles */
    @media print {
        .floating-animation {
            animation: none;
        }

        .glass-card {
            background: white;
            border: 1px solid #e5e7eb;
            box-shadow: none;
        }
    }

    /* High contrast mode support */
    @media (prefers-contrast: high) {
        .glass-card {
            background: #1f2937;
            border: 2px solid #6b7280;
        }

        .text-slate-400 {
            color: #d1d5db;
        }
    }

    /* Reduced motion support */
    @media (prefers-reduced-motion: reduce) {
        .floating-animation,
        .transition-all,
        .transition-colors,
        .transition-transform {
            animation: none;
            transition: none;
        }
    }
</style>

<script>
    // Initialize Lucide icons
    

    // Transaction Tabs Manager
    class TransactionTabsManager {
        constructor() {
            this.activeTab = 'deposits';
            this.tabs = ['deposits', 'withdrawals', 'others'];
            this.init();
        }

        init() {
            // Add event listeners to tab buttons
            this.tabs.forEach(tab => {
                const tabButton = document.getElementById(`${tab}-tab`);
                if (tabButton) {
                    tabButton.addEventListener('click', () => this.switchTab(tab));
                }
            });
        }

        switchTab(tabName) {
            if (this.activeTab === tabName) return;

            const previousTab = this.activeTab;
            this.activeTab = tabName;

            // Update tab button states
            this.updateTabButtons(previousTab, tabName);

            // Switch content with animation
            this.animateTabTransition(previousTab, tabName);
        }

        updateTabButtons(previousTab, activeTab) {
            // Remove active state from previous tab
            if (previousTab) {
                const prevButton = document.getElementById(`${previousTab}-tab`);
                if (prevButton) {
                    prevButton.classList.remove('bg-gray-700', 'text-white', 'shadow-lg');
                    prevButton.classList.add('text-slate-300', 'hover:text-white', 'hover:bg-gray-700/50');
                }
            }

            // Add active state to new tab
            const activeButton = document.getElementById(`${activeTab}-tab`);
            if (activeButton) {
                activeButton.classList.add('bg-gray-700', 'text-white', 'shadow-lg');
                activeButton.classList.remove('text-slate-300', 'hover:text-white', 'hover:bg-gray-700/50');
            }
        }

        animateTabTransition(previousTab, activeTab) {
            const previousContent = document.getElementById(`${previousTab}-content`);
            const activeContent = document.getElementById(`${activeTab}-content`);

            if (!previousContent || !activeContent) return;

            // Hide previous content with animation
            previousContent.classList.add('opacity-0', 'transform', 'translate-y-4');
            
            setTimeout(() => {
                previousContent.classList.add('hidden');
                
                // Show new content
                activeContent.classList.remove('hidden');
                
                // Trigger reflow
                activeContent.offsetHeight;
                
                // Animate in new content
                setTimeout(() => {
                    activeContent.classList.remove('opacity-0', 'translate-y-4');
                    activeContent.classList.add('opacity-100', 'transform', 'translate-y-0');
                }, 10);
            }, 300);
        }

        // Get current active tab
        getActiveTab() {
            return this.activeTab;
        }

        // Programmatically switch to a tab
        goToTab(tabName) {
            if (this.tabs.includes(tabName)) {
                this.switchTab(tabName);
            }
        }
    }

    // Initialize tabs when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        window.transactionTabs = new TransactionTabsManager();
    });

    // Search functionality for each tab
    function initializeSearch() {
        const searchInputs = document.querySelectorAll('input[type="text"]');
        
        searchInputs.forEach(input => {
            if (input.placeholder.includes('ara')) {
                input.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const activeTabContent = document.querySelector(`#${window.transactionTabs.getActiveTab()}-content`);
                    
                    if (activeTabContent) {
                        const cards = activeTabContent.querySelectorAll('.bg-gray-800');
                        const rows = activeTabContent.querySelectorAll('tbody tr');
                        
                        // Search in mobile cards
                        cards.forEach(card => {
                            const text = card.textContent.toLowerCase();
                            card.style.display = text.includes(searchTerm) ? 'block' : 'none';
                        });
                        
                        // Search in desktop table rows
                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.includes(searchTerm) ? 'table-row' : 'none';
                        });
                    }
                });
            }
        });
    }

    // Initialize search when DOM is ready
    document.addEventListener('DOMContentLoaded', initializeSearch);

    // Utility function for formatting numbers
    function formatCurrency(amount, currency = '$') {
        return `${currency}${parseFloat(amount).toLocaleString('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    }

    // Enhanced mobile responsiveness
    function handleMobileLayout() {
        const isMobile = window.innerWidth <= 768;
        const tabContainer = document.querySelector('.flex.flex-col.sm\\:flex-row');
        
        if (tabContainer) {
            if (isMobile) {
                tabContainer.classList.add('space-y-2');
                tabContainer.classList.remove('space-x-2');
            } else {
                tabContainer.classList.remove('space-y-2');
                tabContainer.classList.add('space-x-2');
            }
        }
    }

    // Handle window resize
    window.addEventListener('resize', handleMobileLayout);
    document.addEventListener('DOMContentLoaded', handleMobileLayout);
</script>

@endsection
