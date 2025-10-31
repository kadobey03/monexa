@props([
    'fallback' => null,
    'name' => 'error'
])

@php
    $errorMessage = session('errors') ? session('errors')->first($name) : null;
    $hasError = !empty($errorMessage) || $errors->has($name);
@endphp

@if($hasError)
    @if($fallback)
        {{ $fallback }}
    @else
        <div class="rounded-md bg-error-50 p-4" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <x-ui.icon name="x-circle" class="h-5 w-5 text-error-400" />
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-error-800">
                        {{ __('Something went wrong') }}
                    </h3>
                    <div class="mt-2 text-sm text-error-700">
                        <p>{{ $errorMessage ?: $errors->first($name) }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@else
    {{ $slot }}
@endif