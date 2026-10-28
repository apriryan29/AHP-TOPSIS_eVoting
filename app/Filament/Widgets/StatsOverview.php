<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Kandidat;
use App\Models\Vote;
use App\Models\VoteDetail;
use App\Models\Pemilihan;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $pemilihan = Pemilihan::first();

        // total kandidat
        $totalKandidat = Kandidat::count();

        // total vote (semua suara)
        $totalPemilih = Vote::count();

        $totalSuara = VoteDetail::count();

        // status pemilihan
        $now = now();

        $status = match (true) {
            $now < $pemilihan->mulai => 'Belum Dimulai',
            $now > $pemilihan->selesai => 'Selesai',
            default => 'Aktif',
        };

        return [
            Stat::make('Total Kandidat', $totalKandidat),
            Stat::make('Total Suara Masuk', $totalSuara),
            Stat::make('Total Pemilih', $totalPemilih),
            Stat::make('Status Pemilihan', $status),
        ];
    }
}