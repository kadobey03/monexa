@props([
    'name',
    'size' => 'default',
    'class' => ''
])

@php
    $sizeClasses = [
        'xs' => 'w-3 h-3',
        'sm' => 'w-4 h-4',
        'default' => 'w-5 h-5',
        'lg' => 'w-6 h-6',
        'xl' => 'w-8 h-8',
        '2xl' => 'w-10 h-10'
    ];

    $classes = ($sizeClasses[$size] ?? $sizeClasses['default']) . ' ' . $class;
@endphp

@if($name === 'home')
    <svg class="{{ $classes }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
    </svg>
@elseif($name === 'user')
    <svg class="{{ $classes }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
    </svg>
@elseif($name === 'cog')
    <svg class="{{ $classes }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 1.143c.214.2.441.353.684.45.273.119.585-.04.868-.124l1.216-.456a1.125 1.125 0 011.37.49l1.297 1.143c.214.2.441.353.684.45.273.119.585-.04.868-.124l.216-.081c.425-.16.807-.29 1.144-.39.325-.096.594-.216.81-.336a.75.75 0 01.829 0c.216.12.485.24.81.336.337.1.72.23 1.144.39l.216.081c.424.16.807.29 1.144.39.325.096.594.216.81.336a.75.75 0 01.829 0c.216-.12.485-.24.81-.336.337-.1.72-.23 1.144-.39l-.216-.081c-.424-.16-.807-.29-1.144-.39-.325-.096-.594-.216-.81-.336a.75.75 0 01-.829 0c-.216.12-.485.24-.81.336-.337.1-.72.23-1.144.39l-.216.081c-.424.16-.807.29-1.144.39-.325.096-.594.216-.81.336a.75.75 0 01-.829 0c-.216-.12-.485-.24-.81-.336-.337-.1-.72-.23-1.144-.39l-.216-.081c-.424-.16-.807-.29-1.144-.39-.325-.096-.594-.216-.81-.336a.75.75 0 01-.829 0c-.216.12-.485.24-.81.336-.337.1-.72-.23-1.144-.39l-.216-.081c-.424-.16-.807-.29-1.144-.39-.325-.096-.594-.216-.81-.336a.75.75 0 01-.829 0c-.216.12-.485.24-.81.336-.337.1-.72.23-1.144.39l-.216.081c.424.16.807.29 1.144.39.325.096.594.216.81.336a.75.75 0 01.829 0c.216-.12.485-.24.81-.336.337-.1.72-.23 1.144-.39l.216-.081c.424-.16.807-.29 1.144-.39.325-.096.594.216.81.336a.75.75 0 01.829 0c.216-.12.485-.24.81-.336.337-.1.72-.23 1.144-.39l.216-.081c.424-.16.807.29 1.144.39.325.096.594-.216.81-.336a.75.75 0 01.829 0c.216.12.485.24.81.336.337.1.72-.23 1.144-.39z" />
    </svg>
@elseif($name === 'bars-3')
    <svg class="{{ $classes }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
    </svg>
@elseif($name === 'chevron-down')
    <svg class="{{ $classes }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
    </svg>
@elseif($name === 'check')
    <svg class="{{ $classes }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
    </svg>
@elseif($name === 'x-mark')
    <svg class="{{ $classes }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>
@elseif($name === 'eye')
    <svg class="{{ $classes }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
@elseif($name === 'eye-slash')
    <svg class="{{ $classes }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894l3.65 3.65m-3.65-3.65l-3.65-3.65" />
    </svg>
@else
    <!-- Default fallback icon -->
    <svg class="{{ $classes }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="m9 12 2 2 4-4"></path>
    </svg>
@endif