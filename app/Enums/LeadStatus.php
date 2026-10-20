<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum LeadStatus: string implements HasColor, HasLabel
{
    case Nuevo = 'nuevo';
    case Contactado = 'contactado';
    case Cotizado = 'cotizado';
    case Ganado = 'ganado';
    case Perdido = 'perdido';

    public function getLabel(): string
    {
        return ucfirst($this->value);
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Nuevo => 'info',
            self::Contactado => 'warning',
            self::Cotizado => 'primary',
            self::Ganado => 'success',
            self::Perdido => 'danger',
        };
    }
}
