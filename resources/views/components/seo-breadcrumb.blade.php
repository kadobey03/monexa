{{-- SEO Breadcrumb Component with Structured Data --}}
@php
    $seo = app(\App\Services\SeoService::class);
    $breadcrumbs = $breadcrumbs ?? $seo->generateBreadcrumb($pageType ?? 'homepage', $additionalData ?? []);
@endphp

@if(!empty($breadcrumbs) && count($breadcrumbs) > 1)
    <nav aria-label="breadcrumb" class="bg-gray-50 py-2">
        <div class="container mx-auto px-4">
            <ol class="flex items-center space-x-2 text-sm">
                @foreach($breadcrumbs as $index => $breadcrumb)
                    <li class="flex items-center">
                        @if($index > 0)
                            <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        @endif
                        
                        @if(!$loop->last && !empty($breadcrumb['url']))
                            <a href="{{ $breadcrumb['url'] }}" 
                               class="text-blue-600 hover:text-blue-800 transition-colors">
                                {{ $breadcrumb['name'] }}
                            </a>
                        @else
                            <span class="text-gray-600 font-medium">
                                {{ $breadcrumb['name'] }}
                            </span>
                        @endif
                    </li>
                @endforeach
            </ol>
        </div>
    </nav>

    {{-- BreadcrumbList Structured Data --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            @foreach($breadcrumbs as $index => $breadcrumb)
                {
                    "@type": "ListItem",
                    "position": {{ $index + 1 }},
                    "name": "{{ $breadcrumb['name'] }}",
                    "item": "{{ $breadcrumb['url'] ?? config('app.url') }}"
                }@if(!$loop->last),@endif
            @endforeach
        ]
    }
    </script>
@endif