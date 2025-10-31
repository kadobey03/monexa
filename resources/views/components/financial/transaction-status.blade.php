@props([
    'status',
    'showIcon' => true,
    'size' => 'default'
])

@php
    $statusConfig = [
        'pending' => [
            'label' => __('Pending'),
            'color' => 'warning',
            'icon' => 'clock'
        ],
        'processing' => [
            'label' => __('Processing'),
            'color' => 'info',
            'icon' => 'cog'
        ],
        'completed' => [
            'label' => __('Completed'),
            'color' => 'success',
            'icon' => 'check'
        ],
        'failed' => [
            'label' => __('Failed'),
            'color' => 'error',
            'icon' => 'x-mark'
        ],
        'cancelled' => [
            'label' => __('Cancelled'),
            'color' => 'neutral',
            'icon' => 'x-mark'
        ]
    ];

    $config = $statusConfig[strtolower($status)] ?? $statusConfig['pending'];

    $sizeClasses = [
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'default' => 'text-sm',
        'lg' => 'text-base'
    ];

    $colorClasses = [
        'warning' => 'bg-warning-100 text-warning-800',
        'info' => 'bg-info-100 text-info-800',
        'success' => 'bg-success-100 text-success-800',
        'error' => 'bg-error-100 text-error-800',
        'neutral' => 'bg-neutral-100 text-neutral-800'
    ];

    $classes = 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ' . $colorClasses[$config['color']];
@endphp

@if($config)
    <span class="{{ $classes }}" {{ $attributes }}>
        @if($showIcon && $config['icon'])
            <x-ui.icon :name="$config['icon']" class="w-3 h-3 mr-1" />
        @endif
        {{ $config['label'] }}
    </span>
@else
    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-neutral-100 text-neutral-800">
        {{ $status }}
    </span>
@endif