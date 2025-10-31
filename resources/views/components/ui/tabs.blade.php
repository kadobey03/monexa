@props([
    'tabs' => [],
    'active' => null,
    'variant' => 'default' // 'default', 'pills'
])

@php
    $variantClasses = [
        'default' => 'border-b border-border',
        'pills' => 'bg-surface p-1 rounded-lg'
    ];

    $tabBaseClasses = [
        'default' => 'border-b-2 py-2 px-1 text-sm font-medium',
        'pills' => 'py-2 px-3 text-sm font-medium rounded-md'
    ];

    $tabActiveClasses = [
        'default' => 'border-primary-500 text-primary-600',
        'pills' => 'bg-white shadow-sm text-text-primary'
    ];

    $tabInactiveClasses = [
        'default' => 'border-transparent text-text-secondary hover:text-text-primary hover:border-neutral-300',
        'pills' => 'text-text-secondary hover:text-text-primary'
    ];
@endphp

<div x-data="{ activeTab: '{{ $active ?? array_key_first($tabs) }}' }">
    <!-- Tab headers -->
    <div class="{{ $variantClasses[$variant] ?? $variantClasses['default'] }}">
        <nav class="flex space-x-8" aria-label="Tabs">
            @foreach($tabs as $key => $tab)
                <button
                    x-on:click="activeTab = '{{ $key }}'"
                    :class="activeTab === '{{ $key }}'
                        ? '{{ $tabBaseClasses[$variant] }} {{ $tabActiveClasses[$variant] }}'
                        : '{{ $tabBaseClasses[$variant] }} {{ $tabInactiveClasses[$variant] }}'"
                    class="whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                    :aria-current="activeTab === '{{ $key }}' ? 'page' : null"
                    type="button"
                >
                    @if(isset($tab['icon']))
                        <x-ui.icon :name="$tab['icon']" class="w-4 h-4 mr-2" />
                    @endif
                    {{ $tab['label'] }}
                </button>
            @endforeach
        </nav>
    </div>

    <!-- Tab content -->
    <div class="mt-6">
        @foreach($tabs as $key => $tab)
            <div
                x-show="activeTab === '{{ $key }}'"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="space-y-4"
                role="tabpanel"
                :aria-labelledby="'tab-{{ $key }}'"
            >
                {{ $tab['content'] ?? '' }}
            </div>
        @endforeach

        <!-- Dynamic content slot -->
        <div
            x-show="activeTab === 'custom'"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="space-y-4"
        >
            {{ $slot }}
        </div>
    </div>
</div>