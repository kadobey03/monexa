@props(['title' => __('Confirm Password'), 'content' => __('For your security, please confirm your password to continue.'), 'button' => __('Confirm')])

@php
    $confirmableId = md5($attributes->wire('then'));
@endphp

<span class="confirmable-action" data-confirmable-id="{{ $confirmableId }}" onclick="startConfirmingPassword('{{ $confirmableId }}')">
    {{ $slot }}
</span>

@once
<x-jet-dialog-modal wire:model="confirmingPassword">
    <x-slot name="title">
       <h4 class="">{{ $title }}</h4> 
    </x-slot>

    <x-slot name="content">
        <p class=""> {{ $content }}</p>
       
        <div class="mt-4 border-none">
            <x-jet-input type="password" class="form-control confirmable-password-input"
                        placeholder="{{ __('Password') }}"
                        wire:model.defer="confirmablePassword"
                        wire:keydown.enter="confirmPassword" />

            <x-jet-input-error for="confirmable_password" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="stopConfirmingPassword" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-jet-secondary-button>

        <x-jet-button class="ml-2" dusk="confirm-password-button" wire:click="confirmPassword" wire:loading.attr="disabled">
            {{ $button }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>

<script>
function startConfirmingPassword(confirmableId) {
    if (typeof Livewire !== 'undefined') {
        Livewire.emit('startConfirmingPassword', confirmableId);
    }
}

// Focus password input when confirming password
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Livewire !== 'undefined') {
        Livewire.on('confirming-password', function() {
            setTimeout(function() {
                const passwordInput = document.querySelector('.confirmable-password-input');
                if (passwordInput) {
                    passwordInput.focus();
                }
            }, 250);
        });
        
        // Handle password confirmed event
        Livewire.on('password-confirmed', function(data) {
            setTimeout(function() {
                if (data.id) {
                    const confirmableElement = document.querySelector(`[data-confirmable-id="${data.id}"]`);
                    if (confirmableElement) {
                        const thenEvent = new CustomEvent('then', { bubbles: false });
                        confirmableElement.dispatchEvent(thenEvent);
                    }
                }
            }, 250);
        });
    }
});
</script>
@endonce