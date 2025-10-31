@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => null,
    'required' => false,
    'error' => null,
    'disabled' => false,
    'multiple' => false
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
        <select
            id="{{ $inputId }}"
            name="{{ $name }}"
            @if($multiple) multiple @endif
            @if($placeholder && !$multiple) data-placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            @if($disabled) disabled @endif
            class="block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm
                   {{ $hasError ? 'border-error-300 text-error-900' : 'border-border' }}
                   {{ $disabled ? 'bg-neutral-50 cursor-not-allowed' : 'bg-white' }}"
            wire:model="{{ $name }}"
            aria-describedby="{{ $hasError ? $inputId . '-error' : null }}"
            aria-invalid="{{ $hasError ? 'true' : 'false' }}"
            {{ $attributes }}
        >
            @if($placeholder && !$multiple)
                <option value="">{{ $placeholder }}</option>
            @endif

            @foreach($options as $value => $label)
                <option
                    value="{{ $value }}"
                    {{ $selected == $value ? 'selected' : '' }}
                >
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    @if($hasError)
        <p id="{{ $inputId }}-error" class="text-sm text-error-600" role="alert">
            {{ $error }}
        </p>
    @endif
</div>