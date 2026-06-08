<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Closure;

class CacheManagerService
{
    public function remember(string $strategyKey, array $parameters, Closure $callback)
    {
        $strategy = $this->getStrategy($strategyKey);
        
        $key = $this->buildKey($strategy['key'], $parameters);
        
        $ttl = $strategy['ttl'];

        if (is_null($ttl) || $ttl === 0) {
            return Cache::rememberForever($key, $callback);
        }

        return Cache::remember($key, $ttl, $callback);
    }

    public function forget(string $strategyKey, array $parameters): void
    {
        $strategy = $this->getStrategy($strategyKey);
        
        $key = $this->buildKey($strategy['key'], $parameters);

        Cache::forget($key);
    }

    private function getStrategy(string $strategyKey): array
    {
        $strategy = config("cache_strategy.{$strategyKey}");

        if (!$strategy) {
            throw new \Exception("Cache Strategy Not Found: {$strategyKey}");
        }

        return $strategy;
    }

    private function buildKey(string $keyFormat, array $parameters): string
    {
        return vsprintf($keyFormat, $parameters);
    }
}
