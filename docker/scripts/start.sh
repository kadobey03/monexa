#!/bin/bash

# Exit on any error
set -e

echo "Starting Laravel 12 application setup..."

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
while ! nc -z mysql-monexa 3306; do
    sleep 1
done
echo "MySQL is ready!"

# Wait for Redis to be ready
echo "Waiting for Redis to be ready..."
while ! nc -z redis-monexa 6379; do
    sleep 1
done
echo "Redis is ready!"

# Skip key generation since we already set it
echo "Application key already configured."

# Skip package discovery and cache operations that might fail
echo "Skipping package discovery and cache operations for now..."

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force || echo "Migration failed, but continuing..."

# Create storage symlink if it doesn't exist
if [ ! -L /var/www/html/public/storage ]; then
    echo "Creating storage symlink..."
    php artisan storage:link || echo "Storage link failed, but continuing..."
fi

# Set proper permissions
echo "Setting proper permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "Laravel 12 application setup completed!"

# Start PHP-FPM
echo "Starting PHP-FPM..."
exec php-fpm