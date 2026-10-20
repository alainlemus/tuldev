<?php

namespace App\Filament\Resources\LegalPages\Pages;

use App\Filament\Resources\LegalPages\LegalPageResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditLegalPage extends EditRecord
{
    protected static string $resource = LegalPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view')
                ->label('Ver en el sitio')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->url(fn () => route('legal', $this->getRecord()->slug), shouldOpenInNewTab: true),
        ];
    }
}
