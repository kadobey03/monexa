# Kurulum ve Deployment Kılavuzu - Çok Dilli Destek Sistemi

Bu kılavuz, Monexa Finance platformu çok dilli destek sisteminin kurulum, konfigürasyon ve deployment süreçlerini detaylı olarak açıklamaktadır.

## 📋 İçindekiler

- [Sistem Gereksinimleri](#sistem-gereksinimleri)
- [Kurulum Adımları](#kurulum-adımları)
- [Docker Konfigürasyonu](#docker-konfigürasyonu)
- [Database Kurulumu](#database-kurulumu)
- [Redis Konfigürasyonu](#redis-konfigürasyonu)
- [Laravel Ayarları](#laravel-ayarları)
- [Production Deployment](#production-deployment)
- [Performance Tuning](#performance-tuning)
- [Monitoring Setup](#monitoring-setup)

---

## 🖥️ Sistem Gereksinimleri

### Minimum Gereksinimler

**Server Specifications:**
- CPU: 2 vCPU cores (minimum)
- RAM: 4 GB (minimum), 8 GB (önerilen)
- Storage: 20 GB SSD
- Network: 100 Mbps

**Software Stack:**
- PHP 8.3+ dengan extensions:
  - `ext-redis`
  - `ext-pdo_mysql`
  - `ext-mbstring`
  - `ext-json`
  - `ext-bcmath`
- MySQL 8.0+
- Redis 7.0+
- Nginx/Apache
- Docker & Docker Compose (önerilen)

### Production Gereksinimleri

**High-Performance Setup:**
- CPU: 4+ vCPU cores
- RAM: 16 GB+
- Storage: 100 GB+ NVMe SSD
- Network: 1 Gbps
- Load Balancer support
- CDN integration

---

## 🚀 Kurulum Adımları

### 1. Repository Clone

```bash
# Project repository'sini clone edin
git clone https://github.com/monexa/platform.git
cd monexa-platform

# Translation system branch'ine geçin (eğer varsa)
git checkout feature/translation-system
```

### 2. Environment Hazırlığı

```bash
# .env dosyasını oluşturun
cp .env.example .env

# App key generate edin
docker-compose exec app-monexa php artisan key:generate
```

### 3. Translation-Specific Environment Variables

`.env` dosyasına ekleyin:

```env
# Translation System Configuration
TRANSLATION_CACHE_STORE=redis
TRANSLATION_CACHE_PREFIX=trans
TRANSLATION_CACHE_TTL=3600
TRANSLATION_PERFORMANCE_MONITORING=true
TRANSLATION_DEBUG=false

# Redis Translation Cache
REDIS_TRANSLATION_HOST=redis-monexa
REDIS_TRANSLATION_PORT=6379
REDIS_TRANSLATION_PASSWORD=null
REDIS_TRANSLATION_DB=2

# Default Language Settings
APP_LOCALE=tr
APP_FALLBACK_LOCALE=tr
APP_AVAILABLE_LOCALES=tr,ru,en

# Performance Settings
TRANSLATION_QUERY_CACHE_TTL=1800
TRANSLATION_WARM_CACHE_ON_BOOT=true
TRANSLATION_PRELOAD_GROUPS=auth,admin,user
```

### 4. Docker Container Setup

```bash
# Container'ları başlatın
docker-compose up -d

# Container durumunu kontrol edin
docker-compose ps

# Container loglarını kontrol edin
docker-compose logs app-monexa
```

---

## 🐳 Docker Konfigürasyonu

### Docker Compose Güncellemeleri

`docker-compose.yml` dosyasına Redis service ekleyin:

```yaml
version: '3.8'

services:
  # ... existing services

  redis-monexa:
    image: redis:7.2-alpine
    container_name: redis-monexa
    restart: unless-stopped
    ports:
      - "6379:6379"
    volumes:
      - redis_data:/data
      - ./docker/redis/redis.conf:/usr/local/etc/redis/redis.conf
    command: redis-server /usr/local/etc/redis/redis.conf
    healthcheck:
      test: ["CMD", "redis-cli", "ping"]
      interval: 30s
      timeout: 10s
      retries: 3
      start_period: 40s
    networks:
      - proxy-network
    environment:
      - REDIS_DATABASES=16
      - REDIS_MAXMEMORY=256mb
      - REDIS_MAXMEMORY_POLICY=allkeys-lru

  # Update app service for translation dependencies
  app-monexa:
    # ... existing configuration
    depends_on:
      - mysql-monexa
      - redis-monexa
    environment:
      - REDIS_HOST=redis-monexa
      - CACHE_DRIVER=redis
    volumes:
      # ... existing volumes
      - ./storage/translation-cache:/var/www/html/storage/translation-cache

volumes:
  # ... existing volumes
  redis_data:
    driver: local

networks:
  proxy-network:
    external: true
```

### Redis Configuration File

`docker/redis/redis.conf` oluşturun:

```conf
# Redis Translation Cache Configuration
bind 0.0.0.0
port 6379
databases 16

# Memory Management
maxmemory 256mb
maxmemory-policy allkeys-lru
maxmemory-samples 5

# Persistence
save 900 1
save 300 10
save 60 10000
rdbcompression yes
rdbchecksum yes

# Performance
tcp-keepalive 300
timeout 0
tcp-backlog 511
maxclients 10000

# Logging
loglevel notice
logfile /var/log/redis/redis-server.log

# Translation-specific optimization
hash-max-ziplist-entries 512
hash-max-ziplist-value 64
set-max-intset-entries 512
```

---

## 🗄️ Database Kurulumu

### 1. Migration Files

Translation tabloları için migration'ları çalıştırın:

```bash
# Migration'ları çalıştırın (sırayla)
docker-compose exec app-monexa php artisan migrate --path=/database/migrations/translation

# Veya tek tek
docker-compose exec app-monexa php artisan migrate --path=/database/migrations/2025_11_28_211258_create_languages_table.php
docker-compose exec app-monexa php artisan migrate --path=/database/migrations/2025_11_28_211309_create_phrases_table.php
docker-compose exec app-monexa php artisan migrate --path=/database/migrations/2025_11_28_211319_create_phrase_translations_table.php
docker-compose exec app-monexa php artisan migrate --path=/database/migrations/2025_11_28_213800_add_performance_indexes_to_translation_tables.php
```

### 2. Seed Data

```bash
# Language seeder çalıştırın
docker-compose exec app-monexa php artisan db:seed --class=LanguageSeeder

# Default phrases seed (eğer varsa)
docker-compose exec app-monexa php artisan db:seed --class=DefaultPhrasesSeeder
```

### 3. Index Optimization

```sql
-- Performance için ek indexler
ALTER TABLE phrases ADD INDEX idx_key_group (key, group);
ALTER TABLE phrases ADD INDEX idx_group_active (`group`, created_at);
ALTER TABLE phrase_translations ADD INDEX idx_phrase_lang_reviewed (phrase_id, language_id, is_reviewed);
ALTER TABLE phrase_translations ADD INDEX idx_quality_score (quality_score DESC);

-- Full-text search için (opsiyonel)
ALTER TABLE phrases ADD FULLTEXT(key, description);
ALTER TABLE phrase_translations ADD FULLTEXT(translation);
```

### 4. Database Tuning

MySQL `my.cnf` ayarları:

```ini
[mysqld]
# Translation system optimizations
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
innodb_flush_log_at_trx_commit = 2
innodb_file_per_table = 1

# Query cache
query_cache_type = 1
query_cache_size = 128M
query_cache_limit = 2M

# Connection settings
max_connections = 100
wait_timeout = 600
interactive_timeout = 600

# Character set
character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci
```

---

## ⚡ Redis Konfigürasyonu

### 1. Redis Cache Stores

`config/cache.php` güncellemeleri:

```php
<?php

return [
    // ... existing configuration

    'stores' => [
        // ... existing stores

        'translation' => [
            'driver' => 'redis',
            'connection' => 'translation',
            'prefix' => env('TRANSLATION_CACHE_PREFIX', 'trans'),
            'serializer' => 'php',
            'compress' => true,
        ],

        'translation_performance' => [
            'driver' => 'redis',
            'connection' => 'performance',
            'prefix' => 'perf',
            'serializer' => 'json',
        ],
    ],
];
```

### 2. Redis Database Connections

`config/database.php` Redis ayarları:

```php
'redis' => [
    'client' => env('REDIS_CLIENT', 'phpredis'),

    'options' => [
        'cluster' => env('REDIS_CLUSTER', 'redis'),
        'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
    ],

    'default' => [
        'url' => env('REDIS_URL'),
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'password' => env('REDIS_PASSWORD', null),
        'port' => env('REDIS_PORT', '6379'),
        'database' => env('REDIS_DB', '0'),
    ],

    // Translation-specific connections
    'translation' => [
        'host' => env('REDIS_TRANSLATION_HOST', env('REDIS_HOST', '127.0.0.1')),
        'password' => env('REDIS_TRANSLATION_PASSWORD', env('REDIS_PASSWORD', null)),
        'port' => env('REDIS_TRANSLATION_PORT', env('REDIS_PORT', '6379')),
        'database' => env('REDIS_TRANSLATION_DB', 2),
        'read_write_timeout' => 60,
        'context' => [
            'stream' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ],
    ],

    'performance' => [
        'host' => env('REDIS_PERFORMANCE_HOST', env('REDIS_HOST', '127.0.0.1')),
        'password' => env('REDIS_PERFORMANCE_PASSWORD', env('REDIS_PASSWORD', null)),
        'port' => env('REDIS_PERFORMANCE_PORT', env('REDIS_PORT', '6379')),
        'database' => env('REDIS_PERFORMANCE_DB', 3),
    ],
],
```

### 3. Redis Health Check

```bash
# Redis connection test
docker-compose exec app-monexa php artisan tinker

# Tinker içinde:
Redis::connection('translation')->ping();
Redis::connection('performance')->ping();

# Cache test
Cache::store('translation')->put('test', 'value', 60);
Cache::store('translation')->get('test');
```

---

## ⚙️ Laravel Ayarları

### 1. Service Provider Registration

`config/app.php` providers array'ine ekleyin:

```php
'providers' => [
    // ... existing providers
    
    // Translation System Providers
    App\Providers\DatabaseTranslationServiceProvider::class,
    App\Providers\TranslationCacheServiceProvider::class, // eğer varsa
],
```

### 2. Middleware Registration

`app/Http/Kernel.php` güncellemeleri:

```php
protected $middlewareGroups = [
    'web' => [
        // ... existing middleware
        \App\Http\Middleware\SetLocale::class,
    ],

    'admin' => [
        // ... existing middleware
        \App\Http\Middleware\TranslationAuth::class, // eğer varsa
    ],
];

protected $routeMiddleware = [
    // ... existing middleware
    'setlocale' => \App\Http\Middleware\SetLocale::class,
    'translation.auth' => \App\Http\Middleware\TranslationAuth::class,
];
```

### 3. Translation Configuration

`config/translation.php` oluşturun:

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Translation Settings
    |--------------------------------------------------------------------------
    */
    
    'default_locale' => env('APP_LOCALE', 'tr'),
    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'tr'),
    'available_locales' => explode(',', env('APP_AVAILABLE_LOCALES', 'tr,ru,en')),
    
    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    */
    
    'cache' => [
        'store' => env('TRANSLATION_CACHE_STORE', 'redis'),
        'prefix' => env('TRANSLATION_CACHE_PREFIX', 'trans'),
        'ttl' => env('TRANSLATION_CACHE_TTL', 3600),
        'warm_on_boot' => env('TRANSLATION_WARM_CACHE_ON_BOOT', true),
        'preload_groups' => explode(',', env('TRANSLATION_PRELOAD_GROUPS', 'auth,admin,user')),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Performance Settings
    |--------------------------------------------------------------------------
    */
    
    'performance' => [
        'monitoring_enabled' => env('TRANSLATION_PERFORMANCE_MONITORING', true),
        'query_cache_ttl' => env('TRANSLATION_QUERY_CACHE_TTL', 1800),
        'debug_mode' => env('TRANSLATION_DEBUG', false),
        'max_concurrent_requests' => env('TRANSLATION_MAX_CONCURRENT', 50),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Database Settings
    |--------------------------------------------------------------------------
    */
    
    'database' => [
        'connection' => env('DB_CONNECTION', 'mysql'),
        'batch_size' => env('TRANSLATION_BATCH_SIZE', 100),
        'max_query_time' => env('TRANSLATION_MAX_QUERY_TIME', 1000), // ms
    ],
];
```

### 4. Artisan Commands Registration

`app/Console/Kernel.php`:

```php
protected $commands = [
    // ... existing commands
    
    // Translation Commands
    \App\Console\Commands\MigrateLanguageFiles::class,
    \App\Console\Commands\TranslationPerformanceReport::class,
    \App\Console\Commands\WarmTranslationCache::class, // eğer varsa
    \App\Console\Commands\CleanupTranslationCache::class, // eğer varsa
];

protected function schedule(Schedule $schedule)
{
    // ... existing schedules
    
    // Translation system schedules
    $schedule->command('translation:performance-report --quiet')
             ->dailyAt('02:00')
             ->runInBackground();
             
    $schedule->command('translation:warm-cache')
             ->dailyAt('06:00')
             ->runInBackground();
             
    $schedule->command('translation:cleanup-cache')
             ->weeklyOn(1, '03:00')
             ->runInBackground();
}
```

---

## 🚀 Production Deployment

### 1. Pre-Deployment Checklist

```bash
# 1. Configuration check
docker-compose exec app-monexa php artisan config:cache
docker-compose exec app-monexa php artisan route:cache
docker-compose exec app-monexa php artisan view:cache

# 2. Database backup
mysqldump -u root -p monexa_db > backup_pre_translation_$(date +%Y%m%d_%H%M%S).sql

# 3. Test migration (dry run)
docker-compose exec app-monexa php artisan migrate --pretend

# 4. Check dependencies
docker-compose exec app-monexa composer check-platform-reqs
```

### 2. Deployment Script

`deploy-translation.sh` oluşturun:

```bash
#!/bin/bash

set -e

echo "🚀 Starting Translation System Deployment"

# 1. Application maintenance mode
echo "📝 Enabling maintenance mode..."
docker-compose exec app-monexa php artisan down

# 2. Update codebase
echo "📥 Pulling latest code..."
git pull origin main

# 3. Update dependencies
echo "📦 Updating dependencies..."
docker-compose exec app-monexa composer install --no-dev --optimize-autoloader

# 4. Run migrations
echo "🗄️ Running database migrations..."
docker-compose exec app-monexa php artisan migrate --force

# 5. Clear and rebuild cache
echo "🧹 Clearing caches..."
docker-compose exec app-monexa php artisan config:clear
docker-compose exec app-monexa php artisan route:clear
docker-compose exec app-monexa php artisan view:clear

echo "🔥 Rebuilding caches..."
docker-compose exec app-monexa php artisan config:cache
docker-compose exec app-monexa php artisan route:cache
docker-compose exec app-monexa php artisan view:cache

# 6. Warm translation cache
echo "⚡ Warming translation cache..."
docker-compose exec app-monexa php artisan translation:warm-cache

# 7. Run tests (optional but recommended)
echo "🧪 Running tests..."
docker-compose exec app-monexa php artisan test --testsuite=Translation

# 8. Disable maintenance mode
echo "✅ Disabling maintenance mode..."
docker-compose exec app-monexa php artisan up

echo "🎉 Translation System Deployment Complete!"

# 9. Health check
echo "🏥 Running health check..."
curl -f http://localhost:8080/admin/dashboard/phrases || exit 1

echo "✨ All systems operational!"
```

### 3. Zero-Downtime Deployment (Advanced)

Blue-Green deployment configuration:

```bash
# Blue environment (current)
docker-compose -f docker-compose.blue.yml up -d

# Green environment (new)
docker-compose -f docker-compose.green.yml up -d

# Health check green environment
./scripts/health-check.sh green

# Switch load balancer to green
./scripts/switch-lb.sh green

# Terminate blue environment
docker-compose -f docker-compose.blue.yml down
```

### 4. Rollback Strategy

`rollback.sh`:

```bash
#!/bin/bash

echo "🔄 Starting Translation System Rollback"

# 1. Maintenance mode
docker-compose exec app-monexa php artisan down

# 2. Restore database
mysql -u root -p monexa_db < backup_pre_translation_YYYYMMDD_HHMMSS.sql

# 3. Checkout previous version
git checkout HEAD~1

# 4. Restore dependencies
docker-compose exec app-monexa composer install --no-dev --optimize-autoloader

# 5. Clear caches
docker-compose exec app-monexa php artisan config:clear
docker-compose exec app-monexa php artisan cache:clear

# 6. Disable maintenance
docker-compose exec app-monexa php artisan up

echo "✅ Rollback complete"
```

---

## 🔧 Performance Tuning

### 1. PHP-FPM Optimization

`docker/php-fpm/php-fpm.conf`:

```ini
[www]
user = www-data
group = www-data

listen = 9000
listen.owner = www-data
listen.group = www-data
listen.mode = 0660

; Process management
pm = dynamic
pm.max_children = 20
pm.start_servers = 4
pm.min_spare_servers = 2
pm.max_spare_servers = 8
pm.max_requests = 1000

; PHP settings for translation system
php_admin_value[memory_limit] = 256M
php_admin_value[max_execution_time] = 60
php_admin_value[max_input_vars] = 3000
```

### 2. Nginx Configuration

`docker/nginx/sites/translation.conf`:

```nginx
server {
    listen 80;
    server_name monexa.local;
    root /var/www/html/public;
    index index.php;

    # Translation cache headers
    location ~* \.(js|css|png|jpg|jpeg|gif|svg|woff2?)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # API endpoints caching
    location ~ ^/api/v1/translations/ {
        add_header Cache-Control "public, max-age=3600";
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Admin panel (no cache)
    location ~ ^/admin/dashboard/phrases {
        add_header Cache-Control "no-cache, no-store, must-revalidate";
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP-FPM
    location ~ \.php$ {
        fastcgi_pass app-monexa:9000;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        
        # Translation system optimizations
        fastcgi_buffer_size 128k;
        fastcgi_buffers 4 256k;
        fastcgi_busy_buffers_size 256k;
        fastcgi_read_timeout 120s;
    }
}
```

### 3. Application-Level Optimization

`config/cache.php` production settings:

```php
'stores' => [
    'translation' => [
        'driver' => 'redis',
        'connection' => 'translation',
        'prefix' => 'trans',
        'serializer' => 'igbinary', // Faster serialization
        'compress' => true,
        'compress_threshold' => 2048,
        'compress_level' => 1,
    ],
],
```

### 4. Database Query Optimization

```sql
-- Translation-specific indexes for production
CREATE INDEX idx_phrases_key_hash ON phrases(key(191)) USING HASH;
CREATE INDEX idx_phrase_trans_composite ON phrase_translations(phrase_id, language_id, is_reviewed);
CREATE INDEX idx_phrases_usage_count ON phrases(usage_count DESC);
CREATE INDEX idx_languages_active ON languages(is_active, code);

-- Partition large tables (for high-volume systems)
ALTER TABLE phrase_translations PARTITION BY HASH(language_id) PARTITIONS 4;
```

---

## 📊 Monitoring Setup

### 1. Laravel Telescope (Development)

```bash
# Install Telescope
docker-compose exec app-monexa composer require laravel/telescope --dev

# Publish and migrate
docker-compose exec app-monexa php artisan telescope:install
docker-compose exec app-monexa php artisan migrate
```

### 2. Application Monitoring

`config/logging.php` channels:

```php
'channels' => [
    'translation' => [
        'driver' => 'daily',
        'path' => storage_path('logs/translation.log'),
        'level' => 'info',
        'days' => 30,
        'permission' => 0664,
    ],

    'performance' => [
        'driver' => 'daily',
        'path' => storage_path('logs/performance.log'),
        'level' => 'warning',
        'days' => 14,
    ],
],
```

### 3. Health Check Endpoints

`routes/api.php`:

```php
Route::get('/health/translation', function () {
    return [
        'status' => 'ok',
        'timestamp' => now(),
        'services' => [
            'database' => DB::connection()->getPdo() ? 'ok' : 'error',
            'redis' => Redis::connection('translation')->ping() ? 'ok' : 'error',
            'cache' => Cache::store('translation')->has('health_check') ? 'ok' : 'error',
        ],
        'metrics' => app(\App\Services\PerformanceMonitoringService::class)->getHealthMetrics(),
    ];
});
```

### 4. Monitoring Dashboard

Grafana dashboard konfigürasyonu için `monitoring/grafana-dashboard.json`:

```json
{
  "dashboard": {
    "title": "Translation System Monitoring",
    "panels": [
      {
        "title": "Cache Hit Rate",
        "type": "stat",
        "targets": [
          {
            "expr": "translation_cache_hit_rate"
          }
        ]
      },
      {
        "title": "Response Time",
        "type": "graph",
        "targets": [
          {
            "expr": "translation_response_time_ms"
          }
        ]
      },
      {
        "title": "Database Queries",
        "type": "graph",
        "targets": [
          {
            "expr": "translation_db_queries_per_second"
          }
        ]
      }
    ]
  }
}
```

---

## 🚨 Troubleshooting

### Common Installation Issues

#### Redis Connection Failed
```bash
# Check Redis service
docker-compose ps redis-monexa

# Check Redis logs
docker-compose logs redis-monexa

# Test connection
docker-compose exec app-monexa redis-cli -h redis-monexa ping
```

#### Migration Errors
```bash
# Check migration status
docker-compose exec app-monexa php artisan migrate:status

# Rollback and retry
docker-compose exec app-monexa php artisan migrate:rollback
docker-compose exec app-monexa php artisan migrate
```

#### Permission Issues
```bash
# Fix Laravel permissions
docker-compose exec app-monexa chown -R www-data:www-data storage bootstrap/cache
docker-compose exec app-monexa chmod -R 775 storage bootstrap/cache
```

### Performance Issues

#### Slow Translation Loading
```bash
# Check cache status
docker-compose exec app-monexa php artisan translation:cache-stats

# Warm cache
docker-compose exec app-monexa php artisan translation:warm-cache

# Check query performance
docker-compose exec app-monexa php artisan translation:performance-report
```

### Post-Deployment Verification

```bash
#!/bin/bash
echo "🔍 Post-deployment verification..."

# 1. Health check
curl -f http://localhost:8080/api/health/translation || echo "❌ Health check failed"

# 2. Translation test
curl -s http://localhost:8080/api/v1/translations/tr | jq '.data.auth.login' || echo "❌ Translation API failed"

# 3. Admin panel test
curl -f http://localhost:8080/admin/dashboard/phrases || echo "❌ Admin panel failed"

# 4. Cache test
docker-compose exec app-monexa php artisan tinker --execute="
Cache::store('translation')->put('deployment_test', 'success', 60);
echo Cache::store('translation')->get('deployment_test');
" || echo "❌ Cache test failed"

echo "✅ Verification complete"
```

---

Bu kurulum kılavuzu, translation sisteminin production ortamında güvenli ve performanslı bir şekilde deploy edilmesi için tüm gerekli adımları içermektedir. Herhangi bir sorun yaşadığınızda troubleshooting bölümünü kontrol edin ve gerektiğinde teknik destek ekibiyle iletişime geçin.