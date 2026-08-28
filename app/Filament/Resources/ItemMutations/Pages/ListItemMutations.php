<?php

namespace App\Filament\Resources\ItemMutations\Pages;

use App\Filament\Resources\ItemMutations\ItemMutationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListItemMutations extends ListRecords
{
    protected static string $resource = ItemMutationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
