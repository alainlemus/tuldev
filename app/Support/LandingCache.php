<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

class LandingCache
{
    public const KEY = 'landing.content';

    public static function forget(): void
    {
        Cache::forget(self::KEY);
    }
}
