<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Pemilihan;

class CountdownPemilihan extends Widget
{
    protected string $view = 'filament.widgets.countdown-pemilihan';

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    public function getData(): array
    {
        $pemilihan = Pemilihan::first();

        return [
            'mulai' => $pemilihan?->mulai?->toIso8601String(),
            'selesai' => $pemilihan?->selesai?->toIso8601String(),
        ];
    }
}