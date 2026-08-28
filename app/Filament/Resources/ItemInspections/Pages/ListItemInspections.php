<?php

namespace App\Filament\Resources\ItemInspections\Pages;

use App\Filament\Resources\ItemInspections\ItemInspectionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListItemInspections extends ListRecords
{
    protected static string $resource = ItemInspectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
