<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('scroll_image')->label('Imagen')->disk('public')->height(48),
                TextColumn::make('name')->label('Nombre')->searchable(),
                TextColumn::make('tags')->label('Etiquetas')->badge()->color('gray'),
                TextColumn::make('badge')->label('Insignia')->badge(),
                ToggleColumn::make('is_published')->label('Publicado'),
            ])
            ->reorderable('sort')
            ->defaultSort('sort')
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
