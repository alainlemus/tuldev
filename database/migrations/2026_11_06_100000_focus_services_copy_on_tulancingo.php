<?php

use App\Models\Faq;
use App\Models\Service;
use App\Support\LandingCache;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /** [servicio, descripción anterior, descripción nueva]. El seeder tiene los mismos textos nuevos. */
    private const DESCRIPTIONS = [
        [
            'Sistemas POS',
            'Punto de venta para tu tienda, restaurante o farmacia: ventas, inventario, cortes de caja y reportes en un solo sistema.',
            'Punto de venta para tu tienda, restaurante o farmacia en Tulancingo: ventas, inventario, cortes de caja y reportes en un solo sistema.',
        ],
        [
            'Tiendas en línea',
            'Vende las 24 horas con catálogo, carrito, pagos con tarjeta y envíos, conectada a tu inventario real.',
            'Tu tienda en línea desde Tulancingo: vende las 24 horas con catálogo, carrito, pagos con tarjeta y envíos, conectada a tu inventario real.',
        ],
        [
            'Páginas web administrables',
            'Páginas rápidas y bien posicionadas en Google, con panel para que actualices tu menú, productos o promociones sin depender de nadie.',
            'Páginas web en Tulancingo, rápidas y bien posicionadas en Google, con panel para que actualices tu menú, productos o promociones sin depender de nadie.',
        ],
    ];

    /** Respeta lo editado desde el panel; en una base nueva no hace nada porque el contenido llega con los seeders. */
    public function up(): void
    {
        foreach (self::DESCRIPTIONS as [$title, $previous, $new]) {
            Service::where('title', $title)->where('description', $previous)->first()?->update(['description' => $new]);
        }

        if (Faq::exists()) {
            Faq::firstOrCreate(
                ['question' => '¿Qué servicios de desarrollo de software ofrecen en Tulancingo?'],
                [
                    'answer' => 'Desarrollamos páginas web, tiendas en línea, sistemas POS, apps móviles, bases de datos, facturación y timbrado en línea, pagos en línea y sistemas a la medida para negocios de Tulancingo y la región.',
                    'sort' => Faq::max('sort') + 1,
                    'is_published' => true,
                ],
            );
        }

        LandingCache::forget();
    }
};
