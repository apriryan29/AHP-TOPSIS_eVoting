<?php

namespace App\Filament\Widgets;

use App\Models\Pemilihan;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class KelolaPemilihanTable extends TableWidget
{
    protected static ?string $heading = 'Kelola Pemilihan';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Pemilihan::query()
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('nama_pemilihan')
                    ->label('Nama Pemilihan'),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50),

                Tables\Columns\TextColumn::make('mulai')
                    ->label('Mulai')
                    ->dateTime('d M Y H:i'),

                Tables\Columns\TextColumn::make('selesai')
                    ->label('Selesai')
                    ->dateTime('d M Y H:i'),

                Tables\Columns\TextColumn::make('is_active')
                    ->label('Status')
                    ->formatStateUsing(
                        fn (bool $state): string => $state ? 'Aktif' : 'Tidak Aktif'
                    ),
            ])
            ->actions([
                EditAction::make(),
            ]);
    }
}