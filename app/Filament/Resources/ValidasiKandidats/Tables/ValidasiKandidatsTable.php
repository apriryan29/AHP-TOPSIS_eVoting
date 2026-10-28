<?php

namespace App\Filament\Resources\ValidasiKandidats\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ValidasiKandidatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode')
                    ->label('Kode')
                    ->searchable(),
                TextColumn::make('kriteria')
                    ->label('Kriteria')
                    ->searchable(),
                TextColumn::make('atribut')
                    ->label('Atribut')
                    ->badge()
                    ->colors([
                        'primary' => 'Benefit',
                        'danger' => 'Cost',
                    ])
                    ->alignCenter(),
                TextColumn::make('nilai')
                    ->label('Bobot Nilai')
                    ->alignCenter()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->label('')
                    ->modalSubmitActionLabel('Simpan')
                    ->modalCancelActionLabel('Batal'),
                DeleteAction::make()
                    ->label('')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Hapus')
                    ->modalSubheading('Apakah Anda yakin ingin menghapus data ini?')
                    ->modalSubmitActionLabel('Hapus')
                    ->modalCancelActionLabel('Batal'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Data')
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Hapus')
                        ->modalSubheading('Apakah Anda yakin ingin menghapus data yang dipilih?')
                        ->modalSubmitActionLabel('Hapus')
                        ->modalCancelActionLabel('Batal'),
                ])
                ->label(''),
            ]);
    }
    
}
