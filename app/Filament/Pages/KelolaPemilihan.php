<?php

namespace App\Filament\Pages;

use App\Models\Pemilihan;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class KelolaPemilihan extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon =
        Heroicon::OutlinedAdjustmentsHorizontal;
    public function getBreadcrumbs(): array
    {
        return [
            route('filament.admin.pages.kelola-pemilihan') => 'Kelola Pemilihan',
            'View & Edit',
        ];
    }
    protected static ?string $navigationLabel = 'Kelola Pemilihan';

    protected static string|\UnitEnum|null $navigationGroup = 'Voting';

    protected static ?int $navigationSort = 2;
    protected string $view = 'filament.pages.kelola-pemilihan';

    public ?array $data = [];
    public bool $isEditing = false;

    public ?Pemilihan $pemilihan = null;

    public function mount(): void
    {
        $this->pemilihan = Pemilihan::first();

        $this->form->fill(
            $this->pemilihan?->toArray() ?? []
        );
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->label('Ubah')
                ->icon('heroicon-o-pencil-square')
                ->color('primary')
                ->visible(fn () => ! $this->isEditing)
                ->action(fn () => $this->isEditing = true),

            Action::make('save')
                ->label('Simpan')
                ->icon('heroicon-o-check')
                ->color('success')
                ->visible(fn () => $this->isEditing)
                ->action('save'),

            Action::make('cancel')
                ->label('Batal')
                ->icon('heroicon-o-x-mark')
                ->color('gray')
                ->visible(fn () => $this->isEditing)
                ->action(function () {
                    $this->isEditing = false;

                    $this->form->fill(
                        $this->pemilihan?->toArray() ?? []
                    );
                }),
        ];
    }

    public function save(): void
    {
        if (! $this->pemilihan) {
            Notification::make()
                ->title('Data pemilihan tidak ditemukan')
                ->danger()
                ->send();

            return;
        }

        $this->pemilihan->update($this->data);

        $this->pemilihan->refresh();

        $this->isEditing = false;

        Notification::make()
            ->title('Data berhasil diperbarui')
            ->success()
            ->send();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                TextInput::make('nama_pemilihan')
                    ->label('Nama Pemilihan')
                    ->required()
                    ->disabled(fn () => ! $this->isEditing),

                Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->rows(4)
                    ->disabled(fn () => ! $this->isEditing),
                
                TextInput::make('maksimal_pilihan')
                    ->label('Maksimal Pilihan   ')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->helperText('Masukkan jumlah maksimal Pilihan dalam Pemilihan ini.')
                    ->disabled(fn () => ! $this->isEditing),

                DateTimePicker::make('mulai')
                    ->label('Waktu Mulai')
                    ->native(false)
                    ->disabled(fn () => ! $this->isEditing),

                DateTimePicker::make('selesai')
                    ->label('Waktu Selesai')
                    ->native(false)
                    ->disabled(fn () => ! $this->isEditing),

                Placeholder::make('status')
                    ->label('Status')
                    ->content(function () {
                        if (! $this->pemilihan) {
                            return 'Tidak ada data';
                        }

                        $now = Carbon::now();

                        if ($now->lt($this->pemilihan->mulai)) {
                            return 'Belum Dimulai';
                        }

                        if ($now->between($this->pemilihan->mulai, $this->pemilihan->selesai)) {
                            return 'Sedang Berlangsung';
                        }

                        return 'Sudah Selesai';
                    }),
            ]);
    }
}