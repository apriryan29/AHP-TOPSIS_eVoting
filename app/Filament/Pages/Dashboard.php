<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Override;
use App\Filament\Widgets\HasilPemilihanChart;
use App\Filament\Widgets\RekapitulasiSuara;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\CountdownPemilihan;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard E-Voting';
    protected static ?string $navigationLabel = 'Dashboard';
    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            CountdownPemilihan::class,
            HasilPemilihanChart::class,
            RekapitulasiSuara::class,
        ];
    }
}