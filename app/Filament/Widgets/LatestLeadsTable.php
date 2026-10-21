<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Leads\LeadResource;
use App\Models\Lead;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestLeadsTable extends TableWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Últimos 5 prospectos')
            ->query(fn () => Lead::query()->latest()->limit(5))
            ->columns([
                TextColumn::make('created_at')->label('Recibido')->dateTime('d/m/Y H:i'),
                TextColumn::make('name')->label('Nombre'),
                TextColumn::make('business')->label('Negocio')->placeholder('—'),
                TextColumn::make('type')->label('Tipo')->badge()->color('gray'),
                TextColumn::make('status')->label('Estado')->badge(),
            ])
            ->recordUrl(fn (Lead $record) => LeadResource::getUrl('view', ['record' => $record]))
            ->paginated(false);
    }
}
