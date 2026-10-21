<?php

namespace App\Filament\Resources\Technologies\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TechnologyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Nombre')->required()->maxLength(80),
            Select::make('row')->label('Fila del carrusel')->options([1 => 'Fila 1', 2 => 'Fila 2'])->required()->native(false)->default(1),
            FileUpload::make('logo')
                ->label('Logotipo')
                ->acceptedFileTypes(['image/svg+xml', 'image/png'])
                ->disk('public')
                ->directory('technologies')
                ->visibility('public')
                ->helperText('SVG o PNG cuadrado.')
                ->columnSpanFull(),
            Toggle::make('is_active')->label('Activo')->default(true),
        ])->columns(2);
    }
}
