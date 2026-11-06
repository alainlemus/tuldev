<?php

use App\Support\LandingCache;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    /** [ajuste, texto anterior, texto nuevo]. Respeta lo editado desde el panel. */
    private const COPY = [
        ['site.seo_title', 'Desarrollo de software en Tulancingo, Hidalgo | Tuldev', 'Desarrollo de software en Tulancingo y Pachuca | Tuldev'],
        [
            'site.hero_subtitle',
            'Desarrollo de software a la medida en Tulancingo, Hidalgo: sistemas POS, apps móviles, páginas web, tiendas en línea y bases de datos, programados desde cero para cómo trabajas. Más de 15 años de experiencia.',
            'Desarrollo de software a la medida en Tulancingo y Pachuca, Hidalgo: sistemas POS, apps móviles, páginas web, tiendas en línea y bases de datos, programados desde cero para cómo trabajas. Más de 15 años de experiencia.',
        ],
        ['site.services_title', 'Desarrollo de software en Tulancingo, con un solo equipo', 'Desarrollo de software en Tulancingo y Pachuca, con un solo equipo'],
        [
            'site.services_intro',
            'Para negocios de Tulancingo y la región, desde el punto de venta hasta la app que usan tus clientes. Nada de plantillas: cada sistema se diseña a partir de cómo opera tu empresa.',
            'Para negocios de Tulancingo, Pachuca y todo Hidalgo, desde el punto de venta hasta la app que usan tus clientes. Nada de plantillas: cada sistema se diseña a partir de cómo opera tu empresa.',
        ],
    ];

    public function up(): void
    {
        foreach (self::COPY as [$setting, $previous, $new]) {
            $this->migrator->update($setting, fn (string $current) => $current === $previous ? $new : $current);
        }

        LandingCache::forget();
    }
};
