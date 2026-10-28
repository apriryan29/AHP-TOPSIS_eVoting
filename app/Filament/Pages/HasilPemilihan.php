<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Support\Icons\Heroicon;
use Filament\Notifications\Notification;
use App\Filament\Widgets\HasilPemilihanChart;
use App\Filament\Widgets\RekapitulasiSuara;
use App\Models\Kandidat;
use App\Models\Vote;
use App\Models\Pemilihan;
use App\Mail\KetuaUmumTerpilihMail;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class HasilPemilihan extends Page
{
    protected static string|BackedEnum|null $navigationIcon =
    Heroicon::OutlinedChartPie;
    protected static ?string $navigationLabel = 'Hasil Pemilihan';
    protected static string | \UnitEnum | null $navigationGroup = 'Voting';
    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.hasil-pemilihan';


    protected function getHeaderActions(): array
    {
        return [
        Action::make('ketua')
            ->label('Input Ketua Umum')
            ->color('warning')
            ->modalHeading('Penetapan Ketua Umum')
            ->modalSubmitActionLabel('Tetapkan')
            ->modalCancelActionLabel('Batal')
            ->form([
                Select::make('kandidat_id')
                    ->label('Ketua Umum Terpilih')
                    ->placeholder('Pilih Nama Ketua Umum')
                    ->options(
                        Kandidat::query()
                            ->orderBy('nama')
                            ->pluck('nama', 'id')
                    )
                    ->searchable()
                    ->required(),
            ])
            ->action(function (array $data) {

                $kandidat = Kandidat::findOrFail($data['kandidat_id']);

                // Ambil pemilihan aktif / terbaru
                $pemilihan = Pemilihan::first();

                if (!$pemilihan) {
                    Notification::make()
                        ->title('Data pemilihan tidak ditemukan')
                        ->danger()
                        ->send();

                    return;
                }

                // Simpan Ketua Umum
                $pemilihan->update([
                    'ketua_umum_id' => $kandidat->id,
                ]);

                // Ambil seluruh email voter
                $emails = Vote::whereNotNull('email')
                    ->pluck('email')
                    ->unique();

                foreach ($emails as $email) {
                    Mail::to($email)
                        ->queue(
                            new KetuaUmumTerpilihMail($kandidat)
                        );
                }

                Notification::make()
                    ->title('Ketua Umum berhasil ditetapkan')
                    ->body("{$kandidat->nama} berhasil ditetapkan sebagai Ketua Umum.")
                    ->success()
                    ->send();
            }),


            Action::make('export')
                ->label('Cetak Rekapitulasi')
                ->livewireClickHandlerEnabled(false)
                ->url(route('hasil-pemilihan.pdf')),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            HasilPemilihanChart::class,
            RekapitulasiSuara::class,
        ];
    }
}