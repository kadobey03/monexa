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
    $baseClasses = 'inline-flex items-center justify-center rounded-md font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none';

    $variantClasses = [
        'primary' => 'bg-primary-500 hover:bg-primary-600 text-white focus:ring-primary-500',
        'secondary' => 'bg-neutral-100 hover:bg-neutral-200 text-neutral-900 focus:ring-neutral-500',
        'outline' => 'border border-neutral-300 bg-transparent hover:bg-neutral-50 text-neutral-700 focus:ring-primary-500',
        'ghost' => 'bg-transparent hover:bg-neutral-100 text-neutral-700 focus:ring-neutral-500',
        'success' => 'bg-success-500 hover:bg-success-600 text-white focus:ring-success-500',
        'warning' => 'bg-warning-500 hover:bg-warning-600 text-white focus:ring-warning-500',
        'error' => 'bg-error-500 hover:bg-error-600 text-white focus:ring-error-500',
    ];

    $sizeClasses = [
        'xs' => 'h-8 px-3 text-xs',
        'sm' => 'h-9 px-3 text-sm',
        'default' => 'h-10 px-4 py-2 text-sm',
        'lg' => 'h-11 px-8 text-base',
        'xl' => 'h-12 px-10 text-lg',
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