@props(['id', 'maxWidth'])

@php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md', 
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth ?? '2xl'];
@endphp

<div id="jet-modal-{{ $id ?? 'default' }}"
     class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 transition-opacity duration-300"
     style="display: none; opacity: 0;"
     data-wire-model="{{ $attributes->wire('model') ?? '' }}">
    
    <div class="fixed inset-0 transform transition-all ease-out duration-300 opacity-0"
         onclick="closeJetModal('{{ $id ?? "default" }}')"
         id="jet-modal-backdrop-{{ $id ?? 'default' }}">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div class="modal-dialog modal-lg relative transition-all ease-out duration-300 opacity-0 transform translate-y-4 sm:translate-y-0 sm:scale-95"
         id="jet-modal-content-{{ $id ?? 'default' }}">
        <div class="modal-content bg-white rounded-lg shadow-xl">
            {{ $slot }}
        </div>
    </div>
</div>

<script>
// Jet Modal Management
window.JetModalManager = window.JetModalManager || {
    modals: {},
    
    // Initialize modal
    init: function(modalId, wireModel = null) {
        if (this.modals[modalId]) return;
        
        this.modals[modalId] = {
            element: document.getElementById('jet-modal-' + modalId),
            backdrop: document.getElementById('jet-modal-backdrop-' + modalId),
            content: document.getElementById('jet-modal-content-' + modalId),
            isOpen: false,
            wireModel: wireModel
        };
        
        // Add escape key listener
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modals[modalId].isOpen) {
                this.close(modalId);
            }
        });
        
        // Add custom close event listener
        document.addEventListener('close-modal-' + modalId, () => {
            this.close(modalId);
        });
        
        console.log('Jet Modal initialized:', modalId);
    },
    
    // Show modal
    show: function(modalId) {
        if (!this.modals[modalId]) {
            this.init(modalId);
        }
        
        const modal = this.modals[modalId];
        if (!modal || modal.isOpen) return;
        
        modal.isOpen = true;
        
        // Show modal
        modal.element.style.display = 'block';
        
        // Trigger animations
        setTimeout(() => {
            modal.element.style.opacity = '1';
            modal.backdrop.classList.remove('opacity-0');
            modal.backdrop.classList.add('opacity-100');
            modal.content.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
            modal.content.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
        }, 10);
        
        // Sync with Livewire if wire model exists
        if (modal.wireModel && typeof Livewire !== 'undefined') {
            try {
                Livewire.emit('modal-opened', modalId);
            } catch (e) {
                console.warn('Livewire sync failed for modal:', modalId);
            }
        }
    },
    
    // Close modal
    close: function(modalId) {
        if (!this.modals[modalId]) return;
        
        const modal = this.modals[modalId];
        if (!modal || !modal.isOpen) return;
        
        modal.isOpen = false;
        
        // Trigger closing animations
        modal.element.style.opacity = '0';
        modal.backdrop.classList.remove('opacity-100');
        modal.backdrop.classList.add('opacity-0');
        modal.content.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
        modal.content.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
        
        // Hide modal after animation
        setTimeout(() => {
            modal.element.style.display = 'none';
        }, 300);
        
        // Sync with Livewire if wire model exists
        if (modal.wireModel && typeof Livewire !== 'undefined') {
            try {
                Livewire.emit('modal-closed', modalId);
            } catch (e) {
                console.warn('Livewire sync failed for modal:', modalId);
            }
        }
        
        // Dispatch close event
        document.dispatchEvent(new CustomEvent('modal-closed', {
            detail: { modalId: modalId }
        }));
    },
    
    // Toggle modal
    toggle: function(modalId) {
        if (!this.modals[modalId]) {
            this.init(modalId);
        }
        
        if (this.modals[modalId].isOpen) {
            this.close(modalId);
        } else {
            this.show(modalId);
        }
    }
};

// Global functions for compatibility
function showJetModal(modalId) {
    window.JetModalManager.show(modalId);
}

function closeJetModal(modalId) {
    window.JetModalManager.close(modalId);
}

function toggleJetModal(modalId) {
    window.JetModalManager.toggle(modalId);
}

// Auto-initialize modal when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const modalId = '{{ $id ?? "default" }}';
    const wireModel = '{{ $attributes->wire("model") ?? "" }}';
    window.JetModalManager.init(modalId, wireModel);
});
</script>