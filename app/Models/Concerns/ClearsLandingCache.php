<?php

namespace App\Models\Concerns;

use App\Support\LandingCache;

trait ClearsLandingCache
{
    protected static function bootClearsLandingCache(): void
    {
        static::creating(function ($model) {
            $model->sort ??= (int) static::max('sort') + 1;
        });
        static::saved(fn () => LandingCache::forget());
        static::deleted(fn () => LandingCache::forget());
    }
}
