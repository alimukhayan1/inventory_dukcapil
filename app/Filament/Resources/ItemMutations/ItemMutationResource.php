<?php

namespace App\Filament\Resources\ItemMutations;

use App\Filament\Resources\ItemMutations\Pages\CreateItemMutation;
use App\Filament\Resources\ItemMutations\Pages\ListItemMutations;
use App\Filament\Resources\ItemMutations\Schemas\ItemMutationForm;
use App\Filament\Resources\ItemMutations\Tables\ItemMutationsTable;
use App\Models\ItemMutation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ItemMutationResource extends Resource
{
    protected static ?string $model = ItemMutation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    protected static ?string $modelLabel = 'Mutasi Barang';
    
    protected static ?string $pluralModelLabel = 'Riwayat Mutasi';

    protected static \UnitEnum|string|null $navigationGroup = 'Inventaris';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return ItemMutationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ItemMutationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListItemMutations::route('/'),
            'create' => CreateItemMutation::route('/create'),
        ];
    }
}
