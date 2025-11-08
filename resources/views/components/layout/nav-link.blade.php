@props(['active' => false, 'href' => '#'])

@php
$classes = $active ?? false
    ? 'bg-gray-50 text-indigo-700 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold'
    : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold';
@endphp

<li>
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>