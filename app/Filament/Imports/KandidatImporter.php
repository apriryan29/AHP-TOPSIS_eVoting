<?php

namespace App\Filament\Imports;

use App\Models\Kandidat;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class KandidatImporter extends Importer
{
    protected static ?string $model = Kandidat::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nia')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('asal_komisariat')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('tahun_dad')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('visi')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('misi')
                ->requiredMapping()
                ->rules(['required']),
        ];
    }

    public function resolveRecord(): ?Kandidat
    {
        return Kandidat::firstOrNew([
            'nama' => $this->data['nama'],
            'nia' => $this->data['nia'],
            'asal_komisariat' => $this->data['asal_komisariat'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your kandidat import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
