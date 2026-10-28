<?php

namespace App\Filament\Resources\ValidasiKandidats\Pages;

use App\Filament\Resources\ValidasiKandidats\ValidasiKandidatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\PerbandinganKriteriaTable;

class ListValidasiKandidats extends ListRecords
{
    protected static string $resource = ValidasiKandidatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Kriteria')
                ->modalWidth('lg')
                ->modalSubmitActionLabel('Simpan')
                ->modalCancelActionLabel('Batal')
                ->modalHeading('Tambah Kriteria'),

           Actions\Action::make('perbandingan')
                ->label('Hitung Bobot Kriteria')
                ->icon('heroicon-o-scale')
                ->color('warning')
                ->url(route('filament.admin.pages.perbandingan-kriteria')),
        ];
    }
    protected function getFooterWidgets(): array
    {
        return [
            PerbandinganKriteriaTable::class,
        ];
    }
}
