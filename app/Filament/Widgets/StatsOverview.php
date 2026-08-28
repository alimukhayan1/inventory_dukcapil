<?php

namespace App\Filament\Widgets;

use App\Enums\ItemCondition;
use App\Models\Item;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalItems = Item::count();
        $goodCondition = Item::where('condition', ItemCondition::BAIK)->count();
        $brokenCondition = Item::whereIn('condition', [ItemCondition::RUSAK_RINGAN, ItemCondition::RUSAK_BERAT])->count();
        
        $totalAssetValue = Item::sum('acquisition_price');

        return [
            Stat::make('Total Barang Inventaris', $totalItems)
                ->description('Total seluruh aset tercatat')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),
                
            Stat::make('Kondisi Baik', $goodCondition)
                ->description('Siap digunakan')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
                
            Stat::make('Perlu Perhatian (Rusak)', $brokenCondition)
                ->description('Rusak ringan atau berat')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),
                
            Stat::make('Total Nilai Aset', 'Rp ' . Number::format($totalAssetValue, locale: 'id'))
                ->description('Berdasarkan harga perolehan')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('gray'),
        ];
    }
}
