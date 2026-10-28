<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\NilaiKandidat;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Actions;
use Filament\Support\Icons\Heroicon;

class TabelNilai extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;
    protected static ?string $title = 'Penilaian Kandidat';
    protected static string | \UnitEnum | null $navigationGroup = 'Kandidat';
    protected static ?int $navigationSort = 3;

    protected  string $view = 'filament.pages.tabel-nilai';
    public function getBreadcrumbs(): array
    {
        return [
            route('filament.admin.pages.dashboard') => 'Penilaian Kandidat',
            'Tabel',
        ];
    }

    protected function getHeaderActions():array
    {
        return [
            Actions\Action::make('Hitung Kelayakan')
                ->label('Hitung Kelayakan')
                ->icon('heroicon-o-calculator')
                ->color('primary')
                ->tooltip(
                    'Isi seluruh nilai kandidat terlebih dahulu'
                )
                ->url(route('filament.admin.pages.kelayakan')),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            NilaiKandidat::class,
        ];
    }
}