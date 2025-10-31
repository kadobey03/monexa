# Monexa Fintech Platform - Developer Setup Guide

## İçindekiler
- [Sistem Gereksinimleri](#sistem-gereksinimleri)
- [Proje Kurulumu](#proje-kurulumu)
- [Geliştirme Ortamı](#geliştirme-ortamı)
- [Database Kurulumu](#database-kurulumu)
- [Testing Kurulumu](#testing-kurulumu)
- [IDE Konfigürasyonu](#ide-konfigürasyonu)
- [Geliştirme Workflow'u](#geliştirme-workflowu)
- [Debugging Tools](#debugging-tools)
- [Common Issues](#common-issues)

## Sistem Gereksinimleri

### Minimum Gereksinimler
- **PHP**: 8.3 veya üzeri
- **Composer**: 2.6 veya üzeri
- **Node.js**: 18.x veya üzeri
- **NPM**: 9.x veya üzeri
- **MySQL**: 8.0 veya üzeri
- **Redis**: 6.0 veya üzeri (opsiyonel, cache için)

### Önerilen Sistem Konfigürasyonu
```bash
# PHP Extensions (required)
php -m | grep -E "(bcmath|ctype|fileinfo|json|mbstring|openssl|pdo|tokenizer|xml|curl|gd|mysql)"

# PHP Configuration
memory_limit = 512M
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 60
```

### Platform Specific Setup

#### Windows (WSL2 Önerilir)
```bash
# Chocolatey ile kurulum
choco install php composer nodejs mysql redis

# XAMPP alternatifi
# Download XAMPP from https://www.apachefriends.org/
```

#### macOS (Homebrew)
```bash
# Homebrew ile kurulum
brew install php@8.3 composer node mysql redis

# Laravel Valet (önerilen)
composer global require laravel/valet
valet install
```

#### Ubuntu/Debian
```bash
# APT ile kurulum
sudo apt update
sudo apt install php8.3 php8.3-cli php8.3-fpm php8.3-mysql php8.3-xml php8.3-curl \
                 php8.3-gd php8.3-mbstring php8.3-zip php8.3-bcmath \
                 composer nodejs npm mysql-server redis-server

# PHP-FPM servisini başlat
sudo systemctl start php8.3-fpm
sudo systemctl enable php8.3-fpm
```

## Proje Kurulumu

### 1. Repository Clone
```bash
# HTTPS ile clone
git clone https://github.com/monexa/monexafinans.git
cd monexafinans

# SSH ile clone (önerilen)
git clone git@github.com:monexa/monexafinans.git
cd monexafinans
```

### 2. Dependency Installation
```bash
# Composer dependencies
composer install

# Node dependencies
npm install

# Eğer lock file conflicts varsa
rm -rf node_modules package-lock.json
npm install
```

### 3. Environment Configuration
```bash
# .env dosyası oluştur
cp .env.example .env

# Application key generate
php artisan key:generate
```

### 4. Environment Variables Konfigürasyonu
`.env` dosyasını düzenleyin:

```bash
# Application
APP_NAME="Monexa"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=monexa_local
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Cache Configuration (Redis önerilir)
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail Configuration (Development)
MAIL_MAILER=log
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@monexa.local"
MAIL_FROM_NAME="${APP_NAME}"

# API Keys (Development/Sandbox)
BINANCE_API_KEY=your_binance_test_key
BINANCE_SECRET_KEY=your_binance_test_secret
STRIPE_PUBLIC_KEY=pk_test_your_stripe_public_key
STRIPE_SECRET_KEY=sk_test_your_stripe_secret_key

# Security
SANCTUM_STATEFUL_DOMAINS=localhost:8000,127.0.0.1:8000
SESSION_DOMAIN=localhost

# CRON Protection
CRON_KEY=your_secure_random_key_for_cron_endpoints
```

## Geliştirme Ortamı

### Option 1: Laravel Sail (Docker - Önerilen)
```bash
# Sail kurulumu
composer require laravel/sail --dev
php artisan sail:install

# MySQL, Redis, Mailhog seçin
php artisan sail:install --with=mysql,redis,mailhog

# Docker containers başlat
./vendor/bin/sail up -d

# Alias oluştur (opsiyonel)
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'

# Artisan komutları Sail ile
sail artisan migrate
sail npm run dev
```

### Option 2: Local Development Server
```bash
# PHP built-in server
php artisan serve
# http://localhost:8000

# Laravel Valet (macOS)
valet park
# http://monexafinans.test

# Apache/Nginx Virtual Host
# DocumentRoot: /path/to/project/public
```

## Database Kurulumu

### 1. Database Oluşturma
```sql
-- MySQL Command Line
CREATE DATABASE monexa_local CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'monexa_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON monexa_local.* TO 'monexa_user'@'localhost';
FLUSH PRIVILEGES;
```

### 2. Migration ve Seeding
```bash
# Tüm migration'ları çalıştır
php artisan migrate

# Seed data ile birlikte
php artisan migrate --seed

# Fresh migration (dikkat: tüm data silinir)
php artisan migrate:fresh --seed

# Specific seeder çalıştır
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=PlanSeeder
```

### 3. Test Database Setup
```bash
# Test database oluştur
CREATE DATABASE monexa_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# .env.testing dosyası oluştur
cp .env .env.testing

# .env.testing içinde test database config
DB_DATABASE=monexa_test

# Test migration çalıştır
php artisan migrate --env=testing
```

## Testing Kurulumu

### 1. PHPUnit Configuration
```bash
# PHPUnit çalıştır
php artisan test

# Specific test suite
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature

# Coverage report
php artisan test --coverage
php artisan test --coverage-html=coverage-report

# Parallel testing
php artisan test --parallel
```

### 2. Test Categories
```bash
# Unit Tests - Service layer tests
php artisan test tests/Unit/Services/

# Feature Tests - HTTP endpoint tests  
php artisan test tests/Feature/Api/

# Integration Tests - Database interaction tests
php artisan test tests/Integration/

# Browser Tests (Dusk) - E2E tests
php artisan dusk
```

### 3. Test Database Seeding
```bash
# Test için özel seeder
php artisan make:seeder TestDataSeeder

# Test seeder'ı çalıştır
php artisan db:seed --class=TestDataSeeder --env=testing
```

## IDE Konfigürasyonu

### Visual Studio Code Setup
**Required Extensions:**
```json
{
  "recommendations": [
    "bmewburn.vscode-intelephense-client",
    "bradlc.vscode-tailwindcss",
    "ms-vscode.vscode-blade-formatter",
    "ryannaddy.laravel-artisan",
    "codingyu.laravel-goto-view",
    "amiralizadeh9480.laravel-extra-intellisense"
  ]
}
```

**Settings Configuration:**
```json
{
  "php.suggest.basic": false,
  "php.validate.enable": false,
  "intelephense.files.maxSize": 5000000,
  "blade.format.enable": true,
  "emmet.includeLanguages": {
    "blade": "html"
  },
  "files.associations": {
    "*.blade.php": "blade"
  }
}
```

### PhpStorm Configuration
1. **PHP Interpreter**: `/usr/local/bin/php` (8.3+)
2. **Composer Path**: `/usr/local/bin/composer`
3. **Laravel Plugin**: Install Laravel plugin
4. **Database**: Configure MySQL connection
5. **Code Style**: PSR-12 standard

### Laravel IDE Helper Setup
```bash
# IDE helper packages kurulumu
composer require --dev barryvdh/laravel-ide-helper
composer require --dev barryvdh/laravel-debugbar

# Helper files generate
php artisan ide-helper:generate
php artisan ide-helper:models
php artisan ide-helper:meta
```

## Geliştirme Workflow'u

### 1. Git Workflow
```bash
# Yeni feature branch oluştur
git checkout -b feature/new-payment-method

# Changes commit
git add .
git commit -m "feat: add crypto payment method support"

# Push to origin
git push origin feature/new-payment-method

# Pull Request oluştur
# GitHub/GitLab üzerinden PR create
```

### 2. Code Quality Tools
```bash
# Laravel Pint (Code formatting)
./vendor/bin/pint

# PHPStan (Static Analysis)
composer require --dev phpstan/phpstan
./vendor/bin/phpstan analyse

# Laravel Larastan
composer require --dev nunomaduro/larastan
```

### 3. Asset Development
```bash
# Development mode (watch)
npm run dev

# Production build
npm run build

# Hot Module Replacement
npm run dev -- --hot

# Vite server info
npm run dev -- --host
```

## Debugging Tools

### 1. Laravel Debugbar
```bash
# Debugbar kurulumu (development only)
composer require barryvdh/laravel-debugbar --dev

# .env configuration
APP_DEBUG=true
DEBUGBAR_ENABLED=true
```

### 2. Laravel Telescope
```bash
# Telescope kurulumu
composer require laravel/telescope

# Telescope publish
php artisan telescope:install
php artisan migrate

# Access: http://localhost:8000/telescope
```

### 3. Query Debugging
```php
// Enable query log
DB::enableQueryLog();

// Your database operations
$users = User::with('deposits')->get();

// Get executed queries
$queries = DB::getQueryLog();
dd($queries);

// Single query debugging
User::where('email', $email)->toSql(); // Raw SQL
User::where('email', $email)->dump(); // Query + bindings
```

### 4. Logging Configuration
```php
// config/logging.php - Custom log channel
'channels' => [
    'financial' => [
        'driver' => 'single',
        'path' => storage_path('logs/financial.log'),
        'level' => 'info',
    ],
    
    'lead_management' => [
        'driver' => 'daily',
        'path' => storage_path('logs/leads.log'),
        'days' => 14,
    ],
];

// Usage in code
Log::channel('financial')->info('Deposit processed', [
    'user_id' => $user->id,
    'amount' => $deposit->amount
]);
```

## Local Services Setup

### 1. Redis Setup
```bash
# macOS (Homebrew)
brew install redis
brew services start redis

# Ubuntu
sudo apt install redis-server
sudo systemctl start redis-server

# Docker
docker run -d --name redis -p 6379:6379 redis:alpine

# Test connection
redis-cli ping
# PONG
```

### 2. MySQL Setup
```bash
# MySQL Secure Installation
sudo mysql_secure_installation

# Create development user
mysql -u root -p
CREATE USER 'monexa_dev'@'localhost' IDENTIFIED BY 'dev_password';
GRANT ALL PRIVILEGES ON monexa_*.* TO 'monexa_dev'@'localhost';
```

### 3. Mailhog (Email Testing)
```bash
# Go installation required
go install github.com/mailhog/MailHog@latest

# Run Mailhog
~/go/bin/MailHog

# Web interface: http://localhost:8025
# SMTP: localhost:1025
```

## Performance Optimization (Development)

### 1. Artisan Commands Optimization
```bash
# Clear all caches
php artisan optimize:clear

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Optimize autoloader
composer dump-autoload -o
```

### 2. Asset Compilation
```bash
# Vite optimization
npm run build

# Legacy mix support
npm run production
```

### 3. Database Optimization
```bash
# Check database indexes
php artisan db:check-indexes

# Analyze slow queries
php artisan db:monitor --slow=1000

# Optimize database tables
php artisan db:optimize
```

## Common Issues

### 1. Permission Issues
```bash
# Storage permission fix
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache

# SELinux (if applicable)
sudo setsebool -P httpd_can_network_connect on
```

### 2. PHP Memory Issues
```bash
# Increase memory limit temporarily
php -d memory_limit=1G artisan migrate

# Or in .env
PHP_MEMORY_LIMIT=512M
```

### 3. Node.js Version Issues
```bash
# Install NVM
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash

# Use specific Node version
nvm install 18.18.0
nvm use 18.18.0
```

### 4. Database Connection Issues
```bash
# Check MySQL service
sudo systemctl status mysql

# Test connection
php artisan tinker
DB::connection()->getPdo();
```

### 5. Livewire Issues
```bash
# Clear Livewire cache
php artisan livewire:clear-cache

# Republish Livewire assets
php artisan livewire:publish --force
```

## Useful Development Commands

### Daily Workflow
```bash
# Start development environment
php artisan serve &
npm run dev &
redis-server &

# Fresh development setup
php artisan migrate:fresh --seed
php artisan queue:work &

# Code quality check
./vendor/bin/pint
php artisan test
```

### Artisan Custom Commands
```bash
# Generate API documentation
php artisan api:generate-docs

# Update lead scores
php artisan leads:update-scores

# Process crypto rates
php artisan crypto:update-rates

# Generate test data
php artisan generate:test-data --count=100
```

### Database Management
```bash
# Backup database
php artisan backup:database

# Restore from backup
php artisan restore:database backup_2025_10_31.sql

# Seed specific data
php artisan db:seed --class=DevDataSeeder
```

---

**Son Güncelleme**: 31 Ekim 2025  
**Environment**: Development  
**Support**: [Development Slack Channel](https://monexa.slack.com/channels/development)