<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum LeadType: string implements HasLabel
{
    case Pos = 'pos';
    case AppMovil = 'app_movil';
    case Tienda = 'tienda';
    case Sitio = 'sitio';
    case BaseDatos = 'base_datos';
    case Medida = 'medida';
    case NoSe = 'no_se';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pos => 'Sistema POS',
            self::AppMovil => 'App móvil',
            self::Tienda => 'Tienda en línea',
            self::Sitio => 'Sitio web',
            self::BaseDatos => 'Base de datos',
            self::Medida => 'Sistema a la medida o integración',
            self::NoSe => 'Todavía no lo sé',
        };
    }
}
