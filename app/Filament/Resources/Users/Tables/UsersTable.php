<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Filament\Support\Exceptions\Halt;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),

                TextColumn::make('password')
                    ->label('Password')
                    ->formatStateUsing(fn () => '********'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->label(''),

                DeleteAction::make()
                    ->before(function ($record) {

                        // Cegah hapus user terakhir
                        if (User::count() <= 1) {
                            Notification::make()
                                ->title('Minimal harus ada 1 user aktif')
                                ->danger()
                                ->send();

                            throw new Halt();
                        }

                        // Cegah hapus diri sendiri
                        if ($record->id === Auth::id()) {
                            Notification::make()
                                ->title('Anda tidak bisa menghapus akun yang sedang digunakan')
                                ->danger()
                                ->send();

                            throw new Halt();
                        }
                    })
                    ->label('')
                    ->modalHeading('Konfirmasi Hapus')
                    ->modalSubheading('Apakah Anda yakin ingin menghapus user ini?')
                    ->modalButton('Hapus')
                    ->modalCancelActionLabel('Batal'),
            ]);
    }
}
