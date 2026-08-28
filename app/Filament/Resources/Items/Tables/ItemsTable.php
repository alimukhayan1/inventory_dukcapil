<?php

namespace App\Filament\Resources\Items\Tables;

use App\Enums\ItemCondition;
use App\Enums\ItemStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;

class ItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inventory_code')
                    ->label('Kode Inventaris')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('name')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('room.name')
                    ->label('Ruangan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('employee.name')
                    ->label('Penanggung Jawab')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('condition')
                    ->label('Kondisi')
                    ->badge()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
                SelectFilter::make('room')
                    ->label('Ruangan')
                    ->relationship('room', 'name'),
                SelectFilter::make('condition')
                    ->label('Kondisi')
                    ->options(ItemCondition::class),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(ItemStatus::class),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->after(function ($record) {
                        app(\App\Services\ActivityLogService::class)->log(
                            auth()->user(),
                            'DELETE_ITEM',
                            $record,
                            "Menghapus barang: {$record->inventory_code} - {$record->name}"
                        );
                    }),
                RestoreAction::make()
                    ->after(function ($record) {
                        app(\App\Services\ActivityLogService::class)->log(
                            auth()->user(),
                            'RESTORE_ITEM',
                            $record,
                            "Memulihkan barang: {$record->inventory_code} - {$record->name}"
                        );
                    }),
                ForceDeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
