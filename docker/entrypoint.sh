#!/bin/bash

composer install

# Clear all Laravel caches to ensure fresh state in development
echo "Clearing Laravel caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

exec "$@"