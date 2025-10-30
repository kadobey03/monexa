@props(['on'])

@php
    $messageId = 'action_message_' . uniqid();
@endphp

<div id="{{ $messageId }}" class="action-message" style="display: none;" {{ $attributes->merge(['class' => 'text-sm text-gray-600']) }}>
    {{ $slot->isEmpty() ? 'Saved.' : $slot }}
</div>

@if($on)
<script>
// Show action message for a specific duration
function showActionMessage(messageId, duration = 2000) {
    const messageElement = document.getElementById(messageId);
    if (messageElement) {
        messageElement.style.display = 'block';
        messageElement.style.opacity = '1';
        
        setTimeout(function() {
            messageElement.style.opacity = '0';
            setTimeout(function() {
                messageElement.style.display = 'none';
                messageElement.style.opacity = '1'; // Reset for next time
            }, 300);
        }, duration);
    }
}

// Listen for Livewire events
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Livewire !== 'undefined') {
        Livewire.on('{{ $on }}', function() {
            showActionMessage('{{ $messageId }}');
        });
    }
});
</script>
@endif