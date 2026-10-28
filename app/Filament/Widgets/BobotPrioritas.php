<?php

namespace App\Filament\Widgets;

use App\Models\PerbandinganKriteria;
use App\Models\ValidasiKandidat;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class BobotPrioritas extends BaseWidget
{
    protected static ?string $heading = 'Pengujian Konsistensi';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $kriterias = ValidasiKandidat::all();

        $n = count($kriterias);

        // =========================================
        // BENTUK MATRIKS PERBANDINGAN
        // =========================================
        $matriks = [];

        foreach ($kriterias as $baris) {

            foreach ($kriterias as $kolom) {

                // diagonal
                if ($baris->id == $kolom->id) {

                    $matriks[$baris->id][$kolom->id] = 1;

                } else {

                    // cek data langsung
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

                        // cek kebalikan
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

        // =========================================
        // HITUNG TOTAL KOLOM
        // =========================================
        $totalKolom = [];

        foreach ($kriterias as $kolom) {

            $total = 0;

            foreach ($kriterias as $baris) {

                $total +=
                    $matriks[$baris->id][$kolom->id];
            }

            $totalKolom[$kolom->id] = $total;
        }

        // =========================================
        // HITUNG BOBOT PRIORITAS
        // =========================================
        $prioritas = [];

        foreach ($kriterias as $baris) {

            $total = 0;

            foreach ($kriterias as $kolom) {

                $nilai =
                    $matriks[$baris->id][$kolom->id];

                $normalisasi =
                    $totalKolom[$kolom->id] > 0
                    ? $nilai / $totalKolom[$kolom->id]
                    : 0;

                $total += $normalisasi;
            }

            $prioritas[$baris->id] =
                $total / $n;
        }

        // =========================================
        // HITUNG LAMBDA MAX
        // =========================================
        $lambdaTotal = 0;

        foreach ($kriterias as $baris) {

            $jumlah = 0;

            foreach ($kriterias as $kolom) {

                $jumlah +=
                    $matriks[$baris->id][$kolom->id]
                    * $prioritas[$kolom->id];
            }

            if ($prioritas[$baris->id] != 0) {

                $lambdaTotal +=
                    $jumlah / $prioritas[$baris->id];
            }
        }

        $lambdaMax =
            $n > 0
            ? $lambdaTotal / $n
            : 0;

        // =========================================
        // HITUNG CI
        // =========================================
        $ci =
            $n > 1
            ? ($lambdaMax - $n) / ($n - 1)
            : 0;

        // =========================================
        // RANDOM INDEX
        // =========================================
        $riList = [
            1 => 0.00,
            2 => 0.00,
            3 => 0.58,
            4 => 0.90,
            5 => 1.12,
            6 => 1.24,
            7 => 1.32,
            8 => 1.41,
            9 => 1.45,
            10 => 1.49,
        ];

        $ri = $riList[$n] ?? 1.49;

        // HITUNG CR
        $cr =
            $ri > 0
            ? $ci / $ri
            : 0;

        $crAwal = $cr;

        $fprStatus = 'Tidak Digunakan';

        if ($cr > 0.1) {

            $fprStatus = 'Digunakan';
            // ============================
            // FPR
            // ============================

            $matriks = $this->convertToFPR($matriks);

            $matriks = $this->buildConsistencyMatrix($matriks);

            $matriks = $this->convertToAHP($matriks);

            // ============================
            // HITUNG ULANG AHP
            // ============================

            $hasil = $this->calculateAHP($matriks);

            $prioritas = $hasil['prioritas'];
            $lambdaMax = $hasil['lambdaMax'];
            $ci = $hasil['ci'];
            $cr = $hasil['cr'];
        }
        $crAkhir = $cr;

        // STATUS KONSISTENSI
        $status =
            $cr <= 0.1
            ? 'Konsisten'
            : 'Tidak Konsisten';

        return $table
            ->query(
                ValidasiKandidat::query()
                    ->limit(1)
            )

            ->paginated(false)

            ->columns([

                Tables\Columns\TextColumn::make('lambda_max')
                    ->label('λ Max')

                    ->getStateUsing(fn () =>
                        number_format($lambdaMax, 3)
                    )
                    ->color('warning')
                    ->weight('bold')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('ci')
                    ->label('CI')

                    ->getStateUsing(fn () =>
                        number_format($ci, 3)
                    )
                    ->color('info')
                    ->weight('bold')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('ri')
                    ->label('RI')

                    ->getStateUsing(fn () =>
                        number_format($ri, 3)
                    )
                    ->color('gray')
                    ->weight('bold')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('cr')
                    ->label('CR')

                    ->getStateUsing(fn () =>
                        number_format($cr, 3)
                    )

                    ->color(fn () =>
                        $cr <= 0.1
                            ? 'success'
                            : 'danger'
                    )

                    ->weight('bold')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('cr_awal')
                    ->label('CR Awal')
                    ->getStateUsing(fn() => number_format($crAwal,3))
                    ->alignCenter(),
                    
                Tables\Columns\TextColumn::make('fpr')
                    ->label('FPR')
                    ->getStateUsing(fn() => $fprStatus)
                    ->color(fn() =>
                        $fprStatus == 'Digunakan'
                            ? 'warning'
                            : 'success'
                    )
                    ->weight('bold')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('cr_akhir')
                    ->label('CR Akhir')
                    ->getStateUsing(fn() => number_format($crAkhir,3))
                    ->color(fn() =>
                        $crAkhir <= 0.1
                            ? 'success'
                            : 'danger'
                    )
                    ->weight('bold')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')

                    ->getStateUsing(fn () =>
                        $status
                    )

                    ->color(fn () =>
                        $status == 'Konsisten'
                            ? 'success'
                            : 'danger'
                    )

                    ->weight('bold')
                    ->alignCenter(),
            ]);
    }

    private function convertToFPR(array $matrix): array
    {
        $fpr = [];

        foreach ($matrix as $i => $rows) {

            foreach ($rows as $j => $value) {

                if ($i == $j) {
                    $fpr[$i][$j] = 0.5;
                } elseif ($value > 0) {
                    $fpr[$i][$j] = (1 + (log($value) / log(9))) / 2;
                } else {
                    $fpr[$i][$j] = 0;
                }
            }
        }

        return $fpr;
    }

    private function buildConsistencyMatrix(array $matrix): array
    {
        $g = [];

        $keys = array_keys($matrix);
        $n = count($keys);

        foreach ($keys as $i) {

            foreach ($keys as $k) {

                $sum = 0;

                foreach ($keys as $j) {

                    $sum +=
                        $matrix[$i][$j]
                        +
                        $matrix[$j][$k];
                }

                $g[$i][$k] =
                    ($sum / $n)
                    - 0.5;
            }
        }

        return $g;
    }

    private function convertToAHP(array $matrix): array
    {
        $ahp = [];

        foreach ($matrix as $i => $rows) {

            foreach ($rows as $j => $value) {

                if ($i == $j) {
                    $ahp[$i][$j] = 1;
                } else {
                    $ahp[$i][$j] = pow(9, 2 * ($value - 0.5));
                }
            }
        }

        return $ahp;
    }
    private function calculateAHP(array $matrix): array
    {
        $keys = array_keys($matrix);
        $n = count($keys);

        // Total kolom
        $totalKolom = [];
        foreach ($keys as $kolom) {
            $total = 0;
            foreach ($keys as $baris) {
                $total += $matrix[$baris][$kolom];
            }
            $totalKolom[$kolom] = $total;
        }

        // Bobot prioritas
        $prioritas = [];
        foreach ($keys as $baris) {
            $total = 0;
            foreach ($keys as $kolom) {
                $normalisasi = $totalKolom[$kolom] > 0
                    ? $matrix[$baris][$kolom] / $totalKolom[$kolom]
                    : 0;
                $total += $normalisasi;
            }
            $prioritas[$baris] = $total / $n;
        }

        // Lambda max
        $lambdaTotal = 0;
        foreach ($keys as $baris) {
            $jumlah = 0;
            foreach ($keys as $kolom) {
                $jumlah += $matrix[$baris][$kolom] * $prioritas[$kolom];
            }
            if ($prioritas[$baris] != 0) {
                $lambdaTotal += $jumlah / $prioritas[$baris];
            }
        }
        $lambdaMax = $n > 0 ? $lambdaTotal / $n : 0;

        // CI
        $ci = $n > 1 ? ($lambdaMax - $n) / ($n - 1) : 0;

        // RI & CR
        $riList = [1=>0,2=>0,3=>0.58,4=>0.90,5=>1.12,6=>1.24,7=>1.32,8=>1.41,9=>1.45,10=>1.49];
        $ri = $riList[$n] ?? 1.49;
        $cr = $ri > 0 ? $ci / $ri : 0;

        return compact('prioritas', 'lambdaMax', 'ci', 'cr');
    }
}