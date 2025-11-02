#!/bin/bash

# Exit on any error
set -e

# Get host user ID and group ID from environment variables
HOST_UID=${HOST_UID:-1000}
HOST_GID=${HOST_GID:-1000}

echo "Starting Laravel 12 application setup with user mapping..."
echo "Host UID: $HOST_UID, Host GID: $HOST_GID"

# Create a group with the host GID if it doesn't exist
if ! getent group $HOST_GID > /dev/null 2>&1; then
    echo "Creating group with GID $HOST_GID..."
    groupadd -g $HOST_GID hostgroup
else
    echo "Group with GID $HOST_GID already exists"
fi

# Create a user with the host UID if it doesn't exist
if ! getent passwd $HOST_UID > /dev/null 2>&1; then
    echo "Creating user with UID $HOST_UID..."
    useradd -u $HOST_UID -g $HOST_GID -d /var/www/html -s /bin/bash hostuser
else
    echo "User with UID $HOST_UID already exists"
    # Update existing user's group if needed
    usermod -g $HOST_GID $(getent passwd $HOST_UID | cut -d: -f1)
fi

# Get the username for the host UID
HOST_USER=$(getent passwd $HOST_UID | cut -d: -f1)
HOST_GROUP=$(getent group $HOST_GID | cut -d: -f1)

echo "Using user: $HOST_USER ($HOST_UID) and group: $HOST_GROUP ($HOST_GID)"

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

# Create necessary directories with proper ownership
echo "Creating necessary directories..."
mkdir -p /var/www/html/storage/logs \
         /var/www/html/storage/framework/cache \
         /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/testing \
         /var/www/html/storage/app/public \
         /var/www/html/bootstrap/cache

# Set proper ownership for Laravel directories
echo "Setting proper ownership for Laravel directories..."
chown -R $HOST_UID:$HOST_GID /var/www/html/storage
chown -R $HOST_UID:$HOST_GID /var/www/html/bootstrap/cache

# Set proper permissions
echo "Setting proper permissions..."
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Ensure the application files have correct ownership
echo "Ensuring application files have correct ownership..."
chown -R $HOST_UID:$HOST_GID /var/www/html

# Create storage symlink if it doesn't exist (run as the host user)
if [ ! -L /var/www/html/public/storage ]; then
    echo "Creating storage symlink..."
    su -s /bin/bash $HOST_USER -c "cd /var/www/html && php artisan storage:link" 2>/dev/null || echo "Storage link failed, but continuing..."
fi

# Install/update composer dependencies if needed (run as host user)
if [ -f /var/www/html/composer.json ]; then
    echo "Checking composer dependencies..."
    su -s /bin/bash $HOST_USER -c "cd /var/www/html && composer install --no-dev --optimize-autoloader --no-interaction" 2>/dev/null || echo "Composer install failed, but continuing..."
fi

# Generate application key if needed (run as host user)
if ! grep -q "APP_KEY=base64:" /var/www/html/.env 2>/dev/null; then
    echo "Generating application key..."
    su -s /bin/bash $HOST_USER -c "cd /var/www/html && php artisan key:generate --force" 2>/dev/null || echo "Key generation failed, but continuing..."
fi

# Clear and cache config (run as host user)
echo "Clearing and caching configuration..."
su -s /bin/bash $HOST_USER -c "cd /var/www/html && php artisan config:clear" 2>/dev/null || echo "Config clear failed, but continuing..."
su -s /bin/bash $HOST_USER -c "cd /var/www/html && php artisan config:cache" 2>/dev/null || echo "Config cache failed, but continuing..."

# Run migrations if requested via environment variable
if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "Running database migrations..."
    su -s /bin/bash $HOST_USER -c "cd /var/www/html && php artisan migrate --force" 2>/dev/null || echo "Migrations failed, but continuing..."
fi

echo "Laravel 12 application setup completed!"

# Update PHP-FPM configuration to run as host user
echo "Updating PHP-FPM configuration..."
sed -i "s/user = www-data/user = $HOST_USER/g" /usr/local/etc/php-fpm.d/www.conf
sed -i "s/group = www-data/group = $HOST_GROUP/g" /usr/local/etc/php-fpm.d/www.conf

# Start PHP-FPM
echo "Starting PHP-FPM as user $HOST_USER ($HOST_UID)..."
exec php-fpm