<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(120)
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Set $set, ?string $state, string $operation) => $operation === 'create' ? $set('slug', Str::slug((string) $state)) : null),
            TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true)->maxLength(120),
            Textarea::make('description')->label('Descripción')->required()->rows(3)->columnSpanFull(),
            TagsInput::make('tags')
                ->label('Etiquetas')
                ->helperText('Se muestran como: SaaS · App iOS · …')
                ->columnSpanFull(),
            TextInput::make('badge')
                ->label('Insignia (opcional)')
                ->datalist(['Producto propio', 'En desarrollo'])
                ->helperText('Elige una sugerencia o escribe texto libre.')
                ->maxLength(40),
            TextInput::make('url')
                ->label('URL (solo referencia)')
                ->url()
                ->helperText('No se muestra en la landing.')
                ->maxLength(255),
            FileUpload::make('scroll_image')
                ->label('Imagen de scroll')
                ->helperText('Captura vertical larga; se desplaza sola dentro de la tarjeta.')
                ->image()
                ->disk('public')
                ->directory('projects')
                ->visibility('public')
                ->columnSpanFull(),
            TextInput::make('scroll_alt')
                ->label('Texto alternativo')
                ->placeholder('Recorrido por el sitio de …')
                ->maxLength(200)
                ->columnSpanFull(),
            TextInput::make('scroll_duration')
                ->label('Duración de la animación')
                ->numeric()->minValue(4)->maxValue(120)->default(18)->suffix('segundos')->required(),
            TextInput::make('scroll_delay')
                ->label('Desfase de la animación')
                ->numeric()->default(0)->suffix('segundos')
                ->helperText('Un valor negativo adelanta la animación para que las tarjetas no vayan sincronizadas.'),
            Toggle::make('is_published')->label('Publicado')->default(true),
        ])->columns(2);
    }
}
