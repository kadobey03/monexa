<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use Illuminate\Cache\TaggedCache;

class CacheService
{
    /**
     * Cache store to use.
     */
    protected string $store;

    /**
     * Cache key prefix for translation system.
     */
    protected string $prefix;

    /**
     * Default cache TTL in minutes.
     */
    protected int $defaultTtl;

    /**
     * Constructor.
     *
     * @param string|null $store
     * @param string $prefix
     * @param int $defaultTtl
     */
    public function __construct(?string $store = null, string $prefix = 'translation', int $defaultTtl = 60)
    {
        $this->store = $store ?: config('cache.default', 'redis');
        $this->prefix = $prefix;
        $this->defaultTtl = $defaultTtl;
    }

    /**
     * Get value from cache.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        try {
            return Cache::store($this->store)->get($this->prefixKey($key), $default);
        } catch (\Exception $e) {
            Log::warning('Cache get failed', [
                'key' => $key,
                'store' => $this->store,
                'error' => $e->getMessage()
            ]);
            
            return $default;
        }
    }

    /**
     * Store value in cache.
     *
     * @param string $key
     * @param mixed $value
     * @param int|null $ttl
     * @return bool
     */
    public function put(string $key, $value, ?int $ttl = null): bool
    {
        try {
            $ttl = $ttl ?: $this->defaultTtl;
            
            return Cache::store($this->store)->put(
                $this->prefixKey($key), 
                $value, 
                now()->addMinutes($ttl)
            );
        } catch (\Exception $e) {
            Log::warning('Cache put failed', [
                'key' => $key,
                'store' => $this->store,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Remember value in cache.
     *
     * @param string $key
     * @param callable $callback
     * @param int|null $ttl
     * @return mixed
     */
    public function remember(string $key, callable $callback, ?int $ttl = null)
    {
        try {
            $ttl = $ttl ?: $this->defaultTtl;
            
            return Cache::store($this->store)->remember(
                $this->prefixKey($key),
                now()->addMinutes($ttl),
                $callback
            );
        } catch (\Exception $e) {
            Log::warning('Cache remember failed', [
                'key' => $key,
                'store' => $this->store,
                'error' => $e->getMessage()
            ]);
            
            // Fallback to direct callback execution
            return $callback();
        }
    }

    /**
     * Remember value in cache forever.
     *
     * @param string $key
     * @param callable $callback
     * @return mixed
     */
    public function rememberForever(string $key, callable $callback)
    {
        try {
            return Cache::store($this->store)->rememberForever(
                $this->prefixKey($key),
                $callback
            );
        } catch (\Exception $e) {
            Log::warning('Cache rememberForever failed', [
                'key' => $key,
                'store' => $this->store,
                'error' => $e->getMessage()
            ]);
            
            return $callback();
        }
    }

    /**
     * Check if key exists in cache.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        try {
            return Cache::store($this->store)->has($this->prefixKey($key));
        } catch (\Exception $e) {
            Log::warning('Cache has failed', [
                'key' => $key,
                'store' => $this->store,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Remove key from cache.
     *
     * @param string $key
     * @return bool
     */
    public function forget(string $key): bool
    {
        try {
            return Cache::store($this->store)->forget($this->prefixKey($key));
        } catch (\Exception $e) {
            Log::warning('Cache forget failed', [
                'key' => $key,
                'store' => $this->store,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Remove multiple keys from cache.
     *
     * @param array $keys
     * @return bool
     */
    public function forgetMultiple(array $keys): bool
    {
        try {
            $prefixedKeys = array_map([$this, 'prefixKey'], $keys);
            
            return Cache::store($this->store)->deleteMultiple($prefixedKeys);
        } catch (\Exception $e) {
            Log::warning('Cache forgetMultiple failed', [
                'keys' => $keys,
                'store' => $this->store,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Remove keys matching pattern.
     *
     * @param string $pattern
     * @return int
     */
    public function forgetPattern(string $pattern): int
    {
        try {
            if ($this->store === 'redis') {
                return $this->forgetRedisPattern($pattern);
            }
            
            // For other cache stores, we can't efficiently pattern match
            // This would require listing all keys which is expensive
            Log::warning('Pattern forgetting not supported for store', [
                'store' => $this->store,
                'pattern' => $pattern
            ]);
            
            return 0;
        } catch (\Exception $e) {
            Log::warning('Cache forgetPattern failed', [
                'pattern' => $pattern,
                'store' => $this->store,
                'error' => $e->getMessage()
            ]);
            
            return 0;
        }
    }

    /**
     * Clear all cache.
     *
     * @return bool
     */
    public function flush(): bool
    {
        try {
            return Cache::store($this->store)->flush();
        } catch (\Exception $e) {
            Log::warning('Cache flush failed', [
                'store' => $this->store,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Get cache with tags.
     *
     * @param array $tags
     * @return TaggedCache|static
     */
    public function tags(array $tags)
    {
        try {
            return Cache::store($this->store)->tags($tags);
        } catch (\Exception $e) {
            Log::warning('Cache tags failed', [
                'tags' => $tags,
                'store' => $this->store,
                'error' => $e->getMessage()
            ]);
            
            // Return self if tagging not supported
            return $this;
        }
    }

    /**
     * Increment cache value.
     *
     * @param string $key
     * @param int $value
     * @return int|bool
     */
    public function increment(string $key, int $value = 1)
    {
        try {
            return Cache::store($this->store)->increment($this->prefixKey($key), $value);
        } catch (\Exception $e) {
            Log::warning('Cache increment failed', [
                'key' => $key,
                'value' => $value,
                'store' => $this->store,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Decrement cache value.
     *
     * @param string $key
     * @param int $value
     * @return int|bool
     */
    public function decrement(string $key, int $value = 1)
    {
        try {
            return Cache::store($this->store)->decrement($this->prefixKey($key), $value);
        } catch (\Exception $e) {
            Log::warning('Cache decrement failed', [
                'key' => $key,
                'value' => $value,
                'store' => $this->store,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Add value to cache only if it doesn't exist.
     *
     * @param string $key
     * @param mixed $value
     * @param int|null $ttl
     * @return bool
     */
    public function add(string $key, $value, ?int $ttl = null): bool
    {
        try {
            $ttl = $ttl ?: $this->defaultTtl;
            
            return Cache::store($this->store)->add(
                $this->prefixKey($key), 
                $value, 
                now()->addMinutes($ttl)
            );
        } catch (\Exception $e) {
            Log::warning('Cache add failed', [
                'key' => $key,
                'store' => $this->store,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Get multiple values from cache.
     *
     * @param array $keys
     * @return array
     */
    public function getMultiple(array $keys): array
    {
        try {
            $prefixedKeys = array_map([$this, 'prefixKey'], $keys);
            $results = Cache::store($this->store)->getMultiple($prefixedKeys);
            
            // Remove prefix from result keys
            $unprefixedResults = [];
            foreach ($results as $prefixedKey => $value) {
                $originalKey = $this->unprefixKey($prefixedKey);
                $unprefixedResults[$originalKey] = $value;
            }
            
            return $unprefixedResults;
        } catch (\Exception $e) {
            Log::warning('Cache getMultiple failed', [
                'keys' => $keys,
                'store' => $this->store,
                'error' => $e->getMessage()
            ]);
            
            return [];
        }
    }

    /**
     * Set multiple values in cache.
     *
     * @param array $values
     * @param int|null $ttl
     * @return bool
     */
    public function setMultiple(array $values, ?int $ttl = null): bool
    {
        try {
            $ttl = $ttl ?: $this->defaultTtl;
            $prefixedValues = [];
            
            foreach ($values as $key => $value) {
                $prefixedValues[$this->prefixKey($key)] = $value;
            }
            
            return Cache::store($this->store)->setMultiple(
                $prefixedValues, 
                now()->addMinutes($ttl)
            );
        } catch (\Exception $e) {
            Log::warning('Cache setMultiple failed', [
                'values_count' => count($values),
                'store' => $this->store,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Get cache statistics.
     *
     * @return array
     */
    public function getStats(): array
    {
        try {
            if ($this->store === 'redis') {
                return $this->getRedisStats();
            }
            
            // Basic stats for other stores
            return [
                'store' => $this->store,
                'prefix' => $this->prefix,
                'default_ttl' => $this->defaultTtl
            ];
        } catch (\Exception $e) {
            Log::warning('Cache getStats failed', [
                'store' => $this->store,
                'error' => $e->getMessage()
            ]);
            
            return [];
        }
    }

    /**
     * Warm up cache with predefined data.
     *
     * @param array $data
     * @param int|null $ttl
     * @return int
     */
    public function warmUp(array $data, ?int $ttl = null): int
    {
        $count = 0;
        $ttl = $ttl ?: $this->defaultTtl;
        
        foreach ($data as $key => $value) {
            if ($this->put($key, $value, $ttl)) {
                $count++;
            }
        }
        
        return $count;
    }

    /**
     * Create cache key with prefix.
     *
     * @param string $key
     * @return string
     */
    protected function prefixKey(string $key): string
    {
        return $this->prefix . ':' . $key;
    }

    /**
     * Remove prefix from cache key.
     *
     * @param string $key
     * @return string
     */
    protected function unprefixKey(string $key): string
    {
        $prefix = $this->prefix . ':';
        
        if (str_starts_with($key, $prefix)) {
            return substr($key, strlen($prefix));
        }
        
        return $key;
    }

    /**
     * Remove keys matching Redis pattern.
     *
     * @param string $pattern
     * @return int
     */
    protected function forgetRedisPattern(string $pattern): int
    {
        try {
            $redis = Redis::connection();
            $prefixedPattern = $this->prefixKey($pattern);
            
            // Get all keys matching pattern
            $keys = $redis->keys($prefixedPattern);
            
            if (empty($keys)) {
                return 0;
            }
            
            // Delete keys in batches
            $batchSize = 100;
            $deleted = 0;
            
            for ($i = 0; $i < count($keys); $i += $batchSize) {
                $batch = array_slice($keys, $i, $batchSize);
                $deleted += $redis->del($batch);
            }
            
            return $deleted;
        } catch (\Exception $e) {
            Log::warning('Redis pattern deletion failed', [
                'pattern' => $pattern,
                'error' => $e->getMessage()
            ]);
            
            return 0;
        }
    }

    /**
     * Get Redis cache statistics.
     *
     * @return array
     */
    protected function getRedisStats(): array
    {
        try {
            $redis = Redis::connection();
            $info = $redis->info('memory');
            
            return [
                'store' => $this->store,
                'prefix' => $this->prefix,
                'default_ttl' => $this->defaultTtl,
                'memory_used' => $info['used_memory_human'] ?? 'Unknown',
                'memory_peak' => $info['used_memory_peak_human'] ?? 'Unknown',
                'connected_clients' => $redis->info('clients')['connected_clients'] ?? 0,
                'total_commands_processed' => $redis->info('stats')['total_commands_processed'] ?? 0,
            ];
        } catch (\Exception $e) {
            return [
                'store' => $this->store,
                'prefix' => $this->prefix,
                'default_ttl' => $this->defaultTtl,
                'error' => $e->getMessage()
            ];
        }
    }
}