@props([
    'message',
    'type' => 'info', // 'success', 'error', 'warning', 'info'
    'duration' => 4000,
    'dismissable' => true
])

@php
    $typeClasses = [
        'success' => 'bg-success-50 border-success-200 text-success-800',
        'error' => 'bg-error-50 border-error-200 text-error-800',
        'warning' => 'bg-warning-50 border-warning-200 text-warning-800',
        'info' => 'bg-info-50 border-info-200 text-info-800'
    ];

    $iconMap = [
        'success' => 'check',
        'error' => 'x-mark',
        'warning' => 'exclamation-triangle',
        'info' => 'information-circle'
    ];

    $toastId = 'toast-' . uniqid();
@endphp

@if($message)
    <div
        id="{{ $toastId }}"
        x-data="{ show: true }"
        x-show="show"
        x-init="
            setTimeout(() => {
                show = false;
                setTimeout(() => $el.remove(), 300);
            }, {{ $duration }});
        "
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-2"
        class="max-w-md w-full {{ $typeClasses[$type] ?? $typeClasses['info'] }} border rounded-lg shadow-lg pointer-events-auto p-4"
        role="alert"
    >
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <x-ui.icon :name="$iconMap[$type] ?? 'information-circle'" class="h-6 w-6" />
            </div>

            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium">
                    {{ $message }}
                </p>
            </div>

            @if($dismissable)
                <div class="ml-4 flex-shrink-0 flex">
                    <button
                        @click="show = false; setTimeout(() => $el.remove(), 300);"
                        class="inline-flex rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                        aria-label="{{ __('Dismiss') }}"
                    >
                        <x-ui.icon name="x-mark" class="h-5 w-5" />
                    </button>
                </div>
            @endif
        </div>
    </div>
@endif