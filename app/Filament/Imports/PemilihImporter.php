<?php

namespace App\Filament\Imports;

use App\Models\Vote;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class PemilihImporter extends Importer
{
    protected static ?string $model = Vote::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->requiredMapping(),

            ImportColumn::make('email')
                ->requiredMapping(),

            ImportColumn::make('komisariat')
                ->requiredMapping(),
        ];
    }

    public function resolveRecord(): Vote
    {
        return Vote::firstOrNew([
            'email' => $this->data['email'],
        ]);
    }

    protected function beforeSave(): void
    {
        // Token otomatis jika belum ada
        if (blank($this->record->token)) {
            $this->record->token = random_int(100000, 999999);
        }

        // Password otomatis
        if (blank($this->record->password)) {

            // Ambil nama depan
            $namaDepan = strtolower(
                explode(' ', trim($this->record->nama))[0]
            );

            // Nomor unik 4 digit
            $nomorUnik = random_int(1000, 9999);

            $passwordPlain = $namaDepan . $nomorUnik;

            $this->record->password_awal = $passwordPlain;
            $this->record->password = Hash::make($passwordPlain);

            // Opsional untuk debugging
            logger()->info(
                "Password {$this->record->email}: {$passwordPlain}"
            );
        }

        // Verifikasi otomatis
        $this->record->status_verifikasi = false;

        // Belum memilih
        $this->record->status_memilih = false;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Import pemilih berhasil. ' .
            Number::format($import->successful_rows) .
            ' data berhasil diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' .
                Number::format($failedRowsCount) .
                ' data gagal diimpor.';
        }

        return $body;
    }
}