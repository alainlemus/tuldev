<?php

namespace App\Filament\Resources\Technologies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TechnologiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')->label('Logotipo')->disk('public')->height(28),
                TextColumn::make('name')->label('Nombre')->searchable(),
                TextColumn::make('row')->label('Fila')->badge()->color('gray')->formatStateUsing(fn (int $state) => "Fila {$state}"),
                ToggleColumn::make('is_active')->label('Activo'),
            ])
            ->filters([SelectFilter::make('row')->label('Fila')->options([1 => 'Fila 1', 2 => 'Fila 2'])])
            ->reorderable('sort')
            ->defaultSort('sort')
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
