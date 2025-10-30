@props(['style' => session('flash.bannerStyle', 'success'), 'message' => session('flash.banner')])

@php
    $bannerId = 'banner_' . uniqid();
@endphp

<div id="{{ $bannerId }}" 
     class="banner-notification"
     data-style="{{ $style }}" 
     data-message="{{ $message }}"
     style="display: {{ $message ? 'block' : 'none' }};">
    <div class="max-w-screen-xl mx-auto py-2 px-3 sm:px-6 lg:px-8 
                {{ $style == 'success' ? 'bg-indigo-500' : 'bg-red-700' }}">
        <div class="flex items-center justify-between flex-wrap">
            <div class="w-0 flex-1 flex items-center min-w-0">
                <span class="flex p-2 rounded-lg {{ $style == 'success' ? 'bg-indigo-600' : 'bg-red-600' }}">
                    <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>

                <p class="ml-3 font-medium text-sm text-white truncate banner-message">{{ $message }}</p>
            </div>

            <div class="flex-shrink-0 sm:ml-3">
                <button type="button"
                        class="-mr-1 flex p-2 rounded-md focus:outline-none sm:-mr-2 transition ease-in-out duration-150
                               {{ $style == 'success' ? 'hover:bg-indigo-600 focus:bg-indigo-600' : 'hover:bg-red-600 focus:bg-red-600' }}"
                        aria-label="Dismiss"
                        onclick="closeBanner('{{ $bannerId }}')">
                    <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function closeBanner(bannerId) {
    const banner = document.getElementById(bannerId);
    if (banner) {
        banner.style.display = 'none';
    }
}

function showBanner(style, message) {
    const banner = document.querySelector('.banner-notification');
    if (banner) {
        const messageElement = banner.querySelector('.banner-message');
        if (messageElement) {
            messageElement.textContent = message;
        }
        
        // Update style classes
        const container = banner.querySelector('.max-w-screen-xl');
        const icon = banner.querySelector('span.flex');
        const button = banner.querySelector('button');
        
        if (container && icon && button) {
            // Remove old style classes
            container.classList.remove('bg-indigo-500', 'bg-red-700');
            icon.classList.remove('bg-indigo-600', 'bg-red-600');
            button.classList.remove('hover:bg-indigo-600', 'focus:bg-indigo-600', 'hover:bg-red-600', 'focus:bg-red-600');
            
            // Add new style classes
            if (style === 'success') {
                container.classList.add('bg-indigo-500');
                icon.classList.add('bg-indigo-600');
                button.classList.add('hover:bg-indigo-600', 'focus:bg-indigo-600');
            } else {
                container.classList.add('bg-red-700');
                icon.classList.add('bg-red-600');
                button.classList.add('hover:bg-red-600', 'focus:bg-red-600');
            }
        }
        
        banner.style.display = 'block';
        banner.dataset.style = style;
        banner.dataset.message = message;
    }
}

// Listen for banner messages
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('banner-message', function(event) {
        showBanner(event.detail.style, event.detail.message);
    });
});
</script>