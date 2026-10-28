<?php

namespace App\Filament\Widgets;

use App\Models\Kandidat;
use App\Models\ValidasiKandidat;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class HasilKelayakan extends TableWidget
{
    protected static ?string $heading =
        'Jarak Solusi & Preferensi Kelayakan';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $kriterias = ValidasiKandidat::all();

        $kandidat = Kandidat::with('penilaian')->get();

        // =====================================
        // MATRKS TERBOBOT
        // =====================================
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

        // =====================================
        // SOLUSI IDEAL
        // =====================================
        $aPlus = [];
        $aMinus = [];

        foreach ($kriterias as $kriteria) {

            $nilaiKolom = [];

            foreach ($kandidat as $item) {

                $nilaiKolom[] =
                    $matriksTerbobot[$item->id][$kriteria->id];
            }

            if ($kriteria->atribut == 'Benefit') {

                $aPlus[$kriteria->id] = max($nilaiKolom);
                $aMinus[$kriteria->id] = min($nilaiKolom);

            } else { // cost

                $aPlus[$kriteria->id] = min($nilaiKolom);
                $aMinus[$kriteria->id] = max($nilaiKolom);

            }
        }

        return $table
            ->query(
                Kandidat::query()->with('penilaian')
            )

            ->columns([

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Kandidat')
                    ->searchable()
                    ->weight('bold'),

                // =================================
                // D+
                // =================================
                Tables\Columns\TextColumn::make('d_plus')

                    ->label('D+')

                    ->getStateUsing(function ($record) use (
                        $kriterias,
                        $matriksTerbobot,
                        $aPlus
                    ) {

                        $total = 0;

                        foreach ($kriterias as $kriteria) {

                            $nilai =
                                $matriksTerbobot[$record->id][$kriteria->id];

                            $total += pow(
                                $nilai - $aPlus[$kriteria->id],
                                2
                            );
                        }

                        return number_format(
                            sqrt($total),
                            4
                        );
                    })

                    ->alignCenter(),

                // =================================
                // D-
                // =================================
                Tables\Columns\TextColumn::make('d_minus')

                    ->label('D-')

                    ->getStateUsing(function ($record) use (
                        $kriterias,
                        $matriksTerbobot,
                        $aMinus
                    ) {

                        $total = 0;

                        foreach ($kriterias as $kriteria) {

                            $nilai =
                                $matriksTerbobot[$record->id][$kriteria->id];

                            $total += pow(
                                $nilai - $aMinus[$kriteria->id],
                                2
                            );
                        }

                        return number_format(
                            sqrt($total),
                            4
                        );
                    })
                    ->alignCenter(),

                // =================================
                // PREFERENSI
                // =================================
                Tables\Columns\TextColumn::make('preferensi')

                    ->label('Preferensi')

                    ->getStateUsing(function ($record) use (
                        $kriterias,
                        $matriksTerbobot,
                        $aPlus,
                        $aMinus
                    ) {

                        $dPlus = 0;
                        $dMinus = 0;

                        foreach ($kriterias as $kriteria) {

                            $nilai =
                                $matriksTerbobot[$record->id][$kriteria->id];

                            $dPlus += pow(
                                $nilai - $aPlus[$kriteria->id],
                                2
                            );

                            $dMinus += pow(
                                $nilai - $aMinus[$kriteria->id],
                                2
                            );
                        }

                        $dPlus = sqrt($dPlus);
                        $dMinus = sqrt($dMinus);

                        $preferensi =
                            ($dPlus + $dMinus) > 0
                            ? $dMinus / ($dPlus + $dMinus)
                            : 0;

                        return number_format(
                            $preferensi,
                            4
                        );
                    })
                    ->alignCenter(),

                // =================================
                // STATUS KELAYAKAN
                // =================================
                Tables\Columns\TextColumn::make('status')

                    ->label('Status')

                    ->getStateUsing(function ($record) use (
                        $kriterias,
                        $matriksTerbobot,
                        $aPlus,
                        $aMinus
                    ) {

                        $dPlus = 0;
                        $dMinus = 0;

                        foreach ($kriterias as $kriteria) {

                            $nilai =
                                $matriksTerbobot[$record->id][$kriteria->id];

                            $dPlus += pow(
                                $nilai - $aPlus[$kriteria->id],
                                2
                            );

                            $dMinus += pow(
                                $nilai - $aMinus[$kriteria->id],
                                2
                            );
                        }

                        $dPlus = sqrt($dPlus);
                        $dMinus = sqrt($dMinus);

                        $preferensi =
                            ($dPlus + $dMinus) > 0
                            ? $dMinus / ($dPlus + $dMinus)
                            : 0;

                        // status sesuai ENUM database
                        // Preferensi layak sesuai dengan ketentuan
                        $status = $preferensi >= 0.5
                            ? 'layak'
                            : 'tidak_layak';

                        // update status kandidat
                        Kandidat::where('id', $record->id)
                            ->update([
                                'status' => $status,
                            ]);

                        return $status;
                    })

                    ->formatStateUsing(fn ($state) =>
                        match ($state) {
                            'layak' => 'Layak',
                            'tidak_layak' => 'Tidak Layak',
                            default => 'Pending',
                        }
                    )

                    ->color(fn ($state) =>
                        $state == 'layak'
                            ? 'success'
                            : 'danger'
                    )

                    ->weight('bold')
                    ->alignCenter(),
            ])

            ->paginated(false);
    }
}