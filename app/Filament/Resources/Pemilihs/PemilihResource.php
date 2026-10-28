<?php

namespace App\Filament\Resources\Pemilihs;

use App\Filament\Resources\Pemilihs\Pages\CreatePemilih;
use App\Filament\Resources\Pemilihs\Pages\EditPemilih;
use App\Filament\Resources\Pemilihs\Pages\ListPemilihs;
use App\Filament\Resources\Pemilihs\Schemas\PemilihForm;
use App\Filament\Resources\Pemilihs\Tables\PemilihsTable;
use App\Models\Vote;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PemilihResource extends Resource
{
    protected static ?string $model = Vote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckCircle;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Kelola Pemilih';
    public static function getPluralModelLabel(): string {return 'Kelola Pemilih';}
    protected static string | \UnitEnum | null $navigationGroup = 'Voting';
    protected static ?string $navigationLabel = 'Data Pemilih';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PemilihForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PemilihsTable::configure($table);
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
            'index' => ListPemilihs::route('/'),
            'create' => CreatePemilih::route('/create'),
            'edit' => EditPemilih::route('/{record}/edit'),
        ];
    }
}
