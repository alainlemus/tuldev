<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum HeroBackground: string implements HasLabel
{
    case Puntos = 'puntos';
    case Perspectiva = 'perspectiva';
    case Pulsos = 'pulsos';

    public function getLabel(): string
    {
        return match ($this) {
            self::Puntos => 'Puntos',
            self::Perspectiva => 'Perspectiva',
            self::Pulsos => 'Pulsos',
        };
    }
}
