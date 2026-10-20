<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ServiceIcon: string implements HasLabel
{
    case Pos = 'pos';
    case Movil = 'movil';
    case Tienda = 'tienda';
    case Web = 'web';
    case Datos = 'datos';
    case Codigo = 'codigo';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pos => 'Punto de venta',
            self::Movil => 'Teléfono',
            self::Tienda => 'Carrito',
            self::Web => 'Globo web',
            self::Datos => 'Base de datos',
            self::Codigo => 'Código',
        };
    }

    /** Contenido interno del SVG de 24×24 usado en el diseño. */
    public function svg(): string
    {
        return match ($this) {
            self::Pos => '<rect x="3" y="4" width="18" height="12" rx="2"></rect><path d="M8 20h8M12 16v4M7 8h6M7 11h4"></path>',
            self::Movil => '<rect x="7" y="2" width="10" height="20" rx="2.5"></rect><path d="M11 18h2"></path>',
            self::Tienda => '<path d="M3 4h2l2.4 11h11L21 7H6.2"></path><circle cx="9" cy="19.5" r="1.5"></circle><circle cx="17" cy="19.5" r="1.5"></circle>',
            self::Web => '<circle cx="12" cy="12" r="9"></circle><path d="M3 12h18M12 3c2.5 2.6 3.8 5.6 3.8 9s-1.3 6.4-3.8 9c-2.5-2.6-3.8-5.6-3.8-9S9.5 5.6 12 3z"></path>',
            self::Datos => '<ellipse cx="12" cy="5.5" rx="8" ry="3"></ellipse><path d="M4 5.5v6c0 1.7 3.6 3 8 3s8-1.3 8-3v-6M4 11.5v6c0 1.7 3.6 3 8 3s8-1.3 8-3v-6"></path>',
            self::Codigo => '<path d="M8 7 3 12l5 5M16 7l5 5-5 5M14 4l-4 16"></path>',
        };
    }
}
