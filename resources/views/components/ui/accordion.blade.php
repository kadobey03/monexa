@props([
    'items' => [],
    'multiple' => false,
    'defaultOpen' => null
])

@php
    $accordionId = 'accordion-' . uniqid();
@endphp

<div x-data="accordion({ multiple: {{ $multiple ? 'true' : 'false' }}, defaultOpen: '{{ $defaultOpen }}' })" class="space-y-2">
    @foreach($items as $index => $item)
        @php
            $itemId = $accordionId . '-item-' . $index;
            $headerId = $itemId . '-header';
            $panelId = $itemId . '-panel';
        @endphp

        <div class="border border-border rounded-lg">
            <button
                :aria-expanded="openItems.includes('{{ $index }}')"
                @click="toggle('{{ $index }}')"
                :aria-controls="'{{ $panelId }}'"
                id="{{ $headerId }}"
                class="flex items-center justify-between w-full px-4 py-3 text-left bg-surface hover:bg-surface-hover focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-inset"
                type="button"
            >
                <span class="font-medium text-text-primary">
                    {{ $item['title'] }}
                </span>
                <x-ui.icon
                    x-bind:class="openItems.includes('{{ $index }}') ? 'transform rotate-180' : ''"
                    name="chevron-down"
                    class="w-5 h-5 text-text-secondary transition-transform duration-200"
                />
            </button>

            <div
                x-show="openItems.includes('{{ $index }}')"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 max-h-0"
                x-transition:enter-end="opacity-100 max-h-screen"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 max-h-screen"
                x-transition:leave-end="opacity-0 max-h-0"
                id="{{ $panelId }}"
                :aria-labelledby="'{{ $headerId }}'"
                class="overflow-hidden"
                role="region"
            >
                <div class="px-4 py-3 border-t border-border bg-surface-hover">
                    {{ $item['content'] }}
                </div>
            </div>
        </div>
    @endforeach

    <!-- Dynamic content slot -->
    {{ $slot }}
</div>

<script>
function accordion(config = {}) {
    return {
        openItems: config.defaultOpen ? [config.defaultOpen] : [],

        toggle(index) {
            if (this.openItems.includes(index)) {
                this.openItems = this.openItems.filter(item => item !== index);
            } else {
                if (!config.multiple) {
                    this.openItems = [];
                }
                this.openItems.push(index);
            }
        }
    }
}
</script>