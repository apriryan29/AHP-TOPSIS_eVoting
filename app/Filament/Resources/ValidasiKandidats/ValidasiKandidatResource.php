<?php

namespace App\Filament\Resources\ValidasiKandidats;

use App\Filament\Resources\ValidasiKandidats\Pages\CreateValidasiKandidat;
use App\Filament\Resources\ValidasiKandidats\Pages\EditValidasiKandidat;
use App\Filament\Resources\ValidasiKandidats\Pages\ListValidasiKandidats;
use App\Filament\Resources\ValidasiKandidats\Pages\ViewValidasiKandidat;
use App\Filament\Resources\ValidasiKandidats\Schemas\ValidasiKandidatForm;
use App\Filament\Resources\ValidasiKandidats\Schemas\ValidasiKandidatInfolist;
use App\Filament\Resources\ValidasiKandidats\Tables\ValidasiKandidatsTable;

use App\Models\ValidasiKandidat;
use App\Services\AHPService;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Notifications\Notification;

class ValidasiKandidatResource extends Resource
{
    protected static ?string $model = ValidasiKandidat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'nama';

    protected static ?string $navigationLabel = 'Kelola Kriteria';
    
    protected static ?string $modelLabel = 'Kelola Kriteria';
    protected static ?string $pluralModelLabel = 'Kelola Kriteria';

    protected static string|\UnitEnum|null $navigationGroup = 'Kandidat';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return ValidasiKandidatForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ValidasiKandidatInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ValidasiKandidatsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListValidasiKandidats::route('/'),
        ];
    }
}