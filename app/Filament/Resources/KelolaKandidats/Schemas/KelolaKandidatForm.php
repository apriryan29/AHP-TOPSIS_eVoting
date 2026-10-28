<?php

namespace App\Filament\Resources\KelolaKandidats\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;
use Filament\Forms\Components\RichEditor;

class KelolaKandidatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('nama')
                    ->label('Nama Lengkap Kandidat')
                    ->required(),
                TextInput::make('nia')
                    ->label('NIA')
                    ->required()
                    ->helperText('Isikan dengan tanda strip (-) jika belum memiliki NIA'),
                TextInput::make('asal_komisariat')
                    ->label('Asal Komisariat')
                    ->required()
                    ->datalist([
                        'PK IMM Sabiilul Hasbi Teknik dan Sains',
                        'PK IMM Ilmu Kesehatan',
                        'PK IMM Ekonomi dan Bisnis',
                        'PK IMM Buya Hamka',
                        'PK IMM Muhammad Al-Fatih',
                        'PK IMM Insan Kamil',
                        'PK IMM Psikologi',
                        'PK IMM Keguruan dan Ilmu Pendidikan',
                        'PK IMM Kedokteran',
                        'PK IMM Farmasi',
                    ]),
                TextInput::make('tahun_dad')
                    ->label('Tahun DAD')
                    ->required(),
                
                Textarea::make('visi')
                    ->label('Visi'),

                RichEditor::make('misi')
                    ->label('Misi')
                    ->toolbarButtons([
                        'bulletList',
                        'orderedList',
                        'bold',
                        'italic',
                        'undo',
                        'redo',
                    ]),

                
                FileUpload::make('foto')
                    ->label('Foto Kandidat')
                    ->image()
                    ->directory('kandidat')
                    ->imagePreviewHeight('150')
                    ->disk('public')
                    ->required(),
            ]);
    }
}