# Monexa Fintech Platform - Deployment Guide

## İçindekiler
- [Genel Bakış](#genel-bakış)
- [Production Environment](#production-environment)
- [Server Requirements](#server-requirements)
- [Pre-deployment Checklist](#pre-deployment-checklist)
- [Manual Deployment](#manual-deployment)
- [CI/CD Pipeline](#cicd-pipeline)
- [Security Configuration](#security-configuration)
- [Monitoring & Logging](#monitoring--logging)
- [Backup Strategy](#backup-strategy)
- [Rollback Procedures](#rollback-procedures)
- [Performance Optimization](#performance-optimization)

## Genel Bakış

Monexa platform'u production environment'ta güvenli ve performanslı çalışması için özel konfigürasyonlar gerektirir. Bu guide, staging ve production deploymentları için step-by-step talimatları içerir.

### Deployment Environments
- **Staging**: Pre-production testing environment
- **Production**: Live production environment
- **Blue-Green**: Zero-downtime deployment strategy

### Deployment Strategy
- **Rolling Deployment**: Gradual instance replacement
- **Blue-Green Deployment**: Zero-downtime switching
- **Canary Deployment**: Gradual traffic shifting

## Production Environment

### Infrastructure Overview
```
┌─────────────────────────────────────────────────────────────┐
│                    Load Balancer (Nginx)                    │
│                         SSL Termination                     │
└─────────────────────────────────────────────────────────────┘
                               │
        ┌──────────────────────┼──────────────────────┐
        │                      │                      │
┌───────▼──────┐    ┌─────────▼──────┐    ┌─────────▼──────┐
│  Web Server  │    │  Web Server    │    │  Web Server    │
│   (Nginx +   │    │   (Nginx +     │    │   (Nginx +     │
│   PHP-FPM)   │    │   PHP-FPM)     │    │   PHP-FPM)     │
└──────────────┘    └────────────────┘    └────────────────┘
        │                      │                      │
        └──────────────────────┼──────────────────────┘
                               │
┌─────────────────────────────────────────────────────────────┐
│                     Database Cluster                        │
│              MySQL 8.0 (Master-Slave Setup)               │
└─────────────────────────────────────────────────────────────┘
                               │
┌─────────────────────────────────────────────────────────────┐
│                    Redis Cluster                            │
│              (Session + Cache + Queues)                    │
└─────────────────────────────────────────────────────────────┘
```

### Domain & SSL Configuration
```bash
# Domain setup
monexa.app (Production)
api.monexa.app (API endpoint)
admin.monexa.app (Admin panel)
staging.monexa.app (Staging environment)

# SSL Certificates (Let's Encrypt + Cloudflare)
certbot --nginx -d monexa.app -d api.monexa.app -d admin.monexa.app
```

## Server Requirements

### Minimum Production Specs
```bash
# Web Servers (3 instances)
CPU: 4 vCPU cores
RAM: 8 GB
Storage: 100 GB SSD
Bandwidth: 1 Gbps

# Database Server
CPU: 8 vCPU cores  
RAM: 16 GB
Storage: 500 GB SSD (with backup)
IOPS: 3000+ guaranteed

# Redis Server
CPU: 2 vCPU cores
RAM: 4 GB
Storage: 50 GB SSD
```

### Operating System & Software
```bash
# Operating System
Ubuntu 22.04 LTS (recommended)
CentOS 8 Stream (alternative)

# Web Stack
Nginx 1.20+
PHP 8.3+ with FPM
MySQL 8.0+
Redis 6.2+

# Process Management
Supervisor (queue workers)
Cron (scheduled tasks)
Fail2ban (security)
```

### PHP Production Configuration
```ini
; /etc/php/8.3/fpm/php.ini
memory_limit = 256M
max_execution_time = 60
max_input_time = 60
upload_max_filesize = 10M
post_max_size = 10M
max_file_uploads = 20

; Security
expose_php = Off
display_errors = Off
display_startup_errors = Off
log_errors = On
error_log = /var/log/php/error.log

; OPcache (Production)
opcache.enable = 1
opcache.memory_consumption = 128
opcache.max_accelerated_files = 4000
opcache.revalidate_freq = 0
opcache.validate_timestamps = 0
```

## Pre-deployment Checklist

### 1. Code Preparation
```bash
# ✅ Code quality checks passed
./vendor/bin/pint --test
./vendor/bin/phpstan analyse
php artisan test --coverage-min=90

# ✅ Security scan completed
composer audit
npm audit

# ✅ Database migrations reviewed
php artisan migrate:status
php artisan migrate --dry-run

# ✅ Environment configuration validated
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Dependencies & Assets
```bash
# ✅ Production dependencies installed
composer install --no-dev --optimize-autoloader

# ✅ Assets compiled for production
npm run build
php artisan horizon:publish

# ✅ Storage directories prepared
php artisan storage:link
```

### 3. Configuration Files
```bash
# ✅ .env.production configured
APP_ENV=production
APP_DEBUG=false
APP_URL=https://monexa.app

# ✅ Database configuration
DB_HOST=mysql-cluster.internal
DB_DATABASE=monexa_production
DB_USERNAME=monexa_prod_user

# ✅ Cache configuration
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# ✅ SSL & Security
FORCE_HTTPS=true
SESSION_SECURE_COOKIE=true
```

### 4. Third-party Services
```bash
# ✅ API keys configured (production)
BINANCE_API_KEY=prod_binance_key
STRIPE_SECRET_KEY=sk_live_stripe_key

# ✅ Email service configured
MAIL_MAILER=smtp
MAIL_HOST=smtp.monexa.app

# ✅ Monitoring services
SENTRY_LARAVEL_DSN=https://sentry.io/projects/monexa
NEW_RELIC_LICENSE_KEY=newrelic_key
```

## Manual Deployment

### 1. Server Preparation
```bash
# SSH into production server
ssh deploy@monexa-prod-web01

# Switch to deployment user
sudo su - deploy
cd /var/www/monexa

# Stop running processes
sudo supervisorctl stop monexa-worker:*
sudo systemctl stop php8.3-fpm
```

### 2. Code Deployment
```bash
# Backup current version
cp -r /var/www/monexa /var/www/backups/monexa-$(date +%Y%m%d_%H%M%S)

# Pull latest code
git fetch origin
git checkout main
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader
npm ci
npm run build
```

### 3. Database Migration
```bash
# Backup database first
php artisan backup:database --path=/var/backups/mysql/

# Run migrations
php artisan migrate --force

# Verify migration status
php artisan migrate:status
```

### 4. Cache & Configuration
```bash
# Clear existing caches
php artisan optimize:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Queue restart
php artisan queue:restart
```

### 5. Service Restart
```bash
# Restart PHP-FPM
sudo systemctl restart php8.3-fpm

# Restart Nginx
sudo systemctl reload nginx

# Start queue workers
sudo supervisorctl start monexa-worker:*

# Verify services
sudo systemctl status php8.3-fpm nginx mysql redis-server
```

## CI/CD Pipeline

### GitHub Actions Workflow
**File**: `.github/workflows/deploy.yml`

```yaml
name: Deploy to Production

on:
  push:
    branches: [main]
  workflow_dispatch:

jobs:
  tests:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: 8.3
          extensions: bcmath, ctype, fileinfo, json, mbstring, openssl, pdo, tokenizer, xml
          
      - name: Install Dependencies
        run: composer install --prefer-dist --no-progress
        
      - name: Copy Environment
        run: cp .env.ci .env
        
      - name: Generate Key
        run: php artisan key:generate
        
      - name: Run Tests
        run: php artisan test --coverage-clover=coverage.xml
        
      - name: Security Check
        run: composer audit

  deploy:
    needs: tests
    runs-on: ubuntu-latest
    if: github.ref == 'refs/heads/main'
    
    steps:
      - uses: actions/checkout@v3
      
      - name: Deploy to Production
        uses: appleboy/ssh-action@v0.1.7
        with:
          host: ${{ secrets.PROD_HOST }}
          username: ${{ secrets.PROD_USERNAME }}
          key: ${{ secrets.PROD_SSH_KEY }}
          script: |
            cd /var/www/monexa
            git pull origin main
            composer install --no-dev --optimize-autoloader
            npm ci && npm run build
            php artisan migrate --force
            php artisan optimize
            php artisan queue:restart
            sudo supervisorctl restart monexa-worker:*
            sudo systemctl reload php8.3-fpm nginx
```

### Deployment Scripts
**File**: `scripts/deploy.sh`

```bash
#!/bin/bash

set -e

echo "🚀 Starting Monexa deployment..."

# Variables
DEPLOY_PATH="/var/www/monexa"
BACKUP_PATH="/var/www/backups"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

# Functions
backup_current() {
    echo "📦 Creating backup..."
    sudo cp -r $DEPLOY_PATH $BACKUP_PATH/monexa-$TIMESTAMP
    mysqldump -u root -p monexa_production > $BACKUP_PATH/database-$TIMESTAMP.sql
}

deploy_code() {
    echo "📥 Deploying code..."
    cd $DEPLOY_PATH
    git pull origin main
    composer install --no-dev --optimize-autoloader --no-interaction
    npm ci
    npm run build
}

migrate_database() {
    echo "🗄️ Running migrations..."
    php artisan migrate --force
    php artisan migrate:status
}

optimize_application() {
    echo "⚡ Optimizing application..."
    php artisan optimize
    php artisan storage:link
    chmod -R 775 storage bootstrap/cache
}

restart_services() {
    echo "🔄 Restarting services..."
    php artisan queue:restart
    sudo supervisorctl restart monexa-worker:*
    sudo systemctl reload php8.3-fpm nginx
}

health_check() {
    echo "🏥 Running health check..."
    curl -f http://localhost/health-check || {
        echo "❌ Health check failed! Rolling back..."
        rollback_deployment
        exit 1
    }
    echo "✅ Health check passed!"
}

rollback_deployment() {
    echo "⏪ Rolling back deployment..."
    sudo cp -r $BACKUP_PATH/monexa-$TIMESTAMP/* $DEPLOY_PATH/
    mysql -u root -p monexa_production < $BACKUP_PATH/database-$TIMESTAMP.sql
    restart_services
}

# Main deployment flow
backup_current
deploy_code
migrate_database
optimize_application
restart_services
health_check

echo "🎉 Deployment completed successfully!"
```

### Blue-Green Deployment
```bash
# Blue-Green deployment script
#!/bin/bash

BLUE_PATH="/var/www/monexa-blue"
GREEN_PATH="/var/www/monexa-green"
CURRENT_LINK="/var/www/monexa-current"

# Determine current environment
if [ -L $CURRENT_LINK ]; then
    CURRENT=$(readlink $CURRENT_LINK)
    if [ "$CURRENT" == "$BLUE_PATH" ]; then
        DEPLOY_TO=$GREEN_PATH
        DEPLOY_COLOR="GREEN"
    else
        DEPLOY_TO=$BLUE_PATH
        DEPLOY_COLOR="BLUE"
    fi
else
    DEPLOY_TO=$BLUE_PATH
    DEPLOY_COLOR="BLUE"
fi

echo "🔵🟢 Deploying to $DEPLOY_COLOR environment..."

# Deploy to inactive environment
cd $DEPLOY_TO
git pull origin main
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan optimize

# Health check on new environment
php artisan serve --host=127.0.0.1 --port=8001 &
SERVE_PID=$!
sleep 5

if curl -f http://127.0.0.1:8001/health-check; then
    echo "✅ Health check passed, switching traffic..."
    
    # Switch symlink to new environment
    sudo rm -f $CURRENT_LINK
    sudo ln -s $DEPLOY_TO $CURRENT_LINK
    
    # Restart services
    sudo systemctl reload nginx
    
    echo "🎉 Blue-Green deployment completed!"
else
    echo "❌ Health check failed, keeping current environment"
    exit 1
fi

kill $SERVE_PID
```

## Security Configuration

### 1. SSL/TLS Configuration
```nginx
# /etc/nginx/sites-available/monexa.app
server {
    listen 443 ssl http2;
    server_name monexa.app api.monexa.app;

    ssl_certificate /etc/letsencrypt/live/monexa.app/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/monexa.app/privkey.pem;
    
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE-RSA-AES256-GCM-SHA384;
    ssl_prefer_server_ciphers off;
    
    add_header Strict-Transport-Security "max-age=63072000" always;
    add_header X-Content-Type-Options nosniff;
    add_header X-Frame-Options DENY;
    add_header X-XSS-Protection "1; mode=block";
    add_header Referrer-Policy "strict-origin-when-cross-origin";
}
```

### 2. Firewall Configuration
```bash
# UFW Firewall setup
sudo ufw enable
sudo ufw default deny incoming
sudo ufw default allow outgoing

# Allow necessary ports
sudo ufw allow 22/tcp    # SSH
sudo ufw allow 80/tcp    # HTTP
sudo ufw allow 443/tcp   # HTTPS

# Database access (internal only)
sudo ufw allow from 10.0.1.0/24 to any port 3306
sudo ufw allow from 10.0.1.0/24 to any port 6379
```

### 3. Fail2ban Configuration
```ini
# /etc/fail2ban/jail.local
[DEFAULT]
bantime = 3600
findtime = 600
maxretry = 5

[sshd]
enabled = true
port = ssh
logpath = /var/log/auth.log

[nginx-http-auth]
enabled = true
port = http,https
logpath = /var/log/nginx/error.log

[nginx-limit-req]
enabled = true
port = http,https
logpath = /var/log/nginx/error.log
maxretry = 10
```

### 4. Environment Security
```bash
# .env production security
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error

# Secure session configuration
SESSION_LIFETIME=120
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict

# CSRF protection
SANCTUM_STATEFUL_DOMAINS=monexa.app,admin.monexa.app

# Rate limiting
RATE_LIMIT_PER_MINUTE=60
API_RATE_LIMIT=120
```

## Monitoring & Logging

### 1. Application Monitoring
```bash
# Laravel Telescope (Production monitoring)
php artisan telescope:install
php artisan telescope:publish

# Horizon (Queue monitoring)
php artisan horizon:install
php artisan horizon:publish
```

### 2. Server Monitoring
```bash
# Install monitoring agents
curl -sSL https://agent.datadoghq.com/scripts/install_script.sh | DD_API_KEY=your_key bash

# New Relic PHP agent
wget -O - https://download.newrelic.com/548C16BF.gpg | sudo apt-key add -
echo 'deb http://apt.newrelic.com/debian/ newrelic non-free' | sudo tee /etc/apt/sources.list.d/newrelic.list
sudo apt-get update && sudo apt-get install newrelic-php5
```

### 3. Log Management
```php
// config/logging.php
'channels' => [
    'production' => [
        'driver' => 'stack',
        'channels' => ['daily', 'slack', 'syslog'],
    ],
    
    'daily' => [
        'driver' => 'daily',
        'path' => storage_path('logs/laravel.log'),
        'level' => 'error',
        'days' => 14,
    ],
    
    'slack' => [
        'driver' => 'slack',
        'url' => env('LOG_SLACK_WEBHOOK_URL'),
        'username' => 'Monexa Production',
        'emoji' => ':exclamation:',
        'level' => 'critical',
    ],
];
```

### 4. Health Checks
```php
// routes/web.php
Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'version' => config('app.version'),
        'database' => DB::connection()->getPdo() ? 'connected' : 'disconnected',
        'cache' => Cache::has('health-check') ? 'working' : 'issues',
        'queue' => 'working', // Add queue health check
    ]);
});
```

## Backup Strategy

### 1. Database Backups
```bash
# Daily database backup script
#!/bin/bash
BACKUP_DIR="/var/backups/mysql"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
DB_NAME="monexa_production"

# Create backup
mysqldump --single-transaction --routines --triggers \
    $DB_NAME > $BACKUP_DIR/monexa_$TIMESTAMP.sql

# Compress backup
gzip $BACKUP_DIR/monexa_$TIMESTAMP.sql

# Keep only 30 days of backups
find $BACKUP_DIR -name "monexa_*.sql.gz" -mtime +30 -delete

# Upload to S3
aws s3 cp $BACKUP_DIR/monexa_$TIMESTAMP.sql.gz \
    s3://monexa-backups/database/ --storage-class GLACIER
```

### 2. Application Backups
```bash
# Application files backup
tar -czf /var/backups/app/monexa_$(date +%Y%m%d).tar.gz \
    -C /var/www \
    --exclude='*/node_modules' \
    --exclude='*/vendor' \
    --exclude='*/storage/logs' \
    monexa/

# Upload to cloud storage
aws s3 cp /var/backups/app/monexa_$(date +%Y%m%d).tar.gz \
    s3://monexa-backups/application/
```

### 3. Automated Backup Schedule
```bash
# /etc/cron.d/monexa-backups
# Database backup - every 6 hours
0 */6 * * * root /usr/local/bin/backup-database.sh

# Application backup - daily at 2 AM
0 2 * * * root /usr/local/bin/backup-application.sh

# Log rotation - weekly
0 1 * * 0 root /usr/local/bin/rotate-logs.sh
```

## Rollback Procedures

### 1. Quick Rollback (Code only)
```bash
# Rollback to previous git commit
cd /var/www/monexa
git log --oneline -10  # Find previous commit hash
git reset --hard abc123  # Previous working commit
composer install --no-dev --optimize-autoloader
php artisan optimize
sudo systemctl reload nginx php8.3-fpm
```

### 2. Full Rollback (Code + Database)
```bash
#!/bin/bash
# rollback.sh

BACKUP_PATH="/var/backups"
ROLLBACK_DATE=${1:-$(date +%Y%m%d)}  # Default to today

echo "🔄 Rolling back to backup from $ROLLBACK_DATE..."

# Stop services
sudo supervisorctl stop monexa-worker:*

# Restore application files
cd /var/www
sudo rm -rf monexa
sudo tar -xzf $BACKUP_PATH/app/monexa_$ROLLBACK_DATE.tar.gz

# Restore database
mysql -u root -p monexa_production < $BACKUP_PATH/mysql/monexa_$ROLLBACK_DATE.sql

# Restart services
cd /var/www/monexa
php artisan optimize
sudo supervisorctl start monexa-worker:*
sudo systemctl reload nginx php8.3-fpm

echo "✅ Rollback completed!"
```

### 3. Blue-Green Rollback
```bash
# Switch back to previous environment
CURRENT_LINK="/var/www/monexa-current"
CURRENT=$(readlink $CURRENT_LINK)

if [ "$CURRENT" == "/var/www/monexa-blue" ]; then
    ROLLBACK_TO="/var/www/monexa-green"
else
    ROLLBACK_TO="/var/www/monexa-blue"
fi

echo "🔄 Rolling back to $(basename $ROLLBACK_TO)..."
sudo rm -f $CURRENT_LINK
sudo ln -s $ROLLBACK_TO $CURRENT_LINK
sudo systemctl reload nginx

echo "✅ Rollback completed!"
```

## Performance Optimization

### 1. PHP-FPM Optimization
```ini
; /etc/php/8.3/fpm/pool.d/monexa.conf
[monexa]
user = www-data
group = www-data
listen = /run/php/php8.3-fpm-monexa.sock
listen.owner = www-data
listen.group = www-data
listen.mode = 0660

pm = dynamic
pm.max_children = 50
pm.start_servers = 10
pm.min_spare_servers = 5
pm.max_spare_servers = 20
pm.max_requests = 500

request_terminate_timeout = 60
```

### 2. Nginx Optimization
```nginx
# /etc/nginx/nginx.conf
worker_processes auto;
worker_rlimit_nofile 65535;

events {
    worker_connections 2048;
    use epoll;
    multi_accept on;
}

http {
    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript 
               application/javascript application/json application/xml+rss;
    
    # Cache static assets
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

### 3. Database Optimization
```sql
-- MySQL production configuration
[mysqld]
innodb_buffer_pool_size = 8G  # 70% of available RAM
innodb_log_file_size = 1G
innodb_flush_log_at_trx_commit = 2
innodb_io_capacity = 2000

query_cache_type = 1
query_cache_size = 256M
query_cache_limit = 2M

max_connections = 500
thread_cache_size = 16
table_open_cache = 4000
```

---

**Son Güncelleme**: 31 Ekim 2025  
**Deployment Versiyon**: 3.0  
**Infrastructure**: AWS/DigitalOcean  
**Monitoring**: DataDog + New Relic