<?php

namespace App\Filament\Resources\Pemilihs\Pages;

use App\Filament\Resources\Pemilihs\PemilihResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPemilih extends EditRecord
{
    protected static string $resource = PemilihResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),

            Action::make('kembali')
                ->label('Kembali')
                ->url(PemilihResource::getUrl())
                ->color('gray'),

        ];
    }
}
