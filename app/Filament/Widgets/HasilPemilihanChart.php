<?php

namespace App\Filament\Widgets;

use App\Models\Kandidat;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class HasilPemilihanChart extends ChartWidget
{
    protected ?string $heading = 'Perolehan Suara Kandidat';

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = Kandidat::query()
            ->where('status', 'layak')
            ->leftJoin('vote_details', 'vote_details.candidate_id', '=', 'kandidats.id')
            ->select(
                'kandidats.nama',
                DB::raw('COUNT(vote_details.id) as total_suara')
            )
            ->groupBy(
                'kandidats.id',
                'kandidats.nama'
            )
            ->orderBy('kandidats.id', 'asc')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Suara',
                    'data' => $data->pluck('total_suara')->toArray(),
                    'backgroundColor' => '#3b82f6',
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $data->pluck('nama')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}