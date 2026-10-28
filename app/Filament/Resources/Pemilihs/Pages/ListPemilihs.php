<?php

namespace App\Filament\Resources\Pemilihs\Pages;

use App\Filament\Resources\Pemilihs\PemilihResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\ImportAction;
use App\Filament\Imports\PemilihImporter;
use Filament\Actions\ExportAction;
use App\Filament\Exports\PemilihExporter;

class ListPemilihs extends ListRecords
{
    protected static string $resource = PemilihResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make('import')
                ->label('Import Pemilih')
                ->importer(PemilihImporter::class)
                ->modalHeading('Import Data Pemilih'),
            ExportAction::make('export')
                ->label('Export Pemilih')
                ->exporter(PemilihExporter::class)
                ->modalHeading('Export Data Pemilih'),

            CreateAction::make()
                ->label('Tambah Pemilih'),
        ];
    }
}
