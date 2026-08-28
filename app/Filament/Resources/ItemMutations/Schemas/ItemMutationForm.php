<?php

namespace App\Filament\Resources\ItemMutations\Schemas;

use App\Enums\MutationType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Get;

class ItemMutationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Mutasi')
                    ->schema([
                        Select::make('item_id')
                            ->label('Barang')
                            ->relationship('item', 'name')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->inventory_code} - {$record->name}")
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),
                            
                        Select::make('mutation_type')
                            ->label('Jenis Mutasi')
                            ->options(MutationType::class)
                            ->required()
                            ->live(),
                            
                        DatePicker::make('mutation_date')
                            ->label('Tanggal Mutasi')
                            ->default(now())
                            ->required(),
                    ])->columns(2),

                Section::make('Detail Tujuan Mutasi')
                    ->schema([
                        Select::make('to_room_id')
                            ->label('Ruangan Tujuan')
                            ->relationship('toRoom', 'name')
                            ->searchable()
                            ->preload()
                            ->required(fn (Get $get) => in_array($get('mutation_type'), [MutationType::ROOM->value, MutationType::ROOM_AND_EMPLOYEE->value]))
                            ->visible(fn (Get $get) => in_array($get('mutation_type'), [MutationType::ROOM->value, MutationType::ROOM_AND_EMPLOYEE->value])),
                            
                        Select::make('to_employee_id')
                            ->label('Penanggung Jawab Tujuan')
                            ->relationship('toEmployee', 'name')
                            ->searchable()
                            ->preload()
                            ->required(fn (Get $get) => in_array($get('mutation_type'), [MutationType::RESPONSIBLE_EMPLOYEE->value, MutationType::ROOM_AND_EMPLOYEE->value]))
                            ->visible(fn (Get $get) => in_array($get('mutation_type'), [MutationType::RESPONSIBLE_EMPLOYEE->value, MutationType::ROOM_AND_EMPLOYEE->value])),
                    ])->columns(2),
                    
                Section::make('Keterangan')
                    ->schema([
                        Textarea::make('description')
                            ->label('Alasan / Keterangan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
