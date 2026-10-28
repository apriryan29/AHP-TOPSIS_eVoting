<?php

namespace App\Filament\Resources\Pemilihs\Tables;

use App\Models\VoteDetail;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Collection;

class PemilihsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('komisariat')
                    ->label('Komisariat')
                    ->searchable(),

                TextColumn::make('token')
                    ->label('Token Voting')
                    ->badge()
                    ->copyable(),

                IconColumn::make('status_verifikasi')
                    ->label('Verifikasi')
                    ->boolean(),

                IconColumn::make('status_memilih')
                    ->label('Sudah Memilih')
                    ->boolean(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('resetPilihan')
                    ->label('')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->tooltip('Reset Pilihan')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Reset Pilihan')
                    ->modalDescription('Semua data pilihan pemilih akan dihapus dan pemilih dapat melakukan voting kembali.')
                    ->action(function ($record) {

                        // Hapus data voting pemilih
                        VoteDetail::where('vote_id', $record->id)->delete();

                        // Reset status memilih
                        $record->update([
                            'status_memilih' => false,
                        ]);

                        Notification::make()
                            ->title('Pilihan berhasil direset')
                            ->body("Data voting {$record->nama} berhasil dihapus.")
                            ->success()
                            ->send();
                    })
                    ->modalSubmitActionLabel('Reset')
                    ->modalCancelActionLabel('Batal'),
                EditAction::make()
                    ->label('')
                    ->tooltip('Edit Data Pemilih'),
                DeleteAction::make()
                    ->label('')
                    ->tooltip('Hapus Data Pemilih')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Hapus')
                    ->modalSubheading('Apakah Anda yakin ingin menghapus data ini?')
                    ->modalSubmitActionLabel('Hapus')
                    ->modalCancelActionLabel('Batal'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus')
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Hapus')
                        ->modalSubheading('Apakah Anda yakin ingin menghapus data ini?')
                        ->modalSubmitActionLabel('Hapus')
                        ->modalCancelActionLabel('Batal'),
                    BulkAction::make('resetPilihanBersama')
                        ->label('Reset Pilihan')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('Konfirmasi Reset Pilihan')
                        ->modalDescription('Semua data pilihan pemilih yang dipilih akan dihapus dan mereka dapat melakukan voting kembali.')
                        ->modalSubmitActionLabel('Reset')
                        ->modalCancelActionLabel('Batal')
                        ->action(function (Collection $records) {
                            VoteDetail::whereIn('vote_id', $records->pluck('id'))->delete();
                            foreach ($records as $record) {
                                $record->update([
                                    'status_memilih' => false,
                                ]);
                            }
                            Notification::make()
                                ->title('Pilihan berhasil direset')
                                ->body("Data voting {$records->count()} pemilih berhasil dihapus.")
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ])
                ->label('Aksi Massal'),
            ]);
    }
}
