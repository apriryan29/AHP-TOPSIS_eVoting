<?php

namespace App\Filament\Widgets;

use App\Models\Kandidat;
use App\Models\ValidasiKandidat;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class MatriksNormalisasi extends TableWidget
{
    protected static ?string $heading = 'Matriks Keputusan Ternormalisasi';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $kriterias = ValidasiKandidat::all();
        $jumlahKriteria = $kriterias->count();

        // 🔥 FILTER KANDIDAT VALID (WAJIB)
        $kandidats = Kandidat::with('penilaian')
            ->get()
            ->filter(fn ($k) =>
                $k->penilaian->count() === $jumlahKriteria
            );

        /**
         * =========================
         * HITUNG PEMBAGI (ROOT SUM OF SQUARE)
         * =========================
         */
        $pembagi = [];

        foreach ($kriterias as $kriteria) {

            $totalKuadrat = 0;

            foreach ($kandidats as $kandidat) {

                $nilai = $kandidat->penilaian
                    ->firstWhere('validasi_kandidat_id', $kriteria->id)
                    ?->nilai ?? 0;

                $totalKuadrat += pow($nilai, 2);
            }

            $pembagi[$kriteria->id] = sqrt($totalKuadrat);
        }

        /**
         * =========================
         * KOLOM TABEL
         * =========================
         */
        $columns = [
            Tables\Columns\TextColumn::make('nama')
                ->label('Nama Kandidat'),
        ];

        foreach ($kriterias as $kriteria) {

            $columns[] = Tables\Columns\TextColumn::make('k_' . $kriteria->id)
                ->label(new \Illuminate\Support\HtmlString(
                        $kriteria->kode . '<br>' . $kriteria->kriteria
                    ))
                ->alignCenter()

                ->getStateUsing(function ($record) use ($kriteria, $pembagi) {

                    $nilai = $record->penilaian
                        ->firstWhere('validasi_kandidat_id', $kriteria->id)
                        ?->nilai ?? 0;

                    $hasil = ($pembagi[$kriteria->id] ?? 0) > 0
                        ? $nilai / $pembagi[$kriteria->id]
                        : 0;

                    return number_format($hasil, 3);
                });
        }

        return $table
            ->query(
                Kandidat::with('penilaian')
                    ->whereHas('penilaian') // optional safety
            )
            ->columns($columns)
            ->paginated(false);
    }
}