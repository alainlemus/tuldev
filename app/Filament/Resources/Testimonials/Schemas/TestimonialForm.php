<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('author')->label('Nombre')->required()->maxLength(120),
            TextInput::make('role')->label('Cargo y negocio')->maxLength(160)->helperText('Ejemplo: Dueña, Panadería La Espiga.'),
            Textarea::make('quote')->label('Testimonio')->required()->rows(5)->columnSpanFull(),
            FileUpload::make('photo')->label('Foto o logo (opcional)')->image()->disk('public')->directory('testimonials')->visibility('public')->helperText('Pide autorización antes de publicar nombre o foto de un cliente.'),
            Toggle::make('is_published')->label('Publicado')->default(true),
        ])->columns(2);
    }
}
