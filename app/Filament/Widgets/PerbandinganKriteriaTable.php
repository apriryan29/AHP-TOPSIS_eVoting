<?php

namespace App\Filament\Widgets;

use App\Models\ValidasiKandidat;
use App\Models\PerbandinganKriteria;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class PerbandinganKriteriaTable extends BaseWidget
{
    protected static ?string $heading = 'Nilai Perbandingan Kriteria';

    protected int|string|array $columnSpan = 'full';

    public function mount(): void
    {
        $this->generateMatrix();
    }
    public function generateMatrix(): void
    {
        $kriteria = ValidasiKandidat::all();

        for ($i = 0; $i < count($kriteria); $i++) {
            for ($j = $i + 1; $j < count($kriteria); $j++) {

                PerbandinganKriteria::firstOrCreate([
                    'kriteria_1_id' => $kriteria[$i]->id,
                    'kriteria_2_id' => $kriteria[$j]->id,
                ], [
                    'nilai' => null
                ]);
            }
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\PerbandinganKriteria::query()
            )
            ->columns([
                TextColumn::make('kriteria1.kriteria')
                    ->label('Kriteria 1'),

                TextColumn::make('kriteria2.kriteria')
                    ->label('Kriteria 2'),

                SelectColumn::make('nilai')
                    ->label('Nilai Perbandingan')
                    ->placeholder('Pilih nilai perbandingan')
                    ->options([
                        '1' => '1 - Sama penting',
                        '2' => '2 - Antara 1 dan 3',
                        '3' => '3 - Sedikit lebih penting',
                        '4' => '4 - Antara 3 dan 5',
                        '5' => '5 - Lebih penting',
                        '6' => '6 - Antara 5 dan 7',
                        '7' => '7 - Sangat penting',
                        '8' => '8 - Antara 7 dan 9',
                        '9' => '9 - Mutlak penting',
                    ])
                    ->rules(['required']),
            ]);
    }
}