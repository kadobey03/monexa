#!/bin/bash

# Exit on any error
set -e

echo "Starting Laravel 12 application setup..."

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
while ! nc -z mysql-vicsafe 3306; do
    sleep 1
done
echo "MySQL is ready!"

# Wait for Redis to be ready
echo "Waiting for Redis to be ready..."
while ! nc -z redis-vicsafe 6379; do
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

# Ensure storage directories exist
echo "Ensuring storage directories exist..."
mkdir -p /var/www/html/storage/app/public/photos
mkdir -p /var/www/html/storage/app/public/uploads
mkdir -p /var/www/html/storage/app/public/images

# Remove existing storage symlink if it's broken
if [ -L /var/www/html/public/storage ] && [ ! -e /var/www/html/public/storage ]; then
    echo "Removing broken storage symlink..."
    rm -f /var/www/html/public/storage
fi

# Create storage symlink if it doesn't exist or is broken
if [ ! -L /var/www/html/public/storage ]; then
    echo "Creating storage symlink..."
    if php artisan storage:link; then
        echo "Storage symlink created successfully!"
    else
        echo "Laravel storage:link failed, creating manual symlink..."
        rm -f /var/www/html/public/storage
        ln -s /var/www/html/storage/app/public /var/www/html/public/storage
        if [ -L /var/www/html/public/storage ]; then
            echo "Manual storage symlink created successfully!"
        else
            echo "ERROR: Failed to create storage symlink!"
        fi
    fi
else
    echo "Storage symlink already exists and is valid."
fi

# Verify symlink is working
if [ -L /var/www/html/public/storage ] && [ -d /var/www/html/public/storage ]; then
    echo "✓ Storage symlink verification: SUCCESS"
else
    echo "✗ Storage symlink verification: FAILED"
    echo "Debug info:"
    ls -la /var/www/html/public/ | grep storage || echo "No storage link found"
    ls -la /var/www/html/storage/app/ || echo "storage/app not found"
fi

# Set proper permissions
echo "Setting proper permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Set specific permissions for storage/app/public
echo "Setting storage/app/public permissions..."
chown -R www-data:www-data /var/www/html/storage/app/public
chmod -R 775 /var/www/html/storage/app/public

# Ensure public/storage symlink has correct permissions
if [ -L /var/www/html/public/storage ]; then
    chown -h www-data:www-data /var/www/html/public/storage
fi

echo "✓ All permissions set successfully!"

echo "Laravel 12 application setup completed!"

# Start PHP-FPM
echo "Starting PHP-FPM..."
exec php-fpm