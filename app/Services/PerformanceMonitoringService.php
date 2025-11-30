<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

class PerformanceMonitoringService
{
    private const METRICS_PREFIX = 'translation_metrics:';
    private const QUERY_LOG_KEY = 'translation_query_log';
    private const CACHE_METRICS_KEY = 'translation_cache_metrics';
    private const SLOW_QUERY_THRESHOLD = 100; // 100ms
    
    /**
     * Cache performans metriklerini takip et
     */
    public function recordCacheHit(string $key, string $operation): void
    {
        $this->incrementMetric('cache.hits.' . $operation);
        $this->incrementMetric('cache.hits.total');
        
        // Günlük cache istatistikleri
        $this->recordDailyMetric('cache.hits', $operation);
    }

    /**
     * Cache miss kaydet
     */
    public function recordCacheMiss(string $key, string $operation): void
    {
        $this->incrementMetric('cache.misses.' . $operation);
        $this->incrementMetric('cache.misses.total');
        
        // Günlük cache istatistikleri
        $this->recordDailyMetric('cache.misses', $operation);
    }

    /**
     * Query performansını izle
     */
    public function recordQuery(string $query, float $executionTime, array $bindings = []): void
    {
        $this->incrementMetric('queries.total');
        $this->recordQueryTime($executionTime);
        
        // Yavaş sorguları logla
        if ($executionTime > self::SLOW_QUERY_THRESHOLD) {
            $this->recordSlowQuery($query, $executionTime, $bindings);
        }
        
        // Günlük query istatistikleri
        $this->recordDailyMetric('queries.count');
        $this->recordDailyMetric('queries.avg_time', null, $executionTime);
    }

    /**
     * Cache invalidation eventi kaydet
     */
    public function recordCacheInvalidation(string $pattern, int $keysCleared): void
    {
        $this->incrementMetric('cache.invalidations.total');
        $this->incrementMetric('cache.keys_cleared.total', $keysCleared);
        
        Log::info('Translation cache invalidation', [
            'pattern' => $pattern,
            'keys_cleared' => $keysCleared,
            'timestamp' => now()
        ]);
    }

    /**
     * Translation lookup performansını kaydet
     */
    public function recordTranslationLookup(string $key, string $locale, float $executionTime, bool $cached = false): void
    {
        $this->incrementMetric('translations.lookups.total');
        $this->incrementMetric('translations.lookups.' . $locale);
        
        if ($cached) {
            $this->incrementMetric('translations.cached.total');
        } else {
            $this->incrementMetric('translations.database.total');
        }
        
        $this->recordDailyMetric('translations.lookup_time', $locale, $executionTime);
    }

    /**
     * Cache performans raporu al
     */
    public function getCachePerformanceReport(): array
    {
        $hits = $this->getMetric('cache.hits.total', 0);
        $misses = $this->getMetric('cache.misses.total', 0);
        $total = $hits + $misses;
        
        $hitRate = $total > 0 ? round(($hits / $total) * 100, 2) : 0;
        
        return [
            'cache_hits' => $hits,
            'cache_misses' => $misses,
            'hit_rate' => $hitRate,
            'total_requests' => $total,
            'operations' => [
                'phrase_lookup' => [
                    'hits' => $this->getMetric('cache.hits.phrase_lookup', 0),
                    'misses' => $this->getMetric('cache.misses.phrase_lookup', 0),
                ],
                'language_list' => [
                    'hits' => $this->getMetric('cache.hits.language_list', 0),
                    'misses' => $this->getMetric('cache.misses.language_list', 0),
                ],
                'translation_get' => [
                    'hits' => $this->getMetric('cache.hits.translation_get', 0),
                    'misses' => $this->getMetric('cache.misses.translation_get', 0),
                ],
            ]
        ];
    }

    /**
     * Query performans raporu al
     */
    public function getQueryPerformanceReport(): array
    {
        $totalQueries = $this->getMetric('queries.total', 0);
        $slowQueries = $this->getMetric('queries.slow', 0);
        
        return [
            'total_queries' => $totalQueries,
            'slow_queries' => $slowQueries,
            'slow_query_rate' => $totalQueries > 0 ? round(($slowQueries / $totalQueries) * 100, 2) : 0,
            'average_query_time' => $this->getAverageQueryTime(),
            'recent_slow_queries' => $this->getRecentSlowQueries()
        ];
    }

    /**
     * Translation sistem performans özeti
     */
    public function getPerformanceSummary(): array
    {
        $cacheReport = $this->getCachePerformanceReport();
        $queryReport = $this->getQueryPerformanceReport();
        
        return [
            'cache' => $cacheReport,
            'queries' => $queryReport,
            'translations' => [
                'total_lookups' => $this->getMetric('translations.lookups.total', 0),
                'cached_lookups' => $this->getMetric('translations.cached.total', 0),
                'database_lookups' => $this->getMetric('translations.database.total', 0),
                'languages' => [
                    'tr' => $this->getMetric('translations.lookups.tr', 0),
                    'ru' => $this->getMetric('translations.lookups.ru', 0),
                ],
            ],
            'system_health' => $this->calculateSystemHealth($cacheReport, $queryReport),
        ];
    }

    /**
     * Günlük performans raporu
     */
    public function getDailyReport(string $date = null): array
    {
        $date = $date ?? now()->format('Y-m-d');
        
        return [
            'date' => $date,
            'cache' => [
                'hits' => $this->getDailyMetric('cache.hits', $date),
                'misses' => $this->getDailyMetric('cache.misses', $date),
            ],
            'queries' => [
                'count' => $this->getDailyMetric('queries.count', $date),
                'avg_time' => $this->getDailyMetric('queries.avg_time', $date),
            ],
            'translations' => [
                'tr' => $this->getDailyMetric('translations.lookup_time', $date, 'tr'),
                'ru' => $this->getDailyMetric('translations.lookup_time', $date, 'ru'),
            ],
        ];
    }

    /**
     * Performance temizlik (eski verileri sil)
     */
    public function cleanupOldMetrics(int $daysToKeep = 30): void
    {
        $cutoffDate = now()->subDays($daysToKeep);
        
        // Eski günlük metrikleri temizle
        $pattern = self::METRICS_PREFIX . 'daily:*';
        $keys = Redis::keys($pattern);
        
        foreach ($keys as $key) {
            // Key'den tarihi çıkar
            if (preg_match('/daily:(\d{4}-\d{2}-\d{2})/', $key, $matches)) {
                $date = Carbon::parse($matches[1]);
                if ($date->lt($cutoffDate)) {
                    Redis::del($key);
                }
            }
        }
        
        // Eski slow query loglarını temizle
        $this->cleanupSlowQueryLogs($daysToKeep);
    }

    /**
     * Redis bağlantı sağlığını kontrol et
     */
    public function checkRedisHealth(): array
    {
        try {
            $start = microtime(true);
            Redis::ping();
            $latency = (microtime(true) - $start) * 1000; // ms
            
            $info = Redis::info();
            
            return [
                'status' => 'healthy',
                'latency' => round($latency, 2),
                'memory_usage' => $info['used_memory_human'] ?? 'unknown',
                'connected_clients' => $info['connected_clients'] ?? 0,
                'total_commands_processed' => $info['total_commands_processed'] ?? 0,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Metrik değerini artır
     */
    private function incrementMetric(string $key, int $amount = 1): void
    {
        Redis::incrby(self::METRICS_PREFIX . $key, $amount);
        
        // Metrik TTL set et (7 gün)
        Redis::expire(self::METRICS_PREFIX . $key, 604800);
    }

    /**
     * Metrik değerini al
     */
    private function getMetric(string $key, int $default = 0): int
    {
        return Redis::get(self::METRICS_PREFIX . $key) ?? $default;
    }

    /**
     * Query süresini kaydet
     */
    private function recordQueryTime(float $time): void
    {
        // Moving average hesapla
        $currentAvg = $this->getMetric('queries.avg_time_raw', 0);
        $count = $this->getMetric('queries.count_for_avg', 0);
        
        $newAvg = ($currentAvg * $count + $time) / ($count + 1);
        
        Redis::set(self::METRICS_PREFIX . 'queries.avg_time_raw', $newAvg);
        $this->incrementMetric('queries.count_for_avg');
    }

    /**
     * Yavaş sorguları kaydet
     */
    private function recordSlowQuery(string $query, float $time, array $bindings): void
    {
        $this->incrementMetric('queries.slow');
        
        $slowQueryData = [
            'query' => $query,
            'execution_time' => $time,
            'bindings' => $bindings,
            'timestamp' => now()->toISOString(),
        ];
        
        Redis::lpush(self::SLOW_QUERY_LOG_KEY, json_encode($slowQueryData));
        Redis::ltrim(self::SLOW_QUERY_LOG_KEY, 0, 99); // Son 100 slow query'yi sakla
    }

    /**
     * Günlük metrik kaydet
     */
    private function recordDailyMetric(string $type, string $subkey = null, float $value = null): void
    {
        $date = now()->format('Y-m-d');
        $key = self::METRICS_PREFIX . "daily:{$date}:{$type}";
        
        if ($subkey) {
            $key .= ":{$subkey}";
        }
        
        if ($value !== null) {
            // Ortalama hesapla
            $currentTotal = Redis::hget($key, 'total') ?? 0;
            $currentCount = Redis::hget($key, 'count') ?? 0;
            
            Redis::hset($key, 'total', $currentTotal + $value);
            Redis::hset($key, 'count', $currentCount + 1);
            Redis::hset($key, 'avg', ($currentTotal + $value) / ($currentCount + 1));
        } else {
            Redis::hincrby($key, 'count', 1);
        }
        
        Redis::expire($key, 2592000); // 30 gün
    }

    /**
     * Günlük metrik al
     */
    private function getDailyMetric(string $type, string $date, string $subkey = null): array
    {
        $key = self::METRICS_PREFIX . "daily:{$date}:{$type}";
        
        if ($subkey) {
            $key .= ":{$subkey}";
        }
        
        $data = Redis::hgetall($key);
        
        return [
            'count' => $data['count'] ?? 0,
            'total' => $data['total'] ?? 0,
            'avg' => $data['avg'] ?? 0,
        ];
    }

    /**
     * Ortalama query süresi
     */
    private function getAverageQueryTime(): float
    {
        return $this->getMetric('queries.avg_time_raw', 0);
    }

    /**
     * Son yavaş sorguları al
     */
    private function getRecentSlowQueries(int $limit = 10): array
    {
        $queries = Redis::lrange(self::SLOW_QUERY_LOG_KEY, 0, $limit - 1);
        
        return array_map(function ($query) {
            return json_decode($query, true);
        }, $queries);
    }

    /**
     * Sistem sağlığını hesapla
     */
    private function calculateSystemHealth(array $cacheReport, array $queryReport): string
    {
        $score = 100;
        
        // Cache hit rate kontrolü
        if ($cacheReport['hit_rate'] < 70) {
            $score -= 20;
        } elseif ($cacheReport['hit_rate'] < 85) {
            $score -= 10;
        }
        
        // Slow query rate kontrolü
        if ($queryReport['slow_query_rate'] > 10) {
            $score -= 30;
        } elseif ($queryReport['slow_query_rate'] > 5) {
            $score -= 15;
        }
        
        // Average query time kontrolü
        if ($queryReport['average_query_time'] > 200) {
            $score -= 25;
        } elseif ($queryReport['average_query_time'] > 100) {
            $score -= 10;
        }
        
        if ($score >= 90) return 'excellent';
        if ($score >= 80) return 'good';
        if ($score >= 60) return 'fair';
        return 'poor';
    }

    /**
     * Eski slow query loglarını temizle
     */
    private function cleanupSlowQueryLogs(int $daysToKeep): void
    {
        $cutoffTime = now()->subDays($daysToKeep);
        
        // Slow query listesini temizle
        $queries = Redis::lrange(self::SLOW_QUERY_LOG_KEY, 0, -1);
        
        foreach ($queries as $index => $queryJson) {
            $queryData = json_decode($queryJson, true);
            $timestamp = Carbon::parse($queryData['timestamp']);
            
            if ($timestamp->lt($cutoffTime)) {
                Redis::lrem(self::SLOW_QUERY_LOG_KEY, 0, $queryJson);
            }
        }
    }
}