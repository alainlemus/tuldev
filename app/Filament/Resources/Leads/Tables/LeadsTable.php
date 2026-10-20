<?php

namespace App\Filament\Resources\Leads\Tables;

use App\Enums\LeadStatus;
use App\Enums\LeadType;
use App\Models\Lead;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Recibido')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('name')->label('Nombre')->searchable(),
                TextColumn::make('business')->label('Negocio')->searchable()->placeholder('—'),
                TextColumn::make('whatsapp')->label('WhatsApp')->searchable(),
                TextColumn::make('type')->label('Tipo')->badge()->color('gray'),
                TextColumn::make('status')->label('Estado')->badge(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')->label('Estado')->options(LeadStatus::class),
                SelectFilter::make('type')->label('Tipo de proyecto')->options(LeadType::class),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('whatsapp')
                    ->label('Abrir WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(fn (Lead $record) => $record->whatsappUrl(), shouldOpenInNewTab: true),
                ActionGroup::make([
                    Action::make('changeStatus')
                        ->label('Cambiar estado')
                        ->icon('heroicon-o-arrow-path')
                        ->schema([Select::make('status')->label('Estado')->options(LeadStatus::class)->required()->native(false)])
                        ->fillForm(fn (Lead $record) => ['status' => $record->status])
                        ->action(fn (Lead $record, array $data) => $record->update(['status' => $data['status']])),
                    EditAction::make()->label('Notas y estado'),
                ]),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
