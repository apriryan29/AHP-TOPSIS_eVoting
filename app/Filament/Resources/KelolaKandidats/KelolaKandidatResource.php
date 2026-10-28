<?php

namespace App\Filament\Resources\KelolaKandidats;

use App\Filament\Resources\KelolaKandidats\Pages\CreateKelolaKandidat;
use App\Filament\Resources\KelolaKandidats\Pages\EditKelolaKandidat;
use App\Filament\Resources\KelolaKandidats\Pages\ListKelolaKandidats;
use App\Filament\Resources\KelolaKandidats\Pages\ViewKelolaKandidat;
use App\Filament\Resources\KelolaKandidats\Schemas\KelolaKandidatForm;
use App\Filament\Resources\KelolaKandidats\Schemas\KelolaKandidatInfolist;
use App\Filament\Resources\KelolaKandidats\Tables\KelolaKandidatsTable;
use App\Models\Kandidat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KelolaKandidatResource extends Resource
{
    protected static ?string $model = Kandidat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'nama';
    protected static ?string $navigationLabel = 'Kelola Kandidat';

    //menambahkan judul pada halaman admin
    protected static ?string $modelLabel = 'Kandidat';
    protected static ?string $pluralModelLabel = 'Kandidat';

    protected static string | \UnitEnum | null $navigationGroup = 'Kandidat';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return KelolaKandidatForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return KelolaKandidatInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KelolaKandidatsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKelolaKandidats::route('/'),
            'create' => CreateKelolaKandidat::route('/create'),
            'view' => ViewKelolaKandidat::route('/{record}'),
            'edit' => EditKelolaKandidat::route('/{record}/edit'),
        ];
    }
}
