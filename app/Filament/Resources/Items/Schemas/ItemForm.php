<?php

namespace App\Filament\Resources\Items\Schemas;

use App\Enums\ItemCondition;
use App\Enums\ItemStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        Section::make('Informasi Utama')
                            ->schema([
                                TextInput::make('inventory_code')
                                    ->label('Kode Inventaris')
                                    ->required()
                                    ->maxLength(100)
                                    ->unique(ignoreRecord: true),
                                TextInput::make('name')
                                    ->label('Nama Barang')
                                    ->required()
                                    ->maxLength(255),
                                Select::make('category_id')
                                    ->label('Kategori')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ])
                            ->columnSpan(2),

                        Section::make('Status & Kondisi')
                            ->schema([
                                Select::make('condition')
                                    ->label('Kondisi')
                                    ->options(ItemCondition::class)
                                    ->default(ItemCondition::BAIK)
                                    ->required(),
                                Select::make('status')
                                    ->label('Status')
                                    ->options(ItemStatus::class)
                                    ->default(ItemStatus::AKTIF)
                                    ->required(),
                            ])
                            ->columnSpan(1),

                        Section::make('Spesifikasi & Pengadaan')
                            ->schema([
                                TextInput::make('brand')
                                    ->label('Merk')
                                    ->maxLength(255),
                                TextInput::make('model')
                                    ->label('Model/Tipe')
                                    ->maxLength(255),
                                TextInput::make('serial_number')
                                    ->label('Nomor Seri')
                                    ->maxLength(255),
                                TextInput::make('acquisition_year')
                                    ->label('Tahun Pengadaan')
                                    ->numeric()
                                    ->minValue(1990)
                                    ->maxValue(date('Y')),
                                TextInput::make('acquisition_price')
                                    ->label('Harga Perolehan (Rp)')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->maxValue(999999999999.99),
                            ])
                            ->columns(2)
                            ->columnSpan(2),

                        Section::make('Lokasi & Penanggung Jawab')
                            ->schema([
                                Select::make('room_id')
                                    ->label('Ruangan')
                                    ->relationship('room', 'name')
                                    ->searchable()
                                    ->preload(),
                                Select::make('employee_id')
                                    ->label('Penanggung Jawab')
                                    ->relationship('employee', 'name')
                                    ->searchable()
                                    ->preload(),
                                Textarea::make('description')
                                    ->label('Keterangan Tambahan')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(1),
                    ]),
            ]);
    }
}
