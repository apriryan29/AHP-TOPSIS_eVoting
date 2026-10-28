<?php

namespace App\Filament\Widgets;

use App\Models\Kandidat;
use App\Models\ValidasiKandidat;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
class SolusiIdealKriteria extends TableWidget
{
    protected static ?string $heading = 'Solusi Ideal';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $columns = [

            Tables\Columns\TextColumn::make('jenis')
                ->label('Solusi')
                ->weight('bold')
                ->alignCenter(),
        ];

        $kriterias = ValidasiKandidat::all();

        $kandidat = Kandidat::with('penilaian')->get();

        $matriksTerbobot = [];

        foreach ($kandidat as $item) {

            foreach ($kriterias as $kriteria) {

                $nilaiSemua = $kandidat
                    ->map(function ($k) use ($kriteria) {

                        return $k->penilaian
                            ->where(
                                'validasi_kandidat_id',
                                $kriteria->id
                            )
                            ->first()?->nilai ?? 0;
                    });

                $pembagi = sqrt(
                    $nilaiSemua->sum(
                        fn ($nilai) => pow($nilai, 2)
                    )
                );

                $nilai = $item->penilaian
                    ->where(
                        'validasi_kandidat_id',
                        $kriteria->id
                    )
                    ->first()?->nilai ?? 0;

                $normalisasi =
                    $pembagi > 0
                    ? $nilai / $pembagi
                    : 0;

                $bobot = $kriteria->nilai ?? 0;

                $matriksTerbobot[$item->id][$kriteria->id]
                    = $normalisasi * $bobot;
            }
        }

        $solusiPositif = [];
        $solusiNegatif = [];

        foreach ($kriterias as $kriteria) {

            $nilaiKolom = [];

            foreach ($kandidat as $item) {

                $nilaiKolom[] =
                    $matriksTerbobot[$item->id][$kriteria->id];
            }

            // Benefit atau Cost
            if ($kriteria->atribut == 'Benefit') {

                // Benefit
                $solusiPositif[$kriteria->id] = max($nilaiKolom);
                $solusiNegatif[$kriteria->id] = min($nilaiKolom);

            } else {

                // Cost
                $solusiPositif[$kriteria->id] = min($nilaiKolom);
                $solusiNegatif[$kriteria->id] = max($nilaiKolom);

            }
        }

        foreach ($kriterias as $kriteria) {

            $columns[] = Tables\Columns\TextColumn::make(
                    $kriteria->kode
                )

                ->label(new \Illuminate\Support\HtmlString(
                        $kriteria->kode . '<br>' . $kriteria->kriteria
                    ))

                ->getStateUsing(function ($record) use (
                    $kriteria,
                    $solusiPositif,
                    $solusiNegatif
                ) {

                    if ($record['jenis'] == 'A+') {

                        return number_format(
                            $solusiPositif[$kriteria->id],
                            4
                        );
                    }

                    return number_format(
                        $solusiNegatif[$kriteria->id],
                        4
                    );
                })

                ->alignCenter();
        }

        return $table
            ->records(fn () => collect([

                [
                    'jenis' => 'A+',
                ],

                [
                    'jenis' => 'A-',
                ],

            ]))

            ->columns($columns)

            ->paginated(false);
    }
}