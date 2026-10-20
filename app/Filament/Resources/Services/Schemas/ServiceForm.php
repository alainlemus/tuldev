<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Enums\ServiceIcon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Título')->required()->maxLength(120),
            TextInput::make('tag')
                ->label('Etiqueta de ruta')
                ->helperText('Se muestra como ruta de código, por ejemplo ventas/pos.')
                ->maxLength(60),
            Textarea::make('description')->label('Descripción')->required()->rows(4)->columnSpanFull(),
            Select::make('icon')->label('Ícono')->options(ServiceIcon::class)->required()->native(false),
            Toggle::make('is_active')->label('Activo')->default(true),
        ])->columns(2);
    }
}
