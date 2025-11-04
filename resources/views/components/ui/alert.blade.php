@props(['type' => 'info', 'title' => null, 'dismissible' => false])

@php
    $typeClasses = [
        'success' => 'alert-success',
        'warning' => 'alert-warning',
        'danger' => 'alert-danger',
        'error' => 'alert-danger',
        'info' => 'alert-info'
    ];
    
    $iconClasses = [
        'success' => 'text-semantic-success-500',
        'warning' => 'text-semantic-warning-500',
        'danger' => 'text-semantic-danger-500',
        'error' => 'text-semantic-danger-500',
        'info' => 'text-semantic-info-500'
    ];
    
    $icons = [
        'success' => 'check-circle',
        'warning' => 'alert-triangle',
        'danger' => 'alert-circle',
        'error' => 'alert-circle',
        'info' => 'info'
    ];
@endphp

<div class="{{ $typeClasses[$type] ?? $typeClasses['info'] }} animate-fade-in"
     x-data="{ show: true }"
     x-show="show"
     x-transition
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div class="flex">
        <div class="flex-shrink-0">
            <x-heroicon name="{{ $icons[$type] ?? $icons['info'] }}" class="h-5 w-5 {{ $iconClasses[$type] ?? $iconClasses['info'] }}" />
        </div>
        <div class="ml-3 flex-1">
            @if($title)
                <h3 class="text-sm font-medium mb-1">
                    {{ $title }}
                </h3>
            @endif
            <div class="text-sm">
                {{ $slot }}
            </div>
        </div>
        @if($dismissible)
            <div class="ml-auto pl-3">
                <button @click="show = false" class="modal-close">
                    <span class="sr-only">Dismiss</span>
                    <x-heroicon name="x-mark" class="h-4 w-4" />
                </button>
            </div>
        @endif
    </div>
</div>