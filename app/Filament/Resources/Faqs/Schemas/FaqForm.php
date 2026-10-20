<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('question')->label('Pregunta')->required()->maxLength(200)->columnSpanFull(),
            Textarea::make('answer')->label('Respuesta')->required()->rows(5)->columnSpanFull(),
            Toggle::make('is_published')->label('Publicada')->default(true),
        ])->columns(2);
    }
}
