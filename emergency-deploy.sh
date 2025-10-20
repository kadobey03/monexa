#!/bin/bash

# Emergency Deployment Script
# Use this when Docker Hub is completely down

echo "🚨 Emergency Deployment Mode - Bypassing Docker Hub"

# Stop containers
echo "⏹️ Stopping containers..."
docker-compose down --remove-orphans || true

# Update code only (no rebuild)
echo "📦 Updating application code..."
docker-compose up -d --no-build --remove-orphans

# If that fails, try using existing images
if [ $? -ne 0 ]; then
    echo "⚠️ No-build failed, trying with existing images..."
    docker start app-monexa nginx-monexa mysql-monexa redis-monexa phpmyadmin-monexa || true
fi

# Wait for services
sleep 10

# Update composer dependencies inside running container
echo "📚 Updating dependencies..."
docker exec app-monexa composer install --no-interaction --no-dev --optimize-autoloader || true

# Clear caches
echo "🧹 Clearing caches..."
docker exec app-monexa php artisan config:clear || true
docker exec app-monexa php artisan cache:clear || true
docker exec app-monexa php artisan route:clear || true
docker exec app-monexa php artisan view:clear || true
docker exec app-monexa php artisan optimize || true

# Run migrations if needed
echo "🏗️ Running migrations..."
docker exec app-monexa php artisan migrate --force || true

echo "✅ Emergency deployment completed!"
echo "🔍 Checking container status:"
docker-compose ps