<?php

namespace App\Models\Concerns;

use App\Support\LandingCache;

trait ClearsLandingCache
{
    protected static function bootClearsLandingCache(): void
    {
        static::saved(fn () => LandingCache::forget());
        static::deleted(fn () => LandingCache::forget());
    }
}
