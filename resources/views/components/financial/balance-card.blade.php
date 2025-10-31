@props([
    'balance',
    'currency' => 'USD',
    'label' => __('Balance'),
    'trend' => null, // ['up', 'down', null]
    'clickable' => false
])

@php
    $trendIcon = match($trend) {
        'up' => 'arrow-up',
        'down' => 'arrow-down',
        default => null
    };

    $trendColor = match($trend) {
        'up' => 'text-success-600',
        'down' => 'text-error-600',
        default => 'text-text-secondary'
    };

    $containerClasses = 'bg-surface rounded-lg p-6 border border-border hover:shadow-md transition-shadow';
    if ($clickable) {
        $containerClasses .= ' cursor-pointer hover:bg-surface-hover';
    }
@endphp

<div class="{{ $containerClasses }}" {{ $attributes }}>
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-text-secondary">{{ $label }}</p>
            <p class="text-2xl font-bold text-text-primary mt-1">
                <x-financial.amount-display :amount="$balance" :currency="$currency" size="2xl" />
            </p>
        </div>

        @if($trend)
            <div class="flex items-center {{ $trendColor }}">
                @if($trendIcon)
                    <x-ui.icon :name="$trendIcon" class="w-5 h-5 mr-1" />
                @endif
                <span class="text-sm font-medium">
                    @if($trend === 'up')
                        +2.5%
                    @elseif($trend === 'down')
                        -1.2%
                    @endif
                </span>
            </div>
        @endif
    </div>

    @if($trend)
        <div class="mt-4">
            <div class="flex items-center text-xs text-text-muted">
                <span>{{ __('vs last month') }}</span>
            </div>
        </div>
    @endif
</div>