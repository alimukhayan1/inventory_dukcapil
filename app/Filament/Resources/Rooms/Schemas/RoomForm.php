<?php

namespace App\Filament\Resources\Rooms\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RoomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Ruangan')
                    ->schema([
                        TextInput::make('code')
                            ->label('Kode Ruangan')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true),
                        TextInput::make('name')
                            ->label('Nama Ruangan')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }
}
