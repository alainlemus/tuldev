<?php

namespace App\Filament\Resources\Stats\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class StatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('value')->label('Valor')->required()->maxLength(40)->helperText('Ejemplos: 15+, 120, 98%. Los números cuentan desde 0 al aparecer.'),
            TextInput::make('label')->label('Descripción')->required()->maxLength(120)->helperText('Ejemplo: años de experiencia.'),
            Toggle::make('is_published')->label('Publicada')->default(true),
        ])->columns(2);
    }
}
