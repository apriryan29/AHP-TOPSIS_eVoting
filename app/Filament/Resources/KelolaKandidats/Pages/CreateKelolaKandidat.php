<?php

namespace App\Filament\Resources\KelolaKandidats\Pages;

use App\Filament\Resources\KelolaKandidats\KelolaKandidatResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;

class CreateKelolaKandidat extends CreateRecord
{
    protected static string $resource = KelolaKandidatResource::class;

    public function getTitle(): string
    {
        return 'Tambah Kandidat';
    }
    
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('Simpan'),

            $this->getCancelFormAction()
                ->label('Batal'),
        ];
    }
}
