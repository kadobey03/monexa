@props([
    'value',
    'label',
    'icon' => null,
    'trend' => null, // ['up', 'down', null]
    'color' => 'primary',
    'href' => null
])

@php
    $colorClasses = [
        'primary' => 'bg-primary-50 text-primary-600',
        'success' => 'bg-success-50 text-success-600',
        'warning' => 'bg-warning-50 text-warning-600',
        'error' => 'bg-error-50 text-error-600',
        'info' => 'bg-info-50 text-info-600',
    ];

    $trendColor = match($trend) {
        'up' => 'text-success-600',
        'down' => 'text-error-600',
        default => 'text-text-secondary'
    };

    $cardClasses = 'bg-surface rounded-lg p-6 border border-border hover:shadow-md transition-all duration-200';
    if ($href) {
        $cardClasses .= ' cursor-pointer hover:bg-surface-hover transform hover:-translate-y-1';
    }
@endphp

@if($href)
    <a href="{{ $href }}" class="{{ $cardClasses }}">
@else
    <div class="{{ $cardClasses }}">
@endif

    <div class="flex items-center">
        @if($icon)
            <div class="flex-shrink-0">
                <div class="flex items-center justify-center w-12 h-12 rounded-md {{ $colorClasses[$color] ?? $colorClasses['primary'] }}">
                    <x-ui.icon :name="$icon" class="w-6 h-6" />
                </div>
            </div>
        @endif

        <div class="flex-1 {{ $icon ? 'ml-4' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-2xl font-bold text-text-primary">
                        @if(is_numeric($value))
                            {{ number_format($value, 0) }}
                        @else
                            {{ $value }}
                        @endif
                    </p>
                    <p class="text-sm font-medium text-text-secondary">
                        {{ $label }}
                    </p>
                </div>

                @if($trend)
                    <div class="flex items-center {{ $trendColor }}">
                        @if($trend === 'up')
                            <x-ui.icon name="arrow-up" class="w-4 h-4 mr-1" />
                        @elseif($trend === 'down')
                            <x-ui.icon name="arrow-down" class="w-4 h-4 mr-1" />
                        @endif
                        <span class="text-sm font-medium">
                            @if($trend === 'up')
                                +12%
                            @elseif($trend === 'down')
                                -5%
                            @endif
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>

@if($href)
    </a>
@else
    </div>
@endif