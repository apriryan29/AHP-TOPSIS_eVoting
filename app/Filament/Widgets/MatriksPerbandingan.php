<?php

namespace App\Filament\Widgets;

use App\Models\PerbandinganKriteria;
use App\Models\ValidasiKandidat;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class MatriksPerbandingan extends BaseWidget
{
    protected static ?string $heading = 'Matriks Perbandingan Kriteria';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $columns = [

            Tables\Columns\TextColumn::make('kode')
                ->label('Kriteria'),
        ];

        $kriterias = ValidasiKandidat::all();

        foreach ($kriterias as $kriteria) {

            $columns[] = Tables\Columns\TextColumn::make(
                    $kriteria->kode
                )
                ->label($kriteria->nama_kriteria)

                ->getStateUsing(function ($record) use ($kriteria) {

                    if ($record->id == $kriteria->id) {
                        return 1;
                    }

                    $perbandingan = PerbandinganKriteria::where(
                        'kriteria_1_id',
                        $record->id
                    )
                    ->where(
                        'kriteria_2_id',
                        $kriteria->id
                    )
                    ->first();

                    if ($perbandingan) {
                        return $perbandingan->nilai;
                    }

                    $kebalikan = PerbandinganKriteria::where(
                        'kriteria_1_id',
                        $kriteria->id
                    )
                    ->where(
                        'kriteria_2_id',
                        $record->id
                    )
                    ->first();

                    if ($kebalikan) {
                        return round(1 / $kebalikan->nilai, 3);
                    }

                    return '-';
                })

                ->alignCenter()
                ->color(fn ($state, $record) => $record->id == $kriteria->id ? 'danger' : 'null');
        }

        return $table
            ->query(ValidasiKandidat::query())
            ->columns($columns)
            ->paginated(false);
    }
}