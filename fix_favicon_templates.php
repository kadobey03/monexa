<?php
// Favicon template fix script

$templates = [
    'resources/views/layouts/guest.blade.php',
    'resources/views/layouts/app.blade.php', 
    'resources/views/layouts/guest1.blade.php',
    'resources/views/layouts/base.blade.php',
    'resources/views/layouts/dasht.blade.php',
    'resources/views/layouts/admin.blade.php',
    'resources/views/home/assetss.blade.php'
];

foreach ($templates as $template) {
    if (file_exists($template)) {
        $content = file_get_contents($template);
        
        // Replace problematic favicon calls with null-safe versions
        $patterns = [
            '/asset\(\'storage\/\'\s*\.\s*\$settings->favicon\)/' => "(\$settings->favicon ? asset('storage/' . \$settings->favicon) : asset('favicon.ico'))",
            '/asset\(\'storage\/\'\.\$settings->favicon\)/' => "(\$settings->favicon ? asset('storage/' . \$settings->favicon) : asset('favicon.ico'))"
        ];
        
        $content = preg_replace(array_keys($patterns), array_values($patterns), $content);
        
        file_put_contents($template, $content);
        echo "Fixed: $template\n";
    }
}
?>