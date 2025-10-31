@props([
    'type' => 'info', // 'success', 'error', 'warning', 'info'
    'title' => null,
    'dismissable' => false
])

@php
    $typeClasses = [
        'success' => 'bg-success-50 border-success-200 text-success-800',
        'error' => 'bg-error-50 border-error-200 text-error-800',
        'warning' => 'bg-warning-50 border-warning-200 text-warning-800',
        'info' => 'bg-info-50 border-info-200 text-info-800'
    ];

    $iconMap = [
        'success' => 'check-circle',
        'error' => 'exclamation-circle',
        'warning' => 'exclamation-triangle',
        'info' => 'information-circle'
    ];
@endphp

<div {{ $attributes->merge([
    'class' => 'rounded-lg p-4 border ' . ($typeClasses[$type] ?? $typeClasses['info']),
    'role' => 'alert'
]) }}>
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <x-ui.icon :name="$iconMap[$type] ?? 'information-circle'" class="h-5 w-5" />
        </div>

        <div class="ml-3 flex-1">
            @if($title)
                <h3 class="text-sm font-medium">
                    {{ $title }}
                </h3>
            @endif

            <div class="text-sm mt-1">
                {{ $slot }}
            </div>
        </div>

        @if($dismissable)
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button
                        type="button"
                        class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-transparent focus:ring-primary-500 hover:bg-transparent"
                        onclick="this.closest('[role=alert]').remove()"
                        aria-label="{{ __('Dismiss') }}"
                    >
                        <x-ui.icon name="x-mark" class="h-5 w-5" />
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>