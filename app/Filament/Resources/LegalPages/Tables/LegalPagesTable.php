<?php

namespace App\Filament\Resources\LegalPages\Tables;

use App\Models\LegalPage;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class LegalPagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Título')->searchable(),
                TextColumn::make('slug')->label('Dirección')->prefix('/')->fontFamily('mono'),
                ToggleColumn::make('is_published')->label('Publicada'),
                TextColumn::make('updated_at')->label('Última actualización')->dateTime('d/m/Y H:i'),
            ])
            ->defaultSort('sort')
            ->recordActions([
                Action::make('view')
                    ->label('Ver')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (LegalPage $record) => route('legal', $record->slug), shouldOpenInNewTab: true),
                EditAction::make(),
            ]);
    }
}
