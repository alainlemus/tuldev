<?php

use App\Support\LandingCache;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    /** [ajuste, texto anterior, texto nuevo]. Respeta lo editado desde el panel. */
    private const COPY = [
        ['site.hero_eyebrow', '{ software a la medida }', '{ desarrollo de software en Tulancingo }'],
        [
            'site.hero_subtitle',
            'Sistemas POS, apps móviles, páginas web, tiendas en línea y bases de datos, programados desde cero para cómo trabajas. Más de 15 años de experiencia, desde Tulancingo, Hidalgo.',
            'Desarrollo de software a la medida en Tulancingo, Hidalgo: sistemas POS, apps móviles, páginas web, tiendas en línea y bases de datos, programados desde cero para cómo trabajas. Más de 15 años de experiencia.',
        ],
        ['site.services_title', 'Todo el software de tu negocio, con un solo equipo', 'Desarrollo de software en Tulancingo, con un solo equipo'],
        [
            'site.services_intro',
            'Desde el punto de venta hasta la app que usan tus clientes. Nada de plantillas: cada sistema se diseña a partir de cómo opera tu empresa.',
            'Para negocios de Tulancingo y la región, desde el punto de venta hasta la app que usan tus clientes. Nada de plantillas: cada sistema se diseña a partir de cómo opera tu empresa.',
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
