<?php

namespace App\Filament\Resources\ItemInspections\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class ItemInspectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inspection_date')
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
                IconColumn::make('is_found')
                    ->label('Ditemukan')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('condition')
                    ->label('Kondisi')
                    ->badge()
                    ->sortable(),
                TextColumn::make('inspector.name')
                    ->label('Diperiksa Oleh'),
            ])
            ->defaultSort('inspection_date', 'desc')
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
