@props([
    'open' => false,
    'title' => null,
    'description' => null,
    'size' => 'default', // 'sm', 'default', 'lg', 'xl', '2xl'
    'closeable' => true,
    'footer' => null
])

@php
    $sizeClasses = [
        'sm' => 'max-w-md',
        'default' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        '2xl' => 'max-w-6xl'
    ];

    $modalId = 'modal-' . uniqid();
@endphp

@if($open)
    <div
        x-data="{ open: true }"
        x-show="open"
        x-on:keydown.escape.window="open = false"
        x-on:close-modal.window="open = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="{{ $title ? $modalId . '-title' : null }}"
        aria-describedby="{{ $description ? $modalId . '-description' : null }}"
        role="dialog"
        aria-modal="true"
    >
        <!-- Overlay -->
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
            @click="open = false"
        ></div>

        <!-- Modal content -->
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div
                x-show="open"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative w-full {{ $sizeClasses[$size] ?? $sizeClasses['default'] }} transform overflow-hidden rounded-lg bg-surface text-left shadow-xl transition-all"
            >
                <!-- Header -->
                @if($title || $closeable)
                    <div class="flex items-center justify-between px-6 py-4 border-b border-border">
                        @if($title)
                            <h3 id="{{ $modalId }}-title" class="text-lg font-medium text-text-primary">
                                {{ $title }}
                            </h3>
                        @else
                            <div></div>
                        @endif

                        @if($closeable)
                            <button
                                type="button"
                                @click="open = false"
                                class="text-text-secondary hover:text-text-primary focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 rounded-md p-1"
                                aria-label="{{ __('Close modal') }}"
                            >
                                <x-ui.icon name="x-mark" class="w-6 h-6" />
                            </button>
                        @endif
                    </div>
                @endif

                <!-- Description -->
                @if($description)
                    <div class="px-6 py-2">
                        <p id="{{ $modalId }}-description" class="text-sm text-text-secondary">
                            {{ $description }}
                        </p>
                    </div>
                @endif

                <!-- Body -->
                <div class="px-6 py-4">
                    {{ $slot }}
                </div>

                <!-- Footer -->
                @if($footer)
                    <div class="flex items-center justify-end space-x-3 px-6 py-4 border-t border-border bg-surface-hover">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif