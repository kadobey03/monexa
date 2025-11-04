{{-- Master Breadcrumb Component --}}
@php
    // Default breadcrumbs can be overridden
    $items = $items ?? [];
    
    // Generate default breadcrumbs based on current route
    $routeName = request()->route()->getName();
    $segments = request()->segments();
    
    if (empty($items) && $routeName) {
        $items = [];
        
        // Home
        $items[] = [
            'label' => 'Home',
            'url' => route('dashboard'),
            'icon' => 'home',
            'active' => false
        ];
        
        // Generate based on route segments
        $currentUrl = '';
        foreach ($segments as $index => $segment) {
            $currentUrl .= '/' . $segment;
            
            // Skip 'user' segment
            if ($segment === 'user') continue;
            
            $label = ucfirst(str_replace('-', ' ', $segment));
            $url = url($currentUrl);
            
            // Map common segments to meaningful labels
            switch ($segment) {
                case 'loans':
                    $label = 'Loan Management';
                    break;
                case 'asset':
                    $label = 'Asset Management';
                    break;
                case 'realestate':
                    $label = 'Real Estate';
                    break;
                case 'stocks':
                    $label = 'Stock Market';
                    break;
                case 'bot':
                    $label = 'Bot Trading';
                    break;
                case 'mplans':
                    $label = 'Investment Plans';
                    break;
                case 'crypto':
                    $label = 'Cryptocurrency';
                    break;
                case 'deposits':
                    $label = 'Deposits';
                    break;
                case 'withdrawals':
                    $label = 'Withdrawals';
                    break;
                case 'profile':
                    $label = 'Profile';
                    break;
                case 'support':
                    $label = 'Support';
                    break;
            }
            
            $items[] = [
                'label' => $label,
                'url' => $url,
                'active' => $index === count($segments) - 1
            ];
        }
    }
@endphp

@if(!empty($items))
<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        @foreach($items as $index => $item)
            <li class="inline-flex items-center {{ $item['active'] ? '' : '' }}">
                @if(!$item['active'])
                    <a href="{{ $item['url'] }}" 
                       class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-colors">
                        @if(isset($item['icon']))
                            <x-heroicon name="{{ $item['icon'] }}" class="w-4 h-4 mr-2" />
                        @endif
                        {{ $item['label'] }}
                    </a>
                @else
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">
                            {{ $item['label'] }}
                        </span>
                    </div>
                @endif
            </li>
            
            @if(!$loop->last)
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
@endif

{{-- Breadcrumb Script --}}
@push('scripts')
<script>
// Initialize Lucide icons for breadcrumb
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        
    }
});
</script>
@endpush