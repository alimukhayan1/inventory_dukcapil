<?php

namespace App\Filament\Resources\ItemInspections\Schemas;

use App\Enums\ItemCondition;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Get;

class ItemInspectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Pemeriksaan')
                    ->schema([
                        Select::make('item_id')
                            ->label('Barang yang Diperiksa')
                            ->relationship('item', 'name')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->inventory_code} - {$record->name}")
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),
                            
                        DatePicker::make('inspection_date')
                            ->label('Tanggal Pemeriksaan')
                            ->default(now())
                            ->required(),
                    ])->columns(2),

                Section::make('Hasil Pemeriksaan')
                    ->schema([
                        Toggle::make('is_found')
                            ->label('Barang Ditemukan?')
                            ->default(true)
                            ->live(),
                            
                        Select::make('condition')
                            ->label('Kondisi Barang')
                            ->options(ItemCondition::class)
                            ->required(fn (Get $get) => $get('is_found'))
                            ->visible(fn (Get $get) => $get('is_found')),
                            
                        Textarea::make('notes')
                            ->label('Catatan Pemeriksaan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
