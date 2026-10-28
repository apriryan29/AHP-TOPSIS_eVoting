<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\HasilKelayakan;
use Filament\Pages\Page;
use Filament\Actions;
use App\Filament\Widgets\MatriksKeputusan;
use App\Filament\Widgets\MatriksNormalisasi;
use App\Filament\Widgets\MatriksNormalBerbobot;
use App\Filament\Widgets\SolusiIdealKriteria;
use Filament\Actions\Action;

class Kelayakan extends Page
{
    protected static ?string $title = 'Perhitungan Kelayakan Kandidat';
    protected string $view = 'filament.pages.kelayakan';
    protected static bool $shouldRegisterNavigation = false;
    public function getBreadcrumbs(): array
    {
        return [
            route('filament.admin.pages.tabel-nilai') => 'Penilaian Kandidat',
            'Perhitungan Kelayakan',
        ];
    }
    public function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('Cetak')
                ->icon('heroicon-o-printer')
                ->color('danger')
                ->url(route('kelayakan.pdf'))
                ->openUrlInNewTab(),
            Actions\Action::make('back')
                ->label('Kembali')
                ->color('warning')
                ->url(fn () => route('filament.admin.pages.tabel-nilai')),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            MatriksKeputusan::class,
            MatriksNormalisasi::class,
            MatriksNormalBerbobot::class,
            SolusiIdealKriteria::class,
            HasilKelayakan::class,
        ];
    }
    public function getFooterWidgetsColumns(): int | array
    {
        return 1;
    }
}
