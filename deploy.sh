#!/bin/bash

# Laravel Docker Deployment Script
echo "🚀 Starting Laravel Docker deployment..."

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
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

# Stop existing containers
print_status "Stopping existing containers..."
docker-compose down

# Build and start containers
print_status "Building and starting containers..."
docker-compose up -d --build

# Wait for services to be ready
print_status "Waiting for services to be ready..."
sleep 10

# Check if containers are running
print_status "Checking container status..."
if docker-compose ps | grep -q "Up"; then
    print_status "Containers are running successfully!"
else
    print_error "Some containers failed to start. Check logs with: docker-compose logs"
    exit 1
fi

# Display access information
echo ""
echo "🎉 Deployment completed successfully!"
echo ""
echo "📍 Access your application:"
echo "   🌐 Laravel App: http://localhost"
echo "   🗄️  PhpMyAdmin: http://localhost:8080"
echo ""
echo "📋 Database Information:"
echo "   Host: localhost (or mysql from within containers)"
echo "   Port: 3306"
echo "   Database: laravel"
echo "   Username: laravel_user"
echo "   Password: laravel_password"
echo ""
echo "🔧 Useful Commands:"
echo "   View logs: docker-compose logs"
echo "   Stop services: docker-compose down"
echo "   Restart services: docker-compose restart"
echo "   Run artisan commands: docker-compose exec app php artisan [command]"
echo ""
print_status "Happy coding! 🚀"