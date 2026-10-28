<?php

namespace App\Filament\Widgets;

use App\Models\PerbandinganKriteria;
use App\Models\ValidasiKandidat;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class MatriksNormalisasiAHP extends BaseWidget
{
    protected static ?string $heading = 'Matriks Normalisasi AHP';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $columns = [

            Tables\Columns\TextColumn::make('kode')
                ->label('Kriteria'),
        ];

        $kriterias = ValidasiKandidat::all();

        // BENTUK MATRIKS PERBANDINGAN
        $matriks = [];

        foreach ($kriterias as $baris) {

            foreach ($kriterias as $kolom) {

                // diagonal
                if ($baris->id == $kolom->id) {

                    $matriks[$baris->id][$kolom->id] = 1;

                } else {

                    $perbandingan = PerbandinganKriteria::where(
                        'kriteria_1_id',
                        $baris->id
                    )
                    ->where(
                        'kriteria_2_id',
                        $kolom->id
                    )
                    ->first();

                    if ($perbandingan) {

                        $matriks[$baris->id][$kolom->id]
                            = $perbandingan->nilai;

                    } else {

                        $kebalikan = PerbandinganKriteria::where(
                            'kriteria_1_id',
                            $kolom->id
                        )
                        ->where(
                            'kriteria_2_id',
                            $baris->id
                        )
                        ->first();

                        $matriks[$baris->id][$kolom->id]
                            = ($kebalikan && $kebalikan->nilai != 0)
                            ? (1 / $kebalikan->nilai)
                            : 0;
                    }
                }
            }
        }

        // HITUNG TOTAL KOLOM
        $totalKolom = [];

        foreach ($kriterias as $kolom) {

            $total = 0;

            foreach ($kriterias as $baris) {

                $total += $matriks[$baris->id][$kolom->id];
            }

            $totalKolom[$kolom->id] = $total;
        }

        // HITUNG & SIMPAN BOBOT PRIORITAS
        $prioritasData = [];

        foreach ($kriterias as $baris) {

            $total = 0;

            foreach ($kriterias as $kolom) {

                $nilai = $matriks[$baris->id][$kolom->id];

                $normalisasi =
                    $totalKolom[$kolom->id] > 0
                    ? $nilai / $totalKolom[$kolom->id]
                    : 0;

                $total += $normalisasi;
            }

            $prioritas = $total / count($kriterias);

            // simpan sementara
            $prioritasData[$baris->id] = $prioritas;

            // simpan ke database
            ValidasiKandidat::where('id', $baris->id)
                ->update([
                    'nilai' => round($prioritas, 3),
                ]);
        }

        // KOLOM NORMALISASI
        foreach ($kriterias as $kriteria) {

            $columns[] = Tables\Columns\TextColumn::make(
                    $kriteria->kode
                )

                ->label($kriteria->nama_kriteria)

                ->getStateUsing(function ($record) use (
                    $kriteria,
                    $matriks,
                    $totalKolom
                ) {

                    if (!$record) {
                        return '0.000';
                    }

                    $nilai =
                        $matriks[$record->id][$kriteria->id] ?? 0;

                    $hasil =
                        ($totalKolom[$kriteria->id] ?? 0) > 0
                        ? $nilai / $totalKolom[$kriteria->id]
                        : 0;

                    return number_format($hasil, 3);
                })

                ->alignCenter();
        }

        // =========================================
        // KOLOM BOBOT PRIORITAS
        // =========================================
        $columns[] = Tables\Columns\TextColumn::make(
                'prioritas'
            )

            ->label('Bobot Prioritas')

            ->getStateUsing(function ($record) use (
                $prioritasData
            ) {

                if (!$record) {
                    return '0.000';
                }

                return number_format(
                    $prioritasData[$record->id] ?? 0,
                    3
                );
            })
            ->weight('bold')
            ->color('success')
            ->alignCenter();

        return $table
            ->query(ValidasiKandidat::query())
            ->columns($columns)
            ->paginated(false);
    }
}