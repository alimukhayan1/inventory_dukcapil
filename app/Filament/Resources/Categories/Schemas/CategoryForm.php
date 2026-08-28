<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kategori')
                    ->description('Masukkan detail kategori barang')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kategori')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }
}
