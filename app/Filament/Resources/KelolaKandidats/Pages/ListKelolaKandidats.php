<?php

namespace App\Filament\Resources\KelolaKandidats\Pages;

use App\Filament\Resources\KelolaKandidats\KelolaKandidatResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use App\Filament\Imports\KandidatImporter;
use Filament\Resources\Pages\ListRecords;

class ListKelolaKandidats extends ListRecords
{
    protected static string $resource = KelolaKandidatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
            ->label('Impor Kandidat')
            ->importer(KandidatImporter::class)
            ->modalHeading('Impor Data Kandidat'),
            CreateAction::make()
            ->label('Tambah Kandidat'),
        ];
    }
    public function getBreadcrumb(): string
    {
        return 'Tabel';
    }
}
