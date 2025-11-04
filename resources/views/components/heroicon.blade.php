@php
/**
 * Heroicons Component - Tailwind CSS Compatible Icon System
 * Replaces lucide.js with pure SVG icons from Heroicons
 * 
 * @param string $name - Icon name (heroicons style)
 * @param string $type - Icon type: 'outline' (default) or 'solid'
 * @param string $class - Additional CSS classes
 * @param array $attributes - Additional HTML attributes
 */

// Icon mapping from lucide to heroicons
$iconMap = [
    // Navigation & UI
    'home' => 'home',
    'menu' => 'bars-3',
    'x' => 'x-mark',
    'chevron-down' => 'chevron-down',
    'chevron-up' => 'chevron-up', 
    'chevron-left' => 'chevron-left',
    'chevron-right' => 'chevron-right',
    'chevrons-left' => 'chevron-double-left',
    'chevrons-right' => 'chevron-double-right',
    'arrow-left' => 'arrow-left',
    'arrow-right' => 'arrow-right',
    
    // User & Auth
    'user' => 'user',
    'user-plus' => 'user-plus',
    'user-check' => 'user-check',
    'user-x' => 'user-minus',
    'user-circle' => 'user-circle',
    'user-cog' => 'user-cog',
    'users' => 'users',
    'log-in' => 'arrow-right-on-rectangle',
    'log-out' => 'arrow-left-on-rectangle',
    'shield' => 'shield-check',
    'shield-check' => 'shield-check',
    'shield-alert' => 'shield-exclamation',
    
    // Communication
    'mail' => 'envelope',
    'phone' => 'phone',
    'bell' => 'bell',
    'bell-off' => 'bell-slash',
    
    // Actions & Status
    'check' => 'check',
    'check-circle' => 'check-circle',
    'alert-circle' => 'exclamation-circle',
    'alert-triangle' => 'exclamation-triangle',
    'info' => 'information-circle',
    'help-circle' => 'question-mark-circle',
    'x-circle' => 'x-circle',
    
    // Finance & Trading
    'trending-up' => 'arrow-trending-up',
    'trending-down' => 'arrow-trending-down',
    'dollar-sign' => 'currency-dollar',
    'banknote' => 'banknote',
    'wallet' => 'wallet',
    'credit-card' => 'credit-card',
    'plus-circle' => 'plus-circle',
    'minus-circle' => 'minus-circle',
    'zap' => 'bolt',
    'target' => 'view-finder',
    'gift' => 'gift',
    'repeat' => 'arrow-path',
    
    // System & Settings
    'settings' => 'cog-6-tooth',
    'cog' => 'cog-6-tooth',
    'server' => 'server',
    'database' => 'circle-stack',
    'key' => 'key',
    'lock' => 'lock-closed',
    'unlock' => 'lock-open',
    'eye' => 'eye',
    'eye-off' => 'eye-slash',
    'search' => 'magnifying-glass',
    'filter' => 'funnel',
    'download' => 'arrow-down-tray',
    'upload' => 'arrow-up-tray',
    'refresh-cw' => 'arrow-path',
    'refresh-ccw' => 'arrow-path',
    
    // Layout & Organization
    'layout-dashboard' => 'squares-2x2',
    'grid-3x3' => 'squares-plus',
    'columns' => 'view-columns',
    'list' => 'list-bullet',
    'list-checks' => 'check-list',
    'calendar' => 'calendar-days',
    'clock' => 'clock',
    'folder' => 'folder',
    'file' => 'document',
    'bookmark' => 'bookmark',
    
    // Communication & Social
    'globe' => 'globe-alt',
    'globe-2' => 'globe-americas',
    'at-sign' => 'at-symbol',
    'flag' => 'flag',
    'languages' => 'language',
    'headphones' => 'speaker-wave',
    'life-buoy' => 'life-buoy',
    
    // Media & Content
    'image' => 'photo',
    'video' => 'video-camera',
    'camera' => 'camera',
    'mic' => 'microphone',
    'volume' => 'speaker-wave',
    
    // Navigation & Movement
    'map-pin' => 'map-pin',
    'navigation' => 'cursor-arrow-rays',
    'compass' => 'compass',
    
    // Tools & Actions
    'edit' => 'pencil',
    'edit-2' => 'pencil-square',
    'edit-3' => 'pen-tool',
    'trash' => 'trash',
    'trash-2' => 'trash',
    'copy' => 'document-duplicate',
    'save' => 'document-arrow-down',
    'send' => 'paper-airplane',
    'share' => 'share',
    
    // Technology
    'wifi' => 'wifi',
    'bluetooth' => 'signal',
    'radio' => 'radio',
    'smartphone' => 'device-phone-mobile',
    'tablet' => 'device-tablet',
    'monitor' => 'computer-desktop',
    'hard-drive' => 'server',
    
    // Nature & Weather
    'sun' => 'sun',
    'moon' => 'moon',
    'cloud' => 'cloud',
    'umbrella' => 'cloud-arrow-up',
    
    // Shapes & Graphics
    'circle' => 'stop',
    'square' => 'stop',
    'triangle' => 'play',
    'star' => 'star',
    'heart' => 'heart',
    'diamond' => 'diamond',
    'dot' => 'minus',
    
    // Business & Professional
    'briefcase' => 'briefcase',
    'building' => 'building-office',
    'home' => 'home',
    'shop' => 'building-storefront',
    'award' => 'trophy',
    'certificate' => 'academic-cap',
    
    // Arrows & Directions  
    'arrow-up' => 'arrow-up',
    'arrow-down' => 'arrow-down',
    'arrow-up-circle' => 'arrow-up-circle',
    'arrow-down-circle' => 'arrow-down-circle',
    'corner-up-left' => 'arrow-up-left',
    'corner-up-right' => 'arrow-up-right',
    
    // Gaming & Entertainment
    'gamepad-2' => 'puzzle-piece',
    'music' => 'musical-note',
    'play' => 'play',
    'pause' => 'pause',
    'stop' => 'stop',
    
    // Miscellaneous
    'loader-2' => 'arrow-path',
    'sparkles' => 'sparkles',
    'flame' => 'fire',
    'droplet' => 'beaker',
    'scissors' => 'scissors',
    'paperclip' => 'paper-clip',
    'link' => 'link',
    'tag' => 'tag',
    'hash' => 'hashtag',
    'percent' => 'percent-badge',
    'calculator' => 'calculator',
    'receipt' => 'receipt-percent',
    'shopping-cart' => 'shopping-cart',
    'package' => 'cube',
    'truck' => 'truck',
    'activity' => 'chart-bar',
    'bar-chart' => 'chart-bar',
    'pie-chart' => 'chart-pie',
    'git-branch' => 'code-bracket',
    'code' => 'code-bracket',
    'terminal' => 'command-line',
    'layers' => 'squares-plus',
    'grid' => 'squares-2x2',
    'maximize' => 'arrows-pointing-out',
    'minimize' => 'arrows-pointing-in',
    'panel-left' => 'sidebar',
    'panel-right' => 'sidebar',
    'grip-vertical' => 'bars-3-bottom-left',
    'more-vertical' => 'ellipsis-vertical',
    'more-horizontal' => 'ellipsis-horizontal',
    'external-link' => 'arrow-top-right-on-square',
    'history' => 'clock',
    'rotate-ccw' => 'arrow-uturn-left',
    'rotate-cw' => 'arrow-uturn-right',
    'maximize-2' => 'arrows-pointing-out',
    'minimize-2' => 'arrows-pointing-in',
    'pin' => 'map-pin',
    'unpin' => 'map-pin',
    'plus' => 'plus',
    'minus' => 'minus',
    'filter-x' => 'x-mark',
    'x-square' => 'x-mark',
    'check-square' => 'check-circle',
    'square' => 'square-3-stack-3d',
    'invest' => 'arrow-trending-up',
    'key-round' => 'key',
    'mail-check' => 'envelope-open',
    'shield-question' => 'shield-exclamation',
];

// Get the mapped icon name, fallback to original if not found
$iconName = $iconMap[$name] ?? $name;

// Default type to outline if not specified
$type = $type ?? 'outline';

// Merge classes
$classes = trim(($class ?? '') . ' ' . ($attributes['class'] ?? ''));
unset($attributes['class']);

// Default size if no size classes detected
if (!preg_match('/\b[wh]-\d+/', $classes)) {
    $classes = trim($classes . ' w-5 h-5');
}

// Get SVG path based on type and icon name - using inline logic to avoid function redeclaration
$icons = [
    // Navigation & UI Icons
    'home' => [
        'outline' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25',
        'solid' => 'M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.061l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.432z'
    ],
    'bars-3' => [
        'outline' => 'M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5',
        'solid' => 'M3 6.75A.75.75 0 013.75 6h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 6.75zM3 12a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 12zm0 5.25a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z'
    ],
    'x-mark' => [
        'outline' => 'M6 18L18 6M6 6l12 12',
        'solid' => 'M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 01-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z'
    ],
    'chevron-down' => [
        'outline' => 'm19.5 8.25-7.5 7.5-7.5-7.5',
        'solid' => 'M12.53 16.28a.75.75 0 01-1.06 0l-7.5-7.5a.75.75 0 011.06-1.06L12 14.69l6.97-6.97a.75.75 0 111.06 1.06l-7.5 7.5z'
    ],
    'chevron-up' => [
        'outline' => 'm4.5 15.75 7.5-7.5 7.5 7.5',
        'solid' => 'M11.47 7.72a.75.75 0 011.06 0l7.5 7.5a.75.75 0 11-1.06 1.06L12 9.31l-6.97 6.97a.75.75 0 01-1.06-1.06l7.5-7.5z'
    ],
    'chevron-left' => [
        'outline' => 'M15.75 19.5L8.25 12l7.5-7.5',
        'solid' => 'M7.72 12.53a.75.75 0 010-1.06l7.5-7.5a.75.75 0 111.06 1.06L9.31 12l6.97 6.97a.75.75 0 11-1.06 1.06l-7.5-7.5z'
    ],
    'chevron-right' => [
        'outline' => 'm8.25 4.5 7.5 7.5-7.5 7.5',
        'solid' => 'M16.28 11.47a.75.75 0 010 1.06l-7.5 7.5a.75.75 0 01-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 011.06-1.06l7.5 7.5z'
    ],
    
    // User & Auth Icons
    'user' => [
        'outline' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z',
        'solid' => 'M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z'
    ],
    'user-plus' => [
        'outline' => 'M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z',
        'solid' => 'M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z'
    ],
    'users' => [
        'outline' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
        'solid' => 'M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.128l-.001.144a2.25 2.25 0 01-.233.96 10.088 10.088 0 005.06-1.01.75.75 0 00.42-.643 4.875 4.875 0 00-6.957-4.611 8.586 8.586 0 011.71 5.157v.003z'
    ],
    'envelope' => [
        'outline' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75',
        'solid' => 'M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z'
    ],
    'bell' => [
        'outline' => 'M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0',
        'solid' => 'M5.85 3.5a.75.75 0 00-1.117-1 9.928 9.928 0 00-2.963 7.178 9.923 9.923 0 00.52 3.25c.638-.924 1.072-1.984 1.072-3.15V9a4.5 4.5 0 019 0v.828c0 1.166.434 2.226 1.072 3.15a9.922 9.922 0 00.52-3.25 9.928 9.928 0 00-2.963-7.178.75.75 0 00-1.117 1A8.427 8.427 0 0112 4.5c-1.552 0-2.958.42-4.15 1.146zM15.466 20.5a.75.75 0 01-1.183.613l-2.712-1.96a.75.75 0 01-.133-1.065 3 3 0 105.12 0 .75.75 0 01-.133 1.065l-2.712 1.96a.75.75 0 01-1.183-.613z'
    ],
    'check' => [
        'outline' => 'M4.5 12.75l6 6 9-13.5',
        'solid' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    ],
    'check-circle' => [
        'outline' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'solid' => 'M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z'
    ],
    'exclamation-circle' => [
        'outline' => 'M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z',
        'solid' => 'M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z'
    ],
    'information-circle' => [
        'outline' => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853L12 15.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z',
        'solid' => 'M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.67-1.34l.04-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z'
    ],
    'plus-circle' => [
        'outline' => 'M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z',
        'solid' => 'M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9z'
    ],
    'bolt' => [
        'outline' => 'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z',
        'solid' => 'M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25zM13.5 15H1.5v1.125c0 1.035.84 1.875 1.875 1.875h8.25c1.035 0 1.875-.84 1.875-1.875V15zM22.5 6.375c0-1.036-.84-1.875-1.875-1.875H16.5v1.875h4.125c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125H16.5V21h4.125c1.035 0 1.875-.84 1.875-1.875V6.375z'
    ],
    'arrow-trending-up' => [
        'outline' => 'M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941',
        'solid' => 'M18.97 3.659a2.25 2.25 0 00-3.182 0l-10.94 10.94a3.75 3.75 0 105.304 5.303l7.693-7.693a.75.75 0 011.06 1.06l-7.693 7.693a5.25 5.25 0 11-7.424-7.424l10.939-10.94a3.75 3.75 0 115.303 5.304L9.97 12.97a2.25 2.25 0 11-3.182-3.182l6.99-6.99a.75.75 0 011.06 1.061l-6.99 6.99a.75.75 0 001.061 1.06l10.94-10.939z'
    ],
    'cog-6-tooth' => [
        'outline' => 'M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z',
        'solid' => 'M17.004 10.407c.138.435-.216.842-.672.842h-3.465a.75.75 0 01-.65-.375l-1.732-3c-.229-.396-.053-.907.393-1.004a5.252 5.252 0 016.126 3.537zM8.12 8.464c.307-.338.838-.235 1.066.16l1.732 3a.75.75 0 010 .75l-1.732 3c-.229.397-.76.5-1.067.161A5.23 5.23 0 016.75 12c0-1.362.519-2.603 1.37-3.536zM10.878 17.13c-.447-.098-.623-.608-.394-1.004l1.733-3.002a.75.75 0 01.65-.375h3.465c.457 0 .81.407.672.842a5.252 5.252 0 01-6.126 3.539z M8 12a4 4 0 1115.547-1.661.75.75 0 11-1.518.231A2.5 2.5 0 004.73 9.483a.75.75 0 111.518-.231A4.002 4.002 0 018 12z'
    ],
    'lock-closed' => [
        'outline' => 'M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z',
        'solid' => 'M18 1.5c2.9 0 5.25 2.35 5.25 5.25v3.75a.75.75 0 01-1.5 0V6.75a3.75 3.75 0 10-7.5 0v3.75H8.25a3 3 0 00-3 3v6.75a3 3 0 003 3h7.5a3 3 0 003-3v-6.75a3 3 0 00-3-3H15V6.75c0-2.9 2.35-5.25 5.25-5.25z'
    ],
    'eye' => [
        'outline' => 'M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
        'solid' => 'M12 15a3 3 0 100-6 3 3 0 000 6z M12 2.252A8.014 8.014 0 012.036 9.387a.75.75 0 000 .639A8.014 8.014 0 0112 17.25a8.014 8.014 0 009.964-7.225.75.75 0 000-.639A8.014 8.014 0 0012 2.252z'
    ],
    'magnifying-glass' => [
        'outline' => 'M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z',
        'solid' => 'M10.5 18a7.5 7.5 0 04.79-13.63L17.25 2a.75.75 0 01.02 1.06L15.31 5.02a7.5 7.5 0 01-4.79 12.98z M15.75 10.5a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z'
    ],
    'squares-2x2' => [
        'outline' => 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z',
        'solid' => 'M5.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM2.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM18.75 7.5a.75.75 0 00-1.5 0v2.25H15a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H21a.75.75 0 000-1.5h-2.25V7.5z'
    ],
    'arrow-path' => [
        'outline' => 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m-4.991 4.99a.75.75 0 101.06-1.06l-2.717-2.717',
        'solid' => 'M1.5 6.375c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v3.026a.75.75 0 01-1.5 0V6.375a.375.375 0 00-.375-.375H3.375a.375.375 0 00-.375.375v9.75a.375.375 0 00.375.375H8.25a.75.75 0 010 1.5H3.375A1.875 1.875 0 011.5 16.125V6.375z M11.25 16.811c0 1.621 1.309 2.939 2.93 2.939 1.621 0 2.93-1.318 2.93-2.939s-1.309-2.938-2.93-2.938c-1.621 0-2.93 1.317-2.93 2.938z'
    ],
    'plus' => [
        'outline' => 'M12 4.5v15m7.5-7.5h-15',
        'solid' => 'M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z'
    ],
    'minus' => [
        'outline' => 'M19.5 12h-15',
        'solid' => 'M4.5 12a.75.75 0 01.75-.75h13.5a.75.75 0 010 1.5H5.25A.75.75 0 014.5 12z'
    ]
];

$svgPath = $icons[$iconName][$type] ?? '';
@endphp

<svg {{ $attributes }} class="{{ $classes }}" fill="{{ $type === 'solid' ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
    @if($svgPath)
        @if($type === 'solid')
            <path fill-rule="evenodd" d="{{ $svgPath }}" clip-rule="evenodd"/>
        @else
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $svgPath }}" />
        @endif
    @else
        <!-- Fallback: Generic icon placeholder -->
        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
    @endif
</svg>