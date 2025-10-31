@props([
    'amount',
    'currency' => 'USD',
    'size' => 'default',
    'showSymbol' => true,
    'color' => 'default'
])

@php
    // Format amount with proper decimal places for financial precision
    $formattedAmount = number_format(abs($amount), 2, '.', ',');

    $sizeClasses = [
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'default' => 'text-base',
        'lg' => 'text-lg',
        'xl' => 'text-xl',
        '2xl' => 'text-2xl',
        '3xl' => 'text-3xl'
    ];

    $colorClasses = [
        'default' => 'text-text-primary',
        'success' => 'text-success-600',
        'warning' => 'text-warning-600',
        'error' => 'text-error-600',
        'muted' => 'text-text-muted'
    ];

    $classes = 'font-mono font-semibold ' . ($sizeClasses[$size] ?? $sizeClasses['default']) . ' ' . ($colorClasses[$color] ?? $colorClasses['default']);

    // Currency symbols mapping
    $currencySymbols = [
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'TRY' => '₺',
        'BTC' => '₿',
        'ETH' => 'Ξ'
    ];

    $symbol = $currencySymbols[$currency] ?? $currency;
@endphp

<span class="{{ $classes }}" {{ $attributes }}>
    @if($showSymbol && $symbol)
        <span class="mr-1">{{ $symbol }}</span>
    @endif
    {{ $formattedAmount }}
</span>