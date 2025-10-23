#!/bin/bash

# Laravel Smart Docker Deployment Script
echo "🔧 Starting Smart Laravel Docker deployment..."

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_debug() {
    echo -e "${BLUE}[DEBUG]${NC} $1"
}

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    print_error "Docker is not running. Please start Docker and try again."
    exit 1
fi

# Check if docker-compose is available
if ! command -v docker-compose &> /dev/null; then
    print_error "docker-compose is not installed. Please install it and try again."
    exit 1
fi

# Smart deployment logic - check if build is needed
BUILD_NEEDED=false
TIMESTAMP_FILE=".build-timestamp"

print_status "Checking if build is needed..."

# Check if timestamp file exists
if [ ! -f "$TIMESTAMP_FILE" ]; then
    print_debug "No build timestamp found, build needed"
    BUILD_NEEDED=true
else
    # Check if critical files changed since last build
    if [ "Dockerfile" -nt "$TIMESTAMP_FILE" ]; then
        print_debug "Dockerfile changed, build needed"
        BUILD_NEEDED=true
    elif [ "docker-compose.yml" -nt "$TIMESTAMP_FILE" ]; then
        print_debug "docker-compose.yml changed, build needed"
        BUILD_NEEDED=true
    elif [ "composer.json" -nt "$TIMESTAMP_FILE" ]; then
        print_debug "composer.json changed, build needed"
        BUILD_NEEDED=true
    elif [ "package.json" -nt "$TIMESTAMP_FILE" ]; then
        print_debug "package.json changed, build needed"
        BUILD_NEEDED=true
    fi
fi

# Execute deployment based on build requirement
if [ "$BUILD_NEEDED" = true ]; then
    print_status "Infrastructure changes detected - performing full rebuild..."
    
    # Stop existing containers
    print_status "Stopping existing containers..."
    docker-compose down
    
    # Build and start containers
    print_status "Building and starting containers..."
    docker-compose up -d --build
    
    # Update timestamp
    touch "$TIMESTAMP_FILE"
    
    # Wait longer for build completion
    print_status "Waiting for services to be ready..."
    sleep 15
else
    print_status "No infrastructure changes detected - quick restart..."
    
    # Just restart containers (much faster)
    print_status "Starting containers without rebuild..."
    docker-compose up -d
    
    # Quick wait
    print_status "Waiting for services to be ready..."
    sleep 5
fi

# Check if containers are running
print_status "Checking container status..."
if docker-compose ps | grep -q "Up"; then
    print_status "Containers are running successfully!"
else
    print_error "Some containers failed to start. Check logs with: docker-compose logs"
    exit 1
fi

# Laravel optimizations (only if app container is running)
if docker-compose ps app-monexa | grep -q "Up"; then
    print_status "Running Laravel optimizations..."
    
    # Clear and cache configurations
    docker-compose exec -T app-monexa php artisan config:clear || print_warning "Config clear failed"
    docker-compose exec -T app-monexa php artisan config:cache || print_warning "Config cache failed"
    
    # Cache routes
    docker-compose exec -T app-monexa php artisan route:clear || print_warning "Route clear failed"
    docker-compose exec -T app-monexa php artisan route:cache || print_warning "Route cache failed"
    
    # Cache views
    docker-compose exec -T app-monexa php artisan view:clear || print_warning "View clear failed"
    docker-compose exec -T app-monexa php artisan view:cache || print_warning "View cache failed"
    
    print_status "Laravel optimizations completed!"
fi

# Check for dependency updates (optional quick checks)
COMPOSER_TIMESTAMP=".composer-timestamp"
if [ "composer.json" -nt "$COMPOSER_TIMESTAMP" ] && [ "$BUILD_NEEDED" = false ]; then
    print_status "Composer dependencies may need update..."
    if docker-compose exec -T app-monexa composer install --no-interaction --optimize-autoloader; then
        touch "$COMPOSER_TIMESTAMP"
        print_status "Composer dependencies updated!"
    else
        print_warning "Composer update failed, but continuing..."
    fi
fi

# Display success message and access information
echo ""
echo "🎉 Smart deployment completed successfully!"
echo ""

if [ "$BUILD_NEEDED" = true ]; then
    echo -e "${GREEN}✅ Full rebuild completed${NC}"
else
    echo -e "${BLUE}⚡ Quick restart completed${NC}"
fi

echo ""
echo "📍 Access your application:"
echo "   🌐 Laravel App: http://localhost:8211"
echo "   🗄️  PhpMyAdmin: http://localhost:8111"
echo ""
echo "📋 Database Information:"
echo "   Host: mysql-monexa (or localhost from host)"
echo "   Port: 3306"
echo "   Database: monexa"
echo "   Username: monexa_user"
echo "   Password: sPl2ltlt1emaV5t9"
echo ""
echo "🔧 Useful Commands:"
echo "   View logs: docker-compose logs"
echo "   Stop services: docker-compose down"
echo "   Restart services: docker-compose restart"
echo "   Run artisan commands: docker-compose exec app-monexa php artisan [command]"
echo "   Force rebuild: rm .build-timestamp && ./deploy.sh"
echo ""
print_status "Happy coding! 🚀"