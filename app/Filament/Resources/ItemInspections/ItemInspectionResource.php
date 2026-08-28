<?php

namespace App\Filament\Resources\ItemInspections;

use App\Filament\Resources\ItemInspections\Pages\CreateItemInspection;
use App\Filament\Resources\ItemInspections\Pages\ListItemInspections;
use App\Filament\Resources\ItemInspections\Schemas\ItemInspectionForm;
use App\Filament\Resources\ItemInspections\Tables\ItemInspectionsTable;
use App\Models\ItemInspection;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ItemInspectionResource extends Resource
{
    protected static ?string $model = ItemInspection::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $modelLabel = 'Pemeriksaan Barang';
    
    protected static ?string $pluralModelLabel = 'Riwayat Pemeriksaan';

    protected static \UnitEnum|string|null $navigationGroup = 'Inventaris';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return ItemInspectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ItemInspectionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListItemInspections::route('/'),
            'create' => CreateItemInspection::route('/create'),
        ];
    }
}
