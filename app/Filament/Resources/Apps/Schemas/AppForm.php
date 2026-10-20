<?php

namespace App\Filament\Resources\Apps\Schemas;

use App\Enums\AppStatus;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AppForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Nombre')->required()->maxLength(120),
            Select::make('status')->label('Estado')->options(AppStatus::class)->required()->native(false)->default(AppStatus::EnDesarrollo),
            Textarea::make('description')->label('Descripción')->required()->rows(3)->columnSpanFull(),
            FileUpload::make('image')
                ->label('Imagen')
                ->image()
                ->disk('public')
                ->directory('apps')
                ->visibility('public')
                ->helperText('Proporción 4:3 recomendada.')
                ->columnSpanFull(),
            TextInput::make('image_alt')->label('Texto alternativo')->maxLength(200)->columnSpanFull(),
            TextInput::make('app_store_url')->label('Enlace a App Store')->url()->maxLength(255),
            TextInput::make('google_play_url')->label('Enlace a Google Play')->url()->maxLength(255),
            Toggle::make('is_published')->label('Publicado')->default(true),
        ])->columns(2);
    }
}
