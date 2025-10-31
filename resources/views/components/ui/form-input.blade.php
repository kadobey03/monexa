@props(['label', 'type' => 'text', 'placeholder' => '', 'required' => false, 'error' => null, 'help' => null, 'model' => null])

<div class="form-group">
    @if($label)
        <label for="{{ $attributes->get('id') ?? $attributes->get('wire:model') }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-semantic-danger-500">*</span>
            @endif
        </label>
    @endif
    
    <input
        type="{{ $type }}"
        {{ $attributes->merge([
            'class' => 'form-input' . ($error ? ' border-semantic-danger-500 focus:ring-semantic-danger-500' : '')
        ]) }}
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        @if($model) wire:model="{{ $model }}" @endif
    />
    
    @if($error)
        <p class="form-error">{{ $error }}</p>
    @elseif($help)
        <p class="form-help">{{ $help }}</p>
    @endif
</div>