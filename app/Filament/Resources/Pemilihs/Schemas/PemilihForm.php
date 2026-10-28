<?php

namespace App\Filament\Resources\Pemilihs\Schemas;


use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PemilihForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([

                TextInput::make('nama')
                    ->label('Nama Pemilih')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->required(fn ($operation) => $operation === 'create')
                    ->dehydrated(fn ($state) => filled($state))
                    ->maxLength(255),

                TextInput::make('komisariat')
                    ->label('Asal Komisariat')
                    ->required()
                    ->maxLength(255),

                TextInput::make('token')
                    ->label('Token Voting')
                    ->default(fn () => random_int(100000, 999999))
                    ->unique(ignoreRecord: true)
                    ->readOnly()
                    ->dehydrated()
                    ->required(),

                TextInput::make('status_verifikasi_text')
                    ->label('Status Verifikasi')
                    ->formatStateUsing(fn ($record) =>
                        $record?->status_verifikasi
                            ? 'Terverifikasi'
                            : 'Belum Verifikasi'
                    )
                    ->readOnly()
                    ->dehydrated(false),

                Toggle::make('status_memilih')
                    ->label('Sudah Memilih')
                    ->disabled()
                    ->dehydrated(false),

            ]);
    }
}