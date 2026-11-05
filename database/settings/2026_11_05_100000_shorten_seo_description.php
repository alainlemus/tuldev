<?php

use App\Support\LandingCache;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    private const PREVIOUS = 'Estudio de desarrollo de software a la medida en Tulancingo: sistemas POS, apps móviles, páginas web, tiendas en línea y facturación. Clientes en Pachuca, Querétaro y CDMX.';

    private const SHORTER = 'Desarrollo de software a la medida en Tulancingo: POS, apps móviles, páginas web, tiendas en línea y facturación. Clientes en Pachuca, Querétaro y CDMX.';

    /** Google corta la descripción cerca de los 160 caracteres. Respeta lo editado desde el panel. */
    public function up(): void
    {
        $this->migrator->update('site.seo_description', fn (string $current) => $current === self::PREVIOUS ? self::SHORTER : $current);

        LandingCache::forget();
    }
};
