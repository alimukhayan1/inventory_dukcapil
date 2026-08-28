<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ItemMutations\ItemMutationResource;
use App\Models\ItemMutation;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestMutations extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = 'Mutasi Barang Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ItemMutation::query()->latest('mutation_date')->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('mutation_date')
                    ->label('Tanggal')
                    ->date('d M Y'),
                Tables\Columns\TextColumn::make('item.inventory_code')
                    ->label('Kode Barang'),
                Tables\Columns\TextColumn::make('item.name')
                    ->label('Nama Barang')
                    ->limit(30),
                Tables\Columns\TextColumn::make('mutation_type')
                    ->label('Jenis Mutasi')
                    ->badge(),
                Tables\Columns\TextColumn::make('toRoom.name')
                    ->label('Ruangan Tujuan')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('toEmployee.name')
                    ->label('P. Jawab Tujuan')
                    ->placeholder('-'),
            ])
            ->paginated(false);
    }
}
