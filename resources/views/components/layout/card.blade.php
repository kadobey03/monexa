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

    $shadowClass = $shadow ? 'shadow-md' : '';
    $borderClass = $bordered ? 'border border-border' : '';
@endphp

<div {{ $attributes->merge([
    'class' => 'bg-surface rounded-lg ' . $shadowClass . ' ' . $borderClass
]) }}>
    @if($title || $subtitle || $headerActions)
        <div class="px-6 py-4 border-b border-border">
            <div class="flex items-center justify-between">
                <div>
                    @if($title)
                        <h3 class="text-lg font-semibold text-text-primary">
                            {{ $title }}
                        </h3>
                    @endif

                    @if($subtitle)
                        <p class="mt-1 text-sm text-text-secondary">
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
        <div class="px-6 py-4 border-t border-border bg-surface-hover">
            {{ $footer }}
        </div>
    @endif
</div>