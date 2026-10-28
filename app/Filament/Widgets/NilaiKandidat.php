<?php

namespace App\Filament\Widgets;

use App\Models\Kandidat;
use App\Models\ValidasiKandidat;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;

class NilaiKandidat extends BaseWidget
{
    protected static ?string $heading = 'Nilai Kandidat';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $columns = [

            Tables\Columns\TextColumn::make('nama')
                ->label('Nama Kandidat')
                ->searchable(),
        ];

        $kriterias = ValidasiKandidat::all();

        foreach ($kriterias as $kriteria) {

            $columns[] = Tables\Columns\TextColumn::make(
                    $kriteria->kode
                )
                ->label(new \Illuminate\Support\HtmlString(
                        $kriteria->kode . '<br>' . $kriteria->kriteria
                    ))

                ->getStateUsing(function ($record) use ($kriteria) {

                    return $record->penilaian
                        ->where('validasi_kandidat_id', $kriteria->id)
                        ->first()?->nilai ?? '-';
                })

                ->alignCenter();
        }

        return $table
            ->query(Kandidat::query())

            ->columns($columns)

            ->actions([

                Action::make('penilaian')
                    ->label('Nilai')
                    ->color('primary')
                    ->icon('heroicon-o-pencil-square')
                    ->button()

                    ->modalHeading(fn ($record) =>
                        'Penilaian Kandidat - ' . $record->nama
                    )

                    ->modalCancelActionLabel('Batal')
                    ->modalSubmitActionLabel('Simpan')
                    ->modalWidth('lg')

                    ->form(function ($record) {

                        $form = [];

                        $kriterias = ValidasiKandidat::all();

                        foreach ($kriterias as $kriteria) {

                            $nilai = $record->penilaian()
                                ->where('validasi_kandidat_id', $kriteria->id)
                                ->first();

                            $form[] = Forms\Components\TextInput::make(
                                    $kriteria->kriteria
                                )
                                ->label($kriteria->nama_kriteria)
                                ->numeric()
                                ->default($nilai?->nilai)
                                ->required();
                        }

                        return $form;
                    })

                    ->action(function ($record, array $data) {

                        $kriterias = ValidasiKandidat::all();

                        foreach ($kriterias as $kriteria) {

                            $field = $kriteria->kriteria;

                            $record->penilaian()->updateOrCreate(
                                [
                                    'validasi_kandidat_id' => $kriteria->id,
                                ],
                                [
                                    'nilai' => $data[$field],
                                ]
                            );
                        }
                    })

                    ->successNotificationTitle('Penilaian berhasil disimpan'),
            ]);
    }
}