<?php

namespace App\Filament\Resources\Leads\Schemas;

use App\Enums\LeadStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

/** Solo estado y notas internas son editables: el resto lo captura el formulario público. */
class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('status')->label('Estado')->options(LeadStatus::class)->required()->native(false),
            Textarea::make('notes')->label('Notas internas')->rows(6)->columnSpanFull(),
        ])->columns(2);
    }
}
