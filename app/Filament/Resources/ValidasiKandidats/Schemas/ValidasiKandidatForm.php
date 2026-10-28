<?php

namespace App\Filament\Resources\ValidasiKandidats\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ValidasiKandidatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('kriteria')
                    ->label('Kriteria')
                    ->required(),
                TextInput::make('kode')
                    ->label('Kode Kriteria')
                    ->required(),
                Select::make('atribut')
                    ->label('Atribut')
                    ->placeholder('Pilih Atribut')
                    ->options([
                        'Benefit' => 'Benefit',
                        'Cost' => 'Cost',
                    ])
                    ->required(),
            ]);
    }
}
