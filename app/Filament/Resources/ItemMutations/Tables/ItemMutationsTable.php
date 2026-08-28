<?php

namespace App\Filament\Resources\ItemMutations\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemMutationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('mutation_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('item.inventory_code')
                    ->label('Kode Barang')
                    ->searchable(),
                TextColumn::make('item.name')
                    ->label('Nama Barang')
                    ->searchable()
                    ->limit(30),
                TextColumn::make('mutation_type')
                    ->label('Jenis Mutasi')
                    ->badge()
                    ->sortable(),
                TextColumn::make('toRoom.name')
                    ->label('Ruangan Tujuan')
                    ->placeholder('-'),
                TextColumn::make('toEmployee.name')
                    ->label('P. Jawab Tujuan')
                    ->placeholder('-'),
                TextColumn::make('creator.name')
                    ->label('Dicatat Oleh'),
            ])
            ->defaultSort('mutation_date', 'desc')
            ->filters([
                //
            ])
            ->actions([
                // View action could be added here
            ])
            ->bulkActions([
                // Historical data: no bulk deletes
            ]);
    }
}
