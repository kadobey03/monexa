@props(['id', 'maxWidth'])

@php
    $id = $id ?? md5($attributes->wire('model'));
    
    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ]['2xl'];
@endphp

<div id="{{ $id }}" class="fixed inset-0 z-50 px-4 py-6 overflow-y-auto jetstream-modal sm:px-0 w-100" style="display: none;">
    <div class="fixed inset-0 transition-all transform modal-backdrop" onclick="closeModal('{{ $id }}')">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div class="mb-6 overflow-hidden transition-all transform bg-white rounded-lg shadow-xl sm:w-full w-100 sm:mx-auto modal-content">
        {{ $slot }}
    </div>
</div>

<script>
function showModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'block';
        document.body.classList.add('overflow-y-hidden');
        
        // Handle focus management
        const focusables = modal.querySelectorAll('a, button, input, textarea, select, details, [tabindex]:not([tabindex="-1"])');
        if (focusables.length > 0) {
            focusables[0].focus();
        }
        
        // ESC key handler
        function handleEscape(e) {
            if (e.key === 'Escape') {
                closeModal(id);
                document.removeEventListener('keydown', handleEscape);
            }
        }
        document.addEventListener('keydown', handleEscape);
    }
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'none';
        document.body.classList.remove('overflow-y-hidden');
    }
}

// Wire integration for Livewire
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Livewire !== 'undefined') {
        Livewire.on('showModal', function(id) {
            showModal(id);
        });
        
        Livewire.on('closeModal', function(id) {
            closeModal(id);
        });
    }
});
</script>