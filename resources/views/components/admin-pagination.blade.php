@props(['paginator', 'elements' => null])

@php
    $isDark = Auth('admin')->User()->dashboard_style !== 'light';
    // Generate elements for pagination if not provided
    $elements = $elements ?? [$paginator->getUrlRange(1, $paginator->lastPage())];
@endphp

@if ($paginator->hasPages())
    <div class="bg-admin-50 {{ $isDark ? 'dark:bg-admin-800' : '' }} px-6 py-4 border-t border-admin-200 {{ $isDark ? 'dark:border-admin-700' : '' }} rounded-b-lg">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
            <!-- Results Info -->
            <div class="text-sm text-admin-600 {{ $isDark ? 'dark:text-admin-300' : '' }}">
                <span class="font-medium">{{ $paginator->firstItem() ?? 0 }}</span>
                -
                <span class="font-medium">{{ $paginator->lastItem() ?? 0 }}</span>
                arası,
                <span class="font-semibold text-admin-700 {{ $isDark ? 'dark:text-admin-200' : '' }}">{{ $paginator->total() }}</span>
                toplam kayıt
            </div>

            <!-- Navigation -->
            <div class="flex items-center space-x-2">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-admin-300 {{ $isDark ? 'dark:text-admin-600' : '' }} bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} cursor-default rounded-md leading-5">
                        <i class="fas fa-chevron-left mr-2"></i>
                        Önceki
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                       class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-admin-600 {{ $isDark ? 'dark:text-admin-300' : '' }} bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-md leading-5 hover:bg-admin-50 {{ $isDark ? 'dark:hover:bg-admin-600' : '' }} hover:text-admin-700 {{ $isDark ? 'dark:hover:text-admin-200' : '' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-admin-500 transition-colors duration-150 ease-in-out">
                        <i class="fas fa-chevron-left mr-2"></i>
                        Önceki
                    </a>
                @endif

                {{-- Pagination Elements --}}
                <div class="hidden sm:flex items-center space-x-1">
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-admin-500 {{ $isDark ? 'dark:text-admin-400' : '' }}">{{ $element }}</span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-admin-600 border border-admin-600 rounded-md leading-5 shadow-sm">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                       class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-admin-600 {{ $isDark ? 'dark:text-admin-300' : '' }} bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-md leading-5 hover:bg-admin-50 {{ $isDark ? 'dark:hover:bg-admin-600' : '' }} hover:text-admin-700 {{ $isDark ? 'dark:hover:text-admin-200' : '' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-admin-500 transition-colors duration-150 ease-in-out">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                       class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-admin-600 {{ $isDark ? 'dark:text-admin-300' : '' }} bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-md leading-5 hover:bg-admin-50 {{ $isDark ? 'dark:hover:bg-admin-600' : '' }} hover:text-admin-700 {{ $isDark ? 'dark:hover:text-admin-200' : '' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-admin-500 transition-colors duration-150 ease-in-out">
                        Sonraki
                        <i class="fas fa-chevron-right ml-2"></i>
                    </a>
                @else
                    <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-admin-300 {{ $isDark ? 'dark:text-admin-600' : '' }} bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} cursor-default rounded-md leading-5">
                        Sonraki
                        <i class="fas fa-chevron-right ml-2"></i>
                    </span>
                @endif
            </div>
        </div>

        {{-- Mobile Navigation --}}
        <div class="flex justify-between sm:hidden mt-4">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-admin-300 {{ $isDark ? 'dark:text-admin-600' : '' }} bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} cursor-default rounded-md leading-5">
                    <i class="fas fa-chevron-left mr-2"></i>
                    Önceki
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-admin-600 {{ $isDark ? 'dark:text-admin-300' : '' }} bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-md leading-5 hover:bg-admin-50 {{ $isDark ? 'dark:hover:bg-admin-600' : '' }}">
                    <i class="fas fa-chevron-left mr-2"></i>
                    Önceki
                </a>
            @endif

            <!-- Current Page Indicator -->
            <div class="flex items-center space-x-2">
                <span class="text-sm text-admin-600 {{ $isDark ? 'dark:text-admin-300' : '' }}">
                    Sayfa <span class="font-medium">{{ $paginator->currentPage() }}</span> / <span class="font-medium">{{ $paginator->lastPage() }}</span>
                </span>
            </div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-admin-600 {{ $isDark ? 'dark:text-admin-300' : '' }} bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} rounded-md leading-5 hover:bg-admin-50 {{ $isDark ? 'dark:hover:bg-admin-600' : '' }}">
                    Sonraki
                    <i class="fas fa-chevron-right ml-2"></i>
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-admin-300 {{ $isDark ? 'dark:text-admin-600' : '' }} bg-white {{ $isDark ? 'dark:bg-admin-700' : '' }} border border-admin-300 {{ $isDark ? 'dark:border-admin-600' : '' }} cursor-default rounded-md leading-5">
                    Sonraki
                    <i class="fas fa-chevron-right ml-2"></i>
                </span>
            @endif
        </div>
    </div>
@endif