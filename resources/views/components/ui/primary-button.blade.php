@props(['variant' => 'primary', 'size' => 'medium', 'disabled' => false, 'type' => 'button'])

@php
    $baseClasses = 'btn';
    
    $sizeClasses = [
        'small' => 'btn-sm',
        'medium' => 'btn-md',
        'large' => 'btn-lg'
    ];
    
    $variantClasses = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'success' => 'btn-success',
        'warning' => 'btn-warning',
        'danger' => 'btn-danger',
        'outline' => 'btn-outline',
        'ghost' => 'btn-ghost'
    ];
    
    $classes = $baseClasses . ' ' . ($sizeClasses[$size] ?? $sizeClasses['medium']) . ' ' . ($variantClasses[$variant] ?? $variantClasses['primary']);
@endphp

<button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>