@props([
    'name',
    'label' => null,
    'currency' => null,
    'min' => 0,
    'max' => null,
    'required' => false,
    'error' => null,
    'placeholder' => null,
    'disabled' => false,
    'readonly' => false
])

@php
    $inputId = $name . '-' . uniqid();
    $hasError = !empty($error);
@endphp

<div class="space-y-1">
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-text-primary">
            {{ $label }}
            @if($required)
                <span class="text-error-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        @if($currency)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-text-secondary font-mono text-sm">
                    {{ match($currency) {
                        'USD' => '$',
                        'EUR' => '€',
                        'GBP' => '£',
                        'TRY' => '₺',
                        default => $currency
                    } }}
                </span>
            </div>
        @endif

        <input
            id="{{ $inputId }}"
            name="{{ $name }}"
            type="number"
            step="0.01"
            min="{{ $min }}"
            max="{{ $max }}"
            placeholder="{{ $placeholder }}"
            value="{{ old($name) }}"
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            class="block w-full font-mono text-right pr-3 py-2 border rounded-md shadow-sm placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm
                   {{ $hasError ? 'border-error-300 text-error-900 placeholder-error-300 focus:ring-error-500 focus:border-error-500' : 'border-border' }}
                   {{ $currency ? 'pl-8' : 'pl-3' }}
                   {{ $disabled ? 'bg-neutral-50 cursor-not-allowed' : 'bg-white' }}"
            aria-describedby="{{ $hasError ? $inputId . '-error' : null }}"
            aria-invalid="{{ $hasError ? 'true' : 'false' }}"
            {{ $attributes }}
        />
    </div>

    @if($hasError)
        <p id="{{ $inputId }}-error" class="text-sm text-error-600" role="alert">
            {{ $error }}
        </p>
    @endif
</div>