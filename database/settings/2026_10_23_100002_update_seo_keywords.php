<?php

use App\Support\LandingCache;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->update('site.seo_title', fn () => 'Tuldev · Desarrollo de software y páginas web en Hidalgo y CDMX');
        $this->migrator->update('site.seo_description', fn () => 'Estudio de desarrollo de software a la medida en Tulancingo: sistemas POS, apps móviles, páginas web, tiendas en línea y facturación. Clientes en Pachuca, Querétaro y CDMX.');
        $this->migrator->update('site.hero_subtitle', fn () => 'Sistemas POS, apps móviles, páginas web, tiendas en línea y bases de datos, programados desde cero para cómo trabajas. Más de 15 años de experiencia, desde Tulancingo, Hidalgo.');
        $this->migrator->update('site.coverage_title', fn () => 'Desarrollo de software y páginas web para clientes en');
        $this->migrator->update('site.coverage_places', fn () => "Tulancingo\nPachuca y todo Hidalgo\nQuerétaro\nCiudad de México");

        LandingCache::forget();
    }
};
