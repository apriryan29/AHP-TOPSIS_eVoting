<?php

namespace App\Filament\Resources\KelolaKandidats\Pages;

use App\Filament\Resources\KelolaKandidats\KelolaKandidatResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKelolaKandidat extends ViewRecord
{
    protected static string $resource = KelolaKandidatResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Actions\EditAction::make()
                ->label('Ubah'),

            Actions\Action::make('kembali')
                ->label('Kembali')
                ->url($this->getResource()::getUrl('index'))
                ->color('gray'),
        ];
    }
    
}