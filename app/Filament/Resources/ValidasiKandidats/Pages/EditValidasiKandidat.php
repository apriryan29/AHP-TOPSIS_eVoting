<?php

namespace App\Filament\Resources\ValidasiKandidats\Pages;

use App\Filament\Resources\ValidasiKandidats\ValidasiKandidatResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditValidasiKandidat extends EditRecord
{
    protected static string $resource = ValidasiKandidatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
