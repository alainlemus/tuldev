<?php

use App\Support\LandingCache;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    private const PREVIOUS = 'Tuldev · Desarrollo de software y páginas web en Hidalgo y CDMX';

    private const FOCUSED = 'Desarrollo de software en Tulancingo, Hidalgo | Tuldev';

    /** El objetivo es la búsqueda local en Tulancingo. Respeta lo editado desde el panel. */
    public function up(): void
    {
        $this->migrator->update('site.seo_title', fn (string $current) => $current === self::PREVIOUS ? self::FOCUSED : $current);

        LandingCache::forget();
    }
};
