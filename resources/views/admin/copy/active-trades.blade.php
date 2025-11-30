@extends('layouts.app')
@section('content')

<div class="container-fluid px-6 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <nav class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-2">
                <a href="{{ route('admin.copy.index') }}" class="hover:text-gray-900 dark:hover:text-white">{{ __('admin.copy.copy_trading') }}</a>
                <x-heroicon name="chevron-right" class="w-4 h-4 mx-2" />
                <span class="text-gray-900 dark:text-white">{{ __('admin.copy.active_trades') }}</span>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $title }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">{{ __('admin.copy.monitor_active_positions') }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.copy.statistics') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg font-medium hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                <x-heroicon name="bar-chart-3" class="w-4 h-4" />
               {{ __('admin.copy.statistics') }}
            </a>
            <a href="{{ route('admin.copy.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                <x-heroicon name="arrow-left" class="w-4 h-4" />
                {{ __('admin.copy.back_to_list') }}
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">{{ __('admin.copy.active_positions') }}</p>
                    <p class="text-3xl font-bold">{{ $activeTrades->count() }}</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <x-heroicon name="activity" class="w-6 h-6" />
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">{{ __('admin.copy.total_volume') }}</p>
                    <p class="text-3xl font-bold">${{ number_format($activeTrades->sum('amount'), 0) }}</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <x-heroicon name="currency-dollar" class="w-6 h-6" />
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">{{ __('admin.copy.total_profit') }}</p>
                    <p class="text-3xl font-bold">${{ number_format($activeTrades->sum('profit'), 2) }}</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <x-heroicon name="arrow-trending-up" class="w-6 h-6" />
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">{{ __('admin.copy.avg_profit') }}</p>
                    <p class="text-3xl font-bold">{{ $activeTrades->count() > 0 ? number_format($activeTrades->avg('profit'), 2) : '0.00' }}%</p>
                </div>
                <div class="bg-white/20 rounded-lg p-3">
                    <x-heroicon name="percent" class="w-6 h-6" />
                </div>
            </div>
        </div>
    </div>

    <!-- Active Trades Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('admin.copy.active_copy_trading_positions') }}</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('admin.copy.all_currently_active_positions') }}</p>
        </div>

        @if($activeTrades->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">{{ __('admin.copy.user') }}</th>
                            <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">{{ __('admin.copy.expert') }}</th>
                            <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">{{ __('admin.copy.amount') }}</th>
                            <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">{{ __('admin.copy.profit_loss') }}</th>
                            <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">{{ __('admin.copy.roi') }}</th>
                            <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">{{ __('admin.copy.duration') }}</th>
                            <th class="text-left py-3 px-6 font-semibold text-gray-900 dark:text-white text-sm">{{ __('admin.copy.status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($activeTrades as $trade)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <!-- User -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                            @if($trade->user)
                                                {{ substr($trade->user->name, 0, 1) }}
                                            @else
                                                U
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 dark:text-white">
                                                @if($trade->user)
                                                    {{ $trade->user->name }}
                                                @else
                                                    {{ __('admin.copy.unknown_user') }}
                                                @endif
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                @if($trade->user)
                                                    {{ $trade->user->email }}
                                                @else
                                                    {{ __('admin.copy.no_email') }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Expert -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        @if($trade->expert && $trade->expert->photo)
                                            <img src="{{ asset('storage/' . $trade->expert->photo) }}" 
                                                 class="w-10 h-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600"
                                                 alt="{{ $trade->expert->name }}">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-blue-600 flex items-center justify-center text-white font-bold">
                                                @if($trade->expert)
                                                    {{ substr($trade->expert->name, 0, 1) }}
                                                @else
                                                    E
                                                @endif
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="font-semibold text-gray-900 dark:text-white">
                                                @if($trade->expert)
                                                    {{ $trade->expert->name }}
                                                @else
                                                    {{ __('admin.copy.unknown_expert') }}
                                                @endif
                                            </h3>
                                            <div class="flex items-center gap-1 mt-1">
                                                @if($trade->expert)
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $trade->expert->rating)
                                                            <x-heroicon name="star" class="w-3 h-3 text-yellow-400 fill-current" />
                                                        @else
                                                            <x-heroicon name="star" class="w-3 h-3 text-gray-300 dark:text-gray-600" />
                                                        @endif
                                                    @endfor
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Amount -->
                                <td class="py-4 px-6">
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                        ${{ number_format((float)$trade->amount, 2) }}
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('admin.copy.investment') }}
                                    </div>
                                </td>

                                <!-- Profit/Loss -->
                                <td class="py-4 px-6">
                                    @if($trade->profit > 0)
                                        <div class="text-lg font-semibold text-green-600 dark:text-green-400">
                                            +${{ number_format((float)$trade->profit, 2) }}
                                        </div>
                                        <div class="text-sm text-green-600 dark:text-green-400">
                                            {{ __('admin.copy.profit') }}
                                        </div>
                                    @elseif($trade->profit < 0)
                                        <div class="text-lg font-semibold text-red-600 dark:text-red-400">
                                            -${{ number_format(abs((float)$trade->profit), 2) }}
                                        </div>
                                        <div class="text-sm text-red-600 dark:text-red-400">
                                            {{ __('admin.copy.loss') }}
                                        </div>
                                    @else
                                        <div class="text-lg font-semibold text-gray-600 dark:text-gray-400">
                                            $0.00
                                        </div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ __('admin.copy.break_even') }}
                                        </div>
                                    @endif
                                </td>

                                <!-- ROI -->
                                <td class="py-4 px-6">
                                    @php
                                        $roi = $trade->amount > 0 ? (((float)$trade->profit / (float)$trade->amount) * 100) : 0;
                                    @endphp
                                    @if($roi > 0)
                                        <div class="text-lg font-semibold text-green-600 dark:text-green-400">
                                            +{{ number_format($roi, 2) }}%
                                        </div>
                                    @elseif($roi < 0)
                                        <div class="text-lg font-semibold text-red-600 dark:text-red-400">
                                            {{ number_format($roi, 2) }}%
                                        </div>
                                    @else
                                        <div class="text-lg font-semibold text-gray-600 dark:text-gray-400">
                                            0.00%
                                        </div>
                                    @endif
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('admin.copy.return') }}
                                    </div>
                                </td>

                                <!-- Duration -->
                                <td class="py-4 px-6">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $trade->created_at->diffForHumans() }}
                                    </div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ __('admin.copy.started') }} {{ $trade->created_at->format('M j, Y') }}
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="py-4 px-6">
                                    <div class="flex flex-col gap-2">
                                        <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg text-xs font-medium inline-block">
                                            {{ __('admin.copy.active') }}
                                        </span>
                                        @if($trade->expert && $trade->expert->status === 'active')
                                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg text-xs font-medium inline-block">
                                                {{ __('admin.copy.expert_active') }}
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg text-xs font-medium inline-block">
                                                {{ __('admin.copy.expert_inactive') }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <x-heroicon name="activity" class="w-8 h-8 text-gray-400" />
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ __('admin.copy.no_active_trades') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    {{ __('admin.copy.no_active_positions_message') }}
                </p>
                <a href="{{ route('admin.copy.index') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                    <x-heroicon name="users" class="w-4 h-4" />
                    {{ __('admin.copy.manage_experts') }}
                </a>
            </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
    @parent
    <script>
        // Auto-refresh every 30 seconds
        setInterval(function() {
            if (!document.hidden) {
                location.reload();
            }
        }, 30000);

        document.addEventListener('DOMContentLoaded', function() {
            
        });
    </script>
@endsection
