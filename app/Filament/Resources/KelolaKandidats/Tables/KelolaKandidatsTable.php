<?php

namespace App\Filament\Resources\KelolaKandidats\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

class KelolaKandidatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto')
                    ->label('Foto')
                    ->getStateUsing(fn ($record) => asset('storage/' . $record->foto)),

                TextColumn::make('nama')
                    ->label('Nama Kandidat')
                    ->searchable(),
                TextColumn::make('nia')
                    ->label('NIA')
                    ->searchable(),
                TextColumn::make('asal_komisariat')
                    ->label('Asal Komisariat')
                    ->searchable(),
                TextColumn::make('tahun_dad')
                    ->label('Tahun DAD')
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status')

                    ->formatStateUsing(fn ($state) => match ($state) {
                        'layak' => 'Layak',
                        'tidak_layak' => 'Tidak Layak',
                        default => 'Pending',
                    })
                    ->color(fn ($state) => match ($state) {
                        'layak' => 'success',
                        'tidak_layak' => 'danger',
                        default => 'warning',
                    })

                    ->weight('bold')
                    ->alignCenter(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->label(''),
                EditAction::make()
                    ->label(''),
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
                        ->label('Hapus'),
                ]),
            ]);
    }
}
