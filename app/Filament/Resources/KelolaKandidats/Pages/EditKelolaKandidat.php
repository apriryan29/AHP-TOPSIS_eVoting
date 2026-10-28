<?php

namespace App\Filament\Resources\KelolaKandidats\Pages;

use App\Filament\Resources\KelolaKandidats\KelolaKandidatResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditKelolaKandidat extends EditRecord
{
    protected static string $resource = KelolaKandidatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus')
                ->requiresConfirmation()
                ->after(function (): void {
                    $this->redirect(KelolaKandidatResource::getUrl('index'));
                }),    
            Action::make('kembali')
                ->label('Kembali')
                ->url(KelolaKandidatResource::getUrl('index')),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->label('Perbarui'),

            $this->getCancelFormAction()
                ->label('Batal'),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('view', [
            'record' => $this->record,
        ]);
    }
}
