@props([
    'variant' => 'primary',
    'size' => 'default',
    'loading' => false,
    'disabled' => false,
    'icon' => null,
    'iconPosition' => 'left',
    'type' => 'button'
])

@php
    $baseClasses = 'btn';

    $variantClasses = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'outline' => 'btn-outline',
        'ghost' => 'btn-ghost',
        'success' => 'btn-success',
        'warning' => 'btn-warning',
        'danger' => 'btn-danger',
        'error' => 'btn-danger',
    ];

    $sizeClasses = [
            'xs' => 'btn-sm',
            'sm' => 'btn-sm',
            'default' => 'btn-md',
            'lg' => 'btn-lg',
            'xl' => 'btn-xl',
        ];
    
        $classes = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['primary']) . ' ' . ($sizeClasses[$size] ?? $sizeClasses['default']);

    if ($loading || $disabled) {
        $classes .= ' cursor-not-allowed';
    } else {
        $classes .= ' cursor-pointer';
    }
@endphp

<button
    {{ $attributes->merge(['class' => $classes, 'type' => $type]) }}
    @if($loading) disabled @endif
    @if($disabled) disabled @endif
>
    @if($loading)
        <x-ui.spinner class="w-4 h-4 mr-2" />
    @elseif($icon && $iconPosition === 'left')
        <x-ui.icon :name="$icon" class="w-4 h-4 mr-2" />
    @endif

    <span>{{ $slot }}</span>

    @if($icon && $iconPosition === 'right' && !$loading)
        <x-ui.icon :name="$icon" class="w-4 h-4 ml-2" />
    @endif
</button>