@props(['title'])

<div class="nav-section">
    @if($title)
    <div class="nav-section-title text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wide mb-2">
        {{ $title }}
    </div>
    @endif
    
    <ul role="list" class="nav-section-items space-y-1">
        {{ $slot }}
    </ul>
</div>