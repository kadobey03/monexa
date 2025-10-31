@props([
    'trigger',
    'align' => 'left',
    'width' => '48'
])

@php
    $alignmentClasses = [
        'left' => 'origin-top-left left-0',
        'right' => 'origin-top-right right-0',
        'top' => 'origin-bottom left-0',
        'bottom' => 'origin-top left-0'
    ];

    $widthClasses = [
        '48' => 'w-48'
    ];

    $dropdownId = 'dropdown-' . uniqid();
@endphp

<div class="relative" x-data="{ open: false }">
    <div @click="open = !open">
        {{ $trigger }}
    </div>

    <!-- Dropdown menu -->
    <div
        x-show="open"
        x-on:click.away="open = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-50 mt-2 {{ $widthClasses[$width] ?? $widthClasses['48'] }} {{ $alignmentClasses[$align] ?? $alignmentClasses['left'] }} rounded-md shadow-lg bg-surface ring-1 ring-black ring-opacity-5 divide-y divide-border"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="{{ $dropdownId }}-button"
        tabindex="-1"
    >
        <div class="py-1" role="none">
            {{ $slot }}
        </div>
    </div>
</div>