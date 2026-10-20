<?php

namespace App\Filament\Resources\Leads\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LeadInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Contacto')->columns(2)->schema([
                TextEntry::make('name')->label('Nombre'),
                TextEntry::make('business')->label('Negocio')->placeholder('—'),
                TextEntry::make('whatsapp')->label('WhatsApp')->url(fn ($record) => $record->whatsappUrl(), true),
                TextEntry::make('email')->label('Correo')->placeholder('—')->url(fn ($record) => $record->email ? "mailto:{$record->email}" : null),
                TextEntry::make('type')->label('Tipo de proyecto')->badge(),
                TextEntry::make('status')->label('Estado')->badge(),
                TextEntry::make('message')->label('Mensaje')->placeholder('—')->columnSpanFull(),
            ]),
            Section::make('Notas internas')->schema([
                TextEntry::make('notes')->hiddenLabel()->placeholder('Sin notas'),
            ]),
            Section::make('Origen')->columns(3)->collapsed()->schema([
                TextEntry::make('created_at')->label('Recibido')->dateTime('d/m/Y H:i'),
                TextEntry::make('ip')->label('IP')->placeholder('—'),
                TextEntry::make('user_agent')->label('Navegador')->placeholder('—'),
                TextEntry::make('utm_source')->label('utm_source')->placeholder('—'),
                TextEntry::make('utm_medium')->label('utm_medium')->placeholder('—'),
                TextEntry::make('utm_campaign')->label('utm_campaign')->placeholder('—'),
            ]),
        ]);
    }
}
