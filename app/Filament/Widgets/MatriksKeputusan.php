<?php

namespace App\Filament\Widgets;

use App\Models\Kandidat;
use App\Models\ValidasiKandidat;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class MatriksKeputusan extends TableWidget
{
    protected static ?string $heading = 'Matriks Keputusan';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $kriterias = ValidasiKandidat::all();
        $jumlahKriteria = $kriterias->count();

        // 🔥 FILTER KANDIDAT VALID (WAJIB UNTUK TOPSIS STABIL)
        $kandidats = Kandidat::with('penilaian')
            ->get()
            ->filter(fn ($k) =>
                $k->penilaian->count() === $jumlahKriteria
            );

        /**
         * =========================
         * KOLOM DINAMIS
         * =========================
         */
        $columns = [
            Tables\Columns\TextColumn::make('nama')
                ->label('Nama Kandidat'),
        ];

        foreach ($kriterias as $kriteria) {
            //pemanggilan judul kolom nama kriteria
            $columns[] = Tables\Columns\TextColumn::make('k_' . $kriteria->kriteria)
                ->label(new \Illuminate\Support\HtmlString(
                        $kriteria->kode . '<br>' . $kriteria->kriteria
                    ))
                ->alignCenter()

                ->getStateUsing(function ($record) use ($kriteria) {

                    $nilai = $record->penilaian
                        ->firstWhere('validasi_kandidat_id', $kriteria->id)
                        ?->nilai;

                    return $nilai !== null ? $nilai : 0;
                });
        }

        return $table
            ->query(
                Kandidat::with('penilaian')
                    ->whereHas('penilaian')
            )
            ->columns($columns)
            ->paginated(false);
    }
}