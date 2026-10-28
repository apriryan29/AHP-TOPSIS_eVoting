<?php

namespace App\Filament\Widgets;

use App\Models\Kandidat;
use App\Models\ValidasiKandidat;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class MatriksNormalBerbobot extends TableWidget
{
    protected static ?string $heading = 'Matriks Normalisasi Berbobot';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $kriterias = ValidasiKandidat::all();
        $jumlahKriteria = $kriterias->count();

        /**
         * 🔥 FILTER KANDIDAT VALID (WAJIB)
         */
        $kandidats = Kandidat::with('penilaian')
            ->get()
            ->filter(fn ($k) =>
                $k->penilaian->count() === $jumlahKriteria
            );

        /**
         * =========================
         * HITUNG PEMBAGI NORMALISASI
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
         * KOLOM NORMALISASI TERBOBOT
         * =========================
         */
        $columns = [
            Tables\Columns\TextColumn::make('nama')
                ->label('Nama Kandidat'),
        ];

        foreach ($kriterias as $kriteria) {

            $columns[] = Tables\Columns\TextColumn::make('k_' . $kriteria->kriteria)
                ->label(new \Illuminate\Support\HtmlString(
                        $kriteria->kode . '<br>' . $kriteria->kriteria
                    ))
                ->alignCenter()

                ->getStateUsing(function ($record) use ($kriteria, $pembagi) {

                    $nilai = $record->penilaian
                        ->firstWhere('validasi_kandidat_id', $kriteria->id)
                        ?->nilai ?? 0;

                    $normalisasi = ($pembagi[$kriteria->id] ?? 0) > 0
                        ? $nilai / $pembagi[$kriteria->id]
                        : 0;

                    $bobot = $kriteria->nilai ?? 0;

                    return number_format($normalisasi * $bobot, 3);
                });
        }

        return $table
            ->query(
                Kandidat::with('penilaian')
                    ->whereHas('penilaian') // safety
            )
            ->columns($columns)
            ->paginated(false);
    }
}