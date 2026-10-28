<?php

namespace App\Filament\Widgets;

use App\Models\Kandidat;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Facades\DB;

class RekapitulasiSuara extends TableWidget
{
    protected static ?string $heading = 'Rekapitulasi Hasil Pemilihan';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Kandidat::query()
                    ->where('status', 'layak')
                    ->leftJoin('vote_details', 'vote_details.candidate_id', '=', 'kandidats.id')
                    ->select(
                        'kandidats.id',
                        'kandidats.nama',
                        'kandidats.asal_komisariat',
                        DB::raw('COUNT(vote_details.id) as total_suara')
                    )
                    ->groupBy(
                        'kandidats.id',
                        'kandidats.nama',
                        'kandidats.asal_komisariat'
                    )
                    ->orderByDesc('total_suara')
            )
            ->columns([
                Tables\Columns\TextColumn::make('ranking')
                    ->label('Peringkat')
                    ->state(
                        static fn ($rowLoop) => $rowLoop->iteration
                    ),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Kandidat')
                    ->searchable(),

                Tables\Columns\TextColumn::make('asal_komisariat')
                    ->label('Asal Komisariat'),

                Tables\Columns\TextColumn::make('total_suara')
                    ->label('Perolehan Suara')
                    ->sortable()
                    ->badge()
                    ->color('success'),
            ]);
    }
}