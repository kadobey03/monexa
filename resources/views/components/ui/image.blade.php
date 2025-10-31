@props([
    'src',
    'alt' => '',
    'lazy' => true,
    'webp' => false,
    'sizes' => null,
    'class' => '',
    'width' => null,
    'height' => null
])

@php
    $imageClasses = 'transition-opacity duration-300';
    if ($lazy) {
        $imageClasses .= ' lazy';
    }
@endphp

<picture {{ $attributes->merge(['class' => $class]) }}>
    @if($webp && !str_ends_with($src, '.webp'))
        <source
            srcset="{{ $src }}.webp"
            type="image/webp"
            @if($sizes) sizes="{{ $sizes }}" @endif
        >
    @endif

    <img
        src="{{ $lazy ? 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PC9zdmc+' : $src }}"
        data-src="{{ $lazy ? $src : null }}"
        alt="{{ $alt }}"
        @if($lazy) loading="lazy" @endif
        @if($width) width="{{ $width }}" @endif
        @if($height) height="{{ $height }}" @endif
        @if($sizes) sizes="{{ $sizes }}" @endif
        class="{{ $imageClasses }}"
        @if($lazy) onload="this.classList.remove('lazy')" @endif
    />
</picture>

@push('scripts')
@if($lazy)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const lazyImages = document.querySelectorAll('img.lazy');

    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    observer.unobserve(img);
                }
            });
        });

        lazyImages.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback for browsers without IntersectionObserver
        lazyImages.forEach(img => {
            img.src = img.dataset.src;
            img.classList.remove('lazy');
        });
    }
});
</script>
@endif
@endpush