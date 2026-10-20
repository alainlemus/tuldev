<?php

namespace App\Filament\Resources\ProcessSteps\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProcessStepForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->label('Título')->required()->maxLength(80)->columnSpanFull(),
            Textarea::make('description')->label('Descripción')->required()->rows(3)->columnSpanFull(),
            Toggle::make('is_active')->label('Activo')->default(true),
        ])->columns(2);
    }
}
