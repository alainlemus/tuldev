<?php

namespace App\Filament\Resources\LegalPages;

use App\Filament\Resources\LegalPages\Pages\EditLegalPage;
use App\Filament\Resources\LegalPages\Pages\ListLegalPages;
use App\Filament\Resources\LegalPages\Schemas\LegalPageForm;
use App\Filament\Resources\LegalPages\Tables\LegalPagesTable;
use App\Models\LegalPage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class LegalPageResource extends Resource
{
    protected static ?string $model = LegalPage::class;

    protected static ?string $modelLabel = 'página legal';

    protected static ?string $pluralModelLabel = 'páginas legales';

    protected static ?string $navigationLabel = 'Páginas legales';

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;

    protected static string|\UnitEnum|null $navigationGroup = 'Sitio';

    protected static ?int $navigationSort = 2;

    /** Las páginas legales (aviso y términos) vienen del seeder: solo se editan. */
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return LegalPageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LegalPagesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLegalPages::route('/'),
            'edit' => EditLegalPage::route('/{record}/edit'),
        ];
    }
}
