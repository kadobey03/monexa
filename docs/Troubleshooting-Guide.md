# Sorun Giderme Kılavuzu - Çok Dilli Destek Sistemi

Bu kılavuz, Monexa Finance platformu çok dilli destek sistemiyle ilgili yaygın sorunları ve çözüm yöntemlerini kapsamaktadır.

## 📋 İçindekiler

- [Sistem Diagnostik Araçları](#sistem-diagnostik-araçları)
- [Cache ve Redis Sorunları](#cache-ve-redis-sorunları)
- [Database Sorunları](#database-sorunları)
- [Performance Sorunları](#performance-sorunları)
- [Translation Loading Sorunları](#translation-loading-sorunları)
- [Admin Panel Sorunları](#admin-panel-sorunları)
- [API Endpoint Sorunları](#api-endpoint-sorunları)
- [Deployment Sorunları](#deployment-sorunları)
- [Emergency Procedures](#emergency-procedures)

---

## 🔍 Sistem Diagnostik Araçları

### Health Check Command

Sistem sağlığını kontrol etmek için:

```bash
# Genel health check
docker-compose exec app-monexa php artisan translation:health-check

# Detaylı diagnostic report
docker-compose exec app-monexa php artisan translation:diagnostic --verbose

# Performance baseline
docker-compose exec app-monexa php artisan translation:performance-report --detailed
```

### Manual Diagnostic Steps

```bash
# 1. Container status kontrolü
docker-compose ps

# 2. Service connectivity test
docker-compose exec app-monexa php artisan tinker
>>> DB::connection()->getPdo() ? 'DB OK' : 'DB FAIL'
>>> Redis::connection('translation')->ping() ? 'Redis OK' : 'Redis FAIL'
>>> Cache::store('translation')->put('test', 'ok', 60); Cache::store('translation')->get('test')

# 3. Log examination
docker-compose logs app-monexa --tail=100
docker-compose logs redis-monexa --tail=50
docker-compose logs mysql-monexa --tail=50
```

### System Information Collection

```bash
#!/bin/bash
# collect-system-info.sh

echo "=== MONEXA TRANSLATION SYSTEM DIAGNOSTIC ==="
echo "Timestamp: $(date)"
echo ""

echo "=== Container Status ==="
docker-compose ps

echo ""
echo "=== Disk Usage ==="
df -h

echo ""
echo "=== Memory Usage ==="
free -h

echo ""
echo "=== Translation System Status ==="
docker-compose exec app-monexa php artisan translation:health-check

echo ""
echo "=== Recent Logs (Last 20 lines) ==="
docker-compose logs app-monexa --tail=20
```

---

## ⚡ Cache ve Redis Sorunları

### Problem: Cache Hit Rate Düşük (<70%)

**Belirtiler:**
- Yavaş translation loading
- Yüksek database query sayısı
- Response time artışı

**Diagnostic:**
```bash
# Cache metrikleri kontrol
docker-compose exec app-monexa php artisan translation:cache-stats

# Redis memory kullanımı
docker-compose exec redis-monexa redis-cli INFO MEMORY

# Cache key distribution
docker-compose exec redis-monexa redis-cli --scan --pattern "trans:*" | wc -l
```

**Çözümler:**

1. **Cache TTL Artışı:**
```env
# .env
TRANSLATION_CACHE_TTL=7200  # 2 hours instead of 1
TRANSLATION_QUERY_CACHE_TTL=3600
```

2. **Cache Warming:**
```bash
# Tüm aktif diller için cache ısıtma
docker-compose exec app-monexa php artisan translation:warm-cache

# Belirli gruplar için
docker-compose exec app-monexa php artisan translation:warm-cache --groups=auth,admin
```

3. **Redis Memory Optimization:**
```bash
# Redis config update
docker-compose exec redis-monexa redis-cli CONFIG SET maxmemory 512mb
docker-compose exec redis-monexa redis-cli CONFIG SET maxmemory-policy allkeys-lru
```

### Problem: Redis Connection Timeout

**Belirtiler:**
- Connection timeout errors
- Intermittent cache failures
- "Connection refused" messages

**Diagnostic:**
```bash
# Redis connectivity test
docker-compose exec app-monexa redis-cli -h redis-monexa ping

# Check Redis process
docker-compose exec redis-monexa ps aux | grep redis

# Network connectivity
docker-compose exec app-monexa nc -zv redis-monexa 6379
```

**Çözümler:**

1. **Connection Pool Settings:**
```php
// config/database.php
'redis' => [
    'translation' => [
        'host' => env('REDIS_TRANSLATION_HOST', 'redis-monexa'),
        'port' => env('REDIS_TRANSLATION_PORT', '6379'),
        'database' => env('REDIS_TRANSLATION_DB', 2),
        'read_write_timeout' => 60,
        'timeout' => 5,
        'persistent' => true,
    ],
],
```

2. **Redis Service Restart:**
```bash
docker-compose restart redis-monexa
docker-compose exec app-monexa php artisan cache:clear
```

3. **Connection Health Monitoring:**
```bash
# Add to crontab for monitoring
*/5 * * * * docker-compose exec app-monexa php artisan translation:redis-health
```

### Problem: Cache Corruption/Invalid Data

**Belirtiler:**
- Wrong translations showing
- Mixed language content
- Serialization errors

**Diagnostic:**
```bash
# Check cache consistency
docker-compose exec redis-monexa redis-cli --scan --pattern "trans:*" | head -10

# Validate cache contents
docker-compose exec app-monexa php artisan tinker
>>> Cache::store('translation')->get('trans:tr:auth')
```

**Çözümler:**

1. **Full Cache Clear & Rebuild:**
```bash
docker-compose exec app-monexa php artisan cache:forget trans:*
docker-compose exec redis-monexa redis-cli FLUSHDB
docker-compose exec app-monexa php artisan translation:warm-cache
```

2. **Selective Cache Invalidation:**
```bash
# Clear specific language
docker-compose exec app-monexa php artisan translation:clear-cache --locale=tr

# Clear specific group
docker-compose exec app-monexa php artisan translation:clear-cache --group=auth
```

---

## 🗄️ Database Sorunları

### Problem: Slow Query Performance

**Belirtiler:**
- Translation loading >1 second
- High database CPU usage
- Query timeout errors

**Diagnostic:**
```sql
-- Check slow query log
SHOW VARIABLES LIKE 'slow_query_log';
SHOW VARIABLES LIKE 'long_query_time';

-- Analyze translation-specific queries
SELECT * FROM information_schema.processlist WHERE info LIKE '%phrase%';

-- Index usage analysis
EXPLAIN SELECT pt.translation 
FROM phrases p 
JOIN phrase_translations pt ON p.id = pt.phrase_id 
WHERE p.key = 'auth.login' AND pt.language_id = 1;
```

**Çözümler:**

1. **Missing Index Creation:**
```sql
-- Create essential indexes
CREATE INDEX idx_phrases_key_hash ON phrases(key(191));
CREATE INDEX idx_phrase_trans_lookup ON phrase_translations(phrase_id, language_id);
CREATE INDEX idx_languages_code ON languages(code);

-- Composite indexes for common queries
CREATE INDEX idx_phrases_key_group ON phrases(key, `group`);
CREATE INDEX idx_translations_reviewed ON phrase_translations(is_reviewed, language_id);
```

2. **Query Optimization:**
```bash
# Rebuild query cache
docker-compose exec mysql-monexa mysql -e "RESET QUERY CACHE;"

# Analyze table statistics
docker-compose exec mysql-monexa mysql -e "ANALYZE TABLE phrases, phrase_translations, languages;"
```

3. **Database Configuration Tuning:**
```ini
# my.cnf additions
innodb_buffer_pool_size = 2G
innodb_log_file_size = 512M
query_cache_size = 256M
tmp_table_size = 128M
max_heap_table_size = 128M
```

### Problem: Duplicate Key Errors

**Belirtiler:**
- "Duplicate entry" errors during import
- Constraint violation messages
- Import process failures

**Diagnostic:**
```sql
-- Find duplicate keys
SELECT key, COUNT(*) as count 
FROM phrases 
GROUP BY key 
HAVING count > 1;

-- Check constraint violations
SELECT * FROM information_schema.TABLE_CONSTRAINTS 
WHERE TABLE_NAME IN ('phrases', 'phrase_translations');
```

**Çözümler:**

1. **Duplicate Cleanup:**
```sql
-- Remove duplicates (keep the latest)
DELETE p1 FROM phrases p1
INNER JOIN phrases p2 
WHERE p1.id < p2.id AND p1.key = p2.key;

-- Verify cleanup
SELECT key, COUNT(*) FROM phrases GROUP BY key HAVING COUNT(*) > 1;
```

2. **Import Process Fix:**
```bash
# Use upsert instead of insert for imports
docker-compose exec app-monexa php artisan translation:import --mode=upsert file.xlsx
```

### Problem: Database Connection Pool Exhaustion

**Belirtiler:**
- "Too many connections" errors
- Connection timeout during peak times
- App becomes unresponsive

**Diagnostic:**
```sql
SHOW STATUS LIKE 'Threads_connected';
SHOW STATUS LIKE 'Max_used_connections';
SHOW VARIABLES LIKE 'max_connections';
```

**Çözümler:**

1. **Connection Pool Tuning:**
```ini
# my.cnf
max_connections = 200
wait_timeout = 600
interactive_timeout = 600
max_connect_errors = 10000
```

2. **Laravel Connection Management:**
```php
// config/database.php
'connections' => [
    'mysql' => [
        // ... existing config
        'options' => [
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            PDO::ATTR_PERSISTENT => false,
        ],
        'pool' => [
            'max_connections' => 10,
            'idle_timeout' => 300,
        ],
    ],
],
```

---

## 🚀 Performance Sorunları

### Problem: High Memory Usage

**Belirtiler:**
- Container memory warnings
- Out of memory errors
- Slow response times

**Diagnostic:**
```bash
# Container memory usage
docker stats --no-stream

# PHP memory usage
docker-compose exec app-monexa php -r "echo 'Peak: ' . memory_get_peak_usage(true) / 1024 / 1024 . ' MB\n';"

# Translation cache memory
docker-compose exec redis-monexa redis-cli INFO MEMORY
```

**Çözümler:**

1. **PHP Memory Limit Increase:**
```ini
# docker/php-fpm/php.ini
memory_limit = 512M
max_execution_time = 120
```

2. **Cache Optimization:**
```php
// Reduce cache payload size
'translation' => [
    'driver' => 'redis',
    'serializer' => 'igbinary', // More efficient
    'compress' => true,
    'compress_threshold' => 1024,
],
```

3. **Garbage Collection Tuning:**
```bash
# PHP-FPM process management
docker-compose exec app-monexa php artisan config:cache
docker-compose restart app-monexa
```

### Problem: High CPU Usage

**Belirtiler:**
- Server load averages >2.0
- Slow response times
- High container CPU usage

**Diagnostic:**
```bash
# System load
uptime

# Top processes in container
docker-compose exec app-monexa top

# PHP-FPM status
docker-compose exec app-monexa php-fpm7.4 -t
```

**Çözümler:**

1. **PHP-FPM Pool Optimization:**
```ini
# PHP-FPM pool config
pm = dynamic
pm.max_children = 50
pm.start_servers = 10
pm.min_spare_servers = 5
pm.max_spare_servers = 15
pm.process_idle_timeout = 60s
pm.max_requests = 500
```

2. **Opcache Configuration:**
```ini
opcache.enable = 1
opcache.memory_consumption = 256
opcache.interned_strings_buffer = 16
opcache.max_accelerated_files = 20000
opcache.validate_timestamps = 0
opcache.save_comments = 0
```

---

## 🔤 Translation Loading Sorunları

### Problem: Translation Keys Not Found

**Belirtiler:**
- Raw keys showing instead of translations
- "Translation not found" errors
- Fallback to key names

**Diagnostic:**
```bash
# Check if key exists in database
docker-compose exec app-monexa php artisan tinker
>>> \App\Models\Phrase::where('key', 'auth.login')->exists()

# Check cache contents
>>> Cache::store('translation')->get('trans:tr:auth')
```

**Çözümler:**

1. **Key Verification & Creation:**
```bash
# Search for missing keys
docker-compose exec app-monexa php artisan translation:verify-keys

# Import missing keys from template
docker-compose exec app-monexa php artisan translation:import-missing
```

2. **Fallback Mechanism Fix:**
```php
// Ensure fallback is working
// In TranslationService
public function translate($key, $locale = null, $parameters = [])
{
    $translation = $this->getTranslation($key, $locale);
    
    if (!$translation && $locale !== $this->fallbackLocale) {
        $translation = $this->getTranslation($key, $this->fallbackLocale);
    }
    
    return $translation ?: $key; // Return key as last resort
}
```

### Problem: Wrong Language Displaying

**Belirtiler:**
- User seeing wrong language content
- Mixed language content on same page
- Locale not switching properly

**Diagnostic:**
```bash
# Check current locale
docker-compose exec app-monexa php artisan tinker
>>> app()->getLocale()
>>> session()->get('locale')

# Check middleware execution
tail -f storage/logs/laravel.log | grep SetLocale
```

**Çözümler:**

1. **Locale Middleware Fix:**
```php
// app/Http/Middleware/SetLocale.php
public function handle($request, Closure $next)
{
    $locale = $request->session()->get('locale') 
        ?? $request->cookie('locale')
        ?? $this->detectBrowserLocale($request)
        ?? config('app.locale');
    
    if (in_array($locale, config('app.available_locales'))) {
        app()->setLocale($locale);
        $request->session()->put('locale', $locale);
    }
    
    return $next($request);
}
```

2. **Session Storage Fix:**
```bash
# Clear sessions
docker-compose exec app-monexa php artisan session:flush

# Check session driver
grep SESSION_DRIVER .env
```

### Problem: Pluralization Not Working

**Belirtiler:**
- Wrong plural forms
- Numbers not formatted correctly
- Choice strings showing raw

**Diagnostic:**
```bash
# Test pluralization
docker-compose exec app-monexa php artisan tinker
>>> trans_choice('messages.comments', 0)
>>> trans_choice('messages.comments', 1)  
>>> trans_choice('messages.comments', 5)
```

**Çözümler:**

1. **Pluralization Rules:**
```php
// Ensure proper plural rules in database
// messages.comments should be stored as: "yorum yok|1 yorum|:count yorum"
```

2. **Custom Plural Logic:**
```php
// For Turkish pluralization
public function choice($key, $number, array $replace = [], $locale = null)
{
    $locale = $locale ?: app()->getLocale();
    
    if ($locale === 'tr') {
        return $this->turkishPluralization($key, $number, $replace);
    }
    
    return parent::choice($key, $number, $replace, $locale);
}
```

---

## 👨‍💼 Admin Panel Sorunları

### Problem: Admin Panel Loading Slowly

**Belirtiler:**
- Admin phrases page >5 seconds load time
- Pagination timeout
- Search functionality slow

**Diagnostic:**
```bash
# Check admin query performance
docker-compose exec app-monexa php artisan translation:admin-performance

# Database query log
tail -f storage/logs/queries.log | grep phrases
```

**Çözümler:**

1. **Pagination Optimization:**
```php
// PhrasesController
public function index(Request $request)
{
    $phrases = $this->repository
        ->with(['translations', 'language'])
        ->select(['id', 'key', 'group', 'created_at']) // Limit columns
        ->paginate(50); // Reduce page size
        
    return view('admin.phrases.index', compact('phrases'));
}
```

2. **Search Index Creation:**
```sql
-- Full-text search indexes
ALTER TABLE phrases ADD FULLTEXT idx_key_desc (key, description);
ALTER TABLE phrase_translations ADD FULLTEXT idx_translation (translation);
```

### Problem: Bulk Operations Timing Out

**Belirtiler:**
- Bulk update/delete operations fail
- Timeout errors during import
- Progress indicator stuck

**Diagnostic:**
```bash
# Check PHP execution limits
docker-compose exec app-monexa php -i | grep max_execution_time
docker-compose exec app-monexa php -i | grep memory_limit

# Check for locked tables
docker-compose exec mysql-monexa mysql -e "SHOW OPEN TABLES WHERE In_use > 0;"
```

**Çözümler:**

1. **Batch Processing:**
```php
// Implement chunked processing
public function bulkUpdate(array $updates)
{
    $chunks = array_chunk($updates, 50);
    
    foreach ($chunks as $chunk) {
        DB::transaction(function () use ($chunk) {
            foreach ($chunk as $update) {
                $this->updateTranslation($update);
            }
        });
        
        // Prevent memory buildup
        if (memory_get_usage() > 200 * 1024 * 1024) {
            gc_collect_cycles();
        }
    }
}
```

2. **Queue Implementation:**
```bash
# Use queues for heavy operations
docker-compose exec app-monexa php artisan queue:work --timeout=300
```

### Problem: Import/Export Failures

**Belirtiler:**
- Excel files not uploading
- Export downloads corrupted
- Format validation errors

**Diagnostic:**
```bash
# Check file permissions
ls -la storage/app/translations/

# Check upload limits
docker-compose exec app-monexa php -i | grep upload_max_filesize
docker-compose exec app-monexa php -i | grep post_max_size
```

**Çözümler:**

1. **PHP Upload Limits:**
```ini
# php.ini
upload_max_filesize = 10M
post_max_size = 12M
max_file_uploads = 20
```

2. **File Processing Fix:**
```php
// Ensure proper file handling
public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv|max:10240', // 10MB max
    ]);
    
    try {
        $import = new TranslationImport();
        Excel::import($import, $request->file('file'));
        
        return response()->json(['success' => true]);
    } catch (Exception $e) {
        Log::error('Translation import failed', ['error' => $e->getMessage()]);
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}
```

---

## 🌐 API Endpoint Sorunları

### Problem: API Rate Limiting

**Belirtiler:**
- "Too Many Attempts" errors
- API requests being blocked
- 429 HTTP status codes

**Diagnostic:**
```bash
# Check rate limit configuration
grep RATE_LIMIT .env

# Check Laravel rate limiter
docker-compose exec app-monexa php artisan route:list | grep translation
```

**Çözümler:**

1. **Rate Limit Configuration:**
```php
// RouteServiceProvider
RateLimiter::for('translation-api', function (Request $request) {
    return Limit::perMinute(200)->by($request->ip()); // Increase limit
});
```

2. **Bypass for Admin Users:**
```php
// Middleware for API routes
public function handle($request, Closure $next)
{
    if ($request->user() && $request->user()->isAdmin()) {
        return $next($request); // Skip rate limiting for admins
    }
    
    return RateLimiter::attempt('translation-api', 60, function() use ($next, $request) {
        return $next($request);
    });
}
```

### Problem: API Response Format Inconsistency

**Belirtiler:**
- Different response structures
- Missing data fields
- JSON structure changes

**Diagnostic:**
```bash
# Test API endpoints
curl -X GET "http://localhost:8080/api/v1/translations/tr" \
  -H "Accept: application/json" | jq '.'
```

**Çözümler:**

1. **Response Standardization:**
```php
// ApiController base class
protected function successResponse($data, $message = null, $code = 200)
{
    return response()->json([
        'success' => true,
        'data' => $data,
        'message' => $message,
        'timestamp' => now()->toISOString(),
    ], $code);
}

protected function errorResponse($message, $code = 400, $errors = null)
{
    return response()->json([
        'success' => false,
        'message' => $message,
        'errors' => $errors,
        'timestamp' => now()->toISOString(),
    ], $code);
}
```

---

## 🚀 Deployment Sorunları

### Problem: Migration Failures During Deployment

**Belirtiler:**
- Migration timeout errors
- Rollback failures
- Database schema inconsistencies

**Diagnostic:**
```bash
# Check migration status
docker-compose exec app-monexa php artisan migrate:status

# Check database connection
docker-compose exec app-monexa php artisan tinker
>>> DB::connection()->getPdo()
```

**Çözümler:**

1. **Safe Migration Process:**
```bash
# Pre-deployment checks
docker-compose exec app-monexa php artisan migrate --pretend

# Backup before migration
mysqldump -u root -p monexa_db > backup_pre_migration_$(date +%Y%m%d).sql

# Run migrations with increased timeout
docker-compose exec app-monexa php artisan migrate --timeout=300
```

2. **Migration Rollback Plan:**
```bash
# Automated rollback script
#!/bin/bash
if ! docker-compose exec app-monexa php artisan migrate:status | grep -q "Ran"; then
    echo "Migration failed, rolling back..."
    docker-compose exec app-monexa php artisan migrate:rollback
    mysql -u root -p monexa_db < backup_pre_migration_$(date +%Y%m%d).sql
fi
```

### Problem: Docker Container Startup Issues

**Belirtiler:**
- Containers not starting
- Service dependencies failing
- Network connectivity issues

**Diagnostic:**
```bash
# Container logs
docker-compose logs --tail=100

# Network connectivity
docker network ls
docker network inspect proxy-network
```

**Çözümler:**

1. **Dependency Order Fix:**
```yaml
# docker-compose.yml
services:
  app-monexa:
    depends_on:
      mysql-monexa:
        condition: service_healthy
      redis-monexa:
        condition: service_healthy
```

2. **Health Check Implementation:**
```yaml
# Add health checks
mysql-monexa:
  healthcheck:
    test: ["CMD", "mysqladmin", "ping", "-h", "localhost"]
    timeout: 20s
    retries: 10
    
redis-monexa:
  healthcheck:
    test: ["CMD", "redis-cli", "ping"]
    timeout: 3s
    retries: 5
```

---

## 🚨 Emergency Procedures

### Complete System Failure Recovery

**Scenario: Translation system completely down**

```bash
#!/bin/bash
# emergency-recovery.sh

echo "🚨 EMERGENCY TRANSLATION SYSTEM RECOVERY"

# 1. Stop all services
docker-compose down

# 2. Clean up
docker-compose rm -f
docker volume prune -f

# 3. Restore from backup
mysql -u root -p monexa_db < latest_backup.sql

# 4. Start services with health check
docker-compose up -d --force-recreate

# 5. Wait for services to be ready
echo "Waiting for services..."
sleep 30

# 6. Verify system health
docker-compose exec app-monexa php artisan translation:health-check

# 7. Warm cache
docker-compose exec app-monexa php artisan translation:warm-cache

echo "✅ Recovery complete"
```

### Data Corruption Recovery

**Scenario: Translation data corrupted**

```bash
# 1. Immediate backup of current state
mysqldump -u root -p monexa_db > corrupted_state_$(date +%Y%m%d_%H%M%S).sql

# 2. Stop application
docker-compose exec app-monexa php artisan down

# 3. Restore from last known good backup
mysql -u root -p monexa_db < last_good_backup.sql

# 4. Verify data integrity
docker-compose exec app-monexa php artisan translation:verify-integrity

# 5. Clear all caches
docker-compose exec app-monexa php artisan cache:clear
docker-compose exec redis-monexa redis-cli FLUSHALL

# 6. Rebuild caches
docker-compose exec app-monexa php artisan translation:warm-cache

# 7. Start application
docker-compose exec app-monexa php artisan up
```

### Emergency Contact Information

```
🆘 EMERGENCY CONTACTS

Technical Lead: [Phone/Email]
Database Admin: [Phone/Email]  
DevOps Engineer: [Phone/Email]
System Administrator: [Phone/Email]

🔧 EMERGENCY COMMANDS

# Immediate system stop
docker-compose down

# Emergency backup
./scripts/emergency-backup.sh

# System status
./scripts/system-status.sh

# Recovery procedure  
./scripts/emergency-recovery.sh
```

---

## 📝 Preventive Maintenance

### Daily Checks

```bash
#!/bin/bash
# daily-health-check.sh

echo "=== DAILY TRANSLATION SYSTEM HEALTH CHECK ==="

# 1. Cache hit rate
echo "Cache Hit Rate:"
docker-compose exec app-monexa php artisan translation:cache-stats --format=simple

# 2. Database health
echo "Database Health:"
docker-compose exec mysql-monexa mysqladmin status

# 3. Response time test
echo "Response Time Test:"
time curl -s http://localhost:8080/api/v1/translations/tr > /dev/null

# 4. Error log check
echo "Recent Errors:"
tail -n 20 storage/logs/laravel.log | grep ERROR
```

### Weekly Maintenance

```bash
#!/bin/bash
# weekly-maintenance.sh

echo "=== WEEKLY TRANSLATION SYSTEM MAINTENANCE ==="

# 1. Cache cleanup
docker-compose exec app-monexa php artisan translation:cleanup-cache

# 2. Database optimization
docker-compose exec mysql-monexa mysql -e "OPTIMIZE TABLE phrases, phrase_translations, languages;"

# 3. Log rotation
find storage/logs -name "*.log" -mtime +7 -delete

# 4. Performance report
docker-compose exec app-monexa php artisan translation:performance-report --export
```

### Monthly Reviews

- Cache performance trends
- Database growth analysis  
- Error pattern review
- Performance baseline updates
- Security audit
- Backup integrity verification

---

Bu troubleshooting kılavuzu, translation sistemiyle ilgili yaygın sorunları ve çözüm yöntemlerini kapsamaktadır. Herhangi bir sorunla karşılaştığınızda önce bu kılavuzu kontrol edin, ardından gerektiğinde emergency procedures'ları uygulayın.