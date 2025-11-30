@if ($paginator->hasPages())
<nav role="navigation" aria-label="Sayfalama Navigasyonu" class="flex items-center justify-between">
    <div class="flex justify-between flex-1 sm:hidden">
        {{-- Mobile Pagination --}}
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-admin-500 dark:text-admin-400 bg-white dark:bg-admin-800 border border-admin-300 dark:border-admin-600 cursor-default leading-5 rounded-xl">
                <x-heroicon name="chevron-left" class="w-4 h-4 mr-1" />
                Önceki
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" 
               class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-admin-700 dark:text-admin-300 bg-white dark:bg-admin-800 border border-admin-300 dark:border-admin-600 leading-5 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700 focus:outline-none focus:ring ring-admin-300 focus:border-blue-300 active:bg-admin-100 active:text-admin-700 transition ease-in-out duration-150">
                <x-heroicon name="chevron-left" class="w-4 h-4 mr-1" />
                Önceki
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" 
               class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-admin-700 dark:text-admin-300 bg-white dark:bg-admin-800 border border-admin-300 dark:border-admin-600 leading-5 rounded-xl hover:bg-admin-50 dark:hover:bg-admin-700 focus:outline-none focus:ring ring-admin-300 focus:border-blue-300 active:bg-admin-100 active:text-admin-700 transition ease-in-out duration-150">
                Sonraki
                <x-heroicon name="chevron-right" class="w-4 h-4 ml-1" />
            </a>
        @else
            <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-admin-500 dark:text-admin-400 bg-white dark:bg-admin-800 border border-admin-300 dark:border-admin-600 cursor-default leading-5 rounded-xl">
                Sonraki
                <x-heroicon name="chevron-right" class="w-4 h-4 ml-1" />
            </span>
        @endif
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        {{-- Pagination Info --}}
        <div>
            <p class="text-sm text-admin-700 dark:text-admin-300 leading-5">
                <span class="font-medium">{{ $paginator->firstItem() ?? 0 }}</span>
                -
                <span class="font-medium">{{ $paginator->lastItem() ?? 0 }}</span>
                arası gösteriliyor,
                <span class="font-medium">{{ $paginator->total() }}</span>
                sonuçtan
            </p>
        </div>

        {{-- Desktop Pagination --}}
        <div>
            <span class="relative z-0 inline-flex shadow-sm rounded-xl">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="Önceki Sayfa">
                        <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-admin-500 dark:text-admin-400 bg-white dark:bg-admin-800 border border-admin-300 dark:border-admin-600 cursor-default rounded-l-xl leading-5" 
                              aria-hidden="true">
                            <x-heroicon name="chevron-left" class="w-4 h-4" />
                        </span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" 
                       rel="prev" 
                       class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-admin-500 dark:text-admin-400 bg-white dark:bg-admin-800 border border-admin-300 dark:border-admin-600 rounded-l-xl leading-5 hover:bg-admin-50 dark:hover:bg-admin-700 hover:text-admin-700 dark:hover:text-admin-300 focus:z-10 focus:outline-none focus:ring ring-admin-300 focus:border-blue-300 active:bg-admin-100 active:text-admin-500 transition ease-in-out duration-150" 
                       aria-label="Önceki Sayfa">
                        <x-heroicon name="chevron-left" class="w-4 h-4" />
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span aria-disabled="true">
                            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-admin-700 dark:text-admin-300 bg-white dark:bg-admin-800 border border-admin-300 dark:border-admin-600 cursor-default leading-5">{{ $element }}</span>
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page">
                                    <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-primary-600 border border-primary-600 cursor-default leading-5">{{ $page }}</span>
                                </span>
                            @else
                                <a href="{{ $url }}" 
                                   class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-admin-700 dark:text-admin-300 bg-white dark:bg-admin-800 border border-admin-300 dark:border-admin-600 leading-5 hover:bg-admin-50 dark:hover:bg-admin-700 hover:text-admin-500 dark:hover:text-admin-200 focus:z-10 focus:outline-none focus:ring ring-admin-300 focus:border-blue-300 active:bg-admin-100 active:text-admin-700 transition ease-in-out duration-150" 
                                   aria-label="Sayfa {{ $page }}'e git">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" 
                       rel="next" 
                       class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-admin-500 dark:text-admin-400 bg-white dark:bg-admin-800 border border-admin-300 dark:border-admin-600 rounded-r-xl leading-5 hover:bg-admin-50 dark:hover:bg-admin-700 hover:text-admin-700 dark:hover:text-admin-300 focus:z-10 focus:outline-none focus:ring ring-admin-300 focus:border-blue-300 active:bg-admin-100 active:text-admin-500 transition ease-in-out duration-150" 
                       aria-label="Sonraki Sayfa">
                        <x-heroicon name="chevron-right" class="w-4 h-4" />
                    </a>
                @else
                    <span aria-disabled="true" aria-label="Sonraki Sayfa">
                        <span class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-admin-500 dark:text-admin-400 bg-white dark:bg-admin-800 border border-admin-300 dark:border-admin-600 cursor-default rounded-r-xl leading-5" 
                              aria-hidden="true">
                            <x-heroicon name="chevron-right" class="w-4 h-4" />
                        </span>
                    </span>
                @endif
            </span>
        </div>
    </div>

    {{-- Advanced Pagination Info --}}
    <div class="hidden lg:flex items-center space-x-4 ml-6">
        {{-- Page Size Selector --}}
        @if(request()->routeIs('admin.phrases'))
        <div class="flex items-center space-x-2">
            <label for="pageSizeSelector" class="text-sm text-admin-600 dark:text-admin-400">Sayfa başına:</label>
            <select id="pageSizeSelector" 
                    onchange="changePageSize(this.value)"
                    class="text-sm border-admin-300 dark:border-admin-600 rounded-lg bg-white dark:bg-admin-800 text-admin-900 dark:text-admin-100 focus:ring-primary-500 focus:border-primary-500">
                <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
            </select>
        </div>
        @endif

        {{-- Quick Jump --}}
        @if($paginator->lastPage() > 5)
        <div class="flex items-center space-x-2">
            <label for="pageJumper" class="text-sm text-admin-600 dark:text-admin-400">Sayfaya git:</label>
            <input type="number" 
                   id="pageJumper" 
                   min="1" 
                   max="{{ $paginator->lastPage() }}" 
                   value="{{ $paginator->currentPage() }}"
                   onkeypress="handlePageJump(event, {{ $paginator->lastPage() }})"
                   class="w-16 text-sm border-admin-300 dark:border-admin-600 rounded-lg bg-white dark:bg-admin-800 text-admin-900 dark:text-admin-100 text-center focus:ring-primary-500 focus:border-primary-500">
        </div>
        @endif

        {{-- Page Summary --}}
        <div class="text-sm text-admin-500 dark:text-admin-400">
            Sayfa <span class="font-medium text-admin-700 dark:text-admin-300">{{ $paginator->currentPage() }}</span> 
            / <span class="font-medium text-admin-700 dark:text-admin-300">{{ $paginator->lastPage() }}</span>
        </div>
    </div>
</nav>

<script>
// Page size changer
function changePageSize(perPage) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', perPage);
    url.searchParams.delete('page'); // Reset to first page
    window.location.href = url.toString();
}

// Quick page jumper
function handlePageJump(event, maxPage) {
    if (event.key === 'Enter') {
        const page = parseInt(event.target.value);
        if (page >= 1 && page <= maxPage) {
            const url = new URL(window.location);
            url.searchParams.set('page', page);
            window.location.href = url.toString();
        } else {
            event.target.value = {{ $paginator->currentPage() }};
            alert(`Lütfen 1 ile ${maxPage} arasında bir sayfa numarası girin.`);
        }
    }
}

// Keyboard shortcuts for pagination
document.addEventListener('keydown', function(event) {
    // Only if no input is focused
    if (document.activeElement.tagName !== 'INPUT' && 
        document.activeElement.tagName !== 'TEXTAREA' && 
        document.activeElement.tagName !== 'SELECT') {
        
        // Left arrow or 'p' for previous
        if ((event.key === 'ArrowLeft' || event.key === 'p') && event.ctrlKey) {
            event.preventDefault();
            @if (!$paginator->onFirstPage())
                window.location.href = '{{ $paginator->previousPageUrl() }}';
            @endif
        }
        
        // Right arrow or 'n' for next
        if ((event.key === 'ArrowRight' || event.key === 'n') && event.ctrlKey) {
            event.preventDefault();
            @if ($paginator->hasMorePages())
                window.location.href = '{{ $paginator->nextPageUrl() }}';
            @endif
        }
        
        // Home key for first page
        if (event.key === 'Home' && event.ctrlKey) {
            event.preventDefault();
            @if (!$paginator->onFirstPage())
                const url = new URL(window.location);
                url.searchParams.set('page', 1);
                window.location.href = url.toString();
            @endif
        }
        
        // End key for last page
        if (event.key === 'End' && event.ctrlKey) {
            event.preventDefault();
            @if ($paginator->hasMorePages())
                const url = new URL(window.location);
                url.searchParams.set('page', {{ $paginator->lastPage() }});
                window.location.href = url.toString();
            @endif
        }
    }
});

// Show keyboard shortcuts help on hover
document.addEventListener('DOMContentLoaded', function() {
    const paginationNav = document.querySelector('nav[aria-label="Sayfalama Navigasyonu"]');
    if (paginationNav) {
        paginationNav.title = 'Klavye Kısayolları:\nCtrl+← : Önceki Sayfa\nCtrl+→ : Sonraki Sayfa\nCtrl+Home : İlk Sayfa\nCtrl+End : Son Sayfa';
    }
});
</script>
@endif