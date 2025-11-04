{{-- Master Investment Plan Card Component --}}
@props([
    'plan' => null,
    'type' => 'real_estate', // real_estate, stock, crypto, general
    'selected' => false,
    'index' => 0
])

@php
    $typeColors = [
        'real_estate' => [
            'gradient' => 'from-green-400 via-emerald-500 to-teal-600',
            'accent' => 'green',
            'bg' => 'bg-green-50 dark:bg-green-900/20',
            'border' => 'border-green-200 dark:border-green-800',
            'text' => 'text-green-600 dark:text-green-400',
            'ring' => 'ring-green-500 dark:ring-green-600'
        ],
        'stock' => [
            'gradient' => 'from-blue-500 via-indigo-600 to-purple-700',
            'accent' => 'blue',
            'bg' => 'bg-blue-50 dark:bg-blue-900/20',
            'border' => 'border-blue-200 dark:border-blue-800',
            'text' => 'text-blue-600 dark:text-blue-400',
            'ring' => 'ring-blue-500 dark:ring-blue-600'
        ],
        'crypto' => [
            'gradient' => 'from-orange-500 via-yellow-500 to-red-500',
            'accent' => 'orange',
            'bg' => 'bg-orange-50 dark:bg-orange-900/20',
            'border' => 'border-orange-200 dark:border-orange-800',
            'text' => 'text-orange-600 dark:text-orange-400',
            'ring' => 'ring-orange-500 dark:ring-orange-600'
        ],
        'general' => [
            'gradient' => 'from-gray-500 via-gray-600 to-gray-700',
            'accent' => 'gray',
            'bg' => 'bg-gray-50 dark:bg-gray-900/20',
            'border' => 'border-gray-200 dark:border-gray-800',
            'text' => 'text-gray-600 dark:text-gray-400',
            'ring' => 'ring-gray-500 dark:ring-gray-600'
        ]
    ];

    $colors = $typeColors[$type] ?? $typeColors['general'];
    
    // Default icons for each type
    $typeIcons = [
        'real_estate' => 'home',
        'stock' => 'trending-up',
        'crypto' => 'bitcoin',
        'general' => 'chart-bar'
    ];
    
    $icon = $typeIcons[$type] ?? $typeIcons['general'];
@endphp

@isset($plan)
<div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700 group"
     :class="{'{{ $colors['ring'] }} ring-4': selectedPlan === {{ $index }}}">
    
    {{-- Type Badge --}}
    <div class="absolute top-4 right-4 z-10">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $colors['accent'] }}-100 dark:bg-{{ $colors['accent'] }}-900/30 text-{{ $colors['accent'] }}-800 dark:text-{{ $colors['accent'] }}-300">
            <x-heroicon name="{{ $icon }}" class="w-3 h-3 mr-1" />
            {{ $plan->tag ?? ucfirst($type) }}
        </span>
    </div>

    {{-- Plan Image/Header --}}
    <div class="relative h-48 bg-gradient-to-br {{ $colors['gradient'] }} overflow-hidden">
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white">
                <x-heroicon name="{{ $icon }}" class="w-16 h-16 mx-auto mb-2 opacity-80" />
                <div class="text-sm font-medium opacity-90">
                    {{ $type === 'real_estate' ? 'Real Estate Investment' : 
                       ($type === 'stock' ? 'Stock Market Investment' : 
                       ($type === 'crypto' ? 'Cryptocurrency Investment' : 'Investment Plan')) }}
                </div>
            </div>
        </div>
        {{-- Floating ROI --}}
        <div class="absolute bottom-4 left-4">
            <div class="bg-white bg-opacity-90 dark:bg-gray-800 dark:bg-opacity-90 rounded-lg px-3 py-1">
                <div class="text-lg font-bold {{ $colors['text'] }}">{{ $plan->increment_amount }}%</div>
                <div class="text-xs text-gray-600 dark:text-gray-400">{{ $plan->increment_interval }} ROI</div>
            </div>
        </div>
    </div>

    {{-- Card Content --}}
    <div class="p-6">
        {{-- Plan Header --}}
        <div class="mb-4">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">{{ $plan->name }}</h3>
            <div class="flex items-center justify-between mb-3">
                <div class="text-2xl font-bold {{ $colors['text'] }}">
                    {{ Auth::user()->currency }}{{ number_format($plan->min_price) }}
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">minimum</span>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Duration</div>
                    <div class="font-semibold text-gray-800 dark:text-white">{{ $plan->expiration }} days</div>
                </div>
            </div>
            <div class="h-1 w-full bg-gradient-to-r {{ $colors['gradient'] }} rounded-full"></div>
        </div>

        {{-- Investment Features --}}
        <div class="space-y-3 mb-6">
            {{-- Investment Range --}}
            <div class="flex items-center justify-between py-2 px-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex items-center">
                    <x-heroicon name="currency-dollar" class="w-4 h-4 {{ $colors['text'] }} mr-2" />
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Investment Range</span>
                </div>
                <span class="text-sm font-bold text-gray-900 dark:text-white">
                    {{ Auth::user()->currency }}{{ number_format($plan->min_price) }} - {{ Auth::user()->currency }}{{ number_format($plan->max_price) }}
                </span>
            </div>

            {{-- Return Rate --}}
            <div class="flex items-center justify-between py-2 px-3 {{ $colors['bg'] }} rounded-lg">
                <div class="flex items-center">
                    <x-heroicon name="arrow-trending-up" class="w-4 h-4 {{ $colors['text'] }} mr-2" />
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Return Rate</span>
                </div>
                <span class="text-sm font-bold {{ $colors['text'] }}">
                    {{ $plan->increment_amount }}% {{ $plan->increment_interval }}
                </span>
            </div>

            {{-- Expected Return --}}
            <div class="flex items-center justify-between py-2 px-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <div class="flex items-center">
                    <x-heroicon name="view-finder" class="w-4 h-4 text-blue-600 dark:text-blue-400 mr-2" />
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Expected Return</span>
                </div>
                <span class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ $plan->expected_return }}%</span>
            </div>

            {{-- Bonus Gift --}}
            @if($plan->gift > 0)
            <div class="flex items-center justify-between py-2 px-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                <div class="flex items-center">
                    <x-heroicon name="gift" class="w-4 h-4 text-purple-600 dark:text-purple-400 mr-2" />
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Welcome Bonus</span>
                </div>
                <span class="text-sm font-bold text-purple-600 dark:text-purple-400">
                    {{ Auth::user()->currency }}{{ number_format($plan->gift) }}
                </span>
            </div>
            @endif
        </div>

        {{-- Investment Form --}}
        <form method="post" action="{{ route('joininvestmentplan') }}" class="space-y-4">
            @csrf
            <div x-data="{ amount: '{{ $plan->min_price }}' }">
                {{-- Amount Input --}}
                <div>
                    <label for="amount-{{ $index }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Investment Amount ({{ Auth::user()->currency }})
                    </label>

                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 dark:text-gray-400">{{ Auth::user()->currency }}</span>
                        </span>
                        <input
                            type="number"
                            id="amount-{{ $index }}"
                            name="iamount"
                            min="{{ $plan->min_price }}"
                            max="{{ $plan->max_price }}"
                            x-model="amount"
                            placeholder="Enter amount"
                            class="pl-8 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 py-3 px-4 text-gray-900 dark:text-white shadow-sm focus:border-{{ $colors['accent'] }}-500 focus:ring-2 focus:ring-{{ $colors['accent'] }}-500 dark:focus:ring-{{ $colors['accent'] }}-600 transition-colors duration-200"
                            @click="selectedPlan = {{ $index }}"
                        >
                    </div>

                    {{-- Range Input --}}
                    <div class="mt-3 px-1">
                        <input
                            type="range"
                            min="{{ $plan->min_price }}"
                            max="{{ $plan->max_price }}"
                            x-model="amount"
                            class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-{{ $colors['accent'] }}-600 dark:accent-{{ $colors['accent'] }}-500"
                        >
                        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                            <span>{{ Auth::user()->currency }}{{ number_format($plan->min_price) }}</span>
                            <span>{{ Auth::user()->currency }}{{ number_format($plan->max_price) }}</span>
                        </div>
                    </div>

                    {{-- Profit Calculator --}}
                    <div class="mt-3 p-3 {{ $colors['bg'] }} rounded-lg border {{ $colors['border'] }}">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 dark:text-gray-400">{{ $plan->increment_interval }} Return:</span>
                            <span class="font-medium {{ $colors['text'] }}">
                                {{ Auth::user()->currency }}<span x-text="(amount * {{ $plan->increment_amount }} / 100).toFixed(2)"></span>
                            </span>
                        </div>
                        <div class="flex justify-between items-center text-sm mt-1">
                            <span class="text-gray-600 dark:text-gray-400">Total Return ({{ $plan->expiration }} days):</span>
                            <span class="font-bold {{ $colors['text'] }}">
                                {{ Auth::user()->currency }}<span x-text="(amount * {{ $plan->expected_return }} / 100).toFixed(2)"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="duration" value="{{ $plan->expiration }}">
                <input type="hidden" name="id" value="{{ $plan->id }}">

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full relative py-3 px-6 rounded-lg bg-gradient-to-r {{ $colors['gradient'] }} hover:opacity-90 text-white font-medium shadow-md hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $colors['accent'] }}-500 dark:focus:ring-offset-gray-900 group"
                    @mouseenter="selectedPlan = {{ $index }}"
                >
                    <span class="flex items-center justify-center">
                        <x-heroicon name="invest" class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-200" />
                        Invest in {{ $type === 'real_estate' ? 'Real Estate' : ($type === 'stock' ? 'Stocks' : ($type === 'crypto' ? 'Crypto' : 'Plan')) }}
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endisset

{{-- Plan Card Script --}}
@push('scripts')
<script>
// Initialize Lucide icons for plan cards
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        
    }
});
</script>
@endpush