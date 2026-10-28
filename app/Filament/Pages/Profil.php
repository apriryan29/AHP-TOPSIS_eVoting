<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Profil extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Profil';

    protected static ?string $title = 'Profil';

    protected static ?int $navigationSort = 3;
    protected static bool $shouldRegisterNavigation = false;//hapus ini untuk menampilkan menu profil di sidebar
    protected string $view = 'filament.pages.profil';

    public $user;

    public function mount(): void
    {
        $this->user = Auth::user();
    }


    protected function getHeaderActions(): array
    {
        return [
            Action::make('editProfil')
                ->label('Edit Profil')
                ->icon('heroicon-o-pencil-square')
                ->form([
                    TextInput::make('name')
                        ->label('Nama')
                        ->required()
                        ->default($this->user->name),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->default($this->user->email),
                ])
                ->action(function (array $data) {
                    $this->user->update([
                        'name' => $data['name'],
                        'email' => $data['email'],
                    ]);

                    $this->refreshUser();

                    Notification::make()
                        ->title('Profil berhasil diperbarui')
                        ->success()
                        ->send();
                }),


            Action::make('ubahPassword')
                ->label('Ubah Password')
                ->icon('heroicon-o-key')
                ->color('danger')
                ->form([
                    TextInput::make('password')
                        ->label('Password Baru')
                        ->password()
                        ->required(),

                    TextInput::make('password_confirmation')
                        ->label('Konfirmasi Password')
                        ->password()
                        ->required(),
                ])
                ->action(function (array $data) {

                    if ($data['password'] !== $data['password_confirmation']) {
                        Notification::make()
                            ->title('Password tidak cocok')
                            ->danger()
                            ->send();
                        return;
                    }

                    $this->user->update([
                        'password' => Hash::make($data['password']),
                    ]);

                    Notification::make()
                        ->title('Password berhasil diubah')
                        ->success()
                        ->send();
                }),
        ];
    }

    public function refreshUser(): void
    {
        $this->user = Auth::user();
    }
}