<?php

namespace App\Filament\Resources\LegalPages\Schemas;

use App\Models\LegalPage;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LegalPageForm
{
    public static function configure(Schema $schema): Schema
    {
        $tokens = collect(LegalPage::TOKENS)
            ->map(fn (string $description, string $token) => "{$token}: {$description}")
            ->implode(' · ');

        return $schema->components([
            Section::make()->columns(2)->schema([
                TextInput::make('title')->label('Título')->required()->maxLength(120),
                TextInput::make('slug')->label('Dirección (URL)')->disabled()->dehydrated(false)
                    ->prefix('/')->helperText('No se puede cambiar: es la dirección pública de la página.'),
                Textarea::make('meta_description')->label('Descripción para buscadores')->rows(2)->maxLength(300)->columnSpanFull(),
                Toggle::make('is_published')->label('Publicada')->default(true)
                    ->helperText('Si la ocultas deja de existir en el sitio, en el pie de página y en el sitemap.'),
            ]),
            Section::make('Contenido')->schema([
                RichEditor::make('content')
                    ->hiddenLabel()
                    ->required()
                    ->toolbarButtons([['h2', 'h3', 'bold', 'italic', 'link'], ['bulletList', 'orderedList', 'blockquote'], ['undo', 'redo']])
                    ->helperText("Marcadores que se reemplazan solos con los datos de Ajustes del sitio: {$tokens}"),
            ]),
        ]);
    }
}
