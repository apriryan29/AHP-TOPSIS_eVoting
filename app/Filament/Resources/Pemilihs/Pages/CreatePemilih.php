<?php

namespace App\Filament\Resources\Pemilihs\Pages;

use App\Filament\Resources\Pemilihs\PemilihResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePemilih extends CreateRecord
{
    protected static string $resource = PemilihResource::class;
    public function getTitle(): string
        {
            return 'Tambah Pemilih';
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
