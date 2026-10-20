<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AppStatus: string implements HasColor, HasLabel
{
    case Publicada = 'publicada';
    case Proximamente = 'proximamente';
    case EnDesarrollo = 'en_desarrollo';

    public function getLabel(): string
    {
        return match ($this) {
            self::Publicada => 'Publicada en tiendas',
            self::Proximamente => 'Próximamente en tiendas',
            self::EnDesarrollo => 'En desarrollo',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Publicada => 'success',
            self::Proximamente => 'warning',
            self::EnDesarrollo => 'gray',
        };
    }

    public function isHighlighted(): bool
    {
        return $this === self::Publicada;
    }
}
