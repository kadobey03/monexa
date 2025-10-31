@props([
    'title' => null,
    'subtitle' => null,
    'padding' => 'default',
    'shadow' => true,
    'bordered' => false,
    'headerActions' => null,
    'footer' => null
])

@php
    $paddingClasses = [
        'none' => '',
        'sm' => 'p-4',
        'default' => 'p-6',
        'lg' => 'p-8'
    ];

    $shadowClass = $shadow ? 'shadow-sm hover:shadow-md transition-shadow duration-200' : '';
    $borderClass = $bordered ? 'border border-base-gray-200 dark:border-brand-secondary-700' : '';
    
    $cardClasses = 'card ' . ($shadow ? 'card-elevated ' : '') . ($bordered ? 'bordered ' : '');
@endphp

<div {{ $attributes->merge([
    'class' => $cardClasses . $shadowClass . ' ' . $borderClass
]) }}>
    @if($title || $subtitle || $headerActions)
        <div class="card-header">
            <div class="flex items-center justify-between">
                <div>
                    @if($title)
                        <h3 class="text-lg font-semibold text-base-gray-900 dark:text-base-gray-100">
                            {{ $title }}
                        </h3>
                    @endif

                    @if($subtitle)
                        <p class="mt-1 text-sm text-base-gray-600 dark:text-base-gray-400">
                            {{ $subtitle }}
                        </p>
                    @endif
                </div>

                @if($headerActions)
                    <div class="flex items-center space-x-3">
                        {{ $headerActions }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div class="{{ $paddingClasses[$padding] ?? $paddingClasses['default'] }}">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>