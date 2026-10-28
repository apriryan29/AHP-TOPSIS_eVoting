<?php

namespace App\Filament\Exports;

use App\Models\Vote;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class PemilihExporter extends Exporter
{
    protected static ?string $model = Vote::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('nama')
                ->label('Nama'),

            ExportColumn::make('email')
                ->label('Email'),

            ExportColumn::make('komisariat')
                ->label('Komisariat'),

            ExportColumn::make('password_awal')
                ->label('Password'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export data pemilih berhasil. ' .
            Number::format($export->successful_rows) .
            ' data berhasil diexport.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' .
                Number::format($failedRowsCount) .
                ' data gagal diexport.';
        }

        return $body;
    }
}