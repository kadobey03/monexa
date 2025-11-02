#!/bin/bash
set -e

chown -R $(whoami):$(whoami) /var/www/html

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

# Install composer dependencies if needed
if [ -f composer.json ]; then
    echo "Installing composer dependencies..."
    composer install --no-dev --optimize-autoloader --no-interaction
fi

# Generate application key if needed
if [ ! -f .env ] || ! grep -q "APP_KEY=base64:" .env; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Create storage symlink if it doesn't exist
if [ ! -L public/storage ]; then
    echo "Creating storage symlink..."
    php artisan storage:link
fi

# Clear and cache config
echo "Clearing and caching configuration..."
php artisan config:clear
php artisan config:cache

# Run migrations if requested
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "Running database migrations..."
    php artisan migrate --force
fi

echo "Laravel application setup completed!"

# Execute the command passed to the container
exec "$@"