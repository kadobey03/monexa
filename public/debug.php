<?php
echo "PHP Çalışıyor - " . date('Y-m-d H:i:s') . "<br>";
echo "Laravel Path: " . __DIR__.'/../bootstrap/app.php' . "<br>";

if (file_exists(__DIR__.'/../bootstrap/app.php')) {
    echo "Bootstrap dosyası mevcut<br>";
    
    try {
        require __DIR__.'/../vendor/autoload.php';
        echo "Autoload başarılı<br>";
        
        $app = require_once __DIR__.'/../bootstrap/app.php';
        echo "Laravel app yüklendi<br>";
        
        echo "App Type: " . get_class($app) . "<br>";
        
    } catch (Exception $e) {
        echo "HATA: " . $e->getMessage() . "<br>";
        echo "Stack: " . $e->getTraceAsString() . "<br>";
    }
} else {
    echo "Bootstrap dosyası bulunamadı<br>";
}