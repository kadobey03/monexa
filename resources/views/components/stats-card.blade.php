{{-- Master Statistics Card Component --}}
@props([
    'title' => '',
    'value' => '',
    'icon' => 'chart-bar',
    'color' => 'blue', // blue, green, yellow, red, purple, indigo, gray
    'trend' => null, // 'up', 'down', 'stable'
    'trendValue' => null,
    'description' => null,
    'size' => 'md', // sm, md, lg, xl
    'href' => null
])

@php
    $colorClasses = [
        'blue' => 'text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/30',
        'green' => 'text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/30',
        'yellow' => 'text-yellow-600 dark:text-yellow-400 bg-yellow-100 dark:bg-yellow-900/30',
        'red' => 'text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-900/30',
        'purple' => 'text-purple-600 dark:text-purple-400 bg-purple-100 dark:bg-purple-900/30',
        'indigo' => 'text-indigo-600 dark:text-indigo-400 bg-indigo-100 dark:bg-indigo-900/30',
        'gray' => 'text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800',
        'orange' => 'text-orange-600 dark:text-orange-400 bg-orange-100 dark:bg-orange-900/30',
        'pink' => 'text-pink-600 dark:text-pink-400 bg-pink-100 dark:bg-pink-900/30',
        'teal' => 'text-teal-600 dark:text-teal-400 bg-teal-100 dark:bg-teal-900/30'
    ];

    $sizeClasses = [
        'sm' => 'p-4',
        'md' => 'p-6',
        'lg' => 'p-8',
        'xl' => 'p-10'
    ];

    $iconSizes = [
        'sm' => 'w-5 h-5',
        'md' => 'w-6 h-6',
        'lg' => 'w-8 h-8',
        'xl' => 'w-10 h-10'
    ];

    $textSizes = [
        'sm' => 'text-lg',
        'md' => 'text-3xl',
        'lg' => 'text-4xl',
        'xl' => 'text-5xl'
    ];

    $colorClass = $colorClasses[$color] ?? $colorClasses['blue'];
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    $iconSize = $iconSizes[$size] ?? $iconSizes['md'];
    $textSize = $textSizes[$size] ?? $textSizes['md'];

    $trendIcons = [
        'up' => 'trending-up text-green-500',
        'down' => 'trending-down text-red-500',
        'stable' => 'minus text-gray-500'
    ];
@endphp

<div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm ring-1 ring-gray-200 dark:ring-gray-800 {{ $sizeClass }} transition-all duration-300 hover:shadow-lg hover:ring-gray-300 dark:hover:ring-gray-700">
    
    @if($href)
        <a href="{{ $href }}" class="block">
    @endif
    
    <div class="flex items-center justify-between">
        
        {{-- Content --}}
        <div class="flex-1">
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1 font-medium">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white {{ $textSize }} leading-tight">
                {{ $value }}
            </p>
            
            {{-- Trend --}}
            @if($trend && $trendValue)
                <div class="flex items-center mt-2">
                    <i data-lucide="{{ array_key_exists($trend, $trendIcons) ? $trendIcons[$trend] : 'minus' }}" 
                       class="w-4 h-4 mr-1"></i>
                    <span class="text-sm font-medium {{ 
                        $trend === 'up' ? 'text-green-600 dark:text-green-400' : 
                        ($trend === 'down' ? 'text-red-600 dark:text-red-400' : 'text-gray-500') 
                    }}">
                        {{ $trendValue }}
                    </span>
                </div>
            @endif
            
            {{-- Description --}}
            @if($description)
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $description }}</p>
            @endif
        </div>
        
        {{-- Icon --}}
        <div class="flex-shrink-0 ml-4">
            <div class="p-3 rounded-xl {{ $colorClass }}">
                <i data-lucide="{{ $icon }}" class="{{ $iconSize }}"></i>
            </div>
        </div>
    </div>
    
    @if($href)
        </a>
    @endif
</div>

{{-- Stats Card Script --}}
@push('scripts')
<script>
// Initialize Lucide icons for stats cards
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
@endpush