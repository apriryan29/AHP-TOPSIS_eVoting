<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use App\Filament\Widgets\MatriksPerbandingan;
use App\Filament\Widgets\MatriksNormalisasiAHP;
use App\Filament\Widgets\BobotPrioritas;

class PerbandinganKriteria extends Page
{
    protected static ?string $title = 'Perhitungan AHP';
    public function getBreadcrumbs(): array
    {
        return [
            route('filament.admin.resources.validasi-kandidats.index') => 'Kelola Kriteria',
            'Perhitungan AHP',
        ];
    }
    protected string $view = 'filament.pages.perbandingan-kriteria';
    protected static bool $shouldRegisterNavigation = false;
    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->color('warning')
                ->url(fn () => route('filament.admin.resources.validasi-kandidats.index')),
        ];
    }
    protected function getFooterWidgets(): array
    {
        return [
            MatriksPerbandingan::class,
            MatriksNormalisasiAHP::class,
            BobotPrioritas::class,
        ];
    }
}