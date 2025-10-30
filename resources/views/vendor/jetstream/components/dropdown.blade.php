@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white', 'dropdownClasses' => ''])

@php
switch ($align) {
    case 'left':
        $alignmentClasses = 'origin-top-left left-0';
        break;
    case 'top':
        $alignmentClasses = 'origin-top';
        break;
    case 'none':
    case 'false':
        $alignmentClasses = '';
        break;
    case 'right':
    default:
        $alignmentClasses = 'origin-top-right right-0';
        break;
}

switch ($width) {
    case '48':
        $width = 'w-48';
        break;
}

$dropdownId = 'dropdown_' . uniqid();
@endphp

<div class="relative dropdown-wrapper">
    <div onclick="toggleDropdown('{{ $dropdownId }}')">
        {{ $trigger }}
    </div>

    <div id="{{ $dropdownId }}" 
         class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }} {{ $dropdownClasses }} dropdown-menu"
         style="display: none;">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>

<script>
function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    const isOpen = dropdown.style.display !== 'none';
    
    // Close all other dropdowns
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        if (menu.id !== id) {
            menu.style.display = 'none';
        }
    });
    
    // Toggle this dropdown
    dropdown.style.display = isOpen ? 'none' : 'block';
}

function closeDropdown(id) {
    const dropdown = document.getElementById(id);
    if (dropdown) {
        dropdown.style.display = 'none';
    }
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.dropdown-wrapper')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.style.display = 'none';
        });
    }
});

// Close dropdown when clicking on dropdown content
document.addEventListener('click', function(event) {
    if (event.target.closest('.dropdown-menu')) {
        const dropdown = event.target.closest('.dropdown-menu');
        dropdown.style.display = 'none';
    }
});
</script>