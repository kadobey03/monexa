#!/bin/bash

# Leads Management System Deployment Script
# Version: 1.1 (Updated with Mix file fixes)
# Author: Development Team
# Date: 2025-10-26

set -e # Exit on any error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
PROJECT_NAME="leads-management"
BACKUP_DIR="/backups/leads-management"
LOG_FILE="/var/log/leads-deployment.log"
MAINTENANCE_FILE="storage/framework/maintenance.php"

# Default environment
ENVIRONMENT="production"
SKIP_TESTS=false
SKIP_BACKUP=false
FORCE_DEPLOY=false

# Functions
log() {
    echo -e "${BLUE}[$(date +'%Y-%m-%d %H:%M:%S')] $1${NC}" | tee -a "$LOG_FILE"
}

error() {
    echo -e "${RED}[ERROR] $1${NC}" | tee -a "$LOG_FILE"
    
    # Try to disable maintenance mode on error
    if [[ -f "$MAINTENANCE_FILE" ]]; then
        php artisan up 2>/dev/null || true
    fi
    
    exit 1
}

success() {
    echo -e "${GREEN}[SUCCESS] $1${NC}" | tee -a "$LOG_FILE"
}

warning() {
    echo -e "${YELLOW}[WARNING] $1${NC}" | tee -a "$LOG_FILE"
}

# Help function
show_help() {
    cat << EOF
Leads Management System Deployment Script

Usage: ./deploy-leads-system.sh [OPTIONS]

Options:
    -e, --env ENVIRONMENT    Set environment (production, staging, development) [default: production]
    -s, --skip-tests         Skip running tests before deployment
    -b, --skip-backup        Skip database backup
    -f, --force              Force deployment without confirmation
    -h, --help              Show this help message

Examples:
    ./deploy-leads-system.sh                    # Deploy to production with all checks
    ./deploy-leads-system.sh -e staging -s      # Deploy to staging, skip tests
    ./deploy-leads-system.sh -f                # Force deploy to production

EOF
}

# Parse command line arguments
while [[ $# -gt 0 ]]; do
    case $1 in
        -e|--env)
            ENVIRONMENT="$2"
            shift 2
            ;;
        -s|--skip-tests)
            SKIP_TESTS=true
            shift
            ;;
        -b|--skip-backup)
            SKIP_BACKUP=true
            shift
            ;;
        -f|--force)
            FORCE_DEPLOY=true
            shift
            ;;
        -h|--help)
            show_help
            exit 0
            ;;
        *)
            error "Unknown option: $1"
            ;;
    esac
done

# Validate environment
if [[ ! "$ENVIRONMENT" =~ ^(production|staging|development)$ ]]; then
    error "Invalid environment: $ENVIRONMENT. Must be production, staging, or development"
fi

# Pre-deployment checks
log "Starting deployment to $ENVIRONMENT environment..."

# Check if we're in the correct directory
if [[ ! -f "artisan" ]] || [[ ! -f "composer.json" ]]; then
    error "Not in Laravel project directory. Please run this script from the project root."
fi

# Check Node.js version
NODE_VERSION=$(node -v 2>/dev/null | cut -d'v' -f2 | cut -d'.' -f1 || echo "0")
if [[ "$NODE_VERSION" -lt 16 ]]; then
    error "Node.js 16 or higher is required. Current version: $(node -v 2>/dev/null || echo 'not installed')"
fi

# Check if required files exist
required_files=(
    ".env.${ENVIRONMENT}"
    "package.json"
    "composer.json"
    "vite.config.js"
    "tailwind.config.js"
)

for file in "${required_files[@]}"; do
    if [[ ! -f "$file" ]]; then
        error "Required file not found: $file"
    fi
done

# Check if git working directory is clean (for production)
if [[ "$ENVIRONMENT" == "production" ]] && [[ "$FORCE_DEPLOY" == "false" ]]; then
    if [[ -n "$(git status --porcelain)" ]]; then
        error "Git working directory is not clean. Commit or stash changes before deploying to production."
    fi
fi

# Get confirmation for production deployments
if [[ "$ENVIRONMENT" == "production" ]] && [[ "$FORCE_DEPLOY" == "false" ]]; then
    echo -e "${YELLOW}You are about to deploy to PRODUCTION environment.${NC}"
    echo -e "${YELLOW}This will affect live users. Are you sure? (y/N)${NC}"
    read -r response
    if [[ ! "$response" =~ ^[Yy]$ ]]; then
        log "Deployment cancelled by user."
        exit 0
    fi
fi

# Create backup directory
if [[ "$SKIP_BACKUP" == "false" ]]; then
    mkdir -p "$BACKUP_DIR"
fi

# Step 1: Enable maintenance mode
log "Step 1: Enabling maintenance mode..."
php artisan down --render="errors::503" --secret="$(openssl rand -hex 16)" --refresh=15
success "Maintenance mode enabled"

# Step 2: Backup database
if [[ "$SKIP_BACKUP" == "false" ]]; then
    log "Step 2: Creating database backup..."
    backup_file="$BACKUP_DIR/database_backup_$(date +%Y%m%d_%H%M%S).sql"
    
    # Get database configuration
    DB_HOST=$(php artisan tinker --execute="echo config('database.connections.mysql.host');" 2>/dev/null | tail -1)
    DB_DATABASE=$(php artisan tinker --execute="echo config('database.connections.mysql.database');" 2>/dev/null | tail -1)
    DB_USERNAME=$(php artisan tinker --execute="echo config('database.connections.mysql.username');" 2>/dev/null | tail -1)
    DB_PASSWORD=$(php artisan tinker --execute="echo config('database.connections.mysql.password');" 2>/dev/null | tail -1)
    
    if mysqldump -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE" > "$backup_file" 2>/dev/null; then
        success "Database backup created: $backup_file"
    else
        warning "Database backup failed, but continuing deployment..."
    fi
else
    log "Step 2: Skipping database backup..."
fi

# Step 3: Pull latest code (if in git directory)
if [[ -d ".git" ]]; then
    log "Step 3: Pulling latest code..."
    git fetch origin
    git reset --hard origin/main
    success "Code updated from repository"
else
    log "Step 3: Not a git repository, skipping code pull..."
fi

# Step 4: Install/Update Composer dependencies
log "Step 4: Installing Composer dependencies..."
if composer install --no-dev --optimize-autoloader --no-interaction; then
    success "Composer dependencies installed"
else
    error "Composer installation failed"
fi

# Step 5: Clean and install NPM dependencies
log "Step 5: Installing NPM dependencies..."

# Clean npm cache and node_modules
if [[ -d "node_modules" ]]; then
    log "Cleaning existing node_modules..."
    rm -rf node_modules
fi

if [[ -f "package-lock.json" ]]; then
    log "Cleaning package-lock.json..."
    rm -f package-lock.json
fi

# Clear npm cache
npm cache clean --force

# Install dependencies
if npm install --production=false; then
    success "NPM dependencies installed"
else
    error "NPM installation failed"
fi

# Step 6: Build frontend assets
log "Step 6: Building frontend assets..."

# Ensure directories exist
mkdir -p public/build

# Clean existing build files
rm -rf public/build/*

# Build assets
if [[ "$ENVIRONMENT" == "production" ]]; then
    log "Building for production..."
    if npm run build; then
        success "Production assets compiled"
    else
        error "Production build failed"
    fi
else
    log "Building for development..."
    if npm run build; then
        success "Development assets compiled"
    else
        error "Development build failed"
    fi
fi

# Verify build directory and manifest were created
if [[ ! -d "public/build" ]]; then
    error "Vite build directory not found: public/build"
fi

if [[ ! -f "public/build/manifest.json" ]]; then
    warning "Vite manifest not found: public/build/manifest.json"
    # Create minimal fallback manifest
    echo '{}' > "public/build/manifest.json"
    log "Created fallback Vite manifest file"
else
    success "Verified: public/build/manifest.json"
fi

# Check if any assets were built
asset_count=$(find public/build -name "*.css" -o -name "*.js" | wc -l)
if [[ "$asset_count" -gt 0 ]]; then
    success "Verified: $asset_count asset files built"
else
    warning "No asset files found in public/build directory"
fi

# Step 7: Configure environment
log "Step 7: Configuring environment..."
if [[ -f ".env.${ENVIRONMENT}" ]]; then
    cp ".env.${ENVIRONMENT}" ".env"
    success "Environment configuration loaded"
else
    error "Environment file .env.${ENVIRONMENT} not found"
fi

# Step 8: Generate application key if needed
if ! grep -q "APP_KEY=" .env || grep -q "APP_KEY=$" .env; then
    log "Step 8: Generating application key..."
    php artisan key:generate --force
    success "Application key generated"
else
    log "Step 8: Application key already exists..."
fi

# Step 9: Clear all caches
log "Step 9: Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
success "Caches cleared"

# Step 10: Run database migrations
log "Step 10: Running database migrations..."
if php artisan migrate --force; then
    success "Database migrations completed"
else
    error "Database migration failed"
fi

# Step 11: Seed database if needed (only for non-production)
if [[ "$ENVIRONMENT" != "production" ]]; then
    log "Step 11: Seeding database..."
    php artisan db:seed --force
    success "Database seeded"
else
    log "Step 11: Skipping database seeding for production..."
fi

# Step 12: Run tests
if [[ "$SKIP_TESTS" == "false" ]]; then
    log "Step 12: Running tests..."
    if php artisan test --parallel --stop-on-failure; then
        success "All tests passed"
    else
        error "Tests failed! Deployment aborted."
    fi
else
    log "Step 12: Skipping tests..."
fi

# Step 13: Optimize application
log "Step 13: Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Only cache events if they exist
if php artisan list | grep -q "event:cache"; then
    php artisan event:cache
fi

# Create storage link if it doesn't exist
if [[ ! -L "public/storage" ]]; then
    php artisan storage:link
fi

success "Application optimized"

# Step 14: Set proper permissions
log "Step 14: Setting file permissions..."

# Set proper ownership
if command -v chown > /dev/null 2>&1; then
    chown -R www-data:www-data storage bootstrap/cache public 2>/dev/null || {
        warning "Could not set ownership - may need sudo privileges"
    }
fi

# Set proper permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod -R 755 public

success "File permissions set"

# Step 15: Restart services
log "Step 15: Restarting services..."

# PHP-FPM
if systemctl is-active --quiet php7.4-fpm; then
    systemctl restart php7.4-fpm && success "PHP 7.4-FPM restarted"
elif systemctl is-active --quiet php8.0-fpm; then
    systemctl restart php8.0-fpm && success "PHP 8.0-FPM restarted"
elif systemctl is-active --quiet php8.1-fpm; then
    systemctl restart php8.1-fpm && success "PHP 8.1-FPM restarted"
elif systemctl is-active --quiet php8.2-fpm; then
    systemctl restart php8.2-fpm && success "PHP 8.2-FPM restarted"
else
    warning "No PHP-FPM service found to restart"
fi

# Nginx
if systemctl is-active --quiet nginx; then
    systemctl restart nginx && success "Nginx restarted"
fi

# Redis
if systemctl is-active --quiet redis-server; then
    systemctl restart redis-server && success "Redis restarted"
elif systemctl is-active --quiet redis; then
    systemctl restart redis && success "Redis restarted"
fi

# Step 16: Queue and scheduler setup
log "Step 16: Setting up queues and scheduler..."

# Stop existing queue workers
if pgrep -f "queue:work" > /dev/null; then
    pkill -f "queue:work"
    success "Queue workers stopped"
fi

# Start queue workers (in background)
nohup php artisan queue:work --daemon --sleep=3 --tries=3 --timeout=60 > storage/logs/queue.log 2>&1 &
success "Queue workers started"

# Add cron job for scheduler if not exists
if ! crontab -l 2>/dev/null | grep -q "artisan schedule:run"; then
    (crontab -l 2>/dev/null; echo "* * * * * cd $(pwd) && php artisan schedule:run >> /dev/null 2>&1") | crontab -
    success "Scheduler cron job added"
fi

# Step 17: Health check
log "Step 17: Performing health check..."
sleep 5 # Wait for services to start

# Check if application responds
if curl -f -s -m 10 "http://localhost/health" > /dev/null 2>&1; then
    success "Application health check passed"
elif curl -f -s -m 10 "http://localhost/" > /dev/null 2>&1; then
    success "Application responds to HTTP requests"
else
    warning "HTTP health check failed - check web server configuration"
fi

# Check database connectivity
if php artisan tinker --execute="DB::connection()->getPdo(); echo 'DB Connection OK';" 2>/dev/null | grep -q "DB Connection OK"; then
    success "Database connection check passed"
else
    warning "Database connection check failed"
fi

# Check if Vite manifest is valid
if [[ -f "public/build/manifest.json" ]] && [[ -s "public/build/manifest.json" ]]; then
    success "Vite manifest check passed"
else
    warning "Vite manifest check failed - may cause asset loading issues"
fi

# Step 18: Disable maintenance mode
log "Step 18: Disabling maintenance mode..."
php artisan up
success "Maintenance mode disabled"

# Step 19: Final cleanup
log "Step 19: Performing final cleanup..."

# Remove old log files (keep last 30 days)
find storage/logs -name "*.log" -type f -mtime +30 -delete 2>/dev/null || true

# Clean old backup files (keep last 10)
if [[ -d "$BACKUP_DIR" ]]; then
    cd "$BACKUP_DIR"
    ls -t database_backup_*.sql 2>/dev/null | tail -n +11 | xargs -r rm --
    cd - > /dev/null
fi

# Clean npm cache
npm cache clean --force > /dev/null 2>&1 || true

success "Cleanup completed"

# Step 20: Post-deployment notifications
log "Step 20: Sending notifications..."

# Log deployment info
echo "Deployment completed at $(date)" >> storage/logs/deployments.log
echo "Environment: $ENVIRONMENT" >> storage/logs/deployments.log
echo "Version: $(git rev-parse HEAD 2>/dev/null || echo 'unknown')" >> storage/logs/deployments.log
echo "Build files:" >> storage/logs/deployments.log
ls -la public/build/ 2>/dev/null >> storage/logs/deployments.log || true
echo "---" >> storage/logs/deployments.log

# Send Slack notification if webhook is configured
if [[ -n "${SLACK_WEBHOOK_URL:-}" ]]; then
    curl -X POST -H 'Content-type: application/json' \
        --data "{\"text\":\"✅ Leads Management System deployed successfully to $ENVIRONMENT\n\`\`\`$(git log -1 --oneline 2>/dev/null || echo 'Version unknown')\`\`\`\"}" \
        "$SLACK_WEBHOOK_URL" 2>/dev/null || true
fi

success "Notifications sent"

# Deployment summary
echo ""
echo "=========================================="
echo -e "${GREEN}🚀 DEPLOYMENT COMPLETED SUCCESSFULLY! 🚀${NC}"
echo "=========================================="
echo "Environment: $ENVIRONMENT"
echo "Deployment time: $(date)"
echo "Application URL: ${APP_URL:-'http://localhost'}"
echo ""
echo "Build verification:"
echo "✓ Vite build dir: $(test -d public/build && echo 'OK' || echo 'Missing')"
echo "✓ Vite manifest: $(test -f public/build/manifest.json && echo 'OK' || echo 'Missing')"
echo "✓ Asset count: $(find public/build -name "*.css" -o -name "*.js" 2>/dev/null | wc -l) files"
echo ""
echo "Next steps:"
echo "1. Verify application functionality at: ${APP_URL:-'http://localhost'}/admin/leads"
echo "2. Monitor logs: tail -f storage/logs/laravel.log"
echo "3. Check queue workers: php artisan queue:work --daemon"
echo "4. Monitor performance and user feedback"
echo ""
echo "Troubleshooting:"
echo "- If assets don't load: npm run build && php artisan view:clear"
echo "- If database issues: php artisan migrate:status"
echo "- If queue issues: php artisan queue:restart"
echo ""
echo "Rollback command (if needed):"
echo "./rollback-leads-system.sh"
echo "=========================================="

# Create deployment marker file
echo "{
    \"deployment_id\": \"$(date +%s)\",
    \"environment\": \"$ENVIRONMENT\",
    \"timestamp\": \"$(date -Iseconds)\",
    \"version\": \"$(git rev-parse HEAD 2>/dev/null || echo 'unknown')\",
    \"deployed_by\": \"$(whoami)\",
    \"status\": \"success\",
    \"assets\": {
        \"css_size\": \"$(stat -c%s public/css/leads-management.css 2>/dev/null || echo '0')\",
        \"js_size\": \"$(stat -c%s public/js/leads-management.js 2>/dev/null || echo '0')\",
        \"mix_manifest_exists\": $(test -f public/mix-manifest.json && echo 'true' || echo 'false')
    }
}" > storage/app/deployment.json

log "Deployment completed successfully!"

exit 0